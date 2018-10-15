<?php

namespace App\Http\Controllers\Nutibara\Prerefaccion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Prerefaccion\CrudPrerefaccion;
use App\BusinessLogic\Nutibara\Refaccion\CrudRefaccion;
use App\Http\Middleware\userIpValidated;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Contratos\ResolucionarBL;
use Illuminate\Support\Facades\Auth;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\Inventario\Trazabilidad\TrazabilidadBL;
use Carbon\Carbon;
use PDF;


class PrerefaccionController extends Controller
{
    public function Index(){
		$ipValidation = new userIpValidated();
		$tienda = CrudPrerefaccion::getTiendaByIp($ipValidation->getRealIP());
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/prerefaccion',
				'text'=>'Gestión de contratos'
			],
			[
				'href'=>'contrato/prerefaccion',
				'text'=>'Prerefacción'
				]
			);
			
		return view('Prerefaccion.index',['urls'=>$urls,'tienda' => $tienda]);
    }

    public function get(Request $request){
		
		return CrudPrerefaccion::get($request);
    }

	
	public function prerefaccionar($id_tienda,$id,$action){	
		
		$idx = explode("-",$id);
		$items = CrudPrerefaccion::getItemOrden($id_tienda,$idx);
		
		$contratos = array();
		
		
			if(count($items)>0){
				foreach($items as $key=>$value){
					array_push($contratos,$value->id_contrato);
				}
				
				$columnas_items= Contrato::getColumnasItems($contratos,$id_tienda);
				
				$datos_columnas_items = Contrato::getDatosColumnasItems($contratos,$id_tienda);
		
				$destinatarios = CrudPrerefaccion::getDestinatariosOrden($id_tienda,$idx);

				if( $items[0]->categoria == "Articulo" || $items[0]->categoria == "Artículo" || $items[0]->categoria == "Artículos" ){
					$procesos = CrudPrerefaccion::getListProcesoByVitrina();
				}
				else{
					$procesos = CrudPrerefaccion::getListProceso();
				}
			}else{
				Session::flash('warning', 'No se encontraron items');
				return redirect('/contrato/prerefaccion');
			}
		
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/prerefaccion',
				'text'=>'Gestion de contrato'
			],
			[
				'href'=>'contrato/prerefaccion',
				'text'=>'Prerefaccion de ordenes'
			],
			[
				'href' => 'contrato/prerefaccion/create/'.$id,
				'text' => 'Prerefaccionar ordenes'
			],
		);
		return view('Prerefaccion.create',[
											'urls'=>$urls,
											'procesos'=>$procesos,
											'id' => $id,
											'id_tienda_orden' => $id_tienda,
											'items'=>$items,
											'destinatarios'=>$destinatarios,
											'action'=>$action,
											'columnas_items'=>$columnas_items,
											'datos_columnas_items'=>$datos_columnas_items,
											'tienda'=>$id_tienda
										]);
    }
 
    public function procesar(request $request){	
		// $this->validate($request,[
		// 	'sucursales.*'=>'required|not_in:0',
		// ]); 
		self::guardarTemporal($request);
		//dd($request->all());
		$dataSaved=[
			'numero_orden' => $request->numero_orden,
			'id_item' =>$request->id_item,
			'id_inventario' =>$request->id_inventario,
			'id_hoja_trabajo' =>$request->id_hoja_trabajo,
			'id_tienda_orden' =>$request->id_tienda_orden,
			'subdivision' =>$request->subdivision,
			'numero_documento' => $request->numero_documento,			
			'peso_libre' => str_replace(",", ".", $request->peso_libre),
			'peso_estimado'=>str_replace(",", ".", $request->peso_estimado),
			'peso_total'=>str_replace(",", ".", $request->peso_total),
			'destinatario' => $request->destinatario,
			'id_proceso' => $request->id_proceso,
			'sucursales' => $request->sucursales,
			'procesar' =>$request->procesar,
			'id_cliente_destinatario' => $request->id_cliente,			
			'id_tienda_cliente_destinatario' => $request->id_tienda_cliente,
			'id_tienda_hoja_trabajo' => $request->id_tienda_hoja_trabajo,
			'id_tienda_inventario' => $request->id_tienda_inventario
		];

		$msm = CrudPrerefaccion::Procesar($dataSaved);
		
		if($msm['val']=='Actualizado'){
			Session::flash('message', 'Orden procesada con éxito');
			return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
			return redirect('/contrato/prerefaccion');
		}
		elseif($msm['val']=='Insertado'){
			Session::flash('message', 'Orden sub dividida con éxito');
			return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
			return redirect('/contrato/prerefaccion');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
	}
	
	public function generatePDF($ids_ordenes, $id_tienda){
		
		$user = Auth::user()->name;
		$date = Carbon::now();
		$object = [];
		$destinatarios = CrudRefaccion::getDestinatariosOrdenPadre($id_tienda,$ids_ordenes);
		for ($i=0; $i < count($ids_ordenes); $i++) { 
			array_push($object, ResolucionarBL::getOrdenPDF($ids_ordenes[$i], $id_tienda));
		}
		$pdf = PDF::loadView('DocumentosPDF.ordenresolucion', [ 'object' => $object, 'user' => $user, 'date' => $date, 'destinatarios' => $destinatarios ]);
		return $pdf->download('orden_resolucion.pdf');
	}
	
	public function generateReportePDF(Request $request){
		
		$user = Auth::user()->name;
		$date = Carbon::now();
		$object = [];
		$id_orden=$request->id_orden;
		$id_tienda=$request->id_tienda_orden;
		$destinatarios = CrudRefaccion::getDestinatariosOrdenPadre($id_tienda,[$id_orden]);
		array_push($object, ResolucionarBL::getOrdenPDF($id_orden, $id_tienda));
		$pdf = PDF::loadView('DocumentosPDF.ordenresolucion', [ 'object' => $object, 'user' => $user, 'date' => $date,'destinatarios' => $destinatarios ]);
		return $pdf->download('orden_prerefaccion.pdf');
	}

	public function generateReporteMineriaPDF(Request $request){
		$id_orden=$request->id_orden;
		$id_tienda=$request->id_tienda_orden;
		$object=CrudPrerefaccion::getItemsMineria($id_orden,$id_tienda);
		
		$pdf=PDF::loadView('DocumentosPDF.certificadomineria',['object'=>$object]);
		return $pdf->download('certificado_mineria.pdf');
		
	}
	public function generateExcel($id_orden,$id_tienda,$process){
		return CrudPrerefaccion::generateExcel($id_orden,$id_tienda,$process);
	}

	public function procesarUpdate($data,$ordenes)
	{
		$msm = CrudPrerefaccion::procesarUpdate($data,$ordenes);
		return $msm;
	}

	public function procesarCrear($data,$ordenes)
	{
		$msm = CrudPrerefaccion::procesarUpdate($data,$ordenes);
		return $msm;
	}

	public function getSelectList()
	{
		$msm = CrudPrerefaccion::getSelectList();
		return  response()->json($msm);
	}

	public function getListProceso()
	{
		$msm = CrudPrerefaccion::getListProceso();
		return  response()->json($msm);
	}

	public function getItemOrden($id_tienda,$id)
	{
		$idx = explode("-",$id);
		$data["data"] = CrudPrerefaccion::getItemOrden($id_tienda,$idx);
		$contratos=array();
		foreach($data["data"] as $key => $value){
			array_push($contratos,$value->id_contrato);
		}
		$data["columnas_items"] = Contrato::getColumnasItems( $contratos, $id_tienda );
		$data["datos_columnas_items"] = Contrato::getDatosColumnasItems( $contratos, $id_tienda );
		
		return  response()->json($data);
	}
	
	public function validarItem(request $request)
	{
		
		$response = CrudPrerefaccion::validarItem($request->id_tienda_inventario,$request->id_inventario,$request->id_contrato);
		//dd($response->all());
		return response()->json($response);
	}

	public function quitarItems(request $request)
	{
		

		$items = explode(",",$request->items);
		$response = CrudPrerefaccion::quitarItems($items);
		return response()->json($response);
	}

	public function AnularOrden(request $request)
	{
		
		$items = CrudPrerefaccion::getItemOrden($request->id_tienda,$request->id_orden);
		$data = CrudPrerefaccion::AnularOrden($items);
		
		return response()->json($data);
	}

	public function guardarTemporal(Request $request){
		//dd($request->all());
		$orden_guardar =[
			'id_tienda'=>$request->id_tienda_orden,
			'id_categoria_general'=>0,
			'id_estado'=>env('ORDEN_PENDIENTE_POR_PROCESAR'),
			'fecha_creacion'=>date("Y-m-d H:i:s"),
			'abre_bolsa'=>$request->subdividir,
			'id_proceso' => env('PROCESO_PREREFACCION'),
			'id_orden' => $request->numero_orden,
		];
		$orden_guardar_items = array();
		for ($i=0; $i < count($request->id_inventario); $i++) {
			array_push( $orden_guardar_items, [
				"id_orden_guardar" => $request->numero_orden,
				"codigo_contrato" => 0,
				"id_tienda_contrato" => $request->id_tienda_orden,
				"id_linea_item" => 0,
				"id_proceso" => $request->subdivision[ $i ],
				"peso_taller" => str_replace(",", ".", $request->peso_taller[ $i ]),
				'id_inventario' => $request->id_inventario[ $i ],
				'peso_estimado' => str_replace(",", ".", $request->peso_estimado[ $i ]),
				'peso_total' => str_replace(",", ".", $request->peso_total[ $i ]),
				'precio_ingresado' => $request->precio_ingresado[ $i ],
				'fecha_perfeccionamiento' => 0,
			] );
		}
		$orden_guardar_destinatarios = array();
		for ($i=0; $i < count($request->id_proceso); $i++) {
			array_push( $orden_guardar_destinatarios, [
				"id_orden_guardar" => $request->numero_orden,
				"id_proceso" => $request->id_proceso[ $i ],
				"destinatario" => $request->numero_documento[ $i ],
				"codigo_verificacion" => $request->digito_verificacion[ $i ],
				"numero_bolsa" => $request->numero_bolsa[ $i ],
			] );
		}
		
		CrudPrerefaccion::ordenAddorUpdate($request->numero_orden,$orden_guardar);
		CrudPrerefaccion::ordenActualizarItems($request->numero_orden,$orden_guardar_items);
		CrudPrerefaccion::ordenActualizarDestinatarios($request->numero_orden,$orden_guardar_destinatarios);
		
		////////TRAZABILIDAD
		for($i=0;$i<count($orden_guardar_items);$i++){
			$traza['trazabilidad']['id_tienda']=$orden_guardar_items[$i]['id_tienda_contrato'];
			$traza['trazabilidad']['id']=$orden_guardar_items[$i]['id_inventario'];
			$traza['trazabilidad']['id_origen']=null;
			$traza['trazabilidad']['fecha_salida']=null;
			$traza['trazabilidad']['movimiento']=$orden_guardar_items[$i]['id_proceso'];
			$traza['trazabilidad']['estado']=$orden_guardar['id_estado'];
			$traza['trazabilidad']['fecha_ingreso']=date("Y-m-d H:i:s");
			$traza['trazabilidad']['ubicacion']='Joyería';
			$traza['trazabilidad']['motivo']='Prerefacción';
			$traza['trazabilidad']['numero_contrato']=null;
			$traza['trazabilidad']['numero_item']=$i+1;
			$traza['trazabilidad']['numero_orden']=$orden_guardar_items[$i]['id_orden_guardar'];
			$traza['trazabilidad']['numero_referente']='Or.'.$orden_guardar_items[$i]['id_orden_guardar'];
			TrazabilidadBL::Create($traza);
		}
		
		return redirect()->back();
		
	}
}

<?php

namespace App\Http\Controllers\Nutibara\Maquila;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Maquila\CrudMaquila;
use App\Http\Middleware\userIpValidated;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Contratos\ResolucionarBL;
use App\AccessObject\Nutibara\Contratos\ResolucionarAO;
use Illuminate\Support\Facades\Auth;
use App\AccessObject\Nutibara\Contratos\Contrato;
use Carbon\Carbon;
use PDF;


class MaquilaController extends Controller
{
    public function Index(){
		$ipValidation = new userIpValidated();
		$tienda = CrudMaquila::getTiendaByIp($ipValidation->getRealIP());
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/maquila',
				'text'=>'Gestión de contratos'
			],
			[
				'href'=>'contrato/maquila',
				'text'=>'Maquila'
				]
			);
			
		return view('Maquila.index',['urls'=>$urls,'tienda' => $tienda]);
    }

    public function get(Request $request){
    	return CrudMaquila::get($request);
    }

    public function maquilaar($id_tienda,$id, $action){

		$idx = explode("-",$id);
		$items = CrudMaquila::getItemOrden($id_tienda,$idx);
		$contratos=array();
		if(count($items)>0){
			foreach($items as $key=>$value){
				array_push($contratos,$value->id_contrato);
			}
			$columnas_items= Contrato::getColumnasItems($contratos,$id_tienda);
			$datos_columnas_items = Contrato::getDatosColumnasItems($contratos,$id_tienda);
			$destinatarios = CrudMaquila::getDestinatariosOrden($id_tienda,$idx);
			if($items[0]->categoria == "Articulo" || $items[0]->categoria == "Artículo" || $items[0]->categoria == "Artículos"){
				$procesos = CrudMaquila::getListProcesoByVitrina();
			}else{
				$procesos = CrudMaquila::getListProceso();
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
				'href'=>'contrato/maquila',
				'text'=>'Gestión de Contratos'
			],
			[
				'href'=>'contrato/maquila',
				'text'=>'Maquila de ordenes'
			],
			[
				'href' => 'contrato/maquila/create/'.$id,
				'text' => 'Maquilar ordenes'
			],
		);	
		return view('Maquila.create',[
											'urls'=>$urls,
											'procesos'=>$procesos,
											'id' => $id,
											'id_tienda_orden' => $id_tienda,
											'items'=>$items,
											'destinatarios' => $destinatarios,
											'action' => $action,
											'columnas_items'=>$columnas_items,
											'datos_columnas_items'=>$datos_columnas_items,
											'tienda'=>$id_tienda,
											'maquila_nacional'=>env('PROCESO_MAQUILA_NACIONAL'),
											'maquila_importada'=>env('PROCESO_MAQUILA_IMPORTADA')
										]);
	}
	
	public function guardar(request $request)
	{
		//dd($request->all());
		$proceso = $request->process_nal_imp;
		$orden_guardar = 
		[
			'id_tienda' => $request->id_tienda_orden,
			'id_categoria_general' => 0,
			'id_estado' => env('ORDEN_PENDIENTE_POR_PROCESAR'),
			'fecha_creacion' => date("Y-m-d H:i:s"),
			'abre_bolsa' => $request->subdividir,
			'id_proceso' => ($proceso > 0) ? $proceso : env('PROCESO_MAQUILA'),
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
				"peso_libre" => str_replace(",", ".", $request->peso_libre[ $i ]),
				'id_inventario' => $request->id_inventario[ $i ],
				'peso_estimado' => str_replace(",", ".", $request->peso_estimado[ $i ]),
				'peso_total' => str_replace(",", ".", $request->peso_total[ $i ]),
				'precio_ingresado' => $request->precio_ingresado[ $i ],
				'fecha_perfeccionamiento' => 0,
			] );
		}
		//falta sucursales
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
		//dd($request->sucursales);
		CrudMaquila::ordenAddOrUpdate($request->numero_orden, $orden_guardar);
		CrudMaquila::ordenActualizarItems($request->numero_orden, $orden_guardar_items);
		CrudMaquila::ordenActualizarDestinatarios($request->numero_orden, $orden_guardar_destinatarios);
		if($proceso > 0)
			return redirect('contrato/maquila');
		else
			return redirect()->back();
	}
 
    public function procesar(request $request){	
		self::guardar($request); 
		// $msm = CrudMaquila::process($request->numero_orden, $request->id_proceso);
		$dataSaved=[
			'numero_orden' => $request->numero_orden,
			'id_item' =>$request->id_item,
			'id_inventario' =>$request->id_inventario,
			'id_hoja_trabajo' =>$request->id_hoja_trabajo,
			'id_tienda_orden' =>$request->id_tienda_orden,
			'subdivision' =>$request->subdivision,
			'numero_documento' => $request->numero_documento,
			'peso_taller' => str_replace(",", ".", $request->peso_taller),
			'peso_estimado' =>str_replace(",", ".", $request->peso_estimado),
			'precio_ingresado' =>$request->precio_ingresado,
			'destinatario' => $request->destinatario,
			'id_proceso' => $request->id_proceso,
			'sucursales' => $request->sucursales,
			'procesar' =>$request->procesar,
			'id_cliente_destinatario' => $request->id_cliente,			
			'id_tienda_cliente_destinatario' => $request->id_tienda_cliente,
			'id_tienda_hoja_trabajo' => $request->id_tienda_hoja_trabajo,
			'id_tienda_inventario' => $request->id_tienda_inventario,

			'mano_obra' => $request->mano_obra,
			'transporte' => $request->transporte,
			'costos_indirectos' => $request->costos_indirectos,
			'otros_costos' => $request->otros_costos
		];
		$msm = CrudMaquila::Procesar($dataSaved);

		// if($msm['val']=='Actualizado'){
		// 	Session::flash('message', 'Orden procesada con éxito');
		// 	return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
		// 	return redirect('/contrato/maquila');
		// }else
		if($msm['val']=='Insertado'){
			Session::flash('message', 'Orden procesada con éxito');
			return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
			return redirect('/contrato/maquila');
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
		for ($i=0; $i < count($ids_ordenes); $i++) { 
			array_push($object, ResolucionarBL::getOrdenPDF($ids_ordenes[$i], $id_tienda));
		}
		$pdf = PDF::loadView('DocumentosPDF.ordenresolucion', [ 'object' => $object, 'user' => $user, 'date' => $date ]);
		return $pdf->download('orden_resolucion.pdf');
	}

	public function generateReportePDF(Request $request){
		$user = Auth::user()->name;
		$date = Carbon::now();
		$object = [];
		$id_orden = $request->id_orden;
		$id_tienda = $request->id_tienda_orden;
		array_push($object, ResolucionarBL::getOrdenPDF($id_orden, $id_tienda));
		
		$pdf = PDF::loadView('DocumentosPDF.ordenresolucion', [ 'object' => $object, 'user' => $user, 'date' => $date ]);
		return $pdf->download('orden_resolucion.pdf');
	}

	public function procesarUpdate($data,$ordenes)
	{
		$msm = CrudMaquila::procesarUpdate($data,$ordenes);
		return $msm;
	}

	public function procesarCrear($data,$ordenes)
	{
		$msm = CrudMaquila::procesarUpdate($data,$ordenes);
		return $msm;
	}

	public function getSelectList()
	{
		$msm = CrudMaquila::getSelectList();
		return  response()->json($msm);
	}

	public function getListProceso()
	{
		$msm = CrudMaquila::getListProceso();
		return  response()->json($msm);
	}

	public function getItemOrden($id_tienda,$id)
	{
		$idx = explode("-",$id);
		$data["data"] = CrudMaquila::getItemOrden($id_tienda,$idx);
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
		$response = CrudMaquila::validarItem($request->id_tienda_inventario,$request->id_inventario,$request->id_contrato);
		return response()->json($response);
	}

	public function quitarItems(request $request)
	{
		$items = explode(",",$request->items);
		$response = CrudMaquila::quitarItems($items);
		return response()->json($response);
	}

	public function generateExcel($id_orden, $id_tienda,$process){
		// dd($id_orden);
		return CrudMaquila::generateExcel($id_orden, $id_tienda,$process);
	}

	public function certificadoMineriaPDF(request $request)
	{
		$id_orden = $request->id_orden;
		$id_tienda = $request->id_tienda_orden;
		$object = CrudMaquila::getItemsMineria($id_orden, $id_tienda);
		$pdf = PDF::loadView('DocumentosPDF.certificadomineria', [ 'object' => $object ]);
		return $pdf->download('certificado_mineria.pdf');
	}
}

<?php

namespace App\Http\Controllers\Nutibara\Refaccion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Refaccion\CrudRefaccion;
use App\Http\Middleware\userIpValidated;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Contratos\ResolucionarBL;
use App\AccessObject\Nutibara\Contratos\ResolucionarAO;
use Illuminate\Support\Facades\Auth;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\Inventario\Trazabilidad\TrazabilidadBL;
use Carbon\Carbon;
use PDF;


class RefaccionController extends Controller
{
    public function Index(){
		$ipValidation = new userIpValidated();
		$tienda = CrudRefaccion::getTiendaByIp($ipValidation->getRealIP());
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/refaccion',
				'text'=>'Gestión de contratos'
			],
			[
				'href'=>'contrato/refaccion',
				'text'=>'Refacción'
				]
			);
			
		return view('Refaccion.index',['urls'=>$urls,'tienda' => $tienda]);
    }

    public function get(Request $request){
    	return CrudRefaccion::get($request);
    }

    public function refaccionar($id_tienda,$id, $action){

		$idx = explode("-",$id);
		$items = CrudRefaccion::getItemOrden($id_tienda,$idx);
		$destinatarios = CrudRefaccion::getDestinatariosOrden($id_tienda,$idx);
		$contratos = array();
		foreach ($items as $key => $value){
			array_push($contratos, $value->id_contrato);
		}
		$columnas_items = Contrato::getColumnasItems( $contratos, $id_tienda );
		$datos_columnas_items = Contrato::getDatosColumnasItems( $contratos, $id_tienda );
		if($items[0]->categoria == "Articulo" || $items[0]->categoria == "Artículo" || $items[0]->categoria == "Artículos"){
			$procesos = CrudRefaccion::getListProcesoByVitrina();
		}else{
			$procesos = CrudRefaccion::getListProceso();
		}
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/refaccion',
				'text'=>'Gestion de contrato'
			],
			[
				'href'=>'contrato/refaccion',
				'text'=>'Refaccion de ordenes'
			],
			[
				'href' => 'contrato/refaccion/create/'.$id,
				'text' => 'Refaccionar ordenes'
			],
		);
		return view('Refaccion.create',[
											'urls'=>$urls,
											'procesos'=>$procesos,
											'id' => $id,
											'id_tienda_orden' => $id_tienda,
											'items'=>$items,
											'destinatarios' => $destinatarios,
											'columnas_items' => $columnas_items,
											'datos_columnas_items' => $datos_columnas_items,
											'action' => $action
										]);
	}
	
	public function guardar(request $request)
	{
		$orden_guardar = 
		[
			'id_tienda' => $request->id_tienda_orden,
			'id_categoria_general' => 0,
			'id_estado' => env('ORDEN_PENDIENTE_POR_PROCESAR'),
			'fecha_creacion' => date("Y-m-d H:i:s"),
			'abre_bolsa' => $request->subdividir,
			'id_proceso' => env('PROCESO_REFACCION'),
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
				"peso_taller" => $request->peso_taller[ $i ],
				'id_inventario' => $request->id_inventario[ $i ],
				'peso_estimado' => $request->peso_estimado[ $i ],
				'peso_total' => $request->peso_total[ $i ],
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
		ResolucionarAO::ordenAddOrUpdate($request->numero_orden, $orden_guardar);
		ResolucionarAO::ordenActualizarItems($request->numero_orden, $orden_guardar_items);
		ResolucionarAO::ordenActualizarDestinatarios($request->numero_orden, $orden_guardar_destinatarios);
		return redirect()->back();
	}
 
    public function procesar(request $request){	
		//dd($request->all());
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
		$msm = CrudRefaccion::Procesar($dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', 'Orden procesada con éxito');
			Session::flash('return_redirect', 'contrato/refaccion');
			return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
			return redirect('/contrato/refaccion');
		}
		elseif($msm['val']=='Insertado'){
			Session::flash('message', 'Orden sub dividida con éxito');
			Session::flash('return_redirect', 'contrato/refaccion');
			return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
			return redirect('/contrato/refaccion');
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
		$items = CrudRefaccion::getItemOrden($id_tienda,$ids_ordenes);
		$destinatarios = CrudRefaccion::getDestinatariosOrdenPadre($id_tienda,$ids_ordenes);
		$contratos = array();
		foreach ($items as $key => $value){
			array_push($contratos, $value->id_contrato);
		}
		$columnas_items = Contrato::getColumnasItems( $contratos, $id_tienda );
        $datos_columnas_items = Contrato::getDatosColumnasItems( $contratos, $id_tienda );
		$object = [];
		for ($i=0; $i < count($ids_ordenes); $i++) { 
			array_push($object, ResolucionarBL::getOrdenPDF($ids_ordenes[$i], $id_tienda));
		}
		$pdf = PDF::loadView('DocumentosPDF.ordenresolucion', [ 
			'object' => $object,
			'user' => $user,
			'date' => $date,
			'columnas_items' => $columnas_items,
			'datos_columnas_items' => $datos_columnas_items,
			'contratos' => $contratos,
			'destinatarios' => $destinatarios
		]);
		return $pdf->download('orden_resolucion.pdf');
	}

	public function generateReportePDF(Request $request){
		
		$id_orden = array($request->id_orden);
		$id_tienda = $request->id_tienda_orden;
		$user = Auth::user()->name;
		$date = Carbon::now();
		$items = CrudRefaccion::getItemOrden($id_tienda,$id_orden);
		$destinatarios = CrudRefaccion::getDestinatariosOrdenPadre($id_tienda,$id_orden);
		$contratos = array();
		foreach ($items as $key => $value){
			array_push($contratos, $value->id_contrato);
		}
		$columnas_items = Contrato::getColumnasItems( $contratos, $id_tienda );
        $datos_columnas_items = Contrato::getDatosColumnasItems( $contratos, $id_tienda );
		$object = [];
		array_push($object, ResolucionarBL::getOrdenPDF($id_orden, $id_tienda));
		
		$pdf = PDF::loadView('DocumentosPDF.ordenresolucion', [ 
			'object' => $object,
			'user' => $user,
			'date' => $date,
			'columnas_items' => $columnas_items,
			'datos_columnas_items' => $datos_columnas_items,
			'contratos' => $contratos,
			'destinatarios' => $destinatarios
		]);
		return $pdf->download('orden_resolucion.pdf');
	}

	public function procesarUpdate($data,$ordenes)
	{
		$msm = CrudRefaccion::procesarUpdate($data,$ordenes);
		return $msm;
	}

	public function procesarCrear($data,$ordenes)
	{
		$msm = CrudRefaccion::procesarUpdate($data,$ordenes);
		return $msm;
	}

	public function getSelectList()
	{
		$msm = CrudRefaccion::getSelectList();
		return  response()->json($msm);
	}

	public function getListProceso()
	{
		$msm = CrudRefaccion::getListProceso();
		return  response()->json($msm);
	}

	public function getItemOrden($id_tienda,$id)
	{
		$idx = explode("-",$id);
		$data["data"] = CrudRefaccion::getItemOrden($id_tienda,$idx);
		$contratos = array();
		foreach ($data["data"] as $key => $value){
			array_push($contratos, $value->id_contrato);
		}
		$data["columnas_items"] = Contrato::getColumnasItems( $contratos, $id_tienda );
		$data["datos_columnas_items"] = Contrato::getDatosColumnasItems( $contratos, $id_tienda );
		return  response()->json($data);
	}

	public function validarItem(request $request)
	{
		$response = CrudRefaccion::validarItem($request->id_tienda_inventario,$request->id_inventario,$request->id_contrato);
		return response()->json($response);
	}

	public function quitarItems(request $request)
	{
		$items = ($request->items);
		$response = CrudRefaccion::quitarItems($items);
		return response()->json($response);
	}

	public function generateExcel($id_orden, $id_tienda,$process){
		// dd($id_orden);
		return CrudRefaccion::generateExcel($id_orden, $id_tienda,$process);
	}

	public function certificadoMineriaPDF(request $request)
	{
		$id_orden = $request->id_orden;
		$id_tienda = $request->id_tienda_orden;
		$object = CrudRefaccion::getItemsMineria([$id_orden], $id_tienda);
		$pdf = PDF::loadView('DocumentosPDF.certificadomineria', [ 'object' => $object ]);
		return $pdf->download('certificado_mineria.pdf');
	}

	// Función para anular una orden
	// Se debe reactivar la orden anterior
	public function AnularOrden(request $request)
	{
		$items = CrudRefaccion::getItemOrdenConcat($request->id_tienda,$request->id_orden);
		$data = CrudRefaccion::AnularOrden($items);
		return response()->json($data);
	}
}

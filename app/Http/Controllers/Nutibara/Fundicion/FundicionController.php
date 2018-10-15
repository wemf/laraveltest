<?php

namespace App\Http\Controllers\Nutibara\Fundicion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Fundicion\CrudFundicion;
use App\Http\Middleware\userIpValidated;
use Illuminate\Support\Facades\Session;
use App\AccessObject\Nutibara\Fundicion\Fundicion;
use App\BusinessLogic\Nutibara\Contratos\ResolucionarBL;
use App\AccessObject\Nutibara\Contratos\ResolucionarAO;
use App\BusinessLogic\Nutibara\Resolucion AS CrudResolucion;
use App\AccessObject\Nutibara\Contratos\Contrato;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use dateFormate;
use PDF;

class FundicionController extends Controller
{
   public function Index(){
		$ipValidation = new userIpValidated();
		$tienda = CrudFundicion::getTiendaByIp($ipValidation->getRealIP());
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/fundicion',
				'text'=>'Gestión de contratos'
			],
			[
				'href'=>'contrato/fundicion',
				'text'=>'Fundición'
			]
		);
		
		return view('Fundicion.index',['urls'=>$urls,'tienda' => $tienda]);
    }

    public function get(Request $request){
    	return CrudFundicion::get($request);
    }

    public function fundir($id_tienda,$id, $action,$ver = 0){
		$idx = explode("-",$id);		
		$items = CrudFundicion::getItemOrden($id_tienda,$idx);
		$contratos = array();
		foreach ($items as $key => $value){
			array_push($contratos, $value->id_contrato);
		}
		$columnas_items = Contrato::getColumnasItems( $contratos, $id_tienda );
		$datos_columnas_items = Contrato::getDatosColumnasItems( $contratos, $id_tienda );
		if(isset($items[0]->id_contrato)){
			$datos_perfeccionamiento = CrudFundicion::datosPerfeccionamiento($id_tienda, $items[0]->id_contrato);
		}
		$destinatarios = CrudFundicion::getDestinatariosOrden($id_tienda,$idx);
		if($items[0]->categoria == "Articulo" || $items[0]->categoria == "Artículo" || $items[0]->categoria == "Artículos"){
			$procesos = CrudFundicion::getListProcesoByVitrina();
		}else{
			$procesos = CrudFundicion::getListProceso();
		}
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/fundicion',
				'text'=>'Gestion de contrato'
			],
			[
				'href'=>'contrato/fundicion',
				'text'=>'Fundicion de ordenes'
			],
			[
				'href' => 'contrato/fundicion/create/'.$id,
				'text' => 'Fundicionar ordenes'
			],
		);
		return view('Fundicion.create',[
											'urls'=>$urls,
											'procesos'=>$procesos,
											'ver' => $ver,
											'id' => $id,
											'id_tienda_orden' => $id_tienda,
											'items'=>$items,
											'destinatarios' => $destinatarios,
											'action' => $action,
											'columnas_items' => $columnas_items,
											'datos_columnas_items' => $datos_columnas_items,
											'datos_perfeccionamiento' => $datos_perfeccionamiento,
											'tienda' => $id_tienda
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
			'id_proceso' => env('PROCESO_FUNDICION'),
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
					"peso_taller" => $request->peso_taller_individual[ $i ],
					'id_inventario' => $request->id_inventario[ $i ],
					'peso_estimado' => $request->peso_estimado[ $i ],
					'peso_libre' => str_replace(",", ".", $request->peso_libre[ $i ]),
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

		$orden_actualizar_peso_libre = array();
			for($i=0; $i < count($request->id_inventario); $i++){
				array_push($orden_actualizar_peso_libre, [
					"id_orden" => $request->numero_orden,
					"id_inventario" => $request->id_inventario[ $i ],
					"peso_libre" => str_replace(",", ".", $request->peso_libre[$i]),
				]);
			}
		
		Fundicion::ordenAddOrUpdate($request->numero_orden, $orden_guardar);
		Fundicion::ordenActualizarItems($request->numero_orden, $orden_guardar_items);
		Fundicion::ordenActualizarDestinatarios($request->numero_orden, $orden_guardar_destinatarios);
		Fundicion::ordenActualizarPesoLibre($orden_actualizar_peso_libre);
		return redirect()->back();
	}

	public function procesar(request $request)
	{
		$dataSaved=[
			'numero_orden' => $request->numero_orden,
			'id_item' =>$request->id_item,
			'id_inventario' =>$request->id_inventario,
			'id_hoja_trabajo' =>$request->id_hoja_trabajo,
			'id_tienda_orden' =>$request->id_tienda_orden,
			'subdivision' =>$request->subdivision,
			'numero_documento' => $request->numero_documento,
			'peso_taller_individual' => str_replace(",", ".", $request->peso_taller_individual),
			'peso_libre' => str_replace(",", ".", $request->peso_libre),
			'peso_estimado' => str_replace(",", ".", $request->peso_estimado),
			'precio_ingresado' =>$request->precio_ingresado,
			'destinatario' => $request->destinatario,
			'id_proceso' => $request->id_proceso,
			'sucursales' => $request->sucursales,
			'procesar' =>$request->procesar,
			'id_cliente_destinatario' => $request->id_cliente,			
			'id_tienda_cliente_destinatario' => $request->id_tienda_cliente,
			'id_tienda_hoja_trabajo' => $request->id_tienda_hoja_trabajo,
			'id_tienda_inventario' => $request->id_tienda_inventario,
			'numero_bolsa' => $request->numero_bolsa,
			"codigo_verificacion" => $request->digito_verificacion,
			/*DATOS PARA EL MOVIMIENTO CONTABLE*/
			'peso_total' => str_replace(",", ".", $request->peso_total),
			'peso_estimado_modal' => $request->peso_estimado_modal,
			'peso_libre_modal' => $request->peso_libre_modal,
			'merma_modal' => $request->merma_modal,
			'valor_merma' => $request->valor_merma,
			'merma_por_item' => $request->merma_por_item,
		];

		$msm = CrudFundicion::Procesar($dataSaved);

		if($msm['val']=='Insertado'){
			Session::flash('message', 'Orden sub dividida con éxito');
			return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
			return redirect('/contrato/fundicion');
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
		$items = CrudFundicion::getItemOrden($id_tienda,$ids_ordenes);
		$destinatarios = CrudFundicion::getDestinatariosOrdenPadre($id_tienda,$ids_ordenes);
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
		return $pdf->download('orden_fundicion.pdf');
	} 

	public function generateReportePDF(Request $request){
		$id_orden = array($request->id_orden);
		$id_tienda = $request->id_tienda_orden;
		$user = Auth::user()->name;
		$date = Carbon::now();
		$items = CrudFundicion::getItemOrden($id_tienda,$id_orden);
		$destinatarios = CrudFundicion::getDestinatariosOrdenPadre($id_tienda,$id_orden);
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
		return $pdf->download('orden_fundicion.pdf');
	}

	public function procesarUpdate($data,$ordenes)
	{
		$msm = CrudFundicion::procesarUpdate($data,$ordenes);
		return $msm;
	}

	public function procesarCrear($data,$ordenes)
	{
		$msm = CrudFundicion::procesarUpdate($data,$ordenes);
		return $msm;
	}

	public function getSelectList()
	{
		$msm = CrudFundicion::getSelectList();
		return  response()->json($msm);
	}

	public function getListProceso()
	{
		$msm = CrudFundicion::getListProceso();
		return  response()->json($msm);
	}

	public function getItemOrden($id_tienda,$id)
	{
		$idx = explode("-",$id);
		$data["data"] = CrudFundicion::getItemOrden($id_tienda,$idx);
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
		$response = CrudFundicion::validarItem($request->id_tienda_inventario,$request->id_inventario,$request->id_contrato);
		return response()->json($response);
	}

	public function quitarItems(request $request)
	{
		$items = explode(",",$request->items);
		$response = CrudFundicion::quitarItems($items);
		return response()->json($response);
	}

	public function generateExcel($id_orden, $id_tienda,$process){
		return CrudFundicion::generateExcel($id_orden, $id_tienda,$process);
	}

	public function certificadoMineriaPDF(request $request)
	{
		$id_orden = $request->id_orden;
		$id_tienda = $request->id_tienda_orden;
		$object = CrudFundicion::getItemsMineria($id_orden, $id_tienda);
		$pdf = PDF::loadView('DocumentosPDF.certificadomineria', [ 'object' => $object ]);
		return $pdf->download('certificado_mineria.pdf');
	}

	// Función para anular una orden
	public function AnularOrden(request $request)
	{
		$items = CrudFundicion::getItemOrdenConcat($request->id_tienda,$request->id_orden);
		$data = CrudFundicion::AnularOrden($items);
		return response()->json($data);
	}
}

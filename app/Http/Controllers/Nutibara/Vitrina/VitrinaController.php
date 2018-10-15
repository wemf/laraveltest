<?php

namespace App\Http\Controllers\Nutibara\Vitrina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Vitrina\CrudVitrina;
use App\AccessObject\Nutibara\Vitrina\Vitrina;
use App\BusinessLogic\Nutibara\Refaccion\CrudRefaccion;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\userIpValidated;
use App\BusinessLogic\Nutibara\Contratos\ResolucionarBL;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use dateFormate;
use App\BusinessLogic\Notificacion\ResolucionContrato;

class VitrinaController extends Controller
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
				'href'=>'contrato/vitrina',
				'text'=>'Gestión de Contratos'
			],
			[
				'href'=>'contrato/vitrina',
				'text'=>'Ordenes de perfeccionamiento'
			],
			[
				'href'=>'contrato/vitrina',
				'text'=>'Vitrina'
			]
		);
		return view('Vitrina.index',['urls'=>$urls ,'tienda' => $tienda]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["id_tienda"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["id_categoria"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["id_estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=count(CrudVitrina::getCountVitrina($search));
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudVitrina::Vitrina($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
	}
	
	public function Create($id_tienda,$ids_orden,$ver = 0, $id_remitente = 0){


		$id_orden = explode("-", $ids_orden);
		$procesos = CrudVitrina::getListProceso();
		$resultado = CrudVitrina::DetalleOrdenesVitrina($id_tienda,$id_orden);
		$anterior = Vitrina::getProcesoAnterior($id_tienda,$id_orden);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/vitrina',
				'text'=>'Gestión de Contratos'
			],
			[
				'href'=>'contrato/vitrina',
				'text'=>'Vitrina'
			],
			[
				'href' => 'contrato/vitrina/procesar/'.$id_tienda.'/'.$ids_orden,
				'text' => 'Procesar Orden de Vitrina'
			],
		);
		return view('Vitrina.create',[
										'urls'=>$urls,
										'procesos'=>$procesos,
										'id' =>$ids_orden,
										'items'=>$resultado,
										'id_remitente'=>$id_remitente,
										'ver' => $ver,
										'tienda' => $id_tienda,
										'anterior' => $anterior
										]);
	}

	public function generateExcel($id_orden, $id_tienda,$process){
		// dd($id_orden);
		return CrudVitrina::generateExcel($id_orden, $id_tienda,$process);
	}
	 
	public function Procesar(Request $request)
	{
		$dataSaved=[
			'numero_orden' => $request->numero_orden,
			'id_item' =>$request->id_item,
			'id_inventario' =>$request->id_inventario,
			'id_hoja_trabajo' =>$request->hoja_trabajo,
			'id_tienda_orden' =>$request->id_tienda_orden,
			'subdivision' =>$request->subdivision,
			'peso_taller' =>$request->peso_taller,
			'numero_documento' => $request->numero_documento,
			'sucursales' => $request->sucursales,
			'id_cliente_destinatario' => $request->id_cliente,
			'id_tienda_cliente_destinatario' => $request->id_tienda_cliente,
			'id_proceso' => $request->id_proceso,
			'procesar' =>$request->procesar,
			'peso_libre' => $request->peso_libre,
			'precio_ingresado' => $request->precio_ingresado,
			'peso_estimado' => $request->peso_estimado
		];
		$msm=CrudVitrina::Procesar($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
			return redirect('/contrato/vitrina');
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

	public function getItemOrden($id_tienda,$id)
	{
		$idx = explode("-",$id);
		$response = CrudVitrina::getItemOrden($id_tienda,$idx);
		return  response()->json($response);
	}
	
	public function GetProveedorById(Request $request)
	{
		$ipValidation = new userIpValidated();
		$tienda = CrudRefaccion::getTiendaByIp($ipValidation->getRealIP());
		$response = CrudVitrina::GetProveedorById($tienda,$request->nit);
		return  response()->json($response);
	}

	public function reclasificarItemGet( Request $request ){
		$response = CrudVitrina::reclasificarItemGet($request->id_tienda, $request->id_inventario);
		return response()->json($response);
	}

	public function reclasificarItemPost( Request $request ){
		$response = CrudVitrina::reclasificarItemPost($request->id_categoria, $request->data_reference, (string) $request->id_inventario, (string) $request->id_tienda_inventario, $request->codigo_contrato, $request->id_linea_item);
		return response()->json($response);
	}

	public function SolicitarProcesarVitrina( Request $request ){
		CrudVitrina::SolicitarProcesarVitrina($request);
		$resolucion_vitrina = new ResolucionContrato($request);
		$mensaje = $resolucion_vitrina->SolicitarProcesarVitrina();
		return response()->json(['msm'=>$mensaje]);
	}

	public function SolicitarProcesarVitrinaJZ( Request $request ){
		CrudVitrina::SolicitarProcesarVitrina($request);
		$resolucion_vitrina = new ResolucionContrato($request);
		$mensaje = $resolucion_vitrina->SolicitarProcesarVitrina();
		return response()->json(['msm'=>$mensaje]);
	}

	public function guardarVitrina( Request $request ){
		$response = CrudVitrina::guardarVitrina($request);
		return response()->json($response);
	}

	public function rechazarVitrina( Request $request ){
		$response = CrudVitrina::rechazarVitrina($request);
		return response()->json($response);
	}
}

<?php

namespace App\Http\Controllers\Nutibara\JoyaEspecial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\JoyaEspecial\CrudJoyaEspecial;
use App\BusinessLogic\Nutibara\Refaccion\CrudRefaccion;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\userIpValidated;
use App\BusinessLogic\Nutibara\Contratos\ResolucionarBL;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use dateFormate;


class JoyaEspecialController extends Controller
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
				'href'=>'contrato/joyaespecial',
				'text'=>'Gestión de Contratos'
			],
			[
				'href'=>'contrato/joyaespecial',
				'text'=>'JoyaEspecial'
			]
		);
		return view('JoyaEspecial.index',['urls'=>$urls ,'tienda' => $tienda]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["name"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=CrudJoyaEspecial::getCountJoyaEspecial($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudJoyaEspecial::JoyaEspecial($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
	}
	
	public function Create($id_tienda,$ids_orden){

		$id_orden = explode("-", $ids_orden);
		$procesos = CrudJoyaEspecial::getListProceso();
		$resultado = CrudJoyaEspecial::DetalleOrdenesJoyaEspecial($id_tienda,$id_orden);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/joyaespecial',
				'text'=>'Gestión de Contratos'
			],
			[
				'href'=>'contrato/joyaespecial',
				'text'=>'Joya Especial'
			],
			[
				'href' => 'contrato/joyaespecial/procesar/'.$id_tienda.'/'.$ids_orden,
				'text' => 'Procesar Orden de Joya Especial'
			],
		);
		return view('JoyaEspecial.create',[
										'urls'=>$urls,
										'procesos'=>$procesos,
										'id' =>$ids_orden,
										'items'=>$resultado,
										]);
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
			'procesar' =>$request->procesar
		];
		$msm=CrudJoyaEspecial::Procesar($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
			return redirect('/contrato/joyaespecial');
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
		$response = CrudJoyaEspecial::getItemOrden($id_tienda,$idx);
		return  response()->json($response);
	}

}

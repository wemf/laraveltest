<?php

namespace App\Http\Controllers\Nutibara\ConfigContrato;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use dateFormate;

use App\BusinessLogic\Nutibara\ConfigContrato\ApliRetroventaBusinessLogic;

class ApliRetroventaController extends Controller
{

    public function index(){
		
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/apliretroventa',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/apliretroventa',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/apliretroventa',
				'text'=>'Aplicaciones de Retroventa'
			]
		);
		return view('ConfigContrato.ApliRetroventa.index',['urls'=>$urls]);
    }

    public function get(request $request){
        $start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["pais"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["departamento"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["ciudad"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["zona"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$search["tienda"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
		$search["montodesde"] = str_replace($vowels, "", $request->columns[5]['search']['value']);
		$search["montohasta"] = str_replace($vowels, "", $request->columns[6]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[7]['search']['value']);
		$total=ApliRetroventaBusinessLogic::getCountApliRetroventa($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(ApliRetroventaBusinessLogic::ApliRetroventa($start,$end,$colum, $order,$search)->toArray())
		];
		return response()->json($data);
    }

    public function create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/apliretroventa',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/apliretroventa',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/apliretroventa',
				'text'=>'Aplicaciones de Retroventa'
			],
			[
				'href' => 'configcontrato/apliretroventa/create',
				'text' => 'Nueva Aplicación de Retroventa'
			],
		);
		return view('ConfigContrato.ApliRetroventa.create',['urls'=>$urls]);
    }

    public function store(request $request){
		$dataSaved=[
			'id_pais' => trim($request->pais),
			'id_departamento' => (trim($request->departamento) == null)?0:trim($request->departamento),
			'id_ciudad' => (trim($request->ciudad) == null)?0:trim($request->ciudad),
			'id_tienda' => (trim($request->tienda) == null || trim($request->tienda) == "- Seleccione una opción -")?0:trim($request->tienda),
			'dias_desde' => (trim($request->dias_desde) == null)?null:trim($request->dias_desde),
			'dias_hasta' => (trim($request->dias_hasta) == null)?null:trim($request->dias_hasta),
			'meses_desde' => (trim($request->meses_desde) == null)?null:trim($request->meses_desde),
			'meses_hasta' => (trim($request->meses_hasta) == null)?null:trim($request->meses_hasta),
			'dias_transcurridos' => (trim($request->dias_transcurridos) == null)?null:trim($request->dias_transcurridos),
			'menos_meses' => (trim($request->menos_meses) == null)?null:trim($request->menos_meses),
			'menos_porcentaje_retroventas' => (trim($request->menos_porcentaje_retroventas) == null)?null:trim($request->menos_porcentaje_retroventas),
			'monto_desde' => (trim($request->monto_desde) == null)?null:self::limpiarVal($request->monto_desde),
			'monto_hasta' => (trim($request->monto_hasta) == null)?null:self::limpiarVal($request->monto_hasta),
			'estado' => 1
		];
		if( ApliRetroventaBusinessLogic::validateUnique( $dataSaved ) ){
			$msm=ApliRetroventaBusinessLogic::Create($dataSaved);
			if($msm['val']=='Insertado'){
				Session::flash('message', $msm['msm']);
				return redirect('/configcontrato/apliretroventa');
			}
			elseif($msm['val']=='Error'){
				Session::flash('error', $msm['msm']);
			}
			elseif($msm['val']=='ErrorUnico'){
				Session::flash('warning', $msm['msm']);
			}
		}else{
			Session::flash( 'warning', 'El rango de montos está interfiriendo con otra configuración similar' );
		}
		
		return redirect()->back();
    }

    public function edit($id){
		$data=dateFormate::ToArrayInverse(ApliRetroventaBusinessLogic::getApliRetroventaById($id)->toArray());
		$apliretroventa=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/apliretroventa',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/apliretroventa',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/apliretroventa',
				'text'=>'Aplicaciones de Retroventa'
			],
			[
				'href' => 'configcontrato/apliretroventa/edit/'.$id,
				'text' => 'Editar Aplicación de Retroventa'
			],
		);
		return view('ConfigContrato.ApliRetroventa.edit',['apliretroventa' => $apliretroventa,'urls'=>$urls]);
	}

    public function update(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'id_pais' => trim($request->pais),
			'id_departamento' => (trim($request->departamento) == null)?0:trim($request->departamento),
			'id_ciudad' => (trim($request->ciudad) == null)?0:trim($request->ciudad),
			'id_tienda' => (trim($request->tienda) == null || trim($request->tienda) == "- Seleccione una opción -")?0:trim($request->tienda),
			'dias_desde' => (trim($request->dias_desde) == null)?null:trim($request->dias_desde),
			'dias_hasta' => (trim($request->dias_hasta) == null)?null:trim($request->dias_hasta),
			'meses_desde' => (trim($request->meses_desde) == null)?null:trim($request->meses_desde),
			'meses_hasta' => (trim($request->meses_hasta) == null)?null:trim($request->meses_hasta),
			'dias_transcurridos' => (trim($request->dias_transcurridos) == null)?null:trim($request->dias_transcurridos),
			'menos_meses' => (trim($request->menos_meses) == null)?null:trim($request->menos_meses),
			'menos_porcentaje_retroventas' => (trim($request->menos_porcentaje_retroventas) == null)?null:trim($request->menos_porcentaje_retroventas),
			'monto_desde' => (trim($request->monto_desde) == null)?null:self::limpiarVal($request->monto_desde),
			'monto_hasta' => (trim($request->monto_hasta) == null)?null:self::limpiarVal($request->monto_hasta),
		];

		

		if( ApliRetroventaBusinessLogic::validateUnique( $dataSaved, $id ) ){
			$msm=ApliRetroventaBusinessLogic::update($id,$dataSaved);
			if($msm['val']=='Actualizado'){
				Session::flash('message', $msm['msm']);
				return redirect('/configcontrato/apliretroventa');
			}
			elseif($msm['val']=='Error'){
				Session::flash('error', $msm['msm']);
			}
			elseif($msm['val']=='ErrorUnico'){
				Session::flash('warning', $msm['msm']);
			}
		}else{
			Session::flash( 'warning', 'El rango de montos está interfiriendo con otra configuración similar' );
		}
		return redirect()->back();
	}

    public function inactive(request $request){
		$msm=ApliRetroventaBusinessLogic::inactive($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=ApliRetroventaBusinessLogic::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function delete(request $request){
		$msm=ApliRetroventaBusinessLogic::delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function limpiarVal($val)
	{
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}

}
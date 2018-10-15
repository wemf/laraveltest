<?php

namespace App\Http\Controllers\Nutibara\ConfigContrato;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use dateFormate;

use App\BusinessLogic\Nutibara\ConfigContrato\EspecificaBusinessLogic;

class EspecificaController extends Controller
{

    public function index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/especifica',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/especifica',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/especifica',
				'text'=>'Configuraciones Específicas de Contrato'
			]
		);
		return view('ConfigContrato.Especifica.index',['urls'=>$urls]);
    }

    public function get(request $request){
        $start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["pais"] = str_replace($vowels, "", $request->columns[7]['search']['value']);
		$search["departamento"] = str_replace($vowels, "", $request->columns[8]['search']['value']);
		$search["calificacion"] = str_replace($vowels, "", $request->columns[9]['search']['value']);
		$search["ciudad"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["zona"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["tienda"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["montodesde"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$search["montohasta"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
		$search["vigente"] = str_replace($vowels, "", $request->columns[5]['search']['value']);
		$search["categoria"] = str_replace($vowels, "", $request->columns[6]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[10]['search']['value']);
		$total=EspecificaBusinessLogic::getCountEspecifica($search);
		$data=[
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(EspecificaBusinessLogic::Especifica($start,$end,$colum, $order,$search)->toArray())
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
				'href'=>'configcontrato/especifica',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/especifica',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/especifica',
				'text'=>'Configuraciones Específicas de Contrato'
			],
			[
				'href' => 'configcontrato/especifica/create',
				'text' => 'Nueva Configuración Específica de Contrato'
			],
		);
		return view('ConfigContrato.Especifica.create',['urls'=>$urls]);
    }

    public function store(request $request){
		$dataSaved=[
			'id_tienda' => (trim($request->tienda) == null)?0:trim($request->tienda),
			'id_pais' => (trim($request->pais) == null)?0:trim($request->pais),
			'id_departamento' => (trim($request->departamento) == null)?0:trim($request->departamento),
			'id_ciudad' => (trim($request->ciudad) == null)?0:trim($request->ciudad),
			'id_categoria_general' => trim($request->categoria),
			'id_calificacion_cliente' => (trim($request->id_calificacion_cliente) == "")?0:trim($request->id_calificacion_cliente),
			'monto_desde' => (trim($request->monto_desde) == "")?0:self::limpiarVal($request->monto_desde),
			'monto_hasta' => (trim($request->monto_hasta) == "")?0:self::limpiarVal($request->monto_hasta),
			'fecha_hora_vigencia_desde' => trim($request->fecha_hora_vigencia_desde),
			'fecha_hora_vigencia_hasta' => trim($request->fecha_hora_vigencia_hasta),
			'termino_contrato' => trim($request->termino_contrato),
			'porcentaje_retroventa' => trim($request->porcentaje_retroventa),
			'dias_gracia' => trim($request->dias_gracia),
			'estado' => 1
		];

		if( EspecificaBusinessLogic::validateUnique( $dataSaved ) ) {
			$msm=EspecificaBusinessLogic::Create($dataSaved);
			if($msm['val']=='Insertado'){
				Session::flash('message', $msm['msm']);
				return redirect('/configcontrato/especifica');	
			}
			elseif($msm['val']=='Error'){
				Session::flash('error', $msm['msm']);
			}
			elseif($msm['val']=='ErrorUnico'){
				Session::flash('warning', $msm['msm']);
			}
		} else {
			Session::flash('warning', 'El rango de montos y vigencia está interfiriendo con otra configuración' );
		}
		
		return redirect()->back();
    }

    public function edit($id){
		$data=dateFormate::ToArrayInverse(EspecificaBusinessLogic::getEspecificaById($id)->toArray());
		$especifica=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/especifica',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/especifica',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/especifica',
				'text'=>'Configuraciones Específica de Contrato'
			],
			[
				'href' => 'configcontrato/especifica/edit/'.$id,
				'text' => 'Editar configuración Especifica de contrato'
			],
		);
		return view('ConfigContrato.Especifica.edit',['especifica' => $especifica,'urls'=>$urls]);
	}

    public function update(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'id_tienda' => (trim($request->tienda) == null)?null:trim($request->tienda),
			'id_pais' => (trim($request->pais) == null)?0:trim($request->pais),
			'id_departamento' => (trim($request->departamento) == null)?0:trim($request->departamento),
			'id_ciudad' => (trim($request->ciudad) == null)?0:trim($request->ciudad),
			'id_categoria_general' => trim($request->categoria),
			'id_calificacion_cliente' => (trim($request->id_calificacion_cliente) == "")?0:trim($request->id_calificacion_cliente),
			'monto_desde' => (trim($request->monto_desde) == "")?0:self::limpiarVal($request->monto_desde),
			'monto_hasta' => (trim($request->monto_hasta) == "")?0:self::limpiarVal($request->monto_hasta),
			'fecha_hora_vigencia_desde' => trim($request->fecha_hora_vigencia_desde),
			'fecha_hora_vigencia_hasta' => trim($request->fecha_hora_vigencia_hasta),
			'termino_contrato' => trim($request->termino_contrato),
			'porcentaje_retroventa' => trim($request->porcentaje_retroventa),
			'dias_gracia' => trim($request->dias_gracia)
		];

		$msm=EspecificaBusinessLogic::update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/configcontrato/especifica');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
	}

    public function inactive(request $request){
		$msm=EspecificaBusinessLogic::inactive($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=EspecificaBusinessLogic::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function delete(request $request){
		$msm=EspecificaBusinessLogic::delete($request->id);
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
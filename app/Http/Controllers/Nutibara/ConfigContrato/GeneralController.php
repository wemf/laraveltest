<?php

namespace App\Http\Controllers\Nutibara\ConfigContrato;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use dateFormate;

use App\BusinessLogic\Nutibara\ConfigContrato\GeneralBusinessLogic;

class GeneralController extends Controller
{

    public function index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/general',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/general',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/general',
				'text'=>'Configuraciones generales de Contrato'
			]
		);
		return view('ConfigContrato.General.index',['urls'=>$urls]);
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
		$search["categoria"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=GeneralBusinessLogic::getCountGeneral($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(GeneralBusinessLogic::General($start,$end,$colum, $order,$search)->toArray())
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
				'href'=>'configcontrato/general',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/general',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/general',
				'text'=>'Configuraciones generales de Contrato'
			],
			[
				'href' => 'configcontrato/general/create',
				'text' => 'Nueva Configuración general de Contrato'
			],
		);
		return view('ConfigContrato.General.create',['urls'=>$urls]);
    }

    public function store(request $request){
		$dataSaved=[
			'id_pais' => trim($request->pais),
			'id_categoria_general' => trim($request->categoria),
			'vigencia_desde' => trim($request->vigencia_desde),
			'vigencia_hasta' => trim($request->vigencia_hasta),
			'termino_contrato' => trim($request->termino_contrato),
			'porcentaje_retroventa' => trim($request->porcentaje_retroventa),
			'cantidad_aplazos_contrato' => trim($request->cantidad_aplazos_contrato),
			'dias_gracia' => trim($request->dias_gracia),
			'estado' => 1
		];

		if( GeneralBusinessLogic::validateUnique($dataSaved) ) {
			$msm=GeneralBusinessLogic::Create($dataSaved);
			if($msm['val']=='Insertado'){
				Session::flash('message', $msm['msm']);
				return redirect('/configcontrato/general');		
			}
			elseif($msm['val']=='Error'){
				Session::flash('error', $msm['msm']);
			}
			elseif($msm['val']=='ErrorUnico'){
				Session::flash('warning', $msm['msm']);
			}
		} else {
			Session::flash('warning', 'Ya existe una configuración general con una vigencia similar');
		}
		
		return redirect()->back();
    }

    public function edit($id){
		$data=dateFormate::ToArrayInverse(GeneralBusinessLogic::getGeneralById($id)->toArray());
		$general=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/general',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/general',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/general',
				'text'=>'Configuraciones generales de Contrato'
			],
			[
				'href' => 'configcontrato/general/edit/'.$id,
				'text' => 'Editar configuración general de contrato'
			],
		);
		return view('ConfigContrato.General.edit',['general' => $general,'urls'=>$urls]);
	}

    public function update(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'id_pais' => trim($request->pais),
			'id_categoria_general' => trim($request->categoria),
			'vigencia_desde' => trim($request->vigencia_desde),
			'vigencia_hasta' => trim($request->vigencia_hasta),
			'termino_contrato' => trim($request->termino_contrato),
			'porcentaje_retroventa' => trim($request->porcentaje_retroventa),
			'cantidad_aplazos_contrato' => trim($request->cantidad_aplazos_contrato),
			'dias_gracia' => trim($request->dias_gracia)
		];

		if( GeneralBusinessLogic::validateUnique( $dataSaved, $id ) ) {
			$msm=GeneralBusinessLogic::update($id,$dataSaved);
			if($msm['val']=='Actualizado'){
				Session::flash('message', $msm['msm']);
			return redirect('/configcontrato/general');
			}
			elseif($msm['val']=='Error'){
				Session::flash('error', $msm['msm']);
			}
			elseif($msm['val']=='ErrorUnico'){
				Session::flash('warning', $msm['msm']);
			}
		} else {
			Session::flash('warning', 'Ya existe una configuración general con una vigencia similar');
		}

		return redirect()->back();
	}

    public function inactive(request $request){
		$msm=GeneralBusinessLogic::inactive($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=GeneralBusinessLogic::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function delete(request $request){
		$msm=GeneralBusinessLogic::delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

}
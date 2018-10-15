<?php

namespace App\Http\Controllers\Nutibara\ConfigContrato;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use dateFormate;

use App\BusinessLogic\Nutibara\ConfigContrato\DiaGraciaBusinessLogic;

class DiaGraciaController extends Controller
{

    public function index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/diagracia',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/diagracia',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/diagracia',
				'text'=>'Configuración de Días de Gracia'
			]
		);
		return view('ConfigContrato.DiaGracia.index',['urls'=>$urls]);
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
		$search["tienda"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
		$total=DiaGraciaBusinessLogic::getCountDiaGracia($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(DiaGraciaBusinessLogic::DiaGracia($start,$end,$colum, $order,$search)->toArray())
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
				'href'=>'configcontrato/diagracia',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/diagracia',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/diagracia',
				'text'=>'Configuración de Días de Gracia'
			],
			[
				'href' => 'configcontrato/diagracia/create',
				'text' => 'Nueva Configuración Días de Gracia de Contrato'
			],
		);
		return view('ConfigContrato.DiaGracia.create',['urls'=>$urls]);
    }

	public function store(request $request)
	{

		if($request->tienda === "" || $request->tienda === "- Seleccione una opción -")
		{
			$tienda = null;
		}
		else
		{
			$tienda = $request->tienda;
		}
		$dataSaved=[
			'id_pais' => trim($request->pais),
			'id_departamento' => (trim($request->departamento) == null)?0:trim($request->departamento),
			'id_ciudad' => (trim($request->ciudad) == null)?0:trim($request->ciudad),
			'id_tienda' => (trim($request->tienda) == null)?0:trim($request->tienda),
			'dias_gracia' => trim($request->dias),
			'estado' => 1
		];
		$msm=DiaGraciaBusinessLogic::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/configcontrato/diagracia');		
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
    }

    public function edit($id){
		$data=dateFormate::ToArrayInverse(DiaGraciaBusinessLogic::getDiaGraciaById($id)->toArray());
		$diagracia=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/diagracia',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/diagracia',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/diagracia',
				'text'=>'Configuraciones Días de Gracia de Contrato'
			],
			[
				'href' => 'configcontrato/diagracia/edit/'.$id,
				'text' => 'Editar configuración Día de Gracia de contrato'
			],
		);
		return view('ConfigContrato.DiaGracia.edit',['diagracia' => $diagracia,'urls'=>$urls]);
	}

    public function update(request $request){
		$id = (int)$request->id;
		if($request->tienda === "" || $request->tienda === "- Seleccione una opción -")
		{
			$tienda = null;
		}
		else
		{
			$tienda = $request->tienda;
		}

		$dataSaved=[
			'id_pais' => trim($request->pais),
			'id_departamento' => (trim($request->departamento) == null)?0:trim($request->departamento),
			'id_ciudad' => (trim($request->ciudad) == null)?0:trim($request->ciudad),
			'id_tienda' => (trim($request->tienda) == null)?0:trim($request->tienda),
			'dias_gracia' => trim($request->dias)
		];
		$msm=DiaGraciaBusinessLogic::update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);		
			return redirect('/configcontrato/diagracia');
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
		$msm=DiaGraciaBusinessLogic::inactive($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=DiaGraciaBusinessLogic::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function delete(request $request){
		$msm=DiaGraciaBusinessLogic::delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

}
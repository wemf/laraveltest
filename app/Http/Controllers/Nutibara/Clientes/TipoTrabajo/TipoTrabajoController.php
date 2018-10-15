<?php

namespace App\Http\Controllers\Nutibara\Clientes\TipoTrabajo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\TipoTrabajo\CrudTipoTrabajo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use dateFormate;


class TipoTrabajoController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/tipo/trabajo',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/tipo/trabajo',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/tipo/trabajo',
				'text'=>'Tipos De Trabajo'
			]
		);
		return view('/Clientes/TipoTrabajo.index',['urls'=>$urls]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["nombre"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=CrudTipoTrabajo::getCountTipoTrabajo();
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudTipoTrabajo::TipoTrabajo($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getTipoTrabajo(Request $request){
		$msm = CrudTipoTrabajo::getTipoTrabajo();
		return response()->json($msm);
    }

    public function getTipoTrabajoValueById(request $request) 
	{
		$response = CrudTipoTrabajo::getTipoTrabajoValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/tipo/trabajo',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/tipo/trabajo',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/tipo/trabajo',
				'text'=>'Tipos de Trabajo'
			],
			[
				'href' => 'clientes/tipo/trabajo/create',
				'text' => 'Crear Tipo de Trabajo'
			],
		);
		return view('/Clientes/TipoTrabajo.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
			'estado' => 1
		];
		$msm=CrudTipoTrabajo::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/tipo/trabajo');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
			return redirect()->back();	
    }

    public function Delete(request $request){
		$msm=CrudTipoTrabajo::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudTipoTrabajo::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudTipoTrabajo::getTipoTrabajoById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/tipo/trabajo',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/tipo/trabajo',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/tipo/trabajo',
				'text'=>'Tipo De Trabajo'
			],
			[
				'href' => 'clientes/tipo/trabajo/update/'.$id,
				'text' => 'Actualizar Tipo Trabajo'
			],
		);
		return view('/Clientes/TipoTrabajo.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){	
		$this->validate($request, [
        	'nombre' => [
				'required',
				 'max:50'
				],
    	]);	
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
		];
		$msm=CrudTipoTrabajo::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
		return redirect('/clientes/tipo/trabajo');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
			return redirect()->back();
	}

	public function getSelectList()
	{
		$msm = CrudTipoTrabajo::getSelectList();
		return  response()->json($msm);
	}
}

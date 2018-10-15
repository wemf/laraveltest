<?php

namespace App\Http\Controllers\Nutibara\Clientes\AreaTrabajo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\AreaTrabajo\CrudAreaTrabajo;
use Illuminate\Support\Facades\Session;
use dateFormate;

class AreaTrabajoController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/clientes/areatrabajo',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'/clientes/areatrabajo',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'/clientes/areatrabajo',
				'text'=>'Áreas de Trabajo'
			]
		);
		return view('/Clientes/AreaTrabajo.index',['urls'=>$urls]);
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
		$total=CrudAreaTrabajo::getCountAreaTrabajo($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudAreaTrabajo::AreaTrabajo($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getAreaTrabajo(Request $request){
		$msm = CrudAreaTrabajo::getAreaTrabajo();
		return response()->json($msm);
    }

    public function getAreaTrabajoValueById(request $request) 
	{
		$response = CrudAreaTrabajo::getAreaTrabajoValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/clientes/areatrabajo',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'/clientes/areatrabajo',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'/clientes/areatrabajo',
				'text'=>'Área de Trabajo'
			],
			[
				'href' => '/clientes/areatrabajo/create',
				'text' => 'Crear Áreas Trabajo'
			],
		);
		return view('/Clientes/AreaTrabajo.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
			'estado' => 1
		];
		$msm=CrudAreaTrabajo::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/areatrabajo');
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
		$msm=CrudAreaTrabajo::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudAreaTrabajo::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudAreaTrabajo::getAreaTrabajoById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/clientes/areatrabajo',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'/clientes/areatrabajo',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'/clientes/areatrabajo',
				'text'=>'Áreas de Trabajo'
			],
			[
				'href' => '/clientes/areatrabajo/update/'.$id,
				'text' => 'Actualizar Área Trabajo'
			],
		);
		return view('/Clientes/AreaTrabajo.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
		];
		$msm=CrudAreaTrabajo::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/areatrabajo');
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
		$msm = CrudAreaTrabajo::getSelectList();
		return  response()->json($msm);
	}
}

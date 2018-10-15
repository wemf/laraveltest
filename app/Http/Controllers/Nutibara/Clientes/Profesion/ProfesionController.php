<?php

namespace App\Http\Controllers\Nutibara\Clientes\Profesion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\Profesion\CrudProfesion;
use Illuminate\Support\Facades\Session;
use dateFormate;


class ProfesionController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/profesion',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/profesion',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/profesion',
				'text'=>'Profesiones'
			]
		);
		return view('/Clientes/Profesion.index',['urls'=>$urls]);
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
		$total=CrudProfesion::getCountProfesion($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudProfesion::Profesion($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getProfesion(Request $request){
		$msm = CrudProfesion::getProfesion();
		return response()->json($msm);
    }

    public function getProfesionValueById(request $request) 
	{
		$response = CrudProfesion::getProfesionValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/profesion',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/profesion',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/profesion',
				'text'=>'Profesiones'
			],
			[
				'href' => 'clientes/profesion/create',
				'text' => 'Crear Profesion'
			],
		);
		return view('/Clientes/Profesion.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
			'estado' => 1
		];
		$msm=CrudProfesion::Create($dataSaved);
		
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/profesion');
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
		$msm=CrudProfesion::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudProfesion::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudProfesion::getProfesionById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/profesion',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/profesion',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/profesion',
				'text'=>'Profesiones'
			],
			[
				'href' => 'clientes/profesion/update/'.$data->id,
				'text' => 'Actualizar Profesion'
			],
		);
		return view('/Clientes/Profesion.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
		];
		$msm=CrudProfesion::Update($id,$dataSaved);

		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/profesion');
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
		$msm = CrudProfesion::getSelectList();
		return  response()->json($msm);
	}
}

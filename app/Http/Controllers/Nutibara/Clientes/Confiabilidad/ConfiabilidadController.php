<?php

namespace App\Http\Controllers\Nutibara\Clientes\Confiabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\Confiabilidad\CrudConfiabilidad;
use Illuminate\Support\Facades\Session;
use dateFormate;
use Illuminate\Validation\Rule;


class ConfiabilidadController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/confiabilidad',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/confiabilidad',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/confiabilidad',
				'text'=>'Confiabilidades'
			]
		);
		return view('/Clientes/Confiabilidad.index',['urls'=>$urls]);
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
		$total=CrudConfiabilidad::getCountConfiabilidad($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudConfiabilidad::Confiabilidad($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getConfiabilidad(Request $request){
		$msm = CrudConfiabilidad::getConfiabilidad();
		return response()->json($msm);
    }

    public function getConfiabilidadValueById(request $request) 
	{
		$response = CrudConfiabilidad::getConfiabilidadValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/confiabilidad',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/confiabilidad',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/confiabilidad',
				'text'=>'Confiabilidad'
			],
			[
				'href' => 'clientes/confiabilidad/create',
				'text' => 'Crear Confiabilidad'
			],
		);
		return view('/Clientes/Confiabilidad.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required|unique:tbl_clie_confiabilidad',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
			'permitir_contrato' => ($request->permitir_contrato != null) ? $request->permitir_contrato : 0,
			'estado' => 1
		];
		$msm=CrudConfiabilidad::Create($dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/clientes/confiabilidad');
    }

    public function Delete(request $request){
		$msm=CrudConfiabilidad::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudConfiabilidad::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudConfiabilidad::getConfiabilidadById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/confiabilidad',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/confiabilidad',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/confiabilidad',
				'text'=>'Confiabilidad'
			],
			[
				'href' => 'clientes/confiabilidad/update/'.$data->id,
				'text' => 'Actualizar Confiabilidad'
			],
		);
		return view('/Clientes/Confiabilidad.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'nombre' => [
				'required',
				Rule::unique('tbl_clie_confiabilidad')->ignore($id)
			]
		]);
		
		$dataSaved=[
			'nombre' => $request->nombre,
			'permitir_contrato' => ($request->permitir_contrato != null) ? $request->permitir_contrato : 0,
		];
		$msm=CrudConfiabilidad::Update($id,$dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/clientes/confiabilidad');
	}

	public function getSelectList()
	{
		$msm = CrudConfiabilidad::getSelectList();
		return  response()->json($msm);
	}
}

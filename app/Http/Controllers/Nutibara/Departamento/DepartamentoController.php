<?php

namespace App\Http\Controllers\Nutibara\Departamento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Departamento\CrudDepartamento;
use Illuminate\Support\Facades\Session;
use dateFormate;


class DepartamentoController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'departamento',
				'text'=>'Administración General'
			],
			[
				'href'=>'departamento',
				'text'=>' Maestro de Locaciones'
			],
			[
				'href'=>'departamento',
				'text'=>'Departamentos'
			]
		);
		return view('Departamento.index',['urls'=>$urls]);
    }

    public function get(Request $request){
		$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["pais"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["departamento"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=CrudDepartamento::getCountDepartamento($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudDepartamento::Departamento($start,$end,$colum, $order,$search)->toArray())
		];
		return response()->json($data);
    }

    public function getDepartamentoByPais(Request $request){
		$id = $request->id;
		$data = CrudDepartamento::getDepartamentoByPais($id);
		return response()->json($data);
    }

    public function getDepartamentoValueById(request $request) 
	{
		$response = CrudDepartamento::getDepartamentoValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'departamento',
				'text'=>'Administración General'
			],
			[
				'href'=>'departamento',
				'text'=>' Maestro de Locaciones'
			],
			[
				'href'=>'departamento',
				'text'=>'Departamentos'
			],
			[
				'href' => 'departamento/create',
				'text' => 'Crear Departamento'
			]
		);
		return view('Departamento.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
			'id_pais' => 'required',
			'codigo_dane' => 'required',
			'indicativo_departamento' => 'required',			
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'codigo_dane' => $request->codigo_dane,
			'indicativo_departamento' => $request->indicativo_departamento,			
			'id_pais' => (int)$request->id_pais,
			'estado' => 1,
		];
		$msm=CrudDepartamento::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/departamento');
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
		$msm=CrudDepartamento::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudDepartamento::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudDepartamento::getDepartamentoById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'departamento',
				'text'=>'Administración General'
			],
			[
				'href'=>'departamento',
				'text'=>' Maestro de Locaciones'
			],
			[
				'href'=>'departamento',
				'text'=>'Departamentos'
			],
			[
				'href' => 'departamento/update/'.$data->id,
				'text' => 'Actualizar Departamento'
			]
		);
		return view('Departamento.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
			'id_pais' => 'required',
			'codigo_dane' => 'required',
			'indicativo_departamento' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'codigo_dane' => $request->codigo_dane,
			'indicativo_departamento' => $request->indicativo_departamento,
			'id_pais' => (int)$request->id_pais,
		];
		$msm=CrudDepartamento::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/departamento');
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
		$msm = CrudDepartamento::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListDepartamento(request $request)
	{
		$msm = CrudDepartamento::getSelectListDepartamento($request->id);
		return  response()->json($msm);
	}	

}

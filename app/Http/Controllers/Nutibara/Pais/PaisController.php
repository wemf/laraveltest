<?php

namespace App\Http\Controllers\Nutibara\Pais;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Pais\CrudPais;
use Illuminate\Support\Facades\Session;
use dateFormate;
use Illuminate\Validation\Rule;

class PaisController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'pais',
				'text'=>'Administración General'
			],
			[
				'href'=>'pais',
				'text'=>' Maestro de Locaciones '
			],
			[
				'href'=>'pais',
				'text'=>'Paises'
			]
		);
		return view('Pais.index',['urls'=>$urls]);
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
		$search["estado"] = str_replace($vowels, "", ($request->columns[1]['search']['value'] != null) ? $request->columns[1]['search']['value'] : 1);
		$total=CrudPais::getCountPais($start,$end,$colum, $order,$search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudPais::Pais($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getPais(Request $request){
		$msm = CrudPais::getPais();
		return response()->json($msm);
    }

    public function getPaisValueById(request $request) 
	{
		$response = CrudPais::getPaisValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'pais',
				'text'=>'Administración General'
			],
			[
				'href'=>'pais',
				'text'=>' Maestro de Locaciones'
			],
			[
				'href'=>'pais',
				'text'=>'Paises'
			],
			[
				'href' => 'pais/create',
				'text' => 'Crear País'
			],
		);
		return view('Pais.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'codigo_telefono' => 'unique:tbl_pais',
			'abreviatura' => 'required|unique:tbl_pais',
			'nombre' => 'required|unique:tbl_pais',
			
		]);
		
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'abreviatura' => trim($request->abreviatura),
			'codigo_telefono' => $request->codigo_telefono,
			'estado' => 1,
		];
		$msm=CrudPais::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/pais');
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
		$msm=CrudPais::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudPais::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudPais::getPaisById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'pais',
				'text'=>'Administración General'
			],
			[
				'href'=>'pais',
				'text'=>' Maestro de Locaciones'
			],
			[
				'href'=>'pais',
				'text'=>'Paises'
			],
			[
				'href' => 'pais/update/'.$data->id,
				'text' => 'Actualizar País'
			],
		);
		return view('Pais.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;

		$this->validate($request, [
			'nombre' => [
				'required',	
				Rule::unique('tbl_pais')->ignore($id),
			],
			'abreviatura' => [
				'required',	
				Rule::unique('tbl_pais')->ignore($id),
			],
			'codigo_telefono' => [
				Rule::unique('tbl_pais')->ignore($id),
			]
		]);

		$dataSaved=[
			'nombre' => trim($request->nombre),
			'abreviatura' => trim($request->abreviatura),
			'codigo_telefono' => $request->codigo_telefono
		];
		$msm=CrudPais::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/pais');
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
		$msm = CrudPais::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListPaisSociedad(request $request)
	{
		$msm = CrudPais::getSelectListPaisSociedad($request->id);
		return  response()->json($msm);
	}

	public function getSelectListPais(request $request)
	{
		$msm = CrudPais::getSelectListPais($request->id);
		return  response()->json($msm);
	}

	public function getSelectListPaisByName(request $request)
	{
		$msm = CrudPais::getSelectListPaisByName($request->id);
		return  response()->json($msm);
	}

	public function getInputIndicativo(request $request)
	{
		$msm = CrudPais::getInputIndicativo($request->id);
		return  response()->json($msm);
	}
}

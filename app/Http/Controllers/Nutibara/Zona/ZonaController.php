<?php

namespace App\Http\Controllers\Nutibara\Zona;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Zona\CrudZona;
use Illuminate\Support\Facades\Session;
use dateFormate;


class ZonaController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'zona',
				'text'=>'Administración General'
			],
			[
				'href'=>'zona',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'zona',
				'text'=>'Zonas'
			]
		);
		return view('Zona.index',['urls'=>$urls]);
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
		$search["zona"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=CrudZona::getCountZona($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudZona::Zona($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getZonaByPais(Request $request){
		$id = $request->id;
		$msm = CrudZona::getZonaByPais($id);
		return response()->json($msm);
    }

    public function getZonaValueById(request $request) 
	{
		$response = CrudZona::getZonaValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'zona',
				'text'=>'Administración General'
			],
			[
				'href'=>'zona',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'zona',
				'text'=>'Zonas'
			],
			[
				'href' => 'zona/create',
				'text' => 'Crear Zona'
			],
		);
		
		return view('Zona.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
			'id_pais' => 'required'
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'id_pais' => (int)$request->id_pais,
			'estado' => 1
		];
		$msm=CrudZona::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/zona');
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
		$msm=CrudZona::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudZona::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudZona::getZonaById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'zona',
				'text'=>'Administración General'
			],
			[
				'href'=>'zona',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'zona',
				'text'=>'Zonas'
			],
			[
				'href' => 'zona/update/'.$data->id,
				'text' => 'Actualizar Zona'
			],
		);
		return view('Zona.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id_zona = (int)$request->id;
		$this->validate($request, [
			'nombre' => 'required',
			'id_pais' => 'required'
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'id_pais' => (int)$request->id_pais
		];
		$msm=CrudZona::Update($id_zona,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/zona');
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
		$msm = CrudZona::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListZonaPais(request $request)
	{
		$msm = CrudZona::getSelectListZonaPais($request->id);
		return  response()->json($msm);
	}

	public function getSelectListZonaTienda(request $request)
	{
		$msm = CrudZona::getSelectListZonaTienda($request->id);
		return  response()->json($msm);
	}

}

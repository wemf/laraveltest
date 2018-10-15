<?php

namespace App\Http\Controllers\Nutibara\AsociarCliente\AsociarTienda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\AsociarCliente\AsociarTienda\CrudAsociarTienda;
use Illuminate\Support\Facades\Session;
use dateFormate;


class AsociarTiendaController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'asociarclientes/asociartienda',
				'text'=>'Gestión Humana'
			],
			[
				'href'=>'asociarclientes/asociartienda',
				'text'=>'Asociaciones a Tiendas'
			]
		);
    	return view('/AsociarCliente/AsociarTienda.index',['urls'=>$urls]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];

		
		$vowels = array("$", "^");
		$search["tipodocliente"] = str_replace($vowels, "", $request->columns[5]['search']['value']);
		$search["tipodocumento"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["documento"] = str_replace($vowels, "", $request->columns[6]['search']['value']);
		$search["nombre"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["primerapellido"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$search["segundoapellido"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
		$search["estado"] = (str_replace($vowels, "", $request->columns[1]['search']['value']) == null)?'1':str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=CrudAsociarTienda::getCountAsociarTienda($start,$end,$colum, $order,$search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudAsociarTienda::AsociarTienda($start,$end,$colum, $order,$search)->toArray())
		];
		return response()->json($data);
    }

    public function getAsociarTienda(Request $request){
		$msm = CrudAsociarTienda::getAsociarTienda();
		return response()->json($msm);
    }

    public function getAsociarTiendaValueById(request $request) 
	{
		$response = CrudAsociarTienda::getAsociarTiendaValueById($request->id);
		return response()->json($response);
	}

    public function Create($id,$id_tienda){
		$data = CrudAsociarTienda::getAsociarTiendaById($id,$id_tienda);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'asociarclientes/asociartienda',
				'text'=>'Gestión Humana'
			],
			[
				'href'=>'asociarclientes/asociartienda',
				'text'=>'Asociaciones a Tiendas'
			],
			[
				'href'=>'asociarclientes/asociartienda/create/'.$id.'/'.$id_tienda,
				'text'=>'Asociación a Tienda'
			]
		);
    	return view('/AsociarCliente/AsociarTienda.create', ['attribute' => $data,'urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	
		$dataSaved=[
			'id_tienda' => $request->idtienda,
			'codigo_cliente' => $request->id,
		];
		$msm=CrudAsociarTienda::CreateTiendas($dataSaved,$request->asociaciones);
		$a=array('msm'=>$msm);
		return response()->json($a);
    }

	public function TiendasSeleccionadas(request $request)
	{
		$objeto = CrudAsociarTienda::TiendasSeleccionadas($request->id,$request->idtienda);
		return response()->json($objeto);
	}

    public function Delete(request $request){
		$msm=CrudAsociarTienda::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudAsociarTienda::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudAsociarTienda::getAsociarTiendaById($id)->toArray());
		$data=(object)$data;
       	return view('/asociarclientes/asociartienda.update' , ['attribute' => $data]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
			'descripcion' => $request->descripcion,
		];
		$msm=CrudAsociarTienda::Update($id,$dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/asociarclientes/asociartienda');
	}

	public function getSelectList()
	{
		$msm = CrudAsociarTienda::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListTipoEmpleado()
	{
		$msm = CrudAsociarTienda::getSelectListTipoEmpleado();
		return  response()->json($msm);
	}

	public function getSelectListTipoCliente()
	{
		$msm = CrudAsociarTienda::getSelectListTipoCliente();
		return  response()->json($msm);
	}
}

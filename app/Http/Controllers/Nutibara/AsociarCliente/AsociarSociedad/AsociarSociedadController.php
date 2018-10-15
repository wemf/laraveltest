<?php

namespace App\Http\Controllers\Nutibara\AsociarCliente\AsociarSociedad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\AsociarCliente\AsociarSociedad\CrudAsociarSociedad;
use Illuminate\Support\Facades\Session;
use dateFormate;


class AsociarSociedadController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'asociarclientes/asociarsociedad',
				'text'=>'Gestión Humana'
			],
			[
				'href'=>'asociarclientes/asociarsociedad',
				'text'=>'Asociaciones a Sociedades'
			]
		);
    	return view('/AsociarCliente/AsociarSociedad.index',['urls'=>$urls]);
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
		$search["estado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=CrudAsociarSociedad::getCountAsociarSociedad($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudAsociarSociedad::AsociarSociedad($start,$end,$colum, $order,$search)->toArray())
		];
		return response()->json($data);
    }

    public function getAsociarSociedad(Request $request){
		$msm = CrudAsociarSociedad::getAsociarSociedad();
		return response()->json($msm);
    }

    public function getAsociarSociedadValueById(request $request) 
	{
		$response = CrudAsociarSociedad::getAsociarSociedadValueById($request->id);
		return response()->json($response);
	}

    public function Create($id,$id_tienda){
		$data = CrudAsociarSociedad::getAsociarSociedadById($id,$id_tienda);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'asociarclientes/asociarsociedad',
				'text'=>'Gestión Humana'
			],
			[
				'href'=>'asociarclientes/asociarsociedad',
				'text'=>'Asociaciones a Sociedades'
			],
			[
				'href'=>'asociarclientes/asociarsociedad/create/'.$id.'/'.$id_tienda,
				'text'=>'Asociación a Sociedad'
			]
		);
    	return view('/AsociarCliente/AsociarSociedad.create', ['attribute' => $data,'urls' => $urls]);
    }

    public function CreatePost(request $request){
    	
		$dataSaved=[
			'id_tienda' => $request->idtienda,
			'codigo_cliente' => $request->id,
		];
		$msm=CrudAsociarSociedad::CreateAsociacion($dataSaved,$request->asociaciones);
		$a=array('msm'=>$msm);
		return response()->json($a);
    }

	public function SociedadesSeleccionadas(request $request)
	{
		$objeto = CrudAsociarSociedad::SociedadesSeleccionadas($request->id,$request->idtienda);
		return response()->json($objeto);
	}

    public function Delete(request $request){
		$msm=CrudAsociarSociedad::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudAsociarSociedad::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudAsociarSociedad::getAsociarSociedadById($id)->toArray());
		$data=(object)$data;
       	return view('/asociarclientes/AsociarSociedad.update' , ['attribute' => $data]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required|unique:tbl_clie_area_trabajo',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
			'descripcion' => $request->descripcion,
		];
		$msm=CrudAsociarSociedad::Update($id,$dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/asociarclientes/AsociarSociedad');
	}

	public function getSelectList()
	{
		$msm = CrudAsociarSociedad::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListTipoEmpleado()
	{
		$msm = CrudAsociarSociedad::getSelectListTipoEmpleado();
		return  response()->json($msm);
	}

	public function getSelectListTipoCliente()
	{
		$msm = CrudAsociarSociedad::getSelectListTipoCliente();
		return  response()->json($msm);
	}
}

<?php

namespace App\Http\Controllers\Nutibara\Ciudad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Ciudad\CrudCiudad;
use Illuminate\Support\Facades\Session;
use tienda;
use dateFormate;


class CiudadController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'ciudad',
				'text'=>'Administración General'
			],
			[
				'href'=>'ciudad',
				'text'=>' Maestro de Locaciones'
			],
			[
				'href'=>'ciudad',
				'text'=>'Ciudades'
			]
		);
		return view('Ciudad.index',['urls'=>$urls]);
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
		$search["ciudad"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["codigo_dane"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$estado = str_replace($vowels, "", $request->columns[4]['search']['value']);
		$search["estado"] = ($estado == null || $estado == "")?1:$estado;
		$total=CrudCiudad::getCountCiudad($search);

		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudCiudad::Ciudad($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getCiudadByDepartamento(Request $request){
		$id = $request->id;
		$data = CrudCiudad::getCiudadByDepartamento($id);
		return response()->json($data);
	}
	
	public function getCiudadByPais(Request $request){
		$id = $request->id;
		$data = CrudCiudad::getCiudadByPais($id);
		return response()->json($data);
    }

    public function getCiudadValueById(request $request) 
	{
		$response = CrudCiudad::getCiudadValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'ciudad',
				'text'=>'Administración General'
			],
			[
				'href'=>'ciudad',
				'text'=>' Maestro de Locaciones'
			],
			[
				'href'=>'ciudad',
				'text'=>'Ciudades'
			],
			[
				'href' => 'ciudad/create',
				'text' => 'Crear Ciudad'
			],
		);
		return view('Ciudad.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
			'id_departamento' => 'required',
			'codigo_dane' => 'required',
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'id_departamento' => (int)$request->id_departamento,
			'codigo_dane' => $request->codigo_dane,
			'estado' => 1
		];
		$msm=CrudCiudad::Create($dataSaved);

		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/ciudad');
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
		$msm=CrudCiudad::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudCiudad::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudCiudad::getCiudadById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'ciudad',
				'text'=>'Administración General'
			],
			[
				'href'=>'ciudad',
				'text'=>' Maestro de Locaciones'
			],
			[
				'href'=>'ciudad',
				'text'=>'Ciudades'
			],
			[
				'href' => 'ciudad/update/'.$data->id,
				'text' => 'Actualizar Ciudad'
			],
		);
		return view('Ciudad.update',['urls'=>$urls,'attribute' => $data]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'nombre' => 'required',
			'id_departamento' => 'required',
			'codigo_dane' => 'required',
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'id_departamento' => (int)$request->id_departamento,
			'codigo_dane' => $request->codigo_dane,
		];
		$msm=CrudCiudad::Update($id,$dataSaved);

		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/ciudad');
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
		$msm = CrudCiudad::getSelectList();
		return  response()->json($msm);
	}
	
	public function getSelectListCiudadZona(request $request)
	{
		$msm = CrudCiudad::getSelectListCiudadZona($request->id);
		return  response()->json($msm);
	}

	public function getSelectListCiudadSociedad(request $request)
	{
		$msm = CrudCiudad::getSelectListCiudadSociedad($request->id);
		return  response()->json($msm);
	}

	public function getItemZonaCiudad(request $request)
	{
		$msm = CrudCiudad::getItemZonaCiudad($request->id);
		return  response()->json($msm);
	}

	public function getInputIndicativo(request $request)
	{
		$msm = CrudCiudad::getInputIndicativo($request->id);
		return  response()->json($msm);
	}

	public function getInputIndicativo2(request $request)
	{
		$msm = CrudCiudad::getInputIndicativo2($request->id);
		return response()->json($msm);
	}
	
	public function getSelectListCiudadbyNombre($nombre){
		$id_pais=tienda::Configuracion()->id_pais;
		$ciudades = CrudCiudad::getSelectListCiudadbyNombre($id_pais,$nombre);
		return response()->json($ciudades);
	}

}

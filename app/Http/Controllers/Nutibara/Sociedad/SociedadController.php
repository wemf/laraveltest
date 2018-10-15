<?php

namespace App\Http\Controllers\Nutibara\Sociedad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Sociedad\CrudSociedad;
use Illuminate\Support\Facades\Session;
use dateFormate;


class SociedadController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'sociedad',
				'text'=>'Administración General'
			],
			[
				'href'=>'sociedad',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'sociedad',
				'text'=>'Sociedades'
			]
		);
		return view('Sociedad.index',['urls'=>$urls]);
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
		$search["sociedad"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=CrudSociedad::getCountSociedad($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudSociedad::Sociedad($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getSociedad(Request $request){
		$msm = CrudSociedad::getSociedad();
		return response()->json($msm);
    }

    public function getSociedadValueById(request $request) 
	{
		$response = CrudSociedad::getSociedadValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'sociedad',
				'text'=>'Administración General'
			],
			[
				'href'=>'sociedad',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'sociedad',
				'text'=>'Sociedades'
			],
			[
				'href' => 'sociedad/create',
				'text' => 'Crear Sociedad'
			],
		);
		return view('Sociedad.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
			'nit' => 'required',
			'id_regimen' => 'required',
			'digito_verificacion' => 'required',
			'id_pais' => 'required',
			'codigo_sociedad' => 'required',
			'direccion' => 'required'
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'nit' => trim($request->nit),
			'id_regimen' => (int)$request->id_regimen,
			'id_pais' => (int)$request->id_pais,
			'digito_verificacion' => (int)$request->digito_verificacion,
			'codigo_sociedad' => (int)$request->codigo_sociedad,
			'direccion' => trim($request->direccion),
			'estado' => 1,
		];
		$msm=CrudSociedad::Create($dataSaved);

		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/sociedad');
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
		$msm=CrudSociedad::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudSociedad::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudSociedad::getSociedadById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'sociedad',
				'text'=>'Administración General'
			],
			[
				'href'=>'sociedad',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'sociedad',
				'text'=>'Sociedades'
			],
			[
				'href' => 'sociedad/update/'.$data->id,
				'text' => 'Actualizar Sociedad'
			],
		);
		return view('Sociedad.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'nombre' => 'required',
			'nit' => 'required',
			'id_regimen' => 'required',
			'id_pais' => 'required',
			'digito_verificacion' => 'required',
			'codigo_sociedad' => 'required',
			'direccion' => 'required',
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'nit' => trim($request->nit),
			'id_regimen' => (int)$request->id_regimen,
			'id_pais' => (int)$request->id_pais,
			'digito_verificacion' => (int)$request->digito_verificacion,
			'codigo_sociedad' => (int)$request->codigo_sociedad,
			'direccion' => trim($request->direccion),
		];
		$msm=CrudSociedad::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/sociedad');
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
		$msm = CrudSociedad::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListRegimen()
	{
		$msm = CrudSociedad::getSelectListRegimen();
		return  response()->json($msm);
	}

	public function getSelectListSociedadesPais(request $request)
	{
		$msm = CrudSociedad::getSelectListSociedadesPais($request->id);
		return  response()->json($msm);
	}

}

<?php

namespace App\Http\Controllers\Nutibara\Parametros;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Parametros\CrudParametros;
use Illuminate\Support\Facades\Session;
use dateFormate;


class ParametrosController extends Controller
{
 
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'parametros',
				'text'=>'Administración General'
			],
			[
				'href'=>'parametros',
				'text'=>'Parametros Generales'
			]
		);
		$existeParametro = CrudParametros::getCountParametros();		
    	return view('Parametros.index',['urls'=>$urls,'existeParametro' => $existeParametro]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=$start+(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["nombre"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=CrudParametros::getCountParametros();
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudParametros::Parametros($start,$end,$colum, $order,$search)->toArray())
		];
		return response()->json($data);
    }

    public function getParametros(Request $request){
		$msm = CrudParametros::getParametros();
		return response()->json($msm);
    }

    public function getParametrosValueById(request $request) 
	{
		$response = CrudParametros::getParametrosValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
    	return view('Parametros.create');
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'id_pais' => 'required',
			'id_lenguaje' => 'required',
			'id_moneda' => 'required',
			'redondeo' => 'required',
			'decimales' => 'required'			
        ]);
		$dataSaved=[
			'id_pais' => trim($request->id_pais),
			'id_lenguaje' => (int)$request->id_lenguaje,
			'id_moneda' => $request->id_moneda,
			'estado' => 1,
			'redondeo' => $request->redondeo,
			'decimales' => $request->decimales			
		];
		$msm=CrudParametros::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/parametros');
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
		$msm=CrudParametros::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudParametros::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudParametros::getParametrosById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'parametros',
				'text'=>'Administración General'
			],
			[
				'href'=>'parametros',
				'text'=>'Parametros Generales'
			],
			[
				'href' =>'parametros/update/'.$data->id,
				'text' => 'Actualizar Parametros '
			],
		);
    	return view('Parametros.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'id_pais' => 'required',
			'id_lenguaje' => 'required',
			'id_moneda' => 'required',
			'redondeo' => 'required',
			'decimales' => 'required'
        ]);
		$dataSaved=[
			'id_pais' => trim($request->id_pais),
			'id_lenguaje' => $request->id_lenguaje,
			'id_moneda' => $request->id_moneda,
			'redondeo' => $request->redondeo,
			'decimales' => $request->decimales,
			'precio_bolsa' => (int)$request->precio_bolsa,
			'retecree' => (int)$request->retecree,
		];
		$msm=CrudParametros::Update($id,$dataSaved);
		
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/parametros');
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
		$msm = CrudParametros::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListLenguaje()
	{
		$msm = CrudParametros::getSelectListLenguaje();
		return  response()->json($msm);
	}

	public function getSelectListMoneda()
	{
		$msm = CrudParametros::getSelectListMoneda();
		return  response()->json($msm);
	}

	public function getSelectListMedidaPeso()
	{
		$msm = CrudParametros::getSelectListMedidaPeso();
		return  response()->json($msm);
	}

	public function getSelectPais()
	{
		$msm = CrudParametros::getSelectPais();
		return  response()->json($msm);
	}

	public function ValidateExist(request $request)
	{
		$msm = CrudParametros::ValidateExist($request);
		return  response()->json($msm);
	}

	public function getAbreviatura(request $request)
	{
		return response()->json(CrudParametros::getAbreviatura($request->id));
	}

}

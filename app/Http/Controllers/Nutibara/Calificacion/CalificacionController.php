<?php

namespace App\Http\Controllers\Nutibara\Calificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Calificacion\CrudCalificacion;
use Illuminate\Support\Facades\Session;
use dateFormate;


class CalificacionController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'calificacion',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'calificacion',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'calificacion',
				'text'=>'Calificaciones'
			]
		);
		return view('Calificacion.index',['urls'=>$urls]);
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
		$total=CrudCalificacion::getCountCalificacion($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudCalificacion::Calificacion($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getCalificacion(Request $request){
		$msm = CrudCalificacion::getCalificacion();
		return response()->json($msm);
    }

    public function getCalificacionValueById(request $request) 
	{
		$response = CrudCalificacion::getCalificacionValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'calificacion',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'calificacion',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'calificacion',
				'text'=>'Calificaciones'
			],
			[
				'href' => 'calificacion/create',
				'text' => 'Crear Calificación'
			],
		);
		return view('Calificacion.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
			'valor_min' => 'required',
			'valor_max' => 'required',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
			'valor_min' => self::limpiarVal($request->valor_min),
			'valor_max' => self::limpiarVal($request->valor_max),
			'estado' => 1
		];

		$msm=CrudCalificacion::Create($dataSaved);

		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/calificacion');
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
		$msm=CrudCalificacion::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudCalificacion::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudCalificacion::getCalificacionById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'calificacion',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'calificacion',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'calificacion',
				'text'=>'Calificaciones'
			],
			[
				'href' => 'calificacion/update/'.$data->id,
				'text' => 'Actualizar Calificación'
			],
		);
		return view('Calificacion.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
			'valor_min' => 'required',
			'valor_max' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
			'valor_min' => self::limpiarVal($request->valor_min),
			'valor_max' => self::limpiarVal($request->valor_max),
		];
		$msm=CrudCalificacion::Update($id,$dataSaved);

		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/calificacion');
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
		$msm = CrudCalificacion::getSelectList();
		return  response()->json($msm);
	}

	public function limpiarVal($val)
	{
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}
}

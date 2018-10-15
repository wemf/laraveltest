<?php

namespace App\Http\Controllers\Nutibara\Clientes\CargoEmpleado;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\CargoEmpleado\CrudCargoEmpleado;
use Illuminate\Support\Facades\Session;
use dateFormate;


class CargoEmpleadoController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/cargoempleado',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/cargoempleado',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/cargoempleado',
				'text'=>'Cargos De Empleado'
			]
		);
		return view('/Clientes/CargoEmpleado.index',['urls'=>$urls]);
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
		$total=CrudCargoEmpleado::getCountCargoEmpleado($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudCargoEmpleado::CargoEmpleado($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getCargoEmpleado(Request $request){
		$msm = CrudCargoEmpleado::getCargoEmpleado();
		return response()->json($msm);
    }

    public function getCargoEmpleadoValueById(request $request) 
	{
		$response = CrudCargoEmpleado::getCargoEmpleadoValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/cargoempleado',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/cargoempleado',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/cargoempleado',
				'text'=>'Cargos De Empleado'
			],
			[
				'href' => 'clientes/cargoempleado/create',
				'text' => 'Crear Cargo De Empleado'
			],
		);
		return view('/Clientes/CargoEmpleado.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
			'estado' => 1
		];
		$msm=CrudCargoEmpleado::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/cargoempleado');
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
		$msm=CrudCargoEmpleado::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudCargoEmpleado::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudCargoEmpleado::getCargoEmpleadoById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/cargoempleado',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/cargoempleado',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/cargoempleado',
				'text'=>'Cargos De Empleado'
			],
			[
				'href' => 'clientes/cargoempleado/update/'.$data->id,
				'text' => 'Actualizar Cargo De Empleado '
			],
		);
		return view('/Clientes/CargoEmpleado.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
		];
		$msm=CrudCargoEmpleado::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
		return redirect('/clientes/cargoempleado');
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
		$msm = CrudCargoEmpleado::getSelectList();
		return  response()->json($msm);
	}
}

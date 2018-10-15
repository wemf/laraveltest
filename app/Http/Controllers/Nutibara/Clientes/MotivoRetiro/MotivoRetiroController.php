<?php

namespace App\Http\Controllers\Nutibara\Clientes\MotivoRetiro;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\MotivoRetiro\CrudMotivoRetiro;
use Illuminate\Support\Facades\Session;
use dateFormate;


class MotivoRetiroController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/motivoretiro',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/motivoretiro',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/motivoretiro',
				'text'=>'Motivos De Retiro'
			]
		);
		return view('/Clientes/MotivoRetiro.index',['urls'=>$urls]);
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
		$total=CrudMotivoRetiro::getCountMotivoRetiro($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudMotivoRetiro::MotivoRetiro($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getMotivoRetiro(Request $request){
		$msm = CrudMotivoRetiro::getMotivoRetiro();
		return response()->json($msm);
    }

    public function getMotivoRetiroValueById(request $request) 
	{
		$response = CrudMotivoRetiro::getMotivoRetiroValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/motivoretiro',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/motivoretiro',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/motivoretiro',
				'text'=>'Motivos De Retiro'
			],
			[
				'href' => 'clientes/motivoretiro/create',
				'text' => 'Crear Motivo De Retiro'
			],
		);
		return view('/Clientes/MotivoRetiro.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
			'estado' => 1
		];
		$msm=CrudMotivoRetiro::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/motivoretiro');
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
		$msm=CrudMotivoRetiro::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudMotivoRetiro::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudMotivoRetiro::getMotivoRetiroById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/motivoretiro',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/motivoretiro',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/motivoretiro',
				'text'=>'Motivos De Retiro'
			],
			[
				'href' => 'clientes/motivoretiro/update/'.$data->id,
				'text' => 'Actualizar Motivo De Retiro'
			],
		);
		return view('/Clientes/MotivoRetiro.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
		];
		$msm=CrudMotivoRetiro::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/motivoretiro');
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
		$msm = CrudMotivoRetiro::getSelectList();
		return  response()->json($msm);
	}
}

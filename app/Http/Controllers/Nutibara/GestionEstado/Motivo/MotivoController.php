<?php

namespace App\Http\Controllers\Nutibara\GestionEstado\Motivo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\GestionEstado\Motivo\CrudMotivo;
use Illuminate\Support\Facades\Session;
use dateFormate;


class MotivoController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/gestionestado/motivo',
				'text'=>'Administración General'
			],
			[
				'href'=>'/gestionestado/motivo',
				'text'=>'Maestro de Estados'
			],
			[
				'href'=>'/gestionestado/motivo',
				'text'=>'Motivos'
			]
		);
		return view('/GestionEstado/Motivo.index',['urls'=>$urls]);
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
		$total=CrudMotivo::getCountMotivo($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudMotivo::Motivo($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getMotivo(Request $request){
		$msm = CrudMotivo::getMotivo();
		return response()->json($msm);
    }

    public function getMotivoValueById(request $request) 
	{
		$response = CrudMotivo::getMotivoValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/gestionestado/motivo',
				'text'=>'Administración General'
			],
			[
				'href'=>'/gestionestado/motivo',
				'text'=>'Maestro de Estados'
			],
			[
				'href'=>'/gestionestado/motivo',
				'text'=>'Motivos'
			],
			[
				'href' => '/gestionestado/motivo/create',
				'text' => 'Crear Motivo'
			],
		);
		return view('/GestionEstado/Motivo.create',['urls'=>$urls]);
    }

	 public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'estado' => 1
		];
		$msm=CrudMotivo::Create($dataSaved);
		
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/gestionestado/motivo');
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
		$msm=CrudMotivo::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudMotivo::getMotivoById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/gestionestado/motivo',
				'text'=>'Administración General'
			],
			[
				'href'=>'/gestionestado/motivo',
				'text'=>'Maestro de Estados'
			],
			[
				'href'=>'/gestionestado/motivo',
				'text'=>'Motivos'
			],
			[
				'href' => '/gestionestado/motivo/update/'.$id,
				'text' => 'Actualizar Motivo'
			],
		);
		return view('/GestionEstado/Motivo.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function Active(request $request){
		$msm=CrudMotivo::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => trim($request->nombre),			
		];
		$msm=CrudMotivo::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/gestionestado/motivo');
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
		$msm = CrudMotivo::getSelectList();
		return  response()->json($msm);
	}

	public function getMotivoByEstado(request $request) 
	{
		$response = CrudMotivo::getMotivoByEstado($request->id);
		return response()->json($response);
	}
}

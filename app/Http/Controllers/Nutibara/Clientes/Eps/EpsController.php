<?php

namespace App\Http\Controllers\Nutibara\Clientes\Eps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\Eps\CrudEps;
use Illuminate\Support\Facades\Session;
use dateFormate;


class EpsController extends Controller
{
    public function Index(){ 
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/eps',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/eps',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/eps',
				'text'=>'Eps'
			]
		);
		return view('/Clientes/Eps.index',['urls'=>$urls]);
    }

    public function get(Request $request){
		return  CrudEps::get($request);
	}
	
	public function get_copy(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["name"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=CrudEps::getCountEps($search);
		//dd($total);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudEps::Eps($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getEps(Request $request){
		$msm = CrudEps::getEps();
		return response()->json($msm);
    }

    public function getEpsValueById(request $request) 
	{
		$response = CrudEps::getEpsValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/eps',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/eps',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/eps',
				'text'=>'Eps'
			],
			[
				'href' => 'clientes/eps/create',
				'text' => 'Crear Eps'
			],
		);
		return view('/Clientes/Eps.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required|unique:tbl_clie_eps'
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'estado' => 1,
		];
		$msm=CrudEps::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/eps');
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
		$msm=CrudEps::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudEps::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudEps::getEpsById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/eps',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/eps',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/eps',
				'text'=>'Eps'
			],
			[
				'href' => 'clientes/eps/update/'.$data->id,
				'text' => 'Actualizar Eps'
			],
		);
		return view('Clientes/Eps.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'nombre' => 'required'
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
		];
		$msm=CrudEps::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/eps');
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
		$msm = CrudEps::getSelectList();
		return  response()->json($msm);
	}

}

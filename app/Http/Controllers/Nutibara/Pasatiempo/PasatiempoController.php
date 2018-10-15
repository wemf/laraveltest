<?php

namespace App\Http\Controllers\Nutibara\Pasatiempo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Pasatiempo\CrudPasatiempo;
use Illuminate\Support\Facades\Session;
use dateFormate;


class PasatiempoController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'pasatiempo',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'pasatiempo',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'pasatiempo',
				'text'=>'Pasatiempos'
			]
		);
		return view('Pasatiempo.index',['urls'=>$urls]);
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
		$total=CrudPasatiempo::getCountPasatiempo($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudPasatiempo::Pasatiempo($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getPasatiempo(Request $request){
		$msm = CrudPasatiempo::getPasatiempo();
		return response()->json($msm);
    }

    public function getPasatiempoValueById(request $request) 
	{
		$response = CrudPasatiempo::getPasatiempoValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'pasatiempo',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'pasatiempo',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'pasatiempo',
				'text'=>'Pasatiempos'
			],
			[
				'href' => 'pasatiempo/create',
				'text' => 'Crear Pasatiempo'
			],
		);
		return view('Pasatiempo.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
            'estado' => 1,
		];
		$msm=CrudPasatiempo::Create($dataSaved);
	
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/pasatiempo');
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
		$msm=CrudPasatiempo::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudPasatiempo::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudPasatiempo::getPasatiempoById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'pasatiempo',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'pasatiempo',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'pasatiempo',
				'text'=>'Pasatiempos'
			],
			[
				'href' => 'pasatiempo/update/'.$data->id,
				'text' => 'Actualizar Pasatiempo'
			],
		);
		return view('Pasatiempo.update',['attribute' => $data,'urls'=>$urls]);
	}
	
	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'nombre' => 'required',
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
		];
		$msm=CrudPasatiempo::Update($id,$dataSaved);

		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/pasatiempo');
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
		$msm = CrudPasatiempo::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListPasatiempo(request $request)
	{
		$msm = CrudPasatiempo::getSelectListPasatiempo($request->id);
		return  response()->json($msm);
	}
}

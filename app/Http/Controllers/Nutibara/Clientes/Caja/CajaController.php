<?php

namespace App\Http\Controllers\Nutibara\Clientes\Caja;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\Caja\CrudCaja;
use Illuminate\Support\Facades\Session;
use dateFormate;


class CajaController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/caja',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/caja',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/caja',
				'text'=>'Cajas De Compensación'
			]
		);
		return view('/Clientes/Caja.index',['urls'=>$urls]);
    } 

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["name"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=CrudCaja::getCountCaja($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudCaja::Caja($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getCaja(Request $request){
		$msm = CrudCaja::getCaja();
		return response()->json($msm);
    }

    public function getCajaValueById(request $request) 
	{
		$response = CrudCaja::getCajaValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/caja',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/caja',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/caja',
				'text'=>'Cajas De Compensación'
			],
			[
				'href' => 'clientes/caja/create',
				'text' => 'Crear Caja De Compensación'
			],
		);
		return view('/Clientes/Caja.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required'
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'estado' => 1,
		];
		$msm=CrudCaja::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/caja');
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
		$msm=CrudCaja::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudCaja::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudCaja::getCajaById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/caja',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/caja',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/caja',
				'text'=>'Cajas De Compensación'
			],
			[
				'href' => 'clientes/caja/update/'.$data->id,
				'text' => 'Actualizar Caja de Compensación'
			],
		);
		return view('/Clientes/Caja.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'nombre' => 'required'
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
		];
		$msm=CrudCaja::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/caja');
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
		$msm = CrudCaja::getSelectList();
		return  response()->json($msm);
	}
}

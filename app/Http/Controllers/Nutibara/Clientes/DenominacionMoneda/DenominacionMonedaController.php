<?php

namespace App\Http\Controllers\Nutibara\Clientes\DenominacionMoneda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\DenominacionMoneda\CrudDenominacionMoneda;
use Illuminate\Support\Facades\Session;
use dateFormate;

class DenominacionMonedaController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/clientes/denominacionmoneda',
				'text'=>'Parametros Generales'
			], 
			[
				'href'=>'/clientes/denominacionmoneda',
				'text'=>'Configuración General'
			], 
			[
				'href'=>'/clientes/denominacionmoneda',
				'text'=>'Denominación de Monedas'
			]
		);
		return view('/Clientes/DenominacionMoneda.index',['urls'=>$urls]);
    }

    public function get(Request $request){
		// dd($request->columns);
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)2]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["pais"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["nombre"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=CrudDenominacionMoneda::getCountDenominacionMoneda($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudDenominacionMoneda::DenominacionMoneda($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getDenominacionMoneda(Request $request){
		$msm = CrudDenominacionMoneda::getDenominacionMoneda();
		return response()->json($msm);
    }

    public function getDenominacionMonedaValueById(request $request) 
	{
		$response = CrudDenominacionMoneda::getDenominacionMonedaValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/clientes/denominacionmoneda',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'/clientes/denominacionmoneda',
				'text'=>'Configuración General'
			],
			[
				'href'=>'/clientes/denominacionmoneda',
				'text'=>'Denominación de Monedas'
			],
			[
				'href' => '/clientes/denominacionmoneda/create',
				'text' => 'Crear Denominación de Moneda'
			],
		);
		return view('/Clientes/DenominacionMoneda.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
		$dataSaved=[
			'id_pais' => $request->id_pais,
			'denominacion' => $request->nombre,
			'valor' => self::limpiarVal($request->valor),
			'estado' => 1
		];
		$msm=CrudDenominacionMoneda::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/denominacionmoneda');
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
		$msm=CrudDenominacionMoneda::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudDenominacionMoneda::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudDenominacionMoneda::getDenominacionMonedaById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/clientes/denominacionmoneda',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'/clientes/denominacionmoneda',
				'text'=>'Configuración General'
			],
			[
				'href'=>'/clientes/denominacionmoneda',
				'text'=>'Denominación de Monedas'
			],
			[
				'href' => '/clientes/denominacionmoneda/update/'.$id,
				'text' => 'Actualizar Denominación de Moneda'
			],
		);
		return view('/Clientes/DenominacionMoneda.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'id_pais' => $request->id_pais,
			'denominacion' => $request->nombre,
			'valor' => self::limpiarVal($request->valor),
		];
		$msm=CrudDenominacionMoneda::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/denominacionmoneda');
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
		$msm = CrudDenominacionMoneda::getSelectList();
		return  response()->json($msm);
	}

	public static function limpiarVal($val)
	{
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}
}

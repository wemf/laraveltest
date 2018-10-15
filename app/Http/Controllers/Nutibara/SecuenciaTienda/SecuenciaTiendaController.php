<?php

namespace App\Http\Controllers\Nutibara\SecuenciaTienda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\SecuenciaTienda\CrudSecuenciaTienda;
use Illuminate\Support\Facades\Session;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda as SecuenciaTiendaAO;
use tienda;
use dateFormate;


class SecuenciaTiendaController extends Controller
{
    public function Index(){
		
		
		
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'secuenciatienda',
				'text'=>'Administración General'
			],
			[
				'href'=>'secuenciatienda',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'secuenciatienda',
				'text'=>'Secuencias por Tiendas'
			]
		);
		return view('Secuencia_Tienda.index',['urls'=>$urls]);
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
		$search["departamento"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["ciudad"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["zona"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$search["tienda"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
		
		$total=CrudSecuenciaTienda::getCountSecuenciaTienda($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudSecuenciaTienda::SecuenciaTienda($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getSecuenciaTienda(Request $request){
		$msm = CrudSecuenciaTienda::getSecuenciaTienda();
		return response()->json($msm);
    }

    public function getSecuenciaTiendaValueById(request $request) 
	{
		$response = CrudSecuenciaTienda::getSecuenciaTiendaValueById($request->id);
		return response()->json($response);
	}

    public function Create($id){
    	return view('Secuencia_Tienda.create',['id' => $id]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'codigo_cliente' => 'required',
			'codigo_contrato' => 'required',
			'codigo_plan' => 'required',
			'codigo_bolsa' => 'required',
			'codigo_inventario' => 'required',
			'id' => 'required',
        ]);
		$dataSaved=[
			'id_tienda' => (int)$request->id,
			'codigo_cliente' => (int)$request->codigo_cliente,
			'codigo_contrato' => (int)$request->codigo_contrato,
			'codigo_plan_separe' => (int)$request->codigo_plan,
			'codigo_bolsa_seguridad' => (int)$request->codigo_bolsa,
			'codigo_inventario' => (int)$request->codigo_inventario,
			'sede_principal' => (int)$request->sede_principal,
			'codigo_ingreso' => (int)$request->codigo_ingreso,
			'codigo_egreso' => (int)$request->codigo_egreso,
			'codigo_cuadre_caja' => (int)$request->codigo_cuadre_caja,
			'codigo_arqueo_caja' => (int)$request->codigo_arqueo_caja,
			'codigo_abono_ps' => (int)$request->codigo_abono_ps,
			'codigo_orden_compra' => (int)$request->codigo_orden_compra,
			'codigo_dev_venta' => (int)$request->codigo_dev_venta,
			'codigo_dev_compra' => (int)$request->codigo_dev_venta,
			'estado' => 1
		];
		$msm=CrudSecuenciaTienda::Create($dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/secuenciatienda');
    }

    public function Delete(request $request){
		$msm=CrudSecuenciaTienda::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudSecuenciaTienda::getSecuenciaTiendaById($id)->toArray());
		$data=(object)$data;
		$secuencias = CrudSecuenciaTienda::getTipoSecuenciaById($id);
		$secuencia_invalida = CrudSecuenciaTienda::getListSecInv(3,$id);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'secuenciatienda',
				'text'=>'Administración General'
			],
			[
				'href'=>'secuenciatienda',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'secuenciatienda',
				'text'=>'Secuencia por Tienda'
			],
			[
				'href' => 'secuenciatienda/update/'.$id,
				'text' => 'Actualizar Secuencia Tienda'
			],
		);
		return view('Secuencia_Tienda.update',[
												'attribute' => $data,
												'urls'=>$urls,
												'secuencias'=>$secuencias,
												'secuencia_invalida' => $secuencia_invalida,
												'id_tienda' => $id
											]);
	}

	public function UpdatePost(request $request){
		
		$id = (int)$request->id;
		$msm=CrudSecuenciaTienda::Update($id,$request);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/secuenciatienda');
	}

	public function getSelectList()
	{
		$msm = CrudSecuenciaTienda::getSelectList();
		return  response()->json($msm);
	}

	public function getListSecInv($id)
	{
		return CrudSecuenciaTienda::getListSecInv($id);
	}

	public function createSecInv(request $request)
	{
		$id = $request->id;
		$secuencia = $request->secuencia;
		$id_tienda = $request->id_tienda;
		$msm = CrudSecuenciaTienda::createSecInv($id,$secuencia,$id_tienda);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return response()->json($msm);
	}
}

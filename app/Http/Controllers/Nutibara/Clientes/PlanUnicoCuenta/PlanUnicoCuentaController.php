<?php

namespace App\Http\Controllers\Nutibara\Clientes\PlanUnicoCuenta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\PlanUnicoCuenta\CrudPlanUnicoCuenta;
use App\BusinessLogic\Nutibara\Excel\PlanUnicoCuenta\PlanUnicoCuentaExcel;
use Illuminate\Support\Facades\Session;
use dateFormate;


class PlanUnicoCuentaController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/planunicocuenta',
				'text'=>'Gestión de Contabilidad'
			],
			[
				'href'=>'clientes/planunicocuenta',
				'text'=>'Plan Unico De Cuenta'
			]
		);
		return view('/Clientes/PlanUnicoCuenta.index',['urls'=>$urls]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["cuenta"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["nombre"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["naturaleza"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=CrudPlanUnicoCuenta::getCountPlanUnicoCuenta($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>CrudPlanUnicoCuenta::PlanUnicoCuenta($start,$end,$colum, $order,$search)
		];   
		return response()->json($data);
    }

    public function getPlanUnicoCuenta(Request $request){
		$msm = CrudPlanUnicoCuenta::getPlanUnicoCuenta();
		return response()->json($msm);
    }

    public function getPlanUnicoCuentaValueById(request $request) 
	{
		$response = CrudPlanUnicoCuenta::getPlanUnicoCuentaValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/planunicocuenta',
				'text'=>'Gestión de Contabilidad'
			],
			[
				'href'=>'clientes/planunicocuenta',
				'text'=>'Plan Unico De Cuenta'
			],
			[
				'href' => 'clientes/planunicocuenta/create',
				'text' => 'Nueva Cuenta Del Plan Unico De Cuenta'
			],
		);
		return view('/Clientes/PlanUnicoCuenta.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
		$dataSaved=[
			'cuenta' => $request->cuenta,
			'nombre' => $request->nombre,
			'naturaleza' => $request->naturaleza,
			'porcentaje' => $request->porcentaje,						
			'id_impuesto' => $request->id_impuestos
		]; 
		if(isset($request->tipoimpuesto))
			$dataSaved['tipo_impuesto'] = $request->tipoimpuesto;
		else
			$dataSaved['tipo_impuesto'] = 0;
		$msm=CrudPlanUnicoCuenta::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/planunicocuenta');			
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
		$msm=CrudPlanUnicoCuenta::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudPlanUnicoCuenta::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudPlanUnicoCuenta::getPlanUnicoCuentaById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/planunicocuenta',
				'text'=>'Gestión de Contabilidad'
			],
			[
				'href'=>'clientes/planunicocuenta',
				'text'=>'Plan Unico De Cuenta'
			],
			[
				'href' => 'clientes/planunicocuenta/update/'.$id,
				'text' => 'Actualizar Cuenta de Plan Unico De Cuenta'
			],
		);
		return view('/Clientes/PlanUnicoCuenta.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){

		$id = (int)$request->id;
		$dataSaved=[
			'cuenta' => $request->cuenta,
			'nombre' => $request->nombre,
			'naturaleza' => $request->naturaleza,			
			'porcentaje' => $request->porcentaje,			
			'id_impuesto' => $request->id_impuestos		
		];
		if(isset($request->tipoimpuesto))
			$dataSaved['tipo_impuesto'] = $request->tipoimpuesto;
		else
			$dataSaved['tipo_impuesto'] = 0;
			
		$msm=CrudPlanUnicoCuenta::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/planunicocuenta');
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
		$msm = CrudPlanUnicoCuenta::getSelectList();
		return  response()->json($msm);
	}

	public function getExcel()
	{
		$PlanUnicoCuenta = new PlanUnicoCuentaExcel();
		
		$PlanUnicoCuenta->ExportExcel();
		
		dd('hola');		
	}
}

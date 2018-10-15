<?php

namespace App\Http\Controllers\Nutibara\GestionTesoreria\Impuesto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\GestionTesoreria\Impuesto\CrudImpuesto;
use Illuminate\Support\Facades\Session;
use dateFormate;


class ImpuestoController extends Controller
{
    public function Index(){ 
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/impuesto',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/impuesto',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/impuesto',
				'text'=>'Impuesto'
			]
		);
		return view('GestionTesoreria.Impuesto.index',['urls'=>$urls]);
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
		$total=CrudImpuesto::getCountImpuesto($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudImpuesto::Impuesto($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/impuesto',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/impuesto',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/impuesto',
				'text'=>'Impuesto'
			],
			[
				'href' => 'tesoreria/impuesto',
				'text' => 'Crear impuesto'
			],
		);
		return view('GestionTesoreria.Impuesto.create',['urls'=>$urls]);
    }

    public function Delete(request $request){
		$msm=CrudImpuesto::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudImpuesto::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudImpuesto::getImpuestoById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/impuesto',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/impuesto',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/impuesto',
				'text'=>'Impuesto'
			],
			[
				'href' => 'tesoreria/impuesto/update/'.$data->id,
				'text' => 'Actualizar impuesto'
			]
		);
		return view('GestionTesoreria.Impuesto.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre
 		];
		$msm=CrudImpuesto::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/tesoreria/impuesto');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
		
	}

	public function CreatePost(request $request){
		$dataSaved=[
			'nombre' => $request->nombre,
		];
		$msm=CrudImpuesto::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/tesoreria/impuesto');
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
		$msm = CrudImpuesto::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListById(request $request)
	{
		$msm = CrudImpuesto::getSelectListById($request->id);
		return  response()->json($msm);
	}

}

<?php

namespace App\Http\Controllers\Nutibara\GestionTesoreria\TipoDocumentoContable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\GestionTesoreria\TipoDocumentoContable\CrudTipoDocumentoContable;
use Illuminate\Support\Facades\Session;


class TipoDocumentoContableController extends Controller
{
    public function Index(){ 
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/tipodocumentocontable',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/tipodocumentocontable',
				'text'=>'Tipo Documento Contable'
			]
		);
		return view('GestionTesoreria.TipoDocumentoContable.index',['urls'=>$urls]);
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
		$total=CrudTipoDocumentoContable::getCountTipoDocumentoContable($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>CrudTipoDocumentoContable::TipoDocumentoContable($start,$end,$colum, $order,$search)
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
				'href'=>'tesoreria/tipodocumentocontable',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/tipodocumentocontable',
				'text'=>'Tipo Documento Contable'
			],
			[
				'href' => 'tesoreria/tipodocumentocontable/create',
				'text' => 'Crear Tipo Documento Contable'
			],
		);
		return view('GestionTesoreria.TipoDocumentoContable.create',['urls'=>$urls]);
    }

	public function Desactivate(request $request){
		$msm=CrudTipoDocumentoContable::Desactivate($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudTipoDocumentoContable::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=CrudTipoDocumentoContable::getTipoDocumentoContableById($id);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/tipodocumentocontable',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/tipodocumentocontable',
				'text'=>'Tipo Documento Contable'
			],
			[
				'href' => 'tesoreria/tipodocumentocontable/update/'.$data->id,
				'text' => 'Actualizar Tipo Documento Contable'
			]
		);
		return view('GestionTesoreria.TipoDocumentoContable.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre
		];
		$msm=CrudTipoDocumentoContable::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/tesoreria/tipodocumentocontable');
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
			'estado' => 1
		];
		$msm=CrudTipoDocumentoContable::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/tesoreria/tipodocumentocontable');
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
		$msm = CrudTipoDocumentoContable::getSelectList();
		return  response()->json($msm);
	}

}

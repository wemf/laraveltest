<?php

namespace App\Http\Controllers\Nutibara\Clientes\TipoDocumento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\TipoDocumento\CrudTipoDocumento;
use Illuminate\Support\Facades\Session;
use dateFormate;


class TipoDocumentoController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/tipodocumento',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/tipodocumento',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/tipodocumento',
				'text'=>'Tipos De Documento'
			]
		);
		return view('/Clientes/TipoDocumento.index',['urls'=>$urls]);
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
        $search["nombre_abreviado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=CrudTipoDocumento::getCountTipoDocumento($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudTipoDocumento::TipoDocumento($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getTipoDocumento(Request $request){
		$msm = CrudTipoDocumento::getTipoDocumento();
		return response()->json($msm);
    }

    public function getTipoDocumentoValueById(request $request) 
	{
		$response = CrudTipoDocumento::getTipoDocumentoValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/tipodocumento',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/tipodocumento',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/tipodocumento',
				'text'=>'Tipos De Documento'
			],
			[
				'href' => 'clientes/tipodocumento/create',
				'text' => 'Crear Tipo De Documento'
			],
		);
		return view('/Clientes/TipoDocumento.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
            'nombre_abreviado' => 'required|unique:tbl_clie_tipo_documento',
			'nombre' => 'required|unique:tbl_clie_tipo_documento',
			'codigo_dian' => 'required'
        ]);
		$dataSaved=[
            'nombre_abreviado' => strtoupper($request->nombre_abreviado),
			'nombre' => trim($request->nombre),
			'alfanumerico' => (int)$request->alfanumerico,
			'digito_verificacion' => (int)$request->digito_verificacion,
			'codigo_dian' => trim($request->codigo_dian),
			'contrato' => trim($request->contrato),
			'venta' => trim($request->venta),
			'estado' => 1
		];
		$msm=CrudTipoDocumento::Create($dataSaved);
		
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/tipodocumento');
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
		$msm=CrudTipoDocumento::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudTipoDocumento::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudTipoDocumento::getTipoDocumentoById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/tipodocumento',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/tipodocumento',
				'text'=>'Parametros Generales'
			],
			[
				'href'=>'clientes/tipodocumento',
				'text'=>'Tipos De Documento'
			],
			[
				'href' => 'clientes/tipodocumento/update/'.$id,
				'text' => 'Actualizar Tipo De Documento'
			],
		);
		return view('/Clientes/TipoDocumento.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
            'nombre_abreviado' => 'required',
			'nombre' => 'required',
			'codigo_dian' => 'required'			
        ]);
		$id = (int)$request->id;
		$dataSaved=[
            'nombre_abreviado' => strtoupper($request->nombre_abreviado),
			'nombre' => $request->nombre,
			'alfanumerico' => (int)$request->alfanumerico,
			'digito_verificacion' => (int)$request->digito_verificacion,
			'codigo_dian' => trim($request->codigo_dian),	
			'contrato' => trim($request->contrato),
			'venta' => trim($request->venta)		
		];
		$msm=CrudTipoDocumento::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/tipodocumento');
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
		$msm = CrudTipoDocumento::getSelectList();
		return  response()->json($msm);
	}
	
	public function getTipoDocumentoProveedor()
	{
		$msm = CrudTipoDocumento::getTipoDocumentoProveedor();
		return  response()->json($msm);
	}

	public function getSelectList2()
	{
		$msm = CrudTipoDocumento::getSelectList2();
		return  response()->json($msm);
	}

	public function getAlfanumerico(request $request)
	{
		$msm = CrudTipoDocumento::getAlfanumerico($request->id);
		return  response()->json($msm);
	}
}

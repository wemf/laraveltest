<?php

namespace App\Http\Controllers\Nutibara\Clientes\TipoDocumentoDian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\TipoDocumentoDian\CrudTipoDocumentoDian;
use Illuminate\Support\Facades\Session;
use dateFormate;


class TipoDocumentoDianController extends Controller
{
    public function Index(){
    	return view('/Clientes/TipoDocumentoDian.index');
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
		$total=CrudTipoDocumentoDian::getCountTipoDocumentoDian();
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudTipoDocumentoDian::TipoDocumentoDian($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getTipoDocumentoDian(Request $request){
		$msm = CrudTipoDocumentoDian::getTipoDocumentoDian();
		return response()->json($msm);
    }

    public function getTipoDocumentoDianValueById(request $request) 
	{
		$response = CrudTipoDocumentoDian::getTipoDocumentoDianValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
    	return view('/Clientes/TipoDocumentoDian.create');
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
			'digito_verificacion' => 'required',
			'id_tipo_documento' => 'required',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
			'digito_verificacion' => $request->digito_verificacion,
			'id_tipo_documento' => $request->id_tipo_documento,
			'estado' => 1
		];
		$msm=CrudTipoDocumentoDian::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/tipodocumentodian');
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
		$msm=CrudTipoDocumentoDian::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudTipoDocumentoDian::getTipoDocumentoDianById($id)->toArray());
		$data=(object)$data;
       	return view('/Clientes/TipoDocumentoDian.update' , ['attribute' => $data]);
	}

	public function Active(request $request){
		$msm=CrudTipoDocumentoDian::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
			'digito_verificacion' => 'required',
			'id_tipo_documento' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
			'digito_verificacion' => $request->digito_verificacion,
			'id_tipo_documento' => $request->id_tipo_documento,
		];
		$msm=CrudTipoDocumentoDian::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/clientes/tipodocumentodian');
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
		$msm = CrudTipoDocumentoDian::getSelectList();
		return  response()->json($msm);
	}
}

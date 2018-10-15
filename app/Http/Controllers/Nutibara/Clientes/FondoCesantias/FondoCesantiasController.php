<?php

namespace App\Http\Controllers\Nutibara\Clientes\FondoCesantias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\FondoCesantias\CrudFondoCesantias;
use Illuminate\Support\Facades\Session;
use dateFormate;


class FondoCesantiasController extends Controller
{
    public function Index(){
    	return view('/Clientes/FondoCesantias.index');
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=$start+(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["nombre"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$total=CrudFondoCesantias::getCountFondoCesantias();
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudFondoCesantias::FondoCesantias($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getFondoCesantias(Request $request){
		$msm = CrudFondoCesantias::getFondoCesantias();
		return response()->json($msm);
    }

    public function getFondoCesantiasValueById(request $request) 
	{
		$response = CrudFondoCesantias::getFondoCesantiasValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
    	return view('/Clientes/FondoCesantias.create');
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
			'descripcion' => $request->descripcion,
			'estado' => 1
		];
		$msm=CrudFondoCesantias::Create($dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/clientes/cesantias');
    }

    public function Delete(request $request){
		$msm=CrudFondoCesantias::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudFondoCesantias::getFondoCesantiasById($id)->toArray());
		$data=(object)$data;
       	return view('/Clientes/FondoCesantias.update' , ['attribute' => $data]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
			'descripcion' => $request->descripcion,
			'estado' => 1
		];
		$msm=CrudFondoCesantias::Update($id,$dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/clientes/cesantias');
	}

	public function getSelectList()
	{
		$msm = CrudFondoCesantias::getSelectList();
		return  response()->json($msm);
	}
}

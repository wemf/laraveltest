<?php

namespace App\Http\Controllers\Nutibara\DiasFestivos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\DiasFestivos\CrudDiasFestivos;
use Illuminate\Support\Facades\Session;
use dateFormate;


class DiasFestivosController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'diasfestivos',
				'text'=>'Administración General'
			],
			[
				'href'=>'diasfestivos',
				'text'=>'Dias Festivos'
			]
		);
		return view('DiasFestivos.index',['urls'=>$urls]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["id_pais"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=CrudDiasFestivos::getCountDiasFestivos($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudDiasFestivos::DiasFestivos($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getPais(Request $request){
		$msm = CrudDiasFestivos::getPais();
		return response()->json($msm);
    }

    public function getPaisValueById(request $request) 
	{
		$response = CrudDiasFestivos::getPaisValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'diasfestivos',
				'text'=>'Administración General'
			],
			[
				'href'=>'diasfestivos',
				'text'=>'Dias Festivos'
            ],
			[
				'href' => 'diasfestivos/create',
				'text' => 'Crear Dia Festivo'
			],
		);
		return view('DiasFestivos.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'id_pais' => 'required',
			'fecha' => 'required'
        ]);
		$dataSaved=[
			'id_pais' => (int)($request->id_pais),
			'fecha' => $request->fecha,
			'estado' => 1,
		];
		$msm=CrudDiasFestivos::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/diasfestivos');
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
		$msm=CrudDiasFestivos::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudDiasFestivos::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudDiasFestivos::getPaisById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'diasfestivos',
				'text'=>'Administración General'
			],
			[
				'href'=>'diasfestivos',
				'text'=>'Dias Festivos'
            ],
			[
				'href' => 'diasfestivos/update/'.$data->id,
				'text' => 'Actualizar Dia Festivo'
			],
		);
		return view('DiasFestivos.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'id_pais' => 'required',
			'fecha' => 'required'
		]);
		$dataSaved=[
			'id_pais' => (int)$request->id_pais,
			'fecha' => trim($request->fecha),
		];
		$msm=CrudDiasFestivos::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/diasfestivos');
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
		$msm = CrudDiasFestivos::getSelectList();
		return  response()->json($msm);
	}
}

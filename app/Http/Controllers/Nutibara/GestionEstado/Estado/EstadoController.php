<?php

namespace App\Http\Controllers\Nutibara\GestionEstado\Estado;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\GestionEstado\Estado\CrudEstado;
use Illuminate\Support\Facades\Session;
use dateFormate;


class EstadoController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/gestionestado/estado',
				'text'=>'Administración General'
			],
			[
				'href'=>'/gestionestado/estado',
				'text'=>'Maestro de Estados'
			],
			[
				'href'=>'/gestionestado/estado',
				'text'=>'Estados'
			]
		);
		return view('/GestionEstado/Estado.index',['urls'=>$urls]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["id_tema"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["nombre"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=CrudEstado::getCountEstado();
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudEstado::Estado($start,$end,$colum, $order,$search)->toArray())
		];  
		return response()->json($data);
    }

	public function MotivosDeEstado(Request $request){
		$id_estado = $request->id;
		$objetoMotivos = CrudEstado::MotivosDeEstado($id_estado);
		return response()->json($objetoMotivos);
    }

    public function getEstado(Request $request){
		$msm = CrudEstado::getEstado();
		return response()->json($msm);
    }

    public function getEstadoValueById(request $request) 
	{
		$response = CrudEstado::getEstadoValueById($request->id);
		return response()->json($response);
	}

	public function getEstadosByTema(request $request) 
	{
		$response = CrudEstado::getEstadosByTema($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/gestionestado/estado',
				'text'=>'Administración General'
			],
			[
				'href'=>'/gestionestado/estado',
				'text'=>'Maestro de Estados'
			],
			[
				'href'=>'/gestionestado/estado',
				'text'=>'Estados'
			],
			[
				'href' => '/gestionestado/estado/create',
				'text' => 'Crear Estado'
			],
		);
		return view('/GestionEstado/Estado.create',['urls'=>$urls]);
    }

	public function ActualizarMotivosEstado(Request $request){
		$id_estado = (int)$request->id;
		$dataSaved=[
			'id_tema' => $request->id_tema,
			'nombre' => trim($request->nombre)
			];
		$msm = CrudEstado::ActualizarMotivosEstado($id_estado,$request->asociaciones,$dataSaved);
		$a=array('msm'=>$msm);
		return response()->json($a);
    }

	public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required',
        ]);
		$dataSaved=[
			'id_tema' => $request->id_tema,
			'nombre' => trim($request->nombre),
			'estado' => 1
		];
		$msm=CrudEstado::CreateEstados($dataSaved,$request->asociaciones);
		$a=array('msm'=>$msm);
		return response()->json($a);
    }

    public function Delete(request $request){
		$msm=CrudEstado::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudEstado::getEstadoById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/gestionestado/estado',
				'text'=>'Administración General'
			],
			[
				'href'=>'/gestionestado/estado',
				'text'=>'Maestro de Estados'
			],
			[
				'href'=>'/gestionestado/estado',
				'text'=>'Estados'
			],
			[
				'href' => '/gestionestado/estado/update/'.$data->id,
				'text' => 'Actualizar Estado'
			],
		);
		return view('/GestionEstado/Estado.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function Active(request $request){
		$msm=CrudEstado::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [
			'nombre' => 'required',
        ]);
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre,
		];
		$msm=CrudEstado::Update($id,$dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/GestionEstado/Estado');
	}

	public function getSelectList()
	{
		$msm = CrudEstado::getSelectList();
		return  response()->json($msm);
	}
}

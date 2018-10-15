<?php

namespace App\Http\Controllers\Nutibara\Franquicia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Franquicia\CrudFranquicia;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\FileManager\FileManagerSingle;
use dateFormate;


class FranquiciaController extends Controller
{
	
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'franquicia',
				'text'=>'Administración General'
			],
			[
				'href'=>'franquicia',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'franquicia',
				'text'=>'Nombres Comerciales'
			]
		);
		return view('Franquicia.index',['urls'=>$urls]);
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
		$search["nombre"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["codigo_franquicia"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$total=CrudFranquicia::getCountFranquicia($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudFranquicia::Franquicia($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getFranquicia(Request $request){
		$msm = CrudFranquicia::getFranquicia();
		return response()->json($msm);
    }

    public function getFranquiciaValueById(request $request) 
	{
		$response = CrudFranquicia::getFranquiciaValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'franquicia',
				'text'=>'Administración General'
			],
			[
				'href'=>'franquicia',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'franquicia',
				'text'=>'Nombres Comerciales'
			],
			[
				'href' => 'franquicia/create',
				'text' => 'Crear Nombre Comercial'
			],
		);
		return view('Franquicia.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
		$logo ="1";
		if($request->logo != ""){
			$up = new FileManagerSingle($request->logo);
			$key = uniqid();	
			$id_logo = $up->moveFile($key,env('RUTA_ARCHIVO').'colombia/nombre_comercial');
			// dd($id_logo);
			$logo = $id_logo['msm'][1];
		}

		$dataSaved=[
			'id_pais' => (int)$request->id_pais,
			'nombre' => trim($request->nombre),
			'id_logo' => trim($logo),
			'linea_atencion' => trim($request->linea_atencion),
			'correo_habeas' => trim($request->correo_habeas),
			'correo_pedidos' => trim($request->correo_pedidos),
			'correo_denuncias' => trim($request->correo_denuncia),
			'pagina_web' => trim($request->pagina_web),
			'whatsapp' => trim($request->whatsapp),
			'facebook' => trim($request->facebook),
			'instagram' => trim($request->instagram),
			'otros1' => trim($request->otro1),
			'otros2' => trim($request->otro2),
			'codigo_franquicia' => trim($request->codigo_franquicia),
			'estado' => 1,
		];
		
		$msm=CrudFranquicia::CreateAsociacion($dataSaved,$request->asociaciones);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function SociedadesDeFranquicia(Request $request){
		$id_franquicia = $request->id;
		$objetosAsociados = CrudFranquicia::SociedadesDeFranquicia($id_franquicia);
		return response()->json($objetosAsociados);
	}
	
    public function Delete(request $request){
		$msm=CrudFranquicia::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudFranquicia::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudFranquicia::getFranquiciaByIdUpdate($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'franquicia',
				'text'=>'Administración General'
			],
			[
				'href'=>'franquicia',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'franquicia',
				'text'=>'Nombres Comerciales'
			],
			[
				'href' => 'franquicia/update/'.$id,
				'text' => 'Actualizar Nombre Comercial'
			],
		);
		return view('Franquicia.update',['urls'=>$urls,'attribute' => $data]);
	}

	public function UpdatePost(request $request){
		$id_franquicia = (int)$request->id;
		$this->validate($request, [
			'nombre' => 'required',
			'id_pais' => 'required',
		]);

		$logo = $request->id_logo;
		if($logo == "") $logo = 1;
		if($request->logo != ""){
			$up = new FileManagerSingle($request->logo);
			$key = uniqid();	
			$id_logo = $up->moveFile($key,env('RUTA_ARCHIVO').'colombia/nombre_comercial');
			$logo = $id_logo['msm'][1];
		}

		$dataSaved=[
			'id_pais' => (int)$request->id_pais,
			'nombre' => trim($request->nombre),
			'id_logo' => trim($logo),
			'linea_atencion' => trim($request->linea_atencion),
			'correo_habeas' => trim($request->correo_habeas),
			'correo_pedidos' => trim($request->correo_pedidos),
			'correo_denuncias' => trim($request->correo_denuncia),
			'pagina_web' => trim($request->pagina_web),
			'whatsapp' => trim($request->whatsapp),
			'facebook' => trim($request->facebook),
			'instagram' => trim($request->instagram),
			'otros1' => trim($request->otro1),
			'otros2' => trim($request->otro2),
			'codigo_franquicia' => trim($request->codigo_franquicia),			
		];
		$msm=CrudFranquicia::UpdateAsociacion($id_franquicia,$dataSaved,$request->asociaciones);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function getSelectList()
	{
		$msm = CrudFranquicia::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListFranquiciaPais(request $request)
	{
		$msm = CrudFranquicia::getSelectListFranquiciaPais($request->id);
		return  response()->json($msm);
	}
}

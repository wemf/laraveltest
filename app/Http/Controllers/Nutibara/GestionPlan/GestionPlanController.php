<?php

namespace App\Http\Controllers\Nutibara\GestionPlan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\GestionPlan\CrudGestionPlan;
use App\BusinessLogic\Nutibara\Clientes\Empleado\CrudEmpleado;
use Illuminate\Support\Facades\Session;
use App\AccessObject\Nutibara\Clientes\PersonaNatural\PersonaNatural;
use dateFormate;


class GestionPlanController extends Controller
{
    public function Index(){
    	return view('GestionPlan.index');
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=$start+(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["name"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=CrudGestionPlan::getCountGestionPlan();
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudGestionPlan::GestionPlan($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getGestionPlan(Request $request){
		$msm = CrudGestionPlan::getGestionPlan();
		return response()->json($msm);
    }

    public function getGestionPlanValueById(request $request) 
	{
		$response = CrudGestionPlan::getGestionPlanValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
    	return view('GestionPlan.create',[
			'tipo_documento' => $tipo_documento
		]);
    }

    public function CreatePost(request $request){
		$dataSaved=[
			'idcliente' => trim($request->idcliente),
			'codigo_plan_separe' => trim($request->codigo_plan),
			'monto' => trim($request->monto),
			'abono' => trim($request->abono),
			'fecha_creacion' => trim($request->fecha_creacion),
			'fecha_limite' => trim($request->fecha_limite),
			'deuda' => trim($request->deuda),
			'estado' => 1,
		];
		$response=CrudGestionPlan::Create($dataSaved);
		
		return response()->json($response);

    }

    public function Delete(request $request){
		$msm=CrudGestionPlan::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudGestionPlan::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function getCliente(request $request){
		$response = CrudGestionPlan::getCliente($request->iden);
		return  response()->json($response);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudGestionPlan::getGestionPlanById($id)->toArray());
		$data=(object)$data;
       	return view('GestionPlan.update' , ['attribute' => $data]);
	}

	public function updateClienteT(request $request)
	{
		$codigo_cliente = $request->codigo_cliente;
		$id_tienda = $request->id_tienda;
		$var = explode(" ",$request->apellido);
		$primer_apellido = $var[0];
		$segundo_apellido = $var[1];
		$data = [
					'nombres' => $request->nombre,
					'primer_apellido' => $primer_apellido,
					'segundo_apellido' => $segundo_apellido,
					'fecha_nacimiento' => $request->fecha_nacimiento,
					'fecha_expedicion' => $request->fecha_expedicion,
					'correo_electronico' => $request->correo,
					'id_confiabilidad' => $request->confiabilidad,
		];

		$response = PersonaNatural::actualizarClientes($id_tienda,$codigo_cliente,$data,null);
		return response()->json($response);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'nombre' => 'required'
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'descripcion' => trim($request->descripcion)
		];
		$msm=CrudGestionPlan::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/gestionplan');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
			return redirect()->back();
		
	}

	public function getSelectList(request $request)
	{
		$msm = CrudGestionPlan::getSelectList($resquest->tabla);
		return  response()->json($msm);
	}

	public function getSelectListGestionPlan(request $request)
	{
		$msm = CrudGestionPlan::getSelectListGestionPlan($request->id);
		return  response()->json($msm);
	}
}

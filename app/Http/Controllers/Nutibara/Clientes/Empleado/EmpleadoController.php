<?php

namespace App\Http\Controllers\Nutibara\Clientes\Empleado;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\Empleado\CrudEmpleado;
use App\BusinessLogic\Nutibara\Zona\CrudZona;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Clientes\Empleado\AdaptadorActualizar;
use dateFormate;

class EmpleadoController extends Controller
{
    public function Index(){
		$pais=CrudEmpleado::getSelectList('pais');
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$cargo_empleado = CrudEmpleado::getSelectList('cargo_empleado');
		$tipo_cliente = CrudEmpleado::getSelectList('tipo_cliente');
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/empleado',
				'text'=>'Gestión Humana'
			],
			[
				'href'=>'clientes/empleado',
				'text'=>'Gestión Empleados'
			],
		);
    	return view('/Clientes/Empleado.index',['tipo_cliente'=>$tipo_cliente,'tipo_documento'=>$tipo_documento,'paises'=>$pais,'urls'=>$urls,'cargo_empleado'=>$cargo_empleado]);
    }

    public function get(Request $request){
		return CrudEmpleado::Get($request);	
	}

	public function getEmail(Request $request)
	{
		return (int)CrudEmpleado::getEmail($request->name,$request->idtienda,$request->codigocliente);	
    }

    public function getEmpleado(Request $request){
		$msm = CrudEmpleado::getEmpleado();
		return response()->json($msm);
    }

    public function getEmpleadoValueById(request $request) 
	{
		$response = CrudEmpleado::getEmpleadoValueById($request->id);
		return response()->json($response);
	}

	public function getEmpleadoIden(request $request) 
	{
		$response = CrudEmpleado::getEmpleadoIden($request->identi,$request->tipoDocumento,$request->idTienda);
		return response()->json($response);
	}

	public function getproveedorjuridico(request $request) 
	{
		$tipo_documento = 32;
		$response = CrudEmpleado::getproveedorjuridico($request->identi,$request->digitoverificacion,$tipo_documento);
		return response()->json($response);
	}

	public function getproveedornatural(request $request) 
	{
		$response = CrudEmpleado::getproveedornatural($request->identi,$request->tipoDocumento);
		return response()->json($response);
	}

	public function getCombos($id) 
	{
		$response = CrudEmpleado::getCombos($id);
		return response()->json($response);
	}

	public function getTiendaZona(request $request)
	{
		$response = CrudEmpleado::getTiendaZona($request->id_tienda);
		return response()->json($response);
	}

	public function getUser(request $request)
	{
		$response = CrudEmpleado::getUser($request->email);
		return response()->json($response);
	}

    public function Create(){
		$tipo_empleado = CrudEmpleado::getSelectList('tipo_cliente');
		$tipo_contrato = CrudEmpleado::getSelectList('tipo_contrato');
		$tipo_documento = CrudEmpleado::getDocumentos();
		$zonas = CrudZona::getSelectListByPaisParameter();
		$cargo_empleado = CrudEmpleado::getSelectList('cargo_empleado');
		$pais = CrudEmpleado::getSelectList('pais');
		$tipo_rh = CrudEmpleado::getSelectList('tipo_rh');
		$estado_civil = CrudEmpleado::getSelectList('estado_civil');
		$tipo_vivienda = CrudEmpleado::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudEmpleado::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudEmpleado::getSelectListById('talla','tipo','1');
		$talla_n = CrudEmpleado::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudEmpleado::getSelectList('cargo_empleado');
		$sociedad = CrudEmpleado::getSelectList('sociedad');
		$tienda = CrudEmpleado::getSelectList('tienda');
		$fondo_cesantias = CrudEmpleado::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudEmpleado::getSelectList('fondo_pensiones');
		$eps = CrudEmpleado::getSelectList('eps');
		$caja_compensacion = CrudEmpleado::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudEmpleado::getSelectList('nivel_estudio');
		$ciudad = CrudEmpleado::getSelectList('ciudad');
		$motivo_retiro = CrudEmpleado::getSelectList('motivo_retiro');
		$ocupaciones = CrudEmpleado::getSelectList('ocupacion');
		$role = CrudEmpleado::getSelectList('roles');
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/empleado',
				'text'=>'Gestión Humana'
			],
			[
				'href'=>'clientes/empleado',
				'text'=>'Gestión Empleados'
			],
			[
				'href' => 'clientes/empleado/create',
				'text' => 'Crear Empleado'
			],
		);
    	return view(
			'/Clientes/Empleado.create',
			[
				'date'=>date('Y-m-d'), 
				"tipo_empleado" => $tipo_empleado,
				"tipo_contrato" => $tipo_contrato,
				"tipo_documento" => $tipo_documento,
				"cargo_empleado" => $cargo_empleado,
				"pais" => $pais,
				"tipo_rh" => $tipo_rh,
				"estado_civil" => $estado_civil,
				"tipo_vivienda" => $tipo_vivienda,
				"tenencia_vivienda" => $tenencia_vivienda,
				"talla_camisa" => $talla_camisa,
				"talla_n" => $talla_n,
				"cargo_empleado" => $cargo_empleado,
				"sociedad" => $sociedad,
				"tienda" => $tienda,
				"fondo_cesantias" => $fondo_cesantias,
				"fondo_pensiones" => $fondo_pensiones,
				"eps" => $eps,
				"caja_compensacion" => $caja_compensacion,
				"tipo_parentesco" => $tipo_parentesco,
				"nivel_estudio" => $nivel_estudio,
				"ciudad" => $ciudad,
				"motivo_retiro" => $motivo_retiro,
				"ocupaciones" => $ocupaciones,
				'urls'=>$urls,
				'role'=>$role,
				'zonas' => $zonas
			]
		);
    }
	public function CreatePost(request $request)
	{
		// if ($request->id_pais == 4){
		// 	$this->validate($request, [
		// 		'id_ciudad_nacimiento' => 'required'
		// 	]);
		// }

    	$this->validate($request, [
			// 'id_contrato' => 'required',
			// 'salario' => 'required',
			// 'fecha_ingreso' => 'required',
			// 'id_cargo_empleado' => 'required',
			// 'nombres' => 'required|min:3',
			// 'primer_apellido' => 'required',
			// 'segundo_apellido' => 'required',
			// 'id_tipo_documento' => 'required',
			// 'numero_documento' => 'required',
			// 'id_ciudad_expedicion'=> 'required',
			// 'fecha_nacimiento' => 'required',
			// 'direccion_residencia' => 'required',
			// 'id_ciudad_residencia'=> 'required',
			// 'barrio_residencia' => 'required',
			// 'telefono_residencia' => 'required',
			// 'telefono_celular' => 'required',
			// 'correo_electronico' => 'required',
			// 'id_estado_civil' => 'required',
			// 'id_tipo_vivienda' => 'required',
			// 'id_tenencia_vivienda' => 'required',
			// 'id_fondo_cesantias' => 'required',
			// 'id_fondo_pensiones' => 'required',
			// 'nombres_completos_familiares' => 'required',
			// 'id_parentesco_familiares' => 'required',
			// 'identificacion_familiares' => 'required',
			// 'beneficiario' => 'required',
			// 'ocupacion_familiares' => 'required',
			// 'id_nivel_estudio_familiares' => 'required',
		]);
		$idTienda = $request->id_tienda;
		$msm=CrudEmpleado::Create($request,$idTienda);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/clientes/empleado');
	}

	public function CreateAsociatePost(request $request){

		if ($request->id_pais == 4) {
			$this->validate($request, [
				'id_ciudad_nacimiento' => 'required'
			]);
		}
		$idTienda = $request->id_tienda;
		$msm=CrudEmpleado::CreateAsociate($request,$idTienda);
		if($msm['id_usuario']){
			return redirect('/asociarclientes/asociartienda/create/'.$msm['id_usuario'].'/'.$msm['id_tienda']);		
		}else{
			Session::flash('error', $msm['mensaje']);
		}
    }

    public function Delete(request $request){
		$msm=CrudEmpleado::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id,$idTienda,$id_tipo_cliente=NULL,$tipo_cliente=NULL){
		$tipo_empleado = CrudEmpleado::getSelectList('tipo_cliente');
		$tipo_contrato = CrudEmpleado::getSelectList('tipo_contrato');
		$tipo_documento = CrudEmpleado::getDocumentos();
		$zonas = CrudZona::getSelectListByPaisParameter();
		$cargo_empleado = CrudEmpleado::getSelectList('cargo_empleado');
		$pais = CrudEmpleado::getSelectList('pais');
		$tipo_rh = CrudEmpleado::getSelectList('tipo_rh');
		$estado_civil = CrudEmpleado::getSelectList('estado_civil');
		$tipo_vivienda = CrudEmpleado::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudEmpleado::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudEmpleado::getSelectListById('talla','tipo','1');
		$talla_n = CrudEmpleado::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudEmpleado::getSelectList('cargo_empleado');
		$sociedad = CrudEmpleado::getSelectList('sociedad');
		$tienda = CrudEmpleado::getSelectList('tienda');
		$fondo_cesantias = CrudEmpleado::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudEmpleado::getSelectList('fondo_pensiones');
		$eps = CrudEmpleado::getSelectList('eps');
		$caja_compensacion = CrudEmpleado::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudEmpleado::getSelectList('nivel_estudio');
		$motivo_retiro = CrudEmpleado::getSelectList('motivo_retiro');
		$role = CrudEmpleado::getSelectList('roles');
		$ciudad = CrudEmpleado::getSelectList('ciudad');
		$ocupaciones = CrudEmpleado::getSelectList('ocupacion');
		$adaptador = new AdaptadorActualizar();
		$data = $adaptador->getEmpleadoById($id,$idTienda);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/empleado',
				'text'=>'Gestión Humana'
			],
			[
				'href'=>'clientes/empleado',
				'text'=>'Gestión Empleados'
			],
			[
				'href' => 'clientes/empleado/update/'.$id.'/'.$idTienda,
				'text' => 'Actualizar Empleado'
			],
		);
       	return view('/Clientes/Empleado.update',
		   			[
						'attribute' => $data['datosGenerales'], 
						'estudios' => $data['estudios'] ,
						'familiar_nutibara' => $data['familiar_nutibara'], 
						'contacto_emergencia' => $data['contacto_emergencia'] , 
						'familiar' => $data['familiar'],
						'hist_laboral' => $data['hist_laboral'],
						'date'=>date('Y-m-d'),
						"tipo_empleado" => $tipo_empleado,
						"tipo_contrato" => $tipo_contrato,
						"tipo_documento" => $tipo_documento,
						"cargo_empleado" => $cargo_empleado,
						"pais" => $pais,
						"tipo_rh" => $tipo_rh,
						"estado_civil" => $estado_civil,
						"tipo_vivienda" => $tipo_vivienda,
						"tenencia_vivienda" => $tenencia_vivienda,
						"talla_camisa" => $talla_camisa,
						"talla_n" => $talla_n,
						"cargo_empleado" => $cargo_empleado,
						"sociedad" => $sociedad,
						"tienda" => $tienda,
						"fondo_cesantias" => $fondo_cesantias,
						"fondo_pensiones" => $fondo_pensiones,
						"eps" => $eps,
						"caja_compensacion" => $caja_compensacion,
						"tipo_parentesco" => $tipo_parentesco,
						"nivel_estudio" => $nivel_estudio,
						"ciudad" => $ciudad,
						"motivo_retiro" => $motivo_retiro,
						"role" => $role,
						"ocupaciones" => $ocupaciones,
						"id_tipo_cliente_enviado" => $id_tipo_cliente,
						"tipo_cliente_enviado" => $tipo_cliente,
						'urls'=>$urls,
						'zonas' => $zonas
					]);
	}

	public function UpdateClient($id,$idTienda,$id_tipo_cliente=NULL,$tipo_cliente=NULL){
		$tipo_empleado = CrudEmpleado::getSelectList('tipo_cliente');
		$tipo_contrato = CrudEmpleado::getSelectList('tipo_contrato');
		$tipo_documento = CrudEmpleado::getDocumentos();
		$zonas = CrudZona::getSelectListByPaisParameter();		
		$cargo_empleado = CrudEmpleado::getSelectList('cargo_empleado');
		$pais = CrudEmpleado::getSelectList('pais');
		$tipo_rh = CrudEmpleado::getSelectList('tipo_rh');
		$estado_civil = CrudEmpleado::getSelectList('estado_civil');
		$tipo_vivienda = CrudEmpleado::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudEmpleado::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudEmpleado::getSelectListById('talla','tipo','1');
		$talla_n = CrudEmpleado::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudEmpleado::getSelectList('cargo_empleado');
		$sociedad = CrudEmpleado::getSelectList('sociedad');
		$tienda = CrudEmpleado::getSelectList('tienda');
		$fondo_cesantias = CrudEmpleado::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudEmpleado::getSelectList('fondo_pensiones');
		$eps = CrudEmpleado::getSelectList('eps');
		$caja_compensacion = CrudEmpleado::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudEmpleado::getSelectList('nivel_estudio');
		$motivo_retiro = CrudEmpleado::getSelectList('motivo_retiro');
		$role = CrudEmpleado::getSelectList('roles');
		$ciudad = CrudEmpleado::getSelectList('ciudad');
		$ocupaciones = CrudEmpleado::getSelectList('ocupacion');
		$adaptador = new AdaptadorActualizar();
		$data = $adaptador->getEmpleadoById($id,$idTienda);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/empleado',
				'text'=>'Gestión Humana'
			],
			[
				'href'=>'clientes/empleado',
				'text'=>'Gestión Empleados'
			],
			[
				'href' => 'clientes/empleado/update/'.$id.'/'.$idTienda,
				'text' => 'Actualizar Empleado'
			],
		);
       	return view('/Clientes/Empleado.updateclient' , 
		   			[
						'attribute' => $data['datosGenerales'], 
						'estudios' => $data['estudios'] , 
						'familiar_nutibara' => $data['familiar_nutibara'], 
						'contacto_emergencia' => $data['contacto_emergencia'] , 
						'familiar' => $data['familiar'],
						'hist_laboral' => $data['hist_laboral'],
						'date'=>date('Y-m-d'), 
						"tipo_empleado" => $tipo_empleado,
						"tipo_contrato" => $tipo_contrato,
						"tipo_documento" => $tipo_documento,
						"cargo_empleado" => $cargo_empleado,
						"pais" => $pais,
						"tipo_rh" => $tipo_rh,
						"estado_civil" => $estado_civil,
						"tipo_vivienda" => $tipo_vivienda,	
						"tenencia_vivienda" => $tenencia_vivienda,
						"talla_camisa" => $talla_camisa,
						"talla_n" => $talla_n,
						"cargo_empleado" => $cargo_empleado,
						"sociedad" => $sociedad,
						"tienda" => $tienda,
						"fondo_cesantias" => $fondo_cesantias,
						"fondo_pensiones" => $fondo_pensiones,
						"eps" => $eps,
						"caja_compensacion" => $caja_compensacion,
						"tipo_parentesco" => $tipo_parentesco,
						"nivel_estudio" => $nivel_estudio,
						"ciudad" => $ciudad,
						"motivo_retiro" => $motivo_retiro,
						"role" => $role,
						"ocupaciones" => $ocupaciones,
						"id_tipo_cliente_enviado" => $id_tipo_cliente,
						"tipo_cliente_enviado" => $tipo_cliente,
						'urls'=>$urls,
						'zonas' => $zonas
					]);
	}

	public function UpdatePost(request $request){
		if ($request->id_pais == 4) {
			$this->validate($request, [
				'id_ciudad_nacimiento' => 'required'
			]);
		}

		$id_tienda_actual = $request->id_tienda_actual;
		$codigo_Cliente = $request->codigo_cliente;
		$adaptador = new AdaptadorActualizar();
		$msm = $adaptador->ordenarDatos($request,$codigo_Cliente,$id_tienda_actual);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/clientes/empleado');
	}

	public function getSelectList(request $request)
	{
		$msm = CrudEmpleado::getSelectList($request->tabla);
		return  response()->json($msm);
	}

	public function getSelectListById(request $request)
	{
		$msm = CrudEmpleado::getSelectListById($request->tabla,$request->filter,$request->id);
		return  response()->json($msm);
	}

	public function getAutoComplete(request $request)
	{
		$msm = CrudEmpleado::getAutoComplete($request->term);
		return  response()->json($msm);
	}

	public static function getSociedad($id){
		$msm = CrudEmpleado::getSociedad($id);
		return  response()->json($msm);
	}

	public function Active(request $request){

		$msm=CrudEmpleado::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function getFamiliarN(request $request){
		$msm=CrudEmpleado::getFamiliarN($request->value["telefono"],$request->value["tipo_documento"],$request->value["numero_documento"]);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function ValidarAdmin($idTienda)
	{
		$msm = CrudEmpleado::ValidarAdmin($idTienda);
		return response()->json($msm);
	}

	public function ValidarJefeZona($idZona)
	{
		$msm = CrudEmpleado::ValidarJefeZona($idZona);
		return response()->json($msm);
	}
}

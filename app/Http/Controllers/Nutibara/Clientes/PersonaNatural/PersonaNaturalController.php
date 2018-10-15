<?php

namespace App\Http\Controllers\Nutibara\Clientes\PersonaNatural;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\PersonaNatural\CrudPersonaNatural;
use App\AccessObject\Nutibara\Clientes\PersonaNatural\PersonaNatural;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Clientes\PersonaNatural\AdaptadorActualizar;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\AccessObject\Nutibara\Sociedad\Sociedad;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Franquicia\Franquicia;
use App\BusinessLogic\Nutibara\Ciudad\CrudCiudad;

class PersonaNaturalController extends Controller
{
    public function IndexCliente(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/persona/natural',
				'text'=>'Personas Naturales'
			]
		);
		return view('Clientes.PersonaNatural.index',['urls'=>$urls]);
	}
	
	public function get(Request $request){
		return CrudPersonaNatural::get($request);
    }


    public function get_old(Request $request){
    	$start=(int)$request->start;
		$end=$start+(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["pais"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["departamento"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["ciudad"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["zona"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$search["tienda"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
		$search["cliente"] = str_replace($vowels, "", $request->columns[5]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[6]['search']['value']);
		$total=CrudPersonaNatural::getCountPersonaNatural($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>CrudPersonaNatural::PersonaNatural($start,$end,$colum, $order,$search)
		];   
		return response()->json($data);
    }

    public function getPersonaNatural(Request $request){
		$msm = CrudPersonaNatural::getPersonaNatural();
		return response()->json($msm);
    }

    public function getPersonaNaturalValueById(request $request) 
	{
		$response = CrudPersonaNatural::getPersonaNaturalValueById($request->id);
		return response()->json($response);
	}

	public function getCombos(request $request) 
	{
		$response = CrudEmpleado::getCombos($request->id_zona);
		return response()->json($response);
	}

    public function Create(){

		$ipValidation = new userIpValidated();
		$tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$sociedad = Sociedad::getSelectSociedadByTienda($tienda->id);
		$franquiciahubicado = Franquicia::getSelectFranquiciaByTienda($tienda->id);
		$tipo_empleado = CrudPersonaNatural::getSelectList('tipo_cliente');
		$tipo_contrato = CrudPersonaNatural::getSelectList('tipo_contrato');
		$tipo_documento = CrudPersonaNatural::getTipoDocument();
		$cargo_empleado = CrudPersonaNatural::getSelectList('cargo_empleado');
		$pais = CrudPersonaNatural::getSelectList('pais');
		$tipo_rh = CrudPersonaNatural::getSelectList('tipo_rh');
		$estado_civil = CrudPersonaNatural::getSelectList('estado_civil');
		$tipo_vivienda = CrudPersonaNatural::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudPersonaNatural::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudPersonaNatural::getSelectListById('talla','tipo','1');
		$talla_n = CrudPersonaNatural::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudPersonaNatural::getSelectList('cargo_empleado');
		$fondo_cesantias = CrudPersonaNatural::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudPersonaNatural::getSelectList('fondo_pensiones');
		$eps = CrudPersonaNatural::getSelectList('eps');
		$caja_compensacion = CrudPersonaNatural::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudPersonaNatural::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudPersonaNatural::getSelectList('nivel_estudio');
		$ciudad = CrudPersonaNatural::getSelectList('ciudad');
		$motivo_retiro = CrudPersonaNatural::getSelectList('motivo_retiro');
		$ocupaciones = CrudPersonaNatural::getSelectList('ocupacion');
		$confiabilidad = CrudPersonaNatural::getSelectList('confiabilidad');
		
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/persona/natural',
				'text'=>'Personas Naturales'
			],
			[
				'href' => 'clientes/persona/natural/create',
				'text' => 'Crear Persona Natural'
			],
		);
		return view(
			'Clientes.PersonaNatural.create',
			[
				'date'=>date('Y-m-d'), 
				"tipo_empleado" => $tipo_empleado,
				"tipo_contrato" => $tipo_contrato,
				"tipo_documento" => $tipo_documento,
				"cargo_empleado" => $cargo_empleado,
				"franquiciahubicado" => $franquiciahubicado,
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
				"tipo_doc" => '',
				"num_doc" => '',
				'urls'=>$urls,
				'confiabilidad'=>$confiabilidad,
				
			]
		);
	}

	public function CreateFormContrato($tipo_doc, $num_doc){
		$tipo_empleado = CrudPersonaNatural::getSelectList('tipo_cliente');
		$tipo_contrato = CrudPersonaNatural::getSelectList('tipo_contrato');
		$tipo_documento = CrudPersonaNatural::getTipoDocument();
		$cargo_empleado = CrudPersonaNatural::getSelectList('cargo_empleado');
		$pais = CrudPersonaNatural::getSelectList('pais');
		$tipo_rh = CrudPersonaNatural::getSelectList('tipo_rh');
		$estado_civil = CrudPersonaNatural::getSelectList('estado_civil');
		$tipo_vivienda = CrudPersonaNatural::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudPersonaNatural::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudPersonaNatural::getSelectListById('talla','tipo','1');
		$talla_n = CrudPersonaNatural::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudPersonaNatural::getSelectList('cargo_empleado');
		$sociedad = CrudPersonaNatural::getSelectList('sociedad');
		$tienda = CrudPersonaNatural::getSelectList('tienda');
		$fondo_cesantias = CrudPersonaNatural::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudPersonaNatural::getSelectList('fondo_pensiones');
		$eps = CrudPersonaNatural::getSelectList('eps');
		$caja_compensacion = CrudPersonaNatural::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudPersonaNatural::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudPersonaNatural::getSelectList('nivel_estudio');
		$ciudad = CrudPersonaNatural::getSelectList('ciudad');
		$motivo_retiro = CrudPersonaNatural::getSelectList('motivo_retiro');
		$ocupaciones = CrudPersonaNatural::getSelectList('ocupacion');
		$confiabilidad = CrudPersonaNatural::getSelectList('confiabilidad');
		
		return view(
			'Clientes.PersonaNatural.create',
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
				"tipo_doc" => $tipo_doc,
				"num_doc" => $num_doc,
				'confiabilidad'=>$confiabilidad
			]
		);
	}

    public function CreatePost(request $request){
		$validarClienteExistente = PersonaNatural::validarClienteExistente($request->id_tienda,$request->id_tipo_cliente,$request->numero_documento)->toArray();
		$validarCorreoExistente  = PersonaNatural::validarCorreoExistente($request->id_tienda,$request->id_tipo_cliente,$request->correo_electronico)->toArray();
		if (count($validarClienteExistente) > 0){
			Session::flash('error', 'Este cliente persona natural ya existe.');
		}else if(count($validarCorreoExistente) > 0){
			Session::flash('error', 'Este correo electronico ya existe.');
		}else{
			$msm=CrudPersonaNatural::Create($request);
			if($msm['val']){
				Session::flash('message', $msm['msm']);
				return redirect('/clientes/persona/natural');
			}else{
				Session::flash('error', $msm['msm']);
			}
		}
		/*Contratos enviar info*/
		if($request->tipo_doc != "" && $request->num_doc != ""){
			return redirect('/creacioncontrato/'.$request->tipo_doc.'/'.$request->num_doc);
		}
    }

    public function Delete(request $request){
		$msm=CrudPersonaNatural::Delete($request->id,$request->idTienda);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id,$idTienda,$id_tipo_cliente=NULL,$tipo_cliente=NULL){
		
		$franquicia = Franquicia::getSelectList();		
		$tipo_empleado = CrudPersonaNatural::getSelectList('tipo_cliente');
		$tipo_contrato = CrudPersonaNatural::getSelectList('tipo_contrato');
		$tipo_documento = CrudPersonaNatural::getTipoDocument();
		$cargo_empleado = CrudPersonaNatural::getSelectList('cargo_empleado');
		$pais = CrudPersonaNatural::getSelectList('pais');
		$tipo_rh = CrudPersonaNatural::getSelectList('tipo_rh');
		$estado_civil = CrudPersonaNatural::getSelectList('estado_civil');
		$tipo_vivienda = CrudPersonaNatural::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudPersonaNatural::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudPersonaNatural::getSelectListById('talla','tipo','1');
		$talla_n = CrudPersonaNatural::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudPersonaNatural::getSelectList('cargo_empleado');
		$sociedad = CrudPersonaNatural::getSelectList('sociedad');
		$tienda = CrudPersonaNatural::getSelectList('tienda');
		$fondo_cesantias = CrudPersonaNatural::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudPersonaNatural::getSelectList('fondo_pensiones');
		$eps = CrudPersonaNatural::getSelectList('eps');
		$caja_compensacion = CrudPersonaNatural::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudPersonaNatural::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudPersonaNatural::getSelectList('nivel_estudio');
		$motivo_retiro = CrudPersonaNatural::getSelectList('motivo_retiro');
		$role = CrudPersonaNatural::getSelectList('roles');
		$ciudad = CrudPersonaNatural::getSelectList('ciudad');
		$ocupaciones = CrudPersonaNatural::getSelectList('ocupacion');
		$confiabilidad = CrudPersonaNatural::getSelectList('confiabilidad');		
		$adaptador = new AdaptadorActualizar();
		$data = $adaptador->getPersonaNaturalById($id,$idTienda);
		$indicativo1 = CrudCiudad::getInputIndicativo($data['datosGenerales']->id_ciudad_residencia);
		$indicativo2 = CrudCiudad::getInputIndicativo2($data['datosGenerales']->id_ciudad_residencia);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/persona/natural',
				'text'=>'Personas Naturales'
			],
			[
				'href' => 'clientes/persona/natural/update/'.$id.'/'.$idTienda,
				'text' => 'Actualizar Persona Natural'
			],
		);
       	return view('.Clientes.PersonaNatural.update' , 
		   			[
						'codigo_cliente' => $id,
						'idTienda' => $idTienda,
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
						"tipo_cliente" => $tipo_cliente,
						'urls'=>$urls,
						'confiabilidad'=>$confiabilidad,
						'franquicia'=>$franquicia,
						'indicativo1' => $indicativo1,
						'indicativo2' => $indicativo2	
					]);
	}

	public function UpdatePost(request $request)
	{
		$id_tienda_actual = $request->id_tienda_actual;
		$codigo_Cliente = $request->codigo_cliente;
		$validarCorreoExistente  = PersonaNatural::validarCorreoExistente($request->id_tienda,$request->id_tipo_cliente,$request->correo_electronico)->toArray();
		if($request->validate_foto_anterior != '' || $request->validate_foto_posterior != ''){
			$adaptador = new AdaptadorActualizar();
			$msm = $adaptador->ordenarDatos($request,$codigo_Cliente,$id_tienda_actual);
			if($msm['val']){
				Session::flash('message', $msm['msm']);
			}else{
				Session::flash('error', $msm['msm']);
			}
			return redirect('/clientes/persona/natural');
		}else if(count($validarCorreoExistente) > 0){
			Session::flash('error', 'Este correo electronico ya existe.');			
		}else{
			Session::flash('error', 'No se ha cargado una imagen.');
			return redirect()->back();
		}
			
	}

	public function getSelectList(request $request)
	{
		$msm = CrudPersonaNatural::getSelectList($request->tabla);
		return  response()->json($msm);
	}

	public function getSelectListById(request $request)
	{
		$msm = CrudPersonaNatural::getSelectListById($request->tabla,$request->filter,$request->id);
		return  response()->json($msm);
	}

	public function getAutoComplete(request $request)
	{
		$msm = CrudPersonaNatural::getAutoComplete($request->term);
		return  response()->json($msm);
	}

	public function Active(request $request){
		$msm=CrudPersonaNatural::Active($request->id,$request->idTienda);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
}

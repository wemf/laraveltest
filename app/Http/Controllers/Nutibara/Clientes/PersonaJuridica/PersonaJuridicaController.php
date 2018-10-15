<?php

namespace App\Http\Controllers\Nutibara\Clientes\PersonaJuridica;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\PersonaJuridica\CrudPersonaJuridica;
use App\AccessObject\Nutibara\Clientes\PersonaJuridica\PersonaJuridica;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Clientes\PersonaJuridica\AdaptadorActualizar;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\AccessObject\Nutibara\Sociedad\Sociedad;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Franquicia\Franquicia;
use App\BusinessLogic\Nutibara\Ciudad\CrudCiudad;

class PersonaJuridicaController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/clientes/persona/juridica',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'/clientes/persona/juridica',
				'text'=>'Clientes'
			],
			[
				'href'=>'clientes/persona/juridica',
				'text'=>'Personas Jurídicas'
			]
		);
		return view('Clientes.PersonaJuridica.index',['urls'=>$urls]);
    }

    public function get(Request $request){
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
		$search["numero_documento"] = str_replace($vowels, "", $request->columns[6]['search']['value']);
		$search["nombres"] = str_replace($vowels, "", $request->columns[7]['search']['value']);
		$search["primer_apellido"] = str_replace($vowels, "", $request->columns[8]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[9]['search']['value']);
		$total=CrudPersonaJuridica::getCountPersonaJuridica($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>CrudPersonaJuridica::PersonaJuridica($start,$end,$colum, $order,$search)
		];   
		return response()->json($data);
    }

    public function getPersonaJuridica(Request $request){
		$msm = CrudPersonaJuridica::getPersonaJuridica();
		return response()->json($msm);
    }

    public function getPersonaJuridicaValueById(request $request) 
	{
		$response = CrudPersonaJuridica::getPersonajuridicaValueById($request->id);
		return response()->json($response);
	}

    public function Create(){

		$ipValidation = new userIpValidated();
		$tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$sociedad = Sociedad::getSelectSociedadByTienda($tienda->id);
		$franquiciahubicado = Franquicia::getSelectFranquiciaByTienda($tienda->id);
		$franquicia = Franquicia::getSelectList();		
		$tipo_empleado = CrudPersonaJuridica::getSelectList('tipo_cliente');
		$tipo_contrato = CrudPersonaJuridica::getSelectList('tipo_contrato');
		$tipo_documento = CrudPersonaJuridica::getSelectList('tipo_documento');
		$cargo_empleado = CrudPersonaJuridica::getSelectList('cargo_empleado');
		$pais = CrudPersonaJuridica::getSelectList('pais');
		$tipo_rh = CrudPersonaJuridica::getSelectList('tipo_rh');
		$estado_civil = CrudPersonaJuridica::getSelectList('estado_civil');
		$tipo_vivienda = CrudPersonaJuridica::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudPersonaJuridica::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudPersonaJuridica::getSelectListById('talla','tipo','1');
		$talla_n = CrudPersonaJuridica::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudPersonaJuridica::getSelectList('cargo_empleado');
		$fondo_cesantias = CrudPersonaJuridica::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudPersonaJuridica::getSelectList('fondo_pensiones');
		$eps = CrudPersonaJuridica::getSelectList('eps');
		$caja_compensacion = CrudPersonaJuridica::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudPersonaJuridica::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudPersonaJuridica::getSelectList('nivel_estudio');
		$ciudad = CrudPersonaJuridica::getSelectList('ciudad');
		$motivo_retiro = CrudPersonaJuridica::getSelectList('motivo_retiro');
		$ocupaciones = CrudPersonaJuridica::getSelectList('ocupacion');
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/persona/natural',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/persona/natural',
				'text'=>'Clientes'
			],
			[
				'href'=>'clientes/persona/juridica',
				'text'=>'Personas Jurídicas'
			],
			[
				'href' => 'clientes/persona/juridica/create',
				'text' => 'Crear Persona Jurídica'
			],
		);
		return view(
			'Clientes.PersonaJuridica.create',
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
				"franquicia" => $franquicia,				
				"sociedad" => $sociedad,
				"tienda" => $tienda,
				"franquiciahubicado" => $franquiciahubicado,								
				"fondo_cesantias" => $fondo_cesantias,
				"fondo_pensiones" => $fondo_pensiones,
				"eps" => $eps,
				"caja_compensacion" => $caja_compensacion,
				"tipo_parentesco" => $tipo_parentesco,
				"nivel_estudio" => $nivel_estudio,
				"ciudad" => $ciudad,
				"motivo_retiro" => $motivo_retiro,
				"ocupaciones" => $ocupaciones,
				'urls'=>$urls
			]
		);
    }

    public function CreatePost(request $request){
    	// $this->validate($request, [
		// 	'nombres' => 'required|min:5',
		// 	'id_tienda' => 'required',
		// 	'numero_documento' => 'required',
		// 	'direccion_residencia' => 'required',
		// 	'id_pais_residencia'=> 'required',
		// 	'barrio_residencia' => 'required',
		// 	'telefono_residencia' => 'required',
		// 	'telefono_celular' => 'required',
		// 	'correo_electronico' => 'required',
		// 	'contacto' => 'required',
		// 	'telefono_contacto' => 'required',
		// 	'representante_legal' => 'required',
		// 	'numero_documento_representante' => 'required',
		// 	'id_regimen_contributivo' => 'required',

		// ]);
		// $idTienda = $request->id_tienda;
		$validarCorreoExistente  = PersonaJuridica::validarCorreoExistente($request->id_tienda,$request->id_tipo_cliente,$request->correo_electronico)->toArray();
		$validarClienteExistente = PersonaJuridica::validarClienteExistente($request->id_tienda,$request->id_tipo_cliente,$request->numero_documento)->toArray();
		if (count($validarClienteExistente) > 0){
			Session::flash('message', 'Cliente persona juridica registrado con éxito.');
		}else if(count($validarCorreoExistente) > 0){
			Session::flash('error', 'Este correo electronico ya existe.');
		}else{
			$msm=CrudPersonaJuridica::Create($request);
			if($msm['val']){
				Session::flash('message', 'Cliente persona juridica registrado con éxito.');
				return redirect('/clientes/persona/juridica');
			}else{
				Session::flash('error', 'Este cliente persona juridica ya existe.');
			}
		}
		return redirect('/clientes/persona/juridica');
    }

    public function Delete(request $request){
		$msm=CrudPersonaJuridica::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudPersonaJuridica::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id,$idTienda){
		
		$tipo_empleado = CrudPersonaJuridica::getSelectList('tipo_cliente');
		$tipo_contrato = CrudPersonaJuridica::getSelectList('tipo_contrato');
		$tipo_documento = CrudPersonaJuridica::getSelectList('tipo_documento');
		$cargo_empleado = CrudPersonaJuridica::getSelectList('cargo_empleado');
		$pais = CrudPersonaJuridica::getSelectList('pais');
		$tipo_rh = CrudPersonaJuridica::getSelectList('tipo_rh');
		$estado_civil = CrudPersonaJuridica::getSelectList('estado_civil');
		$tipo_vivienda = CrudPersonaJuridica::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudPersonaJuridica::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudPersonaJuridica::getSelectListById('talla','tipo','1');
		$talla_n = CrudPersonaJuridica::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudPersonaJuridica::getSelectList('cargo_empleado');
		$sociedad = CrudPersonaJuridica::getSelectList('sociedad');
		$tienda = CrudPersonaJuridica::getSelectList('tienda');
		$fondo_cesantias = CrudPersonaJuridica::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudPersonaJuridica::getSelectList('fondo_pensiones');
		$eps = CrudPersonaJuridica::getSelectList('eps');
		$caja_compensacion = CrudPersonaJuridica::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudPersonaJuridica::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudPersonaJuridica::getSelectList('nivel_estudio');
		$ciudad = CrudPersonaJuridica::getSelectList('ciudad');
		$motivo_retiro = CrudPersonaJuridica::getSelectList('motivo_retiro');
		$ocupaciones = CrudPersonaJuridica::getSelectList('ocupacion');
		$adaptador = new AdaptadorActualizar();
		$data = $adaptador->getPersonaJuridicaById($id,$idTienda);
		$indicativo1 = CrudCiudad::getInputIndicativo($data['datosGenerales']->id_ciudad_residencia);
		$indicativo2 = CrudCiudad::getInputIndicativo2($data['datosGenerales']->id_ciudad_residencia);

		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/clientes/persona/juridica',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'/clientes/persona/juridica',
				'text'=>'Clientes'
			],
			[
				'href'=>'clientes/persona/juridica',
				'text'=>'Personas Jurídicas'
			],
			[
				'href' => 'pais/update/'.$id.'/'.$idTienda,
				'text' => 'Actualizar Persona Jurídica'
			],
		);
       	return view('Clientes.PersonaJuridica.update' , 
		   			[
						'attribute' => $data['datosGenerales'], 
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
						'indicativo1' => $indicativo1,
						'indicativo2' => $indicativo2
					]);
	}

	public function UpdatePost(request $request){
		$this->validate($request, [

			'nombres' => 'required|min:5',
			'numero_documento' => 'required',
			'direccion_residencia' => 'required',
			'id_ciudad_residencia'=> 'required',
			'barrio_residencia' => 'required',
			'telefono_residencia' => 'required',
			'telefono_celular' => 'required',
			'correo_electronico' => 'required',
			'contacto' => 'required',
			'telefono_contacto' => 'required',
			'representante_legal' => 'required',
			'numero_documento_representante' => 'required',
			'id_regimen_contributivo' => 'required',

		]);
		$id_tienda_actual = $request->id_tienda_actual;
		$codigo_Cliente = $request->codigo_cliente;
		$adaptador = new AdaptadorActualizar();
		$msm = $adaptador->ordenarDatos($request,$codigo_Cliente,$id_tienda_actual);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/clientes/persona/juridica');
	}

	public function getSelectList(request $request)
	{
		$msm = CrudPersonaJuridica::getSelectList($request->tabla);
		return  response()->json($msm);
	}

	public function getSelectListById(request $request)
	{
		$msm = CrudPersonaJuridica::getSelectListById($request->tabla,$request->filter,$request->id);
		return  response()->json($msm);
	}

	public function getAutoComplete(request $request)
	{
		$msm = CrudPersonaJuridica::getAutoComplete($request->term);
		return  response()->json($msm);
	}
}

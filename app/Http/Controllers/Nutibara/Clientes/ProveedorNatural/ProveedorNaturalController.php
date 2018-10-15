<?php

namespace App\Http\Controllers\Nutibara\Clientes\ProveedorNatural;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\ProveedorNatural\CrudProveedorNatural;
use App\AccessObject\Nutibara\Clientes\ProveedorNatural\ProveedorNatural;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Clientes\ProveedorNatural\AdaptadorActualizar;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\AccessObject\Nutibara\Sociedad\Sociedad;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Franquicia\Franquicia;
use App\BusinessLogic\Nutibara\Ciudad\CrudCiudad;

class ProveedorNaturalController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/proveedor/persona/natural',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/proveedor/persona/natural',
				'text'=>'Proveedores'
			],
			[
				'href'=>'clientes/proveedor/persona/natural',
				'text'=>'Proveedores Naturales'
			]
		);
		return view('Clientes.ProveedorNatural.index',['urls'=>$urls]);
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
		$total=CrudProveedorNatural::getCountProveedorNatural($search["estado"]);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>CrudProveedorNatural::ProveedorNatural($start,$end,$colum, $order,$search)
		];   
		return response()->json($data);
    }

    public function getProveedorNatural(Request $request){
		$msm = CrudProveedorNatural::getProveedorNatural();
		return response()->json($msm);
    }

    public function getProveedorNaturalValueById(request $request) 
	{
		$response = CrudProveedorNatural::getProveedorNaturalValueById($request->id);
		return response()->json($response);
	}

    public function Create(){

		$ipValidation = new userIpValidated();
		$tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$sociedad = Sociedad::getSelectSociedadByTienda($tienda->id);
		$franquiciahubicado = Franquicia::getSelectFranquiciaByTienda($tienda->id);
		$franquicia = Franquicia::getSelectList();		
		$tipo_empleado = CrudProveedorNatural::getSelectList('tipo_cliente');
		$tipo_contrato = CrudProveedorNatural::getSelectList('tipo_contrato');
		$tipo_documento = CrudProveedorNatural::getTipoDocument();
		$cargo_empleado = CrudProveedorNatural::getSelectList('cargo_empleado');
		$pais = CrudProveedorNatural::getSelectList('pais');
		$tipo_rh = CrudProveedorNatural::getSelectList('tipo_rh');
		$estado_civil = CrudProveedorNatural::getSelectList('estado_civil');
		$tipo_vivienda = CrudProveedorNatural::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudProveedorNatural::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudProveedorNatural::getSelectListById('talla','tipo','1');
		$talla_n = CrudProveedorNatural::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudProveedorNatural::getSelectList('cargo_empleado');
		$fondo_cesantias = CrudProveedorNatural::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudProveedorNatural::getSelectList('fondo_pensiones');
		$eps = CrudProveedorNatural::getSelectList('eps');
		$caja_compensacion = CrudProveedorNatural::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudProveedorNatural::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudProveedorNatural::getSelectList('nivel_estudio');
		$ciudad = CrudProveedorNatural::getSelectList('ciudad');
		$motivo_retiro = CrudProveedorNatural::getSelectList('motivo_retiro');
		$ocupaciones = CrudProveedorNatural::getSelectList('ocupacion');
		$confiabilidad = CrudProveedorNatural::getSelectList('confiabilidad');

		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/proveedor/persona/natural',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/proveedor/persona/natural',
				'text'=>'Proveedores'
			],
			[
				'href'=>'clientes/proveedor/persona/natural',
				'text'=>'Proveedores Naturales'
			],
			[
				'href' => 'clientes/proveedor/persona/natural/create',
				'text' => 'Crear Proveedor Natural'
			],
		);

		return view(
			'Clientes.ProveedorNatural.create',
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
				"franquiciahubicado" => $franquiciahubicado,
				"franquicia" => $franquicia,				
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
				'confiabilidad'=>$confiabilidad
			]
		);
    }

    public function CreatePost(request $request){
		$idTienda = $request->id_tienda;
		$validarClienteExistente = ProveedorNatural::validarClienteExistente($request->id_tienda,$request->id_tipo_cliente,$request->numero_documento)->toArray();
		$validarCorreoExistente  = ProveedorNatural::validarCorreoExistente($request->id_tienda,$request->id_tipo_cliente,$request->correo_electronico)->toArray();
		if (count($validarClienteExistente) > 0){
			Session::flash('error', 'Este provedor persona natural ya existe.');
		}else if(count($validarCorreoExistente) > 0){
			Session::flash('error', 'Este correo electronico ya existe.');
		}else{
			$msm=CrudProveedorNatural::Create($request,$idTienda);
			if($msm['val']){
				Session::flash('message', $msm['msm']);
				return redirect('/clientes/proveedor/persona/natural');
			}else{
				Session::flash('error', $msm['msm']);
			}
		}
		return redirect('/clientes/proveedor/persona/natural');	
    }

    public function Delete(request $request){
		$msm=CrudProveedorNatural::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudProveedorNatural::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id,$idTienda,$id_tipo_cliente=NULL){
		$tipo_empleado = CrudProveedorNatural::getSelectList('tipo_cliente');
		$tipo_contrato = CrudProveedorNatural::getSelectList('tipo_contrato');
		$tipo_documento = CrudProveedorNatural::getTipoDocument();
		$cargo_empleado = CrudProveedorNatural::getSelectList('cargo_empleado');
		$pais = CrudProveedorNatural::getSelectList('pais');
		$tipo_rh = CrudProveedorNatural::getSelectList('tipo_rh');
		$estado_civil = CrudProveedorNatural::getSelectList('estado_civil');
		$tipo_vivienda = CrudProveedorNatural::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudProveedorNatural::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudProveedorNatural::getSelectListById('talla','tipo','1');
		$talla_n = CrudProveedorNatural::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudProveedorNatural::getSelectList('cargo_empleado');
		$fondo_cesantias = CrudProveedorNatural::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudProveedorNatural::getSelectList('fondo_pensiones');
		$eps = CrudProveedorNatural::getSelectList('eps');
		$caja_compensacion = CrudProveedorNatural::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudProveedorNatural::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudProveedorNatural::getSelectList('nivel_estudio');
		$motivo_retiro = CrudProveedorNatural::getSelectList('motivo_retiro');
		$role = CrudProveedorNatural::getSelectList('roles');
		$ciudad = CrudProveedorNatural::getSelectList('ciudad');
		$ocupaciones = CrudProveedorNatural::getSelectList('ocupacion');
		$adaptador = new AdaptadorActualizar();
		$data = $adaptador->getProveedorNaturalById($id,$idTienda);
		$confiabilidad = CrudProveedorNatural::getSelectList('confiabilidad');
		$indicativo1 = CrudCiudad::getInputIndicativo($data['datosGenerales']->id_ciudad_residencia);
		$indicativo2 = CrudCiudad::getInputIndicativo2($data['datosGenerales']->id_ciudad_residencia);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/proveedor/persona/natural',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/proveedor/persona/natural',
				'text'=>'Proveedores'
			],
			[
				'href'=>'clientes/proveedor/persona/natural',
				'text'=>'Proveedores Naturales'
			],
			[
				'href' => 'clientes/proveedor/persona/natural/update/'.$id."/".$idTienda,
				'text' => 'Actualizar Proveedor Natural'
			],
		);

       	return view('.Clientes.ProveedorNatural.update' , 
		   			[
						'attribute' => $data['datosGenerales'], 
						'estudios' => $data['estudios'] , 
						'familiar_nutibara' => $data['familiar_nutibara'], 
						'contacto_emergencia' => $data['contacto_emergencia'] , 
						'sucursal_clientes' => $data['sucursal_clientes'] , 
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
						'urls'=>$urls,
						'confiabilidad'=>$confiabilidad,
						'indicativo1' => $indicativo1,
						'indicativo2' => $indicativo2
					]);
	}

	public function UpdatePost(request $request)
	{
		$id_tienda_actual = $request->id_tienda_actual;
		$codigo_Cliente = $request->codigo_cliente;
		$validarCorreoExistente  = ProveedorNatural::validarCorreoExistente($request->id_tienda,$request->id_tipo_cliente,$request->correo_electronico)->toArray();
		if($request->validate_foto_anterior != '' || $request->validate_foto_posterior != ''){
			$adaptador = new AdaptadorActualizar();
			$msm = $adaptador->ordenarDatos($request,$codigo_Cliente,$id_tienda_actual);
			if($msm['val']){
				Session::flash('message', $msm['msm']);
			}else{
				Session::flash('error', $msm['msm']);
			}
			return redirect('/clientes/proveedor/persona/natural');
		}else if(count($validarCorreoExistente) > 0){
			Session::flash('error', 'Este correo electronico ya existe.');
		}else{
			Session::flash('error', 'No se ha cargado una imagen.');
			return redirect()->back();
		}
		
	}

	public function getSelectList(request $request)
	{
		$msm = CrudProveedorNatural::getSelectList($request->tabla);
		return  response()->json($msm);
	}

	public function getSelectListById(request $request)
	{
		$msm = CrudProveedorNatural::getSelectListById($request->tabla,$request->filter,$request->id);
		return  response()->json($msm);
	}

	public static function getSelectListByNombre(request $request){
		$msm = ProveedorNatural::getSelectListByNombre($request->nombres);
		return  response()->json($msm);
	}

	public function getAutoComplete(request $request)
	{
		$msm = CrudProveedorNatural::getAutoComplete($request->term);
		return  response()->json($msm);
	}
}

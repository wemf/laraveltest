<?php

namespace App\Http\Controllers\Nutibara\Clientes\ProveedorJuridico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\ProveedorJuridico\CrudProveedorJuridico;
use App\AccessObject\Nutibara\Clientes\ProveedorJuridico\ProveedorJuridico;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Clientes\ProveedorJuridico\AdaptadorActualizar;
use App\BusinessLogic\Nutibara\Clientes\ProveedorJuridico\AdaptadorCrear;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\AccessObject\Nutibara\Sociedad\Sociedad;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Franquicia\Franquicia;
use App\BusinessLogic\Nutibara\Ciudad\CrudCiudad;

class ProveedorJuridicoController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/proveedor/persona/juridica',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/proveedor/persona/juridica',
				'text'=>'Proveedores'
			],
			[
				'href'=>'clientes/proveedor/persona/juridica',
				'text'=>'Proveedores Jurídicos'
			]
		);
		return view('Clientes.ProveedorJuridico.index',['urls'=>$urls]);
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
		$total=CrudProveedorJuridico::getCountProveedorJuridico($search["estado"]);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>CrudProveedorJuridico::ProveedorJuridico($start,$end,$colum, $order,$search)
		];   
		return response()->json($data);
    }

    public function getProveedorJuridico(Request $request){
		$msm = CrudProveedorJuridico::getProveedorJuridico();
		return response()->json($msm);
    }

    public function getProveedorJuridicoValueById(request $request) 
	{
		$response = CrudProveedorJuridico::getProveedorJuridicoValueById($request->id);
		return response()->json($response);
	}

    public function Create(){

		$ipValidation = new userIpValidated();
		$tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$sociedad = Sociedad::getSelectSociedadByTienda($tienda->id);
		$franquiciahubicado = Franquicia::getSelectFranquiciaByTienda($tienda->id);
		$franquicia = Franquicia::getSelectList();		
		$tipo_empleado = CrudProveedorJuridico::getSelectList('tipo_cliente');
		$tipo_contrato = CrudProveedorJuridico::getSelectList('tipo_contrato');
		$tipo_documento = CrudProveedorJuridico::getSelectList('tipo_documento');
		$cargo_empleado = CrudProveedorJuridico::getSelectList('cargo_empleado');
		$pais = CrudProveedorJuridico::getSelectList('pais');
		$tipo_rh = CrudProveedorJuridico::getSelectList('tipo_rh');
		$estado_civil = CrudProveedorJuridico::getSelectList('estado_civil');
		$tipo_vivienda = CrudProveedorJuridico::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudProveedorJuridico::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudProveedorJuridico::getSelectListById('talla','tipo','1');
		$talla_n = CrudProveedorJuridico::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudProveedorJuridico::getSelectList('cargo_empleado');
		$fondo_cesantias = CrudProveedorJuridico::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudProveedorJuridico::getSelectList('fondo_pensiones');
		$eps = CrudProveedorJuridico::getSelectList('eps');
		$caja_compensacion = CrudProveedorJuridico::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudProveedorJuridico::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudProveedorJuridico::getSelectList('nivel_estudio');
		$ciudad = CrudProveedorJuridico::getSelectList('ciudad');
		$motivo_retiro = CrudProveedorJuridico::getSelectList('motivo_retiro');
		$ocupaciones = CrudProveedorJuridico::getSelectList('ocupacion');

		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/proveedor/persona/juridica',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/proveedor/persona/juridica',
				'text'=>'Proveedores'
			],
			[
				'href'=>'clientes/proveedor/persona/juridica',
				'text'=>'Proveedores Jurídicos'
			],
			[
				'href' => 'clientes/proveedor/persona/juridica/create',
				'text' => 'Crear Proveedor Jurídico'
			],
		);
		
		return view(
			'Clientes.ProveedorJuridico.create',
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
		//$idTienda = $request->id_tienda;
		$validarCorreoExistente  = ProveedorJuridico::validarCorreoExistente($request->id_tienda,$request->id_tipo_cliente,$request->correo_electronico)->toArray();
		$validarClienteExistente = ProveedorJuridico::validarClienteExistente($request->id_tienda,$request->id_tipo_cliente,$request->numero_documento)->toArray();
		if (count($validarClienteExistente) > 0){
			Session::flash('error', 'Este cliente persona juridica ya existe.');
		}else if(count($validarCorreoExistente) > 0){
			Session::flash('error', 'Este correo electronico ya existe.');			
		}else{
			$msm=CrudProveedorJuridico::Create($request);
			if($msm['val']){
				Session::flash('message', $msm['msm']);
				return redirect('/clientes/proveedor/persona/juridica');
			}else{
				Session::flash('error', $msm['msm']);
			}
		}
		return redirect('/clientes/proveedor/persona/juridica');
    }

	public function Delete(request $request)
	{
		$msm=CrudProveedorJuridico::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request)
	{
		$msm=CrudProveedorJuridico::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id,$idTienda)
	{
		$tipo_empleado = CrudProveedorJuridico::getSelectList('tipo_cliente');
		$tipo_contrato = CrudProveedorJuridico::getSelectList('tipo_contrato');
		$tipo_documento = CrudProveedorJuridico::getSelectList('tipo_documento');
		$cargo_empleado = CrudProveedorJuridico::getSelectList('cargo_empleado');
		$pais = CrudProveedorJuridico::getSelectList('pais');
		$tipo_rh = CrudProveedorJuridico::getSelectList('tipo_rh');
		$estado_civil = CrudProveedorJuridico::getSelectList('estado_civil');
		$tipo_vivienda = CrudProveedorJuridico::getSelectList('tipo_vivienda');
		$tenencia_vivienda = CrudProveedorJuridico::getSelectList('tenencia_vivienda');
		$talla_camisa = CrudProveedorJuridico::getSelectListById('talla','tipo','1');
		$talla_n = CrudProveedorJuridico::getSelectListById('talla','tipo','2');
		$cargo_empleado = CrudProveedorJuridico::getSelectList('cargo_empleado');
		$sociedad = CrudProveedorJuridico::getSelectList('sociedad');
		$tienda = CrudProveedorJuridico::getSelectList('tienda');
		$fondo_cesantias = CrudProveedorJuridico::getSelectList('fondo_cesantias');
		$fondo_pensiones = CrudProveedorJuridico::getSelectList('fondo_pensiones');
		$eps = CrudProveedorJuridico::getSelectList('eps');
		$caja_compensacion = CrudProveedorJuridico::getSelectList('caja_compensacion');
		$tipo_parentesco = CrudProveedorJuridico::getSelectList('tipo_parentesco');
		$nivel_estudio = CrudProveedorJuridico::getSelectList('nivel_estudio');
		$motivo_retiro = CrudProveedorJuridico::getSelectList('motivo_retiro');
		$role = CrudProveedorJuridico::getSelectList('roles');
		$ciudad = CrudProveedorJuridico::getSelectList('ciudad');
		$ocupaciones = CrudProveedorJuridico::getSelectList('ocupacion');
		$adaptador = new AdaptadorActualizar();
		$data = $adaptador->getProveedorJuridicoById($id,$idTienda);
		$indicativo1 = CrudCiudad::getInputIndicativo($data['datosGenerales']->id_ciudad_residencia);
		$indicativo2 = CrudCiudad::getInputIndicativo2($data['datosGenerales']->id_ciudad_residencia);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'clientes/proveedor/persona/juridica',
				'text'=>'Gestión De Clientes'
			],
			[
				'href'=>'clientes/proveedor/persona/juridica',
				'text'=>'Proveedores'
			],
			[
				'href'=>'clientes/proveedor/persona/juridica',
				'text'=>'Proveedores Jurídicos'
			],
			[
				'href' => 'clientes/proveedor/persona/juridica/update/'.$id.'/'.$idTienda,
				'text' => 'Actualizar Proveedor Jurídico'
			],
		);
       	return view('Clientes.ProveedorJuridico.update' , 
		   			[
						'attribute' => $data['datosGenerales'], 
						'sucursal_clientes' => $data['sucursal_clientes'], 
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
						// 'regimen_contributivo' => $regimen_contributivo,
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
		$validarCorreoExistente  = ProveedorJuridico::validarCorreoExistente($request->id_tienda,$request->id_tipo_cliente,$request->correo_electronico)->toArray();
		$adaptador = new AdaptadorActualizar();
		if(count($validarCorreoExistente) > 0){
			Session::flash('error', 'Este correo electronico ya existe.');			
		}else{
			$msm = $adaptador->ordenarDatos($request,$codigo_Cliente,$id_tienda_actual);
			if($msm['val']){
				Session::flash('message', $msm['msm']);
			return redirect('/clientes/proveedor/persona/juridica');
			}else{
				Session::flash('error', $msm['msm']);
			}
		}
	}

	public function getSelectList(request $request)
	{
		$msm = CrudProveedorJuridico::getSelectList($request->tabla);
		return  response()->json($msm);
	}

	public function getSelectListById(request $request)
	{
		$msm = CrudProveedorJuridico::getSelectListById($request->tabla,$request->filter,$request->id);
		return  response()->json($msm);
	}

	public function getAutoComplete(request $request)
	{
		$msm = CrudProveedorJuridico::getAutoComplete($request->term);
		return  response()->json($msm);
	}
}

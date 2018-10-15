<?php 

namespace App\BusinessLogic\Nutibara\Clientes\ProveedorJuridico;
use App\AccessObject\Nutibara\Clientes\ProveedorJuridico\ProveedorJuridico;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use config\messages;

class CrudProveedorJuridico {

    public static function Create ($request)
    {				
		$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda,env('SECUENCIA_TIPO_CODIGO_CLIENTE'),1);
		$codigoCliente = $secuencias[0]->response;
		// $adaptador = new AdaptadorCrear($request,$codigoCliente,$idTienda);
		// $dataSave = $adaptador->returnArray();

		$clienteExistente = [
			'id_tipo_cliente'	 				=> $request->id_tipo_cliente,
			'id_tienda' 		 				=> $request->id_tienda,
			'id_tipo_documento'  				=> $request->id_tipo_documento,
			'numero_documento'   				=> $request->numero_documento,
			'digito_verificacion'				=> $request->digito_verificacion,
			'nombres'							=> $request->nombres,
			'direccion_residencia'				=> $request->direccion_residencia,
			'barrio_residencia'					=> $request->barrio_residencia,
			'id_pais_residencia'				=> $request->id_pais_residencia,
			'id_ciudad_residencia'				=> $request->id_ciudad_residencia,
			'telefono_residencia'				=> $request->telefono_residencia,
			'telefono_celular'					=> $request->telefono_celular,
			'correo_electronico'				=> $request->correo_electronico,
			'contacto'							=> $request->contacto,
			'telefono_contacto'					=> $request->telefono_contacto,
			'representante_legal'				=> $request->representante_legal,
			'numero_documento_representante'	=> $request->numero_documento_representante,
			'id_regimen_contributivo'			=> $request->id_regimen_contributivo,
			'estado' => (int)1
		];
		$crearSucursal = array();
		for($i = 0; $i < count($request->nombre_sucursal); $i++){
			array_push($crearSucursal, [
				'id_tienda_sucursal'				=> $request->id_tienda,
				'id_cliente'						=> $codigoCliente[$i],
				'id_tienda_cliente'					=> $request->id_tienda,
				'nombre'							=> $request->nombre_sucursal[$i],
				'id_ciudad'							=> $request->ciudad_sucursal[$i],
				'telefono_sucursal'					=> $request->telefono_sucursal[$i],
				'representante'						=> $request->nombre_representante_sucursal[$i]
			]);
		}
		$dataSave['clienteExistente'] = $clienteExistente;
		$dataSucursal['crearSucursal'] = $crearSucursal;
		if(!ProveedorJuridico::Create($dataSave,$dataSucursal)){
			$msm=['msm'=>Messages::$Cliente['error'],'val'=>false];
		}else{
			$msm=['msm'=>Messages::$Cliente['ok'],'val'=>true];
		}	
		return $msm;		
	}

	public static function ProveedorJuridico ($start,$end,$colum, $order,$search)
    {
		if($search['estado'] == "")
        {
			$result = ProveedorJuridico::ProveedorJuridico($start,$end,$colum, $order);
		}else
        {
			$result = ProveedorJuridico::ProveedorJuridicoWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getProveedorJuridico()
    {
		$msm = ProveedorJuridico::getProveedorJuridico();
		return $msm;
	}

	public static function getCountProveedorJuridico($estado)
	{
		return (int)ProveedorJuridico::getCountProveedorJuridico($estado);
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$Cliente['update_ok'],'val'=>true];
		if(!ProveedorJuridico::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Cliente['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($id)
    {
		$ids = explode("/",$id);
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Cliente['delete_ok'],'val'=>true];
		if(!ProveedorJuridico::Delete($ids[0],$ids[1],$dataSaved))
        {
			$msm=['msm'=>Messages::$Cliente['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	
	public static function Active($id)
    {
		$ids = explode("/",$id);
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Cliente['active_ok'],'val'=>true];
		if(!ProveedorJuridico::Delete($ids[0],$ids[1],$dataSaved))
        {
			$msm=['msm'=>Messages::$Cliente['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList($table)
    {	
		$tabla = self::getTabla($table);
		return ProveedorJuridico::getSelectList($tabla);
	}

	public static function getSelectListById($table,$filter,$id)
    {	
		$tabla = self::getTabla($table);
		return ProveedorJuridico::getSelectListById($tabla,$filter,$id);
	}

	public static function getAutoComplete($palabra)
    {	$return = array();
		$ProveedorJuridico = ProveedorJuridico::getAutoComplete($palabra);
		foreach ($ProveedorJuridico as $key => $value) {
			$return[$key]["codigo_cliente"] = $ProveedorJuridico[$key]->codigo_cliente;
			$return[$key]["id_tienda"] = $ProveedorJuridico[$key]->id_tienda;
			$return[$key]["value"] = $ProveedorJuridico[$key]->nombre;
			$return[$key]["id_ciudad_trabajo"] = $ProveedorJuridico[$key]->id_ciudad_trabajo;
			$return[$key]["id_cargo_ProveedorJuridico"] = $ProveedorJuridico[$key]->id_cargo_ProveedorJuridico;
		}
		return $return;
	}

	private static function getTabla($data)
	{
		$table = '';
		switch($data)
		{
			case 'pais':
				$table = 'tbl_pais';
				break;
			case 'departamento':
				$table = 'tbl_departamento';
				break;
			case 'ciudad':
				$table = 'tbl_ciudad';
				break;
			case 'zona':
				$table = 'tbl_zona';
				break;
			case 'tipo_contrato':
				$table = 'tbl_empl_tipo_contrato';
				break;
			case 'cargo_empleado':
				$table = 'tbl_empl_cargo';
				break;
			case 'estado_civil':
				$table = 'tbl_clie_estado_civil';
				break;
			case 'tipo_vivienda':
				$table = 'tbl_clie_tipo_vivienda';
				break;
			case 'tenencia_vivienda':
				$table = 'tbl_clie_tenencia_vivienda';
				break;
			case 'caja_compensacion':
				$table = 'tbl_clie_caja_compensacion';
				break;
			case 'tipo_documento':
				$table = 'tbl_clie_tipo_documento';
				break;
			case 'tienda':
				$table = 'tbl_tienda';
				break;
			case 'tipo_cliente':
				$table = 'tbl_clie_tipo';
				break;	
			case 'fondo_cesantias':
				$table = 'tbl_clie_fondo_cesantias';
				break;
			case 'fondo_pensiones':
				$table = 'tbl_clie_fondo_pensiones';
				break;	
			case 'eps':
				$table = 'tbl_clie_eps';
				break;	
			case 'tipo_parentesco':
				$table = 'tbl_clie_tipo_parentesco';
				break;
			case 'nivel_estudio':
				$table = 'tbl_clie_nivel_estudio';
				break;
			case 'motivo_retiro':
				$table = 'tbl_empl_motivo_retiro';
				break;	
			case 'regimen_contributivo':
				$table = 'tbl_clie_regimen_contributivo';
				break;
			case 'tipo_rh':
				$table = 'tbl_tipo_rh';
				break;		
			case 'talla':
				$table = 'tbl_tallas';
				break;		
			case 'roles':
				$table = 'tbl_usuario_role';
				break;
			case 'sociedad':
				$table = 'tbl_sociedad';
				break;	
			case 'ocupacion':
				$table = 'tbl_clie_ocupacion';
				break;
			default: 'No se encuantra la tabla';
		}
		return $table;
	}

}
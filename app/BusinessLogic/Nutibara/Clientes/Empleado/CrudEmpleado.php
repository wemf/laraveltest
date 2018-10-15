<?php 

namespace App\BusinessLogic\Nutibara\Clientes\Empleado;
use App\AccessObject\Nutibara\Clientes\Empleado\Empleado;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use DB;

class CrudEmpleado {

	public static function Get($request)
	{
		$select=DB::table('tbl_cliente AS clie')
				->select(
					DB::raw("concat(clie.codigo_cliente,'/',tien.id) AS DT_RowId"),
					"tien.nombre AS Tienda",
					"tipd.nombre AS Tipo_Dumento",
					"clie.numero_documento AS Numero_Documento",
					DB::raw("CONCAT(clie.nombres,' ',clie.primer_apellido,' ',COALESCE(clie.segundo_apellido,'')) Nombres"),
					"clie.telefono_celular AS Celular",
					"clie.direccion_residencia AS Direccion",
					"clie.correo_electronico",
					DB::raw("IF (clie.estado = 1,'Activo','Inactivo') AS estado"),
					"tbl_empl_cargo.nombre as cargo",
					"tbl_clie_tipo.nombre as tipo_cliente"
				)
				->join("tbl_tienda AS tien","clie.id_tienda" ,"=", "tien.id")
				->join("tbl_clie_tipo_documento AS tipd","clie.id_tipo_documento", "=", "tipd.id")
				->join("tbl_ciudad AS ciud","tien.id_ciudad", "=", "ciud.id")
				->join("tbl_departamento AS depar","ciud.id_departamento","=", "depar.id")
				->join("tbl_pais AS pai" , "depar.id_pais", "=", "pai.id")
				->join("tbl_clie_empleado", function ($join) {
					$join->on("clie.codigo_cliente", "=", "tbl_clie_empleado.codigo_cliente");
					$join->on("clie.id_tienda", "=" ,"tbl_clie_empleado.id_tienda");
				})
				->join("tbl_zona AS zon", function ($join) {
					$join->on("pai.id", "=" ,"zon.id_pais");
					$join->on("tien.id_zona", "=", "zon.id");
				})
				->leftJoin("tbl_empl_cargo","tbl_empl_cargo.id","=","tbl_clie_empleado.id_cargo_empleado")
				->join("tbl_clie_tipo","tbl_clie_tipo.id","=","clie.id_tipo_cliente");
		$search = array(
			[
				'tableName' => 'pai', //tabla de busqueda 
				'field' => 'id', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],	
			[
				'tableName' => 'depar', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'ciud', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'tien', 
				'field' => 'id_zona', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'tien', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'tipd', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'clie', 
				'field' => 'numero_documento', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'clie', 
				'field' => 'nombres', 
				'method' => 'like', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'clie', 
				'field' => 'primer_apellido', 
				'method' => 'like', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'clie', 
				'field' => 'id_tipo_cliente', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'tbl_clie_empleado', 
				'field' => 'id_cargo_empleado', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'clie', 
				'field' => 'estado', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			]
		);

		$where = array(
			[
				'field' => 'clie.estado', 
				'method' => '=', 
				'typeWhere' => 'where',
				'value' => 1, 
			]
		);

		$table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
	}

    public static function Create ($request,$idTienda)
    {  
		$secuencias = SecuenciaTienda::getCodigosSecuencia($idTienda,env('SECUENCIA_TIPO_CODIGO_CLIENTE'),1);
		$codigoCliente = $secuencias[0]->response;
		$adaptador = new AdaptadorCrear($request,$codigoCliente,$idTienda);
		$dataSave = $adaptador->returnArray();
		$msm=['msm'=>Messages::$Empleado['ok'],'val'=>true];	
		if(!Empleado::Create($dataSave,$idTienda,$codigoCliente))
        {
			$msm=['msm'=>Messages::$Empleado['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function CreateAsociate ($request,$idTienda)
    {  
		$secuencias = SecuenciaTienda::getCodigosSecuencia($idTienda,env('SECUENCIA_TIPO_CODIGO_CLIENTE'),1);
		$codigoCliente = $secuencias[0]->response;
		$adaptador = new AdaptadorCrear($request,$codigoCliente,$idTienda);
		$dataSave = $adaptador->returnArray();
		$msm = Empleado::CreateAsociate($dataSave,$idTienda,$codigoCliente);
		return $msm;
	}

	public static function Empleado ($start,$end,$colum, $order,$search)
    {
		if(empty($search))
        {
			$result = Empleado::Empleado($start,$end,$colum, $order);
		}else
        {
			$result = Empleado::EmpleadoWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getEmail($name,$idtienda,$codigocliente)
    {
		$resultado = Empleado::getEmail($name,$idtienda,$codigocliente);
		return (int)$resultado;
	}

	public static function getEmpleado()
    {
		$msm = Empleado::getEmpleado();
		return $msm;
	}

	public static function getEmpleadoIden($identi,$tipoDocumento,$idTienda)
    {
		$response = Empleado::getEmpleadoIden($identi,$tipoDocumento,$idTienda);
		return $response;
	}

	public static function getproveedorjuridico($identi,$digitoVerificacion,$tipoDocumento)
    {
		$response = Empleado::getproveedorjuridico($identi,$digitoVerificacion,$tipoDocumento);
		return $response;
	}

	public static function getproveedornatural($identi,$tipoDocumento)
    {
		$response = Empleado::getproveedornatural($identi,$tipoDocumento);
		return $response;
	}

	public static function getCombos($id_zona)
    {
		$response = Empleado::getCombos($id_zona);
		return $response;
	}

	public static function getTiendaZona($id_tienda)
    {
		$response = Empleado::getTiendaZona($id_tienda);
		return $response;
	}

	public static function getUser($user)
    {
		$response = Empleado::getUser($user);
		return $response;
	}

	public static function getCountEmpleado()
	{
		return (int)Empleado::getCountEmpleado();
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$Empleado['update_ok'],'val'=>true];
		if(!Empleado::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Empleado['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($ids)
    {
		/*Divide los Ids en Id y IdTienda porque vienen en uno solo.*/
		$datos = explode("/",$ids);
		$id = $datos[0];
		$idTienda = $datos[1];
		//--------------------------
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Empleado['delete_ok'],'val'=>true];
		if(!Empleado::Delete($id,$idTienda,$dataSaved))
        {
			$msm=['msm'=>Messages::$Empleado['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList($table)
    {	
		$tabla = self::getTabla($table);
		return Empleado::getSelectList($tabla);
	}

	public static function getDocumentos()
    {	
		return Empleado::getDocumentos();
	}

	public static function getSelectListById($table,$filter,$id)
    {	
		$tabla = self::getTabla($table);
		return Empleado::getSelectListById($tabla,$filter,$id);
	}

	public static function getAutoComplete($palabra)
    {	$return = array();
		$empleado = Empleado::getAutoComplete($palabra);
		foreach ($empleado as $key => $value) {
			$return[$key]["codigo_cliente"] = $empleado[$key]->codigo_cliente;
			$return[$key]["id_tienda"] = $empleado[$key]->id_tienda;
			$return[$key]["value"] = $empleado[$key]->nombre;
			$return[$key]["id_ciudad_trabajo"] = $empleado[$key]->id_ciudad_trabajo;
			$return[$key]["id_cargo_empleado"] = $empleado[$key]->id_cargo_empleado;
		}
		return $return;
	}

	public static function getSociedad($id){
		if($id == 1)
			$sede_principal = 0;
		else
			$sede_principal = 1;
		return Empleado::getSociedad($id,$sede_principal);

	}

	public static function getTienda($id){
		if($id == 1)
			$sede_principal = 0;
		else
			$sede_principal = 1;
		return Empleado::getSociedad($id,$sede_principal);

	}

	public static function Active($ids)
    {
		/*Divide los Ids en Id y IdTienda porque vienen en uno solo.*/
		$datos = explode("/",$ids);
		$id = $datos[0];
		$idTienda = $datos[1];
		//--------------------------
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Empleado['active_ok'],'val'=>true];
		if(!Empleado::Update2($id,$idTienda,$dataSaved))
        {
			$msm=['msm'=>Messages::$Empleado['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getFamiliarN($telefono,$tipo_documento,$numero_documento)
    {	
		return Empleado::getFamiliarN($telefono,$tipo_documento,$numero_documento);
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
			case 'tipo_cliente':
				$table = 'tbl_clie_tipo';
				break;
						
			default: 'No se encuantra la tabla';
		}
		return $table;
	}
	public static function ValidarAdmin($idTienda)
	{
		return Empleado::ValidarAdmin($idTienda);
	}

	public static function ValidarJefeZona($idZona)
	{
		return Empleado::ValidarJefeZona($idZona);
	}

}
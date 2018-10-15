<?php 

namespace App\BusinessLogic\Nutibara\Clientes\ProveedorNatural;
use App\AccessObject\Nutibara\Clientes\ProveedorNatural\ProveedorNatural;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;

class CrudProveedorNatural {
	public static function get ($request)
    {		
		$select=ProveedorNatural::get();		
		$search = array(
			[
				'tableName' => 'tbl_pais', //tabla de busqueda 
				'field' => 'id', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],	
			[
				'tableName' => 'tbl_departamento', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_ciudad', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_zona', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_tienda', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_clie_tipo_documento', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_cliente', 
				'field' => 'numero_documento', 
				'method' => 'like', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_cliente', 
				'field' => 'nombres', 
				'method' => 'like', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_cliente', 
				'field' => 'primer_apellido', 
				'method' => 'like', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_cliente', 
				'field' => 'estado', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			]
		);
		$where = array(
			[
				'field' => 'tbl_cliente.estado',
				'value' => 1,
				'typeWhere'=>'where',
				'method'=>'='
			]
		);
		$table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
	}
    public static function Create ($request,$idTienda)
    {				
		$secuencias = SecuenciaTienda::getCodigosSecuencia($idTienda,env('SECUENCIA_TIPO_CODIGO_CLIENTE'),1);
		$codigoCliente = $secuencias[0]->response;

		// $adaptador = new AdaptadorCrear($request,$codigoCliente,$idTienda);
		// $dataSave = $adaptador->returnArray();

		$clienteExistente = [
			'id_tienda' 		 	=> $request->id_tienda,
			'id_tipo_cliente'	 	=> $request->id_tipo_cliente,
			'id_tipo_documento'  	=> $request->id_tipo_documento,
			'numero_documento'   	=> $request->numero_documento,
			'fecha_expedicion' 		=> $request->fecha_expedicion,
			'id_pais_expedicion' 	=> $request->id_pais_expedicion,
			'id_ciudad_expedicion'  => $request->id_ciudad_expedicion,
			'nombres' 				=> $request->nombres,
			'primer_apellido' 		=> $request->primer_apellido,
			'segundo_apellido' 		=> $request->segundo_apellido,
			'correo_electronico' 	=> $request->correo_electronico,
			'genero' 				=> $request->genero,
			'fecha_nacimiento' 		=> $request->fecha_nacimiento,
			'id_pais_residencia' 	=> $request->id_pais_residencia,
			'id_ciudad_residencia' 	=> $request->id_ciudad_residencia,
			'direccion_residencia' 	=> $request->direccion_residencia,
			'telefono_residencia' 	=> $request->telefono_residencia,
			'telefono_celular' 		=> $request->telefono_celular,
			'id_confiabilidad' 		=> $request->id_confiabilidad,
			'estado' => (int)1
		];
		$dataSave['clienteExistente'] = $clienteExistente;

		$msm=['msm'=>Messages::$Cliente['ok'],'val'=>true];	
		if(!ProveedorNatural::Create($dataSave,$idTienda,$codigoCliente))
        {
			$msm=['msm'=>Messages::$Cliente['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function ProveedorNatural ($start,$end,$colum, $order,$search)
    {
		if($search['estado'] == "")
        {
			$result = ProveedorNatural::ProveedorNatural($start,$end,$colum, $order);
		}else
        {
			$result = ProveedorNatural::ProveedorNaturalWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getProveedorNatural()
    {
		$msm = ProveedorNatural::getProveedorNatural();
		return $msm;
	}

	public static function getCountProveedorNatural($estado)
	{
		return (int)ProveedorNatural::getCountProveedorNatural($estado);
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$Cliente['update_ok_proveedor_natural'],'val'=>true];
		if(!ProveedorNatural::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Cliente['update_error_proveedor_natural'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($id)
    {
		$ids = explode('/', $id);
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Cliente['delete_ok'],'val'=>true];
		if(!ProveedorNatural::Delete($ids[0],$ids[1],$dataSaved))
        {
			$msm=['msm'=>Messages::$Cliente['delete_error'],'val'=>false];		
		}	
		return $msm;
	}
	public static function Active($id)
    {
		$ids = explode('/', $id);
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Cliente['active_ok'],'val'=>true];
		if(!ProveedorNatural::Delete($ids[0],$ids[1],$dataSaved))
        {
			$msm=['msm'=>Messages::$Cliente['active_ok'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList($table)
    {
		$tabla = self::getTabla($table);
		return ProveedorNatural::getSelectList($tabla);
	}

	// Función para el tipo de documento del proveedor natural	
	public static function getTipoDocument(){
		return ProveedorNatural::getTipoDocument();
	}

	public static function getSelectListById($table,$filter,$id)
    {	
		$tabla = self::getTabla($table);
		return ProveedorNatural::getSelectListById($tabla,$filter,$id);
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
			case 'franquicia':
				$table = 'tbl_franquicia';
				break;
			case 'confiabilidad':
				$table = 'tbl_clie_confiabilidad';	
				break;
			default: 'No se encuantra la tabla';
		}
		return $table;
	}

}
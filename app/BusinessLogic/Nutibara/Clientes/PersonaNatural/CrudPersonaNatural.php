<?php 

namespace App\BusinessLogic\Nutibara\Clientes\PersonaNatural;
use App\AccessObject\Nutibara\Clientes\PersonaNatural\PersonaNatural;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;


class CrudPersonaNatural {

	public static function get ($request)
    {		
		$select=PersonaNatural::get();		
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
			
		);
		$table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
	}

	public static function crearClienteContrato($id_tienda, $data){
		// $secuencias = SecuenciaTienda::getSecuenciaTiendaById($id_tienda);
		$secuencias = SecuenciaTienda::getCodigosSecuencia($id_tienda, env('SECUENCIA_TIPO_CODIGO_CLIENTE'), 1);
		$codigo_cliente = $secuencias[0]->response;
		$array_temp = array(
			'id_tienda' => $id_tienda,
			'codigo_cliente' => $codigo_cliente,
		);
		$data += $array_temp;		
		PersonaNatural::crearClienteContrato($id_tienda,$codigo_cliente,$data);
		return $codigo_cliente;
	}

    public static function Create ($request)
    {
		$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda,env('SECUENCIA_TIPO_CODIGO_CLIENTE'),1);
		$codigoCliente = $secuencias[0]->response;

		// $adaptador = new AdaptadorCrear($request,$codigoCliente,$request->id_tienda);
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

		if(PersonaNatural::Create($dataSave)){
			$msm=['msm'=>Messages::$Cliente['ok'],'val'=>true];
		}else{
			$msm=['msm'=>Messages::$Cliente['error'],'val'=>false];
		}
		return $msm;
	}

	public static function PersonaNatural ($start,$end,$colum, $order,$search)
    {
		if(empty($search))
        {
			$result = PersonaNatural::PersonaNatural($start,$end,$colum, $order);
		}else
        {
			$result = PersonaNatural::PersonaNaturalWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getPersonaNatural()
    {
		$msm = PersonaNatural::getPersonaNatural();
		return $msm;
	}

	public static function getCountPersonaNatural($search)
	{
		return (int)PersonaNatural::getCountPersonaNatural($search);
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$Cliente['update_ok'],'val'=>true];
		if(!PersonaNatural::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Cliente['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($id,$idTienda)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Cliente['delete_ok'],'val'=>true];
		if(!PersonaNatural::Delete($id,$idTienda,$dataSaved))
        {
			$msm=['msm'=>Messages::$Cliente['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList($table)
    {	
		$tabla = self::getTabla($table);
		return PersonaNatural::getSelectList($tabla);
	}

	public static function getTipoDocument()
    {			
		return PersonaNatural::getTipoDocument();
	}

	public static function getSelectListById($table,$filter,$id)
    {	
		$tabla = self::getTabla($table);
		return PersonaNatural::getSelectListById($tabla,$filter,$id);
	}

	public static function Active($id,$tienda)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Cliente['active_ok'],'val'=>true];
		if(!PersonaNatural::Update2($id,$tienda,$dataSaved))
        {
			$msm=['msm'=>Messages::$Cliente['active_error'],'val'=>false];		
		}	
		return $msm;
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
			case 'confiabilidad':
			$table = 'tbl_clie_confiabilidad';
			break;
				
			default: 'No se encuantra la tabla';
		}
		return $table;
	}

}
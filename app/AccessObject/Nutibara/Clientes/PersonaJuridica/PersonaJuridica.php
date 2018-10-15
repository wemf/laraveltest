<?php 

namespace app\AccessObject\Nutibara\Clientes\PersonaJuridica;

use App\Models\Nutibara\Clientes\Empleado\Empleado AS ModelEmpleado;
use App\Models\Nutibara\Clientes\Cliente AS ModelCliente;
use App\Models\Nutibara\SecuenciaTienda\SecuenciaTienda AS ModelSecuenciaTienda;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use DB;

class PersonaJuridica 
{
	public static function PersonaJuridicaWhere($colum, $order,$search){
		
		return ModelCliente::join('tbl_clie_tipo', function ($join) {
								$join->on('tbl_cliente.id_tipo_cliente' , '=' , 'tbl_clie_tipo.id')
									//  ->where('tbl_cliente.estado', '=', '1')
									 ->where('tbl_clie_tipo.id', '=', '4');
							})
							->join('tbl_tienda','tbl_cliente.id_tienda','tbl_tienda.id')
							->join('tbl_ciudad','tbl_tienda.id_ciudad','tbl_ciudad.id')
							->join('tbl_zona','tbl_zona.id','tbl_tienda.id_zona')
							->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
							->select(
								\DB::Raw('CONCAT(tbl_cliente.codigo_cliente,"/",tbl_tienda.id) AS DT_RowId'),
								'tbl_cliente.nombres AS nombre',
								'tbl_tienda.nombre AS tienda',
								'tbl_cliente.numero_documento AS numero_documento',
								'tbl_cliente.telefono_residencia AS telefono',
								'tbl_cliente.direccion_residencia AS direccion',
								'tbl_cliente.correo_electronico AS correo_electronico',
								'tbl_pais.nombre AS pais',
								'tbl_departamento.nombre AS departamento',
								'tbl_ciudad.nombre AS ciudad',
								'tbl_zona.nombre AS zona',
								\DB::Raw('IF (tbl_cliente.estado = 1 ,"Activo","Inactivo") AS estado')
								)
							->where(function ($query) use ($search){
								if($search['pais'] != "")
								 $query->where('tbl_pais.id', '=',$search['pais']);		
								if($search['departamento'] != "")	
								$query->where('tbl_departamento.id',$search['departamento']);
								if($search['ciudad'] != "")		
								$query->where('tbl_ciudad.id',$search['ciudad']);
								if($search['zona'] != "")										
								$query->where('tbl_zona.id',$search['zona']);
								$query->where('tbl_clie_tipo.id', '=', '4');
								if($search['tienda'] != "")										
								$query->where('tbl_tienda.id',$search['tienda']);
								if($search['nombres'] != "")
								$query->where('tbl_cliente.nombres','like',"%".$search['nombres']."%");
								if($search['numero_documento'] != "")
								$query->where('tbl_cliente.numero_documento','like',"%".$search['numero_documento']."%");
								if($search['primer_apellido'] != "")								
								$query->where('tbl_cliente.primer_apellido','like',"%".$search['primer_apellido']."%");
								$query->where('tbl_cliente.estado', '=', $search['estado']);
							})
							->orderBy($colum, $order)
							->get();
	}

	public static function PersonaJuridica($start,$end,$colum,$order){
		return ModelCliente::join('tbl_clie_tipo', function ($join) {
								$join->on('tbl_cliente.id_tipo_cliente' , '=' , 'tbl_clie_tipo.id');
							})
							->join('tbl_tienda','tbl_cliente.id_tienda','tbl_tienda.id')
							->join('tbl_ciudad','tbl_tienda.id_ciudad','tbl_ciudad.id')
							->join('tbl_zona','tbl_zona.id','tbl_tienda.id_zona')
							->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
							->select(
								\DB::Raw('CONCAT(tbl_cliente.codigo_cliente,"/",tbl_tienda.id) AS DT_RowId'),
								'tbl_cliente.nombres AS nombre',
								'tbl_tienda.nombre AS tienda',
								'tbl_cliente.numero_documento AS numero_documento',
								'tbl_cliente.telefono_residencia AS telefono',
								'tbl_cliente.direccion_residencia AS direccion',
								'tbl_cliente.correo_electronico AS correo_electronico',
								'tbl_pais.nombre AS pais',
								'tbl_departamento.nombre AS departamento',
								'tbl_ciudad.nombre AS ciudad',
								'tbl_zona.nombre AS zona',
								\DB::Raw('IF (tbl_cliente.estado = 1 ,"Activo","Inactivo") AS estado')
								)
								->where('tbl_clie_tipo.id', '=', '4')
								->where('tbl_cliente.estado', '=', '1')
							->orderBy($colum, $order)
							->skip($start)->take($end)		
							->get();
	}

	public static function getCountPersonaJuridica($search){
		return ModelCliente::join('tbl_clie_tipo', function ($join) {
									$join->on('tbl_cliente.id_tipo_cliente' , '=' , 'tbl_clie_tipo.id')									 
									 ->where('tbl_clie_tipo.id', '=', '4');
							})
							->join('tbl_tienda','tbl_cliente.id_tienda','tbl_tienda.id')
							->join('tbl_ciudad','tbl_tienda.id_ciudad','tbl_ciudad.id')
							->join('tbl_zona','tbl_zona.id','tbl_tienda.id_zona')
							->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
							->where(function ($query) use ($search){
								if($search['pais'] != "")
								 $query->where('tbl_pais.id', '=',$search['pais']);		
								if($search['departamento'] != "")	
								$query->where('tbl_departamento.id',$search['departamento']);
								if($search['ciudad'] != "")		
								$query->where('tbl_ciudad.id',$search['ciudad']);
								if($search['zona'] != "")										
								$query->where('tbl_zona.id',$search['zona']);
								$query->where('tbl_clie_tipo.id', '=', '4');
								if($search['tienda'] != "")										
								$query->where('tbl_tienda.id',$search['tienda']);
								if($search['nombres'] != "")
								$query->where('tbl_cliente.nombres','like',"%".$search['nombres']."%");
								if($search['numero_documento'] != "")
								$query->where('tbl_cliente.numero_documento','like',"%".$search['numero_documento']."%");
								if($search['primer_apellido'] != "")								
								$query->where('tbl_cliente.primer_apellido','like',"%".$search['primer_apellido']."%");
								
							})
							->where('tbl_cliente.estado',($search['estado'] == '' )?1:$search['estado'])
							->count();
	}

	public static function getPersonaJuridicaById($id,$idTienda){
		// dd($idTienda);
		return ModelCliente::join('tbl_clie_tipo', function ($join) {
								$join->on('tbl_cliente.id_tipo_cliente' , '=' , 'tbl_clie_tipo.id')
										->where('tbl_cliente.estado', '=', '1')
										->where('tbl_clie_tipo.id', '=', '4');
							})
							->leftjoin('tbl_clie_dias_estudio', function ($join) {
								$join->on('tbl_clie_dias_estudio.codigo_cliente' , '=' , 'tbl_cliente.codigo_cliente');
								$join->on('tbl_clie_dias_estudio.id_tienda', '=', 'tbl_cliente.id_tienda');
							})
							
							->join('tbl_tienda','tbl_cliente.id_tienda','tbl_tienda.id')	
							->join('tbl_sociedad','tbl_tienda.id_sociedad','tbl_sociedad.id')	
							
							->join('tbl_ciudad AS tbl_ciudad_residencia','tbl_cliente.id_ciudad_residencia','tbl_ciudad_residencia.id')	
							->join('tbl_departamento AS tbl_departamento_residencia','tbl_ciudad_residencia.id_departamento','tbl_departamento_residencia.id')	
							->join('tbl_pais AS tbl_pais_residencia','tbl_departamento_residencia.id_pais','tbl_pais_residencia.id')
	
							
							->select(
								'tbl_cliente.codigo_cliente',
								'tbl_cliente.id_tienda',
								'tbl_cliente.id_tipo_cliente',
								'tbl_cliente.nombres',
								'tbl_cliente.digito_verificacion',
								'tbl_cliente.numero_documento',
								'tbl_cliente.telefono_residencia',
								'tbl_cliente.telefono_celular',
								'tbl_cliente.barrio_residencia',
								'tbl_cliente.direccion_residencia',
								'tbl_pais_residencia.id AS id_pais_residencia',
								'tbl_departamento_residencia.id AS id_departamento_residencia',
								'tbl_cliente.id_ciudad_residencia',
								'tbl_cliente.correo_electronico',
								'tbl_cliente.contacto',
								'tbl_cliente.telefono_contacto',
								'tbl_cliente.representante_legal',
								'tbl_cliente.numero_documento_representante',
								'tbl_cliente.id_regimen_contributivo'
							)
							->where('tbl_cliente.codigo_cliente', $id)
							->where('tbl_cliente.id_tienda', $idTienda)
							->first();
	}


	public static function Create($dataSave){
		$result=true;
		try{
			\DB::beginTransaction();
			\DB::table('tbl_cliente')->insert($dataSave);
			//self::ingresarCliente($dataSave['arrayCliente'],$idTienda,$codigoCliente);		
			\DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function validarClienteExistente($id_tienda,$id_tipo_cliente,$numero_documento){
		return \DB::table('tbl_cliente')->select(
									'tbl_cliente.codigo_cliente AS codigo_cliente',
									'tbl_cliente.id_tienda AS id_tienda',
									'tbl_cliente.id_tipo_cliente AS id_tipo_cliente',
									'tbl_cliente.numero_documento AS numero_documento'
								)->where('tbl_cliente.id_tienda',$id_tienda)
								->where('tbl_cliente.id_tipo_cliente',$id_tipo_cliente)
								->where('tbl_cliente.numero_documento',$numero_documento)
								->get();
	}

	public static function validarCorreoExistente($id_tienda,$id_tipo_cliente,$correo_electronico){
		return DB::table('tbl_cliente')->select( 
										'tbl_cliente.codigo_cliente AS codigo_cliente',
										'tbl_cliente.id_tipo_cliente AS id_tipo_cliente',
										'tbl_cliente.id_tienda AS id_tienda',
										'tbl_cliente.correo_electronico AS correo_electronico'
									)->where('tbl_cliente.id_tienda',$id_tienda)
									 ->where('tbl_cliente.id_tipo_cliente',$id_tipo_cliente)
									 ->where('tbl_cliente.correo_electronico',$correo_electronico)
									 ->get();
	}

	private static function ingresarCliente($arrayCliente,$idTienda,$codigoCliente)
	{
		\DB::table('tbl_cliente')->insert($arrayCliente);		
	}


	public static function Update($codigoCliente,$idTienda,$dataSave){	
		$result = true;
		try{
			\DB::beginTransaction();
			self::actualizarClientes($idTienda,$codigoCliente,$dataSave['arrayCliente']);
			\DB::commit();
		}catch(\Exception $e){
			// dd($e);
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function actualizarClientes($idTienda,$codigoCliente,$arrayCliente)
	{
		return	ModelCliente::where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->update($arrayCliente);	
	}

	public static function Delete($id,$idTienda,$dataSaved){
		
		 return ModelCliente::where('id_tienda',$idTienda)->where('codigo_cliente',$id)->update($dataSaved);
	}

	

	public static function getSelectList($table){
		return \DB::table($table)->select('id','nombre AS name')
								->where('estado','1')
								->orderBy('nombre','ASC')
								->get();
	}

	public static function getSelectListById($table,$filter,$id){
		return \DB::table($table)->select('id','nombre AS name')
								->where($filter,$id)
								->where('estado','1')
								->orderBy('nombre','ASC')
								->get();
	}

	public static function getAutoComplete($palabra){
		return ModelCliente::join('tbl_clie_empleado','tbl_cliente.codigo_cliente','tbl_clie_empleado.codigo_cliente')
						->select('tbl_cliente.codigo_cliente','tbl_cliente.id_tienda',
							\DB::raw('concat(tbl_cliente.nombres," ",tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido) AS nombre'),
							'tbl_cliente.id_ciudad_trabajo',
							'tbl_clie_empleado.id_cargo_empleado'
						)
						->where('tbl_cliente.nombres','like','%'.$palabra.'%')
						->orWhere('tbl_cliente.primer_apellido','like','%'.$palabra.'%')
						->where('tbl_cliente.estado','1')
						->get();
	}

}
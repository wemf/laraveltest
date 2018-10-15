<?php 

namespace App\AccessObject\Nutibara\Clientes\PersonaNatural;

use App\Models\Nutibara\Clientes\PersonaNatural\PersonaNatural AS ModelPersonaNatural;
use App\Models\Nutibara\Clientes\Cliente AS ModelCliente;
use App\Models\autenticacion\UsuarioHuellaCola AS ModelHuellaCola;
use App\Models\Nutibara\SecuenciaTienda\SecuenciaTienda AS ModelSecuenciaTienda;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use DB;

class PersonaNatural 
{
	public static function get(){
		return  DB::table('tbl_cliente')->join('tbl_clie_tipo', function ($join) {
										$join->on('tbl_cliente.id_tipo_cliente' , '=' , 'tbl_clie_tipo.id')
										->where('tbl_clie_tipo.id', '=', '3');
							})
							->leftJoin('tbl_clie_empleado', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_clie_empleado.codigo_cliente')->whereNull('tbl_clie_empleado.codigo_cliente');
								$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_clie_empleado.id_tienda')->whereNull('tbl_clie_empleado.id_tienda');
							})
							->leftJoin('tbl_clie_tipo_documento','tbl_cliente.id_tipo_documento','tbl_clie_tipo_documento.id')
							->leftJoin('tbl_tienda','tbl_cliente.id_tienda','tbl_tienda.id')
							->leftJoin('tbl_ciudad','tbl_tienda.id_ciudad','tbl_ciudad.id')
							->leftJoin('tbl_zona','tbl_zona.id','tbl_tienda.id_zona')
							->leftJoin('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->leftJoin('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
							->select(
								DB::Raw('CONCAT(tbl_cliente.codigo_cliente,"/",tbl_tienda.id) AS DT_RowId'),
								'tbl_cliente.nombres AS nombre',
								DB::raw('concat(IFNULL(tbl_cliente.primer_apellido, "")," ",IFNULL(tbl_cliente.segundo_apellido, "")) AS apellidos'),
								'tbl_tienda.nombre AS tienda',
								'tbl_clie_tipo_documento.nombre AS tipo_documento',
								'tbl_cliente.numero_documento AS numero_documento',
								'tbl_cliente.telefono_residencia AS telefono',
								'tbl_cliente.correo_electronico AS correo_electronico',
								'tbl_pais.nombre AS pais',
								'tbl_departamento.nombre AS departamento',
								'tbl_ciudad.nombre AS ciudad',
								'tbl_zona.nombre AS zona',
								DB::Raw('IF (tbl_cliente.estado = 1 ,"Activo","Inactivo") AS estado')
							)
							->orderBy('tbl_cliente.primer_apellido','ASC')
							->orderBy('tbl_cliente.segundo_apellido','ASC')
							->orderBy('tbl_cliente.nombres','ASC');
						
	}

	public static function PersonaNaturalWhere($colum, $order,$search){
		return ModelCliente::join('tbl_clie_tipo', function ($join) {
										$join->on('tbl_cliente.id_tipo_cliente' , '=' , 'tbl_clie_tipo.id')
										// ->where('tbl_cliente.estado', '=', '1')
										->where('tbl_clie_tipo.id', '=', '3');
							})
							->leftJoin('tbl_clie_empleado', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_clie_empleado.codigo_cliente')->whereNull('tbl_clie_empleado.codigo_cliente');
								$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_clie_empleado.id_tienda')->whereNull('tbl_clie_empleado.id_tienda');
							})
							->leftJoin('tbl_clie_tipo_documento','tbl_cliente.id_tipo_documento','tbl_clie_tipo_documento.id')
							->leftJoin('tbl_tienda','tbl_cliente.id_tienda','tbl_tienda.id')
							->leftJoin('tbl_ciudad','tbl_tienda.id_ciudad','tbl_ciudad.id')
							->leftJoin('tbl_zona','tbl_zona.id','tbl_tienda.id_zona')
							->leftJoin('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->leftJoin('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
							->select(
								DB::Raw('CONCAT(tbl_cliente.codigo_cliente,"/",tbl_tienda.id) AS DT_RowId'),
								'tbl_cliente.nombres AS nombre',
								DB::raw('concat(tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido) AS apellidos'),
								'tbl_tienda.nombre AS tienda',
								'tbl_clie_tipo_documento.nombre AS tipo_documento',
								'tbl_cliente.numero_documento AS numero_documento',
								'tbl_cliente.telefono_residencia AS telefono',
								'tbl_cliente.correo_electronico AS correo_electronico',
								'tbl_pais.nombre AS pais',
								'tbl_departamento.nombre AS departamento',
								'tbl_ciudad.nombre AS ciudad',
								'tbl_zona.nombre AS zona',
								DB::Raw('IF (tbl_cliente.estado = 1 ,"Activo","Inactivo") AS estado')
								)
							->where(function ($query) use ($search){
								$query->where('tbl_cliente.nombres', 'like', "%".$search['cliente']."%");
								$query->where('tbl_pais.nombre', 'like', "%".$search['pais']."%");
								$query->where('tbl_departamento.nombre', 'like', "%".$search['departamento']."%");
								$query->where('tbl_ciudad.nombre', 'like', "%".$search['ciudad']."%");
								$query->where('tbl_zona.nombre', 'like', "%".$search['zona']."%");
								$query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
								$query->where('tbl_cliente.estado', '=', $search['estado']);
							})
							->get();
	}

	public static function PersonaNatural($start,$end,$colum,$order){
		return ModelCliente::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								'descripcion AS descripcion'
								)
						        ->where('estado',1)	
						        ->get();
	}

	public static function validarClienteExistente($id_tienda,$id_tipo_cliente,$numero_documento){
		return DB::table('tbl_cliente')->select(
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

	public static function getCountPersonaNatural($search){
		return ModelCliente::join('tbl_clie_tipo', function ($join) {
								$join->on('tbl_cliente.id_tipo_cliente' , '=' , 'tbl_clie_tipo.id')
										// ->where('tbl_cliente.estado', '=', '1')
										->where('tbl_clie_tipo.id', '=', '3');
							})
							->leftJoin('tbl_clie_empleado', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_clie_empleado.codigo_cliente')->whereNull('tbl_clie_empleado.codigo_cliente');
								$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_clie_empleado.id_tienda')->whereNull('tbl_clie_empleado.id_tienda');
							})
							->leftJoin('tbl_clie_tipo_documento','tbl_cliente.id_tipo_documento','tbl_clie_tipo_documento.id')
							->leftJoin('tbl_tienda','tbl_cliente.id_tienda','tbl_tienda.id')
							->leftJoin('tbl_ciudad','tbl_tienda.id_ciudad','tbl_ciudad.id')
							->leftJoin('tbl_zona','tbl_zona.id','tbl_tienda.id_zona')
							->leftJoin('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->leftJoin('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
							->where(function ($query) use ($search){
								if($search['cliente'] !='')$query->where('tbl_cliente.nombres', 'like', "%".$search['cliente']."%");
								if($search['pais'] !='')$query->where('tbl_pais.nombre', 'like', "%".$search['pais']."%");
								if($search['departamento'] !='')$query->where('tbl_departamento.nombre', 'like', "%".$search['departamento']."%");
								if($search['ciudad'] !='')$query->where('tbl_ciudad.nombre', 'like', "%".$search['ciudad']."%");
								if($search['zona'] !='')$query->where('tbl_zona.nombre', 'like', "%".$search['zona']."%");
								if($search['tienda'] !='')$query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
							})
							->where('tbl_cliente.estado',($search['estado'] == '' )?1:$search['estado'])
							->count();
	}

	public static function getPersonaNaturalById($id,$idTienda){
		// dd($idTienda);
		return ModelCliente::join('tbl_clie_tipo', function ($join) {
								$join->on('tbl_cliente.id_tipo_cliente' , '=' , 'tbl_clie_tipo.id')
										->where('tbl_cliente.estado', '=', '1')
										->where('tbl_clie_tipo.id', '=', '3');
							})

							->join('tbl_tienda','tbl_cliente.id_tienda','tbl_tienda.id')	
							->leftJoin('tbl_sociedad','tbl_tienda.id_sociedad','tbl_sociedad.id')	
							->leftJoin('tbl_franquicia','tbl_tienda.id_franquicia','tbl_franquicia.id')

							->leftjoin('tbl_clie_dias_estudio', function ($join) {
								$join->on('tbl_clie_dias_estudio.codigo_cliente' , '=' , 'tbl_cliente.codigo_cliente');
								$join->on('tbl_clie_dias_estudio.id_tienda', '=', 'tbl_cliente.id_tienda');
							})
							
							->leftJoin('tbl_ciudad','tbl_cliente.id_ciudad_expedicion','tbl_ciudad.id')	
							->leftJoin('tbl_departamento','tbl_ciudad.id_departamento','tbl_departamento.id')	
							->leftJoin('tbl_pais','tbl_cliente.id_pais_expedicion','tbl_pais.id')	

							->leftJoin('tbl_ciudad AS tbl_ciudad_nacimiento','tbl_cliente.id_ciudad_nacimiento','tbl_ciudad_nacimiento.id')	
							->leftJoin('tbl_departamento AS tbl_departamento_nacimiento','tbl_ciudad_nacimiento.id_departamento','tbl_departamento_nacimiento.id')	
							->leftJoin('tbl_pais AS tbl_pais_nacimiento','tbl_cliente.id_pais_nacimiento','tbl_pais_nacimiento.id')	
							
							->leftJoin('tbl_ciudad AS tbl_ciudad_residencia','tbl_cliente.id_ciudad_residencia','tbl_ciudad_residencia.id')	
							->leftJoin('tbl_departamento AS tbl_departamento_residencia','tbl_ciudad_residencia.id_departamento','tbl_departamento_residencia.id')	
							->leftJoin('tbl_pais AS tbl_pais_residencia','tbl_departamento_residencia.id_pais','tbl_pais_residencia.id')
							
							->leftjoin('tbl_sys_archivo AS tbl_archivo_a','tbl_cliente.id_foto_documento_anterior','tbl_archivo_a.id')
							->leftjoin('tbl_sys_archivo AS tbl_archivo_b','tbl_cliente.id_foto_documento_posterior','tbl_archivo_b.id')

							->select(
								'tbl_cliente.codigo_cliente',
								'tbl_cliente.id_tienda',
								'tbl_sociedad.id AS id_sociedad',
								'tbl_franquicia.id AS id_franquicia',
								'tbl_cliente.id_tipo_cliente',
								'tbl_cliente.nombres',
								'tbl_cliente.primer_apellido',
								'tbl_cliente.segundo_apellido',
								'tbl_cliente.id_tipo_documento',
								'tbl_cliente.numero_documento',
								'tbl_cliente.fecha_nacimiento',
								'tbl_cliente.telefono_residencia',
								'tbl_cliente.telefono_celular',
								'tbl_cliente.barrio_residencia',
								'tbl_cliente.direccion_residencia',
								'tbl_cliente.fecha_expedicion',
								'tbl_pais.id AS id_pais_expedicion',
								'tbl_departamento.id AS id_departamento_expedicion',
								'tbl_cliente.fecha_expedicion',
								'tbl_cliente.id_ciudad_expedicion',
								'tbl_cliente.fecha_nacimiento',
								'tbl_pais_nacimiento.id AS id_pais_nacimiento',
								'tbl_departamento_nacimiento.id AS id_departamento_nacimiento',
								'tbl_cliente.id_ciudad_nacimiento',
								'tbl_pais_residencia.id AS id_pais_residencia',
								'tbl_departamento_residencia.id AS id_departamento_residencia',
								'tbl_cliente.id_ciudad_residencia',
								'tbl_cliente.correo_electronico',
								'tbl_cliente.id_estado_civil',
								'tbl_cliente.aniversario',
								'tbl_cliente.id_tipo_vivienda',
								'tbl_cliente.tenencia_vivienda',
								'tbl_cliente.libreta_militar',
								'tbl_cliente.distrito_militar',
								'tbl_cliente.rh',
								'tbl_cliente.id_fondo_cesantias',
								'tbl_cliente.id_fondo_pensiones',
								'tbl_cliente.id_eps',
								'tbl_cliente.id_caja_compensacion',
								'tbl_cliente.talla_camisa',
								'tbl_cliente.talla_pantalon',
								'tbl_cliente.talla_zapatos',
								'tbl_cliente.id_nivel_estudio',
								'tbl_cliente.id_nivel_estudio_actual',
								'tbl_cliente.id_regimen_contributivo',
								'tbl_cliente.genero',
								'tbl_cliente.id_confiabilidad',
								'tbl_clie_dias_estudio.lunes AS estudio_lunes',
								'tbl_clie_dias_estudio.martes AS estudio_martes',
								'tbl_clie_dias_estudio.miercoles AS estudio_miercoles' ,
								'tbl_clie_dias_estudio.jueves AS estudio_jueves',
								'tbl_clie_dias_estudio.viernes AS estudio_viernes',
								'tbl_clie_dias_estudio.sabado AS estudio_sabado',
								'tbl_clie_dias_estudio.domingo AS estudio_domingo',
								'tbl_archivo_a.id AS id_foto_anterior',
								'tbl_archivo_a.nombre AS ruta_foto_anterior',
								'tbl_archivo_b.id AS id_foto_posterior',
								'tbl_archivo_b.nombre AS ruta_foto_posterior'
							)
							->where('tbl_cliente.codigo_cliente', $id)
							->where('tbl_cliente.id_tienda', $idTienda)
							->first();
	}


public static function getClienteByDocumento($tipodocumento, $numdocumento){
		return ModelCliente::leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_cliente.id_ciudad_expedicion')
							->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_ciudad.id_departamento')
							->leftJoin('tbl_pais', 'tbl_pais.id', '=', 'tbl_departamento.id_pais')
							->leftJoin('tbl_clie_genero', 'tbl_clie_genero.id', '=', 'tbl_cliente.genero')
							->leftJoin('tbl_clie_regimen_contributivo', 'tbl_clie_regimen_contributivo.id', '=', 'tbl_cliente.id_regimen_contributivo')
							->leftjoin('tbl_sys_archivo AS tbl_archivo_a','tbl_cliente.id_foto_documento_anterior','tbl_archivo_a.id')
							->leftjoin('tbl_sys_archivo AS tbl_archivo_b','tbl_cliente.id_foto_documento_posterior','tbl_archivo_b.id')
							->leftJoin('tbl_ciudad AS ciudad_residencia', 'ciudad_residencia.id', '=', 'tbl_cliente.id_ciudad_residencia')
							->leftJoin('tbl_departamento AS departamento_residencia', 'departamento_residencia.id', '=', 'ciudad_residencia.id_departamento')
							->leftJoin('tbl_pais AS pais_residencia', 'pais_residencia.id', '=', 'departamento_residencia.id_pais')
							->leftJoin('tbl_ciudad AS ciudad_expedicion', 'ciudad_expedicion.id', '=', 'tbl_cliente.id_ciudad_expedicion')
							->leftJoin('tbl_departamento AS departamento_expedicion', 'departamento_expedicion.id', '=', 'ciudad_expedicion.id_departamento')
							->leftJoin('tbl_pais AS pais_expedicion', 'pais_expedicion.id', '=', 'departamento_expedicion.id_pais')
							->leftJoin('tbl_clie_tipo_documento', 'tbl_clie_tipo_documento.id', '=', 'tbl_cliente.id_tipo_documento')
							->select(
								'tbl_cliente.id_tienda',
								'tbl_cliente.codigo_cliente',
								'tbl_cliente.id_tipo_documento',
								'tbl_cliente.numero_documento',
								'tbl_cliente.fecha_nacimiento',
								'tbl_cliente.fecha_expedicion',
								'tbl_cliente.fecha_nacimiento',
								'pais_expedicion.nombre AS pais_expedicion',
								'ciudad_expedicion.nombre AS ciudad_expedicion',
								'tbl_cliente.nombres',
								'tbl_cliente.primer_apellido',
								'tbl_cliente.segundo_apellido',
								'tbl_cliente.correo_electronico',
								'tbl_cliente.id_confiabilidad',
								'tbl_clie_genero.nombre AS genero',
								'pais_residencia.nombre AS pais_residencia',
								'ciudad_residencia.nombre AS ciudad_residencia',
								'pais_residencia.id AS id_pais_residencia',
								'ciudad_residencia.id AS id_ciudad_residencia',
								'tbl_cliente.direccion_residencia',
								'tbl_clie_regimen_contributivo.nombre AS regimen',
								'tbl_cliente.telefono_residencia',
								'tbl_cliente.telefono_celular',
								'tbl_archivo_a.nombre AS ruta_foto_anterior',
								'tbl_archivo_b.nombre AS ruta_foto_posterior',
								'tbl_clie_tipo_documento.nombre as nombre_documento',
								'tbl_clie_tipo_documento.nombre_abreviado as abreviado_documento'
							)
							->where('id_tipo_documento', $tipodocumento)->where('numero_documento', $numdocumento)
							->first();
	}

	public static function getEstudiosById($id,$idTienda){
		return ModelCliente::join('tbl_clie_tipo', function ($join) {
								$join->on('tbl_cliente.id_tipo_cliente' , '=' , 'tbl_clie_tipo.id')
										->where('tbl_cliente.estado', '=', '1')
										->where('tbl_clie_tipo.id', '=', '3');
							})
							->join('tbl_clie_estudios', function ($join) {
								$join->on('tbl_clie_estudios.codigo_cliente' , '=' , 'tbl_cliente.codigo_cliente');
								$join->on('tbl_clie_estudios.id_tienda', '=', 'tbl_cliente.id_tienda');
							})
							->select(
								'tbl_cliente.codigo_cliente',
								'tbl_cliente.id_tienda',
								'tbl_clie_estudios.nombre AS nombre_estudio',
								'tbl_clie_estudios.anos_cursados AS anos_cursados_estudio',
								'tbl_clie_estudios.fecha_inicio AS fecha_inicio_estudio',
								'tbl_clie_estudios.fecha_terminacion AS fecha_terminacion_estudio',
								'tbl_clie_estudios.institucion AS institucion_estudio',
								'tbl_clie_estudios.titulo_obtenido AS titulo_obtenido_estudio',
								'tbl_clie_estudios.finalizado AS finalizado_estudio'
							)
							->where('tbl_cliente.codigo_cliente', $id)
							->where('tbl_cliente.id_tienda', $idTienda)
							->get();
	}

	public static function getParientesById($id,$idTienda){
		return ModelCliente::join('tbl_clie_pariente', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_clie_pariente.codigo_cliente');
								$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_clie_pariente.id_tienda');
							})
							->select(
								'tbl_cliente.codigo_cliente',
								'tbl_cliente.id_tienda',
								'tbl_clie_pariente.codigo_cliente_pariente',
								'tbl_clie_pariente.id_tienda_pariente',
								'tbl_clie_pariente.trabaja_nutibara',
								'tbl_clie_pariente.contacto_emergencia',
								'tbl_clie_pariente.id_tipo_parentesco',
								'tbl_clie_pariente.a_cargo_persona_familiares',
								'tbl_clie_pariente.vive_con_persona_familiares'
							)
							->where('tbl_cliente.codigo_cliente', $id)
							->where('tbl_cliente.id_tienda', $idTienda)
							->get();
	}

	public static function getClienteById($id,$idTienda){
		return ModelCliente::leftJoin('tbl_clie_empleado', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_clie_empleado.codigo_cliente');
								$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_clie_empleado.id_tienda');
							})
							->select(
								'tbl_cliente.codigo_cliente',
								'tbl_cliente.id_tienda',
								'tbl_cliente.id_tipo_cliente',
								'tbl_clie_empleado.id_tipo_contrato',
								// 'tbl_pais.id AS id_pais_trabajo', 
								// 'tbl_departamento.id AS id_departamento_trabajo', 
								// 'tbl_ciudad.id AS id_ciudad_trabajo', 
								'tbl_clie_empleado.salario',
								'tbl_clie_empleado.valor_auxilio_vivenda',
								'tbl_clie_empleado.valor_auxilio_transporte',
								'tbl_clie_empleado.id_cargo_empleado',
								'tbl_clie_empleado.fecha_ingreso',
								'tbl_cliente.nombres',
								'tbl_cliente.primer_apellido',
								'tbl_cliente.segundo_apellido',
								'tbl_cliente.id_tipo_documento',
								'tbl_cliente.numero_documento',
								// 'tbl_cliente.id_pais_expedicion',
								// 'tbl_cliente.id_departamento_expedicion',
								'tbl_cliente.id_ciudad_expedicion',
								'tbl_cliente.fecha_nacimiento',
								'tbl_cliente.id_ciudad_nacimiento',
								'tbl_cliente.telefono_residencia',
								'tbl_cliente.telefono_celular',
								'tbl_cliente.barrio_residencia',
								'tbl_cliente.direccion_residencia',
								'tbl_cliente.id_ciudad_residencia',
								'tbl_cliente.correo_electronico',
								'tbl_cliente.id_estado_civil',
								'tbl_cliente.aniversario',
								'tbl_cliente.id_tipo_vivienda',
								'tbl_cliente.tenencia_vivienda',
								'tbl_cliente.libreta_militar',
								'tbl_cliente.distrito_militar',
								'tbl_cliente.beneficiario',
								'tbl_cliente.ocupacion',
								'tbl_cliente.grado_escolaridad',
								'tbl_cliente.ano_o_semestre',
								'tbl_cliente.id_nivel_estudio',
								'tbl_cliente.rh',
								'tbl_cliente.genero',								
								'tbl_clie_empleado.id_cargo_ejercido_anterior',
								'tbl_cliente.id_fondo_cesantias',
								'tbl_cliente.id_fondo_pensiones',
								'tbl_cliente.id_eps',
								'tbl_cliente.id_caja_compensacion',
								'tbl_clie_empleado.otros_aportes',
								'tbl_cliente.talla_camisa',
								'tbl_cliente.talla_pantalon',
								'tbl_cliente.talla_zapatos',
								'tbl_clie_empleado.familiares_en_nutibara'
								)
							->where('tbl_cliente.codigo_cliente', $id)
							->where('tbl_cliente.id_tienda', $idTienda)
							->first();
	}
	
	public static function getHistorialLaboralById($id,$idTienda){
		return ModelCliente::join('tbl_clie_hist_laboral', function ($join) {
								$join->on('tbl_clie_hist_laboral.codigo_cliente' , '=' , 'tbl_cliente.codigo_cliente');
								$join->on('tbl_clie_hist_laboral.id_tienda' , '=' , 'tbl_cliente.id_tienda');
							})
							->select(
								'tbl_clie_hist_laboral.empresa',
								'tbl_clie_hist_laboral.cargo',
								'tbl_clie_hist_laboral.nombre_jefe_inmediato',
								'tbl_clie_hist_laboral.fecha_ingreso',
								'tbl_clie_hist_laboral.fecha_retiro',
								'tbl_clie_hist_laboral.cantidad_personas_a_cargo',
								'tbl_clie_hist_laboral.ultimo_salario',
								'tbl_clie_hist_laboral.horario_trabajo',
								'tbl_clie_hist_laboral.id_tipo_contrato'
								)
							->where('tbl_cliente.codigo_cliente', $id)
							->where('tbl_cliente.id_tienda', $idTienda)
							->get();
	}

	public static function crearClienteContrato($id_tienda,$codigo_cliente,$data){
		$result=true;
		try{
			\DB::beginTransaction();
			self::ingresarCliente($data,$id_tienda,$codigo_cliente);
			\DB::commit();
		}catch(\Exception $e){
			// dd($e);
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function Create($dataSave){
		$result=true;
		// dd($dataSave);
		try{
			\DB::beginTransaction();
			\DB::table('tbl_cliente')->insert($dataSave);
			// self::ingresarCliente($dataSave['arrayCliente']);		
			// self::ingresarFamiliaresCliente($dataSave['arrayFamiliares'],$dataSave['arrayFamiliaresParientes'],$idTienda);		
			// self::ingresarContactoEmergencia($dataSave['arrayContactoEmergencia'],$dataSave['arrayContactoEmergenciaParientes'],$idTienda);		
			// self::ingresarInformacion($dataSave['arrayHistLaboral'],$dataSave['arrayDiasEstudio'],$dataSave['arrayEstudiosCliente']);
			\DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	private static function ingresarInformacion($arrayHistLaboral,$arrayDiasEstudio,$arrayEstudiosCliente)
	{
		if(!is_null($arrayHistLaboral))    
			\DB::table('tbl_clie_hist_laboral')->insert($arrayHistLaboral);	
		if(!is_null($arrayDiasEstudio))    		
			\DB::table('tbl_clie_dias_estudio')->insert($arrayDiasEstudio);
		if(!is_null($arrayEstudiosCliente))    		
			\DB::table('tbl_clie_estudios')->insert($arrayEstudiosCliente);			
	}

	private static function ingresarCliente($arrayCliente)
	{
		\DB::table('tbl_cliente')->insert($arrayCliente);				
	}

	private static function ingresarFamiliaresCliente($arrayFamiliares,$arrayFamiliaresParientes,$idTienda)
	{
		if(!is_null($arrayFamiliares))
		{
			$cantidad = count($arrayFamiliares);
			$secuencias = SecuenciaTienda::getCodigosSecuencia($idTienda,env('SECUENCIA_TIPO_CODIGO_CLIENTE'),$cantidad);
			$contador = 0;
			if($cantidad != 1)
			{
			 $codigoClienteActual = explode(",", $secuencias[0]->response);			
			}
			else
			{
			 $codigoClienteActual[0] = $secuencias[0]->response;
			}
			foreach ($arrayFamiliares as $key => $value) {
				$arrayFamiliares[$key]['codigo_cliente'] = $codigoClienteActual[$contador];

				$arrayFamiliaresParientes[$key]['codigo_cliente_pariente'] = $codigoClienteActual[$contador];
				$contador++;
			}          
			\DB::table('tbl_cliente')->insert($arrayFamiliares);		
			\DB::table('tbl_clie_pariente')->insert($arrayFamiliaresParientes);		
		}
	}

	private static function ingresarContactoEmergencia($arrayContactoEmergencia,$arrayContactoEmergenciaParientes,$idTienda)
	{
		if(!is_null($arrayContactoEmergencia))
		{
			$cantidad = count($arrayContactoEmergencia);
			$secuencias = SecuenciaTienda::getCodigosSecuencia($idTienda,env('SECUENCIA_TIPO_CODIGO_CLIENTE'),$cantidad);
			$contador = 0;
			if($cantidad != 1)
			{
			 $codigoClienteActual = explode(",", $secuencias[0]->response);			
			}
			else
			{
			 $codigoClienteActual[0] = $secuencias[0]->response;
			}

			foreach ($arrayContactoEmergencia as $key => $value) {
				$arrayContactoEmergencia[$key]['codigo_cliente'] = $codigoClienteActual[$contador];
	
				$arrayContactoEmergenciaParientes[$key]['codigo_cliente_pariente'] = $codigoClienteActual[$contador];
				$contador++;
			}       
			\DB::table('tbl_cliente')->insert($arrayContactoEmergencia);		
			\DB::table('tbl_clie_pariente')->insert($arrayContactoEmergenciaParientes);		   
		}	   
	}

	private static function updateSecuenciaCliente($idTienda,$codigoCliente)
	{
		$codigoCliente++;
		$data = array('codigo_cliente' => $codigoCliente);
		SecuenciaTienda::Update($idTienda,$data);
	}

	public static function Update($codigoCliente,$idTienda,$dataSave){	
		// dd($dataSave);
		$result = true;
		try{
			\DB::beginTransaction();
			self::actualizarClientes($idTienda,$codigoCliente,$dataSave['arrayCliente'],$dataSave['arrayDiasEstudio']);
			self::actualizarFamiliares($idTienda,$codigoCliente,$dataSave['arrayFamiliares'],$dataSave['arrayFamiliaresParientes']);
			self::actualizarContactosEmergencia($idTienda,$codigoCliente,$dataSave['arrayContactoEmergencia'],$dataSave['arrayContactoEmergenciaParientes']);
			self::actualizarEstudiosHistoriaPariente($idTienda,$codigoCliente,$dataSave['arrayEstudiosCliente'],$dataSave['arrayHistLaboral']);
			\DB::commit();
		}catch(\Exception $e){
			// dd($e);
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function actualizarClientes($idTienda,$codigoCliente,$arrayCliente,$arrayDiasEstudio)
	{
		if(isset($arrayCliente['id_tipo_cliente_enviado'])){
			if($arrayCliente['id_tipo_cliente_enviado'] == 1 || $arrayCliente['id_tipo_cliente_enviado'] == 2){
				\DB::table('tbl_clie_empleado')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->delete();	
			}
			unset($arrayCliente['id_tipo_cliente_enviado']);
		}
		\DB::table('tbl_cliente')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->update($arrayCliente);	
		if($arrayDiasEstudio != null){
			\DB::table('tbl_clie_dias_estudio')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->update($arrayDiasEstudio);
		}
	}

	public static function actualizarFamiliares($idTienda,$codigoCliente,$arrayFamiliares,$arrayFamiliaresParientes)
	{
		foreach ($arrayFamiliares as $key => $value) {
			if($arrayFamiliares[$key]['operacion'] == 'A')
			{	
				unset($arrayFamiliares[$key]['operacion']);
				DB::table('tbl_cliente')->where('id_tienda',$idTienda)->where('codigo_cliente',$arrayFamiliares[$key]['codigo_cliente'])->update($arrayFamiliares[$key]);		
				DB::table('tbl_clie_pariente')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->where('codigo_cliente_pariente',$arrayFamiliaresParientes[$key]['codigo_cliente_pariente'])->update($arrayFamiliaresParientes[$key]);
			}
			else if($arrayFamiliares[$key]['operacion'] == 'I')
			{
				unset($arrayFamiliares[$key]['operacion']);
				$arrayFamiliares[$key]['id_tienda'] = $idTienda;
				$arrayFamiliaresParientes[$key]['id_tienda_pariente'] = $idTienda;
				$arrayFamiliares_2 = array($arrayFamiliares[$key]);
				$arrayFamiliaresParientes_2 = array($arrayFamiliaresParientes[$key]);
				self::ingresarFamiliaresCliente($arrayFamiliares_2,$arrayFamiliaresParientes_2,$idTienda);
			}
			else{
			}
		}
		// DB::table('tbl_clie_pariente')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->delete();
	}

	public static function actualizarContactosEmergencia($idTienda,$codigoCliente,$arrayContactos,$arrayContactosParientes)
	{
		foreach ($arrayContactos as $key => $value) {
			if($arrayContactos[$key]['operacion'] == 'A')
			{	
				unset($arrayContactos[$key]['operacion']);
				DB::table('tbl_cliente')->where('id_tienda',$idTienda)->where('codigo_cliente',$arrayContactos[$key]['codigo_cliente'])->update($arrayContactos[$key]);		
				DB::table('tbl_clie_pariente')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->where('codigo_cliente_pariente',$arrayContactosParientes[$key]['codigo_cliente_pariente'])->update($arrayContactosParientes[$key]);
			}
			else if($arrayContactos[$key]['operacion'] == 'I')
			{
				unset($arrayContactos[$key]['operacion']);
				$arrayContactos[$key]['id_tienda'] = $idTienda;
				$arrayContactosParientes[$key]['id_tienda_pariente'] = $idTienda;
				$arrayContactos_2 = array($arrayContactos[$key]);
				$arrayContactosParientes_2 = array($arrayContactosParientes[$key]);
				self::ingresarContactoEmergencia($arrayContactos_2,$arrayContactosParientes_2,$idTienda);
			}
			else{
			}
		}
	}

	public static function actualizarEstudiosHistoriaPariente($idTienda,$codigoCliente,$arrayEstudiosCliente,$arrayHistLaboral)
	{
		\DB::table('tbl_clie_estudios')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->delete();			
		\DB::table('tbl_clie_estudios')->insert($arrayEstudiosCliente);	

		\DB::table('tbl_clie_hist_laboral')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->delete();		
		\DB::table('tbl_clie_hist_laboral')->insert($arrayHistLaboral);	

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

	// Función para el tipo de documento del cliente natural, donde se excluye el tipo de documento nit con el id en base de datos 32
	public static function getTipoDocument(){
		return DB::table('tbl_clie_tipo_documento')
						->select('id','nombre_abreviado','nombre')
						->where('id', '!=' , 32)
						->where('estado',1)
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

	public static function Update2($id,$tienda,$dataSaved){		
		$result="Actualizado";
		try
		{
			ModelCliente::where('codigo_cliente',$id)->where('id_tienda',$tienda)->update($dataSaved);	
		}catch(\Exception $e)
		{
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
		}
		return $result;
	}

	public static function getHuella( $id_tipo_documento, $numero_documento ){
		return ModelCliente::join('tbl_usuario_huella_cola', function($join){
			$join->on('tbl_usuario_huella_cola.id_tipo_documento', '=', 'tbl_cliente.id_tipo_documento');
			$join->on('tbl_usuario_huella_cola.documento', '=', 'tbl_cliente.numero_documento');
		})
		->select('tbl_cliente.id_tienda','tbl_cliente.codigo_cliente','tbl_usuario_huella_cola.huella')
		->where('tbl_cliente.id_tipo_documento', $id_tipo_documento)
		->where('tbl_cliente.numero_documento', $numero_documento)
		->where('tbl_usuario_huella_cola.esta_procesado', '0')
		->first();
	}

	public static function validarVigenciaHuella( $id_tipo_documento, $numero_documento ){
		return ModelHuellaCola::select(
			DB::raw('ABS(TIMESTAMPDIFF(MINUTE, now(), tbl_usuario_huella_cola.fecha)) as minutos_transcurridos')
		)
		->where('tbl_usuario_huella_cola.id_tipo_documento', $id_tipo_documento)
		->where('tbl_usuario_huella_cola.documento', $numero_documento)
		->where('tbl_usuario_huella_cola.esta_procesado', '0')
		->first();
	}

	public static function agregarHuella( $data ){
		

		$result = true;
		try{
			\DB::beginTransaction();
			\DB::table('tbl_usuario_huella')->insert($data);
			\DB::table('tbl_usuario_huella_cola')->where('huella', $data["huella"])->update(['esta_procesado' => 1]);
			\DB::commit();
		}catch(\Exception $e){
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function validarCorreo($correo,$id_tienda)
	{
		return DB::table("tbl_cliente")->where('id_tienda',$id_tienda)
										->where('correo_electronico',$correo)
										->select('correo_electronico')
										->get();
	}

}
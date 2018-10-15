<?php 

namespace app\AccessObject\Nutibara\Clientes\Empleado;

use App\Models\Nutibara\Zona\Zona AS ModelZona;
use App\Models\autenticacion\Usuario AS ModelUsuario;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use App\Models\Nutibara\Ciudad\Ciudad AS ModelCiudad;
use App\Models\Nutibara\Clientes\Cliente AS ModelCliente;
use App\Models\Nutibara\Sociedad\Sociedad AS ModelSociedad;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\Models\Nutibara\Parametros\Parametros AS ModelParametros;
use App\Models\Nutibara\Clientes\Empleado\Empleado AS ModelEmpleado;
use App\Models\Nutibara\SecuenciaTienda\SecuenciaTienda AS ModelSecuenciaTienda;
use App\Models\Nutibara\Clientes\TipoDocumento\TipoDocumento AS ModelTipoDocumento;

use DB;

class Empleado 
{
	public static function EmpleadoWhere($colum, $order,$search){
		return ModelCliente::join('tbl_clie_empleado', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_clie_empleado.codigo_cliente');
								$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_clie_empleado.id_tienda');
							})
							->join('tbl_clie_tipo', function ($join) {
								$join->on('tbl_cliente.id_tipo_cliente' , '=' , 'tbl_clie_tipo.id')
										->where('tbl_clie_tipo.id', '=', '')
										->orWhere('tbl_clie_tipo.id', '=', '2');
										
							})
							->join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')	
							->join('tbl_tienda','tbl_tienda.id','tbl_cliente.id_tienda')	
							->select(
									DB::raw('concat(tbl_cliente.codigo_cliente,"/",tbl_tienda.id) AS DT_RowId'),
									'tbl_cliente.nombres AS nombre',
									'tbl_tienda.nombre AS tienda',
									DB::raw('concat(tbl_cliente.nombres," ",tbl_cliente.primer_apellido) AS nombre_completo'),
									'tbl_clie_tipo_documento.nombre AS tipo_documento',
									'tbl_cliente.numero_documento AS numero_documento',
									'tbl_cliente.telefono_residencia AS telefono',
									'tbl_cliente.direccion_residencia AS direccion',
									'tbl_cliente.correo_electronico AS correo_electronico',
									DB::Raw('IF (tbl_cliente.estado = 1 ,"Activo","Inactivo") AS estado')
									)
							->where(function ($query) use ($search){
									$query->where('tbl_cliente.nombres', 'like', "%".$search['nombre']."%");
							})
							->orderBy($colum, $order)
							->get();
	}

	public static function Empleado($start,$end,$colum,$order){
		
		 return ModelEmpleado::select(
								DB::raw('concat(tbl_cliente.codigo_cliente,"/",tbl_tienda.id) AS DT_RowId'),
								'tbl_cliente.nombres AS nombre',
								'tbl_tienda.nombre AS tienda',
								DB::raw('concat(tbl_cliente.nombres," ",tbl_cliente.primer_apellido) AS nombre_completo'),
								'tbl_clie_tipo_documento.nombre AS tipo_documento',
								'tbl_cliente.numero_documento AS numero_documento',
								'tbl_cliente.telefono_residencia AS telefono',
								'tbl_cliente.direccion_residencia AS direccion',
								'tbl_cliente.correo_electronico AS correo_electronico',
								DB::Raw('IF (tbl_cliente.estado = 1 ,"Activo","Inactivo") AS estado')
							 )
								->where('estado',1)	
								->orderBy($colum, $order)
						        ->get();
	}

	

	public static function getCountEmpleado($estado){
		return ModelEmpleado::join('tbl_cliente', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_clie_empleado.codigo_cliente')
										->where('tbl_cliente.estado', '=', '1');
							})
							->count();
	}

	public static function getEmpleadoIden($identificacion,$tipoDocumento,$idTienda)
	{
		return ModelCliente::join('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
							->select(
							'tbl_cliente.codigo_cliente',
							'tbl_cliente.id_tienda',
							'tbl_cliente.nombres AS nombre',
							DB::raw('CONCAT_WS(" ",tbl_cliente.nombres,tbl_cliente.primer_apellido,tbl_cliente.segundo_apellido) AS nombrecompleto'),							
							'tbl_clie_tipo.nombre AS tipo_cliente',
							'tbl_clie_tipo.id AS id_tipo_cliente'
							)
							->where('tbl_cliente.numero_documento',$identificacion)
							->where('tbl_cliente.id_tipo_documento',$tipoDocumento)	
							->where('tbl_cliente.id_tienda',$idTienda)	
							->where('tbl_cliente.estado',1)	
							->first();
	}

	public static function getproveedorjuridico($identificacion,$digitoVerificacion,$tipoDocumento)
	{
		// 6 = Proveedor Juridico
		return ModelCliente::join('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
							->select(
							'tbl_cliente.codigo_cliente',
							'tbl_cliente.id_tienda',
							'tbl_cliente.nombres AS nombre',
							'tbl_clie_tipo.nombre AS tipo_cliente',
							'tbl_clie_tipo.id AS id_tipo_cliente'
							)
							->where('tbl_cliente.numero_documento',$identificacion)
							->where('tbl_cliente.id_tipo_documento',$tipoDocumento)	
							->where('tbl_cliente.digito_verificacion',$digitoVerificacion)
							->where('tbl_cliente.id_tipo_cliente',6)
							->where('tbl_cliente.estado',1)
							->first();
	}
	public static function getproveedornatural($identificacion,$tipoDocumento)
	{
		//5 = Proveedor Natural
		return ModelCliente::join('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
							->select(
							'tbl_cliente.codigo_cliente',
							'tbl_cliente.id_tienda',
							'tbl_cliente.nombres AS nombre',
							'tbl_clie_tipo.nombre AS tipo_cliente',
							'tbl_clie_tipo.id AS id_tipo_cliente'
							)
							->where('tbl_cliente.numero_documento',$identificacion)
							->where('tbl_cliente.id_tipo_documento',$tipoDocumento)
							->where('tbl_cliente.id_tipo_cliente',5)
							->where('tbl_cliente.estado',1)													
							->first();
	}

	public static function getCombos($id_ciudad){
		return ModelCiudad::join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
						->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						->select(
							'tbl_pais.nombre as nombre_pais',
							'tbl_pais.id as id_pais',
							'tbl_departamento.nombre as nombre_departamento',
							'tbl_departamento.id as id_departamento',
							'tbl_ciudad.nombre as nombre_ciudad',
							'tbl_ciudad.id as id_ciudad'
						)
						->where('tbl_ciudad.id',$id_ciudad)	
						->first();
	}

	public static function getTiendaZona($id_tienda){
		return ModelTienda::join('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
							->select(
							'tbl_ciudad.id AS id_ciudad'
							)
							->where('tbl_tienda.id',$id_tienda)	
							->first();
	}

	public static function getUser($id_usuario){
		return ModelUsuario::select(
							'id',
							'id_role',
							'name',
							'email',
							'modo_ingreso'
							)
							->where('id',$id_usuario)	
							->first();
	}

	public static function getEmpleadoById($id,$idTienda){
		return ModelCliente::leftJoin('tbl_clie_empleado', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_clie_empleado.codigo_cliente');
								$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_clie_empleado.id_tienda');
							})

							->join('tbl_tienda','tbl_cliente.id_tienda','tbl_tienda.id')	
							->leftJoin('tbl_sociedad','tbl_tienda.id_sociedad','tbl_sociedad.id')	
							->leftJoin('tbl_franquicia','tbl_tienda.id_franquicia','tbl_franquicia.id')
							->leftJoin('tbl_usuario', 'tbl_usuario.id','tbl_cliente.id_usuario')
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
							
							->select(
								'tbl_franquicia.id AS franquicia',
								'tbl_cliente.codigo_cliente',
								'tbl_cliente.id_tienda',
								'tbl_sociedad.id AS id_sociedad',
								'tbl_cliente.id_tipo_cliente',
								'tbl_clie_empleado.id_tipo_contrato',
								// 'tbl_pais.id AS id_pais_trabajo', 
								// 'tbl_departamento.id AS id_departamento_trabajo', 
								'tbl_clie_empleado.id_ciudad_trabajo', 
								DB::raw("FORMAT(tbl_clie_empleado.salario,0,'de_DE') as salario"),
								DB::raw("FORMAT(tbl_clie_empleado.valor_auxilio_vivenda,0,'de_DE') as valor_auxilio_vivenda"),
								DB::raw("FORMAT(tbl_clie_empleado.valor_auxilio_transporte,0,'de_DE') as valor_auxilio_transporte"),
								'tbl_clie_empleado.id_cargo_empleado',
								'tbl_clie_empleado.fecha_ingreso',
								'tbl_clie_empleado.ha_laborado_nutibara',
								'tbl_cliente.nombres',
								'tbl_cliente.primer_apellido',
								'tbl_cliente.segundo_apellido',
								'tbl_cliente.id_tipo_documento',
								'tbl_cliente.numero_documento',
								'tbl_cliente.numero_documento',
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
								'tbl_cliente.telefono_residencia',
								'tbl_cliente.telefono_celular',
								'tbl_cliente.barrio_residencia',
								'tbl_cliente.direccion_residencia',
								'tbl_cliente.id_ciudad_residencia',
								'tbl_cliente.correo_electronico',
								'tbl_cliente.id_estado_civil',
								'tbl_cliente.id_tipo_vivienda',
								'tbl_cliente.tenencia_vivienda',
								'tbl_cliente.libreta_militar',
								'tbl_cliente.distrito_militar',
								'tbl_cliente.rh',
								'tbl_clie_empleado.id_cargo_ejercido_anterior',
								'tbl_cliente.id_fondo_cesantias',
								'tbl_cliente.id_fondo_pensiones',
								'tbl_cliente.id_eps',
								'tbl_cliente.genero',
								'tbl_cliente.id_caja_compensacion',
								'tbl_clie_empleado.otros_aportes',
								'tbl_cliente.talla_camisa',
								'tbl_cliente.talla_pantalon',
								'tbl_cliente.talla_zapatos',
								'tbl_clie_empleado.familiares_en_nutibara',
								'tbl_clie_empleado.numero_hijos',
								'tbl_clie_empleado.numero_hermanos',
								'tbl_clie_empleado.total_personas_a_cargo',
								'tbl_clie_empleado.fecha_retiro',
								'tbl_clie_empleado.id_motivo_retiro',
								'tbl_clie_empleado.observacion_novedad',
								'tbl_clie_empleado.id_zona_encargado',
								'tbl_cliente.id_nivel_estudio',
								'tbl_cliente.id_nivel_estudio_actual',
								'tbl_clie_dias_estudio.lunes AS estudio_lunes',
								'tbl_clie_dias_estudio.martes AS estudio_martes',
								'tbl_clie_dias_estudio.miercoles AS estudio_miercoles' ,
								'tbl_clie_dias_estudio.jueves AS estudio_jueves',
								'tbl_clie_dias_estudio.viernes AS estudio_viernes',
								'tbl_clie_dias_estudio.sabado AS estudio_sabado',
								'tbl_clie_dias_estudio.domingo AS estudio_domingo',
								'tbl_usuario.id_role AS id_role',
								'tbl_usuario.modo_ingreso AS modo_ingreso',
								'tbl_cliente.id_usuario'
							)
							->where('tbl_cliente.codigo_cliente', $id)
							->where('tbl_cliente.id_tienda', $idTienda)
							->first();
	}


	public static function getEstudiosById($id,$idTienda){
		return ModelCliente::join('tbl_clie_empleado', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_clie_empleado.codigo_cliente');
								$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_clie_empleado.id_tienda');
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
							->leftJoin('tbl_usuario', 'tbl_usuario.id','tbl_cliente.id_usuario')
							->select(
								'tbl_cliente.codigo_cliente',
								'tbl_cliente.id_tienda',
								'tbl_cliente.id_tipo_cliente',
								'tbl_clie_empleado.id_tipo_contrato',
								DB::raw("FORMAT(tbl_clie_empleado.salario,2,'de_DE') as salario"),
								DB::raw("FORMAT(tbl_clie_empleado.valor_auxilio_vivenda,2,'de_DE') as valor_auxilio_vivenda"),
								DB::raw("FORMAT(tbl_clie_empleado.valor_auxilio_transporte,2,'de_DE') as valor_auxilio_transporte"),
								'tbl_clie_empleado.id_cargo_empleado',
								'tbl_clie_empleado.fecha_ingreso',
								'tbl_cliente.nombres',
								'tbl_cliente.primer_apellido',
								'tbl_cliente.segundo_apellido',
								'tbl_cliente.id_tipo_documento',
								'tbl_cliente.numero_documento',
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
								'tbl_clie_empleado.familiares_en_nutibara',
								'tbl_usuario.id_role AS id_role',
								'tbl_usuario.modo_ingreso AS modo_ingreso',
								'tbl_cliente.id_usuario'
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

	public static function Create($dataSave,$idTienda,$codigoCliente)
	{
		$result=true;
		try{
			DB::beginTransaction();
			$id_usuario = self::ingresarUsuario($dataSave['arrayUsuario']);
			self::ingresarCliente($dataSave['arrayCliente'],$dataSave['arrayEmpleado'],$id_usuario);
			self::ingresarParienteCliente($dataSave['arrayParientesEnNutibara']);
			self::ingresarFamiliaresCliente($dataSave['arrayFamiliares'],$dataSave['arrayFamiliaresParientes'],$idTienda);		
			self::ingresarContactoEmergencia($dataSave['arrayContactoEmergencia'],$dataSave['arrayContactoEmergenciaParientes'],$idTienda);	
			self::ingresarInformacion($dataSave['arrayHistLaboral'],$dataSave['arrayDiasEstudio'],$dataSave['arrayEstudiosEmpleado']);
			self::asociarTiendaPrincipal($idTienda,$codigoCliente,$dataSave['arrayEmpleado']['id_zona_encargado'],$dataSave['arrayCliente']['id_tienda']);			
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;			
			DB::rollback();
		}
		return $result;
	}

	private static function ingresarInformacion($arrayHistLaboral,$arrayDiasEstudio,$arrayEstudiosEmpleado)
	{
		if(!is_null($arrayHistLaboral))   
		DB::table('tbl_clie_hist_laboral')->insert($arrayHistLaboral);	
		if(!is_null($arrayDiasEstudio))  
		DB::table('tbl_clie_dias_estudio')->insert($arrayDiasEstudio);
		if(!is_null($arrayEstudiosEmpleado))    
		DB::table('tbl_clie_estudios')->insert($arrayEstudiosEmpleado);			
	}

	private static function ingresarCliente($arrayCliente,$arrayEmpleado,$id_usuario=NULL)
	{
		$arrayCliente['id_usuario'] = $id_usuario;
		DB::table('tbl_cliente')->insert($arrayCliente);		
		DB::table('tbl_clie_empleado')->insert($arrayEmpleado);	
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
			 $codigoClienteActual = $secuencias[0]->response;
			}
			foreach ($arrayFamiliares as $key => $value) {
				$arrayFamiliares[$key]['codigo_cliente'] = $codigoClienteActual[$contador];

				$arrayFamiliaresParientes[$key]['codigo_cliente_pariente'] = $codigoClienteActual[$contador];
				$contador++;
			}          
			DB::table('tbl_cliente')->insert($arrayFamiliares);		
			DB::table('tbl_clie_pariente')->insert($arrayFamiliaresParientes);		
		}
	}

	private static function ingresarParienteCliente($arrayParientes)
	{       
		if(!is_null($arrayParientes))
		{
			DB::table('tbl_clie_pariente')->insert($arrayParientes);
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
			DB::table('tbl_cliente')->insert($arrayContactoEmergencia);		
			DB::table('tbl_clie_pariente')->insert($arrayContactoEmergenciaParientes);		   
		}	   
	}


	private static function ingresarUsuario($arrayUsuario)
	{
		if(!is_null($arrayUsuario)){
			return DB::table('tbl_usuario')->insertGetId($arrayUsuario);
		}
	}

	public static function updateClientById($id_usuario,$email)
	{
		return DB::table('tbl_usuario')->where('id',$id_usuario)
									   ->update(['email' => $email]);
	}

	public static function Update($codigoCliente,$idTienda,$dataSave){	
		$result = true;
		try{
			DB::beginTransaction();
			self::actualizarClientes($idTienda,$codigoCliente,$dataSave['arrayCliente'],$dataSave['arrayEmpleado'],$dataSave['arrayDiasEstudio']);
			self::actualizarFamiliares($idTienda,$codigoCliente,$dataSave['arrayFamiliares'],$dataSave['arrayFamiliaresParientes']);
			self::actualizarContactosEmergencia($idTienda,$codigoCliente,$dataSave['arrayContactoEmergencia'],$dataSave['arrayContactoEmergenciaParientes']);
			self::actualizarEstudiosHistoriaPariente($idTienda,$codigoCliente,$dataSave['arrayEstudiosEmpleado'],$dataSave['arrayHistLaboral'],$dataSave['arrayParientesEnNutibara']);
			self::asociarTiendaPrincipal($idTienda,$codigoCliente,$dataSave['arrayEmpleado']['id_zona_encargado'],$idTienda);
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;			
			DB::rollback();
		}
		return $result;
	}

	public static function Delete($id,$idTienda,$dataSaved){
		return ModelCliente::where('id_tienda',$idTienda)->where('codigo_cliente',$id)->update($dataSaved);
	}

	public static function actualizarClientes($idTienda,$codigoCliente,$arrayCliente,$arrayEmpleado,$arrayDiasEstudio)
	{
		DB::table('tbl_cliente')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->update($arrayCliente);
		/*Valida si existe registrado como empleado*/
		$existeComoEmpleado =DB::table('tbl_clie_empleado')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->get();
		if(isset($existeComoEmpleado[0]))
		{
		 	DB::table('tbl_clie_empleado')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->update($arrayEmpleado);			
		}
		else
		{
			DB::table('tbl_clie_empleado')->insert($arrayEmpleado);
		}
		DB::table('tbl_clie_dias_estudio')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->update($arrayDiasEstudio);		
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
		if(!is_null($arrayContactos))
		{
			foreach ($arrayContactos as $key => $value) {
			}
		}
	}

	public static function actualizarEstudiosHistoriaPariente($idTienda,$codigoCliente,$arrayEstudiosEmpleado,$arrayHistLaboral,$arrayParientesEnNutibara)
	{
		DB::table('tbl_clie_estudios')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->delete();			
		DB::table('tbl_clie_estudios')->insert($arrayEstudiosEmpleado);	

		DB::table('tbl_clie_hist_laboral')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->delete();		
		DB::table('tbl_clie_hist_laboral')->insert($arrayHistLaboral);	

		DB::table('tbl_clie_pariente')->where('id_tienda',$idTienda)->where('codigo_cliente',$codigoCliente)->where('trabaja_nutibara','1')->delete();			
		self::ingresarParienteCliente($arrayParientesEnNutibara);
	}
	
	public static function asociarTiendaPrincipal($idTienda,$codigoCliente,$zona,$tiendaPrincipal)
	{
		$existe = DB::table('tbl_clie_tienda')->where('id_tienda_cliente',$idTienda)->where('codigo_cliente',$codigoCliente)->get();
		if(!isset($existe[0]))
		{
			DB::table('tbl_clie_tienda')
			->insert(['id_tienda' => $idTienda,'codigo_cliente' => $codigoCliente,'id_tienda_cliente' => $idTienda,'tienda_principal' => 1]);	
		}

		DB::table('tbl_clie_tienda')
			->where('id_tienda_cliente',$idTienda)
			->where('codigo_cliente',$codigoCliente)
			->where('tienda_principal',0)
			->delete();
		//Valida si existe entro una Zona.
		if($zona != null)
		{
			//Borrar Todas las tiendas asociadas que no sean principales
			
			//Tiendas de esa Zona
			$tiendas = DB::table('tbl_tienda')
				->select('id')
				->where('id_zona',$zona)
				->whereNotIn('id',[$tiendaPrincipal])
				->get();
			//Si existen tiendas.
			if(isset($tiendas[0]))
			{
				for ($i=0; $i <count($tiendas) ; $i++) 
				{ 
					$tiendasAsociar[$i]['id_tienda'] = $tiendas[$i]->id;
					$tiendasAsociar[$i]['codigo_cliente'] = $codigoCliente ;
					$tiendasAsociar[$i]['id_tienda_cliente'] = $idTienda ;					
					$tiendasAsociar[$i]['tienda_principal'] = 0 ;			
				}
				DB::table('tbl_clie_tienda')->insert($tiendasAsociar);
			}
		}

	}

	public static function getSelectList($table){
		
		if($table == 'tbl_ciudad')
		{
			return DB::table($table)
								->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
								->join('tbl_parametro_general','tbl_parametro_general.id_pais','tbl_departamento.id_pais')
								->select('tbl_ciudad.id','tbl_ciudad.nombre AS name')
								->where('tbl_ciudad.estado','1')
								->orderBy('tbl_ciudad.nombre','ASC')
								->get();
		}
		else
		{
			return DB::table($table)->select('id','nombre AS name')
			->where('estado','1')
			->orderBy('nombre','ASC')
			->get();
		}
	}

	public static function getSelectListById($table,$filter,$id){
		return DB::table($table)->select('id','nombre AS name')
								->where($filter,$id)
								->where('estado','1')
								->orderBy('nombre','ASC')
								->get();
	}

	public static function getAutoComplete($palabra){
		return ModelCliente::join('tbl_clie_empleado','tbl_cliente.codigo_cliente','tbl_clie_empleado.codigo_cliente')
						->select('tbl_cliente.codigo_cliente','tbl_cliente.id_tienda',
							DB::raw('concat(tbl_cliente.nombres," ",tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido) AS nombre'),
							'tbl_cliente.id_ciudad_trabajo',
							'tbl_clie_empleado.id_cargo_empleado'
						)
						->where('tbl_cliente.nombres','like','%'.$palabra.'%')
						->orWhere('tbl_cliente.primer_apellido','like','%'.$palabra.'%')
						->where('tbl_cliente.estado','1')
						->get();
	}

	public static function updateClientUser($idcliente,$idtienda,$idusuario,$email){
		return ModelCliente::where('codigo_cliente',$idcliente)
							->where('id_tienda',$idtienda)
							->update(['id_usuario' => $idusuario,'correo_electronico' => $email]);
	}

	public static function updateUserClient($idusuario,$email){
		return ModelCliente::where('id_usuario',$idusuario)
							->update(['correo_electronico' => $email]);
	}

	public static function getSociedad($id,$sede_principal){
		return ModelSociedad::join('tbl_tienda','tbl_tienda.id_sociedad','tbl_sociedad.id')
							->join('tbl_secuencia_tienda','tbl_secuencia_tienda.id_tienda','tbl_tienda.id')
							->select('tbl_sociedad.id','tbl_sociedad.nombre AS name')
							->where('tbl_secuencia_tienda.sede_principal',$sede_principal)
							->groupBy('tbl_sociedad.id')
							->groupBy('tbl_sociedad.nombre')
							->get();

	}

	public static function getTienda($id,$sede_principal){
		return ModelTienda::join('tbl_sociedad','tbl_tienda.id_sociedad','tbl_sociedad.id')
							->join('tbl_secuencia_tienda','tbl_secuencia_tienda.id_tienda','tbl_tienda.id')
							->select('tbl_sociedad.id','tbl_sociedad.nombre AS name')
							->where('tbl_secuencia_tienda.sede_principal',$sede_principal)
							->get();

	}

	public static function getparametroGeneral($id){
		return ModelParametros::join('tbl_pais','tbl_pais.id','tbl_parametro_general.id_pais')
							->select('tbl_parametro_general.id','tbl_pais.nombre')
							->where('tbl_parametro_general.id_pais',$id)
							->first();

	}

	public static function getEmail ($name,$idtienda,$codigocliente)
	{
		//Hará la busqueda para el insert.
		if($idtienda == "" && $codigocliente == "")
		{
			return ModelCliente::where('correo_electronico',$name)
			->count();
		}
		//Es necesario no contar el correo que tiene el cliente actualmente para que no tome el que tiene como existente.
		else
		{
			return ModelCliente::where('correo_electronico',$name)
							  ->where('id_tienda','<>',$idtienda)
							  ->where('codigo_cliente','<>',$codigocliente)
							  ->count();
		}
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
	

	public static function getFamiliarN($telefono,$tipo_documento,$numero_documento){
		return ModelCliente::join('tbl_clie_empleado', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_clie_empleado.codigo_cliente');
								$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_clie_empleado.id_tienda');
							})
							->select('tbl_cliente.codigo_cliente',
									'tbl_cliente.id_tienda',
									'tbl_cliente.nombres',
									'tbl_cliente.primer_apellido',
									'tbl_cliente.id_tipo_documento',
									'tbl_cliente.numero_documento',
									'tbl_cliente.fecha_nacimiento',
									'tbl_clie_empleado.id_cargo_empleado',
									'tbl_clie_empleado.id_ciudad_trabajo')
							->where('tbl_cliente.telefono_celular',$telefono)
							->orwhere(function ($query) use ($tipo_documento,$numero_documento) {
								$query->where('tbl_cliente.id_tipo_documento',$tipo_documento)
									  ->where('tbl_cliente.numero_documento',$numero_documento);
							})
							->first();

	}

	public static function getDocumentos()
	{
		return ModelTipoDocumento::select(
									'id',
									'nombre AS name'
									)
									->whereNotIn('nombre',['nit'])
									->get();
	}

	public static function ValidarAdmin($idTienda)
	{
		$datos = DB::table('tbl_clie_empleado')
					->where('id_tienda',$idTienda)
					->where('id_cargo_empleado',5)
					->first();
		if($datos)
			return true;
		else
			return false;
	}

	public static function ValidarJefeZona($idZona)
	{
		$datos = DB::table('tbl_clie_empleado')
					->where('id_zona_encargado',$idZona)
					->first();
		if($datos)
			return true;
		else
			return false;
	}

	public static function CreateAsociate($dataSave,$idTienda,$codigoCliente){
		try{
			DB::beginTransaction();
			$id_usuario = self::ingresarUsuario($dataSave['arrayUsuario']);
			self::ingresarCliente($dataSave['arrayCliente'],$dataSave['arrayEmpleado'],$id_usuario);
			self::ingresarParienteCliente($dataSave['arrayParientesEnNutibara']);
			self::ingresarFamiliaresCliente($dataSave['arrayFamiliares'],$dataSave['arrayFamiliaresParientes'],$idTienda);		
			self::ingresarContactoEmergencia($dataSave['arrayContactoEmergencia'],$dataSave['arrayContactoEmergenciaParientes'],$idTienda);	
			self::ingresarInformacion($dataSave['arrayHistLaboral'],$dataSave['arrayDiasEstudio'],$dataSave['arrayEstudiosEmpleado']);
			self::asociarTiendaPrincipal($idTienda,$codigoCliente,$dataSave['arrayEmpleado']['id_zona_encargado'],$dataSave['arrayCliente']['id_tienda']);		
			$result['id_usuario'] = $dataSave['arrayCliente']['codigo_cliente'];
			$result['id_tienda'] = $idTienda;	
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result['mensaje']='Error al crear el Empleado.';			
			DB::rollback();
		}
		return $result;
	}

}
<?php

namespace App\AccessObject\Nutibara\GestionHumana\Empleado;

use App\Models\Nutibara\Clientes\EstadoCivil\EstadoCivil as ModelEstadoCivil;
use App\Models\Nutibara\Clientes\TenenciaVivienda\TenenciaVivienda as ModelTenenciaVivienda;
use App\Models\Nutibara\Clientes\TipoVivienda\TipoVivienda as ModelTipoVivienda;
use App\Models\Nutibara\Clientes\TipoEstudio\TipoEstudio as ModelTipoEstudio;
use App\Models\Nutibara\Clientes\MotivoRetiro\MotivoRetiro as ModelMotivoRetiro;
use App\Models\Nutibara\Clientes\Empleado\Empleado as ModelEmpleado;
use App\Models\Nutibara\Clientes\TipoDocumento\TipoDocumento as ModelTipoDocumento;
use App\BusinessLogic\Utility\CleanNumberMoney as limpiarCampo;
use dateFormate;

class Reporte
{

    public static function getselectlistEstadoCivil()
    {
        return ModelEstadoCivil::select('id','nombre AS name')
                            ->where('estado','1')
                            ->get();
    }

    public static function getselectlistTenenciaVivienda()
    {
        return ModelTenenciaVivienda::select('id','nombre AS name')
                            ->where('estado','1')
                            ->get();
    }

    public static function getselectlistTipoVivienda()
    {
        return ModelTipoVivienda::select('id','nombre AS name')
                            ->where('estado','1')
                            ->get();
    }

    public static function getselectlistTipoEstudio()
    {
        return ModelTipoEstudio::select('id','nombre AS name')
                            ->where('estado','1')
                            ->get();
    }

    public static function getselectlistMotivoRetiro()
    {
        return ModelMotivoRetiro::select('id','nombre AS name')
                            ->where('estado','1')
                            ->get();
    }

    public static function getselectlistTipoDocumento()
    {
        return ModelTipoDocumento::select('id','nombre_abreviado AS name')
                            ->where('estado','1')
                            ->get();
    }

    public static function getAll()
    {
        $queryString= ModelEmpleado::join('tbl_cliente',function($join){
            $join->on('tbl_cliente.id_tienda','tbl_clie_empleado.id_tienda');
            $join->on('tbl_cliente.codigo_cliente','tbl_clie_empleado.codigo_cliente');
          })
          ->leftJoin('tbl_clie_pariente', function($join){
              $join->on('tbl_clie_pariente.id_tienda','tbl_cliente.id_tienda');
              $join->on('tbl_clie_pariente.codigo_cliente','tbl_cliente.codigo_cliente');
          })
          ->leftJoin('tbl_clie_dias_estudio',function($join){
              $join->on('tbl_clie_dias_estudio.codigo_cliente','tbl_cliente.codigo_cliente');
              $join->on('tbl_clie_dias_estudio.id_tienda','tbl_clie_empleado.id_tienda');
          })
          ->leftJoin('tbl_clie_hist_laboral',function($join){
              $join->on('tbl_clie_hist_laboral.id_tienda','tbl_cliente.id_tienda');
              $join->on('tbl_clie_hist_laboral.codigo_cliente','tbl_cliente.codigo_cliente');
          })
          ->leftJoin('tbl_clie_estudios',function($join){
              $join->on('tbl_clie_estudios.codigo_cliente','tbl_clie_empleado.codigo_cliente');
              $join->on('tbl_clie_estudios.id_tienda','tbl_clie_empleado.id_tienda');
          })
          ->leftJoin('tbl_empl_tipo_contrato',function($join){
              $join->on('tbl_empl_tipo_contrato.id','tbl_clie_empleado.id_tipo_contrato');
              $join->on('tbl_clie_estudios.id_tienda','tbl_clie_empleado.id_tienda');
          })
          ->leftJoin('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
          ->leftJoin('tbl_empl_cargo','tbl_empl_cargo.id','tbl_clie_empleado.id_cargo_empleado')
          ->leftJoin('tbl_ciudad','tbl_ciudad.id','tbl_cliente.id_ciudad_nacimiento')
          ->leftJoin('tbl_clie_estado_civil','tbl_clie_estado_civil.id','tbl_cliente.id_estado_civil')
          ->leftJoin('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
          ->leftJoin('tbl_clie_tipo_vivienda','tbl_clie_tipo_vivienda.id','tbl_cliente.id_tipo_vivienda')
          ->leftJoin('tbl_clie_tenencia_vivienda','tbl_clie_tenencia_vivienda.id','tbl_cliente.tenencia_vivienda')
          ->leftJoin('tbl_empl_motivo_retiro','tbl_empl_motivo_retiro.id','tbl_clie_empleado.id_motivo_retiro')
          ->leftJoin('tbl_pais AS pais_expedicion','pais_expedicion.id','tbl_cliente.id_pais_expedicion')
          ->leftJoin('tbl_departamento AS departamento_expedicion','departamento_expedicion.id','tbl_ciudad.id_departamento')
          ->leftJoin('tbl_ciudad AS ciudad_expedicion','ciudad_expedicion.id','tbl_cliente.id_ciudad_expedicion')
          ->leftJoin('tbl_clie_genero AS genero','genero.id','tbl_cliente.genero')
          ->leftJoin('tbl_pais AS pais_nacimiento','pais_nacimiento.id','tbl_cliente.id_pais_nacimiento')
          ->leftJoin('tbl_departamento AS departamento_nacimiento','departamento_nacimiento.id','tbl_ciudad.id_departamento')
          ->leftJoin('tbl_pais AS pais_residencia','pais_residencia.id','tbl_cliente.id_pais_residencia')
          ->leftJoin('tbl_departamento AS departamento_residencia','departamento_residencia.id','tbl_ciudad.id_departamento')
          ->leftJoin('tbl_ciudad AS ciudad_residencia','ciudad_residencia.id','tbl_cliente.id_ciudad_residencia')
          ->leftJoin('tbl_tipo_rh AS grupo_sanguineo','grupo_sanguineo.id','tbl_cliente.rh')
          ->leftJoin('tbl_tienda AS tienda','tienda.id','tbl_cliente.id_tienda')
          ->leftJoin('tbl_franquicia','tbl_franquicia.id','tienda.id_franquicia')
          ->leftJoin('tbl_sociedad','tbl_sociedad.id','tienda.id_sociedad')
          ->leftJoin('tbl_ciudad AS ciudad_trabajo','ciudad_trabajo.id','tbl_cliente.id_ciudad_trabajo')
          ->leftJoin('tbl_tallas AS camisa','camisa.id','tbl_cliente.talla_camisa')
          ->leftJoin('tbl_tallas AS pantalon','pantalon.id','tbl_cliente.talla_pantalon')
          ->leftJoin('tbl_tallas AS zapatos','zapatos.id','tbl_cliente.talla_zapatos')
          ->leftJoin('tbl_clie_fondo_cesantias AS cesantias','cesantias.id','tbl_cliente.id_fondo_cesantias')
          ->leftJoin('tbl_clie_fondo_pensiones AS pensiones','pensiones.id','tbl_cliente.id_fondo_pensiones')
          ->leftJoin('tbl_clie_eps AS eps','eps.id','tbl_cliente.id_eps')
          ->leftJoin('tbl_clie_caja_compensacion AS compensacion','compensacion.id','tbl_cliente.id_caja_compensacion')
          ->leftJoin('tbl_empl_tipo_contrato AS contrato_anterior','contrato_anterior.id','tbl_clie_hist_laboral.id_tipo_contrato')
          ->leftJoin('tbl_empl_motivo_retiro AS motivoR_anterior','motivoR_anterior.id','tbl_clie_empleado.id_motivo_retiro')
          ->select(
                      'tbl_cliente.codigo_cliente AS id_cliente',
                      'tbl_clie_tipo_documento.nombre_abreviado AS tipo_documento',
                      'tbl_cliente.numero_documento AS cedula',
                      'tbl_cliente.fecha_expedicion AS fecha_expedicion',
                      'pais_expedicion.nombre AS nombre_pais_expedicion',
                      'departamento_expedicion.nombre AS departamento_expedicion',
                      'ciudad_expedicion.nombre AS ciudad_expedicion',
                      'tbl_cliente.nombres',
                      \DB::raw('CONCAT(tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido) as apellidos'),
                      'genero.nombre AS genero',
                      'tbl_cliente.fecha_nacimiento AS fechaNacimiento',
                      \DB::raw('TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) AS Edad '),
                      'pais_nacimiento.nombre AS pais_nacimiento',
                      'departamento_nacimiento.nombre AS departamento_nacimiento',
                      'tbl_ciudad.id AS id_ciudad',
                      'tbl_ciudad.nombre AS ciudad_nacimiento',
                      'pais_residencia.nombre AS pais_residencia',
                      'departamento_residencia.nombre AS departamento_residencia',
                      'ciudad_residencia.nombre as ciudad_residencia',
                      'tbl_cliente.direccion_residencia AS direccion_residencia',
                      'tbl_cliente.barrio_residencia AS barrio_residencia',
                      'tbl_cliente.telefono_residencia AS telefono_residencia',
                      'tbl_cliente.telefono_celular AS celular',
                      'grupo_sanguineo.nombre AS grupo_sanguineo',
                      'tbl_clie_estado_civil.nombre AS estado_civil',
                      'tbl_cliente.correo_electronico AS correo',
                      'tbl_cliente.libreta_militar AS libreta_militar',
                      'tbl_cliente.distrito_militar AS distrito_militar',
                      'tbl_clie_tipo_vivienda.nombre AS tipo_vivienda',
                      'tbl_cliente.tenencia_vivienda AS tenencia_vivienda',
                      'tbl_clie_tenencia_vivienda.nombre AS nombre_Vivienda',
                      'camisa.nombre AS talla_camisa',
                      'pantalon.nombre AS talla_pantalon',
                      'zapatos.nombre AS talla_zapatos',
                      'tbl_clie_tipo.nombre AS tipo_cliente',
                      'tbl_franquicia.nombre AS nombre_comercial',
                      'tbl_sociedad.nombre AS sociedad',
                      'tienda.nombre AS id_tienda',
                      'tbl_empl_cargo.nombre AS cargo',
                      'ciudad_trabajo.nombre AS ciudad_trabajo',
                      'tbl_empl_tipo_contrato.nombre AS tipo_contrato',
                      'tbl_clie_empleado.fecha_ingreso',
                      'tbl_clie_empleado.salario',
                      'tbl_clie_empleado.valor_auxilio_vivenda AS valor_auxilio_vivenda',
                      'tbl_clie_empleado.valor_auxilio_transporte AS auxilio_transporte',
                      'cesantias.nombre AS fondo_cesantias',
                      'pensiones.nombre AS fondo_pensiones',
                      'eps.nombre AS eps',
                      'compensacion.nombre AS caja_compensacion',
                      'tbl_clie_pariente.id_tipo_parentesco AS tipo_pariente',
                      'tbl_clie_pariente.id_tienda_pariente AS tienda_pariente',
                      'tbl_clie_pariente.codigo_cliente_pariente AS codigo_cliente_pariente',
                      'tbl_clie_pariente.trabaja_nutibara AS trabaja_nutibara',
                      'tbl_clie_empleado.familiares_en_nutibara',
                      'tbl_cliente.beneficiario AS bedeficiario_eps',
                      'tbl_cliente.ocupacion AS ocupacion_actual',
                      'tbl_cliente.grado_escolaridad AS grado_escolaridad',
                      'tbl_cliente.ano_o_semestre AS año_o_semestre',
                      'tbl_clie_pariente.a_cargo_persona_familiares AS persona_a_cargo',
                      'tbl_clie_pariente.vive_con_persona_familiares AS vive_con_ella',
                      'tbl_cliente.id_nivel_estudio AS estudio_actual',
                      'tbl_clie_pariente.contacto_emergencia AS contacto_emergencia',
                      \DB::raw('group_concat(tbl_clie_estudios.nombre SEPARATOR " / ") as nombre'),
                      'tbl_clie_estudios.anos_cursados AS años_cursados',
                      \DB::raw('group_concat(tbl_clie_estudios.fecha_inicio SEPARATOR " / ") as fecha_inicio'),
                      \DB::raw('group_concat(tbl_clie_estudios.fecha_terminacion SEPARATOR " / ") as fecha_terminacion'),
                      'tbl_clie_estudios.institucion AS institucion',
                      'tbl_clie_estudios.titulo_obtenido AS titulo_obtenido',
                      \DB::raw('group_concat(tbl_clie_estudios.finalizado SEPARATOR " / ") as finalizado'),
                      'tbl_clie_dias_estudio.lunes AS lunes',
                      'tbl_clie_dias_estudio.martes AS martes',
                      'tbl_clie_dias_estudio.miercoles AS miercoles',
                      'tbl_clie_dias_estudio.jueves AS jueves',
                      'tbl_clie_dias_estudio.viernes AS viernes',
                      'tbl_clie_dias_estudio.sabado AS sabado',
                      'tbl_clie_dias_estudio.domingo AS domingo',
                      'tbl_clie_hist_laboral.empresa AS Empresa_anterior',
                      'tbl_clie_hist_laboral.cargo AS  Cargo_anterior',
                      'tbl_clie_hist_laboral.nombre_jefe_inmediato AS jefe_anterior',
                      'tbl_clie_hist_laboral.fecha_ingreso AS fecha_ingreso_empleo_anetrior',
                      'tbl_clie_hist_laboral.fecha_retiro AS fecha_retiro_empleo_anetrior',
                      'tbl_clie_hist_laboral.cantidad_personas_a_cargo AS personas_a_cargo_empleo_anterior',
                      'tbl_clie_hist_laboral.ultimo_salario AS ultimo_salario',
                      'tbl_clie_hist_laboral.horario_trabajo AS horario_trabajo_anterior',
                      'contrato_anterior.nombre AS tipo_contrato_anterior',
                      'motivoR_anterior.nombre AS retiradoM',
                      'tbl_clie_empleado.fecha_retiro',
                      'tbl_empl_motivo_retiro.nombre AS motivo_retiro',
                      'tbl_clie_empleado.observacion_novedad AS observaciones',
                      \DB::raw('(SELECT COUNT(tbl_clie_pariente.id_tienda) FROM tbl_clie_pariente WHERE tbl_clie_pariente.id_tienda = tbl_cliente.id_tienda AND tbl_clie_pariente.codigo_cliente = tbl_cliente.codigo_cliente AND a_cargo_persona_familiares = 1) AS total_personas_a_cargo'),
                      \DB::raw('(SELECT COUNT(tbl_clie_pariente.id_tienda) FROM tbl_clie_pariente WHERE tbl_clie_pariente.id_tienda = tbl_cliente.id_tienda AND tbl_clie_pariente.codigo_cliente = tbl_cliente.codigo_cliente AND id_tipo_parentesco = '.env("ID_TIPO_PARENTESCO").') AS numero_hijos'),
                      'tbl_clie_empleado.familiares_en_nutibara'
                  )
                  ->where('tbl_clie_tipo.id_tipo_persona', '=', 2);
                  //retornamos el resultado
                  return $queryString->orderBy('tbl_cliente.nombres', 'ASC')->distinct()
                                     ->groupBy('tbl_cliente.id_tienda')
                                     ->groupBy('tbl_cliente.codigo_cliente')
                                     ->groupBy('tbl_empl_cargo.nombre')
                                     ->groupBy('tbl_empl_motivo_retiro.nombre')
                                     ->groupBy('tbl_clie_empleado.id_motivo_retiro')
                                     ->groupBy('tbl_clie_empleado.valor_auxilio_transporte')
                                     ->groupBy('tbl_clie_empleado.salario')
                                     ->groupBy('tbl_clie_empleado.fecha_ingreso')
                                     ->groupBy('tbl_clie_empleado.fecha_retiro')
                                     ->groupBy('tbl_clie_empleado.familiares_en_nutibara')
                                     ->get();
    }

    public static function getAllFull($dataQuery)
    {
        //dd($dataQuery);
        $queryString= ModelEmpleado::join('tbl_cliente',function($join){
            $join->on('tbl_cliente.id_tienda','tbl_clie_empleado.id_tienda');
            $join->on('tbl_cliente.codigo_cliente','tbl_clie_empleado.codigo_cliente');
          })
          ->leftJoin('tbl_clie_pariente', function($join){
              $join->on('tbl_clie_pariente.id_tienda','tbl_cliente.id_tienda');
              $join->on('tbl_clie_pariente.codigo_cliente','tbl_cliente.codigo_cliente');
          })
          ->leftJoin('tbl_clie_dias_estudio',function($join){
              $join->on('tbl_clie_dias_estudio.codigo_cliente','tbl_cliente.codigo_cliente');
              $join->on('tbl_clie_dias_estudio.id_tienda','tbl_clie_empleado.id_tienda');
          })
          ->leftJoin('tbl_clie_hist_laboral',function($join){
              $join->on('tbl_clie_hist_laboral.id_tienda','tbl_cliente.id_tienda');
              $join->on('tbl_clie_hist_laboral.codigo_cliente','tbl_cliente.codigo_cliente');
          })
          ->leftJoin('tbl_clie_estudios',function($join){
              $join->on('tbl_clie_estudios.codigo_cliente','tbl_clie_empleado.codigo_cliente');
              $join->on('tbl_clie_estudios.id_tienda','tbl_clie_empleado.id_tienda');
          })
          ->leftJoin('tbl_empl_tipo_contrato',function($join){
              $join->on('tbl_empl_tipo_contrato.id','tbl_clie_empleado.id_tipo_contrato');
              $join->on('tbl_clie_estudios.id_tienda','tbl_clie_empleado.id_tienda');
          })
          ->leftJoin('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
          ->leftJoin('tbl_empl_cargo','tbl_empl_cargo.id','tbl_clie_empleado.id_cargo_empleado')
          ->leftJoin('tbl_ciudad','tbl_ciudad.id','tbl_cliente.id_ciudad_nacimiento')
          ->leftJoin('tbl_clie_estado_civil','tbl_clie_estado_civil.id','tbl_cliente.id_estado_civil')
          ->leftJoin('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
          ->leftJoin('tbl_clie_tipo_vivienda','tbl_clie_tipo_vivienda.id','tbl_cliente.id_tipo_vivienda')
          ->leftJoin('tbl_clie_tenencia_vivienda','tbl_clie_tenencia_vivienda.id','tbl_cliente.tenencia_vivienda')
          ->leftJoin('tbl_empl_motivo_retiro','tbl_empl_motivo_retiro.id','tbl_clie_empleado.id_motivo_retiro')
          ->leftJoin('tbl_pais AS pais_expedicion','pais_expedicion.id','tbl_cliente.id_pais_expedicion')
          ->leftJoin('tbl_departamento AS departamento_expedicion','departamento_expedicion.id','tbl_ciudad.id_departamento')
          ->leftJoin('tbl_ciudad AS ciudad_expedicion','ciudad_expedicion.id','tbl_cliente.id_ciudad_expedicion')
          ->leftJoin('tbl_clie_genero AS genero','genero.id','tbl_cliente.genero')
          ->leftJoin('tbl_pais AS pais_nacimiento','pais_nacimiento.id','tbl_cliente.id_pais_nacimiento')
          ->leftJoin('tbl_departamento AS departamento_nacimiento','departamento_nacimiento.id','tbl_ciudad.id_departamento')
          ->leftJoin('tbl_pais AS pais_residencia','pais_residencia.id','tbl_cliente.id_pais_residencia')
          ->leftJoin('tbl_departamento AS departamento_residencia','departamento_residencia.id','tbl_ciudad.id_departamento')
          ->leftJoin('tbl_ciudad AS ciudad_residencia','ciudad_residencia.id','tbl_cliente.id_ciudad_residencia')
          ->leftJoin('tbl_tipo_rh AS grupo_sanguineo','grupo_sanguineo.id','tbl_cliente.rh')
          ->leftJoin('tbl_tienda AS tienda','tienda.id','tbl_cliente.id_tienda')
          ->leftJoin('tbl_franquicia','tbl_franquicia.id','tienda.id_franquicia')
          ->leftJoin('tbl_sociedad','tbl_sociedad.id','tienda.id_sociedad')
          ->leftJoin('tbl_ciudad AS ciudad_trabajo','ciudad_trabajo.id','tbl_cliente.id_ciudad_trabajo')
          ->leftJoin('tbl_tallas AS camisa','camisa.id','tbl_cliente.talla_camisa')
          ->leftJoin('tbl_tallas AS pantalon','pantalon.id','tbl_cliente.talla_pantalon')
          ->leftJoin('tbl_tallas AS zapatos','zapatos.id','tbl_cliente.talla_zapatos')
          ->leftJoin('tbl_clie_fondo_cesantias AS cesantias','cesantias.id','tbl_cliente.id_fondo_cesantias')
          ->leftJoin('tbl_clie_fondo_pensiones AS pensiones','pensiones.id','tbl_cliente.id_fondo_pensiones')
          ->leftJoin('tbl_clie_eps AS eps','eps.id','tbl_cliente.id_eps')
          ->leftJoin('tbl_clie_caja_compensacion AS compensacion','compensacion.id','tbl_cliente.id_caja_compensacion')
          ->leftJoin('tbl_empl_tipo_contrato AS contrato_anterior','contrato_anterior.id','tbl_clie_hist_laboral.id_tipo_contrato')
          ->leftJoin('tbl_empl_motivo_retiro AS motivoR_anterior','motivoR_anterior.id','tbl_clie_empleado.id_motivo_retiro')
          ->select(
                      'tbl_cliente.codigo_cliente AS id_cliente',
                      'tbl_clie_tipo_documento.nombre_abreviado AS tipo_documento',
                      'tbl_cliente.numero_documento AS cedula',
                      'tbl_cliente.fecha_expedicion AS fecha_expedicion',
                      'pais_expedicion.nombre AS nombre_pais_expedicion',
                      'departamento_expedicion.nombre AS departamento_expedicion',
                      'ciudad_expedicion.nombre AS ciudad_expedicion',
                      'tbl_cliente.nombres',
                      \DB::raw('CONCAT(tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido) as apellidos'),
                      'genero.nombre AS genero',
                      'tbl_cliente.fecha_nacimiento AS fechaNacimiento',
                      \DB::raw('TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) AS Edad '),
                      'pais_nacimiento.nombre AS pais_nacimiento',
                      'departamento_nacimiento.nombre AS departamento_nacimiento',
                      'tbl_ciudad.nombre AS ciudad_nacimiento',
                      'pais_residencia.nombre AS pais_residencia',
                      'departamento_residencia.nombre AS departamento_residencia',
                      'ciudad_residencia.nombre as ciudad_residencia',
                      'tbl_cliente.direccion_residencia AS direccion_residencia',
                      'tbl_cliente.barrio_residencia AS barrio_residencia',
                      'tbl_cliente.telefono_residencia AS telefono_residencia',
                      'tbl_cliente.telefono_celular AS celular',
                      'grupo_sanguineo.nombre AS grupo_sanguineo',
                      'tbl_clie_estado_civil.nombre AS estado_civil',
                      'tbl_cliente.correo_electronico AS correo',
                      'tbl_cliente.libreta_militar AS libreta_militar',
                      'tbl_cliente.distrito_militar AS distrito_militar',
                      'tbl_clie_tipo_vivienda.nombre AS tipo_vivienda',
                      'tbl_cliente.tenencia_vivienda AS tenencia_vivienda',
                      'tbl_clie_tenencia_vivienda.nombre AS nombre_Vivienda',
                      'camisa.nombre AS talla_camisa',
                      'pantalon.nombre AS talla_pantalon',
                      'zapatos.nombre AS talla_zapatos',
                      'tbl_clie_tipo.nombre AS tipo_cliente',
                      'tbl_franquicia.nombre AS nombre_comercial',
                      'tbl_sociedad.nombre AS sociedad',
                      'tienda.id AS id_tienda',
                      'tienda.nombre AS nombre_tienda',
                      'tbl_empl_cargo.nombre AS cargo',
                      'ciudad_trabajo.nombre AS ciudad_trabajo',
                      'tbl_empl_tipo_contrato.nombre AS tipo_contrato',
                      'tbl_clie_empleado.fecha_ingreso',
                      'tbl_clie_empleado.salario',
                      'tbl_clie_empleado.valor_auxilio_vivenda AS valor_auxilio_vivenda',
                      'tbl_clie_empleado.valor_auxilio_transporte AS auxilio_transporte',
                      'cesantias.nombre AS fondo_cesantias',
                      'pensiones.nombre AS fondo_pensiones',
                      'eps.nombre AS eps',
                      'compensacion.nombre AS caja_compensacion',
                      'tbl_clie_pariente.id_tipo_parentesco AS tipo_pariente',
                      'tbl_clie_pariente.id_tienda_pariente AS tienda_pariente',
                      'tbl_clie_pariente.codigo_cliente_pariente AS codigo_cliente_pariente',
                      'tbl_clie_pariente.trabaja_nutibara AS trabaja_nutibara',
                      'tbl_clie_empleado.familiares_en_nutibara',
                      'tbl_cliente.beneficiario AS bedeficiario_eps',
                      'tbl_cliente.ocupacion AS ocupacion_actual',
                      'tbl_cliente.grado_escolaridad AS grado_escolaridad',
                      'tbl_cliente.ano_o_semestre AS año_o_semestre',
                      'tbl_clie_pariente.a_cargo_persona_familiares AS persona_a_cargo',
                      'tbl_clie_pariente.vive_con_persona_familiares AS vive_con_ella',
                      'tbl_cliente.id_nivel_estudio AS estudio_actual',
                      'tbl_clie_pariente.contacto_emergencia AS contacto_emergencia',
                      \DB::raw('group_concat(tbl_clie_estudios.nombre SEPARATOR " / ") as nombre'),
                      'tbl_clie_estudios.anos_cursados AS años_cursados',
                      \DB::raw('group_concat(tbl_clie_estudios.fecha_inicio SEPARATOR " / ") as fecha_inicio'),
                      \DB::raw('group_concat(tbl_clie_estudios.fecha_terminacion SEPARATOR " / ") as fecha_terminacion'),
                      'tbl_clie_estudios.institucion AS institucion',
                      'tbl_clie_estudios.titulo_obtenido AS titulo_obtenido',
                      \DB::raw('group_concat(tbl_clie_estudios.finalizado SEPARATOR " / ") as finalizado'),
                      'tbl_clie_dias_estudio.lunes AS lunes',
                      'tbl_clie_dias_estudio.martes AS martes',
                      'tbl_clie_dias_estudio.miercoles AS miercoles',
                      'tbl_clie_dias_estudio.jueves AS jueves',
                      'tbl_clie_dias_estudio.viernes AS viernes',
                      'tbl_clie_dias_estudio.sabado AS sabado',
                      'tbl_clie_dias_estudio.domingo AS domingo',
                      'tbl_clie_hist_laboral.empresa AS Empresa_anterior',
                      'tbl_clie_hist_laboral.cargo AS  Cargo_anterior',
                      'tbl_clie_hist_laboral.nombre_jefe_inmediato AS jefe_anterior',
                      'tbl_clie_hist_laboral.fecha_ingreso AS fecha_ingreso_empleo_anetrior',
                      'tbl_clie_hist_laboral.fecha_retiro AS fecha_retiro_empleo_anetrior',
                      'tbl_clie_hist_laboral.cantidad_personas_a_cargo AS personas_a_cargo_empleo_anterior',
                      'tbl_clie_hist_laboral.ultimo_salario AS ultimo_salario',
                      'tbl_clie_hist_laboral.horario_trabajo AS horario_trabajo_anterior',
                      'contrato_anterior.nombre AS tipo_contrato_anterior',
                      'motivoR_anterior.nombre AS retiradoM',
                      'tbl_clie_empleado.fecha_retiro',
                      'tbl_empl_motivo_retiro.nombre AS motivo_retiro',
                      'tbl_clie_empleado.observacion_novedad AS observaciones',
                      \DB::raw('(SELECT COUNT(tbl_clie_pariente.id_tienda) FROM tbl_clie_pariente WHERE tbl_clie_pariente.id_tienda = tbl_cliente.id_tienda AND tbl_clie_pariente.codigo_cliente = tbl_cliente.codigo_cliente AND a_cargo_persona_familiares = 1) AS total_personas_a_cargo'),
                      \DB::raw('(SELECT COUNT(tbl_clie_pariente.id_tienda) FROM tbl_clie_pariente WHERE tbl_clie_pariente.id_tienda = tbl_cliente.id_tienda AND tbl_clie_pariente.codigo_cliente = tbl_cliente.codigo_cliente AND id_tipo_parentesco = '.env("ID_TIPO_PARENTESCO").') AS numero_hijos'),
                      'tbl_clie_empleado.familiares_en_nutibara'
                     )->where(function ($query) use ($dataQuery){
                                if(!empty($dataQuery['nombre'])){
                                    $query->where('tbl_cliente.nombres', 'like', '%'.$dataQuery['nombre'].'%');
                                }
                                if(!empty($dataQuery['tipoCedula'])){
                                    $query->where('tbl_cliente.id_tipo_documento', '=', $dataQuery['tipoCedula']);
                                }
                                if(!empty($dataQuery['cedula'])){
                                    $query->where('tbl_cliente.numero_documento', '=', $dataQuery['cedula']);
                                }
                                if(!empty($dataQuery['estadoCivil'])){
                                    $query->where('tbl_clie_estado_civil.id', '=', $dataQuery['estadoCivil']);
                                }
                                if(!empty($dataQuery['tipoVivienda'])){
                                    $query->where('tbl_clie_tipo_vivienda.id','=', $dataQuery['tipoVivienda']);
                                }
                                if(!empty($dataQuery['primerApellido'])){
                                    $query->where('tbl_cliente.primer_apellido', '=', trim($dataQuery['primerApellido']));
                                }
                                if(!empty($dataQuery['segundoApellido'])){
                                    $query->where('tbl_cliente.segundo_apellido', '=', trim($dataQuery['segundoApellido']));
                                }
                            })
                            ->where('tbl_clie_tipo.id_tipo_persona', '=', 2);
                            //Número de hijos  -Se modifica por -Sebastian Orozco                        
                            if(!empty($dataQuery['hijosMin']) && !empty($dataQuery['hijosMax'])){
                                $hijos=$queryString->having('numero_hijos', '>=', $dataQuery['hijosMin'])
                                                   ->having('numero_hijos', '<=', $dataQuery['hijosMax']);
                                $queryString=$hijos;
                            }else if(empty($dataQuery['hijosMin']) && !empty($dataQuery['hijosMax']) ){
                                $hijos=$queryString->having('numero_hijos','<=',$dataQuery['hijosMax'])
                                                   ->having('numero_hijos', '<=', $dataQuery['hijosMax']);
                                $queryString=$hijos;
                            }else if(!empty($dataQuery['hijosMin']) && empty($dataQuery['hijosMax'])){
                                    $hijos=$queryString->having('numero_hijos', '>=', $dataQuery['hijosMin']);
                                    $queryString=$hijos;
                            }
                            // Personas familiares a cargo -Se modifica por Sebastian Orozco
                            if(!empty($dataQuery['personasCargoMin']) && !empty($dataQuery['personasCargoMax'])){
                                    $personasC=$queryString->having('total_personas_a_cargo','>=',$dataQuery['personasCargoMin'])
                                                           ->having('total_personas_a_cargo','<=',$dataQuery['personasCargoMax']);
                                    $queryString=$personasC;
                            }else if(empty($dataQuery['personasCargoMin']) && !empty($dataQuery['personasCargoMax'])){
                                $personasC=$queryString->having('total_personas_a_cargo','<=',$dataQuery['personasCargoMax']);
                                $queryString=$personasC;
                            }else if(!empty($dataQuery['personasCargoMin']) && empty($dataQuery['personasCargoMax'])){
                                $personasC=$queryString->having('total_personas_a_cargo','>=',$dataQuery['personasCargoMin']);
                                $queryString=$personasC;
                            }
                            //Familiares que trabajan en nutibara (familiares_en_nutibara)datos(1 o 2) -Se modifica por Sebastian Orozco                           
                            if($dataQuery['familiaEmpresa']=='1' ){//si en base de datos = 1
                                $trabajaNut=$queryString->where('familiares_en_nutibara', $dataQuery['familiaEmpresa']);
                                $queryString=$trabajaNut;
                            }else if($dataQuery['familiaEmpresa']=='2' ){//no en base de datos = 0
                                $trabajaNut=$queryString->where('familiares_en_nutibara',  0);
                                $queryString=$trabajaNut;
                            }
                            //Que tenencia de vivienda tiene -Se modifica por Sebastian Orozco
                            if($dataQuery['tenenciaVivienda']=='1'){// propia en base de datos = 1
                                $tenenciaVi=$queryString->where('tenencia_vivienda', $dataQuery['tenenciaVivienda']);
                                $queryString=$tenenciaVi;
                            }else if($dataQuery['tenenciaVivienda']=='2'){// alquilada en base de datos = 2
                                $tenenciaVi=$queryString->where('tenencia_vivienda',2);
                                $queryString=$tenenciaVi;
                            }
                            // Filtro estado estudio -Se modifica por Sebastian Orozco
                            if($dataQuery['estadoEstudio']=='1'){//terminado en base de datos = 3
                                $estadoEstud=$queryString->where('finalizado',  3);
                                $queryString=$estadoEstud;
                            }else if($dataQuery['estadoEstudio']=='2'){//suspendido en base de datos = 2
                                $estadoEstud=$queryString->where('finalizado',  2);
                                $queryString=$estadoEstud;
                            }else if($dataQuery['estadoEstudio']=='3'){//cursando en base de datos = 1
                                $estadoEstud=$queryString->where('finalizado',  1);
                                $queryString=$estadoEstud;
                            }
                            //Filtro fecha estudio -Se modifica por -Sebastian Orozco
                            if(!empty($dataQuery['fechaEstudioMin']) && !empty($dataQuery['fechaEstudioMax'])){
                                $fechaEstudio=$queryString->having('fecha_inicio','>=',dateFormate::ToFormat($dataQuery['fechaEstudioMin']))
                                                          ->having('fecha_terminacion','<=',dateFormate::ToFormat($dataQuery['fechaEstudioMax']));
                                $queryString=$fechaEstudio;
                            }else if(!empty($dataQuery['fechaEstudioMin']) && empty($dataQuery['fechaEstudioMax'])){
                                $fechaEstudio=$queryString->having('fecha_inicio','>=',dateFormate::ToFormat($dataQuery['fechaEstudioMin']));
                                $queryString=$fechaEstudio;
                            }else if(empty($dataQuery['fechaEstudioMin']) && !empty($dataQuery['fechaEstudioMax'])){
                                $fechaEstudio=$queryString->having('fecha_terminacion','<=',dateFormate::ToFormat($dataQuery['fechaEstudioMax']));
                                $queryString=$fechaEstudio;
                            }
                            //Filtro tipo de estudio -Se modifica por Sebastian Orozco
                            if(!empty($dataQuery['tipoEstudio'])){
                                $tipoEstudio=$queryString->where('tbl_clie_estudios.nombre','like', '%'.$dataQuery['tipoEstudio'].'%');
                                $queryString=$tipoEstudio;
                            }
                            //Filtro cargo -Se modifica por Sebastian Orozco
                            if(!empty($dataQuery['cargo'])){
                                $cargo=$queryString->where('cargo','like', '%'.$dataQuery['cargo'].'%');
                                $queryString=$cargo;
                            }
                            //Filtro salario -Se modifica por Sebastian Orozco
                            if(!empty($dataQuery['salarioMin']) && !empty($dataQuery['salarioMax'])){
                                $salario=$queryString->having('tbl_clie_empleado.salario','>=',limpiarCampo::Get($dataQuery['salarioMin']))
                                                     ->having('tbl_clie_empleado.salario','<=',limpiarCampo::Get($dataQuery['salarioMax']));
                                $queryString=$salario;
                            }else if(!empty($dataQuery['salarioMin']) && empty($dataQuery['salarioMax'])){
                                $salario=$queryString->having('tbl_clie_empleado.salario','>=',limpiarCampo::Get($dataQuery['salarioMin']));
                                $queryString=$salario;
                            }else if(empty($dataQuery['salarioMin']) && !empty($dataQuery['salarioMax'])){
                                $salario=$queryString->having('tbl_clie_empleado.salario','>=',0)
                                                     ->having('tbl_clie_empleado.salario','<=',limpiarCampo::Get($dataQuery['salarioMax']));
                                $queryString=$salario;
                            }
                            //Filtro retiro -Se modifica por Sebastian Orozco
                            if($dataQuery['retirado']=='0'){
                                $retiro=$queryString->where('tbl_clie_empleado.id_motivo_retiro','<>','');
                                $queryString=$retiro;
                            }
                            //Filtro fecha retiro -Se modifica por Sebastian Orozco
                            if(!empty($dataQuery['fechaRetiroMin']) && !empty($dataQuery['fechaRetiroMax'])){
                                $Fecharetiro=$queryString->whereBetween('tbl_clie_empleado.fecha_retiro',dateFormate::ToArray([$dataQuery['fechaRetiroMin'],$dataQuery['fechaRetiroMax']]));
                                $queryString=$Fecharetiro;
                            }else if(!empty($dataQuery['fechaRetiroMin']) && empty($dataQuery['fechaRetiroMax'])){
                                $Fecharetiro=$queryString->having('tbl_clie_empleado.fecha_retiro','>=',dateFormate::ToFormat($dataQuery['fechaRetiroMin']));
                                $queryString=$Fecharetiro;
                            }else if(empty($dataQuery['fechaRetiroMin']) && !empty($dataQuery['fechaRetiroMax'])){
                                $Fecharetiro=$queryString->having('tbl_clie_empleado.fecha_retiro','<=',dateFormate::ToFormat($dataQuery['fechaRetiroMax']));
                                $queryString=$Fecharetiro;
                            }
                            //Filtro motivo retiro -Se modifica por Sebastian Orozco
                            if(!empty($dataQuery['motivoRetiro']) && $dataQuery['retirado']=='0'){// terminacion de contrato -> 0 es si está retirado
                                $motivoRetiro=$queryString->having('tbl_clie_empleado.id_motivo_retiro','=',$dataQuery['motivoRetiro']);
                                $queryString=$motivoRetiro;
                            }
                            //Filto auxilio transporte -Se modifica por Sebastian Orozco
                            if($dataQuery['auxilioTransporte']=='1'){// si tiene auxilio de transporte
                                $transporte=$queryString->where('tbl_clie_empleado.valor_auxilio_transporte','<>',0);
                                $queryString=$transporte;
                            }else if($dataQuery['auxilioTransporte']=='2'){// si no tiene auxilio de transporte
                                $transporte=$queryString->where('tbl_clie_empleado.valor_auxilio_transporte',0);
                                $queryString=$transporte;
                            }
                            //Filtro rango de edad -Se modifica por Sebastian Orozco
                            if(!empty($dataQuery['rangoEdadMin']) && !empty($dataQuery['rangoEdadMax'])){
                                $edad=$queryString->having('Edad','>=',$dataQuery['rangoEdadMin'])
                                                  ->having('Edad','<=',$dataQuery['rangoEdadMax']);
                                $queryString=$edad;
                            }else if(!empty($dataQuery['rangoEdadMin']) && empty($dataQuery['rangoEdadMax'])){
                                $edad=$queryString->having('Edad','>=',$dataQuery['rangoEdadMin']);
                                $queryString=$edad;
                            }else if(empty($dataQuery['rangoEdadMin']) && !empty($dataQuery['rangoEdadMax'])){
                                $edad=$queryString->having('Edad','<=',$dataQuery['rangoEdadMax']);
                                $queryString=$edad;
                            }
                            //retornamos el resultado
                            return $queryString->orderBy('tbl_cliente.nombres', 'ASC')->distinct()
                                               ->groupBy('tbl_cliente.id_tienda')
                                               ->groupBy('tbl_cliente.codigo_cliente')
                                               ->groupBy('tbl_empl_cargo.nombre')
                                               ->groupBy('tbl_empl_motivo_retiro.nombre')
                                               ->groupBy('tbl_clie_empleado.id_motivo_retiro')
                                               ->groupBy('tbl_clie_empleado.valor_auxilio_transporte')
                                               ->groupBy('tbl_clie_empleado.salario')
                                               ->groupBy('tbl_clie_empleado.fecha_ingreso')
                                               ->groupBy('tbl_clie_empleado.fecha_retiro')
                                               ->groupBy('tbl_clie_empleado.familiares_en_nutibara')
                                               ->get();
    }

    public static function getInfoChildren($id_tienda,$id_cliente,$name_employee,$last_name_employee,$isAll=false)
    {
        $queryString=ModelEmpleado::leftJoin('tbl_clie_pariente',function($joinGet){
                                    $joinGet->on('tbl_clie_pariente.id_tienda','=','tbl_clie_empleado.id_tienda');
                                    $joinGet->on('tbl_clie_pariente.codigo_cliente','=','tbl_clie_empleado.codigo_cliente');//join con AND
                                })
                                ->leftJoin('tbl_cliente',function($joinGet){
                                    $joinGet->on('tbl_cliente.id_tienda','=','tbl_clie_pariente.id_tienda_pariente');
                                    $joinGet->on('tbl_cliente.codigo_cliente','=','tbl_clie_pariente.codigo_cliente_pariente');//join con AND
                                })
                                ->leftJoin('tbl_ciudad','tbl_ciudad.id','=','tbl_cliente.id_ciudad_nacimiento')
                                ->select(
                                    \DB::raw('"'.$name_employee.'" AS name_employee'),
                                    \DB::raw('"'.$last_name_employee.'" AS last_name_employee'),
                                    'tbl_cliente.nombres AS name_son',
                                    \DB::raw('CONCAT(tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido) AS last_name_son'),
                                    'tbl_cliente.fecha_nacimiento',
                                    \DB::raw('IF(tbl_ciudad.nombre IS NULL, "No registra", tbl_ciudad.nombre) as ciudad'));
        if($isAll){
            $response=$queryString->get();
        }else {
            $response=$queryString->where('tbl_clie_empleado.id_tienda', '=', $id_tienda)
                                    ->where('tbl_clie_empleado.codigo_cliente', '=', $id_cliente)
                                    ->where('tbl_clie_pariente.id_tipo_parentesco', '=', env("ID_TIPO_PARENTESCO"))
                                    ->get();
        }
        return $response;                                
    }
    
    public static function getInfoDependents($id_tienda,$id_cliente,$name_employee,$last_name_employee,$isAll=false)
    {    
        $queryString= ModelEmpleado::leftJoin('tbl_clie_pariente',function($joinGet){
                                $joinGet->on('tbl_clie_pariente.id_tienda','=','tbl_clie_empleado.id_tienda');
                                $joinGet->on('tbl_clie_pariente.codigo_cliente','=','tbl_clie_empleado.codigo_cliente');//join con AND
                            })
                            ->leftJoin('tbl_cliente',function($joinGet){
                                $joinGet->on('tbl_cliente.id_tienda','=','tbl_clie_pariente.id_tienda_pariente');
                                $joinGet->on('tbl_cliente.codigo_cliente','=','tbl_clie_pariente.codigo_cliente_pariente');//join con AND
                            })
                            ->leftJoin('tbl_ciudad','tbl_ciudad.id','=','tbl_cliente.id_ciudad_nacimiento')
                            ->leftJoin('tbl_clie_tipo_parentesco','tbl_clie_tipo_parentesco.id','=','tbl_clie_pariente.id_tipo_parentesco')
                            ->select(
                                \DB::raw('"'.$name_employee.'" AS name_employee'),
                                \DB::raw('"'.$last_name_employee.'" AS last_name_employee'),
                                'tbl_cliente.nombres AS name_dependents',
                                \DB::raw('CONCAT(tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido) AS last_name_dependents'),
                                'tbl_cliente.fecha_nacimiento',
                                \DB::raw('IF(tbl_ciudad.nombre IS NULL, "No registra", tbl_ciudad.nombre) as ciudad'),
                                'tbl_clie_tipo_parentesco.nombre AS parentesco'
                            );
        if($isAll){
             $response=$queryString->get();
        }else {                   
            $response=$queryString->where('tbl_clie_empleado.id_tienda', '=', $id_tienda)
                                    ->where('tbl_clie_empleado.codigo_cliente', '=', $id_cliente)
                                    ->where('tbl_clie_pariente.a_cargo_persona_familiares', '=', '1')
                                    ->get();
            }
        return $response;
    }

    public static function getInfoNutiFamily($id_tienda,$id_cliente,$name_employee,$last_name_employee,$isAll=false)
    {    
        $queryString=ModelEmpleado::join('tbl_clie_pariente',function($joinGet){ 
                                        $joinGet->on('tbl_clie_pariente.id_tienda','=','tbl_clie_empleado.id_tienda');
                                        $joinGet->on('tbl_clie_pariente.codigo_cliente','=','tbl_clie_empleado.codigo_cliente');//join con AND
                                    })
                                    ->join('tbl_cliente',function($joinGet){
                                        $joinGet->on('tbl_cliente.id_tienda','=','tbl_clie_pariente.id_tienda_pariente');
                                        $joinGet->on('tbl_cliente.codigo_cliente','=','tbl_clie_pariente.codigo_cliente_pariente');//join con AND
                                    })
                                    ->leftJoin('tbl_ciudad','tbl_ciudad.id','=','tbl_cliente.id_ciudad_nacimiento')
                                    ->join('tbl_clie_tipo_parentesco','tbl_clie_tipo_parentesco.id','=','tbl_clie_pariente.id_tipo_parentesco')
                                    ->select(
                                        \DB::raw('"'.$name_employee.'" AS name_employee'),
                                        \DB::raw('"'.$last_name_employee.'" AS last_name_employee'),
                                        'tbl_cliente.nombres AS name_nutyFamily',
                                        \DB::raw('CONCAT(tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido) AS last_name_nutyFamily'),
                                        'tbl_cliente.fecha_nacimiento',
                                        'tbl_ciudad.nombre AS ciudad',
                                        'tbl_clie_tipo_parentesco.nombre AS parentesco'
                                    );
        if($isAll){
            $response=$queryString->get();
        }else {
            $response=$queryString->where('tbl_clie_empleado.id_tienda', '=', $id_tienda)
                                    ->where('tbl_clie_empleado.codigo_cliente', '=', $id_cliente)
                                    ->where('tbl_clie_pariente.trabaja_nutibara', '=', '1')
                                    ->get();
        }
        return $response;
    }
}

?>
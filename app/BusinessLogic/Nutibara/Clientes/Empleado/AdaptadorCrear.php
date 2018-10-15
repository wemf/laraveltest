<?php

namespace App\BusinessLogic\Nutibara\Clientes\Empleado;

use Illuminate\Support\Str;

class AdaptadorCrear {

    private $request;
    private $codigo_cliente;
    private $id_tienda;
    private $array = array();
    private $arrayUsuario = NULL;
    private $arrayCliente = NULL;
    private $arrayEmpleado = NULL;
    private $arrayFamiliares = NULL;
    private $arrayHistLaboral = NULL;
    private $arrayDiasEstudio = NULL;
    private $arrayEstudiosEmpleado = NULL;
    private $arrayContactoEmergencia = NULL;
    private $arrayFamiliaresParientes = NULL;
    private $arrayParientesEnNutibara = NULL; 
    private $arrayContactoEmergenciaParientes = NULL;

    public function __construct($request,$codigo_cliente,$id_tienda)
    {
        $this->request = $request;
        $this->codigo_cliente = $codigo_cliente;
        $this->id_tienda = $id_tienda;
    }
    
    public function returnArray()
    {
        $this->arrayCliente = [

            /** ****************
            ***	Primera Pantalla
            *** ***************/
            'codigo_cliente' => $this->codigo_cliente,
            'id_tienda' => $this->id_tienda,
            'id_tipo_documento' => $this->request->id_tipo_documento,        
            'id_tipo_cliente' => $this->request->id_tipo_cliente,    
            'numero_documento' => $this->request->numero_documento,
            'fecha_expedicion' => $this->request->fecha_expedicion,
            'id_pais_expedicion' => $this->request->id_pais_expedicion,
            'id_ciudad_expedicion' => $this->request->id_ciudad_expedicion,
            'genero' => $this->request->genero,
            'nombres' => $this->request->nombres,
            'primer_apellido' => $this->request->primer_apellido,
            'segundo_apellido' => $this->request->segundo_apellido,
            'fecha_nacimiento' => $this->request->fecha_nacimiento,
            'id_pais_nacimiento' => $this->request->id_pais_nacimiento,
            'id_ciudad_nacimiento' => $this->request->id_ciudad_nacimiento,
            'id_ciudad_residencia' => $this->request->id_ciudad_residencia,
            'barrio_residencia' => $this->request->barrio_residencia,            
            'direccion_residencia' => $this->request->direccion_residencia,
            'telefono_residencia' => $this->request->telefono_residencia,
            'id_estado_civil' => $this->request->id_estado_civil,            
            'telefono_celular' => $this->request->telefono_celular,
            'id_ciudad_trabajo' => $this->request->id_ciudad_trabajo,            
            'id_nivel_estudio' => $this->request->nivel_estudio_empleado,
            'id_nivel_estudio_actual' => $this->request->nivel_estudio_empleado_actual,
            'correo_electronico' => $this->request->correo_electronico,
            'libreta_militar' => $this->request->libreta_militar,
            'distrito_militar' => $this->request->distrito_militar,
            'id_tipo_vivienda' => $this->request->id_tipo_vivienda,
            'id_fondo_cesantias' => $this->request->id_fondo_cesantias,
            'id_usuario' => '',
            'talla_zapatos' => $this->request->talla_zapatos,
            'talla_pantalon' => $this->request->talla_pantalon,
            'talla_camisa' => $this->request->talla_camisa,
            'id_caja_compensacion' => $this->request->id_caja_compensacion,
            'id_eps' => $this->request->id_eps,
            'tenencia_vivienda' => $this->request->tenencia_vivienda,
            'id_fondo_pensiones' => $this->request->id_fondo_pensiones,
            'rh' => $this->request->rh,

            'estado' => 1
        ];

        $this->arrayDiasEstudio = [
            'codigo_cliente' => $this->codigo_cliente,
            'id_tienda' => $this->id_tienda,
            'lunes' => (int)$this->request->estudio_lunes_empleado,
            'martes' => (int)$this->request->estudio_martes_empleado,
            'miercoles' => (int)$this->request->estudio_miercoles_empleado,
            'jueves' => (int)$this->request->estudio_jueves_empleado,
            'viernes' => (int)$this->request->estudio_viernes_empleado,
            'sabado' => (int)$this->request->estudio_sabado_empleado,
            'domingo' => (int)$this->request->estudio_domingo_empleado,
        ];
        
            /** ****************
            ***	Segunda Pantalla
            *** ***************/
    
        $this->arrayEmpleado = [
            'id_tienda' => $this->id_tienda,            
            'codigo_cliente' => $this->codigo_cliente,
            'id_cargo_empleado' => $this->request->id_cargo_empleado,
            'id_zona_encargado' => $this->request->id_zona_cargo,
            //Ha laborado en nutibara (No existe).            
            'id_ciudad_trabajo' => $this->request->id_ciudad_trabajo,            
            'id_tipo_contrato' => $this->request->id_contrato,
            'id_motivo_retiro' => $this->request->id_motivo_retiro,
            'fecha_ingreso' => $this->request->fecha_ingreso,
            'fecha_retiro' => $this->request->fecha_retiro,
            'observacion_novedad' => $this->request->observacion_novedad,            
            'salario' => $this->limpiarVal($this->request->id_salario),
            //id_cargo_ejercido aterior (No Existe).
            'valor_auxilio_vivenda' => $this->limpiarVal($this->request->id_valor_auxilio_vivenda),
            'valor_auxilio_transporte' => $this->limpiarVal($this->request->id_valor_auxilio_transporte),
            'otros_aportes' => $this->request->otros_aportes,
            'familiares_en_nutibara' => (int)$this->request->familiares_en_nutibara,
            'numero_hijos' => $this->request->numero_hijos_empleado,//No calcula el numero de Hijos por arreglar (Reparar...)
            'numero_hermanos' => $this->request->numero_hermanos_empleado,//No calcula el numero de Hermanos por arreglar (Reparar...)
            'total_personas_a_cargo' => $this->request->total_a_cargo_empleado,//No calcula el Total de personas a cargo por arreglar (Reparar...)
        ];
        //Valida que no ingrese null el valor de Auxilio de vivienda.
        if($this->arrayEmpleado['valor_auxilio_vivenda'] == null)
        {
            $this->arrayEmpleado['valor_auxilio_vivenda'] = 0;
        }
        //Valida que no ingrese null el valor de Auxlio de transporte.
        if($this->arrayEmpleado['valor_auxilio_transporte'] == null)
        {
            $this->arrayEmpleado['valor_auxilio_transporte'] = 0;
        }

        if(!is_null($this->request->id_tienda_pariente) || !is_null($this->request->nombre_parientes))
        {
            foreach ($this->request->id_tienda_pariente as $key => $value) {
                /*Array dirigido a la tabla de Clientes*/
                if(is_null($this->request->nombre_parientes[$key]) && is_null($this->request->nombre_parientes[$key]))
                {
                    continue;
                }
                $this->arrayParientesEnNutibara[$key]['id_tienda'] = $this->id_tienda;
                $this->arrayParientesEnNutibara[$key]['id_tienda_pariente'] = $this->request->id_tienda_pariente[$key];
                $this->arrayParientesEnNutibara[$key]['codigo_cliente'] = $this->codigo_cliente;
                $this->arrayParientesEnNutibara[$key]['codigo_cliente_pariente'] = $this->request->codigo_cliente_pariente[$key];
                $this->arrayParientesEnNutibara[$key]['id_tipo_parentesco'] = $this->request->id_tipo_parentesco[$key];
                $this->arrayParientesEnNutibara[$key]['id_cargo'] = $this->request->id_cargo_pariente[$key];
                $this->arrayParientesEnNutibara[$key]['trabaja_nutibara'] = 1;
            }
        }
        
        
        /** ****************
        ***	Tercera Pantalla
        *** ***************/
        if(!is_null($this->request->nombres_completos_familiares))
        {
            foreach ($this->request->nombres_completos_familiares as $key => $value) {
                /*Array dirigido a la tabla de Clientes*/
                if(is_null($this->request->nombres_completos_familiares[$key]))
                {
                    continue;
                }
                $this->arrayFamiliares[$key]['nombres'] = $this->request->nombres_completos_familiares[$key];
                $this->arrayFamiliares[$key]['id_tipo_documento'] = $this->request->id_tipo_documento_familiares[$key];
                $this->arrayFamiliares[$key]['numero_documento'] = $this->request->identificacion_familiares[$key];
                $this->arrayFamiliares[$key]['fecha_nacimiento'] = $this->request->fecha_nacimiento_familiares[$key];
                $this->arrayFamiliares[$key]['genero'] = $this->request->id_genero_familiares[$key];             
                $this->arrayFamiliares[$key]['beneficiario'] = $this->request->hd_beneficiario[$key];                    
                $this->arrayFamiliares[$key]['ocupacion'] = $this->request->ocupacion_familiares[$key];
                $this->arrayFamiliares[$key]['grado_escolaridad'] = $this->request->grado_escolaridad_familiares[$key];
                $this->arrayFamiliares[$key]['id_nivel_estudio'] = $this->request->id_nivel_estudio_familiares[$key];
                $this->arrayFamiliares[$key]['ano_o_semestre'] = $this->request->semestre_familiares[$key];
                $this->arrayFamiliares[$key]['id_tienda'] = $this->id_tienda; 
                $this->arrayFamiliares[$key]['estado'] = 1; 
               
                // PASAR CHECKBOX A RADIO

                /*Array dirigido a la tabla de Parientes*/
                $this->arrayFamiliaresParientes[$key]['id_tipo_parentesco'] = $this->request->id_parentesco_familiares[$key]; 
                $this->arrayFamiliaresParientes[$key]['id_tienda'] = $this->id_tienda; 
                $this->arrayFamiliaresParientes[$key]['id_tienda_pariente'] = $this->id_tienda; 
                $this->arrayFamiliaresParientes[$key]['codigo_cliente'] = $this->codigo_cliente; 
                $this->arrayFamiliaresParientes[$key]['vive_con_persona_familiares'] = $this->request->hd_vive_con_persona_familiares[$key];
                $this->arrayFamiliaresParientes[$key]['a_cargo_persona_familiares'] = $this->request->hd_a_cargo_persona_familiares[$key];
            }
        }

        if(!is_null($this->request->nombre_emergencia))
        {
            foreach ($this->request->nombre_emergencia as $key => $value) {
                /*Array dirigido a la tabla de Clientes*/
                if(is_null($this->request->nombre_emergencia[$key]))
                {
                    continue;
                }
                $this->arrayContactoEmergencia[$key]['id_tienda'] = $this->id_tienda;
                $this->arrayContactoEmergencia[$key]['id_tipo_documento'] = $this->request->id_tipo_documento_emergencia[$key];
                $this->arrayContactoEmergencia[$key]['numero_documento'] = $this->request->identificacion_emergencia[$key];
                $this->arrayContactoEmergencia[$key]['nombres'] = $this->request->nombre_emergencia[$key];
                $this->arrayContactoEmergencia[$key]['primer_apellido'] = $this->request->primer_apellido_emergencia[$key];
                $this->arrayContactoEmergencia[$key]['segundo_apellido'] = $this->request->segundo_apellido_emergencia[$key];
                $this->arrayContactoEmergencia[$key]['direccion_residencia'] = $this->request->direccion_emergencia[$key];
                $this->arrayContactoEmergencia[$key]['telefono_residencia'] = $this->request->telefono_emergencia[$key];
                $this->arrayContactoEmergencia[$key]['id_ciudad_residencia'] = $this->request->ciudad_emergencia[$key];
                $this->arrayContactoEmergencia[$key]['estado'] = 1; 

                /*Array dirigido a la tabla de Parientes*/
                $this->arrayContactoEmergenciaParientes[$key]['id_tipo_parentesco'] =  $this->request->parentesco_emergencia[$key];
                $this->arrayContactoEmergenciaParientes[$key]['id_tienda'] = $this->id_tienda; 
                $this->arrayContactoEmergenciaParientes[$key]['id_tienda_pariente'] = $this->id_tienda; 
                $this->arrayContactoEmergenciaParientes[$key]['codigo_cliente'] = $this->codigo_cliente; 
                $this->arrayContactoEmergenciaParientes[$key]['contacto_emergencia'] = 1;  
            }
        }

        if(!is_null($this->request->nombre_estudios))
        {
            foreach ($this->request->nombre_estudios as $key => $value) {
                /*Array dirigido a la tabla de Estudios del Cliente*/
                if(is_null($this->request->nombre_estudios[$key]))
                {
                    continue;
                }
                $this->arrayEstudiosEmpleado[$key]['codigo_cliente'] = $this->codigo_cliente;
                $this->arrayEstudiosEmpleado[$key]['id_tienda'] = $this->id_tienda;
                $this->arrayEstudiosEmpleado[$key]['nombre'] = $this->request->nombre_estudios[$key];
                $this->arrayEstudiosEmpleado[$key]['anos_cursados'] = $this->request->anos_cursados_estudios[$key];
                $this->arrayEstudiosEmpleado[$key]['fecha_inicio'] = $this->request->fecha_inicio_estudios[$key];
                $this->arrayEstudiosEmpleado[$key]['fecha_terminacion'] = $this->request->fecha_terminacion_estudios[$key];
                $this->arrayEstudiosEmpleado[$key]['institucion'] = $this->request->institucion_estudios[$key];
                $this->arrayEstudiosEmpleado[$key]['titulo_obtenido'] = $this->request->titulo_obtenido_estudios[$key];
                $this->arrayEstudiosEmpleado[$key]['finalizado'] = $this->request->finalizado_estudios[$key];
            }
        }

        /** ****************
        ***	Cuarta Pantalla
        *** ***************/
        if(!is_null($this->request->empresa_hist_laboral))
        {
            foreach ($this->request->empresa_hist_laboral as $key => $value) {
                /*Array dirigido a la tabla de Historial Laboral del Cliente*/
                if(is_null($this->request->empresa_hist_laboral[$key]))
                {
                    continue;
                }
                $this->arrayHistLaboral[$key]['codigo_cliente'] = $this->codigo_cliente;
                $this->arrayHistLaboral[$key]['id_tienda'] = $this->id_tienda;
                $this->arrayHistLaboral[$key]['empresa'] = $this->request->empresa_hist_laboral[$key];
                $this->arrayHistLaboral[$key]['cargo'] = $this->request->cargo_hist_laboral[$key];
                $this->arrayHistLaboral[$key]['nombre_jefe_inmediato'] = $this->request->nombre_jefe_hist_laboral[$key];
                $this->arrayHistLaboral[$key]['fecha_ingreso'] = $this->request->fecha_ingreso_hist_laboral[$key];
                $this->arrayHistLaboral[$key]['fecha_retiro'] = $this->request->fecha_retiro_hist_laboral[$key];
                $this->arrayHistLaboral[$key]['cantidad_personas_a_cargo'] = $this->request->personas_a_cargo_hist_laboral[$key];
                $this->arrayHistLaboral[$key]['ultimo_salario'] = $this->request->ultimo_salario_hist_laboral[$key];
                $this->arrayHistLaboral[$key]['horario_trabajo'] = $this->request->horario_trabajo_hist_laboral[$key];
                $this->arrayHistLaboral[$key]['id_tipo_contrato'] = $this->request->tipo_contrato_hist_laboral[$key];
            }
        }

        if(!is_null($this->request->name_crear_usuario) && !is_null($this->request->id_role_crear_usuario) && !is_null($this->request->email_crear_usuario) && !is_null($this->request->modo_ingreso_crear_usuario))
        {
            $this->arrayUsuario['name'] = $this->request->name_crear_usuario;
            $this->arrayUsuario['email'] = $this->request->email_crear_usuario;
            $this->arrayUsuario['id_role'] = $this->request->id_role_crear_usuario;
            $this->arrayUsuario['password'] = bcrypt(Str::random(15));
            $this->arrayUsuario['modo_ingreso'] = $this->request->modo_ingreso_crear_usuario;
            $this->arrayUsuario['created_at'] = date("Y-m-d H:i:s");
            $this->arrayUsuario['estado'] = 1;
        }

        $this->array = array(
            'arrayCliente' => $this->arrayCliente,
            'arrayParientesEnNutibara' => $this->arrayParientesEnNutibara,
            'arrayEmpleado' => $this->arrayEmpleado,
            'arrayFamiliares' => $this->arrayFamiliares,
            'arrayFamiliaresParientes' => $this->arrayFamiliaresParientes,
            'arrayContactoEmergencia' => $this->arrayContactoEmergencia,  
            'arrayContactoEmergenciaParientes' => $this->arrayContactoEmergenciaParientes,  
            'arrayEstudiosEmpleado' => $this->arrayEstudiosEmpleado,
            'arrayHistLaboral' => $this->arrayHistLaboral,
            'arrayDiasEstudio' => $this->arrayDiasEstudio,
            'arrayUsuario' => $this->arrayUsuario,
        );

        return $this->array;
    }
    
    public function limpiarVal($val)
	{
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}

}
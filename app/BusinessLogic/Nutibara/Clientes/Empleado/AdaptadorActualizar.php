<?php 

namespace App\BusinessLogic\Nutibara\Clientes\Empleado;
use App\AccessObject\Nutibara\Clientes\Empleado\Empleado;
use config\messages;

class AdaptadorActualizar {
    
    public static function getEmpleadoById($id,$idTienda)
    {
        $array = array();
        $array['familiar'] = array();
        $array['familiar_nutibara'] = array();
        $array['contacto_emergencia'] = array();
        $array['datosGenerales'] = Empleado::getEmpleadoById($id,$idTienda);
        $array['estudios'] = Empleado::getEstudiosById($id,$idTienda);
        $array['hist_laboral'] = Empleado::getHistorialLaboralById($id,$idTienda);
        $cantidadParientes = Empleado::getParientesById($id,$idTienda);
        $i = 0;
        $j = 0;
        $k = 0;
        foreach ($cantidadParientes as $key => $value) { 
            $persona = Empleado::getClienteById($value->codigo_cliente_pariente,$value->id_tienda_pariente);
            if($value->trabaja_nutibara > 0)
            { 
            // dd('Labora');
                $array['familiar_nutibara'][$i]['codigo_cliente_pariente'] = $value->codigo_cliente_pariente;
                $array['familiar_nutibara'][$i]['id_tienda_pariente'] = $value->id_tienda_pariente;
                $array['familiar_nutibara'][$i]['id_tipo_documento'] = $persona->id_tipo_documento;
                $array['familiar_nutibara'][$i]['numero_documento'] = $persona->numero_documento;
                $array['familiar_nutibara'][$i]['nombre'] = $persona->nombres;
                $array['familiar_nutibara'][$i]['fecha_nacimiento'] = $persona->fecha_nacimiento;
                $array['familiar_nutibara'][$i]['id_tipo_parentesco'] = $value->id_tipo_parentesco;
                $array['familiar_nutibara'][$i]['id_cargo_empleado'] = $persona->id_cargo_empleado;
                $array['familiar_nutibara'][$i]['id_ciudad_residencia'] = $persona->id_ciudad_residencia;
                $i++;
            }
            elseif($value->contacto_emergencia > 0)
            {
                // dd('emergencia');
                $array['contacto_emergencia'][$j]['codigo_cliente'] = $value->codigo_cliente_pariente;
                $array['contacto_emergencia'][$j]['id_tienda'] = $value->id_tienda_pariente;
                $array['contacto_emergencia'][$j]['id_tipo_documento'] = $persona->id_tipo_documento;
                $array['contacto_emergencia'][$j]['numero_documento'] = $persona->numero_documento;
                $array['contacto_emergencia'][$j]['nombre'] = $persona->nombres;
                $array['contacto_emergencia'][$j]['primer_apellido'] = $persona->primer_apellido;
                $array['contacto_emergencia'][$j]['segundo_apellido'] = $persona->segundo_apellido;
                $array['contacto_emergencia'][$j]['id_tipo_parentesco'] = $value->id_tipo_parentesco;
                $array['contacto_emergencia'][$j]['direccion_residencia'] = $persona->direccion_residencia;
                $array['contacto_emergencia'][$j]['id_ciudad_residencia'] = $persona->id_ciudad_residencia;
                $array['contacto_emergencia'][$j]['telefono_residencia'] = $persona->telefono_residencia;
                $j++;
            }
            else
            {
                // dd($persona);
                $array['familiar'][$k]['codigo_cliente'] = $value->codigo_cliente_pariente;
                $array['familiar'][$k]['id_tienda'] = $value->id_tienda_pariente;
                $array['familiar'][$k]['id_tipo_documento'] = $persona->id_tipo_documento;
                $array['familiar'][$k]['numero_documento'] = $persona->numero_documento;
                $array['familiar'][$k]['nombre'] = $persona->nombres;
                $array['familiar'][$k]['id_tipo_parentesco'] = $value->id_tipo_parentesco;
                $array['familiar'][$k]['fecha_nacimiento'] = $persona->fecha_nacimiento;
                $array['familiar'][$k]['genero'] = $persona->genero;
                $array['familiar'][$k]['beneficiario'] = $persona->beneficiario;
                $array['familiar'][$k]['ocupacion'] = $persona->ocupacion;
                $array['familiar'][$k]['grado_escolaridad'] = $persona->grado_escolaridad;
                $array['familiar'][$k]['id_nivel_estudio'] = $persona->id_nivel_estudio;
                $array['familiar'][$k]['semestre'] = $persona->ano_o_semestre;
                $array['familiar'][$k]['vive_con_persona_familiares'] = $value->vive_con_persona_familiares;
                $array['familiar'][$k]['a_cargo_persona_familiares'] = $value->a_cargo_persona_familiares;
                $k++;
            }
        }
        return $array; 
    }

    public function ordenarDatos($request,$codigoCliente,$id_tienda)
    {
        $dataSave = $this->returnArray($request,$codigoCliente,$id_tienda);
        $var = Empleado::updateClientById($request->id_usuario,$request->correo_electronico);
        $msm=['msm'=>Messages::$Empleado['update_ok'],'val'=>true];
		if(!Empleado::Update($codigoCliente,$id_tienda,$dataSave))
        {
			$msm=['msm'=>Messages::$Empleado['update_error'],'val'=>false];
        }
		return $msm;
    }

    public function returnArray($request,$codigo_cliente,$id_tienda)
    {
        $arrayCliente = array();
        $arrayParientesEnNutibara = array();
        $arrayEmpleado = array();
        $arrayFamiliares = array();
        $arrayFamiliaresParientes = array();
        $arrayContactoEmergencia = array();
        $arrayContactoEmergenciaParientes = array();
        $arrayEstudiosEmpleado = array();
        $arrayHistLaboral = array();
        $arrayDiasEstudio = array();

        $arrayCliente = [
            /** ****************
            ***	Primera Pantalla
            *** ***************/            
            // 'codigo_cliente' => $codigo_cliente,
            // 'id_tienda' => $id_tienda,
            'nombres' => $request->nombres,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'id_tipo_documento' => $request->id_tipo_documento,
            'numero_documento' => $request->numero_documento,
            'fecha_expedicion' => $request->fecha_expedicion,
            'id_pais_expedicion' => $request->id_pais_expedicion,
            'id_ciudad_expedicion' => $request->id_ciudad_expedicion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'id_pais_nacimiento' => $request->id_pais_nacimiento,
            'id_ciudad_nacimiento' => $request->id_ciudad_nacimiento,
            'direccion_residencia' => $request->direccion_residencia,
            'id_ciudad_residencia' => $request->id_ciudad_residencia,
            'barrio_residencia' => $request->barrio_residencia,
            'telefono_residencia' => $request->telefono_residencia,
            'telefono_celular' => $request->telefono_celular,
            'correo_electronico' => $request->correo_electronico,
            'id_estado_civil' => $request->id_estado_civil,
            'id_tipo_vivienda' => $request->id_tipo_vivienda,
            'tenencia_vivienda' => $request->id_tenencia_vivienda,
            'libreta_militar' => $request->libreta_militar,
            'distrito_militar' => $request->distrito_militar,
            'id_fondo_cesantias' => $request->id_fondo_cesantias,
            'id_fondo_pensiones' => $request->id_fondo_pensiones,
            'id_eps' => $request->id_eps,
            'id_caja_compensacion' => $request->id_caja_compensacion,
            'talla_camisa' => $request->talla_camisa,
            'talla_pantalon' => $request->talla_pantalon,
            'talla_zapatos' => $request->talla_zapatos,
            'genero' => $request->genero,
            'rh' => $request->rh,
            'estado' => 1
        ];

        //Si Existe un Tipo de cliente para actualizar.
        if(isset($request->id_tipo_cliente))
        {
            $arrayCliente['id_tipo_cliente'] = $request->id_tipo_cliente;
        }

        $arrayDiasEstudio = [
            'codigo_cliente' => $codigo_cliente,
            'id_tienda' => $id_tienda,
            'lunes' => (int)$request->estudio_lunes_empleado,
            'martes' => (int)$request->estudio_martes_empleado,
            'miercoles' => (int)$request->estudio_miercoles_empleado,
            'jueves' => (int)$request->estudio_jueves_empleado,
            'viernes' => (int)$request->estudio_viernes_empleado,
            'sabado' => (int)$request->estudio_sabado_empleado,
            'domingo' => (int)$request->estudio_domingo_empleado,
        ];
        
            /** ****************
            ***	Segunda Pantalla
            *** ***************/
    
        $arrayEmpleado = [
            'id_tipo_contrato' => $request->id_contrato,
            'id_ciudad_trabajo' => $request->id_ciudad_trabajo,
            'salario' => $this->limpiarVal($request->id_salario),
            'valor_auxilio_vivenda' => $this->limpiarVal($request->id_valor_auxilio_vivenda),
            'valor_auxilio_transporte' => $this->limpiarVal($request->id_valor_auxilio_transporte),
            'id_cargo_empleado' => $request->id_cargo_empleado,
            'id_zona_encargado' => $request->id_zona_cargo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'otros_aportes' => $request->otros_aportes,
            'familiares_en_nutibara' => (int)$request->familiares_en_nutibara,
            'numero_hijos' => $request->numero_hijos_empleado,
            'numero_hermanos' => $request->numero_hermanos_empleado,
            'total_personas_a_cargo' => $request->total_a_cargo_empleado,
            'fecha_retiro' => $request->fecha_retiro,
            'observacion_novedad' => $request->observacion_novedad,
            'id_motivo_retiro' => $request->id_motivo_retiro,
            'codigo_cliente' => $codigo_cliente,
            'id_tienda' => $id_tienda,            
        ];

        if(!is_null($request->id_tienda_pariente) && !is_null($request->nombre_parientes))
        {
            foreach ($request->id_tienda_pariente as $key => $value) {
                /*Array dirigido a la tabla de Clientes*/
                if(is_null($request->nombre_parientes[$key]) && is_null($request->nombre_parientes[$key]))
                {
                    continue;
                }
                $arrayParientesEnNutibara[$key]['id_tienda'] = $id_tienda;
                $arrayParientesEnNutibara[$key]['id_tienda_pariente'] = $request->id_tienda_pariente[$key];
                $arrayParientesEnNutibara[$key]['codigo_cliente'] = $codigo_cliente;
                $arrayParientesEnNutibara[$key]['codigo_cliente_pariente'] = $request->codigo_cliente_pariente[$key];
                $arrayParientesEnNutibara[$key]['id_tipo_parentesco'] = $request->id_tipo_parentesco[$key];
                $arrayParientesEnNutibara[$key]['id_cargo'] = $request->id_cargo_pariente[$key];
                $arrayParientesEnNutibara[$key]['trabaja_nutibara'] = 1;
            }
        }

        
        /** ****************
        ***	Tercera Pantalla
        *** ***************/
        if(!is_null($request->nombres_completos_familiares))
        {
            foreach ($request->nombres_completos_familiares as $key => $value) {
                /*Array dirigido a la tabla de Clientes*/
                if(is_null($request->nombres_completos_familiares[$key]))
                {
                    continue;
                }
                if($request->codigo_cliente_familiares[$key] != NULL && $request->id_tienda_familiares[$key] != NULL) {
                    $arrayFamiliares[$key]['operacion'] = 'A'; 
                }else{
                    $arrayFamiliares[$key]['operacion'] = 'I'; 
                    $arrayFamiliares[$key]['estado'] = 1; 
                }

                $arrayFamiliares[$key]['id_tienda'] = $request->id_tienda_familiares[$key]; 
                $arrayFamiliares[$key]['codigo_cliente'] = $request->codigo_cliente_familiares[$key];
                $arrayFamiliares[$key]['id_tipo_documento'] = $request->id_tipo_documento_familiares[$key];
                $arrayFamiliares[$key]['numero_documento'] = $request->identificacion_familiares[$key];
                $arrayFamiliares[$key]['nombres'] = $request->nombres_completos_familiares[$key];
                $arrayFamiliares[$key]['fecha_nacimiento'] = $request->fecha_nacimiento_familiares[$key];
                $arrayFamiliares[$key]['genero'] = $request->id_genero_familiares[$key];
                $arrayFamiliares[$key]['beneficiario'] = $request->hd_beneficiario[$key];
                $arrayFamiliares[$key]['ocupacion'] = $request->ocupacion_familiares[$key];
                $arrayFamiliares[$key]['grado_escolaridad'] = $request->grado_escolaridad_familiares[$key];
                $arrayFamiliares[$key]['id_nivel_estudio'] = $request->id_nivel_estudio_familiares[$key];
                $arrayFamiliares[$key]['ano_o_semestre'] = $request->semestre_familiares[$key];
                $arrayFamiliares[$key]['estado'] = 1; 
                
                /*Array dirigido a la tabla de Parientes*/
                $arrayFamiliaresParientes[$key]['id_tipo_parentesco'] = $request->id_parentesco_familiares[$key]; 
                $arrayFamiliaresParientes[$key]['id_tienda'] = $id_tienda;
                $arrayFamiliaresParientes[$key]['id_tienda_pariente'] = $request->id_tienda_familiares[$key]; 
                $arrayFamiliaresParientes[$key]['codigo_cliente'] = $codigo_cliente; 
                $arrayFamiliaresParientes[$key]['codigo_cliente_pariente'] = $request->codigo_cliente_familiares[$key];; 
                $arrayFamiliaresParientes[$key]['vive_con_persona_familiares'] = $request->hd_vive_con_persona_familiares[$key];
                $arrayFamiliaresParientes[$key]['a_cargo_persona_familiares'] = $request->hd_a_cargo_persona_familiares[$key];

            }
        }

        if(!is_null($request->nombre_emergencia))
        {
            foreach ($request->nombre_emergencia as $key => $value) {
                /*Array dirigido a la tabla de Clientes*/
                if(is_null($request->nombre_emergencia[$key]))
                {
                    continue;
                }
                if($request->codigo_cliente_emergencia[$key] != NULL && $request->id_tienda_emergencia[$key] != NULL) {
                   $arrayContactoEmergencia[$key]['operacion'] = 'A'; 
                }else{
                   $arrayContactoEmergencia[$key]['operacion'] = 'I'; 
                }
                
                $arrayContactoEmergencia[$key]['codigo_cliente'] = $request->codigo_cliente_emergencia[$key];
                $arrayContactoEmergencia[$key]['id_tienda'] = $request->id_tienda_emergencia[$key];
                $arrayContactoEmergencia[$key]['id_tipo_documento'] = $request->id_tipo_documento_emergencia[$key];
                $arrayContactoEmergencia[$key]['numero_documento'] = $request->identificacion_emergencia[$key];
                $arrayContactoEmergencia[$key]['nombres'] = $request->nombre_emergencia[$key];
                $arrayContactoEmergencia[$key]['primer_apellido'] = $request->primer_apellido_emergencia[$key];
                $arrayContactoEmergencia[$key]['segundo_apellido'] = $request->segundo_apellido_emergencia[$key];
                $arrayContactoEmergencia[$key]['direccion_residencia'] = $request->direccion_emergencia[$key];
                $arrayContactoEmergencia[$key]['telefono_residencia'] = $request->telefono_emergencia[$key];
                $arrayContactoEmergencia[$key]['id_ciudad_residencia'] = $request->ciudad_emergencia[$key];
                $arrayContactoEmergencia[$key]['estado'] = 1; 

                /*Array dirigido a la tabla de Parientes*/
                $arrayContactoEmergenciaParientes[$key]['id_tipo_parentesco'] =  $request->parentesco_emergencia[$key];
                $arrayContactoEmergenciaParientes[$key]['id_tienda'] = $id_tienda; 
                $arrayContactoEmergenciaParientes[$key]['codigo_cliente'] = $codigo_cliente; 
                $arrayContactoEmergenciaParientes[$key]['id_tienda_pariente'] = $request->id_tienda_emergencia[$key]; 
                $arrayContactoEmergenciaParientes[$key]['codigo_cliente_pariente'] = $request->id_tienda_pariente_emergencia[$key]; 
                $arrayContactoEmergenciaParientes[$key]['contacto_emergencia'] = 1;  
            }
        }

        if(!is_null($request->nombre_estudios))
        {
            foreach ($request->nombre_estudios as $key => $value) {
                /*Array dirigido a la tabla de Estudios del Cliente*/
                if(is_null($request->nombre_estudios[$key]))
                {
                    continue;
                }
                $arrayEstudiosEmpleado[$key]['codigo_cliente'] = $codigo_cliente;
                $arrayEstudiosEmpleado[$key]['id_tienda'] = $id_tienda;
                $arrayEstudiosEmpleado[$key]['nombre'] = $request->nombre_estudios[$key];
                $arrayEstudiosEmpleado[$key]['anos_cursados'] = $request->anos_cursados_estudios[$key];
                $arrayEstudiosEmpleado[$key]['fecha_inicio'] = $request->fecha_inicio_estudios[$key];
                $arrayEstudiosEmpleado[$key]['fecha_terminacion'] = $request->fecha_terminacion_estudios[$key];
                $arrayEstudiosEmpleado[$key]['institucion'] = $request->institucion_estudios[$key];
                $arrayEstudiosEmpleado[$key]['titulo_obtenido'] = $request->titulo_obtenido_estudios[$key];
                $arrayEstudiosEmpleado[$key]['finalizado'] = $request->finalizado_estudios[$key];
            }
        }

        /** ****************
        ***	Cuarta Pantalla
        *** ***************/
        if(!is_null($request->empresa_hist_laboral))
        {
            foreach ($request->empresa_hist_laboral as $key => $value) {
                /*Array dirigido a la tabla de Historial Laboral del Cliente*/
                if(is_null($request->empresa_hist_laboral[$key]))
                {
                    continue;
                }
                $arrayHistLaboral[$key]['codigo_cliente'] = $codigo_cliente;
                $arrayHistLaboral[$key]['id_tienda'] = $id_tienda;
                $arrayHistLaboral[$key]['empresa'] = $request->empresa_hist_laboral[$key];
                $arrayHistLaboral[$key]['cargo'] = $request->cargo_hist_laboral[$key];
                $arrayHistLaboral[$key]['nombre_jefe_inmediato'] = $request->nombre_jefe_hist_laboral[$key];
                $arrayHistLaboral[$key]['fecha_ingreso'] = $request->fecha_ingreso_hist_laboral[$key];
                $arrayHistLaboral[$key]['fecha_retiro'] = $request->fecha_retiro_hist_laboral[$key];
                $arrayHistLaboral[$key]['cantidad_personas_a_cargo'] = $request->personas_a_cargo_hist_laboral[$key];
                $arrayHistLaboral[$key]['ultimo_salario'] = $request->ultimo_salario_hist_laboral[$key];
                $arrayHistLaboral[$key]['horario_trabajo'] = $request->horario_trabajo_hist_laboral[$key];
                $arrayHistLaboral[$key]['id_tipo_contrato'] = $request->tipo_contrato_hist_laboral[$key];
            }
        }

        $array = array(
            'arrayCliente' => $arrayCliente,
            'arrayParientesEnNutibara' => $arrayParientesEnNutibara,
            'arrayEmpleado' => $arrayEmpleado,
            'arrayFamiliares' => $arrayFamiliares,
            'arrayFamiliaresParientes' => $arrayFamiliaresParientes,
            'arrayContactoEmergencia' => $arrayContactoEmergencia,  
            'arrayContactoEmergenciaParientes' => $arrayContactoEmergenciaParientes,  
            'arrayEstudiosEmpleado' => $arrayEstudiosEmpleado,
            'arrayHistLaboral' => $arrayHistLaboral,
            'arrayDiasEstudio' => $arrayDiasEstudio,
        );
        return $array;
    }

    public function limpiarVal($val)
	{
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}
}
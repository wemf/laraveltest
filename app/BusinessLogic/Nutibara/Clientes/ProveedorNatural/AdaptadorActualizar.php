<?php 

namespace App\BusinessLogic\Nutibara\Clientes\ProveedorNatural;
use App\AccessObject\Nutibara\Clientes\ProveedorNatural\ProveedorNatural;
use App\BusinessLogic\FileManager\FileManagerSingle;
use config\messages;

class AdaptadorActualizar {
    
    public static function getProveedorNaturalById($id,$idTienda)
    {
        $array = array();
        $array['familiar'] = array();
        $array['familiar_nutibara'] = array();
        $array['contacto_emergencia'] = array();
        $array['datosGenerales'] = ProveedorNatural::getProveedorNaturalById($id,$idTienda);
        $array['estudios'] = ProveedorNatural::getEstudiosById($id,$idTienda);
        $array['hist_laboral'] = ProveedorNatural::getHistorialLaboralById($id,$idTienda);
        $array['sucursal_clientes'] = ProveedorNatural::getSucursalClienteById($id,$idTienda);
        $cantidadParientes = ProveedorNatural::getParientesById($id,$idTienda);
        $i = 0;
        $j = 0;
        $k = 0;
        foreach ($cantidadParientes as $key => $value) { 
            $persona = ProveedorNatural::getClienteById($value->codigo_cliente_pariente,$value->id_tienda_pariente);
            if($value->trabaja_nutibara > 0)
            {
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
                $array['contacto_emergencia'][$j]['codigo_cliente'] = $value->codigo_cliente_pariente;
                $array['contacto_emergencia'][$j]['id_tienda'] = $value->id_tienda_pariente;
                $array['contacto_emergencia'][$j]['id_tipo_documento'] = $persona->id_tipo_documento;
                $array['contacto_emergencia'][$j]['numero_documento'] = $persona->numero_documento;
                $array['contacto_emergencia'][$j]['nombre'] = $persona->nombres;
                $array['contacto_emergencia'][$j]['id_tipo_parentesco'] = $value->id_tipo_parentesco;
                $array['contacto_emergencia'][$j]['direccion_residencia'] = $persona->direccion_residencia;
                $array['contacto_emergencia'][$j]['id_ciudad_residencia'] = $persona->id_ciudad_residencia;
                $array['contacto_emergencia'][$j]['telefono_residencia'] = $persona->telefono_residencia;
                $j++;
            }
            else
            {
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
        
        $msm=['msm'=>Messages::$Cliente['update_ok'],'val'=>true];
		if(!ProveedorNatural::Update($codigoCliente,$id_tienda,$dataSave))
        {
			$msm=['msm'=>Messages::$Cliente['update_error'],'val'=>false];		
        }	
		return $msm;
    }

    public function returnArray($request,$codigo_cliente,$id_tienda)
    {
        $arrayCliente = array();
        $arrayParientesEnNutibara = array();
        $arrayFamiliares = array();
        $arrayFamiliaresParientes = array();
        $arrayContactoEmergencia = array();  
        $arrayContactoEmergenciaParientes = array();  
        $arrayEstudiosCliente = array();
        $arrayHistLaboral = array();
        $arrayDiasEstudio = array();
        $arraySucursalesClientesActuales = array();
        $arraySucursalesClientes = array();

        $arrayCliente = [

            /** ****************
            ***	Primera Pantalla
            *** ***************/
            'codigo_cliente' => $codigo_cliente,
            'id_tienda' => $id_tienda,
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
            'id_pais_residencia' => $request->id_pais_residencia,
            'id_ciudad_residencia' => $request->id_ciudad_residencia,
            'barrio_residencia' => $request->barrio_residencia,
            'telefono_residencia' => $request->telefono_residencia,
            'telefono_celular' => $request->telefono_celular,
            'correo_electronico' => $request->correo_electronico,
            'id_estado_civil' => $request->id_estado_civil,
            'aniversario' => $request->aniversario,
            'id_tipo_vivienda' => $request->id_tipo_vivienda,
            'id_tenencia_vivienda' => $request->id_tenencia_vivienda,
            'libreta_militar' => $request->libreta_militar,
            'distrito_militar' => $request->distrito_militar,
            'id_nivel_estudio' => $request->nivel_estudio_persona,
            'id_nivel_estudio_actual' => $request->nivel_estudio_persona_actual,
            'talla_camisa' => $request->talla_camisa,
            'talla_pantalon' => $request->talla_pantalon,
            'talla_zapatos' => $request->talla_zapatos,
            'id_tipo_cliente' => $request->id_tipo_cliente,
            'genero' => $request->genero,
            'rh' => $request->rh,
            'id_regimen_contributivo' => $request->id_regimen_contributivo,
            'estado' => 1
        ];

        if(isset($request->id_tipo_cliente_enviado)){
            $arrayCliente["id_tipo_cliente_enviado"] = $request->id_tipo_cliente_enviado;
        }

        $arrayDiasEstudio = [
            'codigo_cliente' => $codigo_cliente,
            'id_tienda' => $id_tienda,
            'lunes' => (int)$request->estudio_lunes_persona,
            'martes' => (int)$request->estudio_martes_persona,
            'miercoles' => (int)$request->estudio_miercoles_persona,
            'jueves' => (int)$request->estudio_jueves_persona,
            'viernes' => (int)$request->estudio_viernes_persona,
            'sabado' => (int)$request->estudio_sabado_persona,
            'domingo' => (int)$request->estudio_domingo_persona,
        ];
        
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
                $arrayContactoEmergencia[$key]['direccion_residencia'] = $request->direccion_emergencia[$key];
                $arrayContactoEmergencia[$key]['telefono_residencia'] = $request->telefono_emergencia[$key];
                $arrayContactoEmergencia[$key]['id_ciudad_residencia'] = $request->ciudad_emergencia[$key];
                $arrayContactoEmergencia[$key]['estado'] = 1; 

                /*Array dirigido a la tabla de Parientes*/
                $arrayContactoEmergenciaParientes[$key]['id_tipo_parentesco'] =  $request->parentesco_emergencia[$key];
                $arrayContactoEmergenciaParientes[$key]['id_tienda'] = $id_tienda; 
                $arrayContactoEmergenciaParientes[$key]['codigo_cliente'] = $codigo_cliente; 
                $arrayContactoEmergenciaParientes[$key]['id_tienda_pariente'] = $request->id_tienda_emergencia[$key]; 
                $arrayContactoEmergenciaParientes[$key]['codigo_cliente_pariente'] = $request->codigo_cliente_emergencia[$key]; 
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
                $arrayEstudiosCliente[$key]['codigo_cliente'] = $codigo_cliente;
                $arrayEstudiosCliente[$key]['id_tienda'] = $id_tienda;
                $arrayEstudiosCliente[$key]['nombre'] = $request->nombre_estudios[$key];
                $arrayEstudiosCliente[$key]['anos_cursados'] = $request->anos_cursados_estudios[$key];
                $arrayEstudiosCliente[$key]['fecha_inicio'] = $request->fecha_inicio_estudios[$key];
                $arrayEstudiosCliente[$key]['fecha_terminacion'] = $request->fecha_terminacion_estudios[$key];
                $arrayEstudiosCliente[$key]['institucion'] = $request->institucion_estudios[$key];
                $arrayEstudiosCliente[$key]['titulo_obtenido'] = $request->titulo_obtenido_estudios[$key];
                $arrayEstudiosCliente[$key]['finalizado'] = $request->finalizado_estudios[$key];
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

         /** ****************
        ***	Quinta Pantalla
        *** ***************/
        if(!is_null($request->nombre_sucursal[0]) && isset($request->nombre_sucursal[1]))
        {
                /*Array dirigido a la tabla de Sucursales del Cliente*/            
            foreach ($request->nombre_sucursal as $key => $value) 
            {
                if(is_null($request->id_tienda_sucursal[$key]))
                {
                    $arraySucursalesClientes[$key]['id_tienda_sucursal'] = $id_tienda;
                    $arraySucursalesClientes[$key]['id_cliente'] = $codigo_cliente;
                    $arraySucursalesClientes[$key]['id_tienda_cliente'] = $id_tienda;
                    $arraySucursalesClientes[$key]['nombre'] = $request->nombre_sucursal[$key];
                    $arraySucursalesClientes[$key]['id_ciudad'] = $request->ciudad_sucursal[$key];
                    $arraySucursalesClientes[$key]['telefono_sucursal'] = $request->telefono_sucursal[$key];
                    $arraySucursalesClientes[$key]['representante'] = $request->nombre_representante_sucursal[$key];            
                }
                else
                {
                    $arraySucursalesClientesActuales[$key]['id_sucursal'] = $request->id_sucursal[$key];
                    $arraySucursalesClientesActuales[$key]['id_tienda_sucursal'] = $request->id_tienda_sucursal[$key];
                    $arraySucursalesClientesActuales[$key]['nombre'] = $request->nombre_sucursal[$key];
                    $arraySucursalesClientesActuales[$key]['id_ciudad'] = $request->ciudad_sucursal[$key];
                    $arraySucursalesClientesActuales[$key]['telefono_sucursal'] = $request->telefono_sucursal[$key];
                    $arraySucursalesClientesActuales[$key]['representante'] = $request->nombre_representante_sucursal[$key];
                }
               
            }
        }
        else
        {
            $arraySucursalesClientesActuales[0]['nombre'] = 'Borrar';
        }


        /*- ------------------------------------------------------ ---
        *-- ARRAY PARA LAS FOTOS SUBIDAS DEL DOCUMENTO DEL CLIENTE
        *-- ------------------------------------------------------ -*/
        
        if(!is_null($request->foto_1) && !is_null($request->foto_2))
        {
            $single_1 = new FileManagerSingle($request->foto_1);
            $single_2 = new FileManagerSingle($request->foto_2);
            $key = uniqid();
            $id_file1 = $single_1->moveFile($key,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
            $id_file2 = $single_2->moveFile($key,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
            if($id_file1 != NULL && $id_file2 != NULL){
                $arrayCliente['id_foto_documento_anterior'] = $id_file1['msm'][1];
                $arrayCliente['id_foto_documento_posterior'] = $id_file2['msm'][1];
            }
        }
        /*- ------------------------------------------------------ ---
        *-- ------------------------------------------------------ -*/



        /*- --------------------------------------------------- ---
        *-- ARRAY DEFINITIVO PARA ENVIAR A LA CAPA DE LOS DATOS
        *-- --------------------------------------------------- -*/
        
        $array = array(
            'arrayCliente' => $arrayCliente,
            'arrayFamiliares' => $arrayFamiliares,
            'arrayFamiliaresParientes' => $arrayFamiliaresParientes,
            'arrayContactoEmergencia' => $arrayContactoEmergencia,  
            'arrayContactoEmergenciaParientes' => $arrayContactoEmergenciaParientes,  
            'arrayEstudiosCliente' => $arrayEstudiosCliente,
            'arrayHistLaboral' => $arrayHistLaboral,
            'arrayDiasEstudio' => $arrayDiasEstudio,
            'arraySucursalesClientes' => $arraySucursalesClientes,
            'arraySucursalesClientesActuales' => $arraySucursalesClientesActuales,
        );
        return $array;
    }
}
<?php

namespace App\BusinessLogic\Nutibara\Clientes\ProveedorNatural;
use App\BusinessLogic\FileManager\FileManagerSingle;

class AdaptadorCrear {

    private $request;
    private $codigo_cliente;
    private $id_tienda;
    private $array = array();
    private $arrayCliente = NULL;
    private $arrayFamiliares = NULL;
    private $arrayHistLaboral = NULL;
    private $arrayDiasEstudio = NULL;
    private $arrayEstudiosCliente = NULL;
    private $arrayContactoEmergencia = NULL;
    private $arrayFamiliaresParientes = NULL;
    private $arrayContactoEmergenciaParientes = NULL;
    private $arraySucursalesClientes = NULL;

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
            'nombres' => $this->request->nombres,
            'primer_apellido' => $this->request->primer_apellido,
            'segundo_apellido' => $this->request->segundo_apellido,
            'id_tipo_documento' => $this->request->id_tipo_documento,
            'numero_documento' => $this->request->numero_documento,
            'fecha_expedicion' => $this->request->fecha_expedicion,
            'id_pais_expedicion' => $this->request->id_pais_expedicion,
            'id_ciudad_expedicion' => $this->request->id_ciudad_expedicion,
            'fecha_nacimiento' => $this->request->fecha_nacimiento,
            'id_pais_nacimiento' => $this->request->id_pais_nacimiento,
            'id_ciudad_nacimiento' => $this->request->id_ciudad_nacimiento,
            'direccion_residencia' => $this->request->direccion_residencia,
            'id_pais_residencia' => $this->request->id_pais_residencia,
            'id_ciudad_residencia' => $this->request->id_ciudad_residencia,
            'barrio_residencia' => $this->request->barrio_residencia,
            'telefono_residencia' =>$this->request->telefono_residencia,
            'telefono_celular' => $this->request->telefono_celular,
            'correo_electronico' => $this->request->correo_electronico,
            'id_estado_civil' => $this->request->id_estado_civil,
            'aniversario' => $this->request->aniversario,
            'id_tipo_vivienda' => $this->request->id_tipo_vivienda,
            'id_tenencia_vivienda' => $this->request->id_tenencia_vivienda,
            'libreta_militar' => $this->request->libreta_militar,
            'distrito_militar' => $this->request->distrito_militar,
            'id_nivel_estudio' => $this->request->nivel_estudio_persona,
            'id_nivel_estudio_actual' => $this->request->nivel_estudio_persona_actual,
            'id_eps' => $this->request->id_eps,
            'id_caja_compensacion' => $this->request->id_caja_compensacion,
            'talla_camisa' => $this->request->talla_camisa,
            'talla_pantalon' => $this->request->talla_pantalon,
            'talla_zapatos' => $this->request->talla_zapatos,
            'id_tipo_cliente' => $this->request->id_tipo_cliente,
            'genero' => $this->request->genero,
            'rh' => $this->request->rh,
            'id_regimen_contributivo' => $this->request->id_regimen_contributivo,
            'estado' => 1
        ];

        $this->arrayDiasEstudio = [
            'codigo_cliente' => $this->codigo_cliente,
            'id_tienda' => $this->id_tienda,
            'lunes' => (int)$this->request->estudio_lunes_persona,
            'martes' => (int)$this->request->estudio_martes_persona,
            'miercoles' => (int)$this->request->estudio_miercoles_persona,
            'jueves' => (int)$this->request->estudio_jueves_persona,
            'viernes' => (int)$this->request->estudio_viernes_persona,
            'sabado' => (int)$this->request->estudio_sabado_persona,
            'domingo' => (int)$this->request->estudio_domingo_persona,
        ];
        
        
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
                $this->arrayEstudiosCliente[$key]['codigo_cliente'] = $this->codigo_cliente;
                $this->arrayEstudiosCliente[$key]['id_tienda'] = $this->id_tienda;
                $this->arrayEstudiosCliente[$key]['nombre'] = $this->request->nombre_estudios[$key];
                $this->arrayEstudiosCliente[$key]['anos_cursados'] = $this->request->anos_cursados_estudios[$key];
                $this->arrayEstudiosCliente[$key]['fecha_inicio'] = $this->request->fecha_inicio_estudios[$key];
                $this->arrayEstudiosCliente[$key]['fecha_terminacion'] = $this->request->fecha_terminacion_estudios[$key];
                $this->arrayEstudiosCliente[$key]['institucion'] = $this->request->institucion_estudios[$key];
                $this->arrayEstudiosCliente[$key]['titulo_obtenido'] = $this->request->titulo_obtenido_estudios[$key];
                $this->arrayEstudiosCliente[$key]['finalizado'] = $this->request->finalizado_estudios[$key];
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
                $this->arrayHistLaboral  [$key]['id_tienda'] = $this->id_tienda;
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

        /** ****************
        ***	Quinta Pantalla
        *** ***************/
        if(!is_null($this->request->nombre_sucursal[0]))
        {
            foreach ($this->request->nombre_sucursal as $key => $value) {
                /*Array dirigido a la tabla de Sucursales del Cliente*/
                $this->arraySucursalesClientes[$key]['id_tienda_sucursal'] = $this->id_tienda;
                $this->arraySucursalesClientes[$key]['id_cliente'] = $this->codigo_cliente;
                $this->arraySucursalesClientes[$key]['id_tienda_cliente'] = $this->id_tienda;
                $this->arraySucursalesClientes[$key]['nombre'] = $this->request->nombre_sucursal[$key];
                $this->arraySucursalesClientes[$key]['id_ciudad'] = $this->request->ciudad_sucursal[$key];
                $this->arraySucursalesClientes[$key]['telefono_sucursal'] = $this->request->telefono_sucursal[$key];
                $this->arraySucursalesClientes[$key]['representante'] = $this->request->nombre_representante_sucursal[$key];
            }
        }

           
     /*- ------------------------------------------------------ ---
        *-- ARRAY PARA LAS FOTOS SUBIDAS DEL DOCUMENTO DEL CLIENTE
        *-- ------------------------------------------------------ -*/
    if(!is_null($this->request->foto_1) && !is_null($this->request->foto_2))
    {
        $single_1 = new FileManagerSingle($this->request->foto_1);
        $single_2 = new FileManagerSingle($this->request->foto_2);
        $key = uniqid();
        $id_file1 = $single_1->moveFile($key,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
        $id_file2 = $single_2->moveFile($key,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
        if($id_file1 != NULL && $id_file2 != NULL)
        {
            $this->arrayCliente['id_foto_documento_anterior'] = $id_file1['msm'][1];
            $this->arrayCliente['id_foto_documento_posterior'] = $id_file2['msm'][1];
        }
    }

        /*- ------------------------------------------------------ ---
        *-- ------------------------------------------------------ -*/

        /*- --------------------------------------------------- ---
        *-- ARRAY DEFINITIVO PARA ENVIAR A LA CAPA DE LOS DATOS
        *-- --------------------------------------------------- -*/
        $this->array = array(
            'arrayCliente' => $this->arrayCliente,
            'arrayFamiliares' => $this->arrayFamiliares,
            'arrayFamiliaresParientes' => $this->arrayFamiliaresParientes,
            'arrayContactoEmergencia' => $this->arrayContactoEmergencia,  
            'arrayContactoEmergenciaParientes' => $this->arrayContactoEmergenciaParientes,  
            'arrayEstudiosCliente' => $this->arrayEstudiosCliente,
            'arrayHistLaboral' => $this->arrayHistLaboral,
            'arrayDiasEstudio' => $this->arrayDiasEstudio,
            'arraySucursalesClientes' => $this->arraySucursalesClientes
        );        
        return $this->array;
    }
    

}
<?php 

namespace App\BusinessLogic\Nutibara\Clientes\PersonaJuridica;
use App\AccessObject\Nutibara\Clientes\PersonaJuridica\PersonaJuridica;
use config\messages;

class AdaptadorActualizar {
    
    public static function getPersonaJuridicaById($id,$idTienda)
    {
        $array['datosGenerales'] = PersonaJuridica::getPersonaJuridicaById($id,$idTienda);
        return $array; 
    }

    public function ordenarDatos($request,$codigoCliente,$id_tienda)
    {
        $dataSave = $this->returnArray($request,$codigoCliente,$id_tienda);
        // dd($dataSave);
        $msm=['msm'=>Messages::$Cliente['update_ok'],'val'=>true];
		if(!PersonaJuridica::Update($codigoCliente,$id_tienda,$dataSave))
        {
			$msm=['msm'=>Messages::$Cliente['update_error'],'val'=>false];		
        }	
		return $msm;
    }

    public function returnArray($request,$codigo_cliente,$id_tienda)
    {
        $arrayCliente = array();

        $arrayCliente = [

            /** ****************
            ***	Primera Pantalla
            *** ***************/
            'id_tipo_cliente' => $request->id_tipo_cliente,
            'nombres' => $request->nombres,
            'numero_documento' => $request->numero_documento,
            'direccion_residencia' => $request->direccion_residencia,
            'id_ciudad_residencia' => $request->id_ciudad_residencia,
            'barrio_residencia' => $request->barrio_residencia,
            'telefono_residencia' => $request->telefono_residencia,
            'telefono_celular' => $request->telefono_celular,
            'correo_electronico' => $request->correo_electronico,
            
            'contacto' => $request->contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'representante_legal' => $request->representante_legal,
            'numero_documento_representante' => $request->numero_documento_representante,
            'id_regimen_contributivo' => $request->id_regimen_contributivo,
            'estado' => 1
        ];

        $array = array(
            'arrayCliente' => $arrayCliente,
        );

        return $array;
    }
}
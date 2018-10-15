<?php

namespace App\BusinessLogic\Nutibara\Clientes\PersonaJuridica;

class AdaptadorCrear {

    private $request;
    private $codigo_cliente;
    private $id_tienda;
    private $array = array();
    private $arrayCliente = NULL;

    public function __construct($request,$codigo_cliente,$id_tienda)
    {
        $this->request = $request;
        $this->codigo_cliente = $codigo_cliente;
        $this->id_tienda = $id_tienda;
    }
    
    public function returnArray()
    {
        $this->arrayCliente = [

            'id_tipo_cliente' => $this->request->id_tipo_cliente,
            'id_tipo_documento' => $this->request->id_tipo_documento,
            'codigo_cliente' => $this->codigo_cliente,
            'id_tienda' => $this->id_tienda,
            'nombres' => $this->request->nombres,
            'digito_verificacion' => $this->request->digito_verificacion,   
            'numero_documento' => $this->request->numero_documento,
            'direccion_residencia' => $this->request->direccion_residencia,
            'id_ciudad_residencia' => $this->request->id_ciudad_residencia,
            'barrio_residencia' => $this->request->barrio_residencia,
            'telefono_residencia' => $this->request->telefono_residencia,
            'telefono_celular' => $this->request->telefono_celular,
            'correo_electronico' => $this->request->correo_electronico,
            'contacto' => $this->request->contacto,
            'telefono_contacto' => $this->request->telefono_contacto,
            'representante_legal' => $this->request->representante_legal,
            'numero_documento_representante' => $this->request->numero_documento_representante,
            'id_regimen_contributivo' => $this->request->id_regimen_contributivo,
            'estado' => 1

        ];


        $this->array = array(
            'arrayCliente' => $this->arrayCliente,
        );

        return $this->array;
    }
    

}
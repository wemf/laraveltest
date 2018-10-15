<?php

namespace App\BusinessLogic\Nutibara\Clientes\ProveedorJuridico;

class AdaptadorCrear {

    private $request;
    private $codigo_cliente;
    private $id_tienda;
    private $array = array();
    private $arrayCliente = NULL;
    private $arraySucursalesClientes = NULL;

    public function __construct($request,$codigo_cliente,$id_tienda)
    {
        $this->request = $request;
        $this->codigo_cliente = $codigo_cliente;
        $this->id_tienda = $id_tienda;
    }
    
    public function returnArray()
    {
         /** ****************
        ***	 Cliente
        *** ***************/
        $this->arrayCliente = [

            'id_tipo_cliente' => $this->request->id_tipo_cliente,
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

         /** ****************
        ***	Sucursales del Cliente
        *** ***************/
       
        if($this->request->nombre_sucursal[0] != null)
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

        $this->array = array(
            'arrayCliente' => $this->arrayCliente,
            'arraySucursalesClientes' => $this->arraySucursalesClientes,
        );
        return $this->array;
    }
    

}
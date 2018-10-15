<?php 

namespace App\BusinessLogic\Nutibara\Clientes\ProveedorJuridico;
use App\AccessObject\Nutibara\Clientes\ProveedorJuridico\ProveedorJuridico;
use App\AccessObject\Nutibara\Clientes\ProveedorNatural\ProveedorNatural;
use config\messages;

class AdaptadorActualizar {
    
    public static function getProveedorJuridicoById($id,$idTienda)
    {
        $array['datosGenerales'] = ProveedorJuridico::getProveedorJuridicoById($id,$idTienda);
        $array['sucursal_clientes'] = ProveedorNatural::getSucursalClienteById($id,$idTienda);        
        return $array; 
    }

    public function ordenarDatos($request,$codigoCliente,$id_tienda)
    {
        $dataSave = $this->returnArray($request,$codigoCliente,$id_tienda);
        // dd($dataSave);
        $msm=['msm'=>Messages::$Cliente['update_ok'],'val'=>true];
		if(!ProveedorJuridico::Update($codigoCliente,$id_tienda,$dataSave))
        {
			$msm=['msm'=>Messages::$Cliente['update_error'],'val'=>false];		
        }	
		return $msm;
    }

    public function returnArray($request,$codigo_cliente,$id_tienda)
    {
        $arrayCliente = array();
        $arraySucursalesClientes = array();
        $arraySucursalesClientesActuales = array();

        $arrayCliente = [

            /** ****************
            ***	Primera Pantalla
            *** ***************/
            'id_tipo_cliente' => $request->id_tipo_cliente,
            'nombres' => $request->nombres,
            'numero_documento' => $request->numero_documento,
            'digito_verificacion' => $request->digito_verificacion,                        
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

        /** ****************
        ***	Sucursal Pantalla
        *** ***************/
        if(!is_null($request->nombre_sucursal[0]))
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

        $array = array(
            'arrayCliente' => $arrayCliente,
            'arraySucursalesClientes' => $arraySucursalesClientes,
            'arraySucursalesClientesActuales' => $arraySucursalesClientesActuales,
        );
        return $array;
    }
}
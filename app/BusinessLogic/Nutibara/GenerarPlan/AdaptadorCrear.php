<?php

namespace App\BusinessLogic\Nutibara\GenerarPlan;
use App\BusinessLogic\Nutibara\GenerarPlan\CrudGenerarPlan;

class AdaptadorCrear {
    private $request;
    private $codigo_cliente;
    private $codigo_plan;
    private $id_tienda;
    private $array = array();
    private $arrayCliente = NULL;
    private $arrayPlan = NULL;
    private $arrayProductos = NULL;
    private $arrayAbono = NULL;
    private $arrayUpdate = NULL;

    public function __construct($request,$codigo_cliente,$id_tienda,$codigo_plan,$codigo_abono){
        $this->request = $request;
        $this->codigo_cliente = $codigo_cliente;
        $this->id_tienda = $id_tienda;
        $this->codigo_plan = $codigo_plan;
        $this->codigo_abono = $codigo_abono;
    }

    public function returnCreate()
    {

        $this->arrayCliente = [
            'correo_electronico' => $this->request->correo,
            'direccion_residencia' => $this->request->direccion_residencia,
            'telefono_residencia' => $this->request->telefono_residencia,
            'telefono_celular' => $this->request->telefono_celular
        ];

        $this->arrayPlan = [
            'codigo_plan_separe' => (int)$this->codigo_plan,
            'codigo_cliente' => (int)$this->codigo_cliente,
            'id_tienda_cliente' => (int)$this->request->id_tienda_cliente,
            'id_tienda' => (int)$this->id_tienda,
            'monto' => CrudGenerarPlan::limpiarVal($this->request->monto),
            'deuda' => CrudGenerarPlan::limpiarVal($this->request->deuda),
            'estado' => env('PLAN_ESTADO_ACTIVO'),
            'motivo' => null,
            'fecha_creacion' => $this->request->fecha_creacion,
            'fecha_limite' => $this->request->fecha_limite,
            'id_cotizacion' => (int)$this->request->id_cotizacion,
            'id_tienda_cotizacion' => (int)$this->request->id_tienda_cot,
        ];

        $this->arrayAbono = [
            'codigo_plan_separe' => (int)$this->codigo_plan,
			'id_tienda' => (int)$this->id_tienda,
			'saldo_abonado' => CrudGenerarPlan::limpiarVal($this->request->abono),
			'fecha' => date("Y-m-d H:i:s"),
			'saldo_pendiente' => CrudGenerarPlan::limpiarVal($this->request->deuda),
			'descripcion' => "Primer abono",
			'codigo_abono' => (int)$this->codigo_abono
        ];
        
        foreach ($this->request->productos as $key => $value) {
            
            $this->arrayProductos[$key]['codigo_inventario'] = $this->request->productos[$key]['codigo_inventario'];
            $this->arrayProductos[$key]['codigo_plan_separe'] = (int)$this->codigo_plan;
            $this->arrayProductos[$key]['id_tienda'] = (int)$this->id_tienda;
            
            $this->arrayUpdate[$key]['codigo_inventario'] = $this->request->productos[$key]['codigo_inventario'];
            $this->arrayUpdate[$key]['precio'] = CrudGenerarPlan::limpiarVal($this->request->productos[$key]['precio']);
            $this->arrayUpdate[$key]['peso'] = $this->request->productos[$key]['peso'];
            $this->arrayUpdate[$key]['codigo_inventario'] = $this->request->productos[$key]['codigo_inventario'];
            $this->arrayUpdate[$key]['id_tienda'] = (int)$this->id_tienda;
            $this->arrayUpdate[$key]['id_catalogo_producto'] = (int)$this->request->productos[$key]['id_catalogo_producto'];
        }
        
        $this->array = array(
            'arrayCliente' => $this->arrayCliente,
            'arrayPlan' => $this->arrayPlan,
            'arrayProductos' => $this->arrayProductos,
            'arrayAbono' => $this->arrayAbono,
            'arrayUpdate' => $this->arrayUpdate,
            'request' => $this->request
        );

        return $this->array;
    }

}

?>
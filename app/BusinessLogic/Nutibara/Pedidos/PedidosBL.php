<?php

namespace App\BusinessLogic\Nutibara\Pedidos;
use App\AccessObject\Nutibara\Pedidos\PedidosAO;
use App\AccessObject\Nutibara\Tienda\Tienda as TiendaAO;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use config\messages;

class PedidosBL
{
    public static function get($request)
    {
        $select = PedidosAO::get();
        $search = array(
            [
				'tableName' => 'tbl_pedido', //tabla de busqueda 
				'field' => 'fecha_creacion', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
            ],
            [
				'tableName' => 'tbl_pedido', //tabla de busqueda 
				'field' => 'id_categoria', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
            ],
            [
				'tableName' => 'tbl_pedido', //tabla de busqueda 
				'field' => 'id_estado', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
            ]
        );
        $where = "";
        $table = new DatatableBL($select,$search,$where);
        return $table->Run($request);    
    }

    public static function getTransformData($data,$id_tienda)
    {
        $a = explode(",",$data);
        $return = array();
        for($i = 0; $i < count($a); $i++){
            $b = explode("-",$a[$i]);
            $tienda = PedidosAO::getTiendaById($b[0]);
            $producto = PedidosAO::getInfoProducto($b[1]);
            $inventario = PedidosAO::getInventarioByReferencia($b[1],$id_tienda);
            $return[$i] = [
                'tienda' => $tienda->nombre,
                'referencia' => $producto->codigo,
                'descripcion' => $producto->descripcion,
                'inventario' => $inventario[0]->total,
                'pos' => $a[$i]
            ];
        }
        
        return $return;
    }

    public static function create($data,$tienda_pedido)
    {
        $estado = env('PEDIDO_GENERADO');
        if($data->guardar != "") $estado = env('PEDIDO_BORRADOR');
        $dataSub = array();
        $dataPedido = [
            'id_pedido' => $data->numero_orden,
            'id_categoria' => 18,
            'id_estado' => $estado,
            'fecha_creacion' => date('Y-m-d'),
            'id_tienda' => $tienda_pedido
        ];
        for($i = 0;$i < count($data->pos);$i++)
        {
            $b = explode("-",$data->pos[$i]);

            $dataSub[$i] = [
                'id_pedido' => $data->numero_orden,
                'id_tienda' => $b[0],
                'unidades' => $data->cantidad[$i],
                'id_referencia' => $b[1],
                'id_tienda_pedido' => $tienda_pedido
            ];
        }
        
        $respuesta = PedidosAO::create($dataPedido,$dataSub);

        if($respuesta == 'Insertado')
        {   
            if($estado = 1){
                $msm = ['msm' => messages::$Pedidos['ok'],'val' => 'Insertado' ];
            }else{
                $msm = ['msm' => messages::$Pedidos['ok_g'],'val' => 'Insertado' ];
            }
        }elseif($respuesta == 'Error'){
            $msm = ['msm' => messages::$Pedidos['error'],'val' => 'Error' ];
        }

        return $msm;

    }

    public static function updatePedidoAjax($id_pedido,$id_tienda,$id_referencia,$valor,$g)
    {
        if($g == 1){
            $respuesta = PedidosAO::updatePedidoAjaxR($id_pedido,$id_tienda,$id_referencia,$valor);
        }else{
            $respuesta = PedidosAO::updatePedidoAjaxP($id_pedido,$id_tienda,$id_referencia,$valor);
        }
        if($respuesta == 'Insertado')
        {
            $msm  = ['msm' => messages::$Pedidos['updateAjax'],'val' => 'Insertado'];
        }elseif($respuesta == 'Error')
        {
            $msm = ['msm' => messages::$Pedidos['error'],'val' => 'Error'];
        }

        return $msm;
    }

    public static function getEstados()
    {
        return PedidosAO::getEstados();
    }

    public static function getCategorias()
    {
        return PedidosAO::getCategorias();
    }

    public static function validarEstado($id_pedido,$id_tienda)
    {
        return PedidosAO::validarEstado($id_pedido,$id_tienda);
    }

    public static function aprobar($id_pedido,$id_tienda,$num_aprobacion)
    {
        $respuesta = PedidosAO::aprobar($id_pedido,$id_tienda,$num_aprobacion);
        
        if($respuesta == 'Insertado')
        {
            $msm  = ['msm' => messages::$Pedidos['ok_aprobar'],'val' => 'Insertado'];
        }elseif($respuesta == 'Error')
        {
            $msm = ['msm' => messages::$Pedidos['error'],'val' => 'Error'];
        }

        return $msm;
    }

    public static function rechazar($id_pedido,$id_tienda)
    {
        $respuesta = PedidosAO::rechazar($id_pedido,$id_tienda);
        
        if($respuesta == 'Insertado')
        {
            $msm  = ['msm' => messages::$Pedidos['ok_rechazado'],'val' => 'Insertado'];
        }elseif($respuesta == 'Error')
        {
            $msm = ['msm' => messages::$Pedidos['error'],'val' => 'Error'];
        }

        return $msm;
    }

    public static function InfoPedido($id_pedido,$id_tienda)
    {
        return PedidosAO::InfoPedido($id_pedido,$id_tienda);
    }

    public static function updateBorrador($data)
    {
        $respuesta = PedidosAO::updateBorrador($data);
        
        if($respuesta)
        {
            $msm  = ['msm' => messages::$Pedidos['ok_a'],'val' => true];
        }else
        {
            $msm = ['msm' => messages::$Pedidos['error'],'val' => false];
        }

        return $msm;
    }

    public static function updateGenerar($data)
    {
        $respuesta = PedidosAO::updateGenerar($data);
        
        if($respuesta)
        {
            $msm  = ['msm' => messages::$Pedidos['ok_g'],'val' => true];
        }else
        {
            $msm = ['msm' => messages::$Pedidos['error'],'val' => false];
        }

        return $msm;
    }
}

?>
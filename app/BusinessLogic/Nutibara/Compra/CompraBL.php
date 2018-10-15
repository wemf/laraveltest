<?php 

namespace App\BusinessLogic\Nutibara\Compra;
use App\AccessObject\Nutibara\Compra\CompraAO;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use config\messages;

class CompraBL
{
    public static function get($request,$tienda){	
		$id_tienda = 0;
		if($tienda != null) $id_tienda = $tienda->id;
		$select = CompraAO::get();
		$search = array(
			[
				'tableName' => 'tbl_inventario_producto_compra',
				'field' => 'id_tienda',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			],
			[
				'tableName' => 'tbl_inventario_producto_compra',
				'field' => 'lote',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]
		);
		$where = "";
		$table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
    }
    
    public static function infoLote($id_tienda,$lote)
    {
        return CompraAO::infoLote($id_tienda,$lote);
    }

    public static function getProveedor($tipo_documento,$documento)
    {
        return CompraAO::getProveedor($tipo_documento,$documento);
    }

    public static function getInventarioByName($referencia,$id_tienda)
    {
        return CompraAO::getInventarioByName($referencia,$id_tienda);
    }

    public static function getInfoVenta($id_tienda,$id_plan)
    {
        return CompraAO::getInfoVenta($id_tienda,$id_plan);
    }

    public static function getInfoVentaProductos($id_tienda,$id_plan)
    {
        return CompraAO::getInfoVentaProductos($id_tienda,$id_plan);
    }

    public static function createDirecta($data,$id_tienda)
    {
        $lote = date('YmdHis');
        $respuesta = CompraAO::createDirecta($data,$id_tienda,$lote);
        if($respuesta == 'Insertado')
        {
            $msm = ['msm' => Messages::$Compras['ok'], 'val' => true];
        }else{
            $msm = ['msm' => Messages::$Compras['error'], 'val' => false];
        }

        return $msm;
    }

    public static function devolverCompra($data)
    {
        $lote = date('YmdHis');
        $respuesta = CompraAO::devolverCompra($data);
        if($respuesta == 'Insertado')
        {
            $msm = ['msm' => Messages::$Devoluciones['ok'], 'val' => true];
        }else{
            $msm = ['msm' => Messages::$Devoluciones['error'], 'val' => false];
        }

        return $msm;
    }

}
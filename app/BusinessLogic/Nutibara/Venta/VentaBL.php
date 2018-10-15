<?php 

namespace App\BusinessLogic\Nutibara\Venta;
use App\AccessObject\Nutibara\Venta\VentaAO;
use config\messages;

class VentaBL
{
    public static function getCliente($tipo_documento,$documento)
    {
        return VentaAO::getCliente($tipo_documento,$documento);
    }

    public static function getInventarioByName($referencia,$id_tienda)
    {
        return VentaAO::getInventarioByName($referencia,$id_tienda);
    }

    public static function getInfoVenta($id_tienda,$id_plan)
    {
        return VentaAO::getInfoVenta($id_tienda,$id_plan);
    }

    public static function getInfoVentaProductos($id_tienda,$id_plan)
    {
        return VentaAO::getInfoVentaProductos($id_tienda,$id_plan);
    }

    public static function getListImpuesto($tipo)
    {
        return VentaAO::getListImpuesto($tipo);
    }

    public static function getNaturalezaBy($id)
    {
        return VentaAO::getNaturalezaBy($id);
    }

    public static function getNatBy($id)
    {
        return VentaAO::getNatBy($id);
    }

    public static function getConfContable($id)
    {
        return VentaAO::getConfContable($id);
    }

    public static function createDirecta($data,$id_tienda)
    {
        $lote = date('YmdHis');
        $respuesta = VentaAO::createDirecta($data,$id_tienda,$lote);
        if($respuesta == 'Insertado')
        {
            $msm = ['msm' => Messages::$Ventas['ok'], 'val' => true];
        }else{
            $msm = ['msm' => Messages::$Ventas['error'], 'val' => false];
        }

        return $msm;
    }

    public static function facturarPlan($request,$id,$id_tienda,$dataMov)
    {
        $respuesta = VentaAO::facturarPlan($request,$id,$id_tienda,$dataMov);
        if($respuesta)
        {
            $msm = ['msm' => Messages::$Ventas['ok'], 'val' => true];
        }else{
            $msm = ['msm' => Messages::$Ventas['error'], 'val' => false];
        }

        return $msm;
    }

    public static function getPrecioBolsa()
    {
        return VentaAO::getPrecioBolsa();
    }
}
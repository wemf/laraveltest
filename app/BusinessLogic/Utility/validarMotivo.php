<?php
namespace App\BusinessLogic\Utility;

class validarMotivo
{  
    public static function GetMotivo($val)
    {
        $valor = "-1";
        $val == 6 ? $valor = env('BLOQUEO_MOTIVO_INV_VITRINA') : null;
        $val == 7 ? $valor = env('BLOQUEO_MOTIVO_INV_REFACCION') : null;
        $val == 8 ? $valor = env('BLOQUEO_MOTIVO_INV_FUNDICION') : null;
        $val == 9 ? $valor = env('BLOQUEO_MOTIVO_INV_MAQUILA_NA') : null;
        $val == 10 ? $valor = env('BLOQUEO_MOTIVO_INV_JOYA_ESPE') : null;
        $val == 12 ? $valor = env('BLOQUEO_MOTIVO_INV_MAQUILA_IM') : null;
        
		return $valor;
    }

    public static function GetEstado()
    {
        return env('BLOQUEO_ESTADO_INV_PLAN');
    }

}


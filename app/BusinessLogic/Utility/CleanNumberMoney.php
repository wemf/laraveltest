<?php
namespace App\BusinessLogic\Utility;

class CleanNumberMoney
{  
    public static function Get($val)
    {
        $valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return (empty($valLimpiar))?null:$valLimpiar;
    }

}


<?php

namespace App\AccessObject\TipoMoneda;
use App\Models\Nutibara\Parametros\Parametros as TipoMonedaDB;


class TipoMonedaAO 
{	
	public static function getByPais($idPais)
    {
        return TipoMonedaDB::where('id_pais',$idPais)                          
                            ->first();
    } 
}

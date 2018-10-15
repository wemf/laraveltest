<?php

namespace App\BusinessLogic\TipoMoneda;
use App\AccessObject\TipoMoneda\TipoMonedaAO;


class TipoMonedaBase
{
    public function getByPais($idPais=12)
    {
        return TipoMonedaAO::getByPais($idPais);                          
    } 

}
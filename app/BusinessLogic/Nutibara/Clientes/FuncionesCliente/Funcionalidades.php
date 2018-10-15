<?php 

namespace App\BusinessLogic\Nutibara\Clientes\FuncionesCliente;

use App\AccessObject\Nutibara\Clientes\FuncionesCliente\Funcionalidades AS Datos;

class Funcionalidades {

    public function checkCountCliente($tipo_documento , $numero_documento)
    {
        $objeto = Datos::checkCountCliente($tipo_documento , $numero_documento);
        if(is_null($objeto))
            $objeto = NULL;
        return $objeto;
    }

    public function getparametroGeneral($id)
    {
        return Datos::getparametroGeneral($id);
    }

    public function getFranquiciaByTipoCliente($id)
    {
        return Datos::getFranquiciaByTipoCliente($id);
    }

    public function getSociedadByFranquicia($id)
    {
        return Datos::getSociedadByFranquicia($id);
    }

    public function getTiendaBySociedad($id,$franquicia,$sociedad)
    {
        return Datos::getTiendaBySociedad($id,$franquicia,$sociedad);
    }
}
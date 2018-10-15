<?php 

namespace App\Http\Controllers\Nutibara\Clientes\FuncionesCliente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Clientes\FuncionesCliente\Funcionalidades AS Negocio;

class FuncionalidadesController extends Controller{

    public function checkCountCliente(request $request)
    {
        $negocio = new Negocio();
        return $negocio->checkCountCliente($request->value['tipo_documento'] , $request->value['numero_documento']);
    }

    public static function getparametroGeneral(request $request){
        $negocio = new Negocio();
		$msm = $negocio->getparametroGeneral($request->value);
		return  response()->json($msm);
    }
    
    public static function getFranquiciaByTipoCliente(request $request){
        $negocio = new Negocio();
        $msm = $negocio->getFranquiciaByTipoCliente($request->value['id']);
		return  response()->json($msm);
    }

    public static function getSociedadByFranquicia(request $request){
        $negocio = new Negocio();
        $msm = $negocio->getSociedadByFranquicia($request->value['id']);
		return  response()->json($msm);
    }

    public static function getTiendaBySociedad(request $request){
        $negocio = new Negocio();
        $msm = $negocio->getTiendaBySociedad($request->value['id'],$request->value['franquicia'] , $request->value['sociedad']);
		return  response()->json($msm);
    }
}
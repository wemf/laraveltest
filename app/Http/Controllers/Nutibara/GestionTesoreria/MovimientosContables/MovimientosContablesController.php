<?php

namespace App\Http\Controllers\Nutibara\GestionTesoreria\MovimientosContables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\GestionTesoreria\MovimientosContables\CrudMovimientosContables AS mov_contables;
use App\BusinessLogic\Nutibara\CierreCaja\CrudCierreCaja;
use dateFormate;

class MovimientosContablesController extends Controller
{
    public function Index()
    {
        $ipValidation = new userIpValidated();
        $TiendaActual = Contrato::getTiendaByIp($ipValidation->getRealIP());
        $tipoDocumento = mov_contables::tipoDocumento();
        $paises = mov_contables::paises();
        $lastDate = CrudCierreCaja::getCierreCaja($TiendaActual->id);
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'GestionTesoreria',
				'text'=>'Movimientos Contables'
			]
        );
        return view('GestionTesoreria.MovimientosContables.index',[ 'urls'=>$urls,
                                                                    'TiendaActual' => $TiendaActual,
                                                                    'tipoDocumento' => $tipoDocumento,
                                                                    'paises' => $paises,
                                                                    'lastDate' => $lastDate
                                                                ]);
    }

    public function get(Request $request)
    {
        $ipValidation = new userIpValidated();
        $TiendaActual = Contrato::getTiendaByIp($ipValidation->getRealIP());
        $lastDate = CrudCierreCaja::getCierreCaja($TiendaActual->id);
    	return mov_contables::get($request,$lastDate->fecha_inicio);
    }

    public function exportToExcel(Request $request){
	  	return mov_contables::exportToExcel($request);
    }
    
    public function logMovimientosContables($codigo_cierre,$numero_orden,$id_tienda,$id_tipo_documento){
        return dateFormate::ToArrayInverse(mov_contables::logMovimientosContables($codigo_cierre,$numero_orden,$id_tienda,$id_tipo_documento)->toArray());
    }
}

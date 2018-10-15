<?php

namespace App\Http\Controllers\Nutibara\ReporteRotacion;
use App\BusinessLogic\Nutibara\ReporteRotacion\ReporteRotacionBL as reporteBL;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Middleware\userIpValidated;
use Illuminate\Support\Facades\Session;

class ReporteRotacionController extends Controller
{
    public function index()
    {
        $ipValidation = new userIpValidated();
		$tienda = reporteBL::getTiendaByIp($ipValidation->getRealIP());
		
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/ReporteRotacion',
				'text'=>'Pedidos'
			],
			[
				'href'=>'/ReporteRotacion',
				'text'=>'Reporte de rotación de inventario'
			]
		);
		
		return view('ReporteRotacion.index',['urls'=>$urls,'tienda' => $tienda]);
    }

    public function get(request $request)
    {
        return reporteBL::get($request);
    }
}

?>
<?php

namespace App\Http\Controllers\Nutibara\Inventario\Trazabilidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Inventario\InventarioBL;
use App\BusinessLogic\Nutibara\Inventario\Trazabilidad\TrazabilidadBL;

class TrazabilidadController extends Controller
{
	/*Vista del index */
    public function Index(){		
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'inventario',
				'text'=>'Gestión Inventario'
			],
			[
				'href'=>'inventario/trazabilidad',
				'text'=>'Trazabilidad de los Ids'
			]
		);
        return view('Inventario.Trazabilidad.index',['urls'=>$urls]);
	}

	/*Carga la tabla del index */
	public function Get(Request $request)
	{
		return TrazabilidadBL::Get($request);
	}

	/*Carga la tabla del index */
	public function Create($traza)
	{
		return TrazabilidadBL::Create($traza);
	}
}
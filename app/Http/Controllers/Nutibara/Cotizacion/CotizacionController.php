<?php

namespace App\Http\Controllers\Nutibara\Cotizacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Cotizacion\CotizacionBL;
use App\Http\Middleware\userIpValidated;
use App\BusinessLogic\Nutibara\GenerarPlan\CrudGenerarPlan;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use dateFormate;
use Session;
use Auth;

class CotizacionController extends Controller
{
    public function index()
	{
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'generarplan',
				'text'=>'Gestión Plan Separe'
			],
			[
				'href'=>'cotizacion',
				'text'=>'Cotización'
			]
		);
		return view('Cotizacion.index',['urls' => $urls]);
	}

    public function get(request $request)
    {
        return CotizacionBL::get($request);
	}
	
	public function create(){		
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'cotizacion',
				'text'=>'Cotización'
			],
			[
				'href' => 'cotizacion/create',
				'text' => 'Solicitar cotización'
			],
		);
		return view('Cotizacion.create',['urls' => $urls]);
	}

    public function store(request $request){
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$codigo_transaccion = SecuenciaTienda::getCodigosSecuencia($tienda->id,(int)37,(int)1);
		$msm = CotizacionBL::store($request,$tienda->id,Auth::user()->id,$codigo_transaccion[0]->response);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
			return redirect('/cotizacion');
		}
		else{
			Session::flash('error', $msm['msm']);
		}
		return redirect()->back();
	}

	public function update($id_tienda,$id_cotizacion){	
		$data = dateFormate::ToArrayInverse(CotizacionBL::cotizacionById($id_tienda,$id_cotizacion)->toArray());
		$data = (object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'cotizacion',
				'text'=>'Cotización'
			],
			[
				'href' => 'cotizacion/create/'.$id_tienda.'/'.$id_cotizacion,
				'text' => 'Ver Cotización'
			],
		);
		return view('Cotizacion.update',['urls' => $urls,'data' => $data]);
	}

	public function storeUpdate(request $request){
		$msm = CotizacionBL::storeUpdate($request);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
			return redirect('/cotizacion');
		}
		else{
			Session::flash('error', $msm['msm']);
		}
		return redirect()->back();
	}

	public function cotizacionById($id_tienda,$id_cotizacion)
	{
		$response = CotizacionBL::cotizacionById($id_tienda,$id_cotizacion);
		return response()->json($response);
	}

}

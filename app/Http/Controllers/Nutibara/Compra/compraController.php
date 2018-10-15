<?php

namespace App\Http\Controllers\nutibara\compra;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\Empleado\CrudEmpleado;
use App\BusinessLogic\FileManager\FileManagerSingle;
use App\BusinessLogic\Nutibara\Clientes\PersonaNatural\CrudPersonaNatural;
use App\Http\Middleware\userIpValidated;
use App\BusinessLogic\Nutibara\Tienda\CrudTienda;
use App\BusinessLogic\Nutibara\GenerarPlan\CrudGenerarPlan;
use App\AccessObject\Nutibara\Pais\Pais;
use App\BusinessLogic\Nutibara\Compra\CompraBL;
use App\AccessObject\Nutibara\Tienda\Tienda;
use Illuminate\Support\Facades\Session;

class compraController extends Controller
{
    public function index()
    {
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'Pedidos',
				'text'=>'Pedidos'
			],
			[
				'href'=>'compras',
				'text'=>'Compras'
			]
		);
		return view('Compra.Compra',['urls'=>$urls]);
	}
	
	public function get(Request $request){
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
    	return CompraBL::get($request,$tienda);
    }

    public function createCompraDirecta()
    {
        $tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$pdc = CrudTienda::getPDC($tienda->id);
		$fecha = date('Y-m-d');
        $pais = Pais::getSelectList();
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'Pedidos',
				'text'=>'Pedidos'
			],
			[
				'href'=>'compra',
				'text'=>'Compra'
            ],
            [
				'href'=>'compras/createCompra',
				'text'=>'Ingreso de compra'
            ]
        );
        
        return view('Compra.compraDirecta',[
											'tipo_documento' => $tipo_documento,
											'pdc' => $pdc,
											'urls' => $urls,
											'fecha' => $fecha,
											'pais' => $pais,
										]);
    }

    public function createVentaPlan($id_tienda,$id_plan)
    {
		$data = CompraBL::getInfoVenta($id_tienda,$id_plan);
		$dataProductos = CompraBL::getInfoVentaProductos($id_tienda,$id_plan);
        $tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$pdc = CrudTienda::getPDC($tienda->id);
		$fecha = date('Y-m-d');
        $pais = Pais::getSelectList();
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'Pedidos',
				'text'=>'Pedidos'
			],
			[
				'href'=>'compras',
				'text'=>'compras'
            ],
            [
				'href'=>'compras/createVentaDirecta',
				'text'=>'Factura venta directa'
            ]
        );
        
        return view('Venta.ventaPlan',[
											'tipo_documento' => $tipo_documento,
											'pdc' => $pdc,
											'urls' => $urls,
											'fecha' => $fecha,
											'pais' => $pais,
											'data' => $data,
											'dataProductos' => $dataProductos
										]);
    }

    public function getProveedor(request $request)
    {
        $response = CompraBL::getProveedor($request->tipo_documento,$request->documento);
        return response()->json($response);
    }

    public function getInventarioByName(request $request)
    {
        $ipValidation = new userIpValidated();
		$tienda = Tienda::getTiendaByIp($ipValidation->getRealIP());
        $response = CompraBL::getInventarioByName($request->referencia,$tienda->id);
        return response()->json($response);
	}
	
	public function createDirecta(request $request)
	{
		// dd($request->all());
		$ipValidation = new userIpValidated();
		$tienda = Tienda::getTiendaByIp($ipValidation->getRealIP());
		// dd($request->all());
		$msm = CompraBL::createDirecta($request,$tienda->id);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
			return redirect('/compras');
		}
		elseif(!$msm['val']){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
	}

	public function devolucion(request $request)
    {
		$datos = CompraBL::infoLote($request->id_tienda,$request->lote);
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'Pedidos',
				'text'=>'Pedidos'
			],
			[
				'href'=>'compras',
				'text'=>'Compras'
			],
			[
				'href'=>'compras/devolucion/'.$request->id_tienda.'/'.$request->lote,
				'text'=>'Devolución'
			]
		);
		return view('Compra.Devolucion',['urls'=>$urls,'datos'=>$datos]);
	}

	public function devolverCompra(request $request)
	{
		$response = CompraBL::devolverCompra($request->datos);
        return response()->json($response);
	}

}



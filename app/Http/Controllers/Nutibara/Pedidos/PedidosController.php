<?php

namespace App\Http\Controllers\Nutibara\Pedidos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Tienda\Tienda as TiendaAO;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda as SecuenciaAO;
use App\BusinessLogic\Nutibara\Pedidos\PedidosBL;

class PedidosController extends Controller
{

	public function get(request $request)
	{
		return PedidosBL::get($request);
	}

    public function Index()
    {
		$estados = PedidosBL::getEstados();
		$categorias = PedidosBL::getCategorias();
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'pedidos',
				'text'=>'Pedidos'
			]
        );
        return view('Pedidos.index',['urls'=>$urls,'estados' => $estados,'categorias' => $categorias]);
	}
	
	public function create(request $request)
	{
		$ipValidation = new userIpValidated();
		$tienda = TiendaAO::getTiendaByIp($ipValidation->getRealIP());
		$secuencia = SecuenciaAO::getCodigosSecuencia($tienda->id,(int)31,(int)1);
		$data = PedidosBL::getTransformData($request->referencia,$tienda->id);
		
		$urls = array(
			[
				'href' => 'home',
				'text' => 'home'
			],
			[
				'href' => 'pedidos',
				'text' => 'Pedidos'
			],
			[
				'href' => 'pedidos/create/'.$request->referencia,
				'text' => 'Generar pedido'
			]
		);

		return view('Pedidos.create',[
										'urls' => $urls,
										'numero_orden' => $secuencia[0]->response,
										'data' => $data
									]);
	}

	public function createPost(request $request)
	{
		$ipValidation = new userIpValidated();
		$tienda = TiendaAO::getTiendaByIp($ipValidation->getRealIP());
		$msm = PedidosBL::create($request,$tienda->id);
		// dd($msm);
		if($msm['val'] == "Insertado")
		{
			Session::flash('message',$msm['msm']);
			return redirect('/pedidos');
		}else{
			Session::flash('error',$msm['error']);
		}
		return redirect()->back();
	}

	public function updatePedidoAjax(request $request)
	{	
		$paso = self::validarEstado($request->id_pedido,$request->id_tienda);
		if($paso->id_estado == env('PEDIDO_RECHAZADO'))
		{
			$msm = ['msm' => 'El pedido no se puede actualizar la información el pedido se encuntra rechazado.','val' => 'Error'];
		}elseif($paso->id_estado == env('PEDIDO_BORRADOR'))
		{
			$msm = ['msm' => 'El pedido no se ha generado no se puede actualizar la información.','val' => 'Error'];
		}else{
			$msm = PedidosBL::updatePedidoAjax($request->id_pedido,$request->id_tienda,$request->id_referencia,$request->valor,$request->g);
			if($msm['val'] == 'Insertado')
			{
				Session::flash('message',$msm['msm']);
			}else{
				Session::flash('error',$msm['error']);
			}
		}
		return response()->json($msm);
	}

	public function aprobar(request $request)
	{
		$valores = explode("/",$request->value);
		$id_pedido = $valores[0];
		$id_tienda = $valores[1];
		$id_refencia = $valores[2];
		$id_tienda_pedido = $valores[3];

		$paso = self::validarEstado($id_pedido,$id_tienda);
		if($paso->id_estado == env('PEDIDO_RECHAZADO'))
		{
			$msm = ['msm' => 'El pedido no se puede aprobar ya que se encuentra rechazado.','val' => 'Error'];
		}elseif($paso->id_estado == env('PEDIDO_APROBADO'))
		{
			$msm = ['msm' => 'El pedido ya se encuentra aprobado.','val' => 'Error'];
		}elseif($paso->id_estado == env('PEDIDO_BORRADOR'))
		{
			$msm = ['msm' => 'Antes de aprobar el pedido hay que generarlo.','val' => 'Error'];
		}else{
			$msm = PedidosBL::aprobar($id_pedido,$id_tienda_pedido,$request->num_aprobacion);
			if($msm['val'] == 'Insertado')
			{
				Session::flash('message',$msm['msm']);
			}else{
				Session::flash('error',$msm['error']);
			}
		}
		return response()->json($msm);
	}

	public function rechazar(request $request)
	{
		$valores = explode("/",$request->value);
		$id_pedido = $valores[0];
		$id_tienda = $valores[1];
		$id_refencia = $valores[2];
		$id_tienda_pedido = $valores[3];

		$paso = self::validarEstado($id_pedido,$id_tienda);
		if($paso->id_estado == env('PEDIDO_RECHAZADO'))
		{
			$msm = ['msm' => 'El pedido ya se encuentra rechazado.','val' => 'Error'];
		}elseif($paso->id_estado == env('PEDIDO_APROBADO'))
		{
			$msm = ['msm' => 'El pedido no se puede rechazar ya que se encuentra aprobado.','val' => 'Error'];
		}elseif($paso->id_estado == env('PEDIDO_BORRADOR'))
		{
			$msm = ['msm' => 'Antes de aprobar el pedido hay que generarlo.','val' => 'Error'];
		}else{
			$msm = PedidosBL::rechazar($id_pedido,$id_tienda_pedido);
			if($msm['val'] == 'Insertado')
			{
				Session::flash('message',$msm['msm']);
			}else{
				Session::flash('error',$msm['error']);
			}
		}
		return response()->json($msm);
	}

	public function ver($id_pedido,$id_tienda)
	{
		$data = PedidosBL::InfoPedido($id_pedido,$id_tienda);
		$urls = array(
			[
				'href' => 'home',
				'text' => 'home'
			],
			[
				'href' => 'pedidos',
				'text' => 'Pedidos'
			],
			[
				'href' => 'pedidos/ver/'.$id_pedido.'/'.$id_tienda,
				'text' => 'Ver pedido'
			]
		);
		return view('Pedidos.update',['urls' => $urls,'data'=>$data,'id_tienda_pedido' => $id_tienda]);
	}

	public function validarEstado($id_pedido,$id_tienda)
	{
		return PedidosBL::validarEstado($id_pedido,$id_tienda);
	}

	public function updatePost(request $request)
	{
		$ipValidation = new userIpValidated();
		$tienda = TiendaAO::getTiendaByIp($ipValidation->getRealIP());
		(empty($request->generar_pedido)) ? $msm = PedidosBL::updateBorrador($request) : $msm = PedidosBL::updateGenerar($request);
	
		// dd($msm);
		if($msm['val'])
		{
			Session::flash('message',$msm['msm']);
			return redirect('/pedidos');
		}else{
			Session::flash('error',$msm['error']);
		}
		return redirect()->back();
	}
}

?>
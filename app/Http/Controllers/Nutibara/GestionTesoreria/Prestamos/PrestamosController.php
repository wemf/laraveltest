<?php

namespace App\Http\Controllers\Nutibara\GestionTesoreria\Prestamos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\GestionTesoreria\Prestamos\CrudPrestamos;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Contratos\Contrato;
use Illuminate\Support\Facades\Session;
use App\AccessObject\Nutibara\Sociedad\Sociedad;
use App\BusinessLogic\Nutibara\Sociedad\CrudSociedad;
use Illuminate\Support\Facades\Auth;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use dateFormate;

class PrestamosController extends Controller
{
    public function Index(){

		$ipValidation = new userIpValidated();
		$tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$sociedades = CrudSociedad::getSelectList();
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/prestamos',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/prestamos',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/prestamos',
				'text'=>'Prestamos'
			]
		);
		return view('GestionTesoreria.Prestamos.index',['urls'=>$urls,'sociedades' => $sociedades]);
    }

	public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["sociedad_prestadora"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["id_tienda_presta"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["id_tienda"] = str_replace($vowels, "", $request->columns[5]['search']['value']);
		$total=CrudPrestamos::getCountPrestamos($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudPrestamos::Prestamos($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function Create(){
		$ipValidation = new userIpValidated();
		$tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$sociedad = Sociedad::getSelectSociedadByTienda($tienda->id);		
		$sociedades = CrudSociedad::getSelectList();		
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/prestamos',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/prestamos',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/prestamos',
				'text'=>'Prestamos'
			],
			[
				'href' => 'tesoreria/prestamos',
				'text' => 'Realizar Prestamos'
			],
		);
		return view('GestionTesoreria.Prestamos.create',['urls'=>$urls, 'sociedad'=> $sociedad,'sociedades' => $sociedades]);
    }

    public function Delete(request $request){
		$msm=CrudPrestamos::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudPrestamos::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudPrestamos::getPrestamosById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/prestamos',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/prestamos',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/prestamos',
				'text'=>'Prestamos'
			],
			[
				'href' => 'tesoreria/prestamos/update/'.$data->id,
				'text' => 'Actualizar Prestamos'
			]
		);
		return view('GestionTesoreria.Prestamos.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => $request->nombre
 		];
		$msm=CrudPrestamos::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/tesoreria/prestamos');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
		
	}

	public function CreatePost(request $request){
		$ipValidation = new userIpValidated();
		$tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$user = Auth::user()->id;		
		$request->valor = str_replace('.','',$request->valor);

		$dataSaved=[
			'id_tienda' => $tienda->id,
			'sociedad_prestadora' => $request->sociedad_prestadora,
			'id_tienda_presta' => $request->id_tienda_presta,
			'id_usuario' => $user,
			'fecha_pago' => Date('Y-m-d H:i:s'),
			'valor' => $request->valor,
		];
		$msm=CrudPrestamos::Create($dataSaved);
		if($msm['val']=='Insertado'){
			//Se registra primero el retiro de la tienda que prestará
			$referencia = 'PRESTAMOSOC- '.$tienda->id;
			MovimientosTesoreria::registrarMovimientos($request->valor,$tienda->id,env('CONFIGUACION_CONTABLE_ENVIAR_PRESTAMO'),null,$referencia);
			//Se registra el movimiento de la tienda que recibe
			$referencia = 'PRESTAMOSOC- '.$request->id_tienda_presta;
			MovimientosTesoreria::registrarMovimientos($request->valor,$request->id_tienda_presta,env('CONFIGUACION_CONTABLE_RECIBIR_PRESTAMO'),null,$referencia);
			Session::flash('message', $msm['msm']);
			return redirect('/tesoreria/prestamos');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
		
	}

	public function getSelectList()
	{
		$msm = CrudPrestamos::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListById(request $request)
	{
		$msm = CrudPrestamos::getSelectListById($request->id);
		return  response()->json($msm);
	}

}

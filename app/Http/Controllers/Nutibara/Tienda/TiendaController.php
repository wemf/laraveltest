<?php

namespace App\Http\Controllers\Nutibara\Tienda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Tienda\CrudTienda;
use Illuminate\Support\Facades\Session;
use dateFormate;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use DB;

class TiendaController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tienda',
				'text'=>'Administración General'
			],
			[
				'href'=>'tienda',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'tienda',
				'text'=>'Joyerías/Establecimientos Administrativos'
			]
		);
		return view('Tienda.index',['urls'=>$urls]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["pais"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["departamento"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["ciudad"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["zona"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$search["sociedad"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
		$search["franquicia"] = str_replace($vowels, "", $request->columns[5]['search']['value']);
		$search["tienda"] = str_replace($vowels, "", $request->columns[6]['search']['value']);
		$search["codigo_tienda"] = str_replace($vowels, "", $request->columns[7]['search']['value']);
		$search["ip_tienda"] = str_replace($vowels, "", $request->columns[8]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[9]['search']['value']);
		$total=CrudTienda::getCountTienda($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudTienda::Tienda($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getTiendaByZona(request $request){
		$zona = $request->id;
		$msm = CrudTienda::getTiendaByZona($zona);
		return response()->json($msm);
	}

	public function getTiendaBySociedad(request $request){
		$sociedad = $request->id;
		$msm = CrudTienda::getTiendaBySociedad($sociedad);
		return response()->json($msm);
	}
	
	public function getTiendaByZona2(request $request){
		$zona = $request->id;
		$msm = CrudTienda::getTiendaByZona2($zona);
		return response()->json($msm);
    }

    public function getTiendaValueById(request $request) 
	{
		$response = CrudTienda::getTiendaValueById($request->id);
		return response()->json($response);
	}

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tienda',
				'text'=>'Administración General'
			],
			[
				'href'=>'tienda',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'tienda',
				'text'=>'Joyerías/Establecimientos Administrativos'
			],
			[
				'href' => 'tienda/create',
				'text' => 'Crear Joyería/Establecimiento Administrativo'
			],
		);
		return view('Tienda.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'codigo_tienda' => 'required',
			'nombre' => 'required',
			'ip_fija' => 'required',
		]);

		$request->monto_max = str_replace('.','',$request->monto_max);		
		$request->saldo_cierre_caja = str_replace('.','',$request->saldo_cierre_caja);		
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'ip_fija' => trim($request->ip_fija),
			'direccion' => trim($request->direccion),
			'telefono' => trim($request->telefono),
			'codigo_tienda' => trim($request->codigo_tienda),			
			'id_sociedad' => (int)$request->id_sociedad,
			'id_ciudad' => (int)$request->id_ciudad,
			'id_franquicia' => (int)$request->id_franquicia,
			'id_zona' => (int)$request->id_zona,
			'tienda_padre' => $request->tienda_padre,
			'festivo' => (int)$request->festivo,
			'todoeldia' => (int)$request->todoeldia,
			'todoeldia' => (int)$request->todoeldia,
			'estado' => 1,
			'abierto' => 1,
			'tipo_bodega' => (int)$request->tipo_bodega,
			'sede_principal' => (int)$request->sede_principal,
			'monto_max' => (int)$request->monto_max,
		];
		$saldo_cierre_caja = (int)$request->saldo_cierre_caja;
		$horario=[
			0 => 
			[
				'hora_inicio' => $request->lunesH1,
				'hora_cierre' => $request->lunesH2,
			],
			1 => 
			[
				'hora_inicio' => $request->martesH1,
				'hora_cierre' => $request->martesH2
			],
			2 => 
			[
				'hora_inicio' => $request->miercolesH1,
				'hora_cierre' => $request->miercolesH2
			],
			3 => 
			[
				'hora_inicio' => $request->juevesH1,
				'hora_cierre' => $request->juevesH2
			],
			4 =>
			[ 
				'hora_inicio' => $request->viernesH1,
				'hora_cierre' => $request->viernesH2
			],
			5 =>
			[ 
				'hora_inicio' => $request->sabadoH1,
				'hora_cierre' => $request->sabadoH2
			],
			6 =>
			[ 
				'hora_inicio' => $request->domingoH1,
				'hora_cierre' => $request->domingoH2
			]
		];
		
		$msm=CrudTienda::Create($dataSaved,$horario, $saldo_cierre_caja);
		
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/tienda');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
    }

    public function Delete(request $request){
		$msm=CrudTienda::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		
		$data=dateFormate::ToArrayInverse(CrudTienda::getTiendaById($id)->toArray());
		$data=(object)$data;
		$horario = CrudTienda::getHorarioByIdTienda($id);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tienda',
				'text'=>'Administración General'
			],
			[
				'href'=>'tienda',
				'text'=>'Maestro de Estructura de Negocio'
			],
			[
				'href'=>'tienda',
				'text'=>'Joyerías/Establecimientos Administrativos'
			],
			[
				'href' => 'tienda/update/'.$id,
				'text' => 'Actualizar Joyería/Establecimiento Administrativo'
			],
		);
		return view('Tienda.update',['attribute' => $data,'horario' => $horario,'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'nombre' => 'required',
			'direccion' => 'required',
			'telefono' => 'required',
			'id_sociedad' => 'required',
			'id_ciudad' => 'required',			
			'id_zona' => 'required',			
			'id_franquicia' => 'required',
		]);
		
		$request->monto_max = str_replace('.','',$request->monto_max);				
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'ip_fija' => trim($request->ip_fija),
			'direccion' => trim($request->direccion),
			'telefono' => trim($request->telefono),
			'codigo_tienda' => trim($request->codigo_tienda),
			'id_sociedad' => (int)$request->id_sociedad,
			'id_ciudad' => (int)$request->id_ciudad,			
			'id_franquicia' => (int)$request->id_franquicia,
			'id_zona' => (int)$request->id_zona,		
			'festivo' => (int)$request->festivo,
			'todoeldia' => (int)$request->todoeldia,	
			'tienda_padre' => (int)$request->tienda_padre,
			'tipo_bodega' => (int)$request->tipo_bodega,
			'sede_principal' => (int)$request->sede_principal,
			'monto_max' => (int)$request->monto_max,						
		];
			$horario=[
				0 => 
				[
					'hora_inicio' => $request->lunesH1,
					'hora_cierre' => $request->lunesH2,
				],
				1 => 
				[
					'hora_inicio' => $request->martesH1,
				    'hora_cierre' => $request->martesH2
				],
				2 => 
				[
					'hora_inicio' => $request->miercolesH1,
					'hora_cierre' => $request->miercolesH2
				],
				3 => 
				[
					'hora_inicio' => $request->juevesH1,
					'hora_cierre' => $request->juevesH2
				],
				4 =>
				[ 
					'hora_inicio' => $request->viernesH1,
					'hora_cierre' => $request->viernesH2
				],
				5 =>
				[ 
					'hora_inicio' => $request->sabadoH1,
					'hora_cierre' => $request->sabadoH2
				],
				6 =>
				[ 
					'hora_inicio' => $request->domingoH1,
					'hora_cierre' => $request->domingoH2
				]
			];
		$msm=CrudTienda::Update($id,$dataSaved,$horario);

		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/tienda');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
	}
	public function Active(request $request){
		$msm=CrudTienda::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function getSelectList()
	{
		$msm = CrudTienda::getSelectList();
		return  response()->json($msm);
	}

	public function getTiendaByCiudad($id)
	{
		$query = CrudTienda::getTiendaByCiudad($id);
		return  response()->json($query);
	}
	public function getTiendaCiudad(request $request)
	{
		$query = CrudTienda::getTiendaByCiudad($request->id);
		return  response()->json($query);
	}

	public function getTiendaByDepartamento($id)
	{
		$query = CrudTienda::getTiendaByDepartamento($id);
		return  response()->json($query);
	}

	public function getTiendaByPais($id)
	{
		$query = CrudTienda::getTiendaByPais($id);
		return  response()->json($query);
	}

	public function getTiendaisnt(request $request)
	{
		$query = CrudTienda::getTiendaisnt($request->id);
		return  response()->json($query);
	}

	public function selectTiendaBySociedad(request $request )
	{
		$query = CrudTienda::selectTiendaBySociedad($request->id);
		return  response()->json($query);
	}

	public function ValidateMarket(request $request )
	{
		$resultado = CrudTienda::ValidateMarket(trim($request->campo) ,trim($request->data));
		return  response()->json($resultado);
	}

	public function getPDC($id_tienda)
	{
		$response = CrudTienda::getPDC($id_tienda);
		return $response()->json($response);
	}

	public function Abrir()
	{
		$ipValidation = new userIpValidated();
		$Tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$msm = CrudTienda::Abrir($Tienda->id);
		if($msm['val']=='Abierto'){
			Session::flash('message', $msm['msm']);
			return redirect('/home');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		return redirect()->back();
	}

	public function getMontoMax(request $request)
	{
		$query = CrudTienda::getMontoMax($request->id_tienda);
		return  response()->json($query);
	}

	public function arregloTiendas(){
		$result="Datos de la tienda configurados correctamente";
		try{
			DB::beginTransaction();
			self::cierreCajas();
			self::secuenciasCierreCaja();	
			self::secuenciasDetalleMovimiento();	
			self::secuenciasMovimientoContable();	
			DB::commit();
		}catch(\Exception $e){
			$result="Ocurrió un error al intentar configurar los datos de la tienda";			
			DB::rollback();
		}
		return $result;
	}

	public function cierreCajas(){
		$tiendas_cierres = DB::table('tbl_tes_cierre_caja')->select('id_tienda')->distinct()->get();
		$tiendas_cierres = json_decode(json_encode($tiendas_cierres), true);
		$tiendas = DB::table('tbl_tienda')->select('id')->whereNotIn('id', (array)$tiendas_cierres)->get();
		$tiendas = json_decode(json_encode($tiendas), true);

		for ($i=0; $i < count($tiendas); $i++) { 
			$secuencias = SecuenciaTienda::getCodigosSecuencia($tiendas[$i]["id"],env('SECUENCIA_TIPO_CODIGO_CIERRE_CAJA'),1);
			$codigoCierre = $secuencias[0]->response;
			$dataCierre=
			[
				'id_cierre' => $codigoCierre,
				'id_tienda' => $tiendas[$i]["id"],
				'fecha_inicio' => date("Y-m-d H:i:s"),
				'saldo_inicial' => 0,
				'cliclo' => 0
			];
			
			\DB::table('tbl_tes_cierre_caja')->insert($dataCierre);

		}
		
	}

	public function secuenciasCierreCaja(){
		$tiendas_secuencias = DB::table('tbl_secuencia_tienda_x')->select('id_tienda')->where('sec_tipo', env('SECUENCIA_TIPO_MOVIMIENTO_CIERRE_CAJA'))->distinct()->get();
		$tiendas_secuencias = json_decode(json_encode($tiendas_secuencias), true);
		$tiendas = DB::table('tbl_tienda')->select('id')->whereNotIn('id', (array)$tiendas_secuencias)->get();
		$tiendas = json_decode(json_encode($tiendas), true);

		for ($i=0; $i < count($tiendas); $i++) { 
			$dataSecuencia=
			[
				'id_tienda' => $tiendas[$i]["id"],
				'sede_principal' => 0,
				'estado' => 1,
				'sec_siguiente' => 1,
				'sec_desde' => 1,
				'sec_hasta' => 1000000,
				'sec_tipo' => env('SECUENCIA_TIPO_MOVIMIENTO_CIERRE_CAJA')
			];
			\DB::table('tbl_secuencia_tienda_x')->insert($dataSecuencia);

		}
		
	}

	public function secuenciasDetalleMovimiento(){
		$tiendas_secuencias = DB::table('tbl_secuencia_tienda_x')->select('id_tienda')->where('sec_tipo', env('SECUENCIA_TIPO_DETALLE_MOVIMIENTO_CIERRE_CAJA'))->distinct()->get();
		$tiendas_secuencias = json_decode(json_encode($tiendas_secuencias), true);
		$tiendas = DB::table('tbl_tienda')->select('id')->whereNotIn('id', (array)$tiendas_secuencias)->get();
		$tiendas = json_decode(json_encode($tiendas), true);

		for ($i=0; $i < count($tiendas); $i++) { 
			$dataSecuencia=
			[
				'id_tienda' => $tiendas[$i]["id"],
				'sede_principal' => 0,
				'estado' => 1,
				'sec_siguiente' => 1,
				'sec_desde' => 1,
				'sec_hasta' => 1000000,
				'sec_tipo' => env('SECUENCIA_TIPO_DETALLE_MOVIMIENTO_CIERRE_CAJA')
			];
			\DB::table('tbl_secuencia_tienda_x')->insert($dataSecuencia);

		}
		
	}

	public function secuenciasMovimientoContable(){
		$tiendas_secuencias = DB::table('tbl_secuencia_tienda_x')->select('id_tienda')->where('sec_tipo', env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'))->distinct()->get();
		$tiendas_secuencias = json_decode(json_encode($tiendas_secuencias), true);
		$tiendas = DB::table('tbl_tienda')->select('id')->whereNotIn('id', (array)$tiendas_secuencias)->get();
		$tiendas = json_decode(json_encode($tiendas), true);

		for ($i=0; $i < count($tiendas); $i++) { 
			$dataSecuencia=
			[
				'id_tienda' => $tiendas[$i]["id"],
				'sede_principal' => 0,
				'estado' => 1,
				'sec_siguiente' => 1,
				'sec_desde' => 1,
				'sec_hasta' => 1000000,
				'sec_tipo' => env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE')
			];
			\DB::table('tbl_secuencia_tienda_x')->insert($dataSecuencia);

		}
		
	}

	
}

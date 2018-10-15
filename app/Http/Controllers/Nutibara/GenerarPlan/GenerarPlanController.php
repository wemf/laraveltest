<?php

namespace App\Http\Controllers\Nutibara\GenerarPlan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Middleware\userIpValidated;
use App\BusinessLogic\Nutibara\GenerarPlan\CrudGenerarPlan;
use App\BusinessLogic\Nutibara\Clientes\Empleado\CrudEmpleado;
use App\BusinessLogic\Nutibara\Pais\CrudPais;
use App\BusinessLogic\Nutibara\Sociedad\CrudSociedad;
use App\BusinessLogic\Nutibara\Tienda\CrudTienda;
use App\BusinessLogic\Nutibara\Contratos\ProrrogarContrato;
use App\BusinessLogic\Nutibara\Clientes\PersonaNatural\CrudPersonaNatural;
use App\BusinessLogic\FileManager\FileManagerSingle;
use App\BusinessLogic\Nutibara\Clientes\TipoDocumento\CrudTipoDocumento;
use App\AccessObject\Nutibara\GenerarPlan\GenerarPlan;
use App\AccessObject\Nutibara\Clientes\PersonaNatural\PersonaNatural;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\AccessObject\Nutibara\Tienda\Tienda;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use App\AccessObject\Nutibara\Pais\Pais;
use dateFormate;
use Auth;
use PDF;

class GenerarPlanController extends Controller
{
	public function pdfabono()
	{
		return view('GenerarPlan.pdfabono');
	}

    public function Index(){
		$ipValidation = new userIpValidated();
		$tienda = Tienda::getTiendaByIp($ipValidation->getRealIP());
		$id_tienda = 0;
		if($tienda != null)$id_tienda = $tienda->id;
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$estados = CrudGenerarPlan::getEstados();
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			]
		);
		$tienda = CrudTienda::getSelectList();
    	return view('GenerarPlan.index',['tienda' => $tienda,'id_tienda'=>$id_tienda,'urls'=>$urls,'estados'=>$estados,'tipo_documento' => $tipo_documento]);
    }

    public function get(Request $request){
		$ipValidation = new userIpValidated();
		$tienda = Tienda::getTiendaByIp($ipValidation->getRealIP());
    	return CrudGenerarPlan::get($request,$tienda);
    }

    public function getGenerarPlan(Request $request){
		$msm = CrudGenerarPlan::getGenerarPlan();
		return response()->json($msm);
    }

    public function getGenerarPlanValueById(request $request){
		$response = CrudGenerarPlan::getGenerarPlanValueById($request->id);
		return response()->json($response);
	}

	public function getConfig(request $request){
		$response = CrudGenerarPlan::getConfig($request->id_pais,$request->id_departamento,$request->id_ciudad,$request->id_tienda,$request->monto);
		return response()->json($response);
	}

    public function Create(){
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$confiabilidad = GenerarPlan::getSelectListConfiabilidad();
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$pdc = CrudTienda::getPDC($tienda->id);
		// $config = CrudGenerarPlan::getConfig($pdc->id_pais,$pdc->id_departamento,$pdc->id_ciudad,$pdc->id_tienda);
		// $dias = 30 * $config[0]->termino_contrato;
		// $fecha = date('Y-m-d');
		// $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
		// $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$pais = Pais::getSelectList();
		$cotizaciones = CrudGenerarPlan::getSelectListCotizacion($tienda->id);
		$fecha = date("d-m-Y");
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/create',
				'text' => 'Crear Plan Separe'
			],
		);
    	return view('GenerarPlan.create',[
											'tipo_documento' => $tipo_documento,
											'pdc' => $pdc,
											'urls' => $urls,
											'fecha' => $fecha,
											'id_tienda' => $tienda->id,
											// 'fecha_plazo' => $nuevafecha,
											// 'config' => $config,
											'pais' => $pais,
											'confiabilidad' => $confiabilidad
 											// 'cotizaciones' => $cotizaciones
										]);
	}

	public function CreateParam($tipodocumento, $numdocumento, $pa = null, $sa = null, $pn = null, $sn = null, $fn = null, $gen = null, $rh = null){
		if(CrudGenerarPlan::docGenerCotr($tipodocumento) == "1"){
    		return self::CreateParamIndex($tipodocumento, $numdocumento, $pa, $sa, $pn, $sn, $fn, $gen, $rh);
		} else {
			Session::flash('warning', 'Seleccione un registro');
			return redirect()->back();
		}
	}
	
	public function CreateParamIndex($tipodocumento, $numdocumento, $pa = null, $sa = null, $pn = null, $sn = null, $fn = null, $gen = null, $rh = null){
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$info_cliente = PersonaNatural::getClienteByDocumento($tipodocumento, $numdocumento);
		$nombres = "";
		$nombre1 = "";
		$nombre2 = "";
		if($info_cliente != null){
			$nombres = explode(" ",$info_cliente->nombres);
			$nombre1 = $nombres[0];
			$nombre2 = $nombres[1];
		}
		$regimen = 1;
		if($info_cliente != null) $regimen = $info_cliente->regimen;
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$pdc = CrudTienda::getPDC($tienda->id);
		// $config = CrudGenerarPlan::getConfig($pdc->id_pais,$pdc->id_departamento,$pdc->id_ciudad,$pdc->id_tienda);
		// $dias = 30 * $config[0]->termino_contrato;
		// $fecha = date('Y-m-d');
		// $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
		// $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$pais = Pais::getSelectList();
		$cotizaciones = CrudGenerarPlan::getSelectListCotizacion($tienda->id);
		$fecha = date("d-m-Y");
		$confiabilidad = GenerarPlan::getSelectListConfiabilidad();
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/create',
				'text' => 'Crear Plan Separe'
			],
		);
		
    	return view('GenerarPlan.create',[
											'tipo_documento' => $tipo_documento,
											'pdc' => $pdc,
											'urls' => $urls,
											'fecha' => $fecha,
											'id_tienda' => $tienda->id,
											// 'fecha_plazo' => $nuevafecha,
											// 'config' => $config,
											'pais' => $pais,
											'cotizaciones' => $cotizaciones,
											'info_cliente' => $info_cliente,
											'nombre1' => $nombre1,
											'nombre2' => $nombre2,
											'regimen' => $regimen,
											'tipodocumento' => $tipodocumento,
											'numdocumento' => $numdocumento,
											'confiabilidad' => $confiabilidad,
											'entrada' => 1
										]);
	}

	public function CreateIngreso($tipodocumento, $numdocumento)
	{
		if(CrudGenerarPlan::docGenerCotr($tipodocumento) == "1" && CrudGenerarPlan::valDocumento($tipodocumento, $numdocumento,\tienda::OnLine()->id) == 1){
			return self::CreateIngresoIndex($tipodocumento, $numdocumento);
		} else {
			Session::flash('warning', 'El documento no puede generar plan separe');
			return redirect()->back();
		}
	}
	
	public function CreateIngresoIndex($tipodocumento, $numdocumento){
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$info_cliente = PersonaNatural::getClienteByDocumento($tipodocumento, $numdocumento);
		$nombres = "";
		$nombre1 = "";
		$nombre2 = "";
		if($info_cliente != null){
			$nombres = explode(" ",$info_cliente->nombres);
			$nombre1 = $nombres[0];
			if(!empty($nombres[1])) $nombre2 = $nombres[1];
		}
		$regimen = 1;
		if($info_cliente != null) $regimen = $info_cliente->regimen;
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$pdc = CrudTienda::getPDC($tienda->id);
		// $config = CrudGenerarPlan::getConfig($pdc->id_pais,$pdc->id_departamento,$pdc->id_ciudad,$pdc->id_tienda);
		// $dias = 30 * $config[0]->termino_contrato;
		// $fecha = date('Y-m-d');
		// $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
		// $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$pais = Pais::getSelectList();
		$cotizaciones = CrudGenerarPlan::getSelectListCotizacion($tienda->id);
		$fecha = date("d-m-Y");
		$confiabilidad = GenerarPlan::getSelectListConfiabilidad();
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/create',
				'text' => 'Crear Plan Separe'
			],
		);
		
    	return view('GenerarPlan.create',[
											'tipo_documento' => $tipo_documento,
											'pdc' => $pdc,
											'urls' => $urls,
											'fecha' => $fecha,
											'id_tienda' => $tienda->id,
											// 'fecha_plazo' => $nuevafecha,
											// 'config' => $config,
											'pais' => $pais,
											'cotizaciones' => $cotizaciones,
											'info_cliente' => $info_cliente,
											'nombre1' => $nombre1,
											'nombre2' => $nombre2,
											'regimen' => $regimen,
											'tipodocumento' => $tipodocumento,
											'numdocumento' => $numdocumento,
											'confiabilidad' => $confiabilidad,
											'entrada' => 0
										]);
    }

    public function CreatePost(request $request){
		$codigo_cliente = trim($request->codigo_cliente);
		$id_tienda = trim($request->id_tienda);
		$id_tienda_cliente = trim($request->id_tienda_cliente);
		$dataCliente = [
					'correo_electronico' => $request->correo,
					'telefono_celular' => $request->telefono_celular,
					'telefono_residencia' => $request->telefono_residencia,
					'direccion_residencia' => $request->direccion_residencia
		];
		$abono = trim($request->abono);
		$msmCliente = PersonaNatural::actualizarClientes($id_tienda,$codigo_cliente,$dataCliente,null);
		$msm= CrudGenerarPlan::Create($request,$codigo_cliente,$id_tienda,$id_tienda_cliente,$request->forma_pago);

		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return response()->json($msm);
	}	

	public function validarCorreo(request $request)
	{
		$response = PersonaNatural::validarCorreo($request->correo,$request->id_tienda);
		(count($response) > 0) ? $response = false : $response = true;
		return response()->json($response);
	}

	public function generatePDFPlan( Request $request ){
		$params_ps = $request->params_ps;
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$info_cliente = PersonaNatural::getClienteByDocumento($params_ps['tipo_documento_var'], $params_ps['numero_documento_var']);
		$dt = GenerarPlan::getFechaEntrega($params_ps['codigo_plan_var'],$params_ps['id_tienda_var']);
		if($dt != "" && $dt != null){ 
			$dt = dateFormate::ToArrayInverse($dt->toArray());
			$dt = (object)$dt;
		}
		$datos_plan = dateFormate::ToArrayInverse(GenerarPlan::getDatosPlan($params_ps['codigo_plan_var'],$params_ps['id_tienda_var'])->toArray());
		$dp=(object)$datos_plan;
		// dd($fecha_entrega->fecha_entrega);
		$empleado = Contrato::getInfoEmpleado( Auth::user()->id );
		$pdf = PDF::setPaper('a4', 'landscape');
		$pdf = $pdf->loadView(  'GenerarPlan.pdfabono', [ 'tienda' => \tienda::OnLine(),
								'codigo_plan' => $params_ps['codigo_plan_var'],
								'codigo_abono' => $params_ps['codigo_abono'],
								'monto_total' => number_format(CrudGenerarPlan::limpiarVal($params_ps['monto_total']),2,",","."),
								'fecha' => date('d-m-Y'),
								'info_cliente' => $info_cliente,
								'datos_plan' => $dp,
								'empleado' => $empleado,
								'fecha_entrega' => $dt,
								'pago' => number_format(CrudGenerarPlan::limpiarVal($params_ps['saldo_abonar']),2,",","."),
								'saldo_pendiente' => number_format(CrudGenerarPlan::limpiarVal($params_ps['saldo_pendiente']),2,",",".")] );
		return $pdf->download( 'plansepare.pdf' );
	}

	public function createCliente(request $request)
	{
		$huella = PersonaNatural::validarVigenciaHuella( $request->tipo_documento, $request->numero_documento );
        $query = -3;
        if(isset($huella)){
            if($huella->minutos_transcurridos <= 15){
				$single_1 = new FileManagerSingle($request->foto_1);
				$single_2 = new FileManagerSingle($request->foto_2);
				$key = uniqid();
				$key2 = uniqid();
				$id_file1 = $single_1->moveFile($key,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
				$id_file2 = $single_2->moveFile($key2,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
				$data = [
					'id_tipo_cliente' => 3,
					'id_tipo_documento' => $request->tipo_documento,
					'numero_documento' => $request->numero_documento,
					'fecha_nacimiento' => $request->fecha_nacimiento,
					'fecha_expedicion' => $request->fecha_expedicion,
					'id_pais_expedicion' => $request->pais_expedicion,
					'id_pais_residencia' => $request->pais_residencia,
					'id_ciudad_expedicion' => $request->ciudad_expedicion,
					'id_ciudad_residencia' => $request->ciudad_residencia,
					'nombres' => $request->primer_nombre.' '.$request->segundo_nombre,
					'primer_apellido' => $request->primer_apellido,
					'segundo_apellido' => $request->segundo_apellido,
					'correo_electronico' => $request->correo,
					'genero' => $request->genero,
					'direccion_residencia' => $request->direccion_residencia,
					'id_regimen_contributivo' => $request->regimen,
					'telefono_residencia' => trim($request->telefono_residencia),
					'telefono_celular' => trim($request->telefono_celular),
					'id_confiabilidad' => (int)$request->cliente_confiable,
					// 'suplantacion' => (int)$request->suplantacion,
					'id_foto_documento_anterior' => $id_file1['msm'][1],
					'id_foto_documento_posterior' => $id_file2['msm'][1],
					'estado' => 1,
				];

				$query = CrudPersonaNatural::crearClienteContrato($request->id_tienda, $data);
				if($query > 0) self::agregarHuella($request->tipo_documento, $request->numero_documento);
			}
		}	
		return json_encode($query);
	}

	public function createClienteIngreso(request $request)
	{
		$single_1 = new FileManagerSingle($request->foto_1);
		$single_2 = new FileManagerSingle($request->foto_2);
		$key = uniqid();
		$key2 = uniqid();
		$id_file1 = $single_1->moveFile($key,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
		$id_file2 = $single_2->moveFile($key2,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
		$data = [
			'id_tipo_cliente' => 3,
			'id_tipo_documento' => $request->tipo_documento,
			'numero_documento' => $request->numero_documento,
			'fecha_nacimiento' => $request->fecha_nacimiento,
			'fecha_expedicion' => $request->fecha_expedicion,
			'id_pais_expedicion' => $request->pais_expedicion,
			'id_pais_residencia' => $request->pais_residencia,
			'id_ciudad_expedicion' => $request->ciudad_expedicion,
			'id_ciudad_residencia' => $request->ciudad_residencia,
			'nombres' => $request->primer_nombre.' '.$request->segundo_nombre,
			'primer_apellido' => $request->primer_apellido,
			'segundo_apellido' => $request->segundo_apellido,
			'correo_electronico' => $request->correo,
			'genero' => $request->genero,
			'direccion_residencia' => $request->direccion_residencia,
			'id_regimen_contributivo' => $request->regimen,
			'telefono_residencia' => trim($request->telefono_residencia),
			'telefono_celular' => trim($request->telefono_celular),
			// 'id_confiabilidad' => (int)$request->cliente_confiable,
			// 'suplantacion' => (int)$request->suplantacion,
			'id_foto_documento_anterior' => $id_file1['msm'][1],
			'id_foto_documento_posterior' => $id_file2['msm'][1],
			'estado' => 1,
		];

		$query = CrudPersonaNatural::crearClienteContrato($request->id_tienda, $data);
		
		return json_encode($query);
	}

    public function Delete(request $request){
		$msm=CrudGenerarPlan::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudGenerarPlan::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function getCliente(request $request){
		$response = CrudGenerarPlan::getCliente($request->iden,$request->id_tienda);
		return  response()->json($response);
	} 

	public function Update($id){
		$data=CrudGenerarPlan::getGenerarPlanById($id);
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/update/'.$id,
				'text' => 'Actualizar Plan Separe'
			],
		);
       	return view('GenerarPlan.update' , ['attribute' => $data, 'urls'=>$urls]);
	}

	public function updateClienteT(request $request)
	{
		$huella = PersonaNatural::validarVigenciaHuella( $request->tipo_documento, $request->numero_documento );
        $query = -3;
        if(isset($huella)){
            if($huella->minutos_transcurridos <= 15){
				$codigo_cliente = $request->codigo_cliente;
				$id_tienda = $request->id_tienda;
				$var = explode(" ",$request->apellido);
				$primer_apellido = $var[0];
				$segundo_apellido = $var[1];
				$data = [
							'nombres' => $request->nombre,
							'primer_apellido' => $primer_apellido,
							'segundo_apellido' => $segundo_apellido,
							'fecha_nacimiento' => $request->fecha_nacimiento,
							'fecha_expedicion' => $request->fecha_expedicion,
							'correo_electronico' => $request->correo,
							'id_confiabilidad' => $request->confiabilidad,
				];

				$query = PersonaNatural::actualizarClientes($id_tienda,$codigo_cliente,$data,null);
                self::agregarHuella($request->tipo_documento, $request->numero_documento);
			}else{
                $query = -3;
            }
		}
		return response()->json($query);
	}

	public function updateClienteTIngreso(request $request)
	{
		$codigo_cliente = $request->codigo_cliente;
		$id_tienda = $request->id_tienda;
		$data = [
					'nombres' => $request->nombre,
					'correo_electronico' => $request->correo,
					'telefono_residencia' => $request->telefono_residencia,
					'telefono_celular' => $request->telefono_celular,
					'direccion_residencia' => $request->direccion_residencia,
		];

		$query = PersonaNatural::actualizarClientes($id_tienda,$codigo_cliente,$data,null);
        
		return response()->json($query);
	}

	public function UpdatePost(request $request){
		$id = (int)$request->id;
		$this->validate($request, [
			'nombre' => 'required'
        ]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'descripcion' => trim($request->descripcion)
		];
		$msm=CrudGenerarPlan::Update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/generarplan');
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
		$msm = CrudGenerarPlan::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListById(request $request)
	{
		$msm = CrudGenerarPlan::getSelectListbyId($request->tabla,$request->filter,$request->id);
		return  response()->json($msm);
	}

	public function getFranquiciasociedad(request $request){
		$msm = CrudSociedad::getSelectListFranquiciaSociedad($request->id);
		return response()->json($msm);
	}

	// public function getInventarioById(request $request){
	// 	$response = CrudGenerarPlan::getInventarioById($request->codigo_inventario);
	// 	return response()->json($response);
	// }

	public function getInfoPrecio(request $request){
		$response = CrudGenerarPlan::getInfoPrecio($request->id, $request->id_tienda);
		return response()->json($response);
	}

	public function getInventarioById(request $request){
		$response = CrudGenerarPlan::getInventarioByIdB2($request->referencia,$request->id_tienda,$request->array_in);
		return response()->json($response);
	}

	public function getInventarioById2(request $request){
		$response = CrudGenerarPlan::getInventarioById2($request->referencia);
		return response()->json($response);
	}


	public function getSecuencia(request $request)
	{
		$secuencia = SecuenciaTienda::getCodigosSecuencia($request->id_tienda,$request->id_tipo,(int)1);
		return $secuencia[0]->response;
	}

	public function Abonar($id_tienda,$codigo_plan){

		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$infoAbono = CrudGenerarPlan::getInfoAbono($id_tienda,$codigo_plan);
		$saldo_favor = CrudGenerarPlan::getNuevoSaldoFavor($id_tienda,$codigo_plan);
		$reverso = CrudGenerarPlan::buscarReverso($id_tienda,$codigo_plan);
		$reverso_abono = "";
		if($reverso != null) $reverso_abono = $reverso->saldo_abonado;
		if($reverso != null) $reverso = $reverso->codigo_abono;



		$codigo_transaccion = SecuenciaTienda::getCodigosSecuencia($id_tienda,(int)28,(int)1);
		$plan = dateFormate::ToArrayInverse(CrudGenerarPlan::getPlanById($id_tienda,$codigo_plan)->toArray());
		$plan=(object)$plan;
		$codigo_abono = CrudGenerarPlan::getCodigosSecuencia($id_tienda);
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/abonar/'.$id_tienda.'/'.$codigo_plan,
				'text' => 'Abonar Plan Separe'
			],
		);
		return view('GenerarPlan.abonar',[
										'urls' => $urls,
										'id_tienda' => $id_tienda,
										'codigo_plan' => $codigo_plan,
										'codigo_transaccion' => $codigo_transaccion,
										'plan' => $plan,
										'codigo_abono' => $codigo_abono[0]->response,

										'tipo_documento' => $tipo_documento,
										'codigo_abono' => $codigo_abono[0]->response,
										'saldo_favor' => $saldo_favor->nuevo_saldo_favor,
										'infoAbono' => $infoAbono
										]);
	}

	public function verificarcliente(){
		$tipos_doc = CrudTipoDocumento::getSelectList2();
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
				'href'=>'generarplan',
				'text'=>'Verficación de cliente'
			]
		);
		return view('GenerarPlan.verificarcliente',['urls' => $urls,'tipos_doc' => $tipos_doc]);
	}

	public function verificarclienteTransfer(request $request){
		$tipos_doc = CrudTipoDocumento::getSelectList2();
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
				'href'=>'generarplan',
				'text'=>'Verficación de cliente'
			]
		);
		return view('GenerarPlan.verificarclienteTransfer',[
													'urls' => $urls,
													'tipos_doc' => $tipos_doc,
													'id_tienda' => $request->id_tienda,
													'saldo_favor' => $request->saldo_favor,
													'codigo_plan' => $request->codigo_plan
													]);
	}

	public function guardar(request $request){
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$info_cliente = PersonaNatural::getClienteByDocumento($request->tipo_documento, $request->numero_documento);
		$datos_plan = dateFormate::ToArrayInverse(GenerarPlan::getDatosPlan($request->codigo_planS,$request->id_tienda)->toArray());
		$dp=(object)$datos_plan;
		$empleado = Contrato::getInfoEmpleado( Auth::user()->id );
		// return view('GenerarPlan.pdfabono',[ 'tienda' => \tienda::OnLine(), 'request' => dateFormate::ToArrayInverse($request),'fecha' => date('d-m-Y'),'info_cliente' => $info_cliente,'datos_plan' => $dp,'empleado' => $empleado,'pago' => number_format(CrudGenerarPlan::limpiarVal($request->saldo_abonar),2,",","."),'saldo_pendiente' => number_format(CrudGenerarPlan::limpiarVal($request->saldo_pendiente) - CrudGenerarPlan::limpiarVal($request->saldo_abonar),2,",",".")]);
		
		$msm = CrudGenerarPlan::guardar($request,$tienda->id);
		if($msm['val']){
			// Session::flash('message', $msm['msm']);
			return response()->json($msm);
		}
		elseif($msm['val']=='Error'){
			// Session::flash('error', $msm['msm']);
			return response()->json($msm);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
	}

	public function getInfoAbonos(request $request,$id_tienda,$codigo_plan)
	{
		return CrudGenerarPlan::getInfoAbonos($request,$id_tienda,$codigo_plan);
	}

	public function descargarPDFabono(request $request)
	{
		$info_cliente = PersonaNatural::getClienteByDocumento($request->tipo_documento, $request->numero_documento);
		$datos_plan = dateFormate::ToArrayInverse(GenerarPlan::getDatosPlan($request->codigo_planS,$request->id_tienda)->toArray());
		$dp=(object)$datos_plan;
		$empleado = Contrato::getInfoEmpleado( Auth::user()->id );

		$pdf = PDF::setPaper('a4', 'landscape');
		$pdf = $pdf->loadView( 'GenerarPlan.pdfabono', [ 'tienda' => \tienda::OnLine(), 'codigo_plan' => $request->codigo_planS,'codigo_abono' => $request->codigo_abono, 'monto_total' => $request->monto_total,'fecha' => date('d-m-Y'),'info_cliente' => $info_cliente,'datos_plan' => $dp,'empleado' => $empleado,'pago' => number_format(CrudGenerarPlan::limpiarVal($request->saldo_abonar),2,",","."),'saldo_pendiente' => number_format(CrudGenerarPlan::limpiarVal($request->saldo_pendiente) - CrudGenerarPlan::limpiarVal($request->saldo_abonar),2,",",".")]);
		return $pdf->download( 'plansepare.pdf' );
	}

	public function infoAbono($id_tienda,$codigo_plan,$idRemitente=0){
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$infoAbono = CrudGenerarPlan::getInfoAbono($id_tienda,$codigo_plan);
		$abonos = CrudGenerarPlan::getInfoAbonosX($id_tienda,$codigo_plan);
		$saldo_favor = CrudGenerarPlan::getNuevoSaldoFavor($id_tienda,$codigo_plan);
		// $codigo_abono = CrudGenerarPlan::getCodigosSecuencia($id_tienda);
		$id_tienda = $infoAbono->id_tienda_plan;
		$reverso = CrudGenerarPlan::buscarReverso($id_tienda,$codigo_plan);
		$items = CrudGenerarPlan::getItemsPlan($id_tienda,$codigo_plan);
		$reverso_abono = "";
		if($reverso != null) $reverso_abono = $reverso->saldo_abonado;
		if($reverso != null) $reverso = $reverso->codigo_abono;
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/infoAbono/'.$id_tienda.'/'.$codigo_plan,
				'text' => 'Información Plan Separe'
			],
		);	
		return view('GenerarPlan.infoAbono', [
												'tipo_documento' => $tipo_documento,
												'codigo_plan' => $codigo_plan,
												// 'codigo_abono' => $codigo_abono[0]->response,
												'abonos' => $abonos,
												'saldo_favor' => $saldo_favor->nuevo_saldo_favor,
												'infoAbono' => $infoAbono,
												'id_tienda' => $id_tienda,
												'urls' => $urls,
												'idRemitente' => $idRemitente,
												'reverso' => $reverso,
												'reverso_abono' => $reverso_abono,
												'items' => $items
											]);
	}

	public function detalleAbono($id_tienda,$id_abono)
	{
		return response()->json(CrudGenerarPlan::detalleAbono($id_tienda,$id_abono));
	}

	public function mesesAdeudados(request $request){
		$codigo = $request->codigo_contrato;
		$id_tienda = $request->id_tienda;
		$var_menos_porcentaje = (isset($aplicacion_retroventa->menos_porcentaje)) ? $aplicacion_retroventa->menos_porcentaje : 0;
		$var_menos_porcentaje = ($var_menos_porcentaje != null) ? $var_menos_porcentaje : 0;

		$var_menos_meses = (isset($aplicacion_retroventa->menos_meses)) ? $aplicacion_retroventa->menos_meses : 0;
		$var_menos_meses = ($var_menos_meses != null) ? $var_menos_meses : 0;
		$infoActualContrato = Contrato::infoActualContrato($codigo, $id_tienda, $var_menos_porcentaje, $var_menos_meses,0);
		return response()->json($infoActualContrato);
	}

	public function transferirPlan($id_tienda,$codigo_plan){
		$codigo_abono = CrudGenerarPlan::getCodigosSecuencia($id_tienda);
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$infoAbono = CrudGenerarPlan::getInfoAbono($id_tienda,$codigo_plan);
		$codigo_cliente = $infoAbono->codigo_cliente_plan;
		$saldo_favor = CrudGenerarPlan::getNuevoSaldoFavor($id_tienda,$codigo_plan);
		$ipValidation = new userIpValidated();
		$tienda = Tienda::getTiendaByIp($ipValidation->getRealIP());
	
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/transferir/'.$id_tienda.'/'.$codigo_plan,
				'text' => 'Transferir Plan Separe'
			],
		);
		return view('GenerarPlan.transferir',[
												'id_tienda' => $id_tienda,
												'id_tienda_login' => $tienda->id,
												'codigo_cliente' => $codigo_cliente,
												'codigo_plan' => $codigo_plan,
												'tipo_documento' =>$tipo_documento,
												'infoAbono' => $infoAbono,
												'saldo_favor' => $saldo_favor,
												'codigo_abono' => $codigo_abono[0]->response,
												'urls' => $urls
											]);
	}

	public function transferirGuardar(request $request){
		$msm = CrudGenerarPlan::transferirGuardar($request);		
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return response()->json($msm);
	}

	public function transferirNuevoPlan($id_tienda,$saldo_favor,$codigo_plan){
		$saldo_favor = str_replace(".",",",$saldo_favor);
		$codigo_abono = CrudGenerarPlan::getCodigosSecuencia($id_tienda);
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$pdc = CrudTienda::getPDC($tienda->id);
		$pais = Pais::getSelectList();
		// $config = CrudGenerarPlan::getConfig($pdc->id_pais,$pdc->id_departamento,$pdc->id_ciudad,$pdc->id_tienda);
		// $dias = 30 * $config[0]->termino_contrato;
		// $fecha = date("d-m-Y");
		// $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) );
		// $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$fecha = date("d-m-Y");
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/Create/',
				'text' => 'Crear Plan Separe'
			],
		);
		return view('GenerarPlan.transferirNuevoPlan',[
												'id_tienda' => $id_tienda,
												'saldo_transferido' => $saldo_favor,
												'codigo_plan_transferir' => $codigo_plan,
												'codigo_abono' => $codigo_abono[0]->response,
												'urls' => $urls,
												'tipo_documento' => $tipo_documento,
												'pdc' => $pdc,
												// 'config' => $config,
												'fecha' => $fecha,
												// 'fecha_plazo' => $nuevafecha,												
												'pais' => $pais,	
												'tienda' => $tienda											
											]);
	}


	public function TransferirParam($id_tienda,$saldo_favor,$codigo_plan,$tipodocumento, $numdocumento, $pa = null, $sa = null, $pn = null, $sn = null, $fn = null, $gen = null, $rh = null){
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$info_cliente = PersonaNatural::getClienteByDocumento($tipodocumento, $numdocumento);
		$codigo_abono = CrudGenerarPlan::getCodigosSecuencia($id_tienda);
		$nombres = "";
		$nombre1 = "";
		$nombre2 = "";
		if($info_cliente != null){
			$nombres = explode(" ",$info_cliente->nombres);
			$nombre1 = $nombres[0];
			$nombre2 = $nombres[1];
		}
		$regimen = 1;
		if($info_cliente != null) $regimen = $info_cliente->regimen;
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$pdc = CrudTienda::getPDC($tienda->id);
		// $config = CrudGenerarPlan::getConfig($pdc->id_pais,$pdc->id_departamento,$pdc->id_ciudad,$pdc->id_tienda);
		// $dias = 30 * $config[0]->termino_contrato;
		// $fecha = date('Y-m-d');
		// $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
		// $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$pais = Pais::getSelectList();
		$cotizaciones = CrudGenerarPlan::getSelectListCotizacion($tienda->id);
		$fecha = date("d-m-Y");
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/create',
				'text' => 'Crear Plan Separe'
			],
		);
    	return view('GenerarPlan.transferirNuevoPlan',[
											'tipo_documento' => $tipo_documento,
											'pdc' => $pdc,
											'urls' => $urls,
											'fecha' => $fecha,
											'id_tienda' => $tienda->id,
											'saldo_transferido' => $saldo_favor,
											'codigo_abono' => $codigo_abono[0]->response,
											'codigo_plan_transferir' => $codigo_plan,
											'pais' => $pais,
											'cotizaciones' => $cotizaciones,
											'info_cliente' => $info_cliente,
											'nombre1' => $nombre1,
											'nombre2' => $nombre2,
											'regimen' => $regimen,
											'tipodocumento' => $tipodocumento,
											'numdocumento' => $numdocumento,
											'entrada' => 1,
											'tienda' => $tienda	

										]);
	}
	
	
	public function TransferirIngreso($id_tienda,$saldo_favor,$codigo_plan,$tipodocumento, $numdocumento){
		$tipo_documento = CrudEmpleado::getSelectList('tipo_documento');
		$info_cliente = PersonaNatural::getClienteByDocumento($tipodocumento, $numdocumento);
		$codigo_abono = CrudGenerarPlan::getCodigosSecuencia($id_tienda);
		$nombres = "";
		$nombre1 = "";
		$nombre2 = "";
		if($info_cliente != null){
			$nombres = explode(" ",$info_cliente->nombres);
			$nombre1 = $nombres[0];
			if(!empty($nombres[1])) $nombre2 = $nombres[1];
		}
		$regimen = 1;
		if($info_cliente != null) $regimen = $info_cliente->regimen;
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$pdc = CrudTienda::getPDC($tienda->id);
		// $config = CrudGenerarPlan::getConfig($pdc->id_pais,$pdc->id_departamento,$pdc->id_ciudad,$pdc->id_tienda);
		// $dias = 30 * $config[0]->termino_contrato;
		// $fecha = date('Y-m-d');
		// $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
		// $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$pais = Pais::getSelectList();
		$cotizaciones = CrudGenerarPlan::getSelectListCotizacion($tienda->id);
		$fecha = date("d-m-Y");
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/create',
				'text' => 'Crear Plan Separe'
			],
		);
    	return view('GenerarPlan.transferirNuevoPlan',[
											'tipo_documento' => $tipo_documento,
											'pdc' => $pdc,
											'urls' => $urls,
											'fecha' => $fecha,
											'id_tienda' => $tienda->id,
											'saldo_transferido' => $saldo_favor,
											'codigo_abono' => $codigo_abono[0]->response,
											'codigo_plan_transferir' => $codigo_plan,
											'pais' => $pais,
											'cotizaciones' => $cotizaciones,
											'info_cliente' => $info_cliente,
											'nombre1' => $nombre1,
											'nombre2' => $nombre2,
											'regimen' => $regimen,
											'tipodocumento' => $tipodocumento,
											'numdocumento' => $numdocumento,
											'entrada' => 0,
											'tienda' => $tienda	
										]);
    }


	public function createPostTransferir(request $request){
		// dd($request);
		$codigo_cliente = trim($request->codigo_cliente);
		$codigo_plan_transferir = trim($request->codigo_plan_transferir);
		$id_tienda = trim($request->id_tienda);
		$codigo_abono = trim($request->codigo_abono);
		$saldo_transferido = trim($request->saldo_transferido);
		$fecha_creacion = trim($request->fecha_creacion);
		$id_tienda_cliente = trim($request->id_tienda_cliente);
		$cod_sec = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_transfer,(int)28,(int)1);
		$dataCliente = [
			'correo_electronico' => $request->correo,
			'telefono_celular' => $request->telefono_celular,
			'telefono_residencia' => $request->telefono_residencia,
			'direccion_residencia' => $request->direccion_residencia
		];
		if($request->saldo_transferido > 0){
			// dd($request);
			$msmCliente = PersonaNatural::actualizarClientes($id_tienda,$codigo_cliente,$dataCliente,null);
			$msmCreate =  CrudGenerarPlan::Create($request,$codigo_cliente,$id_tienda,$id_tienda_cliente,$request->forma_pago);			
			$codigo_plan_separe = CrudGenerarPlan::codigoPlanPostTransferir($id_tienda,$codigo_cliente);
			$trans = CrudGenerarPlan::limpiarVal($request->saldo_transferido);
			// $trans = $saldo - CrudGenerarPlan::limpiarVal($request->val_transfer);
			$abonoTransferido = [
				'codigo_plan_separe' => $codigo_plan_separe->codigo_plan_separe,
				'id_tienda' => $id_tienda,
				'saldo_abonado' => $trans,
				'fecha' => $request->fecha_creacion,
				'descripcion' => 'Abono por transferencia',
				'codigo_abono' => $request->codigo_abono,
				'estado' => (int)0
			];
			$dataSaved['abonoTransferido'] = $abonoTransferido;
			$retirarValorPlan = [
				'codigo_plan_separe' => $codigo_plan_transferir,
				'id_tienda' => $request->id_tienda_transfer,
				'saldo_abonado' => $trans,
				'fecha' => $request->fecha_creacion,
				'descripcion' => 'Reverso de transferencia',
				'codigo_abono' => $cod_sec[0]->response,
				'estado' => (int)1
			];
			$transfePlan = [
				'estado' => env('CERRAR_PLAN_SEPARE_ESTADO'),
				'motivo' => env('CERRAR_PLAN_SEPARE_MOTIVO'),
				'id_tienda' => $request->id_tienda_transfer,
				'codigo_plan_separe' => $codigo_plan_transferir,
				'deuda' => 0
			];
			$dataSaved['transfePlan'] = $transfePlan;
			$dataSaved['abonoTransferido'] = $abonoTransferido;
			// MovimientosTesoreria::registrarMovimientos($request->saldo_transferido,26,$id_tienda,19);
			$dataSaved['retirarValorPlan'] = $retirarValorPlan;
			// dd($dataSaved);
			$msm = CrudGenerarPlan::createPostTransferir($dataSaved);
		}else{
			$msm = ['msm'=>'Para poder transferir el valor debe ser mayor a 0','val'=>false];	
		}

		return response()->json(['msm' => $msm, 'msmcreate' => $msmCreate]);
	}

	public function getTransferPlanH(request $request){
		$response = CrudGenerarPlan::getTransferPlanH($request->codigo_cliente,$request->codigo_plan);
		return response()->json($response);
	}

	public function getTransferirPlan(request $request){
		$msm = CrudGenerarPlan::getTransferirPlan($request->codigo_cliente,$request->id_tienda,$request->codigo_plan);
		return response()->json($msm);
	}

	public function getTransferirContrato(request $request){
		$msm = CrudGenerarPlan::getTransferirContrato($request->codigo_cliente,$request->id_tienda);
		return response()->json($msm);
	}

	public function getTransferirContratoS(request $request){
		$msm = CrudGenerarPlan::getTransferirContrato($request->codigo_cliente,$request->id_tienda);
		$prorroga = new ProrrogarContrato(NULL,NULL,$request->codigo_contrato,$request->id_tienda,NULL,NULL);
		$data=$prorroga->getContratoById();
		// dd($data);
		$valor_abonado_bd = Contrato::getAbonoProrroga($request->codigo_contrato, $request->id_tienda);
		$porcentaje_retroventa = $data->porcentaje_retroventa;
		$fecha_terminacion_cabecera = $data->fecha_terminacion;

		return response()->json(['msm' => $msm,
								 'data' => $data,
								 'valor_abonado_bd' => $valor_abonado_bd,
								 'porcentaje_retroventa' => $porcentaje_retroventa,
								 'fecha_terminacion_cabecera' => $fecha_terminacion_cabecera
								 ]);
	}	

	public function solicitudAnulacion(request $request){
		$msm = CrudGenerarPlan::solicitudAnulacion($request);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return response()->json($msm);
	}

	public function anular(request $request){
		$msm = CrudGenerarPlan::anular($request);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return response()->json($msm);
	}

	public function reversarAbono(request $request){
		// dd($request->all());
		$msm = CrudGenerarPlan::reversarAbono($request);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}
		else{
			Session::flash('error', $msm['msm']);
		}
		return response()->json($msm);
	}

	public function solicitarReversarAbono(request $request){
		$msm = CrudGenerarPlan::solicitarReversarAbono($request);
		if($msm['val']){
			if($msm['var']['val']){
				Session::flash('message', $msm['msm']);
			}else{
				Session::flash('message', 'Reverso solicitado con éxito, No se puedo enviar mensaje a jefe de zona por que no se encuentra ninguno asociado.');
			}
		}
		else{
			Session::flash('error', $msm['msm']);
		}
		return response()->json($msm);
	}

	public function rechazarReversar(request $request){
		$msm = CrudGenerarPlan::rechazarReversar($request);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return response()->json($msm);
	}
	
	public function sinProducto($id_tienda){		
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
				'href'=>'generarplan',
				'text'=>'Generar Plan Separe'
			],
			[
				'href' => 'generarplan/sinProducto/'.$id_tienda,
				'text' => 'Plan Separe Sin Producto'
			],
		);
		return view('GenerarPlan.sinProducto',[
												'urls' => $urls
											]);
	}

	public function getSelectListCotizacion(request $request)
	{
		$response = CrudGenerarPlan::getSelectListCotizacion($request->id_tienda);
		return response()->json($response);
	}

	public function agregarHuella( $id_tipo_documento, $numero_documento ){
        $result = true;
        try{
            $huella = PersonaNatural::getHuella( $id_tipo_documento, $numero_documento );
            $data = [
                "id_tienda" => $huella->id_tienda,
                "id_cliente" => $huella->codigo_cliente,
                "huella" => $huella->huella,
                "updated_at" => date("Y-m-d H:i:s")
            ];
            PersonaNatural::agregarHuella($data);
        }catch(\Exception $ex){
            $result = false;
        }
        return $result;
	}
	
	public function getCotizacionById(request $request)
	{
		// $response = CrudGenerarPlan::getCotizacionById($request->id_cotizacion,$request->id_tienda);
		$response=dateFormate::ToArrayInverse(CrudGenerarPlan::getCotizacionById($request->id_cotizacion,$request->id_tienda));
		// $reference=(object)$data;
		return response()->json($response);
	}

	public function updateInventario(request $request)
	{
		$response = CrudGenerarPlan::updateInventario($request->id_inventario,$request->id_tienda,$request->id_estado,$request->id_motivo);
		return response()->json($response);
	}

	public function validarFecha(request $request)
	{
		$response = CrudGenerarPlan::validarFecha($request->id_tienda,$request->id_plan);
		$response2 = CrudGenerarPlan::getPlanEstadosAbonos($request->id_tienda,$request->id_plan);
		if($response == null) $response = false;
		(count($response2) > 0) ? $response2 = false : $response2 = true;
		return response()->json(['fecha' => $response, 'estado' => $response2]);
	}


}

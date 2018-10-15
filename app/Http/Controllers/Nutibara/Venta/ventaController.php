<?php

namespace App\Http\Controllers\nutibara\Venta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Clientes\Empleado\CrudEmpleado;
use App\BusinessLogic\FileManager\FileManagerSingle;
use App\BusinessLogic\Nutibara\Clientes\PersonaNatural\CrudPersonaNatural;
use App\BusinessLogic\Nutibara\Tienda\CrudTienda;
use App\BusinessLogic\Nutibara\GenerarPlan\CrudGenerarPlan;
use App\BusinessLogic\Nutibara\Venta\VentaBL;
use App\AccessObject\Nutibara\Venta\VentaAO;
use App\AccessObject\Nutibara\Pais\Pais;
use App\AccessObject\Nutibara\Tienda\Tienda;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda AS SecuenciaTienda;
use App\AccessObject\Nutibara\Clientes\PersonaNatural\PersonaNatural;
use App\AccessObject\Nutibara\Contratos\Contrato;
use Auth;
use PDF;

class ventaController extends Controller
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
				'href'=>'ventas',
				'text'=>'Ventas'
			]
		);
		return view('Venta.Venta',['urls'=>$urls]);
    }

    public function createVentaDirecta()
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
				'href'=>'ventas',
				'text'=>'Ventas'
            ],
            [
				'href'=>'ventas/createVentaDirecta',
				'text'=>'Factura venta directa'
            ]
        );
        
        return view('Venta.ventaDirecta',[
											'tipo_documento' => $tipo_documento,
											'pdc' => $pdc,
											'urls' => $urls,
											'fecha' => $fecha,
											'pais' => $pais
										]);
    }

    public function createVentaPlan($id_tienda,$id_plan,$id_tienda_pr)
    {
		$data = VentaBL::getInfoVenta($id_tienda,$id_plan);
		$dataProductos = VentaBL::getInfoVentaProductos($id_tienda_pr,$id_plan);
		$total = 0;
		$subtotal = 0;
		$impuestos = 0;
		$valor_bruto = 0;
		for ($i=0; $i < count($dataProductos); $i++) { 
			$total += self::limpiarVal($dataProductos[$i]->valor_total);
			$valor_bruto += self::limpiarVal($dataProductos[$i]->valor_total);
			$subtotal += self::limpiarVal($dataProductos[$i]->precio);
			$impuestos += self::limpiarVal($dataProductos[$i]->valor_iva);
		}
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
				'href'=>'ventas',
				'text'=>'Ventas'
            ],
            [
				'href'=>'ventas/createVentaDirecta',
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
											'dataProductos' => $dataProductos,
											'total' => $total,
											'valor_bruto' => $valor_bruto,
											'subtotal' => self::volverVal($subtotal),
											'impuestos' => $impuestos,
											'id_tienda' => $id_tienda,
											'id_tienda_pr' => $id_tienda_pr,
											'id' => $id_plan
										]);
    }

    public function getCliente(request $request)
    {
        $response = VentaBL::getCliente($request->tipo_documento,$request->documento);
        return response()->json($response);
    }

    public function getInventarioByName(request $request)
    {
        $ipValidation = new userIpValidated();
		$tienda = Tienda::getTiendaByIp($ipValidation->getRealIP());
        $response = VentaBL::getInventarioByName($request->referencia,$tienda->id);
        return response()->json($response);
	}
	
	public function createDirecta(request $request)
	{
		// dd($request->all());
		$ipValidation = new userIpValidated();
		$tienda = Tienda::getTiendaByIp($ipValidation->getRealIP());
		if($request->cliente == "0"){
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
		}
		$msm = VentaBL::createDirecta($request,$tienda->id);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
			return redirect('/ventas');
		}
		elseif(!$msm['val']){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
	}

	public function generatePDFPlan( Request $request ){
		$params_ps = $request->params_ps;
		$ipValidation = new userIpValidated();
		$tienda = CrudGenerarPlan::getTiendaByIp($ipValidation->getRealIP());
		$info_cliente = PersonaNatural::getClienteByDocumento($params_ps['tipo_documento_var'], $params_ps['numero_documento_var']);
		$datos_plan = dateFormate::ToArrayInverse(GenerarPlan::getDatosPlan($params_ps['codigo_plan_var'],$params_ps['id_tienda_var'])->toArray());
		$dp=(object)$datos_plan;
		$empleado = Contrato::getInfoEmpleado( Auth::user()->id );
		$pdf = PDF::setPaper('a4', 'landscape');
		$pdf = $pdf->loadView( 'GenerarPlan.pdfabono', [ 'tienda' => \tienda::OnLine(),
		'codigo_plan' => $params_ps['codigo_plan_var'],
		'codigo_abono' => $params_ps['codigo_abono'],
		'monto_total' => $params_ps['monto_total'],
		'fecha' => date('d-m-Y'),
		'info_cliente' => $info_cliente,
		'datos_plan' => $dp,
		'empleado' => $empleado,
		'pago' => number_format(CrudGenerarPlan::limpiarVal($params_ps['saldo_abonar']),2,",","."),
		'saldo_pendiente' => number_format(CrudGenerarPlan::limpiarVal($params_ps['saldo_pendiente']),2,",",".")] );
		return $pdf->download( 'plan_separe.pdf' );
	}
	
	public function facturarPlan(request $request)
	{
		// dd($request->all());
		// dd(\DNS1D::getBarcodeHTML("4445645656", "C128"));
		$info_inventario = VentaAO::getInfoInvetario($request->id_inventario)->toArray();
		$sec = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_pr,env('SECUENCIA_TIPO_CODIGO_COMPROBANTE_CONTABLE'),1);
		$codigoComprobante = $sec[0]->response;
		$info_cliente = PersonaNatural::getClienteByDocumento($request->tipo_documento, $request->numero_documento);
		$empleado = Contrato::getInfoEmpleado( Auth::user()->id );
		// return view('Venta.pdfactura',[
		// 	'tienda' => \tienda::Online(),
		// 	'numero_factura' => $codigoComprobante,
		// 	'info_cliente' => $info_cliente,
		// 	'info_inventario' => $info_inventario,
		// 	'request' => $request
		// ]);

		$naturaleza = VentaBL::getNaturalezaBy(env('CUENTA_PLAN_1'));
		$conf = VentaBL::getConfContable($naturaleza->id_cod_puc);
		$CierreActual = MovimientosTesoreria::getCierreCaja($request->id_tienda_pr);
		
		$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_pr,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
		$codigoMovimiento = $secuencias[0]->response;
		
		// dd($request);
		
		$rt = VentaBL::getPrecioBolsa();
		
		$retecree = round((self::limpiarVal($request->subtotal) * $rt->retecree)/1000);
		
		$dataMov[0]['id_movimiento'] = $codigoMovimiento;
		$dataMov[0]['id_cierre'] = $CierreActual[0]->id_cierre;
		$dataMov[0]['id_tienda'] = $request->id_tienda_pr;
		$dataMov[0]['codigo_movimiento'] = $codigoComprobante;                
		$dataMov[0]['fecha'] = date("Y-m-d H:i:s");
		$dataMov[0]['id_tipo_documento'] = (int)17;
		$dataMov[0]['cuenta'] = $conf->cuenta;
		$dataMov[0]['descripcion'] = $conf->nombre;
		$dataMov[0]['referencia'] = "PAGOPLAN-".$request->codigo_tienda."/".$request->id;
		$dataMov[0]['id_configuracion_contable'] = env('ID_CONFIG_CONTABLE_PLAN_SEPARE');
		$dataMov[0]['valor'] = self::limpiarVal($request->total);
		$dataMov[0]['tercero'] = $request->numero_documento;
		if($naturaleza->naturaleza == 1)
		{
			$dataMov[0]['debito'] = self::limpiarVal($request->subtotal);
			$dataMov[0]['credito'] = 0;
		}
		else
		{   
			$dataMov[0]['credito'] = self::limpiarVal($request->subtotal);
			$dataMov[0]['debito'] = 0;
		}

		for ($i=1; $i < 8; $i++) { 
			switch ($i) {
				case 1:
					if($request->descuentos > 0){
						$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_pr,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
						$codigoMovimiento = $secuencias[0]->response;
						$dataMov[$i]['id_movimiento'] = $codigoMovimiento;
						$dataMov[$i]['id_cierre'] = $CierreActual[0]->id_cierre;
						$dataMov[$i]['id_tienda'] = $request->id_tienda_pr;
						$dataMov[$i]['codigo_movimiento'] = $codigoComprobante;                
						$dataMov[$i]['fecha'] = date("Y-m-d H:i:s");
						$dataMov[$i]['id_tipo_documento'] = (int)17;
						$dataMov[$i]['cuenta'] = env('CUENTA_DESCUENTO');
						$dataMov[$i]['descripcion'] = "DESCUENTO";
						$naturaleza = VentaBL::getNatBy(env('CUENTA_DESCUENTO'));
						if($naturaleza->naturaleza == 1)
						{
							$dataMov[$i]['debito'] = self::limpiarVal($request->descuentos);
							$dataMov[$i]['credito'] = 0;
						}
						else
						{   
							$dataMov[$i]['credito'] = self::limpiarVal($request->descuentos);
							$dataMov[$i]['debito'] = 0;
						}
						$dataMov[$i]['referencia'] = "PAGOPLAN-".$request->codigo_tienda."/".$request->id;
						$dataMov[$i]['id_configuracion_contable'] = env('ID_CONFIG_CONTABLE_PLAN_SEPARE');
						$dataMov[$i]['valor'] = self::limpiarVal($request->total);
						$dataMov[$i]['tercero'] = $request->numero_documento;
					}
					break;
				case 2:
					if($request->v_iva > 0){
						$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_pr,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
						$codigoMovimiento = $secuencias[0]->response;
						$dataMov[$i]['id_movimiento'] = $codigoMovimiento;
						$dataMov[$i]['id_cierre'] = $CierreActual[0]->id_cierre;
						$dataMov[$i]['id_tienda'] = $request->id_tienda_pr;
						$dataMov[$i]['codigo_movimiento'] = $codigoComprobante;                
						$dataMov[$i]['fecha'] = date("Y-m-d H:i:s");
						$dataMov[$i]['id_tipo_documento'] = (int)17;
						$dataMov[$i]['cuenta'] = env('CUENTA_IVA');
						$dataMov[$i]['descripcion'] = "IMPUESTO IVA";
						$naturaleza = VentaBL::getNatBy(env('CUENTA_IVA'));
						if($naturaleza->naturaleza == 1)
						{
							$dataMov[$i]['debito'] = self::limpiarVal($request->v_iva);
							$dataMov[$i]['credito'] = 0;
						}
						else
						{   
							$dataMov[$i]['credito'] = self::limpiarVal($request->v_iva);
							$dataMov[$i]['debito'] = 0;
						}
						$dataMov[$i]['referencia'] = "PAGOPLAN-".$request->codigo_tienda."/".$request->id;
						$dataMov[$i]['id_configuracion_contable'] = env('ID_CONFIG_CONTABLE_PLAN_SEPARE');
						$dataMov[$i]['valor'] = self::limpiarVal($request->total);
						$dataMov[$i]['tercero'] = $request->numero_documento;
					}
					break;
				case 3:
					if($request->v_retefuente > 0){
						$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_pr,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
						$codigoMovimiento = $secuencias[0]->response;
						$dataMov[$i]['id_movimiento'] = $codigoMovimiento;
						$dataMov[$i]['id_cierre'] = $CierreActual[0]->id_cierre;
						$dataMov[$i]['id_tienda'] = $request->id_tienda_pr;
						$dataMov[$i]['codigo_movimiento'] = $codigoComprobante;                
						$dataMov[$i]['fecha'] = date("Y-m-d H:i:s");
						$dataMov[$i]['id_tipo_documento'] = (int)17;
						$dataMov[$i]['cuenta'] = env('CUENTA_RETEFUENTE');
						$dataMov[$i]['descripcion'] = "IMPUESTO RETEFUENTE";
						$naturaleza = VentaBL::getNatBy(env('CUENTA_RETEFUENTE'));
						if($naturaleza->naturaleza == 1)
						{
							$dataMov[$i]['debito'] = self::limpiarVal($request->v_retefuente);
							$dataMov[$i]['credito'] = 0;
						}
						else
						{   
							$dataMov[$i]['credito'] = self::limpiarVal($request->v_retefuente);
							$dataMov[$i]['debito'] = 0;
						}
						$dataMov[$i]['referencia'] = "PAGOPLAN-".$request->codigo_tienda."/".$request->id;
						$dataMov[$i]['id_configuracion_contable'] = env('ID_CONFIG_CONTABLE_PLAN_SEPARE');
						$dataMov[$i]['valor'] = self::limpiarVal($request->total);
						$dataMov[$i]['tercero'] = $request->numero_documento;
					}
					break;
				case 4:
					if($request->v_reteica > 0){
						$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_pr,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
						$codigoMovimiento = $secuencias[0]->response;
						$dataMov[$i]['id_movimiento'] = $codigoMovimiento;
						$dataMov[$i]['id_cierre'] = $CierreActual[0]->id_cierre;
						$dataMov[$i]['id_tienda'] = $request->id_tienda_pr;
						$dataMov[$i]['codigo_movimiento'] = $codigoComprobante;                
						$dataMov[$i]['fecha'] = date("Y-m-d H:i:s");
						$dataMov[$i]['id_tipo_documento'] = (int)17;
						$dataMov[$i]['cuenta'] = env('CUENTA_RETEICA');
						$dataMov[$i]['descripcion'] = "IMPUESTO RETEICA";
						$naturaleza = VentaBL::getNatBy(env('CUENTA_RETEICA'));
						if($naturaleza->naturaleza == 1)
						{
							$dataMov[$i]['debito'] = self::limpiarVal($request->v_reteica);
							$dataMov[$i]['credito'] = 0;
						}
						else
						{   
							$dataMov[$i]['credito'] = self::limpiarVal($request->v_reteica);
							$dataMov[$i]['debito'] = 0;
						}
						$dataMov[$i]['referencia'] = "PAGOPLAN-".$request->codigo_tienda."/".$request->id;
						$dataMov[$i]['id_configuracion_contable'] = env('ID_CONFIG_CONTABLE_PLAN_SEPARE');
						$dataMov[$i]['valor'] = self::limpiarVal($request->total);
						$dataMov[$i]['tercero'] = $request->numero_documento;
					}
					break;
				case 5:
					if($request->v_reteiva > 0){
						$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_pr,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
						$codigoMovimiento = $secuencias[0]->response;
						$dataMov[$i]['id_movimiento'] = $codigoMovimiento;
						$dataMov[$i]['id_cierre'] = $CierreActual[0]->id_cierre;
						$dataMov[$i]['id_tienda'] = $request->id_tienda_pr;
						$dataMov[$i]['codigo_movimiento'] = $codigoComprobante;                
						$dataMov[$i]['fecha'] = date("Y-m-d H:i:s");
						$dataMov[$i]['id_tipo_documento'] = (int)17;
						$dataMov[$i]['cuenta'] = env('CUENTA_RETEIVA');
						$dataMov[$i]['descripcion'] = "IMPUESTO RETEIVA";
						$naturaleza = VentaBL::getNatBy(env('CUENTA_RETEIVA'));
						if($naturaleza->naturaleza == 1)
						{
							$dataMov[$i]['debito'] = self::limpiarVal($request->v_reteiva);
							$dataMov[$i]['credito'] = 0;
						}
						else
						{   
							$dataMov[$i]['credito'] = self::limpiarVal($request->v_reteiva);
							$dataMov[$i]['debito'] = 0;
						}
						$dataMov[$i]['referencia'] = "PAGOPLAN-".$request->codigo_tienda."/".$request->id;
						$dataMov[$i]['id_configuracion_contable'] = env('ID_CONFIG_CONTABLE_PLAN_SEPARE');
						$dataMov[$i]['valor'] = self::limpiarVal($request->total);
						$dataMov[$i]['tercero'] = $request->numero_documento;
					}
					break;
				case 6:
					if($request->v_impuesto_consumo > 0){
						$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_pr,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
						$codigoMovimiento = $secuencias[0]->response;
						$dataMov[$i]['id_movimiento'] = $codigoMovimiento;
						$dataMov[$i]['id_cierre'] = $CierreActual[0]->id_cierre;
						$dataMov[$i]['id_tienda'] = $request->id_tienda_pr;
						$dataMov[$i]['codigo_movimiento'] = $codigoComprobante;                
						$dataMov[$i]['fecha'] = date("Y-m-d H:i:s");
						$dataMov[$i]['id_tipo_documento'] = (int)17;
						$dataMov[$i]['cuenta'] = env('CUENTA_CONSUMO');
						$dataMov[$i]['descripcion'] = "IMPUESTO AL CONSUMO";
						$naturaleza = VentaBL::getNatBy(env('CUENTA_CONSUMO'));
						if($naturaleza->naturaleza == 1)
						{
							$dataMov[$i]['debito'] = self::limpiarVal($request->v_impuesto_consumo);
							$dataMov[$i]['credito'] = 0;
						}
						else
						{   
							$dataMov[$i]['credito'] = self::limpiarVal($request->v_impuesto_consumo);
							$dataMov[$i]['debito'] = 0;
						}
						$dataMov[$i]['referencia'] = "PAGOPLAN-".$request->codigo_tienda."/".$request->id;
						$dataMov[$i]['id_configuracion_contable'] = env('ID_CONFIG_CONTABLE_PLAN_SEPARE');
						$dataMov[$i]['valor'] = self::limpiarVal($request->total);
						$dataMov[$i]['tercero'] = $request->numero_documento;
					}
					break;
				case 7:
					if($request->v_impuesto_consumo > 0){
						$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_pr,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
						$codigoMovimiento = $secuencias[0]->response;
						$dataMov[$i]['id_movimiento'] = $codigoMovimiento;
						$dataMov[$i]['id_cierre'] = $CierreActual[0]->id_cierre;
						$dataMov[$i]['id_tienda'] = $request->id_tienda_pr;
						$dataMov[$i]['codigo_movimiento'] = $codigoComprobante;                
						$dataMov[$i]['fecha'] = date("Y-m-d H:i:s");
						$dataMov[$i]['id_tipo_documento'] = (int)17;
						$dataMov[$i]['cuenta'] = env('CUENTA_RETECREE');
						$dataMov[$i]['descripcion'] = "IMPUESTO RETECREE";
						$naturaleza = VentaBL::getNatBy(env('CUENTA_RETECREE'));
						if($naturaleza->naturaleza == 1)
						{
							$dataMov[$i]['debito'] = self::limpiarVal($retecree);
							$dataMov[$i]['credito'] = 0;
						}
						else
						{   
							$dataMov[$i]['credito'] = self::limpiarVal($retecree);
							$dataMov[$i]['debito'] = 0;
						}
						$dataMov[$i]['referencia'] = "PAGOPLAN-".$request->codigo_tienda."/".$request->id;
						$dataMov[$i]['id_configuracion_contable'] = env('ID_CONFIG_CONTABLE_PLAN_SEPARE');
						$dataMov[$i]['valor'] = self::limpiarVal($request->total);
						$dataMov[$i]['tercero'] = $request->numero_documento;
					}
					break;
				
				default:
					
					break;
			}
			
		}

		$dataMov = array_values($dataMov);

		$secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_pr,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
		$codigoMovimiento = $secuencias[0]->response;
		$naturaleza = VentaBL::getNaturalezaBy(env('CUENTA_PLAN_2'));
		$conf = VentaBL::getConfContable($naturaleza->id_cod_puc);
		$n = count($dataMov) + 1;

		$dataMov[$n]['id_movimiento'] = $codigoMovimiento;
		$dataMov[$n]['id_cierre'] = $CierreActual[0]->id_cierre;
		$dataMov[$n]['id_tienda'] = $request->id_tienda_pr;
		$dataMov[$n]['codigo_movimiento'] = $codigoComprobante;                
		$dataMov[$n]['fecha'] = date("Y-m-d H:i:s");
		$dataMov[$n]['id_tipo_documento'] = (int)17;
		$dataMov[$n]['cuenta'] = $conf->cuenta;
		$dataMov[$n]['descripcion'] = $conf->nombre;
		$dataMov[$n]['referencia'] = "PAGOPLAN-".$request->codigo_tienda."/".$request->id;
		$dataMov[$n]['id_configuracion_contable'] = env('ID_CONFIG_CONTABLE_PLAN_SEPARE');
		$dataMov[$n]['valor'] = self::limpiarVal($request->total);
		$dataMov[$n]['tercero'] = $request->numero_documento;
		if($naturaleza->naturaleza == 1)
		{
			$dataMov[$n]['debito'] = self::limpiarVal($request->total);
			$dataMov[$n]['credito'] = 0;
		}
		else
		{   
			$dataMov[$n]['credito'] = self::limpiarVal($request->total);
			$dataMov[$n]['debito'] = 0;
		}
		
		$msm=VentaBL::facturarPlan($request,$request->id,$request->id_tienda_pr,$dataMov);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
			$pdf = PDF::setPaper('a4', 'landscape');
			$pdf->loadView( 'Venta.pdfactura', [ 'tienda' => \tienda::Online(),
			'numero_factura' => $codigoComprobante,
			'info_cliente' => $info_cliente,
			'info_inventario' => $info_inventario,
			'empleado' => $empleado,
			'request' => $request ] );
			return $pdf->download( 'facturaventa.pdf' );
			return redirect('/generarplan');
		}
		else{
			Session::flash('error', $msm['msm']);
			return redirect('/generarplan');
		}
		return redirect()->back();
		
	}

	public static function limpiarVal($val)
	{
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}

	public static function volverVal($val)
	{
		$valLimpiar = str_replace('.',',',$val);
		return $valLimpiar;
	}

	public function getPrecioBolsa()
	{
		return response()->json(VentaBL::getPrecioBolsa());
	}

}



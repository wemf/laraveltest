<?php

namespace App\Http\Controllers\Nutibara\GestionTesoreria\Causacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\GestionTesoreria\Causacion\CrudCausacion;
use Illuminate\Support\Facades\Session;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Sociedad\Sociedad;
use App\BusinessLogic\Nutibara\Refaccion\CrudRefaccion;
use App\BusinessLogic\Nutibara\Clientes\TipoDocumento\CrudTipoDocumento;
use App\BusinessLogic\Nutibara\Sociedad\CrudSociedad;
use App\BusinessLogic\Nutibara\GestionTesoreria\Impuesto\CrudImpuesto;
use App\BusinessLogic\Nutibara\GestionTesoreria\ConfiguracionContable\CrudConfiguracionContable;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use App\BusinessLogic\Nutibara\Arqueo\CrudArqueo;
use Illuminate\Support\Facades\Auth;


class CausacionController extends Controller
{
    public function Index(){ 
        $ipValidation = new userIpValidated();
        $Tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());		
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/causacion',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/causacion',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/causacion',
				'text'=>'Causacion'
			]
		);
		return view('GestionTesoreria.Causacion.index',['urls'=>$urls, 'Tienda' => $Tienda]);
    }

	public function get(Request $request){
		$ipValidation = new userIpValidated();
		$tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());	
		$users = Auth::user();
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["id_tienda"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
		$search["id_estado"] = str_replace($vowels, "", $request->columns[5]['search']['value']);
		$search["fecha_creado"] = str_replace($vowels, "", $request->columns[6]['search']['value']);
		$search["id_tipo_causacion"] = str_replace($vowels, "", $request->columns[7]['search']['value']);
		$search["primera_busqueda"] = str_replace($vowels, "", $request->columns[8]['search']['value']);
		if($users->id_role == env('ROL_TESORERIA') || $users->id_role == env('ROLE_SUPER_ADMIN'))
		{
			$total=CrudCausacion::getCountCausacionAdmin($search);
			$data=[           
				"draw"=> $draw,
				"recordsTotal"=> $total,
				"recordsFiltered"=> $total,
				"data"=>CrudCausacion::CausacionAdmin($start,$end,$colum, $order,$search)
			];   
		}
		else
		{
			$search['id_tienda'] = $tienda['id'];
			$total=CrudCausacion::getCountCausacion($search);
			$data=[           
				"draw"=> $draw,
				"recordsTotal"=> $total,
				"recordsFiltered"=> $total,
				"data"=>CrudCausacion::Causacion($start,$end,$colum, $order,$search)
			];
		}
		return response()->json($data);
	}
	
	public function Update($id,$idTienda)
	{
		$data['causacion'] = CrudCausacion::getCausacionByIdandTienda($id,$idTienda);
		$sociedad = Sociedad::getSelectSociedadByTienda($idTienda);
		$tipoDocumento = CrudTipoDocumento::getSelectList2();
		$tiposCausacion = CrudCausacion::getSelectListTipoCausacion();
		$sociedadactual = CrudSociedad::getSelectSociedadByTienda($idTienda);
		$sociedades = CrudSociedad::getSelectList($idTienda);
		$impuestos = CrudImpuesto::getSelectList();
		$CierreCajaActual = CrudArqueo::getCierreCaja($idTienda);
		$tipo_documento_contables = CrudConfiguracionContable::getSelectListTipoDocumentoContable();
		$data['detalle']='';
		switch ($data['causacion']['id_tipo_causacion']) {
			case 2: //Pago de nomina
				$data['detalle'] = CrudCausacion::getPagoNomina($data['causacion']['id'],$data['causacion']['id_tienda']);
			break;
			default:
				break;
		}
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/causacion',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/causacion',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/causacion',
				'text'=>'Causacion'
			],
			[
				'href' => 'tesoreria/causacion/update/'.$data['causacion']['id'].'/'.$data['causacion']['id_tienda'],
				'text' => 'Actualizar Causacion'
			]
		);
		return view('GestionTesoreria.Causacion.update',['causacion' => $data['causacion'],
														'sociedad' => $sociedad,
														"tiposdocumentos" => $tipoDocumento,
														"tiposcausacion" => $tiposCausacion,
														"sociedad" => $sociedadactual,
														"sociedades" => $sociedades,
														"impuestos" => $impuestos,
														"tipo_documento_contables" => $tipo_documento_contables,
														"detalles" => $data['detalle'],
														"cierre_caja_actual" => $CierreCajaActual,
														'urls'=>$urls]);
	}

    public function Create(){

		$ipValidation = new userIpValidated();
		$tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$sociedad = Sociedad::getSelectSociedadByTienda($tienda->id);
		$tipoDocumento = CrudTipoDocumento::getSelectList2();
		$tiposCausacion = CrudCausacion::getSelectListTipoCausacion();
		$sociedadactual = CrudSociedad::getSelectSociedadByTienda($tienda->id);
		$sociedades = CrudSociedad::getSelectList($tienda->id);
		$impuestos = CrudImpuesto::getSelectList();
		$tipo_documento_contables = CrudConfiguracionContable::getSelectListTipoDocumentoContable();
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/causacion',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/causacion',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/causacion',
				'text'=>'Causacion'
			],
			[
				'href' => 'tesoreria/causacion',
				'text' => 'Crear Causacion'
			],
		);
		return view('GestionTesoreria.Causacion.create',['urls'=>$urls,
														"tienda" => $tienda,
														"sociedad" => $sociedad,
														"tiposdocumentos" => $tipoDocumento,
														"tiposcausacion" => $tiposCausacion,
														"sociedad" => $sociedadactual,
														"sociedades" => $sociedades,
														"impuestos" => $impuestos,
														"tipo_documento_contables" => $tipo_documento_contables
														]);
    }

	public function Pay($id,$idTienda,$formaPago,$automatico=0)
	{
		$users = Auth::user();				
		$data['causacion']=CrudCausacion::getCausacionByIdandTienda($id,$idTienda);
		if($formaPago == 1)
		$movimiento_contable = env('CONFIGUACION_CONTABLE_PAGO_BANCO');
		elseif($formaPago == 2)
		$movimiento_contable = env('CONFIGUACION_CONTABLE_PAGO_CAJA');
		
		if($data['causacion']['id_tipo_causacion'] == 2)
		$referencia = 'PAGON - '.$data['causacion']['id_tienda'].'/'.$data['causacion']['id'];
		if(MovimientosTesoreria::registrarMovimientos($data['causacion']['valor'],$idTienda,$movimiento_contable,$data['causacion']['comprobante_contable'],$referencia,$automatico))
		{
			$msm=CrudCausacion::Pay($id,$idTienda,$users['id']);
			if($msm['val']=='Actualizado'){
				Session::flash('message', $msm['msm']);
				return redirect('/tesoreria/causacion');
			}
			elseif($msm['val']=='Error'){
				Session::flash('error', $msm['msm']);
			}
			elseif($msm['val']=='ErrorUnico'){
				Session::flash('warning', $msm['msm']);
			}
			return redirect('/tesoreria/causacion');			
		}
	}

	public function CreateSalarioPost(request $request)
	{
		$users = Auth::user();		
		$request->valor = str_replace('.','',$request->valor);
		$request->total = str_replace('.','',$request->total);

		$cont = 0;
		foreach($request["empleados"] as $empleado)
		{
			for ($i=0; $i < count($empleado["id_empleado"]); $i++) 
			{ 
				$datosEmpleados[$cont]["id_empleado"] = $empleado["id_empleado"][$i]; 
				$datosEmpleados[$cont]["id_tienda_empleado"] = $empleado["id_tienda_empleado"][$i]; 
				$datosEmpleados[$cont]["descripcion"] = $empleado["descripcion"][$i]; 
				$datosEmpleados[$cont]["naturaleza"] = $empleado["naturaleza"][$i]; 
				$datosEmpleados[$cont]["cuenta"] = $empleado["cuenta"][$i]; 
				$datosEmpleados[$cont]["descripcion_pago"] = $empleado["descripcionpago"][$i]; 
				$datosEmpleados[$cont]["valor"] = str_replace('.','',$empleado["valor"][$i]); 
				$cont++;
			}
		}

		$datosCausacion=
		[
			'id_tienda' => $request->id_tienda,
			'id_estado' => 100,
			'fecha_creado' => date('Y-m-d H:i:s'),
			'id_usuario_actualizacion' =>$users['id'],
			'id_tipo_causacion' => $request->id_tipo_causacion,
			'valor' => $request->total
		];

		$datosContables = 
		[
			'id_tipo_configuracion_contable' => $request->id_tipo_configuracion_contable,
			'id_tipo_documento_contable' => $request->id_tipo_documento_contable,
			'id_tienda' => $request->id_tienda,
			'causacion' => $request->cxc,
			'total' => $request->total,
			'automatico' => 0
		];

		$msm=CrudCausacion::CreateSalario($datosCausacion,$datosEmpleados);
		if($msm['val']==true){
			$datosContables['id_causacion'] = $msm['id_causacion'];
			$datosContables['referencia'] = 'CAUSPAGON - '.$datosCausacion['id_tienda'].'/'.$msm['id_causacion'];
			MovimientosTesoreria::causarSalario($datosContables,$datosEmpleados,0);
			Session::flash('message', $msm['msm']);
			return redirect('/tesoreria/causacion');
		}
		elseif($msm['val']==false)
		{
			Session::flash('error', $msm['msm']);
		}
	}

	
	public function CreateGastoTiendaPost(request $request)
	{
		$users = Auth::user();		
		$request->valor = str_replace('.','',$request->valor);
		$request->total = str_replace('.','',$request->total_campana);
		$datosEmpleados = [];
		$cont = 0;
		dd($request);
		/*if($request["empleados"]!= null) {
			foreach($request["empleados"] as $empleado)
			{
				for ($i=0; $i < count($empleado["id_empleado"]); $i++) 
				{ 
					$datosEmpleados[$cont]["id_empleado"] = $empleado["id_empleado"][$i]; 
					$datosEmpleados[$cont]["id_tienda_empleado"] = $empleado["id_tienda_empleado"][$i]; 
					$datosEmpleados[$cont]["descripcion"] = $empleado["descripcion"][$i]; 
					$datosEmpleados[$cont]["naturaleza"] = $empleado["naturaleza"][$i]; 
					$datosEmpleados[$cont]["cuenta"] = $empleado["cuenta"][$i]; 
					$datosEmpleados[$cont]["descripcion_pago"] = $empleado["descripcionpago"][$i]; 
					$datosEmpleados[$cont]["valor"] = str_replace('.','',$empleado["valor"][$i]); 
					$cont++;
				}
			}
		}*/
		
		$datosCausacion=
		[
			'id_tienda' => $request->id_tienda,
			'id_estado' => 100,
			'fecha_creado' => date('Y-m-d H:i:s'),
			'id_usuario_actualizacion' =>$users['id'],
			'id_tipo_causacion' => $request->id_tipo_causacion,
			'valor' => $request->total
		];
		$datosContables = 
		[
			'id_tipo_configuracion_contable' => $request->id_tipo_configuracion_contable,
			'id_tipo_documento_contable' => $request->id_tipo_documento_contable,
			'id_tienda' => $request->id_tienda,
			'causacion' => $request->cxc,
			'total' => $request->total,
			'automatico' => 0
		];
		dd($request);

		$msm=CrudCausacion::CreateSalario($datosCausacion,$datosEmpleados);
		if($msm['val']==true){
			$datosContables['id_causacion'] = $msm['id_causacion'];
			$datosContables['referencia'] = 'CAUSGAST - '.$datosCausacion['id_tienda'].'/'.$msm['id_causacion'];
			MovimientosTesoreria::causarSalario($datosContables,$datosEmpleados,0);
			Session::flash('message', $msm['msm']);
			return redirect('/tesoreria/causacion');
		}
		elseif($msm['val']==false)
		{
			Session::flash('error', $msm['msm']);
		}
	}

	public function CreateAnticipoPost(request $request)
	{
		$users = Auth::user();		
		$request->valor = str_replace('.','',$request->valor);
		$request->total = str_replace('.','',$request->total);

		$cont = 0;
		foreach($request["empleados"] as $empleado)
		{
			for ($i=0; $i < count($empleado["id_empleado"]); $i++) 
			{ 
				$datosEmpleados[$cont]["id_empleado"] = $empleado["id_empleado"][$i]; 
				$datosEmpleados[$cont]["id_tienda_empleado"] = $empleado["id_tienda_empleado"][$i]; 
				$datosEmpleados[$cont]["descripcion"] = $empleado["descripcion"][$i]; 
				$datosEmpleados[$cont]["naturaleza"] = $empleado["naturaleza"][$i]; 
				$datosEmpleados[$cont]["cuenta"] = $empleado["cuenta"][$i]; 
				$datosEmpleados[$cont]["descripcion_pago"] = $empleado["descripcionpago"][$i]; 
				$datosEmpleados[$cont]["valor"] = str_replace('.','',$empleado["valor"][$i]); 
				$cont++;
			}
		}

		$datosCausacion=
		[
			'id_tienda' => $request->id_tienda,
			'id_estado' => 100,
			'fecha_creado' => date('Y-m-d H:i:s'),
			'id_' => date('Y-m-d H:i:s'),
			'id_tipo_causacion' => $request->id_tipo_causacion,
			'valor' => $request->total
		];

		$datosContables = 
		[
			'id_tipo_configuracion_contable' => $request->id_tipo_configuracion_contable,
			'id_tipo_documento_contable' => $request->id_tipo_documento_contable,
			'id_tienda' => $request->id_tienda,
			'causacion' => $request->cxc,
			'total' => $request->total
		];

		$msm=CrudCausacion::CreateAnticipo($datosCausacion,$datosEmpleados);
		if($msm['val']==true)
		{
			$datosContables['id_causacion'] = $msm['id_causacion'];
			$datosContables['referencia'] = 'PAGON'.$msm['id_causacion'].'/'.$datosCausacion['id_tienda'];
			MovimientosTesoreria::causarSalario($datosContables,$datosEmpleados);
			Session::flash('message', $msm['msm']);
			return redirect('/tesoreria/causacion');
		}
		elseif($msm['val']==false){
			Session::flash('error', $msm['msm']);
		}
	}

	public function CreateSalarioWithPay(request $request)
	{
		$request->valor = str_replace('.','',$request->valor);
		$request->total = str_replace('.','',$request->total);

		$cont = 0;
		foreach($request["empleados"] as $empleado)
		{
			for ($i=0; $i < count($empleado["id_empleado"]); $i++) 
			{ 
				$datosEmpleados[$cont]["id_empleado"] = $empleado["id_empleado"][$i]; 
				$datosEmpleados[$cont]["id_tienda_empleado"] = $empleado["id_tienda_empleado"][$i]; 
				$datosEmpleados[$cont]["descripcion"] = $empleado["descripcion"][$i]; 
				$datosEmpleados[$cont]["naturaleza"] = $empleado["naturaleza"][$i]; 
				$datosEmpleados[$cont]["cuenta"] = $empleado["cuenta"][$i]; 
				$datosEmpleados[$cont]["descripcion_pago"] = $empleado["descripcionpago"][$i]; 
				$datosEmpleados[$cont]["valor"] = str_replace('.','',$empleado["valor"][$i]); 
				$cont++;
			}
		}

		$datosCausacion=
		[
			'id_tienda' => $request->id_tienda,
			'id_estado' => 100,
			'fecha_creado' => date('Y-m-d H:i:s'),
			'id_tipo_causacion' => $request->id_tipo_causacion,
			'valor' => $request->total
		];

		$datosContables = 
		[
			'id_tipo_configuracion_contable' => $request->id_tipo_configuracion_contable,
			'id_tipo_documento_contable' => $request->id_tipo_documento_contable,
			'id_tienda' => $request->id_tienda,
			'causacion' => $request->cxc,
			'total' => $request->total,
			'automatico' => 1			
		];
		//(Datos de la causacion,$datos del empelado,enviar mensaje)
		$msm=CrudCausacion::CreateSalario($datosCausacion,$datosEmpleados,1);
		if($msm['val']==true)
		{
			$datosContables['id_causacion'] = $msm['id_causacion'];
			$datosContables['referencia'] = 'PAGON - '.$datosCausacion['id_tienda'].'/'.$msm['id_causacion'];
			MovimientosTesoreria::causarSalario($datosContables,$datosEmpleados,1);
			CausacionController::Pay($msm['id_causacion'],$datosCausacion['id_tienda'],$request->formaPago,1);		
			return redirect('/tesoreria/causacion');	
		}
		elseif($msm['val']==false){
			Session::flash('error', $msm['msm']);
		}
	}

	public function Transfer($id,$idTienda)
	{
		$msm=CrudCausacion::Transfer($id,$idTienda);
			if($msm['val']=='Actualizado'){
				Session::flash('message', $msm['msm']);
				return redirect('/tesoreria/causacion');
			}
			elseif($msm['val']=='Error'){
				Session::flash('error', $msm['msm']);
			}
			elseif($msm['val']=='ErrorUnico'){
				Session::flash('warning', $msm['msm']);
			}
			return redirect('/tesoreria/causacion');
	}

	public function AnularCausacion(request $request)
	{
		$users = Auth::user();
		if($users->id_role == env('ROL_JEFE_ZONA') || $users->id_role == env('ROL_TESORERIA') || $users->id_role == env('ROLE_SUPER_ADMIN'))
		{
			if($request->id_tipo_causacion == 2)
			{
				$referencia= "ANUPAGON - ".$request->id_tienda_causacion."/".$request->id_causacion;
				MovimientosTesoreria::AnularCausacionConPago($request->comprobante_contable,$request->id_tienda,$referencia,'Cau');			
				$msm=CrudCausacion::AnularCausacion($request->id_causacion,$request->id_tienda_causacion,$users['id']);
				if($msm['val']=='Actualizado'){
					Session::flash('message', $msm['msm']);
					return redirect('/tesoreria/causacion');
				}
				elseif($msm['val']=='Error'){
					Session::flash('error', $msm['msm']);
				}
				elseif($msm['val']=='ErrorUnico'){
					Session::flash('warning', $msm['msm']);
				}
				return redirect('/tesoreria/causacion');
			}
		}
		else
		{
			if($request->id_cierre_caja_realizado == $request->id_cierre_caja_actual)
			$dirijido = env('ROL_JEFE_ZONA');
			else
			$dirijido = env('ROLE_SUPER_ADMIN');
			$msm = CrudCausacion::SolicitarAnulacion($dirijido,$request->id_causacion,$request->id_tienda_causacion,111);
			if($msm['val']=='Actualizado')
			{
				Session::flash('message', $msm['msm']);				
				return redirect('/tesoreria/causacion');	
			}
			else
			Session::flash('error', $msm['msm']);
		}
	}

	public function AnularCausacionConPago(request $request)
	{
		$users = Auth::user();
		if($users->id_role == env('ROL_JEFE_ZONA') || $users->id_role == env('ROL_TESORERIA') || $users->id_role == env('ROLE_SUPER_ADMIN'))
		{
			if($request->id_tipo_causacion == 2)
			$referencia= "ANUPAGON - ".$request->id_tienda_causacion."/".$request->id_causacion;
			if(MovimientosTesoreria::AnularCausacionConPago($request->comprobante_contable,$request->id_tienda,$referencia,'CauPago'))
			{
				$msm=CrudCausacion::AnularCausacion($request->id_causacion,$request->id_tienda_causacion,$users['id']);
				if($msm['val']=='Actualizado'){
					Session::flash('message', $msm['msm']);
					return redirect('/tesoreria/causacion');
				}
				elseif($msm['val']=='Error'){
					Session::flash('error', $msm['msm']);
				}
				elseif($msm['val']=='ErrorUnico'){
					Session::flash('warning', $msm['msm']);
				}
				return redirect('/tesoreria/causacion');			
			}
		}
		else
		{
			if($request->id_cierre_caja_realizado == $request->id_cierre_caja_actual)
			$dirijido = env('ROL_JEFE_ZONA');
			else
			$dirijido = env('ROLE_SUPER_ADMIN');
			$msm = CrudCausacion::SolicitarAnulacion($dirijido,$request->id_causacion,$request->id_tienda_causacion,112);
			if($msm['val']=='Actualizado')
			{
				Session::flash('message', $msm['msm']);				
				return redirect('/tesoreria/causacion');	
			}
			else
				Session::flash('error', $msm['msm']);			
		}
	}

	public function AnularPago(request $request)
	{
		$users = Auth::user();
		if($users->id_role == env('ROL_JEFE_ZONA') || $users->id_role == env('ROL_TESORERIA') || $users->id_role == env('ROLE_SUPER_ADMIN'))
		{
			if($request->id_tipo_causacion == 2)
			$referencia= "ANUPAGON - ".$request->id_tienda_causacion."/".$request->id_causacion;
			if(MovimientosTesoreria::AnularCausacionConPago($request->comprobante_contable,$request->id_tienda,$referencia,'Pago'))
			{
				$msm=CrudCausacion::AnularCausacion($request->id_causacion,$request->id_tienda_causacion,$users['id']);
				if($msm['val']=='Actualizado'){
					Session::flash('message', $msm['msm']);
					return redirect('/tesoreria/causacion');
				}
				elseif($msm['val']=='Error'){
					Session::flash('error', $msm['msm']);
				}
				elseif($msm['val']=='ErrorUnico'){
					Session::flash('warning', $msm['msm']);
				}
				return redirect('/tesoreria/causacion');			
			}
		}
		else
		{
			if($request->id_cierre_caja_realizado == $request->id_cierre_caja_actual)
			$dirijido = env('ROL_JEFE_ZONA');
			else
			$dirijido = env('ROLE_SUPER_ADMIN');
			$msm = CrudCausacion::SolicitarAnulacion($dirijido,$request->id_causacion,$request->id_tienda_causacion,113);
			if($msm['val']=='Actualizado')
			{
				Session::flash('message', $msm['msm']);				
				return redirect('/tesoreria/causacion');	
			}
			else
				Session::flash('error', $msm['msm']);		
		}
	}
	
	public function getSelectList()
	{
		$msm = CrudCausacion::getSelectList();
		return  response()->json($msm);
	}

	public function getSelectListById(request $request)
	{
		$msm = CrudCausacion::getSelectListById($request->id);
		return  response()->json($msm);
	}

	public function getSelectListCodigo(request $request)
	{
		$msm = CrudCausacion::getSelectListCodigo($request->id);
		return  response()->json($msm);
	}

	public function getSelectListNombre(request $request)
	{
		$msm = CrudCausacion::getSelectListNombre($request->id);
		return  response()->json($msm);
	}
	
	public function getImpuestosByPais()
	{
		$msm = CrudCausacion::getImpuestosByPais();
		return  response()->json($msm);
	}
	
	public function getSelectListTipoCausacion(request $request)
	{
		$msm = CrudCausacion::getSelectListTipoCausacion();
		return response()->json($msm);
	}
}

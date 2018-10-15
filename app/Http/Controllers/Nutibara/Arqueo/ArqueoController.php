<?php

namespace App\Http\Controllers\Nutibara\Arqueo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AccessObject\Nutibara\Parametros\Parametros;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\Arqueo\CrudArqueo;
use App\BusinessLogic\Nutibara\GestionTesoreria\MovimientosContables\SPMovimientosContables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Tienda\Tienda;
use config\messages;
use App\Usuario;
use PDF;
use Carbon\Carbon;
use DB;


class ArqueoController extends Controller
{
    public function Index($cierreCaja = null){
		$cierreCAja = 'No';
		$users = Usuario::all();
		$users_online = '';
		$cantidadUsuarios= array();	
		foreach ($users as $user ) 
		{
			if($user->isOnline() && $user->estado == 1 && $user->id_role != env('ROLE_SUPER_ADMIN'))
			{
				$users_online .= $user->name.', ';
			}
		}
		$cantidadUsuarios = explode(',',$users_online);
		
		if( count($cantidadUsuarios) <= 2 )
		{
			$ipValidation = new userIpValidated();
			$Tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
			$InfoTienda = ArqueoController::getTiendaInfo($Tienda->id);
			$Monedas = ArqueoController::getMonedas();
			$Fecha = Date('d-m-Y H:i:s');
			$CierreCajaActual = ArqueoController::getCierreCaja($Tienda->id);
			$IngresosEgresos = DB::select('CALL sp_s_ingresos_egresos(?,?)',array($CierreCajaActual->id_cierre,$CierreCajaActual->id_tienda));
			$urls=array(
				[
					'href'=>'home',
					'text'=>'home'
				],
				[
					'href'=>'tesoreria/arqueo',
					'text'=>'Gestión de Contabilidad'
				],
				[
					'href'=>'tesoreria/arqueo',
					'text'=>'Arqueo'
				]
			);
			$total_sistema = (($CierreCajaActual->saldo_inicial + $IngresosEgresos[0]->tipo) - $IngresosEgresos[1]->tipo);
			$CierreCajaActual->fecha_inicio = date('d-m-Y H:i:s',strtotime($CierreCajaActual->fecha_inicio));
			return view('Arqueo.create',['urls'=>$urls,
														'Usuario' => Auth::user()->name,
														'Ingresos' => $IngresosEgresos[0]->tipo,
														'Egresos' => $IngresosEgresos[1]->tipo,
														'Monedas' => $Monedas,
														'Tienda' => $Tienda->nombre,
														'Fecha' => $Fecha,
														'InfoTienda' => $InfoTienda,
														'CierreCajaActual' => $CierreCajaActual,
														'cierreCaja' => $cierreCaja,
														'total_sistema' => $total_sistema,
														]);
		}
		else
		{
			return redirect('/home')->with('error','El (Los) usuario(s):  ' .$users_online. ' aún tienen una sesión vigente.');
		}
	}

	public function generatePDF(Request $request)
	{
		$object = $request->all();
		$ipValidation = new userIpValidated();
		$Tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$user = Auth::user()->id;
		//$CierreCajaActual = ArqueoController::getCierreCaja($Tienda->id);
		ArqueoController::registrarAuditoria($request,$Tienda->id,$user);
		//SPMovimientosContables::SPMovimietnosContables($CierreCajaActual->id_cierre,$Tienda->id);
		$pdf = PDF::loadView('DocumentosPDF.arqueopdf', [ 'object' => $object,'usuario' => $user ]);
		return $pdf->download('arqueopdf.pdf');
	}

	public function registrarAuditoria($request,$Tienda,$usuario)
	{
		return crudArqueo::registrarAuditoria($request,$Tienda,$usuario);
	}
	
	public function nuevoCierre(Request $request)
	{
		$ipValidation = new userIpValidated();
		$Tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$msm=['msm'=>Messages::$Arqueo['ok'],'val'=>'Insertado'];		
		if(!CrudArqueo::nuevoCierre($Tienda->id,$request->saldo))
		{
			$msm=['msm'=>Messages::$Arqueo['error'],'val'=>'Error'];	
		}
		return $msm;
	}

	public function getMonedas()
	{
		$id_pais = Parametros::getSelectPais();
		return crudArqueo::getMonedas($id_pais);
	}

	public function getTiendaInfo($id)
	{
		return crudArqueo::getTiendaInfo($id);
	}

	public function cerrarTienda($id)
	{
		return crudArqueo::cerrarTienda($id);
	}

	public function getCierreCaja($id)
	{
		return crudArqueo::getCierreCaja($id);
	}

	public function getEgresos($id)
	{
		return crudArqueo::getEgresos($id);
	}

	public function getIngresos($id)
	{
		return crudArqueo::getIngresos($id);
	}

	public function getUltimoArqueo($Tienda)
	{
		return crudArqueo::getUltimoArqueo($Tienda);
	}
}

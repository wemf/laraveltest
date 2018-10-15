<?php
 
namespace App\Http\Controllers\Nutibara\CierreCaja;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AccessObject\Nutibara\Parametros\Parametros;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\CierreCaja\CrudCierreCaja;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\userIpValidated;
use App\Http\Controllers\Nutibara\Arqueo\ArqueoController;
use App\AccessObject\Nutibara\Tienda\Tienda;
use App\Usuario;
use PDF;
use Carbon\Carbon;
use DB;
use dateFormate;

class CierreCajaController extends Controller
{
		
    public function Index(){
		//enviar esta variable me indica que este arqueo es de Caja, y tiene que continuar.
		$cierreCaja = [];
		//----------------
		$users = Usuario::all();
		$arqueo = new ArqueoController();
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
			$InfoTienda = $arqueo->getTiendaInfo($Tienda->id);
			$Monedas = $arqueo->getMonedas();
            $Fecha = Date('Y-m-d H:i:s');
			//$arqueo->cerrarTienda($Tienda->id);
			$CierreCajaActual = $arqueo->getCierreCaja($Tienda->id);
			$IngresosEgresos =\DB::select('CALL sp_s_ingresos_egresos(?,?)',array($CierreCajaActual->id_cierre,$CierreCajaActual->id_tienda));			
			$urls=array(
				[
					'href'=>'home',
					'text'=>'home'
				],
				[
					'href'=>'/tesoreria/cierrecaja',
					'text'=>'Gestión de Contabilidad'
				],
				[
					'href'=>'/tesoreria/cierrecaja',
					'text'=>'Arqueo'
				]
			);
			return view('Arqueo.create',['urls'=>$urls,
														'Usuario' => Auth::user()->name,
														'Ingresos' => $IngresosEgresos[0]->tipo,
														'Egresos' => $IngresosEgresos[1]->tipo,
														'Monedas' => $Monedas,
														'Tienda' => $Tienda->nombre,
														'Fecha' => $Fecha, 
														'InfoTienda' => $InfoTienda,
														'CierreCajaActual' => $CierreCajaActual,
														'cierreCaja' => $cierreCaja]);
		}
		else
		{
			return redirect('/home')->with('error','El (Los) usuario(s):  ' .$users_online. ' aún tienen una sesión vigente.');
		}
    }
    
    public function IndexCierreCaja()
    {
		$arqueo = new ArqueoController();		
		$ipValidation = new userIpValidated();
		$Tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$InfoTienda = $arqueo->getTiendaInfo($Tienda->id);
		$CierreCajaActual = $arqueo->getCierreCaja($Tienda->id);
		$UltimoArqueo = $arqueo->getUltimoArqueo($Tienda->id);
		$Fecha = Date('Y-m-d H:i:s');
		$IngresosEgresos =\DB::select('CALL sp_s_ingresos_egresos(?,?)',array($CierreCajaActual->id_cierre,$CierreCajaActual->id_tienda));					
		$ReporteCierreCaja =\DB::select('CALL sp_s_cierre_caja_informe(?,?)',array($CierreCajaActual->id_cierre,$CierreCajaActual->id_tienda));			

		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'/tesoreria/cierrecaja',
				'text'=>'Gestión de Contabilidad'
			],
			[
				'href'=>'/tesoreria/cierrecaja',
				'text'=>'Arqueo'
			],
			[
				'href'=>'/tesoreria/cierrecajaindex',
				'text'=>'Cierre De Caja'
			],
		);

		return view('CierreCaja.create',['urls'=>$urls,
														'Usuario' => Auth::user()->name,
														'Tienda' => $Tienda->nombre,
														'ReporteCierreCaja' => $ReporteCierreCaja,
														'Ingresos' => $IngresosEgresos[0]->tipo,
														'Egresos' => $IngresosEgresos[1]->tipo,
														'Fecha' => $Fecha, 
														'CierreCajaActual' => $CierreCajaActual,
														'UltimoArqueo' => $UltimoArqueo->id_arqueo,
														'InfoTienda' => $InfoTienda]);
    }

	public function generatePDF(Request $request)
	{
		$object = $request->all();		
		$ipValidation = new userIpValidated();
		$Tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$user = Auth::user()->name;
		CierreCajaController::registrarAuditoria($request,$Tienda->id,$user);
		$pdf = PDF::loadView('DocumentosPDF.CierreCajapdf', [ 'object' => $object,'usuario' => $user ]);
		return $pdf->download('CierreCajapdf.pdf');
	}

	public function terminarCierreCaja($saldo_final)
	{
		$saldo_final = str_replace('.','',$saldo_final);
		$ipValidation = new userIpValidated();
		$Tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$arqueo = new ArqueoController();		
		$CierreCajaActual = $arqueo->getCierreCaja($Tienda->id);

		$msm=CrudCierreCaja::terminarCierreCaja($CierreCajaActual->id_cierre,$CierreCajaActual->id_tienda,$saldo_final);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/home');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
	}
}

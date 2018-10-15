<?php 

namespace App\BusinessLogic\Nutibara\CierreCaja;
use App\AccessObject\Nutibara\CierreCaja\CierreCaja;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use config\messages;


class CrudCierreCaja {

    public static function getMonedas($pais)
	{
		return CierreCaja::getMonedas($pais);
	}

	public static function getTiendaInfo($id)
	{
		return CierreCaja::getTiendaInfo($id);
	}

	public static function registrarAuditoria($request,$tienda,$usuario)
	{
		$secuencias = SecuenciaTienda::getCodigosSecuencia($tienda,env('SECUENCIA_TIPO_CODIGO_CierreCaja'),1);
		$codigoCierreCaja = $secuencias[0]->response;
		$dataSaved = 
		[		
			'id_CierreCaja' =>$codigoCierreCaja,
			'id_tienda' => $tienda,
			'usuario' => $usuario,
			'fecha_inicial_saldo' => $request->fecha_saldo_inicial,
			'saldo_inicial' =>  $request->saldo_inicial,
			'total_caja_menor' => $request->totalcajamenor,
			'total_caja_fuerte' => $request->totalcajafuerte,
			'total_fisico' => $request->totalfisico,
			'total_sistema' => $request->total_sistema,
			'sobrante' => $request->sobrante,
			'faltante' => $request->faltante,
			'fecha_CierreCaja' => $request->fecha,
			'observaciones' => $request->observaciones
		];
		return CierreCaja::registrarAuditoria($dataSaved);
	}

	public static function getCierreCaja($id)
	{
		return CierreCaja::getCierreCaja($id);
	}

	public static function cerrarTienda($id)
	{
		return CierreCaja::cerrarTienda($id);
	}

	public static function getinfoCierreCaja($id_cierre, $id_tienda)
	{
		return CierreCaja::getinfoCierreCaja($id_cierre, $id_tienda);
	}

	public static function terminarCierreCaja($id_cierre,$id_tienda,$saldo_final)
	{
		$respuesta = CierreCaja::terminarCierreCaja($id_cierre,$id_tienda,$saldo_final);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Arqueo['cierre_caja_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Arqueo['cierre_caja_ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	

	
}
<?php 

namespace App\BusinessLogic\Nutibara\Arqueo;
use App\AccessObject\Nutibara\Arqueo\Arqueo;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use config\messages;


class CrudArqueo {

    public static function getMonedas($pais)
	{
		return Arqueo::getMonedas($pais);
	}

	public static function getTiendaInfo($id)
	{
		return Arqueo::getTiendaInfo($id);
	}

	public static function registrarAuditoria($request,$tienda,$usuario)
	{
		$secuencias = SecuenciaTienda::getCodigosSecuencia($tienda,env('SECUENCIA_TIPO_CODIGO_ARQUEO'),1);
		$codigoArqueo = $secuencias[0]->response;
		$request->saldo_inicial = str_replace('.','',$request->saldo_inicial);
		$request->totalcajamenor = str_replace('.','',$request->totalcajamenor);
		$request->totalcajafuerte = str_replace('.','',$request->totalcajafuerte);
		$request->totalfisico = str_replace('.','',$request->totalfisico);
		$request->total_sistema = str_replace('.','',$request->total_sistema);
		$request->sobrante = str_replace('.','',$request->sobrante);
		$request->faltante = str_replace('.','',$request->faltante);
		$dataSaved = 
		[		
			'id_arqueo' =>$codigoArqueo,
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
			'fecha_arqueo' => $request->fecha,
			'observaciones' => $request->observaciones
		];
		return Arqueo::registrarAuditoria($dataSaved,$tienda);
	}

	public static function getCierreCaja($id)
	{
		return Arqueo::getCierreCaja($id);
	}

	public static function cerrarTienda($id)
	{
		return Arqueo::cerrarTienda($id);
	}

	public static function getEgresos($id)
	{
		return Arqueo::getEgresos($id);
	}

	public static function getIngresos($id)
	{
		return Arqueo::getIngresos($id);
	}

	public static function nuevoCierre($idTienda,$saldo)
	{
		$secuencias = SecuenciaTienda::getCodigosSecuencia($idTienda,env('SECUENCIA_TIPO_CODIGO_CIERRE_CAJA'),1);
		$codigoCierre = $secuencias[0]->response;
		return Arqueo::nuevoCierre($idTienda,$codigoCierre,$saldo);	
	}

	public static function getUltimoArqueo($Tienda)
	{
		return Arqueo::getUltimoArqueo($Tienda);
	}
}
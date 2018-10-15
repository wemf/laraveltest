<?php 

namespace App\BusinessLogic\Nutibara\Contratos;
use App\AccessObject\Nutibara\Contratos\Contrato as ContratoDB;
use config\Messages;
use App\BusinessLogic\Notificacion\AnularContrato as contratoMensaje;

class AnularContrato 
{
	public static function getInfoAnular($codigoContrato,$idTiendaContrato)
	{
		return ContratoDB::getInfoAnular($codigoContrato,$idTiendaContrato);
	} 
	
	public static function SolicitarAnularAction($request)
	{
		$cambioEstado=ContratoDB::cambioEstadoPendienAprobacion($request->codigoContrato,$request->idTienda);
		if($cambioEstado){
			$contratoMensaje =new contratoMensaje($request);
			$msm=$contratoMensaje->SolicitarAnular();
		}else{
			$msm=array(
				'val'=>false,
				'msm'=>Messages::$Notificacion['error_anular_contrato']
			);
		}
		return $msm;
	}

	public static function AprobarSolicitudAction($request)
	{
		$cambioEstado=ContratoDB::cambioEstadoAnulado($request->codigoContrato,$request->idTienda);
		if($cambioEstado){
			$contratoMensaje =new contratoMensaje($request);
			$msm=$contratoMensaje->AprobarSolicitud();
		}else{
			$msm=array(
				'val'=>false,
				'msm'=>Messages::$Notificacion['error_anular_contrato']
			);
		}
		return $msm;
	}

	public static function RechazarSolicitudAction($request)
	{
		$cambioEstado=ContratoDB::cambioEstadoRestablecer($request->codigoContrato,$request->idTienda);
		if($cambioEstado){
			$contratoMensaje =new contratoMensaje($request);
			$msm=$contratoMensaje->RechazarSolicitud();
		}else{
			$msm=array(
				'val'=>false,
				'msm'=>Messages::$Notificacion['error_anular_contrato']
			);
		}
		return $msm;
	}

	public static function AnularContratoAction($request)
	{
		$cambioEstado=ContratoDB::cambioEstadoAnulado($request->codigoContrato,$request->idTienda);
		if($cambioEstado){
			$msm['val']=true;
            $msm['msm']=Messages::$Notificacion['ok_anular_contrato_anulado'];
		}else{
			$msm=array(
				'val'=>false,
				'msm'=>Messages::$Notificacion['error_anular_contrato']
			);
		}
		return $msm;
	}
}
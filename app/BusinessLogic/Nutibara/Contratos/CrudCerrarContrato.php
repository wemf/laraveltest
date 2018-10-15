<?php 

namespace App\BusinessLogic\Nutibara\Contratos;
use App\AccessObject\Nutibara\Contratos\Contrato as ContratoDB;
use config\messages;
use App\BusinessLogic\Notificacion\CerrarContrato as contratoMensaje;


class CrudCerrarContrato {

    public static function getInfoCerrarContrato($codigoContrato,$idTiendaContrato)
	{
		return ContratoDB::getInfoAnular($codigoContrato,$idTiendaContrato);
	}    

	public static function consultarArchivo($id)
	{
		return ContratoDB::consultarArchivo($id);
	}

	public static function CerrarUpdate($request)
	{
		$msm=['msm'=>Messages::$CerrarContrato['ok'],'val'=>true];
		if(!ContratoDB::CerrarUpdate($request->id,$request->id_tienda))
        {
			$msm=['msm'=>Messages::$CerrarContrato['error'],'val'=>false];		
		}
		else
		{
			$contratoMensaje =new contratoMensaje($request);
			$msm=$contratoMensaje->AprobarSolicitud();
		}	
		return $msm;
	}  
	public static function ReversarCierreUpdate($request)
	{
		$msm=['msm'=>Messages::$CerrarContrato['ok'],'val'=>true];
		if(!ContratoDB::ReversarCierreUpdate($request->id,$request->id_tienda))
        {
			$msm=['msm'=>Messages::$CerrarContrato['error'],'val'=>false];		
		}
		else
		{
			$contratoMensaje =new contratoMensaje($request);
			$msm=$contratoMensaje->AprobarSolicitudreverso();
		}	
		return $msm;
	}  
	
	public static function SolicitudCerrarUpdate($request,$file1,$file2,$file3)
	{

		
		$msm=['msm'=>Messages::$CerrarContrato['ok'],'val'=>true];
		if(!ContratoDB::SolicitudCerrarUpdate($request->id,$request->id_tienda,$request->Motivo_Cierre,$file1,$file2,$file3))
        {
			$msm=['msm'=>Messages::$CerrarContrato['error'],'val'=>false];		
		}	
		else
		{
			$contratoMensaje =new contratoMensaje($request);

			$msm=$contratoMensaje->SolicitarCerrar();
		}
		return $msm;
	}  

	public static function SolicitudReversarCierreUpdate($request)
	{
		$msm=['msm'=>Messages::$CerrarContrato['ok'],'val'=>true];
		if(!ContratoDB::SolicitudReversarCierreUpdate($request->id,$request->id_tienda,$request->Motivo_Solicitud_Cierre))
        {
			$msm=['msm'=>Messages::$CerrarContrato['error'],'val'=>false];		
		}
		else
		{
			$contratoMensaje =new contratoMensaje($request);
			$msm=$contratoMensaje->SolicitarReversar();
		}
		return $msm;
	}   

	public static function ListMotivosEstado($id)
    {
		$msm = ContratoDB::ListMotivosEstado($id);
		return $msm;
	}

}
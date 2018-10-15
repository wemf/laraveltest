<?php

namespace App\BusinessLogic\Notificacion;
use App\AccessObject\Notificacion\NotificacionAO;
use config\Messages;

class NotificacionBase implements SendMenssajeInterface
{

    public function getMensajes()
    {
        return NotificacionAO::getMensajes();
    }

    public function Mensajes ($start,$end,$colum, $order,$search){
        if($search["SinLeer"]!=''){
            $search["SinLeer"]=((int)$search["SinLeer"]===0)?1:null;
        }
        if($search["EstadoResuelto"]!=''){
            $search["EstadoResuelto"]=((int)$search["EstadoResuelto"]==0)?null:1;
        }
        if(empty($search["FechaInicial"]) && empty($search["FechaFinal"]) && empty($search["Emisor"]) && empty($search["SinLeer"]) && empty($search["EstadoResuelto"])){
            $result = NotificacionAO::Mensajes($start,$end,$colum, $order);
        }else{
            $result = NotificacionAO::MensajesWhere($colum, $order,$search);   
        }
		return $result;
	}

	public function getCountMensajes()
	{
		return (int)NotificacionAO::getCountMensajes();
    }

    public function GetMensaje($id)
    {
        $response=$this->EstadoVistoOn($id);
        $response['mensaje']=NotificacionAO::GetMensaje($id);
        return $response;        
    }
    
    public function EstadoVistoOn($id)
	{
		$msm=['msm'=>Messages::$Notificacion['delete_ok'],'val'=>true];
		if(!NotificacionAO::EstadoVistoOn($id))
        {
			$msm=['msm'=>Messages::$Notificacion['delete_error'],'val'=>false];		
		}	
		return $msm;
    }

    public function Matricular($request)
    {
       return NotificacionAO::Matricular($request);
    }

    public function GetJefeZona($idTienda)
    {
        return NotificacionAO::GetJefeZona((int)$idTienda);
    }

    public function GetAdministradorTienda($idTienda)
    {
        return NotificacionAO::GetAdministradorTienda((int)$idTienda);
    }

    public function GetTesorero()
    {
        return NotificacionAO::GetTesorero();
    }

    public function GetAdministradordeTienda($idTienda)
    {
        return NotificacionAO::GetAdministradordeTienda((int)$idTienda);
    }
    
    public function GetAdminBodega($idTienda)
    {
        return NotificacionAO::GetAdminBodega((int)$idTienda);     
    }

    public function GetAdminTienda($idTienda)
    {
        return NotificacionAO::GetAdminTienda((int)$idTienda);     
    }

    public function SendMenssaje($mensaje)
    {
        return 'Implementar mensaje de salida';
    }


}
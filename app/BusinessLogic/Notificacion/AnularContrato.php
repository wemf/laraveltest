<?php
namespace App\BusinessLogic\Notificacion;
use Illuminate\Support\Facades\Auth;
use config\Messages;
use App\Mail\notificarUsuario as EmailNotificacion;
use Mail;
use App\Usuario;
use Exception;

class AnularContrato extends NotificacionBase
{   
    private $codigoContrato;
    private $idTienda;
    private $idRemitente;
    private $errorSendeEmail;

    public function __construct($request)
    {
        $this->codigoContrato=$request->codigoContrato;
        $this->idTienda=$request->idTienda;
        if(isset($request->idRemitente)){
            $this->idRemitente=$request->idRemitente;
        }else{
            $this->idRemitente=0;
        }
    }

    private function sendEmail($mensajeEmail)
    {   
        try {
            Mail::to($mensajeEmail['email_receptor'])->send(new EmailNotificacion($mensajeEmail));
        } catch (Exception $e) {
            $this->errorSendeEmail='\nNo se envio email.';
            return false;
        }
        return true;
        
    }

    public function SendMenssaje($mensaje)
    {
        $resoponse=false;
        $isMatriculado= $this->Matricular($mensaje);
        if($isMatriculado){          
            $resoponse=true;
        }
        return $resoponse;
    }

    //El Auxiliar de tienda notifica a los Jefes de Zonas
    private function NotificarJefes($mensaje,$accion)
    {
        $data=array(
            'id_grupo_notificacion'=>uniqid(),
            'id_usuario_receptor'=>0,
            'id_usuario_emisor'=>Auth::id(),
            'id_tipo_notificacion'=>2,
            'estado_visto'=>0,
            'estado_notificacion'=>0,
            'fecha'=>date("Y-m-d H:i:s"), 
            'mensaje'=>$mensaje,
            'accion'=>$accion
        );
        $dataPost=array();
        $jefeZona=$this->GetJefeZona($this->idTienda);
        if(count($jefeZona)>1){
            foreach ($jefeZona as $key => $db) {
                $data['id_usuario_receptor']=$db->id;
                array_push($dataPost,$data);
            }
        }else{
            $data['id_usuario_receptor']=$jefeZona[0]->id;
            $dataPost=$data;
        }
        $response=$this->SendMenssaje($dataPost);
        /*Enviar Email*/
        if($response){
            $mensajeEmail=array(
                'emisor'=>Auth::user()->name,
                'receptor'=>$jefeZona[0]->nombre,
                'email_receptor'=>$jefeZona[0]->email,
                'texto'=>$mensaje
            );
            if(count($jefeZona)>1){
                foreach ($jefeZona as $key => $db) { 
                    $mensajeEmail['receptor']=$db->nombre;
                    $mensajeEmail['email_receptor']=$db->email;     
                    $this->sendEmail($mensajeEmail);             
                }
            }else{
                $this->sendEmail($mensajeEmail);
            }
        }
        return $response;
    }

    //El Jefe de Zonas notifica al Auxiliar de tienda
    private function NotificarAuxiliar($mensaje,$accion)
    {
        $data=array(
            'id_grupo_notificacion'=>uniqid(),
            'id_usuario_receptor'=>$this->idRemitente,
            'id_usuario_emisor'=>Auth::id(),
            'id_tipo_notificacion'=>2,
            'estado_visto'=>0,
            'estado_notificacion'=>1,
            'fecha'=>date("Y-m-d H:i:s"), 
            'mensaje'=>$mensaje,
            'accion'=>$accion
        );       
        $response=$this->SendMenssaje($data); 
          /*Enviar Email*/
          if($response){
            $receptor=Usuario::find($this->idRemitente);
            $mensajeEmail=array(
                'emisor'=>Auth::user()->name,
                'receptor'=>$receptor->name,
                'email_receptor'=>$receptor->email,
                'texto'=>$mensaje
            );          
            $this->sendEmail($mensajeEmail);            
        }
        return $response;
    }

    public function SolicitarAnular()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_anular_contrato']
        );
        $mensaje=Messages::$Notificacion['mensaje_solicitud'];
        $accion='contrato/anular/'.$this->codigoContrato.'/'.$this->idTienda.'/'.Auth::id();
        $result=$this->NotificarJefes($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['ok_anular_contrato'].$this->errorSendeEmail;
        }
        return $msm;
    }

    public function AprobarSolicitud()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_anular_contrato']
        );
        $mensaje=Messages::$Notificacion['ok_anular_contrato_anulado'];
        $accion='contrato/anular/'.$this->codigoContrato.'/'.$this->idTienda;
        $result=$this->NotificarAuxiliar($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['ok_anular_contrato_anulado'].$this->errorSendeEmail;
        }
        return $msm;
    }

    public function RechazarSolicitud()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_anular_contrato']
        );
        $mensaje=Messages::$Notificacion['mensaje_solicitud_rechazada'];
        $accion='contrato/anular/'.$this->codigoContrato.'/'.$this->idTienda;
        $result=$this->NotificarAuxiliar($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['ok_anular_contrato_rechazado'].$this->errorSendeEmail;
        }
        return $msm;
    }
    
}
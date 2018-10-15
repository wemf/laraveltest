<?php
namespace App\BusinessLogic\Notificacion;
use Illuminate\Support\Facades\Auth;
use config\Messages;
use App\Mail\notificarUsuario as EmailNotificacion;
use Mail;
use App\Usuario;
use Exception;

class PagoNomina extends NotificacionBase
{   
    private $codigoCausacion;
    private $idTienda;
    private $idRemitente;
    private $errorSendeEmail;

    public function __construct($request)
    {
        $this->codigoCausacion=$request[0]['id_causacion'];
        $this->idTienda=$request[0]['id_tienda_causacion'];
        if(isset($request[0]['dirijido']))
        $this->dirijido=$request[0]['dirijido'];
        else
        $this->dirijido=0;
        if(isset($request[0]['idRemitente']))
        {
            $this->idRemitente=$request[0]['idRemitente'];
        }else{
            $this->idRemitente=0;
        }
    }

    private function sendEmail($mensajeEmail)
    {
        $result = true;
        try {
            Mail::to($mensajeEmail['email_receptor'])->send(new EmailNotificacion($mensajeEmail));
        } catch (Exception $e) {
            $this->errorSendeEmail='\nNo se envio email.';
            $result = false;
        }
        return $result;
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

    //Notifica los Tesoreros y Admins
    private function NotificarTesorerosyAdmin($mensaje,$accion)
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
        $tesorero=$this->GetTesorero();
        if(count($tesorero)>1){
            foreach ($tesorero as $key => $db) {
                $data['id_usuario_receptor']=$db->id;
                array_push($dataPost,$data);
            }
        }else{
            $data['id_usuario_receptor']=$tesorero[0]->id;
            $dataPost=$data;
        }
        $response=$this->SendMenssaje($dataPost);
        /*Enviar Email*/
        if($response)
        {
            $mensajeEmail=array(
                'emisor'=>Auth::user()->name,
                'receptor'=>$tesorero[0]->nombre,
                'email_receptor'=>$tesorero[0]->email,
                'texto'=>$mensaje
            );
            if(count($tesorero)>1){
                foreach ($tesorero as $key => $db) { 
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

    //Notifica los Tesoreros y Admins
    private function NotificarAdministradoresdeTienda($mensaje,$accion)
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
        $administrador=$this->GetAdministradordeTienda($this->idTienda);
        $response=false;
        if(!$administrador->isEmpty()){
            if(count($administrador)>1){
                foreach ($administrador as $key => $db) {
                    $data['id_usuario_receptor']=$db->id;
                    array_push($dataPost,$data);
                }
            }else{
                $data['id_usuario_receptor']=$administrador[0]->id;
                $dataPost=$data;
            }
            /*Enviar Email*/
            $response=$this->SendMenssaje($dataPost);
        }

        if($response)
        {
            $mensajeEmail=array(
                'emisor'=>Auth::user()->name,
                'receptor'=>$administrador[0]->nombre,
                'email_receptor'=>$administrador[0]->email,
                'texto'=>$mensaje
            );
            if(!$administrador->isEmpty()){
                if(count($administrador)>1){
                    foreach ($administrador as $key => $db) { 
                        $mensajeEmail['receptor']=$db->nombre;
                        $mensajeEmail['email_receptor']=$db->email;     
                        $this->sendEmail($mensajeEmail);             
                    }
                }else{
                    $this->sendEmail($mensajeEmail);
                }
            }
        }
        return $response;
    }

    public function CausacionPendiente()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_causacion_pentiende']
        );
        $mensaje=Messages::$Notificacion['mensaje_causacion_pendiente'];
        $accion='tesoreria/causacion/update/'.$this->codigoCausacion.'/'.$this->idTienda;
        $result=$this->NotificarTesorerosyAdmin($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['ok_causacion_pentiende'].$this->errorSendeEmail;;
        }
        return $msm;
    }

    public function SolicitarAnulacion()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_causacion_pentiende']
        );
        $mensaje=Messages::$Notificacion['mensaje_causacion_anular'];
        $accion='tesoreria/causacion/update/'.$this->codigoCausacion.'/'.$this->idTienda;

        if($this->dirijido == env('ROLE_SUPER_ADMIN'))
        $result=$this->NotificarTesorerosyAdmin($mensaje,$accion);
        else
        $result=$this->NotificarJefes($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['ok_causacion_pentiende'].$this->errorSendeEmail;;
        }
        return $msm;        
    }

    public function TransferenciaRealizada()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_causacion_pentiende']
        );
        $mensaje=Messages::$Notificacion['mensaje_transferencia'];
        $accion='tesoreria/causacion/update/'.$this->codigoCausacion.'/'.$this->idTienda;
        $result=$this->NotificarAdministradoresdeTienda($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['mensaje_transferencia'].$this->errorSendeEmail;;
        }
        return $msm;
    }

    public function AnulacionRealizada()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_causacion_pentiende']
        );
        $mensaje=Messages::$Notificacion['anulacion_realizada'];
        $accion='tesoreria/causacion/update/'.$this->codigoCausacion.'/'.$this->idTienda;
        $result=$this->NotificarAdministradoresdeTienda($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['anulacion_realizada'].$this->errorSendeEmail;;
        }
        return $msm;
    }
    
    
}
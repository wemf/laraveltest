<?php 

namespace App\BusinessLogic\Notificacion;
use Illuminate\Support\Facades\Auth;
use config\Messages;
use App\Mail\notificarUsuario as EmailNotificacion;
use Mail;
use App\Usuario;
use Exception;

class logistica extends NotificacionBase
{
    private $secuencia_guia;
    private $id_tienda;
    private $idRemitente;
    private $errorSendeEmail;

    public function __construct($secuencia_guia,$id_tienda,$idRemitente)
    {
        $this->secuencia_guia = $secuencia_guia;
        $this->id_tienda = $id_tienda;
        if(isset($idRemitente)){
            $this->idRemitente=$idRemitente;
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

    public function notificarAdminBodega($mensaje,$accion)
    {
        // dd("entro aqui"); 
        $data=array(
            'id_grupo_notificacion'=>uniqid(),
            'id_usuario_receptor'=>0,
            'id_usuario_emisor'=>Auth::id(),
            'id_tipo_notificacion'=>2,
            'estado_visto'=>0,
            'estado_notificacion'=>0,
            'fecha'=>date("Y-m-d"),
            'mensaje'=>$mensaje,
            'accion'=>$accion
        );
        $dataPost = array();
        $adminBodega = $this->GetAdminBodega($this->id_tienda);
        // dd($adminBodega);

        if(count($adminBodega) > 1)
        {
            foreach ($adminBodega as $key => $db) {
                $data['id_usuario_receptor']=$db->id;
                array_push($dataPost,$data);
            }
        }else{
            $data['id_usuario_receptor']=$adminBodega[0]->id;
            $dataPost=$data;
        }

        $response=$this->SendMenssaje($dataPost);
        // dd($response);
        if($response){
            $mensajeEmail=array(
                'emisor'=>Auth::user()->name,
                'receptor'=>$adminBodega[0]->nombre,
                'email_receptor'=>$adminBodega[0]->email,
                'texto'=>$mensaje
            );
            if(count($adminBodega)>1){
                foreach ($adminBodega as $key => $db) { 
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

    public function notificarAdminTienda($mensaje,$accion)
    {
        // dd("entro aqui"); 
        $data=array(
            'id_grupo_notificacion'=>uniqid(),
            'id_usuario_receptor'=>0,
            'id_usuario_emisor'=>Auth::id(),
            'id_tipo_notificacion'=>2,
            'estado_visto'=>0,
            'estado_notificacion'=>0,
            'fecha'=>date("Y-m-d"),
            'mensaje'=>$mensaje,
            'accion'=>$accion
        );
        $dataPost = array();
        $adminBodega = $this->GetAdminTienda($this->id_tienda);
        // dd($adminBodega);

        if(count($adminBodega) > 1)
        {
            foreach ($adminBodega as $key => $db) {
                $data['id_usuario_receptor']=$db->id;
                array_push($dataPost,$data);
            }
        }else{
            $data['id_usuario_receptor']=$adminBodega[0]->id;
            $dataPost=$data;
        }

        $response=$this->SendMenssaje($dataPost);
        // dd($response);
        if($response){
            $mensajeEmail=array(
                'emisor'=>Auth::user()->name,
                'receptor'=>$adminBodega[0]->nombre,
                'email_receptor'=>$adminBodega[0]->email,
                'texto'=>$mensaje
            );
            if(count($adminBodega)>1){
                foreach ($adminBodega as $key => $db) { 
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
}

?>
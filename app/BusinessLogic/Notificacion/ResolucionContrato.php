<?php
namespace App\BusinessLogic\Notificacion;
use Illuminate\Support\Facades\Auth;
use config\Messages;
use App\Mail\notificarUsuario as EmailNotificacion;
use Mail;
use App\Usuario;
use Exception;

class ResolucionContrato extends NotificacionBase
{   
    private $codigoContrato;
    private $codigosOrdenes;
    private $idTienda;
    private $idRemitente;
    private $errorSendeEmail;

    public function __construct($request)
    {
        $this->codigoContrato=$request->id;
        $this->codigosOrdenes=$request->id_ordenes;
        $this->idTienda=$request->id_tienda;
        if(isset($request->id_remitente)){
            $this->idRemitente=$request->id_remitente;
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
    private function NotificarAdmin($mensaje,$accion)
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
        $adminTienda=$this->GetAdministradorTienda($this->idTienda);
        if(count($adminTienda)>1){
            foreach ($adminTienda as $key => $db) {
                $data['id_usuario_receptor']=$db->id;
                array_push($dataPost,$data);
            }
        }else{
            $data['id_usuario_receptor']=$adminTienda[0]->id;
            $dataPost=$data;
        }
        $response=$this->SendMenssaje($dataPost);
        /*Enviar Email*/
        if($response){
            $mensajeEmail=array(
                'emisor'=>Auth::user()->name,
                'receptor'=>$adminTienda[0]->nombre,
                'email_receptor'=>$adminTienda[0]->email,
                'texto'=>$mensaje
            );
            if(count($adminTienda)>1){
                foreach ($adminTienda as $key => $db) { 
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

    public function SolicitarProcesarVitrina()
    {
        $msm=array(
            'val'=>false,
            'msm'=>'No se ha podido enviar la solicitud'
        );
        $mensaje='Solicitud de procesamiento de vitrina';
        $accion='contrato/vitrina/procesar/'.$this->idTienda.'/'.$this->codigosOrdenes;
        $result=$this->NotificarAdmin($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['ok_anular_contrato'].$this->errorSendeEmail;
        }
        return $msm;
    }
    
}
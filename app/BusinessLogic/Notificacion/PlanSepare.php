<?php
namespace App\BusinessLogic\Notificacion;
use Illuminate\Support\Facades\Auth;
use config\Messages;
use App\Mail\notificarUsuario as EmailNotificacion;
use Mail;
use App\Usuario;
use Exception;

class PlanSepare extends NotificacionBase
{
    private $codigo_plan;
    private $codigo_abono;
    private $idTienda;
    private $idRemitente;
    private $errorSendeEmail;

    public function __construct($request)
    {
        $this->codigo_plan=$request->codigo_plan;
        $this->codigo_abono=$request->codigo_abono;
        $this->idTienda=$request->id_tienda;
        if(isset($request->idRemitente)){
            $this->idRemitente=$request->idRemitente;
        }else{
            $this->idRemitente=0;
        }
    }

    private function sendEmail($mensajeEmail)
    {
        $result = true;
        try {
            Mail::to($mensajeEmail['email_receptor'])->send(new EmailNotificacion($mensajeEmail));
        } catch (Exception $e){
            $this->errorSendeEmail='\n No se envio email.';
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
            if(count($jefeZona) == 0){
                return false;
                throw new Exception('No se pudo enviar la notificación por que no hay jefe de zona asociados');
            }
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
            // dd($mensajeEmail);
            if(count($jefeZona)>1){
                foreach ($jefeZona as $key => $db){
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
            // dd($mensajeEmail);
            $this->sendEmail($mensajeEmail);
        }
        return $response;
    }
    /*Solicitud de reverso de abono*/
    public function SolicitarAbono()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_reverso_abono']
        );
        $mensaje=Messages::$Notificacion['mensaje_solicitud_abono_reversar'];
        $accion='generarplan/infoAbono/'.$this->idTienda.'/'.$this->codigo_plan.'/'.Auth::id();
        $result=$this->NotificarJefes($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['ok_reverso_abono'].$this->errorSendeEmail;
        }else{
            $msm['val']=false;
            $msm['msm']='No se pudo enviar la notificación por que no hay jefe de zona asociados';
        }
        return $msm;
    }
    /*Aprobar la solicitud de reverso de abono*/
    public function AprobarSolicitudAbono()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$GenerarPlan['rechazar_error']
        );
        $mensaje=Messages::$GenerarPlan['rechazar_error'];
        $accion='generarplan/infoAbono/'.$this->idTienda.'/'.$this->codigo_plan;
        $result=$this->NotificarAuxiliar($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$GenerarPlan['ok_reversar_abono'].$this->errorSendeEmail;;
        }
        return $msm;
    }
    /*Rechazar la solicitud de reverso de abono*/
    public function RechazarSolicitudAbono()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_reverso_abono']
        );
        $mensaje=Messages::$Notificacion['mensaje_solicitud_rechazada'];
        $accion='generarplan/infoAbono/'.$this->idTienda.'/'.$this->codigo_plan;
        $result=$this->NotificarAuxiliar($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['ok_reversar_abono_rechazado'].$this->errorSendeEmail;;
        }
        return $msm;
    }
    /*Solicitud de anulación del plan separe*/
    public function SolicitudAnular()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_anular_plan_separe']
        );
        $mensaje=Messages::$Notificacion['mensaje_solicitud_anular_plan_separe'];
        $accion='generarplan/infoAbono/'.$this->idTienda.'/'.$this->codigo_plan.'/'.Auth::id();
        $result=$this->NotificarJefes($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['mensaje_solicitud_anular_plan_separe'].$this->errorSendeEmail;;
        }
        return $msm;
    }
    /*Aprobar la solicitud de anulación del plan separe*/
    public function AprobarAnulacionPlan()
    {
        $msm=array(
            'val'=>false,
            'msm'=>Messages::$Notificacion['error_anular_plan_separe']
        );
        $mensaje=Messages::$Notificacion['ok_anular_plan_separe'];
        $accion='generarplan/infoAbono/'.$this->idTienda.'/'.$this->codigo_plan;
        $result=$this->NotificarAuxiliar($mensaje,$accion);
        if($result){
            $msm['val']=true;
            $msm['msm']=Messages::$Notificacion['ok_anular_plan_separe'].$this->errorSendeEmail;
        }
        return $msm;
    }   

    public function Cotizacion()
    {   
        $mensaje= 'Cotización de producto';
        $accion='cotizacion/update/'.$this->idTienda.'/'.$this->codigo_plan;
        $result=$this->NotificarJefes($mensaje,$accion);
        return $result;
    }

    public function CotizacionRes()
    {   
        $mensaje= 'Cotización de producto';
        $accion='cotizacion/update/'.$this->idTienda.'/'.$this->codigo_plan;
        $result=$this->NotificarAuxiliar($mensaje,$accion);
        return $result;
    }
}
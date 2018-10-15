<?php 

namespace App\BusinessLogic\Nutibara\Contratos;

use App\AccessObject\Nutibara\ConfigContrato\GeneralAccessObject;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use App\AccessObject\Nutibara\Parametros\Parametros;
use config\messages;

class AplazarContrato
{
    private $dataSaved = NULL;
    private $id_tienda = NULL;
    private $codigo = NULL;

    public function __construct($dataSaved,$codigo,$id_tienda)
    {
        $this->dataSaved = $dataSaved;
        $this->codigo = $codigo;
        $this->id_tienda = $id_tienda;
    }
    
    public function CrearAplazo ($dataSaved,$codigo,$id_tienda)
    {			
        if($this->CompararAnteriorFecha())
        {	 
            if($this->VerificarDiasAplazadosPorId())
            {
                if($this->CompararUltimaFecha())
                {
                    $msm=['msm'=>Messages::$aplazoContrato['ok'],'val'=>true];	
                    if(!Contrato::CrearAplazo($dataSaved))
                    {
                        $msm=['msm'=>Messages::$aplazoContrato['error'],'val'=>false];		
                    }	
                }
                else
                {
                    $msm=['msm'=>Messages::$aplazoContrato['date_error'],'val'=>false];		
                }
            }
            else
            {
                $msm=['msm'=>Messages::$aplazoContrato['error'],'val'=>false];	
            }
        }
        else
        {
            $msm=['msm'=>Messages::$aplazoContrato['date_before_error'],'val'=>false];		
        }
        return $msm;
    }

    private function VerificarDiasAplazadosPorId()
    {
        $fecha_terminacion = '';
        // $prorroga = getProrrogasById($this->codigo);
        // if(!is_null($prorroga))
        // {
        //     dd($prorroga);
        //     $fecha_terminacion = $contrato->fecha_terminacion;
        // }
        // else
        // {
        //     $contrato = Contrato::getContratoById($this->codigo,$this->id_tienda);
        //     $fecha_terminacion = $contrato->fecha_terminacion;
        //     dd($fecha_terminacion);
        // }
        $contrato = Contrato::getContratoById($this->codigo,$this->id_tienda);
        $fecha_terminacion = $contrato->fecha_terminacion;
        // dd($fecha_terminacion);
        $parametros = Contrato::getMaxAplazos($this->codigo,$this->id_tienda);
        $cantidadDias = $parametros->cantidad_aplazos_contrato;
        $nuevafecha = strtotime ( '+'.$cantidadDias.' day' , strtotime ( $fecha_terminacion ) ) ;
        $fechaMaxima = date ( 'Y-m-j' , $nuevafecha );
        if($fechaMaxima > $this->dataSaved['fecha_aplazo'])
            return true;
        else    
            return false;
    }

    private function CompararUltimaFecha()
    {
        $fecha_aplazo = Contrato::getUltimoPlazo($this->codigo,$this->id_tienda);
        if(!isset($fecha_aplazo->fecha_aplazo))
        {
            return true;
        }
        else
        {
            if($this->dataSaved['fecha_aplazo'] > $fecha_aplazo->fecha_aplazo)
                return true;
            else    
                return false;
        }
    }

    private function CompararAnteriorFecha()
    {
        $contrato = Contrato::getContratoById($this->codigo,$this->id_tienda);
        if($this->dataSaved['fecha_aplazo'] > $contrato->fecha_creacion)
            return true;
        else    
            return false;
    }


    public function getContratoById()
    {
        return Contrato::getContratoById($this->codigo,$this->id_tienda);
    }

    public function getAplazosById()
    {
        return Contrato::getAplazosById($this->codigo);
    }
    
     public function getItemsContratoById()
    {
        return Contrato::getItemsContratoById($this->codigo,$this->id_tienda);
    }

}    

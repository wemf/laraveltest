<?php 

namespace App\BusinessLogic\Nutibara\Contratos;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use App\AccessObject\Nutibara\Parametros\Parametros;
use config\messages;

class RetroventaContrato
{
    private $parametroGeneral;
    private $data = NULL;
    private $dataSaved = NULL;
    private $id_tienda = NULL;
    private $codigo = NULL;

    public function __construct($data,$dataSaved,$codigo,$id_tienda)
    {
        $this->data = $data;
        $this->dataSaved = $dataSaved;
        $this->codigo = $codigo;
        $this->id_tienda = $id_tienda;
    }
    
    public function CrearRetroventa ($dataSaved,$codigo,$id_tienda)
    {
        $msm=['msm'=>Messages::$prorrogaContrato['ok'],'val'=>true];	
        if(!Contrato::CrearProrroga($dataSaved))
        {
            $msm=['msm'=>Messages::$prorrogaContrato['error'],'val'=>false];		
        }
        return $msm;
    }

    private function ContarRetroventasPorId()
    {
        $contrato = Contrato::getContratoById($this->codigo,$this->id_tienda);
        $fechaActual = $contrato->fecha_terminacion;
        $parametros = Parametros::getParametrosById(1);
        $cantidadDias = $parametros->cantidad_prorrogas_contrato;
        $nuevafecha = strtotime ( '+'.$cantidadDias.' day' , strtotime ( $fechaActual ) ) ;
        $fechaMaxima = date ( 'Y-m-j' , $nuevafecha );
        if($fechaMaxima > $this->dataSaved['fecha_prorroga'])
            return true;
        else    
            return false;
    }

    public function getContratoById()
    {
        return Contrato::getContratoById($this->codigo,$this->id_tienda);
    }

    public function getRetroventasById()
    {
        return Contrato::getRetroventasById($this->codigo);
    }
    
     public function getItemsContratoById()
    {
        return Contrato::getItemsContratoById($this->codigo,$this->id_tienda);
    }

}    

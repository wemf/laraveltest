<?php 

namespace App\BusinessLogic\Nutibara\Contratos;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use App\AccessObject\Nutibara\Parametros\Parametros;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use config\messages;

class ProrrogarContrato
{
    private $parametroGeneral;
    private $fecha_terminacion_cabecera = NULL;
    private $dataSaved = NULL;
    private $id_tienda = NULL;
    private $codigo = NULL;
    private $meses_prorroga = NULL;
    private $nuevo_valor_abonado = NULL;

    public function __construct($fecha_terminacion_cabecera,$dataSaved,$codigo,$id_tienda, $meses_prorroga, $nuevo_valor_abonado)
    {
        $this->fecha_terminacion_cabecera = $fecha_terminacion_cabecera;
        $this->dataSaved = $dataSaved;
        $this->codigo = $codigo;
        $this->id_tienda = $id_tienda;
        $this->meses_prorroga = $meses_prorroga;
        $this->nuevo_valor_abonado = $nuevo_valor_abonado;
    }

    public function getFechaProrroga(){
        $valor_abonado = Contrato::getAbonoProrroga($this->codigo, $this->id_tienda);
        if(isset($valor_abonado[0]->valor)){
            $action = "update";
        }
        else{
            $action = "insert";
        }
        
        if($action == "insert"){
            Contrato::createAbonoProrroga($this->codigo, $this->id_tienda, $this->nuevo_valor_abonado);
        }else{
            Contrato::updateAbonoProrroga($this->codigo, $this->id_tienda, $this->nuevo_valor_abonado);
        }

        $fecha_prorroga = Contrato::getFechaProrroga($this->codigo, $this->id_tienda);
        if($fecha_prorroga == null)
            $fecha_prorroga_ex = $this->fecha_terminacion_cabecera;
        else
            $fecha_prorroga_ex = $fecha_prorroga->fecha_terminacion;
        
        $array_fecha_prorroga = explode("-", $fecha_prorroga_ex);

        while($this->meses_prorroga > 12){
            $array_fecha_prorroga[0]++;
            $this->meses_prorroga -= 12;
        }
        
        if(($array_fecha_prorroga[1] + $this->meses_prorroga) > 12){
            $array_fecha_prorroga[1] = $this->meses_prorroga - (12 - $array_fecha_prorroga[1]);
            $array_fecha_prorroga[0]++;
        }else{
            $array_fecha_prorroga[1] += $this->meses_prorroga;
        }
        $fecha_prorroga_ok = $array_fecha_prorroga[0]."-".$array_fecha_prorroga[1]."-".$array_fecha_prorroga[2];
        return ($fecha_prorroga_ok);
    }
    
    public function CrearProrroga ($dataSaved,$codigo,$id_tienda)
    {
        $msm=['msm'=>Messages::$prorrogaContrato['ok'],'val'=>true];	
        if(!Contrato::CrearProrroga($dataSaved))
        {
            $msm=['msm'=>Messages::$prorrogaContrato['error'],'val'=>false];		
        }
        else 
        {
            //(Valor, Tienda, id_movimientocontable (1 PRORROGA.) )
            // $referencia = 'PRORRCONTR'.$dataSaved['codigo_contrato'].'/'.$dataSaved['id_tienda_contrato'];
            // MovimientosTesoreria::registrarMovimientos($dataSaved['valor_ingresado'],$id_tienda,1,NULL,$referencia);
        }

        return $msm;
    }

    private function ContarProrrogadosPorId()
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

    private function CompararUltimaFecha()
    {
        $fechaActual = Contrato::getUltimoPlazo($this->codigo,$this->id_tienda);
        if(!isset($fechaActual->fecha_prorroga))
        {
            $contrato = Contrato::getContratoById($this->codigo,$this->id_tienda);
            $fechaActual = $contrato->fecha_terminacion;
        }
        
        if($fechaActual->fecha_prorroga < $this->dataSaved['fecha_prorroga'])
            return true;
        else    
            return false;
    }


    public function getContratoById()
    {
        return Contrato::getContratoById($this->codigo,$this->id_tienda);
    }

    public function getProrrogasById()
    {
        return Contrato::getProrrogasById($this->codigo);
    }
    
     public function getItemsContratoById()
    {
        return Contrato::getItemsContratoById($this->codigo,$this->id_tienda);
    }

}    

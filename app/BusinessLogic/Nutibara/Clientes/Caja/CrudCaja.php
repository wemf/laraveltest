<?php 

namespace App\BusinessLogic\Nutibara\Clientes\Caja;
use App\AccessObject\Nutibara\Clientes\Caja\Caja;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudCaja {

    public static function Create ($dataSaved)
    {				
		$respuesta = Caja::Create($dataSaved);
		if($respuesta=='Error')
        { 
			$msm=['msm'=>Messages::$Caja['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Caja['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Caja ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Caja::Caja($start,$end,$colum, $order);
		}else
        {
			$result = Caja::CajaWhere($start,$end,$colum, $order,$search);
		}
		
		return $result;
	}

	public static function getCaja()
    {
		$msm = Caja::getCaja();
		return $msm;
	}

	public static function getCountCaja($search)
	{
		return (int)Caja::getCountCaja($search);
	}

	public static function getCajaById($id)
	{
		return Caja::getCajaById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Caja::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Caja['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Caja['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Caja['delete_ok'],'val'=>true];
		if(!Caja::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Caja['error_delete'],'val'=>false];		
		}	
		return $msm;
	}
	
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Caja['active_ok'],'val'=>true];
		if(!Caja::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Caja['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Caja::getSelectList();
	}

}
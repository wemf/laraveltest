<?php 

namespace App\BusinessLogic\Nutibara\Clientes\DenominacionMoneda;
use App\AccessObject\Nutibara\Clientes\DenominacionMoneda\DenominacionMoneda;
use config\messages;


class CrudDenominacionMoneda {

    public static function Create ($dataSaved)
    {				
		$respuesta = DenominacionMoneda::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$DenominacionMoneda['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$DenominacionMoneda['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function DenominacionMoneda ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = DenominacionMoneda::DenominacionMoneda($start,$end,$colum, $order);
		}else
        {
			$result = DenominacionMoneda::DenominacionMonedaWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getDenominacionMoneda()
    {
		$msm = DenominacionMoneda::getDenominacionMoneda();
		return $msm;
	}

	public static function getCountDenominacionMoneda($search)
	{
		return (int)DenominacionMoneda::getCountDenominacionMoneda($search);
	}

	public static function getDenominacionMonedaById($id)
	{
		return DenominacionMoneda::getDenominacionMonedaById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = DenominacionMoneda::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$DenominacionMoneda['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$DenominacionMoneda['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$DenominacionMoneda['delete_ok'],'val'=>true];
		if(!DenominacionMoneda::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$DenominacionMoneda['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$DenominacionMoneda['active_ok'],'val'=>true];
		if(!DenominacionMoneda::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$DenominacionMoneda['active_error'],'val'=>false];		
		}	
		return $msm;
	}
}
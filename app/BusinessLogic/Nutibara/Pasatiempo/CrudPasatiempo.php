<?php 

namespace App\BusinessLogic\Nutibara\Pasatiempo;
use App\AccessObject\Nutibara\Pasatiempo\Pasatiempo;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudPasatiempo {

    public static function Create ($dataSaved)
    {				
		$respuesta = Pasatiempo::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Pasatiempo['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Pasatiempo['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Pasatiempo ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Pasatiempo::Pasatiempo($start,$end,$colum, $order);
		}else
        {
			$result = Pasatiempo::PasatiempoWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getPasatiempo()
    {
		$msm = Pasatiempo::getPasatiempo();
		return $msm;
	}

	public static function getCountPasatiempo($search)
	{
		return (int)Pasatiempo::getCountPasatiempo($search);
	}

	public static function getPasatiempoById($id)
	{
		return Pasatiempo::getPasatiempoById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Pasatiempo::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Pasatiempo['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Pasatiempo['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Pasatiempo['delete_ok'],'val'=>true];
		if(!Pasatiempo::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Pasatiempo['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Pasatiempo['active_ok'],'val'=>true];
		if(!Pasatiempo::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Pasatiempo['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Pasatiempo::getSelectList();
	}

	public static function getSelectListPasatiempo($id)
	{
		return Pasatiempo::getSelectListPasatiempo($id);
	}
}
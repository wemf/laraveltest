<?php 

namespace App\BusinessLogic\Nutibara\Sociedad;
use App\AccessObject\Nutibara\Sociedad\Sociedad;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudSociedad {

    public static function Create ($dataSaved)
    {				
		$respuesta = Sociedad::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Sociedad['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Sociedad['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Sociedad ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Sociedad::Sociedad($start,$end,$colum, $order);
		}else
        {
			$result = Sociedad::SociedadWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getSociedad()
    {
		$msm = Sociedad::getSociedad();
		return $msm;
	}

	public static function getCountSociedad($search)
	{
		return (int)Sociedad::getCountSociedad($search);
	}

	public static function getSociedadById($id)
	{
		return Sociedad::getSociedadById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Sociedad::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Sociedad['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Sociedad['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Sociedad['delete_ok'],'val'=>true];
		if(!Sociedad::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Sociedad['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Sociedad['active_ok'],'val'=>true];
		if(!Sociedad::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Sociedad['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Sociedad::getSelectList();
	}

	public static function getSelectListRegimen()
	{
		return Sociedad::getSelectListRegimen();
	}

	public static function getSelectListSociedadesPais($id)
	{
		return Sociedad::getSelectListSociedadesPais($id);
	}

	public static function getSelectSociedadByTienda($id)
	{
		return Sociedad::getSelectSociedadByTienda($id);
	}
	
}
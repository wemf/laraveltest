<?php 

namespace App\BusinessLogic\Nutibara\Pais;
use App\AccessObject\Nutibara\Pais\Pais;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudPais {

    public static function Create ($dataSaved)
    {				
		$respuesta = Pais::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Pais['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Pais['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Pais ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Pais::Pais($start,$end,$colum, $order);
		}else
        {
			$result = Pais::PaisWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getPais()
    {
		$msm = Pais::getPais();
		return $msm;
	}

	public static function getCountPais($start,$end,$colum, $order,$search)
	{
		return (int)Pais::getCountPais($start,$end,$colum, $order,$search);
	}

	public static function getPaisById($id)
	{
		return Pais::getPaisById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Pais::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Pais['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Pais['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Pais['delete_ok'],'val'=>true];
		if(!Pais::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Pais['error_delete'],'val'=>false];		
		}	
		return $msm;
	}
	
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Pais['active_ok'],'val'=>true];
		if(!Pais::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Pais['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Pais::getSelectList();
	}

	public static function getSelectListPaisSociedad($id)
	{
		return Pais::getSelectListPaisSociedad($id);
	}

	public static function getSelectListPais($id)
	{
		return Pais::getSelectListPais($id);
	}

	public static function getSelectListPaisByName($nombre)
	{
		return Pais::getSelectListPaisByName($nombre);
	}

	public static function getInputIndicativo($id)
	{
		return Pais::getInputIndicativo($id);
	}
}
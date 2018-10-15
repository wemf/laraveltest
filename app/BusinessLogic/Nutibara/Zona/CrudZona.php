<?php 

namespace App\BusinessLogic\Nutibara\Zona;
use App\AccessObject\Nutibara\Zona\Zona;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudZona {

    public static function Create ($dataSaved)
    {				
		$respuesta = Zona::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Zona['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Zona['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Zona ($start,$end,$colum, $order,$search)
    {
		
		if($search['estado']=="")
        {
			$result = Zona::Zona($start,$end,$colum, $order);
		}else
        {
			$result = Zona::ZonaWhere($start,$end,$colum, $order,$search);
		}
		
		return $result;
	}

	public static function getZonaByPais($id)
    {
		$msm = Zona::getZonaByPais($id);
		return $msm;
	}

	public static function getCountZona($search)
	{
		return (int)Zona::getCountZona($search);
	}

	public static function getZonaById($id)
	{
		return Zona::getZonaById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Zona::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Zona['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Zona['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Zona['delete_ok'],'val'=>true];
		if(!Zona::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Zona['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Zona['active_ok'],'val'=>true];
		if(!Zona::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Zona['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Zona::getSelectList();
	}

	public static function getSelectListZonaPais($id)
	{
		return Zona::getSelectListZonaPais($id);
	}

	public static function getSelectListByPaisParameter()
	{
		return Zona::getSelectListByPaisParameter();
	}

	public static function getSelectListZonaTienda($id)
	{
		return Zona::getSelectListZonaTienda($id);
	}
}
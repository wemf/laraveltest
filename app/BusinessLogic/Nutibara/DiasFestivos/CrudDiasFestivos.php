<?php 

namespace App\BusinessLogic\Nutibara\DiasFestivos;
use App\AccessObject\Nutibara\DiasFestivos\DiasFestivos;
use config\messages;


class CrudDiasFestivos {

    public static function Create ($dataSaved)
    {				
		$respuesta = DiasFestivos::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$DiasFestivos['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$DiasFestivos['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function DiasFestivos ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = DiasFestivos::DiasFestivos($start,$end,$colum, $order);
		}else
        {
			$result = DiasFestivos::DiasFestivosWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getDiasFestivos()
    {
		$msm = DiasFestivos::getDiasFestivos();
		return $msm;
	}

	public static function getCountDiasFestivos($search)
	{
		return (int)DiasFestivos::getCountDiasFestivos($search);
	}

	public static function getDiasFestivosById($id)
	{
		return DiasFestivos::getDiasFestivosById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = DiasFestivos::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$DiasFestivos['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$DiasFestivos['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function getPaisById($id)
	{
		$datos = DiasFestivos::getPaisById($id);
		return $datos;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$DiasFestivos['delete_ok'],'val'=>true];
		if(!DiasFestivos::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$DiasFestivos['error_delete'],'val'=>false];		
		}	
		return $msm;
	}
	
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$DiasFestivos['active_ok'],'val'=>true];
		if(!DiasFestivos::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$DiasFestivos['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return DiasFestivos::getSelectList();
	}

	public static function getSelectListDiasFestivosSociedad($id)
	{
		return DiasFestivos::getSelectListDiasFestivosSociedad($id);
	}

	public static function getSelectListDiasFestivos($id)
	{
		return DiasFestivos::getSelectListDiasFestivos($id);
	}

	public static function getSelectListDiasFestivosByName($nombre)
	{
		return DiasFestivos::getSelectListDiasFestivosByName($nombre);
	}

	public static function getInputIndicativo($id)
	{
		return DiasFestivos::getInputIndicativo($id);
	}
}
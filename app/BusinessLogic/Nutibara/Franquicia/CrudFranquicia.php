<?php 

namespace App\BusinessLogic\Nutibara\Franquicia;
use App\AccessObject\Nutibara\Franquicia\Franquicia;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudFranquicia {

    public static function Create ($dataSaved)
    {				

		$respuesta = Franquicia::Create($dataSaved,$asociaciones);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Franquicia['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Franquicia['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function CreateAsociacion($dataSaved,$asociaciones)
	{
		$respuesta = Franquicia::CreateAsociacion($dataSaved,$asociaciones);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Franquicia['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Franquicia['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}
	public static function UpdateAsociacion($id_franquicia,$dataSaved,$asociaciones)
	{	
		$respuesta = Franquicia::UpdateAsociacion($id_franquicia,$dataSaved,$asociaciones);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Franquicia['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Franquicia['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Franquicia ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Franquicia::Franquicia($start,$end,$colum, $order);
		}else
        {
			$result = Franquicia::FranquiciaWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getFranquicia()
    {
		$msm = Franquicia::getFranquicia();
		return $msm;
	}

	public static function getCountFranquicia($search)
	{
		return (int)Franquicia::getCountFranquicia($search);
	}

	public static function getFranquiciaById($id)
	{
		return Franquicia::getFranquiciaById($id);
	}

	public static function getFranquiciaByIdUpdate($id)
	{
		return Franquicia::getFranquiciaByIdUpdate($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Franquicia::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Franquicia['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Franquicia['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Franquicia['delete_ok'],'val'=>true];
		if(!Franquicia::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Franquicia['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function SociedadesDeFranquicia($id_franquicia)
    {
		$result = Franquicia::SociedadesDeFranquicia($id_franquicia);
		return $result;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Franquicia['active_ok'],'val'=>true];
		if(!Franquicia::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Franquicia['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Franquicia::getSelectList();
	}

	public static function getSelectListFranquiciaPais($id)
	{
		return Franquicia::getSelectListFranquiciaPais($id);
	}
}
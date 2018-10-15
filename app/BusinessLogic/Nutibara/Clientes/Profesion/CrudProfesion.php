<?php 

namespace App\BusinessLogic\Nutibara\Clientes\Profesion;
use App\AccessObject\Nutibara\Clientes\Profesion\Profesion;
use config\messages;


class CrudProfesion {

    public static function Create ($dataSaved)
    {				
		$respuesta = Profesion::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Profesion['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Profesion['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Profesion ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Profesion::Profesion($start,$end,$colum, $order);
		}else
        {
			$result = Profesion::ProfesionWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getProfesion()
    {
		$msm = Profesion::getProfesion();
		return $msm;
	}

	public static function getCountProfesion($search)
	{
		return (int)Profesion::getCountProfesion($search);
	}

	public static function getProfesionById($id)
	{
		return Profesion::getProfesionById($id);
	}

	public static function Update($id,$dataSaved)
    {

		$respuesta = Profesion::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Profesion['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Profesion['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Profesion['delete_ok'],'val'=>true];
		if(!Profesion::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Profesion['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Profesion['active_ok'],'val'=>true];
		if(!Profesion::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Profesion['active_error'],'val'=>false];		
		}	
		return $msm;
	}
}
<?php 

namespace App\BusinessLogic\Nutibara\Calificacion;
use App\AccessObject\Nutibara\Calificacion\Calificacion;
use config\messages;


class CrudCalificacion {

    public static function Create ($dataSaved)
    {				
		$respuesta = Calificacion::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Calific['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Calific['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Calificacion ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Calificacion::Calificacion($start,$end,$colum, $order);
		}else
        {
			$result = Calificacion::CalificacionWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getCalificacion()
    {
		$msm = Calificacion::getCalificacion();
		return $msm;
	}

	public static function getCountCalificacion($search)
	{
		return (int)Calificacion::getCountCalificacion($search);
	}

	public static function getCalificacionById($id)
	{
		return Calificacion::getCalificacionById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Calificacion::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Calific['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Calific['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}
	

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Calific['delete_ok'],'val'=>true];
		if(!Calificacion::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Calific['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Calific['active_ok'],'val'=>true];
		if(!Calificacion::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Calific['active_error'],'val'=>false];		
		}	
		return $msm;
	}
}
<?php 

namespace App\BusinessLogic\Nutibara\Clientes\AreaTrabajo;
use App\AccessObject\Nutibara\Clientes\AreaTrabajo\AreaTrabajo;
use config\messages;


class CrudAreaTrabajo {

    public static function Create ($dataSaved)
    {				
		$respuesta = AreaTrabajo::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Area['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Area['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function AreaTrabajo ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = AreaTrabajo::AreaTrabajo($start,$end,$colum, $order);
		}else
        {
			$result = AreaTrabajo::AreaTrabajoWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getAreaTrabajo()
    {
		$msm = AreaTrabajo::getAreaTrabajo();
		return $msm;
	}

	public static function getCountAreaTrabajo($search)
	{
		return (int)AreaTrabajo::getCountAreaTrabajo($search);
	}

	public static function getAreaTrabajoById($id)
	{
		return AreaTrabajo::getAreaTrabajoById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = AreaTrabajo::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Area['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Area['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Area['delete_ok'],'val'=>true];
		if(!AreaTrabajo::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Area['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Area['active_ok'],'val'=>true];
		if(!AreaTrabajo::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Area['active_error'],'val'=>false];		
		}	
		return $msm;
	}
}
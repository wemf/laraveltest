<?php 

namespace App\BusinessLogic\Nutibara\Clientes\TipoTrabajo;
use App\AccessObject\Nutibara\Clientes\TipoTrabajo\TipoTrabajo;
use config\messages;


class CrudTipoTrabajo {

    public static function Create ($dataSaved)
    {				

		$respuesta = TipoTrabajo::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$TipoTrabajo['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$TipoTrabajo['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function TipoTrabajo ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = TipoTrabajo::TipoTrabajo($start,$end,$colum, $order);
		}else
        {
			$result = TipoTrabajo::TipoTrabajoWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getTipoTrabajo()
    {
		$msm = TipoTrabajo::getTipoTrabajo();
		return $msm;
	}

	public static function getCountTipoTrabajo()
	{
		return (int)TipoTrabajo::getCountTipoTrabajo();
	}

	public static function getTipoTrabajoById($id)
	{
		return TipoTrabajo::getTipoTrabajoById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = TipoTrabajo::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$TipoTrabajo['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$TipoTrabajo['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$TipoTrabajo['delete_ok'],'val'=>true];
		if(!TipoTrabajo::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$TipoTrabajo['delete_error'],'val'=>false];		
		}	
		return $msm;
	}
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$TipoTrabajo['active_ok'],'val'=>true];
		if(!TipoTrabajo::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$TipoTrabajo['active_error'],'val'=>false];		
		}	
		return $msm;
	}
}
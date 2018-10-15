<?php 

namespace App\BusinessLogic\Nutibara\Clientes\Confiabilidad;
use App\AccessObject\Nutibara\Clientes\Confiabilidad\Confiabilidad;
use config\messages;


class CrudConfiabilidad {

    public static function Create ($dataSaved)
    {				
		$msm=['msm'=>Messages::$Confiabilidad['ok'],'val'=>true];	
		if(!Confiabilidad::Create($dataSaved))
        {
			$msm=['msm'=>Messages::$Confiabilidad['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Confiabilidad ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Confiabilidad::Confiabilidad($start,$end,$colum, $order);
		}else
        {
			$result = Confiabilidad::ConfiabilidadWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getConfiabilidad()
    {
		$msm = Confiabilidad::getConfiabilidad();
		return $msm;
	}

	public static function getCountConfiabilidad($search)
	{
		return (int)Confiabilidad::getCountConfiabilidad($search);
	}

	public static function getConfiabilidadById($id)
	{
		return Confiabilidad::getConfiabilidadById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$Confiabilidad['update_ok'],'val'=>true];
		if(!Confiabilidad::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Confiabilidad['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Confiabilidad['delete_ok'],'val'=>true];
		if(!Confiabilidad::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Confiabilidad['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Confiabilidad['active_ok'],'val'=>true];
		if(!Confiabilidad::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Confiabilidad['active_error'],'val'=>false];		
		}	
		return $msm;
	}
}
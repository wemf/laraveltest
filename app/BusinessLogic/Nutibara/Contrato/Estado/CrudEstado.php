<?php 

namespace app\BusinessLogic\Nutibara\Contrato\Estado;
use App\AccessObject\Nutibara\Contrato\Estado\Estado;
use config\messages;

class CrudEstado {

    public static function Create ($dataSaved)
    {				
		$msm=['msm'=>Messages::$Estado['ok'],'val'=>true];	
		if(!Estado::Create($dataSaved))
        {
			$msm=['msm'=>Messages::$Estado['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Estado ($start,$end,$colum, $order,$search)
    {
		if(empty($search))
        {
			$result = Estado::Estado($start,$end,$colum, $order);
		}else
        {
			$result = Estado::EstadoWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getEstado()
    {
		$msm = Estado::getEstado();
		return $msm;
	}

	public static function getCountEstado()
	{
		return (int)Estado::getCountEstado();
	}

	public static function getEstadoById($id)
	{
		return Estado::getEstadoById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$Estado['update_ok'],'val'=>true];
		if(!Estado::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Estado['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Estado['delete_ok'],'val'=>true];
		if(!Estado::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Estado['delete_error'],'val'=>false];		
		}	
		return $msm;
	}
}
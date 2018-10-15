<?php 

namespace App\BusinessLogic\Nutibara\Clientes\FondoCesantias;
use App\AccessObject\Nutibara\Clientes\FondoCesantias\FondoCesantias;
use config\messages;


class CrudFondoCesantias {

    public static function Create ($dataSaved)
    {				
		$msm=['msm'=>Messages::$FondoCesantias['ok'],'val'=>true];	
		if(!FondoCesantias::Create($dataSaved))
        {
			$msm=['msm'=>Messages::$FondoCesantias['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function FondoCesantias ($start,$end,$colum, $order,$search)
    {
		if(empty($search))
        {
			$result = FondoCesantias::FondoCesantias($start,$end,$colum, $order);
		}else
        {
			$result = FondoCesantias::FondoCesantiasWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getFondoCesantias()
    {
		$msm = FondoCesantias::getFondoCesantias();
		return $msm;
	}

	public static function getCountFondoCesantias()
	{
		return (int)FondoCesantias::getCountFondoCesantias();
	}

	public static function getFondoCesantiasById($id)
	{
		return FondoCesantias::getFondoCesantiasById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$FondoCesantias['update_ok'],'val'=>true];
		if(!FondoCesantias::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$FondoCesantias['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$FondoCesantias['delete_ok'],'val'=>true];
		if(!FondoCesantias::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$FondoCesantias['delete_error'],'val'=>false];		
		}	
		return $msm;
	}
}
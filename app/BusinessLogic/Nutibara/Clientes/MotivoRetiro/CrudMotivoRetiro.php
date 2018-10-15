<?php 

namespace App\BusinessLogic\Nutibara\Clientes\MotivoRetiro;
use App\AccessObject\Nutibara\Clientes\MotivoRetiro\MotivoRetiro;
use config\messages;


class CrudMotivoRetiro {

    public static function Create ($dataSaved)
    {				
		$respuesta = MotivoRetiro::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$MotivoRetiro['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$MotivoRetiro['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function MotivoRetiro ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = MotivoRetiro::MotivoRetiro($start,$end,$colum, $order);
		}else
        {
			$result = MotivoRetiro::MotivoRetiroWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getMotivoRetiro()
    {
		$msm = MotivoRetiro::getMotivoRetiro();
		return $msm;
	}

	public static function getCountMotivoRetiro($search)
	{
		return (int)MotivoRetiro::getCountMotivoRetiro($search);
	}

	public static function getMotivoRetiroById($id)
	{
		return MotivoRetiro::getMotivoRetiroById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = MotivoRetiro::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$MotivoRetiro['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$MotivoRetiro['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$MotivoRetiro['delete_ok'],'val'=>true];
		if(!MotivoRetiro::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$MotivoRetiro['delete_error'],'val'=>false];		
		}	
		return $msm;
	}
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$MotivoRetiro['active_ok'],'val'=>true];
		if(!MotivoRetiro::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$MotivoRetiro['active_error'],'val'=>false];		
		}	
		return $msm;
	}
}
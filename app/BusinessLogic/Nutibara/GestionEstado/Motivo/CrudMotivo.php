<?php 

namespace App\BusinessLogic\Nutibara\GestionEstado\Motivo;
use App\AccessObject\Nutibara\GestionEstado\Motivo\Motivo;
use config\messages;


class CrudMotivo {

    public static function Create ($dataSaved)
    {				
		$respuesta = Motivo::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Motivo['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Motivo['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}
	

	public static function Motivo ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Motivo::Motivo($start,$end,$colum, $order);
		}else
        {
			$result = Motivo::MotivoWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getMotivo()
    {
		$msm = Motivo::getMotivo();
		return $msm;
	}

	public static function getCountMotivo($search)
	{
		return (int)Motivo::getCountMotivo($search);
	}

	public static function getMotivoById($id)
	{
		return Motivo::getMotivoById($id);
	}

	public static function getMotivoByEstado($id_estado)
	{
		return Motivo::getMotivoByEstado($id_estado);
	}
	
	public static function Update($id,$dataSaved)
    {

		$respuesta = Motivo::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Motivo['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Motivo['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function getSelectList()
	{
		return Motivo::getSelectList();
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Motivo['delete_ok'],'val'=>true];
		if(!Motivo::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Motivo['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Motivo['active_ok'],'val'=>true];
		if(!Motivo::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Motivo['active_error'],'val'=>false];		
		}	
		return $msm;
	}
}
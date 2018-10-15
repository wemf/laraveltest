<?php 

namespace App\BusinessLogic\Nutibara\GestionTesoreria\Impuesto;
use App\AccessObject\Nutibara\GestionTesoreria\Impuesto\Impuesto;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;


class CrudImpuesto {
	
	public static function Impuesto ($start,$end,$colum, $order,$search)
    {
			$result = Impuesto::ImpuestoWhere($start,$end,$colum, $order,$search);
		return $result;
	}

    public static function Create ($dataSaved)
    {				
		$respuesta = Impuesto::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Impuesto['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Impuesto['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function getImpuestoById($id)
	{
		return Impuesto::getImpuestoById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Impuesto::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Impuesto['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Impuesto['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Impuesto['delete_ok'],'val'=>true];
		if(!Impuesto::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Impuesto['error_delete'],'val'=>false];		
		}	
		return $msm;
	}
	
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Impuesto['active_ok'],'val'=>true];
		if(!Impuesto::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Impuesto['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Impuesto::getSelectList();
	}

	public static function getCountImpuesto($search)
	{
		return (int)Impuesto::getCountImpuesto($search);
	}

	public static function getSelectListById($id)
	{
		return Impuesto::getSelectListById($id);
	}

}
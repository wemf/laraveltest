<?php 

namespace App\BusinessLogic\Nutibara\GestionTesoreria\TipoDocumentoContable;
use App\AccessObject\Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContable;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;


class CrudTipoDocumentoContable {
	
	public static function TipoDocumentoContable ($start,$end,$colum, $order,$search)
    {
		$result = TipoDocumentoContable::TipoDocumentoContableWhere($start,$end,$colum, $order,$search);
		return $result;
	}

    public static function Create ($dataSaved)
    {				
		$respuesta = TipoDocumentoContable::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$TipoDocumentoContable['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$TipoDocumentoContable['ok'],'val'=>'Insertado'];	
		}
		return $msm;
    }
    
    public static function getCountTipoDocumentoContable($search)
    {
        return (int)TipoDocumentoContable::getCountTipoDocumentoContable($search);
    }

	public static function getTipoDocumentoContableById($id)
	{
		return TipoDocumentoContable::getTipoDocumentoContableById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = TipoDocumentoContable::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$TipoDocumentoContable['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$TipoDocumentoContable['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Desactivate($id)
    {
		$dataSaved['estado'] = 0;
		$respuesta = TipoDocumentoContable::Update($id,$dataSaved);		
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$TipoDocumentoContable['desactivate_error'],'val'=>false];		
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$TipoDocumentoContable['desactivate_ok'],'val'=>true];	
		}
		return $msm;
	}
	
	public static function Active($id)
    {
		$dataSaved['estado'] = 1;
		$respuesta = TipoDocumentoContable::Update($id,$dataSaved);		
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$TipoDocumentoContable['desactivate_error'],'val'=>false];		
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$TipoDocumentoContable['desactivate_ok'],'val'=>true];	
		}
		return $msm;
	}

	public static function getSelectList()
	{
		return TipoDocumentoContable::getSelectList();
	}
}
<?php 

namespace App\BusinessLogic\Nutibara\Clientes\TipoDocumento;
use App\AccessObject\Nutibara\Clientes\TipoDocumento\TipoDocumento;
use config\messages;


class CrudTipoDocumento {

    public static function Create ($dataSaved)
    {				
		$respuesta = TipoDocumento::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$TipoDoc['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$TipoDoc['errorunique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$TipoDoc['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function TipoDocumento ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = TipoDocumento::TipoDocumento($start,$end,$colum, $order);
		}else
        {
			$result = TipoDocumento::TipoDocumentoWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getTipoDocumento()
    {
		$msm = TipoDocumento::getTipoDocumento();
		return $msm;
	}

	public static function getTipoDocumentoProveedor()
    {
		$msm = TipoDocumento::getTipoDocumentoProveedor();
		return $msm;
	}

	public static function getCountTipoDocumento($search)
	{
		return (int)TipoDocumento::getCountTipoDocumento($search);
	}

	public static function getTipoDocumentoById($id)
	{
		return TipoDocumento::getTipoDocumentoById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = TipoDocumento::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$TipoDoc['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$TipoDoc['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function getSelectList()
	{
		return TipoDocumento::getSelectList();
	}

	public static function getSelectList2()
	{
		return TipoDocumento::getSelectList2();
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$TipoDoc['delete_ok'],'val'=>true];
		if(!TipoDocumento::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$TipoDoc['delete_error'],'val'=>false];		
		}	
		return $msm;
	}
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$TipoDoc['active_ok'],'val'=>true];
		if(!TipoDocumento::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$TipoDoc['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getAlfanumerico($id)
	{
		return TipoDocumento::getAlfanumerico($id);
	}
}
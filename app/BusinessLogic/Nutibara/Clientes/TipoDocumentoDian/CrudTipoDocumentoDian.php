<?php 

namespace App\BusinessLogic\Nutibara\Clientes\TipoDocumentoDian;
use App\AccessObject\Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDian;
use config\messages;


class CrudTipoDocumentoDian {

    public static function Create ($dataSaved)
    {				
		$respuesta = TipoDocumentoDian::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$TipoDocumentoDian['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['errorunique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$TipoDocumentoDian['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function TipoDocumentoDian ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = TipoDocumentoDian::TipoDocumentoDian($start,$end,$colum, $order);
		}else
        {
			$result = TipoDocumentoDian::TipoDocumentoDianWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getTipoDocumentoDian()
    {
		$msm = TipoDocumentoDian::getTipoDocumentoDian();
		return $msm;
	}

	public static function getCountTipoDocumentoDian()
	{
		return (int)TipoDocumentoDian::getCountTipoDocumentoDian();
	}

	public static function getTipoDocumentoDianById($id)
	{
		return TipoDocumentoDian::getTipoDocumentoDianById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = TipoDocumentoDian::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$TipoDocumentoDian['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$TipoDocumentoDian['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$TipoDocumentoDian['delete_ok'],'val'=>true];
		if(!TipoDocumentoDian::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$TipoDocumentoDian['delete_error'],'val'=>false];		
		}	
		return $msm;
	}
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$TipoDocumentoDian['active_ok'],'val'=>true];
		if(!TipoDocumentoDian::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$TipoDocumentoDian['active_error'],'val'=>false];		
		}	
		return $msm;
	}}
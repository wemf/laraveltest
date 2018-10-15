<?php 

namespace App\BusinessLogic\Nutibara\Parametros;
use App\AccessObject\Nutibara\Parametros\Parametros;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudParametros {

    public static function Create ($dataSaved)
    {	
		$respuesta = Parametros::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Parametros['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$Parametros['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Parametros['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Parametros ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Parametros::Parametros($start,$end,$colum, $order);
		}else
        {
			$result = Parametros::ParametrosWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getParametros()
    {
		$msm = Parametros::getParametros();
		return $msm;
	}

	public static function getCountParametros()
	{
		return (int)Parametros::getCountParametros();
	}

	public static function getParametrosById($id)
	{
		return Parametros::getParametrosById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Parametros::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Parametros['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$Parametros['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Parametros['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Parametros['delete_ok'],'val'=>true];
		if(!Parametros::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Parametros['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Parametros::getSelectList();
	}

	public static function getSelectListLenguaje()
	{
		return Parametros::getSelectListLenguaje();
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Parametros['active_ok'],'val'=>true];
		if(!Parametros::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Parametros['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectListMoneda()
	{
		return Parametros::getSelectListMoneda();
	}

	public static function getSelectListMedidaPeso()
	{
		return Parametros::getSelectListMedidaPeso();
	}

	public static function getSelectPais()
	{
		return Parametros::getSelectPais();
	}

	public static function ValidateExist($request)
	{
		return Parametros::ValidateExist($request);
	}

	public static function getAbreviatura($id){
		return Parametros::getAbreviatura($id);	
	}
}
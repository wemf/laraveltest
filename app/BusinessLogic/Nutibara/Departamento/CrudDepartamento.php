<?php 

namespace App\BusinessLogic\Nutibara\Departamento;
use App\AccessObject\Nutibara\Departamento\Departamento;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;

class CrudDepartamento {

    public static function Create ($dataSaved)
    {				
		$respuesta = Departamento::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Departamento['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Departamento['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Departamento ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Departamento::Departamento($start,$end,$colum, $order);
		}else
        {
			$result = Departamento::DepartamentoWhere($start,$end,$colum, $order,$search);
		}
		//dd($colum);
		return $result;
	}

	public static function getDepartamentoByPais($id)
    {
		$msm = Departamento::getDepartamentoByPais($id);
		return $msm;
	}

	public static function getCountDepartamento($search)
	{
		return (int)Departamento::getCountDepartamento($search);
	}

	public static function getDepartamentoById($id)
	{
		return Departamento::getDepartamentoById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Departamento::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Departamento['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Departamento['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Departamento['delete_ok'],'val'=>true];
		if(!Departamento::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Departamento['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Departamento['active_ok'],'val'=>true];
		if(!Departamento::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Departamento['active_error'],'val'=>false];		
		}	
		return $msm;
	}
	

	public static function getSelectList()
	{
		return Departamento::getSelectList();
	}

	public static function getSelectListDepartamento($id)
	{
		return Departamento::getSelectListDepartamento($id);
	}
}
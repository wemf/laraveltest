<?php 

namespace App\BusinessLogic\Nutibara\GestionPlan;
use App\AccessObject\Nutibara\GestionPlan\GestionPlan;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudGestionPlan {

    public static function Create ($dataSaved)
    {				
		$respuesta = GestionPlan::Create($dataSaved);
		return $respuesta;
	}

	public static function GestionPlan ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = GestionPlan::GestionPlan($start,$end,$colum, $order);
		}else
        {
			$result = GestionPlan::GestionPlanWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getGestionPlan()
    {
		$msm = GestionPlan::getGestionPlan();
		return $msm;
	}

	public static function getCliente($iden)
	{
		$response = GestionPlan::getCliente($iden);
		return $response;
	}

	public static function getCountGestionPlan()
	{
		return (int)GestionPlan::getCountGestionPlan();
	}

	public static function getGestionPlanById($id)
	{
		return GestionPlan::getGestionPlanById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = GestionPlan::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$GestionPlan['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$GestionPlan['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$GestionPlan['delete_ok'],'val'=>true];
		if(!GestionPlan::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$GestionPlan['error_delete'],'val'=>false];		
		}	
		return $msm;
	}
	
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$GestionPlan['active_ok'],'val'=>true];
		if(!GestionPlan::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$GestionPlan['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return GestionPlan::getSelectList();
	}

	public static function getSelectListGestionPlan($id)
	{
		return GestionPlan::getSelectListGestionPlan($id);
	}
	
}
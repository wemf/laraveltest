<?php 

namespace App\BusinessLogic\Nutibara\Clientes\PlanUnicoCuenta;
use App\AccessObject\Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuenta;
use config\messages;


class CrudPlanUnicoCuenta {

    public static function Create ($dataSaved)
    {				
		$respuesta = PlanUnicoCuenta::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$PlanUnicoCuenta['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$PlanUnicoCuenta['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function PlanUnicoCuenta ($start,$end,$colum, $order,$search)
    {
		$result = PlanUnicoCuenta::PlanUnicoCuentaWhere($start,$end,$colum, $order,$search);
		return $result;
	}

	public static function PlanUnicoCuentaExcel ()
    {
		$result = PlanUnicoCuenta::PlanUnicoCuentaExcel();
		return $result;
	}

	public static function getPlanUnicoCuenta()
    {
		$msm = PlanUnicoCuenta::getPlanUnicoCuenta();
		return $msm;
	}

	public static function getCountPlanUnicoCuenta($search)
	{
		return (int)PlanUnicoCuenta::getCountPlanUnicoCuenta($search);
	}

	public static function getPlanUnicoCuentaById($id)
	{
		return PlanUnicoCuenta::getPlanUnicoCuentaById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = PlanUnicoCuenta::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$PlanUnicoCuenta['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$PlanUnicoCuenta['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$PlanUnicoCuenta['delete_ok'],'val'=>true];
		if(!PlanUnicoCuenta::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$PlanUnicoCuenta['delete_error'],'val'=>false];		
		}	
		return $msm;
	}
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$PlanUnicoCuenta['active_ok'],'val'=>true];
		if(!PlanUnicoCuenta::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$PlanUnicoCuenta['active_error'],'val'=>false];		
		}	
		return $msm;
	}
}
<?php 

namespace App\BusinessLogic\Nutibara\Clientes\CargoEmpleado;
use App\AccessObject\Nutibara\Clientes\CargoEmpleado\CargoEmpleado;
use config\messages;


class CrudCargoEmpleado {

    public static function Create ($dataSaved)
    {				

		$respuesta = CargoEmpleado::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$CargoEmpleado['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$CargoEmpleado['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function CargoEmpleado ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = CargoEmpleado::CargoEmpleado($start,$end,$colum, $order);
		}else
        {
			$result = CargoEmpleado::CargoEmpleadoWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getCargoEmpleado()
    {
		$msm = CargoEmpleado::getCargoEmpleado();
		return $msm;
	}

	public static function getCountCargoEmpleado($search)
	{
		return (int)CargoEmpleado::getCountCargoEmpleado($search);
	}

	public static function getCargoEmpleadoById($id)
	{
		return CargoEmpleado::getCargoEmpleadoById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = CargoEmpleado::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$CargoEmpleado['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$CargoEmpleado['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$CargoEmpleado['delete_ok'],'val'=>true];
		if(!CargoEmpleado::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$CargoEmpleado['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$CargoEmpleado['active_ok'],'val'=>true];
		if(!CargoEmpleado::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$CargoEmpleado['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return CargoEmpleado::getSelectList();
	}
}
<?php 

namespace App\BusinessLogic\Nutibara\Ciudad;
use App\AccessObject\Nutibara\Ciudad\Ciudad;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudCiudad {

    public static function Create ($dataSaved)
    {				
		$respuesta = Ciudad::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Ciudad['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Ciudad['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Ciudad ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Ciudad::Ciudad($start,$end,$colum, $order);
		}else
        {
			$result = Ciudad::CiudadWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getCiudadByDepartamento($id)
    {
		$msm = Ciudad::getCiudadByDepartamento($id);
		return $msm;
	}

	public static function getCiudadByPais($id)
    {
		$msm = Ciudad::getCiudadByPais($id);
		return $msm;
	}

	public static function getCountCiudad($search)
	{
		return (int)Ciudad::getCountCiudad($search);
	}

	public static function getCiudadById($id)
	{
		return Ciudad::getCiudadById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Ciudad::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Ciudad['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Ciudad['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Ciudad['delete_ok'],'val'=>true];
		if(!Ciudad::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Ciudad['error_delete'],'val'=>false];		
		}	
		return $msm;
	}
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Ciudad['active_ok'],'val'=>true];
		if(!Ciudad::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Ciudad['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Ciudad::getSelectList();
	}

	public static function getSelectListCiudadZona($id)
	{
		return Ciudad::getSelectListCiudadZona($id);
	}

	public static function getItemZonaCiudad($id)
	{
		return Ciudad::getItemZonaCiudad($id);
	}

	public static function getInputIndicativo($id)
	{
		return Ciudad::getInputIndicativo($id);
	}

	public static function getInputIndicativo2($id)
	{
		
		return Ciudad::getInputIndicativo2($id);
	}

	public static function getSelectListCiudadbyNombre($id_pais,$nombre){
		return Ciudad::getSelectListCiudadbyNombre($id_pais,$nombre);
	}
}
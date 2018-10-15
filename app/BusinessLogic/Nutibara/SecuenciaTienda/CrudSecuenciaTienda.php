<?php 

namespace App\BusinessLogic\Nutibara\SecuenciaTienda;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudSecuenciaTienda {

    public static function Create ($dataSaved)
    {				
		
		$msm=['msm'=>Messages::$SecuenciaTienda['ok'],'val'=>true];	
		if(!SecuenciaTienda::Create($dataSaved))
        {
			$msm=['msm'=>Messages::$SecuenciaTienda['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function SecuenciaTienda ($start,$end,$colum, $order,$search)
    {
		if(empty($search))
        {
			$result = SecuenciaTienda::SecuenciaTienda($start,$end,$colum, $order);
		}else
        {
			$result = SecuenciaTienda::SecuenciaTiendaWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getSecuenciaTienda()
    {
		$msm = SecuenciaTienda::getSecuenciaTienda();
		return $msm;
	}

	public static function getCountSecuenciaTienda($search)
	{
		$msm =  count(SecuenciaTienda::getCountSecuenciaTienda($search));
		return $msm;
	}

	public static function getSecuenciaTiendaById($id)
	{
		return SecuenciaTienda::getSecuenciaTiendaById($id);
	}

	public static function getTipoSecuencia()
	{
		return SecuenciaTienda::getTipoSecuencia();
	}
	public static function getTipoSecuenciaById($id)
	{
		return SecuenciaTienda::getTipoSecuenciaById($id);
	}

	public static function Update($id,$dataSaved)
    {	
		$msm=['msm'=>Messages::$SecuenciaTienda['update_ok'],'val'=>true];
		if(!SecuenciaTienda::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$SecuenciaTienda['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$SecuenciaTienda['delete_ok'],'val'=>true];
		if(!SecuenciaTienda::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$SecuenciaTienda['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getListSecInv($id,$id_tienda)
	{
		$msm = SecuenciaTienda::getListSecInv($id,$id_tienda);
		return $msm;
	}

	public static function createSecInv($id,$secuencia,$id_tienda)
	{	
		$respuesta = SecuenciaTienda::createSecInv($id,$secuencia,$id_tienda);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$SecuenciaTienda['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$SecuenciaTienda['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	
}
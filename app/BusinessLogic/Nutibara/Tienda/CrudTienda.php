<?php 

namespace App\BusinessLogic\Nutibara\Tienda;
use App\AccessObject\Nutibara\Tienda\Tienda;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class CrudTienda {

    public static function Create ($dataSaved,$horario,$saldo_cierre_caja)
    {				
		$respuesta = Tienda::Create($dataSaved,$horario,$saldo_cierre_caja);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Tienda['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Tienda['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Tienda ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Tienda::Tienda($start,$end,$colum, $order);
		}else
        {
			$result = Tienda::TiendaWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getTiendaByZona($zona)
    {
		$msm = Tienda::getTiendaByZona($zona);
		return $msm;
	}

	public static function getTiendaBySociedad($sociedad)
    {
		$msm = Tienda::getTiendaBySociedad($sociedad);
		return $msm;
	}

	public static function getTiendaByZona2($zona)
    {
		$msm = Tienda::getTiendaByZona2($zona);
		return $msm;
	}

	public static function getCountTienda($search)
	{
		if($search['estado'] == "" || $search['estado'] == null){
			$search['estado'] = 1;
		}
		return (int)Tienda::getCountTienda($search);
	}

	public static function getTiendaById($id)
	{
		return Tienda::getTiendaById($id);
	}

	public static function getHorarioByIdTienda($id)
	{
		return Tienda::getHorarioByIdTienda($id);
	}
	

	public static function getSelectList(){
		return Tienda::getSelectList();
	}

	public static function Update($id,$dataSaved,$horario)
    {

		$respuesta = Tienda::Update($id,$dataSaved,$horario);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Tienda['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Tienda['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Tienda['delete_ok'],'val'=>true];
		if(!Tienda::Update($id,$dataSaved,$horario = null))
        {
			$msm=['msm'=>Messages::$Tienda['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Tienda['active_ok'],'val'=>true];
		if(!Tienda::Update($id,$dataSaved,$horario = null))
        {
			$msm=['msm'=>Messages::$Tienda['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getTiendaByCiudad($id)
    {
		return Tienda::getTiendaByCiudad($id);
	}

	public static function getTiendaByDepartamento($id)
    {
		return Tienda::getTiendaByDepartamento($id);
	}

	public static function getTiendaByPais($id)
    {
		return Tienda::getTiendaByPais($id);
	}
	
	public static function getTiendaisnt($id)
    {
		return Tienda::getTiendaisnt($id);
	}
	
	public static function selectTiendaBySociedad($id)
    {
		return Tienda::selectTiendaBySociedad($id);
	}

	public static function ValidateMarket($campo,$data)
    {
		return Tienda::ValidateMarket($campo,$data);
	}

	public static function getPDC($id_tienda)
	{
		return Tienda::getPDC($id_tienda);
	}

	public static function Abrir($id)
	{
		$respuesta = Tienda::Abrir($id);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Tienda['open_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='Abierto')
		{
			$msm=['msm'=>Messages::$Tienda['open_ok'],'val'=>'Abierto'];	
		}
		return $msm;
	}

	public static function getMontoMax($id)
    {
		return Tienda::getMontoMax($id);
	}
	
}
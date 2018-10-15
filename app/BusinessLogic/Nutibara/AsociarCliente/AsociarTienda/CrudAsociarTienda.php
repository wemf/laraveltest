<?php 

namespace App\BusinessLogic\Nutibara\AsociarCliente\AsociarTienda;
use App\AccessObject\Nutibara\AsociarCliente\AsociarTienda\AsociarTienda;
use config\messages;


class CrudAsociarTienda {

    public static function Create ($dataSaved)
    {				
		$msm=['msm'=>Messages::$AsociarTienda['ok'],'val'=>true];	
		if(!AsociarTienda::Create($dataSaved))
        {
			$msm=['msm'=>Messages::$AsociarTienda['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function AsociarTienda ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = AsociarTienda::AsociarTienda($start,$end,$colum, $order);
		}else
        {
			$result = AsociarTienda::AsociarTiendaWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function TiendasSeleccionadas($id,$idtienda)
    {
		$result = AsociarTienda::TiendasSeleccionadas($id,$idtienda);
		return $result;
	}

	public static function CreateTiendas($dataSaved,$asociaciones)
	{
		$respuesta = AsociarTienda::CreateTiendas($dataSaved,$asociaciones);		
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$AsociarTienda['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$AsociarTienda['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function getAsociarTienda()
    {
		$msm = AsociarTienda::getAsociarTienda();
		return $msm;
	}

	public static function getCountAsociarTienda($start,$end,$colum, $order,$search)
	{
		return (int)AsociarTienda::getCountAsociarTienda($start,$end,$colum, $order,$search);
	}

	public static function getAsociarTiendaById($id,$id_tienda)
	{
		return AsociarTienda::getAsociarTiendaById($id,$id_tienda);
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$AsociarTienda['update_ok'],'val'=>true];
		if(!AsociarTienda::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$AsociarTienda['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$AsociarTienda['delete_ok'],'val'=>true];
		if(!AsociarTienda::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$AsociarTienda['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$AsociarTienda['active_ok'],'val'=>true];
		if(!AsociarTienda::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$AsociarTienda['active_error'],'val'=>false];		
		}	
		return $msm;
	}
	public static function getSelectListTipoCliente()
	{
		return AsociarTienda::getSelectListTipoCliente();
	}
	
}
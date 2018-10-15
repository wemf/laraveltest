<?php 

namespace App\BusinessLogic\Nutibara\AsociarCliente\AsociarSociedad;
use App\AccessObject\Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedad;
use config\messages;


class CrudAsociarSociedad {

    public static function Create ($dataSaved)
    {				
		$msm=['msm'=>Messages::$AsociarSociedad['ok'],'val'=>true];	
		if(!AsociarSociedad::Create($dataSaved))
        {
			$msm=['msm'=>Messages::$AsociarSociedad['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function AsociarSociedad ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = AsociarSociedad::AsociarSociedad($start,$end,$colum, $order);
		}else
        {
			$result = AsociarSociedad::AsociarSociedadWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function SociedadesSeleccionadas($id,$idtienda)
    {
		$result = AsociarSociedad::SociedadesSeleccionadas($id,$idtienda);
		return $result;
	}

	public static function CreateAsociacion($dataSaved,$asociaciones)
	{

		$respuesta = AsociarSociedad::CreateAsociacion($dataSaved,$asociaciones);	
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$AsociarSociedad['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$AsociarSociedad['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function getAsociarSociedad()
    {
		$msm = AsociarSociedad::getAsociarSociedad();
		return $msm;
	}

	public static function getCountAsociarSociedad($search)
	{
		return (int)AsociarSociedad::getCountAsociarSociedad($search);
	}

	public static function getAsociarSociedadById($id,$id_tienda)
	{
		return AsociarSociedad::getAsociarSociedadById($id,$id_tienda);
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$AsociarSociedad['update_ok'],'val'=>true];
		if(!AsociarSociedad::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$AsociarSociedad['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$AsociarSociedad['delete_ok'],'val'=>true];
		if(!AsociarSociedad::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$AsociarSociedad['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$AsociarSociedad['active_ok'],'val'=>true];
		if(!AsociarSociedad::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$AsociarSociedad['active_error'],'val'=>false];		
		}	
		return $msm;
	}
	public static function getSelectListTipoCliente()
	{
		return AsociarSociedad::getSelectListTipoCliente();
	}
	
}
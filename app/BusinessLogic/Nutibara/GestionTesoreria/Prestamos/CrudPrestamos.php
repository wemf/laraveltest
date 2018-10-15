<?php 

namespace App\BusinessLogic\Nutibara\GestionTesoreria\Prestamos;
use App\AccessObject\Nutibara\GestionTesoreria\Prestamos\Prestamos;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;


class CrudPrestamos {
	
	public static function Prestamos($start,$end,$colum, $order,$search)
    {
			$result = Prestamos::PrestamosWhere($start,$end,$colum, $order,$search);
		return $result;
	}

    public static function Create ($dataSaved)
    {				
		//Secuencia de Causacion
		$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda'],env('SECUENCIA_TIPO_CODIGO_PRESTAMO'),1);
		$codigoPrestamo = $secuencias[0]->response;
		$dataSaved['id'] = $codigoPrestamo;
		$respuesta = Prestamos::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Prestamos['prestamo_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Prestamos['prestamo_ok'],'val'=>'Insertado','id'=>$codigoPrestamo];	
		}
		return $msm;
	}

	public static function getPrestamosById($id)
	{
		return Prestamos::getPrestamosById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Prestamos::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Prestamos['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Prestamos['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Prestamos['delete_ok'],'val'=>true];
		if(!Prestamos::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Prestamos['error_delete'],'val'=>false];		
		}	
		return $msm;
	}
	
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Prestamos['active_ok'],'val'=>true];
		if(!Prestamos::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Prestamos['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Prestamos::getSelectList();
	}

	public static function getCountPrestamos($search)
	{
		return (int)Prestamos::getCountPrestamos($search);
	}

	public static function getSelectListById($id)
	{
		return Prestamos::getSelectListById($id);
	}

}
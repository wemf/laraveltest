<?php 

namespace App\BusinessLogic\Nutibara\GestionTesoreria\ConfiguracionContable;
use App\AccessObject\Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContable;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;


class CrudConfiguracionContable {
	
	public static function ConfiguracionContable ($start,$end,$colum, $order,$search)
    {
		$result = ConfiguracionContable::ConfiguracionContableWhere($start,$end,$colum, $order,$search);
		return $result;
	}

    public static function Create ($datosGenerales,$movimientos,$impuestos)
    {	
		$respuesta = ConfiguracionContable::Create($datosGenerales,$movimientos,$impuestos);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$ConfiguracionContable['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$ConfiguracionContable['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function getCountConfiguracionContable($search)
	{
		return (int)ConfiguracionContable::getCountConfiguracionContable($search);
	}

	public static function Update($id,$datosGenerales,$movimientos,$impuestos)
    {
		$respuesta = ConfiguracionContable::Update($id,$datosGenerales,$movimientos,$impuestos);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$ConfiguracionContable['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$ConfiguracionContable['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$msm=['msm'=>Messages::$ConfiguracionContable['delete_ok'],'val'=>true];
		if(!ConfiguracionContable::Delete($id))
        {
			$msm=['msm'=>Messages::$ConfiguracionContable['delete_error'],'val'=>false];		
		}	
		return $msm;
    }

    public static function getPuc($busqueda)
	{
		return ConfiguracionContable::getPuc($busqueda);
	}

	public static function getPucImp($busqueda)
	{
		return ConfiguracionContable::getPucImp($busqueda);
	}

	public static function getProveedores($busqueda)
	{
		return ConfiguracionContable::getProveedores($busqueda);
	}

	public static function getConfiguracionContableById($id)
	{
		$data['configuracioncontable'] = ConfiguracionContable::getConfiguracionContableById($id);
		$data['movimientos'] = ConfiguracionContable::getMovimientosConfiguracionContableById($id);
		$data['impuestos'] = ConfiguracionContable::getImpuestosConfiguracionContableById($id);
		return $data;
	}
	public static function getSelectListClase()
	{
		return ConfiguracionContable::getSelectListClase();
	}

	public static function getSelectListSubClase()
	{
		return ConfiguracionContable::getSelectListSubClase();
	}
	
	public static function getSelectListSubclaseByClase($id)
	{
		return ConfiguracionContable::getSelectListSubclaseByClase($id);
	}

	public static function getSelectListClaseBySubclase($id)
	{
		return ConfiguracionContable::getSelectListClaseBySubclase($id);
	}

	public static function ValidarBorrable($id)
	{
		return ConfiguracionContable::ValidarBorrable($id);
	}

	public static function ValidarRepetido($producto, $id_tipo_documento_contable,$id_sub_clase,$id_categoria)
	{
		return empty(ConfiguracionContable::ValidarRepetido($producto,$id_tipo_documento_contable,$id_sub_clase,$id_categoria)[0]);
	}

	public static function getSelectListTipoDocumentoContable()
	{
		return ConfiguracionContable::getSelectListTipoDocumentoContable();
	}

	public static function selectlistByIdTipoDocumento($id)
	{
		return ConfiguracionContable::selectlistByIdTipoDocumento($id);
	}

	public static function selectlistMovimientosContablesById($id)
	{
		return ConfiguracionContable::selectlistMovimientosContablesById($id);
	}

	public static function getcxc($id)
	{
		return ConfiguracionContable::getcxc($id);
	}

	public static function getImpuestosXConfiguracion($id)
	{
		return ConfiguracionContable::getImpuestosXConfiguracion($id);
	}
}
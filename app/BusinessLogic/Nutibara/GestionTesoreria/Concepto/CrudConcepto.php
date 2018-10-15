<?php 

namespace App\BusinessLogic\Nutibara\GestionTesoreria\Concepto;
use App\AccessObject\Nutibara\GestionTesoreria\Concepto\Concepto;
use config\messages;


class CrudConcepto {


	public static function Concepto ($start,$end,$colum, $order,$search)
    {
		$result = Concepto::ConceptoWhere($start,$end,$colum, $order,$search);
		return $result;
	}


    public static function Create($data,$asociaciones)
    {	
		$respuesta = Concepto::Create($data,$asociaciones);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Concepto['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Concepto['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function getConceptoById($id)
	{
		return Concepto::getConceptoById($id);
	}

	public static function ActualizarImpuestoConcepto($id_concepto,$asociaciones,$dataSaved)
    {
		$respuesta = Concepto::ActualizarImpuestoConcepto($id_concepto,$asociaciones,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Estado['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Estado['update_ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Concepto['delete_ok'],'val'=>true];
		if(!Concepto::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Concepto['error_delete'],'val'=>false];		
		}	
		return $msm;
	}
	
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Concepto['active_ok'],'val'=>true];
		if(!Concepto::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Concepto['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getCountConcepto($search)
	{
		return (int)Concepto::getCountConcepto($search);
	}

	public static function ImpuestoConcepto($id_concepto)
    {
		$result = Concepto::ImpuestoConcepto($id_concepto);
		return $result;
	}

	public static function getSelectListImpuesto()
	{
		return Concepto::getSelectListImpuesto();
	}

	public static function getSelectListTipoDocumentoContable()
	{
		return Concepto::getSelectListTipoDocumentoContable();
	}

	public static function getSelectListCodigo($id)
	{
		return Concepto::getSelectListCodigo($id);
	}

	public static function getSelectListNombre($id)
	{
		return Concepto::getSelectListNombre($id);
	}

}
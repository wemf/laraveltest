<?php 

namespace App\BusinessLogic\Nutibara\Products;
use App\AccessObject\Nutibara\Products\AdminAttributeAccessObject;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class AdminAttributeBusinessLogic {

    public static  function Create ($dateSave){
		$respuesta = AdminAttributeAccessObject::Create("tbl_prod_atributo",$dateSave);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$attribute['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$attribute['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Attributes ($start,$end,$colum, $order,$search){
		if($search['estado']==""){
			$result = AdminAttributeAccessObject::Attributes($start,$end,$colum, $order);
		}else{
			$result = AdminAttributeAccessObject::AttributesWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getAttribute(){
		$msm = AdminAttributeAccessObject::getAttribute();
		return $msm;
	}

	public static function getCountAttributes($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)AdminAttributeAccessObject::getCountAttributes($search);
	}

	public static function getAttributeById($id)
	{
		return AdminAttributeAccessObject::getAttributeById($id);
	}

	public static function getAttributesByCategories($categories)
	{
		return AdminAttributeAccessObject::getAttributesByCategories($categories);
	}
	

	public static function getAttributeAttributesById($id, $padre)
	{
		return AdminAttributeAccessObject::getAttributeAttributesById($id, $padre);
	}

	public static function getAttributeColumnByCategory($id_categoria)
	{
		return AdminAttributeAccessObject::getAttributeColumnByCategory($id_categoria);
	}

	public static function getAttributeValueById($id)
	{
		return AdminAttributeAccessObject::getAttributeValueById($id);
	}

	public static function update($id,$dataSaved){
		$respuesta = AdminAttributeAccessObject::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$attribute['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$attribute['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$attribute['inactive_ok'],'val'=>true];		
		if(!AdminAttributeAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$respuesta = AdminAttributeAccessObject::delete($id);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$attribute['error_delete'],'val'=>false];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_enuso'],'val'=>false];	
		}
		elseif($respuesta=='Eliminado')
		{
			$msm=['msm'=>Messages::$attribute['delete_ok'],'val'=>true];	
		}
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$attribute['active_ok'],'val'=>true];
		if(!AdminAttributeAccessObject::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$attribute['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getAttributeValueUpdate($id)
	{
		return AdminAttributeAccessObject::getAttributeValueUpdate($id);
	}

	public static function getAttributeValueByName($id_atributo, $valor)
	{
		return AdminAttributeAccessObject::getAttributeValueByName($id_atributo, $valor);
	}
}
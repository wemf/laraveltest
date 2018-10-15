<?php 

namespace App\BusinessLogic\Nutibara\Products;
use App\AccessObject\Nutibara\Products\AdminAttributeValueAccessObject;
use App\BusinessLogic\Nutibara\Excel\Products\AttributeValuesExcel;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class AdminAttributeValueBusinessLogic {

	private static function render($in='/\#CONTENIDO\#/ms',$out,$page)
	{
		return preg_replace($in,$out,$page);
	}

    public static  function Create ($dateSave){
		// $auditoria= new CampoAuditoria($dateSave);
		// $dateSave=$auditoria->getInsert();				
		$msm=['msm'=>Messages::$attributeValue['ok'],'val'=>true];		
		if(!AdminAttributeValueAccessObject::Create("tbl_prod_atributo_valores",$dateSave)){
			$msm=['msm'=>Messages::$attributeValue['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function AttributeValues ($start,$end,$colum, $order,$search){
		if($search['estado']==""){
			$result = AdminAttributeValueAccessObject::AttributeValues($start,$end,$colum, $order);
		}else{
			$result = AdminAttributeValueAccessObject::AttributeValuesWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getCountAttributeValues($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)AdminAttributeValueAccessObject::getCountAttributeValues($search);
	}
	

	public static function getAttributeValueById($id)
	{
		return AdminAttributeValueAccessObject::getAttributeValueById($id);
	}
	
	public static function update($id,$dataSaved){
		$msm=['msm'=>Messages::$attributeValue['update_ok'],'val'=>true];		
		if(!AdminAttributeValueAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$attributeValue['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$attributeValue['inactive_ok'],'val'=>true];
		if(!AdminAttributeValueAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$msm=['msm'=>Messages::$attributeValue['delete_ok'],'val'=>true];
		if(!AdminAttributeValueAccessObject::delete($id)){
			$msm=['msm'=>Messages::$attributeValue['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$attributeValue['active_ok'],'val'=>true];
		if(!AdminAttributeValueAccessObject::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$attributeValue['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function exportToExcel(){
		$attributeValuesExcel=new AttributeValuesExcel();
		$attributeValues =AdminAttributeValueAccessObject::getAllAttributeValues();
        return $attributeValuesExcel->ExportExcel($attributeValues);
	}

	public static function countAttrValByParent($id_parent) {
		return AdminAttributeValueAccessObject::countAttrValByParent($id_parent);
	}

	public static function storeFromContr($dateSave){
		return AdminAttributeValueAccessObject::storeFromContr("tbl_prod_atributo_valores",$dateSave);
    }
}
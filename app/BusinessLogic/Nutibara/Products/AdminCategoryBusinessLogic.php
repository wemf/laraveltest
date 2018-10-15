<?php 

namespace App\BusinessLogic\Nutibara\Products;
use App\AccessObject\Nutibara\Products\AdminCategoryAccessObject;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class AdminCategoryBusinessLogic {

    public static  function Create ($dateSave){
		$respuesta = AdminCategoryAccessObject::Create("tbl_prod_categoria_general",$dateSave);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$category['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$category['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Categories ($start,$end,$colum, $order,$search){
		if($search['estado']=="")
        {
			$result = AdminCategoryAccessObject::Categories($start,$end,$colum, $order);
		}else{
			$result = AdminCategoryAccessObject::CategoriesWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getCategoryById($id)
	{
		return AdminCategoryAccessObject::getCategoryById($id);
	}

	public static function getMedida()
	{
		return AdminCategoryAccessObject::getMedida();
	}

	public static function getCountCategories($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)AdminCategoryAccessObject::getCountCategories($search);
	}
	

	public static function getAttributeCategoryById($id)
	{
		return AdminCategoryAccessObject::getAttributeCategoryById($id);
	}

	public static function getFirstAttributeCategoryById($id)
	{
		return AdminCategoryAccessObject::getFirstAttributeCategoryById($id);
	}
	

	public static function Find ($id){
		$result = SysMultibdAccessObject::Find($id);
		return $result;
	}

	public static function update($id,$dataSaved){
		$respuesta = AdminCategoryAccessObject::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$category['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$category['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	
	public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$category['inactive_ok'],'val'=>true];		
		if(!AdminCategoryAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$msm=['msm'=>Messages::$category['delete_ok'],'val'=>true];		
		if(!AdminCategoryAccessObject::delete($id)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$category['active_ok'],'val'=>true];
		if(!AdminCategoryAccessObject::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$category['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getUsersClient($id){
		$msm = AdminCategoryAccessObject::getUsersClient($id);
		return $msm;
	}

	public static function getCategory(){
		$msm = AdminCategoryAccessObject::getCategory();
		return $msm;
	}

	public static function getCategoryNullItem(){
		$msm = AdminCategoryAccessObject::getCategoryNullItem();
		return $msm;
	}

	public static function validateUnique( $data, $id = 0 ) {
		return ( AdminCategoryAccessObject::validateUnique( $data, $id ) > 0 ) ? false : true;
	}
}
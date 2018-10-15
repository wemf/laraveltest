<?php 

namespace App\BusinessLogic\Nutibara\Products;
use App\AccessObject\Nutibara\Products\AdminReferenceAccessObject;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class AdminReferenceBusinessLogic {

    public static  function Create ( $dateSave, $attributes ){
		$respuesta = AdminReferenceAccessObject::Create("tbl_prod_catalogo",$dateSave, $attributes);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$reference['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$reference['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function References ($start,$end,$colum, $order,$search){
		if($search['estado']==""){
			$result = AdminReferenceAccessObject::References($start,$end,$colum, $order);
		}else{
			$result = AdminReferenceAccessObject::ReferencesWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getReference(){
		$msm = AdminReferenceAccessObject::getReference();
		return $msm;
	}

	public static function getCountReferences($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)AdminReferenceAccessObject::getCountReferences($search);
	}

	public static function getReferenceById($id)
	{
		return AdminReferenceAccessObject::getReferenceById($id);
	}
	

	public static function getReferenceValueById($id)
	{
		return AdminReferenceAccessObject::getReferenceValueById($id);
	}

	public static function getAttributesValuesById( $id ) {
		return AdminReferenceAccessObject::getAttributesValuesById( $id );
	}

	public static function update($id,$dataSaved, $attributes){
		$respuesta = AdminReferenceAccessObject::Update($id,$dataSaved, $attributes);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$reference['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$reference['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$reference['inactive_ok'],'val'=>true];		
		if(!AdminReferenceAccessObject::updateBasic($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$reference['active_ok'],'val'=>true];
		if(!AdminReferenceAccessObject::updateBasic($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$reference['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$validarCatalogo = AdminReferenceAccessObject::validarExistenciaCatalogoProductos($id);
		$msm=['msm'=>Messages::$reference['delete_ok'],'val'=>true];	
		if(count($validarCatalogo) == 0){
			if(!AdminReferenceAccessObject::delete($id)){
				$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
			}	
		}else{
			$msm=['msm'=>'Este producto tiene inventario asociado, no se puede eliminar','val'=>false];	
		}
		return $msm;
	}

	public static function getbyid($id){
		return AdminReferenceAccessObject::getbyid($id);
	}
}
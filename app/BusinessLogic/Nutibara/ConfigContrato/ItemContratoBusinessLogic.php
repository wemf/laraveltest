<?php 

namespace App\BusinessLogic\Nutibara\ConfigContrato;
use App\AccessObject\Nutibara\ConfigContrato\ItemContratoAccessObject;
use config\messages;


class ItemContratoBusinessLogic {
    
    public static function ItemContrato($start,$end,$colum, $order,$search){
        if($search['estado']==""){
			$result = ItemContratoAccessObject::ItemContrato($start,$end,$colum, $order);
		}else{
			$result = ItemContratoAccessObject::ItemContratoWhere($start,$end,$colum, $order,$search);
		}
		return $result;
    }

    public static function getCountItemContrato($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)ItemContratoAccessObject::getCountItemContrato($search);
	}

    public static function getItemContratoById($id)
	{
		return ItemContratoAccessObject::getItemContratoById($id);
	}

	public static function getItemContratoByCategoria($id)
	{
		return ItemContratoAccessObject::getItemContratoByCategoria($id);
	}

	public static function getAtributosEdit($id)
	{
		return ItemContratoAccessObject::getAtributosEdit($id);
	}
	
	public static function getAtributosContrato($categoria){
		return ItemContratoAccessObject::getAtributosContrato($categoria);
	}

	public static function getAtributosHijosContrato($id, $padre){
		return ItemContratoAccessObject::getAtributosHijosContrato($id, $padre);
	}
	

    public static  function Create ($dateSave, $table){				
		$msm=['msm'=>Messages::$itemcontrato['ok'],'val'=>true];
		$id=ItemContratoAccessObject::Create($table,$dateSave);
		if(!$id){
			$msm=['msm'=>Messages::$itemcontrato['error'],'val'=>false];		
		}
		if($table == "tbl_contr_item"){
			return $id;
		}else{
			return $msm;
		}	
	}

    public static function update($id,$dataSaved){
		$msm=['msm'=>Messages::$itemcontrato['update_ok'],'val'=>true];		
		if(!ItemContratoAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$itemcontrato['update_error'],'val'=>false];		
		}	
		return $msm;
	}

    public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$itemcontrato['inactive_ok'],'val'=>true];		
		if(!ItemContratoAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_inactive'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$msm=['msm'=>Messages::$itemcontrato['delete_ok'],'val'=>true];		
		if(!ItemContratoAccessObject::delete($id)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$itemcontrato['active_ok'],'val'=>true];
		if(!ItemContratoAccessObject::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$itemcontrato['active_error'],'val'=>false];		
		}	
		return $msm;
	}

}
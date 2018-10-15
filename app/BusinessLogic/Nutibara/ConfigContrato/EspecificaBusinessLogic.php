<?php 

namespace App\BusinessLogic\Nutibara\ConfigContrato;
use App\AccessObject\Nutibara\ConfigContrato\EspecificaAccessObject;
use config\messages;


class EspecificaBusinessLogic {
    
    public static function Especifica($start,$end,$colum, $order,$search){
        if($search['estado']==""){
			$result = EspecificaAccessObject::Especifica($start,$end,$colum, $order);
		}else{
			$result = EspecificaAccessObject::EspecificaWhere($start,$end,$colum, $order,$search);
		}
		return $result;
    }

    public static function getCountEspecifica($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)EspecificaAccessObject::getCountEspecifica($search);
	}

    public static function getEspecificaById($id)
	{
		return EspecificaAccessObject::getEspecificaById($id);
	}

    public static  function Create ($dateSave){
		$respuesta = EspecificaAccessObject::Create("tbl_contr_configuracion",$dateSave);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$especifica['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$especifica['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

    public static function update($id,$dataSaved){
		$respuesta = EspecificaAccessObject::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$especifica['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$especifica['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

    public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$especifica['inactive_ok'],'val'=>true];		
		if(!EspecificaAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_inactive'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$msm=['msm'=>Messages::$especifica['delete_ok'],'val'=>true];		
		if(!EspecificaAccessObject::delete($id)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$especifica['active_ok'],'val'=>true];
		if(!EspecificaAccessObject::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$especifica['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function validateUnique( $data, $id = 0 ) {
		if( EspecificaAccessObject::validateUniqueMonto( $data, $id ) > 0 && EspecificaAccessObject::validateUniqueVigencia( $data, $id ) > 0 ) {
			return false;
		} else {
			return true;
		}
	}

}
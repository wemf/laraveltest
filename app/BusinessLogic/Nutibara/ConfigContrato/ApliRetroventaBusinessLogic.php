<?php 

namespace App\BusinessLogic\Nutibara\ConfigContrato;
use App\AccessObject\Nutibara\ConfigContrato\ApliRetroventaAccessObject;
use config\messages;


class ApliRetroventaBusinessLogic {
    
    public static function ApliRetroventa($start,$end,$colum, $order,$search){
        if($search['estado']==""){
			$result = ApliRetroventaAccessObject::ApliRetroventa($start,$end,$colum, $order);
		}else{
			$result = ApliRetroventaAccessObject::ApliRetroventaWhere($start,$end,$colum, $order,$search);
		}
		return $result;
    }

    public static function getCountApliRetroventa($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)ApliRetroventaAccessObject::getCountApliRetroventa($search);
	}

    public static function getApliRetroventaById($id)
	{
		return ApliRetroventaAccessObject::getApliRetroventaById($id);
	}

    public static  function Create ($dateSave){
		$respuesta = ApliRetroventaAccessObject::Create("tbl_contr_aplicacion_retroventa",$dateSave);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$apliretroventa['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$apliretroventa['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

    public static function update($id,$dataSaved){
		$respuesta = ApliRetroventaAccessObject::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$apliretroventa['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$apliretroventa['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

    public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$apliretroventa['inactive_ok'],'val'=>true];		
		if(!ApliRetroventaAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_inactive'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$msm=['msm'=>Messages::$apliretroventa['delete_ok'],'val'=>true];		
		if(!ApliRetroventaAccessObject::delete($id)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$apliretroventa['active_ok'],'val'=>true];
		if(!ApliRetroventaAccessObject::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$apliretroventa['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function validateUnique( $data, $id = 0 ) {
		if( ApliRetroventaAccessObject::validateUnique( $data, $id ) > 0 ) {
			return false;
		} else {
			return true;
		}
	}
}
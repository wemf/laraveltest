<?php 

namespace App\BusinessLogic\Nutibara\ConfigContrato;
use App\AccessObject\Nutibara\ConfigContrato\GeneralAccessObject;
use config\messages;


class GeneralBusinessLogic {
    
    public static function General($start,$end,$colum, $order,$search){
        if($search['estado']==""){
			$result = GeneralAccessObject::General($start,$end,$colum, $order);
		}else{
			$result = GeneralAccessObject::GeneralWhere($start,$end,$colum, $order,$search);
		}
		return $result;
    }

    public static function getCountGeneral($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)GeneralAccessObject::getCountGeneral($search);
	}

    public static function getGeneralById($id)
	{
		return GeneralAccessObject::getGeneralById($id);
	}

    public static  function Create ($dateSave){
		$respuesta = GeneralAccessObject::Create("tbl_contr_dato_general",$dateSave);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$general['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$general['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

    public static function update($id,$dataSaved){
		$data_old = GeneralAccessObject::getGeneralById($id);
		$termino_dif = ($data_old->termino_contrato - $dataSaved["termino_contrato"]);
		$retroventa_dif = ($data_old->porcentaje_retroventa - $dataSaved["porcentaje_retroventa"]);
		$updateEspecifica = GeneralAccessObject::UpdateEspecifica($dataSaved["id_categoria_general"], ($termino_dif * (-1)), ($retroventa_dif * (-1)));
		$respuesta = GeneralAccessObject::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$general['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$general['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

    public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$general['inactive_ok'],'val'=>true];		
		if(!GeneralAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_inactive'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$msm=['msm'=>Messages::$general['delete_ok'],'val'=>true];		
		if(!GeneralAccessObject::delete($id)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$general['active_ok'],'val'=>true];
		if(!GeneralAccessObject::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$general['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function validateUnique( $data, $id = 0 ) {
		if( GeneralAccessObject::validateUnique( $data, $id ) > 0 ) {
			return false;
		} else {
			return true;
		}
	}

}
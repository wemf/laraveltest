<?php 

namespace App\BusinessLogic\Nutibara\ConfigContrato;
use App\AccessObject\Nutibara\ConfigContrato\DiaGraciaAccessObject;
use config\messages;


class DiaGraciaBusinessLogic {
    
    public static function DiaGracia($start,$end,$colum, $order,$search){
        if($search['estado']==""){
			$result = DiaGraciaAccessObject::DiaGracia($start,$end,$colum, $order);
		}else{
			$result = DiaGraciaAccessObject::DiaGraciaWhere($start,$end,$colum, $order,$search);
		}
		return $result;
    }

    public static function getCountDiaGracia($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)DiaGraciaAccessObject::getCountDiaGracia($search);
	}

    public static function getDiaGraciaById($id)
	{
		return DiaGraciaAccessObject::getDiaGraciaById($id);
	}

    public static  function Create ($dateSave){				

		$respuesta = DiaGraciaAccessObject::Create("tbl_contr_dia_retroventa",$dateSave);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$diagracia['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$diagracia['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

    public static function update($id,$dataSaved){
		$respuesta = DiaGraciaAccessObject::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$diagracia['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$diagracia['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

    public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$diagracia['inactive_ok'],'val'=>true];		
		if(!DiaGraciaAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_inactive'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$msm=['msm'=>Messages::$diagracia['delete_ok'],'val'=>true];		
		if(!DiaGraciaAccessObject::delete($id)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$diagracia['active_ok'],'val'=>true];
		if(!DiaGraciaAccessObject::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$diagracia['active_error'],'val'=>false];		
		}	
		return $msm;
	}

}
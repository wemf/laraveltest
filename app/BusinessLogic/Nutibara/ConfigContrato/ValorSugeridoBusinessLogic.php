<?php 

namespace App\BusinessLogic\Nutibara\ConfigContrato;
use App\AccessObject\Nutibara\ConfigContrato\ValorSugeridoAccessObject;
use config\messages;


class ValorSugeridoBusinessLogic {
    
    public static function ValorSugerido($start,$end,$colum, $order,$search){
        if($search['estado']==""){
			$result = ValorSugeridoAccessObject::ValorSugerido($start,$end,$colum, $order);
		}else{
			$result = ValorSugeridoAccessObject::ValorSugeridoWhere($start,$end,$colum, $order,$search);
		}
		return $result;
    }

    public static function getCountValorSugerido($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)ValorSugeridoAccessObject::getCountValorSugerido($search);
	}

    public static function getValorSugeridoById($id)
	{
		return ValorSugeridoAccessObject::getValorSugeridoById($id);
	}

    public static  function Create ($dateSave, $id_atributos){
		$respuesta = ValorSugeridoAccessObject::Create("tbl_contr_val_peso_sug",$dateSave, $id_atributos);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$valorsugerido['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$valorsugerido['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

    public static function update($id,$dataSaved){
		$respuesta = ValorSugeridoAccessObject::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$valorsugerido['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$valorsugerido['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function validarUnico($data, $id_atributos)
	{
		$id_atributos_array = [];
		try{
			$id_atributos_array = explode(',', $id_atributos);
		}catch(\Exception $e){}
		// dd($id_atributos_array);
		if(isset(ValorSugeridoAccessObject::validarUnico($data, $id_atributos_array)->cantidad)){
			$cantidad_unico = ValorSugeridoAccessObject::validarUnico($data, $id_atributos_array)->cantidad;
		}else{
			$cantidad_unico = 0;
		}
		if($cantidad_unico >= count($id_atributos_array)){
			return false;
		}else{
			return true;
		}
	}

    public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$valorsugerido['inactive_ok'],'val'=>true];		
		if(!ValorSugeridoAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_inactive'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$msm=['msm'=>Messages::$valorsugerido['delete_ok'],'val'=>true];		
		if(!ValorSugeridoAccessObject::delete($id)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$valorsugerido['active_ok'],'val'=>true];
		if(!ValorSugeridoAccessObject::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$valorsugerido['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getMedidaPeso(){
		$medida = ValorSugeridoAccessObject::getMedidaPeso();
		return $medida;
	}

	public static function getValById($id)
	{
		return ValorSugeridoAccessObject::getValById($id);
	}

	public static function getAttributeValueUpdate($id)
	{
		return ValorSugeridoAccessObject::getAttributeValueUpdate($id);
	}

}
<?php 

namespace App\BusinessLogic\Nutibara\ConfigContrato;
use App\AccessObject\Nutibara\ConfigContrato\ValorVentaAccessObject;
use config\messages;


class ValorVentaBusinessLogic {
    
    public static function ValorVenta($start,$end,$colum, $order,$search){
        if($search['estado']==""){
			$result = ValorVentaAccessObject::ValorVenta($start,$end,$colum, $order);
		}else{
			$result = ValorVentaAccessObject::ValorVentaWhere($start,$end,$colum, $order,$search);
		}
		return $result;
    }

    public static function getCountValorVenta($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)ValorVentaAccessObject::getCountValorVenta($search);
	}

    public static function getValorVentaById($id)
	{
		return ValorVentaAccessObject::getValorVentaById($id);
	}

    public static  function Create ($dateSave, $id_atributos){
		$respuesta = ValorVentaAccessObject::Create("tbl_contr_val_venta",$dateSave, $id_atributos);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$valorventa['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$valorventa['ok'],'val'=>'Insertado'];	
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
		if(isset(ValorVentaAccessObject::validarUnico($data, $id_atributos_array)->cantidad)){
			$cantidad_unico = ValorVentaAccessObject::validarUnico($data, $id_atributos_array)->cantidad;
		}else{
			$cantidad_unico = 0;
		}
		if($cantidad_unico >= count($id_atributos_array)){
			return false;
		}else{
			return true;
		}
	}

    public static function update($id,$dataSaved){
		$respuesta = ValorVentaAccessObject::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$valorventa['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$valorventa['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

    public static function inactive($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0; 
		$msm=['msm'=>Messages::$valorventa['inactive_ok'],'val'=>true];		
		if(!ValorVentaAccessObject::update($id,$dataSaved)){
			$msm=['msm'=>Messages::$sysMultibd['error_inactive'],'val'=>false];		
		}	
		return $msm;
	}

	public static function delete($id){
		$msm=['msm'=>Messages::$valorventa['delete_ok'],'val'=>true];		
		if(!ValorVentaAccessObject::delete($id)){
			$msm=['msm'=>Messages::$sysMultibd['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$valorventa['active_ok'],'val'=>true];
		if(!ValorVentaAccessObject::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$valorventa['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getMedidaPeso(){
		$medida = ValorVentaAccessObject::getMedidaPeso();
		return $medida;
	}

	public static function getValById($id)
	{
		return ValorVentaAccessObject::getValById($id);
	}

}
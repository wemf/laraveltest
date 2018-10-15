<?php 

namespace App\BusinessLogic\Nutibara\GestionEstado\Estado;
use App\AccessObject\Nutibara\GestionEstado\Estado\Estado;
use config\messages;


class CrudEstado {

    public static function Create ($dataSaved)
    {				
		$msm=['msm'=>Messages::$Estado['ok'],'val'=>true];	
		if(!Estado::Create($dataSaved))
        {
			$msm=['msm'=>Messages::$Estado['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function ActualizarMotivosEstado($id_estado,$Motivos,$dataSaved)
    {
		$respuesta = Estado::ActualizarMotivosEstado($id_estado,$Motivos,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Estado['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Estado['update_ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function CreateEstados($dataSaved,$Motivos)
    {				
		$respuesta = Estado::CreateEstados($dataSaved,$Motivos);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Estado['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Estado['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}
	public static function Estado ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Estado::Estado($start,$end,$colum, $order);
		}else
        {
			$result = Estado::EstadoWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function MotivosDeEstado($id_estado)
    {
		$result = Estado::MotivosDeEstado($id_estado);
		return $result;
	}

	public static function getEstado()
    {
		$msm = Estado::getEstado();
		return $msm;
	}

	public static function getCountEstado()
	{
		return (int)Estado::getCountEstado();
	}

	public static function getEstadoById($id)
	{
		return Estado::getEstadoById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$Estado['update_ok'],'val'=>true];
		if(!Estado::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Estado['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Estado::getSelectList();
	}

	public static function getEstadosByTema($id_tema)
	{
		return Estado::getEstadosByTema($id_tema);
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Estado['delete_ok'],'val'=>true];
		if(!Estado::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Estado['delete_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Estado['active_ok'],'val'=>true];
		if(!Estado::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Estado['active_error'],'val'=>false];		
		}	
		return $msm;
	}
}
<?php 

namespace App\BusinessLogic\Nutibara\Clientes\Eps;
use App\AccessObject\Nutibara\Clientes\Eps\Eps;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;


class CrudEps {

	public static function get($request)
	{
		$estado=($request->columns[1]["search"]["value"]=="")?1:(int)$request->columns[1]["search"]["value"];
		$select = Eps::get($estado);
		$search=array(	
			[
				'tableName'=>'tbl_clie_eps',
				'field'=>'nombre',
				'method'=>'like',
				'typeWhere'=>'where',
				'searchField'=>null,	
				'searchDate'=>null			
			],	
			[
				'tableName'=>'tbl_clie_eps',
				'field'=>'estado',
				'method'=>'=',
				'typeWhere'=>'where',
				'searchField'=>null,
				'searchDate'=>null			
			]
		);
		$where = array(
			[
				'field' => 'estado', 
				'method' => '=', 
				'typeWhere' => 'where',
				'value' => $estado, 
			]
		);
		$table=new DatatableBL($select,$search,$where);
		//dd($where);
		return $table->Run($request);
	}

    public static function Create ($dataSaved)
    {				
		$respuesta = Eps::Create($dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Eps['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Eps['ok'],'val'=>'Insertado'];	
		}
		return $msm;
	}

	public static function Eps ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Eps::Eps($start,$end,$colum, $order);
		}else
        {
			$result = Eps::EpsWhere($start,$end,$colum, $order,$search);
		}
		
		return $result;
	}

	public static function getEps()
    {
		$msm = Eps::getEps();
		return $msm;
	}

	public static function getCountEps($search)
	{
		return (int)Eps::getCountEps($search);
	}

	public static function getEpsById($id)
	{
		return Eps::getEpsById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$respuesta = Eps::Update($id,$dataSaved);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Eps['update_error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Eps['update_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Eps['delete_ok'],'val'=>true];
		if(!Eps::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Eps['error_delete'],'val'=>false];		
		}	
		return $msm;
	}
	
	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Eps['active_ok'],'val'=>true];
		if(!Eps::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Eps['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList()
	{
		return Eps::getSelectList();
	}

}
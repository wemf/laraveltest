<?php 

namespace App\AccessObject\Nutibara\Parametros;

use App\Models\Nutibara\Parametros\Parametros AS ModelParametros;
use App\Models\Nutibara\Lenguajes\Lenguajes AS ModelLenguajes;
use App\Models\Nutibara\Monedas\Monedas AS ModelMonedas;
use App\Models\Nutibara\MedidasPeso\MedidasPeso AS ModelMedidasPeso;
use DB;
class Parametros 
{
	public static function ParametrosWhere($colum, $order,$search){
		return ModelParametros::join('tbl_pais','tbl_pais.id','tbl_parametro_general.id_pais')
							->join('tbl_sys_tipo_moneda','tbl_sys_tipo_moneda.id','tbl_parametro_general.id_moneda')
							->join('tbl_sys_lenguaje','tbl_sys_lenguaje.id','tbl_parametro_general.id_lenguaje')
							->join('tbl_sys_medida_peso','tbl_sys_medida_peso.id','tbl_parametro_general.id_medida_peso')
							->select('tbl_parametro_general.id AS DT_RowId',
							'tbl_pais.nombre AS pais',
							'tbl_sys_medida_peso.nombre_medida AS medida_peso',
							'tbl_sys_lenguaje.nombre AS lenguaje',
							'tbl_sys_lenguaje.abreviatura AS abreviadoleng',
							'tbl_sys_tipo_moneda.abreviatura AS abreviadomon',
							'tbl_sys_tipo_moneda.nombre AS moneda',
							'tbl_parametro_general.decimales',							
							'redondeo',
							DB::raw("IF(tbl_parametro_general.estado = 1, 'SI', 'NO') AS estado")
							)
							->where(function ($query) use ($search){
								$query->where('tbl_pais.nombre', 'like', "%".$search['nombre']."%");
								$query->where('tbl_parametro_general.estado','=', $search['estado']);
							})
							->orderBy($colum, $order)
							->get();
	}

	public static function Parametros($start,$end,$colum,$order){
		return ModelParametros::join('tbl_pais','tbl_pais.id','tbl_parametro_general.id_pais')
								->join('tbl_sys_tipo_moneda','tbl_sys_tipo_moneda.id','tbl_parametro_general.id_moneda')
								->join('tbl_sys_lenguaje','tbl_sys_lenguaje.id','tbl_parametro_general.id_lenguaje')
								->join('tbl_sys_medida_peso','tbl_sys_medida_peso.id','tbl_parametro_general.id_medida_peso')
								->select('tbl_parametro_general.id AS DT_RowId',
								'tbl_pais.nombre AS pais',
								'tbl_sys_medida_peso.nombre_medida AS medida_peso',
								'tbl_sys_lenguaje.nombre AS lenguaje',
								'tbl_sys_lenguaje.abreviatura AS abreviadoleng',
								'tbl_sys_tipo_moneda.abreviatura AS abreviadomon',
								'tbl_sys_tipo_moneda.nombre AS moneda',
								'tbl_parametro_general.decimales',							
								'redondeo',
								DB::raw("IF(tbl_parametro_general.estado = 1, 'SI', 'NO') AS estado")
								)
						->where('tbl_parametro_general.estado',1)
						->skip($start)->take($end)
						->orderBy($colum, $order)
						->get();
	}

	public static function getCountParametros(){
		return ModelParametros::where('estado', '1')->count();
	}

	public static function getParametrosById($id){
		return ModelParametros::where('id',$id)->first();
	}

	public static function Create($dataSaved)
	{
		$result="Insertado";
		try{
			DB::beginTransaction();
			DB::table('tbl_parametro_general')->insert($dataSaved);		
			DB::commit();
		}catch(\Exception $e){
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
			DB::rollback();
		}
		return $result;
	}

	public static function Update($id,$dataSaved){	
		$result="Actualizado";
		try
		{
			ModelParametros::where('id',$id)->update($dataSaved);
		}catch(\Exception $e)
		{
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
		}
		return $result;	
	}

	public static function getParametros(){
		return ModelParametros::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectList()
	{
		return ModelParametros::select('id','nombre AS name')->where('estado','1')->get();
	}
	public static function getSelectListLenguaje()
	{
		return ModelLenguajes::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectListMoneda()
	{
		return ModelMonedas::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectListMedidaPeso()
	{
		return ModelMedidasPeso::select('id','nombre_medida AS name')->get();
	}

	public static function getSelectPais()
	{
		return ModelParametros::join('tbl_pais','tbl_pais.id','tbl_parametro_general.id_pais')
								->select('tbl_pais.id','tbl_pais.nombre AS name')
								->first();
	}

	public static function ValidateExist($id,$table,$campo)
	{
		if($id == "" )
		{
			return DB::table($table)
					->where($campo,$name)
					->count();
		}
		//Es necesario no contar el correo que tiene el cliente actualmente para que no tome el que tiene como existente.
		else
		{
			return DB::table($table)
				->where('id','<>',$id)
				->where($campo,$name)
				->count();
		}
	}

	public static function getAbreviatura($id)
	{
		return DB::table('tbl_sys_tipo_moneda')->where('id',$id)->first();
	}

	public static function getConfig()
	{
		return ModelParametros::join('tbl_pais','tbl_pais.id','tbl_parametro_general.id_pais')
								->join('tbl_sys_tipo_moneda','tbl_sys_tipo_moneda.id','tbl_parametro_general.id_moneda')
								->join('tbl_sys_lenguaje','tbl_sys_lenguaje.id','tbl_parametro_general.id_lenguaje')
								->join('tbl_sys_medida_peso','tbl_sys_medida_peso.id','tbl_parametro_general.id_medida_peso')
								->select('tbl_parametro_general.id AS DT_RowId',
								'tbl_pais.nombre AS pais',
								'tbl_pais.id AS id_pais',
								'tbl_sys_medida_peso.nombre_medida AS medida_peso',
								'tbl_sys_lenguaje.id AS id_lenguaje',
								'tbl_sys_lenguaje.nombre AS lenguaje',
								'tbl_sys_lenguaje.abreviatura AS abreviadoleng',
								'tbl_sys_tipo_moneda.abreviatura AS abreviadomon',
								'tbl_sys_tipo_moneda.id AS id_moneda',
								'tbl_sys_tipo_moneda.nombre AS moneda',
								'tbl_parametro_general.decimales',							
								'redondeo',
								DB::raw("IF(tbl_parametro_general.estado = 1, 'SI', 'NO') AS estado")
								)
						->where('tbl_parametro_general.estado',1)
						->first();
	}
}
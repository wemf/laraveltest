<?php 

namespace App\AccessObject\Nutibara\SecuenciaTienda;

use App\Models\Nutibara\SecuenciaTienda\SecuenciaTienda AS ModelSecuenciaTienda;
use DB;

class SecuenciaTienda 
{
	public static function SecuenciaTiendaWhere($start,$end,$colum, $order,$search){
		return ModelSecuenciaTienda::join('tbl_tienda','tbl_tienda.id','tbl_secuencia_tienda_x.id_tienda')
						->join('tbl_ciudad','tbl_tienda.id_ciudad','tbl_ciudad.id')
						->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
						->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						->select(
								'tbl_tienda.id AS DT_RowId',
								'tbl_tienda.nombre AS nombre',
								'tbl_ciudad.nombre AS ciudad',
								'tbl_departamento.nombre AS departamento',
								'tbl_pais.nombre AS pais',
								DB::raw("IF( tbl_tienda.sede_principal = 1, 'SI', 'NO') AS sede_principal")
								)
						->where(function ($query) use ($search){
								if($search['pais'] != "") $query->where('tbl_pais.nombre', 'like', "%".$search['pais']."%");
								if($search['departamento'] != "") $query->where('tbl_departamento.nombre', 'like', "%".$search['departamento']."%");
								if($search['ciudad'] != "") $query->where('tbl_ciudad.nombre', 'like', "%".$search['ciudad']."%");
								if($search['tienda'] != "") $query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
							})
							->skip($start)->take($end)							
							->where('tbl_tienda.estado',1)
							->groupBy('tbl_tienda.id')
							->groupBy('tbl_tienda.nombre')
							->groupBy('tbl_ciudad.nombre')
							->groupBy('tbl_departamento.nombre')
							->groupBy('tbl_pais.nombre')
							->groupBy('tbl_tienda.sede_principal')
							->orderBy('tbl_pais.nombre', 'asc')
							->orderBy('tbl_departamento.nombre', 'asc')
							->orderBy('tbl_ciudad.nombre', 'asc')
							->orderBy('tbl_tienda.nombre', 'asc')
							->get();
	}

	public static function SecuenciaTienda($start,$end,$colum,$order){
		return ModelSecuenciaTienda::join('tbl_tienda','tbl_tienda.id','tbl_secuencia_tienda_x.id_tienda')
						->join('tbl_ciudad','tbl_tienda.id_ciudad','tbl_ciudad.id')
						->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
						->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						->select(
								'tbl_tienda.id AS DT_RowId',
								'tbl_tienda.nombre AS nombre',
								'tbl_ciudad.nombre AS ciudad',
								'tbl_departamento.nombre AS departamento',
								'tbl_pais.nombre AS pais',
								DB::raw("IF( tbl_tienda.sede_principal = 1, 'SI', 'NO') AS sede_principal")								
								)
						->where(function ($query) use ($search){
								if($search['pais'] != "") $query->where('tbl_pais.nombre', 'like', "%".$search['pais']."%");
								if($search['departamento'] != "") $query->where('tbl_departamento.nombre', 'like', "%".$search['departamento']."%");
								if($search['ciudad'] != "") $query->where('tbl_ciudad.nombre', 'like', "%".$search['ciudad']."%");
								if($search['tienda'] != "") $query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
							})		
						->where('tbl_tienda.estado',1)	
						->skip($start)->take($end)		
						->groupBy('tbl_tienda.id')				
						->groupBy('tbl_tienda.nombre')				
						->groupBy('tbl_ciudad.nombre')				
						->groupBy('tbl_departamento.nombre')				
						->groupBy('tbl_pais.nombre')				
						->groupBy('tbl_tienda.sede_principal')				
						->orderBy('tbl_pais.nombre', 'asc')
						->orderBy('tbl_departamento.nombre', 'asc')
						->orderBy('tbl_ciudad.nombre', 'asc')
						->orderBy('tbl_tienda.nombre', 'asc')						
						->get();
	}

	public static function getCountSecuenciaTienda($search){
		return ModelSecuenciaTienda::join('tbl_tienda','tbl_tienda.id','tbl_secuencia_tienda_x.id_tienda')
						->join('tbl_ciudad','tbl_tienda.id_ciudad','tbl_ciudad.id')
						->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
						->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						->where(function ($query) use ($search){
								if($search['pais'] != "") $query->where('tbl_pais.nombre', 'like', "%".$search['pais']."%");
								if($search['departamento'] != "") $query->where('tbl_departamento.nombre', 'like', "%".$search['departamento']."%");
								if($search['ciudad'] != "") $query->where('tbl_ciudad.nombre', 'like', "%".$search['ciudad']."%");
								if($search['tienda'] != "") $query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
								})							
						->where('tbl_tienda.estado',1)
						->groupBy('tbl_tienda.id')
						->groupBy('tbl_tienda.nombre')
						->groupBy('tbl_ciudad.nombre')
						->groupBy('tbl_departamento.nombre')
						->groupBy('tbl_pais.nombre')
						->groupBy('tbl_tienda.sede_principal')
						->get();
	}

	public static function getSecuenciaTiendaById($id)
	{
		return ModelSecuenciaTienda::where('estado', '1')->where('id_tienda',$id)->first();
	}

	public static function getSecuenciaContratoTiendaById($id)
	{
		return ModelSecuenciaTienda::where('estado', '1')->where('sec_tipo',env('SECUENCIA_TIPO_CODIGO_CLIENTE'))->where()->get();
	}

	public static function getCodigosSecuencia($id_tienda,$codigo_consecutivo,$cantidad)
	{
		return DB::select('CALL sp_secuencias_tienda_x (?,?,?)',array($id_tienda, $codigo_consecutivo,$cantidad));
	}

	public static function Create($dataSaved){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_secuencia_tienda_x')->insert($dataSaved);		
			DB::commit();
		}catch(\Exception $e){
			$result=false;			
			DB::rollback();
		}
		return $result;
	}

	public static function Update($id,$dataSaved){	

		$result = true;
		try{
			DB::beginTransaction();
			self::prepareData($dataSaved,$id);
			DB::commit();
		}catch(\Exception $e){
			// dd($e);
			$result = false;
			DB::rollback();
		}

		return $result;
	}

	public static function prepareData($dataSaved,$id_tienda)
	{	
		$sec = DB::table('tbl_sys_secuencia_tipo')->select('sec_tipo')->get();
		for($i = 0; $i < count($sec); $i++)
		{
			$j = $sec[$i]->sec_tipo;
			$a = 'sec_desde_'.$j;
			$b = 'sec_hasta_'.$j;
			$c = 'sec_siguiente_'.$j;
			ModelSecuenciaTienda::where('id_tienda',$id_tienda)
								->where('sec_tipo',$j)
								->update([
									'sec_desde' => $dataSaved->$a,
									'sec_hasta' => $dataSaved->$b,
									'sec_siguiente' => $dataSaved->$c,
								]);
		}
		return true;
	}

	public static function getListSecInv($id,$id_tienda)
	{
		return DB::table('tbl_secuencia_config')->where('sec_tienda',$id)
												->where('id_tienda',$id_tienda)
												->select('sec_invalida')
												->get();
	}

	public static function getSecTienda($id,$sec)
	{
		return ModelSecuenciaTienda::where('sec_tipo',$sec)
									->where('id_tienda',$id)
									->select('secuencia_tienda')
									->first();
	}

	public static function Update_old($id,$dataSaved){	
		return ModelSecuenciaTienda::where('id_tienda',$id)->update($dataSaved);	
	}

	public static function createSecInv($id,$secuencia,$id_tienda)
	{
		$result = "Insertado";
		try
		{
			DB::beginTransaction();
			DB::table('tbl_secuencia_config')->insert([
				'sec_invalida' => $secuencia,
				'sec_tienda' => $id,
				'id_tienda' => $id_tienda
			]);
			DB::commit();
		}catch(\Exception $e)
		{
			if($e->getCode() == 2300)
			{
				$result = "ErrorUnico";
			}else
			{
				$result = "Error";
			}
			DB::rollBack();
		}

		return $result;
	}

	public static function getTipoSecuencia($id)
	{
		return DB::table('tbl_sys_secuencia_tipo')->join('tbl_secuencia_tienda_x','tbl_secuencia_tienda_x.sec_tipo','tbl_sys_secuencia_tipo.sec_tipo')
												->select(
													'tbl_sys_secuencia_tipo.nombre',
													'tbl_sys_secuencia_tipo.sec_tipo',
													'tbl_secuencia_tienda_x.fecha_actualizacion as fecha_fin',
													'tbl_secuencia_tienda_x.sec_desde',
													'tbl_secuencia_tienda_x.sec_hasta',
													'tbl_secuencia_tienda_x.sec_siguiente as sec_actual',
													'tbl_secuencia_tienda_x.secuencia_tienda as sec_tienda'
												)
												->where('tbl_secuencia_tienda_x.id_tienda',$id)
												->get();
	}

	public static function getTipoSecuenciaById($id_tienda)
	{
		return DB::table('tbl_sys_secuencia_tipo')->join('tbl_secuencia_tienda_x','tbl_secuencia_tienda_x.sec_tipo','tbl_sys_secuencia_tipo.sec_tipo')
												->where('id_tienda',$id_tienda)	
												->select(
													'tbl_sys_secuencia_tipo.nombre',
													'tbl_sys_secuencia_tipo.sec_tipo',
													'tbl_secuencia_tienda_x.fecha_actualizacion as fecha_fin',
													'tbl_secuencia_tienda_x.sec_desde',
													'tbl_secuencia_tienda_x.sec_hasta',
													'tbl_secuencia_tienda_x.sec_siguiente as sec_actual',
													'tbl_secuencia_tienda_x.secuencia_tienda as sec_tienda'
												)
												->get();
	}

	
}
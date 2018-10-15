<?php 

namespace App\AccessObject\Nutibara\Clientes\DenominacionMoneda;

use App\Models\Nutibara\Clientes\DenominacionMoneda\DenominacionMoneda AS ModelDenominacionMoneda;
use DB;

class DenominacionMoneda 
{
	public static function DenominacionMonedaWhere($start,$end,$colum, $order,$search){
		return ModelDenominacionMoneda::join('tbl_pais','tbl_pais.id','tbl_sys_denominacion_moneda.id_pais')
											->select(
											'tbl_sys_denominacion_moneda.id AS DT_RowId',
											'tbl_sys_denominacion_moneda.denominacion AS nombre',
											DB::raw('FORMAT(tbl_sys_denominacion_moneda.valor,0,"de_DE") as valor'),
											'tbl_pais.nombre AS pais',
											DB::raw("IF(.tbl_sys_denominacion_moneda.estado = 1, 'SI', 'NO') AS estado")
											)
											->where(function ($query) use ($search){
													if($search['nombre'] != "") $query->where('tbl_sys_denominacion_moneda.denominacion', 'like', "%".$search['nombre']."%");
													if($search['estado'] != "") $query->where('tbl_sys_denominacion_moneda.estado', '=', $search['estado']);
													if($search['pais'] != "") $query->where('tbl_pais.id', '=', $search['pais']);
												})
											->skip($start)->take($end)							
											->orderBy('tbl_sys_denominacion_moneda.valor', 'asc')
											->get();
	}

	public static function DenominacionMoneda($start,$end,$colum,$order){
		return ModelDenominacionMoneda::join('tbl_pais','tbl_pais.id','tbl_sys_denominacion_moneda.id_pais')
								->select(
								'tbl_sys_denominacion_moneda.id AS DT_RowId',
								'tbl_sys_denominacion_moneda.denominacion AS nombre',
								DB::raw('FORMAT(tbl_sys_denominacion_moneda.valor,0,"de_DE") as valor'),
								'tbl_pais.nombre AS pais',
								DB::raw("IF(.tbl_sys_denominacion_moneda.estado = 1, 'SI', 'NO') AS estado")
								)
								->where('tbl_sys_denominacion_moneda.estado',1)	
								->skip($start)->take($end)
								->orderBy('tbl_sys_denominacion_moneda.valor', 'asc')
						        ->get();
	}

	public static function getCountDenominacionMoneda($search){
		//dd($search);
		return ModelDenominacionMoneda::join('tbl_pais','tbl_pais.id','tbl_sys_denominacion_moneda.id_pais')
			->where('tbl_sys_denominacion_moneda.estado',($search['estado']=="")?1:$search['estado'])
			->where(function ($query) use ($search){
			if($search['nombre'] != "") $query->where('tbl_sys_denominacion_moneda.denominacion', 'like', "%".$search['nombre']."%");
			if($search['pais'] != "") $query->where('tbl_pais.id', '=', $search['pais']);
			})
			->count();
	}

	public static function getDenominacionMonedaById($id){
		return ModelDenominacionMoneda::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			DB::beginTransaction();
			DB::table('tbl_sys_denominacion_moneda')->insert($dataSaved);		
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
			ModelDenominacionMoneda::where('id',$id)->update($dataSaved);	
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

}
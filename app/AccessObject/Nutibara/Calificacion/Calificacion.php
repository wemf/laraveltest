<?php 

namespace App\AccessObject\Nutibara\Calificacion;

use App\Models\Nutibara\Calificacion\Calificacion AS ModelCalificacion;
use DB;

class Calificacion 
{
	public static function CalificacionWhere($start,$end,$colum, $order,$search){
		return ModelCalificacion::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								DB::raw("FORMAT(valor_min,2,'de_DE') as valor_min"),
								DB::raw("FORMAT(valor_max,2,'de_DE') as valor_max"),
								DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
						->where(function ($query) use ($search){
								$query->where('nombre', 'like', "%".$search['nombre']."%");
								$query->where('estado','=', $search['estado']);
							})
						->skip($start)->take($end)							
						->orderBy('valor_min')
						->get();
	}

	public static function Calificacion($start,$end,$colum,$order){
		return ModelCalificacion::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								DB::raw("FORMAT(valor_min,2,'de_DE') as valor_min"),
								DB::raw("FORMAT(valor_max,2,'de_DE') as valor_max"),
								DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
								->where('estado',1)	
								->skip($start)->take($end)
								->orderBy('valor_min')
						        ->get();
	}

	public static function getCountCalificacion($search){
		return ModelCalificacion::where(function ($query) use ($search){
				$query->where('nombre', 'like', "%".$search['nombre']."%");
				$query->where('estado','=', ($search['estado']=="")?1:$search['estado']);
			})->count();
	}

	public static function getCalificacion(){
		return ModelCalificacion::select('id', 'nombre', 'nombre as name')->where('estado',1)->get();
	}

	public static function getCalificacionById($id){
		return ModelCalificacion::select(
									'id',
									'nombre',
									DB::raw("FORMAT(valor_min,2,'de_DE') as valor_min"),
									DB::raw("FORMAT(valor_max,2,'de_DE') as valor_max"),
									'estado'
								)
								->where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			DB::beginTransaction();
			DB::table('tbl_calificacion')->insert($dataSaved);		
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
			ModelCalificacion::where('id',$id)->update($dataSaved);	
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
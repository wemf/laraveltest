<?php 

namespace App\AccessObject\Nutibara\DiasFestivos;

use App\Models\Nutibara\DiasFestivos\DiasFestivos AS ModelDiasFestivos;
use App\AccessObject\Nutibara\Parametros\Parametros;

class DiasFestivos 
{
	public static function DiasFestivosWhere($start,$end,$colum, $order,$search){
        return ModelDiasFestivos::join('tbl_pais','tbl_pais.id','tbl_sys_dias_festivos.id_pais')
                                ->select(
									'tbl_sys_dias_festivos.id AS DT_RowId',
									'tbl_pais.nombre AS pais',
									'tbl_sys_dias_festivos.fecha AS fecha',
									\DB::raw("IF(tbl_sys_dias_festivos.estado = 1, 'SI', 'NO') AS estado")
								)
					->where(function ($query) use ($search){
						if($search['id_pais'] != '')
						{
							$query->where('tbl_pais.id', '=', $search['id_pais']);						
						}
						$query->where('tbl_sys_dias_festivos.estado','=', $search['estado']);
					})		
					->skip($start)->take($end)
					->orderBy($colum, $order)
					->get();
	}

	public static function DiasFestivos($start,$end,$colum,$order){
		/*Me trae solo los dias festivos del pais que este en Parametros Generales*/ 

		return ModelDiasFestivos::join('tbl_pais','tbl_pais.id','tbl_sys_dias_festivos.id_pais')
                                    ->select(
                                        'tbl_sys_dias_festivos.id AS DT_RowId',
                                        'tbl_pais.nombre AS pais',
                                        'tbl_sys_dias_festivos.fecha AS fecha',
                                        \DB::raw("IF(tbl_sys_dias_festivos.estado = 1, 'SI', 'NO') AS estado")
                                    )
							->where('tbl_sys_dias_festivos.estado',1)
							->where('tbl_pais.id',Parametros::getSelectPais()['id'])
                            ->skip($start)->take($end)
                            ->orderBy($colum, $order)
                            ->get();
	}

	public static function getPaisById($id){
		return ModelDiasFestivos::join('tbl_pais','tbl_pais.id','tbl_sys_dias_festivos.id_pais')
		->select(
			'tbl_sys_dias_festivos.id',
			'tbl_sys_dias_festivos.id_pais',
			'tbl_pais.nombre',
			'tbl_sys_dias_festivos.fecha AS fecha',
			\DB::raw("IF(tbl_sys_dias_festivos.estado = 1, 'SI', 'NO') AS estado")
		)
		->where('tbl_sys_dias_festivos.id',$id)
		->first();
	}

	public static function getCountDiasFestivos($search)
	{
		
		return ModelDiasFestivos::join('tbl_pais','tbl_pais.id','tbl_sys_dias_festivos.id_pais')
								->where(function ($query) use ($search)
								{
									if($search['id_pais'] != '')
									{
										$query->where('tbl_pais.id', '=', $search['id_pais']);						
									}
									if($search['estado'] == '')
									{
										/*Me trae solo los dias festivos del pais que este en Parametros Generales*/ 
										$query->where('tbl_pais.id',Parametros::getSelectPais()['id']);								
										$search['estado'] = 1;
									}
									$query->where('tbl_sys_dias_festivos.estado','=', $search['estado']);
								})	
								->count();
	}

	public static function getDiasFestivosById($id){
		return ModelDiasFestivos::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_sys_dias_festivos')->insert($dataSaved);		
			\DB::commit();
		}catch(\Exception $e){
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
			\DB::rollback();
		}
		return $result;
	}

	public static function Update($id,$dataSaved){	
		$result="Actualizado";
		try
		{
			ModelDiasFestivos::where('id',$id)->update($dataSaved);	
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

	public static function getDiasFestivos(){
		return ModelDiasFestivos::select('id','nombre AS name')->where('estado','1')->get();
	}
}
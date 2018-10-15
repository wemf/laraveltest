<?php 

namespace App\AccessObject\Nutibara\Clientes\AreaTrabajo;

use App\Models\Nutibara\Clientes\AreaTrabajo\AreaTrabajo AS ModelAreaTrabajo;

class AreaTrabajo 
{
	public static function AreaTrabajoWhere($start,$end,$colum, $order,$search){
		return ModelAreaTrabajo::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
						->where(function ($query) use ($search){
								$query->where('nombre', 'like', "%".$search['nombre']."%");
								$query->where('estado', '=', $search['estado']);
							})
						->skip($start)->take($end)							
						->orderBy($colum, $order)
						->get();
	}

	public static function AreaTrabajo($start,$end,$colum,$order){
		return ModelAreaTrabajo::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
								->where('estado',1)	
								->skip($start)->take($end)
								->orderBy($colum, $order)
						        ->get();
	}

	public static function getCountAreaTrabajo($search){
		return ModelAreaTrabajo::where(function ($query) use ($search){
			if($search['nombre']!=""){
				$query->where('nombre', 'like', "%".$search['nombre']."%");
			}
			$query->where('estado', '=', ($search['estado']=="")?1:$search['estado']);
		})->count();
	}

	public static function getAreaTrabajoById($id){
		return ModelAreaTrabajo::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_area_trabajo')->insert($dataSaved);		
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
			ModelAreaTrabajo::where('id',$id)->update($dataSaved);	
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
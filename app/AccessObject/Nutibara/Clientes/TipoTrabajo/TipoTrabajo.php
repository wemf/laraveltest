<?php 

namespace App\AccessObject\Nutibara\Clientes\TipoTrabajo;

use App\Models\Nutibara\Clientes\TipoTrabajo\TipoTrabajo AS ModelTipoTrabajo;

class TipoTrabajo 
{
	public static function TipoTrabajoWhere($start,$end,$colum, $order,$search){
		return ModelTipoTrabajo::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
						->where(function ($query) use ($search){
								$query->where('nombre', 'like', "%".$search['nombre']."%");
								$query->where('estado','=', $search['estado']);
							})
						->skip($start)->take($end)							
						->orderBy($colum, $order)
						->get();
	}

	public static function TipoTrabajo($start,$end,$colum,$order){
		return ModelTipoTrabajo::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
								->where('estado',1)	
								->skip($start)->take($end)
								->orderBy($colum, $order)
						        ->get();
	}

	public static function getCountTipoTrabajo(){
		return ModelTipoTrabajo::where('estado', '1')->count();
	}

	public static function getTipoTrabajoById($id){
		return ModelTipoTrabajo::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_tipo_trabajo')->insert($dataSaved);		
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
			ModelTipoTrabajo::where('id',$id)->update($dataSaved);	
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
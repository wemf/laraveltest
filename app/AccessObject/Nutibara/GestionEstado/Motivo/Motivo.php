<?php 

namespace App\AccessObject\Nutibara\GestionEstado\Motivo;

use App\Models\Nutibara\GestionEstado\Motivo\Motivo AS ModelMotivo;

class Motivo 
{
	public static function MotivoWhere($start,$end,$colum, $order,$search){
		return ModelMotivo::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								'descripcion AS descripcion',
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

	public static function Motivo($start,$end,$colum,$order){
		return ModelMotivo::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								'descripcion AS descripcion',
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
								->where('estado',1)	
								->skip($start)->take($end)
								->orderBy($colum, $order)
						        ->get();
	}

	public static function getCountMotivo($search){
		return ModelMotivo::where(function ($query) use ($search){
											$query->where('nombre', 'like', "%".$search['nombre']."%");
											if($search['estado'] == "")
											$search['estado'] = 1;	
											$query->where('estado', '=', $search['estado']);
										})
										->count();
	}

	public static function getMotivoById($id){
		return ModelMotivo::where('id',$id)->first();
	}

	public static function getMotivoByEstado($id_estado){
		return ModelMotivo::join('tbl_sys_motivo_estado','tbl_sys_motivo_estado.id_motivo','tbl_sys_motivo.id')
							->select(
								'tbl_sys_motivo.id',
								'tbl_sys_motivo.nombre AS name'
							)
							->where('tbl_sys_motivo_estado.id_estado',$id_estado)->get();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_sys_motivo')->insert($dataSaved);		
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
			ModelMotivo::where('id',$id)->update($dataSaved);	
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

	public static function getSelectList(){
		return ModelMotivo::select('id','nombre AS name')->where('estado','1')->get();
	}

}
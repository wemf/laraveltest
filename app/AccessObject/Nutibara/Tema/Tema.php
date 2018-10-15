<?php 

namespace App\AccessObject\Nutibara\Tema;

use App\Models\Nutibara\GestionEstado\Tema\Tema AS ModelTema;

class Tema 
{
	public static function TemaWhere($start,$end,$colum, $order,$search){
		return ModelTema::select(
								'tbl_sys_tema.id AS DT_RowId',
								'tbl_sys_tema.nombre AS nombre'
								)
						->where(function ($query) use ($search){
							   if($search['id_tema'] =! "")
								$query->where('tbl_sys_tema.id', '=', $search['id_tema']);
								$query->where('tbl_sys_tema.estado', '=', $search['estado']);
						})
						->where('tbl_sys_tema.nombre', 'like', "%".$search['nombre']."%")
						->skip($start)->take($end)							
						->orderBy($colum, $order)
						->get();
	}
	public static function Tema($start,$end,$colum,$order){
		
		return ModelEstado::select(
									'tbl_sys_tema.id AS DT_RowId',
									'tbl_sys_tema.nombre AS nombre',
									\DB::raw("IF(tbl_sys_tema.estado = 1, 'SI', 'NO') AS estado")
									)
							->where('tbl_sys_tema.estado',1)
							->skip($start)->take($end)
							->orderBy($colum, $order)
						    ->get();
	}

	public static function getEstadosByTema($id_tema){
		return ModelTema::join('tbl_sys_estado_tema','tbl_sys_estado_tema.id_tema','tbl_sys_tema.id')
						->select(
								'tbl_sys_estado_tema.id',
								'tbl_sys_estado_tema.nombre AS name'
								)
						->where('id_tema',$id_tema)
						->where('tbl_sys_estado_tema.estado','1')
						->get();
	}

	public static function getCountTema($search)
	{
		return ModelTema::where(function ($query) use ($search){
										if($search['id_tema'] =! "")
										$query->where('tbl_sys_tema.id', '=', $search['id_tema']);
										$query->where('tbl_sys_tema.estado', '=', $search['estado']);
								})
								->where('tbl_sys_tema.nombre', 'like', "%".$search['nombre']."%")
	 							->count();
	}

	public static function getTemaById($id){
		return ModelTema::where('id',$id)->first();
	}
	public static function getSelectList(){
		return ModelTema::select('id','nombre AS name')->where('estado','1')->get();
	}
}
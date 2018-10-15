<?php 

namespace App\AccessObject\Nutibara\Clientes\Profesion;

use App\Models\Nutibara\Clientes\Profesion\Profesion AS ModelProfesion;

class Profesion 
{
	public static function ProfesionWhere($start,$end,$colum, $order,$search){
		return ModelProfesion::select(
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

	public static function Profesion($start,$end,$colum,$order){
		return ModelProfesion::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
								->where('estado',1)	
								->skip($start)->take($end)
								->orderBy($colum, $order)
						        ->get();
	}

	public static function getCountProfesion($search){
		return ModelProfesion::where(function ($query) use ($search){
					$query->where('nombre', 'like', "%".$search['nombre']."%");
					$query->where('estado', '=', ($search['estado']=="")?1:$search["estado"]);
				})->count();
	}

	public static function getProfesionById($id){
		return ModelProfesion::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_profesion')->insert($dataSaved);		
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
			ModelProfesion::where('id',$id)->update($dataSaved);	
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
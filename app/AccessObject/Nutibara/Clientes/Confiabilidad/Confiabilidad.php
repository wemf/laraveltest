<?php 

namespace App\AccessObject\Nutibara\Clientes\Confiabilidad;

use App\Models\Nutibara\Clientes\Confiabilidad\Confiabilidad AS ModelConfiabilidad;

class Confiabilidad 
{
	public static function ConfiabilidadWhere($start,$end,$colum, $order,$search){
		return ModelConfiabilidad::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								\DB::raw("IF(permitir_contrato = 1, 'SI', 'NO') AS permitir_contrato"),
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

	public static function Confiabilidad($start,$end,$colum,$order){
		return ModelConfiabilidad::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								\DB::raw("IF(permitir_contrato = 1, 'SI', 'NO') AS permitir_contrato"),
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
								->where('estado',1)	
								->skip($start)->take($end)
								->orderBy($colum, $order)
						        ->get();
	}

	public static function getCountConfiabilidad($search){
		return ModelConfiabilidad::where(function ($query) use ($search){
			$query->where('nombre', 'like', "%".$search['nombre']."%");
			$query->where('estado', '=', ($search['estado']=="")?1:$search['estado']);
		})->count();
	}

	public static function getConfiabilidadById($id){
		return ModelConfiabilidad::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result=true;
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_confiabilidad')->insert($dataSaved);		
			\DB::commit();
		}catch(\Exception $e){
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function Update($id,$dataSaved){	
		return ModelConfiabilidad::where('id',$id)->update($dataSaved);	
	}

}
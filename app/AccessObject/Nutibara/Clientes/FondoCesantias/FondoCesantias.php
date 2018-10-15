<?php 

namespace App\AccessObject\Nutibara\Clientes\FondoCesantias;

use App\Models\Nutibara\Clientes\FondoCesantias\FondoCesantias AS ModelFondoCesantias;

class FondoCesantias 
{
	public static function FondoCesantiasWhere($colum, $order,$search){
		return ModelFondoCesantias::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								'descripcion AS descripcion'
								)
						->where('estado',1)
						->where(function ($query) use ($search){
								$query->where('nombre', 'like', "%".$search['nombre']."%");
							})
						->orderBy($colum, $order)
						->get();
	}

	public static function FondoCesantias($start,$end,$colum,$order){
		return ModelFondoCesantias::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								'descripcion AS descripcion'
								)
						        ->where('estado',1)	
						        ->get();
	}

	public static function getCountFondoCesantias(){
		return ModelFondoCesantias::where('estado', '1')->count();
	}

	public static function getFondoCesantiasById($id){
		return ModelFondoCesantias::where('estado', '1')->where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result=true;
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_fondo_cesantias')->insert($dataSaved);		
			\DB::commit();
		}catch(\Exception $e){
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function Update($id,$dataSaved){	
		return ModelFondoCesantias::where('id',$id)->update($dataSaved);	
	}

}
<?php 

namespace App\AccessObject\Nutibara\Clientes\Eps;

use App\Models\Nutibara\Clientes\Eps\Eps AS ModelEps;

class Eps 
{
	public static function get($estado)
	{
		
		return ModelEps::select("id AS DT_RowId",
								"nombre",
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado"))
								->where("estado",$estado)
								->orderBy("nombre","asc");
	}

	public static function EpsWhere($start,$end,$colum, $order,$search){
			
		return ModelEps::select(
									'id AS DT_RowId',
									'nombre',
									\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
					->where(function ($query) use ($search){
						$query->where('nombre', 'like', "%".$search['name']."%");
						$query->where('estado','=', $search['estado']);
					})	
					->skip($start)->take($end)					
					->orderBy($colum, $order) 
					->get();
	}

	public static function Eps($start,$end,$colum,$order){
		
		return ModelEps::select(
									'id AS DT_RowId',
									'nombre',
									\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado"))
						->where('estado',1)
						->get();
	}

	public static function getCountEps($search){
		
		return ModelEps::where('estado', ($search["estado"]=="")?1:$search["estado"])
										->where(function ($query) use ($search){
											if($search["name"]!=""){
												$query->where('nombre', 'like', "%".$search['name']."%");
											}
											
										})
										->count();
	}

	public static function getEpsById($id){
		return ModelEps::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_eps')->insert($dataSaved);		
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
			ModelEps::where('id',$id)->update($dataSaved);	
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

	public static function getEps(){
		return ModelEps::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectList(){
		return ModelEps::select('id','nombre AS name')->where('estado','1')->get();
	}
}
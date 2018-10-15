<?php 

namespace App\AccessObject\Nutibara\Clientes\Caja;

use App\Models\Nutibara\Clientes\Caja\Caja AS ModelCaja;

class Caja 
{
	public static function CajaWhere($start,$end,$colum, $order,$search){
		return ModelCaja::select(
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

	public static function Caja($start,$end,$colum,$order){
		return ModelCaja::select(
								'id AS DT_RowId',
								'nombre',
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado"))
								->skip($start)->take($end)
								->where('estado',1)
								->orderBy($colum,$order)
								->get();
	}

	public static function getCountCaja($search){
		return ModelCaja::where('estado', ($search['estado']=="")?1:$search['estado'])
						->where(function($query) use($search){
							if($search['name']!=""){
								$query->where('nombre', 'like', "%".$search['name']."%");
							}
						})
						->count();
		 
	}

	public static function getCajaById($id){
		return ModelCaja::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_caja_compensacion')->insert($dataSaved);		
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
			ModelCaja::where('id',$id)->update($dataSaved);	
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

	public static function getCaja(){
		return ModelCaja::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectList(){
		return ModelCaja::select('id','nombre AS name')->where('estado','1')->get();
	}
}
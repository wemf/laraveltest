<?php 

namespace App\AccessObject\Nutibara\Clientes\CargoEmpleado;

use App\Models\Nutibara\Clientes\CargoEmpleado\CargoEmpleado AS ModelCargoEmpleado;

class CargoEmpleado 
{
	public static function CargoEmpleadoWhere($start,$end,$colum, $order,$search){
		return ModelCargoEmpleado::select(
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

	public static function CargoEmpleado($start,$end,$colum,$order){
		return ModelCargoEmpleado::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
								->where('estado',1)	
								->skip($start)->take($end)
								->orderBy($colum, $order)
						        ->get();
	}

	public static function getCountCargoEmpleado($search){
		return ModelCargoEmpleado::where(function ($query) use ($search){
			$query->where('nombre', 'like', "%".$search['nombre']."%");
			$query->where('estado', '=', ($search['estado']=="")?1:$search['estado']);
		})->count();
	}

	public static function getCargoEmpleadoById($id){
		return ModelCargoEmpleado::where('id',$id)->first();
	}

	public static function Create($dataSaved){

		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_empl_cargo')->insert($dataSaved);		
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
			ModelCargoEmpleado::where('id',$id)->update($dataSaved);	
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

	public static function getSelectList()
	{
		return ModelCargoEmpleado::select('id','nombre AS name')->where('estado', 1)->get();
	}
}
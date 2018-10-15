<?php 

namespace App\AccessObject\Nutibara\Clientes\PlanUnicoCuenta;

use App\Models\Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuenta AS ModelPlanUnicoCuenta;

class PlanUnicoCuenta 
{
	public static function PlanUnicoCuentaWhere($start,$end,$colum, $order,$search){
		return ModelPlanUnicoCuenta::select(
									'id AS DT_RowId',
									'cuenta',
									'nombre',
									\DB::raw("CASE WHEN naturaleza = 1 THEN 'Debito' WHEN naturaleza = 0 THEN 'Credito' ELSE 'No Naturaleza' END AS naturaleza")
								)
						->where(function ($query) use ($search){
							if($search['cuenta'] <> '')
							$query->where('cuenta', 'like', "%".$search['cuenta']."%");
							if($search['nombre'] <> '')								
							$query->where('nombre', 'like', "%".$search['nombre']."%");
							if($search['naturaleza'] <> '')								
							$query->where('naturaleza',$search['naturaleza']);
						})	
						->skip($start)->take($end)
						->orderBy($colum, $order)
						->get();
	}

	public static function PlanUnicoCuentaExcel()
	{
		return ModelPlanUnicoCuenta::select(
									'id',
									'cuenta',
									'nombre',
									\DB::raw("CASE WHEN naturaleza = 1 THEN 'Debito' WHEN naturaleza = 0 THEN 'Credito' ELSE 'No Naturaleza' END AS naturaleza")
								)
								->get();
	}
 
	public static function getCountPlanUnicoCuenta($search){
		return ModelPlanUnicoCuenta::where(function ($query) use ($search){
										if($search['cuenta'] <> "")
										$query->where('cuenta', 'like', "%".$search['cuenta']."%");
										if($search['nombre'] <> "")								
										$query->where('nombre', 'like', "%".$search['nombre']."%");
										if($search['naturaleza'] <> "")								
										$query->where('naturaleza',$search['naturaleza']);
									})
									->count();
	}

	public static function getPlanUnicoCuentaById($id){
		return ModelPlanUnicoCuenta::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_plan_unico_cuenta')->insert($dataSaved);		
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
		ModelPlanUnicoCuenta::where('id',$id)
		->update($dataSaved);	
		}catch(\Exception $e)
		{
			dd($e);
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
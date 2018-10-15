<?php 

namespace App\AccessObject\Nutibara\Pasatiempo;

use App\Models\Nutibara\Pasatiempo\Pasatiempo AS ModelPasatiempo;

class Pasatiempo 
{
	public static function PasatiempoWhere($start,$end,$colum, $order,$search){
		
		return ModelPasatiempo::select(
										'id AS DT_RowId',
										'nombre',
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

	public static function Pasatiempo($start,$end,$colum,$order){
		return ModelPasatiempo::select(
										'id AS DT_RowId',
										'nombre',
										\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
										)
						->where('estado',1)
						->skip($start)->take($end)
						->orderBy($colum, $order)
						->get();
	}

	public static function getCountPasatiempo($search){
		return ModelPasatiempo::where(function ($query) use ($search){
			$query->where('nombre', 'like', "%".$search['nombre']."%");
			$query->where('estado','=', ($search['estado']=="")?1:$search['estado']);
		})->count();
	}

	public static function getPasatiempoById($id){
		return ModelPasatiempo::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_pasatiempo')->insert($dataSaved);		
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
			ModelPasatiempo::where('id',$id)->update($dataSaved);	
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

	public static function getPasatiempo(){
		return ModelPasatiempo::select('id','nombre AS nombre')->where('estado','1')->get();
	}

	public static function getSelectList(){
		return ModelPasatiempo::select('id','nombre AS nombre')->where('estado','1')->get();
	}

	public static function getSelectListPasatiempo($id){
		return ModelPasatiempo::select('tbl_departamento.id','tbl_departamento.nombre As nombre')
							->where('estado','1')
							->get();
	}
}
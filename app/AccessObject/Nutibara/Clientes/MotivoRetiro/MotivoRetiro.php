<?php 

namespace App\AccessObject\Nutibara\Clientes\MotivoRetiro;

use App\Models\Nutibara\Clientes\MotivoRetiro\MotivoRetiro AS ModelMotivoRetiro;
use DB;

class MotivoRetiro 
{
	public static function MotivoRetiroWhere($start,$end,$colum, $order,$search){
		return ModelMotivoRetiro::select(
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

	public static function MotivoRetiro($start,$end,$colum,$order){


		$Tienda =  DB::table('tbl_tienda')
		->select(
				 'id'
				)
		->where('id_zona',27)
		->get();
		for ($i=0; $i <	count($Tienda) ; $i++) 
			{
				$tiendasAsociar[$i]['id_tienda'] = $Tienda[$i]->id;
				$tiendasAsociar[$i]['codigo_cliente'] = 1;
				$tiendasAsociar[$i]['id_tienda_cliente'] = 2;

			}
		return ModelMotivoRetiro::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
								->where('estado',1)	
								->skip($start)->take($end)
								->orderBy($colum, $order)
						        ->get();
	}

	public static function getCountMotivoRetiro($search){
		return ModelMotivoRetiro::where(function ($query) use ($search){
			$query->where('nombre', 'like', "%".$search['nombre']."%");
			$query->where('estado', '=', ($search['estado']=="")?1:$search['estado']);
		})->count();
	}

	public static function getMotivoRetiroById($id){
		return ModelMotivoRetiro::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_empl_motivo_retiro')->insert($dataSaved);		
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
			ModelMotivoRetiro::where('id',$id)->update($dataSaved);	
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
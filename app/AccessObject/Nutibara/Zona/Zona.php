<?php 

namespace App\AccessObject\Nutibara\Zona;
use App\Models\Nutibara\Zona\Zona AS ModelZona;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;

class Zona 
{
	public static function ZonaWhere($start,$end,$colum, $order,$search){
		
		return ModelZona::join('tbl_pais','tbl_pais.id','tbl_zona.id_pais')
						->select('tbl_zona.id AS DT_RowId',
								'tbl_zona.nombre',
								'tbl_pais.nombre AS pais',
								\DB::raw("IF(tbl_zona.estado = 1, 'SI', 'NO') AS estado")
								)
						->where(function ($query) use ($search){
								if($search['zona'] != "")
								{
								$query->where('tbl_zona.nombre', 'like', "%".$search['zona']."%");								
								}
								if($search['pais'] != "")
								{
								  $query->where('tbl_pais.id', '=', $search['pais']);																
								}
								if($search['estado'] != "")
								{
									$query->where('tbl_zona.estado','=', $search['estado']);								
								}else{
									$query->where('tbl_zona.estado',1);
								}
							})
						->skip($start)->take($end)						
						->orderBy($colum, $order)
						->orderBy("nombre","asc")
						->get();
	}
	
	public static function Zona($start,$end,$colum,$order){
		
		return ModelZona::join('tbl_pais','tbl_pais.id','tbl_zona.id_pais')
						  ->select('tbl_zona.id AS DT_RowId',
								'tbl_zona.nombre',
								'tbl_pais.nombre AS pais',
								\DB::raw("IF(tbl_zona.estado = 1, 'SI', 'NO') AS estado")
							)
						->where('tbl_zona.estado',1)
						->skip($start)->take($end)
						->orderBy($colum, $order)
						->orderBy("nombre","asc")
						->get();
	}

	public static function getCountZona($search){
		
		return ModelZona::join('tbl_pais','tbl_pais.id','tbl_zona.id_pais')
					->where(function ($query) use ($search){
						if($search['zona'] != "")
						{
						$query->where('tbl_zona.nombre', 'like', "%".$search['zona']."%");								
						}
						if($search['pais'] != "")
						{
						$query->where('tbl_pais.id', '=', $search['pais']);																
						}
						if($search['estado'] != "")
						{
							$query->where('tbl_zona.estado','=', $search['estado']);								
						}else{
							$query->where('tbl_zona.estado',1);
						}
					})->count();
	}

	public static function getZonaById($id){
		return ModelZona::join('tbl_pais','tbl_pais.id','tbl_zona.id_pais')
						->select('tbl_zona.id',
								'tbl_zona.nombre',
								'tbl_pais.id AS id_pais',
								\DB::raw("IF(tbl_zona.estado = 1, 'SI', 'NO') AS estado")
								)
								->where('tbl_zona.id',$id)
								->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_zona')->insert($dataSaved);		
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
			ModelZona::where('id',$id)->update($dataSaved);	
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

	public static function getZonaByPais($id){
		return ModelZona::select('id','nombre AS name', 'nombre')->where('id_pais', $id)->orderBy('tbl_zona.nombre', 'asc')->get();
	}

	public static function getSelectList()
	{
		return ModelZona::select('id','nombre AS name')->where('estado','1')->orderBy('tbl_zona.nombre', 'asc')->get();
	}

	public static function getSelectListByPaisParameter()
	{
		return ModelZona::join('tbl_parametro_general','tbl_parametro_general.id_pais','tbl_zona.id_pais')
						->select('tbl_zona.id',
								'tbl_zona.nombre AS name')
						->where('tbl_zona.estado','1')
						->orderBy('tbl_zona.nombre', 'asc')
						->get();
	}

	public static function getSelectListZonaPais($id){
		try
		{	
		return ModelZona::select('tbl_zona.id',
								 'tbl_zona.nombre AS name'
								)
							->where('tbl_zona.estado','1')
							->where('tbl_zona.id_pais',$id)
							->orderBy('tbl_zona.nombre', 'asc')
							->get();
		}catch(\Exception $e)
		{
			dd($e);
		}
	}

	public static function getSelectListZonaTienda($id){
		try
		{	

		return ModelTienda::select(
								'id',
								'nombre AS name'
								)
							->where('tbl_tienda.id_zona',$id)
							->orderBy('tbl_tienda.nombre', 'asc')
							->get();
		}catch(\Exception $e)
		{
			dd($e);
		}
	}
	
}
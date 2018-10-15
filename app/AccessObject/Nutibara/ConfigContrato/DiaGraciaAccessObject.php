<?php 

namespace App\AccessObject\Nutibara\ConfigContrato;

use App\Models\Nutibara\ConfigContrato\DiaGracia;

class DiaGraciaAccessObject {

    public static function DiaGracia($start,$end,$colum,$order){
		return DiaGracia::leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_dia_retroventa.id_tienda')
					->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_dia_retroventa.id_ciudad')
                    ->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_dia_retroventa.id_departamento')
                    ->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_dia_retroventa.id_pais')
					->select('tbl_contr_dia_retroventa.id AS DT_RowId',
					'tbl_contr_dia_retroventa.dias_gracia', 
					'tbl_pais.nombre as pais', 
					'tbl_departamento.nombre as departamento',
					'tbl_ciudad.nombre AS ciudad',
					'tbl_tienda.nombre AS tienda',
					\DB::raw("IF(tbl_contr_dia_retroventa.estado = 1, 'SI', 'NO') AS estado"))
					->where('tbl_contr_dia_retroventa.estado', '1')
					->skip($start)->take($end)									
					->orderBy($colum, $order)
					->get();
	}

    public static function DiaGraciaWhere($start,$end,$colum, $order,$search){

		return DiaGracia::leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_dia_retroventa.id_tienda')
					->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_dia_retroventa.id_ciudad')
                    ->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_dia_retroventa.id_departamento')
                    ->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_dia_retroventa.id_pais')
					->select('tbl_contr_dia_retroventa.id AS DT_RowId',
					'tbl_contr_dia_retroventa.dias_gracia',
					'tbl_pais.nombre as pais',
					'tbl_departamento.nombre as departamento',
					'tbl_ciudad.nombre AS ciudad',
					'tbl_tienda.nombre AS tienda',					
					\DB::raw("IF(tbl_contr_dia_retroventa.estado = 1, 'SI', 'NO') AS estado"))
					->where(function ($query) use ($search){
						if($search['estado'] != ""){
							$query->where('tbl_contr_dia_retroventa.estado', '=', $search['estado']);
						}
						if($search['tienda'] != ""){
							$query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
						}
						if($search['pais'] != ""){
							$query->where('tbl_pais.id', '=', $search['pais']);
						}
						if($search['departamento'] != ""){
							$query->where('tbl_departamento.id', '=', $search['departamento']);
						}
						if($search['ciudad'] != ""){
							$query->where('tbl_ciudad.id', '=', $search['ciudad']);
						}
					})
					->orderBy($colum, $order)
					->skip($start)->take($end)	
					->get();
	}

	public static function getCountDiaGracia($search){


		return DiaGracia::leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_dia_retroventa.id_tienda')
		->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_dia_retroventa.id_ciudad')
		->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_dia_retroventa.id_departamento')
		->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_dia_retroventa.id_pais')
		->where(function ($query) use ($search){
			if($search['estado'] != ""){
				$query->where('tbl_contr_dia_retroventa.estado', '=', $search['estado']);
			}
			if($search['tienda'] != ""){
			$query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
			}
			if($search['departamento'] != ""){
			$query->where('tbl_departamento.id', 'like', "%".$search['departamento']."%");
			}
			if($search['ciudad'] != ""){
			$query->where('tbl_ciudad.id', 'like', "%".$search['ciudad']."%");
			}
			if($search['pais'] != ""){
				$query->where('tbl_pais.id', '=', $search['pais']);
			}
		})
		->count();
	}

    public static function getDiaGraciaById($id){
		return DiaGracia::leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_dia_retroventa.id_tienda')
						->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_dia_retroventa.id_ciudad')
						->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_dia_retroventa.id_departamento')
						->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_dia_retroventa.id_pais')
						->select(
							'tbl_tienda.id as id_tienda',
							'tbl_pais.id as id_pais',
							'tbl_departamento.id as id_departamento',
							'tbl_ciudad.id as id_ciudad',
							'tbl_contr_dia_retroventa.id',
							'tbl_contr_dia_retroventa.dias_gracia'
						)
						->where('tbl_contr_dia_retroventa.id',$id)->first();
	}

    public static function Create($table,$dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table($table)->insert($dataSaved);
			\DB::commit();
		}catch(\Exception $e){

			dd($e);
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

    public static function update($id,$dataSaved){	
		$result="Actualizado";
		try
		{
			DiaGracia::where('id',$id)->update($dataSaved);	
		}
		catch(\Exception $e)
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

	public static function delete($id){	
		return DiaGracia::where('id',$id)->delete();	
	}

}
<?php 

namespace App\AccessObject\Nutibara\Pais;

use App\Models\Nutibara\Pais\Pais AS ModelPais;
use DB;
class Pais 
{
	public static function PaisWhere($start,$end,$colum, $order,$search){
		return ModelPais::select(
									'id AS DT_RowId',
									'nombre',
									'abreviatura',
									'codigo_telefono',
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

	public static function Pais($start,$end,$colum,$order){
		return ModelPais::select(
									'id AS DT_RowId',
									'nombre',
									'abreviatura',
									'codigo_telefono',
									\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado"))
						->where('estado',1)
						->skip($start)->take($end)
						->orderBy($colum, $order)
						->get();
	}

	public static function getCountPais($start,$end,$colum, $order,$search){
		return ModelPais::where(function ($query) use ($search){
			$query->where('nombre', 'like', "%".$search['name']."%");
			$query->where('estado','=', $search['estado']);
		})
		->count();
	}

	public static function getPaisById($id){
		return ModelPais::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_pais')->insert($dataSaved);		
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
			ModelPais::where('id',$id)->update($dataSaved);	
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

	public static function getPais(){
		return ModelPais::select('id','nombre AS name')->where('estado','1')->orderBy('nombre', 'ASC')->get();
	}

	public static function getSelectList(){
		return ModelPais::select('id',DB::raw('UPPER(nombre) AS name'))->where('estado','1')->orderBy('tbl_pais.nombre', 'asc')->get();
	}
	
	public static function getInputIndicativo($id)
	{
		return ModelPais::select('id','codigo_telefono AS name')->where('id',$id)->first();
	}

	public static function getSelectListPais($id){
		return ModelPais::join('tbl_departamento','tbl_departamento.id_Pais','tbl_pais.id')
							->select('tbl_departamento.id',
									 'tbl_departamento.nombre As name'
									 )
							->where('tbl_departamento.estado','1')
							->where('tbl_pais.id',$id)
							->orderBy('tbl_pais.nombre', 'asc')
							->get();
	}

	public static function getSelectListPaisByName($nombre){
		return ModelPais::join('tbl_departamento','tbl_departamento.id_Pais','tbl_pais.id')
							->select('tbl_departamento.id',
									 'tbl_departamento.nombre As name'
									 )
							->where('tbl_departamento.estado','1')
							->where('tbl_pais.nombre','like','%'.$nombre.'%')
							->orderBy('tbl_departamento.nombre', 'asc')
							->get();
	}

	public static function getSelectListPaisSociedad($id)
	{
		try
		{	
		return ModelPais::join('tbl_sociedad','tbl_pais.id','tbl_sociedad.id_pais')
							->select('tbl_sociedad.id',
									 'tbl_sociedad.nombre AS name'
									 )
							->where('tbl_sociedad.estado','1')
							->where('tbl_pais.id',$id)
							->orderBy('tbl_sociedad.nombre', 'asc')
							->get();
		}catch(\Exception $e)
		{
			dd($e);
		}
	}
}
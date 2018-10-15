<?php 

namespace App\AccessObject\Nutibara\Ciudad;

use App\Models\Nutibara\Ciudad\Ciudad AS ModelCiudad;
use DB;

class Ciudad 
{
	public static function CiudadWhere($start,$end,$colum, $order,$search)
	{
		return ModelCiudad::join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
						->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						->select('tbl_ciudad.id AS DT_RowId',
						'tbl_ciudad.nombre',
						'tbl_departamento.nombre AS departamento',
						'tbl_pais.nombre AS pais',
						'tbl_ciudad.codigo_dane',
						\DB::raw("IF(tbl_ciudad.estado = 1, 'SI', 'NO') AS estado")
						)
						->where(function ($query) use ($search){
							$query->where('tbl_ciudad.nombre', 'like', "%".$search['ciudad']."%");
							$query->where('tbl_departamento.id', 'like', "%".$search['departamento']."%");
							$query->where('tbl_pais.id', 'like', "%".$search['pais']."%");
							$query->where('tbl_ciudad.codigo_dane','like','%'.$search['codigo_dane'].'%');
							$query->where('tbl_ciudad.estado','=', $search['estado']);
						})
						->skip($start)->take($end)						
						->orderBy($colum, $order)
						->get();
	}

	public static function Ciudad($start,$end,$colum,$order){
		return ModelCiudad::join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
								->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
								->select('tbl_ciudad.id AS DT_RowId',
								'tbl_ciudad.nombre',
								'tbl_departamento.nombre AS departamento',
								'tbl_pais.nombre AS pais',
								'tbl_ciudad.codigo_dane',
								\DB::raw("IF(tbl_ciudad.estado = 1, 'SI', 'NO') AS estado")
								)
						->where('tbl_ciudad.estado',1)
						->skip($start)->take($end)
						->orderBy($colum, $order)
						->get();
	}

	public static function getCountCiudad($search){

		return ModelCiudad::join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
							->where(function ($query) use ($search){
								$query->where('tbl_ciudad.nombre', 'like', "%".$search['ciudad']."%");
								$query->where('tbl_departamento.id', 'like', "%".$search['departamento']."%");
								$query->where('tbl_pais.id', 'like', "%".$search['pais']."%");
								$query->where('tbl_ciudad.codigo_dane', 'like', '%'.$search['codigo_dane'].'%');
								$query->where('tbl_ciudad.estado','=', $search['estado']);
							})->count();
	}

	public static function getCiudadById($id){
		return ModelCiudad::join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->select(
									'tbl_ciudad.id',
									'tbl_ciudad.nombre',
									'tbl_ciudad.id_departamento',
									'tbl_departamento.id_pais',
									'tbl_ciudad.codigo_dane',
									'tbl_ciudad.estado'
									)
							->where('tbl_ciudad.id',$id)->first();
	}

	public static function Create($dataSaved)
	{
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_ciudad')->insert($dataSaved);		
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
			ModelCiudad::where('id',$id)->update($dataSaved);	
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

	public static function getCiudadByDepartamento($id){
		return ModelCiudad::select('id','nombre AS name', 'nombre')->where('id_departamento', $id)->where('estado','1')->orderBy('nombre', 'asc')->get();
	}

	public static function getCiudadByPais($id){
		return ModelCiudad::select('tbl_ciudad.id',DB::raw('UPPER(tbl_ciudad.nombre) AS name'), 'tbl_ciudad.nombre')
							->join('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_ciudad.id_departamento')
							->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_departamento.id_pais')
							->where('tbl_pais.id', $id)->where('tbl_ciudad.estado','1')->orderBy('tbl_ciudad.nombre', 'asc')->get();
	}

	public static function getSelectList(){
		return ModelCiudad::select('id',DB::raw('UPPER(nombre) AS name'))->where('estado','1')->orderBy('tbl_ciudad.nombre')->get();
	}

	public static function getSelectListCiudadSociedad($id)
	{
		try
		{	
		return ModelCiudad::join('tbl_sociedad','tbl_ciudad.id','tbl_sociedad.id_ciudad')
							->select('tbl_sociedad.id','tbl_sociedad.nombre AS name')
							->where('tbl_sociedad.estado','1')
							->where('tbl_ciudad.id',$id)
							->get();
		}catch(\Exception $e)
		{
			dd($e);
		}
	}

	public static function getInputIndicativo($id)
	{
		return ModelCiudad::join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
							->select('tbl_departamento.id',
									 DB::raw('concat("+",tbl_pais.codigo_telefono) AS name')
									) 
							->where('tbl_ciudad.id',$id)->first();
	}

	public static function getInputIndicativo2($id)
	{
		return ModelCiudad::join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
							->select('tbl_departamento.id',
									 DB::raw('concat("+",tbl_pais.codigo_telefono," ",tbl_departamento.indicativo_departamento) AS name')
									) 
							->where('tbl_ciudad.id',$id)->first();
	}

	public static function getSelectListCiudadbyNombre($id_pais,$nombre){
		return ModelCiudad::join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
					->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
					->select('tbl_ciudad.nombre')
					->where('tbl_pais.id',$id_pais)
					->where('tbl_ciudad.nombre','LIKE','%'.$nombre.'%')
					->get();
	}
}
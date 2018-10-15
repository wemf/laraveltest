<?php 

namespace App\AccessObject\Nutibara\Departamento;
use App\Models\Nutibara\Departamento\Departamento AS ModelDepartamento;

class Departamento 
{
	public static function DepartamentoWhere($start,$end,$colum, $order,$search){
		return ModelDepartamento::join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
								->select(
									'tbl_departamento.id AS DT_RowId',
									'tbl_departamento.nombre',
									'tbl_departamento.codigo_dane',
									'tbl_departamento.indicativo_departamento',
									'tbl_pais.nombre AS pais',
									\DB::raw("IF(tbl_departamento.estado = 1, 'SI', 'NO') AS estado")
									)
								->where(function ($query) use ($search){
									$query->where('tbl_departamento.nombre', 'like', "%".$search['departamento']."%");
									if($search['pais'] != "")
									{
									$query->where('tbl_pais.id', '=', $search['pais']);									
									} 
									$query->where('tbl_departamento.estado','like', "%".$search['estado']."%");
								})
								->skip($start)->take($end)														
								->orderBy($colum, $order)
								->orderBy("nombre","asc")
								->get();
	}

	public static function Departamento($start,$end,$colum,$order){
		return ModelDepartamento::join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						->select(
							'tbl_departamento.id AS DT_RowId',
							'tbl_departamento.nombre',
							'tbl_departamento.codigo_dane',
							'tbl_departamento.indicativo_departamento',							
							'tbl_pais.nombre AS pais',
							\DB::raw("IF(tbl_departamento.estado = 1, 'SI', 'NO') AS estado")
							)
						->where('tbl_departamento.estado',1)
						->skip($start)->take($end)
						->orderBy($colum, $order)
						->orderBy("nombre","asc")
						->get();
	}

	public static function getCountDepartamento($search){
		
		return ModelDepartamento::join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
												->where(function ($query) use ($search){
													$query->where('tbl_departamento.nombre', 'like', "%".$search['departamento']."%");
													if($search['pais'] != "")
													{
													$query->where('tbl_pais.id', '=', $search['pais']);									
													} 
													$query->where('tbl_departamento.estado','like', "%".$search['estado']."%");
												})
												->where('tbl_departamento.estado',($search['estado']=="")?1:(int)$search['estado'])
												->count();
	}

	public static function getDepartamentoById($id){
		return ModelDepartamento::where('id',$id)->first();
	}

	public static function getDepartamentoByPais($id){
		return ModelDepartamento::select('id', 'nombre as name', 'nombre')->where('estado', '1')->where('id_pais',$id)->orderBy('nombre', 'ASC')->get();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_departamento')->insert($dataSaved);		
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
			ModelDepartamento::where('id',$id)->update($dataSaved);	
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

	public static function getSelectList(){
		return ModelDepartamento::select('id','nombre AS name')->where('estado','1')->orderBy('nombre', 'asc')->get();
	}

	public static function getSelectListDepartamento($id){
		return ModelDepartamento::join('tbl_ciudad','tbl_ciudad.id_departamento','tbl_departamento.id')
							->select('tbl_ciudad.id','tbl_ciudad.nombre AS name')
							->where('tbl_ciudad.estado','1')
							->where('tbl_departamento.id',$id)
							->get();
	}
}
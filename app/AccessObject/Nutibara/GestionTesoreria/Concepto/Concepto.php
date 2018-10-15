<?php 

namespace App\AccessObject\Nutibara\GestionTesoreria\Concepto;

use App\Models\Nutibara\GestionTesoreria\Concepto\Concepto AS ModelConcepto;
use DB;

class Concepto 
{
	public static function ConceptoWhere($start,$end,$colum, $order,$search){

		if($search['estado'] == "")
		$search['estado'] = 1;


		return ModelConcepto::join('tbl_pais','tbl_pais.id','tbl_tes_concepto.id_pais')
							->leftjoin('tbl_tes_tipo_documento_contable','tbl_tes_tipo_documento_contable.id','tbl_tes_concepto.id_tipo_documento_contable')
							->select(
									'tbl_tes_concepto.id AS DT_RowId',
									'tbl_tes_tipo_documento_contable.nombre AS tipo_documento_contable' ,
									'tbl_tes_concepto.nombre',
									'tbl_tes_concepto.codigo',
									'tbl_pais.nombre as pais',
									DB::raw("IF(tbl_tes_concepto.estado = 1, 'Si', 'No') AS estado")
								)
								->where(function ($query) use ($search){
									if($search['id_pais'] != "")
									$query->where('tbl_tes_concepto.id_pais', 'like', '%'.$search['id_pais'].'%');

									if($search['codigo'] != "")
									$query->where('tbl_tes_concepto.codigo', 'like', '%'.$search['codigo'].'%');

									if($search['nombre'] != "")
									$query->where('tbl_tes_concepto.nombre', 'like', '%'.$search['nombre'].'%');
								})
								->where('tbl_tes_concepto.estado',$search['estado'])
								->where('impuesto',0)
								->skip($start)->take($end)
								->orderBy($colum, $order)
								->get();
	}

	public static function Concepto($start,$end,$colum,$order){
		return ModelConcepto::join('tbl_pais','tbl_pais.id','tbl_tes_concepto.id_pais')
						->select(
								'tbl_tes_concepto.id AS DT_RowId',
								'tbl_tes_concepto.nombre',
								'tbl_tes_concepto.codigo',
								'tbl_pais.nombre as pais',
								DB::raw("IF(tbl_tes_concepto.estado = 1, 'Si', 'No') AS estado")
							)
						->where('tbl_tes_concepto.estado',1)
						->where('impuesto',0)											
						->get();
	}

	public static function getCountConcepto($search){
		if($search['estado'] == "")
		$search['estado'] = 1;
		return ModelConcepto::join('tbl_pais','tbl_pais.id','tbl_tes_concepto.id_pais')
							->where(function ($query) use ($search)
							{
								if($search['id_pais'] != "")
									$query->where('tbl_tes_concepto.id_pais', 'like', '%'.$search['id_pais'].'%');

								if($search['codigo'] != "")
									$query->where('tbl_tes_concepto.codigo', 'like', '%'.$search['codigo'].'%');

								if($search['nombre'] != "")
									$query->where('tbl_tes_concepto.nombre', 'like', '%'.$search['nombre'].'%');
							})
							->where('tbl_tes_concepto.estado',$search['estado'])
							->where('impuesto',0)->count();
	}

	public static function getConceptoById($id){
		return ModelConcepto::join('tbl_pais','tbl_pais.id','tbl_tes_concepto.id_pais')
											->select(
													'tbl_tes_concepto.id_tipo_documento_contable',
													'tbl_tes_concepto.id',
													'tbl_tes_concepto.nombre',
													'tbl_tes_concepto.codigo',
													'tbl_tes_concepto.naturaleza',
													'tbl_tes_concepto.id_contracuenta',
													'tbl_pais.nombre as pais',
													DB::raw("IF(tbl_tes_concepto.estado = 1, 'Si', 'No') AS estado")
												)
											->where('tbl_tes_concepto.id',$id)
											->where('impuesto',0)											
											->first();
	}

	public static function Create($data,$asociaciones){
		$result="Insertado";
		try{
			DB::beginTransaction();
			$id_concepto = ModelConcepto::insertGetId($data);
			self::CreateAsociaciones($id_concepto,$asociaciones);
			DB::commit();
		}catch(\Exception $e){
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
			DB::rollback();
		}
		return $result;
	}

	public static function CreateAsociaciones($id_concepto,$asociaciones)
	{
		\DB::table('tbl_sys_concepto_impuesto')
		->where('id_concepto',$id_concepto)
		->delete();

		if($asociaciones[0]!='Objetovacio')
		{	
		for ($i=0; $i < count($asociaciones) ; $i++) { 
			$asociados[$i]['id_concepto'] = $id_concepto;
			$asociados[$i]['id_impuesto'] = $asociaciones[$i];
		}
		DB::table('tbl_sys_concepto_impuesto')->insert($asociados);
		}
	}

	public static function getConcepto(){
		return ModelConcepto::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectListImpuesto(){
		return ModelConcepto::select('id','nombre AS name')->where('estado','1')->where('impuesto','1')->get();
	}
	
	public static function getSelectListTipoDocumentoContable()
	{
		return DB::table('tbl_tes_tipo_documento_contable')
					->select('id','nombre AS name')
					->get();
	}

	public static function ImpuestoConcepto($id_concepto){
		
		return DB::table('tbl_sys_concepto_impuesto')
							->select(
									'id_impuesto AS id_asociar',
									'id_concepto'
									)
							->where('id_concepto',$id_concepto)
						    ->get();
	}

	public static function ActualizarImpuestoConcepto($id_concepto,$asociaciones,$dataSaved)
    {
		$result="Actualizado";		
		try{
			\DB::beginTransaction();
			ModelConcepto::where('id',$id_concepto)->update($dataSaved);
			\DB::table('tbl_sys_concepto_impuesto')->where('id_concepto',$id_concepto)->delete();	
			self::CreateAsociaciones($id_concepto,$asociaciones);
			\DB::commit();
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
			\DB::rollback();
		}
		
		return $result;
	}

	public static function getSelectListCodigo($id){
		if($id == 1)
			$id = 0;
		else
			$id = 1;
			
		return ModelConcepto::select('id','codigo AS name')
		->where('estado','1')
		->where('naturaleza',$id)
		->where('impuesto',0)
		->get();
	}

	public static function getSelectListNombre($id){
		if($id == 1)
			$id = 0;
		else
			$id = 1;

		return ModelConcepto::select('id','nombre AS name')
		->where('estado','1')
		->where('naturaleza',$id)
		->where('impuesto',0)
		->get();
	}
}
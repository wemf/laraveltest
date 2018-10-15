<?php 

namespace App\AccessObject\Nutibara\GestionTesoreria\Impuesto;

use App\Models\Nutibara\GestionTesoreria\Impuesto\Impuesto AS ModelImpuesto;
use App\Models\Nutibara\GestionTesoreria\Concepto\Concepto AS ModelConcepto;
use DB;

class Impuesto 
{
	public static function ImpuestoWhere($start,$end,$colum, $order,$search)
	{
		return ModelImpuesto::select(
									'tbl_tes_impuesto.id AS DT_RowId',					
									'tbl_tes_impuesto.nombre'									
									)
									->where(function ($query) use ($search){
										$query->where('tbl_tes_impuesto.nombre', 'like', "%".$search['nombre']."%");
									})		
									->skip($start)->take($end)
									->orderBy($colum, $order)
									->get();
	}

	public static function getCountImpuesto($search){
		return ModelImpuesto::where(function ($query) use ($search)
								{
									$query->where('tbl_tes_impuesto.nombre', 'like', "%".$search['nombre']."%");
								})
								->count();
	}

	public static function getImpuestoById($id){
		return ModelImpuesto::select(
			'tbl_tes_impuesto.id',					
			'tbl_tes_impuesto.nombre'									
			)
		->where('tbl_tes_impuesto.id',$id)->first();
	}

	public static function Create($dataSaved)
	{
		$result="Insertado";
		try{
			DB::beginTransaction();
			ModelImpuesto::insert(['nombre'=>$dataSaved['nombre']]);		
			DB::commit();
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
			DB::rollback();
		}
		return $result;
	}

	public static function Update($id,$dataSaved){	
		$result="Actualizado";
		try
		{
			ModelImpuesto::where('id',$id)->update($dataSaved);	
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

	public static function getSelectList(){
		return ModelImpuesto::select('id','nombre AS name')->where('estado','1')->get();
	}
}
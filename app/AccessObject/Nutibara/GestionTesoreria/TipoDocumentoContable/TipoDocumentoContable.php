<?php 

namespace App\AccessObject\Nutibara\GestionTesoreria\TipoDocumentoContable;

use App\Models\Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContable AS ModelTipoDocumentoContable;
use App\Models\Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContable AS ModelConfiguracionContable;
use DB;

class TipoDocumentoContable 
{
	public static function TipoDocumentoContableWhere($start,$end,$colum, $order,$search)
	{
		$search['estado'] = ($search['estado'] == "") ? "1" : $search['estado'];

		return ModelTipoDocumentoContable::select(
										'tbl_cont_tipo_documento_contable.id AS DT_RowId',
										'tbl_cont_tipo_documento_contable.nombre',
										\DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")																			
										)
									->where(function ($query) use ($search){							
										$query->where('tbl_cont_tipo_documento_contable.nombre', 'like', "%".$search['nombre']."%");
										$query->where('tbl_cont_tipo_documento_contable.estado', $search['estado']);
									})		
									->skip($start)->take($end)
									->orderBy($colum, $order)
									->get();
	}

	public static function getCountTipoDocumentoContable($search){
		
		$search['estado'] = ($search['estado'] == "") ? "1" : $search['estado'];		
		return ModelTipoDocumentoContable::where(function ($query) use ($search){							
												$query->where('tbl_cont_tipo_documento_contable.nombre', 'like', "%".$search['nombre']."%");
												$query->where('tbl_cont_tipo_documento_contable.estado', $search['estado']);												
											})	
											->count();
	}

	public static function getTipoDocumentoContableById($id){
		return ModelTipoDocumentoContable::select(
			'tbl_cont_tipo_documento_contable.id',									
			'tbl_cont_tipo_documento_contable.nombre'										
			)
		->where('tbl_cont_tipo_documento_contable.id',$id)->first();
	}

	public static function Create($dataSaved)
	{

		$result="Insertado";
		try{
			DB::beginTransaction();
			ModelTipoDocumentoContable::insert([$dataSaved]);		
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

	public static function Update($id,$dataSaved){	
		$result="Actualizado";
		try
		{
			ModelTipoDocumentoContable::where('id',$id)->update($dataSaved);	
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
		return ModelTipoDocumentoContable::select('id','nombre AS name')
			->where('estado', 1)
			->orderBy('name','asc')
			->get();
	}
}
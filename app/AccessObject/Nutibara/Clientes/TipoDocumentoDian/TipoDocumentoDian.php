<?php 

namespace App\AccessObject\Nutibara\Clientes\TipoDocumentoDian;

use App\Models\Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDian AS ModelTipoDocumentoDian;


class TipoDocumentoDian 
{
	public static function TipoDocumentoDianWhere($start,$end,$colum, $order,$search){
		return ModelTipoDocumentoDian::join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_clie_tipo_documento_dian.id_tipo_documento')
						->select(
								'tbl_clie_tipo_documento_dian.id AS DT_RowId',
								'tbl_clie_tipo_documento.nombre_abreviado',
								'tbl_clie_tipo_documento_dian.nombre AS nombre',
								'tbl_clie_tipo_documento_dian.digito_verificacion',
								\DB::raw("IF(tbl_clie_tipo_documento_dian.estado = 1, 'SI', 'NO') AS estado")
								)
						->where(function ($query) use ($search){
								$query->where('tbl_clie_tipo_documento_dian.nombre', 'like', "%".$search['nombre']."%");
								$query->where('tbl_clie_tipo_documento.nombre_abreviado', 'like', "%".$search['nombre_abreviado']."%");
								$query->where('tbl_clie_tipo_documento_dian.estado', '=',$search['estado']);
							})
						->skip($start)->take($end)							
						->orderBy($colum, $order)
						->get();
	}

	public static function TipoDocumentoDian($start,$end,$colum,$order){
		return ModelTipoDocumentoDian::join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_clie_tipo_documento_dian.id_tipo_documento')
							->select(
								'tbl_clie_tipo_documento_dian.id AS DT_RowId',
								'tbl_clie_tipo_documento.nombre_abreviado',
								'tbl_clie_tipo_documento_dian.nombre AS nombre',
								'tbl_clie_tipo_documento_dian.digito_verificacion',
								\DB::raw("IF(tbl_clie_tipo_documento_dian.estado = 1, 'SI', 'NO') AS estado")
								)
							->where('tbl_clie_tipo_documento_dian.estado',1)	
							->skip($start)->take($end)
							->orderBy($colum, $order)
						    ->get();
	}

	public static function getCountTipoDocumentoDian(){
		return ModelTipoDocumentoDian::where('estado', '1')->count();
	}

	public static function getTipoDocumentoDianById($id){
		return ModelTipoDocumentoDian::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_tipo_documento_dian')->insert($dataSaved);		
			\DB::commit();
		}
		catch(\Exception $e){
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
			ModelTipoDocumentoDian::where('id',$id)->update($dataSaved);	
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
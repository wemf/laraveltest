<?php 

namespace App\AccessObject\Nutibara\Clientes\TipoDocumento;

use App\Models\Nutibara\Clientes\TipoDocumento\TipoDocumento AS ModelTipoDocumento;
use DB;
class TipoDocumento 
{
	public static function TipoDocumentoWhere($start,$end,$colum, $order,$search){
		return ModelTipoDocumento::select(
								'id AS DT_RowId',
                                'nombre_abreviado',
								'nombre AS nombre',
								'codigo_dian AS codigo_dian',
								DB::raw("IF(alfanumerico = 1, 'SI', 'NO') AS alfanumerico"),
								DB::raw("IF(contrato = 1, 'SI', 'NO') AS contrato"),
								DB::raw("IF(venta = 1, 'SI', 'NO') AS venta"),
								DB::raw("IF(digito_verificacion = 1, 'SI', 'NO') AS digito"),
								DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
						->where(function ($query) use ($search){
								$query->where('nombre', 'like', "%".$search['nombre']."%");
                                $query->where('nombre_abreviado', 'like', "%".$search['nombre_abreviado']."%");
								$query->where('estado', '=', $search['estado']);
							})
						->skip($start)->take($end)
						->orderBy($colum, $order)
						->get();
	}

	public static function TipoDocumento($start,$end,$colum,$order){
		return ModelTipoDocumento::select(
								'id AS DT_RowId',
                                'nombre_abreviado',
								'nombre AS nombre',
								'codigo_dian AS codigo_dian',								
								DB::raw("IF(alfanumerico = 1, 'SI', 'NO') AS alfanumerico"),
								DB::raw("IF(contrato = 1, 'SI', 'NO') AS contrato"),
								DB::raw("IF(venta = 1, 'SI', 'NO') AS venta"),
								DB::raw("IF(digito_verificacion = 1, 'SI', 'NO') AS digito_verificacion"),
								DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
								->where('estado',1)	
								->skip($start)->take($end)
								->orderBy($colum, $order)
						        ->get();
	}

	public static function getCountTipoDocumento($search){
		return ModelTipoDocumento::where(function ($query) use ($search){
			$query->where('nombre', 'like', "%".$search['nombre']."%");
			$query->where('nombre_abreviado', 'like', "%".$search['nombre_abreviado']."%");
			$query->where('estado', '=', ($search['estado']=="")?1:$search['estado']);
		})->count();
	}

	public static function getTipoDocumento(){
		return ModelTipoDocumento::where('estado', '1')->get();
	}

	public static function getTipoDocumentoById($id){
		return ModelTipoDocumento::where('id',$id)->first();
	}
	public static function getSelectList(){
		return ModelTipoDocumento::select('id','nombre_abreviado AS name')->where('estado','1')->orderBy('nombre','asc')->get();
		
	}

	public static function getSelectList2(){
		return ModelTipoDocumento::select('id','nombre AS name', 'nombre_abreviado')->where('estado','1')->orderBy('nombre','asc')->get();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			DB::beginTransaction();
			DB::table('tbl_clie_tipo_documento')->insert($dataSaved);		
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
			ModelTipoDocumento::where('id',$id)->update($dataSaved);	
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
			dd($e);
		}
		return $result;
	}

	public static function getAlfanumerico($id){
		return ModelTipoDocumento::select('alfanumerico')->where('id',$id)->first();
	}

	public static function getTipoDocumentoProveedor()
	{
		return ModelTipoDocumento::select('id','nombre as name')->whereIn('id',['1','32'])->get();
	}

}
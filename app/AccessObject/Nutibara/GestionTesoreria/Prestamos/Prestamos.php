<?php 

namespace App\AccessObject\Nutibara\GestionTesoreria\Prestamos;

use App\Models\Nutibara\GestionTesoreria\Prestamos\Prestamos AS ModelPrestamos;
use DB;

class Prestamos 
{
	public static function PrestamosWhere($start,$end,$colum, $order,$search)
	{
		return ModelPrestamos::join('tbl_tienda','tbl_tienda.id','tbl_tes_prestamos.id_tienda_presta')
									->join('tbl_usuario','tbl_usuario.id','tbl_tes_prestamos.id_usuario')
									->select(
									DB::raw('concat(tbl_tes_prestamos.id,"/",tbl_tes_prestamos.id_tienda) AS DT_RowId'),
                                    'sociedad_prestadora',
									'tbl_tienda.nombre AS tienda_presta',									
									'name AS usuario',
									'fecha_pago AS fecha',
									DB::raw("CONCAT('$ ', FORMAT(tbl_tes_prestamos.valor,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor")
									)
									->where(function ($query) use ($search){
                                        if($search['sociedad_prestadora'] <> "")
										$query->where('sociedad_prestadora',$search['sociedad_prestadora']);
										if($search['id_tienda_presta'] <> "")
										$query->where('id_tienda_presta',$search['id_tienda_presta']);										
                                        if($search['id_tienda'] <> "")
                                        $query->where('id_tienda',$search['id_tienda']);
									})		
									->skip($start)->take($end)
									->orderBy($colum, $order)
									->get();
	}

	public static function getCountPrestamos($search){
		return ModelPrestamos::join('tbl_tienda','tbl_tienda.id','tbl_tes_prestamos.id_tienda')
									->join('tbl_usuario','tbl_usuario.id','tbl_tes_prestamos.id_usuario')
									->where(function ($query) use ($search){
                                    if($search['sociedad_prestadora'] <> "")
                                    $query->where('sociedad_prestadora',$search['sociedad_prestadora']);
                                    if($search['id_tienda'] <> "")
                                    $query->where('id_tienda',$search['id_tienda']);
                                })
								->count();
	}

	public static function getPrestamosById($id){
		return ModelPrestamos::select(
			'tbl_tes_Prestamos.id',					
			'tbl_tes_Prestamos.nombre'									
			)
		->where('tbl_tes_Prestamos.id',$id)->first();
	}

	public static function Create($dataSaved)
	{
		$result="Insertado";
		try{
			DB::beginTransaction();
			ModelPrestamos::insert($dataSaved);		
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
			dd($e);			
		}
		return $result;
	}

	public static function Update($id,$dataSaved){	
		$result="Actualizado";
		try
		{
			ModelPrestamos::where('id',$id)->update($dataSaved);	
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
		return ModelPrestamos::select('id','nombre AS name')->where('estado','1')->get();
	}
}
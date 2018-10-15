<?php 

namespace App\AccessObject\Nutibara\Products;

use App\Models\Nutibara\Products\Reference;
use App\Models\FormMotor\FormDefiner;
use DB;


class AdminReferenceAccessObject {


	public static function ReferencesWhere($start,$end,$colum, $order,$search){
		return Reference::join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','=','tbl_prod_catalogo.id_categoria')
							->select(
								'tbl_prod_catalogo.id AS DT_RowId',
								'tbl_prod_catalogo.descripcion',
								'tbl_prod_catalogo.nombre as nombreprod',
								'tbl_prod_categoria_general.nombre as categoria',
								'tbl_prod_catalogo.vigencia_desde',
								'tbl_prod_catalogo.vigencia_hasta',
								DB::raw("IF(tbl_prod_catalogo.estado = 1, 'SI', 'NO') AS estado"),
								DB::raw("IF(tbl_prod_catalogo.genera_contrato = 1, 'SI', 'NO') AS genera_contrato"),
								DB::raw("IF(tbl_prod_catalogo.genera_venta = 1, 'SI', 'NO') AS genera_venta")
							)					
							->where(function ($query) use ($search){
								$query->where('tbl_prod_catalogo.nombre', 'like', "%".$search['refName']."%");
								$query->where('tbl_prod_categoria_general.nombre', 'like', "%".$search['catName']."%");
								$query->where('tbl_prod_catalogo.estado', '=', $search["estado"]);
							})
							->skip($start)->take($end)							
							->orderBy('tbl_prod_categoria_general.nombre','ASC')
							->orderBy('tbl_prod_catalogo.nombre','ASC')
							->orderBy('tbl_prod_catalogo.descripcion','ASC')
							->get();
	}

	public static function References($start,$end,$colum,$order){
		return Reference::join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','=','tbl_prod_catalogo.id_categoria')
							->select(
								'tbl_prod_catalogo.id AS DT_RowId',
								'tbl_prod_catalogo.descripcion',
								'tbl_prod_catalogo.nombre as nombreprod',
								'tbl_prod_categoria_general.nombre as categoria',
								'tbl_prod_catalogo.vigencia_desde',
								'tbl_prod_catalogo.vigencia_hasta',
								DB::raw("IF(tbl_prod_catalogo.estado = 1, 'SI', 'NO') AS estado"),
								DB::raw("IF(tbl_prod_catalogo.genera_contrato = 1, 'SI', 'NO') AS genera_contrato"),
								DB::raw("IF(tbl_prod_catalogo.genera_venta = 1, 'SI', 'NO') AS genera_venta")
							)
							->where('tbl_prod_catalogo.estado', '1')
							->skip($start)->take($end)
							->orderBy('tbl_prod_categoria_general.nombre','ASC')
							->orderBy('tbl_prod_catalogo.nombre','ASC')
							->orderBy('tbl_prod_catalogo.descripcion','ASC')
							->get();
	}

	public static function getCountReferences($search){
		return Reference::join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','=','tbl_prod_catalogo.id_categoria')
						->where(function ($query) use ($search){
							$query->where('tbl_prod_catalogo.nombre', 'like', "%".$search['refName']."%");
							$query->where('tbl_prod_categoria_general.nombre', 'like', "%".$search['catName']."%");
							$query->where('tbl_prod_catalogo.estado', '=', $search["estado"]);
						})
						->count();
	}

	public static function getReferenceById($id){
		return Reference::where('id',$id)->first();
	}

	public static function getReferenceValueById($id)
	{
		return Reference::join('tbl_prod_atributo_valores','tbl_prod_atributo_valores.id_atributo','=','tbl_prod_atributo.id_atributo_padre')
					->select('tbl_prod_atributo_valores.id','tbl_prod_atributo_valores.nombre')
					->where('tbl_prod_atributo_valores.estado','1')
					->where('tbl_prod_atributo.id',$id)
					->get();
	}

	public static function getbyid($id){
		return (Reference::join('tbl_prod_referencia', 'tbl_prod_referencia.id_referencia', 'tbl_prod_catalogo.id')
		->join('tbl_prod_atributo_valores', 'tbl_prod_atributo_valores.id', 'tbl_prod_referencia.id_valor_atributo')
		->select(DB::raw("GROUP_CONCAT(tbl_prod_atributo_valores.nombre SEPARATOR ' ') as nombre_referencia"))
		->where('tbl_prod_catalogo.id', $id)
		->first());
	}

	public static function getAttributesValuesById( $id ) {
		return Reference::join('tbl_prod_referencia', 'tbl_prod_referencia.id_referencia', '=', 'tbl_prod_catalogo.id')
						->select('tbl_prod_referencia.id_valor_atributo')
						->get();
	}


	public static function Create( $table, $dataSaved, $attributes ){
		$result="Insertado";
		try{
			DB::beginTransaction();
			$id = DB::table($table)->insertGetId($dataSaved);

			for($i = 0; $i < count($attributes); $i++){
				$attributes[$i]['id_referencia'] = $id;
			}

			DB::table("tbl_prod_referencia")->insert($attributes);
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

	public static function update($id,$dataSaved, $attributes){
		$result="Actualizado";
		try
		{
			DB::beginTransaction();
			Reference::where('id',$id)->update($dataSaved);	
			DB::table("tbl_prod_referencia")->where('id_referencia', $id)->delete();
			for($i = 0; $i < count($attributes); $i++){
				$attributes[$i]['id_referencia'] = $id;
			}

			DB::table("tbl_prod_referencia")->insert($attributes);
			DB::commit();
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
			DB::rollback();
		}
		return $result;
	}

	public static function updateBasic($id,$dataSaved){
		$result="Actualizado";
		try
		{
			DB::beginTransaction();	
			Reference::where('id',$id)->update($dataSaved);
			DB::commit();
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
			DB::rollback();
		}
		return $result;
	}

	public static function delete($id){	
		DB::table('tbl_prod_referencia')->where('id_referencia',$id)->delete();
		return Reference::where('id',$id)->delete();
	}

	public static function getAttribute(){
		return Reference::select('id','nombre')->where('estado','1')->get();
	}

	public static function validarExistenciaCatalogoProductos($id_catalogo){
		return DB::table('tbl_inventario_producto')
						->join('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_inventario_producto.id_catalogo_producto')
						->select(
							'tbl_inventario_producto.id_inventario',
							'tbl_inventario_producto.id_tienda_inventario',
							'tbl_inventario_producto.id_catalogo_producto'
							)
						->where('tbl_inventario_producto.id_catalogo_producto',$id_catalogo)
						->get();
	}
}
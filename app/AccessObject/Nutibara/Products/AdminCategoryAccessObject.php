<?php 

namespace App\AccessObject\Nutibara\Products;

use App\Models\Nutibara\Products\Category;
use App\Models\FormMotor\FormDefiner;
use Carbon\Carbon;
use DB;

class AdminCategoryAccessObject {


	public static function CategoriesWhere($start,$end,$colum, $order,$search){
		return Category::leftjoin('tbl_sys_medida_peso','tbl_sys_medida_peso.id','tbl_prod_categoria_general.id_medida_peso')
						->select(
						'tbl_prod_categoria_general.id AS DT_RowId','nombre',
						'tbl_sys_medida_peso.nombre_medida as id_medida_peso',
						'tbl_prod_categoria_general.vigencia_desde',
						'tbl_prod_categoria_general.vigencia_hasta',
						DB::raw("IF(tbl_prod_categoria_general.estado = 1, 'SI', 'NO') AS estado")
						)
					->where(function ($query) use ($search){
						$query->where('nombre', 'like', "%".$search["catName"]."%");
						$query->where('estado', '=', $search["estado"]);
					})
					->orderBy($colum, $order)
					->skip($start)->take($end)	
					->get();
	}

	public static function Categories($start,$end,$colum,$order){
		return Category::leftjoin('tbl_sys_medida_peso','tbl_sys_medida_peso.id','tbl_prod_categoria_general.id_medida_peso')
							->select(
							'tbl_prod_categoria_general.id AS DT_RowId','nombre',
							'tbl_sys_medida_peso.nombre_medida as id_medida_peso',
							'tbl_prod_categoria_general.vigencia_desde',
							'tbl_prod_categoria_general.vigencia_hasta',
							DB::raw("IF(tbl_prod_categoria_general.estado = 1, 'SI', 'NO') AS estado")
							)
					->where('estado', '1')
					->skip($start)->take($end)									
					->orderBy($colum, $order)
					->get();
	}

	public static function getMedida(){
		return DB::table('tbl_sys_medida_peso')->select('id','nombre_medida as name')
											   ->get();
	}

	public static function getCountCategories($search){
		return Category::where(function ($query) use ($search){
							$query->where('nombre', 'like', "%".$search["catName"]."%");
							$query->where('estado', '=', $search["estado"]);
						})
						->count();
	}

	public static function getCategoryById($id){
		return Category::where('id',$id)->first();
	}

	public static function getAttributeCategoryById($id)
	{
		return Category::join('tbl_prod_atributo','tbl_prod_atributo.id_cat_general','=','tbl_prod_categoria_general.id')
					->leftJoin('tbl_contr_item_config', 'tbl_prod_atributo.id', '=', 'tbl_contr_item_config.id_atributo')
					->select('tbl_prod_atributo.id','tbl_prod_atributo.nombre')
					->where('tbl_prod_atributo.estado','1')
					->where('tbl_prod_categoria_general.id',$id)
					->orderBy('tbl_contr_item_config.orden_posicion')
					->get();
	}

	public static function getFirstAttributeCategoryById($id)
	{
		return Category::join('tbl_prod_atributo as b','tbl_prod_categoria_general.id','=','b.id_cat_general')
					->join('tbl_prod_atributo_valores as c','b.id','=','c.id_atributo')
					->select('b.id as idatributo', 
							'b.nombre as nombreatributo', 
							'c.nombre as nombrevaloratributo',
							'c.id as idvaloratributo')
					->where('b.estado','1')
					->where('c.estado','1')
					->where('b.id_atributo_padre','0')
					->where('tbl_prod_categoria_general.id',$id)
					->get();
	}



	public static function Create($table,$dataSaved){
		$result="Insertado";
		try{
			DB::beginTransaction();
			DB::table($table)->insert($dataSaved);		
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
			\DB::rollback();
		}
		return $result;
	}


	public static function update($id,$dataSaved){
		$result="Actualizado";
		try
		{
			Category::where('id',$id)->update($dataSaved);
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

	public static function delete($id){
		return Category::where('id',$id)->delete();	
	}

	public static function getCategory(){
		return Category::select('id','nombre as name', 'nombre')->where('estado','1')->where('vigencia_desde', '<=', Carbon::now())->where('vigencia_hasta', '>=', Carbon::now())->orderBy('nombre','asc')->get();
	}

	public static function getCategoryNullItem(){
		return Category::leftJoin('tbl_contr_item', 'tbl_contr_item.id_categoria_general', '=', 'tbl_prod_categoria_general.id')
								->join('tbl_prod_atributo', 'tbl_prod_atributo.id_cat_general', 'tbl_prod_categoria_general.id')
								->select(
										'tbl_prod_categoria_general.id',
										'tbl_prod_categoria_general.nombre as name', 
										'tbl_prod_categoria_general.nombre'
									)
									->where('tbl_prod_categoria_general.estado','1')
									->whereNull('tbl_contr_item.id')
									->distinct()
									->get();
	}

	public static function validateUnique( $data, $id ) {
		return Category::where( function($query) use($data, $id) {
			$query->where( 'tbl_prod_categoria_general.id', '<>', $id );
			( $data[ 'nombre' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.nombre', '=', $data[ 'nombre' ] ) : null;
			( $data[ 'vigencia_desde' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.vigencia_desde', '<=', $data[ 'vigencia_desde' ] ) : null;
			( $data[ 'vigencia_desde' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.vigencia_hasta', '>=', $data[ 'vigencia_desde' ] ) : null;
		} )
		->orWhere( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_prod_categoria_general.id', '<>', $id );
			( $data[ 'nombre' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.nombre', '=', $data[ 'nombre' ] ) : null;
			( $data[ 'vigencia_hasta' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.vigencia_desde', '<=', $data[ 'vigencia_hasta' ] ) : null;
			( $data[ 'vigencia_hasta' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.vigencia_hasta', '>=', $data[ 'vigencia_hasta' ] ) : null;
		} )
		->orWhere( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_prod_categoria_general.id', '<>', $id );
			( $data[ 'nombre' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.nombre', '=', $data[ 'nombre' ] ) : null;
			( $data[ 'vigencia_desde' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.vigencia_desde', '>=', $data[ 'vigencia_desde' ] ) : null;
			( $data[ 'vigencia_hasta' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.vigencia_desde', '<=', $data[ 'vigencia_hasta' ] ) : null;
		} )
		->orWhere( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_prod_categoria_general.id', '<>', $id );
			( $data[ 'nombre' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.nombre', '=', $data[ 'nombre' ] ) : null;
			( $data[ 'vigencia_desde' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.vigencia_hasta', '>=', $data[ 'vigencia_desde' ] ) : null;
			( $data[ 'vigencia_hasta' ] != '' ) ? $query->where( 'tbl_prod_categoria_general.vigencia_hasta', '<=', $data[ 'vigencia_hasta' ] ) : null;
		} )->count();
	}
}
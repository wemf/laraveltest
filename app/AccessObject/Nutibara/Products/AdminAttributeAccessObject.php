<?php 

namespace App\AccessObject\Nutibara\Products;

use App\Models\Nutibara\Products\Attribute;
use App\Models\Nutibara\Products\AttributeValue;
use App\Models\FormMotor\FormDefiner;
use DB;

class AdminAttributeAccessObject {


	public static function AttributesWhere($start,$end,$colum, $order,$search){
		

		return Attribute::join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_prod_atributo.id_cat_general')
						->leftJoin('tbl_prod_atributo as tbl_atributo_padre', 'tbl_atributo_padre.id', '=', 'tbl_prod_atributo.id_atributo_padre')
					->select('tbl_prod_atributo.id AS DT_RowId','tbl_prod_atributo.nombre','tbl_atributo_padre.nombre as atributopadre', 'tbl_prod_atributo.descripcion', 'tbl_prod_categoria_general.nombre AS categoria',
					DB::raw("IF(tbl_prod_atributo.estado = 1, 'SI', 'NO') AS estado"))
					->where(function ($query) use ($search){
						$query->where('tbl_prod_atributo.nombre', 'like', "%".$search['attrName']."%");
						$query->where('tbl_prod_categoria_general.nombre', 'like', "%".$search['catName']."%");
						$query->where('tbl_prod_atributo.estado', '=', $search["estado"]);
					})								
					->orderBy($colum, $order)
					->skip($start)->take($end)	
					->get();
	}

	public static function Attributes($start,$end,$colum,$order){
		return Attribute::join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_prod_atributo.id_cat_general')
						->leftJoin('tbl_prod_atributo as tbl_atributo_padre', 'tbl_atributo_padre.id', '=', 'tbl_prod_atributo.id_atributo_padre')
					->select('tbl_prod_atributo.id AS DT_RowId','tbl_prod_atributo.nombre','tbl_atributo_padre.nombre as atributopadre', 'tbl_prod_atributo.descripcion', 'tbl_prod_categoria_general.nombre AS categoria',
					DB::raw("IF(tbl_prod_atributo.estado = 1, 'SI', 'NO') AS estado"))
					->where('tbl_prod_atributo.estado', '1')
					->skip($start)->take($end)									
					->orderBy($colum, $order)
					->get();
	}

	public static function getCountAttributes($search){
		return Attribute::join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_prod_atributo.id_cat_general')
						->leftJoin('tbl_prod_atributo as tbl_atributo_padre', 'tbl_atributo_padre.id', '=', 'tbl_prod_atributo.id_atributo_padre')
						->where(function ($query) use ($search){
							$query->where('tbl_prod_atributo.nombre', 'like', "%".$search['attrName']."%");
							$query->where('tbl_prod_categoria_general.nombre', 'like', "%".$search['catName']."%");
							$query->where('tbl_prod_atributo.estado', '=', $search["estado"]);
						})
						->count();
	}

	public static function getAttributeById($id){
		return Attribute::where('id',$id)->first();
	}

	public static function getAttributeValueById($id)
	{
		return Attribute::join('tbl_prod_atributo_valores','tbl_prod_atributo_valores.id_atributo','=','tbl_prod_atributo.id_atributo_padre')
					->select('tbl_prod_atributo_valores.id','tbl_prod_atributo_valores.nombre')
					->where('tbl_prod_atributo_valores.estado','1')
					->where('tbl_prod_atributo.id',$id)
					->get();
	}

	public static function getIdByNombre($id_categoria, $nombre_atributo){
		return Attribute::select('tbl_prod_atributo.id')
						->where('tbl_prod_atributo.nombre',$nombre_atributo)
						->where('tbl_prod_atributo.id_cat_general',$id_categoria)
						->get();
	}	

	public static function getAttributesByCategories($categories)
	{
		$categorias = "0";
		for ($i=0; $i < count($categories); $i++) {
			$categorias = $categorias.",".$categories[$i];
		}
		if(count($categories) > 1){
			return DB::select('select nombre, nombre as id from 
			(select pa.`nombre`, count(1) comunes
			  from  tbl_prod_categoria_general pcg,
										   tbl_prod_atributo pa
			where pcg.id = pa.id_cat_general
			   and pcg.id in ('.$categorias.')
			group by pa.`nombre`) tf where comunes = '.count($categories));
		}else if(count($categories) == 1){
			return DB::select('select nombre, id from tbl_prod_atributo where id_cat_general = ('.$categories[0].')');
		}
		
	}

	public static function getAttributesByCategories_original($categories)
	{
		return DB::table('tbl_prod_atributo')
					->where(function ($query) use ($categories){
						for($i = 0; $i < count($categories); $i++){
							$query->join('tbl_prod_atributo as cat'.$categories[$i], 'cat'.$categories[$i].'.nombre', '=', 'tbl_prod_atributo.nombre');
						}
					})
					->select('tbl_prod_atributo.nombre')
					->where(function ($query) use ($categories){
						if(count($categories) == 0){
							$query->where('tbl_prod_atributo.id_cat_general', 0);
						}else{
							for($i = 0; $i < count($categories); $i++){
								$query->orWhere('cat'.$categories[$i].'.id_cat_general', $categories[$i]);
								
							}
						}
					})
					->distinct()
					->get();
	}

	public static function getAttributeAttributesById($id, $padre)
	{

		return Attribute::join('tbl_prod_atributo_valores as b','tbl_prod_atributo.id','=','b.id_atributo')
					->select('tbl_prod_atributo.id as idatributo', 
							'tbl_prod_atributo.nombre as nombreatributo', 
							'b.nombre as nombrevaloratributo',
							'b.id as idvaloratributo')
					->where('tbl_prod_atributo.estado','1')
					->where('b.estado','1')
					->where('tbl_prod_atributo.id_atributo_padre',$id)
					->where(function ($query) use ($padre){
						$query->where('b.id_atributo_padre',$padre);
						$query->orWhere('b.id_atributo_padre',0);
					})
					->get();
	}

	public static function getAttributeColumnByCategory($id_categoria)
	{

		// return Attribute::join('tbl_contr_item_config', 'tbl_contr_item_config.id_atributo', '=', 'tbl_prod_atributo.id')
		// 				->select('id', 'nombre')
		// 				->where('estado', '1')
		// 				->where('id_cat_general', $id_categoria)
		// 				->where('columna_independiente_contrato', '1')
		// 				->get();

		return DB::table('tbl_contr_item')
				 ->join('tbl_contr_item_config', 'tbl_contr_item_config.id_item', '=', 'tbl_contr_item.id')
				 ->join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'tbl_contr_item_config.id_atributo')
				 ->select('tbl_prod_atributo.id', 'tbl_prod_atributo.nombre')
				 ->where('tbl_contr_item.id_categoria_general', $id_categoria)
				 ->where('tbl_prod_atributo.estado', '1')
				 ->where('tbl_prod_atributo.columna_independiente_contrato', '1')
				 ->orderBy('tbl_prod_atributo.id_atributo_padre', 'ASC')
				 ->orderBy('tbl_contr_item_config.orden_posicion', 'ASC')
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
			DB::rollback();
		}
		return $result;
	}

	public static function update($id,$dataSaved){	
		$result="Actualizado";
		try{
			Attribute::where('id',$id)->update($dataSaved);
		}catch(\Exception $e){
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
		$result="Eliminado";
		try{
			Attribute::where('id',$id)->delete();
		}catch(\Exception $e){
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

	public static function getAttribute(){
		return Attribute::select('id','nombre')->where('estado','1')->get();
	}

	public static function getAttributeValueUpdate($id)
	{
		return DB::table('tbl_prod_catalogo AS catalogo')
					->join('tbl_prod_referencia AS referencia', 'referencia.id_referencia', '=', 'catalogo.id')
					->join('tbl_prod_atributo_valores AS valores', 'valores.id', '=', 'referencia.id_valor_atributo')
					->join('tbl_prod_atributo AS atributos', 'atributos.id', '=', 'valores.id_atributo')
					->join('tbl_prod_atributo_valores AS todos_valores', 'todos_valores.id_atributo', '=', 'atributos.id')
					->select(
						'atributos.id AS id_atributo',
						'atributos.nombre AS nombre_atributo',
						'todos_valores.id as id_valor',
						'todos_valores.nombre AS nombre_valor',
						'atributos.id_atributo_padre AS id_atributo_padre',
						DB::raw('IF(valores.id = todos_valores.id, 1, 0) as valor_seleccionado')
					)
					->where('catalogo.id', $id)
					->get();
	}

	public static function getAttributeValueByName($id_atributo, $valor)
	{

		return AttributeValue::select( 'nombre', 'id' )
					->where( 'estado', '1' )
					->where( 'id_atributo', $id_atributo )
					->where( 'nombre', 'LIKE', '%'.$valor.'%' )
					->get();
	}
}
<?php 

namespace App\AccessObject\Nutibara\Products;

use App\Models\Nutibara\Products\AttributeValue;
use App\Models\FormMotor\FormDefiner;

class AdminAttributeValueAccessObject {


	public static function AttributeValuesWhere($start,$end,$colum, $order,$search){
		
		return AttributeValue::join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'tbl_prod_atributo_valores.id_atributo')
					->join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_prod_atributo.id_cat_general')
					->leftjoin('tbl_prod_atributo_valores as c', 'tbl_prod_atributo_valores.id_atributo_padre', '=', 'c.id')
					->select('tbl_prod_atributo_valores.id AS DT_RowId','tbl_prod_atributo_valores.nombre AS nombre', 'tbl_prod_atributo.nombre AS atributo', 'tbl_prod_atributo.nombre AS atributo', 'c.nombre as valorpadre', 'tbl_prod_categoria_general.nombre as categoria',
					\DB::raw("IF(tbl_prod_atributo_valores.estado = 1, 'SI', 'NO') AS estado"))
					->where(function ($query) use ($search){
						$query->where('tbl_prod_atributo_valores.nombre', 'like', "%".$search['attrValName']."%");
						$query->where('tbl_prod_categoria_general.nombre', 'like', "%".$search['catName']."%");
						$query->where('tbl_prod_atributo.nombre', 'like', "%".$search['attrName']."%");
						$query->where('tbl_prod_atributo_valores.estado', '=', $search["estado"]);
					})
					->orderBy($colum, $order)
					->skip($start)->take($end)	
					->get();
	}

	public static function AttributeValues($start,$end,$colum,$order){
		return AttributeValue::join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'tbl_prod_atributo_valores.id_atributo')
					->join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_prod_atributo.id_cat_general')
					->leftjoin('tbl_prod_atributo_valores as c', 'tbl_prod_atributo_valores.id_atributo_padre', '=', 'c.id')
					->select('tbl_prod_atributo_valores.id AS DT_RowId','tbl_prod_atributo_valores.nombre AS nombre', 'tbl_prod_atributo.nombre AS atributo', 'tbl_prod_atributo.nombre AS atributo', 'c.nombre as valorpadre', 'tbl_prod_categoria_general.nombre as categoria',
					\DB::raw("IF(tbl_prod_atributo_valores.estado = 1, 'SI', 'NO') AS estado"))
					->where('tbl_prod_atributo_valores.estado', '1')
					->skip($start)->take($end)									
					->orderBy($colum, $order)
					->get();
	}

	public static function getCountAttributeValues($search){
		return AttributeValue::join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'tbl_prod_atributo_valores.id_atributo')
							->join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_prod_atributo.id_cat_general')
							->leftjoin('tbl_prod_atributo_valores as c', 'tbl_prod_atributo_valores.id_atributo_padre', '=', 'c.id')
							->where(function ($query) use ($search){
								$query->where('tbl_prod_atributo_valores.nombre', 'like', "%".$search['attrValName']."%");
								$query->where('tbl_prod_categoria_general.nombre', 'like', "%".$search['catName']."%");
								$query->where('tbl_prod_atributo.nombre', 'like', "%".$search['attrName']."%");
								$query->where('tbl_prod_atributo_valores.estado', '=', $search["estado"]);
							})
							->count();
	}

	public static function getAttributeValueById($id){
		return AttributeValue::join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'tbl_prod_atributo_valores.id_atributo')
								->select('tbl_prod_atributo.id_cat_general',
											'tbl_prod_atributo_valores.id',
											'tbl_prod_atributo_valores.id_atributo',
											'tbl_prod_atributo_valores.nombre',
											'tbl_prod_atributo_valores.id_atributo_padre',
											'tbl_prod_atributo_valores.peso_igual_contrato',
											'tbl_prod_atributo_valores.valor_defecto',
											'tbl_prod_atributo_valores.abreviatura',
											'tbl_prod_atributo_valores.estado')
								->where('tbl_prod_atributo_valores.id',$id)->first();
	}

	public static function getAllAttributeValues(){
		return AttributeValue::join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'tbl_prod_atributo_valores.id_atributo')
							->join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_prod_atributo.id_cat_general')
							->leftjoin('tbl_prod_atributo_valores as c', 'tbl_prod_atributo_valores.id_atributo_padre', '=', 'c.id')
							->select('tbl_prod_categoria_general.nombre as categoria', 'tbl_prod_atributo.nombre AS atributo', 'c.nombre as valorpadre', 'tbl_prod_atributo_valores.nombre AS nombre', \DB::raw("IF(tbl_prod_atributo_valores.estado = 1, 'SI', 'NO') AS estado"))
							->get();
	}

	public static function Create($table,$dataSaved){
		$result=true;
		try{
			\DB::beginTransaction();
			\DB::table($table)->insert($dataSaved);
			\DB::commit();
		}catch(\Exception $e){
			// dd($e);
			$result=false;
			\DB::rollback();
		}
		return $result;
	}

	public static function update($id,$dataSaved){
		$result=true;
		try{
			AttributeValue::where('id',$id)->update($dataSaved);
		}catch(\Exception $e){
			$result=false;
		}
		return $result;
	}

	public static function delete($id){
		$result=true;
		try{
			AttributeValue::where('id',$id)->delete();	
		}catch(\Exception $e){
			$result=false;
		}
		return $result;
	}

	public static function countAttrValByParent($id_parent) {
		return AttributeValue::where('id_atributo_padre', $id_parent)->where('estado', '1')->count();
	}

	public static function storeFromContr($table,$dataSaved){
		$result=null;
		try{
			\DB::beginTransaction();
			$result = \DB::table($table)->insertGetId($dataSaved);
			\DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=null;
			\DB::rollback();
		}
		return $result;
	}
}
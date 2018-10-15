<?php 

namespace App\AccessObject\Nutibara\ConfigContrato;

use App\Models\Nutibara\ConfigContrato\ItemContrato;
use DB;

class ItemContratoAccessObject {

    public static function ItemContrato($start,$end,$colum,$order){
		return ItemContrato::join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_item.id_categoria_general')
					->select('tbl_contr_item.id AS DT_RowId',
							 'tbl_contr_item.nombre',
							 'tbl_prod_categoria_general.nombre as categoria',
							 \DB::raw("IF(tbl_contr_item.estado = 1, 'SI', 'NO') AS estado"))
					->where('tbl_contr_item.estado', '1')
					->skip($start)->take($end)									
					->orderBy($colum, $order)
					->get();
	}

    public static function ItemContratoWhere($start,$end,$colum, $order,$search){
		

		return ItemContrato::join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_item.id_categoria_general')
					->select('tbl_contr_item.id AS DT_RowId',
							 'tbl_contr_item.nombre',
							 'tbl_prod_categoria_general.nombre as categoria',
							 \DB::raw("IF(tbl_contr_item.estado = 1, 'SI', 'NO') AS estado"))
					->where(function ($query) use ($search){
						$query->where('tbl_contr_item.estado', '=', $search["estado"]);
						$query->where('tbl_contr_item.id_categoria_general', 'LIKE', '%'.$search['categoria'].'%');
					})
					->orderBy($colum, $order)
					->skip($start)->take($end)	
					->get();
	}

	public static function getAtributosContrato($categoria){
		return DB::table('tbl_contr_item')
					->join('tbl_contr_item_config', 'tbl_contr_item_config.id_item', '=', 'tbl_contr_item.id')
					->join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'tbl_contr_item_config.id_atributo')
					->leftJoin('tbl_prod_atributo_valores','tbl_prod_atributo.id','=','tbl_prod_atributo_valores.id_atributo')
					->select('tbl_prod_atributo.id as idatributo', 
							'tbl_prod_atributo.nombre as nombreatributo', 
							'tbl_prod_atributo.concatenar_nombre', 
							'tbl_prod_atributo.columna_independiente_contrato', 
							'tbl_prod_atributo.valor_desde_contrato', 
							'tbl_prod_atributo_valores.nombre as nombrevaloratributo',
							'tbl_prod_atributo_valores.id as idvaloratributo',
							'tbl_prod_atributo_valores.peso_igual_contrato',
							'tbl_prod_atributo_valores.valor_defecto',
							'tbl_contr_item_config.obligatorio as item_obligatorio',
							'tbl_contr_item_config.orden_posicion')
					->where('tbl_contr_item.id_categoria_general', $categoria)
					->where('tbl_prod_atributo.estado','1')
					->where('tbl_prod_atributo.id_atributo_padre','0')
					->where(function ($query){
						$query->where(function ($query){
							$query->where('tbl_prod_atributo.valor_desde_contrato', '=', '1');
						});
						$query->orWhere(function ($query){
							$query->where('tbl_prod_atributo.valor_desde_contrato', '=', '0');
							$query->where('tbl_prod_atributo_valores.estado', '=', '1');
						});
					})
					->get();
	}

	public static function getAtributosHijosContrato($id, $padre){
		return DB::table('tbl_contr_item')
					->join('tbl_contr_item_config', 'tbl_contr_item_config.id_item', '=', 'tbl_contr_item.id')
					->join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'tbl_contr_item_config.id_atributo')
					->join('tbl_prod_atributo_valores','tbl_prod_atributo.id','=','tbl_prod_atributo_valores.id_atributo')
					->select('tbl_prod_atributo.id as idatributo', 
							'tbl_prod_atributo.nombre as nombreatributo', 
							'tbl_prod_atributo.concatenar_nombre', 
							'tbl_prod_atributo.columna_independiente_contrato', 
							'tbl_prod_atributo_valores.nombre as nombrevaloratributo',
							'tbl_prod_atributo_valores.id as idvaloratributo',
							'tbl_prod_atributo_valores.peso_igual_contrato',
							'tbl_prod_atributo_valores.valor_defecto',
							'tbl_contr_item_config.obligatorio as item_obligatorio',
							'tbl_contr_item_config.orden_posicion')
					->where('tbl_prod_atributo.estado','1')
					->where('tbl_prod_atributo_valores.estado','1')
					->where('tbl_prod_atributo.id_atributo_padre',$id)
					->where(function ($query) use ($padre){
						$query->where('tbl_prod_atributo_valores.id_atributo_padre',$padre);
						$query->orWhere('tbl_prod_atributo_valores.id_atributo_padre',0);
					})
					->get();
	}

	public static function getCountItemContrato($search){
		return ItemContrato::join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_item.id_categoria_general')
						->where(function ($query) use ($search){
							$query->where('tbl_contr_item.estado', '=', $search["estado"]);
							$query->where('tbl_contr_item.id_categoria_general', 'LIKE', '%'.$search['categoria'].'%');
						})
						->count();
	}

    public static function getItemContratoById($id){
		return ItemContrato::leftJoin('tbl_contr_item_config', 'tbl_contr_item_config.id_item', '=', 'tbl_contr_item.id')
		->leftJoin('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_item.id_categoria_general')
		->select('tbl_contr_item.*', 'tbl_prod_categoria_general.nombre AS nombre_categoria')
		->where('tbl_contr_item.id',$id)
		->orderBy('orden_posicion', 'asc')
		->first();
	}

	public static function getItemContratoByCategoria($id)
	{
		return ItemContrato::where('id_categoria_general',$id)->get();
	}

	public static function getAtributosEdit($id)
	{
		return DB::table('tbl_contr_item_config')->where('id_item', $id)->orderBy('orden_posicion', 'asc')->get();
	}

    public static function Create($table,$dataSaved){
		$result=true;
		$id = 0;
		try{
			DB::beginTransaction();
			if($table == "tbl_contr_item"){
				$id = DB::table($table)->insertGetId($dataSaved);
			}else{
				$id = DB::table($table)->insert($dataSaved);
			}
			
			$result = $id;
			DB::commit();
		}catch(\Exception $e){
			$result=false;
			DB::rollback();
		}
		if($table == "tbl_contr_item"){
			return $id;
		}else{
			return $result;
		}
		
	}

    public static function update($id,$dataSaved){	
		self::deleteItemConfig($id);
		return ItemContrato::where('id',$id)->update($dataSaved);
	}

	public static function deleteItemConfig($id){
		return DB::table('tbl_contr_item_config')->where('id_item',$id)->delete();	
	}

	public static function delete($id){	
		DB::table('tbl_contr_item_config')->where('id_item',$id)->delete();	
		return ItemContrato::where('id',$id)->delete();	
	}

}
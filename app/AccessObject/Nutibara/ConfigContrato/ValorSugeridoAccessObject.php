<?php 

namespace App\AccessObject\Nutibara\ConfigContrato;

use App\Models\Nutibara\ConfigContrato\ValorSugerido;
use DB;

class ValorSugeridoAccessObject {

    public static function ValorSugerido($start,$end,$colum,$order){
		return ValorSugerido::join('tbl_sys_medida_peso', 'tbl_sys_medida_peso.id', '=', 'tbl_contr_val_peso_sug.id_medida_peso')
					->join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_val_peso_sug.id_categoria_general')
					->leftJoin('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_val_peso_sug.id_pais')
					->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_val_peso_sug.id_departamento')
					->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_val_peso_sug.id_ciudad')
					->leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_val_peso_sug.id_tienda')
					->select('tbl_contr_val_peso_sug.id AS DT_RowId',
							 DB::raw("FORMAT(tbl_contr_val_peso_sug.valor_minimo_x_1,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE') as valor_minimo_x_1"),
							 DB::raw("FORMAT(tbl_contr_val_peso_sug.valor_maximo_x_1,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE') as valor_maximo_x_1"),
							 DB::raw("FORMAT(tbl_contr_val_peso_sug.valor_x_1,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE') as valor_x_1"),
							 DB::raw("FORMAT(tbl_contr_val_peso_sug.valor_venta_x_1,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE') as valor_venta_x_1"),
							 'tbl_sys_medida_peso.nombre_medida as medida_peso',
							 'tbl_prod_categoria_general.nombre as categoria',
							 'tbl_pais.nombre as pais',
							 'tbl_departamento.nombre as departamento',
							 'tbl_ciudad.nombre as ciudad',
							 'tbl_tienda.nombre as tienda',
							 DB::raw("(SELECT REPLACE(group_concat(tbl_prod_atributo_valores.nombre), ',', ' ') FROM tbl_contr_val_peso_atrib INNER JOIN tbl_prod_atributo_valores ON tbl_contr_val_peso_atrib.id_valor_atrib = tbl_prod_atributo_valores.id WHERE tbl_contr_val_peso_atrib.id_config_peso = tbl_contr_val_peso_sug.id GROUP BY id_config_peso) as nombre_concatenado"),
							 DB::raw("IF(tbl_contr_val_peso_sug.estado = 1, 'SI', 'NO') AS estado"))
					->where('tbl_contr_val_peso_sug.estado', '1')
					->skip($start)->take($end)
					->orderBy('tbl_pais.nombre', 'asc')
					->orderBy('tbl_departamento.nombre', 'asc')
					->orderBy('tbl_ciudad.nombre', 'asc')
					->orderBy('tbl_tienda.nombre', 'asc')	
					->orderBy($colum, $order)
					->get();
	}

    public static function ValorSugeridoWhere($start,$end,$colum, $order,$search){
		

		return ValorSugerido::join('tbl_sys_medida_peso', 'tbl_sys_medida_peso.id', '=', 'tbl_contr_val_peso_sug.id_medida_peso')
					->join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_val_peso_sug.id_categoria_general')
					->leftJoin('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_val_peso_sug.id_pais')
					->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_val_peso_sug.id_departamento')
					->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_val_peso_sug.id_ciudad')
					->leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_val_peso_sug.id_tienda')
					->select('tbl_contr_val_peso_sug.id AS DT_RowId',
							DB::raw("FORMAT(tbl_contr_val_peso_sug.valor_minimo_x_1,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE') as valor_minimo_x_1"),
							DB::raw("FORMAT(tbl_contr_val_peso_sug.valor_maximo_x_1,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE') as valor_maximo_x_1"),
							DB::raw("FORMAT(tbl_contr_val_peso_sug.valor_x_1,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE') as valor_x_1"),
							DB::raw("FORMAT(tbl_contr_val_peso_sug.valor_venta_x_1,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE') as valor_venta_x_1"),
							 'tbl_sys_medida_peso.nombre_medida as medida_peso',
							 'tbl_prod_categoria_general.nombre as categoria',
							 'tbl_pais.nombre as pais',
							 'tbl_departamento.nombre as departamento',
							 'tbl_ciudad.nombre as ciudad',
							 'tbl_tienda.nombre as tienda',
							 DB::raw("(SELECT REPLACE(group_concat(tbl_prod_atributo_valores.nombre), ',', ' ') FROM tbl_contr_val_peso_atrib INNER JOIN tbl_prod_atributo_valores ON tbl_contr_val_peso_atrib.id_valor_atrib = tbl_prod_atributo_valores.id WHERE tbl_contr_val_peso_atrib.id_config_peso = tbl_contr_val_peso_sug.id GROUP BY id_config_peso) as nombre_concatenado"),
							 DB::raw("IF(tbl_contr_val_peso_sug.estado = 1, 'SI', 'NO') AS estado"))
					->where(function ($query) use ($search){
						$query->where('tbl_contr_val_peso_sug.estado', '=', $search["estado"]);
						$query->where('tbl_contr_val_peso_sug.id_categoria_general', 'LIKE', '%'.$search['categoria'].'%');
					})
					->orderBy($colum, $order)
					->orderBy('tbl_pais.nombre', 'asc')
					->orderBy('tbl_departamento.nombre', 'asc')
					->orderBy('tbl_ciudad.nombre', 'asc')
					->orderBy('tbl_tienda.nombre', 'asc')	
					->skip($start)->take($end)	
					->get();
	}

	public static function getCountValorSugerido($search){
		return ValorSugerido::join('tbl_sys_medida_peso', 'tbl_sys_medida_peso.id', '=', 'tbl_contr_val_peso_sug.id_medida_peso')
							->join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_val_peso_sug.id_categoria_general')
							->leftJoin('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_val_peso_sug.id_pais')
							->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_val_peso_sug.id_departamento')
							->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_val_peso_sug.id_ciudad')
							->leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_val_peso_sug.id_tienda')
							->where(function ($query) use ($search){
								$query->where('tbl_contr_val_peso_sug.estado', '=', $search["estado"]);
								$query->where('tbl_contr_val_peso_sug.id_categoria_general', 'LIKE', '%'.$search['categoria'].'%');
							})
							->count();
	}

    public static function getValorSugeridoById($id){
		return ValorSugerido::select(
								'id',
								'id_medida_peso',
								'id_categoria_general',
								'id_item',
								DB::raw("FORMAT(valor_minimo_x_1,2,'de_DE') as valor_minimo_x_1"),
								DB::raw("FORMAT(valor_maximo_x_1,2,'de_DE') as valor_maximo_x_1"),
								DB::raw("FORMAT(valor_x_1,2,'de_DE') as valor_x_1"),
								DB::raw("FORMAT(valor_venta_x_1,2,'de_DE') as valor_venta_x_1"),
								'estado',
								'id_pais',
								'id_departamento',
								'id_ciudad',
								'id_tienda'
							)
							->where('id',$id)->first();
	}

    public static function Create($table,$dataSaved, $id_atributos){
		$result="Insertado";
		try{
			DB::beginTransaction();
			$id_configuracion = DB::table($table)->insertGetId($dataSaved);
			if($id_atributos != null)
				$a = self::createEspecifica($dataSaved['id_tienda'], $dataSaved['id_categoria_general'], $id_configuracion, $id_atributos);
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

	public static function createEspecifica($id_tienda, $id_categoria, $id_configuracion, $id_atributos){
		try{
			$id_atributos = explode(',', $id_atributos);
		}catch(\Exception $e){}

		$data = [];
		for($i = 0; $i < count($id_atributos); $i++){
			array_push($data, ["id_tienda" => $id_tienda, "id_categoria" => $id_categoria, "id_config_peso" => $id_configuracion, "id_valor_atrib" => $id_atributos[$i]]);
		}
		DB::table('tbl_contr_val_peso_atrib')->insert($data);
		return ($data);
	}

    public static function update($id,$dataSaved){
		$result="Actualizado";
		try
		{
			ValorSugerido::where('id',$id)->update($dataSaved);
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

	public static function validarUnico($data, $id_atributos){
		
		return DB::table('tbl_contr_val_peso_sug')
					->join('tbl_contr_val_peso_atrib', 'tbl_contr_val_peso_atrib.id_config_peso', '=', 'tbl_contr_val_peso_sug.id')
					->select(
						DB::raw("count(id_valor_atrib) as cantidad")
					)
					->where('tbl_contr_val_peso_sug.id_pais', $data['id_pais'])
					->where('tbl_contr_val_peso_sug.id_departamento', $data['id_departamento'])
					->where('tbl_contr_val_peso_sug.id_ciudad', $data['id_ciudad'])
					->where('tbl_contr_val_peso_sug.id_tienda', $data['id_tienda'])
					->where('tbl_contr_val_peso_sug.id_categoria_general', $data['id_categoria_general'])
					->whereIn('tbl_contr_val_peso_atrib.id_valor_atrib', $id_atributos)
					->orderBy('cantidad', 'desc')
					->groupBy('tbl_contr_val_peso_atrib.id_config_peso')
					->first();
	}

	public static function delete($id){	
		ValorSugerido::where('id',$id)->delete();	
		return DB::table('tbl_contr_val_peso_atrib')->where('id_config_peso',$id)->delete();	
	}

	public static function getMedidaPeso(){
		return DB::table('tbl_parametro_general')
						->join('tbl_sys_medida_peso', 'tbl_sys_medida_peso.id', '=', 'tbl_parametro_general.id_medida_peso')
						->select('tbl_sys_medida_peso.nombre_medida', 'tbl_sys_medida_peso.id as id_medida')->where('tbl_parametro_general.estado', 1)->first();
	}

	public static function getValById($id)
	{
		return DB::table('tbl_prod_categoria_general')
						 ->join('tbl_sys_medida_peso','tbl_sys_medida_peso.id','tbl_prod_categoria_general.id_medida_peso')
						 ->select(
							'tbl_sys_medida_peso.nombre_medida',
							'tbl_sys_medida_peso.id'
						 )
						 ->where('tbl_prod_categoria_general.id',$id)
						 ->first();
	}

	public static function getAttributeValueUpdate($id)
	{
		return DB::table('tbl_contr_val_peso_sug AS peso_sug')
					->join('tbl_contr_val_peso_atrib AS peso_atrib', 'peso_atrib.id_config_peso', '=', 'peso_sug.id')
					->join('tbl_prod_atributo_valores AS valores', 'valores.id', '=', 'peso_atrib.id_valor_atrib')
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
					->where('peso_sug.id', $id)
					->get();
	}

}
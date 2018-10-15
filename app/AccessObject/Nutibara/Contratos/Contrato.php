<?php 

namespace App\AccessObject\Nutibara\Contratos;

use App\Models\Nutibara\Contratos\ContratoCabecera AS ModelCabeceraContrato;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use App\Models\Nutibara\Archivo\Archivo AS ModelArchivo;
use App\Models\Nutibara\ConfigContrato\General AS ModelGeneral;
use App\Models\Nutibara\GestionEstado\MotivoEstado\MotivoEstado AS ModelMotivoEstado;


use DB;
use config\messages;

class Contrato 
{
	public static function get(){
		return  DB::table('tbl_contr_cabecera')->join('tbl_cliente', function ($join) {
								$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_contr_cabecera.codigo_cliente');
								$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_cliente');
							})
							->join('tbl_clie_tipo_documento', 'tbl_clie_tipo_documento.id', '=', 'tbl_cliente.id_tipo_documento')
							->join('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
							->join('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_tienda.id_ciudad')
							->join('tbl_zona', 'tbl_zona.id', '=', 'tbl_tienda.id_zona')
							->join('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_ciudad.id_departamento')
							->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_departamento.id_pais')
							->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_contr_cabecera.id_estado_contrato')
							->leftJoin('tbl_sys_motivo','tbl_sys_motivo.id','tbl_contr_cabecera.id_motivo_contrato')
							->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
							->leftJoin('tbl_contr_prorroga', function($join){
								$join->on('tbl_contr_prorroga.id_tienda_contrato', '=', 'tbl_contr_cabecera.id_tienda_contrato');
								$join->on('tbl_contr_prorroga.codigo_contrato', '=', 'tbl_contr_cabecera.codigo_contrato');
							})
							->select(
								DB::Raw('Concat(tbl_contr_cabecera.codigo_contrato,"/",tbl_contr_cabecera.id_tienda_contrato) AS DT_RowId'),
								'tbl_contr_cabecera.codigo_contrato',
								'tbl_contr_cabecera.termino',
								DB::raw("IF(fecha_retroventa IS NULL, '', fecha_retroventa) AS fecha_retroventa"),
								DB::raw("IF(tbl_contr_cabecera.extraviado = 1, 'Si', 'No') AS contrato_extraviado"),
								DB::raw("IF((SELECT COUNT(id_tienda) FROM tbl_contr_tercero WHERE tbl_contr_tercero.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_tercero.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato) > 0, 'Si', 'No') AS reclamo_tercero"),
								'tbl_prod_categoria_general.nombre AS categoria_general',
								'tbl_sys_estado_tema.nombre AS estado_tema',
								DB::raw("IF(IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion) < curdate() AND tbl_contr_cabecera.id_estado_contrato IS NULL, 'Vencido', tbl_sys_motivo.nombre) AS motivo_contrato"),
								
								'tbl_tienda.nombre AS tienda',
								'tbl_contr_cabecera.fecha_creacion',
								DB::Raw('Concat(tbl_contr_cabecera.porcentaje_retroventa, "%") AS porcen_retroventa'),
								'tbl_cliente.numero_documento as documento_cliente',
								DB::raw('IF(tbl_cliente.segundo_apellido IS NULL, Concat(tbl_cliente.nombres, " ", tbl_cliente.primer_apellido), Concat(tbl_cliente.nombres, " ", tbl_cliente.primer_apellido, " ", tbl_cliente.segundo_apellido)) as nombres_cliente'),
								'tbl_clie_tipo_documento.nombre_abreviado as tipo_documento',
								DB::Raw("(IF(timestampdiff(month,tbl_contr_cabecera.fecha_terminacion,tbl_contr_prorroga.fecha_terminacion) IS NULL, '', timestampdiff(month,tbl_contr_cabecera.fecha_terminacion,tbl_contr_prorroga.fecha_terminacion))) AS numero_prorrogas"),
								DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),
								DB::Raw("IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion) AS fecha_terminacion")
							)
							->where(function ($query) {
								$query->whereNull('tbl_contr_prorroga.fecha_terminacion');
								$query->orWhere('tbl_contr_prorroga.fecha_terminacion', DB::raw('(SELECT MAX(tbl_contr_prorroga.fecha_terminacion) FROM tbl_contr_prorroga WHERE tbl_contr_prorroga.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_prorroga.codigo_contrato = tbl_contr_cabecera.codigo_contrato )'));
							})
							->distinct();	
	}

	public static function ContratoWhere($colum, $order,$search){
		return ModelCabeceraContrato::join('tbl_cliente', function ($join) {
										$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_contr_cabecera.codigo_cliente');
										$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_cliente');
									})
									->join('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
									->join('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_tienda.id_ciudad')
									->join('tbl_zona', 'tbl_zona.id', '=', 'tbl_tienda.id_zona')
									->join('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_ciudad.id_departamento')
									->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_departamento.id_pais')
									->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_contr_cabecera.id_estado_contrato')
									->leftJoin('tbl_sys_motivo','tbl_sys_motivo.id','tbl_contr_cabecera.id_motivo_contrato')
									->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
									->leftJoin('tbl_contr_prorroga', function($join){
										$join->on('tbl_contr_prorroga.id_tienda_contrato', '=', 'tbl_contr_cabecera.id_tienda_contrato');
										$join->on('tbl_contr_prorroga.codigo_contrato', '=', 'tbl_contr_cabecera.codigo_contrato');
									})
									->select(
											DB::Raw('Concat(tbl_contr_cabecera.codigo_contrato,"/",tbl_contr_cabecera.id_tienda_contrato) AS DT_RowId'),
											'tbl_contr_cabecera.cod_bolsa_seguridad_desde',
											'tbl_contr_cabecera.porcentaje_Retroventa',
											DB::raw("IF(fecha_retroventa IS NULL, '', fecha_retroventa) AS fecha_retroventa"),
											'tbl_contr_cabecera.termino',
											'tbl_contr_cabecera.fecha_creacion',
											'tbl_contr_cabecera.cod_bolsa_seguridad_hasta',
											'tbl_tienda.nombre AS tienda',
											'tbl_prod_categoria_general.nombre AS categoria_general',
											'tbl_sys_estado_tema.nombre AS estado_tema',
											'tbl_sys_motivo.nombre AS motivo_contrato',
											'fecha_ultima_actualizacion',
											'tbl_contr_cabecera.codigo_contrato',
											DB::Raw("IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion)")
											)
                                    ->where(function ($query) use ($search){
										$query->where('tbl_pais.nombre', 'like', "%".$search['pais']."%");
										$query->where('tbl_departamento.nombre', 'like', "%".$search['departamento']."%");
										$query->where('tbl_ciudad.nombre', 'like', "%".$search['ciudad']."%");
										$query->where('tbl_zona.nombre', 'like', "%".$search['zona']."%");
										$query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
										$query->where('tbl_sys_estado_tema.nombre', 'like', "%".$search['estado']."%");
										$query->where('tbl_sys_motivo.nombre', 'like', "%".$search['motivo']."%");
									})
									->where(function ($query) {
										$query->whereNull('tbl_contr_prorroga.fecha_terminacion');
										$query->orWhere('tbl_contr_prorroga.fecha_terminacion', DB::raw('(SELECT MAX(tbl_contr_prorroga.fecha_terminacion) FROM tbl_contr_prorroga WHERE tbl_contr_prorroga.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_prorroga.codigo_contrato = tbl_contr_cabecera.codigo_contrato )'));
									})
                                    ->orderBy($colum, $order)
									->distinct()
                                    ->get();
	}

	public static function Contrato($start,$end,$colum,$order){
		return ModelCabeceraContrato::join('tbl_cliente', function ($join) {
										$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_contr_cabecera.codigo_cliente');
										$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_cliente');
									})
									->join('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
									->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_contr_cabecera.id_estado_contrato')
									->leftJoin('tbl_sys_motivo','tbl_sys_motivo.id','tbl_contr_cabecera.id_motivo_contrato')
									->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
									->select(
											DB::Raw('Concat(tbl_contr_cabecera.codigo_contrato,"/",tbl_contr_cabecera.id_tienda_contrato) AS DT_RowId'),
											'tbl_contr_cabecera.cod_bolsa_seguridad_desde',
											'tbl_contr_cabecera.porcentaje_Retroventa',
											'tbl_contr_cabecera.termino',
											'tbl_contr_cabecera.fecha_creacion',
											'tbl_contr_cabecera.cod_bolsa_seguridad_hasta',
											'tbl_tienda.nombre AS tienda',
											'tbl_prod_categoria_general.nombre AS categoria_general',
											'tbl_sys_estado_tema.nombre AS estado_tema',
											'tbl_sys_motivo.nombre AS motivo_contrato',
											'fecha_ultima_actualizacion',
											'tbl_contr_cabecera.fecha_terminacion',
											'tbl_contr_cabecera.codigo_contrato'
											)
											->skip($start)->take($end)	
											->orderBy($colum, $order)
											->distinct()
						        	->get();
	}


	public static function getCountContrato(){
		return ModelCabeceraContrato::count();
	}

	public static function getTerRetEsp($id_categoria_general, $id_tienda_contrato){
		return DB::table('tbl_contr_configuracion')
					->select('termino_contrato', 'porcentaje_retroventa')
					->where('id_categoria_general', $id_categoria_general)
					->where('id_tienda', $id_tienda_contrato)
					->first();
	}
	
	public static function getTerminoRetroventa($id_categoria_general, $id_tienda_contrato, $monto){
		$datos_tienda = DB::table('tbl_tienda')
					->join('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_tienda.id_ciudad')
					->join('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_ciudad.id_departamento')
					->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_departamento.id_pais')
					->select('tbl_pais.id as id_pais', 'tbl_departamento.id as id_departamento', 'tbl_ciudad.id as id_ciudad', 'tbl_tienda.id as id_tienda')
					->where('tbl_tienda.id', $id_tienda_contrato)
					->first();

		return DB::select('CALL termino_retroventa_contrato (?,?,?,?,?,?)',array
			(
				$datos_tienda->id_pais, 
				$datos_tienda->id_departamento,
				$datos_tienda->id_ciudad,
				$datos_tienda->id_tienda,
				$id_categoria_general,
				$monto
			)
		);
	}

	public static function validarBolsaPeso($categoria){
		return DB::table('tbl_prod_categoria_general')
					->leftJoin('tbl_sys_medida_peso', 'tbl_sys_medida_peso.id', '=', 'tbl_prod_categoria_general.id_medida_peso')
					->select('tbl_prod_categoria_general.aplica_bolsa', 'tbl_sys_medida_peso.nombre_medida as unidad_medida', 'tbl_prod_categoria_general.control_peso_contrato')
					->where('tbl_prod_categoria_general.id', $categoria)
					->get();
	}

	public static function pesoEstimado($categoria, $tienda, $valores_atributos){
		$a = (string) $valores_atributos;
		$explode_valores = [];
		try{
			if($valores_atributos != null){
				$explode_valores = explode(',', $a);
			}
		}catch(\Exception $e){}

		$array_valores = [];
		for ($i=0; $i < count($explode_valores); $i++) { 
			array_push($array_valores, $explode_valores[$i]);
		}

		$id_config_peso = DB::table('tbl_contr_val_peso_atrib')
										->join('tbl_contr_val_peso_sug', 'tbl_contr_val_peso_sug.id', '=', 'tbl_contr_val_peso_atrib.id_config_peso')
										->select(
											'id_config_peso',
											DB::raw("COUNT(id_config_peso) AS cont_id_config_peso"),
											DB::raw("(SELECT COUNT(XD.id_config_peso) FROM tbl_contr_val_peso_atrib AS XD where XD.id_config_peso = tbl_contr_val_peso_sug.id) as cont_id_config_peso_XD")
										)
										->whereIn('id_valor_atrib', $array_valores)
										->where('id_categoria', $categoria)
										// ->where(DB::Raw('COUNT(id_config_peso)'), '>=', count($array_valores))
										->havingRaw('COUNT(id_config_peso) >= (SELECT COUNT(XD.id_config_peso) FROM tbl_contr_val_peso_atrib AS XD where XD.id_config_peso = tbl_contr_val_peso_sug.id)')
										->groupBy('id_config_peso')
										->groupBy('tbl_contr_val_peso_sug.id')
										->orderBy('cont_id_config_peso', 'DESC')
										->first();
		if(isset($id_config_peso->id_config_peso)){
			$id_config_peso_var = $id_config_peso->id_config_peso;
		}else{
			$id_config_peso_var = 0;
		}

		$cant_val = DB::table('tbl_contr_val_peso_atrib')->select('id')->where('id_config_peso', $id_config_peso_var)->count();
		$data = DB::table('tbl_tienda')
					->join('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_tienda.id_ciudad')
					->join('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_ciudad.id_departamento')
					->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_departamento.id_pais')
					->select('tbl_tienda.id as id_tienda', 'tbl_ciudad.id as id_ciudad', 'tbl_departamento.id as id_departamento', 'tbl_pais.id as id_pais')
					->where('tbl_tienda.id', $tienda)
					->first();
					

		return DB::table('tbl_contr_val_peso_sug')
				->select('valor_x_1', 'valor_minimo_x_1', 'valor_maximo_x_1')
				->where(function ($query) use ($categoria, $data, $id_config_peso, $cant_val, $array_valores, $id_config_peso_var){
					$query->where('tbl_contr_val_peso_sug.id_tienda', '=', $data->id_tienda);
					$query->where('tbl_contr_val_peso_sug.id_categoria_general', '=', $categoria);
					
					if(count($id_config_peso) > 0){
						$query->where('tbl_contr_val_peso_sug.id', '=', $id_config_peso_var);
						$query->where('tbl_contr_val_peso_sug.valores_especificos', '=', 1);
					}else{
						$query->where('tbl_contr_val_peso_sug.valores_especificos', '=', 0);
					}
				})
				->orWhere(function ($query) use ($categoria, $data, $id_config_peso, $cant_val, $array_valores, $id_config_peso_var){
					$query->where('tbl_contr_val_peso_sug.id_ciudad', '=', $data->id_ciudad);
					$query->where('tbl_contr_val_peso_sug.id_categoria_general', '=', $categoria);
					
					if(count($id_config_peso) > 0){
						$query->where('tbl_contr_val_peso_sug.id', '=', $id_config_peso_var);
						$query->where('tbl_contr_val_peso_sug.valores_especificos', '=', 1);
					}else{
						$query->where('tbl_contr_val_peso_sug.valores_especificos', '=', 0);
					}
				})
				->orWhere(function ($query) use ($categoria, $data, $id_config_peso, $cant_val, $array_valores, $id_config_peso_var){
					$query->where('tbl_contr_val_peso_sug.id_departamento', '=', $data->id_departamento);
					$query->where('tbl_contr_val_peso_sug.id_categoria_general', '=', $categoria);
					
					if(count($id_config_peso) > 0){
						$query->where('tbl_contr_val_peso_sug.id', '=', $id_config_peso_var);
						$query->where('tbl_contr_val_peso_sug.valores_especificos', '=', 1);
					}else{
						$query->where('tbl_contr_val_peso_sug.valores_especificos', '=', 0);
					}
				})
				->orWhere(function ($query) use ($categoria, $data, $id_config_peso, $cant_val, $array_valores, $id_config_peso_var){
					$query->where('tbl_contr_val_peso_sug.id_pais', '=', $data->id_pais);
					$query->where('tbl_contr_val_peso_sug.id_categoria_general', '=', $categoria);
					
					if(count($id_config_peso) > 0){
						$query->where('tbl_contr_val_peso_sug.id', '=', $id_config_peso_var);
						$query->where('tbl_contr_val_peso_sug.valores_especificos', '=', 1);
					}else{
						$query->where('tbl_contr_val_peso_sug.valores_especificos', '=', 0);
					}
				})
				->orderBy('id_pais', 'DESC')
				->orderBy('id_departamento', 'DESC')
				->orderBy('id_ciudad', 'DESC')
				->orderBy('id_tienda', 'DESC')
				->first();
	}

	public static function getTerRetGen($id_categoria_general){
		return DB::table('tbl_contr_configuracion')
					->select('termino_contrato', 'porcentaje_retroventa')
					->where('id_categoria_general', $id_categoria_general)
					->first();
	}

	public static function getContratoById($codigo,$id_tienda){
		return ModelCabeceraContrato::join('tbl_cliente', function ($join) {
										$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_contr_cabecera.codigo_cliente');
										$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_cliente');
									})
									->leftJoin('tbl_contr_prorroga', function($join){
										$join->on('tbl_contr_prorroga.id_tienda_contrato', '=', 'tbl_contr_cabecera.id_tienda_contrato');
										$join->on('tbl_contr_prorroga.codigo_contrato', '=', 'tbl_contr_cabecera.codigo_contrato');
									})
									->join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
									->leftJoin('tbl_clie_confiabilidad','tbl_clie_confiabilidad.id','tbl_cliente.id_confiabilidad')
									->join('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
									->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_contr_cabecera.id_estado_contrato')
									->leftJoin('tbl_sys_motivo','tbl_sys_motivo.id','tbl_contr_cabecera.id_motivo_contrato')
									->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
									->select(
											DB::Raw('Concat(tbl_contr_cabecera.codigo_contrato,"/",tbl_contr_cabecera.id_tienda_contrato) AS DT_RowId'),
											'tbl_contr_cabecera.cod_bolsa_seguridad_desde',
											'tbl_contr_cabecera.porcentaje_retroventa',
											'tbl_contr_cabecera.termino',
											'tbl_contr_cabecera.cod_bolsas_seguridad',
											'tbl_contr_cabecera.fecha_creacion',
											DB::Raw("IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion) AS fecha_terminacion"),
											'tbl_contr_cabecera.fecha_retroventa',
											'tbl_contr_cabecera.cod_bolsa_seguridad_hasta',
											'tbl_contr_cabecera.extraviado',
											DB::Raw("IF(timestampdiff(month,tbl_contr_cabecera.fecha_creacion,curdate()) = 1, CONCAT(timestampdiff(month,tbl_contr_cabecera.fecha_creacion,curdate()), ' Mes'), CONCAT(timestampdiff(month,tbl_contr_cabecera.fecha_creacion,curdate()), ' Meses')) AS meses_contrato"),
											DB::Raw('(SELECT CONCAT(COUNT(valor_ingresado), " Prórrogas") FROM tbl_contr_prorroga WHERE tbl_contr_prorroga.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_prorroga.codigo_contrato = tbl_contr_cabecera.codigo_contrato LIMIT 1) AS numero_prorrogas'),
											'tbl_tienda.nombre AS tienda',
											'tbl_prod_categoria_general.nombre AS categoria_general',
											'tbl_prod_categoria_general.id AS id_categoria_general',
											'tbl_sys_estado_tema.nombre AS estado_tema',
											DB::raw("(SELECT SUM(precio_ingresado) FROM tbl_contr_item_detalle WHERE id_codigo_contrato = ".$codigo." AND id_tienda = ".$id_tienda.") as monto"),
											'tbl_sys_motivo.nombre AS motivo_contrato',
											'tbl_clie_tipo_documento.nombre AS tipo_documento',
											'tbl_cliente.nombres',
											DB::raw('IF(tbl_cliente.segundo_apellido IS NULL, tbl_cliente.primer_apellido, concat(tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido)) as apellidos'),
											'tbl_cliente.numero_documento AS numero_documento',
											'tbl_cliente.correo_electronico AS correo_electronico',
											'tbl_cliente.fecha_nacimiento',
											'tbl_cliente.fecha_expedicion',
											'tbl_clie_confiabilidad.nombre AS confiabilidad'
											)	
									->where('tbl_contr_cabecera.codigo_contrato',$codigo)
									->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
									->where(function ($query) {
										$query->whereNull('tbl_contr_prorroga.fecha_terminacion');
										$query->orWhere('tbl_contr_prorroga.fecha_terminacion', DB::raw('(SELECT MAX(tbl_contr_prorroga.fecha_terminacion) FROM tbl_contr_prorroga WHERE tbl_contr_prorroga.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_prorroga.codigo_contrato = tbl_contr_cabecera.codigo_contrato )'));
									})
						        	->first();
	}

	public static function infoActualContrato($codigo_contrato, $tienda_contrato, $porcentaje_menos, $meses_menos, $dias_gracia){
		return DB::select('CALL info_actual_contrato (?,?,?,?, ?)',array($codigo_contrato, $tienda_contrato, $porcentaje_menos, $meses_menos, $dias_gracia));
	}

	public static function Create($dataSaved){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_cabecera')->insert($dataSaved);		
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;			
			DB::rollback();
		}
		return $result;
	}

	public static function actualizarContrato($codigo, $tienda, $dataSaved){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_cabecera')->where('id_tienda_contrato', $tienda)->where('codigo_contrato', $codigo)->update($dataSaved);		
			DB::commit();
		}catch(\Exception $e){
			$result=false;			
			DB::rollback();
		}
		return $result;
	}


	public static function Update($id,$dataSaved){	
		return ModelCabeceraContrato::where('id',$id)->update($dataSaved);	
	}


	public static function crearAuditoria($parametros){
		$result=true;
		try{
			DB::beginTransaction();	
			DB::select('CALL crear_auditoria (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',array
				(
					null,
					null,
					$parametros['fecha_transaccion'],
					$parametros['id_modulo'],
					$parametros['id_usuario'],
					$parametros['numero_1'],
					$parametros['dato_1'],
					$parametros['fecha_1'],
					$parametros['numero_2'],
					$parametros['dato_2'],
					$parametros['fecha_2'],
					$parametros['numero_3'],
					$parametros['dato_3'],
					$parametros['fecha_3'],
					$parametros['transaccion'],
					$parametros['operacion'],
					$parametros['log'],
				)
			);
			DB::commit();
		}catch(\Exception $e){
			$result=false;			
			DB::rollback();
		}
		return $result;
	}



/** ******************************
*** Métodos Para Aplazar Contratos
**  *****************************/

	public static function CrearAplazo($dataSaved){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_aplazo')->insert($dataSaved);
			DB::commit();
		}catch(\Exception $e){
			// dd($e);
			$result=false;			
			DB::rollback();
		}
		return $result;
	}

	public static function getAplazosById($id){
		return ModelCabeceraContrato::join('tbl_contr_aplazo', function ($join) {
										$join->on('tbl_contr_cabecera.id_tienda_contrato' , '=' , 'tbl_contr_aplazo.id_tienda_contrato');
										$join->on('tbl_contr_cabecera.codigo_contrato' , '=' , 'tbl_contr_aplazo.codigo_contrato');
									})
									->select('tbl_contr_cabecera.codigo_contrato AS id',
											'tbl_contr_cabecera.id_tienda_contrato',
											'tbl_contr_aplazo.fecha_aplazo',
											'tbl_contr_aplazo.comentario'
											)
									->where('tbl_contr_cabecera.codigo_contrato',$id)
                                    ->orderBy('tbl_contr_aplazo.fecha_aplazo', 'ASC')	
                                    ->orderBy('tbl_contr_aplazo.fecha_aplazo', 'DESC')	
									->get();
	}
	
	public static function ContarAplazadosPorId($codigo,$id_tienda){
		return ModelCabeceraContrato::join('tbl_contr_aplazo', function ($join) {
										$join->on('tbl_contr_cabecera.id_tienda_contrato' , '=' , 'tbl_contr_aplazo.id_tienda_contrato');
										$join->on('tbl_contr_cabecera.codigo_contrato' , '=' , 'tbl_contr_aplazo.codigo_contrato');
									})
									->select('tbl_contr_cabecera.codigo_contrato AS id',
											'tbl_contr_cabecera.id_tienda_contrato',
											'tbl_contr_aplazo.fecha_aplazo',
											'tbl_contr_aplazo.comentario'
											)
									->where('tbl_contr_cabecera.codigo_contrato',$codigo)
									->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
									->count();
	}

	public static function getUltimoPlazo($codigo,$id_tienda){
		return ModelCabeceraContrato::join('tbl_contr_aplazo', function ($join) {
										$join->on('tbl_contr_cabecera.id_tienda_contrato' , '=' , 'tbl_contr_aplazo.id_tienda_contrato');
										$join->on('tbl_contr_cabecera.codigo_contrato' , '=' , 'tbl_contr_aplazo.codigo_contrato');
									})
									->select('tbl_contr_cabecera.codigo_contrato AS id',
											'tbl_contr_cabecera.id_tienda_contrato',
											'tbl_contr_aplazo.fecha_aplazo',
											'tbl_contr_aplazo.comentario'
											)
									->where('tbl_contr_cabecera.codigo_contrato',$codigo)
									->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
                                    ->orderBy('tbl_contr_aplazo.fecha_aplazo', 'DESC')	
									->first();
	}

	public static function AplazarById($start,$end,$colum,$order,$codigo){
		return ModelCabeceraContrato::join('tbl_cliente', function ($join) {
										$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_contr_cabecera.codigo_cliente');
										$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_cliente');
									})
									->join('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
									->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_contr_cabecera.id_estado_contrato')
									->leftJoin('tbl_sys_motivo','tbl_sys_motivo.id','tbl_contr_cabecera.id_motivo_contrato')
									->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
									->select(
											DB::Raw('Concat(tbl_contr_cabecera.codigo_contrato,"/",tbl_contr_cabecera.id_tienda_contrato) AS DT_RowId'),
											'tbl_contr_cabecera.cod_bolsa_seguridad_desde',
											'tbl_contr_cabecera.porcentaje_Retroventa',
											'tbl_contr_cabecera.termino',
											'tbl_contr_cabecera.fecha_creacion',
											'tbl_contr_cabecera.cod_bolsa_seguridad_hasta',
											'tbl_tienda.nombre AS tienda',
											'tbl_prod_categoria_general.nombre AS categoria_general',
											'tbl_prod_categoria_general.nombre AS categoria_general',
											'tbl_sys_estado_tema.nombre AS estado_tema',
											'tbl_sys_motivo.nombre AS motivo_contrato',
											'fecha_ultima_actualizacion'
											)	
									->where('tbl_contr_cabecera.codigo_contrato',$codigo)
                                    ->orderBy('tbl_contr_aplazo.fecha_aplazo', 'DESC')	
						        	->get();
	
	}


	public static function getItemsContratoById($codigo,$id_tienda){
		return ModelCabeceraContrato::join('tbl_cliente', function ($join) {
										$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_contr_cabecera.codigo_cliente');
										$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_cliente');
									})
									->join('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
									->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
									->join('tbl_contr_detalle', function ($join) {
										$join->on('tbl_contr_detalle.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
										$join->on('tbl_contr_detalle.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
									})
									->join('tbl_contr_item_detalle', function ($join) {
										$join->on('tbl_contr_item_detalle.id_codigo_contrato' , '=' , 'tbl_contr_detalle.codigo_contrato');
										$join->on('tbl_contr_item_detalle.id_tienda' , '=' , 'tbl_contr_detalle.id_tienda');
										$join->on('tbl_contr_item_detalle.id_linea_item_contrato', '=' ,'tbl_contr_detalle.id_linea_item_contrato'  );
										
									})
									->leftJoin('tbl_contr_item', function ($join) {
										$join->on('tbl_contr_item.id', '=' ,'tbl_contr_item_detalle.id_item_contrato' );
									})
									->select(
											'tbl_tienda.nombre AS tienda',
											'tbl_prod_categoria_general.nombre AS categoria_general',
											'tbl_contr_detalle.id_linea_item_contrato',
											DB::raw("tbl_contr_item_detalle.precio_ingresado as precio_ingresado"),
											DB::raw("(SELECT SUM(precio_ingresado) FROM tbl_contr_item_detalle WHERE id_codigo_contrato = ".$codigo." AND id_tienda = ".$id_tienda.") as precio_ingresado_total"),
											'tbl_contr_item_detalle.peso_estimado',
											'tbl_contr_item_detalle.observaciones AS descripcion_item',
											'tbl_contr_item_detalle.nombre AS nombre_item'
											)	
									->where('tbl_contr_cabecera.codigo_contrato',$codigo)
									->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
						        	->get();
	}

	
public static function getItem($start,$end,$colum,$order, $codigoContrato,$idTiendaContrato){
		return ModelCabeceraContrato::leftJoin('tbl_cliente', function ($join) {
											$join->on('tbl_cliente.codigo_cliente', '=', 'tbl_contr_cabecera.codigo_cliente' );
											$join->on('tbl_cliente.id_tienda', '=', 'tbl_contr_cabecera.id_tienda_cliente');
										})
										->leftJoin('tbl_tienda', function ($join) {
											$join->on('tbl_tienda.id', '=' ,'tbl_contr_cabecera.id_tienda_contrato' );
										})
										->leftJoin('tbl_contr_detalle', function ($join) {
											$join->on('tbl_contr_detalle.codigo_contrato', '=', 'tbl_contr_cabecera.codigo_contrato' );
											$join->on('tbl_contr_detalle.id_tienda', '=', 'tbl_contr_cabecera.id_tienda_contrato' );
										})
										->leftJoin('tbl_contr_item_detalle', function ($join) {
											$join->on('tbl_contr_item_detalle.id_codigo_contrato', '=' ,'tbl_contr_detalle.codigo_contrato' );
											$join->on('tbl_contr_item_detalle.id_tienda', '=', 'tbl_contr_detalle.id_tienda'  );
											$join->on('tbl_contr_item_detalle.id_linea_item_contrato', '=' ,'tbl_contr_detalle.id_linea_item_contrato'  );
										})
										->leftJoin('tbl_contr_item', function ($join) {
											$join->on('tbl_contr_item.id', '=' ,'tbl_contr_item_detalle.id_item_contrato' );
										})
										->leftJoin('tbl_prod_categoria_general', function ($join) {
											$join->on('tbl_prod_categoria_general.id', '=' ,'tbl_contr_item.id_categoria_general' );
										})
										->leftJoin('tbl_clie_tipo_documento', function ($join) {
											$join->on('tbl_clie_tipo_documento.id','=','tbl_cliente.id_tipo_documento' );
										})
										->leftJoin('tbl_clie_confiabilidad', function ($join) {
											$join->on('tbl_clie_confiabilidad.id','=','tbl_cliente.id_confiabilidad' );
										})
										->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_contr_cabecera.id_estado_contrato')							
										->select(
											'tbl_contr_item_detalle.id_linea_item_contrato AS DT_RowId',
											'tbl_contr_cabecera.id_tienda_contrato AS Tienda_Contrato',
											'tbl_contr_cabecera.fecha_creacion AS Fecha_Creacion_Contrato',
											'tbl_contr_cabecera.porcentaje_retroventa AS Porcentaje_Retroventa_Contrato',
											'tbl_contr_cabecera.cod_bolsa_seguridad_hasta AS Numero_Bolsa_Seguridad_Contrato',
											'tbl_tienda.nombre AS Tienda_Contrato',
											'tbl_contr_cabecera.codigo_contrato AS Codigo_Contrato',
											DB::Raw("tbl_contr_cabecera.termino-tbl_contr_cabecera.cod_bolsa_seguridad_desde AS Termino_Contrato"),
											'tbl_contr_detalle.id_linea_item_contrato AS Linea_Item',
											'tbl_contr_item.nombre',
											'tbl_contr_item_detalle.nombre AS Nombre_Item',
											'tbl_contr_item_detalle.observaciones AS Descripcion_Item',
											'tbl_contr_item_detalle.precio_ingresado AS Precio_Item',
											'tbl_contr_item_detalle.peso_estimado AS Precio_Estimado_Item',
											'tbl_prod_categoria_general.nombre AS Categoria_Item',
											'tbl_clie_tipo_documento.nombre AS Tipo_Documento_Cliente',
											'tbl_cliente.numero_documento AS Numero_Documento_Cliente',
											'tbl_cliente.nombres AS Nombre_Cliente',
											DB::Raw("Concat(tbl_cliente.primer_apellido,' ',tbl_cliente.segundo_apellido ) AS Apellido_Cliente"),
											'tbl_cliente.correo_electronico AS Email_Cliente',
											'tbl_cliente.fecha_nacimiento AS Fecha_Nacimiento_Cliente',
											'tbl_clie_confiabilidad.nombre AS Alerta_Confiabilidad_Cliente',
											'tbl_sys_estado_tema.nombre AS Estado_Contrato'
										)
										->where('tbl_contr_cabecera.codigo_contrato',$codigoContrato)	
										->where('tbl_contr_cabecera.id_tienda_contrato',$idTiendaContrato)
										->skip($start)->take($end)									
										->orderBy($colum, $order)
										->get();
	}

	public static function getItemContrato($id_categoria_general){
		return DB::table('tbl_contr_item')->select('id')->where('id_categoria_general', $id_categoria_general)->first();
	}

	public static function getItemsContrato($id_codigo_contrato, $id_tienda_contrato){
		return ModelCabeceraContrato::leftJoin('tbl_cliente', function ($join) {
											$join->on('tbl_cliente.codigo_cliente', '=', 'tbl_contr_cabecera.codigo_cliente' );
											$join->on('tbl_cliente.id_tienda', '=', 'tbl_contr_cabecera.id_tienda_cliente');
										})
										->leftJoin('tbl_tienda', function ($join) {
											$join->on('tbl_tienda.id', '=' ,'tbl_contr_cabecera.id_tienda_contrato' );
										})
										->leftJoin('tbl_contr_detalle', function ($join) {
											$join->on('tbl_contr_detalle.codigo_contrato', '=', 'tbl_contr_cabecera.codigo_contrato' );
											$join->on('tbl_contr_detalle.id_tienda', '=', 'tbl_contr_cabecera.id_tienda_contrato' );
										})
										->leftJoin('tbl_contr_item_detalle', function ($join) {
											$join->on('tbl_contr_item_detalle.id_codigo_contrato', '=' ,'tbl_contr_detalle.codigo_contrato' );
											$join->on('tbl_contr_item_detalle.id_tienda', '=', 'tbl_contr_detalle.id_tienda'  );
											$join->on('tbl_contr_item_detalle.id_linea_item_contrato', '=' ,'tbl_contr_detalle.id_linea_item_contrato'  );
										})
										->leftJoin('tbl_contr_item', function ($join) {
											$join->on('tbl_contr_item.id', '=' ,'tbl_contr_item_detalle.id_item_contrato' );
										})
										->leftJoin('tbl_prod_categoria_general', function ($join) {
											$join->on('tbl_prod_categoria_general.id', '=' ,'tbl_contr_item.id_categoria_general' );
										})
										->leftJoin('tbl_clie_tipo_documento', function ($join) {
											$join->on('tbl_clie_tipo_documento.id','=','tbl_cliente.id_tipo_documento' );
										})
										->leftJoin('tbl_clie_confiabilidad', function ($join) {
											$join->on('tbl_clie_confiabilidad.id','=','tbl_cliente.id_confiabilidad' );
										})
										->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_contr_cabecera.id_estado_contrato')							
										->select(
											'tbl_contr_item_detalle.id_linea_item_contrato AS DT_RowId',
											'tbl_contr_cabecera.id_tienda_contrato AS Tienda_Contrato',
											'tbl_contr_cabecera.fecha_creacion AS Fecha_Creacion_Contrato',
											'tbl_contr_cabecera.porcentaje_retroventa AS Porcentaje_Retroventa_Contrato',
											'tbl_contr_cabecera.cod_bolsa_seguridad_hasta AS Numero_Bolsa_Seguridad_Contrato',
											'tbl_tienda.nombre AS Tienda_Contrato',
											'tbl_contr_cabecera.codigo_contrato AS Codigo_Contrato',
											DB::Raw("tbl_contr_cabecera.termino-tbl_contr_cabecera.cod_bolsa_seguridad_desde AS Termino_Contrato"),
											'tbl_contr_detalle.id_linea_item_contrato AS Linea_Item',
											'tbl_contr_item.nombre',
											'tbl_contr_item_detalle.nombre AS Nombre_Item',
											'tbl_contr_item_detalle.observaciones AS Descripcion_Item',
											DB::Raw("CONCAT('$ ', FORMAT((tbl_contr_item_detalle.precio_ingresado),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS Precio_Item"),
											DB::Raw("FORMAT((tbl_contr_item_detalle.peso_estimado),2,'de_DE') AS Precio_Estimado_Item"),
											DB::Raw("FORMAT((tbl_contr_item_detalle.peso_total),2,'de_DE') AS Peso_Total_Item"),
											'tbl_prod_categoria_general.nombre AS Categoria_Item',
											'tbl_clie_tipo_documento.nombre AS Tipo_Documento_Cliente',
											'tbl_cliente.numero_documento AS Numero_Documento_Cliente',
											'tbl_cliente.nombres AS Nombre_Cliente',
											DB::Raw("Concat(tbl_cliente.primer_apellido,' ',tbl_cliente.segundo_apellido ) AS Apellido_Cliente"),
											'tbl_cliente.correo_electronico AS Email_Cliente',
											'tbl_cliente.fecha_nacimiento AS Fecha_Nacimiento_Cliente',
											'tbl_clie_confiabilidad.nombre AS Alerta_Confiabilidad_Cliente',
											'tbl_sys_estado_tema.nombre AS Estado_Contrato'
										)
										->where('tbl_contr_cabecera.codigo_contrato',$id_codigo_contrato)	
										->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda_contrato)
										->get();
	}

	public static function getResumen($id_tienda_contrato, $id_codigo_contrato){
		return ModelCabeceraContrato::leftJoin('tbl_cliente', function ($join) {
										$join->on('tbl_cliente.codigo_cliente', '=', 'tbl_contr_cabecera.codigo_cliente' );
										$join->on('tbl_cliente.id_tienda', '=', 'tbl_contr_cabecera.id_tienda_cliente');
									})
									->leftJoin('tbl_tienda', function ($join) {
										$join->on('tbl_tienda.id', '=' ,'tbl_contr_cabecera.id_tienda_contrato' );
									})
									->leftJoin('tbl_zona', function ($join) {
										$join->on('tbl_zona.id', '=' ,'tbl_tienda.id_zona' );
									})
									->leftJoin('tbl_contr_detalle', function ($join) {
										$join->on('tbl_contr_detalle.codigo_contrato', '=', 'tbl_contr_cabecera.codigo_contrato' );
										$join->on('tbl_contr_detalle.id_tienda', '=', 'tbl_contr_cabecera.id_tienda_contrato' );
									})
									->leftJoin('tbl_contr_item_detalle', function ($join) {
										$join->on('tbl_contr_item_detalle.id_codigo_contrato', '=' ,'tbl_contr_detalle.codigo_contrato' );
										$join->on('tbl_contr_item_detalle.id_tienda', '=', 'tbl_contr_detalle.id_tienda'  );
										$join->on('tbl_contr_item_detalle.id_linea_item_contrato', '=' ,'tbl_contr_detalle.id_linea_item_contrato'  );
									})
									->leftJoin('tbl_contr_item', function ($join) {
										$join->on('tbl_contr_item.id', '=' ,'tbl_contr_item_detalle.id_item_contrato' );
									})
									->leftJoin('tbl_prod_categoria_general', function ($join) {
										$join->on('tbl_prod_categoria_general.id', '=' ,'tbl_contr_item.id_categoria_general' );
									})
									->leftJoin('tbl_clie_tipo_documento', function ($join) {
										$join->on('tbl_clie_tipo_documento.id','=','tbl_cliente.id_tipo_documento' );
									})
									->leftJoin('tbl_clie_confiabilidad', function ($join) {
										$join->on('tbl_clie_confiabilidad.id','=','tbl_cliente.id_confiabilidad' );
									})
									->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_contr_cabecera.id_estado_contrato')							
									->select(
										'tbl_tienda.nombre AS tienda',
										'tbl_zona.nombre AS zona',
										'tbl_cliente.nombres AS nombres_cliente',
										DB::Raw("CONCAT(tbl_cliente.primer_apellido,' ',tbl_cliente.segundo_apellido ) AS apellidos_cliente"),
										'tbl_contr_cabecera.codigo_ AS Tienda_Contrato',
										'tbl_contr_cabecera.fecha_creacion AS Fecha_Creacion_Contrato',
										'tbl_contr_cabecera.porcentaje_retroventa AS Porcentaje_Retroventa_Contrato',
										'tbl_contr_cabecera.cod_bolsa_seguridad_hasta AS Numero_Bolsa_Seguridad_Contrato'
									)
									->where('tbl_contr_cabecera.codigo_contrato',$codigoContrato)	
									->where('tbl_contr_cabecera.id_tienda_contrato',$idTiendaContrato)	
									->get();
	}

	public static function guardarTercero($data){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_tercero')->insert($data);
			DB::commit();
		}catch(\Exception $e){
			$result=false;
			DB::rollback();
		}
		return $result;
	}

	public static function guardarItem($data){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_item_detalle')->insert($data);		
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;			
			DB::rollback();
		}
		return $result;
	}

	public static function guardarDetalle($data){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_detalle')->insert($data);
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;
			DB::rollback();
		}
		return $result;
	}

	public static function guardarDetalleValores($data){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_item_detalle_atr_val')->insert($data);
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;
			DB::rollback();
		}
		return $result;
	}

	public static function getCountItemsContrato($codigoContrato, $idTiendaContrato){
		return DB::table('tbl_contr_item_detalle')->where('id_tienda',$idTiendaContrato)	
		->where('id_codigo_contrato',$codigoContrato)->count();
	}

	public static function getLineaItem($codigoContrato, $idTiendaContrato){
		return DB::table('tbl_contr_item_detalle')->select('id_linea_item_contrato')->where('id_tienda',$idTiendaContrato)	
		->where('id_codigo_contrato',$codigoContrato)->orderBy('id_linea_item_contrato', 'desc')->first();
	}

	public static function getUltimoCodBolsa($id_tienda){
		return DB::table('tbl_secuencia_tienda_x')->where('id_tienda', $id_tienda)->where('sec_tipo', env('SECUENCIA_TIPO_CODIGO_BOLSA_SEGURIDAD'))->value('sec_siguiente');
	}

	public static function getCodBolsasBloq($id_tienda, $ultimo_cod_bolsa){
		return DB::table('tbl_secuencia_config')->select('sec_invalida')->where('sec_invalida', '>=', $ultimo_cod_bolsa)->where('id_tienda', $id_tienda)->where('sec_tienda', env('SECUENCIA_TIPO_CODIGO_BOLSA_SEGURIDAD'))->get();
	}

	public static function getSecuenciaContrato($idtienda, $bolsas){
		return DB::select('CALL secuencias_tienda_contrato (?,?)',array($idtienda, $bolsas));
	}

	public static function getItemContratoDetalle($id, $id_tienda, $codigo_contrato){
		return DB::table('tbl_contr_item_detalle')->where('id_linea_item_contrato',$id)->where('id_tienda', $id_tienda)->where('id_codigo_contrato', $codigo_contrato)->first();
	}

	public static function deleteItem($id, $id_tienda, $codigo_contrato){
		DB::table('tbl_contr_item_detalle')->where('id_linea_item_contrato',$id)->where('id_tienda', $id_tienda)->where('id_codigo_contrato', $codigo_contrato)->delete();
		return DB::table('tbl_contr_detalle')->where('id_linea_item_contrato',$id)->where('id_tienda', $id_tienda)->where('codigo_contrato', $codigo_contrato)->delete();
	}

	public static function getTiendaByIp($ip){
		return (ModelTienda::select('id', 'nombre')
							->where('ip_fija', $ip)
							->limit(1)->first());
	}


	public static function getMaxAplazos($codigo,$id_tienda){
		return ModelCabeceraContrato::
							join('tbl_contr_dato_general','tbl_contr_dato_general.id_categoria_general','tbl_contr_dato_general.id_categoria_general')
							->join('tbl_parametro_general','tbl_parametro_general.id_pais','tbl_contr_dato_general.id_pais')
							->select('tbl_contr_dato_general.id', 'tbl_contr_dato_general.id_pais','tbl_contr_dato_general.cantidad_aplazos_contrato')
							->where('tbl_contr_cabecera.codigo_contrato',$codigo)
							->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
							->first();
	}


	/*Modulo Anular Contratos*/
	public static function getInfoAnular($codigoContrato,$idTiendaContrato){
		return ModelCabeceraContrato::leftJoin('tbl_cliente', function ($join) {
										$join->on('tbl_cliente.codigo_cliente', '=', 'tbl_contr_cabecera.codigo_cliente' );
										$join->on('tbl_cliente.id_tienda', '=', 'tbl_contr_cabecera.id_tienda_cliente');
									})
									->leftJoin('tbl_tienda', function ($join) {
										$join->on('tbl_tienda.id', '=' ,'tbl_contr_cabecera.id_tienda_contrato' );
									})
									->leftJoin('tbl_contr_detalle', function ($join) {
										$join->on('tbl_contr_detalle.codigo_contrato', '=', 'tbl_contr_cabecera.codigo_contrato' );
										$join->on('tbl_contr_detalle.id_tienda', '=', 'tbl_contr_cabecera.id_tienda_contrato' );
									})
									->leftJoin('tbl_contr_item_detalle', function ($join) {
										$join->on('tbl_contr_item_detalle.id_codigo_contrato', '=' ,'tbl_contr_detalle.codigo_contrato' );
										$join->on('tbl_contr_item_detalle.id_tienda', '=', 'tbl_contr_detalle.id_tienda'  );
										$join->on('tbl_contr_item_detalle.id_linea_item_contrato', '=' ,'tbl_contr_detalle.id_linea_item_contrato'  );
									})
									->leftJoin('tbl_contr_item', function ($join) {
										$join->on('tbl_contr_item.id', '=' ,'tbl_contr_item_detalle.id_item_contrato' );
									})
									->leftJoin('tbl_prod_categoria_general', function ($join) {
										$join->on('tbl_prod_categoria_general.id', '=' ,'tbl_contr_item.id_categoria_general' );
									})
									->leftJoin('tbl_clie_tipo_documento', function ($join) {
										$join->on('tbl_clie_tipo_documento.id','=','tbl_cliente.id_tipo_documento' );
									})
									->leftJoin('tbl_clie_confiabilidad', function ($join) {
										$join->on('tbl_clie_confiabilidad.id','=','tbl_cliente.id_confiabilidad' );
									})
									->leftJoin('tbl_sys_archivo',function ($join){
										$join->on('tbl_sys_archivo.id','=','tbl_contr_cabecera.id_certificado');
										$join->on('tbl_sys_archivo.id','=','tbl_contr_cabecera.id_denuncia');
										$join->on('tbl_sys_archivo.id','=','tbl_contr_cabecera.id_incautacion');
									})
									->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_contr_cabecera.id_estado_contrato')
									->leftJoin('tbl_sys_motivo','tbl_sys_motivo.id','tbl_contr_cabecera.id_motivo_contrato')						
									->select(
										'tbl_contr_cabecera.id_tienda_contrato',
										'tbl_contr_cabecera.fecha_creacion AS Fecha_Creacion_Contrato',
										'tbl_contr_cabecera.porcentaje_retroventa AS Porcentaje_Retroventa_Contrato',
										'tbl_contr_cabecera.cod_bolsa_seguridad_hasta AS Numero_Bolsa_Seguridad_Contrato',
										'tbl_tienda.nombre AS Tienda_Contrato',
										'tbl_contr_cabecera.codigo_contrato AS Codigo_Contrato',
										DB::Raw("tbl_contr_cabecera.termino-tbl_contr_cabecera.cod_bolsa_seguridad_desde AS Termino_Contrato"),
										'tbl_contr_detalle.id_linea_item_contrato AS Linea_Item',
										'tbl_contr_item.nombre AS Nombre_Item',
										'tbl_contr_item_detalle.observaciones AS Descripcion_Item',
										'tbl_contr_item_detalle.precio_ingresado AS Precio_Item',
										'tbl_contr_item_detalle.peso_estimado AS Precio_Estimado_Item',
										'tbl_prod_categoria_general.nombre AS Categoria_Item',
										'tbl_clie_tipo_documento.nombre AS Tipo_Documento_Cliente',
										'tbl_cliente.numero_documento AS Numero_Documento_Cliente',
										'tbl_cliente.nombres AS Nombre_Cliente',
										DB::Raw("Concat(tbl_cliente.primer_apellido,' ',tbl_cliente.segundo_apellido ) AS Apellido_Cliente"),
										'tbl_cliente.correo_electronico AS Email_Cliente',
										'tbl_cliente.fecha_nacimiento AS Fecha_Nacimiento_Cliente',
										'tbl_clie_confiabilidad.nombre AS Alerta_Confiabilidad_Cliente',
										'tbl_sys_estado_tema.nombre AS Estado_Contrato',
										'tbl_sys_motivo.nombre AS Motivo_Contrato',
										'tbl_sys_estado_tema.id AS Id_Contrato',
										'tbl_contr_cabecera.id_motivo_contrato',
										'tbl_contr_cabecera.id_certificado',
										'tbl_contr_cabecera.id_denuncia',
										'tbl_contr_cabecera.id_incautacion',
										'tbl_contr_cabecera.id_estado_contrato AS Id_Estado_Contrato'
									)
									->where('tbl_contr_cabecera.codigo_contrato',$codigoContrato)	
									->where('tbl_contr_cabecera.id_tienda_contrato',$idTiendaContrato)	
									->get();
	}

	public static function consultarArchivo($id)
	{
		return modelArchivo::select('nombre','tamanho')
							->where('id',$id)
							->first();
	}

	public static function ListMotivosEstado($id)
	{
		return ModelMotivoEstado::leftJoin('tbl_sys_motivo','tbl_sys_motivo_estado.id_motivo','tbl_sys_motivo.id')
								  ->select(
								  'tbl_sys_motivo.id',
								  'tbl_sys_motivo.nombre AS name'
								  )
								  ->where('tbl_sys_motivo_estado.id_estado',$id)
								  ->get();


	}


	public static function cambioEstadoPendienAprobacion($codigoContrato,$idTiendaContrato){
		return ModelCabeceraContrato::where('tbl_contr_cabecera.codigo_contrato',$codigoContrato)	
									->where('tbl_contr_cabecera.id_tienda_contrato',$idTiendaContrato)
									->update(['id_estado_contrato'=>env('ESTADO_CONTRATO_PENDIENTE')]);
	}

	public static function cambioEstadoAprobado($codigoContrato,$idTiendaContrato){
		return ModelCabeceraContrato::where('tbl_contr_cabecera.codigo_contrato',$codigoContrato)	
									->where('tbl_contr_cabecera.id_tienda_contrato',$idTiendaContrato)
									->update(['id_estado_contrato'=>env('ESTADO_CONTRATO_APROBADO')]);
	}

	public static function cambioEstadoAnulado($codigoContrato,$idTiendaContrato){
		return ModelCabeceraContrato::where('tbl_contr_cabecera.codigo_contrato',$codigoContrato)	
									->where('tbl_contr_cabecera.id_tienda_contrato',$idTiendaContrato)
									->update(['id_estado_contrato'=>env('ESTADO_CONTRATO_ANULADO')]);
	}

	public static function cambioEstadoRestablecer($codigoContrato,$idTiendaContrato){
		return ModelCabeceraContrato::where('tbl_contr_cabecera.codigo_contrato',$codigoContrato)	
									->where('tbl_contr_cabecera.id_tienda_contrato',$idTiendaContrato)
									->update(['id_estado_contrato'=>env('ESTADO_CONTRATO_RESTABLECER')]);
	}

	public static function getRetroventasById($id){
		return ModelCabeceraContrato::join('tbl_contr_prorroga', function ($join) {
										$join->on('tbl_contr_cabecera.id_tienda_contrato' , '=' , 'tbl_contr_prorroga.id_tienda_contrato');
										$join->on('tbl_contr_cabecera.codigo_contrato' , '=' , 'tbl_contr_prorroga.codigo_contrato');
									})
									->select('tbl_contr_cabecera.codigo_contrato AS id',
											'tbl_contr_cabecera.id_tienda_contrato',
											'tbl_contr_prorroga.valor_ingresado',
											'tbl_contr_prorroga.fecha_terminacion',
											'tbl_contr_prorroga.fecha_prorroga'
											)
									->where('tbl_contr_cabecera.codigo_contrato',$id)
                                    ->orderBy('tbl_contr_prorroga.fecha_prorroga', 'ASC')	
                                    ->orderBy('tbl_contr_prorroga.fecha_prorroga', 'DESC')	
									->get();
	}

	// Prorroga de contratos
	public static function CrearProrroga($dataSaved){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_prorroga')->insert($dataSaved);
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;			
			DB::rollback();
		}
		return $result;
	}
	
	public static function getProrrogasById($id){
		return ModelCabeceraContrato::join('tbl_contr_prorroga', function ($join) {
										$join->on('tbl_contr_cabecera.id_tienda_contrato' , '=' , 'tbl_contr_prorroga.id_tienda_contrato');
										$join->on('tbl_contr_cabecera.codigo_contrato' , '=' , 'tbl_contr_prorroga.codigo_contrato');
									})
									->select('tbl_contr_cabecera.codigo_contrato AS id',
											'tbl_contr_cabecera.id_tienda_contrato',
											'tbl_contr_prorroga.valor_ingresado',
											'tbl_contr_prorroga.fecha_terminacion',
											'tbl_contr_prorroga.fecha_prorroga',
											'tbl_contr_prorroga.meses_ingresados'
											)
									->where('tbl_contr_cabecera.codigo_contrato',$id)
                                    ->orderBy('tbl_contr_prorroga.fecha_prorroga', 'ASC')
									->get();
	}

	public static function getAbonoProrroga($contrato, $id_tienda){
		return DB::table('tbl_contr_prorroga_abono')->select('valor')->where('id_tienda_contrato', $id_tienda)->where('codigo_contrato', $contrato)->get();
	}

	public static function getSelectListById($table){
		return DB::table($table)->select('id','nombre AS name')
								->where('estado','1')
								->orderBy('nombre','ASC')
								->get();
	}

	public static function getFechaProrroga($contrato, $id_tienda){
		return DB::table('tbl_contr_prorroga')
					->select('fecha_terminacion')
					->where('id_tienda_contrato', $id_tienda)
					->where('codigo_contrato', $contrato)
					->orderBy('fecha_terminacion', 'DESC')
					->first();
	}

	public static function createAbonoProrroga($codigo, $id_tienda, $valor_ingresado){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_prorroga_abono')->insert(
				['id_tienda_contrato' => $id_tienda, 'codigo_contrato' => $codigo, 'valor' => $valor_ingresado]
			);		
			DB::commit();
		}catch(\Exception $e){
			// dd($e);
			$result=false;			
			DB::rollback();
		}
		return $result;
	}

	public static function updateAbonoProrroga($codigo, $id_tienda, $valor_ingresado){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_prorroga_abono')->where('id_tienda_contrato', $id_tienda)->where('codigo_contrato', $codigo)->update(
				['valor' => $valor_ingresado]
			);		
			DB::commit();
		}catch(\Exception $e){
			// dd($e);
			$result=false;			
			DB::rollback();
		}
		return $result;
	}

	public static function RetroventaPost($id,$id_tienda)
	{
		$resultado = true;
		try
		{
			return ModelCabeceraContrato::where('tbl_contr_cabecera.codigo_contrato',$id)	
										->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
										->update(['id_estado_contrato'=>31,'id_motivo_contrato' => 21 ,'fecha_retroventa' => date('Y-m-d h:i:s')]);
		}catch(\Exception $e)
		{
			$resultado = false;
		}
		return $resultado;
		
	}

	public static function reversarRetroventaPost($id,$id_tienda)
	{
		$resultado = true;
		try
		{
			return ModelCabeceraContrato::where('tbl_contr_cabecera.codigo_contrato',$id)	
										->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
										->update(['id_estado_contrato'=>48]);
		}catch(\Exception $e)
		{
			$resultado = false;
		}
		return $resultado;
		
	}

	public static function CerrarUpdate($id,$id_tienda)
	{
		$resultado = true;
		try
		{
			return ModelCabeceraContrato::where('tbl_contr_cabecera.codigo_contrato',$id)	
										->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
										->update(['id_estado_contrato'=>env('ESTADO_CONTRATO_CERRADO')]);
		}catch(\Exception $e)
		{
			$resultado = false;
		}
		return $resultado;
		
	}
	public static function ReversarCierreUpdate($id,$id_tienda)
	{
		$resultado = true;
		try
		{
			return ModelCabeceraContrato::where('tbl_contr_cabecera.codigo_contrato',$id)	
										->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
										->update(['id_estado_contrato'=>env('ESTADO_CONTRATO_RESTABLECER'),'id_motivo_contrato'=> 11]);
		}catch(\Exception $e)
		{
			$resultado = false;
		}
		return $resultado;
		
	}

	public static function SolicitudReversarCierreUpdate($id,$id_tienda,$id_motivo)
	{
		$resultado = true;
		try
		{
			return ModelCabeceraContrato::where('tbl_contr_cabecera.codigo_contrato',$id)	
										->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
										->update(['id_estado_contrato'=>env('ESTADO_CONTRATO_PENDIENTE_REVERSADO'),'id_motivo_contrato' => $id_motivo]);
		}
		catch(\Exception $e)
		{
			$resultado = false;
		}
		return $resultado;
		
	}

	public static function actualizarItem($data, $where){
		DB::table('tbl_contr_item_detalle')->where($where)->update($data);
	}

	public static function getInfoTercero($codigo, $tienda){
		return DB::table('tbl_contr_tercero')
		->where('id_codigo_contrato', $codigo)->where('id_tienda', $tienda)->get();
	}

	public static function actualizarTercero($codigo, $tienda, $data){
		return DB::table('tbl_contr_tercero')->where('id_codigo_contrato', $codigo)->where('id_tienda', $tienda)->update($data);
	}

	public static function SolicitudCerrarUpdate($id,$id_tienda,$id_motivo,$file1,$file2,$file3)
	{
		$resultado = true;
			try{
				DB::beginTransaction();
				ModelCabeceraContrato::where('tbl_contr_cabecera.codigo_contrato',$id)	
										->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
										->update(['id_estado_contrato'=>env('ESTADO_CONTRATO_PENDIENTE_CERRADO'),'id_motivo_contrato' => $id_motivo,'id_certificado'=> $file1,'id_denuncia'=>$file2,'id_incautacion'=>$file3]);
				DB::commit();
			}catch(\Exception $e)
			{
				$result=false;			
				DB::rollback();
			}
		return $resultado;
	}


	// Función para actualizar campo <extraviado> de la cabecera del contrato
	public static function contratoExtraviado($codigo_contrato, $tienda_contrato, $valor_extraviado){
		return ModelCabeceraContrato::where('codigo_contrato', $codigo_contrato)
									->where('id_tienda_contrato', $tienda_contrato)
									->update(['extraviado' => $valor_extraviado]);
	}

	public static function getContratoPDF($contrato, $tienda, $usuario){
		return ModelCabeceraContrato::join('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
									->leftJoin('tbl_ciudad AS ciudad_tienda','ciudad_tienda.id','tbl_tienda.id_ciudad')
									->leftJoin('tbl_departamento AS departamento_tienda','departamento_tienda.id','ciudad_tienda.id_departamento')
									->leftJoin('tbl_pais AS pais_tienda','pais_tienda.id','departamento_tienda.id_pais')
									->leftJoin('tbl_franquicia AS franquicia_tienda','franquicia_tienda.id','tbl_tienda.id_franquicia')
									->join('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
									->join('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_sociedad.id_regimen')
									->join('tbl_cliente', function ($join) {
										$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_contr_cabecera.codigo_cliente');
										$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_cliente');
									})
									->leftJoin('tbl_contr_detalle', function ($join) {
										$join->on('tbl_contr_detalle.codigo_contrato', '=', 'tbl_contr_cabecera.codigo_contrato' );
										$join->on('tbl_contr_detalle.id_tienda', '=', 'tbl_contr_cabecera.id_tienda_contrato' );
									})
									->leftJoin('tbl_contr_item_detalle', function ($join) {
										$join->on('tbl_contr_item_detalle.id_codigo_contrato', '=' ,'tbl_contr_detalle.codigo_contrato' );
										$join->on('tbl_contr_item_detalle.id_tienda', '=', 'tbl_contr_detalle.id_tienda'  );
										$join->on('tbl_contr_item_detalle.id_linea_item_contrato', '=' ,'tbl_contr_detalle.id_linea_item_contrato'  );
									})
									->leftJoin('tbl_ciudad AS ciudad_expedicion','ciudad_expedicion.id','tbl_cliente.id_ciudad_expedicion')
									->join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
									->leftJoin('tbl_clie_confiabilidad','tbl_clie_confiabilidad.id','tbl_cliente.id_confiabilidad')
									->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_contr_cabecera.id_estado_contrato')
									->leftJoin('tbl_sys_motivo','tbl_sys_motivo.id','tbl_contr_cabecera.id_motivo_contrato')
									->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
									->select(
											'tbl_tienda.nombre AS nombre_tienda',
											'tbl_tienda.direccion AS direccion_tienda',
											'ciudad_tienda.nombre AS ciudad_tienda',
											'tbl_tienda.telefono AS telefono_tienda',
											'tbl_sociedad.nit AS nit_sociedad',
											'tbl_sociedad.nombre AS nombre_sociedad',
											'tbl_sociedad.digito_verificacion AS digito_verificacion_sociedad',
											'tbl_sociedad.direccion AS direccion_sociedad',
											'tbl_clie_regimen_contributivo.nombre AS nombre_regimen',
											'tbl_contr_cabecera.codigo_contrato',
											'tbl_contr_cabecera.cod_bolsa_seguridad_desde',
											'tbl_contr_cabecera.porcentaje_retroventa',
											'tbl_contr_cabecera.termino',
											'tbl_contr_cabecera.fecha_creacion',
											'tbl_contr_cabecera.fecha_terminacion',
											'tbl_contr_cabecera.cod_bolsas_seguridad',
											DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),
											DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) + ((((SUM(tbl_contr_item_detalle.precio_ingresado) * tbl_contr_cabecera.porcentaje_retroventa) / 100) * tbl_contr_cabecera.termino )) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_retroventa"),
											DB::Raw("CONCAT('$ ', FORMAT((SELECT ((((SUM(tbl_contr_item_detalle.precio_ingresado) * tbl_contr_cabecera.porcentaje_retroventa) / 100) * tbl_contr_cabecera.termino )) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_retroventa_simple"),

											DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),0,'de_DE')) AS valor_contrato_texto"),
											DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) + ((((SUM(tbl_contr_item_detalle.precio_ingresado) * tbl_contr_cabecera.porcentaje_retroventa) / 100) * tbl_contr_cabecera.termino)) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),0,'de_DE')) AS valor_retroventa_texto"),
											DB::Raw("CONCAT(COALESCE(tbl_cliente.nombres,''), ' ', COALESCE(tbl_cliente.primer_apellido,''), ' ',  COALESCE(tbl_cliente.segundo_apellido,'')) as nombres"),
											'tbl_contr_cabecera.cod_bolsa_seguridad_hasta',
											DB::Raw("(tbl_contr_cabecera.cod_bolsa_seguridad_hasta - tbl_contr_cabecera.cod_bolsa_seguridad_desde) AS numero_bolsas"),
											'tbl_contr_cabecera.extraviado',
											DB::Raw("IF(timestampdiff(month,tbl_contr_cabecera.fecha_creacion,curdate()) = 1, CONCAT(timestampdiff(month,tbl_contr_cabecera.fecha_creacion,curdate()), ' Mes'), CONCAT(timestampdiff(month,tbl_contr_cabecera.fecha_creacion,curdate()), ' Meses')) AS meses_contrato"),
											DB::Raw('(SELECT CONCAT(SUM(meses_ingresados), " Prórrogas") FROM tbl_contr_prorroga WHERE tbl_contr_prorroga.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_prorroga.codigo_contrato = tbl_contr_cabecera.codigo_contrato LIMIT 1) AS numero_prorrogas'),
											DB::Raw('(SELECT fecha_terminacion FROM tbl_contr_prorroga WHERE tbl_contr_prorroga.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_prorroga.codigo_contrato = tbl_contr_cabecera.codigo_contrato ORDER BY fecha_prorroga DESC LIMIT 1) AS fecha_terminacion_prorroga'),
											DB::Raw("CONCAT('$ ', FORMAT((SELECT valor_ingresado FROM tbl_contr_prorroga WHERE tbl_contr_prorroga.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_prorroga.codigo_contrato = tbl_contr_cabecera.codigo_contrato ORDER BY fecha_prorroga DESC LIMIT 1),'de_DE')) AS valor_ingresado_prorroga"),
											'tbl_tienda.nombre AS tienda',
											'tbl_prod_categoria_general.nombre AS categoria_general',
											'tbl_prod_categoria_general.control_peso_contrato',
											'tbl_prod_categoria_general.aplica_bolsa',
											'tbl_sys_estado_tema.nombre AS estado_tema',
											'tbl_sys_motivo.nombre AS motivo_contrato',
											'tbl_clie_tipo_documento.nombre AS tipo_documento',
											'tbl_clie_tipo_documento.nombre_abreviado AS tipo_documento_abreviado',
											DB::raw('concat(tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido) AS apellidos'),
											'tbl_cliente.numero_documento AS numero_documento',
											DB::raw("REPLACE(FORMAT(tbl_cliente.numero_documento,0), ',', '.') AS numero_documento"),
											'tbl_cliente.correo_electronico AS correo_electronico',
											'tbl_cliente.fecha_nacimiento',
											'tbl_cliente.fecha_expedicion',
											'tbl_cliente.direccion_residencia AS direccion_cliente',
											DB::Raw("IF(tbl_cliente.telefono_celular IS NULL, tbl_cliente.telefono_residencia, tbl_cliente.telefono_celular) AS telefono"),
											'ciudad_expedicion.nombre AS ciudad_expedicion_cliente',
											'tbl_clie_confiabilidad.nombre AS confiabilidad',
											'tbl_contr_item_detalle.id_linea_item_contrato AS linea_item',
											'tbl_contr_item_detalle.nombre AS detalle',
											'tbl_contr_item_detalle.observaciones AS Descripcion_Item',
											DB::Raw("CONCAT('$ ', FORMAT(tbl_contr_item_detalle.precio_ingresado,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS precio_total"),
											DB::Raw("FORMAT(tbl_contr_item_detalle.peso_total,2,'de_DE') AS peso_total"),
											DB::Raw("FORMAT(tbl_contr_item_detalle.peso_estimado,2,'de_DE') AS peso_estimado"),
											DB::Raw("CONCAT(FORMAT((SELECT SUM(tbl_contr_item_detalle.peso_estimado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),2,'de_DE')) AS peso_estimado_total"),
											DB::Raw("CONCAT(FORMAT((SELECT SUM(tbl_contr_item_detalle.peso_total) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),2,'de_DE')) AS peso_total_total"),
											'franquicia_tienda.correo_habeas',
											DB::Raw("LPAD(pais_tienda.codigo_telefono,3,'0') AS cod_pais"),
											DB::Raw("LPAD(franquicia_tienda.codigo_franquicia,2,'0') AS cod_nombre_comercial"),
											DB::Raw("LPAD(tbl_sociedad.codigo_sociedad,2,'0') AS cod_sociedad"),
											DB::Raw("LPAD(tbl_tienda.codigo_tienda,3,'0') AS cod_tienda"),
											DB::Raw("LPAD(tbl_contr_cabecera.codigo_contrato,6,'0') AS cod_contrato_bar")
									)	
									->where('tbl_contr_cabecera.codigo_contrato',$contrato)
									->where('tbl_contr_cabecera.id_tienda_contrato',$tienda)
						        	->get();
	}

	public static function getInfoEmpleado($id_usuario){
		return DB::table('tbl_usuario')
		->join('tbl_cliente', 'tbl_cliente.id_usuario', '=', 'tbl_usuario.id')
		->join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
		->leftJoin('tbl_ciudad as ciudad_expedicion','ciudad_expedicion.id','tbl_cliente.id_ciudad_expedicion')
		->select(
			'tbl_cliente.nombres AS nombres_empleado',
			'tbl_cliente.primer_apellido AS primer_apellido_empleado',
			'tbl_cliente.segundo_apellido AS segundo_apellido_empleado',
			'tbl_clie_tipo_documento.nombre AS tipo_documento',
			'tbl_clie_tipo_documento.nombre_abreviado AS tipo_documento_abreviado',
			DB::raw("REPLACE(FORMAT(tbl_cliente.numero_documento,0), ',', '.') AS numero_documento"),
			'ciudad_expedicion.nombre AS ciudad_expedicion'

		)
		->where('tbl_usuario.id', $id_usuario)->distinct()->first();
	}

	public static function getColumnasItems( $contrato, $tienda ) {
		return DB::table('tbl_prod_atributo')
					->join('tbl_contr_cabecera', 'tbl_prod_atributo.id_cat_general', '=', 'tbl_contr_cabecera.id_categoria_general')
					->select('tbl_prod_atributo.nombre')
					->where('tbl_prod_atributo.columna_independiente_contrato', 1)
					->where('tbl_contr_cabecera.id_tienda_contrato', $tienda)
					->where('tbl_contr_cabecera.codigo_contrato', $contrato)->get();
	}

	public static function getDatosColumnasItems( $contrato, $tienda ) {
		return DB::table('tbl_contr_item_detalle_atr_val')
					->join('tbl_prod_atributo_valores', 'tbl_prod_atributo_valores.id', '=', 'tbl_contr_item_detalle_atr_val.id_atributo_valor')
					->join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'tbl_prod_atributo_valores.id_atributo')
					->select('tbl_prod_atributo_valores.nombre as valor', 'tbl_prod_atributo.nombre as atributo', 'tbl_contr_item_detalle_atr_val.id_linea_item_contrato as linea_item')
					->where('tbl_contr_item_detalle_atr_val.id_tienda', $tienda)
					->where('tbl_contr_item_detalle_atr_val.id_codigo_contrato', $contrato)
					->orderBy('tbl_contr_item_detalle_atr_val.id_linea_item_contrato')->distinct()->get();
	}

	public static function getColumnasItemsOrden( $orden, $tienda ) {
		return DB::table('tbl_prod_atributo')
					->join('tbl_orden', 'tbl_prod_atributo.id_cat_general', '=', 'tbl_orden.categoria')
					->select('tbl_prod_atributo.nombre')
					->where('tbl_prod_atributo.columna_independiente_contrato', 1)
					->where('tbl_orden.id_tienda_orden', $tienda)
					->where('tbl_orden.id_orden', $orden)->get();
	}

	public static function getDatosColumnasItemsOrden( $orden, $tienda ) {
		return DB::table('tbl_contr_item_detalle_atr_val')
					->join('tbl_prod_atributo_valores', 'tbl_prod_atributo_valores.id', '=', 'tbl_contr_item_detalle_atr_val.id_atributo_valor')
					->join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'tbl_prod_atributo_valores.id_atributo')
					->select('tbl_prod_atributo_valores.nombre as valor', 'tbl_prod_atributo.nombre as atributo', 'tbl_contr_item_detalle_atr_val.id_linea_item_contrato as linea_item')
					->where('tbl_contr_item_detalle_atr_val.id_tienda', $tienda)
					->where('tbl_contr_item_detalle_atr_val.id_codigo_contrato', $contrato)
					->orderBy('tbl_contr_item_detalle_atr_val.id_linea_item_contrato')->distinct()->get();
	}

	public static function getMoneda(){
		return DB::table('tbl_parametro_general')->join('tbl_sys_tipo_moneda', 'tbl_sys_tipo_moneda.id', '=', 'tbl_parametro_general.id_moneda')->select('tbl_sys_tipo_moneda.abreviatura')->first();
	}

	public static function aplicacionRetroventa($codigo, $id_tienda){
		$meses_transcurridos = DB::table('tbl_contr_cabecera')
								->join('tbl_contr_detalle', function ($join) {
									$join->on('tbl_contr_detalle.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
									$join->on('tbl_contr_detalle.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
								})
								->select(
									DB::raw('(TIMESTAMPDIFF(MONTH, tbl_contr_cabecera.fecha_creacion, curdate())  + IF(DAY(tbl_contr_cabecera.fecha_creacion) < DAY(curdate()), 1, 0)) as meses'),
									DB::raw("(SELECT SUM(precio_ingresado) FROM tbl_contr_item_detalle WHERE id_codigo_contrato = ".$codigo." AND id_tienda = ".$id_tienda.") as monto")
								)
								->where('tbl_contr_cabecera.id_tienda_contrato', $id_tienda)
								->where('tbl_contr_cabecera.codigo_contrato', $codigo)
								->first();

		$meses_transcurridos->meses = ($meses_transcurridos->meses == '') ? 0 : $meses_transcurridos->meses;
		$meses_transcurridos->monto = ($meses_transcurridos->monto == '') ? 0 : $meses_transcurridos->monto;
								
		$dias_transcurridos = DB::table('tbl_contr_cabecera')
								->select(DB::raw('ABS( SUM(TIMESTAMPDIFF(DAY, DATE_ADD( tbl_contr_cabecera.fecha_creacion, INTERVAL ('.$meses_transcurridos->meses.' - 1) MONTH ), curdate())) ) as dias'))
								->where('id_tienda_contrato', $id_tienda)
								->where('codigo_contrato', $codigo)
								->value('dias');

		// dd($meses_transcurridos->meses);

		// dd($meses_transcurridos->monto);
		return ModelCabeceraContrato::join('tbl_cliente', function ($join) {
										$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_contr_cabecera.codigo_cliente');
										$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_cliente');
									})
									->join('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
									->join('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
									->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
									->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
									->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
									->select(
										DB::Raw(
											'(SELECT menos_porcentaje_retroventas FROM tbl_contr_aplicacion_retroventa AS apli_retroventa
											WHERE (apli_retroventa.id_pais = tbl_pais.id)
											AND (apli_retroventa.id_departamento = tbl_departamento.id OR apli_retroventa.id_departamento = 0)
											AND (apli_retroventa.id_ciudad = tbl_ciudad.id OR apli_retroventa.id_ciudad = 0)
											AND (apli_retroventa.id_tienda = tbl_tienda.id OR apli_retroventa.id_tienda = 0)
											AND (apli_retroventa.meses_desde <= '.$meses_transcurridos->meses.')
											AND (apli_retroventa.meses_hasta >= '.$meses_transcurridos->meses.')
											AND (apli_retroventa.dias_desde <= '.$dias_transcurridos.')
											AND (apli_retroventa.dias_hasta >= '.$dias_transcurridos.')
											AND (apli_retroventa.monto_desde <= '.$meses_transcurridos->monto.')
											AND (apli_retroventa.monto_hasta >= '.$meses_transcurridos->monto.' OR apli_retroventa.monto_hasta = 0)) AS menos_porcentaje'),
										DB::Raw(
											'(SELECT 0) AS menos_meses')
									)	
									->where('tbl_contr_cabecera.codigo_contrato',$codigo)
									->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
									->first();
	}

	public static function aplicacionRetroventaBackup($codigo, $id_tienda){
		$meses_transcurridos = DB::table('tbl_contr_cabecera')
								->join('tbl_contr_detalle', function ($join) {
									$join->on('tbl_contr_detalle.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
									$join->on('tbl_contr_detalle.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
								})
								->select(
									DB::raw('SUM(TIMESTAMPDIFF(MONTH, tbl_contr_cabecera.fecha_creacion, curdate()) + 1) as meses'),
									DB::raw("(SELECT SUM(precio_ingresado) FROM tbl_contr_item_detalle WHERE id_codigo_contrato = ".$codigo." AND id_tienda = ".$id_tienda.") as monto")
								)
								->where('tbl_contr_cabecera.id_tienda_contrato', $id_tienda)
								->where('tbl_contr_cabecera.codigo_contrato', $codigo)
								->first();

		$meses_transcurridos->meses = ($meses_transcurridos->meses == '') ? 0 : $meses_transcurridos->meses;
		$meses_transcurridos->monto = ($meses_transcurridos->monto == '') ? 0 : $meses_transcurridos->monto;
		
		$dias_transcurridos = DB::table('tbl_contr_cabecera')
								->select(DB::raw('SUM(TIMESTAMPDIFF(DAY, DATE_ADD( tbl_contr_cabecera.fecha_creacion, INTERVAL ('.$meses_transcurridos->meses.' - 1) MONTH ), curdate())) as dias'))
								->where('id_tienda_contrato', $id_tienda)
								->where('codigo_contrato', $codigo)
								->value('dias');


		return ModelCabeceraContrato::join('tbl_cliente', function ($join) {
										$join->on('tbl_cliente.codigo_cliente' , '=' , 'tbl_contr_cabecera.codigo_cliente');
										$join->on('tbl_cliente.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_cliente');
									})
									->join('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
									->join('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
									->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
									->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
									->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
									->select(
										DB::Raw(
											'(SELECT menos_porcentaje_retroventas FROM tbl_contr_aplicacion_retroventa AS apli_retroventa
											WHERE (apli_retroventa.id_pais = tbl_pais.id)
											AND (apli_retroventa.id_departamento = tbl_departamento.id OR apli_retroventa.id_departamento = 0)
											AND (apli_retroventa.id_ciudad = tbl_ciudad.id OR apli_retroventa.id_ciudad = 0)
											AND (apli_retroventa.id_tienda = tbl_tienda.id OR apli_retroventa.id_tienda = 0)
											AND (apli_retroventa.meses_desde <= '.$meses_transcurridos->meses.')
											AND (apli_retroventa.meses_hasta <= '.$meses_transcurridos->meses.')
											AND (apli_retroventa.monto_desde <= '.$meses_transcurridos->monto.')
											AND (apli_retroventa.monto_hasta >= '.$meses_transcurridos->monto.')) AS menos_porcentaje'),
										DB::Raw(
											'(SELECT menos_meses FROM tbl_contr_aplicacion_retroventa AS apli_retroventa
											WHERE (apli_retroventa.id_pais = tbl_pais.id)
											AND (apli_retroventa.id_departamento = tbl_departamento.id OR apli_retroventa.id_departamento = 0)
											AND (apli_retroventa.id_ciudad = tbl_ciudad.id OR apli_retroventa.id_ciudad = 0)
											AND (apli_retroventa.id_tienda = tbl_tienda.id OR apli_retroventa.id_tienda = 0)
											AND (apli_retroventa.meses_transcurridos <= '.$dias_transcurridos.')
											AND (apli_retroventa.monto_desde <= '.$meses_transcurridos->monto.')
											AND (apli_retroventa.monto_hasta >= '.$meses_transcurridos->monto.')) AS menos_meses')
									)	
									->where('tbl_contr_cabecera.codigo_contrato',$codigo)
									->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
									->first();
	}

	public static function getDocumentoUsuario($id_usuario)
	{
		return DB::table('tbl_usuario')
					->join('tbl_cliente', 'tbl_cliente.id_usuario', '=', 'tbl_usuario.id')
					->select(
						'tbl_cliente.id_tipo_documento AS tipo_documento',
						'tbl_cliente.numero_documento'
					)
					->where('tbl_usuario.id', $id_usuario)
					->first();
	}

	public static function getAtributosValoresItem( $valores_item ){
		return (DB::table('tbl_prod_atributo_valores AS valores')
		->join('tbl_prod_atributo AS atributos', 'atributos.id', '=', 'valores.id_atributo')
		->join('tbl_prod_atributo_valores AS todos_valores', 'todos_valores.id_atributo', '=', 'atributos.id')
		->select(
			'atributos.id AS id_atributo',
			'atributos.nombre AS nombre_atributo',
			'atributos.valor_desde_contrato',
			'atributos.concatenar_nombre',
			'todos_valores.id as id_valor',
			'todos_valores.nombre AS nombre_valor',
			'atributos.id_atributo_padre AS id_atributo_padre',
			DB::raw('IF(valores.id = todos_valores.id, 1, 0) as valor_seleccionado'),
			DB::raw('IF(valores.id_atributo_padre = todos_valores.id_atributo_padre or todos_valores.id_atributo_padre = 0, 1, 0) as set_valor')
		)
		->whereIn('valores.id', $valores_item)
		->where(function ($query) {
			$query->whereRaw('atributos.id = atributos.id');
			$query->orWhere('atributos.id_atributo_padre', '=', 0);
		})
		->groupBy('todos_valores.id')
		->groupBy('atributos.id')
		->groupBy('atributos.nombre')
		->groupBy('atributos.concatenar_nombre')
		->groupBy('atributos.valor_desde_contrato')
		->groupBy('todos_valores.nombre')
		->groupBy('atributos.id_atributo_padre')
		->groupBy('valores.id_atributo_padre')
		->groupBy('todos_valores.id_atributo_padre')
		->groupBy('valor_seleccionado')
		->groupBy('set_valor')
		->orderBy('atributos.id', 'ASC')
		->orderBy('todos_valores.nombre', 'ASC')
		->get());
	}

	public static function docGenerCotr($tipo_documento){
		return DB::table('tbl_clie_tipo_documento')->where('id', $tipo_documento)->value('contrato');
	}
}


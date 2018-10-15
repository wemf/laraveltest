<?php

// Author				:	<Andrey Higuita>
// Create date	:	<Jueves, 15 de abril de 2018>
// Description	:	<Clase para insertar y actualizar los datos de la resolución en el primer paso (perfeccionamiento de contratos)>

namespace App\AccessObject\Nutibara\Contratos;

use App\Models\Nutibara\Contratos\ContratoCabecera AS ModelCabeceraContrato;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use DB;
use config\messages;
use Carbon;

class ResolucionarAO
{
	public static function getContratos($start, $end, $colum, $order, $search){
		$mytime = Carbon\Carbon::now();
		return (ModelCabeceraContrato::join('tbl_cliente', function ($join) {
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
															// ->leftJoin('tbl_contr_prorroga', function ($join) use ($mytime){
															// 	$join->on('tbl_contr_prorroga.id_tienda_contrato' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
															// 	$join->on('tbl_contr_prorroga.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
															// })
															->leftJoin('tbl_contr_prorroga', function($join)
															{
																$join->on('tbl_contr_prorroga.id_tienda_contrato' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
																$join->on('tbl_contr_prorroga.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
															})
															->leftJoin('tbl_contr_aplazo', function($join)
															{
																$join->on('tbl_contr_aplazo.id_tienda_contrato' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
																$join->on('tbl_contr_aplazo.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
															})
															->select(
																'tbl_contr_prorroga.id_tienda_contrato',
																'tbl_contr_prorroga.codigo_contrato',
																'tbl_contr_prorroga.fecha_terminacion',
																DB::Raw("IF(tbl_contr_prorroga.fecha_prorroga IS NULL, '', tbl_contr_prorroga.fecha_prorroga) AS fecha_prorroga"),
																'tbl_contr_cabecera.codigo_contrato AS DT_RowId',
																'tbl_contr_cabecera.cod_bolsa_seguridad_desde',
																'tbl_contr_cabecera.porcentaje_Retroventa',
																'tbl_contr_cabecera.termino',
																'tbl_contr_cabecera.fecha_creacion',
																'tbl_contr_cabecera.cod_bolsas_seguridad',
																'tbl_contr_cabecera.cod_bolsa_seguridad_hasta',
																'tbl_tienda.nombre AS tienda',
																'tbl_prod_categoria_general.nombre AS categoria_general',
																'tbl_prod_categoria_general.control_peso_contrato AS control_peso',
																'tbl_sys_estado_tema.nombre AS estado_tema',
																'tbl_sys_motivo.nombre AS motivo_contrato',
																'fecha_ultima_actualizacion',
																'tbl_contr_cabecera.fecha_terminacion',
																'tbl_contr_cabecera.codigo_contrato',
																DB::raw("REPLACE(FORMAT(tbl_cliente.numero_documento,0), ',', '.') AS documento_cliente"),
																DB::Raw("CONCAT(COALESCE(tbl_cliente.nombres,''), ' ', COALESCE(tbl_cliente.primer_apellido,''), ' ',  COALESCE(tbl_cliente.segundo_apellido,'')) as nombres_cliente"),
																'tbl_clie_tipo_documento.nombre_abreviado as tipo_documento',
																DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),
																DB::Raw('(SELECT COUNT(tbl_contr_item_detalle.id_codigo_contrato) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato) AS cantidad_items'),
																DB::Raw("FORMAT((SELECT SUM(tbl_contr_item_detalle.peso_estimado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato ),2,'de_DE') AS peso_estimado_total"),
																DB::Raw("FORMAT((SELECT SUM(tbl_contr_item_detalle.peso_total) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato ),2,'de_DE') AS peso_total_total"),
																DB::Raw('Concat(tbl_contr_cabecera.porcentaje_retroventa, "%") AS porcen_retroventa'),
																DB::Raw("IF((SELECT COUNT(id_tienda) FROM tbl_contr_tercero WHERE tbl_contr_tercero.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_tercero.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato) > 0, 'Si', 'No') AS reclamo_tercero"),
																DB::Raw("IF(tbl_contr_cabecera.extraviado = 1, 'Si', 'No') AS contrato_extraviado"),
																DB::Raw("(SUM(timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate()) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) )) AS meses_transcurridos"),
																DB::Raw("(timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) AS numero_prorrogas"),
																DB::Raw("(SUM((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) )) AS meses_adeudados"),
																DB::Raw("(SUM(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) - tbl_contr_cabecera.termino) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) )) AS meses_vencidos")
															)
															->where(function ($query) use ($search){
																$query->where('tbl_tienda.id', '=', $search['id_tienda']);
																$query->where('tbl_prod_categoria_general.id', '=', $search['id_categoria']);

																if($search['tipo_documento'] != ''){
																	$query->where('tbl_cliente.id_tipo_documento', '=', $search['tipo_documento']);
																}

																$query->where('tbl_cliente.numero_documento', 'LIKE', '%'.$search['numero_documento'].'%');

																if($search['numero_contrato_desde'] != ''){
																	$query->where('tbl_contr_cabecera.codigo_contrato', '>=', $search['numero_contrato_desde']);
																}

																if($search['numero_contrato_hasta'] != ''){
																	$query->where('tbl_contr_cabecera.codigo_contrato', '<=', $search['numero_contrato_hasta']);
																}

																if($search['dias_sin_prorroga'] != ''){
																	$query->where(DB::raw('DATEDIFF(curdate(), tbl_contr_prorroga.fecha_prorroga)'), '>=', $search['dias_sin_prorroga']);
																}

																if($search['vencidos_sin_plazo'] == 1){
																	$query->where(function ($query2) {
																		$query2->where('tbl_contr_aplazo.fecha_aplazo', '<', DB::raw('curdate()'));
																		$query2->orWhereNull('tbl_contr_aplazo.fecha_aplazo');
																	});
																}

																if ($search['meses_adeudados_1'] != '') {
																	switch ($search['meses_adeudados_2']) {
																		case '1':
																			$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), $search['meses_adeudados_1']);
																			break;

																		case '2':
																			$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '>', $search['meses_adeudados_1']);
																			break;

																		case '3':
																			$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '>=', $search['meses_adeudados_1']);
																			break;

																		case '4':
																			$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '<', $search['meses_adeudados_1']);
																			break;

																		case '5':
																			$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '<=', $search['meses_adeudados_1']);
																			break;

																		case '6':
																			$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '<>', $search['meses_adeudados_1']);
																			break;

																		case '7':
																			$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '>=', $search['meses_adeudados_1']);
																			$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '<=', $search['meses_adeudados_3']);
																			break;

																		default:

																			break;
																	}
																}
															})
															->where('tbl_contr_cabecera.id_estado_contrato', '=', env('ESTADO_CREACION_CONTRATO'))
															// ->where('tbl_contr_cabecera.fecha_terminacion', '<', $mytime->toDateTimeString())
															// ->where('tbl_contr_prorroga.fecha_terminacion', '<', $mytime->toDateTimeString())
															->where(DB::Raw('IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion) '), '<',  DB::raw('curdate()'))
															// ->orWhere('tbl_contr_prorroga.fecha_terminacion', 'MAX(tbl_contr_prorroga.fecha_terminacion)')
															->where(function ($query) {
																$query->whereNull('tbl_contr_prorroga.fecha_terminacion');
																$query->orWhere('tbl_contr_prorroga.fecha_terminacion', DB::raw('(SELECT MAX(tbl_contr_prorroga.fecha_terminacion) FROM tbl_contr_prorroga WHERE tbl_contr_prorroga.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_prorroga.codigo_contrato = tbl_contr_cabecera.codigo_contrato )'));
															})
															->where(function ($query) {
																$query->whereNull('tbl_contr_aplazo.fecha_aplazo');
																$query->orWhere('tbl_contr_aplazo.fecha_aplazo', DB::raw('(SELECT MAX(tbl_contr_aplazo.fecha_aplazo) FROM tbl_contr_aplazo WHERE tbl_contr_aplazo.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_aplazo.codigo_contrato = tbl_contr_cabecera.codigo_contrato )'));
															})
															->groupBy('tbl_contr_prorroga.codigo_contrato')
															->groupBy('tbl_contr_cabecera.codigo_contrato')
															->groupBy('tbl_contr_cabecera.id_tienda_contrato')
															->groupBy('tbl_contr_cabecera.cod_bolsa_seguridad_desde')
															->groupBy('tbl_contr_cabecera.cod_bolsa_seguridad_hasta')
															->groupBy('tbl_contr_cabecera.porcentaje_retroventa')
															->groupBy('tbl_contr_cabecera.termino')
															->groupBy('tbl_contr_cabecera.fecha_creacion')
															->groupBy('tienda')
															->groupBy('categoria_general')
															->groupBy('estado_tema')
															->groupBy('motivo_contrato')
															->groupBy('fecha_ultima_actualizacion')
															->groupBy('tbl_contr_cabecera.fecha_terminacion')
															->groupBy('nombres_cliente')
															->groupBy('tipo_documento')
															->groupBy('numero_documento')
															->groupBy('DT_RowId')
															->groupBy('extraviado')
															->groupBy('numero_prorrogas')
															->groupBy('tbl_contr_prorroga.id_tienda_contrato')
															->groupBy('tbl_contr_prorroga.codigo_contrato')
															->groupBy('tbl_contr_prorroga.fecha_terminacion')
															->groupBy('tbl_contr_prorroga.fecha_prorroga')
															->groupBy('tbl_contr_cabecera.cod_bolsas_seguridad')
															->groupBy('tbl_prod_categoria_general.control_peso_contrato')
															->orderBy($colum, $order)
															->skip($start)->take($end)
															->get());
	}

	public static function getCountContratos($start, $end, $colum, $order, $search){
		$mytime = Carbon\Carbon::now();
		return ModelCabeceraContrato::join('tbl_cliente', function ($join) {
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
										// ->leftJoin('tbl_contr_prorroga', function ($join) use ($mytime){
										// 	$join->on('tbl_contr_prorroga.id_tienda_contrato' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
										// 	$join->on('tbl_contr_prorroga.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
										// })
										->leftJoin('tbl_contr_prorroga', function($join)
										{
											$join->on('tbl_contr_prorroga.id_tienda_contrato' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
											$join->on('tbl_contr_prorroga.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
										})
										->leftJoin('tbl_contr_aplazo', function($join)
										{
											$join->on('tbl_contr_aplazo.id_tienda_contrato' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
											$join->on('tbl_contr_aplazo.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
										})
										->where(function ($query) use ($search){
											$query->where('tbl_tienda.id', '=', $search['id_tienda']);
											$query->where('tbl_prod_categoria_general.id', '=', $search['id_categoria']);

											if($search['tipo_documento'] != ''){
												$query->where('tbl_cliente.id_tipo_documento', '=', $search['tipo_documento']);
											}

											$query->where('tbl_cliente.numero_documento', 'LIKE', '%'.$search['numero_documento'].'%');

											if($search['numero_contrato_desde'] != ''){
												$query->where('tbl_contr_cabecera.codigo_contrato', '>=', $search['numero_contrato_desde']);
											}

											if($search['numero_contrato_hasta'] != ''){
												$query->where('tbl_contr_cabecera.codigo_contrato', '<=', $search['numero_contrato_hasta']);
											}

											if($search['dias_sin_prorroga'] != ''){
												$query->where(DB::raw('DATEDIFF(curdate(), tbl_contr_prorroga.fecha_prorroga)'), '>=', $search['dias_sin_prorroga']);
											}

											if($search['vencidos_sin_plazo'] == 1){
												$query->where(function ($query2) {
													$query2->where('tbl_contr_aplazo.fecha_aplazo', '<=', DB::raw('curdate()'));
													$query2->orWhereNull('tbl_contr_aplazo.fecha_aplazo');
												});
											}

											if ($search['meses_adeudados_1'] != '') {
												switch ($search['meses_adeudados_2']) {
													case '1':
														$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), $search['meses_adeudados_1']);
														break;

													case '2':
														$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '>', $search['meses_adeudados_1']);
														break;

													case '3':
														$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '>=', $search['meses_adeudados_1']);
														break;

													case '4':
														$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '<', $search['meses_adeudados_1']);
														break;

													case '5':
														$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '<=', $search['meses_adeudados_1']);
														break;

													case '6':
														$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '<>', $search['meses_adeudados_1']);
														break;

													case '7':
														$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '>=', $search['meses_adeudados_1']);
														$query->where(DB::raw('(((timestampdiff(month, tbl_contr_cabecera.fecha_creacion, curdate())) - (timestampdiff(month, tbl_contr_cabecera.fecha_terminacion, IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion))) + IF(DAY(tbl_contr_cabecera.fecha_creacion) <> DAY(curdate()), 1, 0 ) ))'), '<=', $search['meses_adeudados_3']);
														break;

													default:

														break;
												}
											}
										})
										->where('tbl_contr_cabecera.id_estado_contrato', '=', env('ESTADO_CREACION_CONTRATO'))
										// ->where('tbl_contr_cabecera.fecha_terminacion', '<', $mytime->toDateTimeString())
										// ->where('tbl_contr_prorroga.fecha_terminacion', '<', $mytime->toDateTimeString())
										->where(DB::Raw('IF(tbl_contr_prorroga.fecha_terminacion IS NULL, tbl_contr_cabecera.fecha_terminacion, tbl_contr_prorroga.fecha_terminacion) '), '<',  $mytime->toDateTimeString())
										// ->orWhere('tbl_contr_prorroga.fecha_terminacion', 'MAX(tbl_contr_prorroga.fecha_terminacion)')
										->where(function ($query) {
											$query->whereNull('tbl_contr_prorroga.fecha_terminacion');
											$query->orWhere('tbl_contr_prorroga.fecha_terminacion', DB::raw('(SELECT MAX(tbl_contr_prorroga.fecha_terminacion) FROM tbl_contr_prorroga WHERE tbl_contr_prorroga.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_prorroga.codigo_contrato = tbl_contr_cabecera.codigo_contrato )'));
										})
										->where(function ($query) {
											$query->whereNull('tbl_contr_aplazo.fecha_aplazo');
											$query->orWhere('tbl_contr_aplazo.fecha_aplazo', DB::raw('(SELECT MAX(tbl_contr_aplazo.fecha_aplazo) FROM tbl_contr_aplazo WHERE tbl_contr_aplazo.id_tienda_contrato = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_aplazo.codigo_contrato = tbl_contr_cabecera.codigo_contrato )'));
										})
										->skip($start)->take($end)
										->count();
	}

	public static function getTiendaByIp($ip){
		return ModelTienda::select('id', 'nombre')->where('ip_fija', $ip)->first();
	}

	public static function getListProceso($array_procesos){
		return DB::table('tbl_sys_tema')->select('id','nombre as name')
					->whereIn('id',$array_procesos)->get();
	}

	public static function getConfigProcesos( $cat_gen ){
		return DB::table('tbl_prod_categoria_general')
					->select('aplica_vitrina AS 0', 'aplica_refaccion AS 1', 'aplica_fundicion AS 2', 'aplica_maquila AS 3', 'aplica_joya_preciosa AS 4', 'aplica_maquila AS 5')
					->where('id', $cat_gen)
					->first();
	}

	public static function getItemsContrato($id_tienda,$array_contratos)
	{
		return ModelCabeceraContrato::join('tbl_contr_detalle', function($join){
											$join->on('tbl_contr_detalle.id_tienda', 'tbl_contr_cabecera.id_tienda_contrato')
												 ->on('tbl_contr_detalle.codigo_contrato', 'tbl_contr_cabecera.codigo_contrato');
										})
										->join('tbl_contr_item_detalle',function($join){
											$join->on('tbl_contr_item_detalle.id_tienda', 'tbl_contr_detalle.id_tienda')
											->on('tbl_contr_item_detalle.id_codigo_contrato', 'tbl_contr_detalle.codigo_contrato')
											->on('tbl_contr_item_detalle.id_linea_item_contrato', 'tbl_contr_detalle.id_linea_item_contrato');
										})
										->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
										->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
										->whereIn('tbl_contr_cabecera.codigo_contrato',$array_contratos)
									   	->select(
										    	'tbl_contr_cabecera.codigo_contrato',
												'tbl_contr_cabecera.id_tienda_contrato',
												'tbl_contr_cabecera.fecha_creacion',
												'tbl_contr_item_detalle.id_linea_item_contrato',
												'tbl_contr_item_detalle.nombre',
												'tbl_contr_item_detalle.observaciones',
												'tbl_contr_item_detalle.peso_total',
												'tbl_contr_item_detalle.peso_estimado',
												'tbl_contr_item_detalle.precio_ingresado',
												// DB::raw('(select SUM(precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_codigo_contrato = tbl_inventario_item_contrato.id_contrato AND tbl_contr_item_detalle.id_tienda = tbl_inventario_item_contrato.id_tienda_contrato) AS Suma_contrato'),
												DB::raw('cod_bolsa_seguridad_hasta - cod_bolsa_seguridad_desde AS Bolsas'),
												'tbl_prod_categoria_general.nombre as categoria',
												'tbl_prod_categoria_general.id as id_categoria',
												'tbl_prod_categoria_general.control_peso_contrato as control_peso'
									   	)
									   	->get();
	}
	public static function procesarHojaTrabajo($data_orden, $id_tienda_contrato, $codigo_contrato){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_cabecera')
							->where('id_tienda_contrato', $id_tienda_contrato)
							->whereIn('codigo_contrato', $codigo_contrato)
							->update(['id_estado_contrato' => env('ESTADO_CONTRATO_RESOLUCIONADO'), 'id_motivo_contrato' => env('MOTIVO_RESOLUCION_CONTRATO')]);
			DB::table('tbl_orden_hoja_trabajo_cabecera')->insert($data_orden[0][0]);
			DB::table('tbl_orden_hoja_trabajo_detalle')->insert($data_orden[0][1]);
			DB::table('tbl_orden')->insert($data_orden[0][2]);
			DB::table('tbl_orden_trazabilidad')->insert($data_orden[0][3]);
			// DB::table('tbl_inventario_item_contrato')->insert($data_orden[0][4]);
			// DB::table('tbl_inventario_producto')->insert($data_orden[0][5]);
			DB::table('tbl_orden_item')->insert($data_orden[0][6]);
			DB::table('tbl_orden_destinatario')->insert($data_orden[0][7]);
			DB::table('tbl_orden_guardar')
				->join('tbl_orden_guardar_items', 'tbl_orden_guardar.id', '=', 'tbl_orden_guardar_items.id_orden_guardar')
				->whereIn('tbl_orden_guardar_items.codigo_contrato', $codigo_contrato)
				->where('tbl_orden_guardar_items.id_tienda_contrato', $id_tienda_contrato)
				->update(['tbl_orden_guardar.id_estado' => env('ESTADO_CONTRATO_RESOLUCIONADO')]);
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;
			DB::rollback();
		}
		return $result;
	}

	public static function quitarContrato($id_tienda, $codigo_contrato, $id_proceso){
		$result=true;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_cabecera')
							->where('id_tienda_contrato', $id_tienda)
							->where('codigo_contrato', $codigo_contrato)
							->update(['id_estado_contrato' => env('ESTADO_CREACION_CONTRATO'), 'id_motivo_contrato' => 0]);
			DB::table('tbl_inventario_producto')
				->join('tbl_orden_guardar_items', function($join){
					$join->on('tbl_orden_guardar_items.id_inventario', 'tbl_inventario_producto.id_inventario');
					$join->on('tbl_orden_guardar_items.id_tienda_contrato', 'tbl_inventario_producto.id_tienda_inventario');
				})
				->where('tbl_orden_guardar_items.codigo_contrato', $codigo_contrato)
				->where('tbl_orden_guardar_items.id_tienda_contrato', $id_tienda)
				->update(['id_estado_producto' => 78]);

			DB::table('tbl_inventario_item_contrato')
				->where('tbl_inventario_item_contrato.id_contrato', $codigo_contrato)
				->where('tbl_inventario_item_contrato.id_tienda_contrato', $id_tienda)
				->delete();

			DB::table('tbl_orden_guardar_destinatarios')
				->join('tbl_orden_guardar_items', 'tbl_orden_guardar_items.id_orden_guardar', '=', 'tbl_orden_guardar_destinatarios.id_orden_guardar')
				->where('tbl_orden_guardar_items.codigo_contrato', $codigo_contrato)
				->where('tbl_orden_guardar_items.id_tienda_contrato', $id_tienda)
				->where('tbl_orden_guardar_destinatarios.id_proceso', $id_proceso)
				->delete();
			DB::table('tbl_orden_guardar_items')
				->where('tbl_orden_guardar_items.codigo_contrato', $codigo_contrato)
				->where('tbl_orden_guardar_items.id_tienda_contrato', $id_tienda)
				->delete();
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;
			DB::rollback();
		}
		return $result;
	}

	public static function getOrdenPDF($id_orden, $id_tienda ){
		return DB::table('tbl_orden')
			->leftJoin('tbl_tienda','tbl_tienda.id','tbl_orden.id_tienda_orden')
			->leftJoin('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
			->leftJoin('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
			->leftJoin('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_sociedad.id_regimen')
			->leftJoin('tbl_sys_tema','tbl_sys_tema.id','tbl_orden.proceso')
			->leftJoin('tbl_orden_hoja_trabajo_cabecera', function($join){
				$join->on('tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo', 'tbl_orden.id_hoja_trabajo');
				$join->on('tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo', 'tbl_orden.id_tienda_hoja_trabajo');
			})
			->leftJoin('tbl_orden_hoja_trabajo_detalle', function($join){
				$join->on('tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo', 'tbl_orden.id_hoja_trabajo');
				$join->on('tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo', 'tbl_orden.id_tienda_hoja_trabajo');
			})
			->leftJoin('tbl_orden_item', function($join){
				$join->on('tbl_orden_item.id_orden', 'tbl_orden.id_orden');
				$join->on('tbl_orden_item.id_tienda_orden', 'tbl_orden.id_tienda_orden');
			})
			->leftJoin('tbl_inventario_item_contrato', function($join){
				$join->on('tbl_inventario_item_contrato.id_inventario', 'tbl_orden_item.id_inventario');
				$join->on('tbl_inventario_item_contrato.id_tienda_inventario', 'tbl_orden_item.id_tienda_inventario');
			})

			->leftJoin('tbl_contr_item_detalle', function($join){
				$join->on('tbl_contr_item_detalle.id_tienda', 'tbl_inventario_item_contrato.id_tienda_contrato');
				$join->on('tbl_contr_item_detalle.id_codigo_contrato', 'tbl_inventario_item_contrato.id_contrato');
				$join->on('tbl_contr_item_detalle.id_linea_item_contrato', 'tbl_inventario_item_contrato.id_item_contrato');
			})
			->leftJoin('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
			->leftJoin('tbl_contr_cabecera', function($join){
				$join->on('tbl_contr_cabecera.codigo_contrato', 'tbl_contr_item_detalle.id_codigo_contrato');
				$join->on('tbl_contr_cabecera.id_tienda_contrato', 'tbl_contr_item_detalle.id_tienda');
			})
			->select(
					'tbl_tienda.nombre AS nombre_tienda',
					'tbl_tienda.direccion AS direccion_tienda',
					'tbl_ciudad.nombre AS ciudad_tienda',
					'tbl_tienda.telefono AS telefono_tienda',
					'tbl_sociedad.nit AS nit_sociedad',
					'tbl_sociedad.nombre AS nombre_sociedad',
					'tbl_clie_regimen_contributivo.nombre AS nombre_regimen',
					'tbl_orden.id_orden AS numero_orden',
					'tbl_orden.fecha_creacion AS fecha_resolucion',
					'tbl_orden.mano_obra',
					'tbl_orden.transporte',
					'tbl_orden.costos_indirectos',
					'tbl_orden.otros_costos',
					'tbl_prod_categoria_general.nombre AS categoria_general',
					'tbl_inventario_item_contrato.id_contrato AS numero_contrato',
					'tbl_inventario_item_contrato.id_inventario AS numero_id',
					'tbl_contr_item_detalle.nombre AS detalle',
					'tbl_contr_item_detalle.observaciones',
					'tbl_contr_item_detalle.peso_total AS peso_total',
					'tbl_contr_item_detalle.peso_estimado AS peso_estimado',
					'tbl_contr_item_detalle.precio_ingresado AS valor_item',
					DB::Raw("CONCAT('$ ', FORMAT(tbl_contr_item_detalle.precio_ingresado,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_item"),
					'tbl_contr_item_detalle.id_linea_item_contrato AS id_linea_item',
					DB::Raw("tbl_contr_item_detalle.precio_ingresado AS precio_ingresado_noformat"),
					DB::Raw("tbl_contr_item_detalle.peso_estimado AS peso_estimado_noformat"),
					DB::Raw("tbl_contr_item_detalle.peso_total AS peso_total_noformat"),
					DB::Raw("tbl_contr_item_detalle.precio_ingresado AS valor_item_noformat"),
					'tbl_sys_tema.nombre AS titulo_proceso',
					'tbl_sys_tema.id AS id_proceso',
					'tbl_orden_item.peso_taller',
					'tbl_orden_item.peso_joyeria',
					'tbl_orden_item.peso_libre',
					'tbl_orden_item.peso_libre as peso_final',
					DB::Raw("FORMAT((tbl_contr_item_detalle.peso_estimado),2,'de_DE') AS peso_estimado"),
					DB::Raw("FORMAT((tbl_contr_item_detalle.peso_total),2,'de_DE') AS peso_total"),
					DB::Raw("FORMAT((tbl_orden_item.peso_taller),2,'de_DE') AS peso_taller"),
					DB::Raw("FORMAT((tbl_orden_item.peso_joyeria),2,'de_DE') AS peso_joyeria"),
					DB::Raw("FORMAT((tbl_orden_item.peso_libre),2,'de_DE') AS peso_libre"),
					'tbl_contr_cabecera.fecha_creacion AS fecha_ingreso',
					DB::Raw('FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato GROUP BY tbl_contr_item_detalle.precio_ingresado DESC LIMIT 1),2,"de_DE") AS valor_contrato'),
					DB::Raw("FORMAT((SELECT SUM(ogi.peso_total) FROM tbl_orden_item AS ogi WHERE ogi.id_orden = tbl_orden_item.id_orden GROUP BY tbl_orden_item.id_orden DESC),2,'de_DE') AS peso_total_total"),
					DB::Raw("FORMAT((SELECT SUM(ogi.peso_estimado) FROM tbl_orden_item AS ogi WHERE ogi.id_orden = tbl_orden_item.id_orden GROUP BY tbl_orden_item.id_orden DESC),2,'de_DE') AS peso_estimado_total"),
					DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(ogi.precio_ingresado) FROM tbl_orden_item AS ogi WHERE ogi.id_orden = tbl_orden_item.id_orden GROUP BY tbl_orden_item.id_orden DESC),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contratos"),
					DB::raw("(SELECT (cod_bolsas_seguridad) FROM tbl_contr_cabecera WHERE tbl_contr_cabecera.codigo_contrato = tbl_contr_item_detalle.id_codigo_contrato AND tbl_contr_cabecera.id_tienda_contrato = tbl_contr_item_detalle.id_tienda) AS codigos_bolsas"),
					DB::Raw("CONCAT('$ ', FORMAT((tbl_contr_item_detalle.precio_ingresado / tbl_contr_item_detalle.peso_estimado),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_promedio"),
					DB::Raw('(SELECT COUNT(tbl_cabecera_sub.codigo_contrato) FROM tbl_contr_cabecera AS tbl_cabecera_sub WHERE tbl_cabecera_sub.id_tienda_contrato = tbl_orden_hoja_trabajo_detalle.id_tienda_contrato AND tbl_cabecera_sub.codigo_contrato = tbl_orden_hoja_trabajo_detalle.id_contrato GROUP BY tbl_cabecera_sub.codigo_contrato, tbl_cabecera_sub.id_tienda_contrato) AS total_contratos')
			)
			->where('tbl_orden.id_orden',$id_orden)
			->where('tbl_orden.id_tienda_orden',$id_tienda)
			->distinct()
			->get();
	}

	public static function getOrdenExcel($id_orden, $id_tienda)
	{
		return DB::table('tbl_orden_guardar')
				->join('tbl_orden_guardar_items','tbl_orden_guardar.id','tbl_orden_guardar_items.id_orden_guardar')
				->join('tbl_contr_item_detalle', function($join){
					$join->on('tbl_contr_item_detalle.id_codigo_contrato', 'tbl_orden_guardar_items.codigo_contrato');
					$join->on('tbl_contr_item_detalle.id_tienda', 'tbl_orden_guardar_items.id_tienda_contrato');
					$join->on('tbl_contr_item_detalle.id_linea_item_contrato', 'tbl_orden_guardar_items.id_linea_item');
				})
				->join('tbl_contr_cabecera', function($join){
					$join->on('tbl_contr_cabecera.codigo_contrato', 'tbl_orden_guardar_items.codigo_contrato');
					$join->on('tbl_contr_cabecera.id_tienda_contrato', 'tbl_orden_guardar_items.id_tienda_contrato');
				})
				->join('tbl_tienda','tbl_tienda.id','tbl_orden_guardar.id_tienda')
				->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_guardar.id_categoria_general')
				->leftJoin('tbl_sys_tema','tbl_sys_tema.id','tbl_orden_guardar.id_estado')
				->select(
						'tbl_orden_guardar.id AS DT_RowId',
						'tbl_tienda.nombre as tienda_orden',
						'tbl_prod_categoria_general.nombre as categoria',
						'tbl_orden_guardar.fecha_creacion AS fecha_perfeccionamiento_general',
						'tbl_orden_guardar.numero_bolsa_seguridad',
						'tbl_sys_tema.nombre as estado',
						'tbl_orden_guardar_items.id_tienda_contrato',
						'tbl_orden_guardar_items.codigo_contrato',
						'tbl_contr_item_detalle.nombre',
						'tbl_contr_item_detalle.observaciones',

						
						
						DB::Raw("tbl_contr_item_detalle.precio_ingresado AS precio_ingresado_noformat"),
						DB::Raw("tbl_contr_item_detalle.peso_estimado AS peso_estimado_noformat"),
						DB::Raw("tbl_contr_item_detalle.peso_total AS peso_total_noformat"),
						
						DB::Raw("CONCAT('$ ', FORMAT((tbl_contr_item_detalle.precio_ingresado),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS precio_ingresado"),
						DB::Raw("FORMAT((tbl_contr_item_detalle.peso_estimado),2,'de_DE') AS peso_estimado"),
						DB::Raw("FORMAT((tbl_contr_item_detalle.peso_total),2,'de_DE') AS peso_total"),
						DB::Raw("FORMAT((tbl_orden_guardar_items.peso_taller),2,'de_DE') AS peso_taller"),

						DB::raw("CONCAT('$ ', FORMAT((select SUM(precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_codigo_contrato = tbl_orden_guardar_items.codigo_contrato AND tbl_contr_item_detalle.id_tienda = tbl_orden_guardar_items.id_tienda_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS Suma_contrato"),
						DB::raw('cod_bolsa_seguridad_hasta - cod_bolsa_seguridad_desde AS Bolsas'),
						"tbl_contr_item_detalle.id_linea_item_contrato",
						'tbl_prod_categoria_general.id as id_categoria',
						'tbl_orden_guardar.abre_bolsa',
						'tbl_prod_categoria_general.control_peso_contrato AS control_peso',
						'tbl_orden_guardar_items.id_proceso',
						'tbl_orden_guardar.abre_bolsa',
						'tbl_orden_guardar_items.id_inventario',
						'tbl_orden_guardar_items.fecha_perfeccionamiento',
						'tbl_contr_cabecera.fecha_creacion AS fecha_contratacion'
						// DB::Raw('FORMAT((SELECT SUM(inventario_producto.precio_compra) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS valor_contrato'),
						// DB::Raw('FORMAT((SELECT SUM(inventario_producto.peso) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS peso_contrato')
				)
				->where('tbl_tienda.id',$id_tienda)
				->where('tbl_orden_guardar.id',$id_orden)
				->get();
	}

	public static function getReportePDF($codigo_contrato, $id_tienda ){
		return DB::table('tbl_contr_cabecera')
			->leftJoin('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
			->leftJoin('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
			->leftJoin('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
			->leftJoin('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_sociedad.id_regimen')
			->join('tbl_contr_detalle', function ($join) {
				$join->on('tbl_contr_detalle.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
				$join->on('tbl_contr_detalle.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
			})
			->join('tbl_contr_item_detalle', function ($join) {
				$join->on('tbl_contr_item_detalle.id_codigo_contrato' , '=' , 'tbl_contr_detalle.codigo_contrato');
				$join->on('tbl_contr_item_detalle.id_tienda' , '=' , 'tbl_contr_detalle.id_tienda');
				$join->on('tbl_contr_item_detalle.id_linea_item_contrato', '=' ,'tbl_contr_detalle.id_linea_item_contrato'  );

			})
			->leftJoin('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
			->select(
					'tbl_tienda.nombre AS nombre_tienda',
					'tbl_tienda.direccion AS direccion_tienda',
					'tbl_ciudad.nombre AS ciudad_tienda',
					'tbl_tienda.telefono AS telefono_tienda',
					'tbl_sociedad.nit AS nit_sociedad',
					'tbl_sociedad.nombre AS nombre_sociedad',
					'tbl_clie_regimen_contributivo.nombre AS nombre_regimen',
					'tbl_prod_categoria_general.nombre AS categoria_general',
					'tbl_contr_cabecera.codigo_contrato AS numero_contrato',
					'tbl_contr_item_detalle.nombre AS detalle',
					'tbl_contr_item_detalle.observaciones',
					'tbl_contr_item_detalle.peso_total AS peso_total',
					'tbl_contr_item_detalle.peso_estimado AS peso_estimado',
					'tbl_contr_item_detalle.precio_ingresado AS valor_item',
					'tbl_contr_cabecera.fecha_creacion AS fecha_ingreso',
					"tbl_contr_item_detalle.id_linea_item_contrato AS numero_id"
					// DB::Raw('FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) + (((tbl_contr_item_detalle.precio_ingresado * tbl_contr_cabecera.porcentaje_retroventa) / 100) * tbl_contr_cabecera.termino) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato GROUP BY tbl_contr_item_detalle.precio_ingresado DESC LIMIT 1),2,"de_DE") AS valor_contrato')

			)
			->where('tbl_contr_cabecera.codigo_contrato',$codigo_contrato)
			->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
			->orderBy('tbl_contr_cabecera.codigo_contrato', 'asc')
			->distinct()
			->get();
	}

	public static function getReportePDFOrdenGuardada($codigo_contrato, $id_tienda ){
		return DB::table('tbl_contr_cabecera')
			->leftJoin('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
			->leftJoin('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
			->leftJoin('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
			->leftJoin('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_sociedad.id_regimen')
			->join('tbl_contr_detalle', function ($join) {
				$join->on('tbl_contr_detalle.codigo_contrato' , '=' , 'tbl_contr_cabecera.codigo_contrato');
				$join->on('tbl_contr_detalle.id_tienda' , '=' , 'tbl_contr_cabecera.id_tienda_contrato');
			})
			->join('tbl_contr_item_detalle', function ($join) {
				$join->on('tbl_contr_item_detalle.id_codigo_contrato' , '=' , 'tbl_contr_detalle.codigo_contrato');
				$join->on('tbl_contr_item_detalle.id_tienda' , '=' , 'tbl_contr_detalle.id_tienda');
				$join->on('tbl_contr_item_detalle.id_linea_item_contrato', '=' ,'tbl_contr_detalle.id_linea_item_contrato'  );

			})
			->leftJoin('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_contr_cabecera.id_categoria_general')
			->leftJoin('tbl_orden_guardar_items', function ($join) {
				$join->on('tbl_orden_guardar_items.codigo_contrato' , '=' , 'tbl_contr_item_detalle.id_codigo_contrato');
				$join->on('tbl_orden_guardar_items.id_tienda_contrato' , '=' , 'tbl_contr_item_detalle.id_tienda');
				$join->on('tbl_orden_guardar_items.id_linea_item', '=' ,'tbl_contr_item_detalle.id_linea_item_contrato'  );

			})
			->select(
					'tbl_tienda.nombre AS nombre_tienda',
					'tbl_tienda.direccion AS direccion_tienda',
					'tbl_ciudad.nombre AS ciudad_tienda',
					'tbl_tienda.telefono AS telefono_tienda',
					'tbl_sociedad.nit AS nit_sociedad',
					'tbl_sociedad.nombre AS nombre_sociedad',
					'tbl_clie_regimen_contributivo.nombre AS nombre_regimen',
					'tbl_prod_categoria_general.nombre AS categoria_general',
					'tbl_prod_categoria_general.control_peso_contrato',
					'tbl_contr_cabecera.codigo_contrato AS numero_contrato',
					'tbl_contr_item_detalle.nombre AS detalle',
					'tbl_contr_item_detalle.observaciones',
					DB::Raw("FORMAT((tbl_contr_item_detalle.peso_estimado),2,'de_DE') AS peso_estimado"),
					DB::Raw("FORMAT((tbl_contr_item_detalle.peso_total),2,'de_DE') AS peso_total"),

					DB::Raw("tbl_contr_item_detalle.peso_estimado AS peso_estimado_noformat"),
					DB::Raw("tbl_contr_item_detalle.peso_total AS peso_total_noformat"),
					DB::Raw("tbl_contr_item_detalle.precio_ingresado AS valor_item_noformat"),


					DB::Raw("CONCAT('$ ', FORMAT((tbl_contr_item_detalle.precio_ingresado),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_item"),
					DB::Raw("CONCAT('$ ', FORMAT((tbl_contr_item_detalle.precio_ingresado / tbl_contr_item_detalle.peso_estimado),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_promedio"),
					'tbl_contr_cabecera.fecha_creacion AS fecha_ingreso',
					"tbl_orden_guardar_items.id_inventario AS numero_id",
					"tbl_orden_guardar_items.id_linea_item",
					DB::raw("(SELECT (cod_bolsas_seguridad) FROM tbl_contr_cabecera WHERE tbl_contr_cabecera.codigo_contrato = tbl_contr_item_detalle.id_codigo_contrato AND tbl_contr_cabecera.id_tienda_contrato = tbl_contr_item_detalle.id_tienda) AS codigos_bolsas"),
					DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(ogi.precio_ingresado) FROM tbl_orden_guardar_items AS ogi WHERE ogi.id_orden_guardar = tbl_orden_guardar_items.id_orden_guardar GROUP BY tbl_orden_guardar_items.id_orden_guardar DESC),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contratos"),
					DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),
					DB::Raw("CONCAT('$ ', FORMAT((tbl_contr_item_detalle.precio_ingresado),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS Precio_Item"),
					DB::Raw("FORMAT((SELECT SUM(ogi.peso_estimado) FROM tbl_orden_guardar_items AS ogi WHERE ogi.id_orden_guardar = tbl_orden_guardar_items.id_orden_guardar GROUP BY tbl_orden_guardar_items.id_orden_guardar DESC),2,'de_DE') AS peso_estimado_total"),
					DB::Raw("FORMAT((SELECT SUM(ogi.peso_total) FROM tbl_orden_guardar_items AS ogi WHERE ogi.id_orden_guardar = tbl_orden_guardar_items.id_orden_guardar GROUP BY tbl_orden_guardar_items.id_orden_guardar DESC),2,'de_DE') AS peso_total_total"),
					DB::Raw("FORMAT((tbl_contr_item_detalle.peso_total),2,'de_DE') AS Peso_Total_Item"),
					DB::raw("(SELECT fecha_creacion FROM tbl_orden_guardar WHERE tbl_orden_guardar.id = tbl_orden_guardar_items.id_orden_guardar) AS fecha_creacion_perfeccionamiento"),
					DB::raw("(SELECT id_orden FROM tbl_orden_guardar WHERE tbl_orden_guardar.id = tbl_orden_guardar_items.id_orden_guardar) AS id_orden_perfeccionamiento")

			)
			->whereIn('tbl_contr_cabecera.codigo_contrato',$codigo_contrato)
			->where('tbl_contr_cabecera.id_tienda_contrato',$id_tienda)
			->orderBy('tbl_contr_cabecera.codigo_contrato', 'asc')
			->distinct()
			->get();
	}

	public static function inactivarContratos($id_tienda, $codigos_contratos){
		return DB::table('tbl_contr_cabecera')->where('id_tienda_contrato', $id_tienda)->whereIn('codigo_contrato', $codigos_contratos)->update(["id_estado_contrato" => env('ESTADO_CONTRATO_CERRADO'), "id_motivo_contrato" => env('MOTIVO_PERFECCIONAMIENTO_CONTRATO')]);
	}

	public static function ordenGuardar($id_tienda, $codigos_contratos, $id_categoria_general, $fecha_creacion, $abre_bolsa, $codigoOrden){

		$result=0;
		try{
			DB::beginTransaction();
			DB::table('tbl_contr_cabecera')->where('id_tienda_contrato', $id_tienda)->whereIn('codigo_contrato', $codigos_contratos)->update(["id_estado_contrato" => env('ESTADO_CONTRATO_CERRADO'), "id_motivo_contrato" => env('MOTIVO_PERFECCIONAMIENTO_CONTRATO')]);
			$result = DB::table('tbl_orden_guardar')->insertGetId(
				[
					"id_tienda" => $id_tienda,
					"id_categoria_general" => $id_categoria_general,
					"fecha_creacion" => $fecha_creacion,
					"abre_bolsa" => (int)$abre_bolsa,
					"id_estado" => env('ORDEN_PENDIENTE_POR_PROCESAR'),
					"id_orden" => $codigoOrden
				]
			);
			DB::commit();
		}catch(\Exception $e){
			$result=false;
			DB::rollback();
		}
		return $result;
	}

	public static function eliminarOrdenGuardada($id){
		$result=0;
		try{
			DB::beginTransaction();
			DB::table('tbl_orden_guardar')->where('id', $id)->delete();
			DB::table('tbl_orden_guardar_destinatarios')->where('id_orden_guardar', $id)->delete();
			DB::commit();
		}catch(\Exception $e){
			$result=false;
			DB::rollback();
		}
		return $result;
	}

	public static function ordenGuardarItems($items){
		return DB::table('tbl_orden_guardar_items')->insert($items);
	}

	public static function ordenGuardarDestinatarios($destinatarios){
		return DB::table('tbl_orden_guardar_destinatarios')->insert($destinatarios);
	}

	public static function ordenActualizar($id_orden_guardar, $abre_bolsa){
		return DB::table('tbl_orden_guardar')->where("id", $id_orden_guardar)->update(["abre_bolsa" => (int)$abre_bolsa]);
	}

	public static function ordenAddOrUpdate($id_orden, $data){
		DB::table('tbl_orden_guardar')->where("id_orden", $id_orden)->delete();
		return DB::table('tbl_orden_guardar')->insert($data);
	}

	public static function ordenActualizarItems($id_orden_guardar, $items){
		DB::table('tbl_orden_guardar_items')->where('id_orden_guardar', $id_orden_guardar)->delete();
		return DB::table('tbl_orden_guardar_items')->insert($items);
	}

	public static function ordenActualizarDestinatarios($id_orden_guardar, $destinatarios){
		DB::table('tbl_orden_guardar_destinatarios')->where('id_orden_guardar', $id_orden_guardar)->delete();
		return DB::table('tbl_orden_guardar_destinatarios')->insert($destinatarios);
	}

	public static function ordenGuardarInventario($inventario_item_contrato, $inventario_producto){
		DB::table('tbl_inventario_item_contrato')->insert($inventario_item_contrato);
		return DB::table('tbl_inventario_producto')->insert($inventario_producto);
	}

	public static function validarPerfeccionamiento($cat_gen, $id_tienda){
		return DB::table('tbl_orden_guardar')
		->where('id_categoria_general', $cat_gen)
		->where('id_tienda', $id_tienda)
		->where('id_estado', env('ORDEN_PENDIENTE_POR_PROCESAR'))
		->where(DB::raw("MONTH(fecha_creacion)"), DB::raw("MONTH(curdate())"))
		->where(DB::raw("YEAR(fecha_creacion)"), DB::raw("YEAR(curdate())"))
		->count();
	}
}

<?php

// Author		:	<Andrey Higuita>
// Create date	:	<Jueves, 15 de abril de 2018>
// Description	:	<Clase para manejar DB de la resolución en el primer paso (perfeccionamiento de contratos)>


namespace App\AccessObject\Nutibara\Resolucion;

use App\Models\Nutibara\OrdenResolucion\OrdenResolucion AS ModelResolucion;
use App\Models\Nutibara\Orden\Orden AS ModelOrden;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use App\Models\Nutibara\Tema\Tema AS ModelTema;
use DB;

class Resolucion
{
	public static function get($start, $end, $colum, $order, $search)
	{
		return DB::table('tbl_orden_guardar')
				->leftJoin('tbl_orden_guardar_items','tbl_orden_guardar.id','tbl_orden_guardar_items.id_orden_guardar')
				->join('tbl_contr_item_detalle', function($join){
					$join->on('tbl_contr_item_detalle.id_codigo_contrato', 'tbl_orden_guardar_items.codigo_contrato');
					$join->on('tbl_contr_item_detalle.id_tienda', 'tbl_orden_guardar_items.id_tienda_contrato');
					$join->on('tbl_contr_item_detalle.id_linea_item_contrato', 'tbl_orden_guardar_items.id_linea_item');
				})
				->leftJoin('tbl_orden_guardar_destinatarios','tbl_orden_guardar.id','tbl_orden_guardar_destinatarios.id_orden_guardar')
				->join('tbl_tienda','tbl_tienda.id','tbl_orden_guardar.id_tienda')
				->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_guardar.id_categoria_general')
				->leftJoin('tbl_sys_tema','tbl_sys_tema.id','tbl_orden_guardar.id_estado')
				->select(
						'tbl_orden_guardar.id AS DT_RowId',
						'tbl_tienda.nombre as tienda_orden',
						'tbl_prod_categoria_general.nombre as categoria',
						'tbl_orden_guardar.fecha_creacion',
						'tbl_sys_tema.nombre as estado',
						'tbl_orden_guardar.id_orden',
						DB::raw("(SELECT DISTINCT GROUP_CONCAT(cod_bolsas_seguridad SEPARATOR ', ') FROM tbl_contr_cabecera WHERE tbl_contr_cabecera.codigo_contrato = tbl_contr_item_detalle.id_codigo_contrato AND tbl_contr_cabecera.id_tienda_contrato = tbl_contr_item_detalle.id_tienda) AS codigos_bolsas"),
						DB::Raw('(SELECT COUNT(itm_detalle.id_codigo_contrato) FROM tbl_contr_item_detalle AS itm_detalle  WHERE tbl_contr_item_detalle.id_tienda = itm_detalle.id_tienda AND tbl_contr_item_detalle.id_codigo_contrato = itm_detalle.id_codigo_contrato) AS cantidad_items'),
						DB::raw("GROUP_CONCAT(tbl_contr_item_detalle.id_codigo_contrato SEPARATOR ',') AS codigos_contratos"),
						DB::raw("IF(tbl_orden_guardar.id_estado = 89, 'Abierta', 'Cerrada') AS estado_orden"),
						DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(tbl_orden_guardar_items_sub.precio_ingresado) FROM tbl_orden_guardar_items AS tbl_orden_guardar_items_sub WHERE tbl_orden_guardar_items_sub.id_tienda_contrato = tbl_orden_guardar.id_tienda AND tbl_orden_guardar_items_sub.id_orden_guardar = tbl_orden_guardar.id),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),
						DB::Raw("FORMAT((SELECT SUM(tbl_orden_guardar_items_sub.peso_estimado) FROM tbl_orden_guardar_items AS tbl_orden_guardar_items_sub WHERE tbl_orden_guardar_items_sub.id_tienda_contrato = tbl_orden_guardar.id_tienda AND tbl_orden_guardar_items_sub.id_orden_guardar = tbl_orden_guardar.id),2,'de_DE') AS peso_estimado_total"),
						DB::Raw("FORMAT((SELECT SUM(tbl_orden_guardar_items_sub.peso_total) FROM tbl_orden_guardar_items AS tbl_orden_guardar_items_sub WHERE tbl_orden_guardar_items_sub.id_tienda_contrato = tbl_orden_guardar.id_tienda AND tbl_orden_guardar_items_sub.id_orden_guardar = tbl_orden_guardar.id),2,'de_DE') AS peso_total_total")
						// DB::Raw('FORMAT((SELECT SUM(inventario_producto.precio_compra) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS valor_contrato'),
						// DB::Raw('FORMAT((SELECT SUM(inventario_producto.peso) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS peso_contrato')
				)
				->where('tbl_orden_guardar.id_estado',$search["id_estado"])
				->where(function ($query) use ($search) {
					if($search["id_categoria"] != "")
						$query->where('tbl_prod_categoria_general.id',$search['id_categoria']);
				})
				->where('tbl_tienda.id',$search['id_tienda'])
				->orderBy($colum, $order)
				->skip($start)->take($end)
				->distinct()
				->get();
	}

	public static function countResolucion($start, $end, $colum, $order, $search){

		return DB::table('tbl_orden_guardar')
									->leftJoin('tbl_orden_guardar_items','tbl_orden_guardar.id','tbl_orden_guardar_items.id_orden_guardar')
									->join('tbl_contr_item_detalle', function($join){
										$join->on('tbl_contr_item_detalle.id_codigo_contrato', 'tbl_orden_guardar_items.codigo_contrato');
										$join->on('tbl_contr_item_detalle.id_tienda', 'tbl_orden_guardar_items.id_tienda_contrato');
										$join->on('tbl_contr_item_detalle.id_linea_item_contrato', 'tbl_orden_guardar_items.id_linea_item');
									})
									->leftJoin('tbl_orden_guardar_destinatarios','tbl_orden_guardar.id','tbl_orden_guardar_destinatarios.id_orden_guardar')
									->join('tbl_tienda','tbl_tienda.id','tbl_orden_guardar.id_tienda')
									->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_guardar.id_categoria_general')
									->leftJoin('tbl_sys_tema','tbl_sys_tema.id','tbl_orden_guardar.id_estado')
									->select(
										'tbl_orden_guardar.id AS DT_RowId',
										'tbl_tienda.nombre as tienda_orden',
										'tbl_prod_categoria_general.nombre as categoria',
										'tbl_orden_guardar.fecha_creacion',
										'tbl_sys_tema.nombre as estado',
										DB::raw("(SELECT DISTINCT GROUP_CONCAT(cod_bolsas_seguridad SEPARATOR ', ') FROM tbl_contr_cabecera WHERE tbl_contr_cabecera.codigo_contrato = tbl_contr_item_detalle.id_codigo_contrato AND tbl_contr_cabecera.id_tienda_contrato = tbl_contr_item_detalle.id_tienda) AS codigos_bolsas"),
										DB::Raw('(SELECT COUNT(tbl_contr_item_detalle.id_codigo_contrato) FROM tbl_contr_item_detalle AS itm_detalle  WHERE tbl_contr_item_detalle.id_tienda = itm_detalle.id_tienda AND tbl_contr_item_detalle.id_codigo_contrato = itm_detalle.id_codigo_contrato) AS cantidad_items'),
										DB::raw("GROUP_CONCAT(tbl_contr_item_detalle.id_codigo_contrato SEPARATOR ',') AS codigos_contratos"),
										DB::raw("IF(tbl_orden_guardar.id_estado = 89, 'Abierta', 'Cerrada') AS estado_orden"),
										DB::Raw("CONCAT('$ ', FORMAT((SELECT SUM(tbl_orden_guardar_items.precio_ingresado) FROM tbl_orden_guardar_items WHERE tbl_orden_guardar_items.id_tienda_contrato = tbl_orden_guardar.id_tienda AND tbl_orden_guardar_items.id_orden_guardar = tbl_orden_guardar.id),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),
										DB::Raw("FORMAT((SELECT SUM(tbl_orden_guardar_items.peso_estimado) FROM tbl_orden_guardar_items WHERE tbl_orden_guardar_items.id_tienda_contrato = tbl_orden_guardar.id_tienda AND tbl_orden_guardar_items.id_orden_guardar = tbl_orden_guardar.id),2,'de_DE') AS peso_estimado_total"),
										DB::Raw("FORMAT((SELECT SUM(tbl_orden_guardar_items.peso_total) FROM tbl_orden_guardar_items WHERE tbl_orden_guardar_items.id_tienda_contrato = tbl_orden_guardar.id_tienda AND tbl_orden_guardar_items.id_orden_guardar = tbl_orden_guardar.id),2,'de_DE') AS peso_total_total")
											// DB::Raw('FORMAT((SELECT SUM(inventario_producto.precio_compra) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS valor_contrato'),
											// DB::Raw('FORMAT((SELECT SUM(inventario_producto.peso) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS peso_contrato')
									)
									->where('tbl_orden_guardar.id_estado',$search["id_estado"])
									->where('tbl_tienda.id',$search['id_tienda'])
									->where(function ($query) use ($search) {
										if($search["id_categoria"] != "")
											$query->where('tbl_prod_categoria_general.id',$search['id_categoria']);
									})
									->orderBy($colum, $order)
									->skip($start)->take($end)
									->distinct()
									->count();
	}

	public static function getResolucionById($id){
		return ModelResolucion::where('id',$id)->first();
	}

	public static function procesar($data,$ordenes)
	{
		$result="Actualizado";
		try
		{
			DB::beginTransaction();
			self::process($data,$ordenes);
			DB::commit();
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

	public static function process($data,$ordenes)
	{
		$fecha = date("Y-m-d H:i:s");
		// dd($ordenes);
		for ($i=0; $i < count($ordenes); $i++) {
			$secuenciaT = self::sec_trazabilidad($data['id_tienda_orden']);
			DB::table('tbl_orden')->where('id_orden',$ordenes[$i])
									->where('id_tienda_orden',$data['id_tienda_orden'])
									->update([
										'estado' => (int)env('ORDEN_PROCESADA'),
									]);

			DB::table('tbl_orden_trazabilidad')->where('id_orden',$ordenes[$i])
												->where('id_tienda_orden',$data['id_tienda_orden'])
												->update([
													'actual' => (int)0,
												]);


			DB::table('tbl_orden_trazabilidad')->insert([
												[
													'id_trazabilidad' => (int)$secuenciaT[0]->response,
													'id_tienda_trazabilidad' => (int)$data['id_tienda_orden'],
													'id_orden' => (int)$ordenes[$i],
													'id_tienda_orden' => (int)$data['id_tienda_orden'],
													'actual' => (int)1,
													'fecha_accion' => $fecha,
													'accion' => 'Procesado'
												]
			]);
		}
		// dd($data);
		for($i=0; $i < count($data['id_item']); $i++)
		{
			DB::table('tbl_orden_item')->where('id_inventario',$data['id_item'][$i])
									->where('id_tienda_inventario',$data['id_tienda_inventario'][$i])
									->update([
										'peso_taller' => $data['peso_taller'][$i],
									]);

			DB::table('tbl_inventario_producto')->where('id_inventario',$data['id_item'][$i])
									->where('id_tienda_inventario',$data['id_tienda_inventario'][$i])
									->update([
										'id_estado_producto' => (int)env('PROCESADO_REFACCION'),
									]);
		}

		return true;
	}

	public static function Procesarsubdividir($datosPreparados)
	{
		$result='Insertado';
		try
		{
			DB::beginTransaction();
			self::crearOrdenes($datosPreparados['CrearOrdenes']);
			self::actualizarAntiguasOrdenes($datosPreparados['AntiguaTrazabilidad']);
			self::crearTrazabilidad($datosPreparados['CrearTrazabilidad']);
			self::actualizarAntiguaTrazabilidad($datosPreparados['AntiguaTrazabilidad']);
			self::ItemsXOrdenesNuevas($datosPreparados['ItemsXOrden']);
			DB::commit();
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
			DB::rollback();
		}
		return $result;
	}

	public static function crearOrdenes($CrearOrdenes)
	{
		 return ModelOrden::insert($CrearOrdenes);
	}
	public static function actualizarAntiguasOrdenes($AntiguaTrazabilidad)
	{
		for ($i=0; $i < count($AntiguaTrazabilidad) ; $i++)
		{
				ModelOrden::where('id_orden',$AntiguaTrazabilidad[$i]['id_orden'])
								->where('id_tienda_orden',$AntiguaTrazabilidad[$i]['id_tienda_orden'])
								->update(['estado' => $AntiguaTrazabilidad[$i]['estado']]);
		}
	}
	public static function crearTrazabilidad($CrearTrazabilidad)
	{
		return DB::table('tbl_orden_trazabilidad')
			  			->insert($CrearTrazabilidad);
	}
	public static function actualizarAntiguaTrazabilidad($AntiguaTrazabilidad)
	{
		for ($i=0; $i < count($AntiguaTrazabilidad) ; $i++)
		{
			DB::table('tbl_orden_trazabilidad')
				->where('id_orden',$AntiguaTrazabilidad[$i]['id_orden'])
				->where('id_tienda_orden',$AntiguaTrazabilidad[$i]['id_tienda_orden'])
				->update(['actual' => $AntiguaTrazabilidad[$i]['actual'], 'accion' => $AntiguaTrazabilidad[$i]['accion']]);
		}
	}
	public static function ItemsXOrdenesNuevas($ItemsXOrden)
	{
		for ($i=0; $i < count($ItemsXOrden) ; $i++)
		{
			DB::table('tbl_orden_item')
					->insert($ItemsXOrden[$i]);
		}
	}

	public static function sec_trazabilidad($id_tienda)
    {
        return DB::select('CALL sp_secuencias_tienda_x (?,?,?)',array($id_tienda,(int)27,(int)1));
    }

	public static function getSelectList()
	{
		return ModelResolucion::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getListProceso(){
		return ModelTema::select(
								'id',
								'nombre AS name'
								)
								->whereIn('id',[env('PROCESO_VITRINA'),
														env('PROCESO_MAQUILA_NACIONAL'),
														env('PROCESO_MAQUILA_IMPORTADA'),
														env('PROCESO_FUNDICION'),
														env('PROCESO_MAQUILA'),
														env('PROCESO_JOYA_ESPECIAL'),
														env('PROCESO_REFACCION'),
														env('PROCESO_PREREFACCION')
														])
								->get();
	}

	public static function getListProcesoByVitrina(){
		return ModelTema::select(
								'id',
								'nombre AS name'
								)
								->whereIn('id',[env('PROCESO_VITRINA')])
								->get();
	}

	public static function getIdContratos($id_tienda,$id)
	{
		return DB::table('tbl_orden_guardar')
				->join('tbl_orden_guardar_items','tbl_orden_guardar.id','tbl_orden_guardar_items.id_orden_guardar')
				->select(
					DB::raw("group_concat(tbl_orden_guardar_items.codigo_contrato separator '-') as codigo_contratos")
				)
				->where('tbl_orden_guardar.id_tienda',$id_tienda)
				->where('tbl_orden_guardar.id',$id)
				->first();
	}

	public static function getItemOrden($id_tienda,$id)
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
						'tbl_orden_guardar.id_orden',
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
				->where('tbl_orden_guardar.id',$id)
				->get();
	}

	public static function getDestinatariosOrden($id_tienda,$id)
	{
		return DB::table('tbl_orden_guardar')
				->join('tbl_orden_guardar_destinatarios','tbl_orden_guardar.id','tbl_orden_guardar_destinatarios.id_orden_guardar')
				->leftJoin('tbl_sys_tema','tbl_sys_tema.id','tbl_orden_guardar_destinatarios.id_proceso')
				->select(
						'tbl_sys_tema.nombre as proceso',
						'tbl_orden_guardar_destinatarios.destinatario',
						'tbl_orden_guardar_destinatarios.codigo_verificacion',
						'tbl_sys_tema.id as id_proceso',
						'tbl_orden_guardar_destinatarios.numero_bolsa'
				)
				->where('tbl_orden_guardar.id_tienda',$id_tienda)
				->where('tbl_orden_guardar.id',$id)
				->get();
	}

	public static function getTiendaByIp($ip){
		return ModelTienda::select('id', 'nombre')->where('ip_fija', $ip)->first();
	}

	public static function validarItem($id_tienda_inventario,$id_inventario,$id_contrato)
	{
		return DB::table('tbl_orden_item')->join('tbl_orden',function($join){
											$join->on('tbl_orden.id_orden','tbl_orden_item.id_orden')
												 ->on('tbl_orden.id_tienda_orden','tbl_orden_item.id_tienda_orden');
										})
										->join('tbl_inventario_item_contrato',function($join){
											$join->on('tbl_inventario_item_contrato.id_inventario','tbl_orden_item.id_inventario')
												 ->on('tbl_inventario_item_contrato.id_tienda_inventario','tbl_orden_item.id_tienda_inventario');
										})
										->join('tbl_orden_trazabilidad',function($join){
											$join->on('tbl_orden_trazabilidad.id_orden','tbl_orden.id_orden')
												 ->on('tbl_orden_trazabilidad.id_tienda_orden','tbl_orden.id_tienda_orden');
										})
										->join('tbl_tienda','tbl_tienda.id','tbl_orden_item.id_tienda_inventario')
										->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_orden.estado')
										->where('tbl_orden_item.id_tienda_inventario',$id_tienda_inventario)
										->where('tbl_orden_trazabilidad.actual',1)
										->where('tbl_inventario_item_contrato.id_contrato',$id_contrato)
										->select(
													'tbl_orden_item.id_orden',
													'tbl_inventario_item_contrato.id_contrato',
													'tbl_inventario_item_contrato.id_inventario',
													'tbl_inventario_item_contrato.id_tienda_inventario',
													'tbl_orden.estado',
													'tbl_tienda.nombre as tienda',
													'tbl_sys_estado_tema.nombre as nombre_estado'
												)
										->get();
	}

	public static function validarProcesos($id_inventario,$id_tienda_inventario,$id_contrato)
	{

		return DB::table('tbl_orden_item')->join('tbl_orden',function($join){
											$join->on('tbl_orden.id_orden','tbl_orden_item.id_orden')
												 ->on('tbl_orden.id_tienda_orden','tbl_orden_item.id_tienda_orden');
										})
										->join('tbl_inventario_item_contrato',function($join){
											$join->on('tbl_inventario_item_contrato.id_inventario','tbl_orden_item.id_inventario')
												 ->on('tbl_inventario_item_contrato.id_tienda_inventario','tbl_orden_item.id_tienda_inventario');
										})
										->whereIn('tbl_orden_item.id_inventario',$id_inventario)
										->whereIn('tbl_orden.estado',[env('PROCESADO_REFACCION'),env('PROCESADO_FUNDICION'),env('PROCESADO_VITRINA'),env('PROCESADO_MAQUILA'),env('PROCESADO_JOYA_ES')])
										->where('tbl_orden_item.id_tienda_inventario',$id_tienda_inventario)
										->where('tbl_inventario_item_contrato.id_contrato',$id_contrato)
										->select('tbl_orden_item.id_orden')
										->first();
	}

	public static function quitarItems($id_inventario,$id_tienda_inventario,$id_contrato)
	{
		$resultado = "exito";
		try{
			DB::beginTransaction();
			self::updateContrato($id_tienda_inventario,$id_contrato);
			self::deleteInventario($id_inventario,$id_tienda_inventario);
			self::deleteItemHojaTrabajo($id_tienda_inventario,$id_contrato);
			self::deleteItemContratoInv($id_inventario,$id_tienda_inventario);
			self::deleteOrdenItem($id_inventario,$id_tienda_inventario);
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			if($e->getCode() == 23000)
			{
				$resultado='ErrorUnico';
			}
			else
			{
				$resultado = 'error_quitar';
			}
		}
		return $resultado;
	}

	public static function updateContrato($id_tienda_contrato,$id_contrato)
	{
		return DB::table('tbl_contr_cabecera')->where('id_tienda_contrato',$id_tienda_contrato)
									   		->where('codigo_contrato',$id_contrato)
									   		->update(['id_estado_contrato' => env('ESTADO_CONTRATO_RESTABLECER')]);
	}

	public static function deleteInventario($id_inventario,$id_tienda_inventario)
	{
		return DB::table('tbl_inventario_producto')->whereIn('id_inventario',$id_inventario)
												->where('id_tienda_inventario',$id_tienda_inventario)
												->delete();
	}

	public static function deleteItemContratoInv($id_inventario,$id_tienda_inventario)
	{
		return DB::table('tbl_inventario_item_contrato')->whereIn('id_inventario',$id_inventario)
												->where('id_tienda_inventario',$id_tienda_inventario)
												->delete();
	}

	public static function deleteOrdenItem($id_inventario,$id_tienda_inventario)
	{
		return DB::table('tbl_inventario_item_contrato')->whereIn('id_inventario',$id_inventario)
												->where('id_tienda_inventario',$id_tienda_inventario)
												->delete();
	}

	public static function deleteItemHojaTrabajo($id_tienda_contrato,$id_contrato)
	{
		return DB::table('tbl_orden_hoja_trabajo_detalle')->where('id_contrato',$id_contrato)
												->where('id_tienda_contrato',$id_tienda_contrato)
												->delete();
	}

	public static function updateEstadoInventario($id_inventario,$id_tienda,$motivo,$estado)
	{
		return DB::table('tbl_inventario_producto')->where('id_inventario',$id_inventario)
												   ->where('id_tienda_inventario',$id_tienda)
												   ->update([
													   'id_estado_producto' => $estado,
													   'id_motivo_producto' => $motivo
												   ]);
	}

	public static function getItemsContrato($codigo_orden, $id_tienda){
		return DB::table('tbl_orden_guardar')
										->leftJoin('tbl_orden_guardar_items','tbl_orden_guardar.id','tbl_orden_guardar_items.id_orden_guardar')
										->join('tbl_contr_item_detalle', function($join){
											$join->on('tbl_contr_item_detalle.id_codigo_contrato', 'tbl_orden_guardar_items.codigo_contrato');
											$join->on('tbl_contr_item_detalle.id_tienda', 'tbl_orden_guardar_items.id_tienda_contrato');
											$join->on('tbl_contr_item_detalle.id_linea_item_contrato', 'tbl_orden_guardar_items.id_linea_item');
										})
										->join('tbl_contr_cabecera', function($join){
											$join->on('tbl_contr_cabecera.codigo_contrato', 'tbl_orden_guardar_items.codigo_contrato');
											$join->on('tbl_contr_cabecera.id_tienda_contrato', 'tbl_orden_guardar_items.id_tienda_contrato');
										})
										->leftJoin('tbl_cliente', function ($join) {
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
											'tbl_contr_item_detalle.id_linea_item_contrato AS Linea_Item',
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
										->where('tbl_orden_guardar.id',$codigo_orden)
										->where('tbl_orden_guardar.id_tienda',$id_tienda)
										->distinct()
										->get();
	}

}

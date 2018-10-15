<?php 

namespace App\AccessObject\Nutibara\Fundicion;

use App\Models\Nutibara\OrdenResolucion\OrdenResolucion AS ModelFundicion;
use App\Models\Nutibara\Orden\Orden AS ModelOrden;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use App\Models\Nutibara\Tema\Tema AS ModelTema;
use DB;

class Fundicion 
{
	public static function get($start, $end, $colum, $order, $search)
	{
		return DB::table('tbl_orden')->join('tbl_orden_hoja_trabajo_cabecera', function($join){
								$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
									->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
								})
								->join('tbl_orden_hoja_trabajo_detalle', function($join){
									$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo')
										->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo');
								})
								->join('tbl_contr_item_detalle AS tbl_contr_item_detalle_join', function($join){
									$join->on('tbl_contr_item_detalle_join.id_codigo_contrato', 'tbl_orden_hoja_trabajo_detalle.id_contrato');
									$join->on('tbl_contr_item_detalle_join.id_tienda', 'tbl_orden_hoja_trabajo_detalle.id_tienda_contrato');
									$join->on('tbl_contr_item_detalle_join.id_linea_item_contrato', 'tbl_orden_hoja_trabajo_detalle.id_item_contrato');
								})
								->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_orden.estado')
								->join('tbl_tienda','tbl_tienda.id','tbl_orden.id_tienda_orden')
								->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
								->join('tbl_orden_item', function($join){
									$join->on('tbl_orden_item.id_orden','tbl_orden.id_orden')
										->on('tbl_orden_item.id_tienda_orden','tbl_orden.id_tienda_orden');
								})
								->join('tbl_contr_cabecera', function($join){
									$join->on('tbl_contr_cabecera.codigo_contrato', 'tbl_orden_hoja_trabajo_detalle.id_contrato');
									$join->on('tbl_contr_cabecera.id_tienda_contrato', 'tbl_orden_hoja_trabajo_detalle.id_tienda_contrato');
								})
								->select(
											'tbl_orden.id_orden AS DT_RowId',
											'tbl_orden.id_orden',
											'tbl_tienda.nombre as tienda_orden',
											'tbl_prod_categoria_general.nombre as categoria',
											'tbl_orden.fecha_creacion',
											'tbl_sys_estado_tema.nombre as estado',
											DB::RAW("CASE WHEN tbl_sys_estado_tema.id = 89 THEN 'Abiertas sin procesar' WHEN tbl_sys_estado_tema.id = 120 THEN 'Abiertas procesadas' WHEN tbl_sys_estado_tema.id = 90 THEN 'Cerradas' WHEN tbl_sys_estado_tema.id = 119 THEN 'Anuladas' END AS id_estado "),
											// DB::Raw('FORMAT((SELECT SUM(inventario_producto.precio_compra) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS valor_contrato'),
											DB::RAW("(SELECT DISTINCT GROUP_CONCAT( DISTINCT cod_bolsas_seguridad SEPARATOR ', ') FROM tbl_contr_cabecera INNER JOIN tbl_orden_hoja_trabajo_detalle AS trabajo_detalle ON tbl_contr_cabecera.codigo_contrato = trabajo_detalle.id_contrato AND tbl_contr_cabecera.id_tienda_contrato = trabajo_detalle.id_tienda_contrato WHERE trabajo_detalle.id_tienda_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo AND trabajo_detalle.id_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo) AS codigos_bolsas"),
											//DB::raw("CONCAT('$ ', FORMAT((SELECT COALESCE(SUM(tbl_contr_item_detalle.precio_ingresado),0) FROM tbl_contr_item_detalle INNER JOIN tbl_orden_hoja_trabajo_detalle AS trabajo_detalle ON tbl_contr_item_detalle.id_codigo_contrato = trabajo_detalle.id_contrato AND tbl_contr_item_detalle.id_tienda = trabajo_detalle.id_tienda_contrato WHERE trabajo_detalle.id_tienda_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo AND trabajo_detalle.id_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),
											DB::RAW("CONCAT('$ ', FORMAT((SELECT COALESCE(SUM(tbl_contr_item_detalle.precio_ingresado),0) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),
											DB::RAW('FORMAT((SELECT SUM(inventario_producto.peso) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS peso_contrato'),
											//DB::RAW('(SELECT COALESCE(SUM(tbl_contr_item_detalle.peso_estimado),0) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato) AS peso_estimado_total'),
											DB::Raw('COALESCE(FORMAT((SELECT SUM(peso_estimado) FROM (SELECT a.id_orden,a.id_tienda_orden,peso_estimado,proceso FROM tbl_orden a join tbl_orden_item on tbl_orden_item.id_orden = a.id_orden and tbl_orden_item.id_tienda_orden = a.id_tienda_orden GROUP BY a.id_orden,a.id_tienda_orden,tbl_orden_item.id_orden_item) AS tabla WHERE id_orden = `tbl_orden`.`id_orden` AND id_tienda_orden = `tbl_orden`.`id_tienda_orden`),2,"de_DE"),0) as peso_estimado_total'),
											//DB::RAW('(SELECT SUM(orden_item.peso_total) FROM tbl_orden_item AS orden_item WHERE tbl_orden_item.id_orden = orden_item.id_orden AND tbl_orden_item.id_tienda_orden = orden_item.id_tienda_orden) AS peso_total_total'),
											DB::RAW('FORMAT((SELECT COALESCE(SUM(orden_item.peso_total),0) FROM tbl_orden_item AS orden_item WHERE tbl_orden_item.id_orden = orden_item.id_orden AND tbl_orden_item.id_tienda_orden = orden_item.id_tienda_orden),2,"de_DE") AS peso_total_total'),
											DB::RAW('(SELECT COALESCE(SUM(orden_item.peso_taller),0) FROM tbl_orden_item AS orden_item WHERE tbl_orden_item.id_orden = orden_item.id_orden AND tbl_orden_item.id_tienda_orden = orden_item.id_tienda_orden) AS peso_taller_total'),
											DB::RAW('(SELECT COALESCE(SUM(orden_item.peso_libre),0) FROM tbl_orden_item AS orden_item WHERE tbl_orden_item.id_orden = orden_item.id_orden AND tbl_orden_item.id_tienda_orden = orden_item.id_tienda_orden) AS peso_libre_total'),
											DB::RAW('(SELECT COUNT(1) FROM tbl_orden_item AS orden_item WHERE tbl_orden_item.id_orden = orden_item.id_orden AND tbl_orden_item.id_tienda_orden = orden_item.id_tienda_orden) AS cantidad_items'),
											'tbl_orden_item.peso_libre AS peso_libre'
										)
										->where('tbl_orden.proceso',env('PROCESO_FUNDICION'))
										->where('tbl_orden.estado',$search["id_estado"])
										->where(function($query) use($search){
											if($search['id_categoria']!="" && $search['id_categoria']!="null"){
												  $query->where('tbl_prod_categoria_general.id',$search['id_categoria']);
											  }
										  })
										->groupBy('tbl_orden.id_orden')
										->orderBy($colum, $order)
										->skip($start)->take($end)
										->distinct()
										->get();
	}

	public static function countFUNDICION($search){
		return DB::table('tbl_orden')->join('tbl_orden_hoja_trabajo_cabecera', function($join){
			$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
				->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
			})
			->join('tbl_orden_hoja_trabajo_detalle', function($join){
				$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo')
					->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo');
			})
			->join('tbl_contr_item_detalle AS tbl_contr_item_detalle_join', function($join){
				$join->on('tbl_contr_item_detalle_join.id_codigo_contrato', 'tbl_orden_hoja_trabajo_detalle.id_contrato');
				$join->on('tbl_contr_item_detalle_join.id_tienda', 'tbl_orden_hoja_trabajo_detalle.id_tienda_contrato');
				$join->on('tbl_contr_item_detalle_join.id_linea_item_contrato', 'tbl_orden_hoja_trabajo_detalle.id_item_contrato');
			})
			->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_orden.estado')
			->join('tbl_tienda','tbl_tienda.id','tbl_orden.id_tienda_orden')
			->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
			->join('tbl_orden_item', function($join){
				$join->on('tbl_orden_item.id_orden','tbl_orden.id_orden')
					->on('tbl_orden_item.id_tienda_orden','tbl_orden.id_tienda_orden');
			})

			->join('tbl_contr_cabecera', function($join){
				$join->on('tbl_contr_cabecera.codigo_contrato', 'tbl_orden_hoja_trabajo_detalle.id_contrato');
				$join->on('tbl_contr_cabecera.id_tienda_contrato', 'tbl_orden_hoja_trabajo_detalle.id_tienda_contrato');
			})
			->select(
				'tbl_orden.id_orden AS DT_RowId',
				'tbl_orden.id_orden',
				'tbl_tienda.nombre as tienda_orden',
				'tbl_prod_categoria_general.nombre as categoria',
				'tbl_orden.fecha_creacion',
				'tbl_sys_estado_tema.nombre as estado',
				// DB::Raw('FORMAT((SELECT SUM(inventario_producto.precio_compra) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS valor_contrato'),

				DB::raw("(SELECT DISTINCT GROUP_CONCAT( DISTINCT cod_bolsas_seguridad SEPARATOR ', ') FROM tbl_contr_cabecera INNER JOIN tbl_orden_hoja_trabajo_detalle AS trabajo_detalle ON tbl_contr_cabecera.codigo_contrato = trabajo_detalle.id_contrato AND tbl_contr_cabecera.id_tienda_contrato = trabajo_detalle.id_tienda_contrato WHERE trabajo_detalle.id_tienda_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo AND trabajo_detalle.id_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo) AS codigos_bolsas"),
				DB::raw("CONCAT('$ ', FORMAT((SELECT COALESCE(SUM(tbl_contr_item_detalle.precio_ingresado),0) FROM tbl_contr_item_detalle INNER JOIN tbl_orden_hoja_trabajo_detalle AS trabajo_detalle ON tbl_contr_item_detalle.id_codigo_contrato = trabajo_detalle.id_contrato AND tbl_contr_item_detalle.id_tienda = trabajo_detalle.id_tienda_contrato WHERE trabajo_detalle.id_tienda_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo AND trabajo_detalle.id_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),

				DB::Raw('FORMAT((SELECT COALESCE(SUM(inventario_producto.peso),0) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS peso_contrato'),
				DB::RAW('(SELECT COALESCE(SUM(orden_item.peso_estimado),0) FROM tbl_orden_item AS orden_item WHERE tbl_orden_item.id_orden = orden_item.id_orden AND tbl_orden_item.id_tienda_orden = orden_item.id_tienda_orden) AS peso_estimado_total'),
				DB::RAW('(SELECT COALESCE(SUM(orden_item.peso_total),0) FROM tbl_orden_item AS orden_item WHERE tbl_orden_item.id_orden = orden_item.id_orden AND tbl_orden_item.id_tienda_orden = orden_item.id_tienda_orden) AS peso_total_total'),
				DB::RAW('(SELECT COALESCE(SUM(orden_item.peso_taller),0) FROM tbl_orden_item AS orden_item WHERE tbl_orden_item.id_orden = orden_item.id_orden AND tbl_orden_item.id_tienda_orden = orden_item.id_tienda_orden) AS peso_taller_total'),
				DB::RAW('(SELECT COUNT(1) FROM tbl_orden_item AS orden_item WHERE tbl_orden_item.id_orden = orden_item.id_orden AND tbl_orden_item.id_tienda_orden = orden_item.id_tienda_orden) AS cantidad_items')
			)
			->where('tbl_orden.proceso',env('PROCESO_FUNDICION'))
			->where('tbl_orden.estado',$search["id_estado"])
			->distinct()
			->get();
	}

	public static function getItemOrden($id_tienda,$id)
	{
		return DB::table('tbl_orden_hoja_trabajo_cabecera')
										->join('tbl_orden', function($join){
											$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
												 ->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
										})
										
										->join('tbl_orden_hoja_trabajo_detalle', function($join){
                                            $join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo')
                                                ->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo');
                                        })
										->join('tbl_orden_item',function($join){
											$join->on('tbl_orden_item.id_orden','tbl_orden.id_orden')
												 ->on('tbl_orden_item.id_tienda_orden','tbl_orden.id_tienda_orden');
										})
										->leftjoin('tbl_cliente', function($join)
										{
											$join->on('tbl_cliente.codigo_cliente','=','tbl_orden.id_cliente');	
											$join->on('tbl_cliente.id_tienda','=','tbl_orden.id_tienda_cliente');	
										})
										->join('tbl_inventario_item_contrato', function($join){
											$join->on('tbl_inventario_item_contrato.id_inventario','tbl_orden_item.id_inventario')
												 ->on('tbl_inventario_item_contrato.id_tienda_inventario','tbl_orden_item.id_tienda_inventario');
										})
										->join('tbl_tienda', function($join){
												$join->on('tbl_inventario_item_contrato.id_tienda_inventario','tbl_tienda.id');
										})
										->join('tbl_contr_item_detalle', function($join){
											$join->on('tbl_contr_item_detalle.id_codigo_contrato','tbl_inventario_item_contrato.id_contrato')
												 ->on('tbl_contr_item_detalle.id_tienda','tbl_inventario_item_contrato.id_tienda_contrato')
												 ->on('tbl_contr_item_detalle.id_linea_item_contrato','tbl_inventario_item_contrato.id_item_contrato');
										})
										->join('tbl_contr_cabecera', function($join){
											$join->on('tbl_contr_cabecera.codigo_contrato','tbl_contr_item_detalle.id_codigo_contrato')
												 ->on('tbl_contr_cabecera.id_tienda_contrato','tbl_contr_item_detalle.id_tienda');
										})
										->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
										
										->leftJoin('tbl_orden_guardar', function($join){
											$join->on('tbl_orden_guardar.id_orden','tbl_orden.id_orden')
												 ->on('tbl_orden_guardar.id_tienda','tbl_orden.id_tienda_orden');
										})
										->leftJoin('tbl_orden_guardar_items', function($join){
											$join->on('tbl_orden_guardar_items.id_orden_guardar','tbl_orden_item.id_orden')
											->on('tbl_orden_guardar_items.id_tienda_contrato','tbl_orden_item.id_tienda_orden')
											->on('tbl_orden_guardar_items.id_inventario','tbl_orden_item.id_inventario');
										})
										->where('tbl_orden.id_orden',$id)
										->where('tbl_orden.id_tienda_orden',$id_tienda)
										->where('tbl_inventario_item_contrato.id_anulado',0)
										// ->where('tbl_orden.proceso','7')
									   	->select(
										    	'tbl_inventario_item_contrato.id_contrato',
												'tbl_inventario_item_contrato.id_tienda_contrato as tienda_contrato',
												'tbl_orden.fecha_creacion',
												'tbl_inventario_item_contrato.id_inventario',
												'tbl_inventario_item_contrato.id_tienda_inventario',
												'tbl_inventario_item_contrato.id_item_contrato AS id_item',
												'tbl_contr_item_detalle.nombre',
												'tbl_contr_item_detalle.observaciones',
												'tbl_contr_item_detalle.id_linea_item_contrato AS linea_item',
												'tbl_tienda.nombre AS nombre_tienda_contrato',
												DB::Raw("FORMAT((tbl_contr_item_detalle.peso_estimado),2,'de_DE') AS peso_estimado"),
												DB::Raw("FORMAT((tbl_contr_item_detalle.peso_total),2,'de_DE') AS peso_total"),
												DB::Raw("FORMAT((tbl_orden_item.peso_taller),2,'de_DE') AS peso_taller"),
												DB::Raw("tbl_contr_item_detalle.precio_ingresado AS precio_ingresado_noformat"),
												DB::Raw("tbl_contr_item_detalle.peso_estimado AS peso_estimado_noformat"),
												DB::Raw("tbl_contr_item_detalle.peso_total AS peso_total_noformat"),
												DB::raw("CONCAT('$ ', FORMAT((tbl_contr_item_detalle.precio_ingresado),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS precio_ingresado"),
												DB::raw("CONCAT('$ ', FORMAT((select SUM(precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_codigo_contrato = tbl_inventario_item_contrato.id_contrato AND tbl_contr_item_detalle.id_tienda = tbl_inventario_item_contrato.id_tienda_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS Suma_contrato"),               
                                                DB::raw("(SELECT DISTINCT GROUP_CONCAT( DISTINCT cod_bolsas_seguridad SEPARATOR ', ') FROM tbl_contr_cabecera INNER JOIN tbl_orden_hoja_trabajo_detalle AS trabajo_detalle ON tbl_contr_cabecera.codigo_contrato = trabajo_detalle.id_contrato AND tbl_contr_cabecera.id_tienda_contrato = trabajo_detalle.id_tienda_contrato WHERE trabajo_detalle.id_tienda_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo AND trabajo_detalle.id_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo) AS Bolsas"),
												DB::raw('cod_bolsa_seguridad_hasta - cod_bolsa_seguridad_desde AS bolsas'),
												'tbl_cliente.numero_documento AS destinatario',
												'tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo',
												'tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo',
												'tbl_prod_categoria_general.nombre as categoria',
												'tbl_orden.id_orden',
												'tbl_orden.id_tienda_orden',
												'tbl_orden_item.id_orden_item',
												'tbl_orden_item.id_tienda_orden_item',

												'tbl_orden_guardar_items.peso_taller',
												'tbl_contr_item_detalle.id_linea_item_contrato',
												'tbl_orden_item.peso_taller AS peso_taller_individual',
												'tbl_orden_item.peso_estimado AS peso_estimado_individual',
												'tbl_orden_item.peso_total AS peso_total_individual',
												'tbl_orden_item.peso_libre AS peso_libre_individual',
												DB::RAW('COALESCE(tbl_orden_guardar_items.peso_libre,0) AS peso_libre_g'),
												'tbl_orden_guardar_items.id_proceso',
												'tbl_orden_guardar.abre_bolsa',

												DB::Raw("LPAD(tbl_contr_cabecera.codigo_contrato,6,'0') AS codigo_contrato"),
												DB::Raw("CONCAT(COALESCE(tbl_cliente.nombres,''), ' ', COALESCE(tbl_cliente.primer_apellido,''), ' ',  COALESCE(tbl_cliente.segundo_apellido,'')) as nombres_cliente"),
												DB::raw("REPLACE(FORMAT(tbl_cliente.numero_documento,0), ',', '.') AS numero_documento_cliente"),
												DB::Raw("YEAR(tbl_contr_cabecera.fecha_creacion) AS anho_contrato"),
												DB::Raw("MONTH(tbl_contr_cabecera.fecha_creacion) AS mes_contrato"),
												DB::Raw("(tbl_contr_cabecera.fecha_creacion) AS fecha_contrato"),
												DB::Raw("DAY(tbl_contr_cabecera.fecha_creacion) AS dia_contrato")
										   )
										   ->distinct()
									   	->get();
	}

	public static function getFUNDICIONById($id){
		return ModelFUNDICION::where('id',$id)->first();
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
										'estado' => (int)env('PROCESADO_FUNDICION')
										// 'estado' => (int)env('PROCESADO_FUNDICION'),
										// 'mano_obra' => $data['mano_obra'],
										// 'transporte' => $data['transporte'],
										// 'costos_indirectos' => $data['costos_indirectos'],
										// 'otros_costos' => $data['otros_costos']
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
										'id_estado_producto' => (int)env('PROCESADO_FUNDICION'),
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
			DB::table('tbl_orden_destinatario')->insert($datosPreparados['destinatarios']);
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
// functions save orden with mermas in satate BLOQUEADO_FUNDICION

	public static function updateOrdenFundidaMermas($estadoFundido){
		for ($s=0; $s < count($estadoFundido) ; $s++) 
		{ 
			DB::table('tbl_orden')
						->where('id_orden',$estadoFundido[$s]['id_orden'])
						->where('id_tienda_orden',$estadoFundido[$s]['id_tienda_orden'])
						->update(['estado' => $estadoFundido[$s]['estado']]);
		}
	}

	public static function updateItemInventarioFundido($fundidoInventario){
		for ($o=0; $o < count($fundidoInventario) ; $o++){
			for($d=0;$d < count($fundidoInventario[$o]['id_inventario']) ;$d++){
				DB::table('tbl_inventario_producto')
				->where('id_inventario',$fundidoInventario[$o]['id_inventario'][$d])
				->where('id_tienda_inventario',$fundidoInventario[$o]['id_tienda_inventario'][$d])
				->update([
						'peso' => $fundidoInventario[$o]['peso'][$d],
						'id_estado_producto' => $fundidoInventario[$o]['id_estado_producto']
					]);
			}
		}
	}

	public static function ordenEnEstadoFundido($dataprepared){
		$result = 'Insertado';
		try{
			DB::beginTransaction();
			self::updateOrdenFundidaMermas($dataprepared['estadoFundido']);
			self::updateItemInventarioFundido($dataprepared['fundidoInventario']);
			DB::commit();
		}catch(\Exception $e){
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
// end functions in state BLOQUEADO_FUNDICION

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
        return DB::select('CALL sp_secuencias_tienda_x (?,?,?)',array($id_tienda,(int)env('SECUENCIA_TIPO_CODIGO_TRAZABILIDAD'),(int)1));
    }

	public static function getSelectList()
	{
		return ModelFUNDICION::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getListProceso(){
		return ModelTema::select(
								'id',
								'nombre AS name'
								)
								->whereIn('id',[
												env('PROCESO_FUNDICION'),
												env('PROCESO_MAQUILA')
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

	public static function getDestinatariosOrden($id_tienda,$id)
	{
		return DB::table('tbl_orden_guardar')
				->join('tbl_orden_guardar_destinatarios','tbl_orden_guardar.id_orden','tbl_orden_guardar_destinatarios.id_orden_guardar')
				->leftJoin('tbl_sys_tema','tbl_sys_tema.id','tbl_orden_guardar_destinatarios.id_proceso')
				->select(
						'tbl_sys_tema.nombre as proceso',
						'tbl_orden_guardar_destinatarios.destinatario',
						'tbl_orden_guardar_destinatarios.codigo_verificacion',
						'tbl_sys_tema.id as id_proceso',
						'tbl_orden_guardar_destinatarios.numero_bolsa'
				)
				->where('tbl_orden_guardar.id_tienda',$id_tienda)
				->where('tbl_orden_guardar.id_orden',$id)
				->get();
	}

	public static function getDestinatariosOrdenPadre($id_tienda,$id)
	{
		return DB::table('tbl_orden_destinatario')
				->join('tbl_orden', function($join){
					$join->on('tbl_orden.id_orden','tbl_orden_destinatario.id_orden')
						 ->on('tbl_orden.id_tienda_orden','tbl_orden_destinatario.id_tienda_orden');
				})
				->join('tbl_sys_tema','tbl_sys_tema.id','tbl_orden_destinatario.id_proceso')
				->leftJoin('tbl_cliente','tbl_cliente.numero_documento','tbl_orden_destinatario.destinatario')
				->leftJoin('tbl_clie_suc_cliente', function($join){
					$join->on('tbl_clie_suc_cliente.id_cliente','tbl_cliente.codigo_cliente')
						->on('tbl_clie_suc_cliente.id_tienda_cliente','tbl_cliente.id_tienda')
						->on('tbl_clie_suc_cliente.id_sucursal','tbl_orden_destinatario.sucursal');
				})
				->leftJoin('tbl_ciudad AS ciudad_cliente','tbl_cliente.id_ciudad_residencia','ciudad_cliente.id')
				->leftJoin('tbl_ciudad AS ciudad_sucursal','tbl_clie_suc_cliente.id_ciudad','ciudad_sucursal.id')
				->select(
						'tbl_sys_tema.id as id_proceso',
						'tbl_sys_tema.nombre as proceso',
						'tbl_orden_destinatario.destinatario',
						'tbl_orden_destinatario.codigo_verificacion',
						'tbl_orden_destinatario.numero_bolsa',
						'tbl_orden.fecha_creacion',
						'tbl_cliente.nombres AS nombres_destinatario',
						DB::raw("IF(tbl_clie_suc_cliente.id_sucursal IS NULL, 'ÚNICA SUCURSAL', tbl_clie_suc_cliente.nombre) AS sucursal"),
						DB::raw("IF(tbl_clie_suc_cliente.id_sucursal IS NULL, tbl_cliente.telefono_residencia, tbl_clie_suc_cliente.telefono_sucursal) AS telefono"),
						DB::raw("IF(tbl_clie_suc_cliente.id_sucursal IS NULL, ciudad_cliente.nombre, ciudad_sucursal.nombre) AS ciudad")
				)
				->where('tbl_orden_destinatario.id_tienda_orden',$id_tienda)
				->where('tbl_orden_destinatario.id_orden',$id)
				->whereIn('tbl_cliente.id_tipo_cliente',[5,6])
				->distinct()
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
										->join('tbl_sys_tema','tbl_sys_tema.id','tbl_orden.proceso')
										->where('tbl_orden_item.id_tienda_inventario',$id_tienda_inventario)
										->where('tbl_orden_trazabilidad.actual',1)
										->where('tbl_inventario_item_contrato.id_contrato',$id_contrato)
										->where('tbl_inventario_item_contrato.id_anulado',0)
										//->where('tbl_orden.estado',env('ORDEN_PROCESADA'))
										->select(
													'tbl_orden_item.id_orden',
													'tbl_inventario_item_contrato.id_contrato',
													'tbl_inventario_item_contrato.id_inventario',
													'tbl_inventario_item_contrato.id_tienda_inventario',
													'tbl_orden.estado',
													'tbl_tienda.nombre as tienda',
													'tbl_sys_estado_tema.nombre as nombre_estado',
													'tbl_sys_tema.nombre as nombre_proceso'
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
										->whereIn('tbl_orden.estado',[env('PROCESADO_FUNDICION'),env('PROCESADO_FUNDICION'),env('PROCESADO_VITRINA'),env('PROCESADO_MAQUILA'),env('PROCESADO_JOYA_ES')])
										->where('tbl_orden_item.id_tienda_inventario',$id_tienda_inventario)
										->where('tbl_inventario_item_contrato.id_anulado',0)
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
			self::updateInventario($id_inventario,$id_tienda_inventario);
			//self::deleteItemHojaTrabajo($id_tienda_inventario,$id_contrato);
			self::updateItemContratoInv($id_inventario,$id_tienda_inventario);
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

	public static function updateInventario($id_inventario,$id_tienda_inventario)
	{
		return DB::table('tbl_inventario_producto')->whereIn('id_inventario',$id_inventario)
												->where('id_tienda_inventario',$id_tienda_inventario)
												->update(['id_estado_producto' => env('PRODUCTO_NO_DISPONIBLE')]);
	}

	public static function updateItemContratoInv($id_inventario,$id_tienda_inventario)
	{
		return DB::table('tbl_inventario_item_contrato')->whereIn('id_inventario',$id_inventario)
												->where('id_tienda_inventario',$id_tienda_inventario)
												->update(['id_anulado' => 1]);
	}

	// public static function deleteItemHojaTrabajo($id_tienda_contrato,$id_contrato)
	// { //Se comenta por que no se debe eliminar la hoja de trabajo para la trazabilidad de los id's
	// 	return DB::table('tbl_orden_hoja_trabajo_detalle')->where('id_contrato',$id_contrato)
	// 											->where('id_tienda_contrato',$id_tienda_contrato)
	// 											->delete();
	// }

	public static function updateEstadoInventario($id_inventario,$id_tienda,$motivo,$estado)
	{
		return DB::table('tbl_inventario_producto')->where('id_inventario',$id_inventario)
												   ->where('id_tienda_inventario',$id_tienda)
												   ->update([
													   'id_estado_producto' => $estado,
													   'id_motivo_producto' => $motivo
												   ]);
	}

	public static function getOrdenExcel($id_orden, $id_tienda)
	{
		return DB::table('tbl_orden')->join('tbl_orden_hoja_trabajo_cabecera', function($join){
						$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
							->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
				})
				->join('tbl_orden_hoja_trabajo_detalle', function($join){
					$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo')
						->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo');
				})
				->join('tbl_contr_item_detalle AS tbl_contr_item_detalle_join', function($join){
					$join->on('tbl_contr_item_detalle_join.id_codigo_contrato', 'tbl_orden_hoja_trabajo_detalle.id_contrato');
					$join->on('tbl_contr_item_detalle_join.id_tienda', 'tbl_orden_hoja_trabajo_detalle.id_tienda_contrato');
					$join->on('tbl_contr_item_detalle_join.id_linea_item_contrato', 'tbl_orden_hoja_trabajo_detalle.id_item_contrato');
				})
				->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_orden.estado')
				->join('tbl_tienda','tbl_tienda.id','tbl_orden.id_tienda_orden')
				->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
				->join('tbl_orden_item', function($join){
					$join->on('tbl_orden_item.id_orden','tbl_orden.id_orden')
						->on('tbl_orden_item.id_tienda_orden','tbl_orden.id_tienda_orden');
				})
				->join('tbl_inventario_producto', function($join){
					$join->on('tbl_orden_item.id_inventario','tbl_inventario_producto.id_inventario')
						->on('tbl_orden_item.id_tienda_orden','tbl_inventario_producto.id_tienda_inventario');
				})

				->leftJoin('tbl_prod_catalogo', function($join){
					$join->on('tbl_prod_catalogo.id','tbl_inventario_producto.id_catalogo_producto');
				})

				->join('tbl_contr_cabecera', function($join){
					$join->on('tbl_contr_cabecera.codigo_contrato', 'tbl_orden_hoja_trabajo_detalle.id_contrato');
					$join->on('tbl_contr_cabecera.id_tienda_contrato', 'tbl_orden_hoja_trabajo_detalle.id_tienda_contrato');
				})
				->select(
						'tbl_orden.id_orden AS DT_RowId',
						'tbl_tienda.nombre as tienda_orden',
						'tbl_prod_categoria_general.nombre as categoria',
						'tbl_contr_cabecera.codigo_contrato',
						'tbl_contr_cabecera.fecha_creacion AS fecha_perfeccionamiento',
						'tbl_contr_cabecera.fecha_creacion AS fecha_contratacion',
						'tbl_orden_item.id_inventario',
						'tbl_prod_catalogo.descripcion AS nombre',
						'tbl_prod_catalogo.descripcion AS observaciones',
						'tbl_inventario_producto.peso AS peso_total',
						'tbl_inventario_producto.peso_estimado',
						'tbl_inventario_producto.precio_compra',
						'tbl_inventario_producto.peso_taller',
						DB::raw("CONCAT('$ ', FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) FROM tbl_contr_item_detalle INNER JOIN tbl_orden_hoja_trabajo_detalle AS trabajo_detalle ON tbl_contr_item_detalle.id_codigo_contrato = trabajo_detalle.id_contrato AND tbl_contr_item_detalle.id_tienda = trabajo_detalle.id_tienda_contrato WHERE trabajo_detalle.id_tienda_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo AND trabajo_detalle.id_hoja_trabajo = tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS Suma_contrato"),
						DB::raw("CONCAT('$ ', FORMAT((tbl_inventario_producto.precio_compra),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS precio_compra")
				)
				->distinct()
				->where('tbl_orden.id_orden',$id_orden)
				->where('tbl_orden.id_tienda_orden',$id_tienda)
				->get();
	}
	// Inicio Guardado Temporal
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

	public static function ordenActualizarPesoLibre($orden_actualizar_peso_libre){
		for ($i=0; $i < count($orden_actualizar_peso_libre) ; $i++)
		{ 
			DB::table('tbl_orden_item')
				->where('id_orden',       $orden_actualizar_peso_libre[$i]['id_orden'])
				->where('id_inventario',  $orden_actualizar_peso_libre[$i]['id_inventario'])
				->update(['peso_libre' => $orden_actualizar_peso_libre[$i]['peso_libre']]);
		}
	}
	// Final Guardado Temporal

	public static function getItemOrdenConcat($id_tienda,$id)
	{
		return DB::table('tbl_orden_hoja_trabajo_cabecera')
										->join('tbl_orden', function($join){
											$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
												 ->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
										})
										
										->join('tbl_orden_hoja_trabajo_detalle', function($join){
                                            $join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo')
                                                ->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo');
                                        })
										->join('tbl_orden_item',function($join){
											$join->on('tbl_orden_item.id_orden','tbl_orden.id_orden')
												 ->on('tbl_orden_item.id_tienda_orden','tbl_orden.id_tienda_orden');
										})
										->leftjoin('tbl_cliente', function($join)
										{
											$join->on('tbl_cliente.codigo_cliente','=','tbl_orden.id_cliente');	
											$join->on('tbl_cliente.id_tienda','=','tbl_orden.id_tienda_cliente');	
										})
										->join('tbl_inventario_item_contrato', function($join){
											$join->on('tbl_inventario_item_contrato.id_inventario','tbl_orden_item.id_inventario')
												 ->on('tbl_inventario_item_contrato.id_tienda_inventario','tbl_orden_item.id_tienda_inventario');
										})
										->join('tbl_tienda', function($join){
												$join->on('tbl_inventario_item_contrato.id_tienda_inventario','tbl_tienda.id');
										})
										->join('tbl_contr_item_detalle', function($join){
											$join->on('tbl_contr_item_detalle.id_codigo_contrato','tbl_inventario_item_contrato.id_contrato')
												 ->on('tbl_contr_item_detalle.id_tienda','tbl_inventario_item_contrato.id_tienda_contrato')
												 ->on('tbl_contr_item_detalle.id_linea_item_contrato','tbl_inventario_item_contrato.id_item_contrato');
										})
										->join('tbl_contr_cabecera', function($join){
											$join->on('tbl_contr_cabecera.codigo_contrato','tbl_contr_item_detalle.id_codigo_contrato')
												 ->on('tbl_contr_cabecera.id_tienda_contrato','tbl_contr_item_detalle.id_tienda');
										})
										->leftJoin('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
										
										->leftJoin('tbl_orden_guardar', function($join){
											$join->on('tbl_orden_guardar.id_orden','tbl_orden.id_orden')
												 ->on('tbl_orden_guardar.id_tienda','tbl_orden.id_tienda_orden');
										})
										->leftJoin('tbl_orden_guardar_items', function($join){
											$join->on('tbl_orden_guardar_items.id_orden_guardar','tbl_orden_item.id_orden')
											->on('tbl_orden_guardar_items.id_tienda_contrato','tbl_orden_item.id_tienda_orden')
											->on('tbl_orden_guardar_items.id_inventario','tbl_orden_item.id_inventario');
										})
										->where('tbl_inventario_item_contrato.id_anulado',0)
										->where('tbl_orden.id_orden',$id)
										->where('tbl_orden.id_tienda_orden',$id_tienda)
										// ->where('tbl_orden.proceso','8')
									   	->select(
												DB::raw("CONCAT(tbl_inventario_item_contrato.id_tienda_inventario,'-',tbl_inventario_item_contrato.id_inventario,'-',tbl_inventario_item_contrato.id_contrato,'-',tbl_orden.id_orden) AS inventario"),
												"tbl_orden.id_orden",
												"tbl_orden.id_tienda_orden"
										)
										->distinct()
									   	->get();
	}

// Funciones para anular orden
	// public static function AnularOrden($id_orden, $id_tienda_orden)
	// {
	// 	return DB::table('tbl_orden')->where('id_orden',$id_orden)
	// 												->where('id_tienda_orden',$id_tienda_orden)
	// 												->update([
	// 													'estado' => 0
	// 												]);
	// }
	public static function AnularOrden($id_orden, $id_tienda_orden, $id_orden_padre)
	{
		$response = true;
		DB::beginTransaction();
		$ordenes = self::getOrdenesTraza($id_orden_padre, $id_tienda_orden);
		if(count($ordenes) > 0){
			self::deleteOrdenItemTraza($ordenes, $id_tienda_orden);
			self::deleteTraza($id_orden_padre, $id_tienda_orden);
			self::activeTrazaAntigua($id_orden_padre, $id_tienda_orden);
			self::anularOrdenesTraza($ordenes, $id_tienda_orden);
			self::activeOrdenTrazaAntigua($id_orden_padre, $id_tienda_orden);
		}else{
			$response = false;
		}
		
		DB::commit();
		return $response;
	}

	public static function updateEstadoOrden($id_tienda,$id_orden)
	{
		return DB::table('tbl_orden')->where('id_tienda_orden',$id_tienda)
									   		->where('id_orden',$id_orden)
									   		->update(['estado' => env('ANULADA_PREREFACCION')]);
	}
	
	public static function getOrdenesTraza($id_orden_padre, $id_tienda_orden)
	{
		$ordenes = DB::table('tbl_orden_trazabilidad')
		->select('tbl_orden.id_orden')
		->join('tbl_orden', function($join){
			$join->on('tbl_orden.id_orden', 'tbl_orden_trazabilidad.id_orden');
			$join->on('tbl_orden.id_tienda_orden', 'tbl_orden_trazabilidad.id_tienda_orden');
		})
		->where('id_traza_padre',$id_orden_padre)
		->where('id_tienda_traza_padre',$id_tienda_orden)
		->get();

		$ordenes_array = array();
		for ($i=0; $i < count($ordenes); $i++) { 
			array_push($ordenes_array, $ordenes[$i]->id_orden);
		}
		return $ordenes_array;
	}

	public static function deleteOrdenItemTraza($ordenes, $id_tienda_orden)
	{
		DB::table('tbl_orden_item')
		->whereIn('id_orden', $ordenes)
		->where('id_tienda_orden', $id_tienda_orden)->delete();
	}

	public static function deleteTraza($id_orden_padre, $id_tienda_orden)
	{
		DB::table('tbl_orden_trazabilidad')
		->where('id_traza_padre', $id_orden_padre)
		->where('id_tienda_traza_padre', $id_tienda_orden)->delete();
	}

	public static function activeTrazaAntigua($id_orden_padre, $id_tienda_orden)
	{
		DB::table('tbl_orden_trazabilidad')
		->where('id_orden', $id_orden_padre)
		->where('id_tienda_traza_padre', $id_tienda_orden)
		->update(['actual' => 1, 'accion' => 'Creado']);
	}

	public static function anularOrdenesTraza($ordenes, $id_tienda_orden)
	{
		DB::table('tbl_orden')
		->whereIn('id_orden', $ordenes)
		->where('id_tienda_orden', $id_tienda_orden)
		->update(['estado' => env('ORDEN_ANULADA')]);
	}

	public static function activeOrdenTrazaAntigua($id_orden_padre, $id_tienda_orden)
	{
		DB::table('tbl_orden')
		->where('id_orden', $id_orden_padre)
		->where('id_tienda_orden', $id_tienda_orden)
		->update(['estado' => env('ORDEN_PENDIENTE_POR_PROCESAR')]);
	}

	public static function getIdOrdenPadre($id_orden, $id_tienda_orden)
	{
		return DB::table('tbl_orden_trazabilidad')
			->where('id_orden',$id_orden)
			->where('id_tienda_orden',$id_tienda_orden)
			->value('id_traza_padre');
	}

	public static function countOrdenesProcesadas($id_orden_padre, $id_tienda_ordenes)
	{
		return DB::table('tbl_orden_trazabilidad')
			->join('tbl_orden', function($join){
				$join->on('tbl_orden.id_orden', 'tbl_orden_trazabilidad.id_orden');
				$join->on('tbl_orden.id_tienda_orden', 'tbl_orden_trazabilidad.id_tienda_orden');
			})
			->where('id_traza_padre',$id_orden_padre)
			->where('id_tienda_traza_padre',$id_tienda_ordenes)
			->where('estado',env('ORDEN_PROCESADA'))
			->count();
	}
// final funciones anular orden
//quitar contratos
	public static function validarquitarItem($id_tienda_inventario,$id_inventario,$id_contrato)
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
										->where('tbl_inventario_item_contrato.id_anulado',0)
										->where('tbl_inventario_item_contrato.id_contrato',$id_contrato)
										->where('tbl_orden.estado','!=',ENV('ORDEN_PENDIENTE_POR_PROCESAR'))
										->select(
													'tbl_orden_item.id_orden',
													'tbl_inventario_item_contrato.id_contrato',
													'tbl_inventario_item_contrato.id_inventario',
													'tbl_inventario_item_contrato.id_tienda_inventario',
													'tbl_orden.estado',
													'tbl_orden.proceso',
													'tbl_tienda.nombre as tienda',
													'tbl_sys_estado_tema.nombre as nombre_estado'
												)
										->get();
	}

	public static function validarOrden($id_tienda_inventario,$id_orden)
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
										->where('tbl_orden_item.id_orden',$id_orden)
										->where('tbl_inventario_item_contrato.id_anulado',0)
										->select(
													'tbl_orden_item.id_orden',
													'tbl_inventario_item_contrato.id_contrato',
													'tbl_inventario_item_contrato.id_inventario',
													'tbl_inventario_item_contrato.id_tienda_inventario',
													'tbl_orden.estado',
													'tbl_orden.proceso',
													'tbl_tienda.nombre as tienda',
													'tbl_sys_estado_tema.nombre as nombre_estado'
												)
										->get();
	}
//end 
/*para limpiar valores en el movimiento contable*/
	public static function limpiarVal($val){
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}

/*Para los campos Número de orden de perfeccionamiento Y Fecha de orden de perfeccionamiento*/
	public static function datosPerfeccionamiento($id_tienda, $id_contrato)
	{
		return (DB::table('tbl_orden_guardar_items')
			->join('tbl_orden_guardar', function($join){
				$join->on('tbl_orden_guardar_items.id_orden_guardar', 'tbl_orden_guardar.id');
				$join->on('tbl_orden_guardar_items.id_tienda_contrato', 'tbl_orden_guardar.id_tienda');
			})
			->select(
				'fecha_creacion',
				'id_orden'
			)
			->where('tbl_orden_guardar_items.codigo_contrato',$id_contrato)
			->where('tbl_orden_guardar_items.id_tienda_contrato',$id_tienda)
			->first());
	}
}
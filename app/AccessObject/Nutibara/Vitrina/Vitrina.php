<?php 

namespace App\AccessObject\Nutibara\Vitrina;

use App\Models\Nutibara\Orden\Orden AS ModelOrden;
use App\Models\Nutibara\Tema\Tema AS ModelTema;
use DB;

class Vitrina 
{
	public static function VitrinaWhere($start,$end,$colum, $order,$search){
		return DB::table('tbl_orden')->join('tbl_orden_hoja_trabajo_cabecera', function($join)
								{
										$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
											    ->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
								})
								->join('tbl_orden_hoja_trabajo_detalle', function($join){
									$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo')
										->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo');
								})
								->join('tbl_contr_item_detalle', function($join){
									$join->on('tbl_contr_item_detalle.id_codigo_contrato', 'tbl_orden_hoja_trabajo_detalle.id_contrato');
									$join->on('tbl_contr_item_detalle.id_tienda', 'tbl_orden_hoja_trabajo_detalle.id_tienda_contrato');
									$join->on('tbl_contr_item_detalle.id_linea_item_contrato', 'tbl_orden_hoja_trabajo_detalle.id_item_contrato');
								})
								->join('tbl_contr_cabecera', function($join){
									$join->on('tbl_contr_cabecera.codigo_contrato', 'tbl_orden_hoja_trabajo_detalle.id_contrato');
									$join->on('tbl_contr_cabecera.id_tienda_contrato', 'tbl_orden_hoja_trabajo_detalle.id_tienda_contrato');
								})
								->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_orden.estado')
								->join('tbl_tienda','tbl_tienda.id','tbl_orden.id_tienda_orden')
								->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
								->join('tbl_orden_item', function($join){
									$join->on('tbl_orden_item.id_orden','tbl_orden.id_orden')
										 ->on('tbl_orden_item.id_tienda_orden','tbl_orden.id_tienda_orden');
								})
								->join('tbl_inventario_producto', function($join){
									$join->on('tbl_inventario_producto.id_inventario', 'tbl_orden_item.id_inventario');
									$join->on('tbl_inventario_producto.id_tienda_inventario', 'tbl_orden_item.id_tienda_inventario');
								})
								->select(
										'tbl_orden.id_orden AS DT_RowId',
										'tbl_orden.id_orden',
										'tbl_tienda.nombre as tienda_orden',
										'tbl_prod_categoria_general.nombre as categoria',
										'tbl_orden.fecha_creacion',
										'tbl_sys_estado_tema.nombre as estado',
										// DB::Raw('FORMAT((SELECT SUM(inventario_producto.precio_compra) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS valor_contrato'),
										DB::Raw('FORMAT((SELECT COALESCE(FORMAT(SUM(inventario_producto.peso),2,"de_DE"),0) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS peso_contrato'),
										DB::Raw("CONCAT('$ ', FORMAT((SELECT COALESCE(SUM(tbl_contr_item_detalle.precio_ingresado),0) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),
										DB::Raw('COALESCE(FORMAT((SELECT SUM(peso_estimado) FROM (SELECT a.id_orden,a.id_tienda_orden,peso_estimado,proceso FROM tbl_orden a join tbl_orden_item on tbl_orden_item.id_orden = a.id_orden and tbl_orden_item.id_tienda_orden = a.id_tienda_orden GROUP BY a.id_orden,a.id_tienda_orden,tbl_orden_item.id_orden_item) AS tabla WHERE id_orden = `tbl_orden`.`id_orden` AND id_tienda_orden = `tbl_orden`.`id_tienda_orden`),2,"de_DE"),0) as peso_estimado_total'),
										DB::RAW('COALESCE(FORMAT((select sum((select sum(peso) from tbl_inventario_producto where id_inventario = tbl_orden_item.id_inventario and id_tienda_inventario = tbl_orden_item.id_tienda_inventario )) from tbl_orden_item where id_orden = tbl_orden.id_orden and id_tienda_orden = tbl_orden.id_tienda_orden),2,"de_DE"),0) as peso_total_total'),
										'tbl_contr_cabecera.cod_bolsas_seguridad',
										DB::RAW('COALESCE(FORMAT(SUM(tbl_orden_item.peso_taller),2,"de_DE"),0) as peso_taller'),
										DB::RAW('COALESCE(FORMAT((select sum((select sum(peso) from tbl_inventario_producto where id_inventario = tbl_orden_item.id_inventario and id_tienda_inventario = tbl_orden_item.id_tienda_inventario )) from tbl_orden_item where id_orden = tbl_orden.id_orden and id_tienda_orden = tbl_orden.id_tienda_orden),2,"de_DE"),0) as peso_final'),
										DB::RAW('COALESCE(FORMAT((select count(id_orden_item) from tbl_orden_item where id_orden = tbl_orden.id_orden and id_tienda_orden = tbl_orden.id_tienda_orden),2,"de_DE"),0) as ids_internos')
								)
								->where('tbl_orden.proceso',env('PROCESO_VITRINA'))
								->where('tbl_tienda.id', \tienda::Online()->id)
								->where(function ($query) use ($search) {
									if($search["id_estado"] == ""){
										$query->where('tbl_orden.estado', env('ORDEN_PENDIENTE_POR_PROCESAR'));
									}
								})
								->where(function ($query) use ($search) {
									if($search["id_categoria"] != "" && $search["id_categoria"] != "null")	$query->where('tbl_prod_categoria_general.id',$search['id_categoria']);
									if($search["id_estado"] != "" && $search["id_estado"] != "null")	$query->where('tbl_orden.estado',$search['id_estado']);								
								})
								->groupBy('tbl_orden.id_orden','tbl_tienda.id')
								->orderBy($colum, $order)
								->skip($start)
								->take($end)
								->distinct()
								->get();
	}
	
    public static function DetalleOrdenesVitrina($id_tienda,$ids_orden){

		return ModelOrden::join('tbl_orden_hoja_trabajo_cabecera', function ($join) {
			$join->on('tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo' , '=' , 'tbl_orden.id_hoja_trabajo');
			$join->on('tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo' , '=' , 'tbl_orden.id_tienda_hoja_trabajo');
		})
		->join('tbl_orden_item', function ($join) {
			$join->on('tbl_orden_item.id_orden' , '=' , 'tbl_orden.id_orden');
			$join->on('tbl_orden_item.id_tienda_orden' , '=' , 'tbl_orden.id_tienda_orden');
		})
		->leftjoin('tbl_orden_trazabilidad', function ($join) {
			$join->on('tbl_orden_trazabilidad.id_orden' , '=' , 'tbl_orden.id_orden');
			$join->on('tbl_orden_trazabilidad.id_tienda_orden' , '=' , 'tbl_orden.id_tienda_orden');
		})
		->leftjoin('tbl_orden_guardar', function ($join) {
			$join->on('tbl_orden_guardar.id' , '=' , 'tbl_orden_trazabilidad.id_traza_padre');
			$join->on('tbl_orden_guardar.id_tienda' , '=' , 'tbl_orden_trazabilidad.id_tienda_traza_padre');
		})
		->leftjoin('tbl_cliente', function($join)
		{
			$join->on('tbl_cliente.codigo_cliente','=','tbl_orden.id_cliente');	
			$join->on('tbl_cliente.id_tienda','=','tbl_orden.id_tienda_cliente');
		})
		->join('tbl_inventario_item_contrato', function ($join) {
			$join->on('tbl_inventario_item_contrato.id_inventario' , '=' , 'tbl_orden_item.id_inventario');
			$join->on('tbl_inventario_item_contrato.id_tienda_inventario' , '=' , 'tbl_orden_item.id_tienda_inventario');
		})
		->join('tbl_inventario_producto', function ($join) {
			$join->on('tbl_inventario_producto.id_inventario' , '=' , 'tbl_orden_item.id_inventario');
			$join->on('tbl_inventario_producto.id_tienda_inventario' , '=' , 'tbl_orden_item.id_tienda_inventario');
		})
		->join('tbl_contr_item_detalle', function ($join) {
			$join->on('tbl_contr_item_detalle.id_codigo_contrato' , '=' , 'tbl_inventario_item_contrato.id_contrato');
			$join->on('tbl_contr_item_detalle.id_tienda' , '=' , 'tbl_inventario_item_contrato.id_tienda_contrato');
			$join->on('tbl_contr_item_detalle.id_linea_item_contrato' , '=' , 'tbl_inventario_item_contrato.id_item_contrato');
		})
		->join('tbl_contr_cabecera', function ($join) {
			$join->on('tbl_contr_cabecera.codigo_contrato' , '=' , 'tbl_contr_item_detalle.id_codigo_contrato');
			$join->on('tbl_contr_cabecera.id_tienda_contrato' , '=' , 'tbl_contr_item_detalle.id_tienda');
		})
		->join('tbl_tienda','tbl_tienda.id','tbl_contr_cabecera.id_tienda_contrato')
		->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
		->select(
		'tbl_inventario_item_contrato.id_contrato AS contrato',
		'tbl_inventario_item_contrato.id_tienda_contrato AS tienda_contrato',
		'tbl_tienda.nombre AS nombre_tienda',
		'tbl_orden.fecha_creacion AS fecha',
		'tbl_inventario_item_contrato.id_inventario AS id_inventario',
		'tbl_inventario_item_contrato.id_tienda_inventario',
		'tbl_inventario_item_contrato.id_item_contrato AS id_item',
		'tbl_contr_item_detalle.nombre AS atributo',
		'tbl_contr_item_detalle.observaciones AS descripcion',
		'tbl_contr_item_detalle.id_linea_item_contrato',
		DB::raw("FORMAT(tbl_contr_item_detalle.peso_total,2,'de_DE') as peso_total"),
		DB::raw("FORMAT(tbl_contr_item_detalle.peso_estimado,2,'de_DE') as peso_estimado"),
		DB::raw("CONCAT('$ ', FORMAT(tbl_contr_item_detalle.precio_ingresado,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) as precio_ingresado"),
		DB::raw("FORMAT(tbl_orden_item.peso_joyeria,2,'de_DE') as peso_joyeria"),
		DB::raw("FORMAT(tbl_orden_item.peso_taller,2,'de_DE') as peso_taller"),
		DB::raw("CONCAT('$ ', FORMAT((SELECT SUM(precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_codigo_contrato = tbl_inventario_item_contrato.id_contrato AND tbl_contr_item_detalle.id_tienda = tbl_inventario_item_contrato.id_tienda_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS Suma_contrato"),
		DB::raw("(cod_bolsa_seguridad_hasta - cod_bolsa_seguridad_desde) AS Bolsas"),
		'tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo',
		'tbl_prod_categoria_general.nombre as categoria',
		'tbl_prod_categoria_general.id as id_categoria',
		'tbl_orden.id_orden',
		'tbl_orden.fecha_creacion',
		'tbl_orden.id_tienda_orden',
		'tbl_cliente.numero_documento AS destinatario',
		'tbl_inventario_producto.id_catalogo_producto',
		DB::raw("FORMAT(tbl_inventario_producto.peso,2,'de_DE') as peso"),
		'cod_bolsas_seguridad',
		'tbl_orden_guardar.fecha_creacion as fecha_perfeccionamiento',
		'tbl_orden_guardar.id_orden as numero_perfeccionamiento'
		)
		->where('tbl_orden.id_tienda_orden',$id_tienda)
		->whereIn('tbl_orden.id_orden',$ids_orden)
		->get();
	}



	public static function getCountVitrina($search){
		return DB::table('tbl_orden')->join('tbl_orden_hoja_trabajo_cabecera', function($join)
								{
										$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
											    ->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
								})
								->join('tbl_orden_hoja_trabajo_detalle', function($join){
									$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo')
										->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo');
								})
								->join('tbl_contr_item_detalle', function($join){
									$join->on('tbl_contr_item_detalle.id_codigo_contrato', 'tbl_orden_hoja_trabajo_detalle.id_contrato');
									$join->on('tbl_contr_item_detalle.id_tienda', 'tbl_orden_hoja_trabajo_detalle.id_tienda_contrato');
									$join->on('tbl_contr_item_detalle.id_linea_item_contrato', 'tbl_orden_hoja_trabajo_detalle.id_item_contrato');
								})
								->join('tbl_contr_cabecera', function($join){
									$join->on('tbl_contr_cabecera..codigo_contrato', 'tbl_orden_hoja_trabajo_detalle.id_contrato');
									$join->on('tbl_contr_cabecera.id_tienda_contrato', 'tbl_orden_hoja_trabajo_detalle.id_tienda_contrato');
								})
								->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_orden.estado')
								->join('tbl_tienda','tbl_tienda.id','tbl_orden.id_tienda_orden')
								->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
								->join('tbl_orden_item', function($join){
									$join->on('tbl_orden_item.id_orden','tbl_orden.id_orden')
										 ->on('tbl_orden_item.id_tienda_orden','tbl_orden.id_tienda_orden');
								})
								->select(
										'tbl_orden.id_orden AS DT_RowId',
										'tbl_orden.id_orden',
										'tbl_tienda.nombre as tienda_orden',
										'tbl_prod_categoria_general.nombre as categoria',
										'tbl_orden.fecha_creacion',
										'tbl_sys_estado_tema.nombre as estado',
										// DB::Raw('FORMAT((SELECT SUM(inventario_producto.precio_compra) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS valor_contrato'),
										DB::Raw('FORMAT((SELECT SUM(inventario_producto.peso) FROM tbl_inventario_producto AS inventario_producto INNER JOIN tbl_orden_item AS orden_item ON inventario_producto.id_inventario = orden_item.id_inventario AND inventario_producto.id_tienda_inventario = orden_item.id_tienda_inventario WHERE orden_item.id_orden = tbl_orden_item.id_orden AND orden_item.id_tienda_orden = tbl_orden_item.id_tienda_orden),2,"de_DE") AS peso_contrato'),
										DB::Raw("CONCAT(FORMAT((SELECT SUM(tbl_contr_item_detalle.precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato),(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor_contrato"),
										DB::Raw('(SELECT SUM(tbl_contr_item_detalle.peso_estimado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_tienda = tbl_contr_cabecera.id_tienda_contrato AND tbl_contr_item_detalle.id_codigo_contrato = tbl_contr_cabecera.codigo_contrato) AS peso_estimado_total'),
										'tbl_contr_cabecera.cod_bolsas_seguridad'
								)
								->where('tbl_orden.proceso',env('PROCESO_VITRINA'))
								->where('tbl_tienda.id', \tienda::Online()->id)
								->where(function ($query) use ($search) {
									if($search["id_estado"] == ""){
										$query->where('tbl_orden.estado', env('ORDEN_PENDIENTE_POR_PROCESAR'));
									}
								})
								->where(function ($query) use ($search) {
									if($search["id_categoria"] != "" && $search["id_categoria"] != "null")	$query->where('tbl_prod_categoria_general.id',$search['id_categoria']);
									if($search["id_estado"] != "" && $search["id_estado"] != "null")	$query->where('tbl_orden.estado',$search['id_estado']);								
								})
								->distinct()
								->get();
	}
	public static function Procesar($data,$ordenes)
	{
		$result="Insertado";
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
		$secuenciaT = self::sec_trazabilidad($data['id_tienda_orden'][0]);
		
		for ($i=0; $i < count($ordenes); $i++) { 
			DB::table('tbl_orden')->where('id_orden',$ordenes[$i])
									->where('id_tienda_orden',$data['id_tienda_orden'][0])
									->update([
										'estado' => env('ORDEN_PROCESADA'),
									]);

			DB::table('tbl_orden_trazabilidad')->where('id_orden',$ordenes[$i])
												->where('id_tienda_orden',$data['id_tienda_orden'][0])
												->update([ 'actual' => (int)0 ]);
			
			$info_T = DB::table('tbl_orden_trazabilidad')->where('id_tienda_orden',$data['id_tienda_orden'][0])
														->where('id_orden',$ordenes[$i])
														->select('id_trazabilidad','id_tienda_trazabilidad')
														->first();
			
			DB::table('tbl_orden_trazabilidad')->insert(
											[
												[
													'id_trazabilidad' => (int)$secuenciaT[0]->response,
													'id_tienda_trazabilidad' => (int)$data['id_tienda_orden'][0], 
													'id_traza_padre' => $info_T->id_trazabilidad,
													'id_tienda_traza_padre' => $info_T->id_tienda_trazabilidad,
													'id_orden' => (int)$ordenes[$i], 
													'id_tienda_orden' => (int)$data['id_tienda_orden'][0], 
													'actual' => (int)1, 
													'fecha_accion' => $fecha,
													'accion' => 'Procesado'
												]
											]);
		}
		for ($i=0; $i < count($data['id_item']) ; $i++) {

			$nuevo_precio = (float)self::limpiarVal($data['precio_ingresado'][$i]);
			DB::table('tbl_orden_item')->where('id_inventario',$data['id_item'][$i])
			->where('id_tienda_inventario',$data['id_tienda_orden'][0])
			->update(['peso_taller' => $data['peso_taller'][$i]]);

			DB::table('tbl_inventario_producto')
				->where('id_inventario',$data['id_item'][$i])
				->where('id_tienda_inventario',$data['id_tienda_orden'][0])
				->update([ 
					'id_estado_producto' => 79,
					'id_motivo_producto' => 29, 
					'peso' => $data['peso_libre'][$i],
					'precio_venta' => $nuevo_precio,
					'cantidad' => 1
				]);
		}

	}

	public static function sec_trazabilidad($id_tienda)
    {
        return DB::select('CALL sp_secuencias_tienda_x (?,?,?)',array($id_tienda,env('SECUENCIA_TIPO_CODIGO_TRAZABILIDAD'),(int)1));
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

	public static function getListProceso(){
		return ModelTema::select(
			'id',
			'nombre AS name'
		)
		->whereIn('id',
			[
				env('PROCESO_VITRINA'),
				env('PROCESO_MAQUILA_NACIONAL'),
				env('PROCESO_MAQUILA_IMPORTADA'),
				env('PROCESO_REFACCION'),
				env('PROCESO_FUNDICION'),
				env('PROCESO_MAQUILA'),
				env('PROCESO_JOYA_ESPECIAL')
			]
		)
		->get();
	}

	public static function getItemOrden($id_tienda,$id)
	{
		return DB::table('tbl_orden_hoja_trabajo_cabecera')
															->leftJoin('tbl_orden', function($join){
																$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
																		->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
															})
															->leftJoin('tbl_orden_item',function($join){
																$join->on('tbl_orden_item.id_orden','tbl_orden.id_orden')
																		->on('tbl_orden_item.id_tienda_orden','tbl_orden.id_tienda_orden');
															})
															->leftJoin('tbl_inventario_item_contrato', function($join){
																$join->on('tbl_inventario_item_contrato.id_inventario','tbl_orden_item.id_inventario')
																		->on('tbl_inventario_item_contrato.id_tienda_inventario','tbl_orden_item.id_tienda_inventario');
															})
															->leftJoin('tbl_contr_item_detalle', function($join){
																$join->on('tbl_contr_item_detalle.id_codigo_contrato','tbl_inventario_item_contrato.id_contrato')
																		->on('tbl_contr_item_detalle.id_tienda','tbl_inventario_item_contrato.id_tienda_contrato')
																		->on('tbl_contr_item_detalle.id_linea_item_contrato','tbl_inventario_item_contrato.id_item_contrato');
															})
															->leftJoin('tbl_contr_cabecera', function($join){
																$join->on('tbl_contr_cabecera.codigo_contrato','tbl_contr_item_detalle.id_codigo_contrato')
																		->on('tbl_contr_cabecera.id_tienda_contrato','tbl_contr_item_detalle.id_tienda');
															})
															->leftJoin('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
															->leftJoin('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_orden_hoja_trabajo_cabecera.categoria')
															->whereIn('tbl_orden.id_orden',$id)
															->where('tbl_orden.id_tienda_orden',$id_tienda)
															->select(
																	'tbl_inventario_item_contrato.id_inventario',
																	'tbl_contr_item_detalle.nombre',
																	'tbl_contr_item_detalle.observaciones',
																	'tbl_contr_item_detalle.peso_total',
																	'tbl_contr_item_detalle.peso_estimado',
																	'tbl_prod_categoria_general.nombre as categoria',
																	'tbl_orden_item.peso_taller'
															)
															->get();
	}

	public static function GetProveedorById($tienda,$id_cliente)
	{
		$datosCliente =  DB::table('tbl_cliente')
						->leftJoin('tbl_clie_suc_cliente', function($join)
						{
							$join->on('tbl_clie_suc_cliente.id_cliente','tbl_cliente.codigo_cliente')
									->on('tbl_clie_suc_cliente.id_tienda_cliente','tbl_cliente.id_tienda');
						})
						->select(
							'tbl_cliente.codigo_cliente',
							'tbl_cliente.id_tienda',
							'tbl_cliente.nombres',
							'tbl_cliente.primer_apellido',
							'tbl_cliente.telefono_residencia',
							'tbl_cliente.segundo_apellido'
						)
						->where('tbl_cliente.numero_documento',$id_cliente)
						->wherein('tbl_cliente.id_tipo_cliente',[5,6])
						->limit(1)
						->get();
			$SucursalesCliente = DB::table('tbl_cliente')
											->leftJoin('tbl_clie_suc_cliente', function($join)
											{
												$join->on('tbl_clie_suc_cliente.id_cliente','tbl_cliente.codigo_cliente')
														->on('tbl_clie_suc_cliente.id_tienda_cliente','tbl_cliente.id_tienda');
											})
											->select(
												'tbl_clie_suc_cliente.id_sucursal',
												'tbl_clie_suc_cliente.id_tienda_sucursal',
												'tbl_clie_suc_cliente.nombre AS sucursal'
											)
											->where('tbl_cliente.numero_documento',$id_cliente)
											->where('tbl_cliente.id_tienda',$tienda->id)
											->get();
			$dataSaved['datosCliente'] = $datosCliente;
			$dataSaved['SucursalesCliente'] = $SucursalesCliente;
			return $dataSaved;
	 }
	 
	public static function reclasificarItemGet($id_tienda, $id_inventario)
	{
		$catalogo = DB::table('tbl_prod_catalogo AS catalogo')
					->join('tbl_prod_referencia AS referencia', 'referencia.id_referencia', '=', 'catalogo.id')
					->join('tbl_prod_atributo_valores AS valores', 'valores.id', '=', 'referencia.id_valor_atributo')
					->join('tbl_prod_atributo AS atributos', 'atributos.id', '=', 'valores.id_atributo')
					->join('tbl_prod_categoria_general AS categoria', 'categoria.id', '=', 'atributos.id_cat_general')
					->join('tbl_prod_atributo AS todos_atributos', 'todos_atributos.id_cat_general', '=', 'categoria.id')
					->join('tbl_prod_atributo_valores AS todos_valores', 'todos_valores.id_atributo', '=', 'todos_atributos.id')
					->join('tbl_inventario_producto AS inventario_producto', 'inventario_producto.id_catalogo_producto', '=', 'catalogo.id')
					->select(
						'todos_atributos.id AS id_atributo',
						'todos_atributos.nombre AS nombre_atributo',
						'todos_valores.id as id_valor',
						'todos_valores.nombre AS nombre_valor',
						'todos_atributos.id_atributo_padre AS id_atributo_padre',
						DB::raw('IF(valores.id = todos_valores.id, 1, 0) as valor_seleccionado'),
						DB::raw('IF(valores.id_atributo_padre = todos_valores.id_atributo_padre or todos_valores.id_atributo_padre = 0, 1, 0) as set_valor')
					)
					->where('inventario_producto.id_tienda_inventario', $id_tienda)
					->where('inventario_producto.id_inventario', $id_inventario)
					->where(function ($query) {
						$query->whereRaw('atributos.id = todos_atributos.id');
						$query->orWhere('todos_atributos.id_atributo_padre', '=', 0);
					})
					->distinct()
					->orderBy('todos_atributos.id', 'ASC')
					->orderBy('todos_valores.nombre', 'ASC')
					->orderBy('valor_seleccionado', 'DESC')
					->get();
		if(count($catalogo) == 0){
			$catalogo = DB::table('tbl_contr_item_detalle_atr_val AS valores_item_contrato')
					->join('tbl_inventario_item_contrato AS inventario_item_contrato', function($join)
					{
						$join->on('inventario_item_contrato.id_tienda_contrato', '=', 'valores_item_contrato.id_tienda');
						$join->on('inventario_item_contrato.id_contrato', '=', 'valores_item_contrato.id_codigo_contrato');
						$join->on('inventario_item_contrato.id_item_contrato', '=', 'valores_item_contrato.id_linea_item_contrato');
					})
					->join('tbl_prod_atributo_valores AS valores', 'valores.id', '=', 'valores_item_contrato.id_atributo_valor')
					->join('tbl_prod_atributo AS atributos', 'atributos.id', '=', 'valores.id_atributo')
					->join('tbl_prod_categoria_general AS categoria', 'categoria.id', '=', 'atributos.id_cat_general')
					->join('tbl_prod_atributo AS todos_atributos', 'todos_atributos.id_cat_general', '=', 'categoria.id')
					->join('tbl_prod_atributo_valores AS todos_valores', 'todos_valores.id_atributo', '=', 'todos_atributos.id')

					->select(
						'todos_atributos.id AS id_atributo',
						'todos_atributos.nombre AS nombre_atributo',
						'todos_valores.id as id_valor',
						'todos_valores.nombre AS nombre_valor',
						'todos_atributos.id_atributo_padre AS id_atributo_padre',
						DB::raw('IF(valores.id = todos_valores.id, 1, 0) as valor_seleccionado'),
						DB::raw('IF(valores.id_atributo_padre = todos_valores.id_atributo_padre or todos_valores.id_atributo_padre = 0, 1, 0) as set_valor')
					)
					->where('inventario_item_contrato.id_tienda_inventario', $id_tienda)
					->where('inventario_item_contrato.id_inventario', $id_inventario)
					->where(function ($query) {
						$query->whereRaw('atributos.id = todos_atributos.id');
						$query->orWhere('todos_atributos.id_atributo_padre', '=', 0);
					})
					->distinct()
					->orderBy('todos_atributos.id', 'ASC')
					->orderBy('todos_valores.nombre', 'ASC')
					->orderBy('valor_seleccionado', 'DESC')
					->get();
		}

		return  $catalogo;
	}

	public static function reclasificarItemPost_Old($id_categoria, $data_reference, $id_inventario, $id_tienda_inventario, $codigo_contrato, $id_linea_item)
	{
		$array_valores = $data_reference["attributes"];
		$referencia = DB::table('tbl_prod_referencia AS referencia')
										->join('tbl_prod_catalogo', 'tbl_prod_catalogo.id', '=', 'referencia.id_referencia')
										->select('referencia.id_referencia', 'descripcion',
											DB::raw("(SELECT count(id_referencia) FROM tbl_prod_referencia as b WHERE b.id_referencia = referencia.id_referencia) as cont_id_referencia"),
											DB::raw("COUNT(1) as count1")
										)
										->whereIn('referencia.id_valor_atributo', $array_valores)
										->where('id_categoria', $id_categoria)
										->groupBy('referencia.id_referencia')
										->havingRaw('count1 = cont_id_referencia')
										->havingRaw('count1 ='. count($array_valores))
										->orderBy('count1', 'DESC')
										->first();

		if(count($referencia) > 0){
			DB::table('tbl_contr_item_detalle')
			->where('id_tienda', $id_tienda_inventario)
			->where('id_codigo_contrato', $codigo_contrato)
			->where('id_linea_item_contrato', $id_linea_item)
			->update(['nombre' => $referencia->descripcion]);
			DB::table('tbl_inventario_producto')->where('id_inventario', $id_inventario)->where('id_tienda_inventario', $id_tienda_inventario)->update(['id_catalogo_producto' => $referencia->id_referencia]);
			return $referencia;
		}else{
			return 0;
		}
	}

	public static function reclasificarItemPost($id_categoria, $data_reference, $id_inventario, $id_tienda_inventario, $codigo_contrato, $id_linea_item)
	{
		$array_valores = $data_reference["attributes"];

		$referencia = DB::table('tbl_prod_referencia AS referencia')
										->join('tbl_prod_catalogo', 'tbl_prod_catalogo.id', '=', 'referencia.id_referencia')
										->select('referencia.id_referencia', 'descripcion',
											DB::raw("(SELECT count(id_referencia) FROM tbl_prod_referencia as b WHERE b.id_referencia = referencia.id_referencia) as cont_id_referencia"),
											DB::raw("COUNT(1) as count1")
										)
										->whereIn('referencia.id_valor_atributo', $array_valores)
										->where('id_categoria', $id_categoria)
										->groupBy('referencia.id_referencia')
										->havingRaw('count1 = cont_id_referencia')
										->havingRaw('count1 ='. count($array_valores))
										->orderBy('count1', 'DESC')
										->first();

		if(count($referencia) == 0){

			$abreviatura = DB::table('tbl_prod_atributo_valores')
							->join('tbl_prod_atributo', 'tbl_prod_atributo.id', '=', 'id_atributo')
							->where('tiene_abreviatura', 1)
							->whereIn('tbl_prod_atributo_valores.id', $array_valores)
							->value('abreviatura');

			$descripcion = DB::table('tbl_prod_atributo_valores')
							->select(
								DB::raw("GROUP_CONCAT(nombre separator ' ') as descripcion")
							)
							->whereIn('id', $array_valores)
							->first();
			$descripcion = $descripcion->descripcion;

			$codigo = "";
			$valores_reference = [];
			for ($i=0; $i < count($array_valores); $i++) { 
				$codigo .= $array_valores[$i];
				$valores_reference[$i]["id_valor_atributo"] = $array_valores[$i];
			}

			$dataSaved=[
				'codigo' => $codigo,
				'descripcion' => $descripcion,
				'id_categoria' => $id_categoria,
				'nombre' => $abreviatura . "REF" . $codigo,
				'genera_contrato' => 0,
				'genera_venta' => 1,
				'estado' => 1
			];

			$id_referencia = self::saveReference($dataSaved, $valores_reference);
		}else{
			$descripcion = $referencia->descripcion;
			$id_referencia = $referencia->id_referencia;
		}

		DB::table('tbl_contr_item_detalle')
			->where('id_tienda', $id_tienda_inventario)
			->where('id_codigo_contrato', $codigo_contrato)
			->where('id_linea_item_contrato', $id_linea_item)
			->update(['nombre' => $descripcion]);
			DB::table('tbl_inventario_producto')->where('id_inventario', $id_inventario)->where('id_tienda_inventario', $id_tienda_inventario)->update(['id_catalogo_producto' => $id_referencia]);

		$referencia = (object) array('id_referencia' => $id_referencia, 'descripcion' => $descripcion);
		return $referencia;
	}

	public static function saveReference($dataSaved, $valores_reference){
		$id=0;
		try{
			DB::beginTransaction();
			$id = DB::table('tbl_prod_catalogo')->insertGetId($dataSaved);

			for($i = 0; $i < count($valores_reference); $i++){
				$valores_reference[$i]['id_referencia'] = $id;
			}

			DB::table("tbl_prod_referencia")->insert($valores_reference);
			DB::commit();
		}catch(Exception $e){
			$id=0;
			DB::rollback();
		}
		return $id;
	}

	public static function SolicitarProcesarVitrina($request)
	{
		$result = true;
		try{
			DB::beginTransaction();
			// dd($request->all());
			for ($i=0; $i < count($request->id_inventario); $i++) { 
				DB::table("tbl_inventario_producto")->where('id_tienda_inventario',$request->tiendas[$i])
													->where('id_inventario',$request->id_inventario[$i])
													->update(['peso' => $request->pesos[$i]]);
			}
			$ordenes = explode("-",$request->id_ordenes);
			for($i = 0;$i < count($ordenes); $i++)
			{
				DB::table("tbl_orden")->where('id_tienda_orden',$request->id_tienda)
									->where('id_orden',$ordenes[$i])	
									->update(['estado' => env('APJZ_VITRINA')]);
			}
			DB::commit();
		}catch(\Exception $e){
			$result = false;
			DB::rollback();
			dd($e);
		}
	}

	public static function SolicitarProcesarVitrinaJZ($request)
	{
		$result = true;
		try{
			DB::beginTransaction();
			// dd($request->all());
			for ($i=0; $i < count($request->id_inventario); $i++) { 
				DB::table("tbl_inventario_producto")->where('id_tienda_inventario',$request->tiendas[$i])
													->where('id_inventario',$request->id_inventario[$i])
													->update(['peso' => $request->pesos[$i]]);
			}
			$ordenes = explode("-",$request->id_ordenes);
			for($i = 0;$i < count($ordenes); $i++)
			{
				DB::table("tbl_orden")->where('id_tienda_orden',$request->id_tienda)
									->where('id_orden',$ordenes[$i])	
									->update(['estado' => env('APAJ_VITRINA')]);
			}
			DB::commit();
		}catch(\Exception $e){
			$result = false;
			DB::rollback();
			dd($e);
		}
	}

	public static function rechazarVitrina($request)
	{
		$result = true;
		try{
			DB::beginTransaction();
			$ordenes = explode("-",$request->id_ordenes);
			for($i = 0;$i < count($ordenes); $i++)
			{
				DB::table("tbl_orden")->where('id_tienda_orden',$request->id_tienda)
									->where('id_orden',$ordenes[$i])	
									->update(['estado' => env('APJZ_VITRINA')]);
			}
			DB::commit();
		}catch(\Exception $e){
			$result = false;
			DB::rollback();
			dd($e);
		}

		return $result;
	}

	public static function guardarVitrina($request)
	{
		$result = true;
		try{
			DB::beginTransaction();
			// dd($request->all());
			for ($i=0; $i < count($request->id_inventario); $i++) { 
				DB::table("tbl_inventario_producto")->where('id_tienda_inventario',$request->tiendas[$i])
													->where('id_inventario',$request->id_inventario[$i])
													->update(['peso' => self::limpiarVal($request->pesos[$i])]);
			}
			DB::commit();
		}catch(\Exception $e){
			$result = false;
			DB::rollback();
			dd($e);
		}

		return $result;
	}

	public static function getOrdenExcel($id_orden, $id_tienda)
	{
		return DB::table('tbl_tienda')->join('tbl_orden','tbl_orden.id_tienda_orden','tbl_tienda.id')
									->join('tbl_orden_item',function($join){
										$join->on('tbl_orden.id_orden','tbl_orden_item.id_orden')
											 ->on('tbl_orden.id_tienda_orden','tbl_orden_item.id_tienda_orden');
									})
									->join('tbl_inventario_producto',function($join){
										$join->on('tbl_orden_item.id_inventario','tbl_inventario_producto.id_inventario')
											 ->on('tbl_orden_item.id_tienda_inventario','tbl_inventario_producto.id_tienda_inventario');
									})
									->leftJoin('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_inventario_producto.id_catalogo_producto')
									->leftJoin('tbl_orden_hoja_trabajo_cabecera',function($join){
										$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
											 ->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
									})
									->leftJoin('tbl_orden_hoja_trabajo_detalle',function($join){
										$join->on('tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_hoja_trabajo')
											 ->on('tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_detalle.id_tienda_hoja_trabajo');
									})
									->select(
										'tbl_tienda.nombre as nombre_comercial',
										'tbl_tienda.codigo_tienda as codigo',
										'tbl_orden_hoja_trabajo_detalle.id_contrato as numero_contrato',
										DB::raw('"00001" as orden_compra'),
										DB::raw('"00001" as orden_traslado'),
										DB::raw('"00001" as orden_maquila'),
										'tbl_prod_catalogo.nombre as calidad',
										'tbl_inventario_producto.id_inventario as id',
										'tbl_inventario_producto.peso as gramos',
										DB::raw('"contratos" as origen')
									)
									->where('tbl_orden.id_orden',$id_orden)
									->where('tbl_orden.id_tienda_orden',$id_tienda)
									->distinct()
									->get();
	}

	public static function getProcesoAnterior($id_tienda,$id_orden)
	{
		return DB::table('tbl_orden')->whereRaw('id_orden = (select id_traza_padre from tbl_orden_trazabilidad where id_orden = '.$id_orden[0].' and id_tienda_orden = '.$id_tienda.') and id_tienda_orden = '.$id_tienda.'') 
									->value('proceso');
	}

	public static function limpiarVal($val)
	{
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}
}
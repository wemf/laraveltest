<?php 
 
namespace App\AccessObject\Nutibara\MaquilaImportada;

use App\Models\Nutibara\Orden\Orden AS ModelOrden;
use App\Models\Nutibara\Tema\Tema AS ModelTema;
use DB;

class MaquilaImportada 
{

	public static function MaquilaImportadaWhere($start,$end,$colum, $order,$search){
		
		return DB::table('tbl_orden')->join('tbl_orden_hoja_trabajo_cabecera', function($join)
								{
										$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
											    ->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
								})
								->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_orden.estado')
								->join('tbl_tienda','tbl_tienda.id','tbl_orden.id_tienda_orden')
								->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
								->select(
										'tbl_orden.id_orden AS DT_RowId',
										'tbl_orden.id_orden',
										'tbl_tienda.nombre as tienda_orden',
										'tbl_prod_categoria_general.nombre as categoria',
										'tbl_orden.fecha_creacion',
										'tbl_sys_estado_tema.nombre as estado'
								)
								->where('tbl_orden.proceso',env('PROCESO_MAQUILA_IMPORTADA'))
								->where('tbl_orden.estado', env('ORDEN_PENDIENTE_POR_PROCESAR'))
								->orderBy($colum, $order)
								->skip($start)
								->take($end)
								->get();
	}
	
    public static function DetalleOrdenesMaquilaImportada($id_tienda,$ids_orden){

		return ModelOrden::join('tbl_orden_hoja_trabajo_cabecera', function ($join) {
			$join->on('tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo' , '=' , 'tbl_orden.id_hoja_trabajo');
			$join->on('tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo' , '=' , 'tbl_orden.id_tienda_hoja_trabajo');
		})
		->join('tbl_orden_item', function ($join) {
			$join->on('tbl_orden_item.id_orden' , '=' , 'tbl_orden.id_orden');
			$join->on('tbl_orden_item.id_tienda_orden' , '=' , 'tbl_orden.id_tienda_orden');
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
		->join('tbl_contr_item_detalle', function ($join) {
			$join->on('tbl_contr_item_detalle.id_codigo_contrato' , '=' , 'tbl_inventario_item_contrato.id_contrato');
			$join->on('tbl_contr_item_detalle.id_tienda' , '=' , 'tbl_inventario_item_contrato.id_tienda_contrato');
			$join->on('tbl_contr_item_detalle.id_linea_item_contrato' , '=' , 'tbl_inventario_item_contrato.id_item_contrato');
		})
		->join('tbl_contr_cabecera', function ($join) {
			$join->on('tbl_contr_cabecera.codigo_contrato' , '=' , 'tbl_contr_item_detalle.id_codigo_contrato');
			$join->on('tbl_contr_cabecera.id_tienda_contrato' , '=' , 'tbl_contr_item_detalle.id_tienda');
		})
		->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
		->select(
		'tbl_inventario_item_contrato.id_contrato AS contrato',
		'tbl_inventario_item_contrato.id_tienda_contrato AS tienda_contrato',
		'tbl_orden.fecha_creacion AS fecha',
		'tbl_inventario_item_contrato.id_inventario AS id_inventario',
		'tbl_inventario_item_contrato.id_tienda_inventario',
		'tbl_inventario_item_contrato.id_item_contrato AS id_item',
		'tbl_contr_item_detalle.nombre AS atributo',
		'tbl_contr_item_detalle.observaciones AS descripcion',
		'tbl_contr_item_detalle.peso_total',
		'tbl_contr_item_detalle.peso_estimado',
		'tbl_contr_item_detalle.precio_ingresado',	 
		DB::raw("(SELECT SUM(precio_ingresado) FROM tbl_contr_item_detalle WHERE tbl_contr_item_detalle.id_codigo_contrato = tbl_inventario_item_contrato.id_contrato AND tbl_contr_item_detalle.id_tienda = tbl_inventario_item_contrato.id_tienda_contrato) AS Suma_contrato"),
		DB::raw("(cod_bolsa_seguridad_hasta - cod_bolsa_seguridad_desde) AS Bolsas"),
		'tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo',
		'tbl_prod_categoria_general.nombre as categoria',
		'tbl_orden.id_orden',
		'tbl_orden.id_tienda_orden',
		'tbl_cliente.numero_documento AS destinatario'
		)
		->where('tbl_orden.id_tienda_orden',$id_tienda)
		->whereIn('tbl_orden.id_orden',$ids_orden)
		->get();
	}

	

	public static function getCountMaquilaImportada($search){
		return DB::table('tbl_orden')->join('tbl_orden_hoja_trabajo_cabecera', function($join)
		{
				$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
						->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
		})
		->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_orden.estado')
		->join('tbl_tienda','tbl_tienda.id','tbl_orden.id_tienda_orden')
		->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_orden_hoja_trabajo_cabecera.categoria')
		->where('tbl_orden.proceso',env('PROCESO_MAQUILA_IMPORTADA'))
		->where('tbl_orden.estado', env('ORDEN_PENDIENTE_POR_PROCESAR'))		
		->count();
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


			DB::table('tbl_orden_trazabilidad')->insert(
											[
												[
													'id_trazabilidad' => (int)$secuenciaT[0]->response,
													'id_tienda_trazabilidad' => (int)$data['id_tienda_orden'][0], 
													'id_orden' => (int)$ordenes[$i], 
													'id_tienda_orden' => (int)$data['id_tienda_orden'][0], 
													'actual' => (int)1, 
													'fecha_accion' => $fecha, 
													'accion' => 'Procesado'
												]
											]);
		}
		for ($i=0; $i < count($data['id_item']) ; $i++) { 
			
			DB::table('tbl_orden_item')->where('id_inventario',$data['id_item'][$i])
			->where('id_tienda_inventario',$data['id_tienda_orden'][0])
			->update(['peso_taller' => $data['peso_taller'][$i]]);

			DB::table('tbl_inventario_producto')
				->where('id_inventario',$data['id_item'][$i])
				->where('id_tienda_inventario',$data['id_tienda_orden'][0])
				->update([ 'id_estado_producto' => 76 ]);	
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
										->whereIn('id',[env('PROCESO_MAQUILA_NACIONAL'),
																env('PROCESO_MAQUILA_IMPORTADA'),
																env('PROCESO_VITRINA'),
																env('PROCESO_REFACCION'),
																env('PROCESO_FUNDICION'),
																env('PROCESO_MAQUILA'),
																env('PROCESO_JOYA_ESPECIAL')
																])
										->get();
	}

	public static function getItemOrden($id_tienda,$id)
	{
		return DB::table('tbl_orden_hoja_trabajo_cabecera')
											->join('tbl_orden', function($join){
												$join->on('tbl_orden.id_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_hoja_trabajo')
														->on('tbl_orden.id_tienda_hoja_trabajo','tbl_orden_hoja_trabajo_cabecera.id_tienda_hoja_trabajo');
											})
										->join('tbl_orden_item',function($join){
											$join->on('tbl_orden_item.id_orden','tbl_orden.id_orden')
												 ->on('tbl_orden_item.id_tienda_orden','tbl_orden.id_tienda_orden');
										})
										->join('tbl_inventario_item_contrato', function($join){
											$join->on('tbl_inventario_item_contrato.id_inventario','tbl_orden_item.id_inventario')
												 ->on('tbl_inventario_item_contrato.id_tienda_inventario','tbl_orden_item.id_tienda_inventario');
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
										->whereIn('tbl_orden.id_orden',$id)
										->where('tbl_orden.id_tienda_orden',$id_tienda)
									   	->select(
												'tbl_inventario_item_contrato.id_inventario',
												'tbl_contr_item_detalle.nombre',
												'tbl_contr_item_detalle.observaciones',
												'tbl_contr_item_detalle.peso_total',
												'tbl_prod_categoria_general.nombre as categoria'
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
}
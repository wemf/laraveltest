<?php 

namespace App\AccessObject\Nutibara\Compra;
use App\Models\Nutibara\Clientes\Cliente AS ModelCliente;
use App\Models\Nutibara\Clientes\TipoDocumento\TipoDocumento AS ModelTipoDocumento;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use DB;

class CompraAO
{

	public static function get()
	{
		return DB::table('tbl_inventario_producto_compra')->join('tbl_tienda','tbl_tienda.id','tbl_inventario_producto_compra.id_tienda')
														  ->select(
															  DB::Raw('concat(id_tienda,"/",lote) AS DT_RowId'),
															  'nombre as tienda',
															  'lote',
															  'compra',
															  DB::Raw("COALESCE(FORMAT(costo_compra,2,'de_DE'),'0,00') as costo_compra"),
															  'fecha_compra',
															  DB::Raw('COALESCE(devolucion_compra,0) as devolucion_compra'),
															  DB::Raw("COALESCE(FORMAT(costo_devolucion,2,'de_DE'),'0,00') as costo_devolucion"),
															  'fecha_devolucion'
														  );
	}

    public static function getProveedor($tipo_documento,$documento)
    {
        return DB::table('tbl_cliente as c')->join('tbl_clie_suc_cliente as sc',function($join){
													$join->on('c.id_tienda','sc.id_tienda_cliente')
														 ->on('c.codigo_cliente','sc.id_cliente');
											})
											->leftJoin('tbl_clie_regimen_contributivo as r','r.id','c.id_regimen_contributivo')
											->where('c.numero_documento',$documento)
											->where('c.id_tipo_documento',$tipo_documento)
											->select(
												DB::raw("concat_ws(' ',c.nombres,c.primer_apellido,c.segundo_apellido) as nombre"),
												'c.direccion_residencia as direccion',
												'sc.nombre as sucursal',
												'sc.telefono_sucursal as telefono',
												'sc.id_ciudad',
												'r.nombre as regimen',
												'c.codigo_cliente as codigo_proveedor',
												'c.id_tienda as id_tienda_proveedor'
											)
											->first();	
    }

    public static function getInventarioByName($referencia)
    {
        return DB::table('tbl_prod_catalogo')->whereRaw('concat_ws(" ",tbl_prod_catalogo.codigo,tbl_prod_catalogo.descripcion,tbl_prod_catalogo.nombre) like "%'.$referencia.'%"')
											->select(
														'tbl_prod_catalogo.id',
														'tbl_prod_catalogo.nombre',
														'tbl_prod_catalogo.descripcion',
														'tbl_prod_catalogo.id_categoria'
													)
											->whereRaw('"'.date('Y-m-d H:i:s').'" between vigencia_desde and vigencia_hasta')
											->orderBy('nombre','asc')
											->get();	
	}
	
	public static function getInfoVenta($id_tienda,$id_plan)
    {
		return ModelCliente::join('tbl_plan_separe',function($join){
									$join->on('tbl_plan_separe.codigo_cliente','tbl_cliente.codigo_cliente')
										 ->on('tbl_plan_separe.id_tienda','tbl_cliente.id_tienda');
							})
							->leftjoin('tbl_clie_genero','tbl_clie_genero.id','tbl_cliente.genero')
							->leftjoin('tbl_pais','tbl_pais.id','tbl_cliente.id_pais_expedicion')
							->leftjoin('tbl_ciudad','tbl_ciudad.id','tbl_cliente.id_ciudad_nacimiento')
							->leftjoin('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_cliente.id_regimen_contributivo')
							->leftjoin('tbl_sys_archivo as sa','sa.id','tbl_cliente.id_foto_documento_anterior')
							->leftjoin('tbl_sys_archivo as sas','sas.id','tbl_cliente.id_foto_documento_posterior')
							->select(
									'tbl_cliente.codigo_cliente',
									'tbl_cliente.id_tipo_documento',
									'tbl_cliente.numero_documento',
									'tbl_cliente.fecha_nacimiento',
									'tbl_cliente.fecha_expedicion',
									'tbl_cliente.nombres',
									'tbl_cliente.primer_apellido',
									'tbl_cliente.segundo_apellido',
									'tbl_cliente.correo_electronico',
									'tbl_cliente.id_confiabilidad',
									'tbl_cliente.foto',
									'tbl_cliente.id_tienda',
									'tbl_clie_genero.nombre as genero',
									'tbl_cliente.direccion_residencia',
									'tbl_cliente.telefono_residencia',
									'tbl_clie_regimen_contributivo.nombre as regimen',
									'tbl_cliente.telefono_celular',
									'tbl_pais.nombre as pais_expedicion',
									'tbl_ciudad.nombre as ciudad_nacimiento',
									'tbl_cliente.id_pais_expedicion',
									'tbl_cliente.id_ciudad_expedicion',
									'tbl_cliente.id_pais_residencia',
									'tbl_cliente.id_ciudad_residencia',
									'sa.nombre as anterior',
									'sas.nombre as posterior',
									'tbl_cliente.genero',
									'tbl_cliente.id_regimen_contributivo'
									)
							->where('tbl_plan_separe.id_tienda',$id_tienda)
							->where('tbl_plan_separe.codigo_plan_separe',$id_plan)
							->first();	
    }

	
	public static function getInfoVentaProductos($id_tienda,$id_plan)
    {
		return DB::table('tbl_plan_separe')->join('tbl_plan_inv_producto',function($join){
													$join->on('tbl_plan_inv_producto.codigo_plan_separe','tbl_plan_separe.codigo_plan_separe')
														->on('tbl_plan_inv_producto.id_tienda','tbl_plan_separe.id_tienda');
											})
											->join('tbl_inventario_producto',function($join){
													$join->on('tbl_inventario_producto.id_inventario','tbl_plan_inv_producto.codigo_inventario')
														->on('tbl_inventario_producto.id_tienda_inventario','tbl_plan_inv_producto.id_tienda');
											})
											->join('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_inventario_producto.id_catalogo_producto')
											->where('tbl_plan_separe.id_tienda',$id_tienda)
											->where('tbl_plan_separe.codigo_plan_separe',$id_plan)
											->get();	
	}
	
	public static function createDirecta($data,$id_tienda,$lote)
	{
		$result = 'Insertado';
		try{
			DB::beginTransaction();
			self::insertInventarioCompra($id_tienda,$lote,$data->arr_i_compra,$data->id_proveedor,$data->id_tienda_proveedor);
			self::updateInventarioPlanSepare($id_tienda,$lote,$data->arr_i_compra);
			self::insertInventarioNuevo($id_tienda,$lote,$data->arr_i_compra);
			DB::commit();
		}
		catch(\Exception $e)
		{
			dd($e);
			if($e->getCode() == 23000)
			{
				$result = 'Error unic';
			}else{
				$result = 'Error';
			}
		}

		return $result;
	}

	public static function insertInventarioNuevo($id_tienda,$lote,$data)
	{
		for ($i=0; $i < count($data); $i++) 
		{ 
			$cuenta = self::countInventario($id_tienda,$data[$i]['id_inventario']);
			$cantidad = $data[$i]['cantidad'] - $cuenta;
			for($j=0; $j < $cantidad; $j++)
			{
				$secuencia = SecuenciaTienda::getCodigosSecuencia($id_tienda,env('SECUENCIA_TIPO_CODIGO_INVENTARIO'),(int)1);
				DB::table('tbl_inventario_producto')->insert([
														'id_inventario' => $secuencia[0]->response,
														'id_tienda_inventario' => $id_tienda,
														'lote' => $lote,
														'id_catalogo_producto' => $data[$i]['id_inventario'],
														'precio_compra' => $data[$i]['precio'],
														'costo_total' => $data[$i]['costo'],
														'cantidad' => (int)1,
														'fecha_ingreso' => date('Y-m-d'),
														'id_estado_producto' => env('PRODUCTO_DISPONIBLE'),
														'id_motivo_producto' => env('PRODUCTO_MOTIVO_DIS')
													]);
			}
		}

		return true;
	}

	public static function updateInventarioPlanSepare($id_tienda,$lote,$data)
	{
		for ($i=0; $i < count($data); $i++) { 
			$planes = self::buscarPlan($id_tienda,$data[$i]['id_inventario']);
			for($j=0; $j < count($planes); $j++)
			{
				$monto_anterior = $planes[$j]->monto - $planes[$j]->precio_venta;
				$nuevo_monto = $monto_anterior + $data[$i]['precio'];
				
				DB::table('tbl_plan_separe')->where('codigo_plan_separe',$planes[$j]->codigo_plan_separe)
									   		->where('id_tienda',$id_tienda)
									   		->update([
													'monto' => $nuevo_monto
											   ]);
				
				DB::table('tbl_inventario_producto')->where('id_tienda_inventario',$id_tienda)
													->where('id_inventario',$planes[$j]->id_inventario)
													->update([
														'precio_compra' => $data[$i]['precio'],
														'costo_total' => $data[$i]['costo'],
														'cantidad' => (int)1,
														'fecha_ingreso' => date('Y-m-d'),
														'id_estado_producto' => env('BLOQUEO_ESTADO_INV_PLAN'),
														'id_motivo_producto' => env('BLOQUEO_MOTIVO_INV_PLAN')
													]);
			}
		}

		return true;
	}

	public static function countInventario($id_tienda,$id_catalogo)
	{
		return DB::table('tbl_inventario_producto')->where('id_estado_producto',env('BLOQUEO_ESTADO_INV_PLAN'))
												   ->where('id_motivo_producto',env('BLOQUEO_MOTIVO_FABRICACION'))
												   ->count();
	}

	public static function buscarPlan($id_tienda,$id_catalogo)
	{
		return DB::table('tbl_plan_separe as ps')->join('tbl_plan_inv_producto as inp',function($join){
													$join->on('inp.codigo_plan_separe','ps.codigo_plan_separe')
												 		 ->on('inp.id_tienda','ps.id_tienda');
												})
												->join('tbl_inventario_producto as ip',function($join){
													$join->on('ip.id_inventario','inp.codigo_inventario')	
														 ->on('ip.id_tienda_inventario','inp.id_tienda');
												})
												->where('inp.id_tienda',$id_tienda)
												->where('ip.id_catalogo_producto',$id_catalogo)
												->where('ip.id_estado_producto',env('BLOQUEO_ESTADO_INV_PLAN'))
												->where('ip.id_motivo_producto',env('BLOQUEO_MOTIVO_FABRICACION'))
												->select(
														'ps.codigo_plan_separe',
														'ip.id_inventario',
														'ip.precio_venta',
														'ps.monto'
														)
												->get();
	}

	public static function updateInventario($id_tienda,$lote,$data)
	{
		for ($i=0; $i < count($data); $i++) { 
			DB::table('tbl_inventario_producto')->where('id_inventario',$data[$i]['id_inventario'])
												->where('id_tienda_inventario',$data[$i]['id_tienda'])
												->update([
													'lote' => (int)$lote,
													'cantidad' => (int)0,
													'fecha_salida' => date('Y-m-d'),
													'id_estado_producto' => env('INV_VENTA_ESTADO'),
													'id_motivo_producto' => env('INV_VENTA_MOTIVO')
												]);
		}
	}

	public static function insertInventarioCompra($id_tienda,$lote,$data,$id_proveedor,$id_tienda_proveedor)
	{
		$costo_compra = "";
		for ($i=0; $i < count($data); $i++) { 
			$pre = str_replace(".","", $data[$i]['precio']);
			$costo_compra = $costo_compra + $pre;
		}
		return DB::table('tbl_inventario_producto_compra')->insert([
														'id_tienda' => $id_tienda,
														'lote' => $lote,
														'compra' => count($data),
														'fecha_compra' => date('Y-m-d'),
														'costo_compra' => $costo_compra,
														'id_proveedor' => $id_proveedor,
														'id_tienda_proveedor' => $id_tienda_proveedor
													]);
			
	}

	public static function infoLote($id_tienda,$lote)
	{
		return DB::table('tbl_inventario_producto_compra')->join('tbl_tienda','tbl_tienda.id','tbl_inventario_producto_compra.id_tienda')
														  ->join('tbl_inventario_producto',function($join){
																$join->on('tbl_inventario_producto.id_tienda_inventario','tbl_inventario_producto_compra.id_tienda')
																	 ->on('tbl_inventario_producto.lote','tbl_inventario_producto_compra.lote');
														  })
														  ->join('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_inventario_producto.id_catalogo_producto')
														  ->leftJoin('tbl_cliente as c',function($join){
															  $join->on('c.codigo_cliente','tbl_inventario_producto_compra.id_proveedor')
															  	   ->on('c.id_tienda','tbl_inventario_producto_compra.id_tienda_proveedor');
														  })
														  ->leftJoin('tbl_clie_suc_cliente as sc',function($join){
																	$join->on('c.id_tienda','sc.id_tienda_cliente')
																		 ->on('c.codigo_cliente','sc.id_cliente');
															})
														  ->leftJoin('tbl_clie_regimen_contributivo as r','r.id','c.id_regimen_contributivo')
														  ->leftJoin('tbl_clie_tipo_documento as tpd','tpd.id','c.id_tipo_documento')
														  ->leftJoin('tbl_ciudad','tbl_ciudad.id','c.id_ciudad_residencia')
														  ->leftJoin('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
														  ->leftJoin('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
														  ->select(
															  	'tbl_tienda.nombre as tienda',
															  	'tbl_inventario_producto_compra.lote',
															  	'tbl_prod_catalogo.nombre as referencia',
															  	DB::Raw("FORMAT(tbl_inventario_producto.costo_total,2,'de_DE') as costo_compra"),
															  	DB::Raw("FORMAT(tbl_inventario_producto.precio_compra,2,'de_DE') as precio_compra"),
															  	'tbl_inventario_producto_compra.fecha_compra',
															  	'tbl_inventario_producto.id_inventario',
																'tbl_inventario_producto.id_tienda_inventario',
																  
															  	DB::raw("concat_ws(' ',c.nombres,c.primer_apellido,c.segundo_apellido) as nombre"),
																'c.direccion_residencia as direccion',
																'c.numero_documento',
																'tpd.nombre as tipo_documento',
																'sc.nombre as sucursal',
																'sc.telefono_sucursal as telefono',
																'r.nombre as regimen',
																DB::raw('concat("+",tbl_pais.codigo_telefono," ",tbl_departamento.indicativo_departamento) AS indicativo')
														  )
														  ->where('tbl_inventario_producto.lote',$lote)
														  ->where('tbl_inventario_producto.id_tienda_inventario',$id_tienda)
														  ->where('tbl_inventario_producto.id_estado_producto','<>',env('BLOQUEO_ESTADO_INV_PLAN'))
														  ->where('tbl_inventario_producto.id_estado_producto','<>',env('PRODUCTO_NO_DISPONIBLE'))
														  ->get();
	}

	public static function devolverCompra($data)
	{
		$result = 'Insertado';
		try{
			DB::beginTransaction();
			self::updateInventarioCompra($data);
			self::updateInventarioPlanSepareDevolucion($data);
			DB::commit();
		}
		catch(\Exception $e)
		{
			dd($e);
			if($e->getCode() == 23000)
			{
				$result = 'Error unic';
			}else{
				$result = 'Error';
			}
		}

		return $result;
	}

	public static function updateInventarioCompra($data)
	{
		$costo_compra = "";
		for ($i=0; $i < count($data); $i++) { 
			$pre = str_replace(".","", $data[$i]['precio']);
			$costo_compra = $costo_compra + $pre;
		}
		$devoluciones_ant = self::devol_ant($data[0]['id_tienda'],$data[0]['lote']);
		$total = count($data) + $devoluciones_ant->dev;
		$total_costo = $devoluciones_ant->costo_dev + $costo_compra;
		return DB::table('tbl_inventario_producto_compra')->where('id_tienda',$data[0]['id_tienda'])
														->where('lote',$data[0]['lote'])
														->update([
															'devolucion_compra' => $total,
															'fecha_devolucion' => date('Y-m-d'),
															'costo_devolucion' => $total_costo
														]);
			
	}

	public static function devol_ant($id_tienda,$lote)
	{
		return DB::table('tbl_inventario_producto_compra')->where('id_tienda',$id_tienda)
													 ->where('lote',$lote)
													 ->select(
														 DB::raw('COALESCE(devolucion_compra,0) as dev'),
														 DB::raw('COALESCE(costo_devolucion,0) as costo_dev')
													 )
													 ->first();
	}

	public static function updateInventarioPlanSepareDevolucion($data)
	{
		for ($i=0; $i < count($data); $i++) { 
				DB::table('tbl_inventario_producto')->where('id_tienda_inventario',$data[$i]['id_tienda'])
													->where('id_inventario',$data[$i]['id_inventario'])
													->update([
														'cantidad' => (int)0,
														'id_estado_producto' => env('PRODUCTO_NO_DISPONIBLE'),
														'id_motivo_producto' => env('PRODUCTO_MOTIVO_NO_DIS')
													]);
		}

		return true;
	}
	
}
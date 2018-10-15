<?php 

namespace App\AccessObject\Nutibara\Venta;
use App\Models\Nutibara\Clientes\Cliente AS ModelCliente;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda AS SecuenciaTienda;
use DB;

class VentaAO
{
    public static function getCliente($tipo_documento,$documento)
    {
        return ModelCliente::leftjoin('tbl_clie_genero','tbl_clie_genero.id','tbl_cliente.genero')
							->leftjoin('tbl_pais','tbl_pais.id','tbl_cliente.id_pais_expedicion')
							->leftjoin('tbl_ciudad','tbl_ciudad.id','tbl_cliente.id_ciudad_nacimiento')
							->leftjoin('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_cliente.id_regimen_contributivo')
							->leftjoin('tbl_sys_archivo as sa','sa.id','tbl_cliente.id_foto_documento_anterior')
							->leftjoin('tbl_sys_archivo as sas','sas.id','tbl_cliente.id_foto_documento_posterior')
							->select(
									'tbl_cliente.codigo_cliente',
									'tbl_cliente.id_tipo_documento',
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
									'tbl_cliente.genero'
									)
							->where('tbl_cliente.numero_documento',$documento)
							->where('tbl_cliente.id_tipo_documento',$tipo_documento)
							->first();	
    }

    public static function getInventarioByName($referencia,$id_tienda)
    {
        return DB::table('tbl_inventario_producto')->leftJoin('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_inventario_producto._producto_producto')
													->whereRaw('concat_ws(" ",tbl_prod_catalogo.codigo,tbl_prod_catalogo.descripcion,tbl_prod_catalogo.nombre,lote) like "%'.$referencia.'%"')
													->where('tbl_inventario_producto.id_tienda_inventario', $id_tienda)
													->where('tbl_inventario_producto.id_estado_producto', '79')
													->whereIn('tbl_inventario_producto.id_motivo_producto',[28,32])
													->select(
																'tbl_prod_catalogo.id',
																'tbl_prod_catalogo.nombre',
																'tbl_prod_catalogo.descripcion',
																'tbl_inventario_producto.precio_venta as precio',
																'tbl_inventario_producto.peso',
																'tbl_inventario_producto.id_inventario',
																'tbl_inventario_producto.lote'
                                                            )
                                                    ->orderBy('lote','asc')
													->get();	
	}
	
	public static function getInfoVenta($id_tienda,$id_plan)
    {
		return ModelCliente::join('tbl_plan_separe',function($join){
									$join->on('tbl_plan_separe.codigo_cliente','tbl_cliente.codigo_cliente')
										 ->on('tbl_plan_separe.id_tienda_cliente','tbl_cliente.id_tienda');
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
							->where('tbl_plan_separe.id_tienda_cliente',$id_tienda)
							->where('tbl_plan_separe.codigo_plan_separe',$id_plan)
							->first();	
    }

	
	public static function getInfoVentaProductos($id_tienda,$id_plan)
    {
		return DB::table('tbl_inventario_producto')->join('tbl_plan_inv_producto',function($join){
													$join->on('tbl_plan_inv_producto.codigo_inventario','tbl_inventario_producto.id_inventario')
														 ->on('tbl_plan_inv_producto.id_tienda','tbl_inventario_producto.id_tienda_inventario');
													})
													->join('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_inventario_producto.id_catalogo_producto')
													->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_prod_catalogo.id_categoria')
													->join('tbl_cont_configuracioncontable',function($join){
															$join->on('tbl_cont_configuracioncontable.id_categoria','tbl_prod_categoria_general.id')
																 ->where('tbl_cont_configuracioncontable.id_tipo_documento_contable','5');
													})
													->leftJoin('tbl_cont_configuracioncontable_impuestos',function($join){
															$join->on('tbl_cont_configuracioncontable.id','tbl_cont_configuracioncontable_impuestos.id_configuracioncontable')
																 ->whereIn('tbl_cont_configuracioncontable_impuestos.id',[22,25]);
													})
													->where('tbl_plan_inv_producto.id_tienda',$id_tienda)
													->where('tbl_plan_inv_producto.codigo_plan_separe',$id_plan)
													->select(
														'tbl_inventario_producto.id_inventario',
														'tbl_prod_catalogo.nombre as referencia',
														'tbl_prod_categoria_general.nombre as categoria_general',
														'tbl_inventario_producto.precio_venta',
														DB::raw("'' as calidad"),
														'tbl_prod_catalogo.descripcion as detalle',
														DB::raw('1 as cantidad'),
														DB::raw('FORMAT(tbl_inventario_producto.peso,2,"de_DE") as peso	'),
														DB::raw('FORMAT(ROUND(tbl_inventario_producto.precio_venta - COALESCE( ((tbl_inventario_producto.precio_venta / ((19 / 100) + 1)) * (19 / 100)),0),0),0,"de_DE") as precio'),
														// DB::raw('FORMAT(ROUND(tbl_inventario_producto.precio_venta - COALESCE( ((tbl_inventario_producto.precio_venta / ((tbl_cont_configuracioncontable_impuestos.porcentaje / 100) + 1)) * (tbl_cont_configuracioncontable_impuestos.porcentaje / 100)),0),0),2,"de_DE") as precio'),
														DB::raw('0 as porcentaje_descuento'),
														DB::raw('0 as valor_descuento'),
														DB::raw('COALESCE(19,0) as iva'),
														DB::raw('FORMAT(ROUND(COALESCE( ((tbl_inventario_producto.precio_venta / ((19 / 100) + 1)) * (19 / 100)),0),0),0,"de_DE") as valor_iva'),
														// DB::raw('FORMAT(ROUND(COALESCE( ((tbl_inventario_producto.precio_venta / ((tbl_cont_configuracioncontable_impuestos.porcentaje / 100) + 1)) * (tbl_cont_configuracioncontable_impuestos.porcentaje / 100)),0),0),2,"de_DE") as valor_iva'),
														DB::raw('FORMAT(COALESCE(tbl_inventario_producto.precio_venta,0),0,"de_DE") as valor_total')
													)
													->distinct()
													->get();
	}
	
	public static function createDirecta($data,$id_tienda,$lote)
	{
		$result = 'Insertado';
		try{
			DB::beginTransaction();
			self::updateInventario($id_tienda,$lote,$data->arr_i_venta);
			self::insertInventarioVenta($id_tienda,$lote,$data->arr_i_venta);
			DB::commit();
		}
		catch(\Exception $e)
		{
			dd($e);
			DB::rollback();
			if($e->getCode() == 23000)
			{
				$result = 'Error unic';
			}else{
				$result = 'Error';
			}
		}

		return $result;
	}
	public static function facturarPlan($request,$id,$id_tienda,$dataMov)
	{
		$result = true;
		try{
			DB::beginTransaction();
			DB::table('tbl_plan_separe')->where('id_tienda',$id_tienda)
										->where('codigo_plan_separe',$id)
										->update(['estado' => 110]);
			MovimientosTesoreria::registrarMovimientosVenta($request->subtotal,$request->id_tienda,env('ID_CONFIG_CONTABLE_PLAN_SEPARE'),$dataMov);
			DB::commit();
		}
		catch(\Exception $e)
		{
			dd($e);
			DB::rollback();
			$result = false;
		}

		return $result;
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

	public static function insertInventarioVenta($id_tienda,$lote,$data)
	{
		$costo_venta = "";
		for ($i=0; $i < count($data); $i++) { 
			$pre = str_replace(".","", $data[$i]['precio']);
			$costo_venta = $costo_venta + $pre;
		}
		DB::table('tbl_inventario_producto_venta')->insert([
														'id_tienda' => $id_tienda,
														'lote' => $lote,
														'venta' => count($data),
														'fecha_venta' => date('Y-m-d'),
														'costo_venta' => $costo_venta
													]);
	}

	public static function getListImpuesto($tipo)
	{
		return DB::table('tbl_plan_unico_cuenta')->where('id_impuesto',$tipo)->get();
	}

	public static function getNaturalezaBy($id)
	{
		return DB::table('tbl_cont_movimientos_configuracioncontable')->where('id',$id)->first();
	}

	public static function getNatBy($id)
	{
		return DB::table('tbl_plan_unico_cuenta')->where('cuenta',$id)->first();
	}

	public static function getConfContable($id)
	{
		return DB::table('tbl_plan_unico_cuenta')->where('id',$id)->first();
	}

	public static function getPrecioBolsa()
	{
		return DB::table('tbl_parametro_general')->first();
	}

	public static function getInfoInvetario($id_inventario)
	{
		return DB::table('tbl_inventario_producto')->join('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_inventario_producto.id_catalogo_producto')
												->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_prod_catalogo.id_categoria')
												->join('tbl_prod_referencia','tbl_prod_referencia.id_referencia','tbl_prod_catalogo.id')
												->join('tbl_prod_atributo_valores','tbl_prod_atributo_valores.id','tbl_prod_referencia.id_valor_atributo')
												->join('tbl_prod_atributo','tbl_prod_atributo.id','tbl_prod_atributo_valores.id_atributo')
												->whereIn('tbl_inventario_producto.id_inventario',$id_inventario)
												->where('tbl_prod_atributo.nombre','Calidad')
												->select(
													'tbl_inventario_producto.id_inventario as id',
													'tbl_prod_catalogo.nombre as referencia',
													'tbl_prod_categoria_general.nombre as categoria',
													'tbl_prod_atributo_valores.nombre as calidad',
													'tbl_prod_catalogo.descripcion as detalle',
													DB::raw('1 as cantidad'),
													'tbl_inventario_producto.peso',
													DB::raw('0 as descuento'),
													DB::raw('0 as valor_descuento')
												)
												->get();
	}
	
}
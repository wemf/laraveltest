<?php 

namespace App\AccessObject\Nutibara\Inventario;
use App\Models\Nutibara\Products\Reference;
use App\Models\Nutibara\GestionEstado\Estado\Estado;
use App\Models\Nutibara\Inventario\InventarioEntity;
use DB;
use Exception;

class InventarioAO 
{
	public static function GetReferenceAll()
      {
            return Reference::select('id','nombre AS name')->limit(5)->get();
      }

      public static function GetReferenceByValue($value)
      {
            return Reference::select('id','nombre AS name')->where("nombre","like","%$value%")->limit(5)->get();
      }

      public static function GetDescriptionById($id)
      {
            return Reference::select('descripcion','id_categoria')->where('id',$id)->first();
      }

      public static function GetEstado()
      {
            return Estado::select('nombre as name','id')->where('estado',1)->get();
      }

      public static function IsLote($lote)
      {
            return DB::table('tbl_inventario_producto')->where('lote',$lote)->count();
      }

      public static function Create($request)
      {
            $response=true;
            try{
                  DB::beginTransaction();
                  DB::table('tbl_inventario_producto')->insert($request['producto']);
                  DB::table('tbl_inventario_producto_compra')->insert($request['compra']);
                  DB::commit();
            }
            catch(Exception $e){
                  $response=false;	
                  DB::rollback();
            }
            return $response;
      }

      public static function FindInventario($id)
      {
            return InventarioEntity::select(
                  'tbl_inventario_producto.id_inventario',
                  'tbl_inventario_producto.id_tienda_inventario',
                  'tbl_inventario_producto.lote',
                  'tbl_inventario_producto.id_catalogo_producto',
                  'tbl_inventario_producto.es_nuevo',
                  DB::raw("FORMAT(tbl_inventario_producto.precio_venta,0,'de_DE') as precio_venta"),
                  DB::raw("FORMAT(tbl_inventario_producto.precio_compra,0,'de_DE') as precio_compra"),
                  DB::raw("FORMAT(tbl_inventario_producto.costo_total,0,'de_DE') as costo_total"),
                  'tbl_inventario_producto.cantidad',
                  'tbl_inventario_producto.peso',
                  'tbl_inventario_producto.fecha_ingreso',
                  'tbl_inventario_producto.fecha_salida',
                  'tbl_inventario_producto.id_estado_producto',
                  'tbl_inventario_producto.id_motivo_producto',
                  'tbl_inventario_producto_compra.compra',
                  'tbl_inventario_producto_compra.devolucion_compra',
                  DB::raw("FORMAT(tbl_inventario_producto_compra.costo_devolucion,0,'de_DE') as costo_devolucion"),
                  DB::raw("FORMAT(tbl_inventario_producto_compra.costo_compra,0,'de_DE') as costo_compra"),
                  'tbl_inventario_producto_compra.traslado_entrada',
                  DB::raw("FORMAT(tbl_inventario_producto_compra.costo_traslado_entrada,0,'de_DE') as costo_traslado_entrada"),
                  'tbl_inventario_producto_compra.fecha_compra',
                  'tbl_ciudad.id AS id_ciudad',
                  'tbl_ciudad.nombre AS ciudad',
                  'tbl_departamento.id AS id_departamento',
                  'tbl_departamento.nombre AS departamento',
                  'tbl_departamento.id_pais',
                  'tbl_pais.nombre as pais',
                  'tbl_prod_catalogo.nombre AS referencia',
                  'tbl_prod_catalogo.descripcion',
                  'tbl_tienda.nombre AS tienda',
                  'tbl_prod_categoria_general.nombre AS  categoria'
            )
           ->join('tbl_inventario_producto_compra','tbl_inventario_producto_compra.lote','=','tbl_inventario_producto.lote')
           ->join('tbl_tienda','tbl_tienda.id','=','tbl_inventario_producto.id_tienda_inventario')		
				->join('tbl_ciudad','tbl_ciudad.id','=','tbl_tienda.id_ciudad')	
				->join('tbl_departamento','tbl_departamento.id','=','tbl_ciudad.id_departamento')	
				->join('tbl_pais','tbl_pais.id','=','tbl_departamento.id_pais')
				->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','=','tbl_inventario_producto.id_estado_producto')				
				->join('tbl_sys_motivo','tbl_sys_motivo.id','=','tbl_inventario_producto.id_motivo_producto')	
				->leftJoin('tbl_prod_catalogo','tbl_prod_catalogo.id','=','tbl_inventario_producto.id_catalogo_producto')			
				->leftJoin('tbl_prod_categoria_general','tbl_prod_categoria_general.id','=','tbl_prod_catalogo.id_categoria')
           ->where('tbl_inventario_producto.id_inventario',$id)
           ->first();
      }

      public static function Update($request)
      {
            return InventarioEntity::where('id_inventario',$request['producto']['id_inventario'])->update($request['producto']);
      }
}
<?php 

namespace App\AccessObject\Nutibara\Pedidos;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use App\Models\Nutibara\Products\Reference AS ModelCatalogo;
use DB;

class PedidosAO
{

    public static function get()
    {
        return DB::table('tbl_pedido')->join('tbl_tienda','tbl_tienda.id','tbl_pedido.id_tienda')
                                        ->join('tbl_pedido_tienda','tbl_pedido_tienda.id_pedido','tbl_pedido.id_pedido')
                                        ->join('tbl_tienda as t1','t1.id','tbl_pedido_tienda.id_tienda')
                                        ->join('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_pedido_tienda.id_referencia')
                                        ->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_pedido.id_categoria')
                                        ->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_pedido.id_estado')
                                        ->select(
                                            DB::Raw('concat(tbl_pedido.id_pedido,"/",tbl_pedido_tienda.id_tienda,"/",tbl_pedido_tienda.id_referencia,"/",tbl_pedido.id_tienda) AS DT_RowId'),
                                            'tbl_pedido.id_pedido as numero_pedido',
                                            'codigo as referencia',
                                            'tbl_tienda.nombre as tienda_pedido',
                                            't1.nombre as tienda_referencia',
                                            'tbl_prod_categoria_general.nombre as categoria',
                                            'tbl_sys_estado_tema.nombre as estado',
                                            'fecha_creacion as fecha_pedido',
                                            'fecha_aprobacion',
                                            'fecha_cierre',
                                            'numero_aprobacion',
                                            DB::raw('COALESCE(sum(tbl_pedido_tienda.unidades),0) as unidades'),
                                            DB::raw('COALESCE(sum(tbl_pedido_tienda.recibidas),0) as recibidas'),
                                            DB::raw('COALESCE(sum(tbl_pedido_tienda.pendientes),0) as pendientes')
                                        )
                                        ->groupBy('numero_pedido');
    }

    public static function getTiendaById($id)
    {
        return ModelTienda::where('id',$id)->first();
    }

    public static function getInfoProducto($id)
    {
        return ModelCatalogo::where('id',$id)->first();
    }

    public static function getInventarioByReferencia($referencia,$id_tienda)
    {
        $fecha_antx = date('Y-m-d');
        $fecha_ant = strtotime ( '-1 day' , strtotime ( $fecha_antx ) ) ;
        $fecha_ant = date ( 'Y-m-d' , $fecha_ant );
        $fecha_inicio = date('Y-m-d');

        return DB::select("CALL sp_pedidos_inventario_final_by_id (?,?,?,?)", array($referencia,$fecha_inicio,$fecha_ant,$id_tienda));
    }

    public static function create($data,$data1)
    {
        $respuesta = "Insertado";
        // dd($data);
        try{
            DB::beginTransaction();
            DB::table('tbl_pedido')->insert($data);
            DB::table('tbl_pedido_tienda')->insert($data1);
            DB::commit();
        }catch(\Execute $e){
            if($e->getCode() == 23000)
            {
                $respuesta = 'Error unic';
            }else{
                $respuesta = 'Error';
            }
        }

        return $respuesta;

    }

    public static function updatePedidoAjaxP($id_pedido,$id_tienda,$id_referencia,$valor)
    {
        $respuesta = "Insertado";

        try{
            DB::beginTransaction();
            DB::table('tbl_pedido_tienda')->where('id_pedido',$id_pedido)
                                          ->where('id_tienda',$id_tienda)
                                          ->where('id_referencia',$id_referencia)
                                          ->update(['pendientes'=> $valor]);
            DB::commit();
        }catch(\Execute $e)
        {
            if($e->getCode() == 23000){
                $respuesta = 'Error unic';
            }else{
                $respuesta = 'Error';
            }
        }
        
        return $respuesta;
    }

    public static function updatePedidoAjaxR($id_pedido,$id_tienda,$id_referencia,$valor)
    {
        $respuesta = "Insertado";

        try{
            DB::beginTransaction();
            DB::table('tbl_pedido_tienda')->where('id_pedido',$id_pedido)
                                          ->where('id_tienda',$id_tienda)
                                          ->where('id_referencia',$id_referencia)
                                          ->update(['recibidas' => $valor]);
            DB::commit();
        }catch(\Execute $e)
        {
            if($e->getCode() == 23000){
                $respuesta = 'Error unic';
            }else{
                $respuesta = 'Error';
            }
        }
        
        return $respuesta;
    }

    public static function getEstados()
    {
        return DB::table('tbl_sys_estado_tema')->where('id_tema','13')->where('estado','1')->select('id','nombre')->get();
    }

    public static function getCategorias()
    {
        return DB::table('tbl_prod_categoria_general')->select('id','nombre')->get();
    }

    public static function validarEstado($id_pedido,$id_tienda)
    {
        return DB::table('tbl_pedido')->join('tbl_pedido_tienda','tbl_pedido_tienda.id_pedido','tbl_pedido.id_pedido')
                                      ->where('tbl_pedido.id_pedido',$id_pedido)
                                      ->where('tbl_pedido_tienda.id_tienda',$id_tienda)
                                      ->select('tbl_pedido.id_estado')
                                      ->first();
    }

    public static function aprobar($id_pedido,$id_tienda,$num_aprobacion)
    {
        $respuesta = "Insertado";

        try{
            DB::beginTransaction();
            DB::table('tbl_pedido')->where('id_pedido',$id_pedido)
                                   ->where('id_tienda',$id_tienda)
                                   ->update([
                                                'id_estado' => env('PEDIDO_APROBADO'),
                                                'fecha_aprobacion' => date('Y-m-d'),
                                                'numero_aprobacion' => $num_aprobacion
                                            ]);
            DB::commit();
        }catch(\Execute $e)
        {
            if($e->getCode() == 23000){
                $respuesta = 'Error unic';
            }else{
                $respuesta = 'Error';
            }
        }
        
        return $respuesta;
    }

    public static function rechazar($id_pedido,$id_tienda)
    {
        $respuesta = "Insertado";

        try{
            DB::beginTransaction();
            DB::table('tbl_pedido')->where('id_pedido',$id_pedido)
                                   ->where('id_tienda',$id_tienda)
                                   ->update(['id_estado' => env('PEDIDO_RECHAZADO')]);
            DB::commit();
        }catch(\Execute $e)
        {
            if($e->getCode() == 23000){
                $respuesta = 'Error unic';
            }else{
                $respuesta = 'Error';
            }
        }
        
        return $respuesta;
    }

    public static function InfoPedido($id_pedido,$id_tienda)
    {
        return DB::table('tbl_pedido')->join('tbl_pedido_tienda',function($join){
                                            $join->on('tbl_pedido_tienda.id_pedido','tbl_pedido.id_pedido')
                                                 ->on('tbl_pedido_tienda.id_tienda_pedido','tbl_pedido.id_tienda');
                                      })
                                      ->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_pedido.id_categoria')
                                      ->join('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_pedido_tienda.id_referencia')
                                      ->join('tbl_tienda','tbl_tienda.id','tbl_pedido_tienda.id_tienda')
                                      ->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_pedido.id_estado')
                                      ->where('tbl_pedido.id_pedido',$id_pedido)
                                      ->where('tbl_pedido.id_tienda',$id_tienda)
                                      ->select(
                                          'tbl_tienda.id as id_tienda',
                                          'tbl_tienda.nombre as tienda',
                                          'tbl_prod_catalogo.id as id_referencia',
                                          'tbl_prod_catalogo.nombre as referencia',
                                          'tbl_prod_catalogo.descripcion',
                                          'tbl_pedido.fecha_creacion',
                                          DB::raw('COALESCE(tbl_pedido_tienda.unidades,0) as unidades'),
                                          DB::raw('COALESCE(tbl_pedido_tienda.recibidas,0) as recibidas'),
                                          DB::raw('COALESCE(tbl_pedido_tienda.pendientes,0) as pendientes'),
                                          'tbl_pedido_tienda.precio',
                                          'tbl_pedido.id_pedido',
                                          'tbl_prod_categoria_general.nombre as categoria',
                                          'tbl_sys_estado_tema.nombre as estado',
                                          'tbl_sys_estado_tema.id as id_estado'
                                      )
                                      ->get();
    }

    public static function updateBorrador($data)
    {
        $respuesta = true;
        
        try{
            DB::beginTransaction();
            for ($i=0; $i < count($data->unidades); $i++) {
                DB::table('tbl_pedido_tienda')->where('id_pedido',$data->id_pedidos)
                                                ->where('id_tienda',$data->id_tienda)
                                                ->where('id_referencia',$data->id_referencia[$i])
                                                ->update([
                                                        'unidades' => $data->unidades[$i],
                                                        'precio' => $data->precio[$i]
                                                    ]);
            }
            DB::commit();
        }catch(\Execute $e)
        {
            if($e->getCode() == 23000){
                $respuesta = 'Error unic';
            }else{
                $respuesta = 'Error';
            }
        }
        
        return $respuesta;
    }

    public static function updateGenerar($data)
    {
        $respuesta = true;
        try{
            DB::beginTransaction();
            for ($i=0; $i < count($data->unidades); $i++) {
                DB::table('tbl_pedido_tienda')->where('id_pedido',$data->id_pedidos)
                                                ->where('id_tienda',$data->id_tienda)
                                                ->where('id_referencia',$data->id_referencia[$i])
                                                ->update([
                                                            'unidades' => $data->unidades[$i],
                                                            'precio' => $data->precio[$i]
                                                        ]);
            }

            DB::table('tbl_pedido')->where('id_pedido',$data->id_pedidos)
                                    ->where('id_tienda',$data->id_tienda_pedido)
                                    ->update(['id_estado' => env('PEDIDO_GENERADO')]);
            DB::commit();
        }catch(\Execute $e)
        {
            $respuesta = false;
        }
        
        return $respuesta;
    }
}

?>
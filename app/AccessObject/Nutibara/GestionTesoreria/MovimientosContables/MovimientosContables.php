<?php 

namespace App\AccessObject\Nutibara\GestionTesoreria\MovimientosContables;
use DB;

class MovimientosContables
{
    public static function get()
    {
        return DB::table('tbl_cont_movimientos_contables')
                    ->leftJoin('tbl_tienda','tbl_tienda.id','tbl_cont_movimientos_contables.id_tienda')
                    ->leftJoin('tbl_cont_tipo_documento_contable','tbl_cont_tipo_documento_contable.id','tbl_cont_movimientos_contables.id_tipo_documento')
                    ->leftJoin('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
                    ->leftJoin('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
                    ->leftJoin('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
                    ->leftJoin('tbl_zona','tbl_tienda.id_zona','tbl_zona.id')
                    ->leftJoin('tbl_tes_cierre_caja','tbl_tes_cierre_caja.id_cierre','tbl_cont_movimientos_contables.id_cierre')
                    ->leftJoin('tbl_cont_configuracioncontable','tbl_cont_configuracioncontable.id','tbl_cont_movimientos_contables.id_configuracion_contable')
                    ->select(
                        DB::raw("CONCAT(tbl_cont_movimientos_contables.id_cierre, '/', tbl_cont_movimientos_contables.codigo_movimiento, '/', tbl_cont_movimientos_contables.id_tienda, '/', tbl_cont_movimientos_contables.id_tipo_documento) as DT_RowId"),
                        'tbl_cont_movimientos_contables.id_movimiento',
                        'tbl_cont_movimientos_contables.id_cierre',
                        'tbl_cont_movimientos_contables.id_tienda',
                        'tbl_cont_movimientos_contables.codigo_movimiento',
                        'tbl_cont_movimientos_contables.fecha',
                        'tbl_cont_movimientos_contables.cuenta',
                        'tbl_cont_movimientos_contables.descripcion',
                        'tbl_cont_movimientos_contables.debito',
                        'tbl_cont_movimientos_contables.credito',
                        'tbl_cont_movimientos_contables.referencia',
                        'tbl_cont_movimientos_contables.id_configuracion_contable',
                        DB::raw("CONCAT('$ ', FORMAT(tbl_cont_movimientos_contables.valor,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor"),
                        'tbl_cont_configuracioncontable.nombre AS destino',
                        'tbl_cont_tipo_documento_contable.nombre AS tipo_documento',
                        'tbl_pais.id AS id_pais',
                        'tbl_departamento.id AS id_departamento',
                        'tbl_ciudad.id AS id_ciudad',
                        'tbl_zona.id AS id_zona',
                        'tbl_tienda.nombre'
                    )
                    ->orderBy('tbl_cont_movimientos_contables.fecha', 'DESC')
                    ->orderBy('tbl_cont_movimientos_contables.codigo_movimiento', 'DESC')
                    ->groupBy('tbl_cont_movimientos_contables.codigo_movimiento')
                    ->groupBy('tbl_cont_movimientos_contables.id_tipo_documento');
    }

    public static function tipoDocumento()
    {
        return DB::table('tbl_cont_movimientos_contables')
                    ->join('tbl_cont_tipo_documento_contable','tbl_cont_tipo_documento_contable.id','tbl_cont_movimientos_contables.id_tipo_documento')
                    ->select(
                        'tbl_cont_tipo_documento_contable.id',
                        'tbl_cont_tipo_documento_contable.nombre AS name'
                            )
                    ->distinct()
                    ->orderBy('tbl_cont_tipo_documento_contable.nombre','asc')
                    ->get();
    }

    public static function paises(){
        return DB::table('tbl_pais')
                    ->select(
                        'tbl_pais.id',
                        'tbl_pais.nombre AS name'
                    )
                    ->get();
    }

    public static function getExcel($request){
          return self::get()->where('tbl_cont_movimientos_contables.id_tienda',$request->TiendaActual)
                            ->orWhere('tbl_pais.id',$request->pais)
                            ->orWhere('tbl_departamento.id',$request->departamento)
                            ->orWhere('tbl_ciudad.id',$request->ciudad)
                            ->orWhere('tbl_zona.id',$request->zona)
                            ->orWhere('tbl_tienda.id',$request->tienda)
                            ->orWhere('tbl_cont_movimientos_contables.id_tipo_documento',$request->tipo_documento)
                            ->orWhere('tbl_cont_movimientos_contables.codigo_movimiento',$request->codigo_movimiento)
                            ->orWhere('tbl_cont_movimientos_contables.fecha',$request->fecha)
                            ->get();
    }

    public static function logMovimientosContables($codigo_cierre,$numero_orden,$id_tienda,$id_tipo_documento){
        return DB::table('tbl_cont_movimientos_contables')
                        ->leftJoin('tbl_tes_cierre_caja',function($join){
                            $join->on('tbl_tes_cierre_caja.id_cierre','tbl_cont_movimientos_contables.id_cierre');
                            $join->on('tbl_tes_cierre_caja.id_tienda','tbl_cont_movimientos_contables.id_tienda');
                        })
                        ->leftJoin('tbl_cont_tipo_documento_contable','tbl_cont_tipo_documento_contable.id','tbl_cont_movimientos_contables.id_tipo_documento')
                        //->leftJoin('tbl_cont_movimientos_contables_log','tbl_cont_movimientos_contables_log.id_cierre','tbl_cont_movimientos_contables.id_cierre')                        
                        ->select(
                            //'tbl_cont_movimientos_contables_log.id_log',
                            //'tbl_cont_movimientos_contables_log.id_tienda_log',
                            //'tbl_cont_movimientos_contables_log.id_cierre AS cierre_log',
                            //'tbl_cont_movimientos_contables_log.nombre_log',
                            //'tbl_cont_movimientos_contables_log.url_log',
                            //'tbl_cont_movimientos_contables_log.fecha_log',
                            'tbl_tes_cierre_caja.fecha_inicio AS fecha_inicio_cierre',
                            'tbl_tes_cierre_caja.fecha_final AS fecha_final_cierre',
                            'tbl_cont_movimientos_contables.codigo_movimiento AS codigo_movimiento',
                            'tbl_cont_movimientos_contables.fecha AS fecha_documento',
                            'tbl_cont_movimientos_contables.cuenta AS cuenta',
                            'tbl_cont_movimientos_contables.descripcion AS descripcion_documento',
                            DB::raw("IF(tbl_cont_movimientos_contables.debito = 0,'',CONCAT('$ ', FORMAT(tbl_cont_movimientos_contables.debito,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE'))) AS valor_debito"),
                            DB::raw("IF(tbl_cont_movimientos_contables.credito = 0,'',CONCAT('$ ', FORMAT(tbl_cont_movimientos_contables.credito,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE'))) AS valor_credito"),
                            'tbl_cont_movimientos_contables.id_tipo_documento',
                            'tbl_cont_movimientos_contables.id_tienda',
                            'tbl_cont_movimientos_contables.id_configuracion_contable',
                            'tbl_cont_tipo_documento_contable.nombre AS tipo_documento'
                        )
                        ->where('tbl_cont_movimientos_contables.id_cierre',$codigo_cierre)
                        ->where('tbl_cont_movimientos_contables.codigo_movimiento',$numero_orden)
                        ->where('tbl_cont_movimientos_contables.id_tienda',$id_tienda)
                        ->where('tbl_cont_movimientos_contables.id_tipo_documento',$id_tipo_documento)
                        ->orderBy('tbl_cont_movimientos_contables.id_tienda', 'ASC')
                        ->orderBy('tbl_cont_movimientos_contables.id_movimiento', 'ASC')
                        ->distinct()
                        ->get();
    }

    public static function rutaLog(){
        return DB::table('tbl_cont_movimientos_contables_log')
                ->select('tbl_cont_movimientos_contables_log.id_log',
                         'tbl_cont_movimientos_contables_log.url_log')
                ->first();
    }
}
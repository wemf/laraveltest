<?php 

namespace App\AccessObject\Nutibara\Contratos;

// use App\Models\Nutibara\Contratos\ContratoCabecera AS ModelCabeceraContrato;
use App\Models\Nutibara\SecuenciaTienda\SecuenciaTienda as ModelSecuenciaTienda;
use App\Models\Nutibara\Tienda\Tienda as ModelTienda;
use App\Models\Nutibara\Clientes\Empleado\Empleado as ModelEmpleado;
use DB;
use config\messages;

class Logistica 
{
    public static function get()
    {
        return DB::table('tbl_guia')->join('tbl_tienda','tbl_tienda.id','tbl_guia.id_tienda')
                                    ->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_guia.id_estado')
                                    ->join('tbl_sys_motivo','tbl_sys_motivo.id','tbl_guia.id_motivo')
                                    ->select(
                                        'tbl_guia.id_sec_guia AS DT_RowId',
                                        'tbl_guia.codigo_guia',
                                        'tbl_tienda.nombre as tienda',
                                        DB::raw('concat(tbl_sys_estado_tema.nombre," ",tbl_sys_motivo.nombre) as estado')
                                    )
                                    ->groupBy('tbl_guia.id_sec_guia')
                                    ->groupBy('tbl_guia.codigo_guia')
                                    ->groupBy('tbl_tienda.nombre')
                                    ->groupBy('tbl_sys_estado_tema.nombre')
                                    ->groupBy('tbl_sys_motivo.nombre');
    }
    
    public static function getResolucionesById($id)
    {
        return DB::table('tbl_orden')->leftJoin('tbl_orden_trazabilidad',function($join){
                                            $join->on('tbl_orden_trazabilidad.id_orden','tbl_orden.id_orden')
                                                 ->on('tbl_orden_trazabilidad.id_tienda_orden','tbl_orden.id_tienda_orden');
                                        })
                                    ->leftJoin('tbl_guia',function($join){
                                            $join->on('tbl_guia.id_resolucion','tbl_orden.id_orden')
                                                 ->on('tbl_guia.id_tienda','tbl_orden.id_tienda_orden');
                                        })
                                    ->leftJoin('tbl_sys_tema','tbl_sys_tema.id','tbl_orden.proceso')
                                    ->whereRaw('(tbl_guia.id_estado = '.env('CERRAR_GUIA_ESTADO').' or tbl_guia.id_estado is null)')
                                    ->whereRaw('(id_motivo = '.env('CERRAR_GUIA_MOTIVO').' or id_motivo is null)')
                                    ->whereRaw('(disponible = 0 or disponible is null)')
                                    ->where('tbl_orden_trazabilidad.actual','1')
                                    ->select('tbl_orden.id_orden as id',DB::raw('concat(tbl_orden.id_orden," - ",tbl_sys_tema.nombre) as name'))
                                    ->get();
    }

    public static function getResolucionesByIdResolucion($id)
    {
        return DB::table('tbl_orden')->Join('tbl_guia','tbl_guia.id_resolucion','tbl_orden.id_orden')
                                        ->leftJoin('tbl_sys_tema','tbl_sys_tema.id','tbl_orden.proceso')
                                        ->where('tbl_guia.id_sec_guia',$id)
                                        ->select('id_orden as id','id_orden as name','tbl_sys_tema.nombre as proceso')
                                        ->get();
    }

    public static function getGuiaSeguimiento($id)
    {
        return DB::table('tbl_guia')->leftJoin('tbl_cliente',function($join){
                                        $join->on('tbl_cliente.codigo_cliente','tbl_guia.id_user_bodega')
                                             ->on('tbl_cliente.id_tienda','tbl_guia.id_bodega_envio');
                                    })
                                    ->leftJoin('tbl_tienda','tbl_tienda.id','tbl_guia.id_bodega_envio')
                                    ->leftJoin('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
                                    ->leftJoin('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
                                    ->leftJoin('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
                                    ->where('tbl_guia.id_sec_guia',$id)
                                    ->select(
                                        'tbl_guia.id_estado',
                                        'tbl_guia.id_tienda',
                                        'tbl_guia.id_sec_guia',
                                        'tbl_guia.id_tienda_principal',
                                        'tbl_guia.id_motivo',
                                        'tbl_guia.id_bodega_envio',
                                        'tbl_pais.nombre as pais',
                                        'tbl_departamento.nombre as departamento',
                                        'tbl_ciudad.nombre as ciudad',
                                        'tbl_tienda.nombre as destino',
                                        'tbl_tienda.tienda_padre',
                                        DB::raw('concat(tbl_cliente.nombres," ",tbl_cliente.primer_apellido," ",tbl_cliente.segundo_apellido) as recibe'),
                                        DB::raw('IF(tbl_guia.id_tienda_principal = 1, "Si", "No") AS pasar_por_tienda'),
                                        DB::raw('IF((select tipo_bodega from tbl_tienda join tbl_guia on tbl_guia.id_tienda = tbl_tienda.id where tbl_guia.id_sec_guia = '.$id.' limit 1) = 1, "Bodega", "Tienda") AS envio')
                                    )
                                    ->first();
    }

    public static function getSedePrincipal($id)
    {
        return ModelSecuenciaTienda::join('tbl_tienda','tbl_tienda.id','tbl_secuencia_tienda_x.id_tienda')
                                    ->where('id_tienda',$id)
                                    ->select('tbl_tienda.sede_principal','tbl_tienda.tienda_padre')
                                    ->first();
    }

    public static function getEmpleadosTienda($id)
    {
        return DB::table('tbl_cliente')->where('id_tienda',$id)
                                       ->where(function($query){
                                            $query->where('id_tipo_cliente','1')
                                                  ->orWhere('id_tipo_cliente','2');
                                       })
                                       ->select('codigo_cliente as id',DB::raw('concat(nombres," ",primer_apellido," ",segundo_apellido) as name'))
                                       ->get();
    }

    public static function getSelectListPrincipal()
    {
       return ModelSecuenciaTienda::join('tbl_tienda','tbl_tienda.id','tbl_secuencia_tienda_x.id_tienda')
                                    ->where('tbl_secuencia_tienda_x.sede_principal','1')
                                    ->select('tbl_tienda.id','tbl_tienda.nombre')
                                    ->groupBy('tbl_tienda.id')
                                    ->groupBy('tbl_tienda.nombre')
                                    ->get();
    }
    public static function createPost($data,$traza,$relaciones,$id_tienda)
    {
        // dd($traza);
        $result = "Insertado";
		try
		{
            DB::beginTransaction();
            DB::table('tbl_guia')->insert($data);
            DB::table('tbl_guia_historico')->insert($traza);
            self::relacionesDisponibilidad($relaciones,$id_tienda);
            DB::commit();
        }catch(\Exception $e){
            dd($e);
            if($e->getCode() == 2300)
			{
				$result = "ErrorUnico";
			}else
			{
				$result = "Error";
			}
			DB::rollBack();
        }
        return $result;
    }

    public static function relacionesDisponibilidad($relaciones,$id_tienda)
    {
        for($i = 0; $i < count($relaciones); $i++)
        {
            DB::table('tbl_guia')->where('id_resolucion',$relaciones[$i])
                                 ->where('id_tienda',$id_tienda)
                                 ->update(['disponible' => (int)1]);
        }
    }

    public static function sec_guia($id_tienda)
    {
        return DB::select('CALL sp_secuencias_tienda_x (?,?,?)',array($id_tienda,(int)14,(int)1));
    }

    public static function getPaisTienda($id_tienda)
    {
        return ModelTienda::join('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
                            ->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
                            ->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
                            ->where('tbl_tienda.id',$id_tienda)
                            ->select('tbl_pais.id','tbl_pais.abreviatura')
                            ->first();
    }

    public static function getSelectListByTipe($tipe,$city,$id_tienda){
        return ModelTienda::select('id', 'nombre as name')
                            ->where('tipo_bodega',(int)$tipe)
                            ->where('id_ciudad',(int)$city)
                            ->whereNotIn('id',[$id_tienda])
                            ->get();
    }
    
    public static function getTrazabilidad($id)
    {
        return DB::table('tbl_guia_historico')->join('tbl_guia','tbl_guia.id_sec_guia','tbl_guia_historico.sec_guia')
                                              ->join('tbl_tienda','tbl_tienda.id','tbl_guia_historico.destino')
                                              ->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_guia_historico.id_estado')
                                              ->join('tbl_sys_motivo_estado',function($join){
                                                                                $join->on('tbl_sys_motivo_estado.id_estado','tbl_sys_estado_tema.id')
                                                                                     ->on('tbl_sys_motivo_estado.id_motivo','tbl_guia_historico.id_motivo');
                                                                            }
                                                    )
                                              ->join('tbl_sys_motivo','tbl_sys_motivo.id','tbl_sys_motivo_estado.id_motivo')
                                              ->where('tbl_guia_historico.sec_guia',$id)
                                              ->select(
                                                    DB::raw('concat(tbl_sys_estado_tema.nombre, " " , tbl_sys_motivo.nombre) as estado'),
                                                    'tbl_guia_historico.fecha',
                                                    'tbl_guia.codigo_guia as codigo',
                                                    'tbl_tienda.nombre as destino',
                                                    'tbl_guia_historico.observaciones'
                                              )
                                              ->groupBy('tbl_guia_historico.fecha')
                                              ->groupBy('codigo')
                                              ->groupBy('tbl_guia_historico.observaciones')
                                              ->groupBy('tbl_sys_motivo.nombre')
                                              ->groupBy('tbl_sys_estado_tema.nombre')
                                              ->groupBy('tbl_tienda.nombre')
                                              ->orderBy('tbl_guia_historico.fecha', 'asc')
                                              ->get();
    }

    public static function anularGuia($data,$id)
    {
        $result = "Insertado";
		try
		{
            DB::beginTransaction();
            DB::table('tbl_guia')->where('id_sec_guia',$id)->update(['id_estado'=>'71']);//hacer merge archivo sobre escrito messages.php
            DB::table('tbl_guia_historico')->insert($data);
            DB::commit();
        }catch(\Exception $e){
            dd($e);
            if($e->getCode() == 2300)
			{
				$result = "ErrorUnico";
			}else
			{
				$result = "Error";
			}
			DB::rollBack();
        }
        return $result;
    }

    public static function seguimientoGuia($data,$id,$id_estado,$id_motivo)
    {
        $result = "Insertado";
		try
		{
            DB::beginTransaction();
            if(env('CERRAR_GUIA_ESTADO') == $id_estado && env('CERRAR_GUIA_MOTIVO') == $id_motivo){
            DB::table('tbl_guia')->where('id_sec_guia',$id)->update(['id_estado'=>$id_estado,'id_motivo' => $id_motivo,'disponible' => (int)0]);//hacer merge archivo sobre escrito messages.php
            }else{
            DB::table('tbl_guia')->where('id_sec_guia',$id)->update(['id_estado'=>$id_estado,'id_motivo' => $id_motivo]);
            }
            DB::table('tbl_guia_historico')->insert($data);
            DB::commit();
        }catch(\Exception $e){
            dd($e);
            if($e->getCode() == 2300)
			{
				$result = "ErrorUnico";
			}else
			{
				$result = "Error";
			}
			DB::rollBack();
        }
        return $result;
    }

    public static function getEstado($like,$tema)
    {
       return DB::table('tbl_sys_estado_tema')->where('nombre', 'like', "%".$like."%")
                                        ->where('estado','1')
                                        ->where('id_tema',$tema)
                                        ->select('id')
                                        ->first();
    }

    public static function getTiendaByIp($ip){
		return ModelTienda::select('id', 'nombre')->where('ip_fija', $ip)->first();
    }
    
    public static function valdestino($id_tienda)
    {
        return ModelTienda::select('tipo_bodega')->where('id',$id_tienda)->first();
    }
}
<?php

namespace app\AccessObject\Nutibara\ModificarClausulas;

use App\Models\Nutibara\ModificarClausulas\ModificarClausulas AS modClausulas;
use App\Models\Nutibara\SecuenciaTienda\SecuenciaTienda AS ModelSecuenciaTienda;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use DB;


class ModificarClausulas
{
    public static function get(){

        return DB::table('tbl_sys_modificar_clausulas')
        ->join('tbl_sys_detalle_modificarclausula','tbl_sys_detalle_modificarclausula.id_clausula','tbl_sys_modificar_clausulas.id')
        ->leftjoin('tbl_pais','tbl_pais.id','tbl_sys_modificar_clausulas.id_pais')
        ->leftjoin('tbl_departamento','tbl_departamento.id','tbl_sys_modificar_clausulas.id_departamento')
        ->leftjoin('tbl_ciudad','tbl_ciudad.id','tbl_sys_modificar_clausulas.id_ciudad')
        ->leftjoin('tbl_tienda','tbl_tienda.id','tbl_sys_modificar_clausulas.id_tienda')
        ->select(
                'tbl_sys_modificar_clausulas.id AS DT_RowId',
                'tbl_pais.nombre AS pais',
                'tbl_departamento.nombre AS departamento',
                'tbl_ciudad.nombre AS ciudad',
                'tbl_tienda.nombre AS tienda',
                'tbl_sys_modificar_clausulas.nombre_clausula',
                DB::raw('max(tbl_sys_detalle_modificarclausula.vigencia_desde) as vigencia_desde')
                 
        )
        ->whereDate('tbl_sys_detalle_modificarclausula.vigencia_desde',"<=",date('Y-m-d'))
        ->orderBy('tbl_sys_modificar_clausulas.nombre_clausula','asc')
        ->groupBy('tbl_sys_modificar_clausulas.id');
    }

    public static function getById($id,$vigencia){
        
        $cl = DB::table('tbl_sys_modificar_clausulas')
        ->leftjoin('tbl_sys_detalle_modificarclausula','tbl_sys_detalle_modificarclausula.id_clausula','tbl_sys_modificar_clausulas.id')
        ->leftjoin('tbl_pais','tbl_pais.id','tbl_sys_modificar_clausulas.id_pais')
        ->leftjoin('tbl_departamento','tbl_departamento.id','tbl_sys_modificar_clausulas.id_departamento')
        ->leftjoin('tbl_ciudad','tbl_ciudad.id','tbl_sys_modificar_clausulas.id_ciudad')
        
        ->leftjoin('tbl_tienda','tbl_tienda.id','tbl_sys_modificar_clausulas.id_tienda')
        ->select(
                'tbl_sys_modificar_clausulas.id',
                'tbl_pais.nombre AS pais',
                'tbl_departamento.nombre AS departamento',
                'tbl_ciudad.nombre AS ciudad',
                
                'tbl_tienda.nombre AS tienda',
                'tbl_sys_modificar_clausulas.nombre_clausula',
                'tbl_sys_detalle_modificarclausula.id AS id_detalle',
                'tbl_sys_detalle_modificarclausula.descripcion_clausula',
                'tbl_sys_detalle_modificarclausula.vigencia_desde',
                DB::raw("IF(tbl_sys_modificar_clausulas.estado_clausula = 1, 'SI', 'NO') AS estado_clausula")
        )
        ->where('tbl_sys_modificar_clausulas.id',$id)
        ->whereDate('tbl_sys_detalle_modificarclausula.vigencia_desde','>=',$vigencia)
        ->orderBy('tbl_sys_detalle_modificarclausula.id','asc')
        ->limit(2)
        ->get();
        
        return $cl;
    }
    public static function getViewId($id){
        $cl = DB::table('tbl_sys_modificar_clausulas')
        ->leftjoin('tbl_sys_detalle_modificarclausula','tbl_sys_detalle_modificarclausula.id_clausula','tbl_sys_modificar_clausulas.id')
        ->leftjoin('tbl_pais','tbl_pais.id','tbl_sys_modificar_clausulas.id_pais')
        ->leftjoin('tbl_departamento','tbl_departamento.id','tbl_sys_modificar_clausulas.id_departamento')
        ->leftjoin('tbl_ciudad','tbl_ciudad.id','tbl_sys_modificar_clausulas.id_ciudad')
        
        ->leftjoin('tbl_tienda','tbl_tienda.id','tbl_sys_modificar_clausulas.id_tienda')
        ->select(
                'tbl_sys_modificar_clausulas.id',
                'tbl_pais.nombre AS pais',
                'tbl_departamento.nombre AS departamento',
                'tbl_ciudad.nombre AS ciudad',
                
                'tbl_tienda.nombre AS tienda',
                'tbl_sys_modificar_clausulas.nombre_clausula',
                'tbl_sys_detalle_modificarclausula.id AS id_detalle',
                'tbl_sys_detalle_modificarclausula.descripcion_clausula',
                'tbl_sys_detalle_modificarclausula.vigencia_desde'  
                //DB::raw("IF(tbl_sys_modificar_clausulas.estado_clausula = 1, 'SI', 'NO') AS estado_clausula")
        )->where('tbl_sys_modificar_clausulas.id',$id)
        ->whereDate('tbl_sys_detalle_modificarclausula.vigencia_desde',"<=",date('Y-m-d'))
        ->orderBy('tbl_sys_detalle_modificarclausula.vigencia_desde','desc')
        ->first();
        
        return $cl;
    }

    


    //buscar ID
    public static function FindId($clausula){
        return DB::table('tbl_sys_modificar_clausulas')
            ->select(
                'tbl_sys_modificar_clausulas.id'
            )->where('tbl_sys_modificar_clausulas.nombre_clausula',$clausula)
            ->orderBy('tbl_sys_modificar_clausulas.id','desc')->first();
            
        
    }

    public static function FindClausula($data){
        //dd($data['id']);
        $res= DB::table('tbl_sys_modificar_clausulas')
        ->leftjoin('tbl_sys_detalle_modificarclausula','tbl_sys_detalle_modificarclausula.id_clausula','tbl_sys_modificar_clausulas.id')
        ->leftjoin('tbl_pais','tbl_pais.id','tbl_sys_modificar_clausulas.id_pais')
        ->leftjoin('tbl_departamento','tbl_departamento.id','tbl_sys_modificar_clausulas.id_departamento')
        ->leftjoin('tbl_ciudad','tbl_ciudad.id','tbl_sys_modificar_clausulas.id_ciudad')
        ->leftjoin('tbl_tienda','tbl_tienda.id','tbl_sys_modificar_clausulas.id_tienda')
        ->select(
                'tbl_sys_modificar_clausulas.id',
                'tbl_pais.nombre AS pais',
                'tbl_departamento.nombre AS departamento',
                'tbl_ciudad.nombre AS ciudad',
                
                'tbl_tienda.nombre AS tienda',
                'tbl_sys_modificar_clausulas.nombre_clausula',
                'tbl_sys_detalle_modificarclausula.id AS id_detalle',
                'tbl_sys_detalle_modificarclausula.descripcion_clausula',
                'tbl_sys_detalle_modificarclausula.vigencia_desde',
                DB::raw("IF(tbl_sys_modificar_clausulas.estado_clausula = 1, 'SI', 'NO') AS estado_clausula")
        )->where('tbl_sys_modificar_clausulas.id',$data['id'])
        ->where('tbl_sys_modificar_clausulas.id_pais',$data['id_pais'])
        ->where(function($query) use ($data){

            if($data['id_departamento']==null){
                $query->whereNull('tbl_sys_modificar_clausulas.id_departamento');
            }else{
                $query->where('tbl_sys_modificar_clausulas.id_departamento',$data['id_departamento']);

            }
        })
        ->where(function($query) use ($data){
            if($data['id_ciudad']==null){
                $query->whereNull('tbl_sys_modificar_clausulas.id_ciudad');
            }else{
                $query->where('tbl_sys_modificar_clausulas.id_ciudad',$data['id_ciudad']);

            }
        })
        
        ->where(function($query) use ($data){
            if($data['id_tienda']==null){
                $query->whereNull('tbl_sys_modificar_clausulas.id_tienda');
            }else{
                $query->where('tbl_sys_modificar_clausulas.id_tienda',$data['id_tienda']);
            }
        })
        ->whereDate('tbl_sys_detalle_modificarclausula.vigencia_desde',"<=",date('Y-m-d'))
        ->orderBy('tbl_sys_detalle_modificarclausula.vigencia_desde','desc');

        dd($res->first());
    }

    public static function create($dataSaved){
        $result="Insertado";
        try{
            DB::beginTransaction();
            DB::table('tbl_sys_modificar_clausulas')->insert($dataSaved);
            DB::commit();
        }catch(Exception $e){
            if($e->getCode()==23000){
                $result="ErrorUnico";
            }else{
                $result="Error";
            }
            DB::rollback();
        }
        return $result;
    }

    public static function createDetalle($dataSaved){
        $result="Insertado";
        try{
            DB::beginTransaction();
            DB::table('tbl_sys_detalle_modificarclausula')->insert($dataSaved);
            DB::commit();
        }catch(Exception $e){
            if($e->getCode()==23000){
                $result="ErrorUnico";
            }else{
                $result="Error";
            }
            DB::rollback();
        }
        return $result;
    }
    public static function updateDetalle($id,$detalleSaved){

        $result="Insertado";
        try{
            DB::beginTransaction();
            DB::table('tbl_sys_detalle_modificarclausula')->where('tbl_sys_detalle_modificarclausula.id','=',$id)->update($detalleSaved);
            DB::commit();
        }catch(Exception $e){
            if($e->getCode()==23000){
                $result="ErrorUnico";
            }else{
                $result="Error";
            }
            DB::rollback();
        }

        return $result;
    }
    public static function delete($request){}

    public static function paises(){
        return DB::table('tbl_pais')->select('tbl_pais.id','tbl_pais.nombre')->get();
    }
}
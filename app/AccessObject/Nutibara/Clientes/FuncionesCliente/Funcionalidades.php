<?php 

namespace App\AccessObject\Nutibara\Clientes\FuncionesCliente;

use App\Models\Nutibara\Clientes\Cliente AS ModelCliente;
use App\Models\Nutibara\Parametros\Parametros AS ModelParametros;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use App\Models\Nutibara\Sociedad\Sociedad AS ModelSociedad;

class Funcionalidades 
{
    public static function checkCountCliente($tipo_documento , $numero_documento)
    {
        return ModelCliente::select('codigo_cliente','id_tienda','id_tipo_cliente','id_tipo_documento','numero_documento')
                            ->where('id_tipo_documento' , $tipo_documento)
                            ->where('numero_documento' , $numero_documento)
                            ->first();
	}

    public static function getparametroGeneral($id){
        return ModelParametros::join('tbl_pais','tbl_pais.id','tbl_parametro_general.id_pais')
                        ->select('tbl_parametro_general.id','tbl_pais.nombre')
                        ->where('tbl_parametro_general.id_pais',$id)
                        ->first();
    }

    public static function getFranquiciaByTipoCliente($id){
        return ModelTienda::join('tbl_secuencia_tienda_x','tbl_secuencia_tienda_x.id_tienda','tbl_tienda.id')
                        ->join('tbl_franquicia','tbl_franquicia.id','tbl_tienda.id_franquicia')
                        ->distinct()
                        ->select('tbl_franquicia.id','tbl_franquicia.nombre')
                        ->where('tbl_secuencia_tienda_x.sede_principal',$id)
                        ->where('tbl_tienda.tipo_bodega',0)
                        ->get();
    }

    public static function getSociedadByFranquicia($id){
        return ModelTienda::join('tbl_secuencia_tienda_x','tbl_secuencia_tienda_x.id_tienda','tbl_tienda.id')
                        ->join('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
                        ->distinct()
                        ->select('tbl_sociedad.id','tbl_sociedad.nombre')
                        ->where('tbl_secuencia_tienda_x.sede_principal',$id)
                        ->where('tbl_tienda.tipo_bodega',0)                        
                        ->get();
    }

    public static function getTiendaBySociedad($id,$franquicia,$sociedad){
        return ModelTienda::join('tbl_secuencia_tienda_x','tbl_secuencia_tienda_x.id_tienda','tbl_tienda.id')
                        ->join('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
                        ->distinct()
                        ->select('tbl_tienda.id','tbl_tienda.nombre')
                        ->where('tbl_tienda.id_franquicia',$franquicia)
                        ->where('tbl_tienda.id_sociedad',$sociedad  )
                        ->where('tbl_secuencia_tienda_x.sede_principal',$id)
                        ->where('tbl_tienda.tipo_bodega',0)                        
                        ->get();
    }

}
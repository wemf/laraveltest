<?php

namespace App\AccessObject\Nutibara\ReporteRotacion;
use App\Models\Nutibara\Inventario\Inventario as ModelInventario;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use DB;

class ReporteRotacionAO
{
    public static function getTiendaByIp($ip){
		return ModelTienda::select('id', 'nombre')->where('ip_fija', $ip)->first();
	}

	public static function get($start, $end, $colum, $order, $search)
	{
		return DB::select('CALL sp_index_pedidos (?,?,?,?,?,?,?,?,?,?)',array($search["fecha_inicio"],$search["fecha_fin"],$search["id_pais"],$search["id_departamento"],$search["id_ciudad"],$search["id_tienda"],$search["id_categoria"],$search["referencia"],$search["id_sociedad"],$search["id_zona"]));
	}

	public static function getCount($start, $end, $colum, $order, $search)
	{
		$con = DB::select('CALL sp_index_pedidos (?,?,?,?,?,?,?,?,?,?)',array($search["fecha_inicio"],$search["fecha_fin"],$search["id_pais"],$search["id_departamento"],$search["id_ciudad"],$search["id_tienda"],$search["id_categoria"],$search["referencia"],$search["id_sociedad"],$search["id_zona"]));
		return count($con);
	}
}

?>
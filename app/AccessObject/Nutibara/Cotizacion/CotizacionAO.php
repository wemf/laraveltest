<?php 

namespace App\AccessObject\Nutibara\Cotizacion;

use App\Models\Nutibara\GenerarPlan\GenerarPlan AS ModelGenerarPlan;
use App\Models\Nutibara\Clientes\Cliente AS ModelCliente;
use App\Models\Nutibara\Contratos\ContratoCabecera AS ModelContratos;
use App\Models\Nutibara\ConfigContrato\ItemContrato AS ModelItemContratos;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use App\Models\Nutibara\GenerarPlan\Cotizacion;
use DB;

class CotizacionAO 
{
	public static function get(){
		return DB::table('tbl_plan_cotizacion')->join('tbl_tienda','tbl_tienda.id','tbl_plan_cotizacion.id_tienda')
											   ->select(
												   		DB::Raw('concat(tbl_plan_cotizacion.id_tienda,"/",tbl_plan_cotizacion.id_cotizacion) AS DT_RowId'),
														'tbl_plan_cotizacion.id_cotizacion',
													   	'tbl_tienda.nombre as nombre_tienda',
													   	'tbl_plan_cotizacion.referencia',
													   	DB::Raw("FORMAT(tbl_plan_cotizacion.precio,2,'de_DE') as precio"),
													   	'tbl_plan_cotizacion.fecha',
													   	'tbl_plan_cotizacion.fecha_res',
														DB::raw('if(tbl_plan_cotizacion.estado = 0,"Respondido","Pendiente") as estado'),
														DB::raw('SUBSTR(tbl_plan_cotizacion.descripcion, 1, 30) as descripcion')	
											   )
											   ->orderBy('fecha','desc')
											   ->orderBy('estado','asc');
	}

	public static function store($data,$id_tienda,$id_usuario,$id_cotizacion)
	{
		$result = true;
		try{
			DB::beginTransaction();
			DB::table('tbl_plan_cotizacion')->insert([
													'descripcion' => $data->descripcion,
													'id_usuario' => $id_usuario,
													'id_tienda' => $id_tienda,
													'id_cotizacion' => $id_cotizacion,
													'estado' => (int)1,
													'fecha' => date('Y-m-d H:i:s')
													]);
			DB::commit();
		}
		catch(\Exception $e)
		{
			dd($e);
			DB::rollBack();
			$result = false;
		}

		return $result;
	}

	public static function cotizacionById($id_tienda,$id_cotizacion)
	{
		return Cotizacion::where(['id_tienda' => $id_tienda,'id_cotizacion' => $id_cotizacion])
											   ->select(
												   'descripcion',
												   'especificaciones',
												   'peso',
												   'referencia',
												   'fecha_entrega',
												   DB::Raw("FORMAT(precio,2,'de_DE') as precio"),
												   'estado',
												   'id_tienda',
												   'id_cotizacion',
												   'id_usuario',
												   'id_catalogo'
											   )
											   ->first();
	}

	public static function storeUpdate($data)
	{
		$result = true;
		try{
			DB::beginTransaction();
			DB::table('tbl_plan_cotizacion')->where(['id_tienda' => $data->id_tienda,'id_cotizacion' => $data->id_cotizacion])
											->update([
												'fecha_res' =>date('Y-m-d H:i:s'),
												'estado' => (int)0,
												'referencia' => $data->referencia,
												'precio' => self::limpiarVal($data->precio),
												'peso' => self::limpiarVal($data->peso),
												'id_catalogo' => $data->id_catalogo_producto,
												'especificaciones' => $data->especificaciones,
												'fecha_entrega' => $data->fecha_entrega
											]);
			DB::commit();
		}
		catch(\Exception $e)
		{
			dd($e);
			DB::rollBack();
			$result = false;
		}

		return $result;
	}

	public static function limpiarVal($val)
	{
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}
}
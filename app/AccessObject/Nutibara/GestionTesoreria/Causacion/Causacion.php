<?php 

namespace App\AccessObject\Nutibara\GestionTesoreria\Causacion;

use App\Models\Nutibara\GestionTesoreria\Causacion\Causacion AS ModelCausacion;
use App\Models\Nutibara\GestionTesoreria\Concepto\Concepto AS ModelConcepto;
use DB;

class Causacion 
{
	public static function CausacionAdminWhere($start,$end,$colum, $order,$search)
	{
		if($search['primera_busqueda'] == "")
		$search['id_estado'] = 100;		
		return ModelCausacion::join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_tes_causacion.id_estado')
							->join('tbl_tienda','tbl_tienda.id','tbl_tes_causacion.id_tienda')
							->join('tbl_tes_tipo_causacion','tbl_tes_tipo_causacion.id','tbl_tes_causacion.id_tipo_causacion')
							->leftjoin('tbl_usuario','tbl_usuario.id','tbl_tes_causacion.id_usuario_actualizacion')
							->select(
									DB::raw('concat(tbl_tes_causacion.id,"/",tbl_tes_causacion.id_tienda) AS DT_RowId'),
									'tbl_tienda.nombre AS tienda',
									'tbl_sys_estado_tema.nombre AS estado',																
									'tbl_tes_causacion.fecha_creado AS fecha_creado',
									'tbl_tes_tipo_causacion.nombre AS tipo_causacion',
									'tbl_usuario.name AS usuario',
									'tbl_tes_causacion.fecha_actualizado',									
									DB::raw("CONCAT('$ ', FORMAT(tbl_tes_causacion.valor,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor")
								)
								->where(function ($query) use ($search)
								{
									if($search['id_tienda'] <> "")
									$query->where('tbl_tes_causacion.id_tienda',$search['id_tienda']);
									
									if($search['id_estado'] <> "")
									$query->where('tbl_tes_causacion.id_estado',$search['id_estado']);

									if($search['fecha_creado'] <> "")
									$query->where('tbl_tes_causacion.fecha_creado','LIKE','%'. $search['fecha_creado'].'%');

									if($search['id_tipo_causacion'] <> "")
									$query->where('tbl_tes_causacion.id_tipo_causacion', $search['id_tipo_causacion']);
								})
								->skip($start)->take($end)
								->orderBy('fecha_creado', 'desc')
								->get();
	}

	public static function getCountCausacionAdmin($search)
	{
		if($search['primera_busqueda'] == "")
		$search['id_estado'] = 100;
		
		return ModelCausacion::join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_tes_causacion.id_estado')
							->join('tbl_tienda','tbl_tienda.id','tbl_tes_causacion.id_tienda')
							->join('tbl_tes_tipo_causacion','tbl_tes_tipo_causacion.id','tbl_tes_causacion.id_tipo_causacion')
							->leftjoin('tbl_usuario','tbl_usuario.id','tbl_tes_causacion.id_usuario_actualizacion')							
							->where(function ($query) use ($search)
								{
									if($search['id_tienda'] <> "")
									$query->where('tbl_tes_causacion.id_tienda',$search['id_tienda']);
									
									if($search['id_estado'] <> "")
									$query->where('tbl_tes_causacion.id_estado',$search['id_estado']);

									if($search['fecha_creado'] <> "")
									$query->where('tbl_tes_causacion.fecha_creado','LIKE','%'. $search['fecha_creado'].'%');
									

									if($search['id_tipo_causacion'] <> "")
									$query->where('tbl_tes_causacion.id_tipo_causacion', $search['id_tipo_causacion']);
								})
							->count();
	}

	public static function CausacionWhere($start,$end,$colum, $order,$search)
	{
		if($search['primera_busqueda'] == "")		
		$search['id_estado'] = 100;
		return ModelCausacion::join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_tes_causacion.id_estado')
							->join('tbl_tienda','tbl_tienda.id','tbl_tes_causacion.id_tienda')
							->join('tbl_tes_tipo_causacion','tbl_tes_tipo_causacion.id','tbl_tes_causacion.id_tipo_causacion')
							->leftjoin('tbl_usuario','tbl_usuario.id','tbl_tes_causacion.id_usuario_actualizacion')							
							->select(
									DB::raw('concat(tbl_tes_causacion.id,"/",tbl_tes_causacion.id_tienda) AS DT_RowId'),
									'tbl_tienda.nombre AS tienda',
									'tbl_sys_estado_tema.nombre AS estado',																
									'tbl_tes_causacion.fecha_creado AS fecha_creado',
									'tbl_tes_tipo_causacion.nombre AS tipo_causacion',
									'tbl_usuario.name AS usuario',									
									'tbl_tes_causacion.fecha_actualizado',									
									DB::raw("CONCAT('$ ', FORMAT(tbl_tes_causacion.valor,(SELECT decimales FROM tbl_parametro_general LIMIT 1),'de_DE')) AS valor")									
								)
								->where(function ($query) use ($search)
								{
									if($search['id_tienda'] <> "")
									$query->where('tbl_tes_causacion.id_tienda', $search['id_tienda']);

									if($search['id_estado'] <> "")
									$query->where('tbl_tes_causacion.id_estado',$search['id_estado']);

									if($search['fecha_creado'] <> "")
									$query->where('tbl_tes_causacion.fecha_creado','LIKE','%'. $search['fecha_creado'].'%');									

									if($search['id_tipo_causacion'] <> "")
									$query->where('tbl_tes_causacion.id_tipo_causacion', $search['id_tipo_causacion']);
									
									$query->where('tbl_tes_causacion.id_tienda',$search['id_tienda']);									
								})
								->skip($start)->take($end)
								->orderBy('fecha_creado', 'desc')								
								->get();
	}

	public static function getCountCausacion($search)
	{
		if($search['primera_busqueda'] == "")
		$search['id_estado'] = 100;
		return ModelCausacion::join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_tes_causacion.id_estado')
							->join('tbl_tienda','tbl_tienda.id','tbl_tes_causacion.id_tienda')
							->join('tbl_tes_tipo_causacion','tbl_tes_tipo_causacion.id','tbl_tes_causacion.id_tipo_causacion')
							->leftjoin('tbl_usuario','tbl_usuario.id','tbl_tes_causacion.id_usuario_actualizacion')
							->where(function ($query) use ($search)
								{
									if($search['id_estado'] <> "")
									$query->where('tbl_tes_causacion.id_estado',$search['id_estado']);
									if($search['fecha_creado'] <> "")
									$query->where('tbl_tes_causacion.fecha_creado','LIKE','%'. $search['fecha_creado'].'%');									
									if($search['id_tipo_causacion'] <> "")
									$query->where('tbl_tes_causacion.id_tipo_causacion', $search['id_tipo_causacion']);

									$query->where('tbl_tes_causacion.id_tienda',$search['id_tienda']);
								})
							->count();
	}


	public static function getCausacionById($id){
		return ModelCausacion::join('tbl_pais','tbl_pais.id','tbl_tes_causacion.id_pais')
											->select(
													'tbl_tes_causacion.id',
													'tbl_tes_causacion.nombre',
													'tbl_tes_causacion.codigo',
													'tbl_pais.nombre as pais',
													DB::raw("IF(tbl_tes_causacion.estado = 1, 'Si', 'No') AS estado")
												)
											->where('tbl_tes_causacion.id',$id)
											->where('tbl_tes_causacion.id_tienda',$id)
											->where('impuesto',0)											
											->first();
	}

	public static function getCausacionByIdandTienda($id,$idTienda)
	{
		return ModelCausacion::join('tbl_tienda','tbl_tienda.id','tbl_tes_causacion.id_tienda')
								->join('tbl_cont_movimientos_contables','tbl_cont_movimientos_contables.codigo_movimiento','tbl_tes_causacion.comprobante_contable')
								->join('tbl_cont_movimientos_configuracioncontable','tbl_cont_movimientos_configuracioncontable.id_configuracioncontable','tbl_cont_movimientos_contables.id_configuracion_contable')
								->join('tbl_cont_configuracioncontable','tbl_cont_configuracioncontable.id','tbl_cont_movimientos_contables.id_configuracion_contable')
								->join('tbl_cont_tipo_documento_contable','tbl_cont_tipo_documento_contable.id','tbl_cont_configuracioncontable.id_tipo_documento_contable')
								->join('tbl_tes_tipo_causacion','tbl_tes_tipo_causacion.id','tbl_tes_causacion.id_tipo_causacion')
								->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_tes_causacion.id_estado')
									->select(
										'tbl_tes_causacion.id',
										'tbl_tes_causacion.id_tienda',
										'tbl_tes_causacion.id_estado',	
										'tbl_sys_estado_tema.nombre AS estado',	
										'tbl_tes_causacion.id_tipo_causacion',
										'tbl_tes_causacion.valor',
										'tbl_tes_causacion.comprobante_contable',
										'tbl_tes_causacion.fecha_creado',
										'tbl_tienda.nombre',
										'tbl_tienda.monto_max',
										'tbl_cont_tipo_documento_contable.nombre AS tipo_documento_contable',
										'tbl_cont_tipo_documento_contable.id AS id_tipo_documento_contable',
										'tbl_cont_configuracioncontable.id AS id_configuracion',
										'tbl_cont_configuracioncontable.nombre AS configuracion',
										'tbl_tes_tipo_causacion.nombre AS tipo_causacion',
										'tbl_cont_movimientos_contables.id_cierre AS id_cierre_realizado',
										'tbl_cont_movimientos_contables.automatico AS automatico'
									)
									->distinct()									
									->where('tbl_tes_causacion.id',$id)
									->where('tbl_tes_causacion.id_tienda',$idTienda)
									->where('causacion',1)
									->first();
	}

	public static function Pay($id,$idTienda,$id_usuario)
	{
		$result="Actualizado";
		try{
			\DB::beginTransaction();
			ModelCausacion::where('id',$id)->where('id_tienda',$idTienda)
			->update(['id_estado'=>101,
			'fecha_actualizado'=>date('Y-m-d H:i:s'),
			'id_usuario_actualizacion'=>$id_usuario]);
			\DB::commit();
		}catch(\Exception $e)
		{	
			$result = 'Error';
			\DB::rollback();
		}
		
		return $result;
	}

	public static function anularpagos($id,$idTienda,$id_usuario)
	{
		$result="Actualizado";
		try{
			\DB::beginTransaction();
			ModelCausacion::where('id',$id)
			->where('id_tienda',$idTienda)
			->update(['id_estado'=>100,
							'fecha_actualizado'=>date('Y-m-d H:i:s'),
							'id_usuario_actualizacion'=>$id_usuario]);
			\DB::commit();
		}catch(\Exception $e)
		{	
			$result = 'Error';
			\DB::rollback();
		}
		
		return $result;
	}

	public static function AnularCausacion($id,$idTienda,$id_usuario)
	{
		$result="Actualizado";
		try{
			\DB::beginTransaction();
			ModelCausacion::where('id',$id)
			->where('id_tienda',$idTienda)
			->update(['id_estado'=>102,
							'fecha_actualizado'=>date('Y-m-d H:i:s'),
							'id_usuario_actualizacion'=>$id_usuario]);
			\DB::commit();
		}catch(\Exception $e)
		{	
			$result = 'Error';
			\DB::rollback();
		}
		
		return $result;
	}

	public static function Transfer($id,$idTienda)
	{
		$result="Actualizado";
		try{
			\DB::beginTransaction();
			ModelCausacion::where('id',$id)->where('id_tienda',$idTienda)->update(['id_estado'=>109]);
			\DB::commit();
		}catch(\Exception $e)
		{	
			$result = 'Error';
			\DB::rollback();
		}
		return $result;
	}
	
	public static function Create($datosCausacion,$datosProductos,$impuestos){
		$result="Insertado";
		try{
			DB::beginTransaction();
			DB::table('tbl_tes_causacion')->insert($datosCausacion);
			/*Inserta Productos*/
			for ($i=0; $i < count($datosProductos['id']) ; $i++) 
			{ 
				DB::table('tbl_tes_causacion_productos')
				->insert([
						'id'=>$datosProductos['id'][$i],
						'id_tienda' => $datosProductos['id_tienda'][$i],
						'id_causacion' => $datosProductos['id_causacion'][$i],
						'id_concepto' => $datosProductos['id_concepto'][$i],
						'descripcion' => $datosProductos['descripcion'][$i],
						'valor_bruto' => $datosProductos['valor_bruto'][$i],
						'valor_neto' => $datosProductos['valor_neto'][$i],
					]);				 
			}
			/*Inserta Impuestos*/
			for ($i=0; $i < count($impuestos['id']) ; $i++) 
			{ 
				DB::table('tbl_tes_causacion_productos_impuesto')
				->insert([
						'id'=>$impuestos['id'][$i],
						'id_tienda' => $impuestos['id_tienda'][$i],
						'id_producto' => $impuestos['id_producto'][$i],
						'id_impuesto' => $impuestos['id_impuesto'][$i],
						'porcentaje' => $impuestos['porcentaje'][$i],
						'valor_impuesto' => $impuestos['valor_impuesto'][$i]
					]);				 
			}
			DB::commit();
		}catch(\Exception $e){
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
			DB::rollback();
			dd($e);
		}
		return $result;
	}

	public static function ImpuestosCausaciones($impuestos)
	{
		\DB::table('tbl_sys_Causacion_impuesto')
		->where('id_Causacion',$id_Causacion)
		->delete();

		if($asociaciones[0]!='Objetovacio')
		{	
		for ($i=0; $i < count($asociaciones) ; $i++) { 
			$asociados[$i]['id_Causacion'] = $id_Causacion;
			$asociados[$i]['id_impuesto'] = $asociaciones[$i];
		}
		DB::table('tbl_sys_Causacion_impuesto')->insert($asociados);
		}
	}

	public static function getCausacion(){
		return ModelCausacion::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectListImpuesto(){
		return ModelCausacion::select('id','nombre AS name')->where('estado','1')->where('impuesto','1')->get();
	}

	public static function ImpuestoCausacion($id_Causacion){
		
		return DB::table('tbl_sys_Causacion_impuesto')
							->select(
									'id_impuesto AS id_asociar',
									'id_Causacion'
									)
							->where('id_Causacion',$id_Causacion)
						    ->get();
	}

	public static function ActualizarImpuestoCausacion($id_Causacion,$asociaciones,$dataSaved)
    {
		$result="Actualizado";		
		try{
			\DB::beginTransaction();
			ModelCausacion::where('id',$id_Causacion)->update($dataSaved);
			\DB::table('tbl_sys_Causacion_impuesto')->where('id_Causacion',$id_Causacion)->delete();	
			self::CreateAsociaciones($id_Causacion,$asociaciones);
			\DB::commit();
		}catch(\Exception $e)
		{	
			dd($e);
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
			\DB::rollback();
		}
		
		return $result;
	}

	public static function getSelectListCodigo($id){
		return ModelConcepto::select('id','codigo AS name')
		->where('estado','1')
		->where('naturaleza',$id)
		->where('impuesto',0)
		->get();
	}

	public static function getSelectListNombre($id){
		return ModelConcepto::select('id','nombre AS name')
		->where('estado','1')
		->where('naturaleza',$id)
		->where('impuesto',0)
		->get();
	}

	public static function getImpuestosByPais()
	{
		return \DB::table('tbl_tes_concepto')
		->join('tbl_parametro_general','tbl_tes_concepto.id_pais','tbl_parametro_general.id_pais')
		->select('tbl_tes_concepto.id',
				'tbl_tes_concepto.nombre'	
				)
		->where('tbl_tes_concepto.impuesto',1)
		->get();
	}
	
	public static function getSelectListTipoCausacion()
	{
		return \DB::table('tbl_tes_tipo_causacion')
		->select('id',
				'nombre AS name'	
				)
		->get();
	}

	public static function CreateSalario($datosCausacion,$datosSalarios)
	{
		$result = true;
		try
		{
			\DB::beginTransaction();
				\DB::table('tbl_tes_causacion')->insert($datosCausacion);
				\DB::table('tbl_tes_pago_nomina')->insert($datosSalarios);
			\DB::commit();
		}
		catch(\Exception $e)
		{
			dd($e);
			$result = false;
			\DB::rollback();			
		}
		return $result;
	}

	public static function getPagoNomina($id,$idTienda)
	{
		try
		{
			return \DB::table('tbl_tes_pago_nomina')
			->join('tbl_tes_causacion', function ($join) {
				$join->on('tbl_tes_causacion.id','tbl_tes_pago_nomina.id_causacion');
				$join->on('tbl_tes_causacion.id_tienda','tbl_tes_pago_nomina.id_tienda_causacion');
			})
			->join('tbl_plan_unico_cuenta','tbl_plan_unico_cuenta.cuenta','tbl_tes_pago_nomina.concepto_pago')
			->join('tbl_cont_movimientos_contables', function ($join) {
				$join->on('tbl_cont_movimientos_contables.codigo_movimiento','tbl_tes_causacion.comprobante_contable');
				$join->on('tbl_cont_movimientos_contables.cuenta','tbl_tes_pago_nomina.concepto_pago');
			})

			->join('tbl_cont_movimientos_configuracioncontable', function ($join) {
				$join->on('tbl_cont_movimientos_configuracioncontable.id_configuracioncontable','tbl_cont_movimientos_contables.id_configuracion_contable');
				$join->on('tbl_cont_movimientos_configuracioncontable.id_cod_puc','tbl_plan_unico_cuenta.id');
			})

			->join('tbl_cliente', function ($join) {
				$join->on('tbl_cliente.codigo_cliente','tbl_tes_pago_nomina.id_empleado');
				$join->on('tbl_cliente.id_tienda','tbl_tes_pago_nomina.id_tienda_empleado');
			})
			->select(
				'tbl_tes_pago_nomina.id_empleado',
				'tbl_tes_pago_nomina.id_tienda_empleado',
				DB::raw('concat(tbl_tes_pago_nomina.id_empleado,tbl_tes_pago_nomina.id_tienda_empleado,tbl_cont_movimientos_configuracioncontable.id) AS consecutivo'),
				'tbl_cliente.numero_documento',
				DB::raw('CONCAT_WS(" ",tbl_cliente.nombres,tbl_cliente.primer_apellido,tbl_cliente.segundo_apellido) AS nombrecompleto'),
				'tbl_cont_movimientos_configuracioncontable.descripcion',
				'tbl_cont_movimientos_configuracioncontable.naturaleza',
				'tbl_tes_pago_nomina.concepto_pago',
				'tbl_tes_pago_nomina.descripcion_pago',
				'tbl_tes_pago_nomina.valor'
			)
			->distinct()
			->where('tbl_tes_causacion.id',$id)
			->where('tbl_tes_causacion.id_tienda',$idTienda)
			->get();
		}catch(\Exception $e)
		{
			dd($e);
			return false;
		}
	}

	public static function SolicitarAnulacion($id,$idTienda,$estado)
	{
		$result = true;
		$result="Actualizado";
		try{
			\DB::beginTransaction();
				ModelCausacion::where('id',$id)->where('id_tienda',$idTienda)->update(['id_estado'=>$estado]);
			\DB::commit();
		}catch(\Exception $e)
		{	
			$result = 'Error';
			\DB::rollback();
		}
		return $result;
	}

	public static function getPago($id_comprobante)
	{
		return \DB::table('tbl_cont_movimientos_contables')
							->select('id_configuracion_contable')
							->where('codigo_movimiento',$id_comprobante)
							->orderby('id_movimiento','desc')
							->first();
	}
	
}
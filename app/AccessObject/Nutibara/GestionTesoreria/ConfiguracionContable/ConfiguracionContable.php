<?php 

namespace App\AccessObject\Nutibara\GestionTesoreria\ConfiguracionContable;

use App\Models\Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContable AS ModelConfiguracionContable;
use App\Models\Nutibara\GestionTesoreria\Concepto\Concepto AS ModelConcepto;
use DB;

class ConfiguracionContable 
{
	public static function ConfiguracionContableWhere($start,$end,$colum, $order,$search)
	{
		return ModelConfiguracionContable::join('tbl_cont_tipo_documento_contable','tbl_cont_tipo_documento_contable.id','tbl_cont_configuracioncontable.id_tipo_documento_contable')
									->select(
										'tbl_cont_configuracioncontable.id AS DT_RowId',
										'tbl_cont_tipo_documento_contable.nombre AS tipodocumentocontable',
										'tbl_cont_configuracioncontable.nombre',		
										\DB::raw("CASE WHEN tbl_cont_configuracioncontable.nombreproducto = '' THEN 'NO TIENE PRODUCTO' WHEN tbl_cont_configuracioncontable.nombreproducto IS NULL THEN 'NO TIENE PRODUCTO' ELSE tbl_cont_configuracioncontable.nombreproducto END AS nombreproducto"),						
										\DB::raw("CASE WHEN es_borrable = '0' THEN 'NO ES POSIBLE ELIMINAR' WHEN es_borrable = '1' THEN 'ES POSIBLE ELIMINAR' END AS es_borrable")			
										)
									->where(function ($query) use ($search){
										if($search['id_tipo_documento_contable'] <> "")
											$query->where('id_tipo_documento_contable', '=',$search['id_tipo_documento_contable']);
										if($search['nombre'] <> "")
											$query->where('tbl_cont_configuracioncontable.nombre', 'like', "%".$search['nombre']."%");
										if($search['nombreproducto'] == "NO TIENE PRODUCTO")
											$query->whereNull('nombreproducto');
										else if($search['nombreproducto'] <> "")
											$query->where('nombreproducto', 'like', "%".$search['nombreproducto']."%");
									})
									->skip($start)->take($end)
									->orderBy('tipodocumentocontable', $order)
									->orderBy('nombre','asc')
									->get();
	}

	public static function getCountConfiguracionContable($search){
		return ModelConfiguracionContable::where(function ($query) use ($search){
											if($search['id_tipo_documento_contable'] <> "")
												$query->where('id_tipo_documento_contable', '=',$search['id_tipo_documento_contable']);	
											if($search['nombre'] <> "")																				
												$query->where('tbl_cont_configuracioncontable.nombre', 'like', "%".$search['nombre']."%");
											if($search['nombreproducto'] == "NO TIENE PRODUCTO")
												$query->whereNull('nombreproducto');
											else if($search['nombreproducto'] <> "")
												$query->where('nombreproducto', 'like', "%".$search['nombreproducto']."%");
										})
										->count();
	}

	public static function getConfiguracionContableById($id){
		return ModelConfiguracionContable::join('tbl_cont_tipo_documento_contable','tbl_cont_tipo_documento_contable.id','tbl_cont_configuracioncontable.id_tipo_documento_contable')
		->join('tbl_tes_subclases_cierre_caja','tbl_tes_subclases_cierre_caja.id_subclases','tbl_cont_configuracioncontable.id_subclase')
		->leftjoin('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_cont_configuracioncontable.id_categoria')
		->select(
			'tbl_cont_configuracioncontable.id',
			'tbl_cont_tipo_documento_contable.id AS id_tipo_documento_contable',
			'tbl_cont_tipo_documento_contable.nombre AS tipo_documento_contable',
			'tbl_cont_configuracioncontable.nombre',
			'tbl_cont_configuracioncontable.atributos',																								
			'tbl_cont_configuracioncontable.nombreproducto',
			'tbl_cont_configuracioncontable.es_borrable',
			'tbl_cont_configuracioncontable.id_subclase',		
			'tbl_cont_configuracioncontable.id_categoria',		
			'tbl_tes_subclases_cierre_caja.id_clases',
			'tbl_prod_categoria_general.nombre AS categoria'	
			)
		->where('tbl_cont_configuracioncontable.id',$id)
		->first();
	}

	public static function getMovimientosConfiguracionContableById($id)
	{
		return DB::table('tbl_cont_movimientos_configuracioncontable')
		->join('tbl_plan_unico_cuenta','tbl_plan_unico_cuenta.id','tbl_cont_movimientos_configuracioncontable.id_cod_puc')
		->select(
			'tbl_cont_movimientos_configuracioncontable.id',
			'tbl_plan_unico_cuenta.naturaleza AS id_naturaleza',
			\DB::raw("CASE WHEN tbl_plan_unico_cuenta.naturaleza = '0' THEN 'Crédito' ELSE 'Débito' END AS naturaleza"),			
			\DB::raw('concat(tbl_plan_unico_cuenta.cuenta," - ",tbl_plan_unico_cuenta.nombre) AS nom_puc'),
			'tbl_plan_unico_cuenta.id AS idpuc',
			'tbl_cont_movimientos_configuracioncontable.descripcion',																								
			'tbl_cont_movimientos_configuracioncontable.orden',
			'tbl_cont_movimientos_configuracioncontable.tienetercero',
			'tbl_cont_movimientos_configuracioncontable.id_cliente',
			'tbl_cont_movimientos_configuracioncontable.id_tienda',
			'tbl_cont_movimientos_configuracioncontable.nombre_cliente'
		)
		->where('tbl_cont_movimientos_configuracioncontable.id_configuracioncontable',$id)
		->get();
	}

	public static function getImpuestosConfiguracionContableById($id)
	{
		return DB::table('tbl_cont_configuracioncontable_impuestos')
		->join('tbl_plan_unico_cuenta','tbl_plan_unico_cuenta.id','tbl_cont_configuracioncontable_impuestos.id_cod_puc')
		->select(
			'tbl_cont_configuracioncontable_impuestos.id',
			'tbl_cont_configuracioncontable_impuestos.naturaleza AS id_naturaleza',			
			\DB::raw("CASE WHEN tbl_cont_configuracioncontable_impuestos.naturaleza = '0' THEN 'Crédito' ELSE 'Débito' END AS naturaleza"),			
			'tbl_cont_configuracioncontable_impuestos.descripcion AS nombre_impuesto',
			\DB::raw('concat(tbl_plan_unico_cuenta.cuenta," ",tbl_plan_unico_cuenta.nombre) AS nom_puc'),
			'tbl_plan_unico_cuenta.id AS idpuc',					
			'tbl_plan_unico_cuenta.porcentaje'	
		)
		->where('tbl_cont_configuracioncontable_impuestos.id_configuracioncontable',$id)
		->get();
	}
	
	public static function Delete($id)
	{
		$result= true;
		try
		{
			DB::beginTransaction();
			DB::table('tbl_cont_configuracioncontable')->where('id',$id)->delete();
			DB::table('tbl_cont_movimientos_configuracioncontable')->where('id_configuracioncontable',$id)->delete();
			DB::table('tbl_cont_configuracioncontable_impuestos')->where('id_configuracioncontable',$id)->delete();
			DB::commit();
		}
		catch(\Exception $e )
		{
			DB::rollback();			
			$result=false;
		}
		return $result;
	}
    
    public static function getPUC($busqueda)
    {
        try
        {
        return DB::table('tbl_plan_unico_cuenta')
            ->select('id AS codigo',
                    'cuenta',
                    'nombre',
					'naturaleza')
			->where('tipo_impuesto',0)
            ->whereRaw('concat_ws(" ",tbl_plan_unico_cuenta.cuenta,tbl_plan_unico_cuenta.nombre) like "%'.$busqueda.'%"')
            ->get();
        }
        catch(\Exception $e)
        {
			
            dd($e);
        }
	}

	public static function getPUCImp($busqueda)
    {
        try
        {
        return DB::table('tbl_plan_unico_cuenta')
            ->select('id AS codigo',
                    'cuenta',
                    'nombre',
					'naturaleza',
					'porcentaje')
			->where('tipo_impuesto',1)					
            ->whereRaw('concat_ws(" ",tbl_plan_unico_cuenta.cuenta,tbl_plan_unico_cuenta.nombre) like "%'.$busqueda.'%"')
            ->get();
        }
        catch(\Exception $e)
        {
			
            dd($e);
        }
	}

	public static function getProveedores($busqueda)
    {
        try
        {
        return DB::table('tbl_cliente')
			->select('codigo_cliente AS codigo',
					'id_tienda',
					\DB::raw('concat_ws(" ",concat_ws("-",tbl_cliente.numero_documento,tbl_cliente.digito_verificacion),concat_ws(" ",tbl_cliente.nombres,tbl_cliente.primer_apellido,tbl_cliente.segundo_apellido)) AS nombre'))					
			->whereIn('id_tipo_cliente',[5,6])
            ->whereRaw('concat_ws(" ",concat_ws("-",tbl_cliente.numero_documento,tbl_cliente.digito_verificacion),concat_ws(" ",tbl_cliente.nombres,tbl_cliente.primer_apellido,tbl_cliente.segundo_apellido)) like "%'.$busqueda.'%"')
            ->get();
        }
        catch(\Exception $e)
        {
            dd($e);
        }
	}

	public static function insertar($busqueda)
    {
        try
        {
        return DB::table('tbl_plan_unico_cuenta')
            ->select('id AS codigo',
                    'cuenta',
                    'nombre',
                    'naturaleza')
            ->whereRaw('concat_ws(" ",tbl_plan_unico_cuenta.cuenta,tbl_plan_unico_cuenta.nombre) like "%'.$busqueda.'%"')
            ->get();
        }
        catch(\Exception $e)
        {
            dd($e);
        }
	}

	public static function Create($datosGenerales,$movimientos,$impuestos)
	{
		$result="Insertado";
		try{
			DB::beginTransaction();
			$idconfiguracion = self::guardarConfiguracionContable($datosGenerales);
			self::guardarMovimientos($idconfiguracion,$movimientos,$datosGenerales);
			self::guardarImpuestos($idconfiguracion,$impuestos);
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
		}
		return $result;
	}

	public static function Update($id,$datosGenerales,$movimientos,$impuestos){
		$result="Actualizado";
		try
		{
			DB::beginTransaction();
			self::actualizarConfiguracionContable($id,$datosGenerales);
			self::actualizarMovimientos($id,$movimientos);
			self::actualizarImpuestos($id,$impuestos);
			DB::commit();
		}
		catch(\Exception $e)
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
		}
		return $result;
	}

	private static function actualizarConfiguracionContable($id, $datosGenerales)
	{
		if($datosGenerales['es_borrable'] == 0)
		{
			return DB::table('tbl_cont_configuracioncontable')->where('id',$id)->update(['nombre' => $datosGenerales['nombre']]);
		}
		else
		{
			return DB::table('tbl_cont_configuracioncontable')->where('id',$id)->update($datosGenerales);			
		}
	}

	private static function actualizarMovimientos($idconfiguracion,$movimientos)
	{
		$contnuevo = 0;
		$contactulizar = 0;
		for ($i=0; $i < count($movimientos['cod_puc']); $i++) 
		{ 
			if($movimientos['id'][$i] == null)
			{
				$movimientocontablenuevo[$contnuevo]['id_configuracioncontable'] = $idconfiguracion;
				$movimientocontablenuevo[$contnuevo]['naturaleza'] = $movimientos['id_naturaleza'][$i];
				$movimientocontablenuevo[$contnuevo]['id_cod_puc'] = $movimientos['cod_puc'][$i];
				$movimientocontablenuevo[$contnuevo]['descripcion'] = $movimientos['descripcion'][$i];
				$movimientocontablenuevo[$contnuevo]['tienetercero'] = ($movimientos['id_cliente'][$i] ==null ? 0 : 1);
				$movimientocontablenuevo[$contnuevo]['nombre_cliente'] = $movimientos['nombre_cliente'][$i];
				$movimientocontablenuevo[$contnuevo]['id_cliente'] = $movimientos['id_cliente'][$i];
				$movimientocontablenuevo[$contnuevo]['id_tienda'] = $movimientos['id_tienda'][$i];
				$contnuevo++;
			}
			else
			{
				$idactualizar[$contactulizar] = $movimientos['id'][$i];
				$movimientocontableactualizar[$contactulizar]['id_configuracioncontable'] = $idconfiguracion;
				$movimientocontableactualizar[$contactulizar]['naturaleza'] = $movimientos['id_naturaleza'][$i];
				$movimientocontableactualizar[$contactulizar]['id_cod_puc'] = $movimientos['cod_puc'][$i];
				$movimientocontableactualizar[$contactulizar]['descripcion'] = $movimientos['descripcion'][$i];
				$movimientocontableactualizar[$contactulizar]['tienetercero'] = ($movimientos['id_cliente'][$i] ==null ? 0 : 1);
				$movimientocontableactualizar[$contactulizar]['nombre_cliente'] = $movimientos['nombre_cliente'][$i];
				$movimientocontableactualizar[$contactulizar]['id_cliente'] = $movimientos['id_cliente'][$i];
				$movimientocontableactualizar[$contactulizar]['id_tienda'] = $movimientos['id_tienda'][$i];
				$contactulizar++;
			}	
		}

		/* Borrar Movimientos */
		DB::table('tbl_cont_movimientos_configuracioncontable')
		->where('id_configuracioncontable',$idconfiguracion)
		->whereNotIn('id',$idactualizar)
		->delete();
		/* Crea los nuevos movimientos*/
		if(isset($movimientocontablenuevo))		
		DB::table('tbl_cont_movimientos_configuracioncontable')->insert($movimientocontablenuevo);
		/*Actualziar los movimientos*/		
		for ($i=0; $i < count($idactualizar) ; $i++) 
		{ 
			DB::table('tbl_cont_movimientos_configuracioncontable')
			->where('id',$idactualizar[$i])
			->where('id_configuracioncontable',$idconfiguracion)
			->update($movimientocontableactualizar[$i]);	
		}
	}

	private static function actualizarImpuestos($idconfiguracion,$impuestos)
	{
		if(count($impuestos['id_cod_puc']) > 1)
		{
			$contnuevo = 0;
			$contactulizar = 0;
			for ($i=0; $i < count($impuestos['id_cod_puc']); $i++) 
			{
				if($impuestos['id'][$i] == null)
				{
					$impuestos_insert[$contnuevo]['id_configuracioncontable'] = $idconfiguracion;
					$impuestos_insert[$contnuevo]['id_cod_puc'] = $impuestos['id_cod_puc'][$i];
					$impuestos_insert[$contnuevo]['descripcion'] = $impuestos['descripcion'][$i];
					$impuestos_insert[$contnuevo]['naturaleza'] = $impuestos['naturaleza'][$i];
					$impuestos_insert[$contnuevo]['porcentaje'] = $impuestos['porcentaje'][$i];
					$contnuevo++;
				}
				else
				{
					$idactualizarimpuesto[$contactulizar] = $impuestos['id'][$i];
					$impuestos_update[$contactulizar]['id_configuracioncontable'] = $idconfiguracion;
					$impuestos_update[$contactulizar]['id_cod_puc'] = $impuestos['id_cod_puc'][$i];
					$impuestos_update[$contactulizar]['descripcion'] = $impuestos['descripcion'][$i];
					$impuestos_update[$contactulizar]['naturaleza'] = $impuestos['naturaleza'][$i];
					$impuestos_update[$contactulizar]['porcentaje'] = $impuestos['porcentaje'][$i];
					$contactulizar++;
				}
			}
		}
		elseif (count($impuestos['id_cod_puc']) == 1) 
		{
			if($impuestos['id'][0] == null)
			{
				$impuestos_insert['id_configuracioncontable'] = $idconfiguracion;
				$impuestos_insert['id_cod_puc'] = $impuestos['id_cod_puc'][0];
				$impuestos_insert['descripcion'] = $impuestos['descripcion'][0];
				$impuestos_insert['naturaleza'] = $impuestos['naturaleza'][0];
				$impuestos_insert['porcentaje'] = $impuestos['porcentaje'][0];
			}
			else
			{
				$idactualizarimpuesto[0] = $impuestos['id'][0];
				$impuestos_update['id_configuracioncontable'] = $idconfiguracion;
				$impuestos_update['id_cod_puc'] = $impuestos['id_cod_puc'][0];
				$impuestos_update['descripcion'] = $impuestos['descripcion'][0];
				$impuestos_update['naturaleza'] = $impuestos['naturaleza'][0];
				$impuestos_update['porcentaje'] = $impuestos['porcentaje'][0];
			}
		}
		if(isset($idactualizarimpuesto))
		{
			/*Borrar Impuestos*/
			DB::table('tbl_cont_configuracioncontable_impuestos')
			->where('id_configuracioncontable',$idconfiguracion)
			->whereNotIn('id',$idactualizarimpuesto)
			->delete();
		}
		else
		{
			/*Borrar Impuestos*/
			DB::table('tbl_cont_configuracioncontable_impuestos')
			->where('id_configuracioncontable',$idconfiguracion)
			->delete();
		}
		/*Crea Nuevos Impuestos*/
		if(isset($impuestos_insert))
		DB::table('tbl_cont_configuracioncontable_impuestos')->insert($impuestos_insert);
		/*Actualiza los Impuestos*/
		if(count($impuestos['id_cod_puc']) > 1 && isset($impuestos_update))
		{
			/* SI existe mas de un impuesto, y hay impuestos para actualizar... */
			for ($i=0; $i < count($idactualizarimpuesto) ; $i++) 
			{ 
				DB::table('tbl_cont_configuracioncontable_impuestos')
				->where('id',$idactualizarimpuesto[$i])
				->where('id_configuracioncontable',$idconfiguracion)
				->update($impuestos_update[$i]);
			}
		}
		elseif(count($impuestos['id_cod_puc']) == 1 && isset($impuestos_update))
		{
			/* si existe  un impuesto, y hay impuestos para actualizar... */			
			DB::table('tbl_cont_configuracioncontable_impuestos')
			->where('id',$idactualizarimpuesto)
			->where('id_configuracioncontable',$idconfiguracion)
			->update($impuestos_update);
		}
	}
	
	private static function guardarConfiguracionContable($datosGenerales)
	{
		if(!is_null($datosGenerales))
		{
			return DB::table('tbl_cont_configuracioncontable')->insertGetId($datosGenerales);
		}
	}

	private static function guardarMovimientos($idconfiguracion,$movimientos,$datosGenerales)
	{
		$causacion = 0;
		if($datosGenerales['id_tipo_documento_contable'] == 16)
		$causacion = 1;

		for ($i=0; $i < count($movimientos['cod_puc']); $i++) 
		{ 
			$movimientocontable[$i]['id_configuracioncontable'] = $idconfiguracion;
			$movimientocontable[$i]['naturaleza'] = $movimientos['id_naturaleza'][$i];
			$movimientocontable[$i]['id_cod_puc'] = $movimientos['cod_puc'][$i];
			$movimientocontable[$i]['descripcion'] = $movimientos['descripcion'][$i];
			$movimientocontable[$i]['causacion'] = $causacion;
			$movimientocontable[$i]['orden'] = $i;
			$movimientocontable[$i]['tienetercero'] = ($movimientos['id_cliente'][$i] ==null ? 0  : 1);
			$movimientocontable[$i]['nombre_cliente'] = $movimientos['nombre_cliente'][$i];
			$movimientocontable[$i]['id_cliente'] = $movimientos['id_cliente'][$i];
			$movimientocontable[$i]['id_tienda'] = $movimientos['id_tienda'][$i];
			$causacion=0;
		}
		DB::table('tbl_cont_movimientos_configuracioncontable')->insert($movimientocontable);
	}

	private static function guardarImpuestos($idconfiguracion,$impuestos)
	{
		if(count($impuestos['id_cod_puc']) > 1)
		{
			for ($i=0; $i < count($impuestos['id_cod_puc']); $i++) 
			{
				$impuestos_insert[$i]['id_configuracioncontable'] = $idconfiguracion;
				$impuestos_insert[$i]['id_cod_puc'] = $impuestos['id_cod_puc'][$i];
				$impuestos_insert[$i]['descripcion'] = $impuestos['descripcion'][$i];
				$impuestos_insert[$i]['naturaleza'] = $impuestos['naturaleza'][$i];
				$impuestos_insert[$i]['porcentaje'] = $impuestos['porcentaje'][$i];
			}
		}
		elseif (count($impuestos['id_cod_puc']) == 1) 
		{
			$impuestos_insert['id_configuracioncontable'] = $idconfiguracion;
			$impuestos_insert['id_cod_puc'] = $impuestos['id_cod_puc'][0];
			$impuestos_insert['descripcion'] = $impuestos['descripcion'][0];
			$impuestos_insert['naturaleza'] = $impuestos['naturaleza'][0];
			$impuestos_insert['porcentaje'] = $impuestos['porcentaje'][0];
		}
		
		if(isset($impuestos_insert))		
		DB::table('tbl_cont_configuracioncontable_impuestos')->insert($impuestos_insert);
	}

	public static function getSelectListClase(){
		return DB::table('tbl_tes_clases_cierre_caja')
		->select(
				'id_clases AS id',
				DB::raw('UPPER(nombre) AS name')
				)
		->orderBy('nombre')
		->get();
	}

	public static function getSelectListSubClase(){
		return DB::table('tbl_tes_subclases_cierre_caja')
		->select(
				'id_subclases AS id',
				DB::raw('UPPER(nombre) AS name')
				)
		->orderBy('nombre')
		->get();
	}

	public static function getSelectListSubclaseByClase($id){
		return DB::table('tbl_tes_subclases_cierre_caja')
		->select(
				'id_subclases AS id',
				DB::raw('UPPER(nombre) AS name')
				)
		->where('id_clases', $id)
		->where('mostrar',1)
		->orderBy('nombre')
		->get();
	}
	
	public static function getSelectListClaseBySubclase($id){
		return DB::table('tbl_tes_subclases_cierre_caja')
		->join('tbl_tes_subclases_cierre_caja')
		->select(
				'id_subclases AS id',
				DB::raw('UPPER(nombre) AS name')
				)
		->where('id_clases', $id)
		->orderBy('nombre')
		->get();
	}

	public static function ValidarBorrable($id)
	{
		return ModelConfiguracionContable::select(
												'es_borrable'
												)
		->where('id',$id)
		->first();
	}

	public static function ValidarRepetido($producto, $id_tipo_documento_contable,$id_sub_clase,$id_categoria)
	{
		/* Si el producto esta vacio que me diga si el Documento ( sin producto)  ya fue creado.*/
			return ModelConfiguracionContable::select('id')
			->where('id_tipo_documento_contable', $id_tipo_documento_contable)
			->where('id_subclase', $id_sub_clase)
			->where('id_categoria', $id_categoria)
			->where('atributos', $producto)
			->get();
	}


	public static function getSelectListTipoDocumentoContable(){
		return DB::table('tbl_cont_tipo_documento_contable')
		->join('tbl_cont_configuracioncontable','tbl_cont_configuracioncontable.id_tipo_documento_contable','tbl_cont_tipo_documento_contable.id')
		->join('tbl_cont_movimientos_configuracioncontable','tbl_cont_movimientos_configuracioncontable.id_configuracioncontable','tbl_cont_configuracioncontable.id')
		->select(
				'tbl_cont_tipo_documento_contable.id',
				DB::raw('UPPER(tbl_cont_tipo_documento_contable.nombre) AS name')
				)
		->distinct()
		->where('causacion',1)
		->orderBy('tbl_cont_tipo_documento_contable.nombre')
		->get();
	}

	public static function selectlistByIdTipoDocumento($id){
		return DB::table('tbl_cont_configuracioncontable')
		->join('tbl_cont_movimientos_configuracioncontable','tbl_cont_movimientos_configuracioncontable.id_configuracioncontable','tbl_cont_configuracioncontable.id')
		->select(
				'tbl_cont_configuracioncontable.id',
				DB::raw('UPPER(nombre) AS name')
				)
		->where('id_tipo_documento_contable',$id)
		->where('causacion',1)
		->orderBy('nombre')
		->get();
	}

	public static function selectlistMovimientosContablesById($id){
		return DB::table('tbl_cont_movimientos_configuracioncontable')
		->join('tbl_plan_unico_cuenta','tbl_plan_unico_cuenta.id','tbl_cont_movimientos_configuracioncontable.id_cod_puc')		
		->select(
				'tbl_cont_movimientos_configuracioncontable.id',
				DB::raw('UPPER(descripcion) AS nombre'),
				'cuenta',
				'tbl_cont_movimientos_configuracioncontable.naturaleza'
				)
		->where('id_configuracioncontable',$id)
		->where('causacion',0)
		->orderBy('descripcion')
		->get();
	}

	public static function getcxc($id){
		return DB::table('tbl_cont_movimientos_configuracioncontable')
		->select('id')
		->where('id_configuracioncontable',$id)
		->where('causacion',1)
		->first();
	}

	public static function getImpuestosXConfiguracion($id){
		return DB::table('tbl_cont_configuracioncontable_impuestos')
		->join('tbl_plan_unico_cuenta','tbl_plan_unico_cuenta.id','tbl_cont_configuracioncontable_impuestos.id_cod_puc')
		->select('tbl_cont_configuracioncontable_impuestos.id',
					  'tbl_cont_configuracioncontable_impuestos.descripcion',
					  'tbl_cont_configuracioncontable_impuestos.naturaleza',
					  'tbl_cont_configuracioncontable_impuestos.porcentaje',
					  'tbl_plan_unico_cuenta.cuenta',
					  'tbl_plan_unico_cuenta.nombre',
					  'tbl_plan_unico_cuenta.id_impuesto'
					)
		->where('id_configuracioncontable',$id)
		->get();
	}
	
}
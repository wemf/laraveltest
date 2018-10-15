<?php 

namespace App\AccessObject\Nutibara\GenerarPlan;

use App\Models\Nutibara\GenerarPlan\GenerarPlan AS ModelGenerarPlan;
use App\Models\Nutibara\Clientes\Cliente AS ModelCliente;
use App\Models\Nutibara\Contratos\ContratoCabecera AS ModelContratos;
use App\Models\Nutibara\ConfigContrato\ItemContrato AS ModelItemContratos;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use App\BusinessLogic\Nutibara\GenerarPlan\CrudGenerarPlan;
use Auth;
use DB;

class GenerarPlan 
{
	public static function get(){
		return DB::table('tbl_plan_separe')->join('tbl_cliente',function($join){
													$join->on('tbl_cliente.codigo_cliente','tbl_plan_separe.codigo_cliente')
														 ->on('tbl_cliente.id_tienda','tbl_plan_separe.id_tienda_cliente');
											})
											->join('tbl_tienda','tbl_tienda.id','tbl_plan_separe.id_tienda')
											->join('tbl_plan_abono',function($join){
													$join->on('tbl_plan_abono.codigo_plan_separe','tbl_plan_separe.codigo_plan_separe')
														 ->on('tbl_plan_abono.id_tienda','tbl_plan_separe.id_tienda');
											})
											->leftJoin('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
											->join('tbl_sys_estado_tema','tbl_sys_estado_tema.id','tbl_plan_separe.estado')
											->select(
												DB::Raw('concat(tbl_plan_separe.id_tienda,"/",tbl_plan_separe.codigo_plan_separe) AS DT_RowId'),
												"tbl_plan_separe.codigo_plan_separe",
												"tbl_clie_tipo_documento.nombre_abreviado as tipo_documento",
												DB::Raw("FORMAT(tbl_cliente.numero_documento,0,'de_DE') as numero_documento"),
												DB::Raw("concat(tbl_cliente.nombres,' ',tbl_cliente.primer_apellido) as nombre_completo"),
												"tbl_plan_separe.fecha_creacion",
												"tbl_plan_separe.fecha_limite",
												DB::Raw("FORMAT(monto,2,'de_DE') as valor_plan"),
												// DB::Raw("FORMAT((select sum(saldo_abonado) from tbl_plan_separe ps inner join tbl_cliente on tbl_cliente.codigo_cliente = ps.codigo_cliente and tbl_cliente.id_tienda = ps.id_tienda inner join tbl_tienda on tbl_tienda.id = ps.id_tienda inner join tbl_plan_abono on tbl_plan_abono.codigo_plan_separe = ps.codigo_plan_separe and tbl_plan_abono.id_tienda = ps.id_tienda where ps.codigo_plan_separe = tbl_plan_separe.codigo_plan_separe and ps.id_tienda = tbl_plan_separe.id_tienda),2,'de_DE') as total_abonos"),
												// DB::Raw("FORMAT((select COALESCE(sum(saldo_abonado),0) from tbl_plan_abono where estado in (0,2) and id_tienda = tbl_plan_separe.id_tienda and codigo_plan_separe = tbl_plan_separe.codigo_plan_separe) - (select COALESCE(sum(saldo_abonado),0) from tbl_plan_abono where estado = 1 and id_tienda = tbl_plan_separe.id_tienda and codigo_plan_separe = tbl_plan_separe.codigo_plan_separe),2,'de_DE') AS total_abonos"),
												DB::Raw("FORMAT((SELECT COALESCE(SUM(saldo_abonado), 0) FROM tbl_plan_abono JOIN tbl_plan_separe as ps on tbl_plan_abono.codigo_plan_separe = ps.codigo_plan_separe WHERE tbl_plan_abono.estado IN (0 , 2) AND ps.codigo_cliente = tbl_plan_separe.codigo_cliente AND tbl_plan_abono.codigo_plan_separe = tbl_plan_separe.codigo_plan_separe) - (SELECT COALESCE(SUM(saldo_abonado), 0) FROM tbl_plan_abono JOIN tbl_plan_separe as ps on tbl_plan_abono.codigo_plan_separe = ps.codigo_plan_separe WHERE tbl_plan_abono.estado = 1 AND ps.codigo_cliente = tbl_plan_separe.codigo_cliente AND tbl_plan_abono.codigo_plan_separe = tbl_plan_separe.codigo_plan_separe),(select decimales from tbl_parametro_general limit 1),'de_DE') AS total_abonos"),
												DB::Raw("FORMAT(deuda,(select decimales from tbl_parametro_general limit 1),'de_DE') as saldo_pendiente"),
												"tbl_tienda.nombre as nombre_tienda",
												"tbl_sys_estado_tema.nombre as estado"
											)
											->groupBy('tbl_plan_separe.codigo_cliente')
											->groupBy('tbl_plan_separe.id_tienda')
											->groupBy('tbl_clie_tipo_documento.nombre_abreviado')
											->groupBy('tbl_plan_separe.codigo_plan_separe')
											->groupBy('tbl_tienda.nombre')
											->groupBy('tbl_plan_separe.codigo_plan_separe')
											->groupBy('tbl_cliente.numero_documento')
											->groupBy('tbl_cliente.nombres')
											->groupBy('tbl_cliente.primer_apellido')
											->groupBy('tbl_cliente.segundo_apellido')
											->groupBy('tbl_plan_separe.fecha_creacion')
											->groupBy('tbl_plan_separe.fecha_limite')
											->groupBy('tbl_plan_separe.monto')
											->groupBy('tbl_plan_separe.deuda')
											->groupBy('tbl_sys_estado_tema.nombre');
	}

	public static function GenerarPlan($start,$end,$colum,$order){
		return ModelGenerarPlan::select(
									'codigo_plan_separe AS DT_RowId'
								)
								->get();
	}

	public static function getEstados()
	{
		return DB::table('tbl_sys_estado_tema')->select('id','nombre')->where('id_tema','1')->get();
	}

	public static function getCliente($iden,$id_tipo){	
		return ModelCliente::leftjoin('tbl_clie_genero','tbl_clie_genero.id','tbl_cliente.genero')
							->leftjoin('tbl_ciudad','tbl_ciudad.id','tbl_cliente.id_ciudad_nacimiento')
							->leftjoin('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_cliente.id_regimen_contributivo')
							->leftjoin('tbl_sys_archivo as sa','sa.id','tbl_cliente.id_foto_documento_anterior')
							->leftjoin('tbl_sys_archivo as sas','sas.id','tbl_cliente.id_foto_documento_posterior')
							->select(
									'tbl_cliente.codigo_cliente',
									'tbl_cliente.id_tipo_documento',
									'tbl_cliente.fecha_nacimiento',
									'tbl_cliente.fecha_expedicion',
									'tbl_cliente.nombres',
									'tbl_cliente.primer_apellido',
									'tbl_cliente.segundo_apellido',
									'tbl_cliente.correo_electronico',
									'tbl_cliente.id_confiabilidad',
									'tbl_cliente.foto',
									'tbl_cliente.id_tienda',
									'tbl_clie_genero.nombre as genero',
									'tbl_cliente.direccion_residencia',
									'tbl_cliente.telefono_residencia',
									'tbl_clie_regimen_contributivo.nombre as regimen',
									'tbl_cliente.telefono_celular',
									'tbl_ciudad.nombre as ciudad_nacimiento',
									'tbl_cliente.id_pais_expedicion',
									'tbl_cliente.id_ciudad_expedicion',
									'tbl_cliente.id_pais_residencia',
									'tbl_cliente.id_ciudad_residencia',
									'sa.nombre as anterior',
									'sas.nombre as posterior',
									'tbl_cliente.genero'
									)
							->where('numero_documento',$iden)
							->where('tbl_cliente.id_tipo_documento',$id_tipo)
							->whereRaw('(tbl_cliente.id_usuario not in ('.Auth::user()->id.') or tbl_cliente.id_usuario is null)')
							->first();		
	}

	public static function getCountGenerarPlan(){
		return ModelGenerarPlan::where('estado', '1')->count();
	}

	public static function getGenerarPlanById($id){
		return ModelGenerarPlan::where('id',$id)->first();
	}

	public static function Create($dataSaved,$codigo_cliente,$id_tienda,$codigo_plan,$id_tienda_cliente,$forma_pago){
		$result = true;
		try{
			DB::begintransaction();
			self::updateCliente($dataSaved['arrayCliente'],$codigo_cliente,$id_tienda_cliente);
			self::updateProductoPlan($dataSaved['arrayUpdate']);
			$mov = self::mov_contables($dataSaved,$forma_pago);
			$dataSaved['arrayPlan']['id_comprobante'] = $mov;
			self::insertPlan($dataSaved['arrayPlan']);
			self::insertProductos($dataSaved['arrayProductos']);
			self::saveabonos($dataSaved['arrayAbono']);
			DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result = false;
			DB::rollback();
		}		
		return $result;
	}

	public static function mov_contables($data,$forma_pago)
	{
		$msms = true;

		$efectivo = ($data['request']['efectivo'] != "") ? $data['request']['efectivo'] : 0;
		$debito = ($data['request']['debito'] != "") ? $data['request']['debito'] : 0;
		$credito = ($data['request']['credito'] != "") ? $data['request']['credito'] : 0;
		$otro = ($data['request']['otro'] != "") ? $data['request']['otro'] : 0;


		if($efectivo > 0){
			$movimiento_contable[0] = env('CUENTA_EFECTIVO');
			$tipo[0] = 'EFECTIVO';
			$comprabante[0] = 0;
			$observaciones[0] = "";
			$valor[0] = CrudGenerarPlan::limpiarVal($efectivo);
		}
		if($debito > 0){
			$movimiento_contable[1] = env('CUENTA_DEBITO');
			$tipo[1] = 'DEBITO';
			$comprabante[1] = $data['request']['comprobante_debito'];
			$observaciones[1] = "";
			$valor[1] = CrudGenerarPlan::limpiarVal($debito);
		}
		if($credito > 0){
			$movimiento_contable[2] = env('CUENTA_CREDITO');
			$tipo[2] = 'CREDITO';
			$comprabante[2] = $data['request']['comprobante_credito'];
			$observaciones[2] = "";
			$valor[2] = CrudGenerarPlan::limpiarVal($credito);
		}
		if($otro > 0){
			$movimiento_contable[3] = env('CUENTA_OTROS');
			$tipo[3] = 'OTROS';
			$comprabante[3] = $data['request']['comprobante_otro'];
			$observaciones[3] = $data['request']['observaciones'];
			$valor[3] = CrudGenerarPlan::limpiarVal($otro);
		}

		$movimiento_contable = array_values($movimiento_contable);	
		$tipo = array_values($tipo);	
		$comprabante = array_values($comprabante);	
		$observaciones = array_values($observaciones);
		$valor = array_values($valor);

		try{
			$msms = MovimientosTesoreria::registrarMovimientosAbono(CrudGenerarPlan::limpiarVal($data['arrayAbono']['saldo_abonado']),$data['arrayPlan']['id_tienda'],$movimiento_contable,null,'PLANS-'.$data['request']['codigo_tienda'].'/'.$data['arrayPlan']['codigo_plan_separe'],$tipo,$comprabante,$observaciones,$valor,env('TEMA_PLAN_SEPARE'),$data['arrayAbono']['codigo_abono'],$data['request']['numero_documento']);
		}catch(\Exception $e){
			dd($e);
			DB::rollback();
			$msms = false;
		}

		return 'PLANS-'.$data['request']['codigo_tienda'].'/'.$data['arrayPlan']['codigo_plan_separe'];

	}

	public static function validarInventario($id,$id_tienda)
	{
		return DB::table('tbl_inventario_producto')->select('id_inventario')->where('id_inventario',$id)->where('id_tienda_inventario',$id_tienda)->first();
	}

	public static function updateProductoPlan($data){
		for($i = 0; $i < count($data); $i++)
		{
			$existe = self::validarInventario($data[$i]['codigo_inventario'],$data[$i]['id_tienda']);
			if(isset($existe->id_inventario)){
				DB::table('tbl_inventario_producto')->where('id_tienda_inventario',$data[$i]['id_tienda'])
														->where('id_inventario',$data[$i]['codigo_inventario'])
														->update([
															'id_estado_producto' => env('BLOQUEO_ESTADO_INV_PLAN'),
															'id_motivo_producto' => env('BLOQUEO_MOTIVO_INV_PLAN')
															]);
			}else{
				DB::table('tbl_inventario_producto')->insert(
																[
																	'id_inventario' => $data[$i]['codigo_inventario'],
																	'id_tienda_inventario' => $data[$i]['id_tienda'],
																	'lote' => date('YmdHis'),
																	'precio_venta' => $data[$i]['precio'],
																	'cantidad' => (int)0,
																	'peso' => $data[$i]['peso'],
																	'id_catalogo_producto' => $data[$i]['id_catalogo_producto'],
																	'fecha_ingreso' => date('Y-m-d H:i:s'),
																	'id_estado_producto' => env('BLOQUEO_ESTADO_INV_PLAN'),
																	'id_motivo_producto' => env('BLOQUEO_MOTIVO_FABRICACION'),
																	'es_nuevo' => (int)1
																]
															);
			}
		}
		return true;
	}

	private static function updateCliente($arrayCliente,$codigo_cliente,$id_tienda){       
		if(!is_null($arrayCliente))
		{
			return DB::table('tbl_cliente')->where('codigo_cliente',$codigo_cliente)->where('id_tienda',$id_tienda)->update($arrayCliente);
		}
		return false;
	}

	private static function insertPlan($arrayPlan){
		return DB::table('tbl_plan_separe')->insert($arrayPlan);
	}
	
	private static function insertProductos($arrayProductos){	
		return DB::table('tbl_plan_inv_producto')->insert($arrayProductos);
	}

	private static function getCategoria($id_catalogo)
	{
		return DB::table('tbl_prod_catalogo')->where('id',$id_catalogo)->select('id_categoria')->first();
	}

	public static function Update($id,$dataSaved){	
		$result="Actualizado";
		try
		{
			ModelGenerarPlan::where('id',$id)->update($dataSaved);	
		}catch(\Exception $e)
		{
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
			DB::rollBack();
		}
		return $result;
	}

	public static function getSelectList(){
		return ModelGenerarPlan::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectListById($table,$filter,$id){
		return DB::table($table)->select('id','nombre AS name')
								->where($filter,$id)
								->where('estado','1')
								->orderBy('nombre','ASC')
								->get();
	}

	public static function getInventarioById($id){
		return DB::table('tbl_inventario_producto')->join('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_inventario_producto.id_catalogo_producto')
													->where('tbl_prod_catalogo.codigo',$id)
													->where('tbl_inventario_producto.id_estado_producto', env('PRODUCTO_DISPONIBLE'))
													->whereIn('tbl_inventario_producto.id_motivo_producto',[29,32])
													->select(
																'tbl_prod_catalogo.nombre',
																'tbl_prod_catalogo.descripcion',
																DB::raw("FORMAT(tbl_inventario_producto.precio_venta,(select decimales from tbl_parametro_general limit 1),'de_DE') as precio"),
																DB::raw("FORMAT(tbl_inventario_producto.peso,2,'de_DE') as peso_estimado"),
																'tbl_inventario_producto.id_inventario'
															)
													->first();	
	}

	public static function buscarReverso($id_tienda,$codigo_plan)
	{
		return DB::table('tbl_plan_abono')->where('codigo_plan_separe',$codigo_plan)
										  ->where('id_tienda',$id_tienda)
										  ->where('estado','2')
										  ->select('codigo_abono','saldo_abonado')
										  ->first();
	}

	public static function getInventarioByIdB2($referencia,$id_tienda,$array_in){
		return DB::table('tbl_inventario_producto')->join('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_inventario_producto.id_catalogo_producto')
													->whereRaw('concat_ws(" ",tbl_prod_catalogo.codigo,tbl_prod_catalogo.descripcion,tbl_prod_catalogo.nombre,tbl_inventario_producto.id_inventario) like "%'.$referencia.'%"')
													->where(['tbl_inventario_producto.id_estado_producto' => '79','tbl_inventario_producto.id_tienda_inventario' =>  $id_tienda])
													->whereIn('tbl_inventario_producto.id_motivo_producto',[29,32])
													->whereNotIn('tbl_inventario_producto.id_inventario',$array_in)
													->select(
																'tbl_prod_catalogo.id',
																'tbl_prod_catalogo.nombre',
																'tbl_prod_catalogo.descripcion',
																DB::raw("FORMAT(tbl_inventario_producto.precio_venta,(select decimales from tbl_parametro_general limit 1),'de_DE') as precio"),
																DB::raw("FORMAT(tbl_inventario_producto.peso,2,'de_DE') as peso"),
																'tbl_inventario_producto.id_inventario'
															)
													->get();	
	}
	
	public static function getInventarioById2($referencia){
		return DB::table('tbl_prod_catalogo')->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_prod_catalogo.id_categoria')
											 ->whereRaw('concat_ws(" ",tbl_prod_catalogo.codigo,tbl_prod_catalogo.descripcion,tbl_prod_catalogo.nombre) like "%'.$referencia.'%"')
											 ->where('se_fabrica','1')
											 ->select(
												 	'tbl_prod_catalogo.id',
													'tbl_prod_catalogo.nombre',
													'tbl_prod_catalogo.descripcion'
											 )
											 ->get();
	}

	public static function getInfoPrecio($id_referencia, $tienda)
	{
		try
		{
			$data_cat = DB::table('tbl_prod_catalogo')
							->join('tbl_prod_referencia', 'tbl_prod_referencia.id_referencia', 'tbl_prod_catalogo.id')
							->select('tbl_prod_referencia.id_valor_atributo', 'tbl_prod_catalogo.id_categoria')
							->where('tbl_prod_catalogo.id', $id_referencia)
							->get();
			$categoria = $data_cat[0]->id_categoria;

			$control_peso = DB::table('tbl_prod_categoria_general')->where('id', $categoria)->value('control_peso_contrato');

			if($control_peso == 1){
				$array_valores = [];
				for ($i=0; $i < count($data_cat); $i++) { 
					array_push($array_valores, $data_cat[$i]->id_valor_atributo);
				}
	
				$id_config_peso = DB::table('tbl_contr_val_venta_atrib')
												->join('tbl_contr_val_venta', 'tbl_contr_val_venta.id', '=', 'tbl_contr_val_venta_atrib.id_config_peso')
												->select(
													'id_config_peso',
													DB::raw("COUNT(id_config_peso) AS cont_id_config_peso"),
													DB::raw("(SELECT COUNT(XD.id_config_peso) FROM tbl_contr_val_venta_atrib AS XD where XD.id_config_peso = tbl_contr_val_venta.id) as cont_id_config_peso_XD")
												)
												->whereIn('id_valor_atrib', $array_valores)
												->where('id_categoria', $categoria)
												// ->where(DB::Raw('COUNT(id_config_peso)'), '>=', count($array_valores))
												->havingRaw('COUNT(id_config_peso) >= (SELECT COUNT(XD.id_config_peso) FROM tbl_contr_val_venta_atrib AS XD where XD.id_config_peso = tbl_contr_val_venta.id)')
												->groupBy('id_config_peso')
												->groupBy('tbl_contr_val_venta.id')
												->orderBy('cont_id_config_peso', 'DESC')
												->first();
				if(isset($id_config_peso->id_config_peso)){
					$id_config_peso_var = $id_config_peso->id_config_peso;
				}else{
					$id_config_peso_var = 0;
				}
	
				$cant_val = DB::table('tbl_contr_val_venta_atrib')->select('id')->where('id_config_peso', $id_config_peso_var)->count();
				$data = DB::table('tbl_tienda')
							->join('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_tienda.id_ciudad')
							->join('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_ciudad.id_departamento')
							->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_departamento.id_pais')
							->select('tbl_tienda.id as id_tienda', 'tbl_ciudad.id as id_ciudad', 'tbl_departamento.id as id_departamento', 'tbl_pais.id as id_pais')
							->where('tbl_tienda.id', $tienda)
							->first();
							
				$result = DB::table('tbl_contr_val_venta')
						->select('valor_venta_x_1', 'valor_minimo_x_1', 'valor_maximo_x_1')
						->where(function ($query) use ($categoria, $data, $id_config_peso, $cant_val, $array_valores, $id_config_peso_var){
							$query->where('tbl_contr_val_venta.id_tienda', '=', $data->id_tienda);
							$query->where('tbl_contr_val_venta.id_categoria_general', '=', $categoria);
							
							if(count($id_config_peso) > 0){
								$query->where('tbl_contr_val_venta.id', '=', $id_config_peso_var);
								$query->where('tbl_contr_val_venta.valores_especificos', '=', 1);
							}else{
								$query->where('tbl_contr_val_venta.valores_especificos', '=', 0);
							}
						})
						->orWhere(function ($query) use ($categoria, $data, $id_config_peso, $cant_val, $array_valores, $id_config_peso_var){
							$query->where('tbl_contr_val_venta.id_ciudad', '=', $data->id_ciudad);
							$query->where('tbl_contr_val_venta.id_categoria_general', '=', $categoria);
							
							if(count($id_config_peso) > 0){
								$query->where('tbl_contr_val_venta.id', '=', $id_config_peso_var);
								$query->where('tbl_contr_val_venta.valores_especificos', '=', 1);
							}else{
								$query->where('tbl_contr_val_venta.valores_especificos', '=', 0);
							}
						})
						->orWhere(function ($query) use ($categoria, $data, $id_config_peso, $cant_val, $array_valores, $id_config_peso_var){
							$query->where('tbl_contr_val_venta.id_departamento', '=', $data->id_departamento);
							$query->where('tbl_contr_val_venta.id_categoria_general', '=', $categoria);
							
							if(count($id_config_peso) > 0){
								$query->where('tbl_contr_val_venta.id', '=', $id_config_peso_var);
								$query->where('tbl_contr_val_venta.valores_especificos', '=', 1);
							}else{
								$query->where('tbl_contr_val_venta.valores_especificos', '=', 0);
							}
						})
						->orWhere(function ($query) use ($categoria, $data, $id_config_peso, $cant_val, $array_valores, $id_config_peso_var){
							$query->where('tbl_contr_val_venta.id_pais', '=', $data->id_pais);
							$query->where('tbl_contr_val_venta.id_categoria_general', '=', $categoria);
							
							if(count($id_config_peso) > 0){
								$query->where('tbl_contr_val_venta.id', '=', $id_config_peso_var);
								$query->where('tbl_contr_val_venta.valores_especificos', '=', 1);
							}else{
								$query->where('tbl_contr_val_venta.valores_especificos', '=', 0);
							}
						})
						->orderBy('id_pais', 'DESC')
						->orderBy('id_departamento', 'DESC')
						->orderBy('id_ciudad', 'DESC')
						->orderBy('id_tienda', 'DESC')
						->first();
			}else{
				// Acá debería ir la consulta que consulta el precio de los artículos
				$result = DB::table('tbl_prod_catalogo as referencia')->join('tbl_prod_referencia as referencia_atributos','referencia_atributos.id_referencia','referencia.id')
														   ->join('tbl_contr_val_venta_atrib as venta_atributos','venta_atributos.id_valor_atrib','referencia_atributos.id_valor_atributo')
														   ->join('tbl_contr_val_venta as venta','venta.id','venta_atributos.id_config_peso')
														   ->join('tbl_prod_categoria_general as categoria','venta.id_categoria_general','categoria.id')
														   ->where('se_fabrica','1')
														   ->where('referencia.id',$id_referencia)
														   ->whereRaw('CURDATE() between categoria.vigencia_desde and categoria.vigencia_hasta')
														   ->select(
																   'valor_venta_x_1',
																   DB::raw('count(referencia_atributos.id_valor_atributo) AS peso')
														   )
														   ->groupBy('valor_venta_x_1')
														   ->groupBy('referencia_atributos.id_valor_atributo')
														   ->orderBy('peso')
														   ->first();
			}

			
		}catch(\Exception $ex){
			$result = false;
		}
		return $result;
	}

	public static function getPlanById($id_tienda,$codigo_plan){
		return ModelGenerarPlan::join('tbl_tienda','tbl_tienda.id','tbl_plan_separe.id_tienda')
								->where('tbl_plan_separe.id_tienda',$id_tienda)
								->where('tbl_plan_separe.codigo_plan_separe',$codigo_plan)
								->select(
									"tbl_plan_separe.codigo_plan_separe",
									"tbl_plan_separe.codigo_cliente",
									"tbl_plan_separe.id_tienda",
									"tbl_tienda.nombre as tienda",
									DB::raw('FORMAT(tbl_plan_separe.monto,2,"de_DE") as monto'),
									DB::raw('FORMAT(tbl_plan_separe.deuda,2,"de_DE") as deuda'),
									"tbl_plan_separe.motivo",
									"tbl_plan_separe.estado",
									"tbl_plan_separe.fecha_creacion",
									"tbl_plan_separe.fecha_limite"
								)
								->first();
								
	}

	public static function getCodigosSecuencia($id_tienda){
		return DB::select('CALL sp_secuencias_tienda_x (?,?,?)',array($id_tienda, (int)28,(int)1));
	}

	public static function getConfig($id_pais,$id_departamento,$id_ciudad,$id_tienda,$monto){
		return DB::select('CALL sp_plan_separe_config (?,?,?,?,?)',array($id_pais,$id_departamento,$id_ciudad,$id_tienda,$monto));
	}

	public static function getInfoAbono($id_tienda,$codigo_plan){
		
		return ModelGenerarPlan::join('tbl_cliente',function($join){
										$join->on('tbl_cliente.codigo_cliente','tbl_plan_separe.codigo_cliente')
											 ->on('tbl_cliente.id_tienda','tbl_plan_separe.id_tienda_cliente');
								})
								->join('tbl_tienda','tbl_tienda.id','tbl_plan_separe.id_tienda')
								->where('tbl_plan_separe.id_tienda',$id_tienda)
								->where('tbl_plan_separe.codigo_plan_separe',$codigo_plan)
								->select(
									"codigo_plan_separe",
									"tbl_plan_separe.codigo_cliente as codigo_cliente_plan",
									"tbl_plan_separe.id_tienda as id_tienda_plan",
									DB::raw('FORMAT(monto,2,"de_DE") as monto'),
									DB::raw('FORMAT(deuda,2,"de_DE") as deuda'),
									"monto as monto_total",
									"deuda as deuda_actual",
									"motivo",
									"tbl_plan_separe.estado as estado_plan",
									"fecha_creacion",
									"fecha_limite",
									"id_tipo_documento",
									"id_tipo_cliente",
									"id_confiabilidad",
									"digito_verificacion",
									"numero_documento",
									"fecha_expedicion",
									"id_pais_expedicion",
									"id_ciudad_expedicion",
									"genero",
									"nombres",
									"primer_apellido",
									"segundo_apellido",
									"fecha_nacimiento",
									"id_pais_nacimiento",
									"id_ciudad_nacimiento",
									"id_pais_residencia",
									"id_ciudad_residencia",
									"barrio_residencia",
									"direccion_residencia",
									"telefono_residencia",
									"id_estado_civil",
									"telefono_celular",
									"id_ciudad_trabajo",
									"direccion_trabajo",
									"barrio_trabajo",
									"telefono_trabajo",
									"telefono_otros",
									"id_nivel_estudio",
									"id_nivel_estudio_actual",
									"id_profesion",
									"id_tipo_trabajo",
									"id_sector_area_laboral",
									"personas_a_cargo",
									"nombre_contacto",
									"apellidos_contacto",
									"correo_electronico",
									"libreta_militar",
									"distrito_militar",
									"id_tipo_vivienda",
									"tenencia_vivienda",
									"id_fondo_cesantias",
									"id_usuario",
									"talla_zapatos",
									"talla_pantalon",
									"talla_camisa",
									"id_caja_compensacion",
									"id_eps",
									"id_tenencia_vivienda",
									"id_fondo_pensiones",
									"rh",
									"id_cargo",
									"ocupacion",
									"beneficiario",
									"ano_o_semestre",
									"grado_escolaridad",
									"id_regimen_contributivo",
									"aniversario",
									"contacto",
									"telefono_contacto",
									"representante_legal",
									"numero_documento_representante",
									"foto",
									"suplantacion",
									"id_foto_documento_anterior",
									"id_foto_documento_posterior",
									"id",
									"nombre",
									"ip_fija",
									"direccion",
									"telefono",
									"codigo_tienda",
									"id_sociedad",
									"id_ciudad",
									"id_zona",
									"id_franquicia",
									"tienda_padre",
									"festivo",
									"todoeldia",
									"tipo_bodega",
									"abierto",
									"sede_principal",
									"id_tienda_cliente",
									"id_comprobante"
								)
								->first();
	}

	public static function getInfoAbonos($id_tienda,$codigo_plan){
		return DB::table("tbl_plan_separe")->join('tbl_plan_abono',function($join){
										$join->on('tbl_plan_separe.codigo_plan_separe','tbl_plan_abono.codigo_plan_separe')
											 ->on('tbl_plan_separe.id_tienda','tbl_plan_abono.id_tienda');			
								})
								->join('tbl_tienda','tbl_tienda.id','tbl_plan_separe.id_tienda')
								->where('tbl_plan_separe.codigo_plan_separe',$codigo_plan)
								->where('tbl_plan_abono.id_tienda',$id_tienda)
								->select(
										DB::raw('CONCAT(tbl_plan_abono.codigo_abono,"/",tbl_plan_abono.id_tienda,"/",tbl_plan_abono.reversado) as DT_RowId'),
										'tbl_plan_abono.codigo_plan_separe',
										'tbl_plan_abono.id_tienda',
										DB::raw('FORMAT(tbl_plan_abono.saldo_abonado,2,"de_DE") as saldo_abonado'),
										'tbl_plan_abono.fecha',
										DB::raw('FORMAT(tbl_plan_abono.saldo_pendiente,2,"de_DE") as saldo_pendiente'),
										'tbl_plan_abono.descripcion',
										'tbl_plan_abono.codigo_abono',
										'tbl_plan_abono.estado',
										'tbl_plan_separe.deuda',
										'tbl_tienda.nombre',
										DB::raw('if(tbl_plan_abono.estado = 0,"Abono",if(tbl_plan_abono.estado = 1,"Reverso abono","Pendiente reversar")) as tipo_abono')
								);
	}

	public static function getInfoAbonosX($id_tienda,$codigo_plan){
		return ModelGenerarPlan::join('tbl_plan_abono',function($join){
										$join->on('tbl_plan_separe.codigo_plan_separe','tbl_plan_abono.codigo_plan_separe')
											 ->on('tbl_plan_separe.id_tienda','tbl_plan_abono.id_tienda');			
								})
								->where('tbl_plan_separe.codigo_plan_separe',$codigo_plan)
								->where('tbl_plan_abono.id_tienda',$id_tienda)
								->select(
										DB::raw('CONCAT(tbl_plan_abono.codigo_abono,"/",tbl_plan_abono.id_tienda) as DT_RowId'),
										'tbl_plan_abono.codigo_plan_separe',
										'tbl_plan_abono.id_tienda',
										DB::raw('FORMAT(tbl_plan_abono.saldo_abonado,2,"de_DE") as saldo_abonado'),
										'tbl_plan_abono.fecha',
										DB::raw('FORMAT(tbl_plan_abono.saldo_pendiente,2,"de_DE") as saldo_pendiente'),
										'tbl_plan_abono.descripcion',
										'tbl_plan_abono.codigo_abono',
										'tbl_plan_abono.estado',
										'tbl_plan_separe.deuda',
										DB::raw('if(tbl_plan_abono.estado = 0,"Abono",if(tbl_plan_abono.estado = 1,"Reverso abono","Pendiente reversar")) as tipo_abono')
								)
								->get();
	}

	public static function getTransferirPlan($codigo_cliente,$id_tienda,$codigo_plan){
		return ModelGenerarPlan::join('tbl_plan_abono',function($join){
										$join->on('tbl_plan_separe.codigo_plan_separe','tbl_plan_abono.codigo_plan_separe')
										->on('tbl_plan_separe.id_tienda','tbl_plan_abono.id_tienda');
								})
								->join('tbl_cliente','tbl_plan_separe.codigo_cliente','tbl_cliente.codigo_cliente')
								->select('tbl_plan_separe.codigo_plan_separe','tbl_plan_separe.codigo_cliente','deuda',DB::raw("FORMAT(deuda,(select decimales from tbl_parametro_general limit 1),'de_DE') as saldo_pendiente"))
								->where('tbl_plan_separe.codigo_cliente',$codigo_cliente)
								->where('tbl_cliente.id_tienda',$id_tienda)
								->where('tbl_plan_separe.codigo_plan_separe','<>',$codigo_plan)
								->where('tbl_plan_separe.estado','<>',env('CERRAR_PLAN_SEPARE_ANULACION'))
								->where('tbl_plan_separe.estado','<>',env('CERRAR_PLAN_SEPARE_PEN_ANULACION'))
								->where('tbl_plan_separe.estado','<>',env('CERRAR_PLAN_SEPARE_ESTADO'))
								->where('tbl_plan_separe.estado','<>',env('CERRAR_PLAN_SEPARE_PENDIENTE_CIERRE'))
								->where('tbl_plan_separe.estado','<>',env('PLAN_FACTURADO'))
								->where('tbl_plan_separe.estado','<>',env('PLAN_ESTADO_FACTURAR'))
								->groupBy('tbl_plan_separe.codigo_plan_separe','tbl_plan_separe.codigo_cliente','deuda')
								->get(); 		 
	}

	public static function getTransferPlanH($codigo_cliente,$codigo_plan){
		return ModelGenerarPlan::select('codigo_plan_separe','codigo_cliente','deuda','id_tienda')
									->where('codigo_plan_separe',$codigo_plan)
									->where('codigo_cliente',$codigo_cliente)
									->get();
	}

	public static function getTransferirContrato($codigo_cliente,$id_tienda){
		return ModelContratos::join('tbl_cliente',function($join){
									$join->on('tbl_cliente.codigo_cliente','tbl_contr_cabecera.codigo_cliente')
										 ->on('tbl_cliente.id_tienda','tbl_contr_cabecera.id_tienda_cliente');
								})
								->join('tbl_contr_item_detalle',function($join){
									$join->on('tbl_contr_item_detalle.id_codigo_contrato','tbl_contr_cabecera.codigo_contrato')
										 ->on('tbl_contr_item_detalle.id_tienda','tbl_contr_cabecera.id_tienda_contrato');
								})
								->select(
									'tbl_cliente.numero_documento','tbl_cliente.codigo_cliente','tbl_contr_cabecera.codigo_contrato','tbl_contr_cabecera.id_tienda_contrato',
									DB::raw('sum(tbl_contr_item_detalle.precio_sugerido) as valor_contrato'),
									DB::raw('FORMAT((SUM(tbl_contr_item_detalle.precio_ingresado) * tbl_contr_cabecera.porcentaje_retroventa)/100,2) as prorroga')
								)
								->where('tbl_contr_cabecera.id_tienda_cliente',$id_tienda)
								->where('tbl_cliente.codigo_cliente',$codigo_cliente)
								->where('tbl_contr_cabecera.id_estado_contrato','47')
								->groupBy('tbl_cliente.numero_documento')
								->groupBy('tbl_cliente.codigo_cliente')
								->groupBy('tbl_contr_cabecera.codigo_contrato')
								->groupBy('tbl_contr_cabecera.id_tienda_contrato')
								->get();
	}

	public static function createPostTransferir($data){
		$result = "Insertado";
			try{
				DB::beginTransaction();
				self::saveplansepareTrasferir($data['transfePlan']);
				self::abonosPostTransferir($data['abonoTransferido']);
				self::retirarValorPlan($data['retirarValorPlan']);
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
			return ($result);
	}
	public static function abonosPostTransferir($abonoTransferido){
		return DB::table('tbl_plan_abono')->insert($abonoTransferido);
	}
	public static function retirarValorPlan($retirarValorPlan){
		return DB::table('tbl_plan_abono')->insert($retirarValorPlan);
	}
	
	public static function codigoPlanPostTransferir($id_tienda,$codigo_cliente){
		return DB::table('tbl_plan_separe')->select(
										DB::raw('max(codigo_plan_separe) as codigo_plan_separe ')
									)
									->where('id_tienda',$id_tienda)
									->where('codigo_cliente',$codigo_cliente)
									->first();
	}
	
	public static function transferirGuardar($data){
			$result = "Insertado";
			try{
				DB::beginTransaction();
				self::saveplansepareTrasferir($data['transfePlan']);
				self::saveplansepareTrasferirX($data['transfePlanX']);
				self::saveabonosTransferir($data['transfeAbonos']);
				self::saveabonosTransferirX($data['transfeAbonosX']);
				self::liberarIDS($data['transfeAbonos']);
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
			return ($result);
	}
	
	public static function transferirGuardarX($data){
			$result = "Insertado";
			try{
				DB::beginTransaction();
				self::saveabonosTransferir($data['transfeAbonos']);
				self::saveplansepareTrasferir($data['transfePlan']);
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
			return ($result);
	}

	public static function liberarIDS($data)
	{
		$ids = DB::table('tbl_plan_inv_producto')->where('codigo_plan_separe',$data['codigo_plan_separe'])->where('id_tienda',$data['id_tienda'])->delete();
		if(count($ids) > 0)
		{
			for ($i=0; $i < count($ids); $i++) { 
				DB::table('tbl_inventario_producto')->where('id_inventario',$ids[$i])
													->where('id_tienda_inventario',$data['id_tienda'])
													->update(['id_estado_producto' => env('PRODUCTO_DISPONIBLE'), 'id_motivo_producto' => env('PRODUCTO_MOTIVO_DIS')]);
			}
			DB::table('tbl_plan_inv_producto')->where('codigo_plan_separe',$data['codigo_plan_separe'])
											->where('id_tienda',$data['id_tienda'])
											->delete();
		}
	}

	public static function saveplansepareTrasferir($transfePlan){
		DB::table('tbl_plan_separe')->where('codigo_plan_separe','=',$transfePlan['codigo_plan_separe'])
									->where('id_tienda', $transfePlan['id_tienda'])
									->update($transfePlan);
	}

	public static function saveplansepareTrasferirX($transfePlan){
		DB::table('tbl_plan_separe')->where('codigo_plan_separe','=',$transfePlan['codigo_plan_separe'])
									->where('id_tienda', $transfePlan['id_tienda'])
									->update($transfePlan);
	}

	public static function saveabonosTransferir($transfeAbonos){
		return DB::table('tbl_plan_abono')->insert($transfeAbonos);
	}

	public static function saveabonosTransferirX($transfeAbonos){
		return DB::table('tbl_plan_abono')->insert($transfeAbonos);
	}

	public static function getSaldoFavor($id_tienda,$codigo_plan){
		return DB::table('tbl_plan_abono')->select('saldo_abonado','saldo_abonado AS saldo_favor')
										  ->where('tbl_plan_abono.codigo_plan_separe',$codigo_plan)
										  ->where('tbl_plan_abono.id_tienda',$id_tienda)
										  ->sum('saldo_abonado');
	}

	public static function getNuevoSaldoFavor($id_tienda,$codigo_plan){
		return DB::table('tbl_plan_abono')->join('tbl_plan_separe','tbl_plan_separe.codigo_plan_separe','tbl_plan_abono.codigo_plan_separe')
										  ->where('tbl_plan_abono.id_tienda',$id_tienda)
										  ->where('tbl_plan_abono.codigo_plan_separe',$codigo_plan)
										  ->select(
												// DB::Raw("FORMAT((select COALESCE(sum(saldo_abonado),0) from tbl_plan_abono where estado in (0,2) and id_tienda = ".$id_tienda." and codigo_plan_separe = ".$codigo_plan.") - (select COALESCE(sum(saldo_abonado),0) from tbl_plan_abono where estado = 1 and id_tienda = ".$id_tienda." and codigo_plan_separe = ".$codigo_plan."),2,'de_DE') AS nuevo_saldo_favor")
												DB::Raw("FORMAT((SELECT COALESCE(SUM(saldo_abonado), 0) FROM tbl_plan_abono JOIN tbl_plan_separe as ps on tbl_plan_abono.codigo_plan_separe = ps.codigo_plan_separe WHERE tbl_plan_abono.estado IN (0 , 2) AND ps.codigo_cliente = tbl_plan_separe.codigo_cliente AND tbl_plan_abono.codigo_plan_separe = tbl_plan_separe.codigo_plan_separe) - (SELECT COALESCE(SUM(saldo_abonado), 0) FROM tbl_plan_abono JOIN tbl_plan_separe as ps on tbl_plan_abono.codigo_plan_separe = ps.codigo_plan_separe WHERE tbl_plan_abono.estado = 1 AND ps.codigo_cliente = tbl_plan_separe.codigo_cliente AND tbl_plan_abono.codigo_plan_separe = tbl_plan_separe.codigo_plan_separe),2,'de_DE') AS nuevo_saldo_favor")											
											)
										  ->first();
	}

	public static function anular($data){
		$result = "Insertado";
			try{
				DB::beginTransaction();
				self::saveAnular($data['anular']);
				self::liberarIDS($data['anular']);
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
		return ($result);

	}

	public static function saveAnular($anular){
		DB::table('tbl_plan_separe')->where('codigo_plan_separe',$anular['codigo_plan_separe'])
									->where('id_tienda', $anular['id_tienda'])
									->update($anular);
	}

	public static function reversarAbono($data,$id_tienda,$codigo_plan)
	{
			$result = true;
			$dato = DB::table('tbl_plan_separe')->where('id_tienda',$id_tienda)->where('codigo_plan_separe',$codigo_plan)->select('deuda','estado')->first();
			$estado = ($dato->estado == env('CERRAR_PLAN_SEPARE_ESTADO')) ? env('CERRAR_PLAN_SEPARE_ESTADO') : env('PLAN_ESTADO_ACTIVO');

			try{
				DB::beginTransaction();
				DB::table('tbl_plan_abono')->insert($data['reversarAbono']);
				DB::table('tbl_plan_abono')->where('id_tienda',$id_tienda)
										   ->where('codigo_plan_separe',$codigo_plan)
										   ->where('codigo_abono',$data['abonorever'])
										   ->update(['estado' => 0,'reversado' => (int)1]);
				DB::table('tbl_plan_separe')->where('id_tienda',$id_tienda)
											->where('codigo_plan_separe',$codigo_plan)
											->update(['deuda' => $data['reversarAbono']['saldo_pendiente'], 'estado' => $estado]);
				DB::commit();
			}catch(\Exception $e){
				dd($e);
				if($e->getCode() == 2300)
				{
					$result = false;
				}else
				{
					$result = false;
				}
				DB::rollBack();
			}
		return ($result);

	}

	public static function rechazarReversar($id_tienda,$codigo_plan,$codigo_abono){
		$result = true;
			try{
				DB::beginTransaction();
				DB::table('tbl_plan_abono')->where('id_tienda',$id_tienda)
										   ->where('codigo_plan_separe',$codigo_plan)
										   ->where('codigo_abono',$codigo_abono)
										   ->update(['estado' => 0]);
				DB::commit();
			}catch(\Exception $e){
				dd($e);
				if($e->getCode() == 2300)
				{
					$result = false;
				}else
				{
					$result = false;
				}
				DB::rollBack();
			}
		return ($result);

	}

	public static function solicitudAnulacion($id_tienda,$codigo_plan,$codigo_abono){
		$result = true;
		// dd($id_tienda);
			try{
				DB::beginTransaction();
				DB::table('tbl_plan_separe')->where('id_tienda',$id_tienda)
											->where('codigo_plan_separe',$codigo_plan)
											->update(['estado' => env('CERRAR_PLAN_SEPARE_PEN_ANULACION'),
													  'motivo' => env('CERRAR_PLAN_SEPARE_PENDIENTE_ANULACION_MOTIVO')]);
				DB::commit();
			}catch(\Exception $e){
				dd($e);
				if($e->getCode() == 2300)
				{
					$result = false;
				}else
				{
					$result = false;
				}
				DB::rollBack();
			}
		return ($result);

	}

	public static function solicitarReversarAbono($data)
	{
		$result = true;
		try{
			DB::beginTransaction();
			DB::table('tbl_plan_abono')->where('id_tienda',$data->id_tienda)
									   ->where('codigo_plan_separe',$data->codigo_plan)
									   ->where('codigo_abono',$data->id_abono)
									   ->update(['estado' => '2',
									   			 'descripcion' => 'Solicitud de reverso de abono']);
			DB::commit();
		}
		catch(\Exception $e)
		{
			dd($e);
			$result = false;
			DB::rollBack();
		}

		return $result;
	}

	public static function guardar($data){
		$result = "Insertado";
			try{
				DB::beginTransaction();
				self::saveabonos($data['abonos']);
				self::saveplansepare($data['planSepare']);
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
		return ($result);
	}

	public static function mov_contablesAbono($data)
	{
		$msms = true;

		$efectivo = ($data->saldo_abonar_efectivo != "") ? $data->saldo_abonar_efectivo : 0;
		$debito = ($data->saldo_abonar_debito != "") ? $data->saldo_abonar_debito : 0;
		$credito = ($data->saldo_abonar_credito != "") ? $data->saldo_abonar_credito : 0;
		$otro = ($data->saldo_abonar_otro != "") ? $data->saldo_abonar_otro : 0;


		if($efectivo > 0){
			$movimiento_contable[0] = env('CUENTA_EFECTIVO');
			$tipo[0] = 'EFECTIVO';
			$comprabante[0] = 0;
			$observaciones[0] = "";
			$valor[0] = CrudGenerarPlan::limpiarVal($efectivo);
		}
		if($debito > 0){
			$movimiento_contable[1] = env('CUENTA_DEBITO');
			$tipo[1] = 'DEBITO';
			$comprabante[1] = $data->comprobante_debito;
			$observaciones[1] = "";
			$valor[1] = CrudGenerarPlan::limpiarVal($debito);
		}
		if($credito > 0){
			$movimiento_contable[2] = env('CUENTA_CREDITO');
			$tipo[2] = 'CREDITO';
			$comprabante[2] = $data->comprobante_credito;
			$observaciones[2] = "";
			$valor[2] = CrudGenerarPlan::limpiarVal($credito);
		}
		if($otro > 0){
			$movimiento_contable[3] = env('CUENTA_OTROS');
			$tipo[3] = 'OTROS';
			$comprabante[3] = $data->comprobante_otro;
			$observaciones[3] = $data->observaciones;
			$valor[3] = CrudGenerarPlan::limpiarVal($otro);
		}

		$movimiento_contable = array_values($movimiento_contable);	
		$tipo = array_values($tipo);	
		$comprabante = array_values($comprabante);	
		$observaciones = array_values($observaciones);
		$valor = array_values($valor);

		try{
			$msms = MovimientosTesoreria::registrarMovimientosAbono(CrudGenerarPlan::limpiarVal($data->saldo_abonar),$data->id_tienda,$movimiento_contable,null,'PLANS-'.$data->codigo_tienda.'/'.$data->codigo_planS,$tipo,$comprabante,$observaciones,$valor,env('TEMA_PLAN_SEPARE'),$data->codigo_abono,$data->numero_documento);
		}catch(\Exception $e){
			dd($e);
			DB::rollback();
			$msms = false;
		}
		return $msms;
	}

	public static function saveplansepare($planSepare){
		DB::table('tbl_plan_separe')->where('codigo_plan_separe','=',$planSepare['codigo_plan_separe'])
									->where('id_tienda', $planSepare['id_tienda'])
									->update($planSepare);
	}

	public static function saveabonos($abonos){
		return DB::table('tbl_plan_abono')->insert($abonos);
	}

	public static function getTiendaByIp($ip){
		return ModelTienda::select('id', 'nombre')->where('ip_fija', $ip)->first();
	}

	public static function cotizarPost($data,$id_tienda,$id_usuario,$id_cotizacion)
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

	public static function getSelectListCotizacion($id_tienda)
	{
		return DB::table('tbl_plan_cotizacion')->where('estado','0')
											   ->whereRaw('id_cotizacion not in (select pc.id_cotizacion from tbl_plan_cotizacion pc inner join tbl_plan_separe ps on ps.id_tienda_cotizacion = pc.id_tienda and ps.id_cotizacion = pc.id_cotizacion where ps.id_tienda = '.$id_tienda.')')
											   ->where('id_tienda',$id_tienda)
											   ->get();
	}

	public static function getCotizacionById($id_cotizacion,$id_tienda)
	{
		return DB::table('tbl_plan_cotizacion')->where('id_cotizacion',$id_cotizacion)
											   ->where('id_tienda',$id_tienda)
											   ->first();
	}

	public static function updateInventario($id_inventario,$id_tienda,$id_estado,$id_motivo)
	{
		$result = true;
		try{
			DB::beginTransaction();
			DB::table('tbl_inventario_producto')->where('id_tienda_inventario', $id_tienda)
													   ->where('id_inventario', $id_inventario)
												   	   ->update(['id_estado_producto' => $id_estado,'id_motivo_producto' => $id_motivo]);
			DB::commit();
		}catch(\Exception $e)
		{
			dd($e);
			DB::rollBack();
			$result = false;
		}

		return $result;
	}

	public static function validarFecha($id_tienda,$id_plan)
	{
		return ModelGenerarPlan::leftJoin('tbl_plan_cotizacion',function($join){
											$join->on('tbl_plan_cotizacion.id_cotizacion','tbl_plan_separe.id_cotizacion')
												 ->on('tbl_plan_cotizacion.id_tienda','tbl_plan_separe.id_tienda_cotizacion');
										})
								->where('tbl_plan_separe.id_tienda',$id_tienda)
								->where('tbl_plan_separe.codigo_plan_separe',$id_plan)
								->select('tbl_plan_cotizacion.fecha_entrega','tbl_plan_separe.id_tienda_cliente')
								->first();
	}

	public static function getItemsPlan($id_tienda,$codigo_plan)
	{
		return ModelGenerarPlan::join('tbl_plan_inv_producto',function($join){
										$join->on('tbl_plan_inv_producto.codigo_plan_separe','tbl_plan_separe.codigo_plan_separe')
											 ->on('tbl_plan_inv_producto.id_tienda','tbl_plan_separe.id_tienda');
									})
								->join('tbl_inventario_producto','tbl_inventario_producto.id_inventario','tbl_plan_inv_producto.codigo_inventario')
								->join('tbl_prod_catalogo','tbl_prod_catalogo.id','tbl_inventario_producto.id_catalogo_producto')
								->join('tbl_prod_categoria_general','tbl_prod_categoria_general.id','tbl_prod_catalogo.id_categoria')
								->where('tbl_plan_separe.id_tienda',$id_tienda)
								->where('tbl_plan_separe.codigo_plan_separe',$codigo_plan)
								->select(
									'tbl_inventario_producto.id_inventario as id',
									'tbl_prod_categoria_general.nombre as categoria',
									'tbl_prod_catalogo.nombre as referencia',
									'tbl_prod_catalogo.descripcion as nombre',
									'tbl_inventario_producto.peso',
									DB::raw("FORMAT(tbl_inventario_producto.precio_venta,2,'de_DE') as precio")
								)
								->get();	
						
	}

	public static function docGenerCotr($tipo_documento){
		return DB::table('tbl_clie_tipo_documento')->where('id', $tipo_documento)->value('venta');
	}

	public static function detalleAbono($id_tienda,$id_abono)
	{
		return DB::table('tbl_plan_abono')->join('tbl_cont_relacion_movimientos',function($join){
												$join->on('tbl_cont_relacion_movimientos.id_tienda','tbl_plan_abono.id_tienda')
													 ->on('tbl_cont_relacion_movimientos.id_abono','tbl_plan_abono.codigo_abono');
											})
										->join('tbl_cont_movimientos_contables',function($join){
												$join->on('tbl_cont_movimientos_contables.id_movimiento','tbl_cont_relacion_movimientos.id_movimiento')
													 ->on('tbl_cont_movimientos_contables.id_tienda','tbl_cont_relacion_movimientos.id_tienda');
											})
										->select(
											 'tbl_cont_movimientos_contables.tipo',
											 'tbl_cont_movimientos_contables.comprobante',
											 'tbl_cont_movimientos_contables.observaciones',
											 DB::raw('if(tbl_cont_movimientos_contables.debito = 0,FORMAT(tbl_cont_movimientos_contables.credito,0,"de_DE"),FORMAT(tbl_cont_movimientos_contables.debito,0,"de_DE")) as valor')
										)
										->where('tbl_plan_abono.id_tienda',$id_tienda)
										->where('tbl_plan_abono.codigo_abono',$id_abono)
										->get();

	}

	public static function getDatosPlan($codigo_plan,$id_tienda)
	{
		return ModelGenerarPlan::leftJoin('tbl_plan_abono',function($join){
														$join->on('tbl_plan_abono.codigo_plan_separe','tbl_plan_separe.codigo_plan_separe')
															 ->on('tbl_plan_abono.id_tienda','tbl_plan_separe.id_tienda');
													})
											->select(
												'tbl_plan_separe.fecha_creacion',
												'tbl_plan_separe.fecha_limite',
												DB::raw('COUNT(tbl_plan_abono.codigo_plan_separe) as abonos'),
												DB::raw('round(datediff(tbl_plan_separe.fecha_limite,tbl_plan_separe.fecha_creacion) / 30) as plazo')
											)
											->where('tbl_plan_separe.codigo_plan_separe',$codigo_plan)
											->where('tbl_plan_separe.id_tienda',$id_tienda)
											->first();
	}

	public static function getPlanEstadosAbonos($id_tienda,$codigo_plan)
	{
		return DB::table('tbl_plan_abono')->where('codigo_plan_separe',$codigo_plan)
										->where('id_tienda',$id_tienda)
										->where('estado',2)
										->get();
	}

	public static function getFechaEntrega($codigo_plan,$id_tienda)
	{
		return ModelGenerarPlan::join('tbl_plan_cotizacion',function($join){
													$join->on('tbl_plan_separe.id_cotizacion','tbl_plan_cotizacion.id_cotizacion')
														 ->on('tbl_plan_separe.id_tienda_cotizacion','tbl_plan_cotizacion.id_tienda');
												})
												->select('fecha_entrega')
												->where('tbl_plan_separe.codigo_plan_separe',$codigo_plan)
												->where('tbl_plan_separe.id_tienda',$id_tienda)
												->first();
	}

	public static function getSelectListConfiabilidad()
	{
		return DB::table('tbl_clie_confiabilidad')->where('estado',1)->get();
	}

	public static function valDocumento($tipodocumento, $numdocumento,$id_tienda)
	{
		return DB::table('tbl_cliente')->where('numero_documento',$numdocumento)
										->where('id_tipo_documento',$tipodocumento)
										// ->where('id_tienda',$id_tienda)
										->value('estado');
	}
}
<?php

// Author		:	<Andrey Higuita>
// Create date	:	<Jueves, 15 de abril de 2018>
// Description	:	<Clase para manejar la lógica del negocio de la resolución en el primer paso (perfeccionamiento de contratos)>

namespace App\BusinessLogic\Nutibara\Contratos;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\AccessObject\Nutibara\Contratos\ResolucionarAO;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\BusinessLogic\Nutibara\Excel\Resolucion\ResolucionarExcel;
use App\BusinessLogic\Nutibara\Inventario\Trazabilidad\TrazabilidadBL;
use dateFormate;
use DB;

class ResolucionarBL {

	public static function getContratos($request){
		$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];
		$order=$request->order[0]['dir'];
		$vowels = array("$", "^");
		$search["id_tienda"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["id_categoria"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["tipo_documento"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["numero_documento"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$search["numero_contrato_desde"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
		$search["numero_contrato_hasta"] = str_replace($vowels, "", $request->columns[5]['search']['value']);
		$search["dias_sin_prorroga"] = str_replace($vowels, "", $request->columns[6]['search']['value']);
		$search["vencidos_sin_plazo"] = str_replace($vowels, "", $request->columns[7]['search']['value']);
		$search["meses_adeudados_1"] = str_replace($vowels, "", $request->columns[8]['search']['value']);
		$search["meses_adeudados_2"] = str_replace($vowels, "", $request->columns[9]['search']['value']);
		$search["meses_adeudados_3"] = str_replace($vowels, "", $request->columns[10]['search']['value']);
		$datos_contratos = ResolucionarAO::getContratos($start,$end,$colum, $order,$search)->toArray();
		$total=count($datos_contratos);
		$data=[
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse($datos_contratos)
		];
		return response()->json($data);
	}

	public static function getTiendaByIp($ip){
		return ResolucionarAO::getTiendaByIp($ip);
	}

	public static function getListProceso( $cat_gen )
	{
		$arr_proces = [];
		$arr_conf_proces = ResolucionarAO::getConfigProcesos( $cat_gen );
		$arr_id_proces =
		[
			env('PROCESO_VITRINA'),
			env('PROCESO_PREREFACCION'),
			env('PROCESO_FUNDICION'),
			env('PROCESO_MAQUILA_NACIONAL'),
			env('PROCESO_JOYA_ESPECIAL'),
			env('PROCESO_MAQUILA_IMPORTADA')
		];

		for($i = 0; $i < count((array)$arr_conf_proces); $i++){
			if($arr_conf_proces->$i == 1){
				array_push($arr_proces, $arr_id_proces[$i]);
			}
		}
		return ResolucionarAO::getListProceso( $arr_proces );
	}

	public static function getItemsContrato($id_tienda,$array_contratos)
	{
		return ResolucionarAO::getItemsContrato($id_tienda,$array_contratos);
	}

	public static function procesarHojaTrabajo($request)
	{
		$id_hoja_trabajo = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_contrato,env('SECUENCIA_TIPO_CODIGO_HOJA_TRABAJO'), 1);
		$hoja_trabajo_cabecera = [
			'id_hoja_trabajo' => $id_hoja_trabajo[ 0 ]->response,
			'id_tienda_hoja_trabajo' => $request->id_tienda_contrato,
			'fecha_creacion' => $request->fecha_resolucion,
			'categoria' => $request->id_categoria,
			'estado' => 1
		];
		$hoja_trabajo_detalle = array(); //tbl_orden_hoja_trabajo_detalle
		$inventario_item_contrato = array(); //tbl_inventario_item_contrato
		$inventario_producto = array(); //tbl_inventario_producto
		for ($i=0; $i < count($request->id_item); $i++) {
			array_push($hoja_trabajo_detalle,
				[
					'id_hoja_trabajo' => $id_hoja_trabajo[ 0 ]->response,
					'id_tienda_hoja_trabajo' => $request->id_tienda_contrato,
					'id_contrato' => $request->codigo_contrato[$i],
					'id_tienda_contrato' => $request->id_tienda_contrato,
					'id_item_contrato' => $request->id_item[$i],
					'destino' => $request->subdivicion[$i],
				]
			);


			// $id_inventario = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_contrato,env('SECUENCIA_TIPO_CODIGO_INVENTARIO_ITEM'), 1);
			array_push($inventario_item_contrato,
				[
					'id_inventario' => $request->id_inventario[$i],
					'id_tienda_inventario' => $request->id_tienda_contrato,
					'id_contrato' => $request->codigo_contrato[$i],
					'id_tienda_contrato' => $request->id_tienda_contrato,
					'id_item_contrato' => $request->id_item[$i],
				]
			);

			array_push($inventario_producto,
				[
					'id_inventario' => $request->id_inventario[$i],
					'id_tienda_inventario' => $request->id_tienda_contrato,
					'id_estado_producto' => 33,
					'id_motivo_producto' => 11,
					'peso' => $request->peso_total,
					'peso_estimado' => $request->peso_estimado,
					'precio_compra' => $request->precio_ingresado,
				]
			);
		}

		$orden = array(); //tbl_orden
		$response = array();
		$response["ids_ordenes"] = array();
		$response["val"] = false;
		$orden_trazabilidad = array(); //tbl_orden_trazabilidad
		$orden_item = array(); //tbl_orden_item
		$destinatarios = array();//tbl_orden_destinatario
		
		for ($i=0; $i < count($request->id_proceso); $i++) {
			$id_orden = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_contrato,env('SECUENCIA_TIPO_CODIGO_ORDEN'), 1);

			$id_trazabilidad = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_contrato,env('SECUENCIA_TIPO_CODIGO_TRAZABILIDAD'), 1);
			array_push($response["ids_ordenes"], $id_orden[ 0 ]->response);
			array_push($orden,
				[
					'id_orden' => $id_orden[ 0 ]->response,
					'id_tienda_orden' => $request->id_tienda_contrato,
					'id_hoja_trabajo' => $id_hoja_trabajo[ 0 ]->response,
					'id_tienda_hoja_trabajo' => $request->id_tienda_contrato,
					'proceso' => $request->id_proceso[$i],
					'fecha_creacion' => $request->fecha_resolucion,
					'estado' => env('ORDEN_PENDIENTE_POR_PROCESAR'),
					'id_sucursal' => $request->sucursales[$i],
					'id_cliente' => $request->id_cliente[$i],
					'id_tienda_cliente' => $request->id_tienda_cliente[$i],
				]
			);

			array_push($orden_trazabilidad,
				[
					'id_trazabilidad' => $id_trazabilidad[ 0 ]->response,
					'id_tienda_trazabilidad' => $request->id_tienda_contrato,
					'id_orden' => $id_orden[ 0 ]->response,
					'id_tienda_orden' => $request->id_tienda_contrato,
					'actual' => 1,
					'fecha_accion' => $request->fecha_resolucion,
					'accion' => 'Creado',
					'id_traza_padre' => $request->id_orden_guardar,
					'id_tienda_traza_padre' => $request->id_tienda_contrato
				]
			);

			array_push( $destinatarios, [
				"id_orden" => $id_orden[ 0 ]->response,
				"id_tienda_orden" => $request->id_tienda_contrato,
				"id_proceso" => $request->id_proceso[ $i ],
				"destinatario" => $request->numero_documento[ $i ],
				"codigo_verificacion" => $request->digito_verificacion[ $i ],
				"numero_bolsa" => $request->numero_bolsa[ $i ]
			] );

			for ($j=0; $j < count($request->id_item); $j++) {
				if($request->id_proceso[$i] == $request->subdivicion[$j]){
					$id_orden_item = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_contrato,env('SECUENCIA_TIPO_CODIGO_ITEM_ORDEN'), 1);
					array_push($orden_item,
						[
							'id_orden_item' => $id_orden_item[ 0 ]->response,
							'id_tienda_orden_item' => $request->id_tienda_contrato,
							'id_inventario' => $inventario_item_contrato[ $j ]["id_inventario"],
							'id_tienda_inventario' => $request->id_tienda_contrato,
							'id_orden' => $id_orden[ 0 ]->response,
							'id_tienda_orden' => $request->id_tienda_contrato,
							'peso_joyeria' => $request->peso_joyeria[$j],
							'peso_total' => $request->peso_total[$j],
							'peso_estimado' => $request->peso_estimado[$j],
							'precio_ingresado' => $request->precio_ingresado[$j],
						]
					);
				}
			}
		}
		$data_orden = array();
		array_push($data_orden, [
			$hoja_trabajo_cabecera,
			$hoja_trabajo_detalle,
			$orden,
			$orden_trazabilidad,
			$inventario_item_contrato,
			$inventario_producto,
			$orden_item,
			$destinatarios,
		]);

		for($i=0;$i<count($inventario_producto);$i++){
			////////TRAZABILIDAD
			$traza['trazabilidad']['id_tienda']=$inventario_producto[$i]['id_tienda_inventario'];
			$traza['trazabilidad']['id']=$inventario_producto[$i]['id_inventario'];
			$traza['trazabilidad']['id_origen']=null;
			$traza['trazabilidad']['fecha_salida']=null;
			$traza['trazabilidad']['movimiento']=$orden[0]['proceso'];
			$traza['trazabilidad']['estado']=$orden[0]['estado'];
			$traza['trazabilidad']['fecha_ingreso']=date("Y-m-d H:i:s");
			$traza['trazabilidad']['ubicacion']='Taller';
			$traza['trazabilidad']['categoria']=null;
			$traza['trazabilidad']['motivo']='Perfeccionado';
			$traza['trazabilidad']['numero_contrato']=$inventario_item_contrato[$i]['id_contrato'];
			$traza['trazabilidad']['numero_item']=$inventario_item_contrato[$i]['id_item_contrato'];
			$traza['trazabilidad']['numero_orden']=$orden_trazabilidad[0]['id_traza_padre'];
			$traza['trazabilidad']['numero_referente']='Or.'.$orden_trazabilidad[0]['id_orden'];
			TrazabilidadBL::Create($traza);
		}

		$response["val"] = ResolucionarAO::procesarHojaTrabajo($data_orden, $request->id_tienda_contrato, $request->codigo_contrato);
		$response["id_tienda"] = $request->id_tienda_contrato;
		// dd($response);
		return $response;
	}

	public static function guardarHojaTrabajo($request){
		$todayh = getdate(); //monday week begin reconvert
		$fecha_creacion = $todayh['year']. '-' .$todayh['mon']. '-' .$todayh['mday']. ' '.$todayh['hours']. ':' .$todayh['minutes']. ':' .$todayh['seconds'];
		$id_tienda = $request->id_tienda_contrato;
		$id_categoria_general = $request->id_categoria;
		$abre_bolsa = $request->subdividir;
		$codigos_contratos = $request->codigo_contrato_table;
		$secuencias = SecuenciaTienda::getCodigosSecuencia($id_tienda,env('SECUENCIA_TIPO_CODIGO_ORDEN'),1);
		$codigoOrden = $secuencias[0]->response;
		$id_orden_guardar = ResolucionarAO::ordenGuardar($id_tienda, $codigos_contratos, $id_categoria_general, $fecha_creacion, $abre_bolsa, $codigoOrden);

		if($id_orden_guardar > 0){
			$items =array();
			$inventario_item_contrato = array();
			$inventario_producto = array();
			for ($i=0; $i < count($request->id_item_table); $i++) {
				$id_inventario = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_contrato, env('SECUENCIA_TIPO_CODIGO_INVENTARIO_ITEM'), 1);
				array_push( $items, [
					"id_orden_guardar" => $id_orden_guardar,
					"codigo_contrato" => $request->codigo_contrato_table[ $i ],
					"id_tienda_contrato" => $id_tienda,
					"id_linea_item" => $request->id_item_table[ $i ],
					"id_proceso" => $request->subdivicion[ $i ],
					"peso_taller" => $request->peso_joyeria[ $i ],
					'id_inventario' => $id_inventario[ 0 ]->response,
					'peso_estimado' => $request->peso_estimado[ $i ],
					'peso_total' => $request->peso_total[ $i ],
					'precio_ingresado' => $request->precio_ingresado[ $i ],
					'fecha_perfeccionamiento' => DB::raw('curdate()')
				] );

				array_push($inventario_item_contrato,
					[
						'id_inventario' => $id_inventario[ 0 ]->response,
						'id_tienda_inventario' => $request->id_tienda_contrato,
						'id_contrato' => $request->codigo_contrato[$i],
						'id_tienda_contrato' => $request->id_tienda_contrato,
						'id_item_contrato' => $request->id_item[$i],
					]
				);

				array_push($inventario_producto,
					[
						'id_inventario' => $id_inventario[ 0 ]->response,
						'id_tienda_inventario' => $request->id_tienda_contrato,
						'id_estado_producto' => 33,
						'id_motivo_producto' => 11,
						'peso' => $request->peso_total[$i],
						'peso_estimado' => $request->peso_estimado[$i],
						'precio_compra' => $request->precio_ingresado[$i],
					]
				);
			}

			$destinatarios = array();
			for ($i=0; $i < count($request->id_proceso); $i++) {
				array_push( $destinatarios, [
					"id_orden_guardar" => $id_orden_guardar,
					"id_proceso" => $request->id_proceso[ $i ],
					"destinatario" => $request->numero_documento[ $i ],
					"codigo_verificacion" => $request->digito_verificacion[ $i ],
					"numero_bolsa" => $request->numero_bolsa[ $i ]
				] );
			}

			for($i=0;$i<count($items);$i++){
				////////TRAZABILIDAD
				$traza['trazabilidad']['id_tienda']=$items[$i]['id_tienda_contrato'];
				$traza['trazabilidad']['id']=$items[$i]['id_inventario'];
				$traza['trazabilidad']['id_origen']=null;
				$traza['trazabilidad']['fecha_salida']=null;
				$traza['trazabilidad']['fecha_ingreso']=date("Y-m-d H:i:s");
				$traza['trazabilidad']['movimiento']=$inventario_producto[$i]['id_motivo_producto'];
				$traza['trazabilidad']['estado']=$inventario_producto[$i]['id_estado_producto'];
				$traza['trazabilidad']['ubicacion']='Joyería';
				$traza['trazabilidad']['categoria']=null;
				$traza['trazabilidad']['motivo']='Perfeccionamiento';
				$traza['trazabilidad']['numero_contrato']=$items[$i]['codigo_contrato'];
				$traza['trazabilidad']['numero_item']=$items[$i]['id_linea_item'];
				$traza['trazabilidad']['numero_orden']=$items[$i]['id_orden_guardar'];
				$traza['trazabilidad']['numero_referente']='Or.'.$codigoOrden;
				TrazabilidadBL::Create($traza);
			}

			ResolucionarAO::ordenGuardarItems($items);
			ResolucionarAO::ordenGuardarDestinatarios($destinatarios);
			ResolucionarAO::ordenGuardarInventario($inventario_item_contrato, $inventario_producto);
		}
		return $id_tienda.'/'.$id_orden_guardar;
	}

	public static function actualizarHojaTrabajo($request){
		$todayh = getdate(); //monday week begin reconvert
		$fecha_creacion = $todayh['year']. '-' .$todayh['mon']. '-' .$todayh['mday']. ' '.$todayh['hours']. ':' .$todayh['minutes']. ':' .$todayh['seconds'];
		$id_tienda = $request->id_tienda_contrato;
		$id_categoria_general = $request->id_categoria;
		$id_orden_guardar = $request->id_orden_guardar;
		$abre_bolsa = $request->subdividir;
		ResolucionarAO::ordenActualizar($id_orden_guardar, $abre_bolsa);
		if($id_orden_guardar > 0){
			$items = [];
			for ($i=0; $i < count($request->id_item_table); $i++) {
				array_push( $items, [
					"id_orden_guardar" => $id_orden_guardar,
					"codigo_contrato" => $request->codigo_contrato_table[ $i ],
					"id_tienda_contrato" => $id_tienda,
					"id_linea_item" => $request->id_item_table[ $i ],
					"id_proceso" => $request->subdivicion[ $i ],
					"peso_taller" => $request->peso_joyeria[ $i ],
					'id_inventario' => $request->id_inventario[ $i ]
				] );
			}

			$destinatarios = [];
			for ($i=0; $i < count($request->id_proceso); $i++) {
				array_push( $destinatarios, [
					"id_orden_guardar" => $id_orden_guardar,
					"id_proceso" => $request->id_proceso[ $i ],
					"destinatario" => $request->numero_documento[ $i ],
					"codigo_verificacion" => $request->digito_verificacion[ $i ],
					"numero_bolsa" => $request->numero_bolsa[ $i ]
				] );
			}
			ResolucionarAO::ordenActualizarItems($id_orden_guardar, $items);
			ResolucionarAO::ordenActualizarDestinatarios($id_orden_guardar, $destinatarios);
		}
		return $id_orden_guardar;
	}

	public static function eliminarOrdenGuardada($id){
		return ResolucionarAO::eliminarOrdenGuardada($id);
	}

	public static function agregarContrato($request){
		$id_orden_guardar = $request->id_orden_guardar;
		$id_tienda = $request->id_tienda_contrato;
		$codigos_contratos = explode("-", $request->codigos_contratos);
		ResolucionarAO::inactivarContratos($id_tienda, $codigos_contratos);
		if($id_orden_guardar > 0){
			$items = [];
			$inventario_item_contrato = array();
			$inventario_producto = array();
			$items_contratos = ResolucionarAO::getItemsContrato($id_tienda, $codigos_contratos);
			for($i = 0; $i < count($items_contratos); $i++){
				$id_inventario = SecuenciaTienda::getCodigosSecuencia($id_tienda, env('SECUENCIA_TIPO_CODIGO_INVENTARIO_ITEM'), 1);
				array_push( $items, [
					"id_orden_guardar" => $id_orden_guardar,
					"codigo_contrato" => $items_contratos[ $i ]->codigo_contrato,
					"id_tienda_contrato" => $items_contratos[ $i ]->id_tienda_contrato,
					"id_linea_item" => $items_contratos[ $i ]->id_linea_item_contrato,
					'id_inventario' => $id_inventario[ 0 ]->response,
					'peso_estimado' => $items_contratos[ $i ]->peso_estimado,
					'peso_total' => $items_contratos[ $i ]->peso_total,
					'precio_ingresado' => $items_contratos[ $i ]->precio_ingresado,
					'fecha_perfeccionamiento' => DB::raw('curdate()')
				] );

				array_push($inventario_item_contrato,
					[
						'id_inventario' => $id_inventario[ 0 ]->response,
						'id_tienda_inventario' => $items_contratos[ $i ]->id_tienda_contrato,
						'id_contrato' => $items_contratos[ $i ]->codigo_contrato,
						'id_tienda_contrato' => $items_contratos[ $i ]->id_tienda_contrato,
						'id_item_contrato' => $items_contratos[ $i ]->id_linea_item_contrato
					]
				);

				array_push($inventario_producto,
					[
						'id_inventario' => $id_inventario[ 0 ]->response,
						'id_tienda_inventario' => $items_contratos[ $i ]->id_tienda_contrato,
						'id_estado_producto' => 33,
						'id_motivo_producto' => 11
					]
				);
			}
			ResolucionarAO::ordenGuardarItems($items);
			ResolucionarAO::ordenGuardarInventario($inventario_item_contrato, $inventario_producto);
		}
		return response()->json($id_orden_guardar);
	}

	public static function quitarContrato($request){
		$id_tienda = $request->id_tienda;
		$codigo_contrato = $request->codigo_contrato;
		$id_proceso = $request->id_proceso;
		ResolucionarAO::quitarContrato($id_tienda, $codigo_contrato, $id_proceso);
		
		return response()->json($codigo_contrato);
	}

	public static function getOrdenPDF($id_orden, $id_tienda){
		return ResolucionarAO::getOrdenPDF($id_orden, $id_tienda);
	}

	public static function getReportePDF($codigo_contrato, $id_tienda){
		return ResolucionarAO::getReportePDF($codigo_contrato, $id_tienda);
	}

	public static function getReportePDFOrdenGuardada($codigo_contrato, $id_tienda){
		return ResolucionarAO::getReportePDFOrdenGuardada($codigo_contrato, $id_tienda);
	}

	public static function generateExcel($id_orden, $id_tienda){
		$resolucionarExcel=new ResolucionarExcel();
		$resolucionar =ResolucionarAO::getOrdenExcel($id_orden, $id_tienda);
        return $resolucionarExcel->generateExcel($resolucionar);
	}

	public static function validarPerfeccionamiento($cat_gen, $id_tienda){
		$result = false;
		if(ResolucionarAO::validarPerfeccionamiento($cat_gen, $id_tienda) > 0){
			$result =true;
		}else{
			$result = false;
		}
		return $result;
	}
}

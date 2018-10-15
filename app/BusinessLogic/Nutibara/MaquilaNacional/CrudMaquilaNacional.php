<?php 

namespace App\BusinessLogic\Nutibara\MaquilaNacional;
use App\AccessObject\Nutibara\MaquilaNacional\MaquilaNacional;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\BusinessLogic\Utility\validarMotivo;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use App\BusinessLogic\Nutibara\Excel\Resolucion\OrdenesResolucionExcel;
use App\AccessObject\Nutibara\Contratos\Contrato;
use config\messages;
use dateFormate;
use DB;


class CrudMaquilaNacional {

	public static function get($request)
	{
		$start = (int)$request->start;
		$end = (int)$request->length;
		$draw = (int)$request->draw;
		$colum = $request->columns[(int)$request->order[0]['column']]['data'];
		$order = $request->order[0]['dir'];
		$vowels = array("$","^");
		$search["id_tienda"] = str_replace($vowels,"",$request->columns[0]['search']['value']);
		$search["id_categoria"] = str_replace($vowels,"",$request->columns[1]['search']['value']);
		$search["estado"] = str_replace($vowels,"",$request->columns[2]['search']['value']);
		
		if($search["estado"] == 1){
			$search["estado"] = (int)env('ORDEN_PENDIENTE_POR_PROCESAR');
		}elseif($search["estado"] == 2){
			$search["estado"] = (int)env('ORDEN_PROCESADA');
		}

		$total = count(MaquilaNacional::get($start,$end,$colum,$order,$search));
		$data = [
			"draw" => $draw,
			"recordsTotal" => $total,
			"recordsFiltered" => $total,
			"data" => dateFormate::ToArrayInverse(MaquilaNacional::get($start,$end,$colum,$order,$search)->toArray())
		];
		return response()->json($data);
	}

	public static function getTiendaByIp($ip){
		return MaquilaNacional::getTiendaByIp($ip);
	}

	public static function procesarUpdate($data,$ordenes)
	{

		$respuesta = MaquilaNacional::procesarUpdate($data,$ordenes);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$MaquilaNacional['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$MaquilaNacional['ok'],'val'=>'Actualizado'];	
		}
		return $msm;	
	}

	public static function Procesar($dataSaved)
	{
		$id_orden = explode("-", $dataSaved['numero_orden']);		
		// if($dataSaved['procesar'] == 1)
		//  {
		// 	$respuesta =  MaquilaNacional::Procesar($dataSaved,$id_orden);
		// 	$idOrdenes = $id_orden;
		// 	if($respuesta=='Error')
		// 	{
		// 		$msm=['msm'=>Messages::$Orden['error'],'val'=>'Error'];		
		// 	}
		// 	elseif($respuesta=='ErrorUnico')
		// 	{
		// 		$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		// 	}
		// 	elseif($respuesta=='Actualizado')
		// 	{
		// 		// for($i = 0; $i < count($dataSaved["peso_taller"]); $i++){
		// 		// 	if($dataSaved["peso_taller"][$i] != $dataSaved["peso_estimado"][$i]){
		// 		// 		$id_movimientocontable = ( $dataSaved["peso_taller"][$i] < $dataSaved["peso_estimado"][$i] ) ? 57 : 58; // ? 49 : 50;
		// 		// 		$diferencia_peso = abs($dataSaved["peso_taller"][$i] - $dataSaved["peso_estimado"][$i]);
		// 		// 		$valor_x_1 = $dataSaved["precio_ingresado"][$i] / $dataSaved["peso_estimado"][$i];
		// 		// 		$valor = $dataSaved["peso_taller"][$i] * $valor_x_1;
		// 		// 		MovimientosTesoreria::registrarCausacion($valor,$dataSaved["id_tienda_orden"][$i],$id_movimientocontable,NULL,"MERMO-".$dataSaved["id_tienda_orden"][$i]);
		// 		// 		dd($id_movimientocontable);
		// 		// 	}
		// 		// }
		// 		$msm=['msm'=>Messages::$Orden['procesada'],'val'=>'Actualizado', 'ordenes' => $idOrdenes];	
		// 	}
		// 	return $msm;
		//  }
		// else
		// {
			for ($i=0; $i < count($dataSaved['id_proceso']) ; $i++)
			{	
				$item = 0;				
				if($dataSaved['id_proceso'][$i] != env('ID_TEMA_JOYA_ESPECIAL')){
					/*Preparar Crear Ordenes*/ 
					$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'],env('SECUENCIA_TIPO_CODIGO_ORDEN'),1);
					$codigoOrden = $secuencias[0]->response;
					$CrearOrdenes[$i]['id_orden'] = $codigoOrden;
					$idOrdenes[$i] = $codigoOrden;
					$CrearOrdenes[$i]['id_tienda_orden'] = $dataSaved['id_tienda_orden'];
					$CrearOrdenes[$i]['id_hoja_trabajo'] = $dataSaved['id_hoja_trabajo'];
					$CrearOrdenes[$i]['id_tienda_hoja_trabajo'] = $dataSaved['id_tienda_orden'];
					$CrearOrdenes[$i]['proceso'] = $dataSaved['id_proceso'][$i] ;
					$CrearOrdenes[$i]['fecha_creacion'] = date('Y-m-d H:i:s');
					$CrearOrdenes[$i]['estado'] = env('ORDEN_PENDIENTE_POR_PROCESAR');
					$CrearOrdenes[$i]['id_cliente'] = $dataSaved['id_cliente_destinatario'][$i] ;
					$CrearOrdenes[$i]['id_tienda_cliente'] = $dataSaved['id_tienda_cliente_destinatario'][$i];
					$CrearOrdenes[$i]['id_sucursal'] = $dataSaved['sucursales'][$i];
					$CrearOrdenes[$i]['mano_obra'] = $dataSaved['mano_obra'];
					$CrearOrdenes[$i]['transporte'] = $dataSaved['transporte'];
					$CrearOrdenes[$i]['costos_indirectos'] = $dataSaved['costos_indirectos'];
					$CrearOrdenes[$i]['otros_costos'] = $dataSaved['otros_costos'];

					/*Preparar Ordenes Nuevas para  Trazabilidad.*/
					$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'],env('SECUENCIA_TIPO_CODIGO_TRAZABILIDAD'),1);
					$codigoTrazabilidad = $secuencias[0]->response;
					$CrearTrazabilidad[$i]['id_trazabilidad'] = $codigoTrazabilidad;
					$CrearTrazabilidad[$i]['id_tienda_trazabilidad'] = $dataSaved['id_tienda_orden'];
					$CrearTrazabilidad[$i]['id_orden'] = $codigoOrden;
					$CrearTrazabilidad[$i]['id_tienda_orden']  = $dataSaved['id_tienda_orden'];
					$CrearTrazabilidad[$i]['actual'] = 1;
					$CrearTrazabilidad[$i]['fecha_accion'] = date('Y-m-d H:i:s');
					$CrearTrazabilidad[$i]['accion'] = 'Creado';
					

					/*Asociar Items a las nuevas Ordenes*/
					for ($k=0; $k < count($dataSaved['id_inventario']) ; $k++) 
					{ 
						if($dataSaved['subdivision'][$k] == $dataSaved['id_proceso'][$i])
						{
							$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'],env('SECUENCIA_TIPO_CODIGO_ITEM_ORDEN'),1);
							$codigoOrdenItem = $secuencias[0]->response;
							$ItemsXOrden[$i][$item]['id_inventario'] = $dataSaved['id_inventario'][$k];		
							$ItemsXOrden[$i][$item]['id_tienda_inventario'] = $dataSaved['id_tienda_orden'];						
							$ItemsXOrden[$i][$item]['id_orden'] = $codigoOrden;						
							$ItemsXOrden[$i][$item]['id_orden_item'] = $codigoOrdenItem;
							$ItemsXOrden[$i][$item]['id_tienda_orden'] = $dataSaved['id_tienda_orden'];						
							$ItemsXOrden[$i][$item]['id_tienda_orden_item'] = $dataSaved['id_tienda_orden'];
							$ItemsXOrden[$i][$item]['peso_taller'] = $dataSaved['peso_taller'][$k];
							$item ++;
						}
						MaquilaNacional::updateEstadoInventario($dataSaved['id_inventario'][$k],$dataSaved['id_tienda_orden'],validarMotivo::GetMotivo($dataSaved['id_proceso'][$i]),validarMotivo::GetEstado());
						
					}
				}else{
					
					for ($k=0; $k < count($dataSaved['id_inventario']); $k++) 
					{ 
						
						if($dataSaved['subdivision'][$k] == env('ID_TEMA_JOYA_ESPECIAL'))
						{
							$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'],env('SECUENCIA_TIPO_CODIGO_ORDEN'),1);
							$codigoOrden = $secuencias[0]->response;
							$CrearOrdenes[$dataSaved['id_inventario'][$k]]['id_orden'] = $codigoOrden;
							$idOrdenes[$dataSaved['id_inventario'][$k]] = $codigoOrden;
							$CrearOrdenes[$dataSaved['id_inventario'][$k]]['id_tienda_orden'] = $dataSaved['id_tienda_orden'];
							$CrearOrdenes[$dataSaved['id_inventario'][$k]]['id_hoja_trabajo'] = $dataSaved['id_hoja_trabajo'];
							$CrearOrdenes[$dataSaved['id_inventario'][$k]]['id_tienda_hoja_trabajo'] = $dataSaved['id_tienda_orden'];
							$CrearOrdenes[$dataSaved['id_inventario'][$k]]['proceso'] = $dataSaved['id_proceso'][$i] ;
							$CrearOrdenes[$dataSaved['id_inventario'][$k]]['fecha_creacion'] = date('Y-m-d H:i:s');
							$CrearOrdenes[$dataSaved['id_inventario'][$k]]['estado'] = env('ORDEN_PENDIENTE_POR_PROCESAR');
							$CrearOrdenes[$dataSaved['id_inventario'][$k]]['id_cliente'] = $dataSaved['id_cliente_destinatario'][$i] ;
							$CrearOrdenes[$dataSaved['id_inventario'][$k]]['id_tienda_cliente'] = $dataSaved['id_tienda_cliente_destinatario'][$i];
							$CrearOrdenes[$dataSaved['id_inventario'][$k]]['id_sucursal'] = $dataSaved['sucursales'][$i];

							/*Preparar Ordenes Nuevas para  Trazabilidad.*/
							$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'],env('SECUENCIA_TIPO_CODIGO_TRAZABILIDAD'),1);
							$codigoTrazabilidad = $secuencias[0]->response;
							$CrearTrazabilidad[$dataSaved['id_inventario'][$k]]['id_trazabilidad'] = $codigoTrazabilidad;
							$CrearTrazabilidad[$dataSaved['id_inventario'][$k]]['id_tienda_trazabilidad'] = $dataSaved['id_tienda_orden'];
							$CrearTrazabilidad[$dataSaved['id_inventario'][$k]]['id_orden'] = $codigoOrden;
							$CrearTrazabilidad[$dataSaved['id_inventario'][$k]]['id_tienda_orden']  = $dataSaved['id_tienda_orden'];
							$CrearTrazabilidad[$dataSaved['id_inventario'][$k]]['actual'] = 1;
							$CrearTrazabilidad[$dataSaved['id_inventario'][$k]]['fecha_accion'] = date('Y-m-d H:i:s');
							$CrearTrazabilidad[$dataSaved['id_inventario'][$k]]['accion'] = 'Creado';

							$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'],env('SECUENCIA_TIPO_CODIGO_ITEM_ORDEN'),1);
							$codigoOrdenItem = $secuencias[0]->response;
							$ItemsXOrden[$dataSaved['id_inventario'][$k]][$item]['id_inventario'] = $dataSaved['id_inventario'][$k];		
							$ItemsXOrden[$dataSaved['id_inventario'][$k]][$item]['id_tienda_inventario'] = $dataSaved['id_tienda_orden'];						
							$ItemsXOrden[$dataSaved['id_inventario'][$k]][$item]['id_orden'] = $codigoOrden;						
							$ItemsXOrden[$dataSaved['id_inventario'][$k]][$item]['id_orden_item'] = $codigoOrdenItem;
							$ItemsXOrden[$dataSaved['id_inventario'][$k]][$item]['id_tienda_orden'] = $dataSaved['id_tienda_orden'];						
							$ItemsXOrden[$dataSaved['id_inventario'][$k]][$item]['id_tienda_orden_item'] = $dataSaved['id_tienda_orden'];
							$ItemsXOrden[$dataSaved['id_inventario'][$k]][$item]['peso_taller'] = $dataSaved['peso_taller'][$k];
							$item ++;
							MaquilaNacional::updateEstadoInventario($dataSaved['id_inventario'][$k],$dataSaved['id_tienda_orden'],validarMotivo::GetMotivo($dataSaved['id_proceso'][$i]),validarMotivo::GetEstado());
						}

					}					
				}
			}
			/*Actualiza ordenes en Trazabilidad. y ordenes*/
			for($i=0; $i<count($id_orden); $i++)
			{
				$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'],env('SECUENCIA_TIPO_CODIGO_TRAZABILIDAD'),1);
				$codigoTrazabilidad =$secuencias[0]->response;
				$AntiguaTrazabilidad[$i]['id_trazabilidad'] = $codigoTrazabilidad;
				$AntiguaTrazabilidad[$i]['id_tienda_trazabilidad'] = $dataSaved['id_tienda_orden'];
				$AntiguaTrazabilidad[$i]['id_orden'] = $id_orden[$i];
				$AntiguaTrazabilidad[$i]['id_tienda_orden']  = $dataSaved['id_tienda_orden'];
				$AntiguaTrazabilidad[$i]['actual'] = 0;
				$AntiguaTrazabilidad[$i]['fecha_accion'] = date('Y-m-d H:i:s');
				$AntiguaTrazabilidad[$i]['accion'] = 'Subdividido';
				$AntiguaTrazabilidad[$i]['estado'] = env('ORDEN_PROCESADA');
			}


			$datosPreparados['CrearOrdenes'] = array_values($CrearOrdenes);
			$datosPreparados['CrearTrazabilidad'] = array_values($CrearTrazabilidad);
			$datosPreparados['ItemsXOrden'] = array_values($ItemsXOrden);
			$datosPreparados['AntiguaTrazabilidad'] = array_values($AntiguaTrazabilidad);

			$respuesta = MaquilaNacional::Procesarsubdividir($datosPreparados);
			if($respuesta=='Error')
			{
				$msm=['msm'=>Messages::$Orden['error'],'val'=>'Error'];		
			}
			elseif($respuesta=='ErrorUnico')
			{
				$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
			}
			elseif($respuesta=='Insertado')
			{
				$mano_obra = ($dataSaved["mano_obra"] == "") ? 0 : $dataSaved["mano_obra"];
				$transporte = ($dataSaved["transporte"] == "") ? 0 : $dataSaved["transporte"];
				$costos_indirectos = ($dataSaved["costos_indirectos"] == "") ? 0 : $dataSaved["costos_indirectos"];
				$otros_costos = ($dataSaved["otros_costos"] == "") ? 0 : $dataSaved["otros_costos"];
				$peso_total = array_sum($dataSaved['peso_taller']);
				$costo_adicional = ($mano_obra + $transporte + $costos_indirectos + $otros_costos) / $peso_total;

				$msm=['msm'=>Messages::$Orden['subdividida'],'val'=>'Insertado', 'ordenes' => array_values($idOrdenes)];
				for($i = 0; $i < count($dataSaved["peso_taller"]); $i++){
					$peso_taller = ($dataSaved["peso_taller"][$i] == "") ? 0 : $dataSaved["peso_taller"][$i];
					$peso_estimado = ($dataSaved["peso_estimado"][$i] == "") ? 0 : $dataSaved["peso_estimado"][$i];
					$precio_ingresado = ($dataSaved["precio_ingresado"][$i] == "") ? 0 : $dataSaved["precio_ingresado"][$i];
					
					if($peso_taller != $peso_estimado){
						$id_movimientocontable = ( $peso_taller < $peso_estimado ) ? 57 : 58; // ? 49 : 50;
						$diferencia_peso = abs($peso_taller - $peso_estimado);
						$valor_x_1 = $precio_ingresado / $peso_estimado;
						$valor = ($diferencia_peso * $valor_x_1) + $costo_adicional;
						MovimientosTesoreria::registrarCausacion($valor,$dataSaved["id_tienda_orden"],$id_movimientocontable,NULL,"MERMO-".$dataSaved["id_tienda_orden"]."/".$dataSaved["id_inventario"][$i]);
					}
				}
			 }
			 return $msm;
		// }
	}


	public static function getItemOrden($id_tienda,$id)
	{
		return MaquilaNacional::getItemOrden($id_tienda,$id);
	}

	public static function getItemOrdenConcat($id_tienda,$id)
	{
		return MaquilaNacional::getItemOrdenConcat($id_tienda,$id);
	}

	public static function getDestinatariosOrden($id_tienda,$id)
	{
		return MaquilaNacional::getDestinatariosOrden($id_tienda,$id);
	}

	public static function getDestinatariosOrdenPadre($id_tienda,$id)
	{
		return MaquilaNacional::getDestinatariosOrdenPadre($id_tienda,$id);
	}

	public static function getMaquilaNacionalById($id)
	{
		return MaquilaNacional::getMaquilaNacionalById($id);
	}

	public static function getSelectList()
	{
		return MaquilaNacional::getSelectList();
	}

	public static function getListProceso()
	{
		return MaquilaNacional::getListProceso();
	}

	public static function getListProcesoByVitrina()
	{
		return MaquilaNacional::getListProcesoByVitrina();
	}

	public static function validarItem($id_tienda_inventario,$id_inventario,$id_contrato)
	{
		return MaquilaNacional::validarItem($id_tienda_inventario,$id_inventario,$id_contrato);
	}

	public static function quitarItems($items)
	{
		$items = explode(",", $items);
		$id_contrato = "";
		$id_tienda_inventario = "";
		$id_inventario = "";
		$id_orden="";
		for($i = 0; $i < count($items); $i++)
		{
			$item = explode("-",$items[$i]);
			$id_tienda_inventario = $item[0];
			$id_inventario .= $item[1].",";
			$id_contrato = $item[2];
			$id_orden = $item[3];
		}
		$id_inventario = explode(',',$id_inventario);
		$retorno = MaquilaNacional::quitarItems($id_inventario,$id_tienda_inventario,$id_contrato);
		$items = MaquilaNacional::validarItem($id_tienda_inventario,$id_inventario,$id_contrato);
		if(count($items) == 0)	MaquilaNacional::anularOrdenesTraza([$id_orden], $id_tienda_inventario);
		return $retorno;
	}

	public static function AnularOrden($items)
	{
		$items_string = "";
		$id_orden = 0;
		$id_tienda_orden = 0;
		for($i = 0; $i < count($items); $i++)
		{
			$id_orden = $items[$i]->id_orden;
			$id_tienda_orden = $items[$i]->id_tienda_orden;
			$items_string .= $items[$i]->inventario;
			$items_string .= (($i + 1) < count($items)) ? "," : "";
		}
		$id_orden_padre = MaquilaNacional::getIdOrdenPadre($id_orden, $id_tienda_orden);
		if(self::validarEstadoHojaTrabajo($id_orden, $id_tienda_orden, $id_orden_padre))
		{
			MaquilaNacional::AnularOrden($id_orden, $id_tienda_orden, $id_orden_padre);
			$response = true;
		}else {
			$response = false;
		}
		// $retorno = self::quitarItems($items_string);

		return $response;
	}

	public static function validarEstadoHojaTrabajo($id_orden, $id_tienda_orden, $id_orden_padre){
		$result = false;
		try
		{
			$cant_orden_procesadas = MaquilaNacional::countOrdenesProcesadas($id_orden_padre, $id_tienda_orden);
			$result = ($cant_orden_procesadas > 0) ? false : true;
		}
		catch(\Exception $ex)
		{
			$result = false;
			dd($ex);
		}
		return $result;
	}

	public static function generateExcel($id_orden, $id_tienda,$process){
		$resolucionarExcel=new OrdenesResolucionExcel($process);
		$resolucionar =MaquilaNacional::getOrdenExcel($id_orden, $id_tienda);
        return $resolucionarExcel->generateExcel($resolucionar);
	}

	public static function getItemsMineria($id_orden, $id_tienda){
		return MaquilaNacional::getItemOrden($id_tienda, $id_orden);
	}

	public static function datosPerfeccionamiento($id_tienda, $id_contrato){
		return MaquilaNacional::datosPerfeccionamiento($id_tienda, $id_contrato);
	}

	public static function getPorcentTolerancia(){
		return MaquilaNacional::getPorcentTolerancia();
	}

	public static function getReferencias($id_categoria){
		return MaquilaNacional::getReferencias($id_categoria);
	}

	public static function transformacionglobal($id_tienda, $id){
		$idx = explode("-",$id);
		$items = self::getItemOrden($id_tienda,$idx);
		if(isset($items[0]->id_contrato)){
			$datos_perfeccionamiento = self::datosPerfeccionamiento($id_tienda, $items[0]->id_contrato);
		}
		$destinatarios = self::getDestinatariosOrden($id_tienda,$idx);
		$porcentaje_tolerancia = self::getPorcentTolerancia();
		$referencias = self::getReferencias($items[0]->id_categoria);
		$contratos = array();
		foreach ($items as $key => $value){
			array_push($contratos, $value->id_contrato);
		}
		$columnas_items = Contrato::getColumnasItems( $contratos, $id_tienda );
		$datos_columnas_items = Contrato::getDatosColumnasItems( $contratos, $id_tienda );
		if($items[0]->categoria == "Articulo" || $items[0]->categoria == "Artículo" || $items[0]->categoria == "Artículos"){
			$procesos = self::getListProcesoByVitrina();
		}else{
			$procesos = self::getListProceso();
		}
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/maquilanacional',
				'text'=>'Gestión de contratos'
			],
			[
				'href'=>'contrato/maquilanacional',
				'text'=>'Maquila nacional de órdenes'
			],
			[
				'href' => '#',
				'text' => 'Maquila nacional de órdenes'
			],
		);
		return view('MaquilaNacional.transformacionglobal',[
											'urls'=>$urls,
											'procesos'=>$procesos,
											'id' => $id,
											'id_tienda_orden' => $id_tienda,
											'items'=>$items,
											'destinatarios' => $destinatarios,
											'columnas_items' => $columnas_items,
											'datos_columnas_items' => $datos_columnas_items,
											'datos_perfeccionamiento' => $datos_perfeccionamiento,
											'porcentaje_tolerancia' => $porcentaje_tolerancia,
											'referencias' => $referencias
										]);
	}

	public static function transformacionglobalProcesar($request){
		$data = array();
		for ($i=0; $i < count($request->referencia); $i++) { 
			for ($j=0; $j < count($request->transf_cantidad[$i]); $j++) { 
				$id_inventario = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_orden, env('SECUENCIA_TIPO_CODIGO_INVENTARIO_ITEM'), 1);
				array_push($data, [
					'id_inventario' => $id_inventario[ 0 ]->response,
					'id_tienda_inventario' => $request->id_tienda_orden,
					'id_estado_producto' => 33,
					'id_motivo_producto' => 11,
					'id_catalogo_producto' => $request->referencia[$i],
					'peso' => $request->transf_peso_total[$i],
					'fecha_ingreso' => DB::raw('now()'),
					'es_nuevo' => 1,
					'cantidad' => 1
				]);
			}
		}
		return MaquilaNacional::transformacionglobalProcesar($data, $request);
	}
}
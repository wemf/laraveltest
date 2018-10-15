<?php 

namespace App\BusinessLogic\Nutibara\Refaccion;
use App\AccessObject\Nutibara\Refaccion\Refaccion;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\BusinessLogic\Utility\validarMotivo;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use App\BusinessLogic\Nutibara\Excel\Resolucion\OrdenesResolucionExcel;
use App\BusinessLogic\Nutibara\Inventario\Trazabilidad\TrazabilidadBL;
use config\messages;
use dateFormate;


class CrudRefaccion {

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

		$total = count(Refaccion::get($start,$end,$colum,$order,$search));
		$data = [
			"draw" => $draw,
			"recordsTotal" => $total,
			"recordsFiltered" => $total,
			"data" => dateFormate::ToArrayInverse(Refaccion::get($start,$end,$colum,$order,$search)->toArray())
		];
		return response()->json($data);
	}

	public static function getTiendaByIp($ip){
		return Refaccion::getTiendaByIp($ip);
	}

	public static function procesarUpdate($data,$ordenes)
	{

		$respuesta = Refaccion::procesarUpdate($data,$ordenes);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Refaccion['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Refaccion['ok'],'val'=>'Actualizado'];	
		}
		return $msm;	
	}

	public static function Procesar($dataSaved)
	{
		$id_orden = explode("-", $dataSaved['numero_orden']);		
		// if($dataSaved['procesar'] == 1)
		//  {
		// 	$respuesta =  Refaccion::Procesar($dataSaved,$id_orden);
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
					
					// [ASHY] - Datos para la trazabilidad entre órdenes
					$CrearTrazabilidad[$i]['id_traza_padre'] = $id_orden[0];
					$CrearTrazabilidad[$i]['id_tienda_traza_padre'] = $dataSaved['id_tienda_orden'];
					// [ASHY] - Fin ↑
					

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
						Refaccion::updateEstadoInventario($dataSaved['id_inventario'][$k],$dataSaved['id_tienda_orden'],validarMotivo::GetMotivo($dataSaved['id_proceso'][$i]),validarMotivo::GetEstado());
						
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
							Refaccion::updateEstadoInventario($dataSaved['id_inventario'][$k],$dataSaved['id_tienda_orden'],validarMotivo::GetMotivo($dataSaved['id_proceso'][$i]),validarMotivo::GetEstado());
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

			$respuesta = Refaccion::Procesarsubdividir($datosPreparados);
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
						$valor_x_1 = ($peso_estimado > 0) ? $precio_ingresado / $peso_estimado : 0;
						$valor = ($diferencia_peso * $valor_x_1) + $costo_adicional;
						MovimientosTesoreria::registrarCausacion($valor,$dataSaved["id_tienda_orden"],$id_movimientocontable,NULL,"MERMO-".$dataSaved["id_tienda_orden"]."/".$dataSaved["id_inventario"][$i]);
					}
				}
				
				////////TRAZABILIDAD DEL ID
				for($j=0;$j<count($datosPreparados['ItemsXOrden']);$j++){
					for($i=0;$i<count($datosPreparados['ItemsXOrden'][$j]);$i++){
						$traza['trazabilidad']['id_tienda']=$datosPreparados['ItemsXOrden'][$j][$i]['id_tienda_inventario'];
						$traza['trazabilidad']['id']=$datosPreparados['ItemsXOrden'][$j][$i]['id_inventario'];
						$traza['trazabilidad']['id_origen']=null;
						$traza['trazabilidad']['fecha_salida']=null;
						$traza['trazabilidad']['movimiento']=$datosPreparados['CrearOrdenes'][$j]['proceso'];
						$traza['trazabilidad']['estado']=$datosPreparados['CrearOrdenes'][$j]['estado'];
						$traza['trazabilidad']['fecha_ingreso']=date("Y-m-d H:i:s");
						$traza['trazabilidad']['ubicacion']='Taller';
						$traza['trazabilidad']['motivo']='Refacción';
						$traza['trazabilidad']['numero_contrato']=$datosPreparados['CrearOrdenes'][$j]['id_hoja_trabajo'];
						$traza['trazabilidad']['numero_item']=$i+1;
						$traza['trazabilidad']['numero_orden']=$datosPreparados['CrearOrdenes'][$j]['id_orden'];
						$traza['trazabilidad']['numero_referente']='Perf.'.$datosPreparados['CrearOrdenes'][$j]['id_orden'];
						TrazabilidadBL::Create($traza);
					}
				}
			 }
			 return $msm;
		// }
	}


	public static function getItemOrden($id_tienda,$id)
	{
		return Refaccion::getItemOrden($id_tienda,$id);
	}

	public static function getItemOrdenConcat($id_tienda,$id)
	{
		return Refaccion::getItemOrdenConcat($id_tienda,$id);
	}

	public static function getDestinatariosOrden($id_tienda,$id)
	{
		return Refaccion::getDestinatariosOrden($id_tienda,$id);
	}

	public static function getDestinatariosOrdenPadre($id_tienda,$id)
	{
		return Refaccion::getDestinatariosOrdenPadre($id_tienda,$id);
	}

	public static function getRefaccionById($id)
	{
		return Refaccion::getRefaccionById($id);
	}

	public static function getSelectList()
	{
		return Refaccion::getSelectList();
	}

	public static function getListProceso()
	{
		return Refaccion::getListProceso();
	}

	public static function getListProcesoByVitrina()
	{
		return Refaccion::getListProcesoByVitrina();
	}

	public static function validarItem($id_tienda_inventario,$id_inventario,$id_contrato)
	{
		return Refaccion::validarItem($id_tienda_inventario,$id_inventario,$id_contrato);
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
		$items = Refaccion::validarquitarItem($id_tienda_inventario,$id_inventario,$id_contrato);
		if(count($items) == 0){
			Refaccion::anularOrdenesTraza([$id_orden], $id_tienda_inventario);
			$retorno = Refaccion::quitarItems($id_inventario,$id_tienda_inventario,$id_contrato);
			 
			$items = Refaccion::validarOrden($id_tienda_inventario,$id_orden);
		 	//validar cantidad de items para actualizar el estado de la orden
			if(count($items) == 0)	Refaccion::updateEstadoOrden($id_tienda_inventario,$id_orden);
		}	else{
			$retorno = 3;
		}
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
		$id_orden_padre = Refaccion::getIdOrdenPadre($id_orden, $id_tienda_orden);
		$puede_procesar = self::validarEstadoHojaTrabajo($id_orden, $id_tienda_orden, $id_orden_padre);
		$response = 1;
		if($puede_procesar == 1)
		{
			if($id_orden_padre != null){
					$response = Refaccion::AnularOrden($id_orden, $id_tienda_orden, $id_orden_padre);
			}else{
				$response = 0;
			}
			if($response == 0){
				$response = self::quitarItems($items_string);
			}
		}else{
			// Estado 2 = no puede anular porque hay órdenes procesadas.
			$response = 2;
		}
		// $retorno = self::quitarItems($items_string);

		return $response;
	}

	public static function validarEstadoHojaTrabajo($id_orden, $id_tienda_orden, $id_orden_padre){
		$result = 0;
		try
		{
			$cant_orden_procesadas = Refaccion::countOrdenesProcesadas($id_orden_padre, $id_tienda_orden);
			$result = ($cant_orden_procesadas > 0) ? 0 : 1;
		}
		catch(\Exception $ex)
		{
			$result = 0;
			dd($ex);
		}
		return $result;
	}

	public static function generateExcel($id_orden, $id_tienda,$process){
		$resolucionarExcel=new OrdenesResolucionExcel($process);
		$resolucionar =Refaccion::getOrdenExcel($id_orden, $id_tienda);
        return $resolucionarExcel->generateExcel($resolucionar);
	}

	public static function getItemsMineria($id_orden, $id_tienda){
		return Refaccion::getItemOrden($id_tienda, $id_orden);
	}
}
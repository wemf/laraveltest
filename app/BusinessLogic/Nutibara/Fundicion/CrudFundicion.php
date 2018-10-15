<?php 

namespace App\BusinessLogic\Nutibara\Fundicion;
use App\AccessObject\Nutibara\Fundicion\Fundicion;
use App\AccessObject\Nutibara\Refaccion\Refaccion;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\BusinessLogic\Utility\validarMotivo;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use App\BusinessLogic\Nutibara\Excel\Resolucion\OrdenesResolucionExcel;
use App\BusinessLogic\Nutibara\Inventario\Trazabilidad\TrazabilidadBL;
use config\messages;
use Illuminate\Support\Facades\Session;
use dateFormate;


class CrudFundicion {

	public static function get($request)
	{
		$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];
		$order=$request->order[0]['dir'];
		$vowels = array("$", "^");
		$search["id_tienda"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["id_categoria"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["id_estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);

		if ( $search[ "id_estado" ] == 1 ) {
			$search[ "id_estado" ] = ( int )  env( 'ORDEN_PENDIENTE_POR_PROCESAR' );
		} else if ( $search[ "id_estado" ] == 2 ){
			$search[ "id_estado" ] = ( int ) env( 'ORDEN_PROCESADA' );
		} else if ( $search[ "id_estado" ] == 0 ){
			$search[ "id_estado" ] = ( int ) env( 'ANULADA_PREREFACCION' );
		} else if ( $search[ "id_estado" ] == 3 ){ 
			$search[ "id_estado" ] = ( int ) env( 'ORDEN_PROCESADA_MERMA_FUNDICION' );
		}
		
		$total=count(Fundicion::countFundicion($search));
		$data=[
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data" => dateFormate::ToArrayInverse(Fundicion::get( $start, $end, $colum, $order, $search )->toArray())
		];
		return response()->json($data);
	}

	public static function getTiendaByIp($ip){
		return Fundicion::getTiendaByIp($ip);
	}

	public static function procesarUpdate($data,$ordenes)
	{
		$respuesta = Fundicion::procesarUpdate($data,$ordenes);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Fundicion['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Fundicion['ok'],'val'=>'Actualizado'];	
		}
		return $msm;	
	}

	public static function datosPerfeccionamiento($id_tienda, $id_contrato){
		return Fundicion::datosPerfeccionamiento($id_tienda, $id_contrato);
	}

	public static function Procesar($dataSaved)
	{
		$id_orden = explode("-", $dataSaved['numero_orden']);
		$destinatarios = array();
		$nuevo_peso_item = array();
		$merma_por_item = explode(',', $dataSaved['merma_por_item']);

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

					/*Preparar la información de los destinatarios para generar el reporte PDF al subdividir*/
					$destinatarios[$i] = [
						"id_orden" => $codigoOrden,
						"id_tienda_orden" =>  $dataSaved['id_tienda_orden'],
						"id_proceso" => $dataSaved['id_proceso'][$i],
						"destinatario" => $dataSaved['numero_documento'][$i],
						"codigo_verificacion" => $dataSaved['codigo_verificacion'][$i],
						"numero_bolsa" => $dataSaved['numero_bolsa'][$i],
					];

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
							$item ++;
						}
						Fundicion::updateEstadoInventario($dataSaved['id_inventario'][$k],$dataSaved['id_tienda_orden'],validarMotivo::GetMotivo($dataSaved['id_proceso'][$i]),validarMotivo::GetEstado());
						
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
							$ItemsXOrden[$dataSaved['id_inventario'][$k]][$item]['peso_libre'] = $dataSaved['peso_libre'][$k];
							$item ++;
							Fundicion::updateEstadoInventario($dataSaved['id_inventario'][$k],$dataSaved['id_tienda_orden'],validarMotivo::GetMotivo($dataSaved['id_proceso'][$i]),validarMotivo::GetEstado());
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
			
			if(count($dataSaved['id_proceso']) > 0){
				$datosPreparados['CrearOrdenes'] = array_values($CrearOrdenes);
				$datosPreparados['CrearTrazabilidad'] = array_values($CrearTrazabilidad);
				$datosPreparados['ItemsXOrden'] = array_values($ItemsXOrden);
				$datosPreparados['AntiguaTrazabilidad'] = array_values($AntiguaTrazabilidad);
				$datosPreparados['destinatarios'] = array_values($destinatarios);
				$respuesta = Fundicion::Procesarsubdividir($datosPreparados);
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
				   $msm=['msm'=>Messages::$Orden['subdividida'],'val'=>'Insertado', 'ordenes' => array_values($idOrdenes)];
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
							$traza['trazabilidad']['motivo']='Fundición';
							$traza['trazabilidad']['numero_contrato']=$datosPreparados['CrearOrdenes'][$j]['id_hoja_trabajo'];
							$traza['trazabilidad']['numero_item']=$i+1;
							$traza['trazabilidad']['numero_orden']=$datosPreparados['CrearOrdenes'][$j]['id_orden'];
							$traza['trazabilidad']['numero_referente']='Perf.'.$datosPreparados['CrearOrdenes'][$j]['id_orden'];
							TrazabilidadBL::Create($traza);
						}
					}
				}
			   return $msm;
			}else{
				for($s=0; $s<count($id_orden);$s++){

					/*formateamos los resultados de las mermas por items para que sean solo 2 decimales*/	
						for($x=0; $x < count($merma_por_item); $x++){
							$merma_por_item[$x] = number_format( $merma_por_item[$x],2);
						}

					/*MOVIMIENTO CONTABLE POR LAS MERMAS*/
						$peso_libre = (float) str_replace(",", ".", $dataSaved["peso_libre_modal"]);
						$peso_estimado = (float) str_replace(",", ".", $dataSaved["peso_estimado_modal"]);
						if($dataSaved["merma_modal"] > 0){
							$valor = $dataSaved["valor_merma"];
							$id_movimientocontable = 57;
							MovimientosTesoreria::registrarCausacion($valor,$dataSaved["id_tienda_orden"],
							$id_movimientocontable,NULL,"MERMO-".$dataSaved["id_tienda_orden"]."/".$dataSaved["id_inventario"][$s]);
						}

					/*RECALCULAMOS LOS NUEVOS PESOS EN GRAMOS CON LOS QUE QUEDARAN LOS ITEMS EN EL INVENTARIO */
						for($n=0; $n<count($dataSaved['id_inventario']);$n++){
							$nuevo_peso_item[$n] = (float)$dataSaved['peso_total'][$n] - (float)$merma_por_item[$n];
						}

					/*ORGANIZAMOS LOS DATOS PARA GUARDAR Y ACTUALIZAR LAS ORDENES Y LOS ITEMS*/
					$estadoFundido[$s]['id_orden'] = $dataSaved['numero_orden'];
					$estadoFundido[$s]['id_tienda_orden'] = $dataSaved['id_tienda_orden'];
					$estadoFundido[$s]['estado'] = env('ORDEN_PROCESADA_MERMA_FUNDICION');

					$fundidoInventario[$s]['id_inventario'] = $dataSaved['id_inventario'];
					$fundidoInventario[$s]['id_tienda_inventario'] = $dataSaved['id_tienda_inventario'];
					$fundidoInventario[$s]['peso'] = $nuevo_peso_item;
					$fundidoInventario[$s]['id_estado_producto'] = env('BLOQUEADO_FUNDICION');
				}
				$dataprepared['estadoFundido'] = array_values($estadoFundido);
				$dataprepared['fundidoInventario'] = array_values($fundidoInventario);

				$fundido = Fundicion::ordenEnEstadoFundido($dataprepared);
				if($fundido=='Error'){
					Session::flash('error', 'Orden no fue fundida.');
				}elseif($fundido=='ErrorUnico'){
					Session::flash('error', 'Esta orden ya fue fundida.');
				}elseif($fundido=='Insertado'){
					Session::flash('message', 'Orden fundida con éxito.');
				}
			}
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
		$id_orden_padre = Fundicion::getIdOrdenPadre($id_orden, $id_tienda_orden);
		$response = true;
		if(self::validarEstadoHojaTrabajo($id_orden, $id_tienda_orden, $id_orden_padre))
		{
			$response = Fundicion::AnularOrden($id_orden, $id_tienda_orden, $id_orden_padre);
		}
		if($response == false){
			$response = self::quitarItems($items_string);
		}
		return $response;
	}

	public static function validarEstadoHojaTrabajo($id_orden, $id_tienda_orden, $id_orden_padre){
		$result = false;
		try
		{
			$cant_orden_procesadas = Fundicion::countOrdenesProcesadas($id_orden_padre, $id_tienda_orden);
			$result = ($cant_orden_procesadas > 0) ? false : true;
		}
		catch(\Exception $ex)
		{
			$result = false;
			dd($ex);
		}
		return $result;
	}

	public static function getItemOrdenConcat($id_tienda,$id)
	{
		return Fundicion::getItemOrdenConcat($id_tienda,$id);
	}

	public static function getItemOrden($id_tienda,$id)
	{
		return Fundicion::getItemOrden($id_tienda,$id);
	}

	public static function getDestinatariosOrden($id_tienda,$id)
	{
		return Fundicion::getDestinatariosOrden($id_tienda,$id);
	}

	public static function getDestinatariosOrdenPadre($id_tienda,$id)
	{
		return Fundicion::getDestinatariosOrdenPadre($id_tienda,$id);
	}

	public static function getFundicionById($id)
	{
		return Fundicion::getFundicionById($id);
	}

	public static function getSelectList()
	{
		return Fundicion::getSelectList();
	}

	public static function getListProceso()
	{
		return Fundicion::getListProceso();
	}

	public static function getListProcesoByVitrina()
	{
		return Fundicion::getListProcesoByVitrina();
	}	

	public static function validarItem($id_tienda_inventario,$id_inventario,$id_contrato)
	{
		return Fundicion::validarItem($id_tienda_inventario,$id_inventario,$id_contrato);
	}

	public static function quitarItems($items)
	{
		
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
		//recuperar ordenes asociadas al contrato
		$ordenes=Fundicion::validarItem($id_tienda_inventario,$id_inventario,$id_contrato);
		for($i=0;$i<count($ordenes);$i++){
			$orden[$i]=$ordenes[$i]->id_orden;
		}
		$id_inventario = explode(',',$id_inventario);
		$val=Fundicion::validarquitarItem($id_tienda_inventario,$id_inventario,$id_contrato);

		if(count($val)==0){
			$retorno = Fundicion::quitarItems($id_inventario,$id_tienda_inventario,$id_contrato);
			$items = Fundicion::validarOrden($id_tienda_inventario,$id_orden);
			 //validar cantidad de items para actualizar el estado de la orden
			if(count($items) == 0){
				for($ord=0;$ord < count($orden);$ord++){
					Fundicion::updateEstadoOrden($id_tienda_inventario,$orden[$ord]);
				}
			}
		}else{
		 	$retorno="error";
		}
		return $retorno;
	}

	public static function generateExcel($id_orden, $id_tienda,$process){
		$ResolucionarExcel = new OrdenesResolucionExcel($process);
		$fundicion = Fundicion::getOrdenExcel($id_orden, $id_tienda);
        return $ResolucionarExcel->generateExcel($fundicion);
	}

	public static function getItemsMineria($id_orden, $id_tienda){
		return Fundicion::getItemOrden($id_tienda, $id_orden);
	}
}
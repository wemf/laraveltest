<?php 

namespace App\BusinessLogic\Nutibara\Maquila;
use App\AccessObject\Nutibara\Maquila\Maquila;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\BusinessLogic\Utility\validarMotivo;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use App\BusinessLogic\Nutibara\Excel\Resolucion\OrdenesResolucionExcel;
use App\BusinessLogic\Nutibara\Inventario\Trazabilidad\TrazabilidadBL;
use config\messages;
use dateFormate;


class CrudMaquila {

	public static function get($request)
	{
		$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];
		$order=$request->order[ 0 ][ 'dir' ];
		$vowels = array( "$", "^" );
		$search[ "id_tienda" ] = str_replace( $vowels, "", $request->columns[ 0 ][ 'search' ][ 'value' ] );
		$search[ "id_categoria" ] = str_replace( $vowels, "", $request->columns[ 1 ][ 'search' ][ 'value' ] );
		$search[ "estado" ] = str_replace( $vowels, "", $request->columns[ 2 ][ 'search' ][ 'value' ] );
		
		if ( $search[ "estado" ] == 1 ) {
			$search[ "estado" ] = ( int )  env( 'ORDEN_PENDIENTE_POR_PROCESAR' );
		} else if ( $search[ "estado" ] == 2 ){
			$search[ "estado" ] = ( int ) env( 'ORDEN_PROCESADA' );
		}elseif($search[ "estado" ] == 0 ){
			
			$search[ "estado" ] = ( int ) env('ANULADA_PREREFACCION');
		}

		$total = count(Maquila::get( $start, $end, $colum, $order, $search ));
		$data=[
			"draw" => $draw,
			"recordsTotal" => $total,
			"recordsFiltered" => $total,
			"data" => dateFormate::ToArrayInverse(Maquila::get( $start, $end, $colum, $order, $search )->toArray())
		];
		return response()->json($data);
	}

	public static function getTiendaByIp($ip){
		return Maquila::getTiendaByIp($ip);
	}

	public static function procesarUpdate($data,$ordenes)
	{

		$respuesta = Maquila::procesarUpdate($data,$ordenes);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Maquila['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Maquila['ok'],'val'=>'Actualizado'];	
		}
		return $msm;	
	}

	public static function Procesar($dataSaved)
	{
		$id_orden = explode("-", $dataSaved['numero_orden']);		
		// if($dataSaved['procesar'] == 1)
		//  {
		// 	$respuesta =  Maquila::Procesar($dataSaved,$id_orden);
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
						Maquila::updateEstadoInventario($dataSaved['id_inventario'][$k],$dataSaved['id_tienda_orden'],validarMotivo::GetMotivo($dataSaved['id_proceso'][$i]),validarMotivo::GetEstado());
						
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
							Maquila::updateEstadoInventario($dataSaved['id_inventario'][$k],$dataSaved['id_tienda_orden'],validarMotivo::GetMotivo($dataSaved['id_proceso'][$i]),validarMotivo::GetEstado());
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

			$respuesta = Maquila::Procesarsubdividir($datosPreparados);
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
						 $traza['trazabilidad']['motivo']='Maquila';
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


	public static function process($numero_orden, $id_proceso)
	{
		$numero_orden = explode("-", $numero_orden);		
		for ($i=0; $i < count($id_proceso) ; $i++)
		{	
			$response = Maquila::updateProcess($id_orden[0], $id_proceso[$i]);
			if($response == false)
				break;
		}

		if($response==false)
		{
			$msm=['msm'=>Messages::$Maquila['error'],'val'=>'Error'];		
		}else{
			$msm=['msm'=>Messages::$Maquila['ok'],'val'=>'Actualizado'];
		}
		return $msm;
	}


	public static function getItemOrden($id_tienda,$id)
	{
		return Maquila::getItemOrden($id_tienda,$id);
	}

	public static function getDestinatariosOrden($id_tienda,$id)
	{
		return Maquila::getDestinatariosOrden($id_tienda,$id);
	}

	public static function getMaquilaById($id)
	{
		return Maquila::getMaquilaById($id);
	}

	public static function getSelectList()
	{
		return Maquila::getSelectList();
	}

	public static function getListProceso()
	{
		return Maquila::getListProceso();
	}

	public static function getListProcesoByVitrina()
	{
		return Maquila::getListProcesoByVitrina();
	}

	public static function validarItem($id_tienda_inventario,$id_inventario,$id_contrato)
	{
		return Maquila::validarItem($id_tienda_inventario,$id_inventario,$id_contrato);
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
		$id_inventario = explode(',',$id_inventario);
		$val=Maquila::validarquitarItem($id_tienda_inventario,$id_inventario,$id_contrato);
		 if(count($val)==0){
		 	$retorno = Maquila::quitarItems($id_inventario,$id_tienda_inventario,$id_contrato);
		 	$items = Maquila::validarOrden($id_tienda_inventario,$id_orden);
		  	//validar cantidad de items para actualizar el estado de la orden
		 	if(count($items) == 0)	Maquila::updateEstadoOrden($id_tienda_inventario,$id_orden);
		 }else{
		 	$retorno="error";

		}
		
		return $retorno;
	}

	public static function generateExcel($id_orden, $id_tienda,$process){
		$resolucionarExcel=new OrdenesResolucionExcel($process);
		$resolucionar =Maquila::getOrdenExcel($id_orden, $id_tienda);
        return $resolucionarExcel->generateExcel($resolucionar);
	}

	public static function getItemsMineria($id_orden, $id_tienda){
		return Maquila::getItemOrden($id_tienda, $id_orden);
	}

	public static function ordenAddorUpdate($numero_orden,$orden_guardar){
		Maquila::ordenAddorUpdate($numero_orden,$orden_guardar);
	}

	public static function ordenActualizarItems($numero_orden,$orden_guardar_items){
		Maquila::ordenActualizarItems($numero_orden,$orden_guardar_items);
	}

	public static function ordenActualizarDestinatarios($numero_orden,$orden_guardar_destinatarios){
		Maquila::ordenActualizarDestinatarios($numero_orden,$orden_guardar_destinatarios);
	}
}
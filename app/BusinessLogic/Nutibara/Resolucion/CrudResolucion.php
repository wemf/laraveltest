<?php

// Author		:	<Andrey Higuita>
// Create date	:	<Jueves, 15 de abril de 2018>
// Description	:	<Clase para manejar la lógica del negocio de la resolución en el primer paso (perfeccionamiento de contratos)>

namespace App\BusinessLogic\Nutibara\Resolucion;
use App\AccessObject\Nutibara\Resolucion\Resolucion;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\BusinessLogic\Utility\validarMotivo;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\AccessObject\Nutibara\Contratos\Contrato;
use config\messages;


class CrudResolucion {

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
		if($search["id_estado"] == 1){
			$search["id_estado"] = (int)env('ORDEN_PENDIENTE_POR_PROCESAR');
		}elseif($search["id_estado"] == 2){
			$search["id_estado"] = (int)env('ORDEN_PROCESADA');
		}
		$data = Resolucion::get($start, $end, $colum, $order, $search);
		if(isset($data[0])){
			if($data[0]->DT_RowId == null && count($data) == 1){
				$data = [];
			}
		}
		
		$total=count($data);
		$data=[
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>$data
		];
		return response()->json($data);
	}

	public static function getTiendaByIp($ip){
		return Resolucion::getTiendaByIp($ip);
	}

	public static function procesarUpdate($data,$ordenes)
	{

		$respuesta = Resolucion::procesarUpdate($data,$ordenes);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Resolucion['error'],'val'=>'Error'];
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];
		}
		elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Resolucion['ok'],'val'=>'Actualizado'];
		}
		return $msm;
	}

	public static function Procesar($dataSaved)
	{
		$id_orden = explode("-", $dataSaved['numero_orden']);
		if($dataSaved['procesar'] == 1)
		 {
			$respuesta =  Resolucion::Procesar($dataSaved,$id_orden);
			$idOrdenes = $id_orden;
			if($respuesta=='Error')
			{
				$msm=['msm'=>Messages::$Orden['error'],'val'=>'Error'];
			}
			elseif($respuesta=='ErrorUnico')
			{
				$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];
			}
			elseif($respuesta=='Actualizado')
			{
				$msm=['msm'=>Messages::$Orden['procesada'],'val'=>'Actualizado', 'ordenes' => $idOrdenes];
			}
			return $msm;
		 }
		else
		{

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
						Resolucion::updateEstadoInventario($dataSaved['id_inventario'][$k],$dataSaved['id_tienda_orden'],validarMotivo::GetMotivo($dataSaved['id_proceso'][$i]),validarMotivo::GetEstado());

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
							Resolucion::updateEstadoInventario($dataSaved['id_inventario'][$k],$dataSaved['id_tienda_orden'],validarMotivo::GetMotivo($dataSaved['id_proceso'][$i]),validarMotivo::GetEstado());
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

			$respuesta = Resolucion::Procesarsubdividir($datosPreparados);
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
		}
	}


	public static function getIdContratos($id_tienda,$id)
	{
		return Resolucion::getIdContratos($id_tienda,$id);
	}

	public static function getItemOrden($id_tienda,$id)
	{
		return Resolucion::getItemOrden($id_tienda,$id);
	}

	public static function getDestinatariosOrden($id_tienda,$id)
	{
		return Resolucion::getDestinatariosOrden($id_tienda,$id);
	}

	public static function getResolucionById($id)
	{
		return Resolucion::getResolucionById($id);
	}

	public static function getSelectList()
	{
		return Resolucion::getSelectList();
	}

	public static function getListProceso()
	{
		return Resolucion::getListProceso();
	}

	public static function getListProcesoByVitrina()
	{
		return Resolucion::getListProcesoByVitrina();
	}

	public static function validarItem($id_tienda_inventario,$id_inventario,$id_contrato)
	{
		return Resolucion::validarItem($id_tienda_inventario,$id_inventario,$id_contrato);
	}

	public static function quitarItems($items)
	{
		$id_contrato = "";
		$id_tienda_inventario = "";
		$id_inventario = "";
		for($i = 0; $i < count($items); $i++)
		{
			$item = explode("-",$items[$i]);
			$id_tienda_inventario = $item[0];
			$id_inventario .= $item[1].",";
			$id_contrato = $item[2];
		}
		$id_inventario = explode(',',$id_inventario);
		$retorno = Resolucion::quitarItems($id_inventario,$id_tienda_inventario,$id_contrato);
		return $retorno;
	}

	public static function getItemsContrato($codigo_orden, $id_tienda){
		$data["data"] = Resolucion::getItemsContrato($codigo_orden,$id_tienda);
		$codigo_contrato = (isset($data["data"][0]->Codigo_Contrato)) ? $data["data"][0]->Codigo_Contrato : 0;
		$data["columnas_items"] = Contrato::getColumnasItems( $codigo_contrato, $id_tienda );
		$data["datos_columnas_items"] = Contrato::getDatosColumnasItems( $codigo_contrato, $id_tienda );
		return $data;
	}
}

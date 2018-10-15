<?php 

namespace App\BusinessLogic\Nutibara\Vitrina;
use App\AccessObject\Nutibara\Vitrina\Vitrina;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use App\BusinessLogic\Nutibara\Excel\Resolucion\StikersExcel;
use App\BusinessLogic\Nutibara\Inventario\Trazabilidad\TrazabilidadBL;
use config\messages;


class CrudVitrina 
{

    public static function Vitrina($start,$end,$colum, $order,$search)
	{
		$result = Vitrina::VitrinaWhere($start,$end,$colum, $order,$search);

		return $result;
	}

	public static function getCountVitrina($search)
	{
		return Vitrina::getCountVitrina($search);
	}

	public static function getListProceso()
	{
		return Vitrina::getListProceso();
	}

	public static function SolicitarProcesarVitrina($request)
	{
		return Vitrina::SolicitarProcesarVitrina($request);
	}

	public static function SolicitarProcesarVitrinaJZ($request)
	{
		return Vitrina::SolicitarProcesarVitrinaJZ($request);
	}

	public static function guardarVitrina($request)
	{
		$respuesta = Vitrina::guardarVitrina($request);
		if(!$respuesta)
		{
			$msm=['msm'=>'No se pudieron guardar los cambios.','val'=>false];		
		}
		else
		{
			$msm=['msm'=>'Orden guardada con éxito.','val'=>true];	
		}
		return $msm;
	}

	public static function rechazarVitrina($request)
	{
		$respuesta = Vitrina::rechazarVitrina($request);
		if(!$respuesta)
		{
			$msm=['msm'=>'No se pudo rechazar el pedido.','val'=>false];		
		}
		else
		{
			$msm=['msm'=>'Orden rechazada con éxito.','val'=>true];	
		}
		return $msm;
	}

	public static function Procesar($dataSaved)
	{
		$id_orden = explode("-", $dataSaved['numero_orden']);
		if($dataSaved['procesar'] == 1)
		{
			$respuesta =  Vitrina::Procesar($dataSaved,$id_orden);
			$idOrdenes = $id_orden;
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
				for($i = 0; $i < count($dataSaved["peso_libre"]); $i++){
					$peso_libre = (float) str_replace(",", ".", $dataSaved["peso_libre"][$i]);
					$peso_estimado = (float) str_replace(",", ".", $dataSaved["peso_estimado"][$i]);

					if($peso_libre != $peso_estimado){
						$id_movimientocontable = ( $peso_libre < $peso_estimado ) ? 57 : 58; // ? 49 : 50;
						$diferencia_peso = abs($peso_libre - $peso_estimado);
						$valor_x_1 = (float)Vitrina::limpiarVal($dataSaved["precio_ingresado"][$i]) / (float)Vitrina::limpiarVal($peso_estimado);
						$valor = $diferencia_peso * $valor_x_1;
						MovimientosTesoreria::registrarCausacion($valor,$dataSaved["id_tienda_orden"][0],$id_movimientocontable,NULL,"MERMO-".$dataSaved["id_tienda_orden"][0]."/".$dataSaved["id_inventario"][$i]);
					}
				}
				$msm=['msm'=>Messages::$Orden['procesada'],'val'=>'Insertado', 'ordenes' => $idOrdenes];
			}
		}
		else
		{
			 
			for ($i=0; $i < count($dataSaved['id_proceso']) ; $i++) 
			{
				/*Preparar Crear Ordenes*/ 
				$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'][0],env('SECUENCIA_TIPO_CODIGO_ORDEN'),1);
				$codigoOrden = $secuencias[0]->response;
				$CrearOrdenes[$i]['id_orden'] = $codigoOrden;
				$idOrdenes[$i] = $codigoOrden;
				$CrearOrdenes[$i]['id_tienda_orden'] = $dataSaved['id_tienda_orden'][0];
				$CrearOrdenes[$i]['id_hoja_trabajo'] = $dataSaved['id_hoja_trabajo'];
				$CrearOrdenes[$i]['id_tienda_hoja_trabajo'] = $dataSaved['id_tienda_orden'][0];
				$CrearOrdenes[$i]['proceso'] = $dataSaved['id_proceso'][$i] ;
				$CrearOrdenes[$i]['fecha_creacion'] = date('Y-m-d H:i:s');
				$CrearOrdenes[$i]['estado'] = env('ORDEN_PENDIENTE_POR_PROCESAR');
				$CrearOrdenes[$i]['id_cliente'] = $dataSaved['id_cliente_destinatario'][$i] ;
				$CrearOrdenes[$i]['id_tienda_cliente'] = $dataSaved['id_tienda_cliente_destinatario'][$i];
				$CrearOrdenes[$i]['id_sucursal'] = $dataSaved['sucursales'][$i];

				/*Preparar Ordenes Nuevas para  Trazabilidad.*/
				$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'][0],env('SECUENCIA_TIPO_CODIGO_TRAZABILIDAD'),1);
				$codigoTrazabilidad = $secuencias[0]->response;
				$CrearTrazabilidad[$i]['id_trazabilidad'] = $codigoTrazabilidad;
				$CrearTrazabilidad[$i]['id_tienda_trazabilidad'] = $dataSaved['id_tienda_orden'][0];
				$CrearTrazabilidad[$i]['id_orden'] = $codigoOrden;
				$CrearTrazabilidad[$i]['id_tienda_orden']  = $dataSaved['id_tienda_orden'][0];
				$CrearTrazabilidad[$i]['actual'] = 1;
				$CrearTrazabilidad[$i]['fecha_accion'] = date('Y-m-d H:i:s');
				$CrearTrazabilidad[$i]['accion'] = 'Creado';

				/*Asociar Items a las nuevas Ordenes*/
				$item = 0;				
				for ($k=0; $k < count($dataSaved['id_item']) ; $k++) 
				{ 
					if($dataSaved['subdivision'][$k] == $dataSaved['id_proceso'][$i])
					{
						$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'][0],env('SECUENCIA_TIPO_CODIGO_ITEM_ORDEN'),1);
						$codigoOrdenItem = $secuencias[0]->response;
						$ItemsXOrden[$i][$item]['id_inventario'] = $dataSaved['id_item'][$k];		
						$ItemsXOrden[$i][$item]['id_orden'] = $codigoOrden;						
						$ItemsXOrden[$i][$item]['id_orden_item'] = $codigoOrdenItem;
						$ItemsXOrden[$i][$item]['id_tienda_inventario'] = $dataSaved['id_tienda_orden'][$k];
						$ItemsXOrden[$i][$item]['id_tienda_orden'] = $dataSaved['id_tienda_orden'][$k];						
						$ItemsXOrden[$i][$item]['id_tienda_orden_item'] = $dataSaved['id_tienda_orden'][0];
						$ItemsXOrden[$i][$item]['peso_taller'] = $dataSaved['peso_taller'][$k];
						$item ++;
					}
				}
			}
			/*Actualiza ordenes en Trazabilidad. y ordenes*/
			for($i=0; $i<count($id_orden); $i++)
			{
				$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'][0],env('SECUENCIA_TIPO_CODIGO_TRAZABILIDAD'),1);
				$codigoTrazabilidad = $secuencias[0]->response;
				$AntiguaTrazabilidad[$i]['id_trazabilidad'] = $codigoTrazabilidad;
				$AntiguaTrazabilidad[$i]['id_tienda_trazabilidad'] = $dataSaved['id_tienda_orden'][0];
				$AntiguaTrazabilidad[$i]['id_orden'] = $id_orden[$i];
				$AntiguaTrazabilidad[$i]['id_tienda_orden']  = $dataSaved['id_tienda_orden'][0];
				$AntiguaTrazabilidad[$i]['actual'] = 0;
				$AntiguaTrazabilidad[$i]['fecha_accion'] = date('Y-m-d H:i:s');
				$AntiguaTrazabilidad[$i]['accion'] = 'Subdividido';
				$AntiguaTrazabilidad[$i]['estado'] = env('ORDEN_PROCESADA');
			}
			$datosPreparados['CrearOrdenes'] = $CrearOrdenes;
			$datosPreparados['CrearTrazabilidad'] = $CrearTrazabilidad;
			$datosPreparados['ItemsXOrden'] = $ItemsXOrden;
			$datosPreparados['AntiguaTrazabilidad'] = $AntiguaTrazabilidad;
			
			 $respuesta = Vitrina::Procesarsubdividir($datosPreparados);
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
				 $msm=['msm'=>Messages::$Orden['subdividida'],'val'=>'Insertado', 'ordenes' => $idOrdenes];	
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
						  $traza['trazabilidad']['motivo']='Vitrina';
						  $traza['trazabilidad']['numero_contrato']=$datosPreparados['CrearOrdenes'][$j]['id_hoja_trabajo'];
						  $traza['trazabilidad']['numero_item']=$i+1;
						  $traza['trazabilidad']['numero_orden']=$datosPreparados['CrearOrdenes'][$j]['id_orden'];
						  $traza['trazabilidad']['numero_referente']='Perf.'.$datosPreparados['CrearOrdenes'][$j]['id_orden'];
						  TrazabilidadBL::Create($traza);
					  }
				  }
			 }
		}
		return $msm;
	}

	public static function DetalleOrdenesVitrina($id_tienda,$ids_orden)
	{
		return Vitrina::DetalleOrdenesVitrina($id_tienda,$ids_orden);
	}

	public static function getItemsSubOrden($id)
	{
		return Vitrina::getItemsSubOrden($id);
	}

	public static function getItemOrden($id_tienda,$id)
	{
		return Vitrina::getItemOrden($id_tienda,$id);
	}

	public static function GetProveedorById($tienda,$id_cliente)
	{
		return Vitrina::GetProveedorById($tienda,$id_cliente);
	}

	public static function reclasificarItemGet( $id_tienda, $id_inventario )
	{
		return Vitrina::reclasificarItemGet( $id_tienda, $id_inventario );
	}
	
	public static function reclasificarItemPost( $id_categoria, $data_reference, $id_inventario, $id_tienda_inventario, $codigo_contrato, $id_linea_item )
	{
		return Vitrina::reclasificarItemPost($id_categoria, $data_reference, $id_inventario, $id_tienda_inventario, $codigo_contrato, $id_linea_item);
	}

	public static function generateExcel($id_orden, $id_tienda,$process){
		$resolucionarExcel=new StikersExcel($process);
		$resolucionar = Vitrina::getOrdenExcel($id_orden, $id_tienda);
        return $resolucionarExcel->generateExcel($resolucionar);
	}
	
}
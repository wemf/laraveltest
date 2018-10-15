<?php 

namespace App\BusinessLogic\Nutibara\JoyaEspecial;
use App\AccessObject\Nutibara\JoyaEspecial\JoyaEspecial;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use config\messages;


class CrudJoyaEspecial 
{

    public static function JoyaEspecial($start,$end,$colum, $order,$search)
	{
		$result = JoyaEspecial::JoyaEspecialWhere($start,$end,$colum, $order,$search);

		return $result;
	}

	public static function getCountJoyaEspecial($search)
	{
		return JoyaEspecial::getCountJoyaEspecial($search);
	}

	public static function getListProceso()
	{
		return JoyaEspecial::getListProceso();
	}
  
	public static function Procesar($dataSaved)
	{
		$id_orden = explode("-", $dataSaved['numero_orden']);		
		if($dataSaved['procesar'] == 1)
		 {
			$respuesta =  JoyaEspecial::Procesar($dataSaved,$id_orden);	
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
				$msm=['msm'=>Messages::$Orden['procesada'],'val'=>'Insertado', 'ordenes' => $idOrdenes];	
			}
			return $msm;
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
				for ($k=0; $k < count($dataSaved['id_inventario']) ; $k++) 
				{ 
					if($dataSaved['subdivision'][$k] == $dataSaved['id_proceso'][$i])
					{
						$secuencias = SecuenciaTienda::getCodigosSecuencia($dataSaved['id_tienda_orden'][0],env('SECUENCIA_TIPO_CODIGO_ITEM_ORDEN'),1);
						$codigoOrdenItem = $secuencias[0]->response;
						$ItemsXOrden[$i][$item]['id_inventario'] = $dataSaved['id_inventario'][$k];		
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

			 $respuesta = JoyaEspecial::Procesarsubdividir($datosPreparados);
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
			 }
			 return $msm;
		}
	}

	public static function DetalleOrdenesJoyaEspecial($id_tienda,$ids_orden)
	{
		return JoyaEspecial::DetalleOrdenesJoyaEspecial($id_tienda,$ids_orden);
	}

	public static function getItemsSubOrden($id)
	{
		return JoyaEspecial::getItemsSubOrden($id);
	}

	public static function getItemOrden($id_tienda,$id)
	{
		return JoyaEspecial::getItemOrden($id_tienda,$id);
	}
	
}
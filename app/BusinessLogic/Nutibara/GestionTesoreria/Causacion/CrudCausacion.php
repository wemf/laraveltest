<?php 

namespace App\BusinessLogic\Nutibara\GestionTesoreria\Causacion;
use App\AccessObject\Nutibara\GestionTesoreria\Causacion\Causacion;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\BusinessLogic\Notificacion\PagoNomina as salarioMensaje;
use config\messages;


class CrudCausacion {


	public static function CausacionAdmin($start,$end,$colum, $order,$search)
    {
		$result = Causacion::CausacionAdminWhere($start,$end,$colum, $order,$search);
		return $result;
	}

	public static function Causacion($start,$end,$colum, $order,$search)
    {
		$result = Causacion::CausacionWhere($start,$end,$colum, $order,$search);
		return $result;
	}

	public static function getCausacionByIdandTienda($id,$idTienda)
	{
		$data = Causacion::getCausacionByIdandTienda($id,$idTienda);
		return $data;
	}

	public static function Pay($id,$idTienda,$id_usuario)
    {
		$respuesta = Causacion::Pay($id,$idTienda,$id_usuario);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Causacion['error'],'val'=>'Error'];		
		}elseif($respuesta=='Actualizado')
		{
			$msm=['msm'=>Messages::$Causacion['pay_ok'],'val'=>'Actualizado'];	
		}
		return $msm;
	}
	public static function anularpagos($id,$idTienda,$id_usuario)
    {
		$respuesta = Causacion::anularpagos($id,$idTienda,$id_usuario);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Causacion['error'],'val'=>'Error'];		
		}elseif($respuesta=='Actualizado')
		{
			$request[0]['id_causacion'] = $id;
			$request[0]['id_tienda_causacion'] = $idTienda;
			$salarioMensaje =new salarioMensaje($request);
			$salarioMensaje->AnulacionRealizada();
			$msm=['msm'=>Messages::$Notificacion['anulacion_realizada'],'val'=>'Actualizado'];	
		}
		return $msm;
	}
	
	public static function AnularCausacion($id,$idTienda,$id_usuario)
    {
		$respuesta = Causacion::AnularCausacion($id,$idTienda,$id_usuario);
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Causacion['error'],'val'=>'Error'];		
		}elseif($respuesta=='Actualizado')
		{
			$request[0]['id_causacion'] = $id;
			$request[0]['id_tienda_causacion'] = $idTienda;
			$salarioMensaje =new salarioMensaje($request);
			$salarioMensaje->AnulacionRealizada();
			$msm=['msm'=>Messages::$Notificacion['anulacion_realizada'],'val'=>'Actualizado'];	
		}
		return $msm;
	}

	public static function getCountCausacionAdmin($search)
	{
		return (int)Causacion::getCountCausacionAdmin($search);
	}

	public static function getCountCausacion($search)
	{
		return (int)Causacion::getCountCausacion($search);
	}

	public static function ImpuestoCausacion($id_Causacion)
    {
		$result = Causacion::ImpuestoCausacion($id_Causacion);
		return $result;
	}

	public static function getSelectListImpuesto()
	{
		return Causacion::getSelectListImpuesto();
	}

	public static function getSelectListCodigo($id)
	{
		return Causacion::getSelectListCodigo($id);
	}

	public static function getSelectListNombre($id)
	{
		return Causacion::getSelectListNombre($id);
	}

	public static function getImpuestosByPais()
	{
		return Causacion::getImpuestosByPais();
	}
	
	public static function getSelectListTipoCausacion()
	{
		return Causacion::getSelectListTipoCausacion();
	}

	public static function CreateSalario($datosCausacion,$datosEmpleados,$enviarMensaje=0)
	{
		//Secuencia de Causacion
		$secuencias = SecuenciaTienda::getCodigosSecuencia($datosCausacion['id_tienda'],env('SECUENCIA_TIPO_CODIGO_CAUSACION'),1);
		$codigoCausacion = $secuencias[0]->response;
		$datosCausacion['id'] = $codigoCausacion;
		
		for ($i=0; $i < count($datosEmpleados) ; $i++) 
		{ 
			$datosSalario[$i]['id_causacion'] = $datosCausacion['id'];
			$datosSalario[$i]['id_tienda_causacion'] = $datosCausacion['id_tienda'];
			$datosSalario[$i]['id_empleado'] = $datosEmpleados[$i]['id_empleado'];
			$datosSalario[$i]['id_tienda_empleado'] = $datosEmpleados[$i]['id_tienda_empleado'];
			$datosSalario[$i]['concepto_pago'] = $datosEmpleados[$i]['cuenta'];
			$datosSalario[$i]['descripcion_pago'] = $datosEmpleados[$i]['descripcion_pago'];
			$datosSalario[$i]['valor'] = $datosEmpleados[$i]['valor'];
		}

		$msm=['msm'=>Messages::$Causacion['salario_ok'],'val'=>true,'id_causacion' => $datosCausacion['id'] ];
		if(!Causacion::CreateSalario($datosCausacion,$datosSalario))
        {
			$msm=['msm'=>Messages::$Causacion['salario_error'],'val'=>false];
		}
		elseif($enviarMensaje==0)
		{
			$salarioMensaje =new salarioMensaje($datosSalario);
			$salarioMensaje->CausacionPendiente();
		}
		return $msm;
	}
	public static function Transfer($id,$idTienda)
	{
		$respuesta = Causacion::Transfer($id,$idTienda);
		$msm=['msm'=>Messages::$Causacion['transfer_ok'],'val'=>'Actualizado'];	
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Causacion['error'],'val'=>'Error'];		
		}elseif($respuesta=='Actualizado')
		{
			$request[0]['id_causacion'] = $id;
			$request[0]['id_tienda_causacion'] = $idTienda;
			$salarioMensaje =new salarioMensaje($request);
			$salarioMensaje->TransferenciaRealizada();
		}
		return $msm;
	}

	public static function getPagoNomina($id,$idTienda)
	{
		return Causacion::getPagoNomina($id,$idTienda);
	}

	public static function SolicitarAnulacion($dirijido,$id_causacion,$id_tienda_causacion,$estado)
	{
		$respuesta = Causacion::SolicitarAnulacion($id_causacion,$id_tienda_causacion,$estado);	
		$msm=['msm'=>Messages::$Causacion['solicitud_ok'],'val'=>'Actualizado'];	
		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Causacion['error'],'val'=>'Error'];			
		}
		elseif($respuesta=='Actualizado')
		{
			$request[0]['id_causacion'] = $id_causacion;
			$request[0]['id_tienda_causacion'] = $id_tienda_causacion;
			$request[0]['dirijido'] = $dirijido;
			$Mensaje =new salarioMensaje($request);
			$Mensaje->SolicitarAnulacion();
		}
		return $msm;	
	}

	public static function getPago($id_comprobante)
	{
		return Causacion::getPago($id_comprobante);
	}
}


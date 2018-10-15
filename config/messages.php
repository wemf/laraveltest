<?php

namespace config;
Class Messages{
   //Mensajes Formulario
	public static $formDefiner = array(
		'ok'=>'Formulario creada con éxito.',
		'error'=>'Formulario no creado.',
		'update'=>'Se ha creada con éxito, una nueva versión del Formulario.',
		'error_update'=>'Formulario no actualizado.',
		'delete'=>'Formulario inactivado con éxito.',
		'error_delete'=>'Formulario no inactivado.',	
		'duplicated'=>'Formulario duplicado con éxito.',
		'error_duplicated'=>'Formulario no duplicado.',	
	);

	//Mensajes name unique
	public static $nameUnique = array(
		'ok'=>'Campo agregado con éxito.',
		'error'=>'Cambie el nombre en el sistema. Se encuentra asignado a un campo existente.',		
	);

	
	//Mensajes de notificacion del enrrolamiento
	public static $notiRoles = array(
		'denied'=>'No tiene permisos para acceder a la URL.',
		'sendForgotPassword'=>'Se ha enviado a un vínculo para recuperar la contraseña al correo: ',
		'forgotPassword'=>'Ingrese con su nueva contraseña.',
		'errorLogin'=>'Usuario o Contraseña son inválidos.',
		'accountActivated'=>'Su cuenta ha sido activada.',
		'NoaccountActivated'=>'La cuenta no ha sido activada.',
		'accountNoActivated'=>'Su cuenta no ha sido activada.Contacte su administrador.',
		'accountBlocked'=>'Su IP ha sido bloqueda por intentos fallidos, durante (segundos): ',
		'sendAccountActivated'=>'Se ha enviado a su correo un vínculo para activar la cuenta.',
		'userCreated'=>'Usuario creado con éxito y cuenta activada.',
		'duplicated'=>'El correo ya se encuentra asignado a un usuario registrado.',
		'error_email'=>'El correo ingresado no es válido o no existe.',
		'alreadyGotPassword'=>'La cuenta ya había sido activada.',
		);

	//Mensajes de asignar usuario
	public static $AssignedUser = array(
		'create_ok'=>'Usuario Asignado con éxito.',
		'create_error'=>'Usuario No Asignado.',
		'update_ok'=>'Usuario Actualizado con éxito.',
		'update_error'=>'Usuario No Actualizado.',
		);

	//Mensajes de editar información de usuario
	public static $EditUsers = array(
		'update_ok'=>'Usuario editado con éxito.',
		'update_error'=>'Usuario No editado.'
		);

	public static $user_deleted = array(
		'deleted_ok' =>'Usuario ha sido dado de baja con éxito.',
		'deleted_error' =>'Usuario no ha sido dado de baja.',
		);

	public static $user_active = array(
		'active_ok' =>'Usuario ha sido re-activado con éxito.',
		'active_error' =>'Usuario no re-activado.',
		);

	public static $user_edited = array(
		'edited_ok' =>'Usuario editado con éxito',
		'edited_error' =>'Usuario no editado.',
		'edited_error_pass' =>'Las contraseñas no coinciden',
		);

	//Mensajes de notificacion del admin
	public static $admin = array(
		'duplicated'=>'ROL ya estaba asigando al usuario',
		'ok'=>'Rol(es) actualizado con éxito.',
		'error'=>'Rol(es) no actualizado.',
		'delete'=>'Permisos restablecidos con éxito.',
		'error_delete'=>'Permisos no restablecidos.',
		'error_nothing'=>'Permisos no restablecidos, ya que el usuario cuenta con los permisos mínimos.'
		);
	
	//Mensajes FileMangerBusinessLogic
	public static $fileManager = array(
		'copy'=>'Archivo copiado con éxito',
		'error'=>'Archivo no copiado.',
		'empty'=>'No suba archivos vacíos.',
		'ext'=>'Extensión de archivo invalido.',
		'duplicated'=>'Archivo ya cargado.',		
	);

	//Mensajes de asignar usuario
	public static $company = array(
		'ok'=>'Empresa ingresada con éxito.',
		'error'=>'Empresa No ingresada.',
		'update_ok'=>'Empresa actualizada con éxito.',
		'update_error'=>'Empresa no actualizada.',
		'delete_ok'=>'Empresa inactivada con éxito.',
		'delete_error'=>'Empresa no inactivada.',
		'associate_ok'=>'Formulario(s) asociado(s) con éxito',
		'associate_error'=>'Formulario(s) no asociado(s)',
	);

	//Mensajes Admin Categorías
	public static $category = array(
		'ok'=>'Categoría ingresada con éxito.',
		'error'=>'Categoría no ingresada.',
		'update_ok'=>'Categoría actualizada con éxito.',
		'update_error'=>'Categoría no actualizada.',
		'delete_ok'=>'Categoría eliminada con éxito.',
		'delete_error'=>'Categoría no eliminada.',
		'active_ok' => 'Categoría activada con éxito',
		'inactive_ok' => 'Categoría inactivada con éxito',
		'active_error' => 'Categoría no fue activada',
	);


	//Mensajes Admin Atributos
	public static $attribute = array(
		'ok'=>'Atributo ingresado con éxito.',
		'error'=>'Atributo no ingresado.',
		'update_ok'=>'Atributo actualizado con éxito.',
		'update_error'=>'Atributo no actualizado.',
		'delete_ok'=>'Atributo eliminado con éxito.',
		'delete_error'=>'Atributo no eliminado.',
		'active_ok' => 'Atributo activado con éxito',
		'inactive_ok' => 'Atributo inactivado con éxito',
		'active_error' => 'Atributo no fue activado',
	);

	public static $Parametros = array(
		'ok'=>'Parámetro ingresado con éxito.',
		'error'=>'Parámetro no ingresado.',
		'update_ok'=>'Parámetro actualizado con éxito.',
		'update_error'=>'Parámetro no actualizado.',
		'delete_ok'=>'Parámetro inactivado con éxito.',
		'delete_error'=>'Parámetro no inactivado.',
		'active_ok' => 'Parámetro activado con éxito',
		'active_error' => 'Parámetro no fue activado',
		'error_unique' => 'Este Parámetro ya ha sido ingresado, es posible que este desactivado.'
	);

	public static $Orden = array(
		'ok'=>'Orden ingresada con éxito.',
		'error'=>'Orden no ingresada.',
		'subdividida'=>'Orden procesada con éxito.',
		'procesada'=>'Orden Procesada con éxito.',
	);

	//Mensajes Admin Valores Atributos|
	public static $attributeValue = array(
		'ok'=>'Valor de atributo ingresado con éxito.',
		'error'=>'Valor de atributo no ingresado.',
		'update_ok'=>'Valor de atributo actualizado con éxito.',
		'update_error'=>'Valor de atributo no actualizado.',
		'delete_ok'=>'Valor de atributo eliminado con éxito.',
		'delete_error'=>'Valor de atributo no eliminado, este puede estar asociado a un producto.',
		'active_ok' => 'Valor de atributo activado con éxito',
		'inactive_ok' => 'Valor de atributo inactivado con éxito',
		'active_error' => 'Valor de atributo no fue activado',
	);


	//Mensajes Admin Referencias
	public static $reference = array(
		'ok'=>'Referencia ingresada con éxito.',
		'error'=>'Referencia no ingresada.',
		'update_ok'=>'Referencia actualizada con éxito.',
		'update_error'=>'Referencia no actualizada.',
		'delete_ok'=>'Referencia eliminada con éxito.',
		'delete_error'=>'Referencia no eliminada.',
		'active_ok' => 'Referencia activada con éxito',
		'inactive_ok' => 'Referencia inactivada con éxito',
		'active_error' => 'Referencia no fue activada',
	);

	//Mensajes Admin Persistencia
	public static $Msg_Persistence = array(
		'ok'=>'Persistencia creada correctamente',
		'error'=>'Error al crear la persistencia.',
		'already_exists'=>'La persistencia del formulario, ya se encuentra creada.',
	);

	//Mensajes Data Persistencia
	public static $dataPersistence = array(
		'ok'=>'Datos ingresados correctamente',
		'error'=>'Datos no ingresados',
		'incorrect_fields'=>'Los campos del formulario no coinciden, por favor comunicarse con el Administrador',
		'no_persistence'=>'Formulario sin persistencia, por favor comunicarse con el Administrador.',
		'delete'=>'Registro inactivado con éxito.',
		'delete_error'=>'Registro no inactivado.',
		'update'=>'Registro actualizado con éxito.',
		'update_error'=>'Registro no actualizado.',
	);

	/* Configuración de Contratos */

	// General
	public static $general = array(
		'ok'=>'Configuración general ingresada con éxito.',
		'error'=>'Configuración general no ingresada.',
		'update_ok'=>'Configuración general actualizada con éxito.',
		'update_error'=>'Configuración general no actualizada.',
		'delete_ok'=>'Configuración general eliminada con éxito.',
		'inactive_ok'=>'Configuración general desactivada con éxito.',
		'delete_error'=>'Configuración general no eliminada.',
		'inactive_error'=>'Configuración general no desactivada.',
		'active_ok' => 'Configuración general activada con éxito',
		'active_error' => 'Configuración general no fue activada',
	);

	// Especifica
	public static $especifica = array(
		'ok'=>'Configuración específica ingresada con éxito.',
		'error'=>'Configuración específica no ingresada.',
		'update_ok'=>'Configuración específica actualizada con éxito.',
		'update_error'=>'Configuración específica no actualizada.',
		'delete_ok'=>'Configuración específica eliminada con éxito.',
		'inactive_ok'=>'Configuración específica desactivada con éxito.',
		'delete_error'=>'Configuración específica no eliminada.',
		'inactive_error'=>'Configuración específica no desactivada.',
		'active_ok' => 'Configuración específica activada con éxito',
		'active_error' => 'Configuración específica no fue activada',
	);

	// Días de Gracia
	public static $diagracia = array(
		'ok'=>'Configuración ingresada con éxito.',
		'error'=>'Configuración no ingresada.',
		'update_ok'=>'Configuración actualizada con éxito.',
		'update_error'=>'Configuración no actualizada.',
		'delete_ok'=>'Configuración eliminada con éxito.',
		'inactive_ok'=>'Configuración desactivada con éxito.',
		'delete_error'=>'Configuración no eliminada.',
		'inactive_error'=>'Configuración no desactivada.',
		'active_ok' => 'Configuración activada con éxito',
		'active_error' => 'Configuración no fue activada',
	);

	// Aplicación de retroventa
	public static $apliretroventa = array(
		'ok'=>'Aplicación ingresada con éxito.',
		'error'=>'Aplicación no ingresada.',
		'update_ok'=>'Aplicación actualizada con éxito.',
		'update_error'=>'Aplicación no actualizada.',
		'delete_ok'=>'Aplicación eliminada con éxito.',
		'inactive_ok'=>'Aplicación desactivada con éxito.',
		'delete_error'=>'Aplicación no eliminada.',
		'inactive_error'=>'Aplicación no desactivada.',
		'active_ok' => 'Aplicación activada con éxito',
		'active_error' => 'Aplicación no fue activada',
	);


	// Item para Contrato
	public static $itemcontrato = array(
		'ok'=>'Item ingresado con éxito.',
		'error'=>'Item no ingresado.',
		'update_ok'=>'Item actualizado con éxito.',
		'update_error'=>'Item no actualizado.',
		'delete_ok'=>'Item eliminado con éxito.',
		'inactive_ok'=>'Item desactivado con éxito.',
		'delete_error'=>'Item no eliminado.',
		'inactive_error'=>'Item no desactivado.',
		'active_ok' => 'Item activado con éxito',
		'active_error' => 'Item no fue activado',
	);

	// Valor sugerido para Contrato
	public static $valorsugerido = array(
		'ok'=>'Valor sugerido ingresado con éxito.',
		'error'=>'Valor sugerido no ingresado.',
		'update_ok'=>'Valor sugerido actualizado con éxito.',
		'update_error'=>'Valor sugerido no actualizado.',
		'delete_ok'=>'Valor sugerido eliminado con éxito.',
		'inactive_ok'=>'Valor sugerido desactivado con éxito.',
		'delete_error'=>'Valor sugerido no eliminado.',
		'inactive_error'=>'Valor sugerido no desactivado.',
		'active_ok' => 'Valor sugerido activado con éxito',
		'active_error' => 'Valor sugerido no fue activado',
	);

		// Valor sugerido para Contrato
		public static $valorventa = array(
			'ok'=>'Valor de venta ingresado con éxito.',
			'error'=>'Valor de venta no ingresado.',
			'update_ok'=>'Valor de venta actualizado con éxito.',
			'update_error'=>'Valor de venta no actualizado.',
			'delete_ok'=>'Valor de venta eliminado con éxito.',
			'inactive_ok'=>'Valor de venta desactivado con éxito.',
			'delete_error'=>'Valor de venta no eliminado.',
			'inactive_error'=>'Valor de venta no desactivado.',
			'active_ok' => 'Valor de venta activado con éxito',
			'active_error' => 'Valor de venta no fue activado',
		);

		//Mensajes Admin Tipo de documento
	public static $TipoDoc = array(
		'ok'=>'Tipo de Documento ingresado con éxito.',
		'error'=>'Tipo de Documento no ingresado.',
		'update_ok'=>'Tipo de Documento actualizado con éxito.',
		'update_error'=>'Tipo de Documento no actualizado.',
		'delete_ok'=>'Tipo de Documento inactivado con éxito.',
		'delete_error'=>'Tipo de Documento no inactivado.',
		'errorunique'=>'Tipo de Documento ingresado ya esta registrado, es posible que este registro desactivado.',
		'active_ok' => 'Tipo de Documento activado con éxito',
		'active_error' => 'Tipo de Documento no fue activada',
	);

	//Mensajes Admin Calificaciones
	public static $Calific = array(
		'ok'=>'Calificación ingresada con éxito.',
		'error'=>'Calificación no ingresada.',
		'update_ok'=>'Calificación actualizada con éxito.',
		'update_error'=>'Calificación no actualizada.',
		'delete_ok'=>'Calificación inactivada con éxito.',
		'delete_error'=>'Calificación no inactivada.',
		'MaxMin_error'=>'el valor mínimo de la calificación es mayor al valor máximo.',
		'active_ok' => 'Calificación activada con éxito',
		'active_error' => 'Calificación no fue activada',

	);
	//Mensajes Admin Zonas
	public static $Zona = array(
		'ok'=>'Zona ingresada con éxito.',
		'error'=>'Zona no ingresada.',
		'update_ok'=>'Zona actualizada con éxito.',
		'update_error'=>'Zona no actualizada.',
		'delete_ok'=>'Zona inactivada con éxito.',
		'delete_error'=>'Zona no inactivada.',
		'active_ok' => 'Zona activada con éxito',
		'active_error' => 'Zona no fue activada',
	);
	//Mensajes Admin Tienda
	public static $Tienda = array(
		'ok'=>'Tienda ingresada con éxito.',
		'error'=>'Tienda no ingresada.',
		'update_ok'=>'Tienda actualizada con éxito.',
		'update_error'=>'Tienda no actualizada.',
		'delete_ok'=>'Tienda inactivada con éxito.',
		'delete_error'=>'Tienda no inactivada.',
		'active_ok' => 'Tienda activada con éxito',
		'active_error' => 'Tienda no fue activada',
		'open_error' => 'La tienda no fue Abierta',
		'open_ok' => 'La tienda fue abierta con éxito',
	);

	//Mensajes Admin Ciudad
	public static $Ciudad = array(
		'ok'=>'Ciudad ingresada con éxito.',
		'error'=>'Ciudad no ingresada.',
		'update_ok'=>'Ciudad actualizada con éxito.',
		'update_error'=>'Ciudad no actualizada.',
		'delete_ok'=>'Ciudad inactivada con éxito.',
		'delete_error'=>'Ciudad no inactivada.',
		'active_ok' => 'Ciudad activada con éxito',
		'active_error' => 'Ciudad no fue activada',
		
	);

	//Mensajes Admin Secuencia Tienda
	public static $SecuenciaTienda = array(
		'ok'=>'Secuencia Tienda ingresada con éxito.',
		'error'=>'Secuencia Tienda No ingresada.',
		'update_ok'=>'Secuencia Tienda actualizada con éxito.',
		'update_error'=>'Secuencia Tienda no actualizada.',
		'delete_ok'=>'Secuencia Tienda inactivada con éxito.',
		'delete_error'=>'Secuencia Tienda no inactivada.',
		'active_ok' => 'Secuencia Tienda Activada con éxito',
		'active_error' => 'Secuencia Tienda No fue activada',
	);

	//Mensajes Admin Secuencia Pais
	public static $Pais = array(
		'ok'=>'País ingresado con éxito.',
		'error'=>'País No ingresado.',
		'update_ok'=>'País actualizado con éxito.',
		'update_error'=>'País no actualizado.',
		'delete_ok'=>'País inactivado con éxito.',
		'error_delete'=>'País no inactivado.',
		'active_ok' => 'País Activado con éxito',
		'active_error' => 'País No fue activado',
	);

	//Mensajes generar guia
	public static $Logistica = array(
		'ok'=>'Guía ingresada con éxito.',
		'error'=>'Guía No ingresada.',
		'update_ok'=>'Guía actualizada con éxito.',
		'update_error'=>'Guía no actualizada.',
		'delete_ok'=>'Guía inactivada con éxito.',
		'error_delete'=>'Guía no inactivada.',
		'active_ok' => 'Guía Activada con éxito',
		'active_error' => 'Guía No fue activada',
		'ok_anular' => 'Guía anulada',//hacer merge archivo sobre escrito
	);

	//Mensajes generar plan separe
	public static $GenerarPlan = array(
		'ok'=>'Plan separe ingresado con éxito.',
		'ok_abono' => 'Abono ingresado con éxito',
		'ok_transferencia' => 'Transferencia realizada con éxito',
		'ok_anulacion' => 'Petición realizada con éxito',
		'ok_rechazar_reversar' => 'Solicitud rechazada con éxito',
		'ok_reversar_abono' => 'La solicitud ha sido aprobada.',
		'ok_reversar' => 'Petición realizada con exito',
		'ok_reverso'=>'Reverso de abono realizado con éxito.',
		'ok_cotizacion' => 'Cotización creada con éxito',
		'error'=>'Plan separe no ingresado.',
		'error_abonado' => 'El saldo abonado supera el valor de la deuda',
		'error_transferencia' => 'Para poder transferir el valor debe ser mayor a 0',
		'error_reversar' => 'No se puede reversar el abono',
		'error_delete'=>'Plan separe no inactivado.',
		'error_abonado2' => 'Para poder abonar el monto debe ser mayor a 0',
		'error_abonado3' => 'No se puede abonar la totalidad de la deuda, ya que el plan separe no pertenece a esta tienda.',
		'error_anulacion' => 'No se puede anular el plan aún tiene abonos asignados',
		'error_solicitud' => 'No se pudo hacer la solicitud de rechazo.',
		'error_cotizacion' => 'No se pudo crear la cotización',
		'rechazar_error' => 'No se pudo hacer reversar el abono.',
		'update_error'=>'Plan separe no actualizado.',
		'update_ok'=>'Plan separe actualizado con éxito.',
		'delete_ok'=>'Plan separe inactivado con éxito.',
		'active_ok' => 'Plan separe activado con éxito',
		'active_error' => 'Plan separe no fue activado',
	);	

	public static $ConfigPlan = array(
		'ok'=>'Configuración de plan separe ingresada con éxito.',
		'error'=>'Configuración de plan separe no ingresada.',
		'update_ok'=>'Configuración de plan separe actualizada con éxito.',
		'update_error'=>'Configuración de plan separe no actualizada.',
		'delete_ok'=>'Configuración de plan separe eliminada con éxito.',
		'inactive_ok'=>'Configuración de plan separe desactivada con éxito.',
		'delete_error'=>'Configuración de plan separe no eliminada.',
		'inactive_error'=>'Configuración de plan separe no desactivada.',
		'active_ok' => 'Configuración de plan separe activada con éxito',
		'active_error' => 'Configuración de plan separe no fue activada',
	);

	//Mensajes tipo impuesto
	public static $tipoImpuesto = array(
		'ok'=>'Tipo impuesto ingresado con éxito.',
		'error'=>'Tipo impuesto no ingresado.',
		'update_ok'=>'Tipo impuesto actualizado con éxito.',
		'update_error'=>'Tipo impuesto no actualizado.',
		'delete_ok'=>'Tipo impuesto inactivado con éxito.',
		'error_delete'=>'Tipo impuesto no inactivado.',
		'active_ok' => 'Tipo impuesto activado con éxito',
		'active_error' => 'Tipo impuesto no fue activado',
	);

	//Mensajes impuestos
	public static $Impuesto = array(
		'ok'=>'Impuesto ingresado con éxito.',
		'error'=>'Impuesto no ingresado.',
		'update_ok'=>'Impuesto actualizado con éxito.',
		'update_error'=>'Impuesto no actualizado.',
		'delete_ok'=>'Impuesto inactivado con éxito.',
		'error_delete'=>'Impuesto no inactivado.',
		'active_ok' => 'Impuesto activado con éxito',
		'active_error' => 'Impuesto no fue activado',
	);

	//Mensajes conceptos
	public static $Concepto = array(
		'ok'=>'Concepto ingresado con éxito.',
		'error'=>'Concepto no ingresado.',
		'update_ok'=>'Concepto actualizado con éxito.',
		'update_error'=>'Concepto no actualizado.',
		'delete_ok'=>'Concepto inactivado con éxito.',
		'error_delete'=>'Concepto no inactivado.',
		'active_ok' => 'Concepto activado con éxito',
		'active_error' => 'Concepto no fue activado',
	);

	//Mensajes refaccion
	public static $Refaccion = array(
		'ok'=>'Refacción procesada con éxito.',
		'error'=>'No se pudo procesar la refacción, comuniquese con su proveedor.',
		'fallo'=>'Uno de los items del contrato ya se proceso, no se puede realizar la operación.',
		'exito'=>'Se quitaron los items con éxito.',
		'error_quitar'=>'Fallo al intentar quitar los items.',
		'error_q_unico'=>'Refacción no inactivado.',
		'active_ok' => 'Refacción activado con éxito',
		'active_error' => 'Refacción no fue activado',
	);

	//Mensajes prerefaccion
	public static $Prefaccion = array(
		'ok'=>'Prerefacción procesada con éxito.',
		'error'=>'No se pudo procesar la prerefacción, comuniquese con su proveedor.',
		'fallo'=>'Uno de los items del contrato ya se proceso, no se puede realizar la operación.',
		'exito'=>'Se quitaron los items con éxito.',
		'error_quitar'=>'Fallo al intentar quitar los items.',
		'error_q_unico'=>'Prerefacción no inactivado.',
		'active_ok' => 'Prerefacción activado con éxito',
		'active_error' => 'Prerefacción no fue activado',
	);

	//Mensajes refaccion
	public static $Resolucion = array(
		'ok'=>'Resolución procesada con éxito.',
		'error'=>'No se pudo procesar la resolución, comuniquese con su proveedor.',
		'fallo'=>'Uno de los items del contrato ya se proceso, no se puede realizar la operación.',
		'exito'=>'Se quitaron los items con éxito.',
		'error_quitar'=>'Fallo al intentar quitar los items.',
		'error_q_unico'=>'Resolución no inactivado.',
		'active_ok' => 'Resolución activado con éxito',
		'active_error' => 'Resolución no fue activado',
		'exist_perfeccion' => 'Ya existe una orden de perfeccionamiento abierta, adicione o quite contratos sobre esa orden',
	);

	//Mensajes refaccion
	public static $Fundicion = array(
		'ok'=>'Fundición procesada con éxito.',
		'error'=>'No se pudo procesar la fundición, comuniquese con su proveedor.',
		'fallo'=>'Uno de los items del contrato ya se proceso, no se puede realizar la operación.',
		'exito'=>'Se quitaron los items con éxito.',
		'error_quitar'=>'Fallo al intentar quitar los items.',
		'error_q_unico'=>'Fundición no inactivado.',
		'active_ok' => 'Fundición activado con éxito',
		'active_error' => 'Fundición no fue activado',
	);


	//Mensajes Admin Franquicia
	public static $Franquicia = array(
		'ok'=>'Nombre Comercial ingresado con éxito, Será redireccionado a la página principal',
		'error'=>'Nombre Comercial No ingresado, Será redireccionado a la página principal.',
		'update_ok'=>'Nombre Comercial actualizado con éxito, Será redireccionado a la página principal.',
		'update_error'=>'Nombre Comercial no actualizado, Será redireccionado a la página principal.',
		'delete_ok'=>'Nombre Comercial inactivado con éxito.',
		'delete_error'=>'Nombre Comercial no inactivado.',
		'active_ok' => 'Nombre Comercial Activado con éxito',
		'active_error' => 'Nombre Comercial No fue Activado'
	);

	//Mensajes eps
	public static $Eps = array(
		'ok'=>'Eps ingresada con éxito.',
		'error'=>'Eps No ingresada.',
		'update_ok'=>'Eps actualizada con éxito.',
		'update_error'=>'Eps no actualizada.',
		'delete_ok'=>'Eps inactivada con éxito.',
		'error_delete'=>'Eps no inactivada.',
		'active_ok' => 'Eps Activada con éxito',
		'active_error' => 'Eps No fue activada',
	);

	//Mensajes caja de compensacion
	public static $Caja = array(
		'ok'=>'Caja de compensación ingresada con éxito.',
		'error'=>'Caja de compensación No ingresada.',
		'update_ok'=>'Caja de compensación actualizada con éxito.',
		'update_error'=>'Caja de compensación no actualizada.',
		'delete_ok'=>'Caja de compensación inactivada con éxito.',
		'error_delete'=>'Caja de compensación no inactivada.',
		'active_ok' => 'Caja de compensación Activada con éxito',
		'active_error' => 'Caja de compensación No fue activada',
	);

	//Mensajes Admin Departamento
	public static $Departamento = array(
		'ok'=>'Departamento ingresado con éxito.',
		'error'=>'Departamento No ingresado.',
		'update_ok'=>'Departamento actualizado con éxito.',
		'update_error'=>'Departamento no actualizado.',
		'delete_ok'=>'Departamento inactivado con éxito.',
		'delete_error'=>'Departamento no inactivado.',
		'active_ok' => 'Departamento Activado con éxito',
		'active_error' => 'Departamento No fue activado',
		'error_unique' => 'Este Departamento ya ha sido ingresado, es posible que este registro desactivado.',
	);

	//Mensajes Admin Sociedad
	public static $Sociedad = array(
		'ok'=>'Sociedad ingresada con éxito.',
		'error'=>'Sociedad No ingresada.',
		'update_ok'=>'Sociedad actualizada con éxito.',
		'update_error'=>'Sociedad no actualizada.',
		'delete_ok'=>'Sociedad inactivada con éxito.',
		'delete_error'=>'Sociedad no inactivada.',
		'active_ok' => 'Sociedad Activada con éxito',
		'active_error' => 'Sociedad No fue activada',
	);

	//Mensajes Admin Tipo Documento Dian
	public static $TipoDocumentoDian = array(
		'ok'=>'Tipo de Documento Dian ingresado con éxito.',
		'error'=>'Tipo de Documento Dian No ingresado.',
		'errorunique'=>'Tipo de Documento Dian ingresado ya esta registrado, es posible que este registro desactivado.',
		'update_ok'=>'Tipo de Documento Dian actualizado con éxito.',
		'update_error'=>'Tipo de Documento Dian no actualizado.',
		'delete_ok'=>'Tipo de Documento Dian inactivado con éxito.',
		'delete_error'=>'Tipo de Documento Dian no inactivado.',
		'active_ok' => 'Tipo de Documento Dian Activado con éxito',
		'active_error' => 'Tipo de Documento Dian No fue activada',
	);

	//Mensajes Admin Pasatiempo
	public static $Pasatiempo = array(
		'ok'=>'Pasatiempo  ingresado con éxito.',
		'error'=>'Pasatiempo  No ingresado.',
		'update_ok'=>'Pasatiempo  actualizado con éxito.',
		'update_error'=>'Pasatiempo  no actualizado.',
		'delete_ok'=>'Pasatiempo  inactivado con éxito.',
		'delete_error'=>'Pasatiempo  no inactivado.',
		'active_ok' => 'Pasatiempo Activado con éxito',
		'active_error' => 'Pasatiempo No fue activado',
	);

	//Mensajes Admin Profesion
	public static $Profesion = array(
		'ok'=>'Profesión ingresada con éxito.',
		'error'=>'Profesión No ingresada.',
		'update_ok'=>'Profesión actualizada con éxito.',
		'update_error'=>'Profesión no actualizada.',
		'delete_ok'=>'Profesión inactivada con éxito.',
		'delete_error'=>'Profesión no inactivada.',
		'active_ok' => 'Profesión Activada con éxito',
		'active_error' => 'Profesión No fue activada',
	);

	//Mensajes Admin Área de trabajo
	public static $Area = array(
		'ok'=>'Área ingresada con éxito.',
		'error'=>'Área No ingresada.',
		'update_ok'=>'Área actualizada con éxito.',
		'update_error'=>'Área no actualizada.',
		'delete_ok'=>'Área inactivada con éxito.',
		'delete_error'=>'Área no inactivada.',
		'active_ok' => 'Área Activada con éxito',
		'active_error' => 'Área No fue activada',
	);

	//Mensajes Admin Estado
	public static $Estado = array(
		'ok'=>'Estado  ingresado con éxito, será redireccionado atrás.',
		'error'=>'Estado  No ingresado, será redireccionado atrás.',
		'update_ok'=>'Estado  actualizado con éxito, será redireccionado atrás.',
		'update_error'=>'Estado  no actualizado, será redireccionado atrás.',
		'delete_ok'=>'Estado  inactivado con éxito.',
		'delete_error'=>'Estado  no inactivado.',
		'active_ok' => 'Estado Activado con éxito',
		'active_error' => 'Estado No fue activado',
		);

	//Mensajes Admin Motivo
	public static $Motivo = array(
		'ok'=>'Motivo  ingresado con éxito.',
		'error'=>'Motivo  No ingresado.',
		'update_ok'=>'Motivo  actualizado con éxito.',
		'update_error'=>'Motivo  no actualizado.',
		'delete_ok'=>'Motivo  inactivado con éxito.',
		'delete_error'=>'Motivo  no inactivado.',
		'active_ok' => 'Motivo Activado con éxito',
		'active_error' => 'Motivo No fue activado',
	);

	//Mensajes Admin AsociarTienda
	public static $AsociarTienda = array(
		'ok'=>'Tienda Asociada con éxito, será enviado a la página principal.',
		'error'=>'Tienda No Asociada.',
	);
	//Mensajes Admin Asociar Sociedad
	public static $AsociarSociedad = array(
		'ok'=>'Sociedad Asociada con éxito, será enviado a la página principal.',
		'error'=>'Sociedad No Asociada.',
	);

	//Mensajes Admin Plan Unico De cuentas
	public static $PlanUnicoCuenta = array(
		'ok'=>'PlanUnicoCuenta  ingresado con éxito.',
		'error'=>'PlanUnicoCuenta  No ingresado.',
		'update_ok'=>'PlanUnicoCuenta  actualizado con éxito.',
		'update_error'=>'PlanUnicoCuenta  no actualizado.',
		'delete_ok'=>'PlanUnicoCuenta  inactivado con éxito.',
		'delete_error'=>'PlanUnicoCuenta  no inactivado.',
		'active_ok' => 'PlanUnicoCuenta Activada con éxito',
		'active_error' => 'PlanUnicoCuenta No fue activada',
	);

	//Mensajes Admin Nivel de Confiabilidad
	public static $Confiabilidad = array(
		'ok'=>'Confiabilidad  ingresada con éxito.',
		'error'=>'Confiabilidad  No ingresada.',
		'update_ok'=>'Confiabilidad  actualizada con éxito.',
		'update_error'=>'Confiabilidad  no actualizada.',
		'delete_ok'=>'Confiabilidad  inactivada con éxito.',
		'delete_error'=>'Confiabilidad  no inactivada.',
		'active_ok' => 'Confiabilidad Activada con éxito',
		'active_error' => 'Confiabilidad No fue Activada',
	);

	//Mensajes Admin Cargo Empleado
	public static $CargoEmpleado = array(
		'ok'=>'Cargo de Empleado  ingresado con éxito.',
		'error'=>'Cargo de Empleado  No ingresado.',
		'update_ok'=>'Cargo de Empleado  actualizado con éxito.',
		'update_error'=>'Cargo de Empleado  no actualizado.',
		'delete_ok'=>'Cargo de Empleado  inactivado con éxito.',
		'delete_error'=>'Cargo de Empleado  no inactivado.',
		'active_ok' => 'Cargo de Empleado Activado con éxito',
		'active_error' => 'Cargo de Empleado No fue activado',
	);

	//Mensajes Admin Motivo de Retiro
	public static $MotivoRetiro = array(
		'ok'=>'Motivo de Retiro  ingresado con éxito.',
		'error'=>'Motivo de Retiro  No ingresado.',
		'update_ok'=>'Motivo de Retiro  actualizado con éxito.',
		'update_error'=>'Motivo de Retiro  no actualizado.',
		'delete_ok'=>'Motivo de Retiro  inactivado con éxito.',
		'delete_error'=>'Motivo de Retiro  no inactivado.',
		'active_ok' => 'Motivo de Retiro Activado con éxito',
		'active_error' => 'Motivo de Retiro No fue activado',
		);

	//Mensajes Cliente Tipo Trabajo
	public static $TipoTrabajo = array(
		'ok'=>'Tipo de Trabajo  ingresado con éxito.',
		'error'=>'Tipo de Trabajo  No ingresado.',
		'update_ok'=>'Tipo de Trabajo  actualizado con éxito.',
		'update_error'=>'Tipo de Trabajo  no actualizado.',
		'delete_ok'=>'Tipo de Trabajo  inactivado con éxito.',
		'delete_error'=>'Tipo de Trabajo  no inactivado.',
		'active_ok' => 'Tipo de Trabajo Activado con éxito',
		'active_error' => 'Tipo de Trabajo No fue activado',
	);

	//Mensajes Cliente Tipo Trabajo
	public static $FondoCesantias = array(
		'ok'=>'Fondo de Cesantías  ingresado con éxito.',
		'error'=>'Fondo de Cesantías  No ingresado.',
		'update_ok'=>'Fondo de Cesantías  actualizado con éxito.',
		'update_error'=>'Fondo de Cesantías  no actualizado.',
		'delete_ok'=>'Fondo de Cesantías  inactivado con éxito.',
		'delete_error'=>'Fondo de Cesantías  no inactivado.',
	);

	//Mensajes Cliente Tipo Empleado
	public static $Empleado = array(
		'ok'=>'Empleado ingresado con éxito.',
		'error'=>'Empleado No ingresado.',
		'update_ok'=>'Empleado actualizado con éxito.',
		'update_error'=>'Empleado no actualizado.',
		'delete_ok'=>'Empleado inactivado con éxito.',
		'delete_error'=>'Empleado no inactivado.',
		'active_ok' => 'Empleado Activado con éxito',
		'active_error' => 'Empleado No fue activado',
	);

	//Mensajes Cliente
	public static $Cliente = array(
		'ok'=>'Cliente ingresado con éxito.',
		'error'=>'Cliente No ingresado.',
		'update_ok'=>'Cliente actualizado con éxito.',
		'update_error'=>'Cliente no actualizado.',
		'delete_ok'=>'Cliente inactivado con éxito.',
		'delete_error'=>'Cliente no inactivado.',
		'active_ok' => 'Cliente Activado con éxito',
		'active_error' => 'Cliente No fue activado',
		'update_ok_persona_juridica' => 'Cliente persona juridica actualizada con éxito',
		'update_error_persona_juridica' => 'Cliente persona juridica no actualizada',
		'update_ok_proveedor_natural' => 'Cliente proveedor natural actualizado con éxito',
		'update_error_proveedor_natural' => 'Cliente proveedor natural no actualizado',
	);

	public static $ExectionGeneral = array(
		'error_unique' => 'Este valor ya está registrado, es posible que este desactivado.',
		'error_enuso' => 'Este elemento está siendo en uso, por lo tanto no puede eliminarlo',
	);

	//Mensajes Contrato
	public static $aplazoContrato = array(
		'ok'=>'Contrato aplazado con éxito.',
		'error'=>'No se puede aplazar el contrato hasta la fecha seleccionada.',
		'count_error'=>'No se permiten aplazos para esa fecha.',
		'date_error'=>'La fecha ingresada, debe ser superior a la última fecha de aplazo.',
		'date_before_error'=>'La fecha ingresada, no puede ser inferior a la fecha de creación del contrato',
	);

	//Mensajes Contrato Cerrado
	public static $CerrarContrato = array(
		'ok'=>'Contrato cerrado con éxito.',
		'error'=>'Contrato no Cerrado.',
		'invalid' => 'No puede cerrar este contrato'
	);

	//Mensajes Contrato Retroventa
	public static $RetroventaContrato = array(
		'ok'=>'Retroventa del contrato con éxito.',
		'error'=>'Retroventa del contrato falló.',
		'invalid'=>'No puede realizar la retroventa a este contrato porque no está activo o no es de la tienda actual.',
	);

	public static $prorrogaContrato = array(
		'ok'=>'Contrato prorrogado con éxito.',
		'error'=>'Contrato no prorrogado.',
		'invalid'=>'No puede prorrogar este contrato porque no esta activo.',
	);

	public static $aplazarContrato = array(
		'ok'=>'Contrato prorrogado con éxito.',
		'error'=>'Contrato no aplazado.',
		'invalid'=>'No puede aplazar este contrato porque no está activo o no es de la tienda actual.',
	);

	public static $terceroContrato = array(
		'ok'=>'Tercero guardado con éxito.',
		'error'=>'Tercero no guardado.',
	);

	public static $DiasFestivos = array(
		'ok'=>'Día festivo ingresado con éxito.',
		'error'=>'Día festivo no guardado.',
		'update_ok'=>'Día Festivo actualizado con éxito.',
		'update_error'=>'Día Festivo no actualizado.',
		'delete_ok'=>'Día Festivo inactivado con éxito.',
		'delete_error'=>'Día Festivo no inactivado.',
		'active_ok' => 'Día Festivo Activado con éxito',
		'active_error' => 'Día Festivo No fue activado',
	);

	//Mensajes Notificacion
	public static $Notificacion = array(
		'ok'=>'Mensaje matriculado correctamente.',
		'error'=>'Mensaje no matriculado.',
		'delete_ok'=>'Mensaje marcado como visto correctamente.',
		'delete_error'=>'Mensaje no se pudo marcar como visto.',
		'anulacion_realizada'=>'Anulación realizada con éxito.',		
		'ok_anular_contrato'=>'Solicitud enviada correctamente.',		
		'ok_anular_contrato_aprobado'=>'Solicitud aprobada correctamente.',		
		'ok_anular_contrato_rechazado'=>'Solicitud rechazada correctamente.',		
		'ok_anular_contrato_anulado'=>'Contrato anulado correctamente.',		
		'ok_cerrar_contrato_cerrado'=>'Contrato cerrado correctamente.',		
		'ok_cerrar_contrato_reversado'=>'Contrato reversado correctamente.',	
		'error_contrato_empleado'=>'No puede crear un contrato a sí mismo.',		
		'error_anular_contrato'=>'Solicitud fallo, inténtelo nuevamente. Si el error persiste contacte a su administrador. ',
		'mensaje_solicitud'=>'Solicitud para anular el contrato.',
		'mensaje_solicitud_cerrado'=>'Solicitud para cerrar el contrato.',
		'mensaje_solicitud_reversa'=>'Solicitud para reversar el contrato.',
		'mensaje_solicitud_aprobada'=>'Solicitud aprobada para anular el contrato.',
		'mensaje_solicitud_rechazada'=>'Solicitud rechazada para anular el contrato.',
		'mensaje_solicitud_abono_reversar'=>'Solicitud para reversar el abono.',
		'mensaje_solicitud_abono_rechazada'=>'Solicitud rechazada para reversar el abono.',
		'mensaje_causacion_pendiente' => 'tiene una causación pendiente por revisar.',
		'mensaje_causacion_anular' => 'tiene una causación pendiente por anular.',
		'mensaje_transferencia' => 'Se le ha transferido un pago.',
		'ok_reverso_abono'=>'Solicitud enviada para reversar el abono.',
		'ok_reversar_abono_rechazado' => 'Solicitud rechazada correctamente.',
		'error_reverso_abono'=>'Solicitud rechazada para reversar el abono.',
		'mensaje_solicitud_anular_plan_separe'=>'Solicitud para anular el plan separe',
		'error_anular_plan_separe'=>'Solicitud rechazada para anular plan separe.',
		'ok_anular_plan_separe'=>'Plan separe anulado correctamente',
		'ok_causacion_pentiende'=>'Causación realizada.',
		'error_causacion_pentiende'=>'Algo paso en el mensaje de la causación.',

	);

	//Mensajes Admin Denominacion de Moneda
	public static $DenominacionMoneda = array(
		'ok'=>'Denominación  ingresada con éxito.',
		'error'=>'Denominación  No ingresada.',
		'update_ok'=>'Denominación  actualizada con éxito.',
		'update_error'=>'Denominación  no actualizada.',
		'delete_ok'=>'Denominación  inactivada con éxito.',
		'delete_error'=>'Denominación  no inactivada.',
		'active_ok' => 'Denominación  Activada con éxito',
		'active_error' => 'Denominación  No fue activada',
	);

	public static $Pedidos = array(
		'ok' => 'Pedido guardado con éxito',
		'ok_g' => 'Pedido generado con exito',
		'ok_a' => 'Datos actualizados con exito',
		'ok_aprobar' => 'Pedido aprobado con éxito',
		'ok_rechazado' => 'Pedido rechazado con éxito',
		'error' => 'No se pudo ingresar la información',
		'updateAjax' => 'Actulizado con éxito'
	);

	public static $Inventario = array(
		'ok' => 'Inventario guardado con éxito.',
		'error' => 'No se pudo ingresar la información.',
		'error_secuencia' => 'La tienda selecciona no tiene secuencia.',
		'ok_update' => 'Inventario actualizado con éxito.',
		'error_update' => 'No se pudo actualizar la información.'
	);

	public static $Ventas = array(
		'ok' => 'Factura generada con exito',
		'error' => 'No se pudo generar la factura'
	);

	public static $Compras = array(
		'ok' => 'Factura generada con exito',
		'error' => 'No se pudo generar la factura'
	);

	public static $Devoluciones = array(
		'ok' => 'Devolución realizada con éxito',
		'error' => 'No se pudo realizar la devolución'
	);

	public static $ConfiguracionContable = array(
		'ok' => 'Configuración realizada con éxito',
		'error' => 'No se pudo realizar la Configuración',
		'delete_error' => 'No se pudo eliminar la Configuración',
		'delete_ok' => 'Se eliminó la Configuración con éxito',
		'update_ok' => 'Se actualizó la Configuración con éxito',
		'update_error' => 'No se pudo actualizar la Configuración'
	);

	public static $Arqueo = array(
		'ok' => 'Arqueo realizado con éxito.',
		'error' => 'No se pudo finalizar el arqueo.',
		'cierre_caja_ok' => 'El cierre de caja fue realizado con éxito',
		'cierre_caja_error' => 'El cierre de caja no se pudo realizar'
	);

	public static $Causacion = array(
		'salario_ok' => 'Pago de nomina registrada con éxito.',
		'salario_error' => 'No se realizar el pago de nomina.',
		'pay_ok' => 'Pago realizado con éxito',
		'cancel_ok' => 'Pago anulado con éxito',
		'transfer_ok' => 'Transferencia realizada con éxito',
		'solicitud_ok' => 'Solicitud enviada con éxito'
	);

	public static $Prestamos = array(
		'prestamo_ok' => 'Prestamo realizado con éxito.',
		'prestamo_error' => 'No se realizar el prestamo.',
	);

	public static $TipoDocumentoContable = array(
		'ok' => 'Tipo de Documento Contable realizado con éxito',
		'error' => 'No se pudo realizar el Tipo de Documento Contable',
		'using' => 'Este registro no se puede eliminar porque está siendo usado.',
		'delete_error' => 'No se pudo eliminar el Tipo de Documento Contable',
		'delete_ok' => 'Se eliminó el Tipo de Documento Contable con éxito',
		'desactivate_error' => 'No se pudo desactivar el Tipo de Documento Contable',
		'desactivate_ok' => 'Se desactivo el Tipo de Documento Contable con éxito',
		'update_ok' => 'Se actualizó el Tipo de Documento Contable con éxito',
		'update_error' => 'No se pudo actualizar el Tipo de Documento Contable',
		'active_ok' => 'Tipo de Documento Contable Activado con éxito',
		'active_error' => 'Tipo de Documento Contable No fue activado',
	);

	public static $Trazabilidad = array(
		'ok' => 'Trazabilidad guardada con éxito.',
		'error' => 'No se pudo registrar la trazabilidad.',
	);
}
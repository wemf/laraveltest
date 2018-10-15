<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rutas del sistema.
| Ejemplo para implementar por route individual middleware: //->middleware('isFuncionalidad:AS'); 
*/

/* Usuarios logueados*/
Route::group(['middleware'=>['auth','userIpValidated',"RequestTrim"]],function(){


    // Validate users logged
    Route::get('/userslogged', 'HomeController@usersLogged');  

    ////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////Módulo///////////////////////////////////////////
    //////////////////////////////Gestión de Productos////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////

    /* Categorías Generales */
    Route::group(['middleware'=>'isFuncionalidad:gestionProducto.asociarGeneral'],function(){   
        /* Admin Productos */
        Route::get('/products/categories', 'Nutibara\Products\CategoryController@index');
        Route::get('/products/categories/create', 'Nutibara\Products\CategoryController@create');
        Route::get('/products/categories/edit/{id}', 'Nutibara\Products\CategoryController@edit');
        Route::post('/products/categories/store', 'Nutibara\Products\CategoryController@store');
        Route::post('/products/categories/update', 'Nutibara\Products\CategoryController@update');
        Route::post('/products/categories/inactive', 'Nutibara\Products\CategoryController@inactive');
        Route::post('/products/categories/delete', 'Nutibara\Products\CategoryController@delete');
        Route::post('/products/categories/active', 'Nutibara\Products\CategoryController@Active');      
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/products/categories/get', 'Nutibara\Products\CategoryController@get');
    Route::get('/products/categories/getCategory', 'Nutibara\Products\CategoryController@getCategory');
    Route::get('/products/categories/getCategoryNullItem', 'Nutibara\Products\CategoryController@getCategoryNullItem');
    Route::get('/products/categories/getAttributeCategoryById', 'Nutibara\Products\CategoryController@getAttributeCategoryById');
    Route::get('/products/categories/getFirstAttributeCategoryById', 'Nutibara\Products\CategoryController@getFirstAttributeCategoryById');	
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Atributos */
    Route::group(['middleware'=>'isFuncionalidad:gestionProducto.atributoProducto'],function(){  
        /* Attributes */
        Route::get('/products/attributes', 'Nutibara\Products\AttributeController@index'); 
        Route::get('/products/attributes/create', 'Nutibara\Products\AttributeController@create');
        Route::post('/products/attributes/store', 'Nutibara\Products\AttributeController@store');
        Route::get('/products/attributes/edit/{id}', 'Nutibara\Products\AttributeController@edit');
        Route::post('/products/attributes/update', 'Nutibara\Products\AttributeController@update');
        Route::post('/products/attributes/inactive', 'Nutibara\Products\AttributeController@inactive');
        Route::post('/products/attributes/delete', 'Nutibara\Products\AttributeController@delete');        
        Route::post('/products/attributes/active', 'Nutibara\Products\AttributeController@Active');       
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/products/attributes/get', 'Nutibara\Products\AttributeController@get');
    Route::get('/products/attributes/getAttribute', 'Nutibara\Products\AttributeController@getAttribute');
    Route::get('/products/attributes/getAttributesByCategories', 'Nutibara\Products\AttributeController@getAttributesByCategories');
    Route::get('/products/attributes/getAttributeValueById', 'Nutibara\Products\AttributeController@getAttributeValueById');
    Route::get('/products/attributes/getAttributeAttributesById', 'Nutibara\Products\AttributeController@getAttributeAttributesById');
    Route::get('/products/attributes/getAttributeValueByName', 'Nutibara\Products\AttributeController@getAttributeValueByName');
    Route::get('/products/attributes/getAttributeValueUpdate', 'Nutibara\Products\AttributeController@getAttributeValueUpdate');
    Route::get('/products/attributes/getAttributeColumnByCategory', 'Nutibara\Products\AttributeController@getAttributeColumnByCategory');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Valores de Atributos */
    Route::group(['middleware'=>'isFuncionalidad:gestionProducto.valorAtributo'],function(){  
        /* Attribute Values */
        Route::get('/products/attributevalues', 'Nutibara\Products\AttributeValueController@index');
        Route::get('/products/attributevalues/exporttoexcel', 'Nutibara\Products\AttributeValueController@exportToExcel');
        Route::get('/products/attributevalues/create', 'Nutibara\Products\AttributeValueController@create');
        Route::post('/products/attributevalues/store', 'Nutibara\Products\AttributeValueController@store');
        Route::get('/products/attributevalues/edit/{id}', 'Nutibara\Products\AttributeValueController@edit');
        Route::post('/products/attributevalues/update', 'Nutibara\Products\AttributeValueController@update');
        Route::post('/products/attributevalues/inactive', 'Nutibara\Products\AttributeValueController@inactive');
        Route::post('/products/attributevalues/delete', 'Nutibara\Products\AttributeValueController@delete');
        Route::post('/products/attributevalues/active', 'Nutibara\Products\AttributeValueController@Active');       
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/products/attributevalues/get', 'Nutibara\Products\AttributeValueController@get');
    Route::post('/contrato/products/attributevalues/store', 'Nutibara\Products\AttributeValueController@storeFromContr');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Catálogo de Productos */
    Route::group(['middleware'=>'isFuncionalidad:gestionProducto.catalogoProducto'],function(){  
        /* Product References */
        Route::get('/products/references', 'Nutibara\Products\ReferenceController@index');        
        Route::get('/products/references/create', 'Nutibara\Products\ReferenceController@create');
        Route::post('/products/references/store', 'Nutibara\Products\ReferenceController@store');
        Route::get('/products/references/edit/{id}', 'Nutibara\Products\ReferenceController@edit');
        Route::post('/products/references/update', 'Nutibara\Products\ReferenceController@update');
        Route::post('/products/references/inactive', 'Nutibara\Products\ReferenceController@inactive');
        Route::post('/products/references/delete', 'Nutibara\Products\ReferenceController@delete');
        Route::post('/products/references/active', 'Nutibara\Products\ReferenceController@Active');       
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/products/references/get', 'Nutibara\Products\ReferenceController@get');
    Route::get('/products/reference/getbyid', 'Nutibara\Products\ReferenceController@getbyid');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    
    ////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////Módulo///////////////////////////////////////////
    //////////////////////////////Gestión de Contratos////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////

    /* Configuración General */
    Route::group(['middleware'=>'isFuncionalidad:configContrato.configGeneral'],function(){     
        Route::get('/configcontrato/general', 'Nutibara\ConfigContrato\GeneralController@index');        
        Route::get('/configcontrato/general/create', 'Nutibara\ConfigContrato\GeneralController@create');
        Route::post('/configcontrato/general/store', 'Nutibara\ConfigContrato\GeneralController@store');
        Route::get('/configcontrato/general/edit/{id}', 'Nutibara\ConfigContrato\GeneralController@edit');
        Route::post('/configcontrato/general/update', 'Nutibara\ConfigContrato\GeneralController@update');
        Route::post('/configcontrato/general/inactive', 'Nutibara\ConfigContrato\GeneralController@inactive');
        Route::post('/configcontrato/general/delete', 'Nutibara\ConfigContrato\GeneralController@delete'); 
        Route::post('/configcontrato/general/active', 'Nutibara\ConfigContrato\GeneralController@Active');    
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/configcontrato/general/get', 'Nutibara\ConfigContrato\GeneralController@get');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Configuración Específica */
    Route::group(['middleware'=>'isFuncionalidad:configContrato.configEspecifica'],function(){ 
        Route::get('/configcontrato/especifica', 'Nutibara\ConfigContrato\EspecificaController@index');        
        Route::get('/configcontrato/especifica/create', 'Nutibara\ConfigContrato\EspecificaController@create');
        Route::post('/configcontrato/especifica/store', 'Nutibara\ConfigContrato\EspecificaController@store');
        Route::get('/configcontrato/especifica/edit/{id}', 'Nutibara\ConfigContrato\EspecificaController@edit');
        Route::post('/configcontrato/especifica/update', 'Nutibara\ConfigContrato\EspecificaController@update');
        Route::post('/configcontrato/especifica/inactive', 'Nutibara\ConfigContrato\EspecificaController@inactive');
        Route::post('/configcontrato/especifica/delete', 'Nutibara\ConfigContrato\EspecificaController@delete');  
        Route::post('/configcontrato/especifica/active', 'Nutibara\ConfigContrato\EspecificaController@Active');       
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/configcontrato/especifica/get', 'Nutibara\ConfigContrato\EspecificaController@get');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Configuración de Días de Gracia */
    Route::group(['middleware'=>'isFuncionalidad:configContrato.configDiaGracia'],function(){ 
        /* Configuración de Contratos - Día de Gracia */
        Route::get('/configcontrato/diagracia', 'Nutibara\ConfigContrato\DiaGraciaController@index');        
        Route::get('/configcontrato/diagracia/create', 'Nutibara\ConfigContrato\DiaGraciaController@create');
        Route::post('/configcontrato/diagracia/store', 'Nutibara\ConfigContrato\DiaGraciaController@store');
        Route::get('/configcontrato/diagracia/edit/{id}', 'Nutibara\ConfigContrato\DiaGraciaController@edit');
        Route::post('/configcontrato/diagracia/update', 'Nutibara\ConfigContrato\DiaGraciaController@update');
        Route::post('/configcontrato/diagracia/inactive', 'Nutibara\ConfigContrato\DiaGraciaController@inactive');
        Route::post('/configcontrato/diagracia/delete', 'Nutibara\ConfigContrato\DiaGraciaController@delete');   
        Route::post('/configcontrato/diagracia/active', 'Nutibara\ConfigContrato\DiaGraciaController@Active');      
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/configcontrato/diagracia/get', 'Nutibara\ConfigContrato\DiaGraciaController@get');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Configuración de Aplicación de Retroventa */
    Route::group(['middleware'=>'isFuncionalidad:configContrato.configRetroventa'],function(){ 
        /* Configuración de Contratos - Aplicación de Retroventa */
        Route::get('/configcontrato/apliretroventa', 'Nutibara\ConfigContrato\ApliRetroventaController@index');        
        Route::get('/configcontrato/apliretroventa/create', 'Nutibara\ConfigContrato\ApliRetroventaController@create');
        Route::post('/configcontrato/apliretroventa/store', 'Nutibara\ConfigContrato\ApliRetroventaController@store');
        Route::get('/configcontrato/apliretroventa/edit/{id}', 'Nutibara\ConfigContrato\ApliRetroventaController@edit');
        Route::post('/configcontrato/apliretroventa/update', 'Nutibara\ConfigContrato\ApliRetroventaController@update');
        Route::post('/configcontrato/apliretroventa/inactive', 'Nutibara\ConfigContrato\ApliRetroventaController@inactive');
        Route::post('/configcontrato/apliretroventa/delete', 'Nutibara\ConfigContrato\ApliRetroventaController@delete'); 
        Route::post('/configcontrato/apliretroventa/active', 'Nutibara\ConfigContrato\ApliRetroventaController@Active');        
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/configcontrato/apliretroventa/get', 'Nutibara\ConfigContrato\ApliRetroventaController@get');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Configuración Item */
    Route::group(['middleware'=>'isFuncionalidad:configContrato.configContrato'],function(){
        /* Configuración de Contratos - Item para Contrato */
        Route::get('/configcontrato/itemcontrato', 'Nutibara\ConfigContrato\ItemContratoController@index');
        Route::get('/configcontrato/itemcontrato/create', 'Nutibara\ConfigContrato\ItemContratoController@create');
        Route::post('/configcontrato/itemcontrato/store', 'Nutibara\ConfigContrato\ItemContratoController@store');
        Route::get('/configcontrato/itemcontrato/edit/{id}', 'Nutibara\ConfigContrato\ItemContratoController@edit');
        Route::post('/configcontrato/itemcontrato/update', 'Nutibara\ConfigContrato\ItemContratoController@update');
        Route::post('/configcontrato/itemcontrato/inactive', 'Nutibara\ConfigContrato\ItemContratoController@inactive');
        Route::post('/configcontrato/itemcontrato/delete', 'Nutibara\ConfigContrato\ItemContratoController@delete'); 
        Route::post('/configcontrato/itemcontrato/active', 'Nutibara\ConfigContrato\ItemContratoController@Active'); 
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/configcontrato/itemcontrato/get', 'Nutibara\ConfigContrato\ItemContratoController@get');
    Route::get('/configcontrato/itemcontrato/getbycategoria', 'Nutibara\ConfigContrato\ItemContratoController@getByCategoria');
    Route::get('/configcontrato/itemcontrato/getatributos', 'Nutibara\ConfigContrato\ItemContratoController@getAtributosEdit');
    Route::get('/configcontrato/itemcontrato/getatributoscontrato', 'Nutibara\ConfigContrato\ItemContratoController@getAtributosContrato');
    Route::get('/configcontrato/itemcontrato/getatributoshijoscontrato', 'Nutibara\ConfigContrato\ItemContratoController@getAtributosHijosContrato');
    /////////////////////Fin Consultas por Ajax/////////////////////////        

    /* Configuración  de Precio Sugerido */
    Route::group(['middleware'=>'isFuncionalidad:configContrato.configPrecio'],function(){
        /* Configuración de Contratos - Valor Sugerido */
        Route::get('/configcontrato/valorsugerido', 'Nutibara\ConfigContrato\ValorSugeridoController@index');        
        Route::get('/configcontrato/valorsugerido/create', 'Nutibara\ConfigContrato\ValorSugeridoController@create');
        Route::post('/configcontrato/valorsugerido/store', 'Nutibara\ConfigContrato\ValorSugeridoController@store');        
        Route::get('/configcontrato/valorsugerido/edit/{id}', 'Nutibara\ConfigContrato\ValorSugeridoController@edit');
        Route::post('/configcontrato/valorsugerido/update', 'Nutibara\ConfigContrato\ValorSugeridoController@update');
        Route::post('/configcontrato/valorsugerido/inactive', 'Nutibara\ConfigContrato\ValorSugeridoController@inactive');
        Route::post('/configcontrato/valorsugerido/delete', 'Nutibara\ConfigContrato\ValorSugeridoController@delete');
        Route::post('/configcontrato/valorsugerido/active', 'Nutibara\ConfigContrato\ValorSugeridoController@Active');
        Route::get('/configcontrato/valorsugerido/getAttributeValueUpdate', 'Nutibara\ConfigContrato\ValorSugeridoController@getAttributeValueUpdate');

        /* Configuración de Contratos - Valor Venta */
        Route::get('/configcontrato/valorventa', 'Nutibara\ConfigContrato\ValorVentaController@index');        
        Route::get('/configcontrato/valorventa/create', 'Nutibara\ConfigContrato\ValorVentaController@create');
        Route::post('/configcontrato/valorventa/store', 'Nutibara\ConfigContrato\ValorVentaController@store');        
        Route::get('/configcontrato/valorventa/edit/{id}', 'Nutibara\ConfigContrato\ValorVentaController@edit');
        Route::post('/configcontrato/valorventa/update', 'Nutibara\ConfigContrato\ValorVentaController@update');
        Route::post('/configcontrato/valorventa/inactive', 'Nutibara\ConfigContrato\ValorVentaController@inactive');
        Route::post('/configcontrato/valorventa/delete', 'Nutibara\ConfigContrato\ValorVentaController@delete');
        Route::post('/configcontrato/valorventa/active', 'Nutibara\ConfigContrato\ValorVentaController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/configcontrato/valorsugerido/get', 'Nutibara\ConfigContrato\ValorSugeridoController@get');
    Route::post('/configcontrato/valorsugerido/getValById', 'Nutibara\ConfigContrato\ValorSugeridoController@getValById');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/configcontrato/valorventa/get', 'Nutibara\ConfigContrato\ValorVentaController@get');
    Route::post('/configcontrato/valorventa/getValById', 'Nutibara\ConfigContrato\ValorVentaController@getValById');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Gestionar Contratos */
    Route::group(['middleware'=>'isFuncionalidad:gestionarContrato'],function(){
        /* Contratos - Creación Contrato */
        Route::get('/creacioncontrato/verificacioncliente', 'Nutibara\Contrato\CreacionContratoController@verificarcliente');
        Route::get('/creacioncontrato/verificacionclientewebservice', 'Nutibara\Contrato\CreacionContratoController@verificacionclientewebservice');
        Route::get('/creacioncontrato/{tipodocumento}/{numdocumento}', 'Nutibara\Contrato\CreacionContratoController@index');
        Route::get('/creacioncontrato/{tipodocumento}/{numdocumento}/{pa}/{sa}/{pn}/{sn}/{fn}/{gen}/{rh}', 'Nutibara\Contrato\CreacionContratoController@index');
        Route::get('/creacioncontrato', 'Nutibara\Contrato\CreacionContratoController@Create');
        Route::post('/creacioncontrato/crearcliente', 'Nutibara\Contrato\CreacionContratoController@crearCliente');
        Route::post('/creacioncontrato/actualizarcliente', 'Nutibara\Contrato\CreacionContratoController@actualizarCliente');
        Route::post('/creacioncontrato/guardarcontrato', 'Nutibara\Contrato\CreacionContratoController@guardarContrato');
        Route::post('/creacioncontrato/actualizarcontrato', 'Nutibara\Contrato\CreacionContratoController@actualizarContrato');
        Route::get('/creacioncontrato/getitems/{codigo}/{idtienda}', 'Nutibara\Contrato\CreacionContratoController@getItems');
        Route::get('/creacioncontrato/getitemcontratodetalle', 'Nutibara\Contrato\CreacionContratoController@getItemContratoDetalle');
        Route::get('/creacioncontrato/getatributosvaloresitem', 'Nutibara\Contrato\CreacionContratoController@getAtributosValoresItem');
        Route::post('/creacioncontrato/actualizaritem', 'Nutibara\Contrato\CreacionContratoController@actualizarItem');
        Route::post('/creacioncontrato/deleteitem', 'Nutibara\Contrato\CreacionContratoController@deleteItem');
        Route::post('/creacioncontrato/guardaritem', 'Nutibara\Contrato\CreacionContratoController@guardarItem');
        Route::post('/creacioncontrato/getresumen', 'Nutibara\Contrato\CreacionContratoController@getResumen');
        Route::get('/creacioncontrato/getterminoretroventa', 'Nutibara\Contrato\CreacionContratoController@getTerminoRetroventa');
        Route::get('/creacioncontrato/validarBolsaPeso', 'Nutibara\Contrato\CreacionContratoController@validarBolsaPeso');
        Route::get('/creacioncontrato/pesoEstimado', 'Nutibara\Contrato\CreacionContratoController@pesoEstimado');
        Route::post('/contrato/actualizartercero', 'Nutibara\Contratos\ContratoController@actualizarTercero');
        Route::post('/contrato/guardartercero', 'Nutibara\Contratos\ContratoController@guardarTercero');
        Route::post('/contrato/extraviado', 'Nutibara\Contratos\ContratoController@contratoExtraviado');
        
        Route::get('creacioncontrato/pdfcompraventacontrato/{contrato}/{tienda}', 'Nutibara\Contrato\CreacionContratoController@pdfCompraventaContrato');
        Route::post('creacioncontrato/generarpdf', 'Nutibara\Contrato\CreacionContratoController@generatePDF');
        Route::get('creacioncontrato/generarpdf/{contrato}/{tienda}', 'Nutibara\Contrato\CreacionContratoController@generatePDF2');
        
        /* Contratos - Consultar Contrato*/
        Route::get('/contrato/index', 'Nutibara\Contratos\ContratoController@index');
        Route::get('/contrato/get', 'Nutibara\Contratos\ContratoController@get');
        Route::get('/contrato/aplazar/{id}/{id_tienda}', 'Nutibara\Contratos\ContratoController@aplazar');
        Route::post('/contrato/aplazar', 'Nutibara\Contratos\ContratoController@aplazarPost');
        Route::get('/contrato/aplazar/get', 'Nutibara\Contratos\ContratoController@getAplazarById');
        Route::get('/contrato/ver/{id}/{id_tienda}', 'Nutibara\Contratos\ContratoController@verContrato');
        
        /* Retroventa de Contrato */
        Route::get('/contrato/retroventa/{id}/{id_tienda}', 'Nutibara\Contratos\ContratoController@retroventa');
        Route::get('/contrato/retroventapost/{id}/{id_tienda}/{valor}', 'Nutibara\Contratos\ContratoController@retroventaPost');
        Route::get('/contrato/reversarretroventa/{id}/{id_tienda}/{valor}', 'Nutibara\Contratos\ContratoController@reversarRetroventaPost');
    
        /* Prorrogar Contrato */
        Route::get('/contrato/prorrogar/{id}/{id_tienda}', 'Nutibara\Contratos\ContratoController@prorrogar');
        Route::post('/contrato/prorrogar', 'Nutibara\Contratos\ContratoController@prorrogarPost');
        
        /* Cerrar Contratos */
        Route::get('/contrato/cerrarcontrato/{id}/{id_tienda}', 'Nutibara\Contratos\CerrarContratoController@index');
        Route::get('/contrato/cerrarcontrato/listMotivosEstado', 'Nutibara\Contratos\CerrarContratoController@ListMotivosEstado');
        Route::post('/contrato/cerrarcontrato/cerrar', 'Nutibara\Contratos\CerrarContratoController@CerrarUpdate');    
        Route::get('/contrato/cerrarcontratodescargar/{file}', 'Nutibara\Contratos\CerrarContratoController@descargar');    
        Route::post('/contrato/cerrarcontrato/consultarArchivo', 'Nutibara\Contratos\CerrarContratoController@consultarArchivo');    
        Route::post('/contrato/cerrarcontrato/solicitudcerrar', 'Nutibara\Contratos\CerrarContratoController@SolicitudCerrarUpdate');
        Route::post('/contrato/cerrarcontrato/solicitudreversarcierre', 'Nutibara\Contratos\CerrarContratoController@SolicitudReversarCierreUpdate');    
        Route::post('/contrato/cerrarcontrato/reversarcierre', 'Nutibara\Contratos\CerrarContratoController@ReversarCierreUpdate'); 
        
        /* Anular Contratos */
        Route::get('/contrato/anular/{codigoContrato}/{idTiendaContrato}', 'Nutibara\Contratos\AnularController@index');
        Route::get('/contrato/anular/{codigoContrato}/{idTiendaContrato}/{idRemitente}', 'Nutibara\Contratos\AnularController@index');
        
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    /* Contratos - Creación Contrato */
    Route::post('/contrato/prorrogarAjax', 'Nutibara\Contratos\ContratoController@ProrrogarPostAjax');
    Route::get('/creacioncontrato/getitems/{codigo}/{idtienda}', 'Nutibara\Contrato\CreacionContratoController@getItems');
    Route::get('/creacioncontrato/getitemscontrato/{codigo}/{idtienda}', 'Nutibara\Contrato\CreacionContratoController@getItemsContrato');
    Route::get('/creacioncontrato/getitemcontratodetalle', 'Nutibara\Contrato\CreacionContratoController@getItemContratoDetalle');
    Route::post('/creacioncontrato/getresumen', 'Nutibara\Contrato\CreacionContratoController@getResumen');
    Route::get('/creacioncontrato/getterminoretroventa', 'Nutibara\Contrato\CreacionContratoController@getTerminoRetroventa');
    Route::get('/contrato/cerrarcontrato/{id}/{id_tienda}/{idRemitente}', 'Nutibara\Contratos\CerrarContratoController@index');
    
    
    Route::get('contrato/prorrogar/generarpdf/{contrato}/{tienda}', 'Nutibara\Contratos\ContratoController@prorrogaGeneratePDF');
    
    /* Contratos - Consultar Contrato*/
    Route::get('/contrato/get', 'Nutibara\Contratos\ContratoController@get');
    Route::get('/contrato/aplazar/get', 'Nutibara\Contratos\ContratoController@getAplazarById');

    /* Cerrar Contratos */
    Route::get('/contrato/cerrarcontrato/listMotivosEstado', 'Nutibara\Contratos\CerrarContratoController@ListMotivosEstado');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /* Logistica contratos *////////////////////////////////////////////////////////////
    Route::group(['middleware'=>'isFuncionalidad:logistica'],function(){
        Route::get('/contrato/logistica','Nutibara\Contratos\logisticaController@logistica');
        Route::get('/contrato/logistica/trazabilidad/{id}','Nutibara\Contratos\logisticaController@trazabilidad');
        Route::get('/contrato/logistica/anular/{id}','Nutibara\Contratos\logisticaController@anular');
        Route::get('/contrato/logistica/get','Nutibara\Contratos\logisticaController@get');
        Route::get('/contrato/logistica/seguimiento/{id}','Nutibara\Contratos\logisticaController@seguimiento');
        Route::post('/contrato/logistica/create','Nutibara\Contratos\logisticaController@createPost');
    });
    //////////////////////////////* Logistica contratos  ajax*////////////////////////
    Route::get('/contrato/logistica/create','Nutibara\Contratos\logisticaController@create');
    Route::get('/contrato/logistica/getResolucionesById','Nutibara\Contratos\logisticaController@getResolucionesById');
    Route::get('/contrato/logistica/getSedePrincipal','Nutibara\Contratos\logisticaController@getSedePrincipal');
    Route::get('/contrato/logistica/getEmpleadosTienda','Nutibara\Contratos\logisticaController@getEmpleadosTienda');
    Route::get('/contrato/logistica/getSelectListByTipe','Nutibara\Contratos\logisticaController@getSelectListByTipe');
    Route::post('/contrato/logistica/anularGuia','Nutibara\Contratos\logisticaController@anularGuia');
    Route::post('/contrato/logistica/seguimientoGuia','Nutibara\Contratos\logisticaController@seguimientoGuia');
    
    Route::get('/contrato/logistica/prueba','Nutibara\Contratos\logisticaController@prueba');
    //////////////////////////* Logistica contratos  fin*////////////////////////////////

    /* resolucion de contratos refaccion *////////////////////////////////////////////////////////////
    Route::group(['middleware'=>'isFuncionalidad:refaccion'],function(){
        Route::get('/contrato/refaccion',array(
            'as'=>'Index',
            'uses'=>'Nutibara\Refaccion\RefaccionController@index'
        ));
        Route::get('/contrato/refaccion/anular/{id}','Nutibara\Refaccion\RefaccionController@anular');
        Route::get('/contrato/refaccion/get','Nutibara\Refaccion\RefaccionController@get');
        Route::get('/contrato/refaccion/seguimiento/{id}','Nutibara\Refaccion\RefaccionController@seguimiento');
        Route::get('/contrato/refaccion/refaccionar/{id_tienda}/{id}/{action}','Nutibara\Refaccion\RefaccionController@refaccionar');
        Route::get('/contrato/refaccion/getItemOrden/{id_tienda}/{id}','Nutibara\Refaccion\RefaccionController@getItemOrden');
        Route::post('/contrato/refaccion/guardar','Nutibara\Refaccion\RefaccionController@guardar');
        Route::post('/contrato/refaccion/create','Nutibara\Refaccion\RefaccionController@procesar');
        Route::post('/contrato/refaccion/validarItem','Nutibara\Refaccion\RefaccionController@validarItem');
        Route::post('/contrato/refaccion/quitarItems','Nutibara\Refaccion\RefaccionController@quitarItems');
        Route::post('/contrato/refaccion/generatepdf','Nutibara\Refaccion\RefaccionController@generateReportePDF');
        Route::post('/contrato/refaccion/anular','Nutibara\Refaccion\RefaccionController@AnularOrden');
        
        Route::get('/contratos/resolucionar/excelrefaccion/{idorden}/{idtienda}/{process}','Nutibara\Refaccion\RefaccionController@generateExcel');
        Route::get('/contratos/resolucionar/excelstikers/{idorden}/{idtienda}/{process}','Nutibara\Vitrina\VitrinaController@generateExcel');


        Route::get('/contrato/prerefaccion',array(
            'as'=>'Index',
            'uses'=>'Nutibara\Prerefaccion\PrerefaccionController@index'
        ));
        Route::get('/contrato/prerefaccion/anular/{id}','Nutibara\Prerefaccion\PrerefaccionController@anular');
        Route::get('/contrato/prerefaccion/get','Nutibara\Prerefaccion\PrerefaccionController@get');
        Route::get('/contrato/prerefaccion/seguimiento/{id}','Nutibara\Prerefaccion\PrerefaccionController@seguimiento');
        Route::get('/contrato/prerefaccion/prerefaccionar/{id_tienda}/{id}/{action}','Nutibara\Prerefaccion\PrerefaccionController@prerefaccionar');
        Route::get('/contrato/prerefaccion/getItemOrden/{id_tienda}/{id}','Nutibara\Prerefaccion\PrerefaccionController@getItemOrden');
        Route::post('/contrato/prerefaccion/create','Nutibara\Prerefaccion\PrerefaccionController@procesar');
        Route::post('/contrato/prerefaccion/validarItem','Nutibara\Prerefaccion\PrerefaccionController@validarItem');
        Route::post('/contrato/prerefaccion/quitarItems','Nutibara\Prerefaccion\PrerefaccionController@quitarItems');
        Route::post('/contrato/prerefaccion/generatepdf','Nutibara\Prerefaccion\PrerefaccionController@generateReportePDF');
        Route::get('/contrato/prerefaccion/excelprerefaccion/{id_orden}/{id_tienda}/{process}','Nutibara\Prerefaccion\PrerefaccionController@generateExcel');
        Route::post('contrato/prerefaccion/pdfcertificadomineria','Nutibara\Prerefaccion\PrerefaccionController@generateReporteMineriaPDF');
        Route::post('/contrato/prerefaccion/guardar','Nutibara\Prerefaccion\PrerefaccionController@guardarTemporal');
        Route::post('/contrato/prerefaccion/anular','Nutibara\Prerefaccion\PrerefaccionController@AnularOrden');
        
    });

     /* resolucion de contratos Maquila Nacional *////////////////////////////////////////////////////////////
     Route::group(['middleware'=>'isFuncionalidad:maquilanacional'],function(){
        Route::get('/contrato/maquilanacional',array(
            'as'=>'Index',
            'uses'=>'Nutibara\MaquilaNacional\MaquilaNacionalController@index'
        ));        
        Route::get('/contrato/maquilanacional/anular/{id}','Nutibara\MaquilaNacional\MaquilaNacionalController@anular');
        Route::get('/contrato/maquilanacional/get','Nutibara\MaquilaNacional\MaquilaNacionalController@get');
        Route::get('/contrato/maquilanacional/seguimiento/{id}','Nutibara\MaquilaNacional\MaquilaNacionalController@seguimiento');
        Route::get('/contrato/maquilanacional/maquilanacionalar/{id_tienda}/{id}/{action}','Nutibara\MaquilaNacional\MaquilaNacionalController@maquilanacionalar');
        Route::get('/contrato/maquilanacional/getItemOrden/{id_tienda}/{id}','Nutibara\MaquilaNacional\MaquilaNacionalController@getItemOrden');
        Route::post('/contrato/maquilanacional/guardar','Nutibara\MaquilaNacional\MaquilaNacionalController@guardar');
        Route::post('/contrato/maquilanacional/create','Nutibara\MaquilaNacional\MaquilaNacionalController@procesar');
        Route::post('/contrato/maquilanacional/validarItem','Nutibara\MaquilaNacional\MaquilaNacionalController@validarItem');
        Route::post('/contrato/maquilanacional/quitarItems','Nutibara\MaquilaNacional\MaquilaNacionalController@quitarItems');
        Route::post('/contrato/maquilanacional/generatepdf','Nutibara\MaquilaNacional\MaquilaNacionalController@generateReportePDF');
        Route::post('/contrato/maquilanacional/anular','Nutibara\MaquilaNacional\MaquilaNacionalController@AnularOrden');
        // Rutas para la transformación
        Route::get('/contrato/maquilanacional/transformacionglobal/{id_tienda}/{id_orden}','Nutibara\MaquilaNacional\MaquilaNacionalController@transformacionglobal');
        Route::post('/contrato/maquilanacional/transformacionglobal/procesar','Nutibara\MaquilaNacional\MaquilaNacionalController@transformacionglobalProcesar');
        
        Route::get('/contratos/resolucionar/excelmaquilanacional/{idorden}/{idtienda}/{process}','Nutibara\Refaccion\RefaccionController@generateExcel');
        
        
        Route::get('/contrato/maquila',array(
            'as'=>'Index',
            'uses'=>'Nutibara\Maquila\MaquilaController@index'
        ));
        Route::get('/contrato/maquila/anular/{id}','Nutibara\Maquila\MaquilaController@anular');
        Route::get('/contrato/maquila/get','Nutibara\Maquila\MaquilaController@get');
        Route::get('/contrato/maquila/seguimiento/{id}','Nutibara\Maquila\MaquilaController@seguimiento');
        Route::get('/contrato/maquila/maquilaar/{id_tienda}/{id}/{action}','Nutibara\Maquila\MaquilaController@maquilaar');
        Route::get('/contrato/maquila/getItemOrden/{id_tienda}/{id}','Nutibara\Maquila\MaquilaController@getItemOrden');
        Route::post('/contrato/maquila/guardar','Nutibara\Maquila\MaquilaController@guardar');
        Route::post('/contrato/maquila/create','Nutibara\Maquila\MaquilaController@procesar');
        Route::post('/contrato/maquila/validarItem','Nutibara\Maquila\MaquilaController@validarItem');
        Route::post('/contrato/maquila/quitarItems','Nutibara\Maquila\MaquilaController@quitarItems');
        Route::post('/contrato/maquila/generatepdf','Nutibara\Maquila\MaquilaController@generateReportePDF');
        
        Route::get('/contratos/resolucionar/excelmaquila/{idorden}/{idtienda}/{process}','Nutibara\Maquila\MaquilaController@generateExcel');
    });

     /* resolucion de contratos Maquila Importada *////////////////////////////////////////////////////////////
     Route::group(['middleware'=>'isFuncionalidad:maquilaimportada'],function(){
        Route::get('/contrato/maquilaimportada','Nutibara\MaquilaImportada\MaquilaImportadaController@index');
        Route::post('/contrato/maquilaimportada/getproveedorbyid','Nutibara\MaquilaImportada\MaquilaImportadaController@GetProveedorById');
        Route::post('/contrato/maquilaimportada/procesar','Nutibara\MaquilaImportada\MaquilaImportadaController@Procesar');
        Route::get('/contrato/maquilaimportada/get','Nutibara\MaquilaImportada\MaquilaImportadaController@Get');
        Route::get('/contrato/maquilaimportada/procesar/{id_tienda}/{ids_orden}','Nutibara\MaquilaImportada\MaquilaImportadaController@Create'); 
        Route::get('/contrato/maquilaimportada/getItemOrden/{id_tienda}/{id}','Nutibara\MaquilaImportada\MaquilaImportadaController@getItemOrden');        
    });

     /* resolucion de contratos vitrina *////////////////////////////////////////////////////////////
     Route::group(['middleware'=>'isFuncionalidad:vitrina'],function(){
        Route::get('/contrato/vitrina','Nutibara\Vitrina\VitrinaController@index');
        Route::post('/contrato/vitrina/getproveedorbyid','Nutibara\Vitrina\VitrinaController@GetProveedorById');
        Route::post('/contrato/vitrina/procesar','Nutibara\Vitrina\VitrinaController@Procesar');
        Route::get('/contrato/vitrina/get','Nutibara\Vitrina\VitrinaController@Get');
        Route::get('/contrato/vitrina/procesar/{id_tienda}/{ids_orden}','Nutibara\Vitrina\VitrinaController@Create'); 
        Route::get('/contrato/vitrina/procesar/{id_tienda}/{ids_orden}/{ver}','Nutibara\Vitrina\VitrinaController@Create'); 
        Route::get('/contrato/vitrina/getItemOrden/{id_tienda}/{id}','Nutibara\Vitrina\VitrinaController@getItemOrden');
        Route::get('/contrato/vitrina/solicitud/{id}/{id_tienda}/{idRemitente}', 'Nutibara\Vitrina\VitrinaController@Create');
        Route::get('/contrato/vitrina/solicitud/procesar', 'Nutibara\Vitrina\VitrinaController@SolicitarProcesarVitrina');
        Route::get('/contrato/vitrina/solicitud/procesarJZ', 'Nutibara\Vitrina\VitrinaController@SolicitarProcesarVitrinaJZ');
        Route::get('/contrato/vitrina/guardar', 'Nutibara\Vitrina\VitrinaController@guardarVitrina');
        Route::get('/contrato/vitrina/rechazar', 'Nutibara\Vitrina\VitrinaController@rechazarVitrina');
    });

    Route::get('/contrato/item/reclasificar/get','Nutibara\Vitrina\VitrinaController@reclasificarItemGet');
    Route::post('/contrato/item/reclasificar/post','Nutibara\Vitrina\VitrinaController@reclasificarItemPost');

    /* resolucion de contratos vitrina *////////////////////////////////////////////////////////////
    Route::group(['middleware'=>'isFuncionalidad:joyaespecial'],function(){
        Route::get('/contrato/joyaespecial','Nutibara\JoyaEspecial\JoyaEspecialController@index');
        Route::post('/contrato/joyaespecial/procesar','Nutibara\JoyaEspecial\JoyaEspecialController@Procesar');
        Route::get('/contrato/joyaespecial/get','Nutibara\JoyaEspecial\JoyaEspecialController@Get');
        Route::get('/contrato/joyaespecial/procesar/{id_tienda}/{ids_orden}','Nutibara\JoyaEspecial\JoyaEspecialController@Create'); 
        Route::get('/contrato/joyaespecial/getItemOrden/{id_tienda}/{id}','Nutibara\JoyaEspecial\JoyaEspecialController@getItemOrden');        
    });

    /* resolucion de contratos fundicion *////////////////////////////////////////////////////////////
    Route::group(['middleware'=>'isFuncionalidad:fundicion'],function(){
        Route::get('/contrato/fundicion',array(
            'as'=>'Index',
            'uses'=>'Nutibara\Fundicion\FundicionController@index'
        ));
        Route::get('/contrato/fundicion/anular/{id}','Nutibara\Fundicion\FundicionController@anular');
        Route::get('/contrato/fundicion/get','Nutibara\Fundicion\FundicionController@get');
        Route::get('/contrato/fundicion/seguimiento/{id}','Nutibara\Fundicion\FundicionController@seguimiento');
        Route::get('/contrato/fundicion/fundir/{id_tienda}/{id}/{action}','Nutibara\Fundicion\FundicionController@fundir');
        Route::get('/contrato/fundicion/fundir/{id_tienda}/{id}/{action}/{ver}','Nutibara\Fundicion\FundicionController@fundir');
        Route::get('/contrato/fundicion/getItemOrden/{id_tienda}/{id}','Nutibara\Fundicion\FundicionController@getItemOrden');
        Route::post('/contrato/fundicion/create','Nutibara\Fundicion\FundicionController@procesar');
        Route::post('/contrato/fundicion/validarItem','Nutibara\Fundicion\FundicionController@validarItem');
        Route::post('/contrato/fundicion/quitarItems','Nutibara\Fundicion\FundicionController@quitarItems');
        Route::post('/contrato/fundicion/guardar','Nutibara\Fundicion\FundicionController@guardar');
        Route::post('/contrato/fundicion/generatepdf','Nutibara\Fundicion\FundicionController@generateReportePDF');
        Route::post('/contratos/fundicion/pdfcertificadomineria', 'Nutibara\Fundicion\FundicionController@certificadoMineriaPDF');
        Route::get('/contratos/fundicion/excelfundicion/{idorden}/{idtienda}/{process}','Nutibara\Fundicion\FundicionController@generateExcel');
        Route::post('/contrato/fundicion/anular','Nutibara\Fundicion\FundicionController@AnularOrden');


    });

     /* Resolución de Contratos */
    Route::group(['middleware'=>'isFuncionalidad:resolucionContrato'],function(){
        /* Resolucionar Contratos */
        Route::get('contratos/resolucionar', 'Nutibara\Contratos\ResolucionarController@index');
        Route::get('contratos/resolucionar/hojatrabajo/{id_tienda}/{id_contratos}', 'Nutibara\Contratos\ResolucionarController@hojaTrabajo');
        Route::post('contratos/resolucionar/hojatrabajo/procesar', 'Nutibara\Contratos\ResolucionarController@procesarHojaTrabajo');
        Route::post('contratos/resolucionar/hojatrabajo/guardar', 'Nutibara\Contratos\ResolucionarController@guardarHojaTrabajo');
        Route::post('contratos/resolucionar/hojatrabajo/actualizar', 'Nutibara\Contratos\ResolucionarController@actualizarHojaTrabajo');
        Route::post('contratos/resolucionar/hojatrabajo/agregarcontrato', 'Nutibara\Contratos\ResolucionarController@agregarContrato');
        Route::post('contratos/resolucionar/hojatrabajo/quitarcontrato', 'Nutibara\Contratos\ResolucionarController@quitarContrato');
        Route::get('contratos/resolucionar/get', 'Nutibara\Contratos\ResolucionarController@getContratos');
        Route::get('contratos/resolucionar/pdfordenresolucion', 'Nutibara\Contratos\ResolucionarController@pdfOrdenResolucion');
        Route::post('contratos/resolucionar/pdfcertificadomineria', 'Nutibara\Refaccion\RefaccionController@certificadoMineriaPDF');
        Route::post('contratos/resolucionar/pdfreporte', 'Nutibara\Contratos\ResolucionarController@pdfReporteResolucion');

        Route::post('/contratos/resolucionar/pdfperfeccionamiento', 'Nutibara\Contratos\ResolucionarController@pdfPerfeccionamiento');
        Route::get('/contratos/resolucionar/excelperfeccionamiento/{idorden}/{idtienda}', 'Nutibara\Resolucion\ResolucionController@generateExcel');

        Route::get('/contrato/resolucion',array(
            'as'=>'Index',
            'uses'=>'Nutibara\Resolucion\ResolucionController@index'
        ));
        Route::get('/contrato/resolucion/anular/{id}','Nutibara\Resolucion\ResolucionController@anular');
        Route::get('/contrato/resolucion/get','Nutibara\Resolucion\ResolucionController@get');
        Route::get('/contrato/resolucion/seguimiento/{id}','Nutibara\Resolucion\ResolucionController@seguimiento');
        Route::get('/contrato/resolucion/resolucionar/{id_tienda}/{id}','Nutibara\Resolucion\ResolucionController@resolucionar');
        Route::get('/contrato/resolucion/getItemOrden/{id_tienda}/{id}','Nutibara\Resolucion\ResolucionController@getItemOrden');
        Route::post('/contrato/resolucion/create','Nutibara\Resolucion\ResolucionController@procesar');
        Route::post('/contrato/resolucion/validarItem','Nutibara\Resolucion\ResolucionController@validarItem');
        Route::post('/contrato/resolucion/quitarItems','Nutibara\Resolucion\ResolucionController@quitarItems');
        Route::get('/contratos/resolucionar/getitemscontrato/{codigo_tienda}/{id_tienda}','Nutibara\Resolucion\ResolucionController@getItemsContrato');
    });


    // reporte de rotación de inventario
    Route::group(['middleware'=>'isFuncionalidad:ReporteRotacion'],function(){
        Route::get('ReporteRotacion','Nutibara\ReporteRotacion\ReporteRotacionController@index');
        Route::get('ReporteRotacion/get','Nutibara\ReporteRotacion\ReporteRotacionController@get');
    });

    // pedidos
    Route::group(['middleware'=>'isFuncionalidad:pedidos'],function(){
        Route::get('pedidos/get','Nutibara\Pedidos\PedidosController@get');
        Route::get('pedidos','Nutibara\Pedidos\PedidosController@Index');
        Route::get('pedidos/ver/{id_pedido}/{id_tienda}','Nutibara\Pedidos\PedidosController@ver');
        Route::get('pedidos/update','Nutibara\Pedidos\PedidosController@update');
        Route::get('pedidos/create/{referencia}','Nutibara\Pedidos\PedidosController@create');
        Route::post('pedidos/create','Nutibara\Pedidos\PedidosController@createPost');
        Route::post('pedidos/updatePost','Nutibara\Pedidos\PedidosController@updatePost');
    });
    Route::post('pedidos/updatePedidoAjax','Nutibara\Pedidos\PedidosController@updatePedidoAjax');
    Route::post('pedidos/validarPedido','Nutibara\Pedidos\PedidosController@validarPedido');
    Route::post('pedidos/aprobar','Nutibara\Pedidos\PedidosController@aprobar');
    Route::post('pedidos/rechazar','Nutibara\Pedidos\PedidosController@rechazar');

       //ventas
    //    Route::group(['middleware'=>'isFuncionalidad:venta'],function(){
           Route::get('ventas/get','Nutibara\Venta\ventaController@get');
           Route::get('ventas','Nutibara\Venta\ventaController@Index');
           Route::get('ventas/createVentaDirecta','Nutibara\Venta\ventaController@createVentaDirecta');
           Route::get('ventas/createVentaPlan/{id_tienda}/{id_plan}/{id_tienda_pr}','Nutibara\Venta\ventaController@createVentaPlan');
           Route::post('ventas/createDirecta','Nutibara\Venta\ventaController@createDirecta');
           Route::post('venta/facturarPlan','Nutibara\Venta\ventaController@facturarPlan');
           Route::get('/venta/pdfactura', 'Nutibara\Venta\ventaController@pdfactura');
    // });
    
    Route::get('ventas/getCliente','Nutibara\Venta\ventaController@getCliente');
    Route::get('ventas/getInventarioByName','Nutibara\Venta\ventaController@getInventarioByName');
    Route::get('ventas/getPrecioBolsa','Nutibara\Venta\ventaController@getPrecioBolsa');

    //compras
    Route::group(['middleware' => 'isFuncionalidad:compra'],function(){
        Route::get('compras','Nutibara\Compra\compraController@Index');
        Route::get('compras/get','Nutibara\Compra\compraController@get');
        Route::get('compras/createCompra','Nutibara\Compra\compraController@createCompraDirecta');
        Route::get('compras/devolucion/{id_tienda}/{lote}','Nutibara\Compra\compraController@devolucion');
        Route::post('compras/createDirecta','Nutibara\Compra\compraController@createDirecta');
        Route::post('compras/devolverCompra','Nutibara\Compra\compraController@devolverCompra');
    });
    
    Route::get('compras/getProveedor','Nutibara\Compra\compraController@getProveedor');
    Route::get('compras/getInventarioByName','Nutibara\Compra\compraController@getInventarioByName');    

    ////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////Módulo///////////////////////////////////////////
    /////////////////////////////Administración General///////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    
    /* Parámetros Generales */
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.general'],function(){        
        Route::get('/parametros', 'Nutibara\Parametros\ParametrosController@Index')->name('parametros.index');        
        Route::get('/parametros/create', 'Nutibara\Parametros\ParametrosController@Create');
        Route::post('/parametros/create', 'Nutibara\Parametros\ParametrosController@CreatePost');
        Route::get('/parametros/update/{id}', 'Nutibara\Parametros\ParametrosController@Update');
        Route::post('/parametros/update', 'Nutibara\Parametros\ParametrosController@UpdatePost');
        Route::post('/parametros/delete', 'Nutibara\Parametros\ParametrosController@Delete');
        Route::post('/parametros/active', 'Nutibara\Parametros\ParametrosController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/parametros/getselectpais', 'Nutibara\Parametros\ParametrosController@getSelectPais');  
    Route::get('/parametros/getSelectList', 'Nutibara\Parametros\ParametrosController@getSelectList');
    Route::get('/parametros/getselectlistlenguaje', 'Nutibara\Parametros\ParametrosController@getSelectListLenguaje');
    Route::get('/parametros/getselectlistmoneda', 'Nutibara\Parametros\ParametrosController@getSelectListMoneda');
    Route::get('/parametros/getselectlistmedidapeso', 'Nutibara\Parametros\ParametrosController@getSelectListMedidaPeso');
    Route::get('/parametros/get', 'Nutibara\Parametros\ParametrosController@get');
    Route::get('/parametros/validateExist', 'Nutibara\Parametros\ParametrosController@ValidateExist');
    Route::get('/parametros/getAbreviatura', 'Nutibara\Parametros\ParametrosController@getAbreviatura');
    Route::get('/parametros/getConfig', 'Nutibara\Parametros\ParametrosController@getConfig');
    /////////////////////Fin Consultas por Ajax/////////////////////////     

    /*Maestro Locaciones*/
    /* Paises */
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.locacion.pais'],function(){ 
        Route::get('/pais', 'Nutibara\Pais\PaisController@Index');  
        Route::get('/pais/create', 'Nutibara\Pais\PaisController@Create');
        Route::post('/pais/create', 'Nutibara\Pais\PaisController@CreatePost');
        Route::get('/pais/update/{id}', 'Nutibara\Pais\PaisController@Update');
        Route::post('/pais/update', 'Nutibara\Pais\PaisController@UpdatePost');
        Route::post('/pais/delete', 'Nutibara\Pais\PaisController@Delete');
        Route::post('/pais/active', 'Nutibara\Pais\PaisController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/pais/get', 'Nutibara\Pais\PaisController@get');
    Route::get('/pais/getpais', 'Nutibara\Pais\PaisController@getPais');
    Route::get('/pais/getSelectList', 'Nutibara\Pais\PaisController@getSelectList');
    Route::get('/pais/getSelectListPais', 'Nutibara\Pais\PaisController@getSelectListPais');
    Route::get('/pais/getSelectListPaisByName', 'Nutibara\Pais\PaisController@getSelectListPaisByName');
    Route::get('/pais/getinputindicativo', 'Nutibara\Pais\PaisController@getInputIndicativo');
    Route::get('/pais/getSelectListPaisSociedad', 'Nutibara\Pais\PaisController@getSelectListPaisSociedad');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /* Departamentos */
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.locacion.dpto'],function(){
        Route::get('/departamento', 'Nutibara\Departamento\DepartamentoController@Index');
        Route::get('/departamento/create', 'Nutibara\Departamento\DepartamentoController@Create');
        Route::post('/departamento/create', 'Nutibara\Departamento\DepartamentoController@CreatePost');
        Route::get('/departamento/update/{id}', 'Nutibara\Departamento\DepartamentoController@Update');
        Route::post('/departamento/update', 'Nutibara\Departamento\DepartamentoController@UpdatePost');
        Route::post('/departamento/delete', 'Nutibara\Departamento\DepartamentoController@Delete');
        Route::post('/departamento/active', 'Nutibara\Departamento\DepartamentoController@Active');  
    });  
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/departamento/get', 'Nutibara\Departamento\DepartamentoController@get');
    Route::get('/departamento/getdepartamentobypais', 'Nutibara\Departamento\DepartamentoController@getDepartamentoByPais');
    Route::get('/departamento/getSelectList', 'Nutibara\Departamento\DepartamentoController@getSelectList');
    Route::get('/departamento/getSelectListDepartamento', 'Nutibara\Departamento\DepartamentoController@getSelectListDepartamento');
    Route::get('/departamento/getdepartamentobypais/{id}', 'Nutibara\Departamento\DepartamentoController@getDepartamentoByPais');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /* Ciudades */    
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.locacion.ciudad'],function(){ 
        Route::get('/ciudad', 'Nutibara\Ciudad\CiudadController@Index');
        Route::get('/ciudad/create', 'Nutibara\Ciudad\CiudadController@Create');
        Route::post('/ciudad/create', 'Nutibara\Ciudad\CiudadController@CreatePost');
        Route::get('/ciudad/update/{id}', 'Nutibara\Ciudad\CiudadController@Update');
        Route::post('/ciudad/update', 'Nutibara\Ciudad\CiudadController@UpdatePost');
        Route::post('/ciudad/delete', 'Nutibara\Ciudad\CiudadController@Delete');      
        Route::post('/ciudad/active', 'Nutibara\Ciudad\CiudadController@Active');
    }); 
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/ciudad/getciudadbydepartamento/{id}', 'Nutibara\Ciudad\CiudadController@getCiudadByDepartamento');
    Route::get('/ciudad/get', 'Nutibara\Ciudad\CiudadController@get');
    Route::get('/ciudad/getciudadbydepartamento', 'Nutibara\Ciudad\CiudadController@getCiudadByDepartamento');
    Route::get('/ciudad/getciudadbypais', 'Nutibara\Ciudad\CiudadController@getCiudadByPais');
    Route::get('/ciudad/getSelectList', 'Nutibara\Ciudad\CiudadController@getSelectList');
    Route::get('/ciudad/getSelectListCiudadZona', 'Nutibara\Ciudad\CiudadController@getSelectListCiudadZona');
    Route::get('/ciudad/getSelectListCiudadSociedad', 'Nutibara\Ciudad\CiudadController@getSelectListCiudadSociedad');
    Route::get('/ciudad/getItemZonaCiudad', 'Nutibara\Ciudad\CiudadController@getItemZonaCiudad');  
    Route::get('/ciudad/getinputindicativo', 'Nutibara\Ciudad\CiudadController@getInputIndicativo');
    Route::get('/ciudad/getinputindicativo2', 'Nutibara\Ciudad\CiudadController@getInputIndicativo2');
    Route::get('/ciudad/getCiudadbyName/{nombre}','Nutibara\Ciudad\CiudadController@getSelectListCiudadbyNombre');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /*Maestro de Estructura de Negocio*/
    /* Franquicias -> Nombre Comercial*/
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.sociedad.nombreCom'],function(){ 
        Route::get('/franquicia', 'Nutibara\Franquicia\FranquiciaController@Index');       
        Route::get('/franquicia/create', 'Nutibara\Franquicia\FranquiciaController@Create');
        Route::post('/franquicia/create', 'Nutibara\Franquicia\FranquiciaController@CreatePost');
        Route::get('/franquicia/update/{id}', 'Nutibara\Franquicia\FranquiciaController@Update');
        Route::post('/franquicia/update', 'Nutibara\Franquicia\FranquiciaController@UpdatePost');
        Route::post('/franquicia/delete', 'Nutibara\Franquicia\FranquiciaController@Delete');     
        Route::get('/franquicia/sociedadesdefranquicia', 'Nutibara\Franquicia\FranquiciaController@SociedadesDeFranquicia');
        Route::post('/franquicia/active', 'Nutibara\Franquicia\FranquiciaController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/franquicia/get', 'Nutibara\Franquicia\FranquiciaController@get');
    Route::get('/franquicia/getSelectList', 'Nutibara\Franquicia\FranquiciaController@getSelectList');
    Route::get('/franquicia/getSelectListFranquiciaPais', 'Nutibara\Franquicia\FranquiciaController@getSelectListFranquiciaPais');   
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Sociedades */
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.sociedad.sociedad'],function(){ 
        Route::get('/sociedad', 'Nutibara\Sociedad\SociedadController@Index');        
        Route::get('/sociedad/create', 'Nutibara\Sociedad\SociedadController@Create');
        Route::post('/sociedad/create', 'Nutibara\Sociedad\SociedadController@CreatePost');
        Route::get('/sociedad/update/{id}', 'Nutibara\Sociedad\SociedadController@Update');
        Route::post('/sociedad/update', 'Nutibara\Sociedad\SociedadController@UpdatePost');
        Route::post('/sociedad/delete', 'Nutibara\Sociedad\SociedadController@Delete');    
        Route::post('/sociedad/active', 'Nutibara\Sociedad\SociedadController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/sociedad/get', 'Nutibara\Sociedad\SociedadController@get');
    Route::get('/sociedad/getSelectList', 'Nutibara\Sociedad\SociedadController@getSelectList');
    Route::get('/sociedad/getSelectListRegimen', 'Nutibara\Sociedad\SociedadController@getSelectListRegimen');
    Route::get('/sociedad/getSelectListSociedadesPais', 'Nutibara\Sociedad\SociedadController@getSelectListSociedadesPais');
    Route::get('/sociedad/getSelectListFranquiciaSociedad', 'Nutibara\Sociedad\SociedadController@getSelectListFranquiciaSociedad');  
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Zonas */
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.sociedad.zona'],function(){ 
        Route::get('/zona', 'Nutibara\Zona\ZonaController@Index');
        Route::get('/zona/create', 'Nutibara\Zona\ZonaController@Create');
        Route::post('/zona/create', 'Nutibara\Zona\ZonaController@CreatePost');
        Route::get('/zona/update/{id}', 'Nutibara\Zona\ZonaController@Update');
        Route::post('/zona/update', 'Nutibara\Zona\ZonaController@UpdatePost');
        Route::post('/zona/delete', 'Nutibara\Zona\ZonaController@Delete');         
        Route::post('/zona/active', 'Nutibara\Zona\ZonaController@Active');
        Route::get('/zona/ciudadesseleccionadas', 'Nutibara\Zona\ZonaController@CiudadesSeleccionadas');  
    }); 
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/zona/get', 'Nutibara\Zona\ZonaController@get');
    Route::get('/zona/getzonabypais', 'Nutibara\Zona\ZonaController@getZonaByPais');
    Route::get('/zona/getSelectList', 'Nutibara\Zona\ZonaController@getSelectList');
    Route::get('/zona/getSelectListZonaTienda', 'Nutibara\Zona\ZonaController@getSelectListZonaTienda');
    Route::get('/zona/getSelectListZonaPais', 'Nutibara\Zona\ZonaController@getSelectListZonaPais'); 
    Route::get('/zona/getSelectListZonaPais/{id}', 'Nutibara\Zona\ZonaController@getSelectListZonaPais'); 
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Tiendas */
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.sociedad.tienda'],function(){ 
        Route::get('/tienda', 'Nutibara\Tienda\TiendaController@Index');        
        Route::get('/tienda/create', 'Nutibara\Tienda\TiendaController@Create');
        Route::post('/tienda/create', 'Nutibara\Tienda\TiendaController@CreatePost');
        Route::get('/tienda/update/{id}', 'Nutibara\Tienda\TiendaController@Update');
        Route::post('/tienda/update', 'Nutibara\Tienda\TiendaController@UpdatePost');
        Route::post('/tienda/delete', 'Nutibara\Tienda\TiendaController@Delete');        
        Route::post('/tienda/active', 'Nutibara\Tienda\TiendaController@Active');
        Route::post('/tienda/validatemarket', 'Nutibara\Tienda\TiendaController@ValidateMarket');
    }); 
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/tienda/get', 'Nutibara\Tienda\TiendaController@get');
    Route::get('/tienda/gettiendabyzona', 'Nutibara\Tienda\TiendaController@getTiendaByZona');
    Route::get('/tienda/gettiendabyzona2', 'Nutibara\Tienda\TiendaController@getTiendaByZona2');
    Route::get('/tienda/getSelectList', 'Nutibara\Tienda\TiendaController@getSelectList');		
    Route::get('/tienda/getTiendaByCiudad/{id}', 'Nutibara\Tienda\TiendaController@getTiendaByCiudad');
    Route::get('/tienda/gettiendabyciudad', 'Nutibara\Tienda\TiendaController@getTiendaByCiudad');
    Route::get('/tienda/getTiendaByDepartamento/{id}', 'Nutibara\Tienda\TiendaController@getTiendaByDepartamento');
    Route::get('/tienda/getTiendaByPais/{id}', 'Nutibara\Tienda\TiendaController@getTiendaByPais');
    Route::get('/tienda/getTiendaCiudad', 'Nutibara\Tienda\TiendaController@getTiendaCiudad');
    Route::get('/tienda/gettiendabysociedad', 'Nutibara\Tienda\TiendaController@getTiendaBySociedad');
    Route::get('/tienda/getTiendaisnt', 'Nutibara\Tienda\TiendaController@getTiendaisnt');
    Route::get('/tienda/selecttiendabysociedad', 'Nutibara\Tienda\TiendaController@selectTiendaBySociedad');
    Route::get('/tienda/getmontomax', 'Nutibara\Tienda\TiendaController@getMontoMax');
    /////////////////////Fin Consultas por Ajax/////////////////////////  
    
    /* Secuencia De Tiendas */
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.sociedad.secueTienda'],function(){ 
        Route::get('/secuenciatienda', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@Index');        
        Route::get('/secuenciatienda/create/{id}', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@Create');
        Route::post('/secuenciatienda/create', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@CreatePost');
        Route::get('/secuenciatienda/update/{id}', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@Update');
        Route::post('/secuenciatienda/update', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@UpdatePost');
        Route::post('/secuenciatienda/delete', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@Delete');        
        Route::post('/secuenciatienda/active', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@Active');
        Route::post('/secuenciatienda/createSecInv', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@createSecInv');
    });  
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/secuenciatienda/get', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@get');
    Route::get('/secuenciatienda/getSelectList', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@getSelectList');
    Route::get('/secuenciatienda/getListSecInv', 'Nutibara\SecuenciaTienda\SecuenciaTiendaController@getListSecInv');
    /////////////////////Fin Consultas por Ajax/////////////////////////  
 
    /*Modificar clausulas */
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.modificarClausulas'],function(){
        Route::get('/modificarClausulas', 'Nutibara\ModificarClausulas\modificarClausulasController@Index');
        Route::get('/modificarClausulas/get', 'Nutibara\ModificarClausulas\modificarClausulasController@get');
        Route::get('/modificarClausulas/create', 'Nutibara\ModificarClausulas\modificarClausulasController@create');
        Route::post('/modificarClausulas/create', 'Nutibara\ModificarClausulas\modificarClausulasController@createPost');
        Route::get('/modificarClausulas/view/{id}', 'Nutibara\ModificarClausulas\modificarClausulasController@view');
        Route::get('/modificarClausulas/update/{id}', 'Nutibara\ModificarClausulas\modificarClausulasController@update');
        Route::post('/modificarClausulas/update', 'Nutibara\ModificarClausulas\modificarClausulasController@updatePost');
        Route::get('/modificarClausulas/findClausula','Nutibara\ModificarClausulas\modificarClausulasController@FindClausula');
    });
    /*Maestro de Estados*/
    /* Estados */    
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.estado.estado'],function(){  
        Route::get('/gestionestado/estado', 'Nutibara\GestionEstado\Estado\EstadoController@Index');        
        Route::get('/gestionestado/estado/create', 'Nutibara\GestionEstado\Estado\EstadoController@Create');
        Route::post('/gestionestado/estado/create', 'Nutibara\GestionEstado\Estado\EstadoController@CreatePost');
        Route::get('/gestionestado/estado/update/{id}', 'Nutibara\GestionEstado\Estado\EstadoController@Update');
        Route::post('/gestionestado/estado/update', 'Nutibara\GestionEstado\Estado\EstadoController@UpdatePost');
        Route::post('/gestionestado/estado/delete', 'Nutibara\GestionEstado\Estado\EstadoController@Delete');        
        Route::get('/gestionestado/estado/motivosestado', 'Nutibara\GestionEstado\Estado\EstadoController@MotivosDeEstado');
        Route::post('/gestionestado/estado/actualizarmotivosestado', 'Nutibara\GestionEstado\Estado\EstadoController@ActualizarMotivosEstado');
        Route::post('/gestionestado/estado/active', 'Nutibara\GestionEstado\Estado\EstadoController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////  
    Route::get('/gestionestado/estado/getEstadoByTema/{id}', 'Nutibara\GestionEstado\Estado\EstadoController@getEstadosByTema');
    Route::get('/gestionestado/estado/get', 'Nutibara\GestionEstado\Estado\EstadoController@get');
    Route::get('/gestionestado/estado/getselectlist', 'Nutibara\GestionEstado\Estado\EstadoController@getSelectList');
    /////////////////////Fin Consultas por Ajax/////////////////////////

    /* Motivos  */
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.estado.motivo'],function(){  
        Route::get('/gestionestado/motivo', 'Nutibara\GestionEstado\Motivo\MotivoController@Index');        
        Route::get('/gestionestado/motivo/create', 'Nutibara\GestionEstado\Motivo\MotivoController@Create');
        Route::post('/gestionestado/motivo/create', 'Nutibara\GestionEstado\Motivo\MotivoController@CreatePost');
        Route::get('/gestionestado/motivo/update/{id}', 'Nutibara\GestionEstado\Motivo\MotivoController@Update');
        Route::post('/gestionestado/motivo/update', 'Nutibara\GestionEstado\Motivo\MotivoController@UpdatePost');
        Route::post('/gestionestado/motivo/delete', 'Nutibara\GestionEstado\Motivo\MotivoController@Delete');        
        Route::post('/gestionestado/motivo/active', 'Nutibara\GestionEstado\Motivo\MotivoController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/gestionestado/motivo/getmotivobyestado/{id}', 'Nutibara\GestionEstado\Motivo\MotivoController@getMotivoByEstado');
    Route::get('/gestionestado/motivo/get', 'Nutibara\GestionEstado\Motivo\MotivoController@get');
    Route::get('/gestionestado/motivo/getselectlist', 'Nutibara\GestionEstado\Motivo\MotivoController@getSelectList');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /*Dias Festivos*/
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.diaFestivo'],function(){  
        Route::get('/diasfestivos', 'Nutibara\DiasFestivos\DiasFestivosController@Index')->name('diasfestivos.index');
        
        Route::get('/diasfestivos/create', 'Nutibara\DiasFestivos\DiasFestivosController@Create');
        Route::post('/diasfestivos/create', 'Nutibara\DiasFestivos\DiasFestivosController@CreatePost');
        Route::get('/diasfestivos/update/{id}', 'Nutibara\DiasFestivos\DiasFestivosController@Update');
        Route::post('/diasfestivos/update', 'Nutibara\DiasFestivos\DiasFestivosController@UpdatePost');
        Route::post('/diasfestivos/delete', 'Nutibara\DiasFestivos\DiasFestivosController@Delete');
        Route::post('/diasfestivos/active', 'Nutibara\DiasFestivos\DiasFestivosController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/diasfestivos/get', 'Nutibara\DiasFestivos\DiasFestivosController@get');
    Route::get('/diasfestivos/getSelectList', 'Nutibara\DiasFestivos\DiasFestivosController@getSelectList');
    Route::get('/diasfestivos/getselectlistlenguaje', 'Nutibara\DiasFestivos\DiasFestivosController@getSelectListLenguaje');
    Route::get('/diasfestivos/getselectlistmoneda', 'Nutibara\DiasFestivos\DiasFestivosController@getSelectListMoneda');
    Route::get('/diasfestivos/getselectlistmedidapeso', 'Nutibara\DiasFestivos\DiasFestivosController@getSelectListMedidaPeso');
    /////////////////////Fin Consultas por Ajax///////////////////////// 


    ////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////Módulo///////////////////////////////////////////
    ///////////////////////////////Gestión de Clientes////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    
    /* Parámetros Generales */
    /* Tipo de Trabajo */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.tipoTrabajo'],function(){  
        Route::get('/clientes/tipo/trabajo', 'Nutibara\Clientes\TipoTrabajo\TipoTrabajoController@Index');        
        Route::get('/clientes/tipo/trabajo/create', 'Nutibara\Clientes\TipoTrabajo\TipoTrabajoController@Create');
        Route::post('/clientes/tipo/trabajo/create', 'Nutibara\Clientes\TipoTrabajo\TipoTrabajoController@CreatePost');
        Route::get('/clientes/tipo/trabajo/update/{id}', 'Nutibara\Clientes\TipoTrabajo\TipoTrabajoController@Update');
        Route::post('/clientes/tipo/trabajo/update', 'Nutibara\Clientes\TipoTrabajo\TipoTrabajoController@UpdatePost');
        Route::post('/clientes/tipo/trabajo/delete', 'Nutibara\Clientes\TipoTrabajo\TipoTrabajoController@Delete');        
        Route::post('/clientes/tipo/trabajo/active', 'Nutibara\Clientes\TipoTrabajo\TipoTrabajoController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
	Route::get('/clientes/tipo/trabajo/get', 'Nutibara\Clientes\TipoTrabajo\TipoTrabajoController@get');
	Route::get('/clientes/tipo/trabajo/getSelectList', 'Nutibara\Clientes\TipoTrabajo\TipoTrabajoController@getSelectList');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Área de Trabajo  */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.areaTrabajo'],function(){ 
        Route::get('/clientes/areatrabajo', 'Nutibara\Clientes\AreaTrabajo\AreaTrabajoController@Index');        
        Route::get('/clientes/areatrabajo/create/', 'Nutibara\Clientes\AreaTrabajo\AreaTrabajoController@Create');
        Route::post('/clientes/areatrabajo/create', 'Nutibara\Clientes\AreaTrabajo\AreaTrabajoController@CreatePost');
        Route::get('/clientes/areatrabajo/update/{id}', 'Nutibara\Clientes\AreaTrabajo\AreaTrabajoController@Update');
        Route::post('/clientes/areatrabajo/update', 'Nutibara\Clientes\AreaTrabajo\AreaTrabajoController@UpdatePost');
        Route::post('/clientes/areatrabajo/delete', 'Nutibara\Clientes\AreaTrabajo\AreaTrabajoController@Delete');        
        Route::post('/clientes/areatrabajo/active', 'Nutibara\Clientes\AreaTrabajo\AreaTrabajoController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
	Route::get('/clientes/areatrabajo/get', 'Nutibara\Clientes\AreaTrabajo\AreaTrabajoController@get');
	Route::get('/clientes/areatrabajo/getSelectList', 'Nutibara\Clientes\AreaTrabajo\AreaTrabajoController@getSelectList');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /* Tipo de Documento  */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.tipoDocumento'],function(){ 
        Route::get('/clientes/tipodocumento', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@Index');        
        Route::get('/clientes/tipodocumento/create/', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@Create');
        Route::post('/clientes/tipodocumento/create', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@CreatePost');
        Route::get('/clientes/tipodocumento/update/{id}', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@Update');
        Route::post('/clientes/tipodocumento/update', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@UpdatePost');
        Route::post('/clientes/tipodocumento/delete', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@Delete');        
        Route::post('/clientes/tipodocumento/active', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@Active');   
        /* Clientes/Tipo De Documento Dian */
        Route::get('/clientes/tipodocumentodian', 'Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDianController@Index');        
        Route::get('/clientes/tipodocumentodian/create/', 'Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDianController@Create');
        Route::post('/clientes/tipodocumentodian/create', 'Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDianController@CreatePost');
        Route::get('/clientes/tipodocumentodian/update/{id}', 'Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDianController@Update');
        Route::post('/clientes/tipodocumentodian/update', 'Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDianController@UpdatePost');
        Route::post('/clientes/tipodocumentodian/delete', 'Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDianController@Delete');        
        Route::post('/clientes/tipodocumentodian/active', 'Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDianController@Active');
    });  
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/tipodocumento/get', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@get');
	Route::get('/clientes/tipodocumento/getSelectList', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@getSelectList');
	Route::post('/clientes/tipodocumento/getAlfanumerico', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@getAlfanumerico');
    Route::get('/clientes/tipodocumento/getSelectList2', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@getSelectList2');
	Route::get('/clientes/tipodocumento/getTipoDocumentoProveedor', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@getTipoDocumentoProveedor');    
	// Clientes/Tipo De Documento Dian
	Route::get('/clientes/tipodocumentodian/get', 'Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDianController@get');
	Route::get('/clientes/tipodocumentodian/getSelectList', 'Nutibara\Clientes\TipoDocumentoDian\TipoDocumentoDianController@getSelectList');
	// Clientes/ Cargar Tipo Documento Dinamicamente	
    Route::get('/clientes/getTipoDoc', 'Nutibara\CargarSelectController@getTipoDoc'); 
    /////////////////////Fin Consultas por Ajax/////////////////////////   

     /* Profesiones  */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.profesion'],function(){ 
        Route::get('/clientes/profesion', 'Nutibara\Clientes\Profesion\ProfesionController@Index');        
        Route::get('/clientes/profesion/create/', 'Nutibara\Clientes\Profesion\ProfesionController@Create');
        Route::post('/clientes/profesion/create', 'Nutibara\Clientes\Profesion\ProfesionController@CreatePost');
        Route::get('/clientes/profesion/update/{id}', 'Nutibara\Clientes\Profesion\ProfesionController@Update');
        Route::post('/clientes/profesion/update', 'Nutibara\Clientes\Profesion\ProfesionController@UpdatePost');
        Route::post('/clientes/profesion/delete', 'Nutibara\Clientes\Profesion\ProfesionController@Delete');        
        Route::post('/clientes/profesion/active', 'Nutibara\Clientes\Profesion\ProfesionController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/profesion/get', 'Nutibara\Clientes\Profesion\ProfesionController@get');
	Route::get('/clientes/profesion/getSelectList', 'Nutibara\Clientes\Profesion\ProfesionController@getSelectList');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Calificaciones  */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.calificacion'],function(){ 
        Route::get('/calificacion', 'Nutibara\Calificacion\CalificacionController@Index');
        Route::get('/calificacion/create/', 'Nutibara\Calificacion\CalificacionController@Create');
        Route::post('/calificacion/create', 'Nutibara\Calificacion\CalificacionController@CreatePost');
        Route::get('/calificacion/update/{id}', 'Nutibara\Calificacion\CalificacionController@Update');
        Route::post('/calificacion/update', 'Nutibara\Calificacion\CalificacionController@UpdatePost');
        Route::post('/calificacion/delete', 'Nutibara\Calificacion\CalificacionController@Delete');        
        Route::post('/calificacion/active', 'Nutibara\Calificacion\CalificacionController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/calificacion/get', 'Nutibara\Calificacion\CalificacionController@get');
    Route::get('/calificacion/getcalificacion', 'Nutibara\Calificacion\CalificacionController@getCalificacion');
	Route::get('/calificacion/getSelectList', 'Nutibara\Calificacion\CalificacionController@getSelectList');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /* Pasa Tiempos */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.pasaTiempo'],function(){ 
        Route::get('/pasatiempo', 'Nutibara\Pasatiempo\PasatiempoController@Index');        
        Route::get('/pasatiempo/create', 'Nutibara\Pasatiempo\PasatiempoController@Create');
        Route::post('/pasatiempo/create', 'Nutibara\Pasatiempo\PasatiempoController@CreatePost');
        Route::get('/pasatiempo/update/{id}', 'Nutibara\Pasatiempo\PasatiempoController@Update');
        Route::post('/pasatiempo/update', 'Nutibara\Pasatiempo\PasatiempoController@UpdatePost');
        Route::post('/pasatiempo/delete', 'Nutibara\Pasatiempo\PasatiempoController@Delete');
        Route::post('/pasatiempo/active', 'Nutibara\Pasatiempo\PasatiempoController@Active'); 
    });  
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/pasatiempo/get', 'Nutibara\Pasatiempo\PasatiempoController@get');
	Route::get('/pasatiempo/getSelectList', 'Nutibara\Pasatiempo\PasatiempoController@getSelectList');
    Route::get('/pasatiempo/getSelectListPais', 'Nutibara\Pasatiempo\PasatiempoController@getSelectListPais');
    /////////////////////Fin Consultas por Ajax///////////////////////// 
  
    /* Confiabilidad  */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.confiabilidad'],function(){ 
        Route::get('/clientes/confiabilidad', 'Nutibara\Clientes\Confiabilidad\ConfiabilidadController@Index');        
        Route::get('/clientes/confiabilidad/create/', 'Nutibara\Clientes\Confiabilidad\ConfiabilidadController@Create');
        Route::post('/clientes/confiabilidad/create', 'Nutibara\Clientes\Confiabilidad\ConfiabilidadController@CreatePost');
        Route::get('/clientes/confiabilidad/update/{id}', 'Nutibara\Clientes\Confiabilidad\ConfiabilidadController@Update');
        Route::post('/clientes/confiabilidad/update', 'Nutibara\Clientes\Confiabilidad\ConfiabilidadController@UpdatePost');
        Route::post('/clientes/confiabilidad/delete', 'Nutibara\Clientes\Confiabilidad\ConfiabilidadController@Delete');        
        Route::post('/clientes/confiabilidad/active', 'Nutibara\Clientes\Confiabilidad\ConfiabilidadController@Active');
    }); 
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/confiabilidad/get', 'Nutibara\Clientes\Confiabilidad\ConfiabilidadController@get');
	Route::get('/clientes/confiabilidad/getSelectList', 'Nutibara\Clientes\Confiabilidad\ConfiabilidadController@getSelectList');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /*Cargo Empleado  */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.cargoEmpleado'],function(){ 
        Route::get('/clientes/cargoempleado', 'Nutibara\Clientes\CargoEmpleado\CargoEmpleadoController@Index');        
        Route::get('/clientes/cargoempleado/create/', 'Nutibara\Clientes\CargoEmpleado\CargoEmpleadoController@Create');
        Route::post('/clientes/cargoempleado/create', 'Nutibara\Clientes\CargoEmpleado\CargoEmpleadoController@CreatePost');
        Route::get('/clientes/cargoempleado/update/{id}', 'Nutibara\Clientes\CargoEmpleado\CargoEmpleadoController@Update');
        Route::post('/clientes/cargoempleado/update', 'Nutibara\Clientes\CargoEmpleado\CargoEmpleadoController@UpdatePost');
        Route::post('/clientes/cargoempleado/delete', 'Nutibara\Clientes\CargoEmpleado\CargoEmpleadoController@Delete');        
        Route::post('/clientes/cargoempleado/active', 'Nutibara\Clientes\CargoEmpleado\CargoEmpleadoController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/cargoempleado/get', 'Nutibara\Clientes\CargoEmpleado\CargoEmpleadoController@get');
	Route::get('/clientes/cargoempleado/getselectlist', 'Nutibara\Clientes\CargoEmpleado\CargoEmpleadoController@getSelectList');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /* Motivo Retiro  */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.motivoRetiro'],function(){ 
        Route::get('/clientes/motivoretiro', 'Nutibara\Clientes\MotivoRetiro\MotivoRetiroController@Index');        
        Route::get('/clientes/motivoretiro/create/', 'Nutibara\Clientes\MotivoRetiro\MotivoRetiroController@Create');
        Route::post('/clientes/motivoretiro/create', 'Nutibara\Clientes\MotivoRetiro\MotivoRetiroController@CreatePost');
        Route::get('/clientes/motivoretiro/update/{id}', 'Nutibara\Clientes\MotivoRetiro\MotivoRetiroController@Update');
        Route::post('/clientes/motivoretiro/update', 'Nutibara\Clientes\MotivoRetiro\MotivoRetiroController@UpdatePost');
        Route::post('/clientes/motivoretiro/delete', 'Nutibara\Clientes\MotivoRetiro\MotivoRetiroController@Delete');        
        Route::post('/clientes/motivoretiro/active', 'Nutibara\Clientes\MotivoRetiro\MotivoRetiroController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/motivoretiro/get', 'Nutibara\Clientes\MotivoRetiro\MotivoRetiroController@get');
	Route::get('/clientes/motivoretiro/getSelectList', 'Nutibara\Clientes\MotivoRetiro\MotivoRetiroController@getSelectList');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /* EPS */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.eps'],function(){ 
        Route::get('/clientes/eps', 'Nutibara\Clientes\Eps\EpsController@Index');
        Route::get('/clientes/eps/create', 'Nutibara\Clientes\Eps\EpsController@Create');
        Route::post('/clientes/eps/create', 'Nutibara\Clientes\Eps\EpsController@CreatePost');
        Route::get('/clientes/eps/update/{id}', 'Nutibara\Clientes\Eps\EpsController@Update');
        Route::post('/clientes/eps/update', 'Nutibara\Clientes\Eps\EpsController@UpdatePost');
        Route::post('/clientes/eps/delete', 'Nutibara\Clientes\Eps\EpsController@Delete');
        Route::post('/clientes/eps/active', 'Nutibara\Clientes\Eps\EpsController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/eps/get', 'Nutibara\Clientes\Eps\EpsController@get');
    Route::get('/clientes/eps/geteps', 'Nutibara\Clientes\Eps\EpsController@getEps');
	Route::get('/clientes/eps/getSelectList', 'Nutibara\Clientes\Eps\EpsController@getSelectList');
    Route::get('/clientes/eps/getSelectListEps', 'Nutibara\Clientes\Eps\EpsController@getSelectListEps');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /* CAJAS DE COMPENSACION */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.parametro.cajaComp'],function(){ 
        Route::get('/clientes/caja', 'Nutibara\Clientes\Caja\CajaController@Index');
        Route::get('/clientes/caja/create', 'Nutibara\Clientes\Caja\CajaController@Create');
        Route::post('/clientes/caja/create', 'Nutibara\Clientes\Caja\CajaController@CreatePost');
        Route::get('/clientes/caja/update/{id}', 'Nutibara\Clientes\Caja\CajaController@Update');
        Route::post('/clientes/caja/update', 'Nutibara\Clientes\Caja\CajaController@UpdatePost');
        Route::post('/clientes/caja/delete', 'Nutibara\Clientes\Caja\CajaController@Delete');
        Route::post('/clientes/caja/active', 'Nutibara\Clientes\Caja\CajaController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/caja/get', 'Nutibara\Clientes\Caja\CajaController@get');
    Route::get('/clientes/caja/getcaja', 'Nutibara\Clientes\Caja\CajaController@getCaja');
	Route::get('/clientes/caja/getSelectList', 'Nutibara\Clientes\Caja\CajaController@getSelectList');
    Route::get('/clientes/caja/getSelectListCaja', 'Nutibara\Clientes\Caja\CajaController@getSelectListCaja');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /*Clientes*/
    /* Persona Natural */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.cliente.personaNatural'],function(){ 
        Route::get('/clientes/persona/natural', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@IndexCliente');        
        Route::get('/clientes/persona/natural/create/', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@Create');
        Route::get('/clientes/persona/natural/create/contrato/{tipodoc}/{numdoc}', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@CreateFormContrato');
        Route::post('/clientes/persona/natural/create', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@CreatePost');
        Route::get('/clientes/persona/natural/update/{id}/{idTienda}', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@Update');
        Route::post('/clientes/persona/natural/update', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@UpdatePost');
        Route::post('/clientes/persona/natural/delete', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@Delete');
        Route::post('/clientes/persona/natural/active', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@Active');  
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/persona/natural/get', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@get');
	Route::get('/clientes/persona/natural/getSelectList', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@getSelectList');
    Route::get('/clientes/persona/natural/getSelectListById', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@getSelectListById');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /* Persona Jurídica */
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.cliente.personaJuridica'],function(){ 
        Route::get('/clientes/persona/juridica', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@Index');        
        Route::get('/clientes/persona/juridica/create/', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@Create');
        Route::post('/clientes/persona/juridica/create', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@CreatePost');
        Route::get('/clientes/persona/juridica/update/{id}/{idTienda}', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@Update');
        Route::post('/clientes/persona/juridica/update', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@UpdatePost');
        Route::post('/clientes/persona/juridica/delete', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@Delete');
        Route::post('/clientes/persona/juridica/active', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/persona/juridica/get', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@get');
	Route::get('/clientes/persona/juridica/getSelectList', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@getSelectList');
    Route::get('/clientes/persona/juridica/getSelectListById', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@getSelectListById');
    Route::get('/clientes/persona/juridica/getAutoComplete', 'Nutibara\Clientes\PersonaJuridica\PersonaJuridicaController@getAutoComplete');  
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /*Proveedores*/
    /*Persona Natural*/
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.proveedor.personaNatural'],function(){ 
        Route::get('/clientes/proveedor/persona/natural', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@Index');
        Route::post('/clientes/proveedor/persona/natural', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@Index');        
        Route::get('/clientes/proveedor/persona/natural/create/', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@Create');
        Route::post('/clientes/proveedor/persona/natural/create', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@CreatePost');
        Route::get('/clientes/proveedor/persona/natural/update/{id}/{idTienda}', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@Update');
        Route::post('/clientes/proveedor/persona/natural/update', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@UpdatePost');
        Route::post('/clientes/proveedor/persona/natural/delete', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@Delete');         
        Route::post('/clientes/proveedor/persona/natural/active', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@Active');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/proveedor/persona/natural/get', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@get');
	Route::get('/clientes/proveedor/persona/natural/getSelectList', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@getSelectList');
    Route::get('/clientes/proveedor/persona/natural/getSelectListById', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@getSelectListById');
    Route::get('/clientes/proveedor/persona/natural/getSelectListByNombre', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@getSelectListByNombre');
    Route::get('/clientes/proveedor/persona/natural/getAutoComplete', 'Nutibara\Clientes\ProveedorNatural\ProveedorNaturalController@getAutoComplete'); 
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    /*Persona Jurídica*/
    Route::group(['middleware'=>'isFuncionalidad:gestionCliente.proveedor.personaJuridica'],function(){ 
        Route::get('/clientes/proveedor/persona/juridica', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@Index');        
        Route::get('/clientes/proveedor/persona/juridica/create/', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@Create');
        Route::post('/clientes/proveedor/persona/juridica/create', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@CreatePost');
        Route::get('/clientes/proveedor/persona/juridica/update/{id}/{idTienda}', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@Update');
        Route::post('/clientes/proveedor/persona/juridica/update', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@UpdatePost');
        Route::post('/clientes/proveedor/persona/juridica/delete', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@Delete');
        Route::post('/clientes/proveedor/persona/juridica/active', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@Active');        
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/proveedor/persona/juridica/get', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@get');
	Route::get('/clientes/proveedor/persona/juridica/getSelectList', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@getSelectList');
    Route::get('/clientes/proveedor/persona/juridica/getSelectListById', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@getSelectListById');
    Route::get('/clientes/proveedor/persona/juridica/getAutoComplete', 'Nutibara\Clientes\ProveedorJuridico\ProveedorJuridicoController@getAutoComplete');  
    /////////////////////Fin Consultas por Ajax///////////////////////// 
   

    ////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////Módulo///////////////////////////////////////////
    /////////////////////////////Gestión de Contabilidad//////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////     
    
    /* Plan Único de Cuentas  */
    Route::group(['middleware'=>'isFuncionalidad:gestionContabilidad.plan1cuenta'],function(){ 
       Route::get('/clientes/planunicocuenta', 'Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuentaController@Index');        
       Route::get('/clientes/planunicocuenta/create/', 'Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuentaController@Create');
       Route::post('/clientes/planunicocuenta/create', 'Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuentaController@CreatePost');
       Route::get('/clientes/planunicocuenta/update/{id}', 'Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuentaController@Update');
       Route::post('/clientes/planunicocuenta/update', 'Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuentaController@UpdatePost');
       Route::post('/clientes/planunicocuenta/delete', 'Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuentaController@Delete');        
       Route::post('/clientes/planunicocuenta/active', 'Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuentaController@Active');
    });
    
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/planunicocuenta/get', 'Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuentaController@get');
    Route::get('/clientes/planunicocuenta/getexcel', 'Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuentaController@getExcel');
    Route::get('/clientes/planunicocuenta/getSelectList', 'Nutibara\Clientes\PlanUnicoCuenta\PlanUnicoCuentaController@getSelectList');
    /////////////////////Fin Consultas por Ajax///////////////////////// 

    //////////////////////////////// Arqueo
    Route::group(['middleware'=>'isFuncionalidad:tesoreria.arqueo'],function(){ 
        Route::get('/tesoreria/arqueo', 'Nutibara\Arqueo\ArqueoController@Index');  
        Route::post('/tesoreria/arqueo/generatepdf', 'Nutibara\Arqueo\ArqueoController@generatePDF');  
        Route::post('/tesoreria/arqueo/nuevocierre', 'Nutibara\Arqueo\ArqueoController@nuevoCierre');  
    });

    //////////////////////////////// Cierre de Caja.
    Route::group(['middleware'=>'isFuncionalidad:tesoreria.cierrecaja'],function(){ 
        Route::get('/tesoreria/cierrecaja', 'Nutibara\CierreCaja\CierreCajaController@Index');  
        Route::get('/tesoreria/cierrecajaindex', 'Nutibara\CierreCaja\CierreCajaController@IndexCierreCaja');  
        Route::get('/tesoreria/terminarcierrecaja/{saldo_final}', 'Nutibara\CierreCaja\CierreCajaController@terminarCierreCaja');  
        Route::post('/tesoreria/cierrecaja/generatepdf', 'Nutibara\CierreCaja\CierreCajaController@generatePDF');  
    });

    //////////////////////////////// Cierre de Caja.
    
////////// Impuesto/////
    Route::group(['middleware'=>'isFuncionalidad:tesoreria.impuesto'],function(){ 
        Route::get('/tesoreria/impuesto', 'Nutibara\GestionTesoreria\Impuesto\ImpuestoController@Index');        
        Route::get('/tesoreria/impuesto/create', 'Nutibara\GestionTesoreria\Impuesto\ImpuestoController@Create');
        Route::post('/tesoreria/impuesto/create', 'Nutibara\GestionTesoreria\Impuesto\ImpuestoController@CreatePost');
        Route::get('/tesoreria/impuesto/update/{id}', 'Nutibara\GestionTesoreria\Impuesto\ImpuestoController@Update');
        Route::post('/tesoreria/impuesto/update', 'Nutibara\GestionTesoreria\Impuesto\ImpuestoController@UpdatePost');
        Route::post('/tesoreria/impuesto/delete', 'Nutibara\GestionTesoreria\Impuesto\ImpuestoController@Delete');        
        Route::post('/tesoreria/impuesto/active', 'Nutibara\GestionTesoreria\Impuesto\ImpuestoController@Active');
        Route::get('/tesoreria/impuesto/getSelectList', 'Nutibara\GestionTesoreria\Impuesto\ImpuestoController@getSelectList');
        Route::get('/tesoreria/impuesto/getSelectListById', 'Nutibara\GestionTesoreria\Impuesto\ImpuestoController@getSelectListById');
    });
    
    ////////////////////////////////////// Ajax////////////////////////////
    Route::get('/tesoreria/impuesto/get', 'Nutibara\GestionTesoreria\Impuesto\ImpuestoController@get');
    /////////////////////Fin Consultas por Ajax/////////////////////////
    //////////////////////////////// concepto
    Route::group(['middleware'=>'isFuncionalidad:tesoreria.configuracionconcepto'],function(){ 
    Route::get('/tesoreria/configuracionconcepto', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@Index');        
    Route::get('/tesoreria/configuracionconcepto/create', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@Create');
    Route::post('/tesoreria/configuracionconcepto/create', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@CreatePost');
    Route::get('/tesoreria/configuracionconcepto/update/{id}', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@Update');
    Route::post('/tesoreria/configuracionconcepto/update', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@UpdatePost');
    Route::post('/tesoreria/configuracionconcepto/delete', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@Delete');        
    Route::post('/tesoreria/configuracionconcepto/active', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@Active');
    Route::get('/tesoreria/configuracionconcepto/getSelectList', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@getSelectList');
    Route::get('/tesoreria/configuracionconcepto/getselectlistcodigo', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@getSelectListCodigo');
    Route::get('/tesoreria/configuracionconcepto/getselectlistnombre', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@getSelectListNombre');
    Route::get('/tesoreria/configuracionconcepto/impuestoconcepto', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@ImpuestoConcepto');        
    Route::post('/tesoreria/configuracionconcepto/actualizarimpuestoconcepto', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@ActualizarImpuestoConcepto'); 
    }); 

    /////////////////////Consultas por Ajax concepto/////////////////////////////
    Route::get('/tesoreria/configuracionconcepto/get', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@get');
    Route::get('/tesoreria/configuracionconcepto/getselectlistimpuesto', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@getSelectListImpuesto');    
    Route::get('/tesoreria/configuracionconcepto/getselectlistipodocumentocontable', 'Nutibara\GestionTesoreria\Concepto\ConceptoController@getSelectListTipoDocumentoContable');    
    /////////////////////Fin Consultas por Ajax/////////////////////////

    route::group(['middleware' => 'isFuncionalidad:gestionContabilidad.configuracionContable'],function(){
        Route::get('/contabilidad/configuracioncontable', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@Index');        
        Route::get('/contabilidad/configuracioncontable/create', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@Create');
        Route::post('/contabilidad/configuracioncontable/create', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@CreatePost');
        Route::get('/contabilidad/configuracioncontable/view/{id}', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@View');
        Route::get('/contabilidad/configuracioncontable/update/{id}', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@Update');
        Route::post('/contabilidad/configuracioncontable/update', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@UpdatePost');
        Route::post('/contabilidad/configuracioncontable/delete', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@Delete');        
        Route::post('/contabilidad/configuracioncontable/validarborrable', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@ValidarBorrable');        
        Route::get('/contabilidad/configuracioncontable/getpuc', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@getPuc');        
        Route::get('/contabilidad/configuracioncontable/getpucimp', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@getPucImp');                
        Route::get('/contabilidad/configuracioncontable/getProveedores', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@getProveedores');                
        Route::get('/contabilidad/configuracioncontable/selectlistclase', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@getSelectListClase');        
        Route::get('/contabilidad/configuracioncontable/selectlistsubclase', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@getSelectListSubClase');        
        Route::get('/contabilidad/configuracioncontable/selectlistsubclasebyclase', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@getSelectListSubclaseByClase');        
        Route::get('/contabilidad/configuracioncontable/selectlistclasebysubclase', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@getSelectListClaseBySubclase');        
        Route::post('/contabilidad/configuracioncontable/validarrepetido', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@ValidarRepetido');        
    }); 

    /////////////////////Consultas por Ajax contable/////////////////////////////
    Route::get('/contabilidad/configuracioncontable/get', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@get');
    Route::get('/contabilidad/configuracioncontable/selectlistbyidtipodocumento', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@selectlistByIdTipoDocumento');
    Route::get('/contabilidad/configuracioncontable/selectlistmovimientoscontablesbyid', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@selectlistMovimientosContablesById');             
    Route::get('/contabilidad/configuracioncontable/getcxc', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@getcxc');             
    Route::get('/contabilidad/configuracioncontable/getimpuestosxconfiguracion', 'Nutibara\GestionTesoreria\ConfiguracionContable\ConfiguracionContableController@getImpuestosXConfiguracion');             
    /////////////////////Fin Consultas por Ajax/////////////////////////
    
    ////////////////////// Movimientos Contables /////////////////////////////////////
    route::group(['middleware' => 'isFuncionalidad:gestionContabilidad.movimientoscontables'],function(){
        Route::get('/contabilidad/movimientoscontables', 'Nutibara\GestionTesoreria\MovimientosContables\MovimientosContablesController@Index');
    });
    /////////////////////Movimientos contables dataTable/////////////////////////////
    Route::get('/contabilidad/movimientoscontables/get', 'Nutibara\GestionTesoreria\MovimientosContables\MovimientosContablesController@get');
    Route::post('/contabilidad/movimientoscontables/exporttoExcel', 'Nutibara\GestionTesoreria\movimientoscontables\MovimientosContablesController@exportToExcel');
    Route::get('/contabilidad/movimientoscontables/logMovimientosContables/{codigo_cierre}/{numero_orden}/{id_tienda}/{id_tipo_documento}', 'Nutibara\GestionTesoreria\MovimientosContables\MovimientosContablesController@logMovimientosContables');
    /////////////////////Fin Consultas por Ajax/////////////////////////

    ////////// Impuesto/////
    Route::group(['middleware'=>'isFuncionalidad:tesoreria.tipodocumentocontable'],function(){ 
        Route::get('/tesoreria/tipodocumentocontable', 'Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContableController@Index');        
        Route::get('/tesoreria/tipodocumentocontable/create', 'Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContableController@Create');
        Route::post('/tesoreria/tipodocumentocontable/create', 'Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContableController@CreatePost');
        Route::get('/tesoreria/tipodocumentocontable/update/{id}', 'Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContableController@Update');
        Route::post('/tesoreria/tipodocumentocontable/update', 'Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContableController@UpdatePost');
        Route::post('/tesoreria/tipodocumentocontable/delete', 'Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContableController@Delete');        
        Route::post('/tesoreria/tipodocumentocontable/desactivate', 'Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContableController@Desactivate');        
        Route::post('/tesoreria/tipodocumentocontable/active', 'Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContableController@Active');
    });

    /////////////////////Consultas por Ajax concepto/////////////////////////////
    Route::get('/tesoreria/tipodocumentocontable/get', 'Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContableController@get');
    Route::get('/tesoreria/tipodocumentocontable/getselectlist', 'Nutibara\GestionTesoreria\TipoDocumentoContable\TipoDocumentoContableController@getSelectList');        
    /////////////////////Fin Consultas por Ajax/////////////////////////
    
    //Ingresos
    Route::group(['middleware'=>'isFuncionalidad:tesoreria.ingreso'],function(){ 
        Route::get('/tesoreria/ingreso', 'Nutibara\GestionTesoreria\Ingreso\IngresoController@Index');
    });
    //Egreso
    Route::group(['middleware'=>'isFuncionalidad:tesoreria.egreso'],function(){ 
        Route::get('/tesoreria/egreso', 'Nutibara\GestionTesoreria\Egreso\EgresoController@Index');        
    });
    //Nomina
    Route::group(['middleware'=>'isFuncionalidad:tesoreria.nomina'],function(){ 
        Route::get('/tesoreria/nomina', 'Nutibara\GestionTesoreria\Nomina\NominaController@Index');        
    });
    //Causacion
    Route::group(['middleware'=>'isFuncionalidad:tesoreria.causacion'],function(){ 
        Route::get('/tesoreria/causacion', 'Nutibara\GestionTesoreria\Causacion\CausacionController@Index');        
        Route::get('/tesoreria/causacion/create', 'Nutibara\GestionTesoreria\Causacion\CausacionController@Create');        
        Route::get('/tesoreria/causacion/update/{id}/{idTienda}', 'Nutibara\GestionTesoreria\Causacion\CausacionController@Update');        
        Route::get('/tesoreria/causacion/pay/{id}/{idTienda}/{formaPago}', 'Nutibara\GestionTesoreria\Causacion\CausacionController@Pay');
        Route::get('tesoreria/causacion/transfer/{id}/{idTienda}', 'Nutibara\GestionTesoreria\Causacion\CausacionController@Transfer');
        Route::post('/tesoreria/causacion/Cancelsalario', 'Nutibara\GestionTesoreria\Causacion\CausacionController@CancelSalario');        
        Route::get('/tesoreria/causacion/getimpuestosbypais', 'Nutibara\GestionTesoreria\Causacion\CausacionController@getImpuestosByPais');        
        Route::post('/tesoreria/causacion/createsalario', 'Nutibara\GestionTesoreria\Causacion\CausacionController@CreateSalarioPost');
        Route::post('tesoreria/causacion/updatesalario', 'Nutibara\GestionTesoreria\Causacion\CausacionController@UpdateSalarioPost');                           
        Route::post('/tesoreria/causacion/create', 'Nutibara\GestionTesoreria\Causacion\CausacionController@CreatePost');
        Route::post('/tesoreria/causacion/createsalariowithpay', 'Nutibara\GestionTesoreria\Causacion\CausacionController@CreateSalarioWithPay');
        Route::post('/tesoreria/causacion/anularcausacion', 'Nutibara\GestionTesoreria\Causacion\CausacionController@AnularCausacion');
        Route::post('/tesoreria/causacion/anularcausacionconpago', 'Nutibara\GestionTesoreria\Causacion\CausacionController@AnularCausacionConPago');
        Route::post('/tesoreria/causacion/anularpago', 'Nutibara\GestionTesoreria\Causacion\CausacionController@AnularPago');
        Route::post('/tesoreria/causacion/creategastotienda', 'Nutibara\GestionTesoreria\Causacion\CausacionController@CreateGastoTiendaPost');
    });
     /////////////////////Consultas por Ajax/////////////////////////////
     Route::get('/tesoreria/causacion/get', 'Nutibara\GestionTesoreria\Causacion\CausacionController@get'); 
     Route::get('/tesoreria/causacion/getimpuestosporcentaje', 'Nutibara\GestionTesoreria\Causacion\CausacionController@getImpuestosPorcentaje'); 
     Route::get('/tesoreria/causacion/getselectlistcodigo', 'Nutibara\GestionTesoreria\Causacion\CausacionController@getSelectListCodigo');
     Route::get('/tesoreria/causacion/getselectlistnombre', 'Nutibara\GestionTesoreria\Causacion\CausacionController@getSelectListNombre');       
     Route::get('/tesoreria/causacion/getselectlisttipocausacion', 'Nutibara\GestionTesoreria\Causacion\CausacionController@getSelectListTipoCausacion');       
    //Causacion
    Route::group(['middleware'=>'isFuncionalidad:tesoreria.prestamos'],function(){ 
        Route::get('/tesoreria/prestamos', 'Nutibara\GestionTesoreria\Prestamos\PrestamosController@Index');        
        Route::get('/tesoreria/prestamos/create', 'Nutibara\GestionTesoreria\Prestamos\PrestamosController@Create');        
        Route::get('/tesoreria/prestamos/update/{id}/{idTienda}', 'Nutibara\GestionTesoreria\Prestamos\PrestamosController@Update');        
        Route::get('/tesoreria/prestamos/pay/{id}/{idTienda}/{formaPago}', 'Nutibara\GestionTesoreria\Prestamos\PrestamosController@Pay');
        Route::get('tesoreria/prestamos/transfer/{id}/{idTienda}', 'Nutibara\GestionTesoreria\Prestamos\PrestamosController@Transfer');
        Route::get('/tesoreria/prestamos/get', 'Nutibara\GestionTesoreria\Prestamos\PrestamosController@get');        
        Route::post('/tesoreria/prestamos/createsalario', 'Nutibara\GestionTesoreria\Prestamos\PrestamosController@CreateSalarioPost');
        Route::post('tesoreria/prestamos/updatesalario', 'Nutibara\GestionTesoreria\Prestamos\PrestamosController@UpdateSalarioPost');                           
        Route::post('/tesoreria/prestamos/create', 'Nutibara\GestionTesoreria\Prestamos\PrestamosController@CreatePost');
        Route::post('/tesoreria/prestamos/createsalariowithpay', 'Nutibara\GestionTesoreria\Prestamos\PrestamosController@CreateSalarioWithPay');
    });


    ////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////Módulo///////////////////////////////////////////
    //////////////////////////////////Gestión Humana//////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////     
       
    /* Gestión EmpleadosV2 */
    Route::group(['middleware'=>'isFuncionalidad:gestionHumana.empleado'],function(){ 
        Route::get('/clientes/empleadov2', 'Nutibara\Clientes\EmpleadoV2\EmpleadoV2Controller@Index');    
        Route::get('/clientes/empleadov2/create', 'Nutibara\Clientes\EmpleadoV2\EmpleadoV2Controller@Create');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/clientes/empleadov2/get', 'Nutibara\Clientes\EmpleadoV2\EmpleadoV2Controller@get');
    Route::get('/clientes/empleadov2/getEmpleadoIden/{identi}/{tipoDocumento}/{idTienda}', 'Nutibara\Clientes\EmpleadoV2\EmpleadoV2Controller@getEmpleadoIden');        
    Route::get('/clientes/empleadov2/getTiendaZona/{id_tienda}', 'Nutibara\Clientes\EmpleadoV2\EmpleadoV2Controller@getTiendaZona'); 
    Route::get('/clientes/empleadov2/getCombos/{id_zona}', 'Nutibara\Clientes\EmpleadoV2\EmpleadoV2Controller@getCombos');
    Route::post('/clientes/empleadov2/getFranquiciaByTipoCliente', 'Nutibara\Clientes\FuncionesCliente\FuncionalidadesController@getFranquiciaByTipoCliente'); 
    Route::post('/clientes/empleadov2/getSociedadByFranquicia', 'Nutibara\Clientes\FuncionesCliente\FuncionalidadesController@getSociedadByFranquicia'); 
    Route::post('/clientes/empleadov2/getTiendaBySociedad', 'Nutibara\Clientes\FuncionesCliente\FuncionalidadesController@getTiendaBySociedad'); 
    /////////////////////Fin Consultas por Ajax/////////////////////////  
    /* Gestión Empleados */
    Route::group(['middleware'=>'isFuncionalidad:gestionHumana.empleado'],function(){ 
        Route::get('/clientes/empleado', 'Nutibara\Clientes\Empleado\EmpleadoController@Index');        
        Route::get('/clientes/empleado/create', 'Nutibara\Clientes\Empleado\EmpleadoController@Create');
        Route::post('/clientes/empleado/create', 'Nutibara\Clientes\Empleado\EmpleadoController@CreatePost');
        Route::post('/clientes/empleado/createasociate', 'Nutibara\Clientes\Empleado\EmpleadoController@CreateAsociatePost');
        Route::get('/clientes/empleado/update/{id}/{idTienda}', 'Nutibara\Clientes\Empleado\EmpleadoController@Update');
        Route::get('/clientes/empleado/updateclient/{id}/{idTienda}', 'Nutibara\Clientes\Empleado\EmpleadoController@UpdateClient');
        Route::post('/clientes/empleado/update', 'Nutibara\Clientes\Empleado\EmpleadoController@UpdatePost');
        Route::post('/clientes/empleado/delete', 'Nutibara\Clientes\Empleado\EmpleadoController@Delete');
        Route::post('/clientes/empleado/active', 'Nutibara\Clientes\Empleado\EmpleadoController@Active');        
    });
    /////////////////////Consultas por Ajax/////////////////////////////
	Route::get('/clientes/empleado/get', 'Nutibara\Clientes\Empleado\EmpleadoController@get');
	Route::get('/clientes/empleado/getSelectList', 'Nutibara\Clientes\Empleado\EmpleadoController@getSelectList');
    Route::get('/clientes/empleado/getSelectListById', 'Nutibara\Clientes\Empleado\EmpleadoController@getSelectListById');
    Route::get('/clientes/empleado/getAutoComplete', 'Nutibara\Clientes\Empleado\EmpleadoController@getAutoComplete');  
    Route::get('/clientes/empleado/getEmpleadoIden/{identi}/{tipoDocumento}/{idTienda}', 'Nutibara\Clientes\Empleado\EmpleadoController@getEmpleadoIden');        
    Route::get('/clientes/empleado/getproveedorjuridico/{identi}/{digitoverificacion}', 'Nutibara\Clientes\Empleado\EmpleadoController@getProveedorJuridico');        
    Route::get('/clientes/empleado/getproveedornatural/{identi}/{tipoDocumento}', 'Nutibara\Clientes\Empleado\EmpleadoController@getProveedorNatural');        
    Route::get('/clientes/empleado/getUser/{email}', 'Nutibara\Clientes\Empleado\EmpleadoController@getUser'); 
    Route::get('/clientes/empleado/getCombos/{id_zona}', 'Nutibara\Clientes\Empleado\EmpleadoController@getCombos'); 
	Route::get('/clientes/empleado/getTiendaZona/{id_tienda}', 'Nutibara\Clientes\Empleado\EmpleadoController@getTiendaZona'); 
    Route::get('/clientes/empleado/getSociedad/{id}', 'Nutibara\Clientes\Empleado\EmpleadoController@getSociedad'); 
    Route::post('/clientes/empleado/getparametroGeneral', 'Nutibara\Clientes\Empleado\EmpleadoController@getparametroGeneral'); 
    Route::get('/clientes/empleado/getemail', 'Nutibara\Clientes\Empleado\EmpleadoController@getEmail'); 
    Route::post('/clientes/empleado/getFamiliarN', 'Nutibara\Clientes\Empleado\EmpleadoController@getFamiliarN'); 
    Route::get('/clientes/empleado/validaradmin/{idTienda}', 'Nutibara\Clientes\Empleado\EmpleadoController@ValidarAdmin'); 
    Route::get('/clientes/empleado/validarjefezona/{idZona}', 'Nutibara\Clientes\Empleado\EmpleadoController@ValidarJefeZona'); 
    /* Rutas genéricas para todos los clientes */
    Route::post('/clientes/empleado/getparametroGeneral', 'Nutibara\Clientes\FuncionesCliente\FuncionalidadesController@getparametroGeneral'); 
    Route::post('/clientes/funciones/getValidarDocumento', 'Nutibara\Clientes\FuncionesCliente\FuncionalidadesController@checkCountCliente'); 
    Route::get('/clientes/empleado/update/{id}/{idTienda}/{idtipocliente}', 'Nutibara\Clientes\Empleado\EmpleadoController@update'); 
    Route::get('/clientes/persona/natural/update/{id}/{idTienda}/{idtipocliente}', 'Nutibara\Clientes\PersonaNatural\PersonaNaturalController@update'); 
    Route::post('/clientes/empleado/getFranquiciaByTipoCliente', 'Nutibara\Clientes\FuncionesCliente\FuncionalidadesController@getFranquiciaByTipoCliente'); 
    Route::post('/clientes/empleado/getSociedadByFranquicia', 'Nutibara\Clientes\FuncionesCliente\FuncionalidadesController@getSociedadByFranquicia'); 
    Route::post('/clientes/empleado/getTiendaBySociedad', 'Nutibara\Clientes\FuncionesCliente\FuncionalidadesController@getTiendaBySociedad'); 
    /////////////////////Fin Consultas por Ajax/////////////////////////  
        
    /* Reportes de Empleados*/
    Route::group(['middleware'=>'isFuncionalidad:gestionHumana.reporte'],function(){      
        /* Gestión humana/Empleado/Reporte */
        Route::get('/gestionhumana/empleado/reporte', 'Nutibara\GestionHumana\Empleado\ReporteController@Index');
        Route::get('/gestionhumana/empleado/getselectlistEstadoCivil', 'Nutibara\GestionHumana\Empleado\ReporteController@getselectlistEstadoCivil');
        Route::get('/gestionhumana/empleado/getselectlistTenenciaVivienda', 'Nutibara\GestionHumana\Empleado\ReporteController@getselectlistTenenciaVivienda');
        Route::get('/gestionhumana/empleado/getselectlistTipoVivienda', 'Nutibara\GestionHumana\Empleado\ReporteController@getselectlistTipoVivienda');
        Route::get('/gestionhumana/empleado/getselectlistTipoEstudio', 'Nutibara\GestionHumana\Empleado\ReporteController@getselectlistTipoEstudio');
        Route::get('/gestionhumana/empleado/getselectlistMotivoRetiro', 'Nutibara\GestionHumana\Empleado\ReporteController@getselectlistMotivoRetiro');
        Route::get('/gestionhumana/empleado/getselectlistTipoDocumento', 'Nutibara\GestionHumana\Empleado\ReporteController@getselectlistTipoDocumento');      
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/gestionhumana/empleado/get', 'Nutibara\GestionHumana\Empleado\ReporteController@get');
    Route::get('/gestionhumana/empleado/exportExcel/{nombre}/{primerApellido}/{segundoApellido}/{tipoCedula}/{cedula}/{estadoCivil}/{personasCargoMin}/{personasCargoMax}/{hijosMin}/{hijosMax}/{rangoEdadMin}/{rangoEdadMax}/{tipoVivienda}/{tenenciaVivienda}/{tipoEstudio}/{fechaEstudioMin}/{fechaEstudioMax}/{estadoEstudio}/{cargo}/{salarioMin}/{salarioMax}/{auxilioTransporte}/{retirado}/{fechaRetiroMin}/{fechaRetiroMax}/{motivoRetiro}/{familiaEmpresa}/{rangoFamiliaresMin}/{rangoFamiliaresMax}/{infoDetalladaHijos}/{infoDetalladaPersonasCargo}/{infoDetalladaFamiliaEmpresa}/{nulo}', 'Nutibara\GestionHumana\Empleado\ReporteController@exportExcel')->name('gestion.empleado.report');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Asociar Tiendas */
    Route::group(['middleware'=>'isFuncionalidad:gestionHumana.asociarTienda'],function(){  
        Route::get('/asociarclientes/asociartienda', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@Index');        
        Route::get('/asociarclientes/asociartienda/create/{id}/{id_tienda}', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@Create');
        Route::post('/asociarclientes/asociartienda/create', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@CreatePost');
        Route::get('/asociarclientes/asociartienda/update/{id}', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@Update');
        Route::post('/asociarclientes/asociartienda/update', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@UpdatePost');
        Route::post('/asociarclientes/asociartienda/delete', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@Delete');        
        Route::post('/asociarclientes/asociartienda/active', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@Active');        
        Route::get('/asociarclientes/asociartienda/tiendasseleccionadas', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@TiendasSeleccionadas');	     
    });
    /////////////////////Consultas por Ajax/////////////////////////////
	Route::get('/asociarclientes/asociartienda/get', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@get');
	Route::get('/asociarclientes/asociartienda/getselectlist', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@getSelectList');
	Route::get('/asociarclientes/asociartienda/getselectlisttipocliente', 'Nutibara\AsociarCliente\AsociarTienda\AsociarTiendaController@getSelectListTipoCliente');
    /////////////////////Fin Consultas por Ajax/////////////////////////  

    /* Asociar Sociedades */
    Route::group(['middleware'=>'isFuncionalidad:gestionHumana.asociar.sociedad'],function(){
        Route::get('/asociarclientes/asociarsociedad', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@Index');        
        Route::get('/asociarclientes/asociarsociedad/create/{id}/{id_tienda}', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@Create');
        Route::post('/asociarclientes/asociarsociedad/create', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@CreatePost');
        Route::get('/asociarclientes/asociarsociedad/update/{id}', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@Update');
        Route::post('/asociarclientes/asociarsociedad/update', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@UpdatePost');
        Route::post('/asociarclientes/asociarsociedad/delete', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@Delete');        
        Route::post('/asociarclientes/asociarsociedad/active', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@Active');        
        Route::get('/asociarclientes/asociarsociedad/sociedadesseleccionadas', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@SociedadesSeleccionadas');         
    });
    /////////////////////Consultas por Ajax/////////////////////////////
	Route::get('/asociarclientes/asociarsociedad/get', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@get');
	Route::get('/asociarclientes/asociarsociedad/getselectlist', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@getSelectList');
	Route::get('/asociarclientes/asociarsociedad/getselectlisttipocliente', 'Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedadController@getSelectListTipoCliente');
    /////////////////////Fin Consultas por Ajax/////////////////////////  
   
    ////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////Módulo///////////////////////////////////////////
    //////////////////////////////Gestión Plan Separe/////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////   
  
    /* Generar plan separe */
    Route::group(['middleware'=>'isFuncionalidad:gestionPlanSeparare'],function(){
        Route::get('/generarplan', 'Nutibara\GenerarPlan\GenerarPlanController@Index');
        Route::get('/generarplan/verificarcliente', 'Nutibara\GenerarPlan\GenerarPlanController@verificarcliente');
        Route::get('/generarplan/{tipodocumento}/{numdocumento}/{pa}/{sa}/{pn}/{sn}/{fn}/{gen}/{rh}', 'Nutibara\GenerarPlan\GenerarPlanController@CreateParam');
        Route::get('/generarplan/{tipodocumento}/{numdocumento}', 'Nutibara\GenerarPlan\GenerarPlanController@CreateIngreso');
        Route::get('/generarplan/create/{tipodocumento}/{numdocumento}', 'Nutibara\GenerarPlan\GenerarPlanController@CreateIngreso');
        Route::get('/generarplan/getGenerarPlan', 'Nutibara\GenerarPlan\GenerarPlanController@getGenerarPlan');
        Route::get('/generarplan/create', 'Nutibara\GenerarPlan\GenerarPlanController@Create');
        Route::get('/generarplan/cotizar', 'Nutibara\GenerarPlan\GenerarPlanController@Cotizar');
        Route::get('/generarplan/update/{id}', 'Nutibara\GenerarPlan\GenerarPlanController@Update');
        Route::get('/generarplan/getConfig', 'Nutibara\GenerarPlan\GenerarPlanController@getConfig');
        Route::get('/generarplan/getCotizacionById', 'Nutibara\GenerarPlan\GenerarPlanController@getCotizacionById');
        Route::get('/generarplan/validarFecha', 'Nutibara\GenerarPlan\GenerarPlanController@validarFecha');
        Route::get('/generarplan/validarCorreo', 'Nutibara\GenerarPlan\GenerarPlanController@validarCorreo');
        Route::post('/generarplan/cotizarPost', 'Nutibara\GenerarPlan\GenerarPlanController@CotizarPost');
        Route::post('/generarplan/updateInventario', 'Nutibara\GenerarPlan\GenerarPlanController@updateInventario');
        Route::post('/generarplan/create', 'Nutibara\GenerarPlan\GenerarPlanController@CreatePost');
        Route::post('/generarplan/update', 'Nutibara\GenerarPlan\GenerarPlanController@UpdatePost');
        Route::post('/generarplan/delete', 'Nutibara\GenerarPlan\GenerarPlanController@Delete');
        Route::post('/generarplan/active', 'Nutibara\GenerarPlan\GenerarPlanController@Active');        
        Route::post('/generarplan/updateClienteT', 'Nutibara\GenerarPlan\GenerarPlanController@updateClienteT');
        Route::post('/generarplan/updateClienteTIngreso', 'Nutibara\GenerarPlan\GenerarPlanController@updateClienteTIngreso');
        Route::post('/generarplan/createCliente', 'Nutibara\GenerarPlan\GenerarPlanController@createCliente');
        Route::post('/generarplan/createClienteIngreso', 'Nutibara\GenerarPlan\GenerarPlanController@createClienteIngreso');
        Route::post('/generarplan/generarpdf', 'Nutibara\GenerarPlan\GenerarPlanController@generatePDFPlan');

        /*cotización */
        Route::get('/cotizacion', 'Nutibara\Cotizacion\CotizacionController@index');
        Route::get('/cotizacion/get', 'Nutibara\Cotizacion\CotizacionController@get');
        Route::get('/cotizacion/create', 'Nutibara\Cotizacion\CotizacionController@create');
        Route::get('/cotizacion/update/{id_tienda}/{id_cotizacion}', 'Nutibara\Cotizacion\CotizacionController@update');
        Route::post('/cotizacion/store', 'Nutibara\Cotizacion\CotizacionController@store');
        Route::post('/cotizacion/storeUpdate', 'Nutibara\Cotizacion\CotizacionController@storeUpdate');


        /* Abonar plan separe*/ 
        Route::get('/generarplan/abonar/{id_tienda}/{codigo_plan}', 'Nutibara\GenerarPlan\GenerarPlanController@Abonar');
        Route::post('/generarplan/guardar', 'Nutibara\GenerarPlan\GenerarPlanController@guardar');
        Route::get('/generarplan/infoAbono/{id_tienda}/{codigo_plan}', 'Nutibara\GenerarPlan\GenerarPlanController@infoAbono');
        Route::get('/generarplan/transferirPlan/{id_tienda}/{codigo_plan}', 'Nutibara\GenerarPlan\GenerarPlanController@transferirPlan');
        Route::get('/generarplan/descargarPDFabono', 'Nutibara\GenerarPlan\GenerarPlanController@descargarPDFabono');
        
        /*Transferir plan separe*/
        Route::get('/generarplan/getTransferirPlan', 'Nutibara\GenerarPlan\GenerarPlanController@getTransferirPlan');
        Route::get('/generarplan/getTransferPlanH', 'Nutibara\GenerarPlan\GenerarPlanController@getTransferPlanH');
        Route::get('/generarplan/getTransferirContrato', 'Nutibara\GenerarPlan\GenerarPlanController@getTransferirContrato');
        Route::get('/generarplan/getTransferirContratoS', 'Nutibara\GenerarPlan\GenerarPlanController@getTransferirContratoS');
        Route::get('/generarplan/transferirGuardar', 'Nutibara\GenerarPlan\GenerarPlanController@transferirGuardar');
        Route::get('/generarplan/mesesAdeudados', 'Nutibara\GenerarPlan\GenerarPlanController@mesesAdeudados');
        /*Transferir a un nuevo plan*/
        Route::get('generarplan/transferirNuevoPlan/{id_tienda}/{saldo_favor}/{codigo_plan}','Nutibara\GenerarPlan\GenerarPlanController@transferirNuevoPlan');
        Route::get('/generarplan/{id_tienda}/{saldo_favor}/{codigo_plan}/{tipodocumento}/{numdocumento}/{pa}/{sa}/{pn}/{sn}/{fn}/{gen}/{rh}', 'Nutibara\GenerarPlan\GenerarPlanController@TransferirParam');
        Route::get('/generarplan/{id_tienda}/{saldo_favor}/{codigo_plan}/{tipodocumento}/{numdocumento}', 'Nutibara\GenerarPlan\GenerarPlanController@TransferirIngreso');
        Route::get('/generarplan/verificarclienteTransfer/{id_tienda}/{saldo_favor}/{codigo_plan}', 'Nutibara\GenerarPlan\GenerarPlanController@verificarclienteTransfer');
        Route::post('generarplan/CreatePostTransferir', 'Nutibara\GenerarPlan\GenerarPlanController@CreatePostTransferir');
        /*Anular plan seapre y reverzar abonos*/
        Route::get('/generarplan/anular','Nutibara\GenerarPlan\GenerarPlanController@anular');
        Route::get('generarplan/solicitudAnulacion','Nutibara\GenerarPlan\GenerarPlanController@solicitudAnulacion');
        Route::get('/generarplan/reversarAbono','Nutibara\GenerarPlan\GenerarPlanController@reversarAbono');
        Route::get('generarplan/rechazarReversar','Nutibara\GenerarPlan\GenerarPlanController@rechazarReversar');
        Route::get('generarplan/solicitarReversarAbono', 'Nutibara\GenerarPlan\GenerarPlanController@solicitarReversarAbono');
        Route::get('/generarplan/infoAbono/{id_tienda}/{codigo_plan}/{idRemitente}', 'Nutibara\GenerarPlan\GenerarPlanController@infoAbono');
        /*Plan seapre sin producto*/
        Route::get('/generarplan/sinProducto/{id_tienda}','Nutibara\GenerarPlan\GenerarPlanController@sinProducto');
        
        /* Gestion plan separe */
        Route::get('/gestionplan', 'Nutibara\GestionPlan\GestionPlanController@Index');
        Route::get('/gestionplan/create', 'Nutibara\GestionPlan\GestionPlanController@Create');
        Route::post('/gestionplan/create', 'Nutibara\GestionPlan\GestionPlanController@CreatePost');
        Route::get('/gestionplan/update/{id}', 'Nutibara\GestionPlan\GestionPlanController@Update');
        Route::post('/gestionplan/update', 'Nutibara\GestionPlan\GestionPlanController@UpdatePost');
        Route::post('/gestionplan/delete', 'Nutibara\GestionPlan\GestionPlanController@Delete');
        Route::post('/gestionplan/active', 'Nutibara\GestionPlan\GestionPlanController@Active');
        Route::post('/gestionplan/updateClienteT', 'Nutibara\GestionPlan\GestionPlanController@updateClienteT'); 

        // Configuración de plan separe
        Route::get('/gestionplan/config', 'Nutibara\ConfigPlan\ConfigPlanController@index');  
        Route::get('/gestionplan/config/get', 'Nutibara\ConfigPlan\ConfigPlanController@get');        
        Route::get('/gestionplan/config/create', 'Nutibara\ConfigPlan\ConfigPlanController@create');
        Route::post('/gestionplan/config/store', 'Nutibara\ConfigPlan\ConfigPlanController@store');
        Route::get('/gestionplan/config/edit/{id}', 'Nutibara\ConfigPlan\ConfigPlanController@edit');
        Route::post('/gestionplan/config/update', 'Nutibara\ConfigPlan\ConfigPlanController@update');
        Route::post('/gestionplan/config/active', 'Nutibara\ConfigPlan\ConfigPlanController@active');   
        Route::post('/gestionplan/config/inactive', 'Nutibara\ConfigPlan\ConfigPlanController@inactive');
        Route::post('/gestionplan/config/delete', 'Nutibara\ConfigPlan\ConfigPlanController@delete');
    });
    /////////////////////Consultas por Ajax/////////////////////////////
    Route::get('/generarplan/getSelectList', 'Nutibara\GenerarPlan\GenerarPlanController@getSelectList');
    Route::get('/generarplan/getSelectListById', 'Nutibara\GenerarPlan\GenerarPlanController@getSelectListById');
    Route::get('/generarplan/get', 'Nutibara\GenerarPlan\GenerarPlanController@get');
    Route::get('/generarplan/getInventarioById','Nutibara\GenerarPlan\GenerarPlanController@getInventarioById');
    Route::get('/generarplan/getInventarioById2','Nutibara\GenerarPlan\GenerarPlanController@getInventarioById2');
    Route::get('/generarplan/getSecuencia','Nutibara\GenerarPlan\GenerarPlanController@getSecuencia');
    Route::get('/generarplan/getInfoPrecio','Nutibara\GenerarPlan\GenerarPlanController@getInfoPrecio');
    Route::get('/generarplan/getInfoAbonos/{id_tienda}/{codigo_plan}','Nutibara\GenerarPlan\GenerarPlanController@getInfoAbonos');
    Route::get('generarplan/detalleAbono/{id_tienda}/{id_abono}','Nutibara\GenerarPlan\GenerarPlanController@detalleAbono');
    Route::get('/generarplan/getCliente/{id_tienda}/{iden}', 'Nutibara\GenerarPlan\GenerarPlanController@getCliente');
    Route::get('/generarplan/pdfabono', 'Nutibara\GenerarPlan\GenerarPlanController@pdfabono');
    /* Gestion plan separe */
    Route::get('/gestionplan/getCliente/{iden}', 'Nutibara\GestionPlan\GestionPlanController@getCliente');
    Route::get('/gestionplan/getSelectList', 'Nutibara\GestionPlan\GestionPlanController@getSelectList');
    Route::get('/gestionplan/getSelectListGestionPlan', 'Nutibara\GestionPlan\GestionPlanController@getSelectListGestionPlan');
    Route::get('/gestionplan/get', 'Nutibara\GestionPlan\GestionPlanController@get');
    Route::get('/gestionplan/getGestionPlan', 'Nutibara\GestionPlan\GestionPlanController@getGestionPlan');
    /////////////////////Fin Consultas por Ajax///////////////////////// 


    ////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////Módulo///////////////////////////////////////////
    //////////////////////////////Gestión de Usuarios/////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////  

    /* Administrar Usuario */
    Route::group(['middleware'=>'isFuncionalidad:gestionUser.usuario'],function(){
        Route::get('/users/list', 'Autenticacion\UpdateController@listUser')->name('listUser');
        Route::get('/users', 'Autenticacion\UpdateController@users')->name('users');
        Route::get('/users/roles/ajax', 'Autenticacion\UpdateController@Roles')->name('roles');
        Route::post('/users/is/activated', 'Autenticacion\UpdateController@isActivated');
        /*Registrar usuario*/
        Route::get('/users/register', 'Autenticacion\RegisterController@showRegistrationForm')->name('register');
        Route::post('/users/registerAjax', 'Autenticacion\RegisterController@registerAjax');
        Route::post('/users/register', 'Autenticacion\RegisterController@register');
        Route::post('register2', 'Autenticacion\RegisterController@register2')->name('register2');//con validacion de token por email
        /*Actualizar usuario*/
        Route::get('/users/update/{id}', 'Autenticacion\UpdateController@showUpdateForm');
        Route::post('/users/update', 'Autenticacion\UpdateController@update');
        Route::post('/users/updateAjax', 'Autenticacion\UpdateController@updateAjax');
        /*Generar Token*/
        Route::get('/generate/token/user/{id}','Autenticacion\TokenValidatorController@GenerateToken')->name('generateToken');
        Route::get('/generate/token/','Autenticacion\TokenValidatorController@view')->name('generateToken.view');
    });
    /*Administar roles*/
    Route::group(['middleware'=>'isFuncionalidad:gestionUser.rol'],function(){
        Route::get('/users/roles', 'Autenticacion\RolesController@showRoles')->name('admin.roles');
        Route::get('/users/roles/list', 'Autenticacion\RolesController@list')->name('admin.roles.list');    
        /*Crear roles*/    
        Route::get('/users/roles/create', 'Autenticacion\RolesController@showCreateForm')->name('admin.roles.create');
        Route::post('/users/roles/create', 'Autenticacion\RolesController@create');    
        /*Borrar Rol*/
        Route::post('/users/roles/delete', 'Autenticacion\RolesController@delete')->name('admin.roles.delete'); 
        Route::post('/users/roles/activated', 'Autenticacion\RolesController@activateRol')->name('admin.roles.activated');    
        /*Actualizar roles*/    
        Route::get('/users/roles/update/{id}', 'Autenticacion\RolesController@showUpdateForm');
        Route::post('/users/roles/update', 'Autenticacion\RolesController@update')->name('admin.roles.update');
    });
    /*Asignar Módulo al Rol*/
    Route::group(['middleware'=>'isFuncionalidad:gestionUser.funcion'],function(){
        /*Asignar funcionalidades al rol empaquetadas por modulos*/    
        Route::get('/users/roles/module', 'Autenticacion\ModuleController@showModuleForm')->name('admin.roles.module');
        Route::post('/users/roles/module', 'Autenticacion\ModuleController@module');    
        Route::post('/users/roles/module/funcionalidad/update', 'Autenticacion\ModuleController@update')->name('admin.roles.funcionalidad.update');
        Route::get('/users/roles/module/view/function/{id}', 'Autenticacion\ModuleController@viewFunction')->name('admin.roles.view.function');         
    });	 

    /* Denominación de Monedas*/
    Route::group(['middleware'=>'isFuncionalidad:admonGeneral.denominacionmoneda'],function(){ 
        Route::get('/clientes/denominacionmoneda', 'Nutibara\Clientes\DenominacionMoneda\DenominacionMonedaController@Index');
        Route::get('/clientes/denominacionmoneda/create', 'Nutibara\Clientes\DenominacionMoneda\DenominacionMonedaController@Create');
        Route::post('/clientes/denominacionmoneda/create', 'Nutibara\Clientes\DenominacionMoneda\DenominacionMonedaController@CreatePost');
        Route::get('/clientes/denominacionmoneda/update/{id}', 'Nutibara\Clientes\DenominacionMoneda\DenominacionMonedaController@Update');
        Route::post('/clientes/denominacionmoneda/update', 'Nutibara\Clientes\DenominacionMoneda\DenominacionMonedaController@UpdatePost');
        Route::post('/clientes/denominacionmoneda/delete', 'Nutibara\Clientes\DenominacionMoneda\DenominacionMonedaController@Delete');
        Route::post('/clientes/denominacionmoneda/active', 'Nutibara\Clientes\DenominacionMoneda\DenominacionMonedaController@Active');
    });
        /////////////////////Consultas por Ajax/////////////////////////////
        Route::get('/clientes/denominacionmoneda/get', 'Nutibara\Clientes\DenominacionMoneda\DenominacionMonedaController@get');
        Route::get('/clientes/denominacionmoneda/getcaja', 'Nutibara\Clientes\DenominacionMoneda\DenominacionMonedaController@getCaja');
        Route::get('/clientes/denominacionmoneda/getSelectList', 'Nutibara\Clientes\DenominacionMoneda\DenominacionMonedaController@getSelectList');
        /////////////////////Fin Consultas por Ajax///////////////////////// 

       /////////////////////////////////////////////////////////////////////////////////////
      //////////////////////////////////////Módulo/////////////////////////////////////////
     //////////////////////////////Modulo de Inventario///////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////  
     Route::get('/inventario','Nutibara\Inventario\InventarioController@Index');
     Route::get('/inventario/get','Nutibara\Inventario\InventarioController@Get');
     Route::get('/inventario/actualizar/{id}','Nutibara\Inventario\InventarioController@ViewUpdate');
     Route::post('/inventario/actualizar','Nutibara\Inventario\InventarioController@Update');
     Route::post('/inventario/precio/venta','Nutibara\Inventario\InventarioController@ValorVentaByPeso');
     Route::get('/inventario/nuevo','Nutibara\Inventario\InventarioController@ViewCreate');
     Route::post('/inventario/nuevo','Nutibara\Inventario\InventarioController@Create');
     Route::post('/is/lote/get','Nutibara\Inventario\InventarioController@IsLote');
     Route::get('/bucar/referencia/{data}','Nutibara\Inventario\InventarioController@GetReference');
     Route::post('/bucar/descripcion','Nutibara\Inventario\InventarioController@GetDescriptionById');
     Route::get('/estado/get/all','Nutibara\Inventario\InventarioController@GetEstado');
     //////////////////////////////Modulo de trazabilidad de id///////////////////////////////////
     Route::get('/inventario/trazabilidad','Nutibara\Inventario\Trazabilidad\TrazabilidadController@Index');
     Route::get('/inventario/trazabilidad/get','Nutibara\Inventario\Trazabilidad\TrazabilidadController@Get');
     Route::post('/inventario/trazabilidad/create','Nutibara\Inventario\Trazabilidad\TrazabilidadController@Create');
    ////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////Módulo///////////////////////////////////////////
    //////////////////////////////Globales del Sistema////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////  

    /*Home*/
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index');     
    Route::post('/testeo', 'HomeController@testeo');     
    /*Cerrar sesion*/
    Route::post('logout', 'Autenticacion\LoginController@logout')->name('logout'); 
    Route::get('logout', 'Autenticacion\LoginController@logout')->name('logout'); 
	/*Mensajes*/
    Route::get('/mensajes', 'Notificacion\NotificacionController@index')->name('mensajes.index');
    Route::get('/mensajes/get', 'Notificacion\NotificacionController@get')->name('mensajes.get');
    Route::post('/mensajes/get/id', 'Notificacion\NotificacionController@GetMensaje')->name('mensajes.get.id');
    Route::post('/mensajes/matricular', 'Notificacion\NotificacionController@Matricular')->name('mensajes.matricular');
    Route::post('/contrato/anular/solicitud', 'Nutibara\Contratos\AnularController@SolicitarAnularAction')->name('contrato.anular.solicitud');
    Route::post('/contrato/anular/solicitud/aprobado', 'Nutibara\Contratos\AnularController@AprobarSolicitudAction')->name('contrato.anular.solicitud.aprobado');
    Route::post('/contrato/anular/solicitud/anulado', 'Nutibara\Contratos\AnularController@RechazarSolicitudAction')->name('contrato.anular.solicitud.rechazada');
    Route::post('/contrato/anular/anulado', 'Nutibara\Contratos\AnularController@AnularContratoAction')->name('contrato.anular.anulado');
    ////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////  

    ////////////////////////Prueba///////////////////////////////////
    Route::get('/prueba', function(){ 
        return view('prueba');
    });
    /////////////////////////////////////////////////////////////////// 

    // Route::get('/caja/cierre/tiendas', 'Nutibara\Tienda\TiendaController@arregloTiendas');            

});

/* URL usuarios no logueados*/
Route::group(['middleware'=>'guest'],function(){
    /* Autenticacion */
    Route::get('login', 'Autenticacion\LoginController@showLoginForm')->name('login');
    Route::get('login/admin', 'Autenticacion\LoginController@showLoginFormAdmin');
    Route::post('login', 'Autenticacion\LoginController@login'); 

    /*Password Reset Routes*/
    Route::get('password/reset', 'Autenticacion\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Autenticacion\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Autenticacion\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Autenticacion\ResetPasswordController@reset');
    
    /*Verfivar Token por email*/
    Route::get('verifyEmailFirst','Autenticacion\RegisterController@verifyEmailFirst')->name('verifyEmailFirst');
    Route::get('verify/{email}/{verifyToken}','Autenticacion\RegisterController@sendEmailDone')->name('sendEmailDone');
    /*Verifica Token y inicia sesion*/
    Route::get('verifyToken/{email}/{verifyToken}','Autenticacion\TokenValidatorController@LoginToken')->name('loginToken');   
    /*Generar Token, para iniciar sesion*/
    Route::post('/generate/token','Autenticacion\LoginTokenController@GenerateToken')->name('generateToken.create');
    Route::post('/login/token','Autenticacion\LoginTokenController@LoginToken')->name('loginToken.email');  
    Route::get('/login/token','Autenticacion\LoginTokenController@LoginToken')->name('loginToken.huella'); 
 });   

 Route::group(['middleware'=>'isFuncionalidad:admonGeneral.abrirtienda'],function(){ 
    Route::get('/tienda/abrir', 'Nutibara\Tienda\TiendaController@Abrir');            
});




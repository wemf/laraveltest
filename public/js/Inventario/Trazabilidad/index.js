$(document).ready(function() {
    column=[  
        { "data": "tienda" },
        { "data": "id" },
        { "data": "id_origen" },
        { "data": "movimiento" },
        { "data": "fecha_ingreso" },
        { "data": "fecha_salida" },
        { "data": "ubicacion" },
        { "data": "categoria" },
        { "data": "motivo" },
        { "data": "estado" },
        { "data": "numero_contrato" },
        { "data": "numero_item" },
        /*{ "data": "numero_orden" },*/
        { "data": "numero_referente" },
        { "data": "usuario_registro" },
    ];
    dataTableActionFilterRefrechSelect(urlBase.make('inventario/trazabilidad/get'),urlBase.make('plugins/datatable/DataTables-1.10.13/json/spanish.json'),column)
    loadSelectInput("#col0_filter", urlBase.make('pais/getpais'), 2);
    SelectValPais("#col0_filter");
    loadSelectInputByParent("#col1_filter", urlBase.make('departamento/getdepartamentobypais'), $('#col0_filter').val(), 2);
    loadSelectInputByParent("#col2_filter", urlBase.make('ciudad/getciudadbydepartamento'), $('#col1_filter').val(), 2);
});

$(document).ready(function() {
    column=[  
        { "data": "tienda" },
        { "data": "DT_RowId" },
        { "data": "lote" },
        { "data": "categoria_general" },
        { "data": "referencia" },
        { "data": "es_nuevo" },
        { "data": "fecha_ingreso" },
        { "data": "fecha_salida" },
        { "data": "precio_venta" },
        { "data": "precio_compra" },
        { "data": "costo_total" },
        { "data": "cantidad" },
        { "data": "peso" },           
        { "data": "estado" },
        { "data": "motivo" },
    
        
    ];
    dataTableActionFilterRefrechSelect(urlBase.make('inventario/get'),urlBase.make('plugins/datatable/DataTables-1.10.13/json/spanish.json'),column)
 
    loadSelectInput("#col0_filter", urlBase.make('pais/getpais'), 2);
    loadSelectInput("#col9_filter", urlBase.make('estado/get/all'), 2);
    SelectValPais("#col0_filter");            
    loadSelectInputByParent("#col1_filter", urlBase.make('departamento/getdepartamentobypais'), $('#col0_filter').val(), 2);
    loadSelectInputByParent("#col2_filter", urlBase.make('ciudad/getciudadbydepartamento'), $('#col0_filter').val(), 2);
});

$("#updateAction1").click(function() {
    var url2=urlBase.make('/inventario/actualizar');
    updateRowDatatableAction(url2)
});
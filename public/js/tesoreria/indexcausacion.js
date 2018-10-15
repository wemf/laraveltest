//Cargas Iniciales
loadSelectInput("#col0_filter",urlBase.make('pais/getSelectList'));
SelectValPais("#col0_filter");
loadSelectInput('#col5_filter', urlBase.make('gestionestado/estado/getEstadoByTema')+"/"+15, true);
loadSelectInput("#col7_filter",urlBase.make('tesoreria/causacion/getselectlisttipocausacion'));    

//Eventos
$('#col0_filter').change(function () {
        var id = $('#col0_filter').val();
        var url2 = urlBase.make('departamento/getdepartamentobypais') + "/" + id;
        loadSelectInput('#col1_filter', url2, true);

        url2 = urlBase.make('zona/getSelectListZonaPais') + "/" + id;
        loadSelectInput('#col3_filter', url2, true);
    });   

    $('#col0_filter').change();

$('#col1_filter').change(function() {
    var id = $(this).val();
    loadSelectInput('#col2_filter',urlBase.make('ciudad/getciudadbydepartamento')+"/"+id, true);
});

$('#col2_filter').change(function() {
    var id = $(this).val();
    loadSelectInput('#col4_filter', urlBase.make('tienda/getTiendaByCiudad')+"/"+id, true);
});

$("#updateAction1").click(function() {
    updateRowDatatableAction(urlBase.make('tesoreria/causacion/update'))
});

$("#deletedAction1").click(function() { 
    deleteRowDatatableAction(urlBase.make('tesoreria/causacion/delete'));
});

//Forma de pago de la causacion
$('#payAction').click(function(){
var table = $('#dataTableAction').DataTable();
var valueId = table.$('tr.selected').attr('id');
if (valueId != null) {
    $('#id').val(valueId);
    $('#myModal').modal('show');        
} else {
    Alerta('Error', 'Seleccione un registro.', 'error')
}
});

$('#pagar').click(function(){
    if($('#formaPago').val() != 0)      
    window.location = urlBase.make('/tesoreria/causacion/pay') + '/' + $('#id').val()+'/'+$('#formaPago').val();
})
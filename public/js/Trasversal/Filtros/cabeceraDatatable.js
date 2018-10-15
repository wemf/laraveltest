//////////////////////////////////////////////////////
///////////////Logica de cargar Filtros//////////////
////////////////////////////////////////////////////
$(document).ready(function() {


    var url2 = urlBase.make('pais/getSelectList');
    loadSelectInput('#col0_filter', url2, true);
    var url2 = urlBase.make('tienda/getSelectList');
    loadSelectInput('#col4_filter', url2, true);
    SelectValPais("#col0_filter");

    $('#col0_filter').change(function () {
        var id = $('#col0_filter').val();
        var url2 = urlBase.make('departamento/getdepartamentobypais') + "/" + id;
        loadSelectInput('#col1_filter', url2, true);

        url2 = urlBase.make('zona/getSelectListZonaPais') + "/" + id;
        loadSelectInput('#col3_filter', url2, true);

        if( id != '' ) {
            url3 = urlBase.make('tienda/getTiendaByPais') + "/" + id;
        }else{
            url3 = urlBase.make('tienda/getSelectList');
        }
        loadSelectInput('#col4_filter', url3, true);
    });   

    $('#col0_filter').change();

    var url3 = urlBase.make('clientes/tipodocumento/getSelectList2');
    loadSelectInput('#col5_filter', url3, true);

    $('#col1_filter').change(function() {
        var id = $(this).val();
        var url2 = urlBase.make('ciudad/getciudadbydepartamento') + "/" + id;
        loadSelectInput('#col2_filter', url2, true);
    });

    $('#col2_filter').change(function() {
        var id = $(this).val();
        var url2;
        
        if( id != '' ) {
            url2 = urlBase.make('tienda/getTiendaByCiudad') + "/" + id;
        }else{
            url2 = urlBase.make('tienda/getSelectList');
        }
        loadSelectInput('#col4_filter', url2, true);
    });

    $('#col1_filter').change(function() {
        var id = $(this).val();
        var url2;
        
        if( id != '' ) {
            url2 = urlBase.make('tienda/getTiendaByDepartamento') + "/" + id;
        }else{
            url2 = urlBase.make('tienda/getSelectList');
        }
        loadSelectInput('#col4_filter', url2, true);
    });
});
//////////////////////////////////////////////////////
/////////////////////////////////////////////////////

function prorrogaRedirect(){
    var tienda_actual = $('#tienda_actual').val();
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    var url = urlBase.make("contrato/prorrogar");
    if(valueId.split("/")[1] == tienda_actual){
        updateRowDatatableAction(url);
    }else{
        confirm.setTitle('Alerta');
        confirm.setSegment("La tienda a la que le realizará la prorroga no es la misma en la que se encuentra ubicado, ¿desea continuar?");
        confirm.show();

        confirm.setFunction(function() {
            updateRowDatatableAction(url);
        });
    }
}
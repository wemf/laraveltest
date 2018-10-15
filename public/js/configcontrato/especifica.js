$(document).ready(function(){
    $('#col7_filter').change(function () {
        var id = $('#col7_filter').val();
        var url2 = urlBase.make('departamento/getdepartamentobypais') + "/" + id;
        loadSelectInput('#col8_filter', url2, true);

        url2 = urlBase.make('zona/getSelectListZonaPais') + "/" + id;
        loadSelectInput('#col1_filter', url2, true);

        if( id != '' ) {
            url3 = urlBase.make('tienda/getTiendaByPais') + "/" + id;
        }else{
            url3 = urlBase.make('tienda/getSelectList');
        }
        loadSelectInput('#col2_filter', url3, true);
    });   

    $('#col7_filter').change();

    var url3 = urlBase.make('clientes/tipodocumento/getSelectList2');
    loadSelectInput('#col5_filter', url3, true);

    $('#col8_filter').change(function() {
        var id = $(this).val();
        var url2 = urlBase.make('ciudad/getciudadbydepartamento') + "/" + id;
        loadSelectInput('#col0_filter', url2, true);
    });

    $('#col0_filter').change(function() {
        var id = $(this).val();
        var url2;
        
        if( id != '' ) {
            url2 = urlBase.make('tienda/getTiendaByCiudad') + "/" + id;
        }else{
            url2 = urlBase.make('tienda/getSelectList');
        }
        loadSelectInput('#col2_filter', url2, true);
    });

    $('#col8_filter').change(function() {
        var id = $(this).val();
        var url2;
        
        if( id != '' ) {
            url2 = urlBase.make('tienda/getTiendaByDepartamento') + "/" + id;
        }else{
            url2 = urlBase.make('tienda/getSelectList');
        }
        loadSelectInput('#col2_filter', url2, true);
    });
});
$(document).ready(function(){
    $('#col0_filter').change(function () { // pais
        var id = $('#col0_filter').val(); // pais
        var url2 = urlBase.make('departamento/getdepartamentobypais') + "/" + id;
        loadSelectInput('#col1_filter', url2, true); // departamento

        if( id != '' ) {
            url3 = urlBase.make('tienda/getTiendaByPais') + "/" + id;
        }else{
            url3 = urlBase.make('tienda/getSelectList');
        }
        loadSelectInput('#col3_filter', url3, true);
        loadSelectInput('#col2_filter', url3, true);
    });   

    $('#col0_filter').change(); // pais

    $('#col1_filter').change(function() { // departamento
        var id = $(this).val();
        var url2 = urlBase.make('ciudad/getciudadbydepartamento') + "/" + id;
        loadSelectInput('#col2_filter', url2, true); // ciudad
    });

    $('#col2_filter').change(function() { // ciudad
        var id = $(this).val();
        var url2;
        
        if( id != '' ) {
            url2 = urlBase.make('tienda/getTiendaByCiudad') + "/" + id;
        }else{
            url2 = urlBase.make('tienda/getSelectList');
        }
        loadSelectInput('#col3_filter', url2, true); // tienda
    });

    $('#col1_filter').change(function() { // departamento
        var id = $(this).val();
        var url2;
        
        if( id != '' ) {
            url2 = urlBase.make('tienda/getTiendaByDepartamento') + "/" + id;
        }else{
            url2 = urlBase.make('tienda/getSelectList');
        }
        loadSelectInput('#col3_filter', url2, true); // tienda
    });
});
function saveItem( url ) {
    var atributos = {};
    var positions = {};
    var requireds = {};
    var cont = 0;
    $( '.check-pos:checked' ).each( function () {
        var id = $( this ).data( 'id' );
        var pos = $( '#pos-' + id ).val();
        atributos[ cont ] = id;
        positions[ cont ] = pos;
        if ( $( '#attr-required-' + id ).prop( 'checked' ) == true ) {
            requireds[ cont ] = 1;
        } else {
            requireds[ cont ] = 0;
        }
        cont++;
    });

    $.ajax(
        {
            headers: { 'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' ) },
            url: url,
            type: 'POST',
            async: false,
            dataType: 'JSON',
            data:
            {
                atributos: atributos,
                posiciones: positions,
                requeridos: requireds,
                nombre: $( '#nombre' ).val(),
                categoria: $( '#categoria' ).val(),
            },
            success: function (datos) {
                console.log(datos);
                if(datos.val == false){
                    Alerta('Alerta', datos.msm, 'warning');
                }else{
                    Alerta('Guardado', "Item para contrato guardado correctamente", 'success');
                    pageAction.redirect(URL.getUrlList(),2);
                }
                
            },
        }
    );
}

function updateItem( url ) {
    var atributos = {};
    var positions = {};
    var requireds = {};
    var cont = 0;
    $('.check-pos:checked').each(function () {
        var id = $(this).data('id');
        var pos = $('#pos-' + id).val();
        atributos[cont] = id;
        positions[cont] = pos;
        if ($('#attr-required-' + id).prop('checked') == true) {
            requireds[cont] = 1;
        } else {
            requireds[cont] = 0;
        }
        cont++;
    });

    $.ajax(
        {
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: url,
            type: 'POST',
            async: false,
            dataType: 'JSON',
            data:
            {
                atributos: atributos,
                posiciones: positions,
                requeridos: requireds,
                nombre: $('#nombre').val(),
                categoria: $('#categoria').val(),
                id: $('#id').val(),
            },
            success: function (datos) {
                Alerta('Actualizado', "Item para contrato actualizado correctamente", 'success');
                pageAction.redirect(URL.getUrlList(),2);
            },
        }
    );
}

function loadAttributes(url) {
    $('#atributos').html('');
    $.ajax(
        {
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: url,
            type: 'GET',
            async: false,
            dataType: 'JSON',
            data:
            {
                id: $('#categoria').val()
            },
            success: function (datos) {
                jQuery.each(datos, function (indice, datos) {
                    $('#atributos').append(
                        (
                            '<li onmouseup="positions(this, \'text\', 100);" class="ui-state-default" style="cursor: ns-resize;">' +
                            '<div style="display: inline-block;">' +
                            '<input type="checkbox" onchange="positions(this, \'checkbox\');" id="attr-' + datos.id + '" data-id="' + datos.id + '"  class="check-control check-pos" />' +
                            '<label for="attr-' + datos.id + '" class="lbl-check-control" style="font-size: 16px; font-weight: 100; margin-top: 5px;">' + datos.nombre + '</label>' +
                            '</div>' +
                            '<div style="float:right; height: 25px; margin-top: 5px; margin-right: 15px;">' +
                            '<input onblur="positions(this, \'text\');" style="width: 23px; margin-left: 15px; display: block;" type="text" id="pos-' + datos.id + '" class="text-control" disabled/>' +
                            '<label></label>' +
                            '</div>' +
                            '<div style="display: inline-block;float:right;margin-right: 20px;">' +
                            '<input type="checkbox" id="attr-required-' + datos.id + '" data-id="' + datos.id + '"  class="check-control check-required" disabled />' +
                            '<label for="attr-required-' + datos.id + '" class="lbl-check-control" style="font-size: 16px; font-weight: 100; margin-top: 5px;"></label>' +
                            '</div>' +
                            '</li>'
                        )
                    );
                });
            },
        }
    );
}

function getAttributes( url ){
    $.ajax(
        {
            headers: { 'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' ) },
            url: url,
            type: 'GET',
            async: false,
            dataType: 'JSON',
            data:
            {
                id: $( '#id' ).val()
            },
            success: function ( datos ) {
                jQuery.each( datos, function ( indice, datos ) {
                    $( '.check-pos' ).each( function(){
                        var id = $( this ).data( 'id' );
                        if( id == datos.id_atributo ){
                            $( this ).click();
                            if( parseInt( datos.obligatorio ) == 1 ){
                                $( '#attr-required-' + id ).click();
                            }
                        }
                    });
                });
            },
        }
    );
}

function positions(element, type, time = 0) {
    if (type == "checkbox") {
        var id = $(element).data('id');
        if ($(element).prop('checked')) {
            $('#pos-' + id).attr('disabled', false);
            $('#attr-required-' + id).attr('disabled', false);
        } else {
            $('#pos-' + id).attr('disabled', true);
            $('#attr-required-' + id).attr('disabled', true);
            $('#attr-required-' + id).attr('checked', false);
            $('#pos-' + id).val('');
        }
    }
    setTimeout(function () {
        var cont = 1;
        $('.check-pos:checked').each(function () {
            var id = $(this).data('id');
            $('#pos-' + id).val(cont++);
        });
    }, time);;
}
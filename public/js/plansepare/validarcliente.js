$(document).ready(function () {
    $('#element_doc_1').focus();

    $('#element_doc_10').change(function () {
        $.ajax({
            url: urlBase.make('creacioncontrato/verificacionclientewebservice'),
            type: "get",
            async: false,
            data: {
                action: "cliente",
                tipodocumento: $('select[name="tipodocumento_documento"]').val(),
                numdocumento: $('#element_doc_3').val()
            },
            success: function (datos) {
                datos = JSON.parse(datos);
                if (datos.state) {
                    if (datos.codigo != 002) {
                        Alerta('¡Alerta!', "Cliente no puede generar plan separe", type = 'error');
                        $('#element_doc_1').val('');
                        $('#element_doc_2').val('');
                        $('#element_doc_3').val('');
                        $('#element_doc_4').val('');
                        $('#element_doc_5').val('');
                        $('#element_doc_6').val('');
                        $('#element_doc_7').val('');
                        $('#element_doc_8').val('');
                        $('#element_doc_9').val('');
                        $('#element_doc_10').val('');
                        $('#element_doc_1').focus();
                    } else {
                        idTipoDocumento = $('select[name="tipodocumento_documento"] option:selected').data('id');
                        numDocumento = ($('#element_doc_3').val().trim() == '') ? ' ' : parseInt($('#element_doc_3').val().trim());
                        primer_apellido = ($('#element_doc_4').val().trim() == '') ? ' ' : $('#element_doc_4').val().trim();
                        segundo_apellido = ($('#element_doc_5').val().trim() == '') ? ' ' : $('#element_doc_5').val().trim();
                        primer_nombre = ($('#element_doc_6').val().trim() == '') ? ' ' : $('#element_doc_6').val().trim();
                        segundo_nombre = ($('#element_doc_7').val().trim() == '' || $('#element_doc_7').val().trim() == null) ? ' ' : $('#element_doc_7').val().trim();
                        fecha_nacimiento = ($('#element_doc_9').val().trim() == '') ? ' ' : $('#element_doc_9').val().trim();
                        genero = ($('#element_doc_8').val().trim() == '') ? ' ' : $('#element_doc_8').val().trim();
                        rh = ($('#element_doc_10').val().trim() == '') ? ' ' : $('#element_doc_10').val().trim();
                        parametros = idTipoDocumento + "/" +
                            numDocumento + "/" +
                            primer_apellido + "/" +
                            segundo_apellido + "/" +
                            primer_nombre + "/" +
                            segundo_nombre + "/" +
                            fecha_nacimiento + "/" +
                            genero + "/" +
                            rh;
                        pageAction.redirect('../generarplan/' + parametros);
                    }
                }
            }
        });
    });

    $('#tipodocumento_documento').change(function () {
        $('#element_doc_1').focus();
    });
});

var vcliente = (function () {
    return {
        clienteManual: function () {
            var completo = true;
            $('.modal-manual .requerido').each(function () {
                if ($(this).val() == "") {
                    completo = false;
                    $(this).css('border', '1px solid rgba(255,0,0,0.7)');
                    $(this).css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
                } else {
                    $(this).css('border', '1px solid #ccc');
                    $(this).css('box-shadow', 'none');
                }
            });

            if (completo) {
                var parametros = $('#tipodocumento_manual').val() + "/" + $('#numdocumento').val();
                pageAction.redirect('../generarplan/' + parametros);
            }
        }
    }
})();

function Alerta(title, text, type) {
    new PNotify({
        title: title,
        text: text,
        type: type
    });
}
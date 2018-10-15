var guia = (function(){
    return {
        paso1: function(){
            var pas = true;
            if ($('#id_tienda').val() == "" || $('#id_tienda').val() == null) {
                $('#id_tienda').focus();
                $('#tool').remove();
                $('#id_tienda').after('<div class="tool tool-visible" id="tool"><p>Este campo es requerido para poder continuar</p></div>');
                pas = false;
                return pas;
            }

            if (valSec1() && pas) {
                valCont('1', '2')

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: urlBase.make('contrato/logistica/getSedePrincipal'),
                    type: 'get',
                    data: {
                        id: $('#id_tienda').val()
                    },
                    success: function (datos) {
                        var sede_principal = datos.sede_principal;
                        var tienda_padre = datos.tienda_padre;
                        if (sede_principal == "1" || tienda_padre == "0") {
                            $('#pasa_tienda').css('display', 'none');
                        }
                        if (sede_principal == "0" && tienda_padre != "0") {
                            $('#pasa_tienda').css('display', 'block');
                        }
                    }
                });
            }
        },
        paso2: function(){
            var datosrelaciones = {};
            var cont = 0;

            $('.ms-selection .ms-selected').each(function () {
                datosrelaciones[cont++] = $(this).find('span').data('value');
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlBase.make('contrato/logistica/create'),
                type: 'post',
                data: {
                    id_tienda: $('#id_tienda').val(),
                    datosrelaciones: datosrelaciones,
                    user_bodega: $('#user_bodega').val(),
                    bodega_envio: $('#bodega_envio').val(),
                    id_tienda_envio: $('#id_tienda_envio').val(),
                    user_tienda_principal: $('#user_tienda_principal').val()
                },
                success: function (datos) {
                    $('#error').html(datos);
                    console.log(datos.msm);
                    if (datos.val == "Error") {
                        Alerta('Error', datos.msm, 'error');
                    } else if (datos.val == "Insertado") {
                        retornar = datos.val;
                        Alerta('Información', datos.msm);
                        pageAction.redirect(urlBase.make('contrato/logistica'), 1.5);
                    } else if (datos.val == "Actualizado") {
                        alert('3');
                        retornar = datos.val;
                        Alerta('Información', datos.msm);
                        pageAction.redirect(urlBase.make('contrato/logistica'), 1.5);
                    } else if (datos.val == "ErrorUnico") {
                        alert('4');
                        Alerta('Alerta', datos.msm, 'Notice')
                    }
                },
                error: function (datos) {
                    $('#error').html(datos.responseText);
                }
            });
        },
        confirmarAnular: function(){
            var pas = true;
            if ($('#observaciones').val() == "" || $('#observaciones').val() == null) {
                $('#observaciones').focus();
                $('#tool').remove();
                $('#observaciones').after('<div class="tool tool-visible" id="tool"><p>Este campo es requerido para poder continuar</p></div>');
                pas = false;
                return pas;
            }

            if (pas) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: urlBase.make('contrato/logistica/anularGuia'),
                    type: 'post',
                    data: {
                        id: $('#id').val(),
                        destino: $('#destino').val(),
                        observaciones: $('#observaciones').val(),
                    },
                    success: function (datos) {
                        console.log(datos.msm);
                        if (datos.val == "Error") {
                            Alerta('Error', datos.msm, 'error');
                        } else if (datos.val == "Insertado") {
                            retornar = datos.val;
                            Alerta('Información', datos.msm);
                            pageAction.redirect(urlBase.make('contrato/logistica'), 1.5);
                        } else if (datos.val == "Actualizado") {
                            alert('3');
                            retornar = datos.val;
                            Alerta('Información', datos.msm);
                            pageAction.redirect(urlBase.make('contrato/logistica'), 1.5);
                        } else if (datos.val == "ErrorUnico") {
                            alert('4');
                            Alerta('Alerta', datos.msm, 'Notice')
                        }
                    }
                });
            }
        },
        confirmarProceso: function(){
            var pas = true;
            if ($('#observaciones').val() == "" || $('#observaciones').val() == null) {
                $('#observaciones').focus();
                $('#tool').remove();
                $('#observaciones').after('<div class="tool tool-visible" id="tool"><p>Este campo es requerido para poder continuar</p></div>');
                pas = false;
                return pas;
            }

            if (pas) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: urlBase.make('contrato/logistica/seguimientoGuia'),
                    type: 'post',
                    data: {
                        id: $('#id').val(),
                        destino: $('#destino').val(),
                        observaciones: $('#observaciones').val(),
                        id_estado: $('#id_estado').val(),
                        id_motivo: $('#id_motivo').val(),
                    },
                    success: function (datos) {
                        console.log(datos);
                        if (datos.val == "Error") {
                            Alerta('Error', datos.msm, 'error');
                        } else if (datos.val == "Insertado") {
                            retornar = datos.val;
                            Alerta('Información', datos.msm);
                            pageAction.redirect(urlBase.make('contrato/logistica'), 1.5);
                        } else if (datos.val == "Actualizado") {
                            alert('3');
                            retornar = datos.val;
                            Alerta('Información', datos.msm);
                            pageAction.redirect(urlBase.make('contrato/logistica'), 1.5);
                        } else if (datos.val == "ErrorUnico") {
                            alert('4');
                            Alerta('Alerta', datos.msm, 'Notice')
                        }
                    }
                });
            }
        }
    }
})();

$(document).ready(function(){
    $('#g1').click(function () {
        guia.paso1();
    });

    $('#g2').click(function () {
        guia.paso2();
    });

    $('#anularConfir').click(function () {
        guia.confirmarAnular();
    });

    $('#confirm_process').click(function () {
        guia.confirmarProceso();
    });

    $('#id_tienda').click(function () {
        $('.limpiar').val('');
    });
    
    $('#observaciones').on('keypress', function () {
        $('#tool').remove();
    });
    
    $('#confirm_prog').click(function () {
        $('#gridSystemModalLabel').text('Confirmar programación de envio');
    });
    
    $('#confirm_prog_principal').click(function () {
        $('#gridSystemModalLabel').text('Confirmar programación de envio');
    });
    
    $('#confirm_envio').click(function () {
        $('#gridSystemModalLabel').text('Confirmar envio');
    });
    
    $('#confirm_entrega').click(function () {
        $('#gridSystemModalLabel').text('Aceptar envio');
    });

    fillSelect('#id_tienda', '#id_resolucion', urlBase.make('contrato/logistica/getResolucionesById'), false);

    $('#id_tienda_envio').change(function () {
        fillSelect('#id_tienda_envio', '#user_tienda_principal', urlBase.make('contrato/logistica/getEmpleadosTienda'), false);
    });

    $('#bodega_envio').change(function () {
        fillSelect('#bodega_envio', '#user_bodega', urlBase.make('contrato/logistica/getEmpleadosTienda'));
    });

    $('#id_resolucion').multiSelect({
        selectableHeader: "<div class='custom-header'>Resoluciones Sistema</div>",
        selectionHeader: "<div class='custom-header'>Resoluciones Asociadas</div>",
    });

    $('#btn-seguimiento').click(function () {
        var url = urlBase.make('contrato/logistica/seguimiento');
        updateRowDatatableAction(url)
    });

    $('#btn-trazabilidad').click(function () {
        var url = urlBase.make('contrato/logistica/trazabilidad');
        updateRowDatatableAction(url)
    });

    $('#btn-anular').click(function () {
        var url = urlBase.make('contrato/logistica/anular');
        updateRowDatatableAction(url)
    });

    $('#id_pais').change(function () {
        fillSelect('#id_pais', '#id_departamento', urlBase.make('pais/getSelectListPais'));
    });

    $('#id_departamento').change(function () {
        fillSelect('#id_departamento', '#id_ciudad', urlBase.make('/departamento/getSelectListDepartamento'));
    });
});

function valCont(step, step2) {
    $('#step-' + step + 'Btn').hide();
    $('#step-' + step).hide();
    $('#step-' + step2).show();
    $('#step-' + step2 + 'Btn').show();
    $('#st' + step).removeClass('btn-primary');
    $('#st' + step).addClass('btn-default');
    $('#st' + step2).addClass('btn-primary');
}

function valSec1() {
    var bandera = true;
    var datosasociados = {};
    var cont = 0;

    $('.ms-selection .ms-selected').each(function () {
        datosasociados[cont++] = $(this).find('span').data('value');
    });
    if (cont < 1) {
        $('#ms-id_resolucion').after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
        bandera = false;
    } else {
        $('#tool').remove();
        bandera = true;
    }

    return bandera;
}

function envio(e) {
    fillSelectX($(e).val(), '#bodega_envio', urlBase.make('contrato/logistica/getSelectListByTipe'), true, '#id_ciudad', '#id_tienda');
}

function fillSelectX(idtarget, idrequested, url, inputDefaul = true, param2, id_tienda) {
    var city = $(param2).val();
    var id_tienda = $(id_tienda).val();
    $(idrequested).find('option').remove();
    if (inputDefaul) {
        $(idrequested).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url,
        type: 'GET',
        async: false,
        data: {
            city: city,
            tipe: idtarget,
            id_tienda: id_tienda
        },
        success: function (datos) {
            console.log(datos);
            jQuery.each(datos, function (indice, valor) {
                $(idrequested).append($('<option>', {
                    value: valor.id,
                    text: valor.name
                }))
            });
        },
        error: function (request, status, error) {
            Alerta('Error', 'No se pudo realizar la operación.', 'error')
        }
    });
}
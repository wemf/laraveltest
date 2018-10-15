var URL_CLIENTE = (function() {
    //variable global
    var url_cliente = {};
    url_cliente.getURLValidarDocumento = '';
    url_cliente.getEmpleadoActualizar = '';
    url_cliente.getPersonaNaturalActualizar = '';
    url_cliente.getProveedorNaturalActualizar = '';
    url_cliente.getActualizarThis = '';
    return {
        setURLValidarDocumento: function(url3) {
            url_cliente.getURLValidarDocumento = url3;
        },
        getURLValidarDocumento: function() {
            return url_cliente.getURLValidarDocumento;
        },

        setEmpleadoActualizar: function(url3) {
            url_cliente.getEmpleadoActualizar = url3;
        },
        getEmpleadoActualizar: function() {
            return url_cliente.getEmpleadoActualizar;
        },

        setPersonaNaturalActualizar: function(url3) {
            url_cliente.getPersonaNaturalActualizar = url3;
        },
        getPersonaNaturalActualizar: function() {
            return url_cliente.getPersonaNaturalActualizar;
        },

        setProveedorNaturalActualizar: function(url3) {
            url_cliente.getProveedorNaturalActualizar = url3;
        },
        getProveedorNaturalActualizar: function() {
            return url_cliente.getProveedorNaturalActualizar;
        },

        setActualizarThis: function(url3) {
            url_cliente.getActualizarThis = url3;
        },
        getActualizarThis: function() {
            return url_cliente.getActualizarThis;
        },
    }
})();


/*-- ------------------------------------------------------ ---
     FUNCIÓN PARA VALIDAR SI EL DOCUMENTO INGRESADO, EXISTE
---- ------------------------------------------------------ -*/

$('.verificar_documento').blur(function() {
    if ($('input[name="id_tipo_cliente"]').val() == 3 || $('input[name="id_tipo_cliente"]').val() == 5) {
     validarDocumento(this);
    }
});

function validarDocumento(campo) {
    var id_tipo_documento = $('#id_tipo_documento').val();
    var tipo_documento = $('#id_tipo_documento option:selected').text();
    var numero_documento = campo.value;
    var data = {
        tipo_documento: id_tipo_documento,
        numero_documento: numero_documento
    };

     if (id_tipo_documento > 0 && numero_documento != '') {
        var retorno = getAjaxGeneral(data, URL_CLIENTE.getURLValidarDocumento().trim());
        var tipo_de_cliente = '';
        if (retorno != null && retorno != '') {
            var ruta = URL_CLIENTE.getActualizarThis().trim() + "/" + retorno.codigo_cliente + "/" + retorno.id_tienda + "/" + retorno.id_tipo_cliente;
            switch (retorno.id_tipo_cliente) {
                case 1:
                    tipo_de_cliente = 'Empleado-Tienda';
                    // ruta = URL_CLIENTE.getEmpleadoActualizar().trim() + "/" + retorno.codigo_cliente + "/" + retorno.id_tienda + "/" + retorno.id_tipo_cliente;
                    break;
                case 2:
                    tipo_de_cliente = 'Empleado-Sociedad';
                    // ruta = URL_CLIENTE.getEmpleadoActualizar().trim() + "/" + retorno.codigo_cliente + "/" + retorno.id_tienda + "/" + retorno.id_tipo_cliente;

                    break;
                case 3:
                    tipo_de_cliente = 'Cliente Persona Natural';
                    // ruta = URL_CLIENTE.getPersonaNaturalActualizar().trim() + "/" + retorno.codigo_cliente + "/" + retorno.id_tienda + "/" + retorno.id_tipo_cliente;

                    break;
                case 5:
                    tipo_de_cliente = 'Cliente Persona Jurídica';
                    // ruta = URL_CLIENTE.getProveedorNaturalActualizar().trim() + "/" + retorno.codigo_cliente + "/" + retorno.id_tienda + "/" + retorno.id_tipo_cliente;
                    break;
                default:
                    break;
            }
            campo.focus();
            confirm.setTitle('Aviso');
            confirm.setSegment('El tipo de documento: ' + tipo_documento + ' y el número de documento: ' + numero_documento + ', ya se encuentran en el sistema. Pertenecen a una Persona ' + tipo_de_cliente + ' ¿Desea cargar su información y convertirlo en Cliente?');
            confirm.show();
            console.log("retorno");
            $('#confirmSuccess').click(function() {
                pageAction.redirect(ruta);
            })
        }
    }
    return false;
}
/*-- ------------------------------------------------------ ---
---- ------------------------------------------------------ -*/

/*-- ----------------------------------------- ---
     FUNCIONES PARA CLONAR FILAS Y SUS EVENTOS
---- ----------------------------------------- --*/
var count = 1;
$('.btn-agregar-fila').click(function() {
    var padre = $(this).parent();
    var contenido = padre.find('.tr-contenido:first');
    var clonacion = contenido.clone();
    $(clonacion).html($(clonacion).html().replace('id="direccion_emergencia_1"', `id="direccion_emergencia_${++count}"`).replace('data-post="1"', `data-post = "${count}"`));
    $(clonacion).find('#fecha_terminacion_estudios').removeAttr('disabled');
    clonacion.appendTo(contenido.parent());
    var contenido_nuevo = padre.find('.tr-contenido:last');
    contenido_nuevo.find('input,textarea').val('').attr('checked', false);
    refreshClick('borrar-fila', borrarFil);
    refreshClick('direccion', mostrarDireccion);
    refreshClick('data-picker-only', DatePush);
    refreshChange('estudio_finalizado', disabledField);
    refreshChange('fecha_fin', validarFechaFinal);
    refreshBlur('fecha_fin', validarFechaFinal);
});

function DatePush(Check)
{
    $('.data-picker-only').datetimepicker({
        pickTime: false,
        minView: 2,
        format: 'yyyy-mm-dd',
        startDate: new Date(1900, 01, 01),
        autoclose: true,
    });
}

function refreshClick(itmClass, fun) {
    var myEl = document.querySelectorAll('.' + itmClass);
    [].forEach.call(myEl, function(myEls) {
        myEls.addEventListener('click', fun, false);
    });
}

function refreshChange(itmClass, fun) {
    var myEl = document.querySelectorAll('.' + itmClass);
    [].forEach.call(myEl, function(myEls) {
        myEls.addEventListener('change', fun, false);
    });
}

function refreshBlur(itmClass, fun) {
    var myEl = document.querySelectorAll('.' + itmClass);
    [].forEach.call(myEl, function(myEls) {
        myEls.addEventListener('blur', fun, false);
    });
}

function borrarFil() {
    var campo = this;
    var tabla = $(this).closest('table');
    var contador = tabla.find('.tr-contenido').length;
    confirm.setTitle('Aviso');
    confirm.setSegment('¿Realmente desea eliminar el registro?');
    confirm.show();
    $('#confirmSuccess').click(function() {
        if (contador > 1)
            $(campo).closest('tr').remove();
        else
            $(campo).closest('tr').find('input,select').val('').attr('checked', false);
    });
}

function validarFechaFinal() {
    var fecha_inicio = $(this).closest('tr').find('.fecha_inicio');
    if (fecha_inicio.val() >= $(this).val()) {
        $(this).closest('td').focus();
        $('#tool').remove();
        $(this).after('<div class="tool tool-visible" style="clear:both" id="tool"><p>La Fecha Final debe ser mayor a la Fecha inicial</p></div>');
        bandera = false;
    } else {
        $('#tool').remove();
    }

}

function mostrarDireccion() {
    var id = $(this).prop('id');
    var posinput = $('#' + id).data('pos');
    direccion.show(id, posinput);
    $('#resultado').val($(this).val());

    if (direccion.getArray()[posinput] != undefined) {

        var arrayPush = direccion.getArray()[posinput];
        $('#via').val(arrayPush['p1']);
        $('#numero').val(arrayPush['p2']);
        $('#letracruce1').val(arrayPush['p3']);
        $('#puntocardinal1').val(arrayPush['p4']);
        $('#interseccion').val(arrayPush['p5']);
        $('#letracruce2').val(arrayPush['p6']);
        $('#puntocardinal2').val(arrayPush['p7']);
        $('#numero2').val(arrayPush['p8']);
        $('#puntocardinal3').val(arrayPush['p9']);
        $('#numero3').val(arrayPush['p10']);
    }
}

function disabledField() {
    var fecha_finalizacion = $(this).closest('tr').find('.fecha_terminacion_estudios');
    if (fecha_finalizacion) {
        if (this.value != 1) {
            fecha_finalizacion.removeAttr('disabled');
        } else {
            fecha_finalizacion.attr('disabled', true);
            fecha_finalizacion.siblings('div.tool').remove();
            fecha_finalizacion.val('');
        }
    }
}

refreshClick('borrar-fila', borrarFil);
refreshChange('estudio_finalizado', disabledField);
refreshBlur('fecha_fin', validarFechaFinal);
// refreshClick('direccion', mostrarDireccion);
/*-- --------------------------------------- ----
---- --------------------------------------- --*/


/*-- ----------------------------------------------------------------------------------- ---
     FUNCIÓN PARA VERIFICAR SI EL PAÍS SELECCIONADO, ES EL MISMO DE PARÁMETROS GENERALES
---- ----------------------------------------------------------------------------------- --*/

$('.id_pais_parametro').change(function() {
    verificarPaisParametro($(this));
});

function verificarPaisParametro(campo) {
    var flag = false;
    var sufijo = campo.attr('data-sufijo');
    var id_pais = campo.val();
    var url2 = urlBase.make('/clientes/empleado/getparametroGeneral');
    var retorno = getAjaxGeneral(id_pais, url2);
    if (jQuery.isEmptyObject(retorno)) {
        campo.attr('data-parametro', 0);
        $('#id_dep_' + sufijo + ',#id_ciu_' + sufijo).attr('disabled', true);
        $('#id_dep_' + sufijo + ',#id_ciu_' + sufijo).removeClass('requiered');
    } else {
        campo.attr('data-parametro', 1);
        $('#id_dep_' + sufijo + ',#id_ciu_' + sufijo).attr('disabled', false);
        $('#id_dep_' + sufijo + ',#id_ciu_' + sufijo).addClass('requiered');
        flag = true;
    }

    if (sufijo == 'nacimiento') {
        valLibretaMilitar(flag);
    }

}

/*-- ----------------------------------------------------------------------------------- ----
---- ----------------------------------------------------------------------------------- --*/


/*-- ------------------------------------------------------------------------------------------- ---
     FUNCIÓN PARA VALIDAR QUE LA LIBRETA MILITAR SEA OBLIGATORIA CON EL PAÍS DE PARAM. GENERALES
---- ------------------------------------------------------------------------------------------ --*/

$('#genero').change(function() {
    var paisParametro = $('#id_pais_nacimiento').attr('data-parametro');
    if ($(this).val() == 2) {
        $('#libreta_militar,#distrito_militar').attr('disabled', true).val('');
        $('#libreta_militar,#distrito_militar').removeClass('obligatorio requiered');
    } else {
        if (paisParametro == 1) {
            $('#libreta_militar, #distrito_militar').addClass('obligatorio requiered');
        } else {
            $('#libreta_militar,#distrito_militar').removeClass('obligatorio requiered');
        }
        $('#libreta_militar,#distrito_militar').removeAttr('disabled');
    }
});

function valLibretaMilitar(flag) {
    var genero = $('#genero').val();
    if (genero == 1) {
        if (flag) {
            $('#libreta_militar,#distrito_militar').removeAttr('disabled');
            $('#libreta_militar, #distrito_militar').addClass('obligatorio requiered');
        } else {
            $('#libreta_militar, #distrito_militar').removeClass('obligatorio requiered');
        }
    }
}

/*-- ----------------------------------------------------------------------------------- ----
---- ----------------------------------------------------------------------------------- --*/

/*-- ------------------------------------------------------------------ ---
     FUNCIÓN PARA DESHABILITAR LUGAR DE EXPEDICIÓN CON PASAPORTE Y VISA
---- ------------------------------------------------------------------ --*/

$('#id_tipo_documento').change(function() {
    desabilitarExpedicion($(this).val());
})


function desabilitarExpedicion(id) {
    var id_pais_expedicion = $('#id_pais_exp').attr('data-parametro');
    if (id == 12 || id == 37) {
        if (id_pais_expedicion != 1) {
            $('#id_dep_exp,#id_ciu_exp').val('').attr('disabled', true);
        }
    } else {
        if (id_pais_expedicion == 1) {
            $('#id_dep_exp,#id_ciu_exp').val('').attr('disabled', false);
        }
    }
}

$('#id_pais_exp').change(function() {
    quitarDocumento($(this));
})

function quitarDocumento(campo) {
    var id_pais_expedicion = $(campo).attr('data-parametro');
    if (id_pais_expedicion == 1) {
        $('#id_tipo_documento option[value="12"] ,' + '#id_tipo_documento option[value="37"]').css('display', 'none');
    } else {
        $('#id_tipo_documento option[value="12"] ,' + '#id_tipo_documento option[value="37"]').css('display', 'block');
    }
}

$(document).ready(function(){
    $(document).resize();
  }); 

/*-- ------------------------------------------------------------------ ---
---- ------------------------------------------------------------------ --*/
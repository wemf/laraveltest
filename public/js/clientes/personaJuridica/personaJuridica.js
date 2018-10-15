//Carga las URL necesarias para que funcione la persitencia
var URL = (function() {
    //variable global
    var url = {};
    url.getList = '';
    url.getListById = '';
    url.getUpdateAction = '';
    url.getDeletedAction = '';
    url.getCompleteEmpleados = '';
    url.getAction = '';
    url.getUrlListTipoDoc = '';
    url.getTipoDocumento = '';

    return {
        setUrlList: function(url2) {
            url.getList = url2;
        },
        getUrlList: function() {
            return url.getList;
        },
        setUrlListById: function(url2) {
            url.getListById = url2;
        },
        getUrlListById: function() {
            return url.getListById;
        },
        setUpdateAction: function(url2) {
            url.getUpdateAction = url2;
        },
        getUpdateAction: function() {
            return url.getUpdateAction;
        },
        setDeletedAction: function(url2) {
            url.getDeletedAction = url2;
        },
        getDeletedAction: function() {
            return url.getDeletedAction;
        },
        setCompleteEmpleados: function(url2) {
            url.getCompleteEmpleados = url2;
        },
        getCompleteEmpleados: function() {
            return url.getCompleteEmpleados;
        },
        setAction: function(url2) {
            url.getAction = url2;
        },
        getAction: function() {
            return url.getAction;
        },
        setUrlListTipoDoc: function(url2) {
            url.getUrlListTipoDoc = url2;
        },
        getUrlListTipoDoc: function() {
            return url.getUrlListTipoDoc;
        },
        setDate: function(date2) {
            url.date = date2;
        },
        getDate: function() {
            return url.date;
        },
        setEmpleado: function(empleado2) {
            url.empleado = empleado2;
        },
        getEmpleado: function() {
            return url.empleado;
        },
        setEmpleadoActu: function(empleadoA2) {
            url.empleadoA = empleadoA2;
        },
        getEmpleadoActu: function() {
            return url.empleadoA;
        },
        setActionUser: function(user2) {
            url.user = user2;
        },
        getActionUser: function() {
            return url.user;
        },
        setActionUser2: function(user3) {
            url.user2 = user3;
        },
        getActionUser2: function() {
            return url.user2;
        },
        setUser: function(userxx) {
            url.userx = userxx;
        },
        getUser: function() {
            return url.userx;
        },
        setCombos: function(combo2) {
            url.combo = combo2;
        },
        getCombos: function() {
            return url.combo;
        },
        setVar: function(var2) {
            url.var = var2;
        },
        getVar: function() {
            return url.var;
        },
        setTiendaZona: function(zona2) {
            url.zona = zona2;
        },
        getTiendaZona: function() {
            return url.zona;
        },
        setTipoDocumento: function(zona2) {
            url.getTipoDocumento = zona2;
        },
        getTipoDocumento: function() {
            return url.getTipoDocumento;
        },
    }
})();


$(function() {
    $("#tabs").tabs();
});


function runPersistenceForm() {
    loadSelectTable(".id_contrato", URL.getUrlList(), 2, 'tipo_contrato');
    loadSelectTable(".id_pais", URL.getUrlList(), 2, 'pais');
    loadSelectTable(".id_ciudad", URL.getUrlList(), 2, 'ciudad');
    loadSelectTable(".id_cargo_empleado", URL.getUrlList(), 2, 'cargo_empleado');
    loadSelectTable("#id_estado_civil", URL.getUrlList(), 2, 'estado_civil');
    loadSelectTable("#id_tipo_vivienda", URL.getUrlList(), 2, 'tipo_vivienda');
    loadSelectTable("#id_tenencia_vivienda", URL.getUrlList(), 2, 'tenencia_vivienda');
    loadSelectTable("#id_caja_compensacion", URL.getUrlList(), 2, 'caja_compensacion');
    loadSelectTable(".id_tienda", URL.getUrlList(), 2, 'tienda');
    loadSelectTable("#id_tipo_cliente", URL.getUrlList(), 2, 'tipo_cliente', );
    loadSelectTable("#id_fondo_cesantias", URL.getUrlList(), 2, 'fondo_cesantias');
    loadSelectTable("#id_fondo_pensiones", URL.getUrlList(), 2, 'fondo_pensiones');
    loadSelectTable(".id_eps", URL.getUrlList(), 2, 'eps');
    loadSelectTable(".id_tipo_parentesco", URL.getUrlList(), 2, 'tipo_parentesco');
    loadSelectTable(".id_nivel_estudio", URL.getUrlList(), 2, 'nivel_estudio');
    loadSelectTable(".id_motivo_retiro", URL.getUrlList(), 2, 'motivo_retiro');

}


$('#id_pais_residencia').change(function() {
    var id = $(this).val();
    var url = urlBase.make('departamento/getdepartamentobypais') + "/" + id;
    loadSelectInput('#id_dep_residencia',url,true);
});

$('#id_dep_residencia').change(function() {
    var url = urlBase.make('/ciudad/getciudadbydepartamento')
    fillSelect('#id_dep_residencia', '#id_ciu_residencia', url,true);
});

$('#id_ciu_residencia').change(function(){
    fillInput('#id_ciu_residencia','.telefono_indicativo',urlBase.make('ciudad/getinputindicativo2'));          
    fillInput('#id_ciu_residencia','.telefono_indicativo_celular',urlBase.make('ciudad/getinputindicativo'));          
  });


function loadSelectTable(idIput, url, inputDefaul = true, tabla) {
    $(idIput).find('option').remove();
    if (inputDefaul) {
        $(idIput).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }
    $.ajax({
        url: url,
        type: "get",
        async: false,
        data: {
            tabla: tabla
        },
        success: function(datos) {
            jQuery.each(datos, function(indice, valor) {
                var selected = "";
                if ($(idIput).data('load') == valor.id) {
                    selected = "selected";
                }
                $(idIput).append($('<option value="' + valor.id + '" ' + selected + '>' + valor.name + '</option>'));
            });
        }
    });
}


function cargarSelectId(idIput, url, inputDefaul = true, id) {
    $(idIput).find('option').remove();
    if (inputDefaul) {
        $(idIput).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }
     alert(idIput + url);
    $.ajax({
        url: url,
        type: "get",
        async: false,
        data: {
            id: id
        },
        success: function(datos) {
            jQuery.each(datos, function(indice, valor) {
                var selected = "";
                if ($(idIput).data('load') == valor.id) {
                    selected = "selected";
                }
                $(idIput).append($('<option value="' + valor.id + '" ' + selected + '>' + valor.name + '</option>'));
            });
        }
    });
}


function loadSelectTableById(idIput, idTarget, url, inputDefaul = true, tabla, filter) {
    var id = $(idIput).val();
    $(idTarget).find('option').remove();
    if (inputDefaul) {
        $(idTarget).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }
    $.ajax({
        url: url,
        type: "get",
        async: false,
        data: {
            tabla: tabla,
            filter: filter,
            id: id
        },
        success: function(datos) {
            jQuery.each(datos, function(indice, valor) {
                var selected = "";
                if ($(idTarget).data('load') == valor.id) {
                    selected = "selected";
                }
                $(idTarget).append($('<option value="' + valor.id + '" ' + selected + '>' + valor.name + '</option>'));
            });
        }
    });
}


function cargarInputDocumento(id = null) {
    if (id == null)
        id = $('#id_tipo_documento').val();
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: URL.getTipoDocumento(),
        type: 'POST',
        async: false,
        data: { id: id },
        success: function(datos) {
            if (datos.alfanumerico == 1)
                $('#numero_documento').attr('type', 'text');
            else
                $('#numero_documento').attr('type', 'number');
        },
    });
}



$(document).ready(function() {
    $('#panel-familiares-nutibara').css('display', 'none');
    $('#id_cargo_ejercido').attr("disabled", "true");
    $('.tabs-nav li a').css('color', '#000');
    $('#id_tipo_cliente option').each(function() {
        var id = 1;
        var id2 = 2;
        if ($(this).val() != id && $(this).val() != id2)
            $(this).remove();
    });

    loadSelectTable(".id_regimen_contributivo", URL.getUrlList(), 2, 'regimen_contributivo');
    loadSelectTable(".id_ciudad", URL.getUrlList(), 2, 'ciudad');

    cargarInputDocumento();
});


$('.check-a-cargo-familia').click(function() {
    if (this.checked)
        $(this).next('input').val('1');
    else
        $(this).next('input').val('0');
});

$('.check-vive-con-familia').click(function() {
    if (this.checked)
        $(this).next('input').val('1');
    else
        $(this).next('input').val('0');
});

$('input[name="familiares_en_nutibara"]').change(function() {
    if (this.value == 1)
        $('#panel-familiares-nutibara').css('display', 'block');
    else
        $('#panel-familiares-nutibara').css('display', 'none');
});

$('.ha_laborado_nutibara').change(function() {
    if (this.value == 0)
        $('#id_cargo_ejercido').attr("disabled", "true");
    else
        $('#id_cargo_ejercido').removeAttr('disabled');

})

$('.check').click(function() {
    if (this.checked)
        $(this).val('1');
    else
        $(this).val('0');
});


$('.numero_documento').each(function() {
    // $(this).css({'visibility'})
});


$('#btn-add-pariente').click(function() {
    // $(".campos_parientes:nth-child(1)").clone().appendTo("#campos_parientes");
    var row = document.getElementsByClassName('campos_parientes')[0];
    var campo = row.cloneNode(true);
    // console.log(campo);

    row.parentNode.appendChild(campo);
});

$('a.ui-tabs-anchor').css('color', '#FF0000');

$(function() {
    $(".complete_empleado").autocomplete({
        source: URL.getCompleteEmpleados(),
        minLength: 3,
        select: function(event, ui) {
            $(this).next('.hd_id_tienda_pariente').val(ui.item.id_tienda);
            $(this).parent('div').find('.hd_codigo_cliente_pariente').val(ui.item.codigo_cliente);
            $(this).parent().parent('div.row').find('.id_ciudad option').each(function() {
                if ($(this).val() == ui.item.id_ciudad_trabajo)
                    $(this).attr("selected", "selected");
            });
            $(this).parent().parent('div.row').find('.id_cargo_empleado option').each(function() {
                if ($(this).val() == ui.item.id_cargo_empleado)
                    $(this).attr("selected", "selected");
            });
        }
    });
});

var contenidoGral = '';


$('.tabs-nav li').click(function() {
    $('.contenido-tab').hide();
    var contenido = $(this).find('a').attr('href');
    $(contenido).fadeIn();
});


$('form').submit(function() {
    var bandera = false;
    $('.requiered').each(function() {
        // alert($(this).val());
        if ($(this).val() == '') {
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
            bandera = true;
        }
        if (bandera)
            return false;
    });

    $('input[type="email"]').each(function() {
        var baderaEmail = true;
        var testEmail = validarEmail($(this).val());
    });
    if (bandera)
        return false;
    else
        $('form').attr('action', URL.getAction()).submit();
});


$('.obligatorio').keypress(function() {
    $(this).css('border', '1px solid #ccc');
});


$('.obligatorio').change(function() {
    $(this).css('border', '1px solid #ccc');
});

$('.direccion').each(function() {
    var id = $(this).prop("id");
    $("#" + id).on('click', function() {
        $("#idmodal").val("#" + id);
        $("#modal").modal("show");
    })
});

$("#guardardir").on('click', function() {
    $($("#idmodal").val()).val($('#resultado').val());
    $("#modal").modal("hide");
});


$("#id_tienda").change(function() {
    var zona = "";
    var id_tienda = $("#id_tienda").val();
    if (id_tienda != "" && id_tienda !== null) {
        $.ajax({
            url: URL.getTiendaZona() + "/" + id_tienda,
            type: "get",
            success: function(datos) {
                zona = datos.id_zona;
                if (zona != "" && zona !== null) {
                    $.ajax({
                        url: URL.getCombos() + "/" + zona,
                        type: "get",
                        success: function(datos) {
                            $("#id_pais_trabajo").append($('<option value="' + datos.id_pais + '" selected>' + datos.nombre_pais + '</option>'));
                            $("#id_departamento_trabajo").append($('<option value="' + datos.id_departamento + '" selected>' + datos.nombre_departamento + '</option>'));
                            $("#id_ciudad_trabajo").append($('<option value="' + datos.id_ciudad + '" selected>' + datos.nombre_ciudad + '</option>'));
                        }
                    })
                }
            }
        })
    }

});

$('.email_validado').each(function() {
    $(this).blur(function() {
        var flag = validarEmail($(this).val());
        if (flag == false) {
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div style="clear: both;" class="tool tool-visible" id="tool"><p>Correo electrónico debe tener formato "ejemplo@ejemplo.com"</p></div>');
            bandera = false;
        }
    });

});



$('.email_validado').each(function() {
    $(this).blur(function() {
        var flag = validarEmail($(this).val());
        if (flag == false) {
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div style="clear: both;" class="tool tool-visible" id="tool"><p>Correo electrónico debe tener formato "ejemplo@ejemplo.com"</p></div>');
            bandera = false;
        }
    });

});
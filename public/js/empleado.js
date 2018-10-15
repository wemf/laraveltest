//Carga las URL necesarias para que funcione la persitencia
var URL = (function() {
    //variable global
    var url = {};
    url.getList = '';
    url.getListById = '';
    url.getListSociedadByFranquicia = '';
    url.getListFranquicia = '';
    url.getUpdateAction = '';
    url.getDeletedAction = '';
    url.getCompleteEmpleados = '';
    url.getAction = '';
    url.getAction2 = '';
    url.date = '';
    url.getTipoDocumento = '';
    url.getView = '';
    url.getEmpleadoSociedad = '';
    url.getParametroGeneral = '';
    url.getEmpleadoActu = '';
    return {
        setView: function(url2) {
            url.getList = url2;
        },
        getView: function() {
            return url.getView;
        },
        setAction2: function(url2) {
            url.getAction2 = url2;
        },
        getAction2: function() {
            return url.getAction2;
        },

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
        setUrlListSociedadByFranquicia: function(url2) {
            url.getListSociedadByFranquicia = url2;
        },
        getUrlListSociedadByFranquicia: function() {
            return url.getListSociedadByFranquicia;
        },
        setUrlListFranquicia: function(url2) {
            url.getListFranquicia = url2;
        },
        getUrlListFranquicia: function() {
            return url.getListFranquicia;
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
        setEmpleadoSociedad: function(url2) {
            url.getEmpleadoSociedad = url2;
        },
        getEmpleadoSociedad: function() {
            return url.getEmpleadoSociedad;
        },
        setParametroGeneral: function(url2) {
            url.getParametroGeneral = url2;
        },
        getParametroGeneral: function() {
            return url.getParametroGeneral;
        },
        setEmpleadoActu: function(getEmpleadoActu) {
            url.getEmpleadoActu = getEmpleadoActu;
        },
        getEmpleadoActu: function() {
            return url.getEmpleadoActu;
        },
    }
})();


$(function() {
    $("#tabs").tabs();
});


function runPersistenceForm() {
    loadSelectTable(".id_contrato", URL.getUrlList(), 2, 'tipo_contrato');
    loadSelectTable(".id_pais", URL.getUrlList(), 2, 'pais');
    loadSelectTable(".id_cargo_empleado", URL.getUrlList(), 2, 'cargo_empleado');
    loadSelectTable("#id_estado_civil", URL.getUrlList(), 2, 'estado_civil');
    loadSelectTable("#rh", URL.getUrlList(), 2, 'tipo_rh');
    loadSelectTable("#id_role", URL.getUrlList(), 2, 'roles');
    loadSelectTable("#id_tipo_vivienda", URL.getUrlList(), 2, 'tipo_vivienda');
    loadSelectTable("#id_tenencia_vivienda", URL.getUrlList(), 2, 'tenencia_vivienda');
    loadSelectTable("#id_caja_compensacion", URL.getUrlList(), 2, 'caja_compensacion');
    loadSelectTable("#id_tipo_documento", URL.getUrlList(), 2, 'tipo_documento');
    loadSelectTable("#id_tienda", URL.getUrlList(), 2, 'tienda');
    loadSelectTable("#id_tipo_cliente", URL.getUrlList(), 2, 'tipo_cliente');
    loadSelectTable("#id_fondo_cesantias", URL.getUrlList(), 2, 'fondo_cesantias');
    loadSelectTable("#id_fondo_pensiones", URL.getUrlList(), 2, 'fondo_pensiones');
    loadSelectTable(".id_eps", URL.getUrlList(), 2, 'eps');
    loadSelectTable(".id_tipo_parentesco", URL.getUrlList(), 2, 'tipo_parentesco');
    loadSelectTable(".id_nivel_estudio", URL.getUrlList(), 2, 'nivel_estudio');
    loadSelectTable(".id_motivo_retiro", URL.getUrlList(), 2, 'motivo_retiro');
    loadSelectTableById('#talla_camisa', '#talla_camisa', URL.getUrlListById(), 2, 'talla', 'tipo', 1);
    loadSelectTableById('#talla_pantalon', '#talla_pantalon', URL.getUrlListById(), 2, 'talla', 'tipo', 2);
    loadSelectTableById('#talla_zapatos', '#talla_zapatos', URL.getUrlListById(), 2, 'talla', 'tipo', 2);

}

//loadSelectTable(".id_ciudades", URL.getUrlList(), 2, 'ciudad');

$('#id_pais_trabajo').change(function() {
    loadSelectTableById('#id_pais_trabajo', '#id_departamento_trabajo', URL.getUrlListById(), 2, 'departamento', 'id_pais');
});

$('#id_departamento_trabajo').change(function() {
    loadSelectTableById('#id_departamento_trabajo', '#id_ciudad_trabajo', URL.getUrlListById(), 2, 'ciudad', 'id_departamento');
});

$('#id_pais_exp').change(function() {
    if($('#id_pais_exp').find('option:selected').text().toLowerCase() == 'Colombia'.toLowerCase() && ($('#id_tipo_documento').find('option:selected').text().toLowerCase() == 'Visa'.toLowerCase() || $('#id_tipo_documento').find('option:selected').text().toLowerCase() == 'Pasaporte'.toLowerCase())){
        document.getElementById('id_tipo_documento').selectedIndex = 0;
    }
    loadSelectTableById('#id_pais_exp', '#id_dep_exp', URL.getUrlListById(), 2, 'departamento', 'id_pais');
});

$('#id_dep_exp').change(function() {
    loadSelectTableById('#id_dep_exp', '#id_ciu_exp', URL.getUrlListById(), 2, 'ciudad', 'id_departamento');
});

$('#id_pais_nacimiento').change(function() {
    loadSelectTableById('#id_pais_nacimiento', '#id_dep_nacimiento', URL.getUrlListById(), 2, 'departamento', 'id_pais');
});

$('#id_dep_nacimiento').change(function() {
    loadSelectTableById('#id_dep_nacimiento', '#id_ciu_nacimiento', URL.getUrlListById(), 2, 'ciudad', 'id_departamento');
});

$('#id_pais_residencia').change(function() {
    if($(this).find('option:selected').text().toLowerCase() == 'Colombia'.toLowerCase())
    {
        $('#id_dep_residencia').prop('disabled', false);
        $('#id_ciu_residencia').prop('disabled', false);
    }
    else
    {
        $('#id_dep_residencia').prop('disabled', 'disabled');
        $('#id_ciu_residencia').prop('disabled', 'disabled');
    }
    loadSelectTableById('#id_pais_residencia', '#id_dep_residencia', URL.getUrlListById(), 2, 'departamento', 'id_pais');    
});

$('#id_dep_residencia').change(function() {
    loadSelectTableById('#id_dep_residencia', '#id_ciu_residencia', URL.getUrlListById(), 2, 'ciudad', 'id_departamento');
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
    alert(url + idIput);
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

function loadSelectTableById(idIput, idTarget, url3, inputDefaul = true, tabla, filter, id = null) {
    if (id === null) id = $(idIput).val();
    $(idTarget).find('option').remove();
    if (inputDefaul) {
        $(idTarget).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }
    $.ajax({
        url: url3,
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

$('#id_tipo_documento').change(function() {
    var id = $(this).val();
    cargarInputDocumento(id);
    /*------------------------------------------------------------------
    Si Tipo de Documento es VISA o PASAPORTE no puede solicitar Departamento ni Ciudad de Expedicion
    -------------------------------------------------------------------*/
    if($(this).find('option:selected').text() == 'Visa' || $(this).find('option:selected').text() == 'Pasaporte')
    {
        $('#id_dep_exp').prop( "disabled", true );
        $('#id_ciu_exp').prop( "disabled", true );
    }
    else
    {
        $('#id_dep_exp').prop( "disabled", false );
        $('#id_ciu_exp').prop( "disabled", false );
    }
    /*-- ---------------------------------------------------------- ---
    ---- --------------------------------------------------------- --*/
})

$(document).ready(function() {
    //Carga Franquicias en el tap 1
    //loadSelectInput('#id_franquicia', URL.getUrlListFranquicia());

    $('#id_cargo_ejercido').attr("disabled", "true");
    $('.tabs-nav li a').css('color', '#000');

    $('.numeric').each(function() {
        $(this).keyup(function() {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
    });

    $(".maxfecha").each(function() {
        var id = $(this).prop('id');
        if (id != '') {
            $("#" + id).datetimepicker('setEndDate', URL.getDate());
        }
    });

    $('#ui-id-2').click(function() {
        $(".moneda").each(function() {
            $(this).val(money.replace($(this).val()));
        });
    })
    $('.tb1').click(function() {
        $(".moneda").each(function() {
            $(this).val(money.replace($(this).val()));
        });
    })

     $("#numero_documento").blur(function() {
         var identificacion = $("#numero_documento").val();
         var tipo_documento = $('#id_tipo_documento').val();
         if (identificacion != "") {
             $.ajax({
                url: urlBase.make('clientes/empleado/getEmpleadoIden') + "/" + identificacion + "/" +tipo_documento,
                type: "get",
                success: function(datos) {
                    if (datos.codigo_cliente !== undefined) {
                        confirm.setTitle('Aviso');
                        confirm.setSegment('El documento ya existe y pertenece a un '+datos.tipo_cliente+', ¿desea cargar su información?');
                        confirm.show();
                        $("#confirmSuccess").click(function() {
                            pageAction.redirect(urlBase.make('clientes/empleado/updateclient')+ "/" + datos.codigo_cliente + "/" + datos.id_tienda);
                        });
                    }
                }
            })
        }
    });     


    $("#id_tienda").change(function() {
        var zona = "";
        var id_tienda = $("#id_tienda").val();
        if (id_tienda != "" && id_tienda !== null) {
            $.ajax({
                url: URL.getTiendaZona() + "/" + id_tienda,
                type: "get",
                success: function(datos) {
                    ciudad = datos.id_ciudad;
                    if (ciudad != "" && ciudad !== null) {
                        $.ajax({
                            url: URL.getCombos() + "/" + ciudad,
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

    $('#asignacion').click(function() {
        var id_usuario = $('#idUsuario').val();
        if(id_usuario =="") id_usuario = $('#id_usuario').val();
        if(id_usuario =="") id_usuario = 0;
        $('#modalUser').modal('show');
        var email = $('#email').val();
        if (email != '' && email !== null) {
            $.ajax({
                url: URL.getUser().trim() + "/" + id_usuario,
                type: 'get',
                success: function(datos) {

                    if (datos.id !== undefined) {
                        $('#name').val(datos.name);
                        $('#email').val(datos.email);
                        $('#id_role').val(datos.id_role);
                        $('#modo_ingreso').val(datos.modo_ingreso);
                        $('#idUsuario').val(datos.id);
                        $('#guardarUser').remove();
                    } else {
                        $('#actualizarUser').remove();
                    }
                }
            })
        }
    });

    $('#btnCrearUsuario').click(function() {
        $('#modalUserCreate').modal('show');
        $('#name').val($('input[name="nombres"]').val() + " " + $('input[name="primer_apellido"]').val());
        $('#email').val($('input[name="correo_electronico"]').val());
    });

    $('#RedirectAsociarTienda').click(function(){

    });

    $('#guardarUser').click(function() {
        var id_role = $('#id_role').val();
        var email = $('#email').val();
        var name = $('#name').val();
        var modo_ingreso = $('#modo_ingreso').val();
        var codigo_cliente = $('#codigo_cliente').val();
        var id_tienda = $('#hd_id_tienda').val();
        
        if ((id_role != "" && id_role !== null) && (email != "" && email !== null) && (name != "" && name !== null) && (modo_ingreso != "" && modo_ingreso !== null)) {

            data = {
                id_role: id_role,
                name: name,
                email: email,
                modo_ingreso: modo_ingreso,
                codigo_cliente: codigo_cliente,

                id_tienda: id_tienda,
            }
            actionAjax(data, URL.getActionUser());
            location.reload();
        }

    });

    $('#CreateUser').click(function() {
        var id_role = $('#id_role').val();
        var email = $('#email').val();
        var name = $('#name').val();
        var modo_ingreso = $('#modo_ingreso').val();
        if (id_role != "" && id_role !== null && email != "" && email !== null && name != "" && name !== null && modo_ingreso != "" && modo_ingreso !== null) {
            $('#form-attribute #id_role_crear_usuario').val(id_role);
            $('#form-attribute #email_crear_usuario').val(email);
            $('#form-attribute #name_crear_usuario').val(name);
            $('#form-attribute #modo_ingreso_crear_usuario').val(modo_ingreso);
            $('#div_msg_usuario').empty().append('<div class="alert alert-info"><strong>Información!</strong> Se ha agregado la información para crear un usuario.</div>');
        }

    });

    $('#actualizarUser').click(function() {
        var id_role = $('#id_role').val();
        var email = $('#email').val();
        var name = $('#name').val();
        var modo_ingreso = $('#modo_ingreso').val();
        var codigo_cliente = $('#codigo_cliente').val();
        var id_tienda = $('#hd_id_tienda').val();
        var id = $('#idUsuario').val();

        if (id_role != "" && id_role !== null && email != "" && email !== null && name != "" && name !== null) {
            data = {
                id_role: id_role,
                name: name,
                email: email,
                modo_ingreso: modo_ingreso,
                codigo_cliente: codigo_cliente,
                id_tienda: id_tienda,
                id: id,
            }
            actionAjax(data, URL.getAction2());
            location.reload();
        }

    });

    $('#numero_documento').attr('type', 'number');

    $('#id_tipo_cliente option').each(function() {
        if ($(this).val() != 1 && $(this).val() != 2 && $(this).val() != '')
            $(this).remove();
    });

    $('#id_tipo_documento option').each(function() {
        if ($(this).val() == 4)
            $(this).remove();
    });
    cargarInputDocumento();
});

cargar();

function cargar() {
    var zona = "";
    var sociedad = "";
    var id_tienda = $("#id_tienda").val();
    if(id_tienda)
    {
    $.ajax({
        url: URL.getTiendaZona() + "/" + id_tienda,
        type: "get",
        success: function(datos) {
            zona = datos.id_zona;
            sociedad = datos.id_sociedad;
            if (zona != "" && zona !== null) {
                $.ajax({
                    url: URL.getCombos() + "/" + zona,
                    type: "get",
                    success: function(datos) {
                        $("#id_pais_trabajo").val(datos.id_pais);
                        $("#id_departamento_trabajo").val(datos.id_departamento);
                        $("#id_ciudad_trabajo").val(datos.id_ciudad);
                    }
                })
            }
        }
    })
    };
}

/*Funcion para agregar 1 o 0 a los Check*/
    function checkNext(Check){
        if(Check.checked){
            $(Check).next('input').val('1');
            $(Check).val('1');
        }
        else{
            $(Check). next('input').val('0');
            $(Check).val('0');
        }
    }
//-------------------------------------------------------------


$('.check-retiro').click(function() {
    if (this.checked) {
        $(this).next('input').val('1');
        $('#fecha_retiro').prop('disabled', false);
        $('#id_motivo_retiro').prop('disabled', false);
        $('textarea[name="observacion_novedad"]').prop('disabled', false);
    } else {
        $(this).next('input').val('0');
        $('#fecha_retiro').prop('disabled', true);
        $('#id_motivo_retiro').prop('disabled', true);
        $('textarea[name="observacion_novedad"]').prop('disabled', true);
    }
});



$('input[name="familiares_en_nutibara"]').change(function() {
    if (this.value == 1) {
        $('#panel-familiares-nutibara').css('opacity', '1');
        $('#panel-familiares-nutibara').find('select input').addClass('requiered').removeAttr('disabled');
    } else {
        $('#panel-familiares-nutibara').css('opacity', '0.5');
        $('#panel-familiares-nutibara #dataTable').find('select input textarea').removeClass('requiered').attr('disabled', 'disabled');
    }
});


$('.check').click(function() {
    if (this.checked)
        $(this).val('1');
    else
        $(this).val('0');
});

$('#finalizado').click(function() {
    var estadofin = $('#finalizado').val();
    if (estadofin == "2" || estadofin == "3")
        $('.obl').addClass('obligatorio');
    else if (estadofin == "1")
    {
        $('.obl').removeClass('obligatorio');
        $('#tool').remove();
    }
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

$("#updateAction1").click(function() {
    var url2 = URL.getUpdateAction();
    updateRowDatatableAction(url2);
});

$("#deletedAction1").click(function() {
    var url2 = URL.getDeletedAction();
    deleteRowDatatableAction(url2);
});



function EliminarDatoDatatableAction(url2) {
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    var valueIdTienda = table.$('tr.selected').find('td').html();

    var idPost = { id: valueId, idTienda: valueIdTienda };
    // var idPost = { id: valueId };
    confirm.setTitle('Alerta');
    confirm.setSegment("¿Desactivar el registro?");
    confirm.show();
    confirm.setFunction(function() {
        if (valueId != null) {
            var action = actionAjax(idPost, url2);
            if (action) {
                table.row('tr.selected').remove().draw();
            }
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });
}


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

$('.contenido-tab').hide();
$('.tabs-nav li').click(function() {
    $('.contenido-tab').hide();
    var contenido = $(this).find('a').attr('href');
    $(contenido).fadeIn();
});


$('form').submit(function() {
    var bandera = false;
    var gen = $('#genero').val();

    $('.requiered').each(function() {
        if ($(this).val() == '') {
            var idTad = $(this).closest('div[id^="tabs-"]').attr('aria-labelledby');
            $("#" + idTad).click();
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
            bandera = true;
        }
        if (bandera)
            return false;
    });


    $(".obligatoriocheck").on('click', function() {
        $(this).css('border', 'none');
    });

    if (bandera) {
        return false;
    } else {
        $('#id_ciudad_trabajo').attr('disabled', false);
        $('#panel-familiares-nutibara #dataTable ').find('input,select').attr('disabled', false);
        $('.dataTables-example3').find('input,select').attr('disabled', false);
        if($('#id_cargo_empleado').val() != 54)
        {
            $('form').attr('action', URL.getAction()).submit();
        }
        else
        {
            $('#modalRevisor').modal('show');
        }
    }

});

/* Si es Revisor redirecciona a asociar tiendas.*/
$('#RedirectAsociarTienda').click(function()
{
    codigoCliente = $('#codigo_cliente').val();
    tienda = $('#id_tienda').val();
    if($('#codigo_cliente').val() == undefined)
    {
        $('form').attr('action', urlBase.make('clientes/empleado/createasociate')).submit();
    }
    else
    {
        pageAction.redirect( urlBase.make('/asociarclientes/asociartienda/create/'+codigoCliente+'/'+tienda),0.1 );
    }
});

$('#cancelarAsociarTienda').click(function(){
    $('form').attr('action', URL.getAction()).submit();    
});
/* si no crea el empleado. y redrecciona a el maestro de empleado*/

$('.obligatorio').keypress(function() {
    $(this).css('border', '1px solid #ccc');
});


$('.obligatorio').change(function() {
    $(this).css('border', '1px solid #ccc');
});


function valDivRequiered(id) {
    var bandera = true;
    $('#' + id + ' .requiered').each(function() {
        if ($(this).val() == "") {
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div style="clear: both;" class="tool tool-visible" id="tool"><p>Este campo es requerido para poder continuar</p></div>');
            bandera = false;
        }

        if (bandera == false) {
            return false;
        }
    });

    return bandera;
};


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


$('#cancelConfirm').click(function() {
    $('#numero_documento').val('');
});

$('.tipo_documento option').each(function() {
    if ($(this).val() == 32) {
        $(this).remove();
    }
});


/*-- ----------------------------------------------------------- ---
     FUNCIÓN PARA BUSCAR LOS PARIENTES QUE LABOREN EN LA EMPRESA
---- ---------------------------------------------------------- --*/

$('#btn_pariente_nutibara').click(function() {
    buscarPariente();
});

function buscarPariente() {
    var indicativo = $('#indicativo_telefono_pariente_nutibara').val().trim();
    var telefono = $('#telefono_pariente_nutibara').val().trim();
    var telefono_2 = indicativo + " " + telefono;
    var tipo_documento = $('#tipo_documento_pariente_nutibara').val();
    var numero_documento = $('#numero_documento_pariente_nutibara').val();
    var url2 = urlBase.make('/clientes/empleado/getFamiliarN');
    var data = {
        telefono: telefono_2,
        tipo_documento: tipo_documento,
        numero_documento: numero_documento
    }
    if (comprobar_Pariente(tipo_documento, numero_documento) == true) {
        if ((telefono_2 != '') || (tipo_documento > 0 && numero_documento != '')) {
            var retorno = getAjaxGeneral(data, url2);
            if (jQuery.isEmptyObject(retorno.msm)) {
                alert("Vacío");
            } else {
                var contenido_nuevo = $('#panel-familiares-nutibara #dataTable').find('.tr-contenido:last');
                contenido_nuevo.find('input[name="id_tienda_pariente[]"]').val(retorno.msm.id_tienda);
                contenido_nuevo.find('input[name="codigo_cliente_pariente[]"]').val(retorno.msm.codigo_cliente);
                contenido_nuevo.find('select[name="id_tipo_documento_parientes[]"]').val(retorno.msm.id_tipo_documento).attr('selected', 'selected');
                contenido_nuevo.find('input[name="identificacion_parientes[]"]').val(retorno.msm.numero_documento);
                contenido_nuevo.find('input[name="nombre_parientes[]"]').val(retorno.msm.nombres);
                contenido_nuevo.find('input[name="fecha_nacimiento_parientes[]"]').val(retorno.msm.fecha_nacimiento);
                contenido_nuevo.find('select[name="id_cargo_pariente[]"]').val(retorno.msm.id_cargo_empleado).attr('selected', 'selected');
                contenido_nuevo.find('select[name="ciudad_pariente[]"]').val(retorno.msm.id_ciudad_trabajo).attr('selected', 'selected');
                contenido_nuevo.find('select[name="id_tipo_parentesco[]"]').removeAttr('disabled').addClass('requiered');
            }
        }
    } else {
        alert("No puede utilizar el actual Empleado como Familiar en Nutibara");
    }
}

function comprobar_Pariente(tipo, numero) {
    var tipo_documento = $('#id_tipo_documento').val();
    var numero_documento = $('#numero_documento').val();
    if ((tipo_documento == tipo) && (numero_documento == numero)) {
        return false;
    } else {
        return true;
    }
}

/*-- ---------------------------------------------------------- ---
---- --------------------------------------------------------- --*/


/*-- --------------------------------------------------------------- ---
     FUNCIÓN FILTRAR TIENDAS Y SEDES PRINCIPALES DESDE TIPO EMPLEADO
---- --------------------------------------------------------------- --*/

$('#id_tipo_cliente').change(function() 
{
    // Al momento de seleccionar un nuevo tipo de cliente Restaura la tienda y los parametros que trae la tienda.
    $("#id_tienda").empty();
    $("#id_pais_trabajo").empty();
    $("#id_departamento_trabajo").empty();
    $("#id_ciudad_trabajo").empty();
    $("#id_tienda").append($('<option>', {
        value: '',
        text: '- Seleccione una opción -',
    }));
    //---------------------------------------------------------------------------------------------------------
    cargarFranquicias($(this).val());
    cargarSociedades($(this).val());
});

$('#id_sociedad').change(function() {
    cargarTiendas($("#id_tipo_cliente").val());
});

function cargarFranquicias(id) {
    
    var id_principal = 0;
    if (id == 2) {
        id_principal = 1;
    }
    var data = { id: id_principal };
    var url2 = urlBase.make('clientes/empleado/getFranquiciaByTipoCliente');
    var retorno = getAjaxGeneral(data, url2);
    if (!jQuery.isEmptyObject(retorno)) {
        cargarSelectMin(retorno, "#id_franquicia");
    } else {}
}

function cargarSociedades(id) {
    
    var id_principal = 0;
    if (id == 2) {
        id_principal = 1;
    }
    var data = { id: id_principal};
    var url2 = urlBase.make('clientes/empleado/getSociedadByFranquicia');
    var retorno = getAjaxGeneral(data, url2);
    if (!jQuery.isEmptyObject(retorno)) {
        cargarSelectMin(retorno, "#id_sociedad");
    } else {}
}

function cargarTiendas(id) {
    var id_principal = 0;
    var id_franquicia = $('#id_franquicia').val();
    var id_sociedad = $('#id_sociedad').val();

    if (id == 2) {
        id_principal = 1;
    }
    
    if(id_franquicia)
    {
        var data = { id: id_principal, franquicia: id_franquicia, sociedad: id_sociedad };
        var url2 = urlBase.make('clientes/empleado/getTiendaBySociedad');
        var retorno = getAjaxGeneral(data, url2);
        if (!jQuery.isEmptyObject(retorno)) 
        {
            cargarSelectMin(retorno, "#id_tienda");
        }
    }
}

function cargarSelectMin(objeto, select) {
    $(select).empty();
    $(select).append($('<option>', {
        value: '',
        text: '- Seleccione una opción -',
    }));
    jQuery.each(objeto, function(indice, valor) {
        var selected = "";
        if ($(select).data('load') == valor.id) {
            selected = "selected";
        }
        $(select).append($('<option value="' + objeto[indice].id + '" ' + selected + '>' + objeto[indice].nombre + '</option>'));
    });
}

/*Si no es Jefe de Zona no se muestre el campo de Zona.*/
$('.id_cargo_empleado').change(function(){

    if($(this).val()== 6)
    {
        $('.id_zona_cargo').removeClass('hide');
        $("#id_zona_cargo").val("");
        $("#id_zona_cargo").addClass("requiered");
    }
    else
    {
        $('.id_zona_cargo').addClass('hide');
        $("#id_zona_cargo").val("");
        $("#id_zona_cargo").removeClass("requiered");
    }
    validarAdministradorJoyeria();
});

$('#id_zona_cargo').change(function(){
    if($('#id_zona_cargo').val() != '')
    {
        $.ajax({
            url: urlBase.make('clientes/empleado/validarjefezona/'+$('#id_zona_cargo').val()),
            type: "get",
            async: false,
            success: function(datos) {
                if (datos== true) {
                    $('#id_zona_cargo').val('');
                    confirm.setTitle('Aviso');
                    confirm.setSegment('Ya existe un empleado con este cargo y no se pueden asignar mas.');
                    confirm.show();
                    $("#confirmSuccess").click(function() 
                    { 
                    });
                }
            }
        });
    }
});
 /*Valida si existe un administrador para esa tienda.*/
function validarAdministradorJoyeria()
{
    if($('.id_cargo_empleado').val() == 5 && $('#numero_documento').val() == '' )
    {
        $.ajax({
            url: urlBase.make('clientes/empleado/validaradmin/'+$('#id_tienda').val()),
            type: "get",
            async: false,
            success: function(datos) 
            {
                if (datos== true) {
                    $('.id_cargo_empleado').val('');
                    confirm.setTitle('Aviso');
                    confirm.setSegment('Ya existe un empleado con este cargo y no se pueden asignar mas.');
                    confirm.show();
                    $("#confirmSuccess").click(function() 
                    { 
                    });
                    
                }
            }
        });
    }
};

/*-- ---------------------------------------------------------- ---
---- --------------------------------------------------------- --*/


/*-- --------------------------------------------------------------- ---
     FUNCIÓN FILTRAR TIENDAS Y SEDES PRINCIPALES DESDE TIPO EMPLEADO
---- --------------------------------------------------------------- --*/
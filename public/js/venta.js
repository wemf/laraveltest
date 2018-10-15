var t = $('#productosVentaDirecta').DataTable();
var arraypushx = new Array();
var count_items = 0;
var funcion = (function(){
    var url = {};
        url.getSRC = '';
        url.getSRC2 = '';
    return{
        setSRC: function (url2) {
            url.getSRC = url2;
        },
        getSRC: function () {
            return url.getSRC;
        },
        setSRC2: function (url2) {
            url.getSRC2 = url2;
        },
        getSRC2: function () {
            return url.getSRC2;
        },
        info_cliente: function(){
            var tipo_documento = limpiar_texto($('#tipo_documento').val());
            var numero_documento = limpiar_texto($('#numero_documento').val());
            if(tipo_documento != ""){
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: urlBase.make('ventas/getCliente'),
                    type: 'get',
                    data: {
                        tipo_documento: tipo_documento,
                        documento: numero_documento
                    },
                    success: function (datos) {
                        if (limpiar_texto(datos.codigo_cliente)) {
                            var nombres = datos.nombres.split(" ");
                            primer_nombre = (limpiar_texto(nombres[0]) == "") ? primer_nombre = "" : primer_nombre = nombres[0];
                            segundo_nombre = (limpiar_texto(nombres[1]) == "") ? segundo_nombre = "" : segundo_nombre = nombres[1];
                            var ruta_anterior = (limpiar_texto(datos.anterior) == "") ? funcion.getSRC2().trim() : funcion.getSRC().trim() + limpiar_texto(datos.anterior);
                            var ruta_posterior = (limpiar_texto(datos.posterior) == "") ? funcion.getSRC2().trim() : funcion.getSRC().trim() + limpiar_texto(datos.posterior);
                            
                            $('#pais_residencia').val(limpiar_texto(datos.id_pais_residencia)).attr('disabled', 'disabled');
                            $('#ciudad_residencia').val(limpiar_texto(datos.id_ciudad_residencia)).attr('disabled', 'disabled');
                            $('#pais_expedicion').val(limpiar_texto(datos.id_pais_expedicion)).attr('disabled', 'disabled');
                            $('#ciudad_expedicion').val(limpiar_texto(datos.id_ciudad_expedicion)).attr('disabled', 'disabled');
                            $('#fecha_nacimiento').val(limpiar_texto(datos.fecha_nacimiento)).attr('readonly', 'readonly').removeClass('data-picker-only');
                            $('#fecha_expedicion').val(limpiar_texto(datos.fecha_expedicion)).attr('readonly', 'readonly').removeClass('data-picker-only');
                            $('#primer_nombre').val(primer_nombre).attr('readonly', 'readonly');
                            $('#segundo_nombre').val(segundo_nombre).attr('readonly', 'readonly');
                            $('#primer_apellido').val(limpiar_texto(datos.primer_apellido)).attr('readonly', 'readonly');
                            $('#segundo_apellido').val(limpiar_texto(datos.segundo_apellido)).attr('readonly', 'readonly');
                            $('#correo').val(limpiar_texto(datos.correo_electronico));
                            $('#genero').val(limpiar_texto(datos.genero)).attr('readonly', 'readonly');
                            $('#direccion_residencia').val(limpiar_texto(datos.direccion_residencia));
                            $('#regimen').val(limpiar_texto(datos.regimen)).attr('disabled', 'disabled');
                            $('#telefono_residencia').val(limpiar_texto(datos.telefono_residencia));
                            $('#telefono_celular').val(limpiar_texto(datos.telefono_celular));
                            $('#foto_1').removeClass('requiered');
                            $('#foto_2').removeClass('requiered');
                            $('.flip-1').attr('src', ruta_anterior);
                            $('.flip-2').attr('src', ruta_posterior);
                            $('#cliente').val('1');
                            $('.docs').hide();
                            $('#divBtn').css('display', '');
                            $('#codigo_cliente').val(limpiar_texto(datos.codigo_cliente));
                            $('#id_tienda').val(limpiar_texto(datos.id_tienda));
                            
                            fillInput('#ciudad_residencia', '#telefono_residencia_indicativo', urlBase.make('/ciudad/getinputindicativo2'));
                            fillInput('#ciudad_residencia', '#telefono_celular_indicativo', urlBase.make('/ciudad/getinputindicativo'));
                            
                        }else{
                            $('#cliente').val('0');
                            $('.inputBloqueo').each(function(){
                                $(this).val('').attr('readonly', false);
                            });
                            $('.selectBloqueo').each(function(){
                                $(this).val('').attr('disabled', false);
                            });
                            $('#fecha_nacimiento').val('');
                            $('#fecha_expedicion').val('');
                            $('#direccion_residencia').val('');
                        }
                    }    
                })
            }else{
                $('#tipo_documento').focus();
                $('#tool').remove();
                $('#tipo_documento').after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
            }
        },
        buscarProducto:function(){
            var option = "";
                $('.content_buscador').show('slow');
                $.ajax({
                    url: urlBase.make('ventas/getInventarioByName'),
                    type: "get",
                    data: {
                        referencia: $('#referencia').val()
                    },
                    success: function (data) {
                        var j = 0;
                        var id_inven = "";
                        jQuery.each(data, function (i, val) {
                            if (limpiar_texto(data[j]) != "") {
                                if (limpiar_texto(data[j].id_inventario) != "") id_inven = data[j].id_inventario;
                                option += '<option value="' + data[j].id + '|' + data[j].nombre + '|' + data[j].descripcion + '|' + data[j].lote + '|' + id_inven + '|' + data[j].precio + '" >' + data[j].nombre + ' - ' + data[j].descripcion + '</option>';
                                j++;
                            }
                        });
                        $('#select_codigo_inventario').empty().append(option);
                        option = "";
                    }
                })
        },
        addproduct:function(){
            var paso = 1;
            var vaciar = 0;
            if (limpiar_texto($('#referencia').val()) != '') {

                for (var i = 0; i < arraypushx.length; i++) {
                    if (arraypushx[i]['codigo_inventario'] == $('#id_inventario').val()) {
                        paso = 0;
                    }
                }
                if (limpiar_texto($('#precio').val()) == "") {
                    $('#alertPas').css('display', 'block');
                    $('#textAlert').text('Este producto no se puede agregar ya que no cuenta con un precio.');
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                } else if (paso == 1) {
                    vaciar = 0;

                    arraypushx.push({
                        id_tienda: limpiar_texto($('#id_tienda').val()),
                        codigo_inventario: limpiar_texto($('#id_inventario').val()),
                        precio: limpiar_texto($('#precio').val()),
                    });
                    var arr_names = [ 'id_tienda', 'id_inventario', 'precio', 'concepto', 'lote', 'iva', 'porcentaje_descuento', 'valor_descuento' ];
                    for (var i = 0; i < arr_names.length; i++) {
                        $('#arr_venta').append(`<input type="hidden" name="arr_i_venta[${count_items}][${arr_names[i]}]" value="${limpiar_texto($(`#${arr_names[i]}`).val())}">`);
                    }                    
                    
                    t.row.add([
                        $('#id_inventario').val(),
                        $('#referencia').val(),
                        0,
                        1,
                        $('#peso').val(),
                        `<input type="text" id="precio_${$('#id_inventario').val()}" value="${$('#id_inventario').val()}" class="form-control money v_precio" readonly>`,
                        `<input type="text" class="form-control" name="porcentaje_iva[]" id="porcentaje_iva_${$('#id_inventario').val()}" value="0">`,
                        `<input type="text" id="valor_iva_${$('#id_inventario').val()}" name="valor_iva[]" class="form-control money v_iva" value="0" readonly>`,
                        `<input type="text" class="form-control" name="porcentaje_retefuente[]" maxlength="2" id="porcentaje_retefuente_${$('#id_inventario').val()}" onkeyup="calculaValores(this.value,'valor_retefuente_${$('#id_inventario').val()}','v_retefuente','v_retefuente','${$('#precio').val()}','${$('#id_inventario').val()}');calcular_precio_retfuente();">`,
                        `<input type="text" id="valor_retefuente_${$('#id_inventario').val()}" name="valor_retefuente[]" class="form-control money v_retefuente" value="0" readonly>`,
                        `<input type="text" class="form-control" name="porcentaje_renteica[]" maxlength="2" id="porcentaje_renteica_${$('#id_inventario').val()}" value="0" onkeyup="calculaValores(this.value,'valor_renteica_${$('#id_inventario').val()}','v_reteica','v_reteica','${$('#precio').val()}','${$('#id_inventario').val()}');calcular_precio_retica();">`,
                        `<input type="text" id="valor_renteica_${$('#id_inventario').val()}" name="valor_renteica[]" class="form-control money v_reteica" value="0" readonly>`,
                        `<input type="text" class="form-control" name="porcentaje_renteiva[]" maxlength="2" id="porcentaje_renteiva_${$('#id_inventario').val()}" value="0" onkeyup="calculaValoresRetIVA(this.value,'valor_renteiva_${$('#id_inventario').val()}','v_reteiva','v_reteiva','valor_iva_${$('#id_inventario').val()}');calcular_precio_retiva();">`,
                        `<input type="text" id="valor_renteiva_${$('#id_inventario').val()}" name="valor_renteiva[]" class="form-control money v_reteiva" value="0" readonly>`,
                        $('#precio').val()
                    ]).draw(false);
                    $('#concepto_' + $('#id_inventario').val()).val($('#concepto').val());
                    $('#addproduct').css('display', 'none');
                    $('#alertPas').css('display', 'none');
                    ++count_items;
                } else {
                    $('#addproduct').css('display', 'none');
                    $('#alertPas').css('display', 'block');
                    $('#textAlert').text('Este producto ya se agrego recientemente');
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            } else {
                $('#addproduct').css('display', 'none');
                $('#alertPas').css('display', 'block');
                $('#textAlert').text('No se pudo agregar el producto.');
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
            if (vaciar == 0) {
                $('#referencia').val('');
                $('#nombre_producto').val('');
                $('#precio').val('');
                $('#concepto').val('');
                $('#descripcion').val('');
                $('#id_inventario').val('');
                $('#lote').val('');
            }

            // $('#valor_bruto').text(0);
            // $('#descuento').text(0);
            // $('#subtotal').text(0);
            // $('#iva').text(0);
            // $('#valor_iva').text(0);
            // $('#valor_refuente').text(0);
            // $('#valor_rete_ica').text(0);
            // $('#valor_rete_iva').text(rete_iva());
            // $('#valor_impuesto_consumo').text(0);
            // $('#total').text(total());
        },
        quitarItem:function(){
            arraypushx.splice($('.selected').index(), 1);
            t.row('.selected').remove().draw(false);

            // $('#valor_bruto').text(0);
            // $('#descuento').text(0);
            // $('#subtotal').text(0);
            // $('#iva').text(0);
            // $('#valor_iva').text(0);
            // $('#valor_refuente').text(0);
            // $('#valor_rete_ica').text(0);
            // $('#valor_rete_iva').text(rete_iva());
            // $('#valor_impuesto_consumo').text(0);
            // $('#total').text(total());
        },
        calculaPrecioBolsa:function(){
            var precio = getPrecioBolsa();
            var numero_bolsas = ($('#numero_bolsas').val() == "") ? 0 : $('#numero_bolsas').val();
            
            $('#v_impuesto_consumo').val(parseInt(precio) * parseInt(numero_bolsas));
            $('#productosVenta input').keyup();
        }
        
    }
})();

$(document).ready(function(){

    $(".money").each(function () {
        $(this).val(money.replace($(this).val()));
    });

    $('#numero_bolsas').keyup(function(){
        funcion.calculaPrecioBolsa();
    });

    $('#productosVenta').DataTable({ language: { url: urlBase.make('plugins/datatable/DataTables-1.10.13/json/spanish.json') } });
    
    $('#numero_documento').blur(function(){
        funcion.info_cliente();
    });

    $('#referencia').keyup(function(){
        funcion.buscarProducto();
    });

    $('#addproduct').click(function(){
        funcion.addproduct();
    });

    $('#btn_quitar_item').click(function () {
        funcion.quitarItem();
    });

    $('#productosVenta tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            t.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#facturar').click(function () {
        PNotify.removeAll();
        $('#facturar').css('display', 'none');
        Alerta('Información', 'Factura creada con exito','success',false);
        Alerta('Información', 'En breve sera redireccionado','success',false);
        setTimeout(function () {
            pageAction.redirect(urlBase.make('generarplan'));
        }, 7000);
    })

});


function selectValue(val){
    $('#precio').val('');
    $('#concepto').val('');
    $('#descripcion').val('');
    var datos = val.value.split("|");

    $('#referencia').val(datos[1]);
    $('#descripcion').val(datos[2]);
    $('#lote').val(datos[3]);
    $('#id_inventario').val(datos[4]);
    $('#precio').val(datos[5]);
    $('.content_buscador').hide('slow');
    if (limpiar_texto(datos[5]) != "") $('#addproduct').css('display', '');
    $(".moneda").each(function () {
        $(this).val(money.replace($(this).val()));
    });
}

function total() {
    var arraySum = [];
    var total = 0;
    for (var i = 0; i < arraypushx.length; i++) {
        arraySum.push(arraypushx[i]['precio']);
    }
    total = sumNumbers(arraySum);
    total = money.replace(total.toString());
    return total;
}

function calculaValoresIVA(porcentaje = 0, text, $class, label, valor)
{
    var porcen = porcentaje.split("|");
    var porcenx = porcen[0] / 100;
    porcenx = porcenx + 1;
    var resultado = (limpiarVal(valor) / porcenx);
    resultado = limpiarVal(valor) - Math.round(resultado);
    $('#' + text).val(resultado);
    var val = 0;
    $('.'+$class).each(function () {
        if ($(this).attr("id") != text) val = val + parseInt($(this).val());
    });
    $('#' + label).val(resultado + val);
    $(".money").each(function () {
        $(this).val(money.replace($(this).val()));
    });
}

function calculaValoresRetIVA(porcentaje = 0, text, $class, label, valor, id_inventario)
{
    var porcen = porcentaje.split("|");
    var valor = $(`#valor_iva_${id_inventario}`).val();
    var resultado = (porcen[0] * limpiarVal( valor ) ) / 100;
    resultado = Math.round(resultado);
    console.log(resultado);
    $('#' + text).val(resultado);
    var val = 0;
    var valc = 0;
    $('.'+$class).each(function () {
        if ($(this).attr("id") != text) val = val + parseInt(limpiarVal($(this).val()));
    });
    
    $('#' + label).val(resultado + val);
    
    $(`#valor_iva_${id_inventario}`).val(parseInt(limpiarVal($(`#valor_iva_${id_inventario}`).val())) - resultado);
    $('.v_iva').each(function () {
        if ($(this).attr("id") != text) valc = valc + parseInt(limpiarVal($(this).val()));
    });
    $(`#v_iva`).val(valc.toString());
    $(".money").each(function () {
        $(this).val(money.replace($(this).val()));
    });
}

function calculaValores(porcentaje = 0, text, $class, label, valor, id_inventario)
{

    var porcen = porcentaje.split("|");
    var porcenx = porcen[0] / 100;
    porcenx = porcenx + 1;
    var resultado = limpiarVal(valor) - Math.round(limpiarVal(valor) / porcenx),
        subtotal = 0,
        valor_iva = 0,
        can_productos = $('#productosVenta tbody tr').length,
        valor_consumo = ($('#v_impuesto_consumo').val() == "") ? valor_consumo = 0 : valor_consumo = (parseFloat(limpiarVal($('#v_impuesto_consumo').val())) / can_productos);
    
    $('#' + text).val(limpiarValInverso(resultado.toString()));
    var val = 0;
    $('.'+$class).each(function () {
        if ($(this).attr("id") != text) val = val + parseInt($(this).val());
    });
    
    var resta = parseFloat( limpiarVal($(`#valor_total_${id_inventario}`).val())) - valor_consumo - parseFloat(limpiarVal($(`#valor_iva_${id_inventario}`).val())) - Math.round(parseFloat(limpiarVal($(`#valor_retefuente_${id_inventario}`).val()))) - Math.round(parseFloat(limpiarVal($(`#valor_renteica_${id_inventario}`).val()))) ;
    // console.log(resta);
    $('#' + label).val(resultado + val);
    $(`#precio_${id_inventario}`).val( resta );
    $(".v_precio").each(function () {
        subtotal = parseFloat(limpiarVal($(this).val())) + parseFloat(subtotal);
    });
    $(".v_iva").each(function () {
        valor_iva = parseFloat(limpiarVal($(this).val())) + parseFloat(valor_iva);
    });
    $(`#subtotal`).val(subtotal);
    $(`#base_iva`).val(subtotal);
    $(`#v_iva`).val(valor_iva);
    $(".money").each(function () {
        $(this).val(money.replace($(this).val()));
    });
}

function calculaValoresICA(porcentaje = 0, text, $class, label, valor, id_inventario)
{

    var porcen = porcentaje.split("|");
    var porcenx = porcen[0];
    var resultado = Math.round((limpiarVal(valor) * porcenx) / 1000),
        subtotal = 0,
        valor_iva = 0,
        can_productos = $('#productosVenta tbody tr').length,
        valor_consumo = ($('#v_impuesto_consumo').val() == "") ? valor_consumo = 0 : valor_consumo = (parseFloat(limpiarVal($('#v_impuesto_consumo').val())) / can_productos);

    $(`#${text}`).val(limpiarValInverso(resultado.toString()));
    var val = 0;
    $(`.${$class}`).each(function () {
        if ($(this).attr("id") != text) val = val + parseInt($(this).val());
    });
    var resta = parseFloat(limpiarVal($(`#valor_total_${id_inventario}`).val())) - valor_consumo - parseFloat(limpiarVal($(`#valor_iva_${id_inventario}`).val())) - Math.round(parseFloat(limpiarVal($(`#valor_retefuente_${id_inventario}`).val()))) - Math.round(parseFloat(limpiarVal($(`#valor_renteica_${id_inventario}`).val())));
    $('#' + label).val(resultado + val);
    $(`#precio_${id_inventario}`).val(resta);
    $(".v_precio").each(function () {
        subtotal = parseFloat(limpiarVal($(this).val())) + parseFloat(subtotal);
    });
    $(".v_iva").each(function () {
        valor_iva = parseFloat(limpiarVal($(this).val())) + parseFloat(valor_iva);
    });
    $(`#subtotal`).val(subtotal);
    $(`#base_iva`).val(subtotal);
    $(`#v_iva`).val(valor_iva);
    $(".money").each(function () {
        $(this).val(money.replace($(this).val()));
    });
}

function calcular_precio(id_inventario, valor){
    // var total = parseInt(limpiarVal($('#valor_descuento_' + id_inventario).val())) + parseInt(limpiarVal($('#valor_iva_' + id_inventario).val())) + parseInt(limpiarVal($('#valor_retefuente_' + id_inventario).val())) + parseInt(limpiarVal($('#valor_renteica_' + id_inventario).val())) + parseInt(limpiarVal($('#valor_renteiva_' + id_inventario).val())) + parseInt(limpiarVal($('#valor_consumo_' + id_inventario).val()));
    // var can_productos = $('#productosVenta tbody tr').length,
    //     valor_consumo = ($('#v_impuesto_consumo').val() == "") ? valor_consumo = 0 : valor_consumo = (parseFloat(limpiarVal($('#v_impuesto_consumo').val())) / can_productos);
    // var resta = parseFloat(limpiarVal($(`#valor_total_${id_inventario}`).val())) - valor_consumo - parseFloat(limpiarVal($(`#valor_iva_${id_inventario}`).val())) - Math.round(parseFloat(limpiarVal($(`#valor_retefuente_${id_inventario}`).val()))) - Math.round(parseFloat(limpiarVal($(`#valor_renteica_${id_inventario}`).val())));
    // $('#precio_' + id_inventario).val(resta);
    // $('#subtotal').val(res);
    // $('#base_iva').val(res);
    // $(".money").each(function () {
    //     $(this).val(money.replace($(this).val()));
    // });
}

function calcular_precio_retiva() {
    var total = 0;
    $('.v_reteiva').each(function () {
        total = parseInt(total) + parseInt(limpiarVal($(this).val()));
    });
    $('#v_reteiva').val(total);
    
    $(".money").each(function () {
        $(this).val(money.replace($(this).val()));
    });
}

function calcular_precio_retica() {
    var total = 0;
    $('.v_reteica').each(function () {
        total = parseInt(total) + parseInt(limpiarVal($(this).val()));
    });
    $('#v_reteica').val(total);
    
    $(".money").each(function () {
        $(this).val(money.replace($(this).val()));
    });
}

function calcular_precio_retfuente() {
    var total = 0;
    $('.v_retefuente').each(function () {
        total = parseInt(total) + parseInt(limpiarVal($(this).val()));
    });
    $('#v_retefuente').val(total);
    
    $(".money").each(function () {
        $(this).val(money.replace($(this).val()));
    });
}


function limpiar_texto($var) {
    if ($var != '' && $var !== undefined && $var != undefined && $var != "undefined" && $var !== null) {
        return $var;
    } else {
        return '';
    }
}

function limpiarVal(val) {
    var valLimpiar = val.replace(/\./g, '');
    valLimpiar = valLimpiar.replace(',', '.', valLimpiar);
    valLimpiar = valLimpiar.trim(valLimpiar);
    return valLimpiar;
}

function limpiarValInverso(val) {
    var valLimpiar = val.replace('.', ',');
    valLimpiar = valLimpiar.trim(valLimpiar);
    return valLimpiar;
}

function getPrecioBolsa() 
{
    var response = "";
    $.ajax({
        url: urlBase.make('ventas/getPrecioBolsa'),
        type: "get",
        async: false,
        success: function (data) {
            response = data.precio_bolsa;
        }
    });
    return response;
}
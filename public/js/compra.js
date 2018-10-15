var t = $('#productosVenta').DataTable();
var arraypushx = new Array();
var arrayCheck = new Array();
var count_items = 0;
var funcion = (function(){
    return{
        info_proveedor:function(){
            var tipo_documento = limpiar_texto($('#tipo_documento').val());
            var numero_documento = limpiar_texto($('#numero_documento').val());
            if(tipo_documento != ""){
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: urlBase.make('compras/getProveedor'),
                    type: 'get',
                    data: {
                        tipo_documento: tipo_documento,
                        documento: numero_documento
                    },
                    success: function (datos) {
                        if (limpiar_texto(datos.nombre)) {

                            $('#nombre').val(limpiar_texto(datos.nombre));
                            $('#sucursal').val(limpiar_texto(datos.sucursal));
                            $('#direccion').val(limpiar_texto(datos.direccion));
                            $('#regimen').val(limpiar_texto(datos.regimen));
                            $('#telefono').val(limpiar_texto(datos.telefono));
                            $('#id_ciudad').val(limpiar_texto(datos.id_ciudad));
                            $('#id_proveedor').val(limpiar_texto(datos.codigo_proveedor));
                            $('#id_tienda_proveedor').val(limpiar_texto(datos.id_tienda_proveedor));
                            
                            fillInput('#id_ciudad', '#telefono_indicativo', urlBase.make('/ciudad/getinputindicativo2'));
                            
                        }else{
                            $('#cliente').val('0');
                            $('.clear').each(function(){
                                $(this).val('');
                            });
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
            if ($('#referencia').val().length > 1) {
                $('.content_buscador').show('slow');
                $.ajax({
                    url: urlBase.make('compras/getInventarioByName'),
                    type: "get",
                    data: {
                        referencia: $('#referencia').val()
                    },
                    success: function (data) {
                        var j = 0;
                        var id_inven = "";
                        jQuery.each(data, function (i, val) {
                            if (limpiar_texto(data[j]) != "") {
                                option += '<option value="' 
                                    + data[j].id + '|' 
                                    + data[j].nombre + '|' 
                                    + data[j].descripcion + '|' 
                                    + data[j].id_categoria + '|' 
                                    + '" >' 
                                    + data[j].nombre + ' - ' + data[j].descripcion 
                                    + '</option>';
                                j++;
                            }
                        });
                        $('#select_codigo_inventario').empty().append(option);
                        option = "";
                    }
                })
            }
        },
        addproduct:function(){
            var paso = 1;
            var vaciar = 0;
            if (limpiar_texto($('#referencia').val()) != '') {

                for (var i = 0; i < arraypushx.length; i++) {
                    if (arraypushx[i]['codigo_inventario'] == $('#id_inventario').val() || arraypushx[i]['id_categoria'] != $('#id_categoria').val()) {
                        (arraypushx[i]['codigo_inventario'] == $('#id_inventario').val()) ? paso = 0 : paso = 2;
                    }
                }
                if ($('#costo').val() == "") {
                    vaciar = 1;
                    $('#costo').attr('placeholder', 'Este campo es obligatorio').css('border-color', '#ff0000');
                } else if($('#precio').val() == "") {
                    vaciar = 1;
                    $('#precio').attr('placeholder', 'Este campo es obligatorio').css('border-color','#ff0000');
                } else if (paso == 1) {
                    vaciar = 0;
                    $('#costo').css('border-color','#cccccc').attr('placeholder', '');
                    $('#precio').css('border-color','#cccccc').attr('placeholder', '');
                    arraypushx.push({
                        id_tienda: limpiar_texto($('#id_tienda').val()),
                        codigo_inventario: limpiar_texto($('#id_inventario').val()),
                        precio: limpiar_texto($('#precio').val()),
                        id_categoria: limpiar_texto($('#id_categoria').val()),
                        costo: limpiar_texto($('#costo').val()),
                        cantidad: limpiar_texto($('#cantidad').val()),
                    });
                    var arr_names = ['id_inventario', 'precio', 'costo', 'id_categoria', 'iva', 'porcentaje_descuento', 'valor_descuento', 'cantidad' ];
                    for (var i = 0; i < arr_names.length; i++) {
                        $('#arr_venta').append(`<input type="hidden" name="arr_i_compra[${count_items}][${arr_names[i]}]" value="${limpiar_texto($(`#${arr_names[i]}`).val())}">`);
                    }                    
                    
                    t.row.add([
                        $('#referencia').val(),
                        $('#descripcion').val(),
                        $('#costo').val(),
                        $('#precio').val(),
                        $('#cantidad').val(),
                        0,
                        0,
                        0,
                        0,
                        0,
                        valor_total()
                    ]).draw(false);
                    $('#concepto_' + $('#id_inventario').val()).val($('#concepto').val());
                    $('#addproduct').css('display', 'none');
                    $('#alertPas').css('display', 'none');
                    ++count_items;
                } else {
                    if(paso == 0){
                        $('#addproduct').css('display', 'none');
                        $('#alertPas').css('display', 'block');
                        $('#textAlert').text('Este producto ya se agrego recientemente.');
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }else if(paso == 2){
                        $('#addproduct').css('display', 'none');
                        $('#alertPas').css('display', 'block');
                        $('#textAlert').text('Este producto no pertenece a la misma categoria.');
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
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
                $('#costo').val('');
                $('#descripcion').val('');
                $('#id_inventario').val('');
                $('#id_categoria').val('');
                $('#cantidad').val('');
                $('#costo').val('');
            }

            $('#valor_bruto').text(valor_bruto());
            $('#descuento').text(valor_descuento());
            $('#subtotal').text(subtotal());
            $('#iva').text(baseiva());
            $('#valor_iva').text(iva());
            $('#valor_refuente').text(valor_refuente());
            $('#valor_rete_ica').text(rete_ica());
            $('#valor_rete_iva').text(rete_iva());
            $('#valor_impuesto_consumo').text(impuestos());
            $('#total').text(total());
        },
        quitarItem:function(){
            var pos = $('.selected').index();
            arraypushx.splice(pos, 1);
            t.row('.selected').remove().draw(false);

            $('#valor_bruto').text(valor_bruto());
            $('#descuento').text(valor_descuento());
            $('#subtotal').text(subtotal());
            $('#iva').text(baseiva());
            $('#valor_iva').text(iva());
            $('#valor_refuente').text(valor_refuente());
            $('#valor_rete_ica').text(rete_ica());
            $('#valor_rete_iva').text(rete_iva());
            $('#valor_impuesto_consumo').text(impuestos());
            $('#total').text(total());
        },
        devolucionCompra:function(){
            var i = 0;
            arrayCheck = new Array();
            $("input:checked").each(function () {
                var val = $(this).val();
                val = val.split("/");
                arrayCheck.push({
                    id_inventario: val[0],
                    id_tienda: val[1],
                    nombre_tienda: $(this).parent().parent().find('td:nth-child(2)').text(),
                    lote: $(this).parent().parent().find('td:nth-child(3)').text(),
                    referencia: $(this).parent().parent().find('td:nth-child(4)').text(),
                    costo: $(this).parent().parent().find('td:nth-child(5)').text(),
                    precio: $(this).parent().parent().find('td:nth-child(6)').text(),
                    fecha_compra: $(this).parent().parent().find('td:nth-child(7)').text()
                });

                i++;    
            });
            var d = '';
            for (var j = 0; j < arrayCheck.length; j++) {
                d += '<tr>' +
                        '<td>' + arrayCheck[j].nombre_tienda + '</td>' +
                        '<td>' + arrayCheck[j].lote + '</td>' +
                        '<td>' + arrayCheck[j].referencia + '</td>' +
                        '<td>' + arrayCheck[j].costo + '</td>' +
                        '<td>' + arrayCheck[j].precio + '</td>' +
                        '<td>' + arrayCheck[j].fecha_compra + '</td>' +
                    '</tr>';
            }
            $("#table_devolucion tbody").html(d);
        },
        devolverCompra:function(){
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: urlBase.make('compras/devolverCompra'),
                type: "post",
                data: {
                    datos: arrayCheck
                },
                success:function(data){
                    if (!data.val) {
                        Alerta('Error', data.msm, 'error');
                        // pageAction.redirect(urlBase.make('compras'));
                    } else {
                        Alerta('Información', data.msm);
                        pageAction.redirect(urlBase.make('compras'));
                    }
                }
            })
        }
    }
})();

$(document).ready(function(){
    $('#productosVenta').DataTable({ language: { url: urlBase.make('plugins/datatable/DataTables-1.10.13/json/spanish.json') } });
    
    $('#numero_documento').blur(function(){
        funcion.info_proveedor();
    });

    $('#referencia').keypress(function(){
        funcion.buscarProducto();
    });

    $('#addproduct').click(function(){
        funcion.addproduct();
    });

    $('#btn_quitar_item').click(function(){
        funcion.quitarItem();
    });

    $('#devolver').click(function(){
        funcion.devolverCompra();
    });

    $('#btn_quitar_item').click(function(){
        funcion.devolucionCompra();
        if (arrayCheck.length > 0){
            $('#myModal').modal('show');
        }else{
            Alerta('Error', 'Debe de seleccionar almenos un producto para poder quitarlo.', 'error');
        }
    })
    
    $('#tipo_documento').change(function(){
        if($(this).val() == "1"){
            $('#div_digito').css('display', 'none').val('');
            $('#ndoc').removeClass('col-md-9').addClass('col-md-12').val('');
        }else{
            $('#div_digito').css('display', '').val('');
            $('#ndoc').removeClass('col-md-12').addClass('col-md-9').val('');
        }
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

});


function selectValue(val){
    $('#precio').val('');
    $('#costo').val('');
    $('#descripcion').val('');
    $('#cantidad').val('');
    var datos = val.value.split("|");

    $('#id_inventario').val(datos[0]);
    $('#referencia').val(datos[1]);
    $('#descripcion').val(datos[2]);
    $('#id_categoria').val(datos[3]);
    $('.content_buscador').hide('slow');
    if (limpiar_texto(datos[1]) != "") $('#addproduct').css('display', '');
    $(".moneda").each(function () {
        $(this).val(money.replace($(this).val()));
    });
}

function total() {
    var arraySum = [];
    var total = 0;
    var valor = 0;
    var precio = 0;
    for (var i = 0; i < arraypushx.length; i++) {
        precio = arraypushx[i]['precio']; 
        precio = precio.replace(/\./g, "");
        valor = eval(precio) * eval(arraypushx[i]['cantidad']);
        valor = money.replace(valor.toString());

        arraySum.push(valor);
    }
    total = sumNumbers(arraySum);
    total = money.replace(total.toString());
    return total;
}

function subtotal() {
    var subtotal = 0;
    return subtotal;
}

function impuestos() {
    var impuestos = 0;
    return impuestos;
}

function retenciones() {
    var retenciones = 0;
    return retenciones;
}

function iva() {
    var iva = 0;
    return iva;
}

function baseiva() {
    var baseiva = 0;
    return baseiva;
}

function rete_ica() {
    var rete_ica = 0;
    return rete_ica;
}

function valor_bruto() {
    var valor_bruto = 0;
    return valor_bruto;
}

function valor_descuento() {
    var valor_descuento = 0;
    return valor_descuento;
}

function valor_refuente() {
    var valor_refuente = 0;
    return valor_refuente;
}

function rete_iva() {
    var rete_iva = 0;
    return rete_iva;
}

function valor_total()
{
    var valor_total = 0;
    var precio = $('#precio').val();
    precio = precio.replace(/\./g, "");

    valor_total = eval(precio) * eval($('#cantidad').val());
    valor_total = money.replace(valor_total.toString());
    return valor_total;
}

function checksDevolucionAll(e)
{
    if ($(e).prop('checked')) {
        $('.check-select').prop('checked', true);
        $('.check-select').val('1');
    } else {
        $('.check-select').prop('checked', false);
        $('.check-select').val('0');
    }
}




function limpiar_texto($var) {
    if ($var != '' && $var !== undefined && $var != undefined && $var != "undefined" && $var !== null) {
        return $var;
    } else {
        return '';
    }
}

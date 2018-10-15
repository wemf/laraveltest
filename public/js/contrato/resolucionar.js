// Author				:	<Andrey Higuita>
// Create date	:	<Jueves, 15 de febrero de 2018>
// Description	:	<Javascript para las funciones del lado del cliente para realizar el proceso del primer paso de la resolución (perfeccionamiento de contratos)>

var resolucion = (function(){
    var id_proceso_old;
    return {
        ordenes_resolucion:function(){
            return {
                document_ready:function(){
                    loadSelectInput('.slc_categoria_general', urlBase.make('products/categories/getCategory'), true);
                    loadSelectInput(".slc_tienda", urlBase.make('/tienda/getSelectList'), true);
                    loadSelectInput(".slc_tipo_documento", urlBase.make('/clientes/tipodocumento/getSelectList2'), true);
                    this.detalles_tabla();
                },
                meses_adeudados:function(value){
                    if(value == 7){
                        $('#filter_col10').removeClass('hide');
                    }else{
                        $('#filter_col10').addClass('hide');
                    }
                },
                detalles_tabla:function(){
                    $('#table_resolucion tbody').on('click', 'td.details-control', function () {
                        var tr = $(this).closest('tr');
                        var codigo_contrato = $(tr).attr('id');
                        var id_tienda = $('#col0_filter').val();
                        var row = table_multi_select.row( tr );

                        if ( row.child.isShown() ) {
                            // This row is already open - close it
                            row.child.hide();
                            tr.removeClass('shown');
                        }
                        else {
                            // Open this row
                            row.child( resolucion.ordenes_resolucion().detalle_tabla_html(codigo_contrato, id_tienda) ).show();
                            tr.addClass('shown');
                        }
                    } );
                },
                detalles_tabla_guardada:function(){
                    $('#table_resolucion tbody').on('click', 'td.details-control', function () {
                        var tr = $(this).closest('tr');
                        var codigo_orden = $(tr).attr('id');
                        var id_tienda = $('#col0_filter').val();
                        var row = table_multi_select.row( tr );

                        if ( row.child.isShown() ) {
                            // This row is already open - close it
                            row.child.hide();
                            tr.removeClass('shown');
                        }
                        else {
                            // Open this row
                            row.child( resolucion.ordenes_resolucion().detalle_tabla_html_guardada(codigo_orden, id_tienda) ).show();
                            tr.addClass('shown');
                        }
                    } );
                },
                detalle_tabla_html:function(codigo_contrato, id_tienda){
                    var total_cantidad = 0, total_precio = 0, total_peso_estimado = 0, total_peso_total = 0;
                    var html_tabla = '<div class="contenedor_detalle"><div class="flip"></div><table>';
                    var cant_cols = 0;
                    $.ajax({
                        url: urlBase.make('creacioncontrato/getitemscontrato/' + codigo_contrato + '/' + id_tienda),
                        type: "get",
                        async: false,
                        success: function(datos) {
                            cant_cols = 0;
                            html_tabla += '<thead><th>Código Contrato</th><th>Linea Item</th>';
                            jQuery.each(datos.columnas_items, function(indice, valor){
                                html_tabla += `<th>${ datos.columnas_items[indice].nombre }</td>`;
                                ++cant_cols; // SE SUMA LA CANTIDAD DE COLUMNAS PARA AGREGARLAS EN EL FOOTER
                            });
                            html_tabla += '<th>Atributos</th><th>Precio</th><th>Peso Total</th><th>Peso Estimado</th><th>Cantidad</th></thead>';
                            jQuery.each(datos.data, function(indice, valor) {
                                total_precio += parseFloat(datos.data[indice].Precio_Item.replace('$ ', '').replace(/\./g, '').replace(',', '.'));
                                total_peso_estimado += parseFloat(datos.data[indice].Precio_Estimado_Item.replace(/\./g, '').replace(',', '.'));
                                total_peso_total += parseFloat(datos.data[indice].Peso_Total_Item.replace(/\./g, '').replace(',', '.'));
                                ++total_cantidad;
                                html_tabla +=
                                    `<tr>
                                        <td>${ datos.data[indice].Codigo_Contrato }</td>
                                        <td>${ datos.data[indice].Linea_Item }</td>`;

                                jQuery.each(datos.columnas_items, function(indice_columnas, valor_columnas){
                                    var col_print = 0;
                                    jQuery.each(datos.datos_columnas_items, function(indice_datos, valor_datos){
                                        if(datos.columnas_items[indice_columnas].nombre == datos.datos_columnas_items[indice_datos].atributo && datos.datos_columnas_items[indice_datos].linea_item == datos.data[indice].Linea_Item && col_print == 0){
                                            html_tabla += `<td>${ datos.datos_columnas_items[indice_datos].valor }</td>`;
                                            col_print = 1;
                                        }
                                    });
                                    if(col_print == 0){
                                        html_tabla += `<td></td>`;
                                    }
                                });

                                html_tabla +=
                                        `<td>${ datos.data[indice].Nombre_Item }</td>
                                        <td>$ ${ money.replace( datos.data[indice].Precio_Item ) }</td>
                                        <td>${ datos.data[indice].Peso_Total_Item }</td>
                                        <td>${ datos.data[indice].Precio_Estimado_Item }</td>
                                        <td>1</td>
                                    </tr>`;
                            });
                        }
                    });

                    html_tabla += `<tfoot><td></td><td></td>`;

                    for (var i = 0; i < cant_cols; i++) {
                      html_tabla += `<td></td>`;
                    }

                    return html_tabla += `<td>Totales</td><td>$ ${ money.replace( total_precio.toString() ) }</td><td>${ total_peso_total.toFixed(2).toString().replace('.', ',') }</td><td>${ total_peso_estimado.toFixed(2).toString().replace('.', ',') }</td><td>${ total_cantidad }</td></tfoot></table></div>`;
                },
                detalle_tabla_html_guardada:function(codigo_orden, id_tienda){
                    var total_cantidad = 0, total_precio = 0, total_peso_estimado = 0, total_peso_total = 0;
                    var html_tabla = '<div class="contenedor_detalle"><div class="flip"></div><table>';
                    var cant_cols = 0;
                    $.ajax({
                        url: urlBase.make('contratos/resolucionar/getitemscontrato/' + codigo_orden + '/' + id_tienda),
                        type: "get",
                        async: false,
                        success: function(datos) {
                            cant_cols = 0;
                            html_tabla += '<thead><th>Código Contrato</th><th>Linea Item</th>';
                            jQuery.each(datos.columnas_items, function(indice, valor){
                                html_tabla += `<th>${ datos.columnas_items[indice].nombre }</td>`;
                                ++cant_cols; // SE SUMA LA CANTIDAD DE COLUMNAS PARA AGREGARLAS EN EL FOOTER
                            });
                            html_tabla += '<th>Atributos</th><th>Precio</th><th>Peso Total</th><th>Peso Estimado</th><th>Cantidad</th></thead>';
                            jQuery.each(datos.data, function(indice, valor) {
                                total_precio += parseFloat(datos.data[indice].Precio_Item.replace('$ ', '').replace(/\./g, '').replace(',', '.'));
                                total_peso_estimado += parseFloat(datos.data[indice].Precio_Estimado_Item.replace(/\./g, '').replace(',', '.'));
                                total_peso_total += parseFloat(datos.data[indice].Peso_Total_Item.replace(/\./g, '').replace(',', '.'));
                                ++total_cantidad;
                                html_tabla +=
                                    `<tr>
                                        <td>${ datos.data[indice].Codigo_Contrato }</td>
                                        <td>${ datos.data[indice].Linea_Item }</td>`;

                                jQuery.each(datos.columnas_items, function(indice_columnas, valor_columnas){
                                    var col_print = 0;
                                    jQuery.each(datos.datos_columnas_items, function(indice_datos, valor_datos){
                                        if(datos.columnas_items[indice_columnas].nombre == datos.datos_columnas_items[indice_datos].atributo && datos.datos_columnas_items[indice_datos].linea_item == datos.data[indice].Linea_Item && col_print == 0){
                                            html_tabla += `<td>${ datos.datos_columnas_items[indice_datos].valor }</td>`;
                                            col_print = 1;
                                        }
                                    });
                                    if(col_print == 0){
                                        html_tabla += `<td></td>`;
                                    }
                                });

                                html_tabla +=
                                        `<td>${ datos.data[indice].Nombre_Item }</td>
                                        <td>$ ${ money.replace( datos.data[indice].Precio_Item ) }</td>
                                        <td>${ datos.data[indice].Peso_Total_Item }</td>
                                        <td>${ datos.data[indice].Precio_Estimado_Item }</td>
                                        <td>1</td>
                                    </tr>`;
                            });
                        }
                    });

                    html_tabla += `<tfoot><td></td><td></td>`;

                    for (var i = 0; i < cant_cols; i++) {
                      html_tabla += `<td></td>`;
                    }

                    return html_tabla += `<td>Totales</td><td>$ ${ money.replace( total_precio.toString() ) }</td><td>${ total_peso_total.toFixed(2).toString().replace('.', ',') }</td><td>${ total_peso_estimado.toFixed(2).toString().replace('.', ',') }</td><td>${ total_cantidad }</td></tfoot></table></div>`;
                },
                resolucionar:function(){
                    var contratos = "";
                    var cont = 0;
                    $('#table_resolucion .check-resolucionar:checked').each(function(){
                        if(cont > 0)
                            contratos += "-";
                        contratos += $(this).parent().parent().parent().attr('id');
                        ++cont;
                    });

                    ( contratos != "" ) ? location.href = urlBase.make('contratos/resolucionar/hojatrabajo/' + $('#col0_filter').val() + "/" + contratos) : Alerta( 'Alerta', 'Debe seleccionar por lo menos un contrato', 'warning' );


                }
            }
        },
        hoja_trabajo:function(){
            return {
                document_ready:function(){
                    this.subdividir_items();
                    this.subdividir_mouse_down();
                    this.subdividir_click();
                },
                procesar:function(){
                    if(validateRequiredInput('#cont_fran')){
                        setTimeout(function () { location.href = urlBase.make('contratos/resolucionar'); }, 5000);
                        $("#form_resolucionar").attr("action", urlBase.make('contratos/resolucionar/hojatrabajo/procesar'));
                        $('#form_resolucionar').submit();
                    }
                },
                procesar_perfeccionamiento:function(){
                    // if(validateRequiredInput('#cont_fran')){
                        // setTimeout(function () { location.href = urlBase.make('contrato/resolucion'); }, 5000);
                        $("#form_resolucionar").attr("action", urlBase.make('contratos/resolucionar/hojatrabajo/procesar'));
                        // $('#form_resolucionar').submit();
                    // }
                },
                guardar:function(){
                    // setTimeout(function () { location.href = urlBase.make('contratos/resolucionar'); }, 5000);
                    $("#form_resolucionar").attr("action", urlBase.make('contratos/resolucionar/hojatrabajo/guardar'));
                    $('#form_resolucionar').submit();
                },
                actualizar:function(){
                    // setTimeout(function () { location.href = urlBase.make('contratos/resolucionar'); }, 5000);
                    $("#form_resolucionar").attr("action", urlBase.make('contratos/resolucionar/hojatrabajo/actualizar'));
                    $('#form_resolucionar').submit();
                },
                subdividir_items:function(){
                    $('.subdividir').change(function(){
                        var id_proceso = $(this).find('option:selected').val();
                        if(id_proceso != "")
                        {
                            if(resolucion.hoja_trabajo().validate_process(id_proceso_old)){
                                $('.table_destinatario tr[data-proceso="' + id_proceso_old + '"]').remove();
                            }
                            var exist = false;
                            $('.table_destinatario tr[data-proceso="' + id_proceso + '"]').each(function(){
                                exist = true;
                            });
                            if(!exist){
                                var html_tabla="";
                                html_tabla +=
                                `<tr data-proceso='${id_proceso}'>
                                <td>  ${$(this).find('option:selected').text()} </td>
                                <td><input type="text" id="numero_bolsa" name="numero_bolsa[]" class="form-control" required></td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input  class="form-control resertInp buscar_destinatario" placeholder="Nombre proveedor" onkeyup="buscarDestinatario(this);"  type="text" id="buscar_destinatario" name="buscar_destinatario">
                                            <div class="content_buscador" style="display:none;">
                                                <select name="select_buscar_destinatario" size="4" class="form-control co-md-12 select_buscar_destinatario" onclick="selectValue(this);"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" id="numero_documento" placeholder="Nit proveedor" name="numero_documento[]" class="form-control nit" required="required">
                                                <span class="input-group-addon white-color">
                                                    <input id="prueba" maxlength='1' name="digito_verificacion[]" type="text" class="nit-val"
                                                        onBlur="validarNit(this)" required>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td> <label class="nombres" name = "nombres[]"></>  </td>
                                <td> <label class="telefonos" name = "telefonos[]"></>  </td>
                                <td>
                                    <select name="sucursales[]" class="form-control select-suc">
                                    <option value=""> Seleccione opción </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="id_proceso[]" value='${id_proceso}'>
                                    <input type="hidden" class = "id_cliente" name="id_cliente[]">
                                    <input type="hidden" class = "id_tienda_cliente" name="id_tienda_cliente[]">
                                </td>
                                </tr>`;
                                $('.items_dest').find('tbody').append(html_tabla);
                            }
                        };
                    });
                },
                subdividir_mouse_down:function(){
                    $('.subdividir').mousedown(function(){
                        id_proceso_old = $(this).find('option:selected').val();
                    })
                },
                validate_process:function(id_proceso_old){
                    var cont_process = 0;
                    $('.subdividir option:selected[value="' + id_proceso_old + '"]').each(function(){
                        ++cont_process;
                    });
                    if(cont_process > 0){
                        return false;
                    }else{
                        return true;
                    }
                },
                subdividir_click:function(){
                    $('#subdividir').click(function(){
                        if($(this).val() == "0"){
                            $(".subdividir").css('display','table-cell');
                            $("#cont-selectAll").css('display','inline-block');
                            $(".select-sub").each(function(){
                                $(this).addClass("requiered");

                            });
                            $('.peso_joyeria').addClass("requiered");
                            $('.peso_joyeria').removeAttr("disabled");
                            $('.peso_joyeria').val("");
                            $('.select-sub option:nth-child(1)').prop('selected', 'selected');
                            $('#procesar').val('0');
                            $('.items_dest tbody tr').remove();
                        }else{
                            $(".subdividir").css('display', 'none');
                            $("#cont-selectAll").css('display', 'none');
                            $(".select-sub").each(function () {
                                $(this).removeClass("requiered");
                            });
                            $('.peso_joyeria').removeClass("requiered");
                            $('.peso_joyeria').attr("disabled", "disabled");
                            $('.peso_joyeria').each(function(){
                                $(this).val($(this).parent().parent().find('.peso_estimado_dest').text().replace(',', '.'));
                            });
                            $('.select-sub option[value="16"]').prop('selected', 'selected');
                            $('#procesar').val('1');
                            $('.items_dest tbody tr').remove();
                            var html_tabla = `<tr data-proceso="16">
                                                <td>Pre-refacción</td>
                                                <td><input type="text" id="numero_bolsa" name="numero_bolsa[]" class="form-control" required></td>
                                                <td>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <input  class="form-control resertInp buscar_destinatario" placeholder="Nombre proveedor" onkeyup="buscarDestinatario(this);"  type="text" id="buscar_destinatario" name="buscar_destinatario">
                                                        <div class="content_buscador" style="display:none;">
                                                            <select name="select_buscar_destinatario" size="4" class="form-control co-md-12 select_buscar_destinatario" onclick="selectValue(this);"></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="input-group">
                                                            <input type="text" id="numero_documento" placeholder="Nit proveedor" name="numero_documento[]" class="form-control nit" required="required">
                                                            <span class="input-group-addon white-color">
                                                                <input id="prueba" maxlength='1' name="digito_verificacion[]" type="text" class="nit-val"
                                                                    onBlur="validarNit(this)" required>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <td> <label class="nombres" name = "nombres[]"></>  </td>
                                                <td> <label class="telefonos" name = "telefonos[]"></>  </td>
                                                <td>
                                                    <select name="sucursales[]" class="form-control select-suc">
                                                    <option value=""> Seleccione opción </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="id_proceso[]" value='16'>
                                                    <input type="hidden" class = "id_cliente" name="id_cliente[]">
                                                    <input type="hidden" class = "id_tienda_cliente" name="id_tienda_cliente[]">
                                                </td>
                                            </tr>`;
                            $('.items_dest').find('tbody').append(html_tabla);
                        }
                        $(window).resize();
                    });
                },
                agregar_contratos:function(){
                    var contratos = "";
                    var cont = 0;
                    $('#table_resolucion .check-resolucionar:checked').each(function(){
                        if(cont > 0)
                            contratos += "-";
                        contratos += $(this).parent().parent().parent().attr('id');
                        ++cont;
                    });

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: urlBase.make('contratos/resolucionar/hojatrabajo/agregarcontrato'),
                        type: "POST",
                        data: {
                            codigos_contratos: contratos,
                            id_orden_guardar: $('#id_orden_guardar').val(),
                            id_tienda_contrato: $('#id_tienda_contrato').val()
                        },
                        success:function(datos){
                            location.reload();
                        }
                    });
                },
                quitar_contratos:function(){
                    var codigo_contrato = $('#dataTableAction .selected .codigo_contrato_tabla').text();
                    var id_tienda = $('#id_tienda_contrato').val();
                    var id_proceso = $('#dataTableAction .selected .select-sub').val();
                    id_proceso = ($(`.select-sub option:selected[value="${ id_proceso }"]`).length > 1) ? 0 : id_proceso;
                    if (codigo_contrato != "")
                    {
                        confirm.setTitle('Alerta');
                        confirm.setSegment('¿Está seguro que desea remover este contrato de la orden?');
                        confirm.show();

                        confirm.setFunction(function() {
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                url: urlBase.make('contratos/resolucionar/hojatrabajo/quitarcontrato'),
                                type: "POST",
                                data: {
                                    codigo_contrato: codigo_contrato,
                                    id_tienda: id_tienda,
                                    id_proceso: id_proceso
                                },
                                success:function(datos){
                                    location.reload();
                                }
                            });
                        });
                    }else{
                        Alerta('Error', 'Seleccione un registro.', 'error');
                    }
                }
            }
        }
    }
})();



function validate_process(id_proceso_old){
    var cont_process = 0;
    $('#DataTables_Table_0 .subdividir option:selected[value="' + id_proceso_old + '"]').each(function(){
        ++cont_process;
    });
    if(cont_process > 0){
        return false;
    }else{
        return true;
    }

}

function validarNit(input)
{
    $('#tool').remove();
    var nit=$(input).parent().parent().find(".nit").val();
    var numVerificacion=calcularDigitoVerificacion(nit);
    var digito=$(input).val();
    if(numVerificacion!=false && digito==numVerificacion)
    {
       informacionProveedor = datosproveedor(nit);
       console.log(informacionProveedor);
       if(!jQuery.isEmptyObject(informacionProveedor.datosCliente))
       {
       $( input ).parent().parent().parent().parent().parent().parent().find(".id_cliente").val(informacionProveedor.datosCliente[0].codigo_cliente);
       $( input ).parent().parent().parent().parent().parent().parent().find(".id_tienda_cliente").val(informacionProveedor.datosCliente[0].id_tienda);
       $( input ).parent().parent().parent().parent().parent().parent().find(".nombres").text(informacionProveedor.datosCliente[0].nombres);
       $( input ).parent().parent().parent().parent().parent().parent().find(".telefonos").text(informacionProveedor.datosCliente[0].telefono_residencia);
       if(jQuery.isEmptyObject(informacionProveedor.SucursalesCliente)  ||  informacionProveedor.SucursalesCliente[0].id_sucursal == null)
       {
        $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc option").remove();
        $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc").append('<option readOnly> Unica Sucursal </option>');
       }
       else
       {
            $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc option").remove();
            $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc").append('<option value=""> Seleccione una opción </option>');
           for (let i = 0; i < informacionProveedor.SucursalesCliente.length; i++)
           {
            $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc").append('<option value = '+informacionProveedor.SucursalesCliente[i].id_sucursal+'/'+informacionProveedor.SucursalesCliente[i].id_tienda_sucursal+'>'+informacionProveedor.SucursalesCliente[i].sucursal+'</option>');
           }
       }
       }
       else
       {
        $( input ).parent().parent().parent().parent().parent().parent().find(".nombres").text('Cliente no encontrado');
        $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc option").remove();
        $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc").append('<option value=""> Seleccione una opción </option>');
        $( input ).parent().parent().parent().parent().parent().parent().find(".telefonos").text("");
       }
    }else{
        $(input).val('');
        $(input).parent().parent().after(`<div class="tool tool-visible" id="tool" style="clear:both">
                                    <p>El dígito de verificación ${digito} para el Nit ${nit} no es válido, por favor revise.</p>
                               </div>`);
        }
}

function datosproveedor(nit)
{
   url2 = urlBase.make('/contrato/vitrina/getproveedorbyid');
    var retornar = false;
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url2,
        type: 'POST',
        async: false,
        data: {
            nit: nit
        },
        success: function(datos)
        {
            retornar = datos;
        },
        error: function(request, status, error) {
        }
    });
    return retornar;
}

$('#btn-reporte').click(function(){
    $('#form_generar_reporte').submit();
});

$('#btn_reporte_pdf').click(function(){
    var codigos_contratos = "";
    var id_tienda = $('#col0_filter').val();
    codigos_contratos = $('#table_resolucion .check-resolucionar:checked').parent().parent().parent().find('.codigos_contratos').text();
    if(codigos_contratos != "" && codigos_contratos != undefined){
        $('#codigos_contratos').val(codigos_contratos);
        $('#id_tienda_contrato').val(id_tienda);
        $('#frm_reporte_pdf').submit();
    }else{
        Alerta('Error', 'Seleccione un registro.', 'error')
    }    
});

$('#btn_reporte_excel').click(function(){
    var id_orden = "";
    var id_tienda = $('#col0_filter').val();
    id_orden = $('#table_resolucion .check-resolucionar:checked').parent().parent().parent().attr('id');
    if(id_orden != "" && id_orden != undefined){
        Alerta('Cargando', 'Descargando Excel..', 'notice');
        pageAction.redirect(urlBase.make(`contratos/resolucionar/excelperfeccionamiento/${ id_orden }/${ id_tienda }`));
    }else{
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
});

$(document).ready( function() {
    
} );

$('#selectAll').change(function(){
    $('.select-sub').val($('#selectAll').val());
    $('.table_destinatario tbody tr').remove();
    $('.select-sub').change();
});


function buscarDestinatario(element){
    var option = "";
    $(element).siblings('.content_buscador').show();
    
    $.ajax({
        url: urlBase.make('clientes/proveedor/persona/natural/getSelectListByNombre'),
        type: "get",
        data: {
            nombres: $(element).val(),
        },
        success: function (data) {
            var j = 0;
            jQuery.each(data, function (i, val) {
                console.log(data[j]);
                if (__(data[j]) != "") {
                    option += '<option value="' + data[j].numero_documento + '" >' + data[j].nombre + '</option>';
                    j++;
                }
            });
            $(element).siblings('.content_buscador').find('select').empty().append(option);
            option = "";
        }
    });
}

function __($var){
    if ($var != '' && $var !== undefined && $var != undefined && $var != "undefined" && $var !== null){
        return $var;
    }else{
        return '';
    }
}

function selectValue(val)
{
    $(val).parent().siblings('.buscar_destinatario').val($(val).find('option:selected').text());
    $(val).parent().parent().siblings('.col-md-7').find('.nit').val($(val).val());
    $(val).parent().parent().parent().parent().parent().parent().find(".nit-val").val(calcularDigitoVerificacion($(val).val()));
    $(val).parent().parent().parent().parent().parent().parent().find(".nit-val").blur();
    $('.content_buscador').hide();
}

function calcTotDest(){
    var fundicion = 0,
        prerefaccion = 0,
        refaccion = 0,
        fundicion = 0,
        vitrina = 0,
        joya_especial = 0,
        maquila_nacional = 0,
        maquila_internacional = 0;
    $("#dataTableAction tbody tr").each(function(){
        proceso = $(this).find('.subdividir select').val();
        switch (proceso) {
            case 6:
                vitrina += parseInt($(this).find('.precio_ingresado').text());
                break;

            case value:
                
                break;
        
            default:
                break;
        }

        if($(this).find('.subdividir select').val() == 8)
            
            if($(this).find('.subdividir select').val() == 8)
            fundicion += parseInt($(this).find('.precio_ingresado').text());
            if($(this).find('.subdividir select').val() == 8)
            fundicion += parseInt($(this).find('.precio_ingresado').text());
            if($(this).find('.subdividir select').val() == 8)
            fundicion += parseInt($(this).find('.precio_ingresado').text());
            if($(this).find('.subdividir select').val() == 8)
            fundicion += parseInt($(this).find('.precio_ingresado').text());
        
    });
}

function button_perfec(){
    if($('.filter_estado').val() == 89 && $('.filter_categoria').val() != ""){
        $('.btn-perfeccionar').show();
    }else{
        $('.btn-perfeccionar').hide();
    }
}

function resetChecks()
{
    $('.check-resolucionar').prop('checked', false);
}


// Función para resetear los totales
function resetTotales()
{
    total_valor_contratos = 0,
    total_contratos = 0,
    valor_contrato = 0,
    total_peso_contratos = 0,
    total_peso_estimado_contratos = 0,
    total_peso_taller = 0,
    total_peso_final = 0,
    peso_contrato = 0,
    peso_estimado_contrato = 0,
    cantidad_items = 0,
    total_cantidad_items = 0;
    $('#lbl_total_valor_contratos').text(money.replace((total_valor_contratos.toFixed(money.getNumDecimal())).toString().replace(/\./g, ',')));
    $('#lbl_total_peso_contratos').text(((total_peso_contratos.toFixed(2)).toString().replace(/\./g, ',')));
    $('#lbl_total_peso_taller').text(((total_peso_taller.toFixed(2)).toString().replace(/\./g, ',')));
    $('#lbl_total_peso_final').text(((total_peso_final.toFixed(2)).toString().replace(/\./g, ',')));
    $('#lbl_estimado_peso_contratos').text(((total_peso_estimado_contratos.toFixed(2)).toString().replace(/\./g, ',')));
    $('#lbl_total_cantidad_items').text(((total_cantidad_items).toString()));
    $('#lbl_total_contratos').text(money.replace((total_contratos).toString()));
}


function totales_resolucion_det(){
    var 
        valor_contratos = 0,
        cantidad_contratos = 0,
        peso_estimado = 0,
        peso_total = 0,
        peso_taller = 0,
        cantidad_id = 0;
        total_valor_contratos = 0;
        total_peso_contratos = 0;
        total_peso_estimado_contratos = 0;
        total_cantidad_items = 0;
        total_contratos = 0;

        $('#table_resolucion tbody tr').each(function(){
            valor_contrato = ($(this).find('td.var_valor_contrato').text() != '') ? ($(this).find('td.var_valor_contrato').text().replace(/\./g, '').replace(',', '.')) : '$ 0';
            valor_contrato = parseFloat(valor_contrato.split('$ ')[1]);
            peso_contrato = ($(this).find('td.var_peso_contrato').text() != '') ? parseFloat($(this).find('td.var_peso_contrato').text().replace(',','.')) : 0;
            peso_estimado_contrato = ($(this).find('td.var_peso_estimado_contrato').text() != '') ? parseFloat($(this).find('td.var_peso_estimado_contrato').text().replace(',','.')) : 0;
            cantidad_items = ($(this).find('td.var_cantidad_items').text() != '') ? parseInt($(this).find('td.var_cantidad_items').text()) : 0;
            
            valor_contrato = (valor_contrato == NaN) ? 0 : valor_contrato;
            peso_contrato = (peso_contrato == NaN) ? 0 : peso_contrato;
            peso_estimado_contrato = (peso_estimado_contrato == NaN) ? 0 : peso_estimado_contrato;
            cantidad_items = (cantidad_items == NaN) ? 0 : cantidad_items;

            total_valor_contratos += valor_contrato;
            total_peso_contratos += peso_contrato;
            total_peso_estimado_contratos += peso_estimado_contrato;
            total_cantidad_items += cantidad_items;
            ++total_contratos;
        });

        $('#lbl_total_valor_contratos').text(money.replace((total_valor_contratos.toFixed(money.getNumDecimal())).toString().replace(/\./g, ',')));
        $('#lbl_total_peso_contratos').text(((total_peso_contratos.toFixed(2)).toString().replace(/\./g, ',')));
        $('#lbl_estimado_peso_contratos').text(((total_peso_estimado_contratos.toFixed(2)).toString().replace(/\./g, ',')));
        $('#lbl_total_cantidad_items').text(((total_cantidad_items).toString()));
        $('#lbl_total_contratos').text(money.replace((total_contratos).toString()));
}


function datatablePerfeccionamiento(id_table, url_ajax, url_lenguage, columns) {
    table_multi_select = $('#' + id_table).DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 100,
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        ajax: {
            url: url_ajax,
        },
        fixedColumns:   {
            'iLeftColumns': 2
        },
        language: {
            url: url_lenguage
        },
        "fnDrawCallback": function( oSettings ) {
            $('#' + id_table + ' tbody td:not(.no-replace-spaces)').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
            $(window).resize();
            totales_resolucion_det();
        },
        "aoColumns": columns,
        "order": [[2, 'asc']],
    });

    $('.global_filter').on('click', function() {
        filterGlobal(id_table);
        
    });

    $('.button_filter').click(function() {
        filterColumn(id_table);
        
        if($('.filter_estado').val() == 1)
        {
            $('.btn-procesar-index').show();
        }
        else if($('.filter_estado').val() == 2 || $('.filter_estado').val() == 0)
        {
            $('.btn-procesar-index').hide();
        }
    });

    
    $('.button_filter2').click(function() {
        if ($("#col3_filter").is(':checked')) {
            $('#deletedAction1').html("<i class='fa fa-check'></i> Activar");
            $('#deletedAction1').addClass("btn-warning").removeClass("btn-orange");
        } else {
            $('#deletedAction1').html("<i class='fa fa-times-circle'></i> Desactivar");
            $('#deletedAction1').removeClass("btn-warning").addClass("btn-orange");
        }
        filterColumn(id_table);
        
    });
    $('.button_filter').click();
    
}





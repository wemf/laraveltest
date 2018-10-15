$('#subdividir').click(function(){
    if($(this).val() == "0"){
        $(".subdividir").css('display','table-cell');
        $(".items_dest").css('display', 'table-cell');
        $("#cont-selectAll").css('display','inline-block');
        $(".select-sub").addClass("requiered");
        $('#procesar').val('0');
    }else{
        $(".subdividir").css('display', 'none');
        $(".items_dest").css('display', 'none');
        $("#cont-selectAll").css('display', 'none');
        $(".select-sub").removeClass("requiered");
        $('#procesar').val('1');
        $(".peso_taller_input").val(" ");
    }
});

$('#selectAll').change(function(){
    $('.select-sub').val($('#selectAll').val());
});

$('#btn-procesar').click(function(){
    if(valDivRequiered('cont_fran'))
    {
        $('#form_maquilanacional').submit();
    }
});

$('#btn-guardar').click(function () {
    $('#form_maquilanacional').submit();
});

var ESTADOS = (function () {
    var estado = {};
        estado.procesado = '';
    return {
        setProcesado:function (pro) {
            estado.procesado = pro;
        },
        getProcesado:function () {
            return estado.procesado;
        }
    }
})();

$('#btn-quitar').click(function(){
    var itemSelec = "";
    $('#DataTables_Table_0 .selected').each(function(){
        itemSelec = $(this).attr('id');
    });
    itemSelec = itemSelec.split("-");
    var id_tienda = itemSelec[0];
    var id_item = itemSelec[1];
    var id_contrato = itemSelec[2];

    if (itemSelec != "")
    {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('contrato/maquilanacional/validarItem'),
            type: "POST",
            data: {
                id_tienda_inventario: id_tienda,
                id_inventario: id_item,
                id_contrato: id_contrato
            },
            success:function(datos){
                var cont_tr = "";
                $('.modal-body table tbody tr').remove();
                jQuery.each(datos, function (indice, valor) {
                    if (datos[indice].estado == ESTADOS.getProcesado()){
                        $('#text').remove();
                        $('.modal-footer').append("<label for='' class='control-label col-md-6 col-sm-6 col-xs-12' id='text'><b>No se pueden quitar los items por que ya se ha procesado alguno de ellos</b></label>");
                        $('#confirmar').hide();
                    }
                    $('#' + datos[indice].id_tienda_inventario + '-' + datos[indice].id_inventario + '-' + datos[indice].id_contrato).addClass('selected');
                    cont_tr += "<tr>";
                    cont_tr += "<td>" + datos[indice].id_inventario + "</td>";
                    cont_tr += "<td>" + datos[indice].id_orden + "</td>";
                    cont_tr += "<td>" + datos[indice].id_contrato + "</td>";
                    cont_tr += "<td>" + datos[indice].tienda + "</td>";
                    cont_tr += "<td>" + datos[indice].nombre_estado + "</td>";
                    cont_tr += "</tr>";
                });
                $(".modal-body table tbody").append(cont_tr);
                $('#myModal').modal('show');
            }
        });
    }else{
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
    
});

$('#confirmar').click(function(){
    var itemSelec = "";
    $('#DataTables_Table_0 .selected').each(function () {
        itemSelec += $(this).attr('id') + ",";
    });
    itemSelec = itemSelec.slice(0,-1);
    if (itemSelec != "")
    {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('contrato/maquilanacional/quitarItems'),
            type: "POST",
            data: {
                items: itemSelec
            },
            success: function(datos){
                if (datos == "exito") {
                    Alerta('Información', 'Se han quitado exitosamente los items.');
                    pageAction.redirect(urlBase.make('contrato/maquilanacional'));
                } else {
                    Alerta('Error', 'Ha ocurrido un error no se pudieron quitar los items.', 'error');
                    pageAction.redirect(urlBase.make('contrato/maquilanacional'));
                }
            }
        })
    }
});




var id_proceso_old;
$('.subdividir').change(function () {
    var id_proceso = $(this).find('option:selected').val();
    if (id_proceso != "") {
        if (validate_process(id_proceso_old)) {
            $('.table_destinatario tr[data-proceso="' + id_proceso_old + '"]').remove();
        }
        var exist = false;
        $('.table_destinatario tr[data-proceso="' + id_proceso + '"]').each(function () {
            exist = true;
        });
        if (!exist) {
            var html_tabla = "";
            html_tabla +=
            `<tr data-proceso='${id_proceso}'>
            <td>  ${$(this).find('option:selected').text()} </td>
            <td><input type="text" id="numero_bolsa" name="numero_bolsa[]" class="form-control validate-required" required></td>
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
                            <input type="text" id="numero_documento" placeholder="Nit proveedor" name="numero_documento[]" class="form-control nit validate-required" required="required">
                            <span class="input-group-addon white-color">
                                <input id="prueba" maxlength='1' name="digito_verificacion[]" type="text" class="nit-val validate-required"
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

function selectValue(val)
{
    $(val).parent().siblings('.buscar_destinatario').val($(val).find('option:selected').text());
    $(val).parent().parent().siblings('.col-md-7').find('.nit').val($(val).val());
    $('.content_buscador').hide();
}

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

$('#btn_reporte_excel').click(function(){
    var id_orden = "";
    var id_tienda = $('#col0_filter').val();
    id_orden = $('#table_maquilanacional .check-resolucionar:checked').parent().parent().parent().attr('id');
    if(id_orden != "" && id_orden != undefined){
        Alerta('Cargando', 'Descargando Excel..', 'notice');
        pageAction.redirect(urlBase.make(`contratos/resolucionar/excelmaquilanacional/${ id_orden }/${ id_tienda }/maquilanacional`));
    }else{
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
});

function resetChecks()
{
    $('.check-resolucionar').prop('checked', false);
}

$('#btn_reporte_pdf').click(function(){
    var id_orden = "";
    var id_tienda = $('#col0_filter').val();
    id_orden = $('#table_maquilanacional .check-resolucionar:checked').parent().parent().parent().attr('id');
    if(id_orden != "" && id_orden != undefined){
        $('#id_orden').val(id_orden);
        $('#id_tienda_contrato').val(id_tienda);
        
        $("#frm_reporte_pdf").attr("action", urlBase.make('contrato/maquilanacional/generatepdf'));
        $('#frm_reporte_pdf').submit();
    }else{
        Alerta('Error', 'Seleccione un registro.', 'error')
    }    
});

$('#btn_certificado_mineria_pdf').click(function(){
    var id_orden = "";
    var id_tienda = $('#col0_filter').val();
    id_orden = $('#table_maquilanacional .check-resolucionar:checked').parent().parent().parent().attr('id');
    if(id_orden != "" && id_orden != undefined){
        $('#id_orden').val(id_orden);
        $('#id_tienda_contrato').val(id_tienda);

        $("#frm_reporte_pdf").attr("action", urlBase.make('contratos/resolucionar/pdfcertificadomineria'));
        $('#frm_reporte_pdf').submit();
    }else{
        Alerta('Error', 'Seleccione un registro.', 'error')
    }    
});

$('#btn_anular').click(function(){
    var id_orden="";
    //obtener tienda
    var tienda =   $('#col0_filter').val();
    //obtener orden
    id_orden = $('#table_maquilanacional .check-resolucionar:checked').parent().parent().parent().attr('id');
    
    if(id_orden!="" && id_orden!=null && id_orden!=undefined){
        $.ajax({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: urlBase.make('contrato/maquilanacional/anular'),
            type: "POST",
            data:{
                id_tienda: tienda,
                id_orden: id_orden
            },
            success:function(data){
                Alerta('Éxito','Orden anulada con éxito','success');
                $('.button_filter').click();
            }
        });
    }else{
        Alerta('Error','Seleccione un registro','error');
    }
    
});

$('#btn_anular_confirm').click(function(){
    confirm.setTitle('Alerta');
    confirm.setSegment('¿Está seguro que desea anular la orden?');
    confirm.show();
    confirm.setFunction(function(){
        $('#btn_anular').click();
    });
});

function validate_process(id_proceso_old) {
    var cont_process = 0;
    $('#DataTables_Table_0 .subdividir option:selected[value="' + id_proceso_old + '"]').each(function () {
        ++cont_process;
    });
    if (cont_process > 0) {
        return false;
    } else {
        return true;
    }

}

$('.subdividir').mousedown(function () {
    // console.log("Vieja: " + $(this).find('option:selected').text())
    id_proceso_old = $(this).find('option:selected').val();
    // console.log(id_proceso_old);
})


var maquilanacional = (function(){
    return {
        detalles_tabla: function () {
            $('#table_maquilanacional tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var codigo_orden = $(tr).attr('id');
                var id_tienda = $('#col0_filter').val();
                var row = table_multi_select.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child(maquilanacional.detalle_tabla_html(codigo_orden, id_tienda)).show();
                    tr.addClass('shown');
                }
            });
        },
        detalle_tabla_html: function (codigo_orden, id_tienda) {
            var total_cantidad = 0, total_precio = 0;
            var html_tabla = '<table>';
            
            var cant_cols = 0;
            $.ajax({
                url: urlBase.make('contrato/fundicion/getItemOrden/' + id_tienda + '/' + codigo_orden),
                type: "get",
                async: false,
                success: function (datos) {
                    cant_cols = 0;
                    html_tabla += '<thead><th>Número ID</th><th>Codigo Contrato</th><th>Linea Item</th>';
                    jQuery.each(datos.columnas_items, function(indice, valor){
                        html_tabla += `<th>${ datos.columnas_items[indice].nombre }</td>`;
                        ++cant_cols; // SE SUMA LA CANTIDAD DE COLUMNAS PARA AGREGARLAS EN EL FOOTER
                    });
                    html_tabla += '<th>Categoria</th><th>Atributos</th><th>Descripción</th><th>Peso total</th><th>Peso estimado</th><th>Peso libre</th></thead>'
                    
                    jQuery.each(datos.data, function(indice, valor) {
                        console.log(datos.data);
                        ++total_cantidad;
                        html_tabla +=
                        `<tr>
                        <td>${ datos.data[indice].id_inventario }</td>
                        <td>${ datos.data[indice].id_contrato }</td>
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
                            '<td>' + datos.data[indice].categoria + '</td>' +
                            '<td>' + datos.data[indice].nombre + '</td>' +
                            '<td>' + datos.data[indice].observaciones + '</td>' +
                            '<td>' + ((datos.data[indice].peso_total != null) ? datos.data[indice].peso_total : "") + '</td>' +
                            '<td>' + ((datos.data[indice].peso_estimado != null) ? datos.data[indice].peso_estimado : "") + '</td>' +
                            '<td>' + ((datos.data[indice].peso_libre_format != null) ? datos.data[indice].peso_libre_format : "") + '</td>' +
                        '</tr>';
                    });
                }
            });
            return html_tabla;
        }
    }
})();


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

        $('#table_maquilanacional tbody tr').each(function(){
            valor_contrato = ($(this).find('td.var_valor_contrato').text() != '') ? ($(this).find('td.var_valor_contrato').text().replace(/\./g, '').replace(',', '.')) : '$ 0';
            valor_contrato = parseFloat(valor_contrato.split('$ ')[1]);
            peso_contrato = ($(this).find('td.var_peso_contrato').text() != '') ? parseFloat($(this).find('td.var_peso_contrato').text()) : 0;
            peso_estimado_contrato = ($(this).find('td.var_peso_estimado_contrato').text() != '') ? parseFloat($(this).find('td.var_peso_estimado_contrato').text()) : 0;
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

function datatableMaquilaNacional(id_table, url_ajax, url_lenguage, columns) {
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

$(document).ready(function(){
    var table = $('#DataTables_Table_0').DataTable();
    $('#DataTables_Table_0 tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $("#btn-reporte").click(function() {
        var table = $('.check-resolucionar:checked')
        if (table.length > 0) {
            $('#reporte').click();
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error');
        }
    });

    totales_resolucion_det();


    // $('#table_maquilanacional tbody').on('click', 'tr', function () {
    //     if (!$(this).find('td').hasClass('dataTables_empty')) {
    //         valor_contrato = ($(this).find('td:nth-child(10)').text() != '') ? parseFloat($(this).find('td:nth-child(10)').text().replace(/\./g, '').replace(/\,/g, '.')) : 0;
    //         console.log(valor_contrato);
    //         (valor_contrato == NaN) ? 0 : null;
    //         if ($(this).hasClass('selected')) {
    //             total_valor_contratos -= valor_contrato;
    //             --total_contratos;
    //         } else {
    //             total_valor_contratos += valor_contrato;
    //             ++total_contratos;
    //         }
    //         $('#lbl_total_valor_ordenes').text(money.replace((total_valor_contratos).toString()));
    //         $('#lbl_total_ordenes').text(money.replace((total_contratos).toString()));
    //     }
    // });


});

function  replaceNull(){
    $('table td').each(function(){
        if($(this).text() == "null"){
            $(this).text("");
        }
    })
}


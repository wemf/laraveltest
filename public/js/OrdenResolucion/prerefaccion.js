$('#subdividir').click(function(){
    if($(this).val() == "0"){
        $(".subdividir").css('display','table-cell');
        $(".items_dest").css('display', 'block');
        $("#cont-selectAll").css('display','inline-block');
        $(".select-sub").addClass("requiered");
        $('#procesar').val('0');
        
    }else{
        
        $(".subdividir").css('display', 'none');
        $(".items_dest").css('display', 'none');
        $("#cont-selectAll").css('display', 'none');
        $(".select-sub").removeClass("requiered");
        $('#procesar').val('1');
        //$(".peso_taller_input").val($(".peso_taller_input").val());
    }
});

function resetChecks()
{
    $('.check-resolucionar').prop('checked', false);
}



function validatesubdivir(){
    var subdividir = $('#subdividir').val();
    if(subdividir==0){
        Alerta('Advertencia','No se puede procesar una orden sin subdividir','warning');
        return false;
    }else{
        return true;
    }
    
}
// $('#btn-procesar').click(function(){
//     var subdividir = $('#subdividir').val();

//     if(subdividir=='0'){
//         Alerta('Error','No se puede procesar una orden sin subdividir','error');
//     }else{
//         // if(valDivRequiered('cont_fran'))
//         // {
//         //     console.log(valDivRequiered('cont_fran'));
//             if('#subdividir'!=0){
//                 setTimeout(function () { location.href = urlBase.make('contrato/prerefaccion'); }, 5000);
//                 $('#form_prerefaccion').submit();
//             }
           
//         // }
//     }
    
// });

// $('form.form-proces-resolucion').submit(function(e){
//     if($(this).attr("action") == urlBase.make("contrato/refaccion/create")){
//         e.preventDefault();
//         // Validate the form using generic validaing
//         if( validator.checkAll( $(this) ) ){
//             $('#btn-procesar').click();
//         }else{
//             return false;
//         }
//     }
// });

$('#form_prerefaccion').submit(function(e){
    
    // Validate the form using generic validaing
    if( validator.checkAll( $(this) ) ){
        $('input,select').attr('readonly', 'readonly');
    $('input[type="submit"],input[type="button"],input[type="reset"]').attr('disabled', 'disabled');
        var proceso = $('#pros').val();
        setTimeout(function () { location.href = urlBase.make('contrato/'+proceso); }, 5000);
    }else{
        return false;
    }
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

$('#btn_anular').click(function(){
    var id_orden="";
    //obtener tienda
    var tienda =   $('#col0_filter').val();
    //obtener orden
    id_orden = $('#table_prerefaccion .check-resolucionar:checked').parent().parent().parent().attr('id');
    
    if(id_orden!="" && id_orden!=null && id_orden!=undefined){
        $.ajax({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: urlBase.make('contrato/prerefaccion/anular'),
            type: "POST",
            data:{
                id_tienda: tienda,
                id_orden: id_orden
            },
            success:function(data){
                console.log(data);
                if (data == "exito") {
                    Alerta('Información', 'La orden se ha anulado exitosamente.','success');
                    location.reload();
                } else {
                    Alerta('Error', 'Ha ocurrido un error no se pudieron quitar los items.', 'error');
                    location.reload();
                }
            }
        });
    }else{
        Alerta('Error','Seleccione un registro','error');
    }
    
});

$('#btn_anular_confirm').click(function(){
    var id_orden="";
    id_orden = $('#table_prerefaccion .check-resolucionar:checked').parent().parent().parent().attr('id');
    if(id_orden!="" && id_orden!=null && id_orden!=undefined){
        confirm.setTitle('Alerta');
        confirm.setSegment('¿Está seguro que desea anular la orden?');
        confirm.show();
        confirm.setFunction(function(){
            $('#btn_anular').click();
        });
    }else{
        Alerta('Error','Seleccione un registro','error');
    }
});

$('#btn-quitar').click(function(){
    var itemSelec = "";
    $('.tabla-resolucion .selected').each(function(){
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
            url: urlBase.make('contrato/prerefaccion/validarItem'),
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
    var id_orden=$('#numero_orden').val();
    var itemSelec = "";
    $('.tabla-resolucion .selected').each(function () {
        itemSelec += $(this).attr('id') + "-" + id_orden + ",";
    });
    itemSelec = itemSelec.slice(0,-1);
    
    
    if (itemSelec != "")
    {

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('contrato/prerefaccion/quitarItems'),
            type: "POST",
            data: {
                items: itemSelec
            },
            
            success: function(datos){
                //console.log(datos);
                if (datos == "exito") {
                    Alerta('Información', 'Se han quitado exitosamente los items.');
                    pageAction.redirect(urlBase.make('contrato/prerefaccion'));
                } else if(datos="error") {
                    Alerta('Advertencia', 'No se puede quitar items, ya existen IDs procesados', 'warning');
                    pageAction.redirect(urlBase.make('contrato/prerefaccion'));
                }else{
                    Alerta('Error', 'Ha ocurrido un error no se pudieron quitar los items.', 'error');
                    pageAction.redirect(urlBase.make('contrato/prerefaccion'));
                }
            }
        })
    }
});

/*BUSCAR DESTINATARIOS*/ 
/*AL CAMBIAR SELECCIONAR TODOS ACTUALIZA LOS ITEMS*/
$('#selectAll').change(function(){
    //$('.items_dest').find('tbody').empty();
    $('.select-sub').val($('#selectAll').val());
});

/*AGREGA CAMPOS DESTINATARIOS SEGÚN EL PROCESO A SUBDIVIDIR*/
var id_proceso_old;
$('.subdividir,#selectAll').change(function () {
    console.log("old"+id_proceso_old);
    var select = $('#selectAll').val();
    
    
    if(id_proceso_old==""){
        $('.items_dest').find('tbody').empty();
    }
    var id_proceso = $(this).find('option:selected').val();
    console.log("proceso"+id_proceso);
    //console.log("selectAll: "+select+" proceso: "+id_proceso+" old: "+id_proceso_old);
    if (id_proceso != "" ) {
        
        if (validate_process(id_proceso_old)) {
            console.log(id_proceso_old);
            // $('.table_destinatario tr[data-proceso="' + id_proceso + '"]').remove();
            $('.table_destinatario tr[data-proceso="' + id_proceso_old + '"]').remove();
        }
        var exist = false;
        
        $('.table_destinatario tr[data-proceso="' + id_proceso + '"]').each(function () {
            exist = true;
        });
        console.log(exist);
        if (!exist) {
            
            var html_tabla = "";
            html_tabla +=
            `<tr data-proceso='${id_proceso}'>
            <td>  ${$(this).find('option:selected').text()} </td>
            <td><input type="text" id="numero_bolsa" name="numero_bolsa[]" class="form-control validate-required requiered" required></td>
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
                            <input type="text" id="numero_documento" placeholder="Nit proveedor"  name="numero_documento[]" class="form-control nit validate-required requiered" required="required">
                            <span class="input-group-addon white-color">
                                <input id="prueba" maxlength='1' name="digito_verificacion[]"  type="text" class="nit-val validate-required requiered"
                                    onBlur="validarNit(this)" required>
                            </span>
                        </div>
                    </div>
                </div>
            </td>
            <td> <label class="nombres" name = "nombres[]"></>  </td>
            <td> <label class="telefonos" name = "telefonos[]"></>  </td>
            <td>
                <select name="sucursales[]" class="form-control select-suc requiered">
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
    }else if(id_proceso_old!=""){
        $('.table_destinatario tr[data-proceso="' + id_proceso_old + '"]').remove();
            }else{
                $('.items_dest').find('tbody').empty();
        };


});



function selectValue(val)
{
    $(val).parent().siblings('.buscar_destinatario').val($(val).find('option:selected').text());
    $(val).parent().parent().siblings('.col-md-7').find('.nit').val($(val).val());
    $(val).parent().parent().parent().find(".nit-val").val(calcularDigitoVerificacion($(val).val()));
    $(val).parent().parent().parent().parent().parent().parent().find(".nit-val").blur();
    $('.content_buscador').hide();
}
function __($var){
    if ($var != '' && $var !== undefined && $var != undefined && $var != "undefined" && $var !== null){
        return $var;
    }else{
        return '';
    }
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


/*modal report*/
$("#btn-reporte").click(function(){
    var table = $('.check-resolucionar:checked')
    if(table.length>0){
        $('#reporte').click();
    }else{
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
});

$('#btn_reporte_excel').click(function(){   
    var id_orden = "";
    var id_tienda = $('#col0_filter').val();
    id_orden = $('#table_prerefaccion .check-resolucionar:checked').parent().parent().parent().attr('id');
    
    if(id_orden != "" && id_orden != undefined){
        Alerta('Cargando', 'Descargando Excel..', 'notice');
        pageAction.redirect(urlBase.make(`contrato/prerefaccion/excelprerefaccion/${ id_orden }/${ id_tienda }/prerefaccion`));
    }else{
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
});

$('#btn_reporte_pdf').click(function(){
    var id_orden = "";
    var id_tienda = $('#col0_filter').val();
    id_orden = $('#table_prerefaccion .check-resolucionar:checked').parent().parent().parent().attr('id');
    if(id_orden != "" && id_orden != undefined){
        
        $('#id_orden').val(id_orden);
        $('#id_tienda_contrato').val(id_tienda);
        $("#frm_reporte_pdf").attr("action", urlBase.make('contrato/prerefaccion/generatepdf'));
        $('#frm_reporte_pdf').submit();
    }else{
        Alerta('Error', 'Seleccione un registro.', 'error')
    }    
});

$('#btn_certificado_mineria_pdf').click(function(){
    var id_orden = "";
    var id_tienda = $('#col0_filter').val();
    id_orden = $('#table_prerefaccion .check-resolucionar:checked').parent().parent().parent().attr('id');
    if(id_orden != "" && id_orden != undefined){
        $('#id_orden').val(id_orden);
        $('#id_tienda_contrato').val(id_tienda);
        $("#frm_reporte_pdf").attr("action", urlBase.make('contrato/prerefaccion/pdfcertificadomineria'));
        $('#frm_reporte_pdf').submit();
    }else{
        Alerta('Error', 'Seleccione un registro.', 'error')
    }    
});

/*REPORTS INTO PROCESAR*/
$('#btn_reporte_excel_create').click(function () {
    var id_orden = $('#id_orden').val();
    var id_tienda = $('#id_tienda_orden').val();
    if (id_orden != "" && id_orden != undefined) {
        Alerta('Cargando', 'Descargando Excel..', 'notice');
        pageAction.redirect(urlBase.make(`contrato/prerefaccion/excelprerefaccion/${id_orden}/${id_tienda}/prerefaccion`));
    } else {
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
});
/*BEGIND PDF PROCESAR*/
$('#btn_reporte_pdf_create').click(function () {
    var id_orden = $('#id_orden').val();
    var id_tienda = $('#id_tienda_orden').val();
    if (id_orden != "" && id_orden != undefined) {
        $("#frm_reporte_pdf").attr("action", urlBase.make('contrato/prerefaccion/generatepdf'));            
        $('#frm_reporte_pdf').submit();
    } else {
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
});
/*END PDF PROCESAR*/
/*BEGIND MINERÍA PROCESAR*/
$('#btn_certificado_mineria_pdf_create').click(function () {
    var id_orden = $('#id_orden').val();
    var id_tienda = $('#id_tienda_orden').val();
    if (id_orden != "" && id_orden != undefined) {
        $("#frm_reporte_pdf").attr("action", urlBase.make('contrato/prerefaccion/pdfcertificadomineria'));
        $('#frm_reporte_pdf').submit();
    } else {
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
});
/*END MINERÍA PROCESAR*/
/*END REPORTS INTO PROCESAR*/


function validate_process(id_proceso_old) {
    var cont_process = 0;
    $('.tabla-resolucion .subdividir option:selected[value="' + id_proceso_old + '"]').each(function () {
        ++cont_process;
    });
    if (cont_process > 0) {
        return false;
    } else {
        return true;
    }

}


/*ACTUALIZAR EL PROCESO ANTERIOR*/
$('.subdividir').mousedown(function () {
    // console.log("Vieja: " + $(this).find('option:selected').text())
    if($(this).find('option:selected').val()==""){
        id_proceso_old=id_proceso_old;    
    }else{
        id_proceso_old = $(this).find('option:selected').val();
    }
    
    //console.log('mousedown subdividir: '+id_proceso_old);
    $('#selectAll').val("");
})
$('#selectAll').mousedown(function () {
    // console.log("Vieja: " + $(this).find('option:selected').text())
    
    id_proceso_old = $(this).find('option:selected').val();
    
    //console.log('mousedown selectAll :'+id_proceso_old);
})


var refaccion = (function(){
    return {
        detalles_tabla: function () {
            $('#table_prerefaccion tbody').on('click', 'td.details-control', function () {
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
                    row.child(refaccion.detalle_tabla_html(codigo_orden, id_tienda)).show();
                    tr.addClass('shown');
                }
            });
        },
        detalle_tabla_html: function (codigo_orden, id_tienda){
            var total_cantidad = 0, total_precio = 0;
            var html_tabla = '<table>';
            var cant_cols = 0;
            $.ajax({
                url: urlBase.make('contrato/prerefaccion/getItemOrden/' + id_tienda + '/' + codigo_orden),
                type: "get",
                async: false,
                success: function (datos) {
                    console.log(datos);
                    cant_cols = 0;
                    html_tabla += '<thead><th>Número ID</th>';
                    // <th>Línea ítem</th><th>Nombre</th>
                    jQuery.each(datos.columnas_items, function(indice, valor){
                        html_tabla += `<th>${ datos.columnas_items[indice].nombre }</td>`;
                        ++cant_cols; // SE SUMA LA CANTIDAD DE COLUMNAS PARA AGREGARLAS EN EL FOOTER
                    });
                    html_tabla += '<th>Categoría</th><th>Atributos</th><th>Descripción</th><th>Peso total</th><th>Peso estimado</th><th>Peso taller</th><th>Numero de Contrato</th></thead>'
                    
                    jQuery.each(datos.data, function(indice, valor) {
                        ++total_cantidad;
                        html_tabla +=
                        `<tr>
                        <td>${ datos.data[indice].id_inventario }</td>`;

                        // <td>${ datos.data[indice].Linea_Item }</td>
                        // <td>${ datos.data[indice].Nombre_Item }</td>
                        
                        jQuery.each(datos.columnas_items, function(indice_columnas, valor_columnas){
                            console.log(datos.columnas_items);                        
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
                            '<td>' + ((datos.data[indice].observaciones != null)?datos.data[indice].observaciones:"") + '</td>' +
                            '<td>' + ((datos.data[indice].peso_total != null) ? datos.data[indice].peso_total : "") + '</td>' +
                            '<td>' + ((datos.data[indice].peso_estimado != null) ? datos.data[indice].peso_estimado : "") + '</td>' +
                            '<td>' + ((datos.data[indice].peso_taller != null) ? datos.data[indice].peso_taller : "") + '</td>' +
                            '<td>' + datos.data[indice].id_contrato + '</td>'+
                        '</tr>';
                    });
                }
            });
            return html_tabla += '</table>';
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

        $('#table_prerefaccion tbody tr').each(function(){
            valor_contrato = ($(this).find('td.var_valor_contrato').text() != '') ? ($(this).find('td.var_valor_contrato').text().replace(/\./g, '').replace(',', '.')) : '$ 0';
            valor_contrato = parseFloat(valor_contrato.split('$ ')[1]);
            peso_contrato = ($(this).find('td.var_peso_contrato').text() != '') ? parseFloat($(this).find('td.var_peso_contrato').text()) : 0;
            peso_estimado_contrato = ($(this).find('td.var_peso_estimado_contrato').text() != '') ? parseFloat($(this).find('td.var_peso_estimado_contrato').text()) : 0;
            cantidad_items = ($(this).find('td.var_cantidad_items').text() != '') ? parseInt($(this).find('td.var_cantidad_items').text()) : 0;
            valor_contrato = (valor_contrato == NaN) ? 0 : valor_contrato;
            peso_contrato = (peso_contrato == NaN) ? 0 : peso_contrato;
            peso_estimado_contrato = (peso_estimado_contrato == NaN) ? 0 : peso_estimado_contrato;
            peso_taller
            cantidad_items = (cantidad_items == NaN) ? 0 : cantidad_items;

            total_valor_contratos += valor_contrato;
            total_peso_contratos += peso_contrato;
            total_peso_estimado_contratos += peso_estimado_contrato;
            total_cantidad_items += cantidad_items;
            var id=$(this).find('.sorting_1').text()
            if(id!=""){
                ++total_contratos;
            }
            
        });

        $('#lbl_total_valor_contratos').text(money.replace((total_valor_contratos.toFixed(money.getNumDecimal())).toString().replace(/\./g, ',')));
        $('#lbl_total_peso_contratos').text(((total_peso_contratos.toFixed(2)).toString().replace(/\./g, ',')));
        $('#lbl_estimado_peso_contratos').text(((total_peso_estimado_contratos.toFixed(2)).toString().replace(/\./g, ',')));
        $('#lbl_total_cantidad_items').text(((total_cantidad_items).toString()));
        $('#lbl_total_contratos').text(money.replace((total_contratos).toString()));
}

function datatableRefaccion(id_table, url_ajax, url_lenguage, columns) {
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
    if($("#subdividir").val() == "1"){
        $("#cont-selectAll").css('display','inline-block');
        $("#cont-selectAll").css('display','inline-block');
    }
    $(".nit-val").blur();
    var table = $('.tabla-resolucion').DataTable();
    $('.tabla-resolucion tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    //totales_resolucion();



});

var modal_costos = (function(){
    var mano_obra = null,
        transporte = null,
        costos_indirectos = null,
        otros_costos = null;
    return{
        show:function(){
            $('#modal_costos').addClass('modal-diag-show').removeClass('modal-diag-hide');
        },
        hide:function(){
            $('#modal_costos').removeClass('modal-diag-show').addClass('modal-diag-hide');
        },
        accept:function(){
            if(validateRequiredInput('#modal_costos')){
                this.set_costos();
                $('#total_costos').val(this.total_costos());
                this.reformat_money();
                this.hide();
            }
        },
        cancel:function(){
            $('#mano_obra').val((this.mano_obra == 0) ? '' : this.mano_obra);
            $('#transporte').val(this.transporte);
            $('#costos_indirectos').val(this.costos_indirectos);
            $('#otros_costos').val(this.otros_costos);
            this.reformat_money();
        },
        set_costos:function(){
            this.mano_obra = this.reformat_double('#mano_obra');
            this.transporte = this.reformat_double('#transporte');
            this.costos_indirectos = this.reformat_double('#costos_indirectos');
            this.otros_costos = this.reformat_double('#otros_costos');
        },
        reset_inputs:function(){
            $('#mano_obra').val((this.reformat_double('#mano_obra') == 0) ? '' : this.reformat_double('#mano_obra'));
            $('#transporte').val(this.reformat_double('#transporte'));
            $('#costos_indirectos').val(this.reformat_double('#costos_indirectos'));
            $('#otros_costos').val(this.reformat_double('#otros_costos'));
            this.validate_mano_obra();
        },
        validate_mano_obra:function(){
            if($('#mano_obra').val() == 0 || $('#mano_obra').val() == ''){
                $('#editar_costos').addClass('swing-top');
                setTimeout(function(){ $('#editar_costos').removeClass('swing-top'); }, 1000);
            }
        },
        total_costos:function(){
            return this.mano_obra + this.transporte + this.costos_indirectos + this.otros_costos;
        },
        reformat_money:function(){
            $('.moneda').blur();
        },
        reformat_double:function( input ){
            return parseFloat(($(`${ input }`).val() != "") ? $(`${ input }`).val().replace(/\./g, '').replace(/\,/g, '.') : 0);
        }
    }
})();


function saveOrden(url){    
    
    $("#form_prerefaccion").attr("action", urlBase.make(url));
    $('#form_prerefaccion').submit();
    setTimeout(function () { Alerta("Información","Se a guardado correctamente","success"); }, 5000);
    
}
var old_dv = "";
function validarNit(input)
{
    $('#tool').remove();
    var nit=$(input).parent().parent().find(".nit").val();       
    var numVerificacion=calcularDigitoVerificacion(nit);
    var digito=$(input).val();
    if(numVerificacion!=false && digito==numVerificacion)
    {       
       informacionProveedor = datosproveedor(nit);
       if(!jQuery.isEmptyObject(informacionProveedor.datosCliente))
       {
       $( input ).parent().parent().parent().parent().parent().parent().find(".id_cliente").val(informacionProveedor.datosCliente[0].codigo_cliente);         
       $( input ).parent().parent().parent().parent().parent().parent().find(".id_tienda_cliente").val(informacionProveedor.datosCliente[0].id_tienda);         
       $( input ).parent().parent().parent().parent().parent().parent().find(".nombres").text(informacionProveedor.datosCliente[0].nombres);         
       $( input ).parent().parent().parent().parent().parent().parent().find(".telefonos").text(informacionProveedor.datosCliente[0].telefono_residencia);  
       $( input ).parent().parent().parent().parent().parent().parent().find(".telefonos_input").val(informacionProveedor.datosCliente[0].telefono_residencia);  
       if(jQuery.isEmptyObject(informacionProveedor.SucursalesCliente)  ||  informacionProveedor.SucursalesCliente[0].id_sucursal == null)
       {
        $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc option").remove();
        $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc").append('<option readOnly> Unica Sucursal </option>');
       }
       else
       {
            $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc option").remove();
            $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc").append('<option value="0"> Seleccione una opción </option>');                             
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
        $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc").append('<option value="0"> Seleccione una opción </option>');
        $( input ).parent().parent().parent().parent().parent().parent().find(".telefonos").text("");          
        $( input ).parent().parent().parent().parent().parent().parent().find(".telefonos_input").val("");          
       }
    }else{
        // if(old_dv==""){
        //     old_dv=$(input).val();
        //     $(input).val('');
        // }else if($(input).val()==""){
        //     $(input).val('');
        // }else{
        //     $(input).val(old_dv);
        // }
            // $(input).parent().parent().after(`<div class="tool tool-visible" id="tool" style="clear:both">
            //     <p>El dígito de verificación ${digito} para el Nit ${nit} no es válido, por favor revise.</p></div>`);
        }
}

function datatableRefaccion(id_table, url_ajax, url_lenguage, columns) {
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
        if($('.filter_estado').val() == "1")
        {
            $('.btn-procesar').show();
            $('.btn-ver-index').show();
            $('#btn-reporte').show();
            $('#btn_anular_confirm').show();
        }
        else if($('.filter_estado').val() == "2")
        {
            $('.btn-procesar').hide();
            $('.btn-ver-index').show();
            $('#btn-reporte').show();
            $('#btn_anular_confirm').hide();
        }else if( $('.filter_estado').val() == "0"){
            $('.btn-ver-index').hide();
            $('.btn-procesar').hide();
            $('#btn-reporte').hide();
            $('#btn_anular_confirm').hide();
        }
        
        filterColumn(id_table);        
    });

    $('.button_filter').click();
}

function datosproveedor(nit)
{
   url2 = urlBase.make('contrato/vitrina/getproveedorbyid');
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

//restablecer pantalla true actualiza pagina, sin true actualiza cache
function reload(){
    location.reload(true);
}




// function resetInputs(){
//     if($("#subdividir").val() == 1){
//         $("#subdividir").val(0);
        
//     }else{
//         $("#subdividir").val(1);
        
//     }    
//     $("#subdividir").click();
//     $(".select-sub").hide();
// }

    

    

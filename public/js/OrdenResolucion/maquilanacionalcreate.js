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

function selectValue(val)
{
    $(val).parent().siblings('.buscar_destinatario').val($(val).find('option:selected').text());
    $(val).parent().parent().siblings('.col-md-7').find('.nit').val($(val).val());
    $(val).parent().parent().parent().parent().parent().parent().find(".nit-val").val(calcularDigitoVerificacion($(val).val()));
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

$('#subdividir').click(function(){
    $("#selectAll option:nth-child(1)").prop('selected', true);
    $("#selectAll option:nth-child(1)").change();
    if($(this).val() == "0"){
        $(".subdividir").css('display','table-cell');
	$(".items_dest").css('display', 'block');
	$("#cont-selectAll").css('display','inline-block');
        $(".select-sub").attr("requiered", "required");
        $('#procesar').val('0');
        $('#div_df').hide();
    }else{
        $(".subdividir").css('display', 'none');
        $(".select-sub").removeAttr("required");
        $('#procesar').val('1');
        $('#div_df').show();
        $(".peso_taller_input").val("");
    }
    $('.dataTableAction th:nth-child(1)').click();

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
        $('.peso_joyeria').val("");
        $('.select-sub option[value="6"]').prop('selected', 'selected');
        $('#procesar').val('1');
        $('.items_dest tbody tr').remove();
        var html_tabla = `<tr data-proceso="6">
                            <td>Vitrina</td>
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
                                <input type="hidden" name="id_proceso[]" value='6'>
                                <input type="hidden" class = "id_cliente" name="id_cliente[]">
                                <input type="hidden" class = "id_tienda_cliente" name="id_tienda_cliente[]">
                            </td>
                        </tr>`;
        $('.items_dest').find('tbody').append(html_tabla);
    }
    $(window).resize();
});

$('#selectAll').change(function(){
    $('.select-sub').val($('#selectAll').val());
    $('.table_destinatario tbody tr').remove();
    $('.select-sub').change();
});

$('#from_proceso').submit(function(e){
        // Validate the form using generic validaing
        if( validator.checkAll( $(this) ) ){
            var proceso = $('#pros').val();
            setTimeout(function () { location.href = urlBase.make('contrato/'+proceso); }, 5000);
        }else{
            return false;
        }
});


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

$('#btn-procesar-refaccion').click(function(){
    var proceso = $('#pros').val();
    // setTimeout(function () { location.href = urlBase.make('contrato/'+proceso); }, 5000);
    $('.btn-procesar-orden').click();
     
});

$('#btn-procesar').click(function(){
    var cont_reclasificado = 0;
    $('.val-reclasificado').each(function(){
        if($(this).val() == 0){
            ++cont_reclasificado;
        }
    });

    if(cont_reclasificado == 0){
        var proceso = $('#pros').val();
        if(validateRequiredInput('#cont_fran'))
        {
            setTimeout(function () { location.href = urlBase.make('contrato/'+proceso); }, 5000);
            $('.btn-procesar-orden').click();
        }
    }else{
        $('.content-val-reclasificado').addClass('swing');
        setTimeout(function(){ $('.content-val-reclasificado').removeClass('swing'); }, 1000);
        Alerta('Información', 'Aún faltan ID´s por reclasificar, no se puede procesar hasta realizar este paso', 'warning');
    }
});

$('#btn-solicitar-procesar').click(function () {
    var cont_reclasificado = 0;
    $('.val-reclasificado').each(function () {
        if ($(this).val() == 0) {
            ++cont_reclasificado;
        }
    });

    var ids = [];
    $('.id_inventario').each(function (index) {
        ids[index] = $(this).text();
    });
    var pesos = [];
    $('.peso_libre').each(function (index) {
        pesos[index] = $(this).val();
    });
    var tiendas = [];
    $('.id_tienda_inventario').each(function (index) {
        tiendas[index] = $(this).val();
    });
    
    if (valClass('peso_libre') && cont_reclasificado == 0) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('contrato/vitrina/solicitud/procesar'),
            type: "GET",
            data: {
                id_tienda: $('#id_tienda_ordenes').val(),
                id_ordenes: $('#numero_orden').val(),
                id_remitente: $('#id_remitente').val(),
                id_inventario: ids,
                pesos: pesos,
                tiendas: tiendas
            },
            success: function (datos) {
                console.log(datos);
                setTimeout(function () { window.location = urlBase.make('contrato/vitrina') }, 3000);
                Alerta('Información', 'Solicitud enviada correctamente, será redireccionado al inicio en breve', 'success');
            }
        });
    }else{
        if (cont_reclasificado > 0){
            Alerta('Información', 'Aún faltan ID´s por reclasificar, no se puede solicitar procesamiento hasta realizar este paso', 'warning');
        }
        if (!valClass('peso_libre')){
            Alerta('Información', 'Aún faltan pesos por ingresar', 'warning');
        }
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
            url: urlBase.make('contrato/refaccion/validarItem'),
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
    $('.tabla-resolucion .selected').each(function () {
        itemSelec += $(this).attr('id') + ",";
    });
    itemSelec = itemSelec.slice(0,-1);
    if (itemSelec != "")
    {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('contrato/refaccion/quitarItems'),
            type: "POST",
            async: false,
            data: {
                items: itemSelec
            },
            success: function(datos){
                if (datos == "exito") {
                    Alerta('Información', 'Se han quitado exitosamente los items.');
                    pageAction.redirect(urlBase.make('contrato/refaccion'));
                }
                else if (datos == 3) {
                    Alerta('Error', 'No puede quitar los items porque hay otros procesados.', 'error');
                    pageAction.redirect(urlBase.make('contrato/refaccion'));
                } else {
                    Alerta('Error', 'Ha ocurrido un error no se pudieron quitar los items.', 'error');
                    pageAction.redirect(urlBase.make('contrato/refaccion'));
                }
            }
        })
    }
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

var id_proceso_old;
$('.subdividir').change(function () {
    $('.dataTables_empty').remove();
    var id_proceso = $(this).find('option:selected').val();
    console.log(id_proceso);
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
    }else{
        console.log($(`.subdividir option[value='${ id_proceso_old }']:selected`).length);
        if ($(`.subdividir option[value='${ id_proceso_old }']:selected`).length == 0) {
            $('.table_destinatario tr[data-proceso="' + id_proceso_old + '"]').remove();
        }
    }
})

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
            $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc").append('<option> Seleccione una opción </option>');                             
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
        $( input ).parent().parent().parent().parent().parent().parent().find(".select-suc").append('<option> Seleccione una opción </option>');
        $( input ).parent().parent().parent().parent().parent().parent().find(".telefonos").text("");          
        $( input ).parent().parent().parent().parent().parent().parent().find(".telefonos_input").val("");          
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

$('.subdividir').mousedown(function()
{
    id_proceso_old = $(this).find('option:selected').val();
})

var vitrina = (function(){
    return {
        detalles_tabla: function () {
            $('#table_vitrina tbody').on('click', 'td.details-control', function () {
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
                    row.child(vitrina.detalle_tabla_html(codigo_orden, id_tienda)).show();
                    tr.addClass('shown');
                }
            });
        },
        detalle_tabla_html: function (codigo_orden, id_tienda) {
            var total_cantidad = 0,
                total_precio = 0;
            var html_tabla = '<table>';
            var cant_cols = 0;
            $.ajax({
                url: urlBase.make('contrato/fundicion/getItemOrden/' + id_tienda + '/' + codigo_orden),
                type: "get",
                async: false,
                success: function (datos) {
                    cant_cols = 0;
                    html_tabla += '<thead><th>Número ID</th><th>Linea Item</th><th>Nombre</th>';
                    jQuery.each(datos.columnas_items, function (indice, valor) {
                        html_tabla += `<th>${ datos.columnas_items[indice].nombre }</td>`;
                        ++cant_cols; // SE SUMA LA CANTIDAD DE COLUMNAS PARA AGREGARLAS EN EL FOOTER
                    });
                    html_tabla += '<th>Categoria</th><th>Atributos</th><th>Descripción</th><th>Peso total</th><th>Peso estimado</th><th>Peso taller</th></thead>'

                    jQuery.each(datos.data, function (indice, valor) {
                        ++total_cantidad;
                        html_tabla +=
                            `<tr>
                        <td>${ datos.data[indice].id_contrato }</td>
                        <td>${ datos.data[indice].Linea_Item }</td>
                        <td>${ datos.data[indice].Nombre_Item }</td>`;

                        jQuery.each(datos.columnas_items, function (indice_columnas, valor_columnas) {
                            console.log(datos.columnas_items);
                            var col_print = 0;
                            jQuery.each(datos.datos_columnas_items, function (indice_datos, valor_datos) {
                                if (datos.columnas_items[indice_columnas].nombre == datos.datos_columnas_items[indice_datos].atributo && datos.datos_columnas_items[indice_datos].linea_item == datos.data[indice].Linea_Item && col_print == 0) {
                                    html_tabla += `<td>${ datos.datos_columnas_items[indice_datos].valor }</td>`;
                                    col_print = 1;
                                }
                            });
                            if (col_print == 0) {
                                html_tabla += `<td></td>`;
                            }
                        });

                        html_tabla +=
                            '<td>' + datos.data[indice].categoria + '</td>' +
                            '<td>' + datos.data[indice].nombre + '</td>' +
                            '<td>' + datos.data[indice].observaciones + '</td>' +
                            '<td>' + ((datos.data[indice].peso_total != null) ? datos.data[indice].peso_total : "") + '</td>' +
                            '<td>' + ((datos.data[indice].peso_estimado != null) ? datos.data[indice].peso_estimado : "") + '</td>' +
                            '<td>' + ((datos.data[indice].peso_taller != null) ? datos.data[indice].peso_taller : "") + '</td>' +
                            '</tr>';
                    });
                }
            });
            return html_tabla += '</table>';
        }
    }
})();




$(document).ready(function(){
    // [ASHY] SE COMENTAN LAS SIGUIENTES LINEAS DE CÓDIGO, YA QUE NO ESTÁN REALIZANDO NADA EN ESTE
    // [ASHY] MOMENTO PARA VITRINA.

    // var table = $('#DataTables_Table_0').DataTable();
    // $('#DataTables_Table_0 tbody').on('click', 'tr', function () {
    //     if ($(this).hasClass('selected')) {
    //         $(this).removeClass('selected');
    //     }
    //     else {
    //         table.$('tr.selected').removeClass('selected');
    //         $(this).addClass('selected');
    //     }
    // });

    // [ASHY]
    // [ASHY] TABLA DE ORDENES DE RESOLUCIÓN, CON EL CAMBIO DE LOS TOTALES
    // [ASHY] FINALIZA TOTALES DE ÓRDENES

    $('#btn_reporte_excel').click(function () {
        var id_orden = "";
        var id_tienda = $('#col0_filter').val();
        id_orden = $('#table_vitrina .check-resolucionar:checked').parent().parent().parent().attr('id');
        if (id_orden != "" && id_orden != undefined) {
            Alerta('Cargando', 'Descargando Excel..', 'notice');
            pageAction.redirect(urlBase.make(`contratos/resolucionar/excelrefaccion/${id_orden}/${id_tienda}/vitrina`));
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });

    $('#btn_stikers_excel').click(function () {
        var id_orden = "";
        var id_tienda = $('#col0_filter').val();
        id_orden = $('#table_vitrina .check-resolucionar:checked').parent().parent().parent().attr('id');
        if (id_orden != "" && id_orden != undefined) {
            Alerta('Cargando', 'Descargando Excel..', 'notice');
            pageAction.redirect(urlBase.make(`contratos/resolucionar/excelstikers/${id_orden}/${id_tienda}/vitrina`));
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });

    $('#btn_reporte_pdf').click(function () {
        var id_orden = "";
        var id_tienda = $('#col0_filter').val();
        id_orden = $('#table_vitrina .check-resolucionar:checked').parent().parent().parent().attr('id');
        if (id_orden != "" && id_orden != undefined) {
            $('#id_orden').val(id_orden);
            $('#id_tienda_contrato').val(id_tienda);
            $('#frm_reporte_pdf').submit();
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });

    $('#btn_certificado_mineria_pdf').click(function () {
        var id_orden = "";
        var id_tienda = $('#col0_filter').val();
        id_orden = $('#table_vitrina .check-resolucionar:checked').parent().parent().parent().attr('id');
        if (id_orden != "" && id_orden != undefined) {
            $('#id_orden').val(id_orden);
            $('#id_tienda_contrato').val(id_tienda);

            $("#frm_reporte_pdf").attr("action", urlBase.make('contratos/resolucionar/pdfcertificadomineria'));
            $('#frm_reporte_pdf').submit();
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });

    // funciones para el crear reportes

    $('#btn_reporte_excel_create').click(function () {
        var id_orden = $('#id_orden').val();
        var id_tienda = $('#id_tienda_orden').val();
        if (id_orden != "" && id_orden != undefined) {
            Alerta('Cargando', 'Descargando Excel..', 'notice');
            pageAction.redirect(urlBase.make(`contratos/resolucionar/excelrefaccion/${id_orden}/${id_tienda}/vitrina`));
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });

    $('#btn_stikers_excel_create').click(function () {
        var id_orden = $('#id_orden').val();
        var id_tienda = $('#id_tienda_orden').val();
        if (id_orden != "" && id_orden != undefined) {
            Alerta('Cargando', 'Descargando Excel..', 'notice');
            pageAction.redirect(urlBase.make(`contratos/resolucionar/excelstikers/${id_orden}/${id_tienda}/vitrina`));
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });

    $('#btn_reporte_pdf_create').click(function () {
        var id_orden = $('#id_orden').val();
        var id_tienda = $('#id_tienda_orden').val();
        if (id_orden != "" && id_orden != undefined) {
            $('#frm_reporte_pdf').submit();
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });

    $('#btn_certificado_mineria_pdf_create').click(function () {
        var id_orden = $('#id_orden').val();
        var id_tienda = $('#id_tienda_orden').val();
        if (id_orden != "" && id_orden != undefined) {
            $("#frm_reporte_pdf").attr("action", urlBase.make('contratos/resolucionar/pdfcertificadomineria'));
            $('#frm_reporte_pdf').submit();
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });

    // fin funciones

});

function btnProcesar(ver = null) {
    var contratos = "";
    var cont = 0;
    var paso = true;

    $('.table_resolucion .check-resolucionar:checked').each(function () {
        if (cont > 0)
            contratos += "-";
        contratos += $(this).parent().parent().parent().attr('id');
        ++cont;
        
        if ($(this).parent().parent().parent().find('td.var_estado').text().trim() != "Pendiente Por Procesar") paso = false;
    });
    if (ver != null) paso = true;
    if (paso) {
        if(ver != null){
            (contratos != "") ? location.href = urlBase.make('contrato/vitrina/procesar/' + $('#col0_filter').val() + "/" + contratos + "/1"): Alerta('Alerta', 'Debe seleccionar por lo menos un contrato', 'warning');
        }else{
            (contratos != "") ? location.href = urlBase.make('contrato/vitrina/procesar/' + $('#col0_filter').val() + "/" + contratos) : Alerta('Alerta', 'Debe seleccionar por lo menos un contrato', 'warning');
        }
    } else {
        Alerta('Alerta', 'Solo los contratos abiertos se pueden procesar', 'warning')
    }
}

function reclasificarItem( id_tienda, codigo_contrato, id_inventario, id_linea_item ){
    $('.selects').html('');
    $('#parentAttribute').find('option').remove();
    $('#var_id_tienda').val(id_tienda);
    $('#var_id_inventario').val(id_inventario);
    $('#var_codigo_contrato').val(codigo_contrato);
    $('#var_id_linea_item').val(id_linea_item);
    $.ajax(
    {
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url : urlBase.make('contrato/item/reclasificar/get'),
        type : 'GET',
        async : false,
        dataType : 'JSON',
        data : 
        {
            id_tienda : id_tienda,
            id_inventario : id_inventario
        },
        success: function (datos) {
            $select = 0;
            $option = 0;
            var selected = "";
            jQuery.each(datos, function (indice, datos) {
                // if(datos.set_valor == '1'){
                    selected = (datos.valor_seleccionado == 1) ? ' selected ' : '';
                    if($select == datos.id_atributo && $option != datos.id_valor){
                        $('#slc-attr-' + datos.id_atributo).append
                        (
                            '<option value="' + datos.id_valor + '" ' + selected + '>' + datos.nombre_valor + '</option>'
                        );
                    }else if($select != datos.id_atributo){
                        $('.selects').append
                        (
                            '<div class="form-group bottom-20 nth-child-attribute-' + datos.id_atributo_padre + '" id="form-group-' + datos.id_atributo + '">'+
                                '<label class="control-label col-md-3 col-sm-3 col-xs-12">' + datos.nombre_atributo + ' </label>'+
                                '<div class="col-md-6 col-sm-6 col-xs-12">'+
                                    '<select id="slc-attr-' + datos.id_atributo + '" data-concat="' + datos.concatenar_nombre + '" onchange="loadAttributeAttributes(' + datos.id_atributo + ', this.value, \'' + URL.getUrlAttributeAttributesById() + '\')" class="form-control col-md-7 col-xs-12">'+
                                        '<option value="0"> - Seleccione una opción - </option>'+
                                        '<option value="' + datos.id_valor + '" ' + selected + '>' + datos.nombre_valor + '</option>'+
                                    '</select>'+
                                '</div>'+
                            '</div>'
                        );
                    }
                    $select = datos.id_atributo;
                    $option = datos.id_valor;
                // }
            });
        },
        
    });
    $('#modal_rename_reference').show();
}

function reclasificarItemPost(){
    var data = {};
    data.attributes= [];
    var i=0;
    $('#form-references .selects select').each(function(){
        if($(this).val() != 0){
            data.attributes[i] = {};
            data.attributes[i++] = $(this).val();
        }
    });

    $.ajax(
    {
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
        url : urlBase.make('contrato/item/reclasificar/post'),
        type : 'POST',
        async : false,
        dataType : 'JSON',
        data : 
        {
            data_reference: data,
            id_categoria: $('#id_categoria').val(),
            id_tienda_inventario: $('#var_id_tienda').val(),
            id_inventario: $('#var_id_inventario').val(),
            codigo_contrato: $('#var_codigo_contrato').val(),
            id_linea_item: $('#var_id_linea_item').val(),
            
        },
        success: function (datos) {
            console.log(datos);
            if(datos.id_referencia > 0){
                $('#modal_rename_reference').hide();
                Alerta('Guardado', 'Ítem reclasificado con éxito.');
                $(`#nombre-inventario-` + $('#var_id_inventario').val()).text(datos.descripcion);
                $(`#estado-reclasificacion-` + $('#var_id_inventario').val()).find('input').val(1);
                $(`#estado-reclasificacion-` + $('#var_id_inventario').val()).find('i').addClass('fa-check').removeClass('fa-times').css('color', 'green');
            }else{
                Alerta('Alerta', 'La referencia que esta ingresando no existe.', 'warning');
            }
            // if(datos.val == "ErrorUnico"){
            //     Alerta('Ya existe', 'Ya existe una referencia con los mismos valores.', 'warning');
            // }else{
            //     Alerta('Guardado', 'Referencia guardada correctamente.');
            //     pageAction.redirect(URL.getUrlIndex(), 0);
            // }
        },
        error: function ( request, status, error ){
            console.log(error);
            if(error == "Internal Server Error"){
                Alerta('Alerta', 'Debe completar todos los campos.', 'warning');
            }else{
                Alerta('Ya existe', 'Ya existe una referencia con los mismos valores.', 'warning');
            }
        }
        
    });
    
}


// ASHY - Guarda la orden para procesar en otro momento
function saveOrden(url){    
    $("#from_proceso").attr("action", urlBase.make(url));
    $('#from_proceso').submit();
}

function resetChecks() {
    $('.check-resolucionar').prop('checked', false);
}

function valClass(clas)
{   
    var retorno = true;
    $(`.${clas}`).each(function(){
        if($(this).val() == "") {
            $(this).addClass('alert-validate-required');
            retorno = false;
        }else{
            $(this).removeClass('alert-validate-required');
            retorno = true;
        }
    });

    return retorno;
}

// Función para resetear campos
function resetInputs(){
    if($("#subdividir").val() == 1){
        $("#subdividir").val(0);
    }else{
        $("#subdividir").val(1);
    }    
    $("#subdividir").click();
    $(".select-sub").change();
}
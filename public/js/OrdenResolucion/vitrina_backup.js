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

$('#subdividir').click(function(){
    if($(this).val() == "0"){
        $(".subdividir").css('display','table-cell');
        $(".items_dest").css('display', 'table-cell');
        $("#cont-selectAll").css('display','inline-block');
        $(".select-sub").addClass("requiered");
        $('#procesar').val('0');
        $('#div_df').hide();
    }else{
        $(".subdividir").css('display', 'none');
        $(".items_dest").css('display', 'none');
        $("#cont-selectAll").css('display', 'none');
        $(".select-sub").removeClass("requiered");
        $('#procesar').val('1');
        $('#div_df').show();
        $(".peso_taller_input").val("");
    }
    $('.dataTableAction th:nth-child(1)').click();
});

$('#selectAll').change(function(){
    $('.select-sub').val($('#selectAll').val());
    $('.table_destinatario tbody tr').remove();
    $('.select-sub').change();
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
            $('#from_proceso').submit();
        }
    }else{
        $('.content-val-reclasificado').addClass('swing');
        setTimeout(function(){ $('.content-val-reclasificado').removeClass('swing'); }, 1000);
        Alerta('Información', 'Aún faltan ID´s por reclasificar, no se puede procesar hasta realizar este paso', 'warning');
    }
});

$('#btn-solicitar-procesar').click(function(){
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: urlBase.make('contrato/vitrina/solicitud/procesar'),
        type: "GET",
        data: {
            id_tienda: $('#id_tienda_ordenes').val(),
            id_ordenes: $('#numero_orden').val(),
            id_remitente: $('#id_remitente').val()
        },
        success:function(datos){
            setTimeout(function(){ window.location = urlBase.make('contrato/vitrina') }, 3000);
            Alerta('Información', 'Solicitud enviada correctamente, será redireccionado al inicio en breve', 'success');
        }
    });
});



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
            $('#mano_obra').val(this.mano_obra);
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
            $('#mano_obra').val(this.reformat_double('#mano_obra'));
            $('#transporte').val(this.reformat_double('#transporte'));
            $('#costos_indirectos').val(this.reformat_double('#costos_indirectos'));
            $('#otros_costos').val(this.reformat_double('#otros_costos'));
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
            <td>  
                <div class="input-group">           
                <input type="text" id="numero_documento" name="numero_documento[]" class="form-control nit" required>
                <span class="input-group-addon white-color"><input id="prueba" maxlength = '1' name="digito_verificacion" type="text" class="nit-val" onBlur="validarNit(this)" required></span>
                </div>
             </td> 
            <td> <label class="nombres" name ="nombres[]"></label>  </td>
            <td> 
                <label class="telefonos" name="telefonos[]"></label> 
                <input type="hidden" class="telefonos_input requiered" name="telefonos_input[]">  
            </td>
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
       console.log(informacionProveedor);
       if(!jQuery.isEmptyObject(informacionProveedor.datosCliente))
       {
       $( input ).parent().parent().parent().parent().find(".id_cliente").val(informacionProveedor.datosCliente[0].codigo_cliente);         
       $( input ).parent().parent().parent().parent().find(".id_tienda_cliente").val(informacionProveedor.datosCliente[0].id_tienda);         
       $( input ).parent().parent().parent().parent().find(".nombres").text(informacionProveedor.datosCliente[0].nombres);         
       $( input ).parent().parent().parent().parent().find(".telefonos").text(informacionProveedor.datosCliente[0].telefono_residencia);  
       $( input ).parent().parent().parent().parent().find(".telefonos_input").val(informacionProveedor.datosCliente[0].telefono_residencia);  
       if(jQuery.isEmptyObject(informacionProveedor.SucursalesCliente)  ||  informacionProveedor.SucursalesCliente[0].id_sucursal == null)
       {
        $( input ).parent().parent().parent().parent().find(".select-suc option").remove();
        $( input ).parent().parent().parent().parent().find(".select-suc").append('<option readOnly> Unica Sucursal </option>');
       }
       else
       {
            $( input ).parent().parent().parent().parent().find(".select-suc option").remove();
            $( input ).parent().parent().parent().parent().find(".select-suc").append('<option> Seleccione una opción </option>');                             
           for (let i = 0; i < informacionProveedor.SucursalesCliente.length; i++) 
           {
            $( input ).parent().parent().parent().parent().find(".select-suc").append('<option value = '+informacionProveedor.SucursalesCliente[i].id_sucursal+'/'+informacionProveedor.SucursalesCliente[i].id_tienda_sucursal+'>'+informacionProveedor.SucursalesCliente[i].sucursal+'</option>');                
           }
       }
       }
       else
       {
        $( input ).parent().parent().parent().parent().find(".nombres").text('Cliente no encontrado');
        $( input ).parent().parent().parent().parent().find(".select-suc option").remove();
        $( input ).parent().parent().parent().parent().find(".select-suc").append('<option> Seleccione una opción </option>');
        $( input ).parent().parent().parent().parent().find(".telefonos").text("");          
        $( input ).parent().parent().parent().parent().find(".telefonos_input").val("");          
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
            var total_cantidad = 0, total_precio = 0;
            var html_tabla = '<table>';
            html_tabla +=
                '<thead><th>Número de inventario</th><th>Nombre</th><th>Observaciones</th><th>Peso total</th><th>Categoria</th></thead>';
            $.ajax({
                url: urlBase.make('contrato/vitrina/getItemOrden/' + id_tienda + '/' + codigo_orden),
                type: "get",
                async: false,
                success: function (datos) {
                    jQuery.each(datos, function (indice, valor) {
                        total_precio += datos[indice].Precio_Item;
                        ++total_cantidad;
                        html_tabla +=
                            '<tr>' +
                            '<td>' + datos[indice].id_inventario + '</td>' +
                            '<td>' + datos[indice].nombre + '</td>' +
                            '<td>' + datos[indice].observaciones + '</td>' +
                            '<td>' + datos[indice].peso_total + '</td>' +
                            '<td>' + datos[indice].categoria + '</td>' +
                            '</tr>';
                    });
                }
            });
            return html_tabla;
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
    totales_resolucion();
    // [ASHY] FINALIZA TOTALES DE ÓRDENES
});

function btnProcesar(){
    var contratos = "";
    var cont = 0;
    $('.table_resolucion .check-resolucionar:checked').each(function(){
        if(cont > 0)
            contratos += "-";
        contratos += $(this).parent().parent().parent().attr('id');
        ++cont;
    });

    ( contratos != "" ) ? location.href = urlBase.make('contrato/vitrina/procesar/' + $('#col0_filter').val() + "/" + contratos) : Alerta( 'Alerta', 'Debe seleccionar por lo menos un contrato', 'warning' );
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
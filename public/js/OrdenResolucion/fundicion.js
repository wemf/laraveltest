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
        $(".peso_libre_input").val($(".peso_libre_input").val());
    }    
});


/*BEGIND FUNCTION CLEAN ( , ) AND ( . ) AND ( / ) AND ( ' ' ) AND ( $ )*/
function limpiarVal(val){
        var v = val.split('.');
        var valLimpiar = val.replace(/\./g, '');
        valLimpiar = valLimpiar.replace('$', '');
        valLimpiar = valLimpiar.replace(',', '.', valLimpiar);
        valLimpiar = valLimpiar.trim(valLimpiar);
        return valLimpiar;
    }
/*END FUNCTION CLEAN */

$('#btn-procesar').click(function(){
    var subdividir = $('#subdividir').val();
    var peso_libre = $('.peso_libre_input').val();
    var peso_estimado = $('.peso_estimado').val();
    var valor_item_contrato = $('.precio_ingresado').val();
    var id_inventario = $('.id_inventario').val();
    if(subdividir == '0'){
        var array_val_item = new Array();
        var array_peso_estimado = new Array();
        var array_peso_libre = new Array();
        var array_id_item = new Array();
        var valor_merma = new Array();
        var merma_por_item = new Array();
        var i = 0, j = 0, s = 0, f = 0;
        var total_peso_estimado = 0;
        var total_peso_libre = 0;
        var merma = 0;
    //calcular total peso estimado
        $('.peso_estimado').each(function(){
            if($(this).val()){
                total_peso_estimado = total_peso_estimado + parseFloat(limpiarVal($(this).val()));
                array_peso_estimado[j] = limpiarVal($(this).val());
                j++;
            }
        });
    // calcular total peso libre
        $('.peso_libre_input').each(function(){
            if($(this).val()){
                total_peso_libre = total_peso_libre + parseFloat(limpiarVal($(this).val()));
                array_peso_libre[f] = limpiarVal($(this).val());
                f++;
            }
        });
    // Se optiene el valor del contrato por item
        $('.precio_ingresado').each(function(){
            array_val_item[i] = limpiarVal($(this).val());
            i++;
        });
    // Se optiene el valor del id por item
        $('.id_inventario').each(function(){
            array_id_item[s] = $(this).val();
            s++;
        });
    // Calcular merma ( peso estimado item -  peso libre item = merma)
        for(var $m = 0; $m < array_id_item.length ;$m++){
            merma_por_item[$m] = array_peso_estimado[$m] - array_peso_libre[$m];
        }

    merma = total_peso_estimado - total_peso_libre;
        // validamos los totales positivos y negativos con 2 decimales
            var str = merma.toString();
            var merma_modal= (Math.sign(str) > 0) ? str.substring(0,4) : str.substring(0,5);

            var ytr = total_peso_estimado.toString();
            var peso_estimado_modal = (Math.sign(ytr) > 0) ? ytr.substring(0,4) : ytr.substring(0,5);

            var xtr = total_peso_libre.toString();
            var peso_libre_modal = (Math.sign(xtr) > 0) ? xtr.substring(0,4) : xtr.substring(0,5);
        
        //Si Merma > 0 calcular valor de merma =  (Valor item  del contrato ) / peso estimado del item del contrato * Merma
        //SI merma > 0 calcular ajuste de inventario = merma (gramos) (PENDIENTE CUANDO ESTE INVENTARIO)
        if(merma > 0){
            //array_peso_estimado es el peso estimado de cada ítem y array_val_item es el valor $ de cada ítem
            for(var $k = 0; $k < array_val_item.length ; $k++){
                valor_merma = (array_val_item[$k]) / array_peso_estimado[$k] * merma;
            };
        }
        //Si Merma < 0 no se calcula  valor de merma 
        //SI merma < 0 calcula ajuste de inventario = merma (gramos negativo) (PENDIENTE CUANDO ESTE INVENTARIO)
        //si merma = 0 no hay movimientos

    // boton acepar modal mermas
        $('#btn_aceptar_merma').click(function(){
            setTimeout(function () { location.href = urlBase.make('contrato/fundicion'); }, 1000);
            $('#form_fundicion').submit();
        });

    // llenar el modal
        var load_data = "";
        $('.modal-body table tbody tr').remove();
            load_data += "<tr>";
                load_data += "<td>" + peso_estimado_modal + "</td>";
                load_data += "<td>" + peso_libre_modal + "</td>";
                load_data += "<td>" + merma_modal + "</td>";
                // información para movimientos contables y nuevo valor y peso de los items
                load_data += `<td> <input type='hidden' class='peso_estimado_modal' name='peso_estimado_modal' value=${peso_estimado_modal}>` + `</td>`;
                load_data += `<td> <input type='hidden' class='peso_libre_modal' name='peso_libre_modal' value=${peso_libre_modal}>` + `</td>`;
                load_data += `<td> <input type='hidden' class='merma_modal' name='merma_modal' value=${merma_modal}>` + `</td>`;
                load_data += `<td> <input type='hidden' class='valor_merma' name='valor_merma' value=${valor_merma}>` + `</td>`;
                load_data += `<td> <input type='hidden' class='merma_por_item' name='merma_por_item' value=${merma_por_item}>` + `</td>`;                
            load_data += "</tr>";
        $(".modal-body table tbody").append(load_data);
    //mostrar el modal
        $('#modalMermas').modal('show');

    }else{
        if(valDivRequiered('cont_fran'))
        {
            if('#subdividir'!=0){
                setTimeout(function () { location.href = urlBase.make('contrato/fundicion'); }, 1000);
                $('#form_fundicion').submit();
            }           
        }
    }
});

$('#btn-guardar').click(function () {
    $('#form_fundicion').submit();
});
/*BEGIND FUNCTION ANULAR ORDEN*/
    $('#btn_anular').click(function(){
        var id_orden="";
        //obtener tienda
        var tienda =   $('#col0_filter').val();
        //obtener orden
        id_orden = $('#table_fundicion .check-resolucionar:checked').parent().parent().parent().attr('id');
        if(id_orden!="" && id_orden!=null && id_orden!=undefined){
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: urlBase.make('contrato/fundicion/anular'),
                type: "POST",
                data:{
                    id_tienda: tienda,
                    id_orden: id_orden
                },
                success:function(data){
                    if(data == 3){
                        Alerta('Error','No puede anular la orden porque fueron procesados unos de sus IDs','error');
                    }else{
                        Alerta('Éxito','Orden anulada con éxito','success');
                    }
                    $('.button_filter').click();
                }
            });
        }else{
            Alerta('Error','Seleccione un registro','error');
        }
    });

    $('#btn_anular_confirm').click(function(){
        var id_orden = '';
        id_orden = $('#table_fundicion .check-resolucionar:checked').parent().parent().parent().attr('id');
        if(id_orden!="" && id_orden!=null && id_orden!=undefined){
            confirm.setTitle('Alerta');
            confirm.setSegment('¿Está seguro que desea anular la orden?');
            confirm.show();
            confirm.setFunction(function(){
                $('#btn_anular').click();
            });
        }else{
            Alerta('Advertencia','Seleccione un registro','warning');
        }
    });
/*END FUNCTION ANULAR ORDEN*/

var ESTADOS = (function () {
    var estado = {};
    estado.procesado = '';
    return {
        setProcesado: function (pro) {
            estado.procesado = pro;
        },
        getProcesado: function () {
            return estado.procesado;
        }
    }
})();

$('#btn-quitar').click(function(){
    var itemSelec = "";
    $('#tabla_fundicion_wrapper .selected').each(function(){
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
            url: urlBase.make('contrato/fundicion/validarItem'),
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
                        cont_tr += "<td>" + datos[indice].nombre_proceso + "</td>";
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

$('#confirmar').click(function () {
    var id_orden=$('#numero_orden').val();
    var itemSelec = "";
    $('#tabla_fundicion .selected').each(function () {
        itemSelec += $(this).attr('id') + "-" + id_orden + ",";        
    });
    
    itemSelec = itemSelec.slice(0, -1);
    if (itemSelec != "") {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('contrato/fundicion/quitarItems'),
            type: "POST",
            data: {
                items: itemSelec
            },
            success: function (datos) {
                if (datos == "exito") {
                    Alerta('Información', 'Se han quitado exitosamente los items.');
                    pageAction.redirect(urlBase.make('contrato/fundicion'));
                } else if(datos="error"){
                    Alerta('Advertencia', 'No se puede quitar items, ya existen IDs procesados', 'warning');
                    pageAction.redirect(urlBase.make('contrato/fundicion'));
                }else{
                    Alerta('Error', 'Ha ocurrido un error no se pudieron quitar los items.', 'error');
                    pageAction.redirect(urlBase.make('contrato/fundicion'));
                }
            }
        })
    }
});

/*ACTUALIZAR EL PROCESO ANTERIOR*/
$('.subdividir').mousedown(function () {
    if($(this).find('option:selected').val()==""){
        id_proceso_old=id_proceso_old;    
    }else{
        id_proceso_old = $(this).find('option:selected').val();
    }
    $('#selectAll').val("");
})

$('#selectAll').mousedown(function () {    
    id_proceso_old = $(this).find('option:selected').val();
})

/*SEARCH DESTINATARIOS*/
    /*AL CAMBIAR SELECCIONAR TODOS ACTUALIZA LOS ITEMS*/
    $('#selectAll').change(function(){
        //$('.items_dest').find('tbody').empty();
        $('.select-sub').val($('#selectAll').val());
    });

    var id_proceso_old;
    $('.subdividir,#selectAll').change(function () {
        if(id_proceso_old==""){
            $('.items_dest').find('tbody').empty();
        }
        var id_proceso = $(this).find('option:selected').val();
        if (id_proceso != "" ) {
            
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
                `<tr data-proceso='${id_proceso}' value="${id_proceso}">
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
                                    <input type="text" id="numero_documento" placeholder="Nit proveedor" name="numero_documento[]" class="form-control nit validate-required " required="required">
                                    <span class="input-group-addon white-color">
                                        <input id="prueba" maxlength='1' name="digito_verificacion[]" type="text" class="nit-val validate-required " onBlur="validarNit(this)" required>
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

    function validate_process(id_proceso_old){
        var cont_process = 0;
        $('#tabla_fundicion .subdividir option:selected[value="' + id_proceso_old + '"]').each(function(){
            ++cont_process;
        });
        if(cont_process > 0){
            return false;
        }else{
            return true;
        }
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
                console.log(data);
                var j = 0;
                jQuery.each(data, function (i, val) {
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
        $(val).parent().parent().parent().find(".nit-val").val(calcularDigitoVerificacion($(val).val()));
        $(val).parent().parent().parent().parent().parent().parent().find(".nit-val").blur();
        $('.content_buscador').hide();
    }
/*END SEARCH DESTINATARIOS*/

function resetChecks()
{
    $('.check-resolucionar').prop('checked', false);
}
 
/*BEGIND REPORTS INDEX */
    /*BOTON REPORTS INDEX validando que almenos 1 peso libre este ingresado en los items*/
    $("#btn-reporte").click(function(){
        var table = $('.check-resolucionar:checked')
        if (table.length > 0){
            $('.check-resolucionar:checked').each(function(){
                if($(this).parent().parent().parent().find('.var_peso_libre').text() == 0){
                    Alerta('Error','No se pueden generar reportes si el peso libre es 0.','error');
                }else{
                    $('#reporte').click();
                }
            })
        } else {
            Alerta('Error', 'Debe seleccionar un registro para poder continuar.', 'Error');
        }
    });
    /*END BOTON REPORTS INDEX*/

    /*Excel INDEX*/
    $('#btn_reporte_excel').click(function(){
        var id_orden = "";
        var id_tienda = $('#col0_filter').val();
        id_orden = $('#table_fundicion .check-resolucionar:checked').parent().parent().parent().attr('id');
        if(id_orden != "" && id_orden != undefined){
            Alerta('Cargando', 'Descargando Excel..', 'notice');
            pageAction.redirect(urlBase.make(`contratos/fundicion/excelfundicion/${ id_orden }/${ id_tienda }/fundicion`));
        }else{
            Alerta('Error', 'Seleccione un registro.', 'error');
        }
    });
    /*END EXCEL INDEX*/

    /*REPORTE INDEX*/
    $('#btn_reporte_pdf').click(function(){
        var id_orden = "";
        var id_tienda = $('#col0_filter').val();
        id_orden = $('#table_fundicion .check-resolucionar:checked').parent().parent().parent().attr('id');
        if(id_orden != "" && id_orden != undefined){
            $('#id_orden').val(id_orden);
            $('#id_tienda_contrato').val(id_tienda);
            $("#frm_reporte_pdf").attr("action", urlBase.make('contrato/fundicion/generatepdf'));
            $('#frm_reporte_pdf').submit();
        }else{
            Alerta('Error', 'Seleccione un registro.', 'error');
        }    
    });
    /*END REPORTE INDEX*/

    /*MINERÍA INDEX*/
    $('#btn_certificado_mineria_pdf').click(function(){
        var id_orden = "";
        var id_tienda = $('#col0_filter').val();
        id_orden = $('#table_fundicion .check-resolucionar:checked').parent().parent().parent().attr('id');
        if(id_orden != "" && id_orden != undefined){
            $('#id_orden').val(id_orden);
            $('#id_tienda_contrato').val(id_tienda);
            $("#frm_reporte_pdf").attr("action", urlBase.make('contratos/fundicion/pdfcertificadomineria'));
            $('#frm_reporte_pdf').submit();
        }else{
            Alerta('Error', 'Seleccione un registro.', 'error');
        }    
    });
    /*END MINERÍA INDEX*/
/*END FUNCTIONS INDEX */

/*BEGIND FUNCIONES REPORTS PROCESAR*/
    
    $("#btn_reports_procesar").click(function(){
        var modal = true;
        $('.peso_libre_input').each(function(){
            if($(this).val() == '' || $(this).val() == null){
                modal = false;
            }
        });
        if(modal == false){
            Alerta('Error','Validar que todos los pesos libres no esten vacios.','error');
        }else{
            $('#reporte_procesar').click();
        }
    });

    /*BEGIND EXCEL PROCESAR*/
    $('#btn_reporte_excel_create').click(function () {
        var id_orden = $('#id_orden').val();
        var id_tienda = $('#id_tienda_orden').val();
        if (id_orden != "" && id_orden != undefined) {
            Alerta('Cargando', 'Descargando Excel..', 'notice');
            pageAction.redirect(urlBase.make(`contratos/fundicion/excelfundicion/${id_orden}/${id_tienda}/fundicion`));
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error');
        }
    });
    /*END EXCEL PROCESAR*/
    /*BEGIND PDF PROCESAR*/
    $('#btn_reporte_pdf_create').click(function () {
        var id_orden = $('#id_orden').val();
        var id_tienda = $('#id_tienda_orden').val();
        if (id_orden != "" && id_orden != undefined) {
            $("#frm_reporte_pdf").attr("action", urlBase.make('contrato/fundicion/generatepdf'));
            $('#frm_reporte_pdf').submit();
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error');
        }
    });
    /*END PDF PROCESAR*/
    /*BEGIND MINERÍA PROCESAR*/
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
    /*END MINERÍA PROCESAR*/
/*END FUNCTIONS PROCESAR*/


/*BEGIND FUNCTION FOR DATATABLE DETAILS*/
    var fundicion = (function(){
        return {
            detalles_tabla: function () {
                $('#table_fundicion tbody').on('click', 'td.details-control', function () {
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
                        row.child(fundicion.detalle_tabla_html(codigo_orden, id_tienda)).show();
                        tr.addClass('shown');
                    }
                });
            },

            detalle_tabla_html: function (codigo_orden, id_tienda){
                var total_cantidad = 0, total_precio = 0;
                var html_tabla = '<table>';
                $.ajax({
                    url: urlBase.make('contrato/fundicion/getItemOrden/' + id_tienda + '/' + codigo_orden),
                    type: "get",
                    async: false,
                    success: function (datos) {
                        cant_cols = 0;
                        html_tabla += '<thead><th>Número ID</th><th>Categoría</th>';
                        jQuery.each(datos.columnas_items, function(indice, valor){
                            html_tabla += `<th>${ datos.columnas_items[indice].nombre }</td>`;
                            ++cant_cols; // SE SUMA LA CANTIDAD DE COLUMNAS PARA AGREGARLAS EN EL FOOTER
                        });
                        html_tabla += '<th>Atributos</th><th>Descripción</th><th>Peso total</th><th>Peso estimado</th><th>Peso taller</th><th>Peso libre</th><th>Número contrato</th></thead>'
                        
                        jQuery.each(datos.data, function(indice, valor) {
                            ++total_cantidad;
                            html_tabla +=
                            `<tr>
                            <td>${ datos.data[indice].id_inventario }</td>
                            <td>${ datos.data[indice].categoria }</td>`;
                            
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
                                '<td>' + datos.data[indice].nombre + '</td>' +
                                '<td>' + datos.data[indice].observaciones + '</td>' +
                                '<td>' + ((datos.data[indice].peso_total_individual != null) ? datos.data[indice].peso_total_individual : "") + '</td>' +
                                '<td>' + ((datos.data[indice].peso_estimado_individual != null) ? datos.data[indice].peso_estimado_individual : "") + '</td>' +
                                '<td>' + ((datos.data[indice].peso_taller_individual != null) ? datos.data[indice].peso_taller_individual : "") + '</td>' +
                                '<td>' + ((datos.data[indice].peso_libre_individual != null) ? datos.data[indice].peso_libre_individual : "") + '</td>' +
                                '<td>' + datos.data[indice].id_contrato + '</td>' +
                            '</tr>';
                        });
                    }
                });
                return html_tabla += '</table>';
            }
        }
    })();
/*END FUNCTIONS FOR DATATABLE DETAILS */

/*BEGIND FUNCTIONS TO TOTALS BAR*/

    var total_valor_contratos = 0,
        total_contratos = 0,
        valor_contrato = 0,
        total_peso_contratos = 0,
        total_peso_estimado_contratos = 0,
        total_peso_taller = 0,
        total_peso_libre = 0,
        total_peso_final = 0,
        peso_contrato = 0,
        peso_estimado_contrato = 0,
        cantidad_items = 0,
        total_cantidad_items = 0;

    function totales_resolucion() {
        $('.totales_resolucion tbody').on('click', '.check-resolucionar', function () {
            if (!$(this).find('td').hasClass('dataTables_empty')) {
                valor_contrato = ($(this).parent().parent().parent().find('td.var_valor_contrato').text() != '') ? ($(this).parent().parent().parent().find('td.var_valor_contrato').text().replace(/\./g, '').replace(',', '.')) : '$ 0';
                valor_contrato = parseFloat(valor_contrato.split('$ ')[1]);
                peso_contrato = ($(this).parent().parent().parent().find('td.var_peso_contrato').text() != '') ? parseFloat($(this).parent().parent().parent().find('td.var_peso_contrato').text()) : 0;
                peso_taller = ($(this).parent().parent().parent().find('td.var_peso_taller').text() != '') ? parseFloat($(this).parent().parent().parent().find('td.var_peso_taller').text()) : 0;
                peso_libre = ($(this).parent().parent().parent().find('td.var_peso_libre').text() != '') ? parseFloat($(this).parent().parent().parent().find('td.var_peso_libre').text()) : 0;
                peso_final = ($(this).parent().parent().parent().find('td.var_peso_final').text() != '') ? parseFloat($(this).parent().parent().parent().find('td.var_peso_final').text()) : 0;
                peso_estimado_contrato = ($(this).parent().parent().parent().find('td.var_peso_estimado_contrato').text() != '') ? parseFloat($(this).parent().parent().parent().find('td.var_peso_estimado_contrato').text()) : 0;
                cantidad_items = ($(this).parent().parent().parent().find('td.var_cantidad_items').text() != '') ? parseInt($(this).parent().parent().parent().find('td.var_cantidad_items').text()) : 0;

                valor_contrato = (valor_contrato == NaN || valor_contrato == "NaN") ? 0 : valor_contrato;
                peso_contrato = (peso_contrato == NaN) ? 0 : peso_contrato;
                peso_taller = (peso_taller == NaN) ? 0 : peso_taller;
                peso_libre = (peso_libre == NaN) ? 0 : peso_libre;
                peso_final = (peso_final == NaN) ? 0 : peso_final;
                peso_estimado_contrato = (peso_estimado_contrato == NaN) ? 0 : peso_estimado_contrato;
                cantidad_items = (cantidad_items == NaN) ? 0 : cantidad_items;

                if ($(this).val() == '1') {
                    total_valor_contratos -= valor_contrato;
                    total_peso_contratos -= peso_contrato;
                    total_peso_taller -= peso_taller;
                    total_peso_libre -= peso_libre;
                    total_peso_final -= peso_final;
                    total_peso_estimado_contratos -= peso_estimado_contrato;
                    total_cantidad_items -= cantidad_items;
                    --total_contratos;
                    $('#all_check').prop('checked', false);
                    $('#all_check').val('0');
                } else {
                    total_valor_contratos += valor_contrato;
                    total_peso_contratos += peso_contrato;
                    total_peso_taller += peso_taller;
                    total_peso_libre += peso_libre;
                    total_peso_final += peso_final;
                    total_peso_estimado_contratos += peso_estimado_contrato;
                    total_cantidad_items += cantidad_items;
                    ++total_contratos;
                }
                $('#lbl_total_valor_contratos').text(money.replace((total_valor_contratos.toFixed(money.getNumDecimal())).toString().replace(/\./g, ',')));                
                $('#lbl_total_peso_contratos').text(((total_peso_contratos.toFixed(2)).toString().replace(/\./g, ',')));
                $('#lbl_total_peso_taller').text(((total_peso_taller.toFixed(2)).toString().replace(/\./g, ',')));
                $('#lbl_total_peso_libre').text(((total_peso_libre.toFixed(2)).toString().replace(/\./g, ',')));
                $('#lbl_total_peso_final').text(((total_peso_final.toFixed(2)).toString().replace(/\./g, ',')));
                $('#lbl_estimado_peso_contratos').text(((total_peso_estimado_contratos.toFixed(2)).toString().replace(/\./g, ',')));
                $('#lbl_total_cantidad_items').text(((total_cantidad_items).toString()));
                $('#lbl_total_contratos').text(money.replace((total_contratos).toString()));
            }
        });

        // $('#all_check').click(function () {
        //     if ($(this).prop('checked')) {
        //         $('.check-resolucionar').prop('checked', true);
        //         $('.check-resolucionar').val('1');
        //         total_valor_contratos = 0;
        //         total_peso_contratos = 0;
        //         total_peso_estimado_contratos = 0;
        //         total_cantidad_items = 0;
        //         total_contratos = 0;
        //         total_peso_taller = 0;
        //         total_peso_libre = 0;
        //         total_peso_final = 0;
        //         $('.totales_resolucion tbody tr').find('td.var_valor_contrato').each(function () {
        //             valor_contrato = ($(this).text() != '') ? ($(this).text().replace(/\./g, '').replace(',', '.')) : '$ 0';
        //             valor_contrato = parseFloat(valor_contrato.split('$ ')[1]);
        //             peso_contrato = ($(this).parent().find('td.var_peso_contrato').text() != '') ? parseFloat($(this).parent().find('td.var_peso_contrato').text()) : 0;
        //             peso_estimado_contrato = ($(this).parent().find('td.var_peso_estimado_contrato').text() != '') ? parseFloat($(this).parent().find('td.var_peso_estimado_contrato').text()) : 0;
        //             cantidad_items = ($(this).parent().find('td.var_cantidad_items').text() != '') ? parseInt($(this).parent().find('td.var_cantidad_items').text()) : 0;
        //             peso_taller = ($(this).parent().find('td.var_peso_taller').text() != '') ? parseFloat($(this).parent().find('td.var_peso_taller').text()) : 0;
        //             peso_libre = ($(this).parent().find('td.var_peso_libre').text() != '') ? parseFloat($(this).parent().find('td.var_peso_libre').text()) : 0;
        //             peso_final = ($(this).parent().find('td.var_peso_final').text() != '') ? parseFloat($(this).parent().find('td.var_peso_final').text()) : 0;

        //             valor_contrato = (valor_contrato == NaN) ? 0 : valor_contrato;
        //             peso_contrato = (peso_contrato == NaN) ? 0 : peso_contrato;
        //             peso_estimado_contrato = (peso_estimado_contrato == NaN) ? 0 : peso_estimado_contrato;
        //             peso_taller = (peso_taller == NaN) ? 0 : peso_taller;
        //             peso_libre = (peso_libre == NaN) ? 0 : peso_libre;
        //             peso_final = (peso_final == NaN) ? 0 : peso_final;
        //             cantidad_items = (cantidad_items == NaN) ? 0 : cantidad_items;

        //             total_valor_contratos += valor_contrato;
        //             total_peso_contratos += peso_contrato;
        //             total_peso_estimado_contratos += peso_estimado_contrato;
        //             total_cantidad_items += cantidad_items;
        //             total_peso_taller += peso_taller;
        //             total_peso_libre += peso_libre;
        //             total_peso_final += peso_final;
        //             ++total_contratos;
        //         });
        //     } else {
        //         $('.check-resolucionar').prop('checked', false);
        //         $('.check-resolucionar').val('0');
        //         total_valor_contratos = 0;
        //         total_peso_contratos = 0;
        //         total_peso_estimado_contratos = 0;
        //         total_cantidad_items = 0;
        //         total_contratos = 0;
        //         total_peso_taller = 0;
        //         total_peso_libre = 0;
        //         total_peso_final = 0;
        //     }
        //     $('#lbl_total_valor_contratos').text(money.replace((total_valor_contratos.toFixed(money.getNumDecimal())).toString().replace(/\./g, ',')));
        //     $('#lbl_total_peso_contratos').text(money.replace((total_peso_contratos.toFixed(2)).toString().replace(/\./g, ',')));
        //     $('#lbl_estimado_peso_contratos').text(money.replace((total_peso_contratos.toFixed(2)).toString().replace(/\./g, ',')));
        //     $('#lbl_total_cantidad_items').text(((total_cantidad_items).toString()));
        //     $('#lbl_total_contratos').text(money.replace((total_contratos).toString()));
        //     $('#lbl_total_peso_taller').text(money.replace((total_peso_taller.toFixed(2)).toString().replace(/\./g, ',')));
        //     $('#lbl_total_peso_libre').text(money.replace((total_peso_libre.toFixed(2)).toString().replace(/\./g, ',')));
        //     $('#lbl_total_peso_final').text(money.replace((total_peso_final.toFixed(2)).toString().replace(/\./g, ',')));
        // });
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
    
            $('#table_fundicion tbody tr').each(function(){
                valor_contrato = ($(this).find('td.var_valor_contrato').text() != '') ? ($(this).find('td.var_valor_contrato').text().replace(/\./g, '').replace(',', '.')) : '$ 0';
                valor_contrato = parseFloat(valor_contrato.split('$ ')[1]);
                peso_contrato = ($(this).find('td.var_peso_contrato').text() != '') ? parseFloat($(this).find('td.var_peso_contrato').text()) : 0;
                peso_estimado_contrato = ($(this).find('td.var_peso_estimado_contrato').text() != '') ? parseFloat($(this).find('td.var_peso_estimado_contrato').text()) : 0;
                peso_taller = ($(this).parent().find('td.var_peso_taller').text() != '') ? parseFloat($(this).parent().find('td.var_peso_taller').text()) : 0;
                peso_libre = ($(this).parent().parent().parent().find('td.var_peso_libre').text() != '') ? parseFloat($(this).parent().parent().parent().find('td.var_peso_libre').text()) : 0;
                cantidad_items = ($(this).find('td.var_cantidad_items').text() != '') ? parseInt($(this).find('td.var_cantidad_items').text()) : 0;

                valor_contrato = (valor_contrato == NaN) ? 0 : valor_contrato;
                peso_contrato = (peso_contrato == NaN) ? 0 : peso_contrato;
                peso_estimado_contrato = (peso_estimado_contrato == NaN) ? 0 : peso_estimado_contrato;
                peso_taller = (peso_taller == NaN) ? 0 : peso_taller;
                peso_libre = (peso_libre == NaN) ? 0 : peso_libre;
                cantidad_items = (cantidad_items == NaN) ? 0 : cantidad_items;
    
                total_valor_contratos += valor_contrato;
                total_peso_contratos += peso_contrato;
                total_peso_estimado_contratos += peso_estimado_contrato;
                total_peso_taller += peso_taller;
                total_peso_libre += peso_libre;
                total_cantidad_items += cantidad_items;
                if($('#table_fundicion tbody tr').find('.dataTables_empty').length == 0)
                    ++total_contratos;
            });
    
            $('#lbl_total_valor_contratos').text(money.replace((total_valor_contratos.toFixed(money.getNumDecimal())).toString().replace(/\./g, ',')));
            $('#lbl_total_contratos').text(money.replace((total_contratos).toString()));
            $('#lbl_total_cantidad_items').text(((total_cantidad_items).toString()));

            $('#lbl_total_peso_contratos').text((total_peso_contratos.toFixed(2)).toString().replace(/\./g, ','));
            $('#lbl_estimado_peso_contratos').text((total_peso_contratos.toFixed(2)).toString().replace(/\./g, ','));
            $('#lbl_total_peso_taller').text((total_peso_taller.toFixed(2)).toString().replace(/\./g, ','));
            $('#lbl_total_peso_libre').text((total_peso_libre.toFixed(2)).toString().replace(/\./g, ','));
    }
/*END FUNCTIONS TOTALS BAR*/

function datatableFundicion(id_table, url_ajax, url_lenguage, columns) {
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
            // totales_resolucion();
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
        else if($('.filter_estado').val() == 3 || $('.filter_estado').val() == 2 || $('.filter_estado').val() == 0)
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

// Guarda la orden para procesar en otro momento
    function saveOrden(url){
            $("#form_fundicion").attr("action", urlBase.make(url));
            $('#form_fundicion').submit();
    }

/*BEGIND FUNCTION PESO_LIBRE = PESO_ESTIMADO FIRTS TIME CHARGE VIEW*/
    function transferPeso(){
        var peso_libre_vacio = $('.peso_libre_input').val();
        if(peso_libre_vacio == 0){
            $('.peso_libre_input').each(function(){
                $(this).val($(this).parent().parent().find('.peso_estimado').val());
            });
        }else{
            $('.peso_libre_input').val();
        }
    }
/*END FUNCTION PESO_LIBRE = PESO_ESTIMADO FIRTS TIME CHARGE VIEW*/

$(document).ready(function(){
    
    if($("#subdividir").val() == "1"){
        $("#cont-selectAll").css('display','inline-block');
        $("#cont-selectAll").css('display','inline-block');
    }
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
    
    
})

// Función para resetear campos
    function resetInputs(){
        if($("#subdividir").val() == 1){
            $("#subdividir").val(0);
        }else{
            $("#subdividir").val(1);
        }    
        $("#subdividir").click();
        $("#switch_check").click();
        $(".select-sub").change();
    }

    function  replaceNull(){
        $('table td').each(function(){
            if($(this).text() == "null"){
                $(this).text("");
            }
        });
    }
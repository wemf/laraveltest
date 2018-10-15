var arraypushx = [];
var array_in = ["0"];

var URL = (function(){
    var url = {};
        url.getSRC = '';
        url.getSRC2 = '';
    return {
        setSRC: function(url2){
            url.getSRC = url2;
        },
        getSRC: function(){
            return url.getSRC;
        },
        setSRC2: function(url2){
            url.getSRC2 = url2;
        },
        getSRC2: function(){
            return url.getSRC2;
        }
    }    
})();

$(document).ready(function(){
    $('.button_filter').click();
    $('.numeric').each(function(){
        $(this).keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
    });

    $('#telefono_residencia').keyup(function(){
        if ($(this).val() == ""){
            $('#telefono_celular').addClass('requiered');
            $('#telefono_celular_indicativo').addClass('requiered');
        } 
        else{
            $('#telefono_celular').removeClass('requiered');
            $('#telefono_celular_indicativo').removeClass('requiered');
        } 
    });

    $('#telefono_celular').keyup(function () {
        if ($(this).val() == ""){
            $('#telefono_residencia').addClass('requiered');
            $('#telefono_residencia_indicativo').addClass('requiered');
        } 
        else{
            $('#telefono_residencia').removeClass('requiered');
            $('#telefono_residencia_indicativo').removeClass('requiered');
        } 
    });

    $('#correo').blur(function(){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('generarplan/validarCorreo'),
            type: "get",
            data: {
                correo: $('#correo').val(),
                id_tienda: $('#id_tienda').val()
            },
            success: function(data) {
                if(data){
                    $('#correo').val("");
                    Alerta('Información', 'El correo que escribio ya existe. Intente ingresando otro diferente.', 'warning');
                }
            }
        });
    })

    $('#form-cliente').on('submit', function(e) {
        var rut = 'generarplan/createCliente';
        var rutx = 'generarplan/updateClienteT';
        if ($('#entrada').val() == "0") rut = 'generarplan/createClienteIngreso';
        if ($('#entrada').val() == "0") rutx = 'generarplan/updateClienteTIngreso';
        // console.log(rut, rutx);
        if ($('#cliente').val() == "1" && valDivRequiered('step1'))
        {
            var formData = new FormData(document.getElementById('form-cliente'));   
            formData.append('dato', 'valor');
            e.preventDefault();
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: urlBase.make(rut),
                type: "POST",
                async: false,
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    // console.log(data);
                    $('#codigo_cliente').val(data.replace(/['"]+/g, ''));
                    $('#x').val(data);
                }
            });
            if ($('#x').val() == '-3') {
                pageAction.redirect(urlBase.make('generarplan/verificarcliente'), 2);
                Alerta('Información', 'No se puede crear el cliente porque no se encontró una huella vigente', 'warning');
            } else if ($('#x').val() == '-1') {
                pageAction.redirect(urlBase.make('generarplan/verificarcliente'), 2);
                Alerta('Información', 'No se puede crear el cliente porque no hay secuencias de tienda, por favor contacte al administrador', 'warning');
            }
        }else if ($('#cliente').val() == "0" && valDivRequiered('step1')) {
            
            var formData = new FormData(document.getElementById('form-cliente'));
            formData.append('dato', 'valor');
            e.preventDefault();
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: urlBase.make(rutx),
                type: "POST",
                async: false,
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#x').val(data);
                }
            });
            if ($('#x').val() == '-3') {
                pageAction.redirect(urlBase.make('generarplan/verificarcliente'), 2);
                Alerta('Información', 'No se puede crear el cliente porque no se encontró una huella vigente', 'warning');
            }
        }
        else{
            e.preventDefault();
        }

        $('#primer_nombre_X').val($('#primer_nombre').val());
        $('#segundo_nombre_X').val($('#segundo_nombre').val());
        $('#primer_apellido_X').val($('#primer_apellido').val());
        $('#segundo_apellido_X').val($('#segundo_apellido').val());
    })

    $('.rest').click(function(){
        // $('#numero_documento').attr('readonly', 'readonly');
        // $('#tipo_documento').attr('disabled', false);
        $('.resertInp').val('');
        $('#alertPas').css('display', 'none');
        $('#divBtn').css('display', 'none');
        arraypushx = [];
        var dataTable = $('#productosPlan').DataTable();
        dataTable.clear().draw();
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });

    $('#ciudad_residencia').change(function(){
        fillInput('#ciudad', '#telefono_residencia_indicativo', urlBase.make('/ciudad/getinputindicativo2'));
        fillInput('#ciudad', '#telefono_celular_indicativo', urlBase.make('/ciudad/getinputindicativo'));
    });

    $('#rest2').click(function () {
        valVolver('2', '1');
    });

    $('#rest3').click(function(){
        valVolver('3', '1');
    });

    var t = $('#productosPlan').DataTable({
        language: {
            url: urlBase.make('/plugins/datatable/DataTables-1.10.13/json/spanish.json')
        }
    });
   
    $('#g3').click(function(){
        // PNotify.removeAll();
        var codigo_cliente = __($('#codigo_cliente').val());
        var id_tienda = __($('#id_tienda').val());
        var bandera = true;
        var monto = parseFloat(limpiarVal($('#monto').val()));
        var abono = parseFloat(limpiarVal($('#abono').val()));
        var deuda = parseFloat(limpiarVal($('#deuda').val()));
        var paso = $('#paso').val();
        var abono_mayor = parseFloat(limpiarVal($('#abono_mayor').val()));
        var valor_transferido = __($('#saldo_transferido').val());
        if (valor_transferido != "") valor_transferido = limpiarVal($('#saldo_transferido').val());
        if (valor_transferido == "") valor_transferido = 0;
        if (abono > monto) {
            Alerta('Error', 'Abono no debe ser mayor al monto.', 'error');
        }else if (abono < abono_mayor){
            Alerta('Error', 'Abono no debe ser menor al abono inicial.', 'error');
        }else if (__($('#porcentaje').val()) != "" && __($('#fecha_limite').val()) != ""){
                var isValid = true;
                var isValidCredito = validateFormaPago('credito'),
                    isValidDebito = validateFormaPago('debito'),
                    isValidOtro = validateFormaPago('otro'),
                    isValidObs = validateFormaPago('observaciones');

                if (($('#efectivo').val() == "" && !isValidCredito && !isValidDebito && !isValidOtro) || !isValidCredito || !isValidDebito || !isValidOtro || ((!isValidOtro && !isValidObs) || (isValidOtro && !isValidObs))) {
                    Alerta('Error', 'Debe ingresar un valor para realizar el abono.', 'Error');
                    isValid = false;
                }
                if (codigo_cliente && isValid && paso == "0") {
                    $('#paso').val("1");
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: urlBase.make('generarplan/create'),
                        type: 'post',
                        async: false,
                        data: {
                            id_tienda: id_tienda,
                            codigo_cliente: codigo_cliente,
                            correo: __($('#correo').val()),
                            direccion_residencia: __($('#direccion_residencia').val()),
                            telefono_residencia: __($('#telefono_residencia').val()),
                            telefono_celular: __($('#telefono_celular').val()),
                            monto: __($('#monto').val()),
                            abono: __($('#abono').val()),
                            fecha_creacion: __($('#fecha_creacion').val()),
                            fecha_limite: __($('#fecha_limite').val()),
                            deuda: __($('#deuda').val()),
                            id_tienda_cliente: __($('#id_tienda_cliente').val()),
                            id_cotizacion: __($('#id_cot').val()),
                            id_tienda_cot: __($('#id_tienda_cot').val()),
                            codigo_tienda: __($('#codigo_tienda').val()),
                            efectivo: __($('#efectivo').val()),
                            credito: __($('#credito').val()),
                            debito: __($('#debito').val()),
                            otro: __($('#otro').val()),
                            comprobante_credito: __($('#comprobante_credito').val()),
                            comprobante_debito: __($('#comprobante_debito').val()),
                            comprobante_otro: __($('#comprobante_otro').val()),
                            observaciones: __($('#observaciones').val()),
                            tipo_documento: __($('#tipo_documento').val()),
                            numero_documento: __($('#numero_documento').val()),
                            productos: arraypushx
                        },
                        success: function (datos){
                            if(!datos.val){
                                Alerta('Error',datos.msm,'error');
                                console.log(datos);
                                // pageAction.redirect(urlBase.make('generarplan'));
                            }else{
                                console.log(datos);
                                Alerta('Información', datos.msm, 'success', false);
                                Alerta('Información', 'En breve sera redireccionado', 'success', false);
                                $('#tipo_documento_var').val(datos.tipo_documento);
                                $('#numero_documento_var').val(datos.numero_documento);
                                $('#codigo_plan_var').val(datos.codigo_plan);
                                $('#id_tienda_var').val(datos.id_tienda);
                                $('#codigo_abono_var').val(datos.codigo_abono);
                                $('#monto_total_var').val(datos.monto_total);
                                $('#saldo_abonar_var').val(datos.saldo_abonar);
                                $('#saldo_pendiente_var').val(datos.saldo_pendiente);
                                $('#form_generate_pdf').submit();
                                setTimeout(function () {
                                    pageAction.redirect(urlBase.make('generarplan'));
                                }, 8000);
                                
                            }
                        }
                    });
                }else{
                    Alerta('Error', 'No se puede guardar varias veces el registro', 'Error');
                }
        }else{
            Alerta('Error', 'Esta tienda no cuenta con una configuración de termino y porcentaje', 'error');
        }    
    });
    
    $('#codigo_inventario').blur(function () {
        var codigo_inventario = __($('#codigo_inventario').val());
        if(codigo_inventario != "")
        {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('generarplan/getInventarioById'),
            type: 'get',
            data: {
                codigo_inventario: codigo_inventario,
            },
            success: function (datos) {
                    
                if (__(datos.nombre) != "") {
                    $('#alertPas').css('display', 'none');
                    $('#nombre_producto').val(__(datos.nombre));
                    $('#precio').val(__(datos.precio));
                    $('#peso').val(__(datos.peso_estimado));
                    $('#descripcion').val(__(datos.descripcion));
                    $('#id_inventario').val(__(datos.id_inventario));
                    $('#addproduct').css('display','');
                    $(".moneda").each(function () {
                        $(this).val(money.replace($(this).val()));
                    });
                } else {
                    $('#alertPas').css('display', 'block');
                    $('#textAlert').text('El producto buscado no esta disponible.');
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            }
        });
        }   
    });

    $('#producto').change(function(){
        arraypushx = [];
        var dataTable = $('#productosPlan').DataTable();
        dataTable.clear().draw();
        $('#id_cot').val('');
        $('#id_tienda_cot').val('');
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $('#total').text(0);
        if (parseInt($('#producto').val()) == 0){
            $('#cot').css('display', '');
            $('#codigo_inventarioX').attr('readonly', true);
            $('#div_referencia').removeClass('col-md-12');
            $('#div_referencia').addClass('col-md-6');
        }else{
            $('#cot').css('display', 'none');
            $('#codigo_inventarioX').attr('readonly', false);
            $('#div_referencia').removeClass('col-md-6');
            $('#div_referencia').addClass('col-md-12');
        }
    });

    $('#id_cotizacion').change(function(){
        $.ajax({
            url: urlBase.make('generarplan/getCotizacionById'),
            type: 'get',
            async: false,
            data: {
                id_cotizacion: $('#id_cotizacion').val(),
                id_tienda: $('#id_tienda').val()
            }, success: function (data) {
                $('#codigo_inventarioX').val(data.referencia);
                $('#descripcion').val(data.descripcion);
                $('#precio').val(data.precio);
                $('#peso').val(data.peso);
                var date = Date.parse(data.fecha_entrega);
                $('#fecha_entrega').val(date.toString('dd-MM-yyyy'));
                $('#div_fecha_entrega').show();
                $('#id_catalogo_producto').val(data.id_catalogo);
                $('#id_inventario').val(getSecuencia($('#id_tienda').val(), 23));
                $('#addproduct').css('display', '');
                $(".moneda").each(function () {
                    $(this).val(money.replace($(this).val()));
                });
            }
        });
    });

    $('#addproduct').click(function(){
        var paso = 1;
        var vaciar = 0;
        var cot = $('#id_cotizacion').val();
        var id_cot = cot.split("/")[0];
        var id_tienda_cot = cot.split("/")[1];
        $('#div_check_prod').hide();
        if (__($('#codigo_inventarioX').val()) != ''){

            jQuery.each(arraypushx, function (key, value) {
                if (arraypushx[key].codigo_inventario == $('#id_inventario').val())
                {
                    paso = 0;
                }
            });
            if(parseInt($('#producto').val()) == 0 && arraypushx.length == 1){
                $('#alertPas').css('display', 'block');
                $('#textAlert').text('No se puede agregar este producto ya que se esta haciendo un plan separe sin producto existente.');
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }else if (__($('#precio').val()) == ""){
                $('#alertPas').css('display', 'block');
                $('#textAlert').text('Este producto no se puede agregar ya que no cuenta con un precio.');
                $("html, body").animate({ scrollTop: 0 }, "slow");
            } else if (__($('#peso').val()) == "")
            {
                vaciar = 1;
                $('#tool').remove();
                $('#peso').after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
            }else if (paso == 1){
                vaciar = 0;
                arraypushx.push({
                    id_tienda: __($('#id_tienda').val()),
                    codigo_inventario: __($('#id_inventario').val()),
                    precio: limpiarVal(__($('#precio').val())),
                    peso: limpiarVal(__($('#peso').val())),
                    id_catalogo_producto: __($('#id_catalogo_producto').val())
                });

                array_in.push( $('#id_inventario').val() );
                
                t.row.add([
                    null,
                    $('#id_inventario').val(),
                    $('#codigo_inventarioX').val(),
                    $('#descripcion').val(),
                    `$${$('#precio').val()}`,
                    $('#peso').val()
                ]).draw( false );
                $('#id_cot').val(id_cot);
                $('#id_tienda_cot').val(id_tienda_cot);
                $('#addproduct').css('display', 'none');
                $('#alertPas').css('display','none');
            }else{
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
        if (vaciar == 0){
            $('#id_cotizacion').val('');
            $('#codigo_inventarioX').val('');
            $('#nombre_producto').val('');
            $('#precio').val('');
            $('#peso').val('');
            $('#descripcion').val('');
            $('#id_inventario').val('');
        } 

        $('#peso').attr('readonly', true);
        
        var arraySum = [];
        var total = 0;
        jQuery.each(arraypushx, function (key, value) {
            arraySum.push(arraypushx[key].precio);
        });
        total = sumNumbers(arraySum);
        total = money.replace(total.toString());
        
        $('#total').text(`$${total}`);
        
    });

    $('.obligatorio').change(function(){
        $(this).css('border','1px solid #ccc');
    });
    
    $('.obligatorio').keypress(function(){
        $(this).css('border','1px solid #ccc');
    });

    var table = $('#productosPlan').DataTable();

    $('#productosPlan tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#btn_quitar_item').click(function () {
        if ($('#productosPlan .selected td:nth-child(2)').text() != ""){
            // $.ajax({
            //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //     url: urlBase.make('generarplan/updateInventario'),
            //     type: 'post',
            //     async: false,
            //     data: {
            //         id_tienda: arraypushx[$('.selected').index()].id_tienda,
            //         id_inventario: arraypushx[$('.selected').index()].codigo_inventario,
            //         id_estado: 79,
            //         id_motivo: 29
            //     },
            //     success: function (data) {
            //         console.log(data);
            //     }
            // });
            var c = $('.selected').index() + 1;
            arraypushx.splice($('.selected').index(),1);
            array_in.splice(c,1);
            table.row('.selected').remove().draw(false);
            var arraySum = [];
            var total = 0;
            jQuery.each(arraypushx, function (key, value) {
                arraySum.push(arraypushx[key].precio);
            });
            total = sumNumbers(arraySum);
            total = money.replace(total.toString());
            $('#total').text(total);
        }else{
            Alerta('Error', 'Debe seleccionar un producto para poder quitarlo.', 'error');
        }
        // console.log(arraypushx);    
    });

    $('#g2').click(function () {
        var monto = [];
        var abono = 0;
        var deuda = 0;
        var i = 0;
        jQuery.each(arraypushx, function (key, value){
            jQuery.each(value, function (keyx, valuex){
                // console.log(keyx + " : " + valuex)
                if (keyx == "precio"){
                    // monto = eval(monto) + eval(valuex);
                    monto.push(valuex);
                }
                i++;
            });
        });
        
        total = sumNumbers(monto);
        $.ajax({
            url: urlBase.make('generarplan/getConfig'),
            type: 'get',
            async: false,
            data: {
                id_pais: $('#pais').val(),
                id_departamento: $('#departamento').val(),
                id_ciudad: $('#ciudad').val(),
                id_tienda: $('#id_tienda').val(),
                monto: total
            },success: function(data){
                if (data.length > 0){
                    $('#porcentaje').val(data[0].porcentaje_retroventa);
                    $('#id_porcentaje').val(data[0].porcentaje_retroventa);
                    var hoy = new Date();
                    var dias = 30 * parseInt(data[0].termino_contrato);
                    var calculado = new Date();
                    calculado.setDate(
                        hoy.getDate() + dias
                    ); 
                    var fecha = calculado.toISOString().split('T')[0];
                    var date = Date.parse(fecha);
                    $('#fecha_limite').val(date.toString('dd-MM-yyyy'));
                }
            }
        });
        var porcentaje = __($('#id_porcentaje').val());
        if (porcentaje != ""){
            var ab = parseFloat(total) * parseFloat(porcentaje) / 100;
            ab = String(ab).replace(/\./g, ",");
            var deu = parseFloat(total) - (parseFloat(total) * parseFloat(porcentaje)) / 100;
            deu = String(deu).replace(/\./g, ",");
            $('#abono_mayor').val(ab);
            $('#abono').val(0);
            // $('#abono').val(ab);
            // $('#efectivo').val(ab);
            $('#deuda').val(deu);
        }

        $('#monto').val(parseFloat(total));
        $('#porcentaje').val(porcentaje);
        $(".moneda").each(function (){
            $(this).val(money.replace($(this).val()));
        });
    });

    $('#g2TransferirPlan').click(function (){
        var monto = [];
        var abono = 0;
        var deuda = 0;
        var i = 0;
        var saldo_transferido = limpiarVal($('#saldo_transferido').val().trim());
        jQuery.each(arraypushx, function (key, value) {
            jQuery.each(value, function (keyx, valuex) {
                // console.log(keyx + " : " + valuex)
                if (keyx == "precio") {
                    // monto = eval(monto) + eval(valuex);
                    monto.push(valuex);
                }
                i++;
            });
        });
        var total = sumNumbers(monto);
        $.ajax({
            url: urlBase.make('generarplan/getConfig'),
            type: 'get',
            async: false,
            data: {
                id_pais: $('#pais').val(),
                id_departamento: $('#departamento').val(),
                id_ciudad: $('#ciudad').val(),
                id_tienda: $('#id_tienda').val(),
                monto: total
            }, success: function (data) {
                if (data.length > 0) {
                    $('#porcentaje').val(data[0].porcentaje_retroventa);
                    $('#id_porcentaje').val(data[0].porcentaje_retroventa);
                    var hoy = new Date();
                    var dias = 30 * parseInt(data[0].termino_contrato);
                    var calculado = new Date();
                    calculado.setDate(
                        hoy.getDate() + dias
                    );
                    var fecha = calculado.toISOString().split('T')[0];
                    $('#fecha_limite').val(fecha);
                }
            }
        });
        var porcentaje = __($('#id_porcentaje').val());
        if (porcentaje != "") {
            var abono = ((eval(total) * eval(porcentaje)) / 100) - eval(saldo_transferido);
            if(abono < 0){
                saldo_transferido = Math.abs(abono);
                abono = 0;
            }
            var deudaT = parseInt(total) - parseInt(abono) - limpiarVal($('#saldo_transferido').val().trim());
            if (parseInt(deudaT) < 0) deudaT = 0;
            $('#abono').val(0);
            // $('#abono').val(String(abono).replace(/\./g, ","));
            // $('#efectivo').val(String(abono).replace(/\./g, ","));
            $('#abono_mayor').val(abono);
            $('#deuda').val(String(deudaT).replace(/\./g, ","));
            $('#porcentaje').val(porcentaje);
            $('#val_tranfer').val(Math.abs(total - limpiarVal($('#saldo_transferido').val().trim())));
        }    
        $('#monto').val(total);
        $(".moneda").each(function () {
            $(this).val(money.replace($(this).val()));
        });
    });

    $('#g3Transferir').click(function(){
        // PNotify.removeAll();
        var codigo_cliente = __($('#codigo_cliente').val());
        var id_tienda = __($('#id_tienda').val());
        var bandera = true;
        var saldo_transferido = $('#saldo_transferido').val();
        if (parseInt(limpiarVal($('#monto').val())) < parseInt(limpiarVal(saldo_transferido))) saldo_transferido = $('#monto').val();
        var codigo_plan_transferir = $('#codigo_plan_transferir').val();
        var codigo_abono = $('#codigo_abono').val(); 
        
        var monto = parseFloat(limpiarVal($('#monto').val()));
        var abono = parseFloat(limpiarVal($('#abono').val()));
        var deuda = parseFloat(limpiarVal($('#deuda').val()));
        var abono_mayor = parseFloat(limpiarVal($('#abono_mayor').val()));
        var valor_transferido = __($('#saldo_transferido').val());
        var paso = $('#paso').val();
        if (valor_transferido != "") valor_transferido = limpiarVal($('#saldo_transferido').val());
        if (valor_transferido == "") valor_transferido = 0;
        
        if (abono > monto) {
            Alerta('Error', 'Abono no debe ser mayor al monto.', 'error');
        } else if (abono < abono_mayor) {
            Alerta('Error', 'Abono no debe ser menor al abono inicial.', 'error');
        } else if (__($('#porcentaje').val()) != "" && __($('#fecha_limite').val()) != "") {
            var isValid = true;
            var isValidCredito = validateFormaPago('credito'),
                isValidDebito = validateFormaPago('debito'),
                isValidOtro = validateFormaPago('otro'),
                isValidObs = validateFormaPago('observaciones');

            if (!isValidCredito || !isValidDebito || ((!isValidOtro && !isValidObs) || (isValidOtro && !isValidObs))) {
                Alerta('Error', 'Debe ingresar un valor para realizar el abono.', 'Error');
                isValid = false;
            }
            if (codigo_cliente && isValid && paso == "0") {
                $('#paso').val("1");
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: urlBase.make('generarplan/CreatePostTransferir'),
                    type: 'post',
                    data: {
                        id_tienda: id_tienda,
                        codigo_cliente: codigo_cliente,
                        saldo_transferido: saldo_transferido,
                        codigo_plan_transferir: codigo_plan_transferir,
                        codigo_abono: codigo_abono,
                        correo: __($('#correo').val()),
                        direccion_residencia: __($('#direccion_residencia').val()),
                        telefono_residencia: __($('#telefono_residencia').val()),
                        telefono_celular: __($('#telefono_celular').val()),
                        monto: __($('#monto').val()),
                        abono: __($('#abono').val()),
                        fecha_creacion: __($('#fecha_creacion').val()),
                        fecha_limite: __($('#fecha_limite').val()),
                        deuda: __($('#deuda').val()),
                        id_tienda_cliente: __($('#id_tienda_cliente').val()),
                        id_tienda_transfer: $('#id_tienda_transfer').val(),
                        id_cotizacion: __($('#id_cot').val()),
                        id_tienda_cot: __($('#id_tienda_cot').val()),
                        val_transfer: $('#val_tranfer').val(),
                        efectivo: __($('#efectivo').val()),
                        credito: __($('#credito').val()),
                        debito: __($('#debito').val()),
                        otro: __($('#otro').val()),
                        comprobante_credito: __($('#comprobante_credito').val()),
                        comprobante_debito: __($('#comprobante_debito').val()),
                        comprobante_otro: __($('#comprobante_otro').val()),
                        observaciones: __($('#observaciones').val()),
                        tipo_documento: __($('#tipo_documento').val()),
                        numero_documento: __($('#numero_documento').val()),
                        productos: arraypushx
                    },
                    success: function (datos){
                        console.log(datos.msmcreate);
                        if (!datos.msmcreate.val) {
                            Alerta('Error', datos.msmcreate.msm, 'error');
                            // pageAction.redirect(urlBase.make('/generarplan'));
                        }else{
                            Alerta('Información', datos.msmcreate.msm,'success', false);
                            Alerta('Información', 'En breve sera redireccionado','success',false);
                            $('#tipo_documento_var').val(datos.msmcreate.tipo_documento);
                            $('#numero_documento_var').val(datos.msmcreate.numero_documento);
                            $('#codigo_plan_var').val(datos.msmcreate.codigo_plan);
                            $('#id_tienda_var').val(datos.msmcreate.id_tienda);
                            $('#codigo_abono_var').val(datos.msmcreate.codigo_abono);
                            $('#monto_total_var').val(datos.msmcreate.monto_total);
                            $('#saldo_abonar_var').val(datos.msmcreate.saldo_abonar);
                            $('#saldo_pendiente_var').val(datos.msmcreate.saldo_pendiente);
                            $('#form_generate_pdf').submit();
                            setTimeout(function () {
                                pageAction.redirect(urlBase.make('generarplan'));
                            }, 8000);
                        }
                    }
                });
            }else{
                Alerta('Error', 'No se puede guardar varias veces el registro', 'Error');
            }
        } else {
            Alerta('Error', 'Esta tienda no cuenta con una configuración de termino y porcentaje', 'error');
        }   
    });
    var arraySum = [];
    var total = 0;
    jQuery.each(arraypushx, function (key, value) {
        arraySum.push(arraypushx[key].precio);
    });
    total = sumNumbers(arraySum);
    total = money.replace(total.toString());
    $('#total').text(total);
});

$('#pais').change(function(){
    loadSelectTableById('#pais', '#departamento', urlBase.make('generarplan/getSelectListById'),2,'departamento','id_pais');
});

$('#departamento').change(function(){
    loadSelectTableById('#departamento', '#ciudad', urlBase.make('generarplan/getSelectListById'),2,'ciudad','id_departamento');
});

$('#ciudad').change(function(){
    loadSelectTableById('#ciudad', '#id_tienda', urlBase.make('generarplan/getSelectListById'),2,'tienda','id_ciudad');
});


function loadSelectTableById(idIput, idTarget, url, inputDefaul = true,tabla,filter) {
    id = $(idIput).val();
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
            tabla : tabla,
            filter : filter,
            id : id
        },
        success: function (datos) {
            jQuery.each(datos, function (indice, valor) {
                var selected = "";
                if ($(idTarget).data('load') == valor.id) {
                    selected = "selected";
                }   
                $(idTarget).append($('<option value="' + valor.id + '" ' + selected + '>' + valor.name + '</option>'));
            });
        }
    });
}

function valProducto(id, sig, idbtn, sigbtn, step, step2) {
    var bandera = true;
    if (arraypushx.length < 1){
        bandera = false;
    }
    if (bandera) {
        $('#alertPas').css('display', 'none');
        $('#' + sig).show();
        $('#' + id).hide();
        $('#' + sigbtn).show();
        $('#' + idbtn).hide();
        $('#' + step).removeClass('btn-primary');
        $('#' + step).addClass('btn-default');
        $('#' + step2).addClass('btn-primary');
    } else {
        $('#alertPas').css('display', 'block');
        $('#textAlert').text('Agregue por lo menos un producto para poder continuar con el guardador.');
    }
};

function __($var){
    if ($var != '' && $var !== undefined && $var != undefined && $var != "undefined" && $var !== null){
        return $var;
    }else{
        return '';
    }
}

$('#efectivo, #debito, #credito, #otro').keyup(function(){
    var saldo_efectivo = ($('#efectivo').val() == "") ? 0 : limpiarVal($('#efectivo').val());
    var saldo_debito = ($('#debito').val() == "") ? 0 : limpiarVal($('#debito').val());
    var saldo_credito = ($('#credito').val() == "") ? 0 : limpiarVal($('#credito').val());
    var saldo_otro = ($('#otro').val() == "") ? 0 : limpiarVal($('#otro').val());
    var input = ($("#abono")[0]) ? 'abono' : 'saldo_abonar';
    var saldo = parseFloat(saldo_efectivo) + parseFloat(saldo_debito) + parseFloat(saldo_credito) + parseFloat(saldo_otro);    
    // $(".moneda").each(function () {
    $(`#${input}`).val(money.replace(saldo.toString()));
    // });
}); 

$('#efectivo, #debito, #credito, #otro').blur(function () {
    var saldo_efectivo = ($('#efectivo').val() == "") ? 0 : limpiarVal($('#efectivo').val());
    var saldo_debito = ($('#debito').val() == "") ? 0 : limpiarVal($('#debito').val());
    var saldo_credito = ($('#credito').val() == "") ? 0 : limpiarVal($('#credito').val());
    var saldo_otro = ($('#otro').val() == "") ? 0 : limpiarVal($('#otro').val());
    var input = ($("#abono")[0]) ? 'abono' : 'saldo_abonar';
    var abono = parseFloat(saldo_efectivo) + parseFloat(saldo_debito) + parseFloat(saldo_credito) + parseFloat(saldo_otro);
    if($("#abono")[0]){

        var monto = parseFloat(limpiarVal($('#monto').val()));
        var deuda = parseFloat(limpiarVal($('#deuda').val()));
        var abono_mayor = parseFloat(limpiarVal($('#abono_mayor').val()));
        var valor_transferido = __($('#saldo_transferido').val());
        if (valor_transferido != "") valor_transferido = limpiarVal($('#saldo_transferido').val());
        if (valor_transferido == "") valor_transferido = 0;
        
        if ((parseFloat(valor_transferido) + parseFloat(abono)) > monto) {
            // $('#abono').val(abono_mayor);
            $('#deuda').val(eval(monto - abono_mayor - valor_transferido));
            Alerta('Error', 'Abono no debe ser mayor al monto.', 'error');
        } else if ((parseFloat(valor_transferido) + parseFloat(abono)) >= abono_mayor && (parseFloat(valor_transferido) + parseFloat(abono)) <= monto) {
            deuda = eval(monto - abono - valor_transferido);
            $('#deuda').val(deuda);
        } else {
            // $('#abono').val(abono_mayor);
            deuda = eval(monto - abono_mayor - valor_transferido);
            $('#deuda').val(deuda);
            Alerta('Error', 'Abono no debe ser menor al abono inicial.', 'error');
        }
    }else{
        var monto = parseFloat(limpiarVal($('#saldo_pendiente').val())); 
        if ((parseFloat(valor_transferido) + parseFloat(abono)) > monto) {
            Alerta('Error', 'Abono no debe ser mayor a la deuda pendiente.', 'error');
        } 
    }
    $(`#${input}`).val(money.replace(abono.toString()));
});

$('#btn-procesar').click(function () {
    // PNotify.removeAll();
    var saldo_efectivo = ($('#efectivo').val() == "") ? 0 : limpiarVal($('#efectivo').val());
    var saldo_debito = ($('#debito').val() == "") ? 0 : limpiarVal($('#debito').val());
    var saldo_credito = ($('#credito').val() == "") ? 0 : limpiarVal($('#credito').val());
    var saldo_otro = ($('#otro').val() == "") ? 0 : limpiarVal($('#otro').val());
    var abono = parseFloat(saldo_efectivo) + parseFloat(saldo_debito) + parseFloat(saldo_credito) + parseFloat(saldo_otro);
    var isValid = true;
    var isValidCredito = validateFormaPago('credito'),
        isValidDebito = validateFormaPago('debito'),
        isValidOtro = validateFormaPago('otro'),
        isValidObs = validateFormaPago('observaciones');
    var paso = $('#paso').val();
    if (($('#efectivo').val() == "" && !isValidCredito && !isValidDebito && !isValidOtro) || !isValidCredito || !isValidDebito || ((!isValidOtro && !isValidObs) || (isValidOtro && !isValidObs))) {
        Alerta('Error', 'Debe ingresar un valor para realizar el abono.', 'Error');
        isValid = false;
    }
    var monto = parseFloat(limpiarVal($('#saldo_pendiente').val()));
    if (abono > monto) {
        isValid = false;
        Alerta('Error', 'Abono no debe ser mayor a la deuda pendiente.', 'error');
    }
    console.log(isValid);
    if (isValid && paso == "0") {
         $.ajax({
             headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
             url: urlBase.make('generarplan/guardar'),
             data: {
                 tipo_documento: $('#tipo_documento').val(),
                 numero_documento: $('#numero_documento').val(),
                 nombres: $('#nombres').val(),
                 codigo_planS: $('#codigo_planS').val(),
                 apellidos: $('#apellidos').val(),
                 monto_total: $('#monto_total').val(),
                 saldo_pendiente: $('#saldo_pendiente').val(),
                 saldo: $('#saldo').val(),
                 tienda: $('#tienda').val(),
                 codigo_transaccion: $('#codigo_transaccion').val(),
                 codigo_abono: $('#codigo_abono').val(),
                 fecha_abono: $('#fecha_abono').val(),
                 fecha_limite: $('#fecha_limite').val(),
                 saldo_abonar_efectivo: $('#efectivo').val(),
                 saldo_abonar_credito: $('#credito').val(),
                 saldo_abonar_debito: $('#debito').val(),
                 saldo_abonar_otro: $('#otro').val(),
                 comprobante_credito: $('#comprobante_credito').val(),
                 comprobante_debito: $('#comprobante_debito').val(),
                 comprobante_otro: $('#comprobante_otro').val(),
                 observaciones: $('#observaciones').val(),
                 saldo_abonar: $('#saldo_abonar').val(),
                 id_tienda: $('#id_tienda').val(),
                 id_comprobante: $('#id_comprobante').val(),
                 codigo_tienda: $('#codigo_tienda').val(),
            },
            type: 'post',
            success: function(datos) {
                // var tt = limpiarVal(saldo_pendiente) - limpiarVal(saldo_abonar);
                console.log(datos);
                if(!datos.val) {
                    Alerta('Error', datos.msm, 'error');
                }else{
                    $('#paso').val("1");
                    Alerta('Información', datos.msm, 'success', false);
                    Alerta('Información', 'En breve sera redireccionado', 'success', false);
                    $('#tipo_documento_var').val($('#tipo_documento').val());
                    $('#numero_documento_var').val($('#numero_documento').val());
                    $('#codigo_plan_var').val($('#codigo_planS').val());
                    $('#id_tienda_var').val($('#id_tienda').val());
                    $('#codigo_abono_var').val($('#codigo_abono').val());
                    $('#monto_total_var').val($('#monto_total').val());
                    $('#saldo_abonar_var').val($('#saldo_abonar').val());
                    $('#saldo_pendiente_var').val(parseFloat(limpiarVal($('#saldo_pendiente').val())) - parseFloat(limpiarVal($('#saldo_abonar').val())));
                    $('#form_generate_pdf').submit();
                    setTimeout(function () {
                        pageAction.redirect(urlBase.make('generarplan'));
                    }, 7000);
                }
            }
         });  
    }else{
        if (paso == "1") {
            // PNotify.removeAll();
            Alerta('Error', 'No se puede guardar varias veces el registro', 'Error');
        }
    }
});


$('#transferir').change(function(){
    var transferir = __($('#transferir').val());
    var transferirC = __($('#contrato').val());
    var codigo_planS = __($('#codigo_planS').val());
    var numero_documento = __($('#numero_documento').val());
    var id_tienda = __($('#id_tienda_cliente').val());
    var codigo_cliente = __($('#codigo_cliente').val());
    $('#transferirA option').remove();
    $('#transferirA').append('<option value="">- Seleccione una opción -</option>');

    if(transferir == "1"){
        $.ajax({
            headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: urlBase.make('generarplan/getTransferirPlan'),
            data:{
                id_tienda: id_tienda,
                codigo_cliente: codigo_cliente,
                numero_documento: numero_documento,
                codigo_plan: codigo_planS
            },
            type: 'get',
                success: function (transfePlan){
                    for (var i=0; transfePlan.length > i; i++){
                        $('#transferirA').append('<option value="' + transfePlan[i].codigo_plan_separe + '">' + transfePlan[i].codigo_plan_separe + ' - Saldo pendiente:' + transfePlan[i].saldo_pendiente +'</option>');
                    }
                }
            })
	}else if(transferir == '2'){
        $.ajax({
            headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: urlBase.make('generarplan/getTransferirContrato'),
            data:{
                id_tienda: id_tienda,
                codigo_cliente: codigo_cliente
            },
            type: 'get',
                success: function (transfeCont){
                    for (var f=0; transfeCont.length > f; f++) {
                        $('#transferirA').append('<option value="' + transfeCont[f].codigo_contrato + '">' + transfeCont[f].codigo_contrato+' - Valor prorroga:'+transfeCont[f].prorroga +'</option>');
                    }
                }
            })
    }
});

$('#transferirA').change(function(){
    var codigo_plan = $(this).val();
    var codigo_cliente = $('#codigo_cliente').val();
    var transferir = __($('#transferir').val());
    var id_tienda_cliente = __($('#id_tienda_cliente').val());
    var id_tienda = __($('#id_tienda').val());
    if(transferir == "1"){
        $.ajax({
            url: urlBase.make('generarplan/getTransferPlanH'),
            type: "get",
            data:{
                codigo_cliente: codigo_cliente,
                codigo_plan: codigo_plan
            },
            success: function(datos){
                // console.log(datos);
                $('#deuda2').val(datos[0].deuda);
                $('#id_tienda_plan').val(datos[0].id_tienda);
            }
        })
    }else if(transferir == "2"){
        $.ajax({
            url: urlBase.make('generarplan/mesesAdeudados'),
            type: "get",
            data:{
                codigo_cliente: codigo_cliente,
                id_tienda: id_tienda,
                codigo_contrato: $('#transferirA').val()
            },
            success: function(datos){
                console.log(datos);
                $('#meses_adeudados').val(datos[0].meses_adeudados);
                $('#precio_total').val(datos[0].valor_contrato);
            }
        })
    }
});

$('#cantidad').keyup(function(){
    var codigo_plan = $('#transferirA').val();
    var codigo_cliente = $('#codigo_cliente').val();
    var transferir = __($('#transferir').val());
    var id_tienda_cliente = __($('#id_tienda_cliente').val());
    var id_tienda = __($('#id_tienda').val());
    if (transferir == "2") {
        $('#total_prorrogar').val($('#cantidad').val());
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('generarplan/getTransferirContratoS'),
            type: "get",
            data: {
                codigo_cliente: $('#codigo_cliente').val(),
                id_tienda: $('#id_tienda').val(),
                codigo_contrato: $('#transferirA').val()
            },
            success: function (datos) {
                var valor_abonado_bd = datos.valor_abonado_bd;
                if (valor_abonado_bd.length > 0) valor_abonado_bd = datos.valor_abonado_bd[0].valor;
                if (__(valor_abonado_bd) == "") valor_abonado_bd = "0";

                $('#id').val($('#transferirA').val());
                $('#valor_ingresado').val(limpiarVal($('#cantidad').val()));
                $('#deuda2').val(datos.data.monto);
                $('#porcen_retro').val(datos.porcentaje_retroventa);
                $('#valor_abonado_bd').val(valor_abonado_bd);
                $('#fecha_terminacion_cabecera').val(datos.fecha_terminacion_cabecera);
                $('#id_tienda_plan').val(datos.data.DT_RowId.split("/")[1]);
                prorroga.calcularMeses();
            }
        });
    }
});

$('#btn-transferP').click(function () {
    // PNotify.removeAll();
    var transferir = $('#transferir').val();
    var transferirA = $('#transferirA').val();
    var transferirNuevoPlan = $('#trasferir_nuevo_plan').val();
    var id_tienda = $('#id_tienda').val();
    var saldo_favor = limpiarVal($('#saldo_favor').val());
    var codigo_abono = $('#codigo_abono').val();
    var codigo_plan = $('#codigo_planS').val();
    var cantidad = limpiarVal($('#cantidad').val());
    var paso = $('#paso').val();
    if(cantidad == "") cantidad = 0;
    if (transferirNuevoPlan == "1") {
        if (parseFloat(saldo_favor) > 0 && parseFloat(cantidad) > 0 && parseFloat(cantidad) <= parseFloat(saldo_favor)) {
            pageAction.redirect(urlBase.make('/generarplan/verificarclienteTransfer/' + id_tienda + '/' + cantidad + '/' + codigo_plan));
        } else {
            if (parseFloat(saldo_favor) == 0){
                Alerta('Error', 'No cuenta con saldo a favor para transferir.', 'Error');
            } else if (parseFloat(cantidad) > parseFloat(saldo_favor)) {
                Alerta('Error', 'La cantidad no debe ser mayor al saldo a favor.', 'Error');
            } else{
                Alerta('Error', 'La cantidad debe ser mayor a cero.', 'Error');
            }
        }
    } else if (parseInt(limpiarVal($('#saldo_favor').val())) >= parseInt(limpiarVal($('#deuda2').val())) && $('#id_tienda_login').val() != $('#id_tienda_plan').val())
    {
        Alerta('Error', 'No se puede transferir el valor total de la deuda ya que no es la tienda donde se realizo el plan separe.', 'Error');
    }else{
        if (eval(saldo_favor) > 0 && parseFloat(cantidad) > 0 && parseFloat(cantidad) <= parseFloat(saldo_favor)) {
            if (valDivRequiered('content_transfer')) {
                if (transferir == "1") {
                    var saldo_plan = $('#transferirA option:selected').text().split(":");
                    saldo_plan = limpiarVal(saldo_plan[1].toString());
                    if (parseFloat(cantidad) <= parseFloat(saldo_plan) && paso == "0"){
                        $('#paso').val("1");
                        $.ajax({
                            url: urlBase.make('generarplan/transferirGuardar'),
                            type: "get",
                            data: {
                                codigo_plan_separe: $('#codigo_planS').val(),
                                transferir: transferir,
                                transferirA: transferirA,
                                codigo_abono: $('#codigo_abono').val(),
                                saldo_favor: $('#cantidad').val(),
                                id: $('#id').val(),
                                codigo_cliente: $('#codigo_cliente').val(),
                                id_tienda: $('#id_tienda').val(),
                                precio_total: $('#precio_total').val(),
                                deuda2: $('#deuda2').val(),
                                porcentaje_retroventa: $('#porcen_retro').val(),
                                valor_abonado_bd: $('#valor_abonado_bd').val(),
                                meses_prorroga: $('#meses_prorroga').val(),
                                valor_ingresado: $('#valor_ingresado').val(),
                                nuevo_valor_abonado: $('#nuevo_valor_abonado').val(),
                                fecha_prorroga: $('#fecha_prorroga').val(),
                                fecha_terminacion_cabecera: $('#fecha_terminacion_cabecera').val(),
                                saldo_pendiente_plan: $('#saldo_pendiente_plan').val(),
                                id_tienda_plan: $('#id_tienda_plan').val(),
                                saldo_pendiente: $('#saldo_pendiente_transfer').val()
                            },
                            success: function (datos) {
                                if (!datos.val) {
                                    Alerta('Error', datos.msm, 'error');
                                    // pageAction.redirect(urlBase.make('generarplan'));
                                } else {
                                    Alerta('Información', datos.msm, 'success', false);
                                    Alerta('Información', 'Desacargando pdf...', 'success', false);
                                    Alerta('Alerta', 'Recuerde transferir todo el saldo a favor de este plan separe', 'Error', false);
                                    // pageAction.redirect(urlBase.make('generarplan'));
                                    $('#codigo_plan_var').val(datos.data.codigo_plan_separe);
                                    $('#id_tienda_var').val(datos.data.id_tienda);
                                    $('#codigo_abono_var').val(datos.data.codigo_abono);
                                    $('#saldo_abonar_var').val(datos.data.saldo_abonado);
                                    $('#saldo_pendiente_var').val(datos.data.saldo_pendiente);
                                    $('#form_generate_pdf').submit();
                                    setTimeout('document.location.reload()', 6000);
                                }
                            }
                        })
                    }else{
                        if (parseFloat(cantidad) > parseFloat(saldo_plan)) {
                            Alerta('Error', 'No se puede transferir un monto mayor al saldo pendiente del plan separe seleccionado.', 'Error');
                        }else{
                            Alerta('Error', 'No se puede guardar varias veces el registro', 'Error');
                        }
                    }
                }else if (transferir == "2") {
                    var limit_prorrogar = 0,
                        meses_prorrogar = 0;
                        limit_prorrogar = parseInt($('#meses_adeudados').val()) + 1;
                        limit_prorrogar = (limit_prorrogar < 0) ? 0 : limit_prorrogar;
                        meses_prorrogar = parseInt($('#meses_prorroga').val());
                if (meses_prorrogar > limit_prorrogar) {
                    Alerta('Alerta', `No puede prorrogar más de ${limit_prorrogar} meses`, 'warning');
                }else if (saldo_favor > deuda2) {
                    Alerta('Error', 'No se puede transferir porque el saldo a favor es mayor al valor del contrato', 'error');
                    // pageAction.redirect(urlBase.make('generarplan'));
                } else if (saldo_favor <= 0) {
                    Alerta('Error', 'No se puede transferir porque el saldo a favor debe ser mayor a 0', 'error');
                    // pageAction.redirect(urlBase.make('generarplan'));
                } else if (paso == "1"){
                    Alerta('Error', 'No se puede guardar varias veces el registro', 'Error');
                }else{
                    $('#paso').val("1");
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: urlBase.make('contrato/prorrogarAjax'),
                        type: "post",
                        data: {
                            transferir: transferir,
                            transferirA: transferirA,
                            codigo_plan_separe: $('#codigo_planS').val(),
                            codigo_abono: $('#codigo_abono').val(),
                            saldo_favor: limpiarVal($('#cantidad').val()),
                            id: $('#id').val(),
                            codigo_cliente: $('#codigo_cliente').val(),
                            id_tienda_plan: $('#id_tienda').val(),
                            precio_total: limpiarVal($('#precio_total').val()),
                            deuda2: $('#deuda2').val(),
                            porcentaje_retroventa: $('#porcen_retro').val(),
                            valor_abonado_bd: limpiarVal($('#valor_abonado_bd').val()),
                            meses_prorroga: $('#meses_prorroga').val(),
                            valor_ingresado: limpiarVal($('#cantidad').val()),
                            nuevo_valor_abonado: limpiarVal($('#nuevo_valor_abonado').val()),
                            fecha_prorroga: $('#fecha_prorroga').val(),
                            fecha_terminacion_cabecera: $('#fecha_terminacion_cabecera').val(),
                            id_tienda: $('#id_tienda_plan').val()
                        },
                        success: function (datos) {
                            if (saldo_favor < deuda2) {
                                if (!datos.val) {
                                    Alerta('Error', datos.msm, 'error');
                                    // pageAction.redirect(urlBase.make('generarplan'));
                                } else {
                                    Alerta('Información', datos.msm, 'success', false);
                                    Alerta('Alerta', 'Recuerde transferir todo el saldo a favor de este plan separe', 'error',false);
                                    $('#pdfcontrato').attr('action', urlBase.make(`contrato/prorrogar/generarpdf/${$('#id').val()}/${$('#id_tienda_plan').val()}`));
                                    $('#boton_pdf').click();
                                    // pageAction.redirect(urlBase.make('generarplan'));
                                    setTimeout('document.location.reload()', 5000);
                                }
                            } else {
                                Alerta('Error', 'No se puede transferir porque el saldo a favor es mayor al valor del contrato', 'error');
                                // pageAction.redirect(urlBase.make('generarplan'));
                            }
                        }
                    })
                }
            }
        }
        } else {
            if (parseFloat(saldo_favor) == 0){
                Alerta('Error', 'No cuenta con saldo a favor para transferir.', 'Error');
            } else if (parseFloat(cantidad) > parseFloat(saldo_favor)){
                Alerta('Error', 'La cantidad no debe ser mayor al saldo a favor.', 'Error');
            } else{
                Alerta('Error', 'Necesita ingresar la cantidad que va a transferir.', 'Error');
            }
        }
    }
});

( $('#isset_abonos').val() == 1 ) ? $('#anular').attr("disabled", true) : $('#anular').removeAttr("disabled");

$('#anular').click(function(){
    // PNotify.removeAll();
    var saldo_abonado = parseFloat(limpiarVal($('#saldo').val()));
    var id_tienda = $('#id_tienda').val();
    var codigo_plan = $('#codigo_planS').val();
    var idRemitente = $('#idRemitente').val();
    if (saldo_abonado == 0){
        $.ajax({
            url: urlBase.make('generarplan/anular'),
            data:{
                id_tienda: id_tienda,
                codigo_plan: codigo_plan,
                idRemitente: idRemitente
            },
            type: 'get',
                success: function (anular){
                    Alerta('Insertado','Petición realizada con éxito','success');
                    pageAction.redirect(urlBase.make('generarplan'));
                }
        })
    }else{
        Alerta('Error','No se puede anular el plan aún tiene abonos asignados','error');
    }
});

$('#solicitud_anular').click(function(){
    // PNotify.removeAll();
    var saldo_abonado = parseFloat(limpiarVal($('#saldo').val()));
    var id_tienda = $('#id_tienda').val();
    var codigo_plan = $('#codigo_planS').val();
    var idRemitente = $('#idRemitente').val();
    if (saldo_abonado == 0 && $('#dataTableAction tbody tr').length == 2 && $('#dataTableAction tbody tr:nth-child(1)').find('td:nth-child(4)').text() == "Abono" && $('#dataTableAction tbody tr:nth-child(2)').find('td:nth-child(4)').text() == "Reverso abono") {
        $.ajax({
            url: urlBase.make('generarplan/solicitudAnulacion'),
            data:{
                id_tienda: id_tienda,
                codigo_plan: codigo_plan,
                idRemitente: idRemitente
            },
            type: 'get',
            success: function (anular){
                Alerta('Insertado','Petición realizada con éxito','success');
                pageAction.redirect(urlBase.make('generarplan'));
            }
        })
    }else{
        if (saldo_abonado > 0){
            Alerta('Error','No se puede anular el plan aún tiene abonos asignados, para poder continuar transfiera los abonos asociados al plan.','error');
        }else{
            Alerta('Error', 'Ya no es posible anular el plan separe.', 'error');
        }
    }
});

$('#solicitar_reversar_abono').click(function(){
    // PNotify.removeAll();
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    if (valueId != undefined)
    {
        valueId = valueId.split('/')[2];
    }else{
        Alerta('Error', 'Seleccione un registro para continuar.', 'error');
    }
    var id_tienda = $('#id_tienda').val();
    var codigo_plan = $('#codigo_planS').val();
    var codigo_abono = $('#codigo_abono').val();
    var id_abono = $('#dataTableAction .selected td:nth-child(3)').text();
    var idRemitente = $('#idRemitente').val();
    var fecha_creacion = $('#dataTableAction .selected td:nth-child(6)').text();
        fecha_creacion = fecha_creacion.split(" ");
        fecha_creacion = fecha_creacion[0];
    var fecha_actual = $('#fecha_actual').val();
    var tipo = $('#dataTableAction .selected td:nth-child(4)').text();
    var saldo = parseFloat(limpiarVal($('#saldo').val()));
    var valor_abono_rev = parseFloat(limpiarVal($('#dataTableAction .selected td:nth-child(5)').text()));
    if (fecha_actual == fecha_creacion && tipo == 'Abono' && saldo > 0 && saldo >= valor_abono_rev && valueId == "0")
    {
        $.ajax({
            url: urlBase.make('generarplan/solicitarReversarAbono'),
            data:{
                id_tienda: id_tienda,
                codigo_plan: codigo_plan,
                codigo_abono: codigo_abono,
                id_abono: id_abono,
                idRemitente: idRemitente
            },
            type: 'get',
            success: function(data){
                if (!data.val) {
                    Alerta('Error', data.msm, 'error');
                    // pageAction.redirect(urlBase.make('generarplan'));
                } else {
                    Alerta('Información', data.msm);
                    pageAction.redirect(urlBase.make('generarplan'));
                }
            }
        })
    }else{
        if (saldo < valor_abono_rev){
            Alerta('Error', 'No se puede reversar ya que el abono es mayor a la cantidad abonada.', 'error');
        }else if (saldo < 1){
            Alerta('Error', 'El saldo tiene que ser mayor a cero para poder reversar..', 'error');
        } else if (valueId == undefined) {
            Alerta('Error', 'Seleccione un registro para continuar.', 'error');
        }else if (fecha_actual != fecha_creacion){
            Alerta('Error','No se puede reversar el abono, el plazo a caducado.','error');
        } else if (valueId == "1") {
            Alerta('Error','Este abono ya ha sido reversado anteriormente.','error');
        }else{
            Alerta('Error','No se puede reversar ya que no es un abono.','error');
        }
    }   
});

$('#reversar_abono').click(function(){
    var id_tienda = $('#id_tienda').val();
    var codigo_plan = $('#codigo_planS').val();
    var codigo_abono = $('#codigo_abono').val();
    var id_abono = $('#abonorever').val();
    var saldo_abono = $('#abonorever_sal').val();
    var fecha_creacion = $('#fecha_creacion').val();
    var fecha_actual = $('#fecha_actual').val();
    var idRemitente = $('#idRemitente').val();
    $.ajax({
        url: urlBase.make('generarplan/reversarAbono'),
        type: 'get',
        data:{
            id_tienda: id_tienda,
            codigo_plan: codigo_plan,
            id_abono: id_abono, 
            saldo_abono: saldo_abono,
            saldo_pendiente: $('#saldo_pendiente').val(),
            fecha_actual: fecha_actual,
            codigo_abono: codigo_abono,
            idRemitente: idRemitente,
            abonorever: $('#abonorever').val()
        },
        success: function (data){
                if (!data.val) {
                    Alerta('Error', data.msm, 'error');
                    // pageAction.redirect(urlBase.make('generarplan'));
                } else {
                    Alerta('Información', data.msm);
                    pageAction.redirect(urlBase.make('generarplan'));
                }
            }
    });
});

$('#rechazar_reversar_abono').click(function(){
    var id_tienda = $('#id_tienda').val();
    var codigo_plan = $('#codigo_planS').val();
    var codigo_abono = $('#abonorever').val();
    var idRemitente = $('#idRemitente').val();
    $.ajax({
        url: urlBase.make('generarplan/rechazarReversar'),
        data:{
            id_tienda: id_tienda,
            codigo_plan: codigo_plan,
            codigo_abono: codigo_abono,
            idRemitente: idRemitente
        },
        type: 'get',
        success: function (data){
            if (!data.val) {
                Alerta('Error', data.msm, 'error');
                pageAction.redirect(urlBase.make('generarplan'));
            } else {
                Alerta('Información', data.msm);
                pageAction.redirect(urlBase.make('generarplan'));
            }
        }
    })
});






////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$('#codigo_inventarioX').keyup(function(){
    var option = "";
    $('.content_buscador').show('slow');
    if(parseInt($('#producto').val()) == 1)
    {
        $.ajax({
            url: urlBase.make('generarplan/getInventarioById'),
            type: "get",
            data: {
                id_pais: $('#pais').val(),
                id_departamento: $('#departamento').val(),
                array_in: array_in,
                id_tienda: $('#id_tienda').val(),
                referencia: $('#codigo_inventarioX').val()
            },
            success: function (data) {
                var j = 0;
                var id_inven = "";
                jQuery.each(data, function (i, val) {
                    if (__(data[j]) != "") {
                        if (__(data[j].id_inventario) != "") id_inven = data[j].id_inventario;
                        option += `<option value="${data[j].id}|${data[j].nombre}|${data[j].descripcion}|${data[j].peso}|${id_inven}|${data[j].precio}">${id_inven} - ${data[j].nombre} - ${data[j].descripcion} - ${data[j].precio}</option>`;
                        j++;
                    }
                });
                $('#select_codigo_inventario').empty().append(option);
                option = "";
            }
        });
    }else{
        $.ajax({
            url: urlBase.make('generarplan/getInventarioById2'),
            type: "get",
            data: {
                id_pais: $('#pais').val(),
                id_departamento: $('#departamento').val(),
                id_ciudad: $('#ciudad').val(),
                id_tienda: $('#id_tienda').val(),
                referencia: $('#codigo_inventarioX').val()
            },
            success: function (data) {
                var j = 0;
                var id_inven = "";
                jQuery.each(data, function (i, val) {
                    if (__(data[j]) != "") {
                        if (__(data[j].id_inventario) != "") id_inven = data[j].id_inventario;
                        option += '<option value="' + data[j].id + '|' + data[j].nombre + '|' + data[j].descripcion + '|' + id_inven + '" >' + data[j].nombre + ' - ' + data[j].descripcion + '</option>';
                        j++;
                    }
                });
                $('#select_codigo_inventario').empty().append(option);
                option = "";
            }
        })
    }
});

$('#step-2').click(function(){
    $('.content_buscador').hide('slow');
});

function selectValue(val)
{
    $('#precio').val('');
    $('#peso').val('');
    $('#descripcion').val('');
    var datos = val.value.split("|");
    $.ajax({
        url: urlBase.make('generarplan/getInfoPrecio'),
        type: "get",
        data: {
            id: datos[0],
            id_tienda: $('#id_tienda').val()
        },
        success: function (data) {
            $('#codigo_inventarioX').val(datos[1]);
            $('#id_catalogo_producto').val(datos[0]);
            $('#descripcion').val(datos[2]);
            if(__(datos[3]) != "") $('#peso').val(datos[3]);
            (__(datos[4]) == "") ? $('#id_inventario').val(getSecuencia($('#id_tienda').val(), 23)) : $('#id_inventario').val(datos[4]);
            (__(datos[5]) == "") ? $('#precio').val(data.valor_venta_x_1) : $('#precio').val(datos[5]);
            $('#precio').val(data.valor_venta_x_1);
            $('.content_buscador').hide('slow');
            if (__(data.valor_venta_x_1) != "" || __(datos[5]) != "") $('#addproduct').css('display', '');
            $(".moneda").each(function () {
                $(this).val(money.replace($(this).val()));
            });
        }
    })

}

function total() {
    var arraySum = [];
    var total = 0;
    jQuery.each(arraypushx, function (key, value) {
        arraySum.push(arraypushx[key].precio);
    });
    total = sumNumbers(arraySum);
    total = money.replace(total.toString());

    return total;
}

function getSecuencia(id_tienda,id_tipo)
{
    var response = "";
    $.ajax({
        url: urlBase.make('generarplan/getSecuencia'),
        type: "get",
        async: false,
        data: {
            id_tienda: id_tienda,
            id_tipo: id_tipo
        },
        success: function (data) {
            response = data;
        }
    });
    return response;
}


function facturarRedirect(url2) {
    // PNotify.removeAll();
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    if (valueId != "") {
        var paso = table.$('tr.selected').children('td:nth-child(10)').text();
        var estado = table.$('tr.selected').children('td:nth-child(11)').text();
        var x = 1;
        var y = "";
        var es = "";
        var dateObj = new Date();
        var newdate = dateObj.toISOString().split('T')[0];
        $.ajax({
            url: urlBase.make('generarplan/validarFecha'),
            type: 'get',
            async: false,
            data: {
                id_tienda: valueId.split("/")[0],
                id_plan: valueId.split("/")[1],
            },
            success: function(data){
                y = data.fecha.id_tienda_cliente;
                es = data.estado;
                if(data.fecha.fecha_entrega != ""){
                    if (validate_fechaMayorQue(data.fecha_entrega, newdate)) x = 0;
                }
            }
        });
        if (((parseFloat(limpiarVal(paso)) == 0 && (estado == 'Facturar')) || (parseFloat(limpiarVal(paso)) == 0 && estado == 'Activo')) && x == 1 && es) {
            window.location = url2 + '/' + y + '/' + valueId.split("/")[1] + '/' + valueId.split("/")[0];
        } else {
            if(x == 0){
                Alerta('Error', 'Aun no se puede facturar ya que el producto no se ha terminado de fabricar.', 'error')
            }else if(!es){
                Alerta('Error', 'No se puede facturar por que tiene un reverso pendiente.', 'error')
            }else{
                if (estado == 'Facturado'){
                    Alerta('Error', 'El registro seleccionado ya se ha facturado', 'error')
                }else{
                    Alerta('Error', 'El registro seleccionado no se puede facturar ya que no se ha pagado completamente', 'error')
                }
            }
        }

    }else{
        Alerta('Error', 'Debe seleccionar un registro para poder continuar.', 'Error')
    }
}

function transferirRedirect(url2)
{   
    // PNotify.removeAll();
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    if (valueId != "") {
        var estado = table.$('tr.selected').children('td:nth-child(11)').text();
        if (estado == "Facturado" || estado == "Anulado")
        {
            if (estado == "Facturado") {
                Alerta('Error', 'El registro seleccionado no se puede transferir, ya ha sido facturado', 'error');
            }
            if (estado == "Anulado") {
                Alerta('Error', 'El registro seleccionado no se puede transferir, ya que esta anulado', 'error');
            }
        }else{
            window.location = url2 + '/' + valueId;
        }
    } else {
        Alerta('Error', 'Debe seleccionar un registro para poder continuar.', 'Error')
    }
}

function abonoRedirect(url2)
{
    // PNotify.removeAll();
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    if (valueId != "") {
        var paso = table.$('tr.selected').children('td:nth-child(10)').text();
        var estado = table.$('tr.selected').children('td:nth-child(11)').text();
        if (estado == "Cerrado" || estado == "Facturado" || estado == "Facturar" || estado == "Anulado")
        {
            if (estado == "Cerrado") {
                Alerta('Error', 'El registro seleccionado no se puede abonar, ya que se encuentra cerrado', 'error');
            }
            if (estado == "Facturado") {
                Alerta('Error', 'El registro seleccionado no se puede abonar, ya ha sido facturado', 'error');
            }
            if (estado == "Facturar") {
                Alerta('Error', 'El registro seleccionado no se puede abonar, ya que esta pendiente por facturar', 'error');
            }
            if (estado == "Anulado") {
                Alerta('Error', 'El registro seleccionado no se puede abonar, ya que esta anulado', 'error');
            }
        }else{
            window.location = url2 + '/' + valueId;
        }
    } else {
        Alerta('Error', 'Debe seleccionar un registro para poder continuar.', 'Error')
    }
}

function limpiarVal(val)
{
    var v = val.split('.');
    var valLimpiar = val.replace(/\./g, '');
    valLimpiar = valLimpiar.replace(',', '.', valLimpiar);
    valLimpiar = valLimpiar.trim(valLimpiar);
    return valLimpiar;
}

function valVolver(step, step2) {
    $('#step-' + step + 'Btn').hide();
    $('#step-' + step).hide();
    $('#step-' + step2).show();
    $('#step-' + step2 + 'Btn').show();
    $('#st' + step).removeClass('btn-primary');
    $('#st' + step).addClass('btn-default');
    $('#st' + step2).addClass('btn-primary');
}

function validate_fechaMayorQue(fechaInicial, fechaFinal) {
    valuesStart = fechaInicial.split("-");
    valuesEnd = fechaFinal.split("-");

    // var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
    // var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
    var dateStart = valuesStart[0] + valuesStart[1] + valuesStart[2];
    var dateEnd = valuesEnd[0] + valuesEnd[1] + valuesEnd[2];
    if (dateStart >= dateEnd) {
        return true;
    }
    return false;
}

function validateFormaPago(forma)
{
    var result;
    if ((($(`#${forma}`).val() != '' && $(`#${forma}`).val() != 0 && ($(`#${forma}`).val()).length > 0) && $(`#comprobante_${forma}`).val() == '')) {
        $(`#comprobante_${forma}`).addClass('alert-validate-required');
        $(`#comprobante_${forma}`).attr("placeholder", "Este campo es requerido");
        result = false;
    } else {
        $(`#comprobante_${forma}`).removeClass('alert-validate-required');
        $(`#comprobante_${forma}`).attr("placeholder", "");
        result = true;
    }

    if (forma == 'observaciones' && ($(`#otro`).val() != '' && $(`#otro`).val() != 0) && $(`#observaciones`).val() == '')
    {
        $(`#observaciones`).addClass('alert-validate-required');
        $(`#observaciones`).attr("placeholder", "Este campo es requerido");
        result = false;
    }
    // console.log(result);
    return result;
}

function validarAbonoCreate()
{
    var monto = parseFloat(limpiarVal($('#monto').val()));
    var abono = parseFloat(limpiarVal($('#abono').val()));
    var deuda = parseFloat(limpiarVal($('#deuda').val()));
    var abono_mayor = parseFloat(limpiarVal($('#abono_mayor').val()));
    var valor_transferido = __($('#saldo_transferido').val());
    if (valor_transferido != "") valor_transferido = limpiarVal($('#saldo_transferido').val());
    if (valor_transferido == "") valor_transferido = 0;

    // console.log(monto);
    // console.log(abono);
    // console.log(deuda);
    // console.log(abono_mayor);
    // console.log(valor_transferido);

    if (abono > monto) {
        // $('#abono').val(abono_mayor);
        $('#deuda').val(eval(monto - abono_mayor - valor_transferido));
        Alerta('Error', 'Abono no debe ser mayor al monto.', 'error');
    } else if (abono >= abono_mayor && abono <= monto) {
        deuda = eval(monto - abono - valor_transferido);
        $('#deuda').val(deuda);
    } else {
        // $('#abono').val(abono_mayor);
        deuda = eval(monto - abono_mayor - valor_transferido);
        $('#deuda').val(deuda);
        Alerta('Error', 'Abono no debe ser menor al abono inicial.', 'error');
    }
    $(".moneda").each(function () {
        $(this).val(money.replace($(this).val()));
    });
}
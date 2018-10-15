
// Variables para la definición de la tabla de los items
var data_table, results = [], row_num = 0, col_num = 8, row_cell = 1, col_cell = 0, iter = 0, detail_attribute_values = [], new_col_num = 0, col_new = '',
min_values = [], max_values = [],
cols = [
    { "mDataProp": "Field1", sTitle: " ", sType: "string", "orderable": false },
    { "mDataProp": "Field2", sTitle: "# Item", sType : "string"},
    { "mDataProp": "Field3", sTitle: "Categ", sType : "string"},
    { "mDataProp": "Field4" , sTitle: "Nombre", sType : "string"},
    { "mDataProp": "Field5" ,  sTitle: "Descripción", sType : "string"},
    { "mDataProp": "Field6" ,  sTitle: "Precio Sug", sType : "string"},
    { "mDataProp": "Field7", sTitle: "Precio Ing", sType: "string" },
    { "mDataProp": "Field8", sTitle: "Peso Total", sType: "string" },
    { "mDataProp": "Field9" ,  sTitle: "Peso Estim", sType : "string"},
];

var contrato = (function(){
    var atributos = {};
        atributos.cantItems = 0;

    var url = {}; 
        url.getCategory='';

    return {
        setCantItems:function(val){            
            atributos.cantItems=val;
        },
        getCantItems:function(){            
            return atributos.cantItems;
        },
        setUrlGetCategory:function(url2){            
            url.getCategory=url2;
        },
        getUrlGetCategory:function(){            
            return url.getCategory;
        },
        setUrlAttributeCategoryById:function(url2){           
            url.getAttributeCategoryById=url2;
        },
        getUrlAttributeCategoryById:function(){           
            return url.getAttributeCategoryById;
        },
        setUrlAttributeAttributesById:function(url2){           
            url.getAttributeAttributesById=url2;
        },
        getUrlAttributeAttributesById:function(){           
            return url.getAttributeAttributesById;
        },

        indicativoCliente: function () {
            fillInput('#ciudad_residencia', '.indicativo_cliente_telefono', urlBase.make('ciudad/getinputindicativo2'));
            fillInput('#ciudad_residencia', '.indicativo_cliente_celular', urlBase.make('ciudad/getinputindicativo'));
        },

        // Función para guardar los datos del cliente - Formulario Tab 1
        crearCliente:function(url, e){
            var complete = true;
            $('#step-1').find('.requerido').each(function(){
                if($(this).val() == "" || $(this).val() == null){
                    complete = false;
                    $(this).css('border', '1px solid rgba(255,0,0,0.7)');
                    $(this).css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
                }else{
                    $(this).css('border', '1px solid #ccc');
                    $(this).css('box-shadow', 'none');
                }
            });

            $('#step-1').find('.email_validado').each(function() {
                if($(this).val() != ''){
                    var flag = validarEmail($(this).val());
                    if (flag == false) {
                        $(this).css('border', '1px solid rgba(255,0,0,0.7)');
                        $(this).css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
                        $(this).focus();
                        $('#tool').remove();
                        $(this).after('<div style="clear: both;" class="tool tool-visible" id="tool"><p>Correo electrónico debe tener formato "ejemplo@ejemplo.com"</p></div>');
                        complete = false;
                    } else {
                        $('#tool').remove();
                        $(this).css('border', '1px solid #ccc');
                        $(this).css('box-shadow', 'none');
                    }
                }else{
                    $('#tool').remove();
                    $(this).css('border', '1px solid #ccc');
                    $(this).css('box-shadow', 'none');
                }
            
            });

            if(complete == true){
                var formData = new FormData(document.getElementById('form-cliente'));
                formData.append('dato','valor');
                e.preventDefault();
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: url,
                    type: "POST",
                    async: false,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data){
                        $('#idcliente').val(data);
                    }
                });
                if($('#idcliente').val() == '-3'){
                    pageAction.redirect( urlBase.make( 'creacioncontrato/verificacioncliente' ), 2 );
                    Alerta('Información', 'No se puede crear el cliente porque no se encontró una huella vigente', 'warning');
                }else if($('#idcliente').val() != '-1' ){
                    valVolver(1,2);
                }else{
                    Alerta('Información', 'No se puede crear el cliente porque no hay secuencias de tienda, por favor contacte al administrador', 'warning');
                }
            }else{
                e.preventDefault();
            }
        },

        // Función para actualizar los datos del cliente - Formulario Tab 1
        actualizarCliente:function(url, e){
            var complete = true;
            $('#step-1').find('.requerido').each(function(){
                if($(this).val() == "" || $(this).val() == null){
                    complete = false;
                    $(this).css('border', '1px solid rgba(255,0,0,0.7)');
                    $(this).css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
                }else{
                    $(this).css('border', '1px solid #ccc');
                    $(this).css('box-shadow', 'none');
                }
            });

            $('#step-1').find('.email_validado').each(function() {
                if($(this).val() != ""){
                    var flag = validarEmail($(this).val());
                    if (flag == false) {
                        $(this).css('border', '1px solid rgba(255,0,0,0.7)');
                        $(this).css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
                        $(this).focus();
                        $('#tool').remove();
                        $(this).after('<div style="clear: both;" class="tool tool-visible" id="tool"><p>Correo electrónico debe tener formato "ejemplo@ejemplo.com"</p></div>');
                        complete = false;
                    }else{
                        $('#tool').remove();
                        $(this).css('border', '1px solid #ccc');
                        $(this).css('box-shadow', 'none'); 
                    }
                } else {
                    $('#tool').remove();
                    $(this).css('border', '1px solid #ccc');
                    $(this).css('box-shadow', 'none');
                }
            
            });

            if(complete == true){
                var formData = new FormData(document.getElementById('form-cliente'));
                formData.append('dato','valor');
                e.preventDefault();
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: url,
                    type: "POST",
                    async: false,
                    data: formData,
                    processData: false,
                    contentType: false,
                });
                valVolver(1,2);
                if( $( '#cliente_confiable option:selected' ).data( 'contrato' ) == 'SI' && parseInt( $( '#suplantacion' ).val() ) == 0 )
                    valVolver(1,2);
                else{
                    Alerta( "Información", "El cliente no puede generar contrato, será redireccionado a la gestión de contratos en breve.", "warning" );
                    pageAction.redirect( urlBase.make( 'contrato/index' ), 2 );
                }
            }else{
                e.preventDefault();
            }
        },

        agregarItem:function(){
            var complete = true;
            var addItem = true;
            $('#step-3').find('.requerido-item').each(function(){
                if($(this).val() == "" || $(this).val() == null){
                    complete = false;
                    $(this).css('border', '1px solid rgba(255,0,0,0.7)');
                    $(this).css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
                }else{
                    $(this).css('border', '1px solid #ccc');
                    $(this).css('box-shadow', 'none');
                }
            });
            if(complete == true){
                if ($('#peso_estimado_item').hasClass('requerido-item')) {
                    if (parseFloat($('#precio_ingresado_item').val().replace('.', '')) >= (parseFloat($('#precio_ingresado_item').attr('min')) * parseFloat($('#peso_estimado_item').val().replace(',', '.'))) && parseFloat($('#precio_ingresado_item').val().replace('.', '')) <= (parseFloat($('#precio_ingresado_item').attr('max')) * parseFloat($('#peso_estimado_item').val().replace(',', '.')))){
                        addItem = true;
                    }else{
                        addItem = false;
                    }
                }else{
                    addItem = true;
                }

                if(addItem){
                    var t = $('#dataTableItems').DataTable();
                    this.setCantItems(this.getCantItems() + 1);
                    var columns = [];
                    $('.selects select[data-column="1"]').each(function(){
                        columns.push($(this).val());
                    })
                    t.row.add( 
                        [
                            this.getCantItems(),
                            $('#category').val(),
                            $('#nombre_item').val(),
                            $('#descripcion_item').val(),
                            $('#precio_sugerido_item').val(),
                            $('#precio_ingresado_item').val(),
                            $('#peso_estimado_item').val(),
                            $('#peso_total_item').val(),
                        ] 
                    ).draw( false );
                    $('#nombre_item').val('');
                    $('#descripcion_item').val('');
                    $('#precio_ingresado_item').val('');
                    $('#peso_estimado_item').val('');
                    $('#peso_total_item').val('');
                    $('.selects').html('');
                    $('#category').change();
                }else{
                    Alerta("Información", "El precio ingresado no es correcto", 'warning');
                }
            }
            this.totalesItems();
        },

        editarItem:function(){
            var selectedItem = false;
            var pos = parseInt($('tr.selected').find('td:nth-child(2)').text()) - 1;
            this.cargarValoresItem(pos);
            $('.selected').each(function(){
                selectedItem = true;
                if ($(this).find('td').hasClass('dataTables_empty')){
                    selectedItem = false;
                }
            });
            if (selectedItem){
                var t = $('#dataTableItems').DataTable();
                $('#edit_precio_ingresado_item').attr('min', min_values[pos]).attr('max', max_values[pos]);
                if ($('tr.selected').find('td:nth-child(1)').text() == 0) {
                    $('#edit_peso_estimado_item').attr('readonly', 'readonly');
                    $('#edit_peso_estimado_item').addClass('peso_igual');
                }else{
                    $('#edit_peso_estimado_item').removeAttr('readonly', 'readonly');
                    $('#edit_peso_estimado_item').removeClass('peso_igual');
                }

                $('#edit_nombre_item').val($('tr.selected').find('td:nth-child(' + (4 + new_col_num) + ')').text());
                $('#edit_descripcion_item').val($('tr.selected').find('td:nth-child(' + (5 + new_col_num) + ')').text());
                $('#edit_precio_sugerido_item').val($('tr.selected').find('td:nth-child(' + (6 + new_col_num) + ')').text().replace(/\./g, ''));
                $('#edit_precio_ingresado_item').val($('tr.selected').find('td:nth-child(' + (7 + new_col_num) + ')').text().replace(/\./g, ''));
                $('#edit_peso_total_item').val($('tr.selected').find('td:nth-child(' + (8 + new_col_num) + ')').text().replace(/\./g, ''));
                $('#edit_peso_estimado_item').val($('tr.selected').find('td:nth-child(' + (9 + new_col_num) + ')').text().replace(/\./g, ''));
                $('#edit_precio_sugerido_item').blur();
                $('#edit_precio_ingresado_item').blur();
                $('.modal-update').addClass('confirm-visible').removeClass('confirm-hide');
            }else{
                Alerta("Información", "Debe seleccionar un registro", "warning");
            }
        },

        cargarValoresItem:function(pos){
            $('.selects_actualizar').html('');
            $('#parentAttribute').find('option').remove();
            var valores_item = [];
            for (var i = 0; i < detail_attribute_values.length; i++) {
                if(detail_attribute_values[i][0] == pos + 1){
                    valores_item.splice(valores_item.length + 1, 0, detail_attribute_values[i][1]);
                }
            }
            $.ajax(
            {
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url : urlBase.make('creacioncontrato/getatributosvaloresitem'),
                type : 'GET',
                async : false,
                dataType : 'JSON',
                data : 
                {
                    valores_item : valores_item,
                },
                success: function (datos) {
                    $select = 0;
                    var selected = "";
                    jQuery.each(datos, function (indice, datos) {
                        var item_requerido = "";
                        var label_requerido = "";
                        var valor_defecto = "";
                        if(datos.item_obligatorio == 1){
                            label_requerido = "<span class='required red'>*</span>";
                            item_requerido = "requerido-item";
                        }

                        valor_defecto = (datos.valor_defecto == 1) ? "selected" : null;
                        var readonly = (datos.nombre_atributo.toUpperCase().trim() == "ORIGEN") ? "disabled" : null;
                        if(datos.set_valor == '1'){
                            selected = (datos.valor_seleccionado == 1) ? ' selected ' : '';
                            if($select == datos.id_atributo){
                                $('#slc-attr-' + datos.id_atributo).append
                                (
                                    '<option value="' + datos.id_valor + '" ' + selected + '>' + datos.nombre_valor + '</option>'
                                );
                            }else{
                                    

                                    if(datos.valor_desde_contrato == 0){
                                        $('.selects_actualizar').append
                                        (
                                            '<div class="nth-child-attribute-' + datos.id_atributo_padre + '" data-posicion="' + datos.orden_posicion + '" id="form-group-' + datos.id_atributo + '">'+
                                                '<div class="col-md-12 col-xs-12 bottom-20">'+
                                                    '<label>' + datos.nombre_atributo + ' ' + label_requerido + '</label>'+
                                                    '<select ' + readonly + ' id="slc-attr-' + datos.id_atributo + '" data-concat="' + datos.concatenar_nombre + '" data-atributo-edit="' + datos.nombre_atributo + '" onchange="loadAttributeAttributes(' + datos.id_atributo + ', this.value, \'' + urlBase.make('products/attributes/getAttributeAttributesById') + '\', \'selects_actualizar\');  contrato.pesoEstimadoActualizar();" class="form-control col-md-7 col-xs-12 ' + item_requerido + ' select-attr-item">'+
                                                        '<option value="0"> - Seleccione una opción - </option>'+
                                                        '<option value="' + datos.id_valor + '" ' + selected + '>' + datos.nombre_valor + '</option>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'
                                        );
                                    }else {
                                        if(selected != ''){
                                            $('.selects_actualizar').append
                                            (
                                                '<div class="nth-child-attribute-' + datos.id_atributo_padre + '" data-posicion="' + datos.orden_posicion + '" id="form-group-' + datos.id_atributo + '">'+
                                                    '<div class="col-md-12 col-xs-12 bottom-20">'+
                                                        `<label>${ datos.nombre_atributo } ${ label_requerido }</label>
                                                        <input data-idatributo="${ datos.id_atributo }" data-id-valor="${ datos.id_valor }" data-atributo-edit="${ datos.nombre_atributo }" value="${ datos.nombre_valor }" data-atributo="${ datos.nombre_atributo }" data-concat="${ datos.concatenar_nombre }" class="form-control input-text-value" type="text" id="valor_atributo_${ datos.id_atributo }" name="valor_atributo_${ datos.id_atributo }" onblur="hideList(${ datos.id_atributo }); selectValueAttr(this, ${ datos.id_atributo });" onkeyup="searchValues('${ datos.id_atributo }', this.value);">
                                                        <div class="content_buscador_${ datos.id_atributo }" style="display:none;">
                                                            <select name="select_valor_atributo_${ datos.id_atributo }" id="select_valor_atributo_${ datos.id_atributo }" size="4" class="form-control co-md-12" onclick="selectValueAttr(this, ${ datos.id_atributo });"></select>
                                                        </div>` +
                                                    '</div>'+
                                                '</div>'
                                            );
                                        }
                                        
                                    }
                            }
                            $select = (datos.valor_desde_contrato == 0) ? datos.id_atributo : 0;
                        }
                    });
                    $('.selects_actualizar select').change(function(){
                        $('#edit_nombre_item').val('');
                        $('.selects_actualizar select').each(function(){
                            if($(this).val() != 0 && $(this).val() != '' && $(this).data('concat') == '1'){
                                $('#edit_nombre_item').val($('#edit_nombre_item').val() + $(this).find('option:selected').text() + " ");
                            }
                        });
                        $('.selects_actualizar input').each(function(){
                            if($(this).val() != 0 && $(this).val() != '' && $(this).data('concat') == '1'){
                                $('#edit_nombre_item').val($('#edit_nombre_item').val() + $(this).val() + " ");
                            }
                        });

                        var cant = 0;
                        $('.selects_actualizar select option:selected[data-peso="1"]').each(function(){
                            cant++;
                        });
                        if(cant > 0){
                            $('#edit_peso_estimado_item').addClass('peso_igual');
                            $('#edit_peso_estimado_item').prop('readonly');
                            $('.peso_igual').val($('#edit_peso_total_item').val());
                        }else{
                            if($('#edit_peso_estimado_item').hasClass('requerido-item')){
                                $('#edit_peso_estimado_item').removeClass('peso_igual');
                                $('#edit_peso_estimado_item').removeAttr('readonly');
                            }
                        }

                        $('#edit_peso_total_item').keyup();
                    });
                },
                
            });
            $('#modal_rename_reference').show();
        },

        actualizarItem:function(){
            var addItem = true;
            var redondeo = redondeaAlAlza($('#edit_precio_ingresado_item').val().replace(/\./g, '').replace(/\,/g, '.'), 5000);
            var precio = $('#edit_precio_ingresado_item').val().replace(/\./g, '').replace(/\,/g, '.');
            if ($('#peso_estimado_item').hasClass('requerido-item')) {
                if (parseFloat($('#edit_precio_ingresado_item').val().replace('.', '').replace(/\,/g, '.')) >= (parseFloat($('#edit_precio_ingresado_item').attr('min')) * parseFloat($('#edit_peso_estimado_item').val().replace(',', '.'))) && parseFloat($('#edit_precio_ingresado_item').val().replace('.', '')) <= (parseFloat($('#edit_precio_ingresado_item').attr('max')) * parseFloat($('#edit_peso_estimado_item').val().replace(',', '.')))){
                    addItem = true;
                }else{
                    addItem = false;
                }
            }else{
                addItem = true;
            }

            if(addItem){
                if(precio == redondeo){
                    contrato.actualizarItemTrue();
                } else {
                    confirm.setTitle('Alerta');
                    confirm.setSegment('El precio ingresado será redondeado a ' + money.replace(redondeo.toString()) + ', ¿desea continuar guardando el item?');
                    confirm.show();
                    confirm.setFunction(function(){
                        $('#edit_precio_ingresado_item').val(money.replace(redondeo.toString()));
                        contrato.actualizarItemTrue();
                    });
                }
            } else {
                Alerta("Información", "El precio ingresado no es correcto", 'warning');
            }
        },

        actualizarItemTrue:function(){
            var pos = parseInt($('tr.selected').find('td:nth-child(2)').text()) - 1;
            $('tr.selected').find('td:nth-child(4)').text($('#edit_nombre_item').val());
            $('tr.selected').find('td:nth-child(5)').text($('#edit_descripcion_item').val());
            $('tr.selected').find('td:nth-child(6)').text($('#edit_precio_sugerido_item').val());
            $('tr.selected').find('td:nth-child(7)').text($('#edit_precio_ingresado_item').val());
            $('tr.selected').find('td:nth-child(8)').text($('#edit_peso_total_item').val());
            $('tr.selected').find('td:nth-child(9)').text($('#edit_peso_estimado_item').val());
            $('.modal-update').addClass('confirm-hide').removeClass('confirm-visible');
            results[pos].Field4 = $('#edit_nombre_item').val();
            results[pos].Field5 = $('#edit_descripcion_item').val();
            results[pos].Field6 = $('#edit_precio_sugerido_item').val();
            results[pos].Field7 = $('#edit_precio_ingresado_item').val();
            results[pos].Field8 = $('#edit_peso_total_item').val();
            results[pos].Field9 = $('#edit_peso_estimado_item').val();
            Alerta('Actualizado', 'Ítem actualizado correctamente.');

            var aoCols = data_table.fnSettings().aoColumns;
            var newRow = new Object();
            for(var iRec=0; iRec<aoCols.length; iRec++){
                if(iRec == 0)
                    ($('#peso_estimado_item').attr('readonly')) ? results[pos][aoCols[iRec].mDataProp] = 0 : results[pos][aoCols[iRec].mDataProp] = 1;
                else if(iRec == 2)
                    results[pos][aoCols[iRec].mDataProp] = $('*[data-col-item="' + iRec + '"] option:selected').text();
                else if(iRec == 1){}
                else if (iRec >= (7 + new_col_num) && iRec <= (8 + new_col_num)){}
                    // results[pos][aoCols[iRec].mDataProp] = (parseFloat($('*[data-col-item="' + (iRec - new_col_num) + '"]').val().replace(',', '.')).toFixed(2)).replace('.', ',');
                else if (iRec >= 3 + new_col_num){}
                    // results[pos][aoCols[iRec].mDataProp] = $('*[data-col-item="' + (iRec - new_col_num) + '"]').val();
                else{
                    // data-atributo
                    var textOption = $('.selects_actualizar select[data-atributo-edit="' + cols[iRec].sTitle + '"] option:selected').text();
                    textOption = (textOption == "" || textOption == null) ? $('.selects_actualizar input[data-atributo-edit="' + cols[iRec].sTitle + '"]').val() : textOption;
                    results[pos][aoCols[iRec].mDataProp] = (textOption != " - Seleccione una opción - " && textOption != "")?textOption:'N/A';
                }
            }

            for(var i = (detail_attribute_values.length - 1); i >= 0; i--){
                if(detail_attribute_values[i][0] == (pos + 1)){
                    detail_attribute_values.splice(i, 1);
                }
            }

            $( '.selects_actualizar select' ).each( function() {
                if( $(this).val() != '' ) {
                    detail_attribute_values.splice(detail_attribute_values.length + 1, 0, [ pos + 1, $(this).val() ]);
                }
            } );

            $( '.selects_actualizar input' ).each( function() {
                if( $(this).val() != '' ) {
                    detail_attribute_values.splice(detail_attribute_values.length + 1, 0, [ pos + 1, $(this).data('id-valor') ]);
                }
            } );

            min_values.splice(min_values.length + 1, 0, parseFloat($('#precio_ingresado_item').attr('min')));
            max_values.splice(max_values.length + 1, 0, parseFloat($('#precio_ingresado_item').attr('max')));

            data_table.fnDestroy();
            contrato.tablaItems().cargarTabla();
            contrato.tablaItems().addDBClikHandler();
        },

        removerItem:function(){
            var t = $('#dataTableItems').DataTable();
            confirm.setTitle('Alerta');
            confirm.setSegment('¿Eliminar el registro?');
            confirm.show();
            confirm.setFunction(function(){
                t.row('.selected').remove().draw( false );
            });
            this.totalesItems();
        },

        pesoEstimado:function(){
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: urlBase.make("creacioncontrato/pesoEstimado"),
                type: "GET",
                async: false,
                data: {
                    categoria: $('#category').val(),
                    tienda: $('#tienda_contrato').val(),
                    valores_atributos: $('#valores_atributos').val(),
                },
                success: function(data){
                    $('#precio_sugerido_item').val(data.valor_x_1);
                    $('#precio_sugerido_item').blur();
                    $('#precio_ingresado_item').attr('min', data.valor_minimo_x_1);
                    $('#precio_ingresado_item').attr('max', data.valor_maximo_x_1);
                }
            });
        },

        pesoEstimadoActualizar:function(){
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: urlBase.make("creacioncontrato/pesoEstimado"),
                type: "GET",
                async: false,
                data: {
                    categoria: $('#category').val(),
                    tienda: $('#tienda_contrato').val(),
                    valores_atributos: $('#valores_atributos').val(),
                },
                success: function(data){
                    $('#edit_precio_sugerido_item').val(data.valor_x_1);
                    $('#edit_precio_sugerido_item').blur();
                    $('#edit_precio_ingresado_item').attr('min', data.valor_minimo_x_1);
                    $('#edit_precio_ingresado_item').attr('max', data.valor_maximo_x_1);
                }
            });
        },

        validarPeso: function () {
            var ok = false;
            if ($('#peso_estimado_item').val() != "" && $('#peso_total_item').val() != "") {
                var peso_estimado_item = parseFloat($('#peso_estimado_item').val().replace(/\./g, '').replace(/\,/g, '.'));
                var peso_total_item = parseFloat($('#peso_total_item').val().replace(/\./g, '').replace(/\,/g, '.'));
                var ok = false;
                if ((peso_estimado_item) > (peso_total_item)){
                    PNotify.removeAll();
                    Alerta('Información', 'El peso total no puede ser menor al estimado, el peso estimado ha sido cambiado', 'warning');
                    ok = false;
                } else {
                    ok = true;
                }
            }else{
                ok = true;
            }
            return ok;
        },

        pesoIgual: function () {
            $('.peso_igual').val($('#peso_total_item').val());
            if ($('#peso_estimado_item').val() != "" && $('#peso_total_item').val() != "") {
                var peso_estimado_item = parseFloat($('#peso_estimado_item').val().replace(/\./g, '').replace(/\,/g, '.'));
                var precio_sugerido_item = parseFloat($('#precio_sugerido_item').val().replace(/\./g, '').replace(/\,/g, '.'));
                var peso_total_item = parseFloat($('#peso_total_item').val().replace(/\./g, '').replace(/\,/g, '.'));
                if ((peso_estimado_item) > (peso_total_item)) {
                    PNotify.removeAll();
                    Alerta('Información', 'El peso total no puede ser menor al estimado, el peso estimado ha sido cambiado', 'warning');
                }
            }
            $('#precio_ingresado_item').val(parseFloat(peso_estimado_item * precio_sugerido_item).toFixed(0));
            $('#precio_ingresado_item').blur();
        },

        validarPesoActualizar:function(){
            $('.peso_igual').val($('#edit_peso_total_item').val());
            if($('#edit_peso_estimado_item').val() != "" && $('#edit_peso_total_item').val() != ""){
                if(parseFloat($('#edit_peso_estimado_item').val()) >  parseFloat($('#edit_peso_total_item').val())){
                    $('#edit_peso_estimado_item').val($('#edit_peso_total_item').val());
                    PNotify.removeAll();
                    Alerta('Información', 'El peso total no puede ser menor al estimado, el peso estimado ha sido cambiado', 'warning');
                }
            }
            $('#edit_precio_ingresado_item').val(parseFloat($('#edit_peso_estimado_item').val().replace(/\./g, '').replace(/\,/g, '.')) * parseFloat($('#edit_precio_sugerido_item').val().replace(/\./g, '').replace(/\,/g, '.')));
            $('#edit_precio_ingresado_item').blur();
        },

        totalesItems:function(){
            var precio_ingresado = 0, peso_estimado = 0, peso_total = 0;
            $('#dataTableItems tbody tr').each(function(){
                precio_ingresado += parseFloat($(this).find('td:nth-child(6)').text().replace(/\./g, '').replace(',', '.'));
                peso_estimado += parseFloat($(this).find('td:nth-child(7)').text().replace(',', '.'));
                peso_total += parseFloat($(this).find('td:nth-child(8)').text().replace(',', '.'));
            });
            $('#total_precio_ingresado').text(precio_ingresado);
            $('#total_peso_estimado').text(peso_estimado);
            $('#total_peso_total').text(peso_total);
        },

        resumenContrato:function(){
            $('#res_tienda').text($('#tienda_contrato').find('option:selected').text());
            $('#res_codigo_empleado').text();
            $('#res_nombre_empleado').text();
            $('#res_nombre_cliente').text($('#primer_nombre').val() + " " + $('#segundo_nombre').val());
            $('#res_apellidos_cliente').text($('#primer_apellido').val() + " " + $('#segundo_apellido').val());
            $('#res_fecha_retroventa').text($('#fecha_terminacion').val());
            // $('#res_codigo_contrato').text($('#codigo_contrato').val());
            $('#res_categoria').text($('#category').find('option:selected').text());
            $('#res_numero_bolsa').text($('#numero_bolsa').val());
            $('#res_porcentaje_retroventa').text($('#porcentaje_retroventa').val());
            $('#res_termino').text($('#termino').val());
            var valor_contrato = parseFloat($('#total_precio_ingresado').text().replace(/\./g, '').replace(/\,/g, '.'));
            var porcentaje_retroventa = parseFloat($('#porcentaje_retroventa').val());
            var termino_contrato = parseFloat($('#termino').val());
            $('#res_retroventa').text('$ ' + money.replace((valor_contrato + (((valor_contrato * porcentaje_retroventa) / 100) * termino_contrato)).toString()));
            var cod_bolsas = "";
            var ultimo_cod_bolsa = parseInt($('#ultimo_cod_bolsa').val()) + 1;
            var bolsa_actual = 0;
            var bloq;
            while (bolsa_actual < parseInt($('#numero_bolsa').val())){
                bloq = false;
                $('.bolsas_bloq[value="' + ultimo_cod_bolsa + '"]').each(function(){
                    bloq = true;
                });
                if(bloq == false){
                    if ((bolsa_actual + 1) == $('#numero_bolsa').val())
                        cod_bolsas += ultimo_cod_bolsa;
                    else
                        cod_bolsas += ultimo_cod_bolsa + ", ";
                    
                    ++bolsa_actual;
                }
                ++ultimo_cod_bolsa;
            }
            $('#res_cod_bolsas').text(cod_bolsas);
            $('#table_items').html($('.content_tabla_items').html());
        },

        guardarContrato:function(){
            $("#btn-terminar-contrato").attr('disabled', 'disabled');
            cant_items = 0;
            $('#table_items tbody tr').each(function(){
                if($(this).find('td').hasClass('dataTables_empty'))
                    cant_items = 0;
                else
                    cant_items++;
            });

            if(cant_items >= 0){
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: urlBase.make("creacioncontrato/guardarcontrato"),
                    type: "POST",
                    async: false,
                    data: {
                        id_tienda_contrato: $('#tienda_contrato').val(),
                        id_tienda_cliente: $('#idtienda').val(),
                        codigo_cliente: $('#idcliente').val(),
                        id_categoria_general: $('#category').val(),
                        porcentaje_retroventa: $('#porcentaje_retroventa').val(),
                        termino: $('#termino').val(),
                        dias_gracia: $('#dias_gracia').val(),
                        fecha_creacion: $('#fecha_creacion').val(),
                        fecha_terminacion: $('#fecha_terminacion').val(),
                        numero_bolsa: $('#numero_bolsa').val(),
                        codigos_bolsas: $('#res_cod_bolsas').text(),
                        id_tipo_documento_tercero: $('#tipodocumentotercero').val(),
                        numero_documento_tercero:  $('#numero_documeto_tercero').val(),
                        nombres_tercero:  $('#nombres_tercero').val(),
                        apellidos_tercero:  $('#apellidos_tercero').val(),
                        telefono_tercero:  $('#telefono_tercero').val(),
                        celular_tercero: $('#celular_tercero').val(),
                        correo_tercero:  $('#correo_tercero').val(),
                        direccion_tercero:  $('#direccion_tercero').val(),
                        parentesco_tercero:  $('#parentesco_tercero').val(),
                        informacion_tercero: $('#autorizar_tercero').val(),
                        detail_attribute_values: detail_attribute_values,
                        valor_contrato: parseFloat($('#total_precio_ingresado').text().replace(/\./g, '').replace(/\,/g, '.')),
                    },
                    success:function(datos) {
                        $('#codigo_contrato').val(datos);
                    }
                });

                if(parseInt($('#codigo_contrato').val()) > 0){
                    var items = {};
                    var detalles = {};
                    var posicion = 0;
                    $('#table_items tbody tr').each(function(){
                        var item = ({
                            id_tienda : $('#tienda_contrato').val(),
                            id_codigo_contrato : $('#codigo_contrato').val(),
                            id_linea_item_contrato : $(this).find('td:nth-child(2)').text(),
                            nombre: $(this).find('td:nth-child(' + (4 + new_col_num) + ')').text(),
                            observaciones: $(this).find('td:nth-child(' + (5 + new_col_num) + ')').text(),
                            precio_sugerido: $(this).find('td:nth-child(' + (6 + new_col_num) + ')').text().replace(/\./g, '').replace(/\,/g, '.'),
                            precio_ingresado: $(this).find('td:nth-child(' + (7 + new_col_num) + ')').text().replace(/\./g, '').replace(/\,/g, '.'),
                            peso_estimado: $(this).find('td:nth-child(' + (9 + new_col_num) + ')').text().replace(/\./g, '').replace(/\,/g, '.'),
                            peso_total: $(this).find('td:nth-child(' + (8 + new_col_num) + ')').text().replace(/\./g, '').replace(/\,/g, '.'),
                        });

                        var detalle = ({
                            id_tienda : $('#tienda_contrato').val(),
                            codigo_contrato : $('#codigo_contrato').val(),
                            id_linea_item_contrato : $(this).find('td:nth-child(2)').text(),
                        });

                        items[posicion] = item;
                        detalles[posicion] = detalle;
                        posicion++;
                    });
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: urlBase.make("creacioncontrato/guardaritem"),
                        type: "POST",
                        async: false,
                        data: {
                            items: items,
                            detalles: detalles,
                        },
                    });

                    myWindow = window.open(urlBase.make(`creacioncontrato/pdfcompraventacontrato/${ $('#codigo_contrato').val() }/${ $('#tienda_contrato').val() }`), "myWindow", "width=200, height=100");
                    myWindow.resizeTo(screen.availWidth, screen.availHeight);
                    myWindow.print();

                    $('#contrato_pdf').val($('#codigo_contrato').val());
                    $('#tienda_pdf').val($('#tienda_contrato').val());
                    Alerta("Información", "Contrato terminado correctamente, será redireccionado en breve", 'success');
                    pageAction.redirect(urlBase.make('contrato/index'), 10);
                    // $('#form_pdf_contrato').submit();
                }else{
                    Alerta("Información", "No se pudo crear el contrato por falta de secuencias para la tienda, comuníquese con un administrador", 'warning');
                    $("#btn-terminar-contrato").removeAttr('disabled', 'disabled');
                }
            }else{
                Alerta("Información", "No puede terminar el contrato sin agregar Ítemes", 'warning');
                $("#btn-terminar-contrato").removeAttr('disabled', 'disabled');
            }
        },

        validarItems:function(){
            var cont = 0;
            $('#dataTableItems tbody tr').each(function(){
                if($(this).find('td').hasClass('dataTables_empty'))
                    cont = 0;
                else
                    cont++;
            });
            if(cont > 0){
                var t = $('#dataTableItems').DataTable();
                confirm.setTitle('Alerta');
                confirm.setSegment('Ya se han agregado ítems, si cambia de categoría se perderan, ¿desea continuar?');
                confirm.show();
                confirm.setFunction(function(){
                    results = [];
                    contrato.tablaItems().resetearIndexItems();
                    data_table.fnDestroy();
                    contrato.tablaItems().cargarTabla();
                    contrato.tablaItems().addDBClikHandler();
                });
                $('#category').prop('disabled', 'disabled');
            }else{
                $('#category').removeAttr('disabled');
            }
        },
        
        contratoExtraviado:function(){
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: urlBase.make('contrato/extraviado'),
                type: 'POST',
                async: false,
                data: {
                    codigo_contrato: $('#codigo_contrato').val(),
                    tienda_contrato: $('#tienda_contrato').val(),
                    valor_extraviado: $('#contrato_extraviado').val(),
                },
                success:function(datos){
                    if(datos == true){
                        Alerta('Información', 'Contrato actualizado correctamente.', 'success');
                    }else{
                        Alerta('Error', 'No se pudo actualizar el contrato.', 'error');
                    }
                }
            })
        },

        bolsaCategoria:function(){
            if($('#category').val() != ""){
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: urlBase.make("creacioncontrato/validarBolsaPeso"),
                    type: "GET",
                    async: false,
                    data: {
                        categoria: $('#category').val()
                    },
                    success: function(data){
                        $('#unidad_medida').text(data[0]["unidad_medida"]);
                        if(data[0]["aplica_bolsa"] == 1){
                            $('#codigos_bolsas').removeClass('hide');
                            $('#campo_aplica_bolsa').removeClass('hide');
                            $('#numero_bolsa').addClass('requerido');
                        }else{
                            $('#codigos_bolsas').addClass('hide');
                            $('#campo_aplica_bolsa').addClass('hide');
                            $('#numero_bolsa').removeClass('requerido');
                            $('#numero_bolsa').val('0');
                        }
                        
                        if(data[0]["control_peso_contrato"] == 1){
                            $('.control_peso_contrato input').removeAttr('readonly', 'readonly');
                            $('.control_peso_contrato input').addClass('requerido-item');
                            $('.control_peso_contrato input').val('');
                            $('.control_peso_contrato_edit input').removeAttr('readonly', 'readonly');
                        }else{
                            $('.control_peso_contrato input').attr('readonly', 'readonly');
                            $('.control_peso_contrato input').removeClass('requerido-item');
                            $('.control_peso_contrato input').val('0');
                            $('.control_peso_contrato_edit input').attr('readonly', 'readonly');
                        }
                    }
                });
            }
        },

        validarDatosCategoria:function() {
            if ( $( '.selects' ).html() == '' ) {
                $('.btn-guardar-contrato').attr('disabled', 'disabled');
                Alerta("Alerta", "No puede continuar porque no hay configuración de items para contrato para la categoría " + $('#category option:selected').text(), 'warning');
            } else if( $('#porcentaje_retroventa').val() == "" || $('#termino').val() == "" || $('#porcentaje_retroventa').val() == 0 || $('#termino').val() == 0 ) {
                $('.btn-guardar-contrato').attr('disabled', 'disabled');
                Alerta("Alerta", "No puede continuar porque no hay configuración de retroventa para la categoría " + $('#category option:selected').text(), 'warning');
            } else {
                $('.btn-guardar-contrato').removeAttr('disabled', 'disabled');
            }
        },

        // Función para validar campos requeridos en los formularios y permitir navegar entre tabs
        validarRequeridos:function(formulario, tab){
            var complete = true;
            $(formulario + ' .requerido').each(function(){
                if($(this).val() == "" || $(this).val() == null){
                    complete = false;
                    $(this).css('border', '1px solid rgba(255,0,0,0.7)');
                    $(this).css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
                }else{
                    $(this).css('border', '1px solid #ccc');
                    $(this).css('box-shadow', 'none');
                }
            });

            $(formulario + ' .email_validado').each(function() {
                if($(this).val() != ""){
                    var flag = validarEmail($(this).val());
                    if (flag == false  && $(this).val() != "") {
                        $(this).css('border', '1px solid rgba(255,0,0,0.7)');
                        $(this).css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
                        $(this).focus();
                        $('#tool').remove();
                        $(this).after('<div style="clear: both;" class="tool tool-visible" id="tool"><p>Correo electrónico debe tener formato "ejemplo@ejemplo.com"</p></div>');
                        complete = false;
                    }else{
                        $('#tool').remove();
                        $(this).css('border', '1px solid #ccc');
                        $(this).css('box-shadow', 'none'); 
                    }
                }
            
            });

            if(tab == 2 && !$('#campo_aplica_bolsa').hasClass('hide') && $('#numero_bolsa').val() == 0){
                complete = false;
                $('#numero_bolsa').css('border', '1px solid rgba(255,0,0,0.7)').css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
                PNotify.removeAll();
                Alerta("Información", "El número de bolsas debe ser mayor a 0", 'warning');
            }

            if(complete)
                valVolver(tab, ++tab);
        },

        tablaItems:function(){
            return {
                cargarTabla:function(){
                    //Construct the measurement table
                    $('#dataTableItems').html('');
                    data_table = $('#dataTableItems').dataTable({
                        "aoColumns": cols,
                        "aaData": results,
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "order": [[1, "asc"]],
                        language: {
                            url: urlBase.make('plugins/datatable/DataTables-1.10.13/json/spanish.json')
                        },
                        "fnDrawCallback": function (oSettings) {
                            $('#dataTableItems tbody td').text(function () { $(this).text($(this).text().replace(/\s/g, " ")) });
                            $(window).resize();
                        },
                    });
                    this.attachTableClickEventHandlers();
                    this.cargarTotales();
                    getTerminoRetroventa(urlBase.make('creacioncontrato/getterminoretroventa'));
                },

                cargarTotales:function(){
                    var total_precio_ingresado = 0, total_peso_estimado = 0, total_peso_total = 0;
                    for (var i = 0; i < results.length; i++) {                        
                        total_precio_ingresado += parseFloat(results[i].Field7.replace(/\./g, '').replace(',', '.'));
                        total_peso_estimado += parseFloat(results[i].Field8.replace(/\./g, '').replace(',', '.'));
                        total_peso_total += parseFloat(results[i].Field9.replace(/\./g, '').replace(',', '.'));
                    }

                    $('#dataTableItems').append(
                        `<tfoot>
                            <tr>
                                <td class="dataTables_empty"></td>
                                <td class="dataTables_empty"></td>
                                <td class="dataTables_empty"></td>
                                <td class="dataTables_empty"></td>
                                <td class="dataTables_empty"></td>
                                ${col_new}
                                <td style="text-align: right !important; padding-right: 10px !important;" class="dataTables_empty">Totales</td>
                                <td style="text-align: right !important; padding-right: 10px !important;" class="dataTables_empty" id="total_precio_ingresado">` + money.replace(total_precio_ingresado.toString()) + `</td>
                                <td style="text-align: right !important; padding-right: 10px !important;" class="dataTables_empty" id="total_peso_estimado">` + (parseFloat(total_peso_estimado).toFixed(2)).toString().replace('.', ',') + `</td>
                                <td style="text-align: right !important; padding-right: 10px !important;" class="dataTables_empty" id="total_peso_total">` + (parseFloat(total_peso_total).toFixed(2)).toString().replace('.', ',') + `</td>
                            </tr>
                        </tfoot>`
                    );
                },

                attachTableClickEventHandlers:function(){
                    //row/column indexing is zero based
                    $("#dataTableItems thead tr th").click(function() {     
                        col_num = parseInt( $(this).index() );
                    });
                    $("#dataTableItems tbody tr td").click(function() {     
                        col_cell = parseInt( $(this).index() );
                        row_cell = parseInt( $(this).parent().index() );    
                    });  
                },

                agregarItem:function(){
                    if( $('#peso_total_item').val() == '' ) $('#peso_total_item').val(0);
                    if( $('#peso_estimado_item').val() == '' ) $('#peso_estimado_item').val(0);
                    if (contrato.validarPeso() ) {
                        var complete = true;
                        var addItem = true;
                        $('#step-3').find('.requerido-item').each(function(){
                            if($(this).val() == "" || $(this).val() == null){
                                complete = false;
                                $(this).css('border', '1px solid rgba(255,0,0,0.7)');
                                $(this).css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
                            }else{
                                $(this).css('border', '1px solid #ccc');
                                $(this).css('box-shadow', 'none');
                            }
                        });
                        if(complete == true){
                            if($('#peso_estimado_item').hasClass('requerido-item')){
                                var precio_ingresado = $('#precio_ingresado_item').val().replace(/\./g, '');
                                if (parseFloat(precio_ingresado) >= (parseFloat($('#precio_ingresado_item').attr('min')) * parseFloat($('#peso_estimado_item').val().replace(/\./g, '').replace(',', '.'))) && parseFloat(precio_ingresado) <= (parseFloat($('#precio_ingresado_item').attr('max')) * parseFloat($('#peso_estimado_item').val().replace(/\./g, '').replace(',', '.')))){
                                    addItem = true;
                                }else{
                                    addItem = false;
                                }
                            }else{
                                addItem = true;
                            }
            
                            if(addItem){
                                //adding/removing row from datatable datasource
                                //create test new record
                                var redondeo = redondeaAlAlza($('#precio_ingresado_item').val().replace(/\./g, '').replace(/\,/g, '.'), 5000);
                                var precio = $('#precio_ingresado_item').val().replace(/\./g, '').replace(/\,/g, '.');
                                if(precio == redondeo){

                                    contrato.tablaItems().saveItem();
                                    
                                }else{
                                    confirm.setTitle('Alerta');
                                    confirm.setSegment('El precio ingresado será redondeado a ' + money.replace(redondeo.toString()) + ', ¿desea continuar guardando el item?');
                                    confirm.show();
                                    confirm.setFunction(function(){
                                        $('#precio_ingresado_item').val(money.replace(redondeo.toString()));
                                        contrato.tablaItems().saveItem();
                                    });
                                }
                            }else{
                                Alerta("Información", "El precio ingresado no es correcto", 'warning');
                            }
                        }
                    }
                },

                saveItem:function(){

                    contrato.tablaItems().saveNewValues();

                    var aoCols = data_table.fnSettings().aoColumns;
                    var newRow = new Object();
                    for(var iRec=0; iRec<aoCols.length; iRec++){
                        if(iRec == 0)
                            ($('#peso_estimado_item').attr('readonly')) ? newRow[aoCols[iRec].mDataProp] = 0 : newRow[aoCols[iRec].mDataProp] = 1;
                        else if(iRec == 1)
                            newRow[aoCols[iRec].mDataProp] = ( results.length + 1 );
                        else if(iRec == 2)
                            newRow[aoCols[iRec].mDataProp] = $('*[data-col-item="' + iRec + '"] option:selected').text();
                        else if (iRec >= (7 + new_col_num) && iRec <= (8 + new_col_num))
                            newRow[aoCols[iRec].mDataProp] = (parseFloat($('*[data-col-item="' + (iRec - new_col_num) + '"]').val().replace(',', '.')).toFixed(2)).replace('.', ',');
                        else if (iRec >= 3 + new_col_num)
                            newRow[aoCols[iRec].mDataProp] = $('*[data-col-item="' + (iRec - new_col_num) + '"]').val();
                        else{
                            // data-atributo
                            var textOption = $('.selects select[data-atributo="' + cols[iRec].sTitle + '"] option:selected').text();
                            textOption = (textOption == "" || textOption == null) ? $('.selects input[data-atributo="' + cols[iRec].sTitle + '"]').val() : textOption;
                            newRow[aoCols[iRec].mDataProp] = (textOption != " - Seleccione una opción - " && textOption != "")?textOption:'N/A';
                        }
                    }    
                    
                    results.splice(results.length+1, 0, newRow);

                    $( '.selects select' ).each( function() {
                        if( $(this).val() != '' ) {
                            detail_attribute_values.splice(detail_attribute_values.length + 1, 0, [ results.length, $(this).val() ]);
                        }
                    } );

                    $( '.selects input' ).each( function() {
                        if( $(this).val() != '' ) {
                            detail_attribute_values.splice(detail_attribute_values.length + 1, 0, [ results.length, $(this).data('id-valor') ]);
                        }
                    } );

                    min_values.splice(min_values.length + 1, 0, parseFloat($('#precio_ingresado_item').attr('min')));
                    max_values.splice(max_values.length + 1, 0, parseFloat($('#precio_ingresado_item').attr('max')));

                    data_table.fnDestroy();
                    this.cargarTabla();
                    this.addDBClikHandler();
                    $('#nombre_item').val('');
                    $('#descripcion_item').val('');
                    $('#precio_ingresado_item').val('');
                    $('#peso_estimado_item').val('');
                    $('#peso_total_item').val('');
                    $('.selects').html('');
                    loadFirstAttributes($("#category"), contrato.getUrlAttributeCategoryById());
                },

                saveNewValues:function(){
                    var id_val_attr = 0;
                    var exist = false;
                    $('.input-text-value').each(function(){
                        $(this).siblings('div').find(`select option[data-text="${ $(this).val() }"]`).each(function(){
                            exist = true;
                            id_val_attr = $(this).val();
                        });
                        id_val_attr = (id_val_attr != undefined && id_val_attr != null && id_val_attr != "") ? id_val_attr : null;
                        $(this).data('id-valor', id_val_attr);

                        if($(this).data('id-valor') == null){
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                url: urlBase.make('contrato/products/attributevalues/store'),
                                type: 'POST',
                                async: false,
                                data: {
                                    id_atributo: $(this).data('idatributo'),
                                    nombre: $(this).val(),
                                },
                                success:function(datos){
                                    $(this).data('id-valor', datos);
                                }
                            });
                        }
                    });
                },

                removerItem:function(){
                    var t = $('#dataTableItems').DataTable();
                    confirm.setTitle('Alerta');
                    confirm.setSegment('¿Eliminar el registro?');
                    confirm.show();
                    confirm.setFunction(function(){
                        var pos = ( parseInt( $( '#dataTableItems tr.selected td:nth-child(1)' ).text() ) - 1 );
                        results.splice( pos, 1 );
                        detail_attribute_values.splice( pos, 1 );
                        min_values.splice( pos, 1 );
                        max_values.splice( pos, 1 );
                        contrato.tablaItems().resetearIndexItems();
                        data_table.fnDestroy();
                        contrato.tablaItems().cargarTabla();
                        contrato.tablaItems().addDBClikHandler();
                    });
                    // this.totalesItems();
                },

                agregarColumnas:function (){
                    this.resetearColumnas();
                    new_col_num = 0;
                    col_new = '';
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: urlBase.make('products/attributes/getAttributeColumnByCategory'),
                        type: "GET",
                        async: false,
                        data: {
                            id_categoria: $('#category').val(),
                        },
                        success: function(datos) {
                            jQuery.each(datos, function (indice, datos) {
                                cols.splice(col_num-5, 0, {"mDataProp": "newField"+iter, sTitle: datos.nombre, sType : "string"});
                                for(var iRes=0; iRes<results.length ;iRes++){
                                    results[iRes]["newField"+iter] = 0;
                                }
                                data_table.fnDestroy();
                                $("#dataTableItems thead tr th").eq(col_num).after('<th>'+datos.nombre+'</th>');
                                iter++;
                                new_col_num++;
                                col_new += '<td class="dataTables_empty"></td>';
                            });
                        }
                    });
                    data_table.fnDestroy();
                    this.cargarTabla();
                    this.addDBClikHandler();
                },

                resetearColumnas:function(){
                    col_num=8; iter=0;
                    cols = [
                        { "mDataProp": "Field1", sTitle: " ", sType: "string", "orderable": false },
                        { "mDataProp": "Field2", sTitle: "# Item", sType: "string"},
                        { "mDataProp": "Field3", sTitle: "Categ", sType: "string"},
                        { "mDataProp": "Field4", sTitle: "Nombre", sType: "string"},
                        { "mDataProp": "Field5", sTitle: "Descripción", sType: "string"},
                        { "mDataProp": "Field6", sTitle: "Precio Sug", sType: "string"},
                        { "mDataProp": "Field7", sTitle: "Precio Ing", sType: "string" },
                        { "mDataProp": "Field8", sTitle: "Peso Total", sType: "string" },
                        { "mDataProp": "Field9", sTitle: "Peso Estim", sType: "string"},
                    ];
                },

                resetearIndexItems:function(){
                    for (var i = 0; i < results.length; i++) {
                        results[ i ].Field2 = i + 1;
                    }
                },

                addDBClikHandler:function(){
                    $('#dataTableItems tbody tr').on('dblclick', function (e) {
                        e.preventDefault();
                        var nRow = $(this)[0];
                        var jqTds = $('>td', nRow);
                        if($.trim(jqTds[0].innerHTML.substr(0,6)) != '<input'){
                            if ( nEditing !== null && nEditing != nRow ) {
                                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                                restoreRow( oTable, nEditing );
                                nEditing = nRow;
                                editRow( oTable, nRow );
                            }
                            else {
                                /* No edit in progress - let's start one */
                                nEditing = nRow;
                                editRow( oTable, nRow );
                            }
                        }                    
                    } );
                    
                    $('#dataTableItems tbody tr').keydown(function(event){
                        if(event.keyCode==13){
                            event.preventDefault();
                            if(nEditing==null)
                                alert("Select Row");
                            else
                                saveRow( oTable, nEditing );
                                nEditing = null;
                        }
                        /* Editing this row and want to save it */
                    });
                }
            }
        },

        indicativoPais:function(){
            fillInput('#ciudadtercero', '#telefono_tercero_indicativo', urlBase.make('ciudad/getinputindicativo2'));
            fillInput('#ciudadtercero', '#celular_tercero_indicativo', urlBase.make('ciudad/getinputindicativo'));
        },

        telefonosTercero:function(){
            if($('#autorizar_tercero').val()== '1'){
                if($('#telefono_tercero').val () != "" || $('#celular_tercero').val () != ""){
                    $('#telefono_tercero').removeClass('requerido');
                    $('#celular_tercero').removeClass('requerido');
                    $('#telefono_tercero').removeClass('requerido_tercero');
                    $('#celular_tercero').removeClass('requerido_tercero');
                    $('#telefono_tercero').css('border', '1px solid #ccc').css('box-shadow', 'none');
                    $('#celular_tercero').css('border', '1px solid #ccc').css('box-shadow', 'none');
                }else{
                    $('#telefono_tercero').addClass('requerido');
                    $('#celular_tercero').addClass('requerido');
                    $('#telefono_tercero').addClass('requerido_tercero');
                    $('#celular_tercero').addClass('requerido_tercero');
                }
            }
        }
    }
})();

function autorizarTercero()
{
    if($('#autorizar_tercero').val()== '1'){
        $('.pnl_autorizar_tercero').css('display', 'block');
        $('.requerido_tercero').addClass('requerido');
        $('#correo_tercero').addClass('email_validado');
    }else{
        $('.pnl_autorizar_tercero').css('display', 'none');
        $('.pnl_autorizar_tercero input, .pnl_autorizar_tercero select').removeClass('requerido');
        $('#correo_tercero').removeClass('email_validado');
    }
}

function getTerminoRetroventa(url)
{
    if($('#tienda_contrato').val() != "" && $('#category').val() != ""){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: url,
            type: "GET",
            async: false,
            data: {
                id_tienda_contrato: $('#tienda_contrato').val(),
                id_categoria_general: $('#category').val(),
                monto: $('#total_precio_ingresado').text().replace(/\./g, '').replace(/\,/g, '.'),
            },
            success: function(datos) {
                var porcentaje_retroventa = 0,
                    termino = 0,
                    dias_gracia = 0;
                jQuery.each(datos, function (indice, datos) {
                    porcentaje_retroventa = datos.porcentaje_retroventa;
                    termino = datos.termino_contrato;
                    dias_gracia = datos.dias_gracia;
                });
                $('#porcentaje_retroventa').val(porcentaje_retroventa);
                $('#termino').val(termino);
                $('#dias_gracia').val(dias_gracia);
                $('#porcentaje_retroventa').change();
                $('#termino').change();
            }
        });
    }
}

function calcularTerminacion()
{
    var termino = parseInt($('#termino').val());
    var fecha_actual = $('#fecha_creacion').val();
    var array_fecha = fecha_actual.split("-");
    var anho = parseInt(array_fecha[0]);
    var mes = parseInt(array_fecha[1]);
    var dia = array_fecha[2];
    if((mes + termino) > 24){
        mes = termino - (24 - mes);
        anho = anho + 2;
    }else if((mes + termino) > 12){
        mes = termino - (12 - mes);
        anho = anho + 1;
    }else{
        mes = mes + termino;
    }
    if(mes < 10){
        $('#fecha_terminacion').val(anho + '-0' + mes + '-' + dia);
    }else{
        $('#fecha_terminacion').val(anho + '-' + mes + '-' + dia);
    }
}



$('#g3').click(function()
{
    valVolver(3,4);
});

function valVolver(step,step2)
{
    $('#step-'+step+'Btn').hide();
    $('#step-'+step).hide();
    $('#step-'+step2).show();
    $('#step-'+step2+'Btn').show();
    $('#st'+step).removeClass('btn-primary');
    $('#st'+step).addClass('btn-default');
    $('#st'+step2).addClass('btn-primary');
    $( "html" ).scrollTop( 0 );
}


function runAttributeForm()
{
    loadSelectInput("#category",contrato.getUrlGetCategory(),2);    
}

var listado_atributos = [
    { lAtributo : 2 }
];
function ordenarAtributos() {
    var attrList = [];
    $( '.selects .row' ).each( function() {
        attrList[ $( this ).data( 'posicion' ) ] = $( this );
    } );

    for ( var i = 0; i < attrList.length; i++ ){
        $( '.selects' ).append( attrList[ i ] );
    }
}

function loadFirstAttributes(element, url2)
{
    $('.selects').html('');
    $('.type-text, #step-3 input[type="number"], textarea').val('');
    $('#parentAttribute').find('option').remove();
    var id = $(element).val();
    $.ajax(
    {
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
        url : url2,
        type : 'GET',
        async : false,
        dataType : 'JSON',
        data : 
        {
            id : id
        },
        success: function (datos) {
            $select = 0;
            jQuery.each(datos, function (indice, datos) {
                var item_requerido = "";
                var label_requerido = "";
                var valor_defecto = "";
                if(datos.item_obligatorio == 1){
                    label_requerido = "<span class='required red'>*</span>";
                    item_requerido = "requerido-item";
                }

                valor_defecto = (datos.valor_defecto == 1) ? "selected" : null;
                var readonly = (datos.nombreatributo.toUpperCase().trim() == "ORIGEN") ? "disabled" : null;

                if($select == datos.idatributo){
                    $('#slc-attr-' + datos.idatributo).append
                    (
                        '<option ' + valor_defecto + ' data-peso="' + datos.peso_igual_contrato + '" value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'
                    );
                }else{
                    

                    if(datos.valor_desde_contrato == 0){
                        $('.selects').append
                        (
                            '<div class="row" data-posicion="' + datos.orden_posicion + '">'+
                                '<div class="col-md-offset-1 col-md-10 col-xs-12 bottom-20">'+
                                    '<label>' + datos.nombreatributo + ' ' + label_requerido + '</label>'+
                                    '<select ' + readonly + ' id="slc-attr-' + datos.idatributo + '" data-concat="' + datos.concatenar_nombre + '" data-column="' + datos.columna_independiente_contrato + '" data-atributo="' + datos.nombreatributo + '" onchange="loadAttributeAttributes(' + datos.idatributo + ', this.value, \'' + contrato.getUrlAttributeAttributesById() + '\'); contrato.pesoEstimado();" class="form-control col-md-7 col-xs-12 ' + item_requerido + ' select-attr-item">'+
                                        '<option value> - Seleccione una opción - </option>'+
                                        '<option ' + valor_defecto + ' data-peso="' + datos.peso_igual_contrato + '" value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'+
                                    '</select>'+
                                '</div>'+
                            '</div>'
                        );
                    }else {
                        $('.selects').append
                        (
                            `<div class="row" data-posicion="${ datos.orden_posicion }">
                                <div class="col-md-offset-1 col-md-10 col-xs-12 bottom-20">
                                    <label>${ datos.nombreatributo } ${ label_requerido }</label>
                                    <input data-idatributo="${ datos.idatributo }"  data-atributo="${ datos.nombreatributo }" data-concat="${ datos.concatenar_nombre }" class="form-control input-text-value" type="text" id="valor_atributo_${ datos.idatributo }" name="valor_atributo_${ datos.idatributo }" onblur="hideList(${ datos.idatributo }); selectValueAttr(this, ${ datos.idatributo });" onkeyup="searchValues('${ datos.idatributo }', this.value);">
                                    <div class="content_buscador_${ datos.idatributo }" style="display:none;">
                                        <select name="select_valor_atributo_${ datos.idatributo }" id="select_valor_atributo_${ datos.idatributo }" size="4" class="form-control co-md-12" onclick="selectValueAttr(this, ${ datos.idatributo });"></select>
                                    </div>
                                </div>
                            </div>`
                        );
                        
                    }
                }
                $select = datos.idatributo;
            });

            $('.selects select').change(function(){
                // contrato.columnasAtributos();
                $('#nombre_item').val('');
                $('.selects select').each(function(){
                    if($(this).val() != 0 && $(this).val() != '' && $(this).data('concat') == '1'){
                        $('#nombre_item').val($('#nombre_item').val() + $(this).find('option:selected').text() + " ");
                    }
                });
                $('.selects input').each(function(){
                    if($(this).val() != 0 && $(this).val() != '' && $(this).data('concat') == '1'){
                        $('#nombre_item').val($('#nombre_item').val() + $(this).val() + " ");
                    }
                });

                var cant = 0;
                $('.selects select option:selected[data-peso="1"]').each(function(){
                    cant++;
                });
                if(cant > 0){
                    $('#peso_estimado_item').addClass('peso_igual');
                    $('#peso_estimado_item').prop('readonly');
                    $('.peso_igual').val($('#peso_total_item').val());
                }else{
                    if($('#peso_estimado_item').hasClass('requerido-item')){
                        $('#peso_estimado_item').removeClass('peso_igual');
                        $('#peso_estimado_item').removeAttr('readonly');
                    }
                }
            });
        },
        
    });
    ordenarAtributos();
}

function loadAttributeAttributes(id, value, url2, content = "selects")
{
    $('#valores_atributos').val('');
    cont = 0;
    $(`.${content} select`).each(function(){
        if($(this).val() != ""){
            if(cont == 0){
                $('#valores_atributos').val($(this).val());
            }else{
                $('#valores_atributos').val($('#valores_atributos').val() + ',' + $(this).val());
            }
            ++cont;
        }
    });
    $('.nth-child-attribute-' + id).remove();
    $.ajax(
    {
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
        url : url2,
        type : 'GET',
        async : false,
        dataType : 'JSON',
        data : 
        {
            id : id,
            padre : value
        },
        success: function (datos) {
            $select = 0;
            jQuery.each(datos, function (indice, datos) {
                var item_requerido = "";
                var label_requerido = "";
                if(datos.item_obligatorio == 1){
                    label_requerido = "<span class='required red'>*</span>";
                    item_requerido = "requerido-item";
                }
                var valor_defecto = (datos.valor_defecto == 1) ? "selected" : null;
                var readonly = (datos.nombreatributo.toUpperCase().trim() == "ORIGEN") ? "disabled" : null;
                if($select == datos.idatributo){
                    $('#slc-attr-' + datos.idatributo).append
                    (
                        '<option ' + valor_defecto + ' data-peso="' + datos.peso_igual_contrato + '" value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'
                    );
                }else{
                    $(`.${content}`).append
                    (
                        '<div class="row" data-posicion="' + datos.orden_posicion + '">'+
                            '<div class="' + $('#slc-attr-' + id).parent().attr('class') + ' col-md-offset-1 col-md-10 col-xs-12 bottom-20 nth-child-attribute-' + id + '" id="form-group-' + datos.idatributo + '">'+
                                '<label>' + datos.nombreatributo + ' ' + label_requerido + '</label>'+
                                '<select ' + readonly + ' ' + item_requerido + ' id="slc-attr-' + datos.idatributo + '" data-concat="' + datos.concatenar_nombre + '" data-column="' + datos.columna_independiente_contrato + '" data-atributo="' + datos.nombreatributo + '" onchange="loadAttributeAttributes(' + datos.idatributo + ', this.value, \'' + contrato.getUrlAttributeAttributesById() + '\', \'' + content + '\'); contrato.pesoEstimado();" class="form-control col-md-7 col-xs-12 ' + item_requerido + '">'+
                                    '<option value> - Seleccione una opción - </option>'+
                                    '<option ' + valor_defecto + ' data-peso="' + datos.peso_igual_contrato + '" value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'
                    );
                }
                $select = datos.idatributo;
            });

            $(`.${content} select`).change(function(){
                // contrato.columnasAtributos();
                $('#nombre_item').val('');
                $(`.${content} select`).each(function(){
                    if($(this).val() != 0 && $(this).val() != '' && $(this).data('concat') == '1'){
                        $('#nombre_item').val($('#nombre_item').val() + $(this).find('option:selected').text() + " ");
                    }
                });

                $(`.${content} input`).each(function(){
                    if($(this).val() != 0 && $(this).val() != '' && $(this).data('concat') == '1'){
                        $('#nombre_item').val($('#nombre_item').val() + $(this).val() + " ");
                    }
                });

                var cant = 0;
                $(`.${content} select option:selected[data-peso="0"]`).each(function(){
                    cant++;
                });
                if(cant > 0){
                    if ($('#peso_estimado_item').hasClass('requerido-item')) {
                        $('#peso_estimado_item').removeClass('peso_igual');
                        $('#peso_estimado_item').removeAttr('readonly');
                    }
                } else {
                    $('#peso_estimado_item').addClass('peso_igual');
                    $('#peso_estimado_item').attr('readonly', 'readonly');
                    var edit = ( content == "selects_actualizar" ) ? "edit_" : "";
                    $('.peso_igual').val($('#'+edit+'peso_total_item').val());
                }
            });
        },
        
    });
    ordenarAtributos();
}

function searchValues(id_atributo, valor){
    var option = "";
    $(`.content_buscador_${ id_atributo }`).show('slow');
    $.ajax({
        url: urlBase.make('products/attributes/getAttributeValueByName'),
        type: "get",
        data: {
            id_atributo: id_atributo,
            valor: valor
        },
        success:function(data){
            var j = 0;
            var id_inven = "";
            jQuery.each(data, function (indice, data) {
                option += `<option data-text="${ data.nombre }" value="${ data.id }">${ data.nombre }</option>`;
            });
            $(`#select_valor_atributo_${ id_atributo }`).empty().append(option);
            option = "";
        }
    });
}

function selectValueAttr(element, id_atributo)
{
    text_value = $(element).find('option:selected').text();
    id_value = $(element).find('option:selected').val();
    id_value = (id_value != undefined) ? id_value : null;
    if(text_value != "") $(`#valor_atributo_${ id_atributo }`).val(text_value);
    $(`#valor_atributo_${ id_atributo }`).data('id-valor', id_value);
}

function hideList(id_atributo){
    $(`.content_buscador_${ id_atributo }`).hide('slow');
}


$(document).ready(function(){
    $('.tlx').keyup();
    contrato.tablaItems().cargarTabla();
    $('#dataTableItems').click(function(){
        if($(this).find('tbody tr:hover').hasClass('selected')){
            $(this).find('tbody tr:hover').removeClass('selected')
        }else{
            var table = $('#dataTableItems').DataTable();
            table.$('tr.selected').removeClass('selected');
            $(this).find('tbody tr:hover').addClass('selected');
        }
    });

    $('input, select').change(function(){
        if($(this).val() != null && $(this).val() != ''){
            $(this).css('border', '1px solid #ccc');
            $(this).css('box-shadow', 'none');
        }
    });

    $('#cancelConfirm, .shadow, #confirmSuccess').click(function(){
        $('#category').removeAttr('disabled');
    });
    $('#form-cliente').on('submit',function(e){
        if($('#type-action').val() == "create")
            contrato.crearCliente(urlBase.make('creacioncontrato/crearcliente'), e);
        else
            contrato.actualizarCliente(urlBase.make('creacioncontrato/actualizarcliente'), e);
    });

    fillInput('#ciudad_residencia', '.indicativo_cliente_telefono', urlBase.make('ciudad/getinputindicativo2'));
    fillInput('#ciudad_residencia', '.indicativo_cliente_celular', urlBase.make('ciudad/getinputindicativo'));
});

function redondeaAlAlza(x,r) {
    xx = Math.floor(x/r)
    if (xx!=x/r) {xx++}
    return (xx*r)
}
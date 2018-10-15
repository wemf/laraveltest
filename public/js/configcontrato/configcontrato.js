var URL= (function (){ 
    var url = {}; 
        url.list='';
        url.getPais='';
        url.getCategoria='';
        url.getZona='';
        url.getTiendaByZona='';
        url.getCalificacion='';

    return{ 
        setUrlList:function(url2){           
            url.list=url2;
        },
        getUrlList:function(){           
            return url.list;
        },
        setUrlPais:function(url2){           
            url.list=url2;
        },
        getUrlPais:function(){           
            return url.list;
        },
        setUrlGetCategoria:function(url2){            
            url.getCategoria=url2;
        },
        getUrlGetCategoria:function(){            
            return url.getCategoria;
        },
        setUrlGetZona:function(url2){            
            url.getZona=url2;
        },
        getUrlGetZona:function(){            
            return url.getZona;
        },
        setUrlGetTiendaByZona:function(url2){           
            url.getTiendaByZona=url2;
        },
        getUrlGetTiendaByZona:function(){           
            return url.getTiendaByZona;
        },
        
        setUrlCalificacion:function(url2){           
            url.getCalificacion=url2;
        },
        getUrlCalificacion:function(){           
            return url.getCalificacion;
        },
        setUrlAttributeAttributesById:function(url2){           
            url.getAttributeAttributesById=url2;
        },
        getUrlAttributeAttributesById:function(){           
            return url.getAttributeAttributesById;
        },
    }
})();

var validate_form = ( function() {
    return {
        save_specific : function() {
            if( !this.validate_values('monto_desde', 'monto_hasta', 'money') ) {
                Alerta('Información', 'El monto desde no puede ser mayor al monto hasta', 'warning');
            } else if( !this.validate_values('fecha_desde', 'fecha_hasta', 'datetime') ) {
                Alerta('Información', 'La vigencia desde no puede ser mayor a la vigencia hasta', 'warning');
            } else {
                $( '#btn-save' ).click();
            }            
        },

        validate_values : function(target1, target2, type = 'number', equal = false) {
            var result = true;
            if (type == "number") {
                var target1_1 = ($('#' + target1).val() == '') ? 0 : parseInt($('#' + target1).val());
                var target2_1 = ($('#' + target2).val() == '') ? 0 : parseInt($('#' + target2).val());
            } else if(type == "datetime") {
                var target1_1 = ($('#' + target1).val() == '') ? 0 : ($('#' + target1).val()).split('-');
                target1_1 = (target1_1.length == 3) ? parseInt(target1_1[2].toString() + target1_1[1].toString() + target1_1[0].toString()) : null;

                var target2_1 = ($('#' + target2).val() == '') ? 0 : ($('#' + target2).val()).split('-');
                target2_1 = (target2_1.length == 3) ? parseInt(target2_1[2].toString() + target2_1[1].toString() + target2_1[0].toString()) : null;
            } else if(type == "money") {
                var target1_1 = ($('#' + target1).val() == '') ? 0 : ($('#' + target1).val().replace(/\./g, '').replace(/\,/g, '.'));
                var target2_1 = ($('#' + target2).val() == '') ? 0 : ($('#' + target2).val().replace(/\./g, '').replace(/\,/g, '.'));
                target1_1 = parseFloat(target1_1);
                target2_1 = parseFloat(target2_1);
            }
            if(equal)
                ( target1_1 >= target2_1 ) ? result = false : null;
            else
                ( target1_1 > target2_1 ) ? result = false : null;
            return result;
        }
    }
} )();

$(document).ready(function(){
    $('#pais').change();
    $('#departamento').change();
    $('#ciudad').change();
    $('#zona').change();
    loadFirstAttributes(".categoria_precio_sugerido", urlBase.make('configcontrato/itemcontrato/getatributoscontrato'), 2);

    $('#categoria').change(function(){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('configcontrato/valorsugerido/getValById'),
            type: 'POST',
            data:{
                id: $(this).val()
            },
            success: function(datos){
                $('.valText').each(function(){
                    $(this).empty();
                    $(this).text(datos.nombre_medida);
                    $('#id_medida_peso').val(datos.id);
                });

                $('.rem').each(function(){
                    $(this).removeAttr('disabled');
                    $(this).val('');
                });
            }
        })
    });


});

function runChange() {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: urlBase.make('configcontrato/valorsugerido/getValById'),
        type: 'POST',
        data:{
            id: $('#categoria').val()
        },
        success: function(datos){
            $('.valText').each(function(){
                $(this).empty(datos.id);
                $(this).text(datos.nombre_medida);
                $('#id_medida_peso').val(datos.id);
            });

            $('.rem').each(function(){
                $(this).removeAttr('disabled');
            });
        }
    })
}

function runValorSugeridoForm(){
    loadSelectInput("#pais", URL.getUrlPais(), 2);
    loadSelectInput("#categoria",URL.getUrlGetCategoria(),2);  
}

function runItemContratoForm(){
    loadSelectInput("#categoria",URL.getUrlGetCategoria(),2);  
}

function runRetroventaForm(){
    loadSelectInput("#pais", URL.getUrlPais(), 2);
}

function runDiaGraciaForm(){
    loadSelectInput("#pais", URL.getUrlPais(), 2);
    loadSelectInput("#id_calificacion_cliente", URL.getUrlCalificacion(), 2);
    loadSelectInput("#categoria",URL.getUrlGetCategoria(),2);  
}

function runGeneralForm(){
    loadSelectInput("#pais", URL.getUrlPais(), 2);
    loadSelectInput("#categoria",URL.getUrlGetCategoria(),2);  
}

function runConfigDiaGraciaForm(){
    loadSelectInput("#pais", URL.getUrlPais(), 2);
}



function loadSelect(element,url2,select)
{
    $('#' + select).find('option').remove();
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
            $('#' + select).append($('<option>', {
                value: '',
                text: " - Seleccione una opción - "
            }));

            jQuery.each(datos, function (indice, datos) {   
                var selected = "";
                if($('#' + select).data('load') == datos.id){
                    selected = "selected";
                }
                $('#' + select).append($('<option value="' + datos.id + '" ' + selected + '>' + datos.nombre + '</option>'));
            });
        },
        
    });
}


// Función para hacer un campo requerido si está sujeto a otro campo
function valRequired(e, campo){
    if($(e).val() != ""){
        $(campo).attr('required', true);
    }else{
        $(campo).attr('required', false);
    }
}

function loadFirstAttributes(id, url2)
{
    $(id).change(function()
    {
        $('.selects').html('');
        $('.type-text, #step-3 input[type="number"], textarea').val('');
        $('#parentAttribute').find('option').remove();
        var id = $(this).val();
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
                    if($select == datos.idatributo){
                        $('#slc-attr-' + datos.idatributo).append
                        (
                            '<option data-peso="' + datos.peso_igual_contrato + '" value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'
                        );
                    }else{
                        $('.selects').append
                        (
                                '<div class="form-group">'+
                                    '<label class="control-label col-md-3 col-sm-3 col-xs-12">' + datos.nombreatributo + '</label>'+
                                    '<div class="col-md-6 col-sm-6 col-xs-12">'+
                                        '<select id="slc-attr-' + datos.idatributo + '" data-concat="' + datos.concatenar_nombre + '" data-column="' + datos.columna_independiente_contrato + '" data-atributo="' + datos.nombreatributo + '" onchange="loadAttributeAttributes(' + datos.idatributo + ', this.value, \'' + urlBase.make('configcontrato/itemcontrato/getatributoshijoscontrato') + '\')" class="form-control col-md-7 col-xs-12 select-attr-item">'+
                                            '<option value> - Seleccione una opción - </option>'+
                                            '<option data-peso="' + datos.peso_igual_contrato + '" value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'
                        );
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
    });
}

function loadAttributeAttributes(id, value, url2)
{
    $('#valores_atributos').val('');
    cont = 0;
    $('.selects select').each(function(){
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
                if($select == datos.idatributo){
                    $('#slc-attr-' + datos.idatributo).append
                    (
                        '<option data-peso="' + datos.peso_igual_contrato + '" value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'
                    );
                }else{
                    $('.selects').append
                    (
                            '<div class="form-group bottom-20 nth-child-attribute-' + id + '" id="form-group-' + datos.idatributo + '">'+
                                '<label class="control-label col-md-3 col-sm-3 col-xs-12">' + datos.nombreatributo + '</label>'+
                                '<div class="col-md-6 col-sm-6 col-xs-12">'+
                                    '<select  id="slc-attr-' + datos.idatributo + '" data-concat="' + datos.concatenar_nombre + '" data-column="' + datos.columna_independiente_contrato + '" data-atributo="' + datos.nombreatributo + '" onchange="loadAttributeAttributes(' + datos.idatributo + ', this.value, \'' + urlBase.make('configcontrato/itemcontrato/getatributoshijoscontrato') + '\')" class="form-control col-md-7 col-xs-12">'+
                                        '<option value> - Seleccione una opción - </option>'+
                                        '<option data-peso="' + datos.peso_igual_contrato + '" value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'+
                                    '</select>'+
                                '</div>'+
                            '</div>'
                    );
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

                var cant = 0;
                $('.selects select option:selected[data-peso="1"]').each(function(){
                    cant++;
                });
                if(cant > 0){
                    $('#peso_estimado_item').addClass('peso_igual');
                    $('#peso_estimado_item').attr('readonly', 'readonly');
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
}

function guardarApliRetroventa() {
    if( !validate_form.validate_values('monto_desde', 'monto_hasta', 'money') ) {
        Alerta('Información', 'El monto desde no puede ser mayor al monto hasta', 'warning');
    } else {
        ($('#monto_desde').val() == '') ? $('#monto_desde').val(0) : false;
        ($('#monto_hasta').val() == '') ? $('#monto_hasta').val(0) : false;
        (parseFloat($('#monto_desde').val().replace(/\./g, '')) > parseFloat($('#monto_hasta').val().replace(/\./g, ''))) ? Alerta('Alerta', 'El monto desde no puede ser mayor al monto hasta', 'warning') : document.getElementById("submit_button").click();
    }
}

function loadAttributesUpdate(){
    $('.selects').html('');
    $('#parentAttribute').find('option').remove();
    $.ajax(
    {
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
        url : urlBase.make('configcontrato/valorsugerido/getAttributeValueUpdate'),
        type : 'GET',
        async : false,
        dataType : 'JSON',
        data : 
        {
            id : $('#id').val()
        },
        success: function (datos) {
            $select = 0;
            var selected = "";
            console.log(datos);
            jQuery.each(datos, function (indice, datos) {
                selected = (datos.valor_seleccionado == 1) ? ' selected ' : '';
                if($select == datos.id_atributo){
                    $('#slc-attr-' + datos.id_atributo).append
                    (
                        '<option value="' + datos.id_valor + '" ' + selected + '>' + datos.nombre_valor + '</option>'
                    );
                }else{
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
            });
        },
        
    });
}

function guardarValSug(){

    
    if( !validate_form.validate_values('valor_minimo_x_1', 'valor_maximo_x_1', 'money') ) {
        Alerta('Información', 'El valor mínimo no puede ser mayor al valor máximo', 'warning');
    } else {
        ($('#valor_minimo_x_1').val() == '') ? $('#valor_minimo_x_1').val(0) : false;
        ($('#valor_maximo_x_1').val() == '') ? $('#valor_maximo_x_1').val(0) : false;
        (parseFloat($('#valor_minimo_x_1').val().replace(/\./g, '')) > parseFloat($('#valor_maximo_x_1').val().replace(/\./g, ''))) ? Alerta('Alerta', 'El valor mínimo no puede ser mayor al valor máximo', 'warning') : $(".btn-guardar-valor").click();
    }
}
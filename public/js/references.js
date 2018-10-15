

var URL= (function (){ 
    var url = {}; 
        url.getCategory='';
        url.getAttributeCategoryById='';
        url.getAttributeAttributesById='';
        url.attributeCreate='';
        url.CreateReference='';
        url.IndexPage='';

    return{ 
        setUrlIndex:function(url2){            
            url.IndexPage=url2;
        },
        getUrlIndex:function(){            
            return url.IndexPage;
        },
        setUrlCreateReference:function(url2){            
            url.CreateReference=url2;
        },
        getUrlCreateReference:function(){            
            return url.CreateReference;
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
        setUrlattributeCreate:function(url2){         
            url.attributeCreate=url2;
        },
        getUrlattributeCreate:function(){         
            return url.attributeCreate;
        },
    }
})();


function runAttributeForm(){
    loadSelectInput("#category",URL.getUrlGetCategory(),2);    
    loadFirstAttributes("#category", URL.getUrlAttributeCategoryById(), 2);
}

function runReferenceList(){
    loadSelectValName("#col1_filter",URL.getUrlGetCategory(),2);   
}

function loadFirstAttributes(id, url2){
    $(id).change(function()
    {
        $('.selects').html('');
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
                            '<option value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'
                        );
                    }else{
                        $('.selects').append
                        (
                            '<div class="form-group bottom-20">'+
                                '<label class="control-label col-md-3 col-sm-3 col-xs-12">' + datos.nombreatributo + ' </label>'+
                                '<div class="col-md-6 col-sm-6 col-xs-12">'+
                                    '<select id="slc-attr-' + datos.idatributo + '" data-concat="' + datos.concatenar_nombre + '" onchange="loadAttributeAttributes(' + datos.idatributo + ', this.value, \'' + URL.getUrlAttributeAttributesById() + '\')" class="form-control col-md-7 col-xs-12">'+
                                        '<option value="0"> - Seleccione una opción - </option>'+
                                        '<option value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'+
                                    '</select>'+
                                '</div>'+
                            '</div>'
                        );
                    }
                    $select = datos.idatributo;
                });
            },
            
        });
    });
}

function loadAttributeAttributes(id, value, url2)
{
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
            console.log(datos);
            $select = 0;
            jQuery.each(datos, function (indice, datos) {
                 
                if($select == datos.idatributo){
                    $('#slc-attr-' + datos.idatributo).append
                    (
                        '<option value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'
                    );
                }else{
                    $('.selects').append
                    (
                        '<div class="form-group bottom-20 nth-child-attribute-' + id + '" id="form-group-' + datos.idatributo + '">'+
                            '<label class="control-label col-md-3 col-sm-3 col-xs-12">' + datos.nombreatributo + ' </label>'+
                            '<div class="col-md-6 col-sm-6 col-xs-12">'+
                                '<select id="slc-attr-' + datos.idatributo + '" data-concat="' + datos.concatenar_nombre + '" onchange="loadAttributeAttributes(' + datos.idatributo + ', this.value, \'' + URL.getUrlAttributeAttributesById() + '\')" class="form-control col-md-7 col-xs-12">'+
                                    '<option value="0 "> - Seleccione una opción - </option>'+
                                    '<option value="' + datos.idvaloratributo + '">' + datos.nombrevaloratributo + '</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'
                    );
                }
                $select = datos.idatributo;
            });

            $('.selects select').change(function(){
                $('#nombre_item').val('');
                $('.selects select').each(function(){
                    if($(this).val() != 0 && $(this).val() != '' && $(this).data('concat') == '1'){
                        $('#nombre_item').val($('#nombre_item').val() + $(this).find('option:selected').text() + " ");
                    }
                });
            });
        },
        
    });
}

function validate_values(target1, target2, type = 'number',equal = false) {
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

function saveReference(type = "create"){
    if( !validate_values('valid_since', 'valid_until', 'datetime') ) {
        Alerta('Información', 'La vigencia desde no puede ser mayor a la vigencia hasta', 'warning');
    }else{
        var url = "";
        if(type == "create"){
            url = urlBase.make('products/references/store');
        }else{
            url = urlBase.make('products/references/update');
        }
        if($('#category').val() != '' && $('#name_reference').val() != '' && $('#valid_since').val() != '' && $('#valid_until').val() != ''){
            var data = {};
            data.attributes={};
            data.description={};
            data.code={};    
            var i=0;
            var codereference = ($('#category').val()).toString();
            var descriptionreference = $('#category').children("option").filter(":selected").text() + " ";
    
            $('#form-references .selects select').each(function(){
                if($(this).val() != 0){
                    data.attributes[i] = {};
                    data.attributes[i++].id_valor_atributo = $(this).val();
                    codereference += ($(this).val()).toString();
                    descriptionreference += ($(this).children("option").filter(":selected").text()).toString() + " ";
                }
            });
    
            data.description = descriptionreference;
            data.code = codereference;
    
            $.ajax(
            {
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
                url : url,
                type : 'POST',
                async : false,
                dataType : 'JSON',
                data : 
                {
                    code : codereference,
                    description : descriptionreference,
                    datareference: data,
                    valid_since: $('#valid_since').val(),
                    valid_until: $('#valid_until').val(),
                    idcategory: $('#category').val(),
                    name_reference: $('#name_reference').val(),
                    genera_contrato: $('#genera_contrato').val(),
                    genera_venta: $('#genera_venta').val(),
                    id_update: $('#id').val()
                },
                success: function (datos) {
                    if(datos.val == "ErrorUnico"){
                        Alerta('Ya existe', 'Ya existe una referencia con los mismos valores.', 'warning');
                    }else{
                        Alerta('Guardado', 'Referencia guardada correctamente.');
                        pageAction.redirect(URL.getUrlIndex(), 0);
                    }
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
    }
    
}

function reseter(){
    $('.selects').html('');
}

function loadAttributesUpdate(){
    $('.selects').html('');
    $('#parentAttribute').find('option').remove();
    $.ajax(
    {
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
        url : urlBase.make('products/attributes/getAttributeValueUpdate'),
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
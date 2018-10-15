

var URL = (function () {
    var url = {};
    url.getCategory = '';
    url.getAttribute = '';
    url.getAttributeValueById = '';
    url.attributeCreate = '';

    return {
        setUrlGetCategory: function (url2) {
            url.getCategory = url2;
        },
        getUrlGetCategory: function () {
            return url.getCategory;
        },
        setUrlGetAttribute: function (url2) {
            url.getAttribute = url2;
        },
        getUrlGetAttribute: function () {
            return url.getAttribute;
        },
        setUrlAttributeValueById: function (url2) {
            url.getAttributeValueById = url2;
        },
        getUrlAttributeValueById: function () {
            return url.getAttributeValueById;
        },
        setUrlattributeCreate: function (url2) {
            url.attributeCreate = url2;
        },
        getUrlattributeCreate: function () {
            return url.attributeCreate;
        },
    }
})();


function runAttributeValueFormCreate() {
    loadSelectAttribute("#category", URL.getUrlGetAttribute(), 2);
    loadSelectAttributeValues("#attribute", URL.getUrlAttributeValueById(), 'create');
    $('#category').change();
    $('#attribute').change();
}

function runAttributeValueFormEdit() {
    loadSelectInput("#category", URL.getUrlGetCategory(), 2);
    loadSelectAttribute("#category", URL.getUrlGetAttribute(), 2);
    loadSelectAttributeValuesEdit("#attribute", URL.getUrlAttributeValueById(), 'edit');
    $('#category').change();
    $('#attribute').change();
}

function runAttributeValueList() {
    loadSelectValName("#col1_filter", URL.getUrlGetCategory(), 2);
}

function loadSelectAttribute(id, url2) {
    $(id).change(function () {
        $('#attribute').find('option').remove();
        var id = $(this).val();
        $.ajax(
            {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: url2,
                type: 'GET',
                async: false,
                dataType: 'JSON',
                data:
                {
                    id: id
                },
                success: function (datos) {
                    $('#attribute').append($('<option>', {
                        value: "",
                        text: "- Seleccione una opción -"
                    }));

                    jQuery.each(datos, function (indice, datos) {
                        var selected = "";
                        if ($('#attribute').data('load') == datos.id) {
                            selected = "selected";
                        }
                        $('#attribute').append($('<option value="' + datos.id + '" data-idattr="' + datos.id + '" ' + selected + '>' + datos.nombre + '</option>'));
                    });
                },

            });
    });
}

function loadSelectAttributeValues(id, url2, parampage) {
    $(id).change(function () {
        $('.parentAttributeContent').removeClass('hide');
        if (parampage == "edit") var length = 1;
        else var length = ($('#category').val() == null)?0:$('#category').val().length;
        

        if(length <= 1){
            $('#parentValue').find('option').remove();
            var id = $(this).find('option:selected').data('idattr');
            $.ajax(
            {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: url2,
                type: 'GET',
                async: false,
                dataType: 'JSON',
                data:
                {
                    id: id
                },
                success: function (datos) {
                    $('#parentValue').append($('<option>', {
                        value: 0,
                        text: "Ninguno"
                    }));

                    jQuery.each(datos, function (indice, datos) {
                        var selected = "";
                        if ($('#parentValue').data('load') == datos.id) {
                            selected = "selected";
                        }
                        $('#parentValue').append($('<option value="' + datos.id + '" data-idattr="' + datos.id + '" ' + selected + '>' + datos.nombre + '</option>'));
                    });
                },

            });
        }else{
            $('#parentValue').find('option').remove();
            $('#parentValue').append($('<option value="0">Ninguno</option>'));
            $('.parentAttributeContent').addClass('hide');
        }
    });
}

function loadSelectAttributeValuesEdit(id, url2, parampage) {
    $(id).change(function () {
        $('.parentAttributeContent').removeClass('hide');
        if (parampage == "edit") var length = 1;
        else var length = ($('#category').val() == null)?0:$('#category').val().length;
        

        if(length <= 1){
            $('#parentValue').find('option').remove();
            var id = $(this).find('option:selected').data('idattr');
            $.ajax(
            {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: url2,
                type: 'GET',
                async: false,
                dataType: 'JSON',
                data:
                {
                    id: id
                },
                success: function (datos) {
                    $('#parentValue').append($('<option>', {
                        value: 0,
                        text: "Ninguno"
                    }));

                    jQuery.each(datos, function (indice, datos) {
                        var selected = "";
                        if ($('#parentValue').data('load') == datos.id) {
                            selected = "selected";
                        }
                        $('#parentValue').append($('<option value="' + datos.id + '" data-idattr="' + datos.id + '" ' + selected + '>' + datos.nombre + '</option>'));
                    });
                },

            });
        }else{
            $('#parentValue').find('option').remove();
            $('#parentValue').append($('<option value="0">Ninguno</option>'));
            $('.parentAttributeContent').addClass('hide');
        }
    });
}

function resetvalues() {
    $('#category').val($('#category').data('load'));
    $('#category').change();
    $('#attribute').change();
}

function getAttributesByCategories(url) {

    var length = ($('#category').val() == null)?0:$('#category').val().length;

    if(length > 1){
        $('#parentValue').find('option').remove();
        $('#parentValue').append($('<option value="0">Ninguno</option>'));
        $('.parentAttributeContent').addClass('hide');
    }else{
        $('.parentAttributeContent').removeClass('hide');
    }

    $('#attribute').find('option').remove();
    $.ajax(
        {
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: url,
            type: 'GET',
            async: false,
            dataType: 'JSON',
            data:
            {
                categories: $('#category').val()
            },
            success: function (datos) {
                $('#attribute').append($('<option>', {
                    value: "",
                    text: "- Seleccione una opción -"
                }));

                jQuery.each(datos, function (indice, datos) {
                    var selected = "";
                    if ($('#attribute').data('load') == datos.id) {
                        selected = "selected";
                    }
                    $('#attribute').append($('<option value="' + datos.nombre + '" data-idattr="' + datos.id + '" ' + selected + '>' + datos.nombre + '</option>'));
                });
            },

        });
}

function GenerateExcel() {
    Alerta('Cargando', 'Descargando Excel..', 'notice');

    // $.each(dataEmpleado, function(key, value) {
    //     if (value == '') {
    //         dataEmpleado[key] = 0;
    //     }
    // });
    // var dataGet = dataEmpleado.nombre + '/' + dataEmpleado.primerApellido + '/' + dataEmpleado.segundoApellido + '/' + dataEmpleado.tipoCedula + '/' + dataEmpleado.cedula + '/' + dataEmpleado.estadoCivil + '/' + dataEmpleado.personasCargoMin + '/' + dataEmpleado.personasCargoMax + '/' + dataEmpleado.hijosMin + '/' + dataEmpleado.hijosMax + '/' + dataEmpleado.rangoEdadMin + '/' + dataEmpleado.rangoEdadMax + '/' + dataEmpleado.tipoVivienda + '/' + dataEmpleado.tenenciaVivienda + '/' + dataEmpleado.tipoEstudio + '/' + dataEmpleado.fechaEstudioMin + '/' + dataEmpleado.fechaEstudioMax + '/' + dataEmpleado.estadoEstudio + '/' + dataEmpleado.cargo + '/' + dataEmpleado.salarioMin + '/' + dataEmpleado.salarioMax + '/' + dataEmpleado.auxilioTransporte + '/' + dataEmpleado.retirado + '/' + dataEmpleado.fechaRetiroMin + '/' + dataEmpleado.fechaRetiroMax + '/' + dataEmpleado.motivoRetiro + '/' + dataEmpleado.familiaEmpresa + '/' + dataEmpleado.rangoFamiliaresMin + '/' + dataEmpleado.rangoFamiliaresMax + '/' + dataEmpleado.infoDetalladaHijos + '/' + dataEmpleado.infoDetalladaPersonasCargo + '/' + dataEmpleado.infoDetalladaFamiliaEmpresa + '/' + dataEmpleado.nulo;
    /*
       $.ajax({       
           url: URL.getUrlExcel(),
           type: 'GET',
           async: false,
           data: dataEmpleado,  
           success: function(data) {
              
           }   
       });*/
    pageAction.redirect(urlBase.make('products/attributevalues/exporttoexcel'));
}


var URL= (function (){ 
    var url = {}; 
        url.getCategoria='';
        url.getZona='';
        url.getTiendaByZona='';

    return{ 
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
    }
})();

$(document).ready(function(){
    $('#zona').change();
});

function runDiaGraciaForm(){
    loadSelectInput("#categoria",URL.getUrlGetCategoria(),2);  
    loadSelectInput("#zona",URL.getUrlGetZona(),2);    
    loadSelectTienda("#zona", URL.getUrlGetTiendaByZona())
}

function loadSelectTienda(id,url2)
{
    $(id).change(function()
    {
        $('#tienda').find('option').remove();
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
                zona : id
            },
            success: function (datos) {
                $('#tienda').append($('<option>', {
                    value: 'null',
                    text: " - Seleccione una opción - "
                }));

                jQuery.each(datos, function (indice, datos) {   
                    var selected = "";
                    if($('#tienda').data('load') == datos.id){
                        selected = "selected";
                    }
                    $('#tienda').append($('<option value="' + datos.id + '" ' + selected + '>' + datos.nombre + '</option>'));
                });
            },
            
        });
    });
}
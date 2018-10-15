

var URL= (function (){ 
    var url = {}; 
        url.getCategory='';
        url.getAttributeCategoryById='';
        url.attributeCreate='';

    return{ 
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
        setUrlattributeCreate:function(url2){         
            url.attributeCreate=url2;
        },
        getUrlattributeCreate:function(){         
            return url.attributeCreate;
        },
    }
})();

var validate_form = (function(){
    return {
        save:function(){
            if ($('#category').val() == null) {
                 Alerta('Información', 'El campo categoria es obligatorio', 'warning');
            }else {
                $('#btn-save').click();
            }
        }
    }
})();


function runAttributeForm(page){
    loadSelectInput("#category",URL.getUrlGetCategory(),0);  
    loadSelectAttribute("#category", URL.getUrlAttributeCategoryById(), page)
    $('#category').change();
}

function runAttributeList(){
    loadSelectValName("#col1_filter",URL.getUrlGetCategory(),2);   
}



function loadSelectAttribute(id,url2,parampage)
{
    $(id).change(function()
    {
        $('.parentAttributeContent').removeClass('hide');

        if (parampage == "edit") var length = 1;
        else var length = ($(this).val() == null)?0:$(this).val().length;

        if(length <= 1){
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
                    $('#parentAttribute').append($('<option value="0">Ninguno</option>'));
    
                    jQuery.each(datos, function (indice, datos) {   
                        var selected = "";
                        if($('#parentAttribute').data('load') == datos.id){
                            selected = "selected";
                        }
                        $('#parentAttribute').append($('<option value="' + datos.id + '" ' + selected + '>' + datos.nombre + '</option>'));
                    });
                },
                
            });
        }else{
            $('#parentAttribute').find('option').remove();
            $('#parentAttribute').append($('<option value="0">Ninguno</option>'));
            $('.parentAttributeContent').addClass('hide');
        }
        
    });
}
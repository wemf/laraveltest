
//Carga las URL necesarias para que funcione la persitencia
var URL= (function (){ 
    //variable global
    var url = {}; 
        url.getCompany='';
        url.getFormCompanyById='';
        url.persistenceCreate='';

    return{ 
        setUrlGetCompany:function(url2){			
            url.getCompany=url2;
        },
        getUrlGetCompany:function(){			
            return url.getCompany;
        },
        setUrlFormCompanyById:function(url2){			
            url.getFormCompanyById=url2;
        },
        getUrlFormCompanyById:function(){			
            return url.getFormCompanyById;
        },
        setUrlpersistenceCreate:function(url2){			
            url.persistenceCreate=url2;
        },
        getUrlpersistenceCreate:function(){			
            return url.persistenceCreate;
        },
        setUrlFillSelect:function(url2){			
            url.UrlFillSelect=url2;
        },
        getUrlFillSelect:function(){			
            return url.UrlFillSelect;
        },
    }
})();

//Iniciar logica Persistencia Formulario
function runPersistenceForm()
{
    loadSelectInput("#idcompany",URL.getUrlGetCompany(),2);    
    cargarSelect("#idcompany",URL.getUrlFormCompanyById(),2)
}

$('#btn-in').click(function()
{
    ajaxPersistence(URL.getUrlpersistenceCreate());
});


function cargarSelect(id,url2)
{
    $(id).change(function()
    {
        $('#idform').find('option').remove();
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
                jQuery.each(datos, function (indice, datos) {   
                    $('#idform').append($('<option>', {
                        value: datos.id,
                        text: datos.name
                    }))
                });
            },
            
        });
    });
}

function ajaxPersistence(url2)
{
    $.ajax({
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
        url : url2,
        type : 'POST',
        async : false,
        dataType : 'JSON',
        data : 
        {
            idform : $('#idform').val()
        },
        success: function (datos) {
            if(!datos.val){   
                Alerta('Error', datos.msm,'error') 
            }else{
                retornar=datos.val;
                Alerta('Información',datos.msm) 
            }
        },
        
    });
}

/** ************************************************** ****
*** *** Carga de selects por maestros con persistencia ***/

function runFillSelect()
{
    switch($('#idform').val())
    {
        case '44': 
            fillSelect($('#idform').val(),37,'Nombre','240-InputSelect',URL.getUrlFillSelect());
            break;

        case '47': 
            fillSelect($('#idform').val(),44,'Nombre','248-InputSelect',URL.getUrlFillSelect());
            break;

        case '49': 
            fillSelect($('#idform').val(),37,'Nombre','256-InputSelect',URL.getUrlFillSelect());
            fillSelect($('#idform').val(),47,'Nombre','258-InputSelect',URL.getUrlFillSelect());
            fillSelect($('#idform').val(),50,'Nombre','262-InputSelect',URL.getUrlFillSelect());
            break;

        default: 
            break;
    }
}

function fillSelect(idform,idFormRequiered,alias,idselect,url)
{
    var val_Select = $('#'+idselect).val();
    alert(val_Select);
    $.ajax({
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
        url : url,
        type : 'POST',
        async : false,
        dataType : 'JSON',
        data : 
        {
            idform : idform,
            idFormRequiered : idFormRequiered,
            alias : alias
        },
        success: function (datos) {
            $('#'+idselect).empty();            
            if(jQuery.isEmptyObject(datos))
            {   
                $('#'+idselect).append('<option value="">No hay registros</option>');
            }
            else
            {
                $('#'+idselect).append('<option value="">--Selecciona--</option>');
                datos.forEach(function(element) {
                    if(val_Select == element.id)
                        $('#'+idselect).append('<option value="'+element.id+'" selected>'+element.name+'</option>');
                    else
                        $('#'+idselect).append('<option value="'+element.id+'">'+element.name+'</option>');
                });
            }
        }
    });
}
 /** ************************************************** ***/


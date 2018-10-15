//Carga las URL necesarias para que funcione la persitencia
var URL= (function (){ 
    //variable global
    var url = {}; 
        url.getData='';
        url.getUrl='';
        url.getRedirec='';
    return{ 
        setUrl:function(url2){
            url.getUrl=url2;
        },
        getUrl:function(){			
            return url.getUrl;
        },
        setRedirec:function(url2){			
            url.getRedirec=url2;
        },
        getRedirec:function(){			
            return url.getRedirec;
        }
    }
})();

//Iniciar logica Persistencia Formulario
function runAsociaciones()
{
   
    if(saveAsociaciones(URL.getUrl()))
    {
     pageAction.redirect( URL.getRedirec(), 1.5 );
    }
}

function runImpuestoConceptos(idInput)
{
    ValidarImpuestosSeleccionados(idInput,URL.getUrl());
}

//---------------------------------------

//Guarda las tiendas y sociedades que estan seleccionadas al momento de llamar la funcion
function saveAsociaciones(url){
    var datosasociados = {};
    var cont = 0;
    $('.ms-selection .ms-selected').each(function(){
      datosasociados[cont++] = $(this).find('span').data('value');
    });
    //valida que si hayan tiendas elegidas.
    if(jQuery.isEmptyObject(datosasociados))
    {
        datosasociados[0] = 'Objetovacio';
    }

    data = 
        {
            id_tipo_documento_contable : $('#id_tipo_documento_contable').val(),
            id : $('#id').val(),
            naturaleza : $('#id_naturaleza').val(),
            id_contracuenta : $('#id_contracuenta_codigo').val(),
            id_pais: $('#id_pais').val(),
            concepto: $('#codigo').val(),
            nombre: $('#nombre').val(),
            asociaciones: datosasociados
        }; 
    return actionAjaxWithMessages(data, url);
  }

   //Llama todos los Impuestos que el usuario ha seleccionado antes (sirve para llamarlos al momento de actualizar los actuales)
   function ValidarImpuestosSeleccionados(idIput, url) 
   {
     $.ajax({
         url: url,
         type: "get",
         async: false,
         data: {
             id: $('#id').val(),
         },
         success: function (datos) {
             jQuery.each(datos, function (indice, valor) {
                 var selected = "false";
                 $(idIput).find('option').each(function(){
                     if ($(this).val() == valor.id_asociar) {
                         $(this).attr('selected', true);
                     }
                 });
             });
             
         }
     });
     }

     //Si escoge el codigo cambia el nombre
     $('#id_contracuenta_codigo').change(function(){
        $('#id_contracuenta_nombre').val($('#id_contracuenta_codigo').val());
     });

     //Si escoge el nombre cambia el codigo
     $('#id_contracuenta_nombre').change(function(){
        $('#id_contracuenta_codigo').val($('#id_contracuenta_nombre').val());
     });

     //Si Naturaleza cambia, Nombre y Codigo trae.
     $('#id_naturaleza').change(function(){
        fillSelect('#id_naturaleza','#id_contracuenta_codigo',urlBase.make('/tesoreria/concepto/getselectlistcodigo'),false);
      });
  
      $('#id_naturaleza').change(function(){
        fillSelect('#id_naturaleza','#id_contracuenta_nombre',urlBase.make('/tesoreria/concepto/getselectlistnombre'),false);
      });
     

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
        setData:function(url2){			
            url.getData=url2;
        },
        getData:function(){			
            return url.getData;
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
function runEstados()
{
    if(saveEstado(URL.getUrl()))
    {
        pageAction.redirect( URL.getRedirec(), 1.5 );
    }
}
function runMotivosEstado(idInput)
{
    ValidarMotivosSeleccionados(idInput,URL.getUrl());
}
function runAsociaciones()
{
   
    if(saveAsociaciones(URL.getUrl()))
    {
     pageAction.redirect( URL.getRedirec(), 1.5 );
    }
}
function runSeleccionadas(idInput)
{
    ValidarSeleccionados(idInput,URL.getUrl());
}
//---------------------------------------
function valSociedades() {
    var datosasociados = {};
    var cont = 0;
    $('.ms-selection .ms-selected').each(function(){
        datosasociados[cont++] = $(this).find('span').data('value');
    });
    if(cont < 1){
        $('#tool').remove();
        $('#ms-id_sociedad').after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
        return false;
    }else{
        $('#tool').remove();
        return true;
    }
}


//Guarda los estados que estan seleccionados al momento de llamar la funcion
function saveEstado(url){
    var motivosval = {};
    var cont = 0;
    $('.ms-selection .ms-selected').each(function(){
      motivosval[cont++] = $(this).find('span').data('value');
    });
    data =
        {
          id: $('#id').val(),
          tema: $('#id_tema').val(),
          nombre: $('#nombre').val(),
          descripcion: $('#descripcion').val(),
          linea_atencion: $('#linea_atencion').val(),
          correo_habeas: $('#correo_habeas').val(),
          correo_pedidos: $('#correo_pedidos').val(),
          correo_denuncias: $('#correo_denuncia').val(),
          pagina_web: $('#pagina_web').val(),
          whatsapp: $('#whatsapp').val(),
          facebook: $('#facebook').val(),
          instagram: $('#instagram').val(),
          otro1: $('#otro1').val(),
          otro2: $('#otro2').val(),
          motivos: motivosval
        };

    return actionAjaxWithMessages(data, url)
  }

  //Guarda las tiendas y sociedades que estan seleccionadas al momento de llamar la funcion
  function saveAsociaciones(url){
    var complete = true;
    $('.requerido').each(function(){
        if($(this).val() == "" || $(this).val() == null){
            complete = false;
            $(this).css('border', '1px solid rgba(255,0,0,0.7)');
            $(this).parent('.required-show').css('border', '1px solid rgba(255,0,0,0.7)');
            $(this).css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
            $(this).parent('.required-show').css('box-shadow', '0px 0px 2px 1px rgba(255,0,0,0.4)');
        }else{
            $(this).css('border', '1px solid #ccc');
            $(this).parent('.required-show').css('border', '1px solid #ccc');
            $(this).css('box-shadow', 'none');
            $(this).parent('.required-show').css('box-shadow', 'none');
        }
    });
    if(complete == true){
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
              id: $('#id').val(),
              idtienda: $('#idtienda').val(),
              id_tema: $('#id_tema').val(),
              id_pais: $('#id_pais').val(),
              nombre: $('#nombre').val(),
              linea_atencion: $('#linea_atencion').val(),
              correo_habeas: $('#correo_habeas').val(),
              correo_pedidos: $('#correo_pedidos').val(),
              correo_denuncias: $('#correo_denuncia').val(),
              pagina_web: $('#pagina_web').val(),
              whatsapp: $('#whatsapp').val(),
              facebook: $('#facebook').val(),
              instagram: $('#instagram').val(),
              otro1: $('#otro1').val(),
              otro2: $('#otro2').val(),
              asociaciones: datosasociados
            }; 
        return actionAjaxWithMessages(data, url);
    }    
  }

  //Llama todos los Motivos que el usuario ha seleccionado antes (sirve para llamarlos al momento de actualizar los actuales)
  function ValidarMotivosSeleccionados(idIput, url) 
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
//Llama todos los Motivos que el usuario ha seleccionado antes (sirve para llamarlos al momento de actualizar los actuales)
 function ValidarSeleccionados(idIput, url) 
  {
    $.ajax({
        url: url,
        type: "get",
        async: false,
        data: {
            id: $('#id').val(),
            idtienda: $('#idtienda').val(),
        },
        success: function (datos) {
            jQuery.each(datos, function (indice, valor) {
                $(idIput).append('<option value="' + valor.id + '" selected>' + valor.nombre + '</option>');
            });
        }
    });
    }

    //Permite dejar en la pantalla de seleccionados las tiendas que yo escogí de otras zonas
    function saveAsociar(url, idtarget,idSelect)
    {
        var datosasociados = [];
            datosasociados.val = [];
            datosasociados.text = [];
        var cont = datosasociados.length;
        $('.ms-selection .ms-selected').each(function(){
            var ele = $(this);
            var contarray = 0;
            var exist = false;
            $(datosasociados.val).each(function(){
                if($(ele).find('span').data('value') == datosasociados['val'][contarray]){
                    exist = true;
                }
            });
            if(exist == false){
                datosasociados['val'][cont] = $(ele).find('span').data('value');
                datosasociados['text'][cont] = $(ele).find('span').text();
                cont++;
            }
        });
        var id = $(idtarget).val();
        $.ajax({
            url: url,
            type: "get",
            async: false,
            data: {
                id:id,
            },
            success: function (datos) {
                $(idSelect).html('');
                contt = 0;
                jQuery.each(datos, function (indice, valor) {
                    $(idSelect).append($('<option>', {
                        value: valor.id,
                        text: valor.name
                    }))
                });

                contval = 0;
                $(datosasociados.val).each(function(){
                    exist = false;
                    $(idSelect + ' option').each(function(){
                        if($(this).val() == datosasociados.val[contval]){
                            $(this).attr('selected', true);
                            exist = true;
                        }
                    });
                    if(exist == false){
                        $(idSelect).append('<option value="' + datosasociados.val[contval] + '" selected>' + datosasociados.text[contval] + '</option>');
                    }
                    contval++;
                });
            }
        });
    }
 /** ************************************************** ***/

 $(document).ready(function(){
    $('#form-attributex').on('submit',function(e){

        var formData = new FormData(document.getElementById('form-attributex'));
        formData.append('dato','valor');

        var datosasociados = [];
        var cont = 0;
        $('.ms-selection .ms-selected').each(function(){
            formData.append('asociaciones[]',$(this).find('span').data('value'));
        });
        e.preventDefault();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('franquicia/create'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success:function(datos){
            //    $('#res').append(datos);
            // console.log(datos);
                if (datos.msm.val == "Error") {
                    Alerta('Error', datos.msm.msm, 'error');
                } else if (datos.msm.val == "Insertado") {
                    retornar = datos.msm.val;
                    Alerta('Información', datos.msm.msm);
                    pageAction.redirect( URL.getRedirec(), 1.5 );
                } else if (datos.msm.val == "Actualizado") {
                    retornar = datos.msm.val;
                    Alerta('Información', datos.msm.msm);
                    pageAction.redirect( URL.getRedirec(), 1.5 );
                } else if (datos.msm.val == "ErrorUnico") {
                    Alerta('Alerta', datos.msm.msm, 'Notice')
                }
            }
        });
        
      });

      $('#form-attribute').on('submit',function(e){
        
                var formData = new FormData(document.getElementById('form-attribute'));
                formData.append('dato','valor');
        
                var datosasociados = [];
                var cont = 0;
                $('.ms-selection .ms-selected').each(function(){
                    formData.append('asociaciones[]',$(this).find('span').data('value'));
                });
                e.preventDefault();
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: urlBase.make('franquicia/update'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success:function(datos){
                    //    $('#res').append(datos);
                    // console.log(datos);
                        if (datos.msm.val == "Error") {
                            Alerta('Error', datos.msm.msm, 'error');
                        } else if (datos.msm.val == "Insertado") {
                            retornar = datos.msm.val;
                            Alerta('Información', datos.msm.msm);
                            pageAction.redirect( URL.getRedirec(), 1.5 );
                        } else if (datos.msm.val == "Actualizado") {
                            retornar = datos.msm.val;
                            Alerta('Información', datos.msm.msm);
                            pageAction.redirect( URL.getRedirec(), 1.5 );
                        } else if (datos.msm.val == "ErrorUnico") {
                            Alerta('Alerta', datos.msm.msm, 'Notice')
                        }
                    }
                });
                
              });
 });

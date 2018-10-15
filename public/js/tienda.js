$(document).ready(function(){

        /*Eventos*/
        $('.moneda').each(function() {
          $(this).val(money.replace($(this).val()));
        });
        //----------------------------------

        //Valida la tienda en festivos y 24/7 1 todo el tiempo
        if($('#todoeldia').val() == "1")
        {
        $("#todoeldia").prop('checked', true);        
        }
        else
        {
        $("#todoeldia").prop('checked', false);
        $("#config_horarios").removeClass('hide');
        }
        if($('#festivo').val() == "1")
        {
          $("#festivo").prop('checked', true);          
        }
      //------------------------------------------------

        /*Evento para llenar otros select Apartir de Pais*/
        $('#id_pais').change(function(){
          fillSelect('#id_pais','#id_departamento',urlBase.make('pais/getSelectListPais'));
          fillSelect('#id_pais','#id_franquicia',urlBase.make('franquicia/getSelectListFranquiciaPais'));
          fillSelect('#id_pais','#id_zona',urlBase.make('zona/getSelectListZonaPais'));     
        });
        /* ----------------------------------------- */
     
        //Evento para llenar el select de ciudad desde departamento
        $('#id_departamento').change(function(){
          fillSelect('#id_departamento','#id_ciudad',urlBase.make('/departamento/getSelectListDepartamento'));      
        });
        //------------------------------------------------
        
        //Evento para llenar el select de tienda padre desde ciudad
        $('#id_ciudad').change(function(){
          fillSelect('#id_ciudad','#tienda_padre',urlBase.make('tienda/getTiendaCiudad'));      
          fillInput('#id_ciudad','#telefono_indicativo',urlBase.make('ciudad/getinputindicativo2'));          
        });
        //------------------------------------------------
        
        //Evento para llenar Sociedades a partir de los paises.
        $('#id_pais').change(function(){
          fillSelect('#id_pais','#id_sociedad',urlBase.make('/pais/getSelectListPaisSociedad'));
        });
        //---------------------------------------------------

        //Valida que el usuario ponga hora de entrada y cerrada de la tienda.
         $('.day-store ').blur(function(){
           if($(this).val() != ""){
            $(this).parent().siblings('div').find('input').attr('required',true);
           }else{
            $(this).parent().siblings('div').find('input').removeAttr('required');
           }
         });
         //-----------------------------------------------------------------------
         
         /*Aplicar Funciones antes de Iniciar la pagina*/
         $('.id_pais_create').change();         
         //---------------------------------------------------------------- 
}); 

 // Metodo para Validar Campos ( si existe Determinado campo.)
 function validarCampo(campo)
 {
   data= $('#'+ campo).val()+"";
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: urlBase.make('tienda/validatemarket'),
        type: "POST",
        async: false,
        data: {
            campo:campo,
            data:data
        },
        success: function (datos) 
        {
          if(datos > 0)
          {
            $('#'+campo).focus();
            $('#tool').remove();
            $('#'+campo).after('<div class="tool tool-visible" id="tool"><p>Este registro ya existe, es posible que se este usando en una tienda desactivada.</p></div>');
            $('#'+campo).val("");
          }
          else
          {
            $('#tool').remove();
          }
        }
    });
 }

 /*Si escoge tipo Bodeja, no puede ser administrativa ni Principal*/
$('#tipo_bodega').click(function(){
  if ($('#tipo_bodega').val() == "0")
  {
    $('#tienda_padre').val('');
    $('#sede_principal').val('0');
    $('#sw_sede_principal').children().prop('checked', false);    
  }
});

/* Si tienda padre, no Tipo bodega, no sede principal*/
$('#tienda_padre').change(function(){
  if ($('#tienda_padre').val() != ""){
    $('#tipo_bodega').val('0');
    $('#sw_tipo_bodega').children().prop('checked', false);

    $('#sede_principal').val('0');
    $('#sw_sede_principal').children().prop('checked', false);   
  }
});

/* Si tienda padre, no Tipo bodega, no sede principal*/
$('#sede_principal').change(function(){
  if ($('#sede_principal').val() == "1")
  {
    $('#tienda_padre').val('');
    $('#tipo_bodega').val('0');
    $('#sw_tipo_bodega').children().prop('checked', false);
  }
});

var tool = (function(){
    return{
        hide:function(){
            $('.tool').addClass('tool-hide').removeClass('tool-visible')
        }
    }
})();

$('.requiered').on('keypress',function(){
    tool.hide();
});

$('.requiered').on('change',function(){
    tool.hide();
});

$('.requieredCkeck').on('click',function(){
    tool.hide();
});

//para las bolitas
function valRequiered(id, sig, idbtn, sigbtn, step, step2){
    var bandera = true;
    $('#'+ id +' .requiered').each(function(){
        if($(this).val()==""){
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool"><p>Este campo es requerido para poder continuar</p></div>');
            bandera = false;
        }

        if(bandera == false){
            return false;
        }
    });

    if(bandera){
        $('#'+sig).show();
        $('#'+id).hide();
        $('#'+sigbtn).show();
        $('#'+idbtn).hide();
        $('#' + step).removeClass('btn-primary');
        $('#' + step).addClass('btn-default');
        $('#' + step2).addClass('btn-primary');
    }else{
        return false;
    }
};

//sin bolitas
function valDivRequiered(id){
    var bandera = true;
    $('#'+ id +' .requiered').each(function(){
        if($(this).val()==""){
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
            bandera = false;
        }

        if(bandera == false){
            return false;
        }
    });

    return bandera;
};

function valRegisterExist(id,table,campo,mode='insert')
{
    var bandera = true;
        var input = $('#'+id).val();
        var id= "";
        if(mode != 'insert')
        {
             id = $('#id').val();
        }
        $.ajax({
            url: urlBase.make('/parametros/validateExist'),
            type: "get",
            async: false,
            data: {
                name: input,
                id:id,
                campo:campo,
                table:table,
            },
            success: function (datos) 
            {
              if(datos > 0)
              {
                bandera = false;
              }
            }
        });
        if(bandera == false)
        {
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool"><p>Este registro ya existe.</p></div>');
        }
}

function valEmailRequired(id,mode = 'insert')
{
    var bandera = true;
    $('#'+ id +' .requieredEmail').each(function(){
        var Email = $(this).val();
        var idtienda= "";
        var codigocliente= "";
        if(mode != 'insert')
        {
            $('#id_tienda').change().attr('disabled',false);            
             idtienda = $('#id_tienda').val();
             $('#id_tienda').change().attr('disabled',true);             
             codigocliente = $('#codigo_cliente').val();
        }
        $.ajax({
            url: urlBase.make('/clientes/empleado/getemail'),
            type: "get",
            async: false,
            data: {
                name: Email,
                idtienda:idtienda,
                codigocliente:codigocliente,
            },
            success: function (datos) 
            {
              if(datos > 0)
              {
                bandera = false;
              }
            }
        });
        if(bandera == false)
        {
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool"><p>Este Correo ya está registrado.</p></div>');
        }
    });;
    return bandera;
}
function requiredChecked(id,val)
{
    $('#'+id).val(val);
}
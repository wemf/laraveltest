$('#addSecuencia').click(function(){
    var bandera = true;
    $('.requiered').each(function(){
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
    if(bandera){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('secuenciatienda/createSecInv'),
            type: 'post',
            data: {
                id: $('#sec_tienda').val(),
                secuencia: $('#sec_invalida').val(),
                id_tienda: $('#id_tienda').val()
            },
            success: function(datos){
                console.log($('#id_tienda').val());
                if(datos.val == 'Error'){
                    Alerta('Error',datos.msm,'error');
                }else{
                    Alerta('Información',datos.msm);
                    var t = $('#dataTableAction').DataTable();
                    t.row.add([
                        $('#sec_invalida').val(),
                    ]).draw(false);
                }
                $('#sec_invalida').val('');
            }
        });
    }
});

$('.numeric').each(function() {
    $(this).keyup(function() {
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
});

function valMin(val1,val2,val3)
{   
    
    var num1 = $('#'+val1).val();
    var num2 = $('#'+val2).val();
    var num3 = $('#'+val3).val();
    var valx = eval(num1 - 1);
    
    if(eval(num3) < eval(valx))
    {
        $('#'+val3).val(valx)
    }

    if(eval(num3) > eval(num2))
    {
        $('#'+val3).val(num2)
    }
}



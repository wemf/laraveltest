$('#guardarTipo').click(function(){
    if (valTipe())
    {
        if(saveAsociaciones(urlBase.make('tesoreria/tipoImpuesto/create')))
        {
            pageAction.redirect(urlBase.make('tesoreria/tipoImpuesto'), 1.5);
        }
    }
})

$('#guardarTipoU').click(function(){
    if (valTipe() && valDivRequiered('div_tp'))
    {
        if(saveAsociaciones(urlBase.make('tesoreria/tipoImpuesto/update')))
        {
            pageAction.redirect(urlBase.make('tesoreria/tipoImpuesto'), 1.5);
        }
    }
})

function valTipe() {
    var datosasociados = {};
    var cont = 0;
    $('.ms-selection .ms-selected').each(function () {
        datosasociados[cont++] = $(this).find('span').data('value');
    });
    if (cont < 1) {
        $('#tool').remove();
        $('#ms-id_pais').after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
        return false;
    } else {
        $('#tool').remove();
        return true;
    }
}
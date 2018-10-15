$(function() {
    $("#tabs").tabs();
});

$('.tabs-nav li a').css('color', '#000');
        
$('.tb1').click(function() {    
    $(".moneda").each(function() {
        $(this).val(money.replace($(this).val()));
     });
})

$('a.ui-tabs-anchor').css('color', '#FF0000');

$('.tabs-nav li').click(function() {
    $('.contenido-tab').hide();
    var contenido = $(this).find('a').attr('href');
    $(contenido).fadeIn();
});

$('.contenido-tab').hide();

$('.cantidadesmenor').change(function()
{
    var totalMenor = ($(this).val())*($(this).parent().parent().find('input.valormenor').val())
    $( this ).parent().parent().find('input.totalmenor').val(totalMenor);
    var totalCajaMenor = 0;    
    var totalCajaFuerte = 0;    
    $(".totalmenor").each(function() {
        $(this).val(money.replace($(this).val()));
        totalCajaMenor += parseInt($(this).val().replace(/\./g,''));                
     });
     $('.totalcajamenor').val(totalCajaMenor);     
     $(".totalcajamenor").each(function() {
        $(this).val(money.replace($(this).val()));
     });
     $(".totalfuerte").each(function() {
        $(this).val(money.replace($(this).val()));
        totalCajaFuerte += parseInt($(this).val().replace(/\./g,''));        
     });
     $('.totalfisico').val(totalCajaFuerte+totalCajaMenor);
     $(".totalfisico").each(function() {
        $(this).val(money.replace($(this).val()));
     });

     totalIngresoEgreso = parseInt($('.total_sistema').val().replace(/\./g,''))-parseInt($('.totalfisico').val().replace(/\./g,''));
     
     if(totalIngresoEgreso > 0)
     {
        $('.faltante').val(totalIngresoEgreso);
        $('.faltante').val(money.replace($('.faltante').val()));         
        $('.sobrante').val(0);
     }
     else
     {
        $('.faltante').val(0);
        $('.sobrante').val(totalIngresoEgreso);
        $('.sobrante').val(money.replace($('.sobrante').val()));
     }
})

$('.cantidadesfuerte').change(function()
{
    var totalFuerte = ($(this).val())*($(this).parent().parent().find('input.valorfuerte').val())  
    $( this ).parent().parent().find('input.totalfuerte').val(totalFuerte);
    var totalCajaMenor = 0;        
    var totalCajaFuerte = 0;
    $(".totalfuerte").each(function() {
        $(this).val(money.replace($(this).val()));
        totalCajaFuerte += parseInt($(this).val().replace(/\./g,''));        
     });
     $('.totalcajafuerte').val(totalCajaFuerte);    
     $(".totalcajafuerte").each(function() {
        $(this).val(money.replace($(this).val()));
     });
     $(".totalmenor").each(function() {
        $(this).val(money.replace($(this).val()));
        totalCajaMenor += parseInt($(this).val().replace(/\./g,''));                
     });
     $('.totalfisico').val(totalCajaFuerte+totalCajaMenor);
     $(".totalfisico").each(function() {
        $(this).val(money.replace($(this).val()));
     });
     totalIngresoEgreso = parseInt($('.total_sistema').val().replace(/\./g,''))-parseInt($('.totalfisico').val().replace(/\./g,''));
     if(totalIngresoEgreso > 0)
     {
        $('.faltante').val(totalIngresoEgreso);
        $('.faltante').val(money.replace($('.faltante').val()));                 
        $('.sobrante').val(0);         
     }
     else
     {
        $('.faltante').val(0);         
        $('.sobrante').val(totalIngresoEgreso*(-1));
        $('.sobrante').val(money.replace($('.sobrante').val()));        
     }
})
$('.total_sistema').val(parseInt($('.saldo_inicial').val().replace(/\./g,''))+parseInt($('.ingresos').val().replace(/\./g,''))-parseInt($('.egresos').val().replace(/\./g,'')));
$(".moneda").each(function() {
    $(this).val(money.replace($(this).val()));
 });

 $('#arqueoConfirm').click(function()
{
    $('.loading-gif').removeClass('hide');
    $('#terminararqueo').removeClass('hide');
    $('#continuar').removeClass('hide');
});

$('#terminararqueo').click(function(){
    pageAction.redirect( urlBase.make('home'), 1.5 );
});

$('#form-attribute').submit(function (evt) {
    evt.preventDefault();
    faltante = parseInt($('.faltante').val().replace(/\./g,''));
    sobrante = parseInt($('.sobrante').val().replace(/\./g,''))
    if( (faltante < 1000 || sobrante  < 1000) || (faltante > 1000 || sobrante  > 1000))
        return true;
    else {
        Alerta('Warning', 'No es posible pasar a el cierre de caja pues tiene sobrante o faltante', 'Acción no posible');
        return false;
    }
});


$('#terminarcierrecaja').click(function(){
    pageAction.redirect(urlBase.make('/tesoreria/terminarcierrecaja/') +$('#total_sistema').val());
});
$('.cantidadesfuerte').change();

$('#continuar').click(function(){

    if( parseInt($('.faltante').val().replace(/\./g,'')) < 1000 &&  parseInt($('.sobrante').val().replace(/\./g,'')) < 1000)
        pageAction.redirect(urlBase.make('/tesoreria/cierrecajaindex'));
    else
    Alerta('Warning', 'No es posible pasar a el cierre de caja pues tiene sobrante o faltante', 'Acción no posible');    
})

function isNumber(e){
    /*e = e || window.event;
    var charCode = e.which ? e.which : e.keyCode;
    return /\d/.test(String.fromCharCode(charCode));*/
}

$( ".check" ).change(function() {
    $(this).parent('div.container-check').children().each(function(){ 
        if ( !$(this).is(":first-child") ) {
            $(this).toggleClass('ocultar');
        }
    });
});
function ocultar(){    
    $("div.container-check").children().each(function(){ 
        if ( !$(this).is(":first-child") ) {
            $(this).toggleClass('ocultar');            
        }
    });
}
ocultar() 
$(document).ready(function(){ 
     $(".form_date").datepicker(); 
});
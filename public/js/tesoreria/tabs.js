$('.btn-recorrido').click(function() {
    var id = $(this).attr('data-id-div');
    nextTab(this)     
});

function nextTab(e) {
    var idTab = $(e).closest('div[id^="tabs-"]').attr('id');
    $('.contenido-tab').hide();
    var contenido = $(e).attr('data-href');
    $("#" + contenido).fadeIn();
    $("#" + contenido + ":first-child").focus();
    
}
$('.btn-recorrido').click(function() {
    var id = $(this).attr('data-id-div');
    var isEmail = valEmailRequired(id, 'update');
    var isCan = valDivRequiered(id);
    var anterior = $(this).attr('data-anterior');
    if (anterior == 1)
        isCan = true
    if (isCan == true && isEmail == true) {
        id = $(this).attr('next');
        $("#" + id).click();
        $(document).scrollTop(0);
    }
});

$('.btn-recorrido3').click(function() {
    var id = $(this).attr('data-id-div');
    var isEmail = valEmailRequired(id, 'update');
    var isCan = valDivRequiered(id);
    var anterior = $(this).attr('data-anterior');
    if (anterior == 1)
        isCan = true
    if (isCan == true && isEmail == true) {
        nextTab(this)
    }
});

function nextTab(e) {
    var idTab = $(e).closest('div[id^="tabs-"]').attr('id');
    $('.contenido-tab').hide();
    var contenido = $(e).attr('data-href');
    $("#" + contenido).fadeIn();
    $("#" + contenido + ":first-child").focus();

}
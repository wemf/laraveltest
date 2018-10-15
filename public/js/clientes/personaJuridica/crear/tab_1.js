$('.btn-recorrido').click(function() {
    var id = $(this).attr('data-id-div');
    var isEmail = valEmailRequired(id);
    var isCan = valDivRequiered(id);
    var anterior = $(this).attr('data-anterior');
    if (anterior == 1)
        isCan = true
    if (isCan == true) {
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

$('#id_tipo_cliente').change(function() {
    var id = $(this).val();
    var url2 = URL.getEmpleadoSociedad();
    var ruta = url2.trim() + "/" + id;
    loadSelectInput('#id_sociedad', ruta, true);
});
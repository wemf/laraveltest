if ($('#estado_contrato').val() == 'Cerrado') {
    $("#deletedAction1").addClass('hide');
    $("#updateAction1").removeClass('hide');
}

function generarPDF(){
    copia_contrato();
    confirm.hide();
}

function copia_contrato(){
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: urlBase.make('contrato/extraviado'),
        type: 'POST',
        async: false,
        data: {
            codigo_contrato: $('#contrato_pdf').val(),
            tienda_contrato: $('#tienda_pdf').val(),
            valor_extraviado: 0,
            session_pdf: true
        },
        success:function(datos){
            if(datos == true){
                Alerta('Información', 'Se ha generado una copia del contrato que se descargará en breve.', 'success');
            }else{
                Alerta('Error', 'No se pudo actualizar el contrato.', 'error');
            }
            pageAction.reload(2);
        }
    })
}
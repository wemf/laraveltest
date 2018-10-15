function validarMontosCalificaciones(){
    if( !validate_form.validate_values('valor_min', 'valor_max', 'money') ) {
        Alerta('Información', 'El valor mínimo no puede ser mayor al valor máximo', 'warning');
    } else {
        $( '#btn-save' ).click();
    }            
}
function guardarConfPS(){
    if( !validate_form.validate_values('monto_desde', 'monto_hasta', 'money') ) {
        Alerta('Información', 'El monto desde no puede ser mayor al monto hasta', 'warning');
    } else if( !validate_form.validate_values('fecha_desde', 'fecha_hasta', 'datetime') ) {
        Alerta('Información', 'La vigencia desde no puede ser mayor a la vigencia hasta', 'warning');
    } else {
        $( '#btn-save' ).click();
    }            
}
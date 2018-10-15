var transformacion = (function(){
    return {
        cargarDatosReferencia:function(input){
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: urlBase.make('products/reference/getbyid'),
                type: "GET",
                async: true,
                data: {
                    id_referencia: input.value
                },
                success: function (datos) {
                    $(input).parent().parent().find('.transf-atributos').text(datos.nombre_referencia);
                }
            });
        },
        agregarLinea:function(){
            var linea = $('.tabla-resolucion tbody tr:nth-child(1)').html().replace('value="Borrar"', 'value="Quitar"').replace('transformacion.borrarReferencia', 'transformacion.quitarReferencia');
            $('.tabla-resolucion tbody').append(`<tr>${ linea }</tr>`);
            $('.tabla-resolucion tbody tr:nth-last-child(1)').find('.transf-atributos').text('');
        },
        quitarReferencia:function(input){
            $(input).parent().parent().remove();
        },
        borrarReferencia:function(input){
            $(input).parent().parent().find('.transf-referencia option[value=""]').prop('selected', true);
            $(input).parent().parent().find('.transf-atributos').text('');
            $(input).parent().parent().find('.transf-talla-medida').text('');
            $(input).parent().parent().find('.transf-cantidad').val('');
            $(input).parent().parent().find('.transf-peso-total').val('');
        },
        validarPesos:function(){
            var total_gramos_transformacion = parseFloat($('#total_gramos_transformacion').val().replace(',','.')),
                porcentaje_tolerancia = parseFloat($('#val_porcentaje_tolerancia').val().replace(',','.'));
                min_gramos_transformacion = total_gramos_transformacion - ((total_gramos_transformacion * porcentaje_tolerancia) / 100),
                max_gramos_transformacion = total_gramos_transformacion + ((total_gramos_transformacion * porcentaje_tolerancia) / 100),
                total_gramos_ingresados = parseFloat($('.transf-total-peso-total').text().replace(',','.'));

            if(total_gramos_ingresados >= min_gramos_transformacion && total_gramos_ingresados <= max_gramos_transformacion){
                $('#btn-procesar').click();
            }else{
                Alerta('Alerta', 'Los pesos ingresados no se encuentran dentro de la tolerancia', 'error');
            }
            
        },
        calcularTotales:function(){
            var total_cantidad = 0, total_gramos = 0;
            var cantidad_parcial = 0, gramos_parcial = 0;
            $('.tabla-resolucion tbody tr').each(function(){
                total_cantidad += ($(this).find('.transf-cantidad').val() != '') ? parseInt($(this).find('.transf-cantidad').val()) : 0;
                total_gramos += ($(this).find('.transf-peso-total').val() != '') ? parseFloat($(this).find('.transf-peso-total').val().replace(',','.')) : 0;
                
                
                total_cantidad = (total_cantidad == NaN) ? 0 : total_cantidad;
                total_gramos = (total_gramos == NaN) ? 0 : total_gramos;
            });
            $('.transf-total-cantidad').text(((total_cantidad).toString()));
            $('.transf-total-peso-total').text(((total_gramos.toFixed(2)).toString().replace(/\./g, ',')));
        }
    }
})();
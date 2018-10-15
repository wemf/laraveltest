var prorroga = (function(){
    return {
        calcularMeses:function(){
            var precio_total = parseFloat($('#precio_total').val()),
                porcentaje_retroventa = parseFloat($('#porcen_retro').val()),
                retroventa = (precio_total * porcentaje_retroventa) / 100,
                valor_abonado = (parseFloat($('#valor_abonado_bd').val()) != "") ? parseFloat($('#valor_abonado_bd').val()) : 0,
                valor_total = ($('#total_prorrogar').val() != "") ? parseFloat($('#total_prorrogar').val().replace(/\./g, '').replace(/\,/g, '.')) : 0,
                meses_prorroga = 0;

            if ( valor_total >= retroventa ) {
                var result = valor_total / retroventa;
                meses_prorroga = Math.floor(result);
                valor_total = ((result - meses_prorroga) * retroventa);
            }
            $('#meses_prorroga').val(meses_prorroga);
            $('#nuevo_valor_abonado').val(valor_total.toFixed(2));
        },
        
        calcularValor:function(){
            var precio_total = parseFloat($('#precio_total').val()),
                porcentaje_retroventa = parseFloat($('#porcen_retro').val()),
                retroventa = (precio_total * porcentaje_retroventa) / 100,
                valor_abonado = parseFloat($('#valor_abonado_bd').val()),
                meses_prorroga = parseFloat($('#meses_prorroga').val()),
                valor_ingresado = 0;

            var result = meses_prorroga * retroventa;
            valor_ingresado = result - valor_abonado;
            $('#total_prorrogar').val(valor_ingresado);
            $('#total_prorrogar').blur();
            // $('#efectivo, #var_efectivo').val(0);
            // $('#debito, #var_debito').val(0);
            // $('#credito, #var_credito').val(0);
            // $('#otros, #var_otros').val(0);
            $('#nuevo_valor_abonado').val(0);
        },

        validateProrroga:function(){
            var isValid = true;
            if(!this.validateFormaPago('efectivo') || !this.validateFormaPago('debito') || !this.validateFormaPago('credito') || !this.validateFormaPago('otros')){
                isValid = false;
            }

            var efectivo = ($('#efectivo').val() != "") ? parseFloat($('#efectivo').val().replace(/\./g, '').replace(/\,/g, '.')) : 0,
            debito = ($('#debito').val() != "") ? parseFloat($('#debito').val().replace(/\./g, '').replace(/\,/g, '.')) : 0,
            credito = ($('#credito').val() != "") ? parseFloat($('#credito').val().replace(/\./g, '').replace(/\,/g, '.')) : 0,
            otros = ($('#otros').val() != "") ? parseFloat($('#otros').val().replace(/\./g, '').replace(/\,/g, '.')) : 0,
            valor_total = ($('#total_prorrogar').val() != "") ? parseFloat($('#total_prorrogar').val().replace(/\./g, '').replace(/\,/g, '.')) : 0,
            valor_total_sum = efectivo + debito + credito + otros;

            if(valor_total_sum != valor_total){
                Alerta('Alerta', `Los importes ingresados no coinciden con el total a prórrogar`, 'warning');
                isValid = false;
            }

            if(isValid){
                var limit_prorrogar = 0,
                    meses_prorrogar = 0;
                    limit_prorrogar = parseInt($('#meses_adeudados').val()) + 1;
                    limit_prorrogar = (limit_prorrogar < 0) ? 0 : limit_prorrogar;
                    meses_prorrogar = parseInt($('#meses_prorroga').val());
                if(meses_prorrogar > limit_prorrogar){
                    Alerta('Alerta', `No puede prorrogar más de ${limit_prorrogar} meses`, 'warning');
                }else{
                    $('#var_efectivo').val(($('#efectivo').val() != "") ? parseFloat($('#efectivo').val().replace(/\./g, '').replace(/\,/g, '.')) : 0);
                    $('#var_debito').val(($('#debito').val() != "") ? parseFloat($('#debito').val().replace(/\./g, '').replace(/\,/g, '.')) : 0);
                    $('#var_credito').val(($('#credito').val() != "") ? parseFloat($('#credito').val().replace(/\./g, '').replace(/\,/g, '.')) : 0);
                    $('#var_otros').val(($('#otros').val() != "") ? parseFloat($('#otros').val().replace(/\./g, '').replace(/\,/g, '.')) : 0);
                    $('#btn-prorrogar').click();
                }
            }
            
        },

        validateFormaPago:function(forma){
            var result;
            if(($(`#${ forma }`).val() != '' && $(`#${ forma }`).val() != 0) && $(`#aprobacion_${ forma }`).val() == ''){
                $(`#aprobacion_${ forma }`).addClass('alert-validate-required');
                $(`#aprobacion_${ forma }`).attr("placeholder", "Este campo es requerido");
                result = false;
            }else{
                $(`#aprobacion_${ forma }`).removeClass('alert-validate-required');
                $(`#aprobacion_${ forma }`).attr("placeholder", "");
                result = true;
            }
            return result;
        }
    }
})();
//Validar si es superAdmin o no.
var superAdmin = 0;
/*Evento para llenar otros select Apartir de Pais*/
$('#id_pais').change(function(){
    fillSelect('#id_pais','#id_departamento',urlBase.make('pais/getSelectListPais'));
    $('#id_departamento').change();
    $('#id_ciudad').change();
    
  });
  /* ----------------------------------------- */

  //Evento para llenar el select de ciudad desde departamento
  $('#id_departamento').change(function(){
    fillSelect('#id_departamento','#id_ciudad',urlBase.make('/departamento/getSelectListDepartamento'));
    $('#id_ciudad').change();
  });
  //------------------------------------------------
  
  //Evento para llenar el select de tienda desde ciudad
  $('#id_ciudad').change(function(){
    fillSelect('#id_ciudad','#id_tienda',urlBase.make('tienda/getTiendaCiudad'));      
  });
  //------------------------------------------------

    //Evento para llenar el input de monto_max desde tienda
    $('#id_tienda').change(function(){
        idtienda = {id_tienda:$(this).val()}

        $('#monto_max').val(generalAjax(idtienda,urlBase.make('tienda/getmontomax'),'GET').monto_max);
        $('#monto_max').val(money.replace($('#monto_max').val()));
        $('#id_tipo_documento, #documento_empleado').val('');
    });
    //------------------------------------------------

  $('#id_tipo_documento').change(function()
  {
    $('.limpiar').val('');    
  });

  $('#id_tipo_documento_proveedor_natural').change(function()
  {
    $('.limpiar').val('');    
  });

  $('#id_tipo_documento_contable').change(function()
  {
    fillSelect('#id_tipo_documento_contable','#id_tipo_configuracion_contable',urlBase.make('contabilidad/configuracioncontable/selectlistbyidtipodocumento'));           
  });


  $('#id_tipo_configuracion_contable').change(function()
  {
    if($(this).val() != "")
    {
        idtipoconfiguracioncontable = {id:$(this).val()}
        $('#cxc').val(generalAjax(idtipoconfiguracioncontable,urlBase.make('contabilidad/configuracioncontable/getcxc'),'GET').id); 
        cuentas = (generalAjax(idtipoconfiguracioncontable,urlBase.make('contabilidad/configuracioncontable/selectlistmovimientoscontablesbyid'),'GET'));
        option = "<option value=''>-Seleccione una opción</option>";            
        for (i = 0; i < cuentas.length; i++) 
        {                    
            option += '<option value="'+cuentas[i].id+'" data-naturaleza="'+cuentas[i].naturaleza+'" data-cuenta="'+cuentas[i].cuenta+'">'+cuentas[i].nombre+'</option>';
        }

        //Llena los conceptos de pagos de nomina por que se escogió esta opción
        if($('#id_tipo_causacion').val() == 2)
        {
            $('#id_concepto_nomina').empty().append(option);
        }
        //Llena los conceptos de administración de tienda (campanas) por que se escogió esta opción y se cargan sus impuestos.
        else if($('#id_tipo_causacion').val() == 4)
        {
            $('#id_concepto_campana').empty().append(option);
            data={id:$(this).val()};
            request = generalAjax(data,urlBase.make('/contabilidad/configuracioncontable/getimpuestosxconfiguracion'),'GET');
            console.log();
            impuestos = ``;
            for (i = 0; i < request.length; i++) 
            {
                impuestos += `<div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-4 col-sm-1 col-xs-12">${request[i].descripcion}<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-11 col-xs-12">
                                                        <input type="text" class="form-control justNumbers centrar-derecha requieredcampana inputimpuesto " data-cuenta="${request[i].cuenta}" data-idimpuesto="${request[i].id_impuesto}" data-naturaleza="${request[i].naturaleza}" id="${request[i].id}" value="${request[i].porcentaje}" maxlength="3">
                                                </div>
                                                <div class="col-md-2 col-sm-11 col-xs-12" style="margin-top: -6px;">
                                                        Inclu&iacute;do<input type="checkbox" onchange="intercaleCheck(this);" id="incluido${request[i].id}" class="column_filter check-control check-pos incluido" value="0" />
                                                        <label for="incluido${request[i].id}" class="lbl-check-control" style="font-size: 27px!important; margin-top: -10px; font-weight: 100; height: 26px; display: block;"></label>
                                                </div>
                                            </div>
                                        </div>`; 
            }
            //Si no tiene impuestos.
            if($.isEmptyObject(request))
            impuestos += `<h3>No hay impuestos configurados.</h3>`;
            $('.imp').empty().append(impuestos);
        }
        else if($('#id_tipo_causacion').val() == 6)
        {
            $('#id_concepto_nomina').empty().append(option);
        }
    }
  });

  /* depende de lo que escoja se abrirá el dirijido. */
  $('#id_tipo_causacion').change(function()
  {
        //Limpieza de campos. IMPORTANTE ! NO CAMBIAR SI NO SABE.
        $('.limpiar').val('');
        $('.pagonomina').addClass('hidenomodify');
        $('.pagocampana').addClass('hidenomodify');
        $('.dirigido').addClass('hide');
        $('.datostienda').removeClass('hide');
        $('#id_tipo_documento_contable').val('').change();

        option = "<option value=''>-Seleccione una opción</option>";
        $('#id_concepto_nomina').empty().append(option);
        $('#id_concepto_campana').empty().append(option); 

        valor = $(this).val();
        if(valor == 2) //Pago de Nomina y Prestaciones Sociales
        {
            $('.dirigidoempleado').removeClass('hide');
            $('.pagonomina').removeClass('hidenomodify');
        }
        else if(valor == 4) //Administracion de Tienda
        {
            $('.tipoproveedor').removeClass('hide');      
            $('.pagocampana').removeClass('hidenomodify');   
        }
        else if(valor == 6) //Anticipos
        {
            $('.dirigidoempleado').removeClass('hide');
            $('.anticipo').removeClass('hidenomodify');        
        }
  });

    $('#id_tipo_proveedor').change(function(){
        $('.dirigido').addClass('hide');
        $('.tipoproveedor').removeClass('hide');
        if($(this).val() == 0)
        {
            $('.limpiar').val('');         
            $('.dirigidoproveedorjuridico').removeClass('hide');
        }
        else if($(this).val() == 1)
        {
            $('.limpiar').val('');
            $('.dirigidoproveedornatural').removeClass('hide');
        }
    });

    /*Me trae el Empleado que copio por documento.*/
    $('#documento_empleado').change(function()
    {
        documento = $(this).val();
        tipo_documento = $('#id_tipo_documento').val();
        idtienda = $('#id_tienda').val();
        if(tipo_documento != "")
        {
            if(idtienda != "")
            {
                $.ajax({
                    url: urlBase.make('/clientes/empleado/getEmpleadoIden/')+documento+'/'+tipo_documento+'/'+idtienda,
                    type: "get",
                    async: false,
                    success: function(datos) 
                    {
                        if(jQuery.isEmptyObject(datos))
                        {
                            $('#documento_empleado').focus();
                            $('#tool').remove();
                            $('#documento_empleado').after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este Empleado no Existe</p></div>');
                            $('.limpiar').val('');
                        }
                        else
                        {
                            $('#nombre_empleado').val(datos.nombrecompleto);
                            $('#id_empleado').val(datos.codigo_cliente);
                            $('#id_tienda_empleado').val(datos.id_tienda);
                            $('#tool').remove();                        
                        }
                    }         
                });
            }
            else
            {
                Alerta('Warning', 'Por favor selecione una joyería.', 'Alerta');    
            }        
        }
    });

    /*Me trae el Proveedor Juridico que copio por nit.*/
    $('#digito_verificacion').change(function()
    {
        documento = $('#numero_documento').val();
        digitoverificacion = $(this).val();
            $.ajax({
                url: urlBase.make('/clientes/empleado/getproveedorjuridico/')+documento+'/'+digitoverificacion,
                type: "get",
                async: false,
                success: function(datos) 
                {
                    if(jQuery.isEmptyObject(datos))
                    {
                        $('#nombre_empleado_nit').focus();
                        $('#tool').remove();
                        $('#nombre_empleado_nit').after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este Proveedor no Existe</p></div>');
                        $('.limpiar').val('');                        
                    }
                    else
                    {
                        $('#nombre_empleado_nit').val(datos.nombre);
                        $('#id_empleado').val(datos.codigo_cliente);
                        $('#id_tienda_empleado').val(datos.id_tienda);
                        $('#tool').remove();
                    }
                }         
            });
    });

    /*Me trae el Proveedor Natural que copio por documento.*/
    $('#documento_proveedor_natural').change(function()
    {
        documento = $(this).val();
        tipo_documento = $('#id_tipo_documento_proveedor_natural').val();
        if(tipo_documento != "")
        {
            $.ajax({
                url: urlBase.make('/clientes/empleado/getproveedornatural/')+documento+'/'+tipo_documento,
                type: "get",
                async: false,
                success: function(datos) 
                {
                    if(jQuery.isEmptyObject(datos))
                    {
                        $('#documento_proveedor_natural').focus();
                        $('#tool').remove();
                        $('#documento_proveedor_natural').after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este Proveedor no Existe</p></div>');
                        $('.limpiar').val('');
                    }
                    else
                    {
                        $('#nombre_proveedor_natural').val(datos.nombre);
                        $('#id_empleado').val(datos.codigo_cliente);
                        $('#id_tienda_empleado').val(datos.id_tienda);
                        $('#tool').remove();
                    }
                }         
            });
        }
    });

    $('#btn-agregar-campana').click(function(){
        if(valDivRequieredcampana() && NoConceptosRepetidos())
        {
            if($('#documento_proveedor_natural').val() != '')
            {
                tipo_documento = $('#id_tipo_documento_proveedor_natural').find('option:selected').text();
                nombre_cliente = $('#nombre_proveedor_natural').val();
                numero_documento = $('#documento_proveedor_natural').val();
            }
            else
            {
                tipo_documento = 'NIT';
                nombre_cliente = $('#nombre_empleado_nit').val();
                numero_documento = $('#numero_documento').val();
            }
            articulo = $('#articulo_campana').val();
            valor_bruto = $('#valor_bruto_campana').val();
            //valor_neto =  valor_bruto;
            /*$('input[id*=incluido][type=checkbox]:checked').each(function(){ 
                impuesto_consecutivo = $(this)[0].id.replace("incluido","");
                impuesto_valor = $('#'+impuesto_consecutivo).val();
                //console.log(impuesto_valor);
            });*/

            $(this).val().replace(/\./g,'');
            html_tabla = '';
            html_tabla += `<tr>
                            <td>
                                <input type="hidden" value='${$('#id_empleado').val()}' name='terceros[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][id_empleado][]' >
                                <input type="hidden" value='${$('#id_tienda_empleado').val()}' name='terceros[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][id_tienda_empleado][]'>
                                <input type="hidden" value='${$('#id_empleado').val()+$('#id_tienda_empleado').val()+$('#id_concepto_nomina').val()}' class="consecutivo" >
                                <input type="text" readonly class="form-control" value='${numero_documento}' name='terceros[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][numero_documento][]'>      
                            </td>
                            <td>
                                <input type="text" readonly class="form-control" value='${nombre_cliente}' name='terceros[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][nombre_cliente][]'>
                            </td>
                            <td>
                                <input type="text" readonly class="form-control" value='${articulo}' name='terceros[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][articulo][]'>
                            </td>
                            <td>
                                <input type="text" readonly class="form-control" value='${valor_bruto}' name='terceros[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][valor_bruto][]'>
                            </td>`;
            //// lista de impuestos genericos
            $(".lt_imp").each(function(){
                impuesto_consecutivo = $(this)[0].id.replace("impuesto","");
                impuesto_valor = $('input[data-idimpuesto='+impuesto_consecutivo+']').val();
                if(impuesto_valor){ 
                    impuesto_calculado = (valor_bruto*impuesto_valor);
                }else{
                    impuesto_calculado = 0;
                }
                html_tabla += `<td>
                                    <input type="text" readonly class="form-control" value='${impuesto_calculado}'  name='terceros[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][impuesto_${impuesto_consecutivo}'][]'>
                                </td>`;
            });
            html_tabla += `<td>
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" class="moneda form-control centrar-derecha st1" readonly id="valor" maxlength="15" value='${valor_bruto}'>
                                </div>
                            </td>
                            <td>
                                <button type="button" onclick="borrarConcepto(this)"  class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>
                            </td>
                            </tr>`;
            $('#tabla_campana').find('tbody').append(html_tabla);
            $('#tabla_campana').find(".moneda").each(function() {
                $(this).val(money.replace($(this).val()));
            });
            //Limpia los campos
            $('#valor_bruto_campana').val(0);
            $('#id_concepto_campana').val('').focus();
            $('#articulo_campana').val('');            
            conceptosTotal();
        }
        // deseleccionar los check de impuestos
        $('input[id*=incluido][type=checkbox]:checked').attr('checked', false);
    });

    //Guardar Formulario
    $('#btn-guardar').click(function()
    {
        if(valDivRequieredgeneral())
        {
            valor = $('#id_tipo_causacion').val();
            if(valor == 2) //Pago de Nomina y Prestaciones Sociales
            {
                $('form').attr('action', urlBase.make('tesoreria/causacion/createsalario')).submit();
            }
            else if(valor == 4) //Administracion de Tienda
            {
                $('form').attr('action', urlBase.make('tesoreria/causacion/creategastotienda')).submit();
            }
            else if(valor == 6) //Anticipos
            {
                $('form').attr('action', urlBase.make('tesoreria/causacion/createanticipo')).submit();
            }
        }
    });

    $('#btn-agregar-salario').click(function()
    {
        if(valDivRequieredsalario() && NoSalariosRepetidos())
        {
            html_tabla = '';
            html_tabla += `<tr>
                                <td>
                                    <input type="hidden" name='empleados[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][id_empleado][]' value='${$('#id_empleado').val()}'>      
                                    <input type="hidden" name='empleados[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][id_tienda_empleado][]' value='${$('#id_tienda_empleado').val()}'>     
                                    <input type="hidden" class="consecutivo" value='${$('#id_empleado').val()+$('#id_tienda_empleado').val()+$('#id_concepto_nomina').val()}'>     
                                    <input type="text" readonly class="form-control" value='${$('#documento_empleado').val()}'>      
                                </td>
                                <td>
                                    <input type="text" readonly class="form-control" value='${$('#nombre_empleado').val()}'>
                                </td>
                                <td>
                                    <input type="text" name = 'empleados[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][descripcion][]' readonly class="form-control"  value='${$('#id_concepto_nomina').find('option:selected').text()}'>                                    
                                    <input type="hidden" name='empleados[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][naturaleza][]' readonly class="form-control" value='${$('#id_concepto_nomina').find('option:selected').data('naturaleza')}'>                                    
                                    <input type="hidden" name='empleados[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][cuenta][]' readonly class="form-control" value='${$('#id_concepto_nomina').find('option:selected').data('cuenta')}'>                                    
                                </td>
                                <td>
                                    <input type="text" name='empleados[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][descripcionpago][]' readonly class="form-control" value='${$('#descripcion_pago_nomina').val()}'>                                    
                                </td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" name="empleados[${$('#id_empleado').val()}_${$('#id_tienda_empleado').val()}][valor][]" class="moneda form-control centrar-derecha st" readonly id="valor" value='${$('#salario').val()}' maxlength="15" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </td>
                                <td>
                                    <button type="button" onclick="borrarFila(this)"  class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>
                                </td>
                            </tr>`;
            $('#tabla_salarios').find('tbody').append(html_tabla);

            $('#tabla_salarios').find(".moneda").each(function() {
                $(this).val(money.replace($(this).val()));
            });
            //Limpia los campos
            $('#salario').val(0);
            $('#id_concepto_nomina').val('').focus();
            $('#descripcion_pago_nomina').val('');            
            salarioTotal();   
        }
    });

//No puede poner repetidos.
    function NoSalariosRepetidos()
    {
        bandera = true;
        $('.conceptoexiste').addClass('hide');
              
        $(".consecutivo").each(function()
        {
            consecutivo = $('#id_empleado').val()+$('#id_tienda_empleado').val()+$('#id_concepto_nomina').val();
            if($(this).val() == consecutivo)
            {
                $('.conceptoexiste').removeClass('hide');
                bandera = false;
            }
        });
        return bandera;
    }

//No puede poner repetidos.
    function NoConceptosRepetidos()
    {
        bandera = true;
       /*$('.conceptoexiste').addClass('hide');
              
        $(".consecutivo").each(function()
        {
            consecutivo = $('#id_empleado').val()+$('#id_tienda_empleado').val()+$('#id_concepto_nomina').val();
            if($(this).val() == consecutivo)
            {
                $('.conceptoexiste').removeClass('hide');
                bandera = false;
            }
        });*/
        return bandera;
    }
//Pone el salario Total
    function salarioTotal()
    {
        valor = 0        
        $(".st").each(function(){
            valor += parseInt($(this).val().replace(/\./g,''));
        });
        $('#total').val(valor);
        $('#total').val(money.replace($('#total').val()));   
        $('#total').change();   
    }
    // calcular el total de conceptos de administrar tienda
    function conceptosTotal()
    {
        valor = 0        
        $(".st1").each(function(){
            valor += parseInt($(this).val().replace(/\./g,''));
        });
        $('#total_campana').val(valor);
        $('#total_campana').val(money.replace($('#total_campana').val()));   
        $('#total_campana').change();   
    }

    //sin bolitas
function valDivRequiered(id){
    var bandera = true;
    $('#'+ id +' .requiered').each(function(){
        if($(this).val()==""){
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
            bandera = false;
        }
        if(bandera == false)
            {return false;}
        else
            $('#tool').remove();
    });

    return bandera;
};

    //Valida los requeridos de salario
    function valDivRequieredsalario(){
        var bandera = true;
        $('.requieredsalario').each(function(){
            if($(this).val()==""){
                $(this).focus();
                $('#tool').remove();
                $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Es necesario completar este campo para continuar.</p></div>');
                bandera = false;
            }
            if(bandera == false)
            {return false;}
            else
            $('#tool').remove();
        });
        return bandera;
    };

    //Valida los requeridos de salario
    function valDivRequieredcampana(){
        var bandera = true;
        $('.requieredcampana').each(function(){
            if($(this).val()==""){
                $(this).focus();
                $('#tool').remove();
                $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Es necesario completar este campo para continuar.</p></div>');
                bandera = false;
            }
            if(bandera == false)
            {   return false;   }
            else
                $('#tool').remove();
            
        });
        return bandera;
    };


    //Valida los requeridos de salario
    function valDivRequieredgeneral(){
        var bandera = true;
        $('.generalrequired').each(function(){
            if($(this).val()==""){
                $(this).focus();
                $('#tool').remove();
                $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Es necesario completar este campo para continuar.</p></div>');
                bandera = false;
            }
            if(bandera == false)
            {return false;}
            else
            $('#tool').remove();
        });
        return bandera;
    };

//Pago de nomina - Borrar Fila
function borrarFila(button)
{
    $(button).parent().parent().remove();
    salarioTotal();
};
//Administrar tienda - Borrar Fila
function borrarConcepto(button)
{
    $(button).parent().parent().remove();
    conceptosTotal();
};

//Forma de pago de la causacion
$('#payAction').click(function(){
    $('#myModal').modal('show');
});

$('#pagar').click(function(){
    
    //Pagar en la actualización
    if($('#formaPago').val() != 0 && $('#id_causacion').length)
    window.location = urlBase.make('tesoreria/causacion/pay') + '/' + $('#id_causacion').val()+'/'+$('#id_tienda_causacion').val()+'/'+$('#formaPago').val();
    else
    {
        //Pago directo sin causar
        if($('#formaPago').val() != 0)
        {
            montoMax = parseInt($('#monto_max').val().replace(/\./g,''));
            total = parseInt($('#total').val().replace(/\./g,''));
            if(total>montoMax)
            {
                Alerta('Warning', 'No es posible pagar esta causación ya que supera el monto máximo de la tienda', 'Acción no posible');                
            }
            else
            {
                if(valDivRequieredgeneral())
                {
                    valor = $('#id_tipo_causacion').val();
                    if(valor == 2) //Pago de Nomina y Prestaciones Sociales
                    {
                        $('form').attr('action', urlBase.make('tesoreria/causacion/createsalariowithpay')).submit();
                    }
                    else if(valor == 4) //Administracion de Tienda
                    {}
                    else if(valor == 6) //Anticipos
                    {}
                }
            }
        }
    }
})

//Transferir a la tienda
$('#btn-transferir').click(function()
{
    window.location = urlBase.make('tesoreria/causacion/transfer') + '/' + $('#id_causacion').val()+'/'+$('#id_tienda_causacion').val();    
});

//Modal de anulación
$('#btn-anular-admin').click(function(){
    $('#myanulacionmodal').modal('show');
});

//Solicitudes de anulacion
$('#anularcausacion').click(function()
{ 
    $('form').attr('action', urlBase.make('tesoreria/causacion/anularcausacion')).submit();    
});

$('#anularpagocausacion').click(function()
{
    $('form').attr('action', urlBase.make('tesoreria/causacion/anularcausacionconpago')).submit();
});

$('#anularpago').click(function()
{
    $('form').attr('action', urlBase.make('tesoreria/causacion/anularpago')).submit();
});

$('#confirmanular').click(function()
{
    //Anular Cauascion
    if($('#id_estado').val() == 111)
        $('form').attr('action', urlBase.make('tesoreria/causacion/anularcausacion')).submit();
    //Anular pago y cauascion
    else if($('#id_estado').val() == 112)
        $('form').attr('action', urlBase.make('tesoreria/causacion/anularcausacionconpago')).submit();
    //Anular pago
    else if( $('#id_estado').val() == 113)
        $('form').attr('action', urlBase.make('tesoreria/causacion/anularpago')).submit();    
})

//Cuando cargue.
$( document ).ready(function() 
{
    //valia a quien se le envía 
    if($('#id_cierre_caja_realizado').val() == $('#id_cierre_caja_actual').val())
        $('.cierreactual').removeClass('hide');
    else
        $('.pasocierre').removeClass('hide');
    
    //Valida que opciones para anular tiene
    //Pagado
    if($('#id_estado').val() == 101)
    {
        $('#anularcausacion').addClass('hide');
        $('#payAction').addClass('hide');
        $('#btn-transferir').addClass('hide');
    }
    //Anulado
    else if ($('#id_estado').val() == 102)
        $('.opcion').addClass('hide');
    //Solo cauascion
    else if ($('#id_estado').val() == 100)
    {
        $('#anularpagocausacion').addClass('hide');
        $('#anularpago').addClass('hide');
    }
    //Enviaron solicitud de anular.
    else if($('#id_estado').val() == 111 || $('#id_estado').val() == 112 || $('#id_estado').val() == 113)
    {
        $('.opcion').addClass('hide');        
    }
    //Si el pago es automatico solo podra anular toodo el registro.
    if($('#automatico').val() == 1)
    {
        $('#anularcausacion').addClass('hide');
        $('#anularpago').addClass('hide');
        $('#anularpagocausacion').removeClass('hide');
    }
    // Si el usuario NO es superadmin y el estado no es autorizado pago en tienda no muestre botón de pago
    if(superAdmin==0 && $('#id_estado').val() != 109)
        $('#payAction').addClass('hide');
    // Si ya está transferido a tienda ocultar el botón de transferir y ocultar botones de anular pagos
    if($('#id_estado').val() == 109){
        $('#btn-transferir').addClass('hide');
        $('#anularpago').addClass('hide');
        $('#anularpagocausacion').addClass('hide');
        $('.cierreactual').addClass('hide');
    }
});
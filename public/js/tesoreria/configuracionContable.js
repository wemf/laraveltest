var contCheck = 0;
//Busca los codigos y nombres mas parecidos del PUC.
function buscarCodigos(input)
{
    buscador = $(input).parent().parent().find('select.selectSearch');
    content_buscador = $(input).parent().next('div');
    var option = "";
    if ($(input).val().length > 1) {
        $(content_buscador).show('slow');
        $.ajax({
            url: urlBase.make('contabilidad/configuracioncontable/getpuc'),
            type: "get",
            data: {
                busqueda: $(input).val()
            },
            success:function(data)
            {              
                option = "";                
                for (i = 0; i < data.length; i++) 
                {                    
                    option += '<option value="'+data[i].codigo+'" data-naturaleza="'+data[i].naturaleza+'">'+data[i].cuenta+' - '+data[i].nombre+'</option>';
                }
                $(buscador).empty().append(option);
            }
        })
    }
}

function buscarCodigosImpuestos(input)
{
    buscador = $(input).parent().parent().find('select.selectSearch');
    content_buscador = $(input).parent().next('div');
    var option = "";
    if ($(input).val().length > 1) {
        $(content_buscador).show('slow');
        $.ajax({
            url: urlBase.make('contabilidad/configuracioncontable/getpucimp'),
            type: "get",
            data: {
                busqueda: $(input).val()
            },
            success:function(data)
            {              
                option = "";                
                for (i = 0; i < data.length; i++) 
                {                    
                    option += '<option value="'+data[i].codigo+'" data-naturaleza="'+data[i].naturaleza+'" data-porcentaje="'+data[i].porcentaje+'">'+data[i].cuenta+' - '+data[i].nombre+'</option>';
                }
                $(buscador).empty().append(option);
            }
        })
    }
}

//Busca los codigos y nombres mas parecidos del PUC.
function buscarProv(input)
{
    buscador = $(input).parent().parent().find('select.selectSearchProv');
    content_buscador = $(input).parent().next('div');
    var option = "";
    if ($(input).val().length > 1) {
        $(content_buscador).show('slow');
        $(buscador).show('slow');
        $.ajax({
            url: urlBase.make('contabilidad/configuracioncontable/getProveedores'),
            type: "get",
            data: {
                busqueda: $(input).val()
            },
            success:function(data)
            {
                option = "";                
                for (i = 0; i < data.length; i++) 
                {                    
                    option += '<option value="'+data[i].codigo+'" data-tienda="'+data[i].id_tienda+'" >'+data[i].nombre+'</option>';
                }
                $(buscador).empty().append(option);
            }
        })
    }
}

//Adiciona los datos necesrios del proveedor
function selectValueProv(val)
{
    $(val).parent().prev('div').find('input.terceros').val($(val).find('option:selected').text());
    $(val).parent().prev('div').find('input.cod_tercero').val($(val).val());
    $(val).parent().prev('div').find('input.cod_tienda_tercero').val($(val).find('option:selected').data('tienda'));
    $(val).parent().prev('div').find('input.hd_terceros').val($(val).find('option:selected').text());
    $(val).parent().hide('slow');
    $('#tool').remove();
}

//Adiciona los datos necesrios del puc
function selectValue(val)
{
    $(val).parent().prev('div').find('input.nom_puc').val($(val).find('option:selected').text());
    $(val).parent().prev('div').find('input.cod_puc').val($(val).val());
    $(val).parent().parent().next('div').find('select').val($(val).find('option:selected').data('naturaleza'));
    $(val).parent().parent().next().next('div').find('input').val($(val).find('option:selected').data('porcentaje'));
    $(val).parent().prev('div').find('input.hd_codigoPuc').val($(val).find('option:selected').text());
    $(val).parent().hide('slow');
    $('#tool').remove();
}

//Adiciona campos de Conceptos
$('#adicionar').click(function()
{
    contCheck ++;
    row="";
    row = `<div class="col-md-6 col-xs-12 movimiento">
                <div class="form-group">
                    <label class="control-label col-xs-2 justNumbers">PUC<span class="required">*</span></label>
                    <div class="col-xs-8">
                        <input type="text" id="nom_puc" class="form-control requieredPuc nom_puc requiered" value='' onkeyup="buscarCodigos(this); validarRequeridos(this)">
                        <input type="hidden" id="cod_puc" name="cod_puc[]" class="form-control requieredPuc cod_puc" value=''>
                        <input type="hidden" id="id" name="id[]" class="form-control "value=''>
                        <input type="hidden" id="hd_codigoPuc" name="hd_codigoPuc[]" class="form-control hd_codigoPuc" value=''>
                    </div>
                    <div class="selec_puc col-xs-8 col-xs-offset-2" style="display:none;">
                        <select id="selec_puc" class="selectSearch form-control col-xs-12" size="4" class="form-control co-md-12" onclick="selectValue(this);"></select>
                    </div>
                </div>	
                <div class="form-group">
                    <label class="control-label col-xs-2">Naturaleza<span class="required">*</span></label>
                    <div class="col-xs-8">
                        <select class="column_filter form-control id_naturaleza requiered" disabled="true" id="id_naturaleza" name="id_naturaleza[]">
                            <option value="">- Seleccione una opción -</option>
                            <option value="0">Cr&eacute;dito</option>
                            <option value="1">D&eacute;bito</option>
                        </select> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-2">Descripción<span class="required">*</span></label>
                    <div class="col-xs-5">
                        <input type="text" id="descripcion" name="descripcion[]" class="form-control requiered" value=''onkeyup="validarRequeridos(this);">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3" style="margin-top: -4px;">
                        Tiene Tercero? <input type="checkbox" onchange="intercaleCheck(this), habilitartercero(this) ;" id="tercero${contCheck}" name="tienetercero[]" class="column_filter check-control check-pos" value="0" />
                        <label for="tercero${contCheck}" class="lbl-check-control" style="font-size: 27px!important; margin-top: -10px; font-weight: 100; height: 26px; display: block;"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">Tercero<span class="required">*</span></label>
                    <div class="col-xs-8">
                        <input type="text" readOnly id="terceros" name="terceros[]" class="form-control  terceros" onkeyup="buscarProv(this);validarRequeridos(this);" value=''>
                        <input type="hidden" id="cod_tercero" name="cod_tercero[]" class="form-control cod_tercero " value=''>                                
                        <input type="hidden" id="cod_tienda_tercero" name="cod_tienda_tercero[]" class="form-control cod_tienda_tercero " value=''>                                
                        <input type="hidden" id="hd_terceros" name="hd_terceros[]" class="form-control hd_terceros " value=''>                                
                    </div>
                    <div class="selec_puc col-xs-8 col-xs-offset-2" style="display:none;">
                        <select name="selec_puc[]" id="selec_puc" class="selectSearchProv form-control col-xs-12" size="4" class="form-control co-md-12" onclick="selectValueProv(this);"></select>
                    </div>
                </div>
            </div>`;

    if(valRequire())
    $( row ).insertBefore( ".opciones" );
});

//borra filas de Impuestos y/o conceptos
function borrarfila(boton)
{
    $(boton).parent().prev('div .movimiento').remove();
}

//Valida que exista al menos un credito y un debito.
function validarNaturalezas()
{
    creditos = 0;
    debitos = 0;
    $('.id_naturaleza').each(function(){
        if($(this).val() == 1)
        {debitos++;}
        else if($(this).val() == 0)
        {creditos++;}
    })
    if(debitos == 0 || creditos==0) 
    {
        Alerta('Alerta', 'Tiene que existir mínimo un crédito y un débito', 'warning');
        return false;
    }
    else 
    {
        return true;
    }
}

//Valida los campos no Impuestos
function valRequire()
{
    var bandera = true;
    $('.requiered').each(function(){
        if($(this).val()==""){
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
            bandera = false;
        }

        if(bandera == false){
            return false;
        }
    });

    return bandera;
}

function valTerceros() {
    var bandera = true;
    $('.terceros.requiered').each(function (key, value) {
        if ($(this).val() != $('.hd_terceros')[key].value) {
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>El valor ingresado no es válido</p></div>');
            bandera = false;
        }
        if (bandera == false) {
            return false;
        }
    });
    return bandera;
}

function valPuc() {
    var bandera = true;
    $('.nom_puc.requieredPuc').each(function (key, value) {
        if ($(this).val() != $('.hd_codigoPuc')[key].value) {
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>El valor ingresado no es válido</p></div>');
            bandera = false;
        }
        if (bandera == false) {
            return false;
        }
    });
    return bandera;
}

//Valida los campos no Impuestos
function valRequirePuc()
{
    var bandera = true;
    $('.requieredPuc').each(function(){
        if($(this).val()==""){
            $(this).focus();
            $('#tool').remove();
            $(this).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Información ingresada no es valida para el PUC</p></div>');
            bandera = false;
        }

        if(bandera == false){
            return false;
        }
    });

    return bandera;
}

//Adiciona campos de impuestos cada vez que undo el boton
$('#adicionarimpuesto').click(function(){
    impuesto =  `<div class="col-md-6 col-xs-12 movimiento">
                    <div class="form-group">
                        <label class="control-label col-xs-2">Nombre<span class="required">*</span></label>
                        <div class="col-xs-8">
                            <input type="text" id="impuesto_nombre" name="impuesto_nombre[]" class="form-control requiered" value=''>
                            <input type="hidden" id="id" name="idimpuestos[]" class="form-control" value=''>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-2 justNumbers">PUC<span class="required">*</span></label>
                        <div class="col-xs-8">
                        <input type="text" id="impuesto" name="impuesto[]" class="form-control nom_puc requieredPuc" value='' onkeyup="buscarCodigosImpuestos(this)">        
                        <input type="hidden" id="select_puc_impuesto" name="select_puc_impuesto[]" class="form-control cod_puc" value=''>        
                        <input type="hidden" id="hd_codigoPuc" name="hd_codigoPuc[]" class="form-control hd_codigoPuc" value=''>
                        </div>
                        <div class="selec_puc_impuesto col-xs-7 col-xs-offset-2 " style="display:none;">
                            <select id="selec_puc_impuesto" class="selectSearch form-control col-xs-12" size="4" class="form-control co-md-12" onclick="selectValue(this);"></select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-2">Naturaleza<span class="required">*</span></label>
                        <div class="col-xs-8">
                        <select class="column_filter form-control id_naturaleza_impuesto requiered" disabled="true" id="id_naturaleza_impuesto" name="id_naturaleza_impuesto[]" >
                            <option value="">- Seleccione una opción -</option>
                            <option value="0">Cr&eacute;dito</option>
                            <option value="1">D&eacute;bito</option>
                        </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-2">Porcentaje<span class="required">*</span></label>
                        <div class="col-xs-8">
                        <input type="number" id="porcentaje_impuesto" name="porcentaje_impuesto[]" step="any" class="form-control requiered" value=''>        
                        </div>
                    </div>
                </div>`;
    if(valRequire() && valRequirePuc())
        $(impuesto).insertBefore(".opcionesimpuesto");
});

//Envia los datos del modal a el formulario.
$('#enviarAtributosModal').click(function(){

        $('#producto').val($('#nombre_item').val());
        $('#valores_atributos_principal').val($('#valores_atributos').val());
        $('#myModal').hide( "slow" );
        $('#cerrarModal').click();
        $('#id_clase').val('');
        $('#id_clase').change();
});

//Valida los campos requeridos.
$('form').submit(function(){
    if($('#idconfiguracion').val() > 0)
    {
        if (valTerceros() && valPuc() && valRequire() && valRequirePuc())
        $('form').attr('action', urlBase.make('/contabilidad/configuracioncontable/update')).submit();
    }
    else
    {
        if (valTerceros() && valPuc() && valRequire() && validarNaturalezas() && valRequirePuc())
        $('form').attr('action', urlBase.make('/contabilidad/configuracioncontable/create')).submit();
    }
    
});
//Si escoge Tipo = Compra no puede adicionar IMPUESTOS pues este tiene que estar en el maestro.
$('#id_tipo_documento_contable').change(function()
{
    $('#id_clase').val('');
    $('#id_clase').change();
    //Si se escoge Compra No puede mostrar impuestos
    if($('#id_tipo_documento_contable').val() == 6 )
    {
        $('.impuestos').children('.movimiento').remove();
        $('.impuestos').prev('div').addClass('hide');
        $('.impuestos').addClass('hide');       
    }
    else
    {
        $('.impuestos').prev('div').removeClass('hide');
        $('.impuestos').removeClass('hide');        
        $('.primeraCausacion').addClass('hide');    
    }
    //Si escoge Gastos Generales Adiciona para que el primer movmiento sea la causación.
    if($('#id_tipo_documento_contable').val() == 16 || $('#id_tipo_documento_contable').val() == 17)
    {
        $('.primeraCausacion').removeClass('hide');
    }
})

//Si escoge ventas excluidas No puede adcionar impuestos. 
$('#id_subclase').change(function()
{
    //validarRepetidos();    
    if($(this).val() == 10 || $(this).val() == 45)
    {
        $('.impuestos').children('.movimiento').remove();
        $('.impuestos').prev('div').addClass('hide');
        $('.impuestos').addClass('hide');
    }
    else
    {
        $('.impuestos').prev('div').removeClass('hide');
        $('.impuestos').removeClass('hide');
        $('.primeraCausacion').addClass('hide');    
    }
});

/* Valida si el registro se puede borrar o no.*/
function validarborrable(url2,url1)
{
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    if(valueId != null) 
    {
        data = 
          {
            id: valueId
          };
        if(generalAjax(data,url2).es_borrable == 1)
        {
            deleteRowDatatableAction(url1);
        }
        else
        {
            Alerta('Alerta', 'Este registro no se puede borrar', 'warning');
        } 
    }
    else
    Alerta('Error', 'Seleccione un registro.', 'error');

}

/* Si el Producto combinado con el tipo de documento contable esta repetido no puede dejarlos pasar. */
function validarRepetidos()
{
url = urlBase.make('contabilidad/configuracioncontable/validarrepetido')
data=
{
    producto : $('#producto').val(),
    id_tipo_documento_contable : $('#id_tipo_documento_contable').val(),
    id_categoria : $('#category').val(),
    id_sub_clase: $('#id_subclase').val(),
};
    bandera = true;
    if(!generalAjax(data,url))
    {
        $('#id_subclase').focus();
        $('#tool').remove();
        $('#id_subclase').after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este movimiento contable ya esta registrado.</p></div>');
        bandera = false;
    }
    return bandera;
}

function unlockDisables()
{
    $('.selects').find('select').each(function(){
        $(this).prop("disabled", false);
    });
}

//Function para los Checks para habilitar o no los campos.
function habilitartercero(input)
{
    if($(input).val() == 1)
    {
        $(input).parent('div').parent('div').next('div').find('input.terceros').attr("readonly",false);
        $(input).parent('div').parent('div').next('div').find('input.terceros').addClass('requiered');
    }
    else
    {
        $(input).parent('div').parent('div').next('div').find('input.terceros').attr("readonly",true);    
        $(input).parent('div').parent('div').next('div').find('input.terceros').val('');
        $(input).parent('div').parent('div').next('div').find('input.terceros').removeClass('requiered');        
        $(input).parent('div').parent('div').next('div').find('input.cod_tercero').val('');
        $(input).parent('div').parent('div').next('div').find('input.cod_tienda_tercero').val('');
    }
};

function validarRequeridos(input){
    $('#tool').remove();
    if($(input).val()==""){
        $(input).focus();
        $('#tool').remove();
        $(input).after('<div class="tool tool-visible" id="tool" style="clear:both"><p>Este campo es requerido para poder continuar</p></div>');
    }
}

$('.requiered').keyup(function(){
    validarRequeridos(this);
});

$('.requieredPuc').keyup(function(){
    validarRequeridos(this);
});

$( document ).ready(function() 
{
    if($('#id_tipo_documento_contable').val() == 16 || $('#id_tipo_documento_contable').val() == 17)
    $('.primeraCausacion').removeClass('hide');
    $('.tercero').each(function()
    {
        if ($(this).val() == "1") 
            $(this).prop('checked', true);
        else 
            $(this).prop('checked', false);
    });
    $('#deletedAction1').click(function(){
        $('#confirmsegment').text('¿Eliminar el registro?');
    });
    
})
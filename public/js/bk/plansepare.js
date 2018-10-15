var arraypushx = [];

$(document).ready(function(){

    $('.numeric').each(function(){
        $(this).keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
    });
    

    $('#numero_documento').blur(function(){
        $('#alertPas').css('display','none');
        var numero_documento = __($('#numero_documento').val());
        var id_tienda = __($('#id_tienda').val());
        if(numero_documento != "" && id_tienda != ""){
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: urlBase.make('generarplan/getCliente') + "/" + id_tienda + "/" + numero_documento,
                type: 'get',
                success: function (datos){
                    if(__(datos.codigo_cliente))
                    {   
                        var a = datos.nombres.split(" ");
                        var primer_nombre = a[0];
                        var segundo_nombre = a[1];

                        fillInput('#ciudad', '#telefono_residencia_indicativo', urlBase.make('/ciudad/getinputindicativo'));
                        fillInput('#ciudad', '#telefono_celular_indicativo', urlBase.make('/ciudad/getinputindicativo'));

                        $('#numero_documento').attr('readonly', 'readonly');
                        $('#tipo_documento').attr('disabled', 'disabled');

                        $('#tipo_documento').val(__(datos.id_tipo_documento));
                        $('#primer_nombre').val(__(primer_nombre));
                        $('#segundo_nombre').val(__(segundo_nombre));
                        $('#primer_apellido').val(__(datos.primer_apellido));
                        $('#segundo_apellido').val(__(datos.segundo_apellido));
                        $('#correo').val(__(datos.correo_electronico));
                        $('#confiabilidad').val(__(datos.id_confiabilidad));
                        $('#fecha_nacimiento').val(__(datos.fecha_nacimiento));
                        $('#fecha_expedicion').val(__(datos.fecha_expedicion));
                        $('#genero').val(__(datos.genero));
                        $('#regimen').val(__(datos.regimen));
                        $('#telefono_celular').val(datos.telefono_celular);
                        $('#direccion_residencia').val(__(datos.direccion_residencia));
                        $('#telefono_residencia').val(__(datos.telefono_residencia));
                        $('#foto').val(__(datos.foto));
                        $('#codigo_cliente').val(__(datos.codigo_cliente));
                        $('#id_tienda_cliente').val(__(datos.id_tienda));
                        $('#pais_expedicion').val(__(datos.pais_expedicion));
                        $('#ciudad_nacimiento').val(__(datos.ciudad_nacimiento));
                    }else{
                        $('#primer_nombre').val('');
                        $('#segundo_nombre').val('');
                        $('#primer_apellido').val('');
                        $('#segundo_apellido').val('');
                        $('#correo').val('');
                        $('#confiabilidad').val('');
                        $('#fecha_nacimiento').val('');
                        $('#fecha_expedicion').val('');
                        $('#genero').val('');
                        $('#regimen').val('');
                        $('#telefono_celular').val('');
                        $('#telefono_celular_indicativo').val('');
                        $('#direccion_residencia').val('');
                        $('#telefono_residencia_indicativo').val('');
                        $('#telefono_residencia').val('');
                        $('#foto').val('');
                        $('#codigo_cliente').val('');
                        $('#id_tienda_cliente').val('');
                        $('#pais_expedicion').val('');
                        $('#ciudad_nacimiento').val('');
                        $('#alertPas').css('display','block');
                        $('#textAlert').text('No se encontraron datos relacionados al documento que esta intentado buscar, verifique la información del cliente antes de continuar o ingrese otro documento.');
                    }
                }
            })
        }
    });

    $('.rest').click(function(){
        $('#numero_documento').attr('readonly', false);
        $('#tipo_documento').attr('disabled', false);
        $('.resertInp').val('');
        arraypushx = [];
        var dataTable = $('#productosPlan').DataTable();
        dataTable.clear().draw();
    });

    $('#rest2').click(function () {
        valVolver('2', '1');
    });

    $('#rest3').click(function(){
        valVolver('3', '1');
    });


    var t = $('#productosPlan').DataTable({
        language: {
            url: urlBase.make('/plugins/datatable/DataTables-1.10.13/json/spanish.json')
        }
    });
   
    $('#g3').click(function(){
        
        var codigo_cliente = __($('#codigo_cliente').val());
        var id_tienda = __($('#id_tienda').val());
        var bandera = true;

        if (codigo_cliente && valDivRequiered('step3')){
            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: urlBase.make('generarplan/create'),
                type: 'post',
                data: {
                    id_tienda: id_tienda,
                    codigo_cliente: codigo_cliente,
                    correo: __($('#correo').val()),
                    direccion_residencia: __($('#direccion_residencia').val()),
                    telefono_residencia: __($('#telefono_residencia').val()),
                    telefono_celular: __($('#telefono_celular').val()),
                    monto: __($('#monto').val()),
                    abono: __($('#abono').val()),
                    fecha_creacion: __($('#fecha_creacion').val()),
                    fecha_limite: __($('#fecha_limite').val()),
                    deuda: __($('#deuda').val()),
                    id_tienda_cliente: __($('#id_tienda_cliente').val()),
                    productos: arraypushx
                },
                success: function (datos){
                    // console.log(datos);
                    if(!datos.val){
                        Alerta('Error',datos.msm,'error');
                        pageAction.redirect(urlBase.make('/generarplan'));
                    }else{
                        Alerta('Información',datos.msm);
                        pageAction.redirect(urlBase.make('/generarplan'));
                    }
                }
            });
        }
    });

    $('#codigo_inventario').blur(function () {
        var codigo_inventario = $('#codigo_inventario').val();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('generarplan/getInventarioById'),
            type: 'get',
            data: {
                codigo_inventario: codigo_inventario,
            },
            success: function (datos) {
                if (__(datos.nombre) != "") {
                    $('#alertPas').css('display', 'none');
                    $('#nombre_producto').val(__(datos.nombre));
                    $('#precio').val(__(datos.precio));
                    $('#peso').val(__(datos.peso_estimado));
                    $('#descripcion').val(__(datos.descripcion));
                    $('#addproduct').css('display','');
                } else {
                    $('#alertPas').css('display', 'block');
                    $('#textAlert').text('El producto buscado no esta disponible.');
                }
            }
        });
    });

    $('#addproduct').click(function(){
        var paso = 1;
        if (__($('#codigo_inventario').val()) != '' && __($('#nombre_producto').val()) != '' ){

            jQuery.each(arraypushx, function (key, value) {
                jQuery.each(value, function (keyx, valuex) {
                    if (valuex == $('#codigo_inventario').val())
                    {
                        paso = 0;
                    }
                });
            });
            if (paso == 1){
                
                arraypushx.push({
                    id_tienda: __($('#id_tienda').val()),
                    codigo_inventario: __($('#codigo_inventario').val()),
                    precio: __($('#precio').val())
                });
                
                t.row.add( [
                    $('#codigo_inventario').val(),
                    $('#nombre_producto').val(),
                    $('#precio').val(),
                    $('#peso').val(),
                    $('#descripcion').val()
                ] ).draw( false );
                $('#addproduct').css('display', 'none');
                $('#alertPas').css('display','none');
            }else{
                $('#addproduct').css('display', 'none');
                $('#alertPas').css('display', 'block');
                $('#textAlert').text('Este producto ya se agrego recientemente');
            }
        } else {
            $('#addproduct').css('display', 'none');
            $('#alertPas').css('display', 'block');
            $('#textAlert').text('No se pudo agregar el producto.');
        }
        
        $('#codigo_inventario').val('');
        $('#nombre_producto').val('');
        $('#precio').val('');
        $('#peso').val('');
        $('#descripcion').val('');
    });

    $('.obligatorio').change(function(){
        $(this).css('border','1px solid #ccc');
    });
    
    $('.obligatorio').keypress(function(){
        $(this).css('border','1px solid #ccc');
    });

    var table = $('#productosPlan').DataTable();

    $('#productosPlan tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#btn_quitar_item').click(function () {
        arraypushx.splice($('.selected').index(),1);
        table.row('.selected').remove().draw(false);
        // console.log(arraypushx);
    });

    $('#g2').click(function () {
        var monto = 0;
        var porcentaje = 10;
        var abono = 0;
        var deuda = 0;
        jQuery.each(arraypushx, function (key, value) {
            jQuery.each(value, function (keyx, valuex) {
                // console.log(keyx + " : " + valuex)
                if (keyx == "precio") {
                    monto = eval(monto) + eval(valuex);
                }
            });
        });

        $('#monto').val(monto);
        $('#porcentaje').val(porcentaje);
        $('#abono').val((monto * porcentaje) / 100);
        $('#deuda').val(monto - (monto * porcentaje) / 100);

    });

});





$('#pais').change(function(){
    loadSelectTableById('#pais', '#departamento', urlBase.make('generarplan/getSelectListById'),2,'departamento','id_pais');
});

$('#departamento').change(function(){
    loadSelectTableById('#departamento', '#ciudad', urlBase.make('generarplan/getSelectListById'),2,'ciudad','id_departamento');
});

$('#ciudad').change(function(){
    loadSelectTableById('#ciudad', '#id_tienda', urlBase.make('generarplan/getSelectListById'),2,'tienda','id_ciudad');
});

function loadSelectTableById(idIput, idTarget, url, inputDefaul = true,tabla,filter) {
    id = $(idIput).val();
    $(idTarget).find('option').remove();
    if (inputDefaul) {
        $(idTarget).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }
    $.ajax({
        url: url,
        type: "get",
        async: false,
        data: {
            tabla : tabla,
            filter : filter,
            id : id
        },
        success: function (datos) {
            jQuery.each(datos, function (indice, valor) {
                var selected = "";
                if ($(idTarget).data('load') == valor.id) {
                    selected = "selected";
                }   
                $(idTarget).append($('<option value="' + valor.id + '" ' + selected + '>' + valor.name + '</option>'));
            });
        }
    });
}

function valVolver(step,step2){
    $('#step-'+step+'Btn').hide();
    $('#step-'+step).hide();
    $('#step-'+step2).show();
    $('#step-'+step2+'Btn').show();
    $('#st'+step).removeClass('btn-primary');
    $('#st'+step).addClass('btn-default');
    $('#st'+step2).addClass('btn-primary');
}

function valProducto(id, sig, idbtn, sigbtn, step, step2) {
    var bandera = true;
    if (arraypushx.length < 1){
        bandera = false;
    }
    if (bandera) {
        $('#alertPas').css('display', 'none');
        $('#' + sig).show();
        $('#' + id).hide();
        $('#' + sigbtn).show();
        $('#' + idbtn).hide();
        $('#' + step).removeClass('btn-primary');
        $('#' + step).addClass('btn-default');
        $('#' + step2).addClass('btn-primary');
    } else {
        $('#alertPas').css('display', 'block');
        $('#textAlert').text('Agregue por lo menos un producto para poder continuar con el guardador.');
    }
};


$('#btn-procesar').click(function () {
    if (valDivRequiered('content_abono')) {
        $('#form-attribute').submit();
    }
});

function __($var){
    if($var != '' && $var !== undefined && $var !== null){
        return $var;
    }else{
        return '';
    }
}
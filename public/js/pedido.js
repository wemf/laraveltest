function guardarRecibidas(e) 
{
    var padre = $(e).parent().parent('tr').first().prop('id');
    var res = padre.split("/");
    var id_pedido = res[0];
    var id_tienda = res[1];
    var id_referencia = res[2];
    var valor = $(e).val();
    
    if(valor != "")
    {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('pedidos/updatePedidoAjax'),
            type: "post",
            data: {
                id_pedido : id_pedido,
                id_tienda : id_tienda,
                id_referencia : id_referencia,
                valor : valor,
                g : 1
            },
            success:function(data) {
                if (data.val == "Insertado") {
                    Alerta('Informacion', data.msm)
                } else {
                    Alerta('Error', data.msm, 'error');
                }
            }
        })
    }
}

function ver()
{
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    
    if (valueId != null) {
        console.log(valueId);
        var res = valueId.split("/");
        var id_pedido = res[0];
        var id_tienda = res[3];
        window.location = urlBase.make('pedidos/ver/' + id_pedido + '/' + id_tienda);
    } else {
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
}



function guardarPendientes(e)
{
    var padre = $(e).parent().parent('tr').first().prop('id');
    var res = padre.split("/");
    var id_pedido = res[0];
    var id_tienda = res[1];
    var id_referencia = res[2];
    var valor = $(e).val();

    if (valor != "") {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('pedidos/updatePedidoAjax'),
            type: "post",
            data: {
                id_pedido : id_pedido,
                id_tienda : id_tienda,
                id_referencia : id_referencia,
                valor : valor,
                g : 0
            },
            success: function (data) {
                if (data.val == "Insertado"){
                    Alerta('Informacion',data.msm)
                }else{
                    Alerta('Error', data.msm, 'error');
                }
            }
        });
    }
}

function aprobar() 
{
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    if (valueId != null) {
        $('#myModal').modal('show');
        $('#valuex').val(valueId);
    } else {
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
}


$('#save-aprobar').click(function(){
    if ($('#num_aprobacion').val() !== "")
    {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('pedidos/aprobar'),
            type: "post",
            data: {
                value: $('#valuex').val(),
                num_aprobacion: $('#num_aprobacion').val()
            },
            success: function (data) {
                if (data.val == "Error") {
                    Alerta('Error', data.msm, 'error');
                } else {
                    Alerta('Informacion', data.msm);
                    location.reload();
                }
            }
        });
    }else{
        Alerta('Error', 'El campo de número de aprovación es obligatorio', 'error')
    }
});


function rechazar() 
{
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    if (valueId != null) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('pedidos/rechazar'),
            type: "post",
            data: {
                value : valueId
            },
            success: function (data) {
                if (data.val == "Error") {
                    Alerta('Error', data.msm, 'error');
                } else {
                    Alerta('Informacion', data.msm);
                    location.reload();
                }
            }
        });
    } else {
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
}

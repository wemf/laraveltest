
var noti= (function (){ 
    var url = {};       
        url.get='';
        url.datatable='';
        url.visto='';
        url.base='';
    var id=0;
    return{ 
        setUrlGet:function(url2){            
            url.get=url2;
        },
        setUrlDatatable:function(url2){            
            url.datatable=url2;
        },
        getUrlGet:function(){            
            return url.get;
        },
        getUrlVisto:function(){            
            return url.visto;
        },
        getUrlBase:function(){            
            return url.base;
        },
        getId:function(){            
            return id;
        },
        getUrlDatatable:function(){            
            return url.datatable;
        },
        setUrlVito:function(url2){            
            url.visto=url2;
        },
        setUrlBase:function(url2){            
            url.base=url2;
        },
        vistoAction:function(){
            var table = $('#dataTableAction').DataTable();
            var valueId = table.$('tr.selected').attr('id');
            id = { id: valueId };
            if (valueId != null) {
                showMessageConfirm();
            } else {
                Alerta('Error', 'Seleccione un registro.', 'error')
            }
        },
        vistoMenuAction:function(e){
            id = { id: $(e).data('id') };
            showMessageConfirm();
        },
        run:function(){
            var column=[   
                { "data": "Fecha" },    
                { "data": "Nombre_Usurio_Emisor" },    
                { "data": "mensaje" },
                { "data": "estado_visto" },
                { "data": "estado_notificacion" },
            ];
            dataTableActionFilter(url.get,url.datatable,column);
        },
    }
})();


function actionAjax3(data2, url2) {
    var retornar = false;
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url2,
        type: 'POST',
        async: false,
        data: data2,
        success: function(datos) {
            retornar=datos;
        },
        error: function(request, status, error) {
            Alerta('Error', 'No se pudo realizar la operación.', 'error')
        }
    });
    return retornar;
}

function showMessageConfirm(){
    confirm.setTitle('Autorización');
    confirm.setSegment('¿Revisar?');
    confirm.show();
    confirm.setFunction(function(){
        idPost=noti.getId();
        url2=noti.getUrlVisto();
        base=noti.getUrlBase();
        var action = actionAjax3(idPost, url2);
        if(action.val){
            Alerta('Revisar', action.msm+'\nEspere, será redireccionado en 2 segundos.');
            var url2=base+"/"+action.mensaje.accion;
            pageAction.redirect(url2,2);
        }else{
            Alerta('Error', action.msm, 'error');
        }
    });
}
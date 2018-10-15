
var anular= (function (){ 
    var url = {};       
        url.datatable='';
        url.solicitud='';
        url.rechazar='';
        url.aprobado='';
        url.anulado='';
    var idTienda;
    var codigoContrato;
    var idRemitente;
    return{ 
        setUrlDatatable:function(url2){            
            url.datatable=url2;
        },
        setUrlSolicitud:function(url2){            
            url.solicitud=url2;
        },
        setUrlAprobado:function(url2){            
            url.aprobado=url2;
        },
        setUrlAnulado:function(url2){            
            url.anulado=url2;
        },
        setUrlSolicitudRechazada:function(url2){            
            url.rechazar=url2;
        },
        setIdTienda:function(id2){            
            idTienda=id2;
        },
        setCodigoContrato:function(id2){            
            codigoContrato=id2;
        },
        setIdRemitente:function(id2){            
            idRemitente=id2;
        },
        SolicitarAnularAction:function(){
            var url2=url.solicitud;
            var data2={
                'idTienda':idTienda,
                'codigoContrato':codigoContrato
            };
            var isAction=actionAjax(data2, url2);
            if(isAction){
                pageAction.reload(2);
            }
        },
        AprobarSolicitudAction:function(){
            var url2=url.aprobado;
            var data2={
                'idTienda':idTienda,
                'codigoContrato':codigoContrato,
                'idRemitente':idRemitente
            };
            var isAction=actionAjax(data2, url2);
            if(isAction){
                pageAction.reload(2);
            }
        },
        RechazarSolicitudAction:function(){
            var url2=url.rechazar;
            var data2={
                'idTienda':idTienda,
                'codigoContrato':codigoContrato,
                'idRemitente':idRemitente
            };
            var isAction=actionAjax(data2, url2);
            if(isAction){
                pageAction.reload(2);
            }
        },
        AnularContratoAction:function(){
            var url2=url.anulado;
            var data2={
                'idTienda':idTienda,
                'codigoContrato':codigoContrato
            };
            var isAction=actionAjax(data2, url2);
            if(isAction){
                pageAction.reload(2);
            }
        },
        run:function(){
            $('#dataTableAction').DataTable({
                language: {
                       url:url.datatable
                   },
             });
        },
    }
})();
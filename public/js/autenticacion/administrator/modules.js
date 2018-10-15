
var URL= (function (){ 
    var url = {};       
        url.funcionalidad='';
        url.idRole=0;
    return{ 
        setFuncionalidad:function(url2){            
            url.funcionalidad=url2;
        },
        getFuncionalidad:function(){            
            return url.funcionalidad;
        }, 
        setIdRole:function(id){            
            url.idRole=id;
        },
        getIdRole:function(){            
            return url.idRole;
        }, 
    }
})();

function funcionAction(e){
    var url2=URL.getFuncionalidad();  
    data2={
        'id_role':URL.getIdRole(),
        'id_funcionalidad':parseInt(e.value)    
    };
    actionAjaxII(data2, url2); 
} 

function actionAjaxII(data2, url2) {
    var retornar = false;
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url2,
        type: 'POST',
        async: true,
        data: data2,
        success: function (datos) {
            if (!datos.state) {
                Alerta('Alerta!', datos.msm, 'warning')
            } else {
                retornar = datos.data;
                Alerta('Información!', datos.msm)
            }
        },
        error: function (request, status, error) {
            Alerta('Error!', 'No se pudo realizar la operación.', 'error')
        }
    });
    return retornar;
}
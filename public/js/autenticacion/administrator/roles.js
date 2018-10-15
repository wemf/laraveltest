
var URL= (function (){ 
    var url = {};       
        url.spanishModule='';
        url.list='';
        url.update='';
        url.delete='';     
    return{ 
        setSpanishModule:function(url2){            
            url.spanishModule=url2;
        },
        getSpanishModule:function(){            
            return url.spanishModule;
        }, 

        setList:function(url2){            
            url.list=url2;
        },
        getList:function(){            
            return url.list;
        }, 

        setUpdate:function(url2){            
            url.update=url2;
        },
        getUpdate:function(){            
            return url.update;
        }, 
        
        setDelete:function(url2){            
            url.delete=url2;
        },
        getDelete:function(){            
            return url.delete;
        }, 

        loadDataTable:function(){
            column=[           
                { "data": "Rol" },
                { "data": "descripcion" },
                { "data": "estado" },
            ];
            dataTableActionFilter(URL.getList(),URL.getSpanishModule(),column);
        }
    }
})();

$(window).load(function() { 
    $("#updateAction1").click(function() {
        var url2=URL.getUpdate();
        updateRowDatatableAction(url2)
    });

    $("#activatedAction1").click(function() { 
        var url2=urlBase.make('users/roles/activated');
        deleteRowDatatableAction(url2,'¿Activar Rol?')
    });

    $("#deletedAction1").click(function() { 
        var url2=URL.getDelete();
        deleteRowDatatableAction(url2);
    }); 
});
function updateRowRolAction(url2) {
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    if (valueId != null) {
        window.location = url2 + '/' + valueId
    } else {
        Alerta('Error', 'Seleccione un ROL.', 'error')
    }
}
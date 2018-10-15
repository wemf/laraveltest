
var URL= (function (){ 
    var url = {};       
        url.spanishModule='';
        url.roles='';
        url.listUser='';
        url.update='';
        url.activated='';
      
    return{ 
        setSpanishModule:function(url2){            
            url.spanishModule=url2;
        },
        getSpanishModule:function(){            
            return url.spanishModule;
        },

        setRoles:function(url2){            
            url.roles=url2;
        },
        getRoles:function(){            
            return url.roles;
        },

        setListUser:function(url2){            
            url.listUser=url2;
        },
        getListUser:function(){            
            return url.listUser;
        }, 
        
        setUpdate:function(url2){            
            url.update=url2;
        },
        getUpdate:function(){            
            return url.update;
        }, 

        setActivated:function(url2){            
            url.activated=url2;
        },
        getActivated:function(){            
            return url.activated;
        }, 
    }
})();

var USERS= (function (){    
    var idUser=0;    
    return{             
        loadRol:function(id=0){            
            loadSelectInput('#id_role',URL.getRoles())
            if(id!=0){
                $('#id_role').val(id);
                idUser=id;
            }
        },
        reset:function(){
            document.getElementById("form-user").reset(); 
            if(idUser!=0){
                $('#id_role').val(idUser);
            }
        },
        list:function(){            
            column=[           
                    { "data": "Role" },
                    { "data": "name" },
                    { "data": "email" },
                    { "data": "estado" },  
                ];
            dataTableActionFilter(URL.getListUser(),URL.getSpanishModule(),column)

            loadSelectInput('#col0_filter',URL.getRoles())
            $("#updateAction1").click(function() {
                var url2=URL.getUpdate();
                updateRowDatatableAction(url2)
            });

            $("#deletedAction1").click(function() { 
                var url2=URL.getActivated();
                deleteRowDatatableAction(url2);                       
            });

            $("#activatedAction1").click(function() { 
                var url2=URL.getActivated();
                deleteRowDatatableAction(url2);                       
            });
            
            $(".button_filter2").click(function() {
                if($("#col3_filter").is(':checked'))
                {
                    $("#activatedAction1").removeClass('hide');
                    $("#deletedAction1").addClass('hide');
                }else
                {
                    $("#activatedAction1").addClass('hide');
                    $("#deletedAction1").removeClass('hide');
                }
            })
            },
    }
})();

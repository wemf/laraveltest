//////////////////////////////////////////////////////////////////
/////////////////////======FORM MOTOR=====////////////////////////
//////////////////////////////////////////////////////////////////

//////////////////////======Listar=====//////////////////////////
var initFormMotorDefiner= (function (){ 
    //variable global
    var url={};    
        url.get='';
        url.spanish='';
        url.delete='';
        url.actualizar='';    
        url.openForm='';
        url.duplicated='';
    return{       
        setUrlGet: function (url2){
            url.get=url2;
        },
        setUrlSpanish: function (url2){
            url.spanish=url2;
        },
        setUrlDelete: function (url2){
            url.delete=url2;
        },
        setUrlActualizar: function (url2){
            url.actualizar=url2;
        },       
        setUrlOpenForm: function (url2){
            url.openForm=url2;
        },  
        setUrlDuplicated: function (url2){
            url.duplicated=url2;
        },    
        getUrlGet: function (){
            return url.get;
        },
        getUrlSpanish: function (){
            return url.spanish;
        },
        getUrlDelete: function (){
            return url.delete;
        },
        getUrlActualizar: function (){
            return url.actualizar;
        },   
        getUrlOpenForm: function (){
           return url.openForm;
        },   
        getUrlDuplicated: function (){
            return url.duplicated;
        },           
        //Carga inicial
        run: function (){          
            column=[           
                { "data": "name" },           
                { "data": "created_at" },
                { "data": "updated_at" }       
            ];
            dataTableAction(url.get,url.spanish,column)
        },
        debug:function(){
            console.log(url);
        }

    }
})();

$("#deletedAction").click(function() { 
    var url2=initFormMotorDefiner.getUrlDelete();
    deleteRowDatatableAction(url2)
});

$("#updateAction").click(function() { 
    var url2=initFormMotorDefiner.getUrlActualizar();
    updateRowDatatableAction(url2)
});


$("#openFormAction").click(function() {  
    var url2=initFormMotorDefiner.getUrlOpenForm();  
    var table = $('#dataTableAction').DataTable();  
    var valueId=table.$('tr.selected').attr('id');       
    if(valueId!=null){
      window.open(url2+'/'+valueId);
    }else{
          Alerta('Error', 'Seleccione un registro.','error')       
    }
});
//////////////////////////////////////////////////////////////////
///////////////////////======FIN=====/////////////////////////////
//////////////////////////////////////////////////////////////////


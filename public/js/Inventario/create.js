function loadDescriptionAtion(e) {
    var id2=e.target.attributes['data-value-list'].value;
    var data2={id:id2};
    var url2=urlBase.make('bucar/descripcion');
    var text=generalAjax(data2, url2);
    if(text!='' && text!=false){
        $("#id_referencia-name").val(id2);    
        $("#descripcion").val(text.descripcion);  
        $("#categoriaGeneral").val(text.id_categoria);  
          
    }
}

function validatedLoteAction(e) {
    var data2={lote:e.value};
    var url2=urlBase.make('is/lote/get');
    var text=generalAjax(data2, url2);
    if(text>0){
        $("#lote").val('');
        $("#lote").prop('placeholder',"Lote: "+data2.lote+" ya fue ingresado.");    
    }
}

$(document).ready(function() {
    loadSelectInput("#pais", urlBase.make('pais/getpais'), 2);
    loadSelectInput("#categoriaGeneral", urlBase.make('products/categories/getCategory'), 2);
    SelectValPais("#pais");            
    loadSelectInputByParent("#departamento", urlBase.make('departamento/getdepartamentobypais'), $('#pais').val(), 2);
    loadSelectInputByParent("#ciudad", urlBase.make('ciudad/getciudadbydepartamento'), $('#pais').val(), 2);
    $('.datalist-load').each(function(){
        autoCompletateAction.setUrlAjax($(this).data('ajax-url'));
        autoCompletateAction.setIdInput($(this).prop('id'));
        autoCompletateAction.setIdDataList($(this).attr('list'));
        autoCompletateAction.activateEventBlur();
        autoCompletateAction.loadData();
        this.addEventListener("blur", function( event ) {
            loadDescriptionAtion(event);    
        }, true); 
    });   
});
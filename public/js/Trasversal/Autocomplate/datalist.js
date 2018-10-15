 //////////////////////////////////////////////////////////////////////////////////
 //////////////////////////////Modulo Autocomplate////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////

//Funcion autocompletar mediante un ajax.
//Paramentos del ajax: json con 'id' y 'name'
 var autoCompletateAction=(function(){
     // Get the <datalist> and <input> elements.
     var dataList;
     var input;
     // Create a new XMLHttpRequest.
     var request = new XMLHttpRequest();       
     //URL for ajax
     var urlAjax="";

     return {
         //Cambia el valor por defecto del ID del elemento datalist
         setIdDataList:function(id){
             dataList = document.getElementById(id);
         },
         //Cambia el valor por defecto del ID del elemento input
         setIdInput:function(id){
             input = document.getElementById(id);
         },
         //requiere setIdDataList setIdInput sean implementado antes de este
         activateEventBlur:function(){
             //Load event onBlur when load first field
            input.addEventListener("blur", function( event ) {
                autoCompletateAction.blur(this);    
            }, true); 
         },
         //Cambia el valor por defecto de la URL del llamado ajax metodo GET
         setUrlAjax:function(url2){
             urlAjax = url2;
         },
         //Activa el autocomplete al INPUT relacionado 
         run:function(e){   
            autoCompletateAction.setUrlAjax($(e).data('ajax-url'));
            autoCompletateAction.setIdInput($(e).prop('id'));
            autoCompletateAction.setIdDataList($(e).attr('list'));             
             var data='null';
             if(e.value!='')
                 data=e.value;            
            
             if(!autoCompletateAction.validateValue(data))
                 autoCompletateAction.loadData(data);
         },
         loadData:function(data='null'){
             //console.log('Run Ajax');
             // Handle state changes for the request.
             request.onreadystatechange = function(response) {
                 if (request.readyState === 4) {
                     if (request.status === 200) {
                         // Parse the JSON
                         var jsonOptions = JSON.parse(request.responseText);
                         if(jsonOptions!=''){
                             //Remove the options
                             dataList.innerHTML='';
                             // Loop over the JSON array.
                             jsonOptions.forEach(function(item) {
                                 // Create a new <option> element.
                                 var option = document.createElement('option');
                                 // Set the value using the item in the JSON array.
                                 option.value = item.name;
                                 option.id = item.id;
                                 // Add the <option> element to the <datalist>.
                                 dataList.appendChild(option);
                             });
                             // Update the placeholder text.
                             input.placeholder = "Buscar refencia";
                         }else{
                             input.placeholder = input.value+" : No se encontró en la búsqueda :(";
                             input.value = "";
                         }

                     } else {
                         // An error occured :(
                         input.placeholder = "No se encontró la búsqueda :(";
                     }
                 }
             };
             
             // Update the placeholder text.
             input.placeholder = "Buscando...";

             // Set up and make the request.            
             request.open('GET',urlAjax+"/"+data, false);
             request.send();          
         },
         validateValue:function(data){
             var optionFound = false;                
             // Determine whether an option exists with the current value of the input.
             for (var j = 0; j < dataList.options.length; j++) {
                 var control=dataList.options[j].value.toLowerCase().indexOf(data.toLowerCase());
                 if (control>=0) {
                     optionFound = true;
                     break;
                 }
             } 
             return optionFound;               
         },
         blur:function(e){
             var data='null';
             var optionFound = false;   
             var response=false;
             if(e.value!='')
                 data=e.value;    
             // Determine whether an option exists with the current value of the input.
             for (var j = 0; j < dataList.options.length; j++) {
                 if (dataList.options[j].value.toLowerCase()==data.toLowerCase()) {
                     optionFound = true;
                     response=dataList.options[j].id;
                     break;
                 }
             } 
             if(!optionFound){
                 e.placeholder = e.value+" : No se encontró en la búsqueda :(";
                 e.value='';
             }
             //console.log("I am blur");
             //console.log(response);
             // Create a "data-value-list" attribute
             var att = document.createAttribute("data-value-list");  
             // Set the value of the "data-value-list" attribute     
             att.value = response;  
             // Add the "data-value-list" attribute to Input                         
             e.setAttributeNode(att);                          
             return response;
         }
     }    
 })();
 //////////////////////////////////////////////////////////////////////////////////
 //////////////////////////////////Implementación/////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////


 /*Ejemplo de implemntacion desde HTML */
 //Elementos que deben ser unicos:
 // id="ajax"
 // list="json-datalist" 
 // id="json-datalist"
 //Clase requerida: datalist-load
 /*
  <div class="input-group">
        <input id="ajax" type="text" list="json-datalist" placeholder="Buscar refencia" class="form-control centrar-derecha datalist-load" data-ajax-url="{{ url('bucar/referencia') }}" onkeyup="autoCompletateAction.run(this);"
            required>
        <span class="input-group-addon btn btn-info">
            <i class="fa fa-search"></i>
        </span>
        <datalist id="json-datalist"></datalist>
    </div>
 */

 /*Ejemplo de implemntacion desde javascripts */
 /*
  $('.datalist-load').each(function(){
        autoCompletateAction.setUrlAjax($(this).data('ajax-url'));
        autoCompletateAction.setIdInput($(this).prop('id'));
        autoCompletateAction.setIdDataList($(this).attr('list'));
        autoCompletateAction.activateEventBlur();
        autoCompletateAction.loadData();
    });
 */
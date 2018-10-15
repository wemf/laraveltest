//////////////////////////////////////////////////////////////////
/////////////////////======FORM MOTOR=====////////////////////////
//////////////////////////////////////////////////////////////////

//////////////////////======Definer=====//////////////////////////
var contId=0;
$( "#input" ).click(function() {
	var html='<div class="list-group-item inputAttr">'
			+'<span  class="delete-itm badge">X</span>'
			+'<span  class="show-attr badge"><i class="glyphicon glyphicon-pencil" ></i></span>'
			+'<input id="input-'
			+contId
			+'" name="input_'
			+contId
			+'" class="itm-field ui-state-disabled" placeholder="Ejemplo" type="text"></input>'
			+'</div>';
	$( "#container-add" ).append(html);
	refreshClick('delete-itm',deleteItm);
	refreshClick('show-attr',showAttr);
	contId++;
});

$( "#etiqueta" ).click(function() {
	var html='<div class="list-group-item labelAttr">'
			+'<span  class="delete-itm badge">X</span>'
			+'<span  class="show-attr badge"><i class="glyphicon glyphicon-pencil" ></i></span>'
			+'<label id="label-'
			+contId
			+'" class="itm-field">Etiqueta</label>'
			+'</div>';
	$( "#container-add" ).append(html);
	refreshClick('delete-itm',deleteItm);
	refreshClick('show-attr',showAttr);
	contId++;
});

$( "#parrafo" ).click(function() {
	var html='<div class="list-group-item textareaAttr">'
			+'<span  class="delete-itm badge">X</span>'
			+'<span  class="show-attr badge"><i class="glyphicon glyphicon-pencil" ></i></span>'
			+'<textarea id="textarea-'
			+contId
			+'" name="parrafo_'
			+contId
			+'" class="itm-field" placeholder="Ejemplo Parrafo"></textarea>'
			+'</div>';
	$( "#container-add" ).append(html);
	refreshClick('delete-itm',deleteItm);
	refreshClick('show-attr',showAttr);
	contId++;
});

$( "#lista" ).click(function() {
	var html='<div class="list-group-item selectAttr">'
			+'<span  class="delete-itm badge">X</span>'
			+'<span  class="show-attr badge"><i class="glyphicon glyphicon-pencil" ></i></span>'
			+'<select id="select-'
			+contId
			+'" name="select_'
			+contId
			+'" class="itm-field ui-state-disabled"></select>'
			+'</div>';
	$( "#container-add" ).append(html);
	refreshClick('delete-itm',deleteItm);
	refreshClick('show-attr',showAttr);
	contId++;
});

$( "#radio" ).click(function() {
	var html='<div class="list-group-item radioAttr">'
			+'<span  class="delete-itm badge">X</span>'
			+'<span  class="show-attr badge"><i class="glyphicon glyphicon-pencil" ></i></span>'
			+'<input id="radio-'
			+contId
			+'" class="itm-field" name="radio" type="radio"></input>'
			+'</div>';
	$( "#container-add" ).append(html);
	refreshClick('delete-itm',deleteItm);
	refreshClick('show-attr',showAttr);
	contId++;
});

$( "#checkbox" ).click(function() {
	var html='<div class="list-group-item checkboxAttr">'
			+'<span  class="delete-itm badge">X</span>'
			+'<span  class="show-attr badge"><i class="glyphicon glyphicon-pencil" ></i></span>'
			+'<span  class="add-container-check badge">Hijos</span>'
			+'<input id="checkbox-'
			+contId
			+'" name="checkbox_'
			+contId
			+'" class="itm-field" type="checkbox"></input>'
			+'</div>';
	$( "#container-add" ).append(html);
	refreshClick('delete-itm',deleteItm);
	refreshClick('show-attr',showAttr);
	refreshClick('add-container-check',containerCheck);	
	contId++;
});

function refreshClick(itmClass,fun){
	var myEl = document.querySelectorAll('.'+itmClass);
    [].forEach.call(myEl, function(myEls) {
        myEls.addEventListener('click', fun , false);
    });	
}

function refreshChange(itmClass,fun){
	var myEl = document.querySelectorAll('.'+itmClass);
    [].forEach.call(myEl, function(myEls) {
        myEls.addEventListener('change', fun , false);
    });	
}

function deleteItm(){
	$(this).parent('div.list-group-item').remove();		
}

function deleteItmCheck(){
	$(this).parent('div.container-check').parent('div.list-group-item').find('input.check').removeClass('check');	//borramos check
	$(this).parent('div.container-check').remove();	
}

function containerCheck(){
	var html='<div id="conatiner-check-'
			 +contId
			 +'" class="container-check sortable2 connectedSortable">'
			 +'<span  class="delete-itm badge2 ui-state-disabled">X</span>'
			 +'<p class="sombra ui-state-disabled">'			 
			 +'Arrastre los campos a esta sección!!'
			 +'</p>'
			 +'</div>';
	$(this).parent('div.list-group-item').append(html);	
	refreshClick('delete-itm',deleteItmCheck);
	refreshSortable();
	contId++;
}

function showAttr(){	
	var id=$(this).parent('div.list-group-item').find('.itm-field').prop('id');
	$('#id-input').val(id);		
	tool.setId(id);
	
	$("#container-add div.list-group-item").each(function(){	
        if ( $(this).hasClass( "itm-select" ) ) {
            $(this).toggleClass('itm-select');			
        }
    });
	
	$(this).parent('div.list-group-item').toggleClass('itm-select');
	hiddenAttr();
	if($(this).parent('div.list-group-item').hasClass( "labelAttr" )){
		tool.showAttrLabel();	
	}
	if($(this).parent('div.list-group-item').hasClass( "inputAttr" )){
		tool.showAttrInput();	
	}
	if($(this).parent('div.list-group-item').hasClass( "textareaAttr" )){
		tool.showAttrTextarea();	
	}
	if($(this).parent('div.list-group-item').hasClass( "selectAttr" )){
		tool.showAttrSelect();	
	}
	if($(this).parent('div.list-group-item').hasClass( "radioAttr" )){
		tool.showAttrRadio();	
	}
	if($(this).parent('div.list-group-item').hasClass( "checkboxAttr" )){
		tool.showAttrCheckbox();	
	}
	
}

var tool= (function (){ 
    //variable global
    var id=''; 
	var valor=''; 	
    return{   
        setId:function(id2){
			id=id2;
        }, 	
        showAttrLabel:function(){			
			$("#text").toggleClass('ocultar');				
			$("#text").val($("#"+id).text());			
        },	
        showAttrInput:function(){			
			$("#value").toggleClass('ocultar');
			$("#div-required").toggleClass('ocultar');			
			$("#value").val($("#"+id).val());	
			$("#placeholder").toggleClass('ocultar');
			$("#placeholder").val($("#"+id).prop('placeholder'));
			$("#mascara").toggleClass('ocultar');	
			var valor=$("#"+id).prop('type');
			if(valor=='text'){					
				$("#mascara").val("");
			}else if(valor=='email'){					
				$("#mascara").val("email");
			}else if(valor=='date' || $('#'+id).hasClass('form_date')){//preguntar con la clase datepicker, para firefox
				$("#mascara").val("fecha");//Solucionar cuando este firefox
			}else if(valor=='number'){
				$("#mascara").val("numero");									
			}
			valor=$("#"+id).prop('pattern');
			if(valor=='\[0-9]{3}[\-]\[0-9]{3}[\-]\[0-9]{4}'){					
				$("#mascara").val("telefono");				
			}else if(valor=='^\[1-9]?[0-9]+([.]\[0-9]{3})*'){
				$("#mascara").val("moneda");
			}else if(valor=='[a-zA-Z0-9]+'){
				$("#mascara").val("direccion");				
			}else if(valor=='(\[0-9]{5}([\-]\[0-9]{4})?)'){
				$("#mascara").val("postal");
			}	
			//Es un campo obligatorio
			if ($("#"+id).prop('required')) {
				if (!$('#required').is(':checked')) {
					$('#required').prop('checked',true);
				}
			}						
        },	
        showAttrTextarea:function(){
			$("#text").toggleClass('ocultar');
			$("#div-required").toggleClass('ocultar');	
			$("#text").val($("#"+id).text());	
			$("#placeholder").toggleClass('ocultar');	
			$("#placeholder").val($("#"+id).prop('placeholder'));
			$("#fila").toggleClass('ocultar');
			$("#fila").val($("#"+id).prop('rows'));
			$("#columna").toggleClass('ocultar');
			$("#columna").val($("#"+id).prop('cols'));
			//Es un campo obligatorio
			if ($("#"+id).prop('required')) {
				if (!$('#required').is(':checked')) {
					$('#required').prop('checked',true);
				}
			}			
        },	
		showAttrSelect:function(){
			$("#itm-select").toggleClass('ocultar');
			$("#div-required").toggleClass('ocultar');	
			$("#itm").val("")
			if ( $("#"+id+' option').length > 0 ) {		
				$("#"+id+' option').each(function(){										
					addItmAttribute($(this).text());
				});
			}
			//Es un campo obligatorio
			if ($("#"+id).prop('required')) {
				if (!$('#required').is(':checked')) {
					$('#required').prop('checked',true);
				}
			}
        },
		showAttrRadio:function(){
			$("#value").toggleClass('ocultar');
			valor=$("#"+id).val();
			if(valor!='on'){
				$("#value").val($("#"+id).val());
			}				
			$("#name").toggleClass('ocultar');	
			$("#name").val($("#"+id).prop('name'));	
        },
		showAttrCheckbox:function(){
			$("#value").toggleClass('ocultar');
			valor=$("#"+id).val();
			if(valor!='on'){
				$("#value").val($("#"+id).val());
			}	
			$("#name").toggleClass('ocultar');
			$("#name").val($("#"+id).prop('name'));	
        },
        debug:function(){
            console.log(id);
        }

    }
})();

function hiddenAttr(){
	$("#menu-der").children().each(function(){		
        if ( !$(this).hasClass( "ocultar" ) && !$(this).is(":first-child")) {
            $(this).toggleClass('ocultar');
			if($(this).is('input') && $(this).prop('type')!='hidden' || $(this).is('select')){
				$(this).val('');
			}
			if($(this).is('textarea')){
				$(this).text('');
			}
        }
    });
	$("#container-itm-add").find('div.list-group-item').remove();
	if ($('#required').is(':checked')) {
		$('#required').prop('checked',false);
	}	
}

$( "#updateAttr" ).click(function() {
	var id=$('#id-input').val();
	if(id!=''){		
		setAttr.setId(id);
		if($('#'+id).is('input') && $('#'+id).prop('type')=='text' || $('#'+id).prop('type')=='email' || $('#'+id).prop('type')=='number' || $('#'+id).hasClass('form_date')){			
			setAttr.setMascara($("#mascara").val());
			setAttr.setValue($("#value").val());
			setAttr.setPlaceholder($("#placeholder").val());
			if ($('#required').is(':checked')) {
				setAttr.setRequired();
			}
		}
		if($('#'+id).is('label')){
			setAttr.setText($("#text").val());			
		}
		if($('#'+id).is('textarea')){
			setAttr.setText($("#text").val());	
			setAttr.setPlaceholder($("#placeholder").val());
			setAttr.setFila($("#fila").val());
			setAttr.setColumna($("#columna").val());
			if ($('#required').is(':checked')) {
				setAttr.setRequired();
			}
		}
		if($('#'+id).is('select')){
			setAttr.setSelectItm("container-itm-add");	
			if ($('#required').is(':checked')) {
				setAttr.setRequired();
			}			
		}
		
		if($('#'+id).is('input') && $('#'+id).prop('type')=='radio'){
			setAttr.setValue($("#value").val());
			setAttr.setName($("#name").val());			
		}
		if($('#'+id).is('input') && $('#'+id).prop('type')=='checkbox'){
			setAttr.setValue($("#value").val());
			setAttr.setName($("#name").val());				
		}
	}
});

var setAttr= (function (){ 
    //variable global
    var id='';         
    return{   
        setId:function(id2){
			id=id2;
        }, 	
        setText:function(valor){			
			$('#'+id).text(valor);			
        }, 
        setValue:function(valor){			
			$('#'+id).val(valor);			
        }, 
        setPlaceholder:function(valor){			
			$('#'+id).prop('placeholder',valor);			
        },
		setRequired:function(){	
			$('#'+id).prop('required',true);			
        },
		setMascara:function(valor){			
				$('#'+id).removeAttr("placeholder");
				$('#'+id).removeAttr("title");
				$('#'+id).removeAttr("pattern");
				$('#'+id).removeClass('form_date');
				$('#'+id).val("");
				if(valor==''){					
					$('#'+id).prop('type','text');
				}else if(valor=='email'){					
					$('#'+id).prop('type','email');
				}else if(valor=='fecha'){					
					//$('#'+id).prop('type','date');
					$('#'+id).addClass('form_date');	
					$("#"+id).datepicker(); 				
				}else if(valor=='telefono'){					
					$('#'+id).prop('type','text');					
					$('#'+id).prop('title','123-456-7890');
					$('#'+id).prop('pattern','\[0-9]{3}[\-]\[0-9]{3}[\-]\[0-9]{4}');
				}else if(valor=='numero'){
					$('#'+id).prop('type','number');									
				}else if(valor=='moneda'){
					$('#'+id).prop('type','text');					
					$('#'+id).prop('title','1.000.000');
					$('#'+id).prop('pattern','^\[1-9]?[0-9]+([.]\[0-9]{3})*');
				}else if(valor=='direccion'){
					$('#'+id).prop('type','text');					
					$('#'+id).prop('title','Alfa-Númerico');
					$('#'+id).prop('pattern','[a-zA-Z0-9]+');
				}else if(valor=='postal'){
					$('#'+id).prop('type','text');					
					$('#'+id).prop('title','nnnnn or nnnnn-nnnn');
					$('#'+id).prop('pattern','(\[0-9]{5}([\-]\[0-9]{4})?)');
				}
        },
		setFila:function(valor){
			if(valor!=''){
				$('#'+id).prop('rows',valor);
			}
        },
		setColumna:function(valor){
			if(valor!=''){
				$('#'+id).prop('cols',valor);
			}
        },
		setName:function(valor){
			if(valor!=''){
				$('#'+id).prop('name',valor);
			}
        },
		setSelectItm:function(idUl){			
			if ( $("#"+idUl+' div.list-group-item').length > 0 ) {
				$('#'+id).find('option').remove();
				$("#"+idUl).children().each(function(){
					$('#'+id).append($('<option>', { 									
										text : $(this).find('p').text() 
									}));
				});
			}
        },
        debug:function(){
            console.log(id);
        }

    }
})();

$( "#add-itm" ).click(function() {
	var valor=$("#itm").val();
	if(valor!=''){
		addItmAttribute(valor);
	}
});

function addItmAttribute(valor){
	var html='<div class="list-group-item labelAttr">'
			+'<span  class="delete-itm badge">X</span>'
			+'<p>'+valor+'</p>'
			+'</div>';
	$( "#container-itm-add" ).append(html);
	refreshClick('delete-itm',deleteItm);		
}

//Funciones sorteables
function refreshSortable(){
	$( ".sortable1" ).sortable().disableSelection();
	$( ".sortable2" ).sortable({
		connectWith: ".connectedSortable",
		cancel: ".ui-state-disabled"
	}).disableSelection();
}
refreshSortable();

//Guardar Formulario
$("#guardar").click(function() {	
	var nameForm=$("#nameForm").val();
	if(nameForm!=''){
		if($("#container-add div.list-group-item").length>0){	
			var myEl = document.querySelectorAll('#container-add');			
			if(myEl[0].childNodes[0].childElementCount>4){			
				alert('Restricción del sistema, Un elemento que contiene hijos no puede ser el primer elemento del formulario. Anteponga otro elemento, por ejemplo una etiqueta.');
			}else{
				savedItm.getItm();
				savedItm.setNameForm(nameForm);
				savedItm.postAjax();
			}			
		}else{
			alert('Ingrese almenos un elemento.');
		}
	}else{
		alert('Ingrese el nombre del formulario.');
	}
	
});

//actualizar Formulario
$("#actualizarForm").click(function() {	
	var nameForm=$("#nameForm").val();
	if(nameForm!=''){		
		if($("#container-add div.list-group-item").length>0){		
			var myEl = document.querySelectorAll('#container-add');			
			if(myEl[0].childNodes[0].childElementCount>4){	
				alert('Restricción del sistema, Un elemento que contiene hijos no puede ser el primer elemento del formulario. Anteponga otro elemento, por ejemplo una etiqueta.');
			}else{
				savedItm.getItm();
				savedItm.setNameForm(nameForm);
				savedItm.postAjax();
			}
		}else{
			alert('Ingrese almenos un elemento.');
		}
	}else{
		alert('Ingrese el nombre del formulario.');
	}
	
});

var savedItm= (function (){ 
    //variable global
    var attributes = {}; 
	var dataPost = {};
		dataPost.attributes= {};
		dataPost.nameForm= {};  
		dataPost.idForm= 0; 
	var cont=0;
	var urlPost='';
	var urlRedirect='';	
    return{ 
		setIdForm:function(id2){			
			dataPost.idForm=id2;
        },
        setUrlPost:function(url){			
			urlPost=url;
        }, 
		seturlRedirect:function(url2){			
			urlRedirect=url2;
        }, 
		setNameForm:function(nameForm){			
			dataPost.nameForm=nameForm;
        },  
        getItm:function(){
			attributes = {};			
			dataPost.attributes= {}; 
			cont=0;			
			$("#container-add").children().each(function(){
				attributes=savedItm.whoIsInput(this);
				dataPost.attributes[cont]=attributes;
				if(!$.isEmptyObject(attributes)){
					if(attributes.type=="checkbox"){
						var a=savedItm.eachContainerCheck(this);
						dataPost.attributes[cont].hijo=a;
					}					
					cont++;			
				}	
			});
        },
		whoIsInput:function(itm){
			attributes = {};
			if($(itm).find('.itm-field').is('label')){			
				attributes = {}; 
				attributes.type='label';
				attributes.text=$(itm).find('.itm-field').text();	
			} 
			if($(itm).find('.itm-field').is('input') && $(itm).find('.itm-field').prop('type')!='radio' && $(itm).find('.itm-field').prop('type')!='checkbox'){			
				attributes = {}; 
				attributes.type=$(itm).find('.itm-field').prop('type');
				attributes.placeholder=$(itm).find('.itm-field').prop('placeholder');
				attributes.value=$(itm).find('.itm-field').val();	
				attributes.pattern=$(itm).find('.itm-field').prop('pattern');
				attributes.title=$(itm).find('.itm-field').prop('title');
				var required=$(itm).find('.itm-field').prop('required');
				if(required!=' '){attributes.required=1;}
			} 
			if($(itm).find('.itm-field').is('textarea')){
				attributes = {}; 
				attributes.type="textarea";
				attributes.text=$(itm).find('.itm-field').text();	
				attributes.placeholder=$(itm).find('.itm-field').prop('placeholder');
				attributes.rows=$(itm).find('.itm-field').prop('rows');
				attributes.cols=$(itm).find('.itm-field').prop('cols');
				var required=$(itm).find('.itm-field').prop('required');
				if(required!=' '){attributes.required=1;}
			} 
			if($(itm).find('.itm-field').is('select')){
				attributes = {}; 
				attributes.type="select";	
				attributes.options={};	
				var optionText='';
				var cont2=0;
				var id=$(itm).find('.itm-field').prop('id');
				$("#"+id+' option').each(function(){
					optionText=$(this).text();					
					attributes.options[cont2]={value:optionText,text:optionText};					
					cont2++;
				});
				var required=$(itm).find('.itm-field').prop('required');
				if(required!=' '){attributes.required=1;}				
			} 
			if($(itm).find('.itm-field').is('input') && $(itm).find('.itm-field').prop('type')=='radio'){
				attributes = {}; 
				attributes.type="radio";	
				var valor=$(itm).find('.itm-field').val();	
				if(valor!='on'){
					attributes.value=valor;
				}else{
					attributes.value='';
				}	
			}
			if($(itm).find('.itm-field').is('input') && $(itm).find('.itm-field').prop('type')=='checkbox'){
				attributes = {}; 
				attributes.type="checkbox";	
				var valor=$(itm).find('.itm-field').val();	
				if(valor!='on'){
					attributes.value=valor;
				}else{
					attributes.value='';
				}		 
			}
			attributes.class=$(itm).find('.itm-field').prop('class');//Captura las clases del campo.			
			var name=$(itm).find('.itm-field').prop('name');//Captura las name del campo.	
			if(!$.isEmptyObject(name)){
				attributes.name=name;	
			}
			return attributes;
        }, 
		eachContainerCheck:function(itm){	
			var contador=0;		
			var almacenar={};			
			var id=$(itm).find('div.container-check').prop('id');
			if($("#"+id+" div.list-group-item").length>0){							
				$("#"+id).children().each(function(){					
					if($(this).is('div.list-group-item')){
						var input=savedItm.whoIsInput(this);						
						if(input.type=="checkbox"){							
							almacenar[contador]=input;//almacena checkbox							
							var a=savedItm.eachContainerCheck(this);	
							//Sale de la recursividad
							almacenar[contador].hijo=a;//almacena retorno 
						}else{
							almacenar[contador]=input;
						}						
						contador++;
					}										
				});
			}	
			return almacenar;
        },
        debug:function(){
            console.log(dataPost);
        },
		toJson:function(){
            return JSON.stringify(dataPost);
        },
		postAjax: function (){
            var retornar=false;
            $.ajax({   
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
                url:urlPost, 
                type:'POST',
                async: false,
                data: savedItm.toJson(),
				beforeSend: function () { 					
					$('#processingForm').toggleClass('ocultar');
				},
                success: function (result) {
					if(!result.state){
						Alerta('Error', result.msm,'error');
					}else{
						Alerta('Información', result.msm); 
						if(parseInt(dataPost.idForm)===0){
							pageAction.redirect(urlRedirect+"/"+result.id,2);
						}
						retornar=true;
					}
					//console.log(datos);					
                },
                error: function (request, status, error) {
                    alert('Error \n'+ 'No se pudo realizar la operación.\nRevice su conexión a Internet. \n'+' error')					
                }            
            }).done(function() {
				$('#processingForm').toggleClass('ocultar');
			});
            return retornar;            
         }
    }
})();

var openForm= (function (){ 
	var urlPost='';	
    return{ 
        setUrlPost:function(url){			
			urlPost=url;
        },
		show: function(){			
			window.open(urlPost);
        },
	}
})();

//////////////////////////////////////////////////////////////////
///////////////////////======FIN=====/////////////////////////////
//////////////////////////////////////////////////////////////////


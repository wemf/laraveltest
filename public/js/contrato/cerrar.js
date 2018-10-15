function consultarArchivo(id,pos){
    if(id != "1"){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: urlBase.make('contrato/cerrarcontrato/consultarArchivo'),
            type: 'POST',
            data: {
                id: id
            },
            success: function(datos){
                $('#nombre_archivo_'+pos).text(datos.nombre);
                $('#peso_archivo_'+pos).text(datos.tamanho);
                if(datos.tamanho != '' && datos.tamanho !== undefined){
                    $('#kb_'+pos).text('KB');
                }
            }
        })
    }
}

// $(".f1").click(function(){
//     $("#file_certificado").click();
// });

// $(".f2").click(function(){
//     $("#file_denuncia").click();
// });

// $(".f3").click(function(){
//     $("#file_incautacion").click();
// });


document.querySelector("html").classList.add('js');

var fileInput1  = document.querySelector( ".input-file1" ),  
    button1     = document.querySelector( ".f1" ),
    the_return1 = document.querySelector(".file-return1");
      
button1.addEventListener( "keydown", function( event ) {  
    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
        fileInput1.focus();  
    }  
});
button1.addEventListener( "click", function( event ) {
   fileInput1.focus();
   return false;
});  
fileInput1.addEventListener( "change", function( event ) {  
    the_return1.innerHTML = this.value;  
});  


////////////////////////////////////////////////////////////////////


var fileInput2  = document.querySelector( ".input-file2" ),  
    button2     = document.querySelector( ".f2" ),
    the_return2 = document.querySelector(".file-return2");
      
button2.addEventListener( "keydown", function( event ) {  
    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
        fileInput2.focus();  
    }  
});
button2.addEventListener( "click", function( event ) {
   fileInput2.focus();
   return false;
});  
fileInput2.addEventListener( "change", function( event ) {  
    the_return2.innerHTML = this.value;  
});  


///////////////////////////////////////////////////////////////////////


var fileInput3  = document.querySelector( ".input-file3" ),  
    button3     = document.querySelector( ".f3" ),
    the_return3 = document.querySelector(".file-return3");
      
button3.addEventListener( "keydown", function( event ) {  
    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
        fileInput3.focus();  
    }  
});
button3.addEventListener( "click", function( event ) {
   fileInput3.focus();
   return false;
});  
fileInput3.addEventListener( "change", function( event ) {  
    the_return3.innerHTML = this.value;  
});  



function reset_file(tagId,tagId2) {
        $('.'+tagId2).empty();
        document.getElementById(tagId).innerHTML =document.getElementById(tagId);
}


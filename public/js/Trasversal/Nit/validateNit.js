/*Procedimiento para el calculo del digito de verificacion de un NIT */
function  calcularDigitoVerificacion(myNit)  {
    var vpri,
        x,
        y,
        z;
    
    // Se limpia el Nit
    myNit = myNit.replace ( /\s/g, "" ) ; // Espacios
    myNit = myNit.replace ( /,/g,  "" ) ; // Comas
    myNit = myNit.replace ( /\./g, "" ) ; // Puntos
    myNit = myNit.replace ( /-/g,  "" ) ; // Guiones
    
    // Se valida el nit
    if  ( isNaN ( myNit ) )  {
      console.log ("El nit/cédula '" + myNit + "' no es válido(a).") ;
      return false ;
    };
    
    // Procedimiento
    vpri = new Array(16) ; 
    z = myNit.length ;
  
    vpri[1]  =  3 ;
    vpri[2]  =  7 ;
    vpri[3]  = 13 ; 
    vpri[4]  = 17 ;
    vpri[5]  = 19 ;
    vpri[6]  = 23 ;
    vpri[7]  = 29 ;
    vpri[8]  = 37 ;
    vpri[9]  = 41 ;
    vpri[10] = 43 ;
    vpri[11] = 47 ;  
    vpri[12] = 53 ;  
    vpri[13] = 59 ; 
    vpri[14] = 67 ; 
    vpri[15] = 71 ;
  
    x = 0 ;
    y = 0 ;
    for  ( var i = 0; i < z; i++ )  { 
      y = ( myNit.substr (i, 1 ) ) ;
      x += ( y * vpri [z-i] ) ;
    }  
    y = x % 11 ;
    return ( y > 1 ) ? 11 - y : y ;
}
///////////////////////////////////////////////////////////////////////////////////////////
/*Funcion para restringir escritura de solo numeros y validacion del formato de un nit*/
///////////////////////////////////////////////////////////////////////////////////////////

var nitAction= (function (){  
    return{ 
        replace:function(value2){              
            var expresion1=/[^\d]/g          
            return value2.replace(expresion1, "");
        },
        replace2:function(value2){  
            var expresion1=/^(\d+)(-\d{1,2})/         
            return value2.replace(expresion1, "$1");
                
        }       
    }
})();
///////////////////////////////////////////////////////////////////////////////////////////
/*
Utilice cuando se quiera que genere el dígito de validacion en el mismos input
Ejemplo de implementación:
    <input type="text" class="digito-verificacion">
*/
///////////////////////////////////////////////////////////////////////////////////////////

$(".digito-verificacion").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value ) {            
            return nitAction.replace(value);
        });
    },   
    "blur": function (event) {
        $(event.target).val(function (index, value ) {            
            return nitAction.replace2(value);
        });             
        $('#tool').remove();
        var nit=$(this).val();       
        var numVerificacion=calcularDigitoVerificacion(nit);
        if(numVerificacion!=false){       
            $(this).val(nit+"-"+numVerificacion);
        }else{
            $(this).val('');          
            $(this).after(`<div class="tool tool-visible" id="tool" style="clear:both">
                                <p>El nit/cédula ${nit} no es válido(a)</p>
                           </div>`);
        }
    }
}); 

///////////////////////////////////////////////////////////////////////////////////////////
/*
Utilice cuando se quiera validar y digitar el dígito de verificacón.
Ejemplo de implementación:
HTML:
    <div class="input-group">
        <input type="text" class="form-control nit" required>
        <span class="input-group-addon white-color"><input id="prueba" type="text" class="nit-val" required></span>
    </div>
BLADE:
    @include("Trasversal.Nit.validateNit")
*/
///////////////////////////////////////////////////////////////////////////////////////////

$(".nit").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value ) {            
            return nitAction.replace(value);
        });
    } 
}); 

$(".nit-val").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value ) {            
            return nitAction.replace(value);
        });
    },
    "blur": function (event) {
        $(event.target).val(function (index, value ) {            
            return nitAction.replace(value);
        });             
        $('#tool').remove();
        var nit=$(this).parent().parent().find(".nit").val();       
        var numVerificacion=calcularDigitoVerificacion(nit);
        var digito=$(this).val();
        //console.log(nit);
        //console.log(numVerificacion);
        if(numVerificacion!=false && digito==numVerificacion){       
            //alert("vamos bien");
        }else{
            $(this).val('');          
            $(this).parent().parent().after(`<div class="tool tool-visible" id="tool" style="clear:both">
                                        <p>El dígito de verificación ${digito} para el Nit ${nit} no es válido, por favor revise.</p>
                                   </div>`);
        }
    } 
}); 






$(".moneda").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value ) {            
            return money.replace(value);
        });
    },
    "blur": function (event) {
        $(event.target).val(function (index, value ) {            
            return money.replace(value);
        });
    }
}); 

var money= (function (){   
    //Valores generales
    var gen={};
        //Numero decimal
        gen.numDecimal=2;
        //Separador decimal
        gen.sepDecimal=",";
        //Separador de miles
        gen.sepMil="."

    var expresion={};
        expresion.uno="";
        expresion.dos="";
        expresion.tres="";
        expresion.cuatro="";
        expresion.cinco="";

    return{ 
        changeSimbolo:function(value2){ 
            $('.simbolo_tipo_moneda').html(value2); 
        },
        setNumDecimal:function(value2){  
            gen.numDecimal=value2;
        },
        setSepDecimal:function(value2){  
            gen.sepDecimal=value2;
        },
        setSepMil:function(value2){  
            gen.sepMil=value2;
        },
        getNumDecimal:function(){
            return gen.numDecimal;
        },
        replace:function(value2){  
            /*Validaciones generales*/ 
            //No se ingresa , al comienzo
            //No se ingresa dos ,, 
            //Solo puede ingresar  numeros y una coma  
            var a=/^sepDecimal|sepDecimal{2,}|-{2,}|[^\-\dsepDecimal]|(\d\-+)+/g
            //expresion.uno=/^,|,{2,}|[^\d\,]/g   
            expresion.uno=new RegExp(a.source.replace(/sepDecimal/g, gen.sepDecimal),'g');
            /*Valida que no ingrese dos comas, ejemplo: 12,5,5 (no se permite)*/ 
            a=/([0-9]+sepDecimal[0-9]+)(sepDecimal)$/  
            //expresion.dos=/([0-9]+,[0-9]+)(,)$/   
            expresion.dos=new RegExp(a.source.replace(/sepDecimal/g, gen.sepDecimal)); 
            /*Formatea el numero y pone el punto (.) decimal*/  
            //Controla que no aplique la separacion de miles, si encuentra una coma (,) 
            // var isComa=/,/g
            // if(isComa.test(value2)){
            //     expresion.tres=/ /
            // } else{
                a=/\B(?=(\d{3})+(?!\d)\sepMil?)/g  
            //     //expresion.tres=/\B(?=(\d{3})+(?!\d)\.?)/g 
                expresion.tres=new RegExp(a.source.replace(/sepMil/g, gen.sepMil),'g');   
            // }             
            /*Valida que no ingrese cero seguido de un numero, ejemplo:01*/     
            a=/(^[0+sepMil]+)(?=\d{1,9})/g   
            //expresion.cuatro=/(^[0+.]+)(?=\d{1,9})/g    
            expresion.cuatro=new RegExp(a.source.replace(/sepMil/g, gen.sepMil),'g');    
            /*Valida que sea dos digitos decimales, ejemplo: ,20*/   
            a=/(sepDecimal\d{numDecimal})((sepMil?\dsepMil?)+$)/ 
            //expresion.cinco=/(,\d{2}) ((.?\d.?)+$)/   
            expresion.cinco=new RegExp(a.source.replace(/sepMil/g, gen.sepMil).replace(/sepDecimal/g, gen.sepDecimal).replace(/numDecimal/g, gen.numDecimal));     
                 
            return value2.replace(expresion.uno, "") 
                         .replace(expresion.dos, '$1') 
                         .replace(expresion.tres, gen.sepMil)
                         .replace(expresion.cuatro, "")
                         .replace(expresion.cinco, "$1");
        },        
        debug:function(){                        
            console.log(gen);    
            console.log(expresion);        
        }
    }
})();

var money_old= (function (){   
    var gen={};
        gen.numDecimal=2;
        gen.sepDecimal=',';
        gen.sepMil='.';
    return{ 
        changeSimbolo:function(value2){ 
            $('.simbolo_tipo_moneda').html(value2); 
        },
        setNumDecimal:function(value2){  
            gen.numDecimal=value2;
        },
        setSepDecimal:function(value2){  
            gen.sepDecimal=value2;
        },
        setSepMil:function(value2){  
            gen.sepMil=value2;
        },
        replace:function(value2){   
            /*Validaciones generales*/ 
            //No se ingresa , al comienzo
            //No se ingresa dos ,, 
            //Solo puede ingresar  numeros y una coma  
            var expresion1=/^,|,{2,}|[^\-\d\,]|(\d\-+)+/g 
            /*Valida que no ingrese dos comas, ejemplo: 12,5,5 (no se permite)*/    
            var expresion2=/([0-9]+,[0-9]+)(,)$/  
            /*Formatea el numero y pone el punto (.) decimal*/  
            //Controla que no aplique la separacion de miles, si encuentra una coma (,) 
            var isComa=/,/g
            if(isComa.test(value2)){
                //var expresion3=/ /
            } else{
                var expresion3=/\B(?=(\d{3})+(?!\d)\.?)/g 
            }  
            /*Valida que no ingrese cero seguido de un numero, ejemplo:01*/     
            var expresion4=/(^[0+.]+)(?=\d{1,9})/g   
           /*Valida que sea dos digitos decimales, ejemplo: ,20*/     
            var expresion5=/(,\d{2})((.?\d.?)+$)/    
            return value2.replace(expresion1, "") 
                         .replace(expresion2, '$1') 
                         .replace(expresion3, ".")
                         .replace(expresion4, "")
                         .replace(expresion5, "$1");
        }       
    }
})();

$(".moneda").each(function(){
    $(this).val(money.replace($(this).val()));
});

//Ejemplo de implentacion en el HTML
/*
//Desde el html nativo
<div class="input-group">
    <span class="input-group-addon">$</span>
    <input type="text" class="moneda form-control centrar-derecha" aria-label="Amount (to the nearest dollar)">
</div>
//Usando Laravel
 @include('Trasversal.Moneda.tipo')
 */
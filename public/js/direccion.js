var direccion= (function (){ 
    var pos0 = '';
        pos1 = '';
        pos2 = '';
        pos3 = '';
        pos4 = '';
        pos5 = '';
        pos6 = '';
        pos7 = '';
        pos8 = '';
        pos9 = '';
        pos10 = '';
        posIn = '';
        array = {};
    var contador=0;
    return{ 
        setPosIn:function(posIn2){
            posIn = posIn2;
        },
        setPos0:function(pos2){
            pos0 = pos2;
        },
        setArray:function(array2){
            array = array2;
        },
        setpos1:function(url2){
            pos1 = url2;
        },
        setpos2:function(url2){
            pos2 = url2;
        },
        setpos3:function(url2){
            pos3 = url2;
        },
        setpos4:function(url2){
            pos4 = url2;
        },
        setpos5:function(url2){
            pos5 = url2;
        },
        setpos6:function(url2){
            pos6 = url2;
        },
        setpos7:function(url2){
            pos7 = url2;
        },
        setpos8:function(url2){
            pos8 = url2;
        },
        setpos9:function(url2){
            pos9 = url2;
        },
        setpos10:function(url2){
            pos10 = url2;
        },
        getpos1:function(url2){
            return pos1;
        },
        getpos2:function(url2){
            return pos2;
        },
        getpos3:function(url2){
            return pos3;
        },
        getpos4:function(url2){
            return pos4;
        },
        getpos5:function(url2){
            return pos5;
        },
        getpos6:function(url2){
            return pos6;
        },
        getpos7:function(url2){
            return pos7;
        },
        getpos8:function(url2){
            return pos8;
        },
        getpos9:function(url2){
            return pos9;
        },
        getpos10:function(url2){
            return pos10;
        },
        getPosIn:function(url2){
            return posIn;
        },
        getArray:function(){
            return array;
        },
        getPos0:function(){
            return pos0;
        },
        getContador:function(){
            return contador++;
        },
        show:function(id,posIn){
            $('.modal-confirm-direccion').addClass('confirm-visible').removeClass('confirm-hide');
            direccion.setPos0(id);
            direccion.setPosIn(posIn);
        },
        hide:function(){
            $('.modal-confirm-direccion').addClass('confirm-hide').removeClass('confirm-visible');
        },
    }
})();

$('.confirmDir').click(function(){
    direccion.setpos1($('#via').val());
    direccion.setpos2($('#numero').val());
    direccion.setpos3($('#letracruce1').val());
    direccion.setpos4($('#puntocardinal1').val());
    direccion.setpos5($('#interseccion').val());
    direccion.setpos6($('#letracruce2').val());
    direccion.setpos7($('#puntocardinal2').val());
    direccion.setpos8($('#numero2').val());
    direccion.setpos9($('#puntocardinal3').val());
    direccion.setpos10($('#numero3').val());

    var p1 = direccion.getpos1();
    var p2 = direccion.getpos2();
    var p3 = direccion.getpos3();
    var p4 = direccion.getpos4();
    var p5 = direccion.getpos5();
    var p6 = direccion.getpos6();
    var p7 = direccion.getpos7();
    var p8 = direccion.getpos8();
    var p9 = direccion.getpos9();
    var p10 = direccion.getpos10();
    var arrayPush = direccion.getArray();
    var cont = direccion.getContador();
    var id = direccion.getPos0();
    var posinput = $('#'+id).data('pos');

        arrayPush[posinput] = {
            p1: p1,
            p2: p2,
            p3: p3,
            p4: p4,
            p5: p5,
            p6: p6,
            p7: p7,
            p8: p8,
            p9: p9,
            p10: p10
        }
        direccion.setArray(arrayPush);
        $('#'+id).val($('#resultado').val());
        $('#resultado').val("");
        $('#via').val("");
        $('#numero').val("");
        $('#letracruce1').val("");
        $('#puntocardinal1').val("");
        $('#interseccion').val("");
        $('#letracruce2').val("");
        $('#puntocardinal2').val("");
        $('#numero2').val("");
        $('#puntocardinal3').val("");
        $('#numero3').val("");

    $('.modal-confirm-direccion').addClass('confirm-hide').removeClass('confirm-visible');
});

$('.direccion').click(function(){
    var id = $(this).prop('id');
    var posinput = $('#'+id).data('pos');
    direccion.show(id,posinput);
    $('#resultado').val($(this).val());

    if(direccion.getArray()[posinput]  != undefined){
        
        var arrayPush = direccion.getArray()[posinput];
        $('#via').val(arrayPush['p1']);
        $('#numero').val(arrayPush['p2']);
        $('#letracruce1').val(arrayPush['p3']);
        $('#puntocardinal1').val(arrayPush['p4']);
        $('#interseccion').val(arrayPush['p5']);
        $('#letracruce2').val(arrayPush['p6']);
        $('#puntocardinal2').val(arrayPush['p7']);
        $('#numero2').val(arrayPush['p8']);
        $('#puntocardinal3').val(arrayPush['p9']);
        $('#numero3').val(arrayPush['p10']);
    }

});

$("#confirmSuccess").on('click',function(){
    $($("#idmodal").val()).val($('#resultado').val());
    $('.modal-confirm').addClass('confirm-hide').removeClass('confirm-visible');
});

$('.numeric').each(function(){
    $(this).keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
});

function direction() {
    var pos1 = $('#via').val();
    var pos2 = $('#numero').val();
    var pos3 = $('#letracruce1').val();
    var pos4 = $('#puntocardinal1').val();
    var pos5 = $('#interseccion').val();
    var pos6 = $('#letracruce2').val();
    var pos7 = $('#puntocardinal2').val();
    var pos8 = $('#numero2').val();
    var pos9 = $('#puntocardinal3').val();
    var pos10 = $('#numero3').val();
    if(pos1 === null) pos1 = "";
    $('#resultado').val(pos1 + " " + pos2 + " " + pos3 + " " + pos4 + " # " + pos5 + " " + pos6 + " " + pos7 + " " + pos8 + " " + pos9 + " " + pos10);
}

$('.dir').each(function(){
    var elemen = $(this).prop('id');
    $("#"+elemen).on('keyup',function(){
        direction();
    });
    $("#"+elemen).change(function(){
        direction();
    });
    $("#"+elemen).on('focus',function(){
        direction();
    });
});

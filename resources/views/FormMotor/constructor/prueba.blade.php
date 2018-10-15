<html>
<head>
<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="  crossorigin="anonymous"></script>
<style>
.ocultar{
    display: none;
}
</style>
</head>
<body>
Hola Prueba: Hijos de los hijos!!
<div class='container-check'>
    <input type="checkbox" id="cbox1" class="check" value="1"></input>
    <br>
    <label id="1" class="1">Hola 1 -</label>
    <br>
    <label id='2' class="2">Hola 2 -</label>
    <div class='container-check'>
        <input type="checkbox" id="cbox2" class="check" value="1"></input>
        <br>
        <label id="3" class="1">Hola 3 -</label>
        <br>
        <label id='4' class="2">Hola 4 -</label>
        <div class='container-check'>
            <input type="checkbox" id="cbox3" class="check" value="1"></input>
            <br>
            <label id="5" class="5">Hola 5 -</label>
            <br>
            <label id='6' class="5">Hola 6 -</label>
        </div>
    </div>
</div>

<script>
$( ".check" ).change(function() {
    $(this).parent('div.container-check').children().each(function(){ 
        if ( !$(this).is(":first-child") ) {
            $(this).toggleClass('ocultar');
        }
    });
});
function ocultar(){    
    $("div.container-check").children().each(function(){ 
        if ( !$(this).is(":first-child") ) {
            $(this).toggleClass('ocultar');            
        }
    });
}
ocultar() 
</script>
</body>
</html>

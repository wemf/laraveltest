/*
  JavaScript  donde ponemos las mascaras de el aplicativo
  Estas mascaras se aplican por medio de las clases. 

*/ 

//  Mascara de IP 
//  Esta funcion funciona mediante pattern así que requiere un evento submmit para disparar el evento
$('.maskIp').attr('pattern','[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}');
$('.maskIp').attr('title','Formato de IP invalido.\nEjemplo: 127.0.0.1\nEjemplo: 255.255.255.255');


//mascara de Telefono
//  Esta funcion funciona mediante pattern así que requiere un evento submmit para disparar el evento
$('.maskTelefono').attr('pattern','[0-9]{7,10}');
$('.maskTelefono').attr('title','Formato de Tienda invalido, minimo 8 digitos, maximo 10.\nEjemplo: 3048572186 \nEjemplo: 5485752 ');

//Mascara de Indicativo de telefono.
$('.maskIndicativoDepartamento').attr('pattern','[0-9]{1}');
$('.maskIndicativoDepartamento').attr('title','Los indicativos solo tienen un dígito.');
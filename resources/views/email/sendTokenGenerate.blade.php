<p>Hola, {{$user->name}}</p>

<p>Para iniciar sesión ingrese el siguiente Token: </p>

<b>{{$user->verify_token}}</b>

<p>Este Token tiene una vigencia de 15 minutos, pasado este tiempo debe solicitar nuevamente un nuevo Token.</p>

<img src="{{asset('images/Plantilla-Planeta-Planta.png')}}"/>
<p><em>Antes de imprimir este correo electrónico, piense bien si es necesario hacerlo: El medio ambiente es cuestión de todos.<br>Por favor no responder este correo.</em></p>
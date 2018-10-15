<h1>Hola</h1>

<p>
    Por favor realice click en el siguiente vínculo para la activacion de la cuenta.

    <a href="{{ url('/activate') }}/{{$user->email}}/{{$code}}" >Activar Cuenta</a>
</p>
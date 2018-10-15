<h1>Hola</h1>

<p>
    Por favor realice click en el siguiente vínculo para restablecer la contraseña.

    <a href="{{ url('/reset') }}/{{$user->email}}/{{$code}}" >Restablecer</a>
</p>
<p>Hola, {{$user->name}}</p>

<p>Haga Click el siguiente link para iniciar sesión.</p>

<p><a href="{{route('loginToken',['email'=>$user->email,'verifyToken'=>$user->verify_token])}}">Iniciar Sesión</a></p>

<p>Este Link tiene una vigencia de 15 minutos, pasado este tiempo debe solicitar nuevamente un nuevo link.</p>

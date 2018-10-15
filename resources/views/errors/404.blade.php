@extends('layouts.errors')

@section('content') 

    <div class="contain-error">
        <h1 class="message-error">Oops!</h1>
        <br>
        <p class="details-error">Ha ocurrido un error, inténtelo nuevamente o contacte con el administrador.</p>
        <!-- <br>
        <p class="details-error">Por favor para ir al inicio de Sinnut, precione clic en el botón de abajo.</p>
        <br><br>
        <a class="button-home" href="{{ url('home') }}">Inicio Sinnut</a> -->
    </div>


    <script>
        setTimeout((function(){ window.location = "{{ url('home') }}"; }), 10000);
    </script>
@endsection
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    <title>Nutibara</title>    
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
    <link href="{{asset('css/errors.css')}}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
</head>
<body class="login">
    <header>
        <div class="site_title">
            <img src="{{ asset('images/logo.png') }}" width="45px" />
            <span>SINNUT</span>
        </div>
    </header>
    <div class="content">        
        @yield('content') 
    </div>
</body>
<script src="{{asset('/plugins/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('/plugins/bootstrap-3.3.7-dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/plugins/pnotify.custom.min.js')}}"></script>
<script src="{{asset('/plugins/progressbarr.min.js')}}"></script>
<script src="{{asset('/js/web.js')}}"></script>
</html>
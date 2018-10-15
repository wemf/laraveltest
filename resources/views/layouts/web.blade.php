<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    <title>Nutibara</title>    
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />        
    <link href="{{asset('/plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/css/pnotify.custom.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet" />
    <link href="{{asset('plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
</head>
<body class="login">
    <div class="menu-toggler sidebar-toggler"></div>
    <div class="logo">	
       <!--<img src="{{asset('img/logo-dataware.png')}}" alt="" style="height:150px; max-width: 100%;">-->
    </div>
    <div class="content">        
        @yield('content') 
    </div>
    <div class="copyright container">
        2017 © AlgarTech. Nutibara
    </div>
</body>
<script src="{{asset('/plugins/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('/plugins/bootstrap-3.3.7-dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/plugins/pnotify.custom.min.js')}}"></script>
<script src="{{asset('/plugins/progressbarr.min.js')}}"></script>
<script src="{{asset('/js/web.js')}}"></script>
<script>
    @if(Session::has('message'))
        Alerta('Información', "{{ Session::get('message') }}")
    @endif
    @if(Session::has('error'))
        Alerta('Error', "{{ Session::get('error') }}",'error')
    @endif
    @yield('javascript')
</script>
</html>
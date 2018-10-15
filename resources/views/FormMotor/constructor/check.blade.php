<html>
<head>
    <title>Motor v2.0</title>    
    <script src="{{asset('/plugins/jquery-3.1.1.min.js')}}"></script> 
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />  
    <link href="{{asset('/css/datepickerJquery.css')}}" rel="stylesheet" />
    <link href="{{asset('/css/formMotorCheck.css')}}" rel="stylesheet" />
    {{-- <link href="{{asset('/plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css')}}" rel="stylesheet" /> --}}

</head>
<body>
    <div class="container">
        <h1> {{$nameForm}} </h1>
        <form action="javascript:void(0);">
            {!!html_entity_decode($form)!!}
            <button type="submit">Guardar</button>
        </form>   
    </div>
    <script src="{{asset('/js/formMotorCheck.js')}}"></script>    
</body>
</html>

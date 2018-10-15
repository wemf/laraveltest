<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="{{ asset('images/ficon.png') }}" />
  <link href="{{asset('/css/pnotify.custom.min.css')}}" rel="stylesheet" />
  <link href="{{asset('/css/confirm.css')}}" rel="stylesheet" />
  <link href="{{asset('/css/direccion.css')}}" rel="stylesheet" />
  <link href="{{asset('/css/tool.css')}}" rel="stylesheet" />
  <link href="{{asset('/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet" />
  <link href="{{asset('plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
  <!--select multiple-->
  <link href="{{asset('plugins/searchable-option-list-master/sol.css')}}" rel="stylesheet" />
  <!--End select multiple-->
  <!--DataTable-->
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/datatable/DataTables-1.10.13/css/jquery.dataTables.min.css')}}"
  />
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/datatable/Responsive-2.1.0/css/responsive.dataTables.min.css')}}"
  />
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/datatable/Scroller-1.4.2/css/scroller.dataTables.min.css')}}"
  />
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/datatable/Select-1.2.0/css/select.dataTables.min.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.multiselect.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/MultiSelect/css/multi-select.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('css/web.css')}}" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!--End_DataTable-->
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--Migas de Pan-->
  <link rel="stylesheet" type="text/css" href="{{asset('css/migas_pan/migas.css')}}" />
  <title>Nutibara</title>
  <!-- Bootstrap -->
  <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
  <!-- iCheck -->
  <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
  <!-- bootstrap-progressbar -->
  <link href="{{ asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
  <!-- JQVMap -->
  <link href="{{ asset('vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" />
  <!-- bootstrap-daterangepicker -->
  <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/default.css') }}" rel="stylesheet"> @yield('head')
</head>
<body class="nav-md">
  <!-- <div class="loading-gif">
    <table class="loading-master" cellspacing="0">
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
  </div> -->
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col menu_fixed">
        <div class="left_col scroll-view" style="width: 100% !important;">
          <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('/home') }}" class="site_title">
              <img src="{{ asset('images/logo.png') }}" width="45px" />
              <span>SINNUT</span>
            </a>
          </div>
          <div class="clearfix"></div>
          <!-- menu profile quick info -->
          <!-- <div class="profile clearfix">
            <div class="profile_pic">
            </div>
            <div class="profile_info">
              <span>Bienvenido,</span>
              <h2>{{Auth::user()->name}}</h2>
            </div>
          </div> -->
          <!-- /menu profile quick info -->
          <br/> @include('layouts.menuPrincipal')
        </div>
      </div>
      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle">
                <i class="fa fa-bars"></i>
              </a>
            </div>
            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <div class="datos-usuario">
                    <p style="display: inline-block;">{{Auth::user()->name}}</p> / 
                    <p style="display: inline-block;">{{Auth::user()->role->nombre}}</p>
                  </div>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li>
                    <a href="javascript:;"> Perfil</a>
                  </li>
                  <li>
                    <a href="javascript:;">
                      <span class="badge bg-red pull-right">50%</span>
                      <span>Ajustes</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:;">Ayuda</a>
                  </li>
                  <li>
                    <a onclick="document.getElementById('logout-form').submit()">
                      <i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a>
                  </li>
                </ul>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
              @include('layouts.notificacion')
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->
      <!-- page content -->
      <div class="right_col" role="main">
        @yield('content')
      </div>
      <!-- /page content -->
      <!-- footer content -->
      <footer>
        <div class="pull-right footer">
          SINNUT /@if(isset(tienda::OnLine()->nombre)) {{strtoupper(tienda::OnLine()->nombre)}}@else SIN TIENDA @endif
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>
  </div>
  <!--  Modal de Confirmación  -->
  @include('layouts.confirm')
  <!--  Modal de Confirmación  -->
  <!--  Modal de direccion  -->
  @include('layouts.direccion')
  <!--  Modal de direccion  -->
  <!-- jQuery -->
  <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('vendors/validator/validator.js') }}"></script>
  <script>
  @yield('javascriptpr')
  </script>
  <!-- Librería para input tipo datapicker -->
  <script src="{{asset('js/jquery.datetimepicker.full.js')}}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
  <!-- NProgress -->
  <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
  <!-- Chart.js -->
  <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
  <!-- gauge.js -->
  <script src="{{ asset('vendors/gauge.js/dist/gauge.min.js') }}"></script>
  <!-- bootstrap-progressbar -->
  <script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
  <script src="{{asset('/plugins/pnotify.custom.min.js')}}"></script>
  <script src="{{asset('js/jquery.multiselect.js')}}"></script>
  <script src="{{asset('js/maskedinput.js')}}"></script>
  <!-- iCheck -->
  <script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
  <!-- Skycons -->
  <script src="{{ asset('vendors/skycons/skycons.js') }}"></script>
  <!-- Flot -->
  <script src="{{ asset('vendors/Flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
  <script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
  <!-- Flot plugins -->
  <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
  <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
  <script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>
  <!-- DateJS -->
  <script src="{{ asset('vendors/DateJS/build/date.js') }}"></script>
  <!-- JQVMap -->
  <script src="{{ asset('vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
  <script src="{{ asset('vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
  <script src="{{ asset('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <!-- Custom Theme Scripts -->
  <script src="{{ asset('build/js/custom.js') }}"></script>
  <script src="{{asset('/plugins/progressbarr.min.js')}}"></script>
  <!--datetimepicker-->
  <script src="{{asset('/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js')}}"></script>
  <script src="{{asset('/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js')}}"></script>
  <!--End_datetimepicker-->
  <!--select multiple-->
  <script src="{{asset('/plugins/searchable-option-list-master/sol.js')}}"></script>
  <!--End select multiple-->
  <!--DataTable-->
  <script type="text/javascript" src="{{asset('/plugins/datatable/DataTables-1.10.13/js/jquery.dataTables.js')}}"></script>
  <script type="text/javascript" src="{{asset('/plugins/datatable/Responsive-2.1.0/js/dataTables.responsive.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('/plugins/datatable/Scroller-1.4.2/js/dataTables.scroller.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('/plugins/datatable/Select-1.2.0/js/dataTables.select.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('/plugins/MultiSelect/js/jquery.multi-select.js')}}"></script>
  <!--End_DataTable-->
  <script type="text/javascript" src="{{ asset('/plugins/pnotify.custom.min.js') }}"></script>
  <script src="{{asset('/js/web.js')}}"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!--notificacion-->
  <script type="text/javascript" src="{{asset('/js/notificacion/notificacion.js')}}"></script>
  <!--notificacion-->
  <!--direccion-->
  <script type="text/javascript" src="{{asset('/js/direccion.js')}}"></script>
  <!--direccion-->
  <!-- Mask -->
  <script type="text/javascript" src="{{asset('/js/masks.js')}}"></script>
  <!-- Mask -->
  <!--Modal Confirm-->
  <script type="text/javascript" src="{{asset('/js/confirm.js')}}"></script>
  <script type="text/javascript" src="{{asset('/js/tool.js')}}"></script>
  <!--Migas de Pan-->
  <script src="{{asset('/js/migas_pan/migas.js')}}"></script>
  <!--Modal Confirm-->
  <!--Tipo de moneda General -->
  <script src="{{asset('js/Trasversal/Moneda/tipo.js')}}"></script>
  <!--Validacion nit -->
  <script src="{{asset('js/Trasversal/Nit/validateNit.js')}}"></script> 
  <script>
    urlBase.setBase("{{ url('/') }}");
  </script>
  @stack('scripts')
  <script>
  @if (Session:: has('return_redirect'))
  setTimeout(function () { location.href = urlBase.make("{{ Session::get('return_redirect') }}"); }, 3000);
  
  @endif

    @if (Session:: has('message'))
    Alerta('Información', "{{ Session::get('message') }}")
    @endif
    @if (Session:: has('error'))
    Alerta('Error', "{{ Session::get('error') }}", 'error')
    @endif
    @if (Session:: has('warning'))
    Alerta('Alerta', "{{ Session::get('warning') }}", 'warning')
    @endif
    @if (count($errors)>0)
      @foreach($errors->all() as $error)
          Alerta('Error', "{{$error}}", 'error');
      @endforeach
    @endif
    @yield('javascript')
    noti.setUrlGet("{{route('mensajes.get')}}");
    noti.setUrlVito("{{ route('mensajes.get.id') }}");
    noti.setUrlBase("{{ url('/') }}");
    //Configuracion global de moneda
    @inject('moneda', 'App\TipoMoneda')
    money.changeSimbolo('{{$moneda->getByPais()->simbolo_tipo_moneda}}');
    money.setNumDecimal('{{$moneda->getByPais()->decimales}}');
    money.setSepDecimal('{{$moneda->getByPais()->separador_decimal}}');
    money.setSepMil('{{$moneda->getByPais()->separador_mil}}');
    
    $(window).load(function(){
      $('.loading-gif').addClass('hide');
    });

    </script>

</body>
</html>
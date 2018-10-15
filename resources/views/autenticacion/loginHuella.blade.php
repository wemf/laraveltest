<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nutibara  | Login</title>
    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('vendors/animate.css/animate.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/autenticacion/login.css') }}" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/ficon.png') }}"/>
  </head>
  <body class="login">
      <div class="login_wrapper">
        <div class="animate form login_form"> 	
				<input type="radio" class="hide" id="r-form-huella" name="r-form" checked>
				<input type="radio" class="hide" id="r-form-documento" name="r-form">
				<input type="radio" class="hide" id="r-form-token" name="r-form">
				@include('message')
				<div class="row autenticacion">
					<div class="col-md-6 col-xs-5 col-xs-offset-1 col-md-offset-0 ">
						<label for="r-form-huella" id="btn-huella" class="circulos">
							<img src="{{ asset('images/fingerprint.svg') }}" />
						</label>
					</div>
					<div class="col-md-6 col-xs-5 col-md-offset-0">
						<label for="r-form-documento" id="btn-documento" class="circulos">
							<img src="{{ asset('images/cedula.svg') }}" />
						</label>
					</div>
				</div>
				<div class="row">
				<div class="col-md-12 col-xs-12">
					<div id="formulario-documento">						
						<form class="formulario"  method="POST"  action="{{route('generateToken.create')}}" >		
							 {{ csrf_field() }}  
              <h3 class="center">Autenticar con Documento</h3>						
							<div class="form-group">
								<label for="tipoDocumento">Tipo Documento</label>					
								<select class="form-control" name="tipoDocumento" required>
								    <option value>- Seleccione una opción -</option>
                    @foreach ($tipoDocumentos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach									
								</select>
							</div>
							<div class="form-group">
								<label for="documento">Documento</label>
								<input type="number" name="documento" class="form-control"  placeholder="Documento" maxlength="15" required>
							</div>
							<div class="form-group center">
								<button id="btn-login" type="submit" class="btn btn-primary">Generar Token</button>
								<button type="reset" class="btn btn-danger">Restablecer</button>
							</div>
              <div class="center">
                <div class="btn btn-link"><label for="r-form-token">Ingresar Token</label></div>
              </div>
						</form>					
					</div>
					<div id="formulario-huella">						
						<form class="center formulario">						
							<h3 >Autenticar con Huella</h3>
							<img  src="{{ asset('images/huella_digital.svg') }}">
						</form>					
					</div>
          <div id="formulario-token">						
						<form class="formulario"  method="POST"  action="{{route('loginToken.email')}}" >		
							 {{ csrf_field() }}  
              <h3 class="center">Autenticar con Token</h3>
							<div class="form-group">
								<label for="documento">Token</label>
								<input type="text" name="token" class="form-control" name="token"  placeholder="Ingrese Token" maxlength="15" required>
							</div>
							<div class="form-group center">
								<button id="btn-token" type="submit" class="btn btn-primary">Iniciar Sesión</button>
								<button type="reset" class="btn btn-danger">Restablecer</button>
							</div>
              <div class="center">
                <div class="btn btn-link"><label for="r-form-documento"><i class="fa fa-angle-left" aria-hidden="true"></i> Regresar</label></div>
              </div>
						</form>					
					</div>
				</div>
				</div>
                <div class="clearfix"></div>
                <div class="separator center">
                    <div class="clearfix"></div>    
                    <div>
					<h1><b>Iniciar Sesión</b></h1>    
                    <h1><img src="{{ asset('images/ficon.png') }}" width="45px" /> Nutibara</h1>
                    <p>©2017 Todos Los Derechos Reservados.</p>
                    </div>
                </div>        
          </section>
        </div>
      </div>  
  </body> 
<!-- jQuery -->
<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Logn -->
<script src="{{asset('/js/autenticacion/login.js')}}"></script>
</html>
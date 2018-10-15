@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">         
                @if(Session::has('message'))    
                    <div class="alert alert-info">             
                        {{ Session::get('message') }}      
                    </div>                     
                @endif
                @if(Session::has('error'))  
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>   
                @endif
                @if(Session::has('warning'))  
                    <div class="alert alert-warning">
                        {{ Session::get('warning') }}
                    </div>   
                @endif
                <div class="panel-heading">Nuevo Usuario</div>
                <div class="panel-body">
                    <form id="form-user" class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('id_role') ? ' has-error' : '' }}">
                            <label for="id_role" class="col-md-4 control-label">Rol</label>
                            <div class="col-md-6">
                                <select type="text" class="form-control" id="id_role" name="id_role"  value="{{ old('id_role') }}" required autofocus></select>
                                @if ($errors->has('id_role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id_role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombres</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <button class="btn btn-primary" type="reset">Restablecer</button>
                                <a href="{{route('users')}}" class="btn btn-danger" type="button">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/autenticacion/administrator/users.js')}}"></script>
@endpush

@section('javascript') 
    URL.setRoles("{{route('roles')}}");
    USERS.loadRol();  
@endsection
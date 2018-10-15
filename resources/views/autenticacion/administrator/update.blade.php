@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-xs-12 ">
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
                <div class="panel-heading">Actualizar Usuario</div>
                <div class="panel-body">
                    <form id="form-user" class="form-horizontal" method="POST" action="{{ url('/users/update') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="form-group{{ $errors->has('id_role') ? ' has-error' : '' }}">
                            <label for="id_role" class="col-md-4 control-label">Rol <span class="red">*</span></label>
                            <div class="col-xs-12 col-md-6 ">
                                @if ($errors->has('id_role'))
                                    <select type="text" class="form-control" id="id_role" name="id_role" value="{{ old('id_role') }}" required autofocus></select>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id_role') }}</strong>
                                    </span>
                                @else
                                    <select type="text" class="form-control" id="id_role" name="id_role" required autofocus></select>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_role" class="col-md-4 control-label">Modo de ingreso <span class="red">*</span></label>
                            <div class="col-xs-12 col-md-6">
                                <select id="modo_ingreso" name="modo_ingreso" class="form-control" required="required">
                                    <option value="">- Seleccione una opción -</option>
                                    <option value="0">Lector biometrico</option>
                                    <option value="1">Numero de identificación</option>
                                </select>  
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombres <span class="red">*</span></label>

                            <div class="col-xs-12 col-md-6 ">
                                @if ($errors->has('name'))
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @else
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail <span class="red">*</span></label>

                            <div class="col-xs-12 col-md-6 ">                               
                                @if ($errors->has('email'))
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @else
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-xs-12 col-md-6 ">
                                <input id="password" type="password" class="form-control" name="password" placeholder="¿Actualizar la contraseña actual?" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                            <div class="col-xs-12 col-md-6 ">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="¿Actualizar la contraseña actual?" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 col-md-6  col-md-offset-4">
                                <button type="submit" class="btn btn-success">Actualizar</button>
                                <a class="btn btn-primary" onclick="USERS.reset()">Restablecer</a>
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
    USERS.loadRol("{{ $user->id_role }}");  
    $('#modo_ingreso').val({{ $user->modo_ingreso }});
@endsection



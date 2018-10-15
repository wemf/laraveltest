@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-xs-12">
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
                <div class="panel-heading">Actualizar Rol</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/users/roles/update') }}">
                        {{ csrf_field() }}                       
                        <input type="hidden" name="id" value="{{ $rol->id }}">
                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre <span class="red">*</span></label>
                            <div class="col-md-6">
                                @if ($errors->has('nombre'))
                                    <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @else
                                    <input id="nombre" type="text" class="form-control" name="nombre" value="{{ $rol->nombre }}" required>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                            <label for="descripcion" class="col-md-4 control-label">Descripción</label>
                            <div class="col-md-6">
                                
                                @if ($errors->has('descripcion'))
                                    <textarea id="descripcion" type="text" class="form-control" name="descripcion" >{{ old('descripcion') }} </textarea>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descripcion') }}</strong>
                                    </span>
                                @else
                                    <textarea id="descripcion" type="text" class="form-control" name="descripcion" >{{ $rol->descripcion }} </textarea>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">    
                                <button type="submit" class="btn btn-success">Actualizar</button>
                                <button class="btn btn-primary" type="reset">Restablecer</button>
                                <a href="{{route('admin.roles')}}" class="btn btn-danger" type="button">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript') 
@endsection
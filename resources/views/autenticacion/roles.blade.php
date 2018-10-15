@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
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
                <div class="panel-heading">Nuevo Rol</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('admin.roles.create') }}">
                        {{ csrf_field() }}                       

                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre <span class="red">*</span></label>
                            <div class="col-md-6">                                
                                @if ($errors->has('nombre'))
                                    <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @else
                                    <input id="nombre" type="text" class="form-control" name="nombre"  required>
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
                                    <textarea id="descripcion" type="text" class="form-control" name="descripcion" > </textarea>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">                               
                                <button type="submit" class="btn btn-success">Guardar</button>
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
@extends('layouts.master')

@section('content')
<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar País</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('pais/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $attribute->nombre }}" type="text" name="nombre" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Descripción
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea type="text" name="descripcion" class="form-control col-md-7 col-xs-12">{{ $attribute->descripcion }}</textarea>
            </div>
          </div>
          <input type="hidden" name="id" value="{{$attribute->id}}">
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/pais') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>

        </form>
      </div>
    </div>
</div>
</div>
@endsection

@section('javascript')
    @parent

@endsection

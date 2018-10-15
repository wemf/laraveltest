@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Calificación</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('calificacion/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" required="required" class="form-control col-md-7 col-xs-12" value="{{ $attribute->nombre }}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Valor Mínimo <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha" name="valor_min" id="valor_min" maxlength="15" aria-label="Amount (to the nearest dollar)" value="{{ $attribute->valor_min }}" required="required">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Valor Máximo <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha" name="valor_max" id="valor_max" maxlength="15" aria-label="Amount (to the nearest dollar)" value="{{ $attribute->valor_max }}" required="required">
              </div>
            </div>
          </div>
          <input type="hidden" name="id" value="{{$attribute->id}}">
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" id="btn-save" class="btn btn-success hidden">Guardar</button>
              <button type="button" onclick="validarMontosCalificaciones();" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/calificacion') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/configcontrato/configcontrato.js')}}"></script>
    <script src="{{asset('/js/calificaciones.js')}}"></script>
@endpush

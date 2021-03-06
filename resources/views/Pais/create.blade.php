@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar País</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('/pais/create') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" onKeyDown="limitText(this,50);" value="{{ old('nombre') }}" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Abreviatura <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="abreviatura" onKeyDown="limitText(this,5);" value="{{ old('abreviatura') }}" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Indicativo <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input title="Solo se permiten indicativos desde 0 hasta 9999" value="{{ old('codigo_telefono') }}" min="0" max="9999" onKeyDown="limitText(this,3);" type="number" name="codigo_telefono" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>   

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

@push('scripts')
    <script src="{{asset('/js/attributes.js')}}"></script>
@endpush

@section('javascript')   


function limitText(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    }
}
  
@endsection

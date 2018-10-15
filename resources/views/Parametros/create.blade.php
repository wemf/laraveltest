@extends('layouts.master')

@section('content')
<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Parámetros Generales</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('/parametros/create') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')      
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">País <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select type="text" id="id_pais" name="id_pais" required="required" class="form-control col-md-7 col-xs-12">
                <option>- Seleccione una opción -</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Lenguaje <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select type="text" id="id_lenguaje" name="id_lenguaje" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">-- Seleccione una opción --</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Moneda <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select type="text" id="id_moneda" name="id_moneda" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">-- Seleccione una opción --</option>
              </select>
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Redondeo <span class="required">*</span>
              </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="numeric5 form-control" id="redondeo" name="redondeo" maxlength="1">
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/parametros') }}" class="btn btn-danger" type="button">Regresar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
@endpush

@section('javascript')   
        loadSelectInput("#id_pais","{{ url('/pais/getSelectList') }}") ;
        loadSelectInput("#id_lenguaje","{{ url('/parametros/getselectlistlenguaje') }}");
        loadSelectInput("#id_moneda","{{ url('/parametros/getselectlistmoneda') }}");  
        loadSelectInput("#id_medida_peso","{{ url('/parametros/getselectlistmedidapeso') }}");

        $('.numeric5').each(function(){
            $(this).keyup(function (){
                this.value = (this.value + '').replace(/[^0-5]/g, '');
            });
        });
@endsection

@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Plan Unico de Cuenta</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('/clientes/planunicocuenta/create') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')      
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cuenta <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="cuenta" required="required" class="form-control col-md-7 col-xs-12 justNumbers">
            </div>
          </div> 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div> 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Naturaleza <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="naturaleza" name="naturaleza" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
                <option value="0">Credito</option>
                <option value="1">Debito</option>
              </select>
            </div>
          </div>

          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">¿Cuenta tipo impuesto?<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="tipoimpuesto" name="tipoimpuesto"   onchange="intercaleCheck(this);"  value="0">
                  <span class="slider"></span>
                </label>
              </div>
          </div>

          <div class="form-group hide">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Impuesto <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_impuestos" name="id_impuestos" class="form-control col-md-7 col-xs-12">
              </select>
            </div>
          </div>

          <div class="form-group hide">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Porcentaje <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="porcentaje" id="porcentaje" class="form-control col-md-7 col-xs-12" min="0" value="0" step="any">
            </div>
          </div>
          
      <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/clientes/planunicocuenta') }}" class="btn btn-danger" type="button">Cancelar</a>
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
loadSelectInput("#id_impuestos","{{ url('/tesoreria/impuesto/getSelectList') }}");

$('#tipoimpuesto').change(function(){
  if($('#tipoimpuesto').val() == 0)
  {
    $('#id_impuestos').parent().parent().addClass('hide');
    $('#id_impuestos').val('');
    $('#id_impuestos').removeAttr('required');

    $('#porcentaje').parent().parent().addClass('hide');
    $('#porcentaje').val(null);
    $('#porcentaje').removeAttr('required');   
  }
  else
  {
    $('#id_impuestos').parent().parent().removeClass('hide');    
    $('#id_impuestos').prop('required',true);          

    $('#porcentaje').parent().parent().removeClass('hide');    
    $('#porcentaje').prop('required',true);     
  }
});
@endsection

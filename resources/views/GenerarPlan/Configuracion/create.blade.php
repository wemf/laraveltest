@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Nueva Configuración de Plan Separe</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-diagracia" action="{{ url('gestionplan/config/store') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">País <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="pais" name="pais" onchange="clearSelects([['departamento', 'delete_options'], ['ciudad', 'delete_options'], ['tienda', 'delete_options']], true);loadSelectChild(this, '#departamento', '{{ url('/departamento/getdepartamentobypais') }}');" class="form-control col-md-7 col-xs-12" required="required">
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Departamento 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="departamento" name="departamento" onchange="clearSelects([['ciudad', 'delete_options'], ['tienda', 'delete_options']], true);loadSelectChild(this, '#ciudad', '{{ url('/ciudad/getciudadbydepartamento') }}');" class="form-control col-md-7 col-xs-12">
                  <option value="0"> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ciudad 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="ciudad" name="ciudad" onchange="clearSelects([['tienda', 'delete_options']], true);loadSelectChild(this, '#tienda', '{{ url('/tienda/gettiendabyzona') }}');" class="form-control col-md-7 col-xs-12">
                  <option value="0"> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tienda 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="tienda" id="tienda" class="form-control col-md-7 col-xs-12">
                  <option value="0" selected> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Monto desde 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha" name="monto_desde" id="monto_desde" maxlength="15" aria-label="Amount (to the nearest dollar)" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Monto hasta
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha" name="monto_hasta" id="monto_hasta" maxlength="15" aria-label="Amount (to the nearest dollar)" autocomplete="off">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Vigencia desde <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="fecha_hora_vigencia_desde" id="fecha_desde" onchange="validateMinAndMax('fecha_desde', 'fecha_hasta', 'max', 'datetime');" required="required" class="form-control col-md-7 col-xs-12 data-picker-only" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Vigencia hasta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="fecha_hora_vigencia_hasta" id="fecha_hasta" onchange="validateMinAndMax('fecha_hasta', 'fecha_desde', 'min', 'datetime');" required="required" class="form-control col-md-7 col-xs-12  data-picker-only" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Término de <br>plan separe <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" min="1" max="100" name="termino_contrato" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Porcentaje de abono <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" min="0" max="100"  name="porcentaje_retroventa" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" id="btn-save" class="btn btn-success hidden">Guardar</button>
              <button type="button" onclick="guardarConfPS();" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('gestionplan/config') }}" class="btn btn-danger" type="button">Cancelar</a>
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
    <script src="{{asset('/js/plansepare/configuracion.js')}}"></script>
@endpush

@section('javascript')   
  @parent   
    URL.setUrlPais("{{ url('/pais/getpais') }}");
    URL.setUrlCalificacion("{{ url('/calificacion/getcalificacion') }}");
    URL.setUrlGetCategoria("{{ url('/products/categories/getCategory') }}");
    URL.setUrlGetZona("{{ url('/zona/getzona') }}");
    URL.setUrlGetTiendaByZona("{{ url('/tienda/gettiendabyzona') }}");
    runDiaGraciaForm();   
    SelectValPais('#pais');
@endsection

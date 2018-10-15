@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Nueva Aplicación de Retroventa</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-apliretroventa" action="{{ url('configcontrato/apliretroventa/store') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">País <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="pais" name="pais" onchange="clearSelects([['departamento', 'delete_options'], ['ciudad', 'delete_options'], ['tienda', 'delete_options']], 1);loadSelectChild(this, '#departamento', '{{ url('/departamento/getdepartamentobypais') }}');" class="form-control col-md-7 col-xs-12" required>
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Departamento 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="departamento" name="departamento" onchange="clearSelects([['ciudad', 'delete_options'], ['tienda', 'delete_options']], 1);loadSelectChild(this, '#ciudad', '{{ url('/ciudad/getciudadbydepartamento') }}');" class="form-control col-md-7 col-xs-12">
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ciudad
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="ciudad" name="ciudad" onchange="clearSelects([['tienda', 'delete_options']], 1);loadSelectChild(this, '#tienda', '{{ url('/tienda/gettiendabyzona') }}');" class="form-control col-md-7 col-xs-12">
                  <option value="0" selected> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tienda
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="tienda" id="tienda" class="form-control col-md-7 col-xs-12 required">
                  <option value="0" selected> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Meses <br>transcurridos desde
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="meses_desde" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Meses <br>transcurridos hasta
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="meses_hasta" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dias_desde">Días transcurridos desde
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="dias_desde" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dias_hasta">Días transcurridos hasta
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="dias_hasta" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group hide">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Días transcurridos
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="dias_transcurridos" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group hide">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Meses a restar
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="menos_meses" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">% a cobrar retroventa
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="menos_porcentaje_retroventas" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Monto desde
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha" name="monto_desde" id="monto_desde" maxlength="15" aria-label="Amount (to the nearest dollar)">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Monto hasta
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha" name="monto_hasta" id="monto_hasta" maxlength="15" aria-label="Amount (to the nearest dollar)">
              </div>
            </div>
          </div>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="button" onclick="guardarApliRetroventa();" class="btn btn-success">Guardar</button>
              <button type="submit" id="submit_button" class="btn btn-success hide">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('configcontrato/apliretroventa') }}" class="btn btn-danger" type="button">Cancelar</a>
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
@endpush

@section('javascript')   
  @parent   
    URL.setUrlPais("{{ url('/pais/getpais') }}");
    URL.setUrlGetZona("{{ url('/zona/getzona') }}");
    URL.setUrlGetTiendaByZona("{{ url('/tienda/gettiendabyzona') }}");
    runRetroventaForm();    
    SelectValPais("#pais");
@endsection

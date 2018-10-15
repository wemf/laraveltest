@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Editar configuración general de contrato</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-diagracia" action="{{ url('configcontrato/general/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 

            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pais">País <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="pais" data-load="{{ $general->id_pais }}" name="pais" class="form-control col-md-7 col-xs-12" required>
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="categoria">Categoría <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="categoria" data-load="{{ $general->id_categoria_general }}" id="categoria" class="form-control col-md-7 col-xs-12" required>
                  <option value="0" selected> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Vigencia desde <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" value="{{ $general->vigencia_desde }}" id="fecha_desde" onchange="validateMinAndMax('fecha_desde', 'fecha_hasta', 'max', 'datetime');" name="vigencia_desde" required="required" class="form-control col-md-7 col-xs-12 data-picker-only">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Vigencia hasta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" value="{{ $general->vigencia_hasta }}" id="fecha_hasta" onchange="validateMinAndMax('fecha_hasta', 'fecha_desde', 'min', 'datetime');" name="vigencia_hasta" required="required" class="form-control col-md-7 col-xs-12 data-picker-only">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="termino_contrato"> Término de <br>contrato <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" value="{{ $general->termino_contrato }}" name="termino_contrato" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="porcentaje_retroventa">Porcentaje de retroventa <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" value="{{ $general->porcentaje_retroventa }}" step="0.01" name="porcentaje_retroventa" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cantidad_aplazos_contrato">Máximo de Días para Aplazar Contratos <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="cantidad_aplazos_contrato" value="{{ $general->cantidad_aplazos_contrato }}" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dias_gracia">Días de Gracia <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="dias_gracia" value="{{ $general->dias_gracia }}" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>




          
          
          <input type="hidden" name="id" value="{{$general->id}}">

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('configcontrato/general') }}" class="btn btn-danger" type="button">Cancelar</a>
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
    URL.setUrlGetCategoria("{{ url('/products/categories/getCategory') }}");
    URL.setUrlPais("{{ url('/pais/getpais') }}");
    URL.setUrlGetTiendaByZona("{{ url('/tienda/gettiendabyzona') }}");
    runGeneralForm();


    $("#updateAction2").click(function() 
    {
      var url2="{{ url('/products/attributes/store') }}";
      updateRowDatatableAction(url2)
    });

@endsection

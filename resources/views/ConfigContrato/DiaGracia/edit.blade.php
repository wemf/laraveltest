@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Editar configuración de días de gracia</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-diagracia" action="{{ url('configcontrato/diagracia/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">País <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="pais" required="required" name="pais" data-load="{{ $diagracia->id_pais }}" onchange="clearSelects([['departamento', 'delete_options'], ['ciudad', 'delete_options'], ['tienda', 'delete_options']], 1);loadSelectChild(this, '#departamento', '{{ url('/departamento/getdepartamentobypais') }}');" class="form-control col-md-7 col-xs-12">
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Departamento 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="departamento" data-load="{{ $diagracia->id_departamento }}" name="departamento" onchange="clearSelects([['ciudad', 'delete_options'], ['tienda', 'delete_options']], 1);loadSelectChild(this, '#ciudad', '{{ url('/ciudad/getciudadbydepartamento') }}');" class="form-control col-md-7 col-xs-12">
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ciudad
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="ciudad" data-load="{{ $diagracia->id_ciudad }}" name="ciudad" onchange="clearSelects([['tienda', 'delete_options']], 1);loadSelectChild(this, '#tienda', '{{ url('/tienda/gettiendabyzona') }}');" class="form-control col-md-7 col-xs-12">
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tienda
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="tienda" id="tienda" data-load="{{ $diagracia->id_tienda }}" class="form-control col-md-7 col-xs-12">
                  <option value="0" selected> - Seleccione una opción - </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Número de días <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="dias" required="required" value="{{ $diagracia->dias_gracia }}" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          
          <input type="hidden" name="id" value="{{$diagracia->id}}">

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('configcontrato/diagracia') }}" class="btn btn-danger" type="button">Cancelar</a>
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
    runConfigDiaGraciaForm(); 


    $("#updateAction2").click(function() 
    {
      var url2="{{ url('/products/attributes/store') }}";
      updateRowDatatableAction(url2)
    });

@endsection

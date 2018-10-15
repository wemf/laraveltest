@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Editar precio sugerido</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-diagracia" action="{{ url('configcontrato/valorsugerido/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 

            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">País <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="pais" name="pais" data-load="{{ $valorsugerido->id_pais }}" onchange="clearSelects([['departamento', 'delete_options'], ['ciudad', 'delete_options'], ['tienda', 'delete_options']], true);loadSelectChild(this, '#departamento', '{{ url('/departamento/getdepartamentobypais') }}');" class="form-control col-md-7 col-xs-12" required="required">
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Departamento
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="departamento" data-load="{{ $valorsugerido->id_departamento }}" name="departamento" onchange="clearSelects([['ciudad', 'delete_options'], ['tienda', 'delete_options']], true);loadSelectChild(this, '#ciudad', '{{ url('/ciudad/getciudadbydepartamento') }}');" class="form-control col-md-7 col-xs-12">
                  <option value="0"> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ciudad 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="ciudad" data-load="{{ $valorsugerido->id_ciudad }}"  name="ciudad" onchange="clearSelects([['tienda', 'delete_options']], true);loadSelectChild(this, '#tienda', '{{ url('/tienda/gettiendabyzona') }}');" class="form-control col-md-7 col-xs-12" >
                  <option value="0"> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tienda
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="tienda" data-load="{{ $valorsugerido->id_tienda }}" id="tienda" class="form-control col-md-7 col-xs-12" >
                  <option value="0" selected> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="categoria">Categoría <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="categoria" id="categoria" data-load="{{ $valorsugerido->id_categoria_general }}" onchange="loadSelect(this, '{{ url('/configcontrato/itemcontrato/getbycategoria') }}', 'item');" class="form-control col-md-7 col-xs-12" required>
                  <option value="0" selected> - Seleccione una opción - </option>
              </select>
            </div>
          </div>

          <div class="selects">
          </div>

          <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item">Item para contrato <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="item" name="item" data-load="{{ $valorsugerido->id_item }}" class="form-control col-md-7 col-xs-12" required>
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div> -->

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valor_minimo_x_1">Valor mínimo por <span class="valText">(?)</span> <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <!-- <input type="number" name="valor_minimo_x_1" id="valor_minimo_x_1" onchange="validateMinAndMax('valor_minimo_x_1', 'valor_maximo_x_1', 'max')" onblur="validateMinAndMax('valor_minimo_x_1', 'valor_maximo_x_1', 'max')" value="{{ $valorsugerido->valor_minimo_x_1 }}" required="required" class="form-control col-md-7 col-xs-12 rem" disabled> -->
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha rem" name="valor_minimo_x_1" id="valor_minimo_x_1" maxlength="15" aria-label="Amount (to the nearest dollar)" value="{{ $valorsugerido->valor_minimo_x_1 }}" required disabled>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valor_maximo_x_1">Valor máximo por <span class="valText">(?)</span> <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <!-- <input type="number" name="valor_maximo_x_1" id="valor_maximo_x_1" onchange="validateMinAndMax('valor_maximo_x_1', 'valor_minimo_x_1', 'min')" onblur="validateMinAndMax('valor_maximo_x_1', 'valor_minimo_x_1', 'min')" value="{{ $valorsugerido->valor_maximo_x_1 }}" required="required" class="form-control col-md-7 col-xs-12 rem" disabled> -->
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha rem" name="valor_maximo_x_1" id="valor_maximo_x_1" maxlength="15" aria-label="Amount (to the nearest dollar)" value="{{ $valorsugerido->valor_maximo_x_1 }}" required disabled>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valor_x_1">Valor por <br> <span class="valText">(?)</span> <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <!-- <input type="number" name="valor_x_1" value="{{ $valorsugerido->valor_x_1 }}" required="required" class="form-control col-md-7 col-xs-12 rem" disabled> -->
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha rem" name="valor_x_1" id="valor_x_1" maxlength="15" aria-label="Amount (to the nearest dollar)" value="{{ $valorsugerido->valor_x_1 }}" required disabled>
              </div>
            </div>
          </div>


          <div class="form-group hide">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valor_venta_x_1">Valor por <br> <span class="valText">(?)</span> para la venta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <!-- <input type="number" name="valor_venta_x_1" value="{{ $valorsugerido->valor_venta_x_1 }}" required="required" class="form-control col-md-7 col-xs-12 rem" disabled> -->
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha rem" name="valor_venta_x_1" id="valor_venta_x_1" maxlength="15" aria-label="Amount (to the nearest dollar)" value="{{ $valorsugerido->valor_venta_x_1 }}" disabled>
              </div>
            </div>
          </div>
          <input type="hidden" id="id_medida_peso" name="id_medida_peso">
          
          <input type="hidden" name="id" id="id" value="{{$valorsugerido->id}}">

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success btn-guardar-valor hide">Guardar</button>
              <button type="button" onclick="guardarValSug();" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('configcontrato/valorsugerido') }}" class="btn btn-danger" type="button">Cancelar</a>
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
    URL.setUrlGetCategoria("{{ url('/products/categories/getCategory') }}");
    URL.setUrlGetZona("{{ url('/pais/getpais') }}");
    URL.setUrlGetTiendaByZona("{{ url('/tienda/gettiendabyzona') }}");
    URL.setUrlAttributeAttributesById("{{ url('/products/attributes/getAttributeAttributesById') }}");
    runValorSugeridoForm();
    $('#categoria').change();
    
    
    $("#updateAction2").click(function() 
    {
      var url2="{{ url('/products/attributes/store') }}";
      updateRowDatatableAction(url2)
    });
    runChange();
    loadAttributesUpdate();

@endsection

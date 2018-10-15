@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Nuevo precio de venta</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-valorventa" action="{{ url('configcontrato/valorventa/store') }}" method="POST" class="form-horizontal form-label-left">
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="categoria">Categoría <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="categoria" id="categoria" onchange="loadSelect(this, '{{ url('/configcontrato/itemcontrato/getbycategoria') }}', 'item');" class="form-control col-md-7 col-xs-12 categoria_precio_sugerido" required>
                  <option value="0" selected> - Seleccione una opción - </option>
              </select>
            </div>
          </div>
          <div class="form-group">
          <div class="selects">

          </div>
          </div>

          <input type="hidden" name="valores_atributos" id="valores_atributos" />

          <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item">Item para contrato <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="item" name="item" class="form-control col-md-7 col-xs-12" required>
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div> -->

          <div class="form-group hide">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valor_minimo_x_1">Valor mínimo por <span class="valText">(?)</span> <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha rem" name="valor_minimo_x_1" id="valor_minimo_x_1" maxlength="15" aria-label="Amount (to the nearest dollar)" onchange="valMinAndMax('valor_minimo_x_1', 'valor_maximo_x_1')"  disabled>
              </div>
            </div>
          </div>

          <div class="form-group hide">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valor_maximo_x_1">Valor máximo por <span class="valText">(?)</span> <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha rem" name="valor_maximo_x_1" id="valor_maximo_x_1" maxlength="15" aria-label="Amount (to the nearest dollar)" onchange="valMinAndMax('valor_minimo_x_1', 'valor_maximo_x_1')"  disabled>
              </div>
            </div>
          </div>

          <div class="form-group hide">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valor_x_1">Valor por <br> <span class="valText">(?)</span> <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha rem" name="valor_x_1" id="valor_x_1" maxlength="15" aria-label="Amount (to the nearest dollar)"  disabled>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valor_venta_x_1">Valor por <br> <span class="valText">(?)</span> para la venta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha rem" name="valor_venta_x_1" id="valor_venta_x_1" maxlength="15" aria-label="Amount (to the nearest dollar)" required disabled>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valor_compra">Precio compra por<br> <span class="valText">(?)</span> para la venta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha rem" name="valor_compra" id="valor_compra" maxlength="15" aria-label="Amount (to the nearest dollar)" required disabled>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="costo">Costo por<br> <span class="valText">(?)</span> para la venta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha rem" name="costo" id="costo" maxlength="15" aria-label="Amount (to the nearest dollar)" required disabled>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="autoriza">Autoriza compra de inventario con costo igual o mayor al precio de venta por<br> <span class="valText">(?)</span> para la venta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <label class="switch_check">
                  <input type="checkbox" id="autoriza" name="autoriza" value="0" onchange="intercaleCheck(this);" checked="">
                  <span class="slider"></span>
                </label>
              </div>
            </div>
          </div>


          <input type="hidden" id="id_medida_peso" name="id_medida_peso" value="{{ $medida_peso->id_medida }}">
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('configcontrato/valorventa') }}" class="btn btn-danger" type="button">Cancelar</a>
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
    URL.setUrlGetZona("{{ url('/configcontrato/itemcontrato/getbycategoria') }}");
    URL.setUrlGetTiendaByZona("{{ url('/tienda/gettiendabyzona') }}");
    runValorSugeridoForm();
    SelectValPais("#pais");


    $( "#newUserEmail" ).click(function() {
        if(valRequired.input()==true){
            $("#form-user").prop( "action","{{url('/register/to/email')}}" )
            $("#form-user").submit();
        }
    });

    $( "#generatedPassword" ).click(function() {
        var pass=generar(7);
        $("#password-1").val(pass);
        $("#password-2").val(pass);
    });    
@endsection

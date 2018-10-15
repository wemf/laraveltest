@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Nuevo Valor de Atributo</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('products/attributevalues/store') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Categoría <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="category" name="category[]" onchange="getAttributesByCategories('{{ url('products/attributes/getAttributesByCategories') }}');" multiple="multiple" name="category" required="required" class="form-control col-md-7 col-xs-12 3col active">
                  @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="attribute">Atributo <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="attribute" name="attribute" class="form-control col-md-7 col-xs-12" required>
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>
          <div class="form-group parentAttributeContent">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parentValue">Valor Padre <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="parentValue" id="parentValue" class="form-control col-md-7 col-xs-12">
                  <option value="0" selected>Ninguno</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Valor <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" maxlength="70" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="abreviatura">Abreviatura <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="abreviatura" id="abreviatura" maxlength="70" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label for="peso_igual_contrato" class="control-label col-md-3 col-sm-3 col-xs-12">¿Pedir Peso Estimado?</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="peso_igual_contrato" name="peso_igual_contrato" value="0"  onchange="intercaleCheck(this);" />
                  <span class="slider"></span>
                </label>
            </div>
          </div>

          <div class="form-group">
            <label for="valor_defecto" class="control-label col-md-3 col-sm-3 col-xs-12">Valor Por Defecto</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="valor_defecto" name="valor_defecto" value="0"  onchange="intercaleCheck(this);" />
                  <span class="slider"></span>
                </label>
            </div>
          </div>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('products/attributevalues') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>

        </form>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/attributevalues.js')}}"></script>
@endpush

@section('javascript')   
  @parent   
    URL.setUrlGetCategory("{{ url('/products/categories/getCategory') }}");
    URL.setUrlGetAttribute("{{ url('/products/categories/getAttributeCategoryById') }}");
    URL.setUrlAttributeValueById("{{ url('/products/attributes/getAttributeValueById') }}");
    runAttributeValueFormCreate();


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

@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Nuevo Atributo</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('products/attributes/store') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Categoría <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="category" name="category[]" multiple="multiple" name="category" required="required" class="form-control col-md-7 col-xs-12 3col active">
                  @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="form-group parentAttributeContent">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Atributo Padre </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="parentAttribute" id="parentAttribute" class="form-control col-md-7 col-xs-12">
                  <option value="0" selected="selected">Ninguno</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="name" maxlength="30" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label for="tiene_abreviatura" class="control-label col-md-3 col-sm-3 col-xs-12">Agregar abreviatura</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="tiene_abreviatura" name="tiene_abreviatura" value="0"  onchange="intercaleCheck(this);" />
                  <span class="slider"></span>
                </label>
            </div>
          </div>


          <div class="form-group">
            <label for="valor_desde_contrato" class="control-label col-md-3 col-sm-3 col-xs-12">Valor Manual</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="valor_desde_contrato" name="valor_desde_contrato" value="0"  onchange="intercaleCheck(this);" />
                  <span class="slider"></span>
                </label>
            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Concatenar<br> Nombre <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="concatenar_nombre" name="concatenar_nombre" value="1"  onchange="intercaleCheck(this);" checked>
                <span class="slider"></span>
              </label>
            </div>
          </div>


          <div class="form-group">
            <label for="columna_independiente_contrato" class="control-label col-md-3 col-sm-3 col-xs-12">Columna Independiente en Item de Contrato</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="columna_independiente_contrato" name="columna_independiente_contrato" value="0"  onchange="intercaleCheck(this);" />
                  <span class="slider"></span>
                </label>
            </div>
          </div>

          <div class="form-group">
            <label for="atributo_referencia" class="control-label col-md-3 col-sm-3 col-xs-12">Habilitar para la creación de referencias</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="atributo_referencia" name="atributo_referencia" value="0"  onchange="intercaleCheck(this);" />
                  <span class="slider"></span>
                </label>
            </div>
          </div>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button id="btn-save" type="submit" class="btn btn-success hide">Guardar</button>
              <button type="button" onclick="validate_form.save();" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" onclick="resetInput();" type="reset">Restablecer</button>
              <a href="{{ url('products/attributes') }}" class="btn btn-danger" type="button">Cancelar</a>
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
  @parent   
    URL.setUrlGetCategory("{{ url('/products/categories/getCategory') }}");
    URL.setUrlAttributeCategoryById("{{ url('/products/categories/getAttributeCategoryById') }}");
    runAttributeForm('create');

    function resetInput(){
      $('.ms-options-wrap span').text('- Seleccione Opciones -');
    }
@endsection

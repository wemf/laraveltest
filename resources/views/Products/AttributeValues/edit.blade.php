@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Editar Valor de Atributo</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('products/attributevalues/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 

            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Categoría <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="category" name="category"  data-load="{{ $attributeValue->id_cat_general }}" class="form-control col-md-7 col-xs-12" required>
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="attribute">Atributo <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="attribute" name="attribute"  data-load="{{ $attributeValue->id_atributo }}" value="{{ $attributeValue->id_atributo }}" class="form-control col-md-7 col-xs-12" required>
                  <option> - Seleccione una opción - </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="parentValue">Valor Padre <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="parentValue" id="parentValue"  data-load="{{ $attributeValue->id_atributo_padre }}" value="{{ $attributeValue->id_atributo_padre }}" class="form-control col-md-7 col-xs-12">
                  <option value="0" selected>Ninguno</option>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Valor <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $attributeValue->nombre }}" maxlength="70" type="text" name="nombre" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="abreviatura">Abreviatura <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $attributeValue->abreviatura }}" maxlength="70" type="text" name="abreviatura" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>


          <div class="form-group">
            <label for="peso_igual_contrato" class="control-label col-md-3 col-sm-3 col-xs-12">¿Pedir Peso Estimado?</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="peso_igual_contrato" name="peso_igual_contrato"  onchange="intercaleCheck(this);" 
                    @if($attributeValue->peso_igual_contrato == 0)
                      checked value="1"
                    @else 
                      value="0"
                    @endif
                   />
                  <span class="slider"></span>
                </label>
            </div>
          </div>

          <div class="form-group">
            <label for="valor_defecto" class="control-label col-md-3 col-sm-3 col-xs-12">Valor Por Defecto</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="valor_defecto" name="valor_defecto" value="{{ $attributeValue->valor_defecto }}"  onchange="intercaleCheck(this);" 
                    @if($attributeValue->valor_defecto == 1)
                      checked
                    @endif
                   />
                  <span class="slider"></span>
                </label>
            </div>
          </div>

          <input type="hidden" name="id" value="{{$attributeValue->id}}">
          
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
    runAttributeValueFormEdit();

    $("#updateAction2").click(function() 
    {
      var url2="{{ url('/products/attributes/store') }}";
      updateRowDatatableAction(url2)
    });

@endsection

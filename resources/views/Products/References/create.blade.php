@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Nueva Referencia de Producto</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-references"action="javascript:void(0)" class="form-horizontal form-label-left" autocomplete="off">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
            <div class="form-group bottom-20">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Categoría <span class="required red">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="category" name="category" class="form-control col-md-7 col-xs-12 required" required>
                    <option> - Seleccione una opción - </option>
                </select>
              </div>
            </div>
            <div class="selects">
            </div>

            <div class="form-group bottom-20">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_reference">Referencia <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" maxlength="70" name="name_reference" id="name_reference" maxlength="40" required class="form-control col-md-7 col-xs-12 required">
            </div>
          </div>

          <div class="form-group bottom-20">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valid_since">Vigencia desde <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" maxlength="70" name="valid_since" id="valid_since"  required="required" class="form-control col-md-7 col-xs-12  data-picker-only">
            </div>
          </div>

          <div class="form-group bottom-20">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valid_until">Vigencia hasta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" maxlength="70" name="valid_until" id="valid_until"  required="required" class="form-control col-md-7 col-xs-12  data-picker-only">
            </div>
          </div>

          <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="genera_contrato">Habilitado para contrato <span class="required red">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="switch_check">
              <input type="checkbox" id="genera_contrato" name="genera_contrato" value="1"  onchange="intercaleCheck(this);" checked>
              <span class="slider"></span>
            </label>
          </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="genera_venta">Habilitado para venta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="genera_venta" name="genera_venta" value="1"  onchange="intercaleCheck(this);" checked>
                <span class="slider"></span>
              </label>
            </div>
          </div>
          
          <div class="ln_solid"></div>
          <div class="form-group bottom-20">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" onclick="saveReference()" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" onclick="reseter()" type="reset">Restablecer</button>
              <a href="{{ url('products/references') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/references.js')}}"></script>
@endpush

@section('javascript')   
  @parent   
    URL.setUrlIndex("{{ url('/products/references') }}");
    URL.setUrlGetCategory("{{ url('/products/categories/getCategory') }}");
    URL.setUrlAttributeCategoryById("{{ url('/products/categories/getFirstAttributeCategoryById') }}");
    URL.setUrlAttributeAttributesById("{{ url('/products/attributes/getAttributeAttributesById') }}");

    URL.setUrlCreateReference("{{ url('/products/references/store') }}");
    runAttributeForm(); 
@endsection

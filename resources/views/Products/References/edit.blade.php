@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Editar Referencia de Producto</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-references" action="javascript:void(0)" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 

            <div class="form-group bottom-20">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Categoría <span class="required red">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="category" name="category" data-load="{{ $reference->id_categoria }}" class="form-control col-md-7 col-xs-12 required" required>
                    <option> - Seleccione una opción - </option>
                </select>
              </div>
            </div>
            <div class="selects">
            </div>
          
          <div class="form-group bottom-20">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Referencia <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $reference->nombre }}" maxlength="70" type="text" name="name_reference" id="name_reference" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group bottom-20 hide">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre <span class="required red">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="{{ $reference->descripcion }}" maxlength="70" class="form-control col-md-7 col-xs-12" type="text" name="description" required>
            </div>
          </div>

          <div class="form-group bottom-20">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valid_since">Vigencia desde <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" value="{{ $reference->vigencia_desde }}" maxlength="70" name="valid_since" id="valid_since"  required="required" class="form-control col-md-7 col-xs-12 data-picker-only">
            </div>
          </div>

          <div class="form-group bottom-20">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valid_until">Vigencia hasta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" value="{{ $reference->vigencia_hasta }}" maxlength="70" name="valid_until" id="valid_until"  required="required" class="form-control col-md-7 col-xs-12 data-picker-only">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="genera_contrato">Puede generar contrato <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="genera_contrato" name="genera_contrato" value="{{ $reference->genera_contrato }}"  onchange="intercaleCheck(this);">
                <span class="slider"></span>
              </label>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="genera_venta">Habilitado para venta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="genera_venta" name="genera_venta"  value="{{ $reference->genera_venta }}"  onchange="intercaleCheck(this);">
                <span class="slider"></span>
              </label>
            </div>
          </div>

          <input type="hidden" name="id" id="id" value="{{$reference->id}}">
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" onclick="saveReference('update')" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
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
    runAttributeForm(); 
    loadAttributesUpdate();
@endsection

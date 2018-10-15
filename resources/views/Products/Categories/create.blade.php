@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Nueva Categoría</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" autocomplete="off" action="{{ url('products/categories/store') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
          
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" required="required" maxlength="70" value="{{ old('nombre') }}" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Unidad de Medida <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select type="text" id="id_medida_peso" name="id_medida_peso" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
                @foreach($medida as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach 
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valid_since">Vigencia desde <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" maxlength="70" name="valid_since" required="required" id="valid_since" value="{{ old('valid_since') }}" class="form-control col-md-7 col-xs-12 data-picker-only">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valid_since">Vigencia hasta <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" maxlength="70" name="valid_until" required="required" id="valid_until" value="{{ old('valid_until') }}"  class="form-control col-md-7 col-xs-12 data-picker-only">
            </div>
          </div>


        <div class="form-group">
          <label for="control_peso_contrato" class="control-label col-md-3 col-sm-3 col-xs-12">Control Peso Contrato</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="control_peso_contrato" name="control_peso_contrato" value="0"  onchange="intercaleCheck(this);" />
                <span class="slider"></span>
              </label>
          </div>
        </div>


        <div class="form-group">
          <label for="aplica_bolsa" class="control-label col-md-3 col-sm-3 col-xs-12">Bolsa</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="aplica_bolsa" name="aplica_bolsa" value="0"  onchange="intercaleCheck(this);" />
                <span class="slider"></span>
              </label>
          </div>
        </div>

        <div class="form-group">
          <label for="aplica_refaccion" class="control-label col-md-3 col-sm-3 col-xs-12">Refacción</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="aplica_refaccion" name="aplica_refaccion" value="0"  onchange="intercaleCheck(this);" />
                <span class="slider"></span>
              </label>
          </div>
        </div>

        <div class="form-group">
          <label for="aplica_vitrina" class="control-label col-md-3 col-sm-3 col-xs-12">Vitrina</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="aplica_vitrina" name="aplica_vitrina" value="0"  onchange="intercaleCheck(this);" />
                <span class="slider"></span>
              </label>
          </div>
        </div>

        <div class="form-group">
          <label for="aplica_fundicion" class="control-label col-md-3 col-sm-3 col-xs-12">Fundición</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="aplica_fundicion" name="aplica_fundicion" value="0"  onchange="intercaleCheck(this);" />
                <span class="slider"></span>
              </label>
          </div>
        </div>

        <div class="form-group">
          <label for="aplica_joya" class="control-label col-md-3 col-sm-3 col-xs-12">Joya especial</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="aplica_joya" name="aplica_joya" value="0"  onchange="intercaleCheck(this);" />
                <span class="slider"></span>
              </label>
          </div>
        </div>

        <div class="form-group">
          <label for="aplica_maquila" class="control-label col-md-3 col-sm-3 col-xs-12">Maquila</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="aplica_maquila" name="aplica_maquila" value="0"  onchange="intercaleCheck(this);" />
                <span class="slider"></span>
              </label>
          </div>
        </div>

        <div class="form-group">
            <label for="se_fabrica" class="control-label col-md-3 col-sm-3 col-xs-12">Se fabrica</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="switch_check">
                <input type="checkbox" id="se_fabrica" name="se_fabrica" value="0"  onchange="intercaleCheck(this);" />
                <span class="slider"></span>
              </label>
            </div>
        </div>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button id="btn-save" type="submit" class="btn btn-success hide">Guardar</button>
              <button type="button" onclick="validate_form_C.save_specific();" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('products/categories') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>

        </form>
      </div>
    </div>
</div>
</div>

@push('scripts')
    <script src="{{asset('/js/categories.js')}}"></script>
@endpush
@endsection
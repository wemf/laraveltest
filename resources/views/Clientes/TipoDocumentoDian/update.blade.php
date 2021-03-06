@extends('layouts.master')

@section('content')
<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Tipo Documento Dian</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('/clientes/tipodocumentodian/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
            
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Documento <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_tipo_documento" name="id_tipo_documento" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>  

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" required="required" class="form-control col-md-7 col-xs-12" value="{{ $attribute->nombre }}">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Requiere Dígito de Verificación <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="inline-30">
              <input type="radio" id="optSi" name="digito_verificacion" class="radio-control" value="Si" />
              <label for="optSi" class="lbl-radio-control" style="font-size: 20px!important; font-weight: 100; height: 26px; display: block;"> Si</label>
            </div>
            <div class="inline-30">
              <input type="radio" id="optNo" name="digito_verificacion" class="radio-control" value="No" />
              <label for="optNo" class="lbl-radio-control" style="font-size: 20px!important; font-weight: 100; height: 26px; display: block;"> No</label>
            </div>
          </div>
      </div>
         
          <input type="hidden" name="id" value="{{$attribute->id}}">
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/clientes/tipodocumentodian') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
@endsection

@section('javascript')
    loadSelectInput("#id_tipo_documento","{{ url('/clientes/tipodocumento/getSelectList') }}")

    $('#id_tipo_documento').val({{ $attribute->id_tipo_documento }});
    $('#opt' + '{{ $attribute->digito_verificacion }}').attr('checked', true);
@endsection

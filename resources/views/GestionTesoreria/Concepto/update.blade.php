@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Concepto</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('/tesoreria/concepto/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
            
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_concepto">Tipo Documento Contable <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="column_filter form-control" id="id_tipo_documento_contable" name="id_tipo_documento_contable"></select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="naturaleza">País <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input readOnly type="text" id="id_pais" name="id_pais"  required="required" class="form-control col-md-7 col-xs-12" value='{{$attribute->pais}}'>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="naturaleza">Código <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input readOnly type="text" id="codigo" name="codigo"  required="required" class="form-control col-md-7 col-xs-12" value='{{$attribute->codigo}}'>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" id="nombre" required="required" class="form-control col-md-7 col-xs-12" value='{{$attribute->nombre}}'>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_concepto">Naturaleza <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="column_filter form-control" id="id_naturaleza" name="id_naturaleza">
                <option value="">- Seleccione una opción -</option>
                <option value="0">Credito</option>
                <option value="1">Debito</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_concepto">Código Contra Cuenta <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="column_filter form-control" id="id_contracuenta_codigo" name="id_contracuenta_codigo"></select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_concepto">Nombre Contra Cuenta <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="column_filter form-control" id="id_contracuenta_nombre" name="id_contracuenta_nombre"></select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Impuestos <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select multiple="multiple" id="id_impuesto" name="id_impuesto" required = "required">
              </select>
            </div>
          </div>

          <input type="hidden" name="id" id='id' value="{{$attribute->id}}">
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="button" id='btn-guardar' class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/tesoreria/concepto') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>

        </form>
      </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
    <script src="{{asset('/js/tesoreria/concepto.js')}}"></script>
@endpush
@section('javascript')
    @parent
    
    loadSelectInput("#id_tipo_documento_contable","{{ url('/tesoreria/concepto/getselectlistipodocumentocontable') }}");
    $('#id_tipo_documento_contable').val({{$attribute->id_tipo_documento_contable}});
    $('#id_naturaleza').val({{$attribute->naturaleza}});
    $('#id_naturaleza').change();
    $('#id_naturaleza').change(function(){
      fillSelect('#id_naturaleza','#id_contracuenta_codigo','{{ url('/tesoreria/concepto/getselectlistcodigo') }}');
    });

    $('#id_naturaleza').change(function(){
      fillSelect('#id_naturaleza','#id_contracuenta_nombre','{{ url('/tesoreria/concepto/getselectlistnombre') }}');
    });
    $('#id_contracuenta_codigo').val({{$attribute->id_contracuenta}});
    $('#id_contracuenta_nombre').val({{$attribute->id_contracuenta}});

    

    //Transforma el Select a MultiSelect
    loadSelectInput("#id_impuesto","{{ url('/tesoreria/concepto/getselectlistimpuesto') }}", false);
    
    URL.setUrl(" {{ url('/tesoreria/concepto/impuestoconcepto') }}" );
    runImpuestoConceptos('#id_impuesto');
    $('#id_impuesto').multiSelect({
      selectableHeader: "<div class='custom-header'>Impuestos en Sistema</div>",
      selectionHeader: "<div class='custom-header'>Impuestos Asociados</div>",
    });

    //Guardar Nuevos Impuestos
    URL.setUrl(" {{ url('/tesoreria/concepto/actualizarimpuestoconcepto') }}" );
    URL.setRedirec(" {{ url('/tesoreria/concepto') }}" );
    $('#btn-guardar').click(function(){
      runAsociaciones();
    });
    
@endsection

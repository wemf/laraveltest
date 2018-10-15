@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar concepto</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form action="{{ url('/tesoreria/concepto/create') }}" method="POST" class="form-horizontal form-label-left">
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_concepto">País <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="column_filter form-control" id="id_pais" name="id_pais"></select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="naturaleza">Código <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="codigo" name="codigo" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="nombre" name="nombre" required="required" class="form-control col-md-7 col-xs-12">
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
              <select class="column_filter form-control" id="id_contracuenta_codigo" name="id_contracuenta_codigo">
                <option value="">- Seleccione una opción -</option>                
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_concepto">Nombre Contra Cuenta <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="column_filter form-control" id="id_contracuenta_nombre" name="id_contracuenta_nombre">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Impuestos <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select multiple="multiple" id="id_impuesto" name="id_impuesto" required = "required"></select>
            </div>
          </div>

          </div>
       
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="button" id = 'btn-guardar' class="btn btn-success">Guardar</button>
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
    loadSelectInput("#id_pais","{{ url('/pais/getSelectList') }}");  
    loadSelectInput("#id_tipo_documento_contable","{{ url('/tesoreria/concepto/getselectlistipodocumentocontable') }}");
    SelectValPais("#id_pais");
    

    loadSelectInput("#id_impuesto","{{ url('/tesoreria/concepto/getselectlistimpuesto') }}", false);    
    $('#id_impuesto').multiSelect({
      selectableHeader: "<div class='custom-header'>Impuestos en Sistema</div>",
      selectionHeader: "<div class='custom-header'>Impuestos Asociados</div>",
    });

    URL.setUrl(" {{ url('/tesoreria/concepto/create') }}" );
    URL.setRedirec(" {{ url('/tesoreria/concepto') }}" );
    $('#btn-guardar').click(function(){
      runAsociaciones();
    });
@endsection

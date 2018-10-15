@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="row">
<div class="col-md-6 col-md-offset-3 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Asociación a Sociedad</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')  

             <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
             <input class="form-control col-md-7 col-xs-12" disabled type="text" name="nombre" value="{{$attribute->nombres}} {{$attribute->primer_apellido}} {{$attribute->segundo_apellido}}" >
            </div>
          </div>    
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">País <span class="required">*</span>
            </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_pais" name="id_pais" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div> 
          
          <input type="hidden" id="id"name="id" value="{{$attribute->codigo_cliente}}">
          <input type="hidden" id="idtienda" name="idtienda" value="{{$attribute->id_tienda}}">
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sociedades <span class="required">*</span>
            </label>
             <div class="col-md-6 col-sm-6 col-xs-12 multiselec">
              <select multiple="multiple" id="id_sociedad" name="id_sociedad" required="required" class="form-control col-md-7 col-xs-12">
              </select>
             </div>
          </div>

      <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button id='btn-guardar' type="button" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/asociarclientes/asociarsociedad') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
        </form>
        
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/estados.js')}}"></script>
@endpush

@section('javascript')
    loadSelectInput("#id_pais","{{ url('/pais/getSelectList') }}")

    $('#id_pais').change(function(){
      saveAsociar('{{ url('/pais/getSelectListPaisSociedad') }}', '#id_pais', '#id_sociedad');
      $('#id_sociedad').multiSelect('refresh');
    });
    
    //Carga inicial de Sociedades (si el usuario escogio)
    URL.setUrl(" {{ url('/asociarclientes/asociarsociedad/sociedadesseleccionadas') }}" );
    runSeleccionadas('#id_sociedad');
    $('#id_sociedad').multiSelect({
      selectableHeader: "<div class='custom-header'>Sociedades Sistema</div>",
      selectionHeader: "<div class='custom-header'>Sociedades Asociadas</div>",
    });
    
    //Vamo a guardar 
    URL.setUrl(" {{ url('/asociarclientes/asociarsociedad/create') }}" );
    URL.setRedirec(" {{ url('/asociarclientes/asociarsociedad') }}" );
    $('#btn-guardar').click(function(){
      runAsociaciones();
    });
@endsection

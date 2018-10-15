@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="row">
<div class="col-md-10 col-md-offset-1 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Asociación a Tienda</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')  

          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
             <div class="col-md-7 col-sm-7 col-xs-12">
             <input class="form-control col-md-7 col-xs-12" disabled type="text" name="nombre" value="{{$attribute->nombres}} {{$attribute->primer_apellido}} {{$attribute->segundo_apellido}}" >
            </div>
          </div>    

          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Zona <span class="required">*</span>
            </label>
             <div class="col-md-7 col-sm-7 col-xs-12">
              <select id="id_zona" name="id_zona"  class="form-control col-md-7 col-xs-12 ">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>

          <input type="hidden" id="id"name="id" value="{{$attribute->codigo_cliente}}">
          <input type="hidden" id="idtienda" name="idtienda" value="{{$attribute->id_tienda}}">
          
          <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Tiendas <span class="required">*</span>
            </label>
             <div class="col-md-7 col-sm-7 col-xs-12 multiselec required-show">
              <select multiple="multiple" id="id_tienda" name="id_tienda" required="required" class="form-control col-md-7 col-xs-12">
              </select>
             </div>
          </div>

      <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button id='btn-guardar' type="button" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/asociarclientes/asociartienda') }}" class="btn btn-danger" type="button">Cancelar</a>
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
    loadSelectInput("#id_zona","{{ url('/zona/getSelectList') }}");

    $('#id_zona').change(function(){
      saveAsociar('{{ url('/zona/getSelectListZonaTienda') }}', '#id_zona', '#id_tienda');   
      $('#id_tienda').multiSelect('refresh'); 
    });

    //Carga inicial de tiendas (si el usuario escogio)
    URL.setUrl(" {{ url('/asociarclientes/asociartienda/tiendasseleccionadas') }}" );
    runSeleccionadas('#id_tienda');
    $('#id_tienda').multiSelect({
      selectableHeader: "<div class='custom-header'>Tiendas Sistema</div>",
      selectionHeader: "<div class='custom-header'>Tiendas Asociadas</div>",
    });
    
    //Vamo a guardar 
    URL.setUrl(" {{ url('/asociarclientes/asociartienda/create') }}" );
    URL.setRedirec(" {{ url('/asociarclientes/asociartienda') }}" );
    $('#btn-guardar').click(function(){
      runAsociaciones();
    });
@endsection

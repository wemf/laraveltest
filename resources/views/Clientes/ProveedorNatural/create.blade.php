@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="col-md-11  " style="float:none !important;">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Proveedor Persona Natural</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="javascript:void(0)" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}  
            @include('FormMotor/message')  
          <div id="tabs">
            <ul class="tabs-nav">
              <li class="tabs-1"><a href="#tabs-1">Datos Generales</a></li>
              {{-- <li class="tabs-2"><a href="#tabs-2">Datos Familiares</a></li>
              <li class="tabs-3"><a href="#tabs-3">Información Académica</a></li>
              <li class="tabs-4"><a href="#tabs-4">Información Laboral</a></li>
              <li class="tabs-5"><a href="#tabs-5">Sucursales</a></li> --}}
            </ul>
            <div id="tabs-1" class="contenido-tab">
              @include('Clientes/ProveedorNatural/crear/tab_1')  
            </div>
            {{-- <div id="tabs-2" class="contenido-tab" >
              @include('Clientes/ProveedorNatural/crear/tab_2')  
            </div>
            <div id="tabs-3" class="contenido-tab">
              @include('Clientes/ProveedorNatural/crear/tab_3')  
            </div>
            <div id="tabs-4" class="contenido-tab">
              @include('Clientes/ProveedorNatural/crear/tab_4')  
            </div>
            <div id="tabs-5" class="contenido-tab">
              @include('Clientes/ProveedorNatural/crear/tab_5')  
            </div> --}}
            <!-- Se agregan dos variables para la manipulación de creación de contrato contra la creación del cliente -->
          </div>    
          <br>
          <div class="form-group">
            <div class="col-md-2 col-sm-2 col-xs-2 col-md-offset-4">
               <button type="submit" class="btn btn-success form-control">Guardar</button>
              {{-- <button class="btn btn-primary" type="reset">Restablecer</button>  --}}              
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 col-md-offset-0">
              <a href="{{ url('/clientes/proveedor/persona/natural') }}" class="btn btn-danger form-control" type="button">Cancelar</a>
            </div>
          </div>
        </form>
                
      </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/clientes/personaNatural/personaNatural.js')}}"></script>
    <script src="{{asset('/js/clientes/personaNatural/crear/tab_1.js')}}"></script>
    <script src="{{asset('/js/clientes/clientes.js')}}"></script>

@endpush
@section('javascript')   
    URL.setUrlList("{{ url('/clientes/persona/natural/getSelectList') }}");
    URL.setUrlListById("{{ url('/clientes/persona/natural/getSelectListById') }}");
    {{--  URL.setCompletePersonas("{{ url('/clientes/empleado/getAutoComplete') }}");  --}}
    URL.setAction("{{ url('/clientes/proveedor/persona/natural/create') }}");
    URL.setUrlListTipoDoc("{{ url('/clientes/getTipoDoc') }}");
    URL.setTiendaZona("{{ url('/clientes/empleado/getTiendaZona/') }}");
    URL.setCombos("{{ url('/clientes/empleado/getCombos/') }}");
    URL.setDate('{{ $date }}');
    URL.setEmpleado(" {{ url('/clientes/empleado/getEmpleadoIden') }} ");
    URL.setTipoDocumento(" {{ url('/clientes/tipodocumento/getAlfanumerico') }} ");
    URL_CLIENTE.getEmpleadoActualizar("{{ url('/clientes/empleado/update') }}");
    URL_CLIENTE.getPersonaNaturalActualizar("{{ url('/clientes/persona/natural/update') }}");
    URL_CLIENTE.getProveedorNaturalActualizar("{{ url('/clientes/proveedor/persona/natural/update') }}");

@endsection

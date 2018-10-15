@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

  <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Crear Empleado</h2>
          <div class="text-right">
            <!-- <button type="button" class="btn btn-primary" id="btnCrearUsuario">Asignación de usuario</button> -->
          </div>
        </div>
        <div id="div_msg_usuario"></div>
        <div class="modal" id="modalRevisor">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Agregar Tiendas</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">      
                    <form class="form-horizontal">
                        <div class="form-group">
                          <h5 class="modal-title">Este empleado es un Revisor, ¿Desea agregar mas tiendas?</h5>
                        </div>
                    </form>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="idUsuario">
              <button type="button" class="btn btn-success" id="RedirectAsociarTienda">Guardar</button>
              <!-- <button class="btn btn-primary" type="reset">Restablecer</button> -->
              <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelarAsociarTienda">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
        <div class="x_content">
          <br />
          <form id="form-attribute" action="javascript:void(0)" method="POST" class="form-horizontal form-label-left">
              {{ csrf_field() }}  
              @include('message')  
            <input type="hidden" id="id_role_crear_usuario" name="id_role_crear_usuario">
            <input type="hidden" id="email_crear_usuario" name="email_crear_usuario">
            <input type="hidden" id="name_crear_usuario" name="name_crear_usuario">
            <input type="hidden" id="modo_ingreso_crear_usuario" name="modo_ingreso_crear_usuario">
            <div id="tabs">
              <ul class="tabs-nav">
                <li class="tabs-1 tab-seleccionado"><a href="#tabs-1">Datos Generales</a></li>
                <li class="tabs-2"><a href="#tabs-2">Información Contractual</a></li>
                <li class="tabs-3"><a href="#tabs-3">Datos Familiares</a></li>
                <li class="tabs-4"><a href="#tabs-4">Información Académica</a></li>
                <li class="tabs-5"><a href="#tabs-5">Información Laboral</a></li>
                <li class="tabs-6"><a href="#tabs-6">Novedad de Empleado</a></li>
              </ul>
              <div id="tabs-1" class="contenido-tab">
                @include('Clientes/Empleado/crear/tab_1')  
              </div>
              <div id="tabs-2" class="contenido-tab">
                @include('Clientes/Empleado/crear/tab_2')  
              </div>
              <div id="tabs-3" class="contenido-tab">
                @include('Clientes/Empleado/crear/tab_3')  
              </div>
              <div id="tabs-4" class="contenido-tab">
                @include('Clientes/Empleado/crear/tab_4')  
              </div>
              <div id="tabs-5" class="contenido-tab">
                @include('Clientes/Empleado/crear/tab_5')  
              </div>
              <div id="tabs-6" class="contenido-tab">
                @include('Clientes/Empleado/crear/tab_6')   
              </div>
            </div>    
            
            <br>
             
              <div class="col-md-2 col-sm-2 col-xs-2 col-md-offset-4">
                <a href="{{ url('/clientes/empleado') }}" class="btn btn-danger form-control" type="button">Cancelar</a>
              </div>
          </form>
          
        </div>
      </div>
  </div>
@endsection

@push('scripts')
    <script src="{{asset('/js/clientes/clientes.js')}}"></script>
    <script src="{{asset('/js/empleado.js')}}"></script>
    <script src="{{asset('/js/clientes/empleados/crear/tab_1.js')}}"></script>
@endpush

@section('javascript')   
    //<script>
    URL.setAction("{{ url('/clientes/empleado/create') }}");
    URL.setUrlList("{{ url('/clientes/empleado/getSelectList') }}");
    URL.setUrlListById("{{ url('/clientes/empleado/getSelectListById') }}");
    URL.setUrlListFranquicia("{{ url('/franquicia/getSelectList') }}");
    URL.setUrlListSociedadByFranquicia("{{ url('/sociedad/getSelectListFranquiciaSociedad') }}");
    URL.setCompleteEmpleados("{{ url('/clientes/empleado/getAutoComplete') }}");
    URL.setTiendaZona("{{ url('/clientes/empleado/getTiendaZona/') }}");
    URL.setCombos("{{ url('/clientes/empleado/getCombos/') }}");
    URL.setDate('{{ $date }}');
    URL.setEmpleado(" {{ url('/clientes/empleado/getEmpleadoIden') }} ");
    URL.setTipoDocumento(" {{ url('/clientes/tipodocumento/getAlfanumerico') }} ");
    URL.setEmpleadoActu(" {{ url('/clientes/empleado/update/') }} ");
    URL.setEmpleadoSociedad("{{ url('/clientes/empleado/getSociedad') }}");
    URL.setParametroGeneral("{{ url('/clientes/empleado/getparametroGeneral') }}");
    URL.setTipoDocumento(" {{ url('/clientes/tipodocumento/getAlfanumerico') }} ");    
    URL_CLIENTE.setURLValidarDocumento("{{ url('/clientes/funciones/getValidarDocumento') }}");
    URL_CLIENTE.setEmpleadoActualizar("{{ url('/clientes/empleado/update') }}");
    URL_CLIENTE.setPersonaNaturalActualizar("{{ url('/clientes/persona/natural/update') }}");
    URL_CLIENTE.setProveedorNaturalActualizar("{{ url('/clientes/proveedor/persona/natural/update') }}");
    URL_CLIENTE.setActualizarThis("{{ url('/clientes/empleado/update') }}");
    // runPersistenceForm();
@endsection

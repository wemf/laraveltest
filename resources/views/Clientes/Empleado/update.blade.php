@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Empleado</h2>
        <div class="text-right">
          <button type="button" class="btn btn-primary" id="asignacion">Asignación de usuario</button>
        </div>
      </div>

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

      <div class="modal" id="modalUser">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Creación de nuevo usuario</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">      
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="id_role" class="col-md-4 control-label">Rol</label>
                            <div class="col-md-6">
                                <select type="text" class="form-control" id="id_role" name="id_role"  value="{{ old('id_role') }}" required autofocus>
                                  <option value="">- Seleccione una opción -</option>
                                  @foreach($role as $tipo)
                                  <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                  @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Nombres</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" maxlength="100" value="{{$attribute->nombres}} {{$attribute->primer_apellido}} {{$attribute->segundo_apellido}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{$attribute->correo_electronico}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="modo_ingreso" class="col-md-4 control-label">Modo de ingreso</label>

                            <div class="col-md-6">
                              <select id="modo_ingreso" name="modo_ingreso" class="form-control" required="required">
                                    <option value="">- Seleccione una opción -</option>
                                    <option value="0">Lector biométrico</option>
                                    <option value="1">Numero de identificación</option>
                                </select>  
                            </div>
                        </div>
                    </form>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="idUsuario" value="{{ $attribute->id_usuario }}">
              <button type="submit" class="btn btn-success" id="guardarUser">Guardar</button>
              <button type="submit" class="btn btn-success" id="actualizarUser">Guardar</button>
              <!-- <button class="btn btn-primary" type="reset">Restablecer</button> -->
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="javascript:void(0)" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')  
          <div id="tabs">
            <ul class="tabs-nav">
              <li class="tabs-1"><a href="#tabs-1">Datos Generales</a></li>
              <li class="tabs-2"><a href="#tabs-2">Información Contractual</a></li>
              <li class="tabs-3"><a href="#tabs-3">Datos Familiares</a></li>
              <li class="tabs-4"><a href="#tabs-4">Información Académica</a></li>
              <li class="tabs-5"><a href="#tabs-5">Información Laboral</a></li>
              <li class="tabs-6"><a href="#tabs-6">Novedad de Empleado</a></li>
            </ul>
            <div id="tabs-1" class="contenido-tab">
              @include('Clientes/Empleado/actualizar/tab_1')  
            </div>
            <div id="tabs-2" class="contenido-tab">
              @include('Clientes/Empleado/actualizar/tab_2')  
            </div>
            <div id="tabs-3" class="contenido-tab">
              @include('Clientes/Empleado/actualizar/tab_3')  
            </div>
            <div id="tabs-4" class="contenido-tab">  
              @include('Clientes/Empleado/actualizar/tab_4')  
            </div>
            <div id="tabs-5" class="contenido-tab">
              @include('Clientes/Empleado/actualizar/tab_5')  
            </div>
            <div id="tabs-6" class="contenido-tab">
              @include('Clientes/Empleado/actualizar/tab_6')  
            </div>  
        
      </div>
            <br>
              <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                <div class="form-group">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="{{ $attribute->id_usuario }}">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button class="btn btn-primary" type="reset">Restablecer</button>
                    <a href="{{ url('/clientes/empleado') }}" class="btn btn-danger" type="button">Cancelar</a>
                </div>
              </div> 
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/empleado.js')}}"></script>
    <script src="{{asset('/js/clientes/clientes.js')}}"></script>
    <script src="{{asset('/js/clientes/empleados/actualizar/tab_1.js')}}"></script>
@endpush
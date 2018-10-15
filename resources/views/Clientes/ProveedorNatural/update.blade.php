@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="col-md-11" style="float:none !important;">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Proveedor Persona Natural</h2>
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
              <input type="hidden" name="id_tipo_cliente" value="3">
              @include('Clientes/ProveedorNatural/actualizar/tab_1')  
            </div>
            {{-- <div id="tabs-2" class="contenido-tab">
              @include('Clientes/ProveedorNatural/actualizar/tab_2')  
            </div>
            <div id="tabs-3" class="contenido-tab">
              @include('Clientes/ProveedorNatural/actualizar/tab_3')  
            </div>
            <div id="tabs-4" class="contenido-tab">
              @include('Clientes/ProveedorNatural/actualizar/tab_4')  
            </div>
            <div id="tabs-5" class="contenido-tab">
              @include('Clientes/ProveedorNatural/actualizar/tab_5')  
            </div> --}}
          </div>    
          <br>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="hidden" id="codigo_cliente" name="codigo_cliente" value="{{$attribute->codigo_cliente}}">
              <input type="hidden" id="hd_id_tienda" name="id_tienda_actual" value="{{$attribute->id_tienda}}" >
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/clientes/proveedor/persona/natural') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
           @if(isset($id_tipo_cliente_enviado))
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="hidden" id="id_tipo_cliente_enviado" name="id_tipo_cliente_enviado" value="{{$id_tipo_cliente_enviado}}">
            </div>
          @endif
        </form>
        
      </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/clientes/personaNatural/personaNatural.js')}}"></script>
    <script src="{{asset('/js/clientes/personaNatural/actualizar/tab_1.js')}}"></script>
    <script src="{{asset('/js/clientes/clientes.js')}}"></script>

@endpush

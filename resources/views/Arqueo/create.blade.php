@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

  <div class="col-md-12">
      <div class="x_panel">
          <h2>Arqueo de caja</h2>
        <div id="div_msg_usuario"></div>
        <div class="x_content">
          <br />
          <form id="form-attribute" action="{{ url('/tesoreria/arqueo/generatepdf') }}" method="POST" class="form-horizontal form-label-left">
              {{ csrf_field() }}  
              @include('message')  
            <div id="tabs">
              <ul class="tabs-nav">
                <li class="tabs-1 tab-seleccionado"><a href="#tabs-1">Saldos del Sistema</a></li>
                <li class="tabs-2"><a href="#tabs-2">Conteo del Efectivo de Caja Menor</a></li>
                <li class="tabs-3"><a href="#tabs-3">Saldo del Arqueo</a></li>
              </ul>
              <div id="tabs-1" class="contenido-tab">
                @include('Arqueo/crear/tab_1')  
              </div>
              <div id="tabs-2" class="contenido-tab">
              @include('Arqueo/crear/tab_2')                
              </div>
              <div id="tabs-3" class="contenido-tab">
              @include('Arqueo/crear/tab_3')              
              </div>
            </div>    
            
            <br>
          </form>
          
        </div>
      </div>
  </div>
@endsection

@push('scripts')
    <script src="{{asset('/js/tesoreria/arqueo.js')}}"></script>
    <script src="{{asset('/js/tesoreria/tabs.js')}}"></script>
@endpush

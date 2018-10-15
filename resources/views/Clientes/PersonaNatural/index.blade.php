@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Cliente Persona Natural</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('Trasversal.Boton.botonCrud', ['href' => "/clientes/persona/natural/create"])
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    @include('Trasversal.Filtros.cabeceraDatatable')
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
          <tr>            
              <th>Joyería</th> 
              <th>Tipo de Documento</th>  
              <th>Número de Documento</th>  
              <th>Apellidos</th>  
              <th>Nombres</th> 
              <th>Teléfono</th>  
              <th>Correo Electrónico</th>  
              <th>Estado</th>  
              <th class="hide"></th>  
              <th class="hide"></th>  
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@push('scripts')
   <script src="{{asset('/js/clientes/personaNatural/personaNatural.js')}}"></script>
   <script src="{{asset('js/Trasversal/Filtros/cabeceraDatatable.js')}}"></script>
@endpush

@section('javascript')   
  @parent
    URL.setUpdateAction("{{ url('/clientes/persona/natural/update') }}");
    URL.setDeletedAction("{{ url('/clientes/persona/natural/delete') }}");
    URL.setActivateAction("{{ url('/clientes/persona/natural/active') }}");

   column=[           
            { "data": "tienda" },
            { "data": "tipo_documento" },
            { "data": "numero_documento" },
            { "data": "apellidos" },
            { "data": "nombre" },
            { "data": "telefono" },
            { "data": "correo_electronico" },
            { "data": "estado" },
            { "data": "", "visible": false },
            { "data": "", "visible": false },
        ];
  	dataTableActionFilter("{{url('/clientes/persona/natural/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)
      
    url2=urlBase.make('clientes/tipodocumento/getSelectList2');
    loadSelectInput('#col5_filter', url2, true);

@endsection
@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Cliente proveedor/Persona Natural</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('Trasversal.Boton.botonCrud', ['href' => "/clientes/proveedor/persona/natural/create"])
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
              <th>Dirección</th>  
              <th>Correo Electrónico</th>  
              <th>Estado</th>  
              <th class="hide"></th>  
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('js/Trasversal/Filtros/cabeceraDatatable.js')}}"></script>
@endpush
@section('javascript')   
  @parent
   column=[           
            { "data": "tienda" },
            { "data": "tipo_documento" },
            { "data": "numero_documento" },
            { "data": "apellidos" },
            { "data": "nombre" },
            { "data": "telefono" },
            { "data": "direccion" },
            { "data": "correo_electronico" },
            { "data": "estado" },
            { "data": "" },
        ];
  	dataTableActionFilter("{{url('/clientes/proveedor/persona/natural/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column ,3)

       $("#updateAction1").click(function() {
      var url2="{{ url('/clientes/proveedor/persona/natural/update') }}";
      updateRowDatatableAction(url2)
    });
    
    $("#deletedAction1").click(function() { 
      var url2="{{ url('/clientes/proveedor/persona/natural/delete') }}";
      deleteRowDatatableAction(url2);
    });

    $("#activatedAction1").click(function() { 
      var url2="{{ url('/clientes/proveedor/persona/natural/active') }}";
      deleteRowDatatableAction(url2, "¿Activar el registro?");
    });

@endsection
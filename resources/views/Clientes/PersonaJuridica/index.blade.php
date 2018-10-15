@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Cliente Persona Jurídica</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('Trasversal.Boton.botonCrud', ['href' => "/clientes/persona/juridica/create"])
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    @include('Trasversal.Filtros.cabeceraDatatable')
    <table id="dataTableAction" class="display esconder" width="100%" cellspacing="0">
        <thead>
          <tr>            
              <th>Joyería</th> 
              <th>Nit</th>  
              <th>Nombres</th> 
              <th>Teléfono</th>  
              <th>Dirección</th>  
              <th>Correo Electrónico</th>  
              <th>Estado</th>  
              <th class="hide"></th>  
              <th class="hide"></th>  
              <th class="hide"></th>  
          </tr>
      </thead>        
    </table>
  </div>
</div>

<style>
  #filter_col5{
    display: none !important;
  }
  #filter_col8{
    display: none !important;
  }
</style>

@endsection

@section('javascriptpr') 
  $("#filter_col6 span").text("Nit");
@endsection

@push('scripts')
    <script src="{{asset('js/Trasversal/Filtros/cabeceraDatatable.js')}}"></script>
@endpush
@section('javascript')   
  @parent
  
   column=[           
            { "data": "tienda" },
            { "data": "numero_documento" },
            { "data": "nombre" },
            { "data": "telefono" },
            { "data": "direccion" },
            { "data": "correo_electronico" },
            { "data": "estado" },
            { "data": "", "visible": false  },
            { "data": "", "visible": false },
            { "data": "", "visible": false }, 
        ];
  	dataTableActionFilter("{{url('/clientes/persona/juridica/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column ,2)
    
    $("#updateAction1").click(function() {
      var url2="{{ url('/clientes/persona/juridica/update') }}";
      updateRowDatatableAction(url2)
    });
    
    $("#deletedAction1").click(function() { 
      var url2="{{ url('/clientes/persona/juridica/delete') }}";
      deleteRowDatatableAction(url2);
    });

    $("#activatedAction1").click(function() { 
      var url2="{{ url('/clientes/persona/juridica/active') }}";
      deleteRowDatatableAction(url2, "¿Activar el registro?");
    });

@endsection
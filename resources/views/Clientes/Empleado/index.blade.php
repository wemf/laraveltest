@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Empleado</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('Trasversal.Boton.botonCrud', ['href' => '/clientes/empleado/create'])
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    @include('Trasversal.Filtros.cabeceraDatatable2')
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
          <tr>            
              <th>Tienda</th> 
              <th>Tipo de Documento</th>  
              <th>No. Documento</th>  
              <th>Tipo Cliente</th>  
              <th>Cargo</th>  
              <th>Nombres y Apellidos</th> 
              <th>Celular</th> 
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

@endsection

@push('scripts')
    <script src="{{asset('js/Trasversal/Filtros/cabeceraDatatable.js')}}"></script>
@endpush

@section('javascript')   
  @parent

  $(document).ready(function(){
    $('.button_filter').click();
  });

   column=[  
            { "data": "Tienda" },
            { "data": "Tipo_Dumento" },
            { "data": "Numero_Documento" },
            { "data": "tipo_cliente" },
            { "data": "cargo" },
            { "data": "Nombres" },           
            { "data": "Celular" },
            { "data": "correo_electronico" },
            { "data": "estado" },
            { "data": "", "visible": false },
            { "data": "", "visible": false },
            { "data": "", "visible": false }
        ];
  	dataTableActionFilter("{{url('/clientes/empleado/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)
    
    var url2=urlBase.make('/clientes/tipodocumento/getSelectList2');
    loadSelectInput('#col5_filter', url2, true);

    $("#updateAction1").click(function() {
      var url2="{{ url('/clientes/empleado/update') }}";
      updateRowDatatableAction(url2)
    });

    $("#deletedAction1").click(function() { 
    var url2 = "{{ url('/clientes/empleado/delete') }}";
    deleteRowDatatableAction(url2);
    });
    
    $("#activatedAction1").click(function() { 
      var url2="{{ url('/clientes/empleado/active') }}";
      deleteRowDatatableAction(url2, "¿Activar el registro?");
    });

@endsection
@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')

    <div class="x_panel">
        <div class="x_title">
            <h2>Modificar Cláusulas</h2>
            <div class="clearfix">
                <div class="btn-group pull-right espacio" role="group" >                        
                    @if(Auth::user()->role->id==env('ROLE_SUPER_ADMIN')) 
                     <a title="Nuevo Registro" href="{{ url('/modificarClausulas/create') }}"  id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
                    @endif
                    <button title="Ver Registro Seleccionado"  id="viewAction1" type="button" class="btn btn-primary"><i class="fa fa-eye"></i> Ver</button>
                    <button title="Actualizar Registro Seleccionado"  id="updateAction1"  type="button" class="btn btn-warning"><i class="fa fa-pencil-square-o  "></i> Actualizar</button> 
                </div>
            </div>
        </div>
        
        <div class="x_content">  
            {{-- Data Table Information List --}}
            <table id="dataTableAction" class="display" width="100%" cellspacing="0" align="center">
                <thead class="thead">
                    <tr>
                        <th>País</th>
                        <th>Departamento</th>
                        <th>Ciudad</th>
                        <th>Joyería</th>
                        <th>Nombre Cláusula</th>
                        <th>Desde</th>                        
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
        { "data": "pais"},
        { "data": "departamento"},
        { "data": "ciudad"},
        { "data": "tienda"},
        { "data": "nombre_clausula"},
        { "data": "vigencia_desde"}
        

        

    ];
    dataTableActionFilter("{{ url('/modificarClausulas/get') }}","{{ url('/plugins/datatable/DataTables-1.10.13/json/spanish.json') }}",column);
    
    $("#viewAction1").click(function() {
        var url2="{{ url('/modificarClausulas/view') }}";
        updateRowDatatableAction(url2)
    });
    
      $("#updateAction1").click(function() {
        var url2="{{ url('/modificarClausulas/update') }}";
        updateRowDatatableAction(url2)
      });
      
     
  
      
@endsection
@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
  <h2>Asignar Roles</h2>
  <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <button onclick="updateRowRolAction('{{url('/users/roles/module/view/function')}}')" class="btn btn-success"><i class="fa fa-plus"></i> Asignar Funcionalidad</button>
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
      <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
        <tbody>
            <tr id="filter_col0" data-column="0">
                <td>Rol<input type="text" class="column_filter form-control" id="col0_filter"></input></td>
            </tr>      
            <tr>
                <td><button type="text" class="btn btn-primary button_filter2 button_filter"><i class="fa fa-search"></i> Buscar</button></td>
            </tr>
        </tbody>
      </table>
    </div>
      <table id="dataTableAction" class="display" width="100%" cellspacing="0">
         <thead>
            <tr>  
                <th>Rol</th>   
                <th>Descripción</th> 
                <th>Estado</th> 
            </tr>
        </thead>       
      </table>

  </div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('/js/autenticacion/administrator/roles.js')}}"></script>
@endpush


@section('javascript') 
  URL.setSpanishModule("{{url('/plugins/datatable/DataTables-1.10.13/json/spanishModule.json')}}");
  URL.setList("{{route('admin.roles.list')}}");
  URL.loadDataTable(); 
@endsection
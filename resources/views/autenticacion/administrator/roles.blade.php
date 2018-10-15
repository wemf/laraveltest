@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="x_panel">
  <div class="x_title">
  <h2>Administrar Roles</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('Trasversal.Boton.botonCrud',['href'=>'/users/roles/create'])   
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
      <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
        <tbody>
            <tr id="filter_col0" data-column="0">
                <td>Rol<input type="text" class="column_filter form-control" id="col0_filter"></input></td>
            </tr> 
            <tr id="filter_col1" data-column="1">
                <td align="center">
                    Inactivo <br>
                    <input type="checkbox" onchange="intercaleCheckInvert(this);" class="column_filter form-control check-control" id="col1_filter" value="1">
                    <label for="col1_filter" class="lbl-check-control" style="font-size: 27px; font-weight: 100; margin-top: 5px;"></label>
                </td>
            </tr>     
            <tr>
                <td><button type="text" onclick="intercaleFunction('col1_filter');"  class="btn btn-primary button_filter2 button_filter"><i class="fa fa-search"></i> Buscar</button></td>
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
  URL.setUpdate("{{ route('admin.roles.update') }}");
  URL.setDelete("{{ url('/users/roles/delete')}}");
  URL.loadDataTable();
@endsection
@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
  <h2>Administrar Usuarios</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <a href="{{ route('register') }}" title="Nuevo Usuario" type="button" class="btn btn-success hide"><i class="fa fa-plus  "></i> Nuevo</a>
      <button title="Actualizar Registro Seleccionado"  id="updateAction1" type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o "></i> Actualizar</button>
      <button title="Desactivar Registro Seleccionado"  id="deletedAction1"  type="button" class="btn btn-orange"><i class="fa fa-times-circle "></i> Desactivar</button>
      <button title="Activar Registro Seleccionado"  id="activatedAction1"  type="button" class="btn btn-warning hide"><i class="fa fa-check "></i> Activar</button>       
    </div>
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
      <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
        <tbody>
            <tr id="filter_col0" data-column="0">
                <td>Rol<select type="text" class="column_filter form-control" id="col0_filter"></select></td>
            </tr>
            <tr id="filter_col1" data-column="1">
                <td>Nombre<input type="text" class="column_filter form-control" id="col1_filter"></td>
            </tr>
            <tr id="filter_col2" data-column="2">
                <td>Email<input type="text" class="column_filter form-control" id="col2_filter"></td>
            </tr>
            <tr id="filter_col3" data-column="3">
                <td align="center">
                    Inactivo <br>
                    <input type="checkbox" onchange="intercaleCheckInvert(this);" class="column_filter form-control check-control" id="col3_filter" value="1">
                    <label for="col3_filter" class="lbl-check-control" style="font-size: 27px; font-weight: 100; margin-top: 5px;"></label>
                </td>
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
                <th>Nombre</th>          
                <th>Email</th> 
                <th>Activo</th>	
            </tr>
        </thead>       
      </table>

  </div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('/js/autenticacion/administrator/users.js')}}"></script>
@endpush

@section('javascript') 
    URL.setSpanishModule("{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}");
    URL.setRoles("{{route('roles')}}");
    URL.setListUser("{{route('listUser')}}");  
    URL.setUpdate("{{ url('/users/update') }}");  
    URL.setActivated("{{ url('/users/is/activated')}}");  
    USERS.list();  
@endsection
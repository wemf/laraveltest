@extends('layouts.master')

@section('content')

<div class="x_panel">
  <div class="x_title">
  <h2>Generear Link de Inicio de Sesión</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <button title="Generar Inicio Sesión y enviar por Email"  id="updateAction1" type="button" class="btn btn-success"><i class="fa fa-send "></i> Enviar por Email</button>
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
                    <input type="checkbox" onchange="intercaleCheck(this);" class="column_filter form-control check-control" id="col3_filter" value="0">
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
    URL.setUpdate("{{ url('/generate/token/user/') }}");  
    URL.setActivated("{{ url('/users/is/activated')}}");  
    USERS.list();  
@endsection
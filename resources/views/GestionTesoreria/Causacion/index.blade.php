@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')
@include('GestionTesoreria/Causacion/Modals/Pagar')         

<div class="x_panel">
    <div class="x_title">
      <h2>Causaciones</h2>
    <div class="clearfix"></div>
    </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
        <a title="Nuevo Registro" href="{{ url('/tesoreria/causacion/create') }}"  id="newAction" class="btn btn-success"><i class="fa fa-plus "></i> Nuevo</a>
        <button title="Revisar Registro Seleccionado"  id="updateAction1" type="button" class="btn btn-info"><i class="fa fa-pencil-square-o "></i> Revisar</button>       
        <!-- <a title="Pagar Registro Seleccionado"  id="payAction" href="#" class="btn btn-primary"><i class="fa fa-credit-card "></i> Pagar</a> -->
        <!-- <a title="Anular Registro Seleccionado"  id="cancelAction" href="#" class="btn btn-danger"><i class="fa fa-exclamation-circle "></i> Anular</a> -->
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
            <tbody>
                @if((Auth::user()->role->id==env('ROL_TESORERIA')) || (Auth::user()->role->id==env('ROLE_SUPER_ADMIN')))            
                <tr id="filter_col0" data-column="0">
                    <td>País<select class="column_filter form-control" id="col0_filter"></select></td>
                </tr>

                <tr id="filter_col1" data-column="1">
                    <td>Departamento<select class="column_filter form-control" id="col1_filter"></select></td>
                </tr>

                <tr id="filter_col2" data-column="2">
                    <td>Ciudad<select class="column_filter form-control" id="col2_filter">
                    <option value>-Seleccione una opción-</option>
                    </select></td>
                </tr>

                <tr id="filter_col3" class="hide" data-column="3">
                    <td>Zona<select class="column_filter form-control" id="col3_filter"></select></td>
                </tr>

                <tr id="filter_col4" data-column="4">
                    <td>Joyer&iacute;a<select class="column_filter form-control" id="col4_filter">
                    <option value>-Seleccione una opción-</option>
                    </select></td>
                </tr>
                @else
                <tr id="filter_col4" data-column="4">
                    <td>Joyer&iacute;a
                        <select class="column_filter form-control" id="col4_filter" disabled>
                            <option type="text" id="tienda" name="tienda" class="form-control" value='{{$Tienda->id}}'>{{$Tienda->nombre}}</option>
                        </select>
                    </td>
                </tr>                
                @endif
                
                <tr id="filter_col5" data-column="5">
                    <td>Estado<select class="column_filter form-control" id="col5_filter">
                    <option value>-Seleccione una opción-</option>
                    </select></td>
                </tr>

                <tr id="filter_col6" data-column="6">
                    <td>Fecha Creado 
                        <input type="text" class="column_filter form-control data-picker-only" id="col6_filter" name="fecha_creacion" maxlength="10" placeholder="Desde">
                    </td>
                </tr>
                <tr id="filter_col7" data-column="7">
                    <td>Tipo Causación <select class="column_filter form-control" id="col7_filter">
                    <option value>-Seleccione una opción-</option>
                    </select></td>
                </tr>

                <tr id="filter_col8" data-column="8">
                    <td><input class="column_filter" id="col8_filter" type="hidden" value='1'></td>
                </tr>

                <tr>
                    <td><button type="text" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>

            </tbody>
        </table>
    </div>
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
      <thead>
          <tr>               
              <th>Código</th>
              <th>Joyer&iacute;a</th>
              <th>Estado</th> 
              <th>Fecha Creación</th> 
              <th>Tipo Causación</th> 
              <th>Usuario</th> 
              <th>Fecha Actualizado</th>              
              <th>Valor</th> 
              <th class="hide"></th> 
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection
@push('scripts')
    <script src="{{asset('/js/tesoreria/indexcausacion.js')}}"></script>
@endpush
@section('javascript')   
  @parent
   column=[           
            { "data": "DT_RowId" },
            { "data": "tienda" },
            { "data": "estado" },
            { "data": "fecha_creado" },
            { "data": "tipo_causacion" },
            {"data": "usuario"},
            {"data": "fecha_actualizado"},            
            {"data": "valor"},
            { "data": "", "visible": false, },            
        ];
  	dataTableActionFilter("{{url('/tesoreria/causacion/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)
@endsection
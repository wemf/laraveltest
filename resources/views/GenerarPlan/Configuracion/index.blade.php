@extends('layouts.master') 
@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
        <h2>Configuraciones de Plan Separe</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="btn-group pull-right espacio" role="group" aria-label="...">
            <a href="{{ url('/gestionplan/config/create') }}" title="Agregar Nuevo Registro" type="button" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
            <button title="Actualizar Registro Seleccionado" id="updateAction1" type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o "></i> Actualizar</button>
            <button title="Desactivar Registro Seleccionado" id="deletedAction1" type="button" class="btn btn-orange"><i class="fa fa-times-circle "></i> Desactivar</button>
            <button title="Activar Registro Seleccionado" id="activatedAction1" type="button" class="btn btn-warning hide"><i class="fa fa-check "></i> Activar</button>
            <button title="Eliminar Registro Seleccionado" id="deletedAction2" type="button" class="btn btn-danger"><i class="fa fa-times-circle "></i> Eliminar</button>
        </div>
        <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
        <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
        <div class="contentfilter-table">
            <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
                <tbody>
                    <tr id="filter_col0" data-column="0">
                        <td>País<select class="column_filter form-control" id="col0_filter" onchange="loadSelectInputByParent('#col1_filter', '{{url('/departamento/getdepartamentobypais')}}', this.value, 1); loadSelectInputByParent('#col2_filter', this.value, 1)"></select></td>
                    </tr>
                    <tr id="filter_col1" data-column="1">
                        <td>Departamento<select class="column_filter form-control" id="col1_filter" onchange="loadSelectInputByParent('#col2_filter', '{{url('/ciudad/getciudadbydepartamento')}}', this.value, 1)"></select></td>
                    </tr>
                    <tr id="filter_col2" data-column="2">
                        <td>Ciudad<select class="column_filter form-control" id="col2_filter" onchange="loadSelectInputByParent('#col3_filter', this.value, 1)"></select></td>
                    </tr>
                    <tr id="filter_col3" data-column="3">
                        <td>Tienda<select class="column_filter form-control" id="col3_filter"></select></td>
                    </tr>
                    <tr id="filter_col4" data-column="4">
                        <td>Monto desde<input type="number" class="column_filter form-control" id="col4_filter"></td>
                    </tr>
                    <tr id="filter_col5" data-column="5">
                        <td>Monto hasta<input type="number" value="max" class="column_filter form-control" id="col5_filter"></td>
                    </tr>
                    <tr id="filter_col6" class="no-width" data-column="6">
                        <td>
                            Vigente 
                            <input type="checkbox" onchange="intercaleCheck(this);" id="col6_filter" class="column_filter check-control check-pos" value="1" checked="checked"/>
                            <label for="col6_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                        </td>
                    </tr>
                    <tr id="filter_col7" class="no-width" data-column="7">
                        <td>
                            Inactivos
                            <input type="checkbox" onchange="intercaleCheckInvert(this);" id="col7_filter" class="column_filter check-control check-pos" value="1" />
                            <label for="col7_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                        </td>
                    </tr>
                    <tr>
                        <td><button type="button" onclick="intercaleFunction('col7_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table id="dataTableAction" class="display" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>País</th>
                    <th>Departamento</th>
                    <th>Ciudad</th>
                    <th>Tienda</th>
                    <th>Monto Desde</th>
                    <th>Monto Hasta</th>
                    <th>Término de Plan Separe</th>
                    <th>Porcentaje de abono</th>
                    <th>Activo</th>	
                </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
    <script src="{{asset('/js/plansepare/filtroTiendasParametros.js')}}"></script>
@endpush
@endsection 
@section('javascript') 
@parent 
loadSelectInput("#col0_filter", "{{url('/pais/getpais')}}", 2);
SelectValPais("#col0_filter");
loadSelectInputByParent("#col1_filter", "{{url('/departamento/getdepartamentobypais')}}", $('#col0_filter').val(), 2);
loadSelectInputByParent("#col2_filter", "{{url('/ciudad/getciudadbydepartamento')}}", $('#col0_filter').val(), 2);
loadSelectInputByParent("#col3_filter", "{{url('/tienda/gettiendabyzona')}}", $('#col2_filter').val(), 2);
$("#col0_filter").change();
column=[ 
    { "data": "pais" }, 
    { "data": "departamento" }, 
    { "data": "ciudad" },  
    { "data": "tienda" }, 
    { "data": "monto_desde" }, 
    { "data": "monto_hasta" }, 
    { "data": "termino_contrato" }, 
    { "data": "porcentaje_retroventa" }, 
    { "data": "estado" },
]; 
dataTableActionFilter("{{url('/gestionplan/config/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column);
$("#updateAction1").click(function() { var url2="{{ url('/gestionplan/config/edit') }}"; updateRowDatatableAction(url2) }); 
$("#deletedAction1").click(function() { var url2="{{ url('/gestionplan/config/inactive') }}"; deleteRowDatatableAction(url2); }); 
$("#deletedAction2").click(function() { var url2="{{ url('/gestionplan/config/delete') }}"; deleteRowDatatableAction(url2, "¿Eliminar el registro?"); }); 
$("#activatedAction1").click(function() { var url2="{{ url('/gestionplan/config/active') }}"; deleteRowDatatableAction(url2, "¿Activar el registro?"); });
@endsection
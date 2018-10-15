@extends('layouts.master') 
@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
        <h2>Configuraciones Específicas de Contrato</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="btn-group pull-right espacio" role="group" aria-label="...">
            <a href="{{ url('/configcontrato/especifica/create') }}" title="Agregar Nuevo Registro" type="button" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
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
                    <tr id="filter_col8" data-column="7">
                        <td>País<select class="column_filter form-control" id="col7_filter" onchange="loadSelectInputByParent('#col8_filter', '{{url('/departamento/getdepartamentobypais')}}', this.value, 1); loadSelectInputByParent('#col1_filter', '{{url('/zona/getzonabypais')}}', this.value, 1)"></select></td>
                    </tr>
                    <tr id="filter_col9" data-column="8">
                        <td>Departamento<select class="column_filter form-control" id="col8_filter" onchange="loadSelectInputByParent('#col0_filter', '{{url('/ciudad/getciudadbydepartamento')}}', this.value, 1)"></select></td>
                    </tr>
                    <tr id="filter_col1" data-column="0">
                        <td>Ciudad<select class="column_filter form-control" id="col0_filter" onchange="loadSelectInputByParent('#col2_filter', '{{url('/tienda/gettiendabyzona')}}', this.value, 1)"></select></td>
                    </tr>
                    <tr id="filter_col2" data-column="1">
                        <td>Zona<select class="column_filter form-control" id="col1_filter"></select></td>
                    </tr>
                    <tr id="filter_col3" data-column="2">
                        <td>Tienda<select class="column_filter form-control" id="col2_filter"></select></td>
                    </tr>
                    <tr id="filter_col7" data-column="6">
                        <td>Categoría<select class="column_filter form-control" id="col6_filter"></select></td>
                    </tr>
                    <tr id="filter_col10" data-column="9">
                        <td>Calificación<select class="column_filter form-control" id="col9_filter"></select></td>
                    </tr>
                    <tr id="filter_col4" data-column="3">
                        <td>Monto desde<input type="number" class="column_filter form-control" id="col3_filter"></td>
                    </tr>
                    <tr id="filter_col5" data-column="4">
                        <td>Monto hasta<input type="number" value="max" class="column_filter form-control" id="col4_filter"></td>
                    </tr>
                    <tr id="filter_col6" class="no-width" data-column="5">
                        <td>
                            Vigente 
                            <input type="checkbox" onchange="intercaleCheck(this);" id="col5_filter" class="column_filter check-control check-pos" value="0"/>
                            <label for="col5_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                        </td>
                    </tr>
                    <tr id="filter_col11" class="no-width" data-column="10">
                        <td>
                            Inactivos
                            <input type="checkbox" onchange="intercaleCheckInvert(this);" id="col10_filter" class="column_filter check-control check-pos" value="1" />
                            <label for="col10_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                        </td>
                    </tr>
                    <tr>
                        <td><button type="button" onclick="intercaleFunction('col10_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
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
                    <th>Categoría</th>
                    <th>Calificación</th>
                    <th>Monto Desde</th>
                    <th>Monto Hasta</th>
                    <th>Vigencia Desde</th>
                    <th>Vigencia Hasta</th>
                    <th>Término de Contrato</th>
                    <th>Porcentaje de Retroventa</th>
                    <th>Días de Gracia</th>
                    <th>Activo</th>	
                </tr>
            </thead>
        </table>
    </div>
</div>

@push('scripts')
    <script src="{{asset('/js/configcontrato/especifica.js')}}"></script>
@endpush

@endsection @section('javascript') @parent loadSelectInput("#col6_filter", "{{url('/products/categories/getCategory')}}",2);
loadSelectInput("#col7_filter", "{{url('/pais/getpais')}}", 2);
SelectValPais("#col7_filter");
loadSelectInput("#col9_filter", "{{url('/calificacion/getcalificacion')}}",2);
loadSelectInputByParent("#col8_filter", "{{url('/departamento/getdepartamentobypais')}}", $('#col7_filter').val(), 2);
loadSelectInputByParent("#col0_filter", "{{url('/ciudad/getciudadbydepartamento')}}", $('#col7_filter').val(), 2);
loadSelectInputByParent("#col2_filter", "{{url('/tienda/gettiendabyzona')}}", $('#col0_filter').val(), 2);
loadSelectInputByParent("#col1_filter", "{{url('/zona/getzonabypais')}}", $('#col8_filter').val(), 2);
$("#col7_filter").change();
column=[ 
    { "data": "pais" }, 
    { "data": "departamento" }, 
    { "data": "ciudad" },  
    { "data": "tienda" }, 
    { "data": "categoria" }, 
    { "data": "calificacion"}, 
    { "data": "monto_desde" }, 
    { "data": "monto_hasta" }, 
    { "data": "vigencia_desde" }, 
    { "data": "vigencia_hasta" }, 
    { "data":"termino_contrato" }, 
    { "data": "porcentaje_retroventa" }, 
    { "data": "dias_gracia" },
    { "data": "estado" },
]; 
dataTableActionFilter("{{url('/configcontrato/especifica/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column);
$("#updateAction1").click(function() { var url2="{{ url('/configcontrato/especifica/edit') }}"; updateRowDatatableAction(url2) }); 
$("#deletedAction1").click(function() { var url2="{{ url('/configcontrato/especifica/inactive') }}"; deleteRowDatatableAction(url2); }); 
$("#deletedAction2").click(function() { var url2="{{ url('/configcontrato/especifica/delete') }}"; deleteRowDatatableAction(url2, "¿Eliminar el registro?"); }); 
$("#activatedAction1").click(function() { var url2="{{ url('/configcontrato/especifica/active') }}"; deleteRowDatatableAction(url2, "¿Activar el registro?"); });
@endsection
@extends('layouts.master') 

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
        <h2>Aplicaciones de Retroventa</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="btn-group pull-right espacio" role="group" aria-label="...">
            <a href="{{ url('/configcontrato/apliretroventa/create') }}" title="Agregar Nuevo Registro" type="button" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
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
                        <td>País<select type="text" class="column_filter form-control" id="col0_filter"></select></td>
                    </tr>
                    <tr id="filter_col1" data-column="1">
                    <td>Departamento
                        <select type="text" class="column_filter form-control" id="col1_filter">
                            <option value="">- Seleccione una Opción -</option>
                        </select>
                    </td>
                    </tr>
                    <tr id="filter_col2" data-column="2">
                        <td>Ciudad
                        <select type="text" class="column_filter form-control" id="col2_filter">
                            <option value="">- Seleccione una Opción -</option>
                        </select>
                        </td>
                    </tr>
                    <tr id="filter_col3" data-column="3" class="hide">
                        <td>Zona
                            <select type="text" class="column_filter form-control" id="col3_filter">
                                <option value="">- Seleccione una Opción -</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="filter_col4" data-column="4">
                        <td>Tienda<input type="text" class="column_filter form-control" id="col4_filter"></td>
                    </tr>
                    <tr id="filter_col5" data-column="5">
                        <td>Monto desde<input type="number" class="column_filter form-control" id="col5_filter"></td>
                    </tr>
                    <tr id="filter_col6" data-column="6">
                        <td>Monto hasta<input type="number" value="max" class="column_filter form-control" id="col6_filter"></td>
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
                    <th>Meses Transcurridos Desde</th>
                    <th>Meses Transcurridos Hasta</th>
                    <th>Días Transcurridos Desde</th>
                    <th>Días Transcurridos Hasta</th>
                    <th>% a Cobrar Retroventa</th>
                    <th>Monto Desde</th>
                    <th>Monto Hasta</th>	
                    <th>Activo</th>	
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection 
@section('javascript') 
@parent 
var url2 = urlBase.make('pais/getSelectList');
    loadSelectInput('#col0_filter', url2, true);
    SelectValPais("#col0_filter");

    $('#col0_filter').change(function () {
        var id = $('#col0_filter').val();
        var url2 = urlBase.make('departamento/getdepartamentobypais') + "/" + id;
        loadSelectInput('#col1_filter', url2, true);

        url2 = urlBase.make('zona/getSelectListZonaPais') + "/" + id;
        loadSelectInput('#col3_filter', url2, true);
    }); 
    $('#col0_filter').change();

    $('#col1_filter').change(function() {
        var id = $(this).val();
        var url2 = urlBase.make('ciudad/getciudadbydepartamento') + "/" + id;
        loadSelectInput('#col2_filter', url2, true);
    });

column=[ { "data":"pais" }, { "data":"departamento" }, { "data":"ciudad" }, { "data": "tienda" }, { "data": "meses_desde" }, { "data": "meses_hasta" }, { "data": "dias_desde" }, { "data": "dias_hasta" }, { "data": "menos_porcentaje_retroventas" }, { "data": "monto_desde" }, { "data": "monto_hasta"},{ "data": "estado" }, ]; 
dataTableActionFilter("{{url('/configcontrato/apliretroventa/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column);
$("#updateAction1").click(function() { var url2="{{ url('/configcontrato/apliretroventa/edit') }}"; updateRowDatatableAction(url2) }); 
$("#deletedAction1").click(function() { var url2="{{ url('/configcontrato/apliretroventa/inactive') }}"; deleteRowDatatableAction(url2); }); 
$("#deletedAction2").click(function() { var url2="{{ url('/configcontrato/apliretroventa/delete') }}"; deleteRowDatatableAction(url2, "¿Eliminar el registro?"); }); 
$("#activatedAction1").click(function() { var url2="{{ url('/configcontrato/apliretroventa/active') }}"; deleteRowDatatableAction(url2, "¿Activar el registro?"); });
@endsection
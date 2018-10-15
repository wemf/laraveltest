@extends('layouts.master') 

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
        <h2>Configuración de Días de Gracia</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="btn-group pull-right espacio" role="group" aria-label="...">
            <a href="{{ url('/configcontrato/diagracia/create') }}" title="Agregar Nuevo Registro" type="button" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
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
                                <option value="">- Seleccione una opción -</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="filter_col2" data-column="2">
                        <td>Ciudad
                        <select type="text" class="column_filter form-control" id="col2_filter">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                        </td>
                    </tr>
                    <tr id="filter_col3" data-column="3">
                        <td>Tienda<input type="text" class="column_filter form-control" id="col3_filter"></td>
                    </tr>
                    <tr id="filter_col4" class="no-width" data-column="4">
                        <td>
                            Inactivos
                            <input type="checkbox" onchange="intercaleCheckInvert(this);" id="col4_filter" class="column_filter check-control check-pos" value="1" />
                            <label for="col4_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                        </td>
                    </tr>
                    <tr>
                        <td><button type="button" onclick="intercaleFunction('col4_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
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
                    <th>Número de Días</th>	
                    <th>Activo</th>	
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection @section('javascript') @parent 

var url2 = '{{url('pais/getSelectList')}}';
    loadSelectInput('#col0_filter', url2, true);
    SelectValPais("#col0_filter");

    $('#col0_filter').change(function () {
        var id = $('#col0_filter').val();
        var url2 = '{{url('departamento/getdepartamentobypais')}}' + "/" + id;
        loadSelectInput('#col1_filter', url2, true);

    }); 
    $('#col0_filter').change();

    $('#col1_filter').change(function() {
        var id = $(this).val();
        var url2 = '{{url('ciudad/getciudadbydepartamento')}}' + "/" + id;
        loadSelectInput('#col2_filter', url2, true);
    });

column=[ { "data":
"pais" }, { "data": "departamento" },{ "data": "ciudad" }, { "data": "tienda" }, { "data": "dias_gracia" },{ "data": "estado" }, ]; dataTableActionFilter("{{url('/configcontrato/diagracia/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)
$("#updateAction1").click(function() { var url2="{{ url('/configcontrato/diagracia/edit') }}"; updateRowDatatableAction(url2) }); 
$("#deletedAction1").click(function() { var url2="{{ url('/configcontrato/diagracia/inactive') }}"; deleteRowDatatableAction(url2); }); 
$("#deletedAction2").click(function() { var url2="{{ url('/configcontrato/diagracia/delete') }}"; deleteRowDatatableAction(url2, "¿Eliminar el registro?"); });
$("#activatedAction1").click(function() { var url2="{{ url('/configcontrato/diagracia/active') }}"; deleteRowDatatableAction(url2, "¿Activar el registro?"); });
 @endsection
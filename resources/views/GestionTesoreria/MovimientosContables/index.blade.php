@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="x_panel">

    <div class="x_title">
        <h2>Movimientos Contables</h2>
        <div class="clearfix"></div>
    </div>

    <form id="frm-filters" action="{{ url('contabilidad/movimientoscontables/exporttoExcel') }}" method="POST">
        {{ csrf_field() }}
        <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
        <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
        <div class="contentfilter-table">
            <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
                <tbody>
                 @if(Auth::user()->role->id==env('ROL_TESORERIA')|| Auth::user()->role->id==env('ROLE_SUPER_ADMIN'))  
                    <tr id="filter_col0" data-column="0">
                        <td>País
                            <select type="text" class="column_filter form-control" id="col0_filter" name="pais">
                            <option value="">-- Seleccione una opción  --</option>
                                @foreach ($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="filter_col1" data-column="1">
                        <td>Departamento
                            <select type="text" class="column_filter form-control" id="col1_filter" name="departamento">
                                <option value="">-- Seleccione una opción  --</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="filter_col2" data-column="2">
                        <td>Ciudad
                            <select type="text" class="column_filter form-control" id="col2_filter" name="ciudad">
                                <option value="">-- Seleccione una opción --</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="filter_col3" data-column="3">
                        <td>Zona
                            <select type="text" class="column_filter form-control" id="col3_filter" name="zona">
                                <option value="">-- Seleccione una opción --</option>                                 
                            </select>
                        </td>
                    </tr>
                    <tr id="filter_col4" data-column="4">
                        <td>Tienda
                            <select type="text" class="column_filter form-control" id="col4_filter" name="tienda">
                                <option value="">-- Seleccione una opción --</option>
                            </select>
                        </td>
                    </tr>
                    @else
                    <tr id="filter_col4" data-column="4">
                        <td>Tienda
                            <select type="text" class="column_filter form-control" id="col4_filter" name="tienda" disabled>
                                <option type="text" id="tienda" name="tienda" class="form-control" value='{{tienda::OnLine()->id}}'>{{tienda::OnLine()->nombre}}</option>
                            </select>
                        </td>
                    </tr>
                    @endif
                    <tr id="filter_col5" data-column="5">
                        <td>Tipo Documento
                            <select class="form-control column_filter" id="col5_filter" name="tipo_documento">
                                <option value="">-seleccionar un registro-</option>
                                @foreach ($tipoDocumento as $tipoDoc)
                                    <option type="text" id="tipo_documento" name="tipo_documento" value='{{$tipoDoc->id}}'>{{$tipoDoc->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="filter_col6" data-column="6">
                        <td>Número de Orden
                            <input  class="form-control column_filter" type="text" id="col6_filter" name="codigo_movimiento" maxlength="8" placeholder="-Ingrese código movimiento-">
                        </td>
                    </tr>
                    <tr id="filter_col7" data-column="7">
                        <td>Fecha de creación: Desde
                            <input type="text" class="column_filter form-control data-picker-only" id="col7_filter" name="fecha_cracionD" maxlength="10" placeholder="Desde" value='@if(isset($lastDate->fecha_inicio)){{ explode(' ',$lastDate->fecha_inicio)[0] }}@endif'>
                        </td>
                    </tr>
                    <tr id="filter_col8" data-column="8">
                        <td>Fecha de creación: Hasta
                            <input type="text" class="column_filter form-control data-picker-only" id="col8_filter" name="fecha_cracionH" maxlength="10" placeholder="Hasta" value='{{ date('Y-m-d') }}'>
                        </td>
                    </tr>
                    <tr style="width: 100px !important;">
                        <td><a class="btn btn-primary button_filter" id="btn-buscar"><i class="fa fa-search"></i> Buscar</a></td>
                    </tr>
                    <tr>
                        <td style="margin-top: 22px;"><button class="hidden btn btn-primary" type="submit">Exportar</button></td>
                    </tr>
                    <tr>
                        <td style="margin-top: 22px;"><button class="hidden btn btn-primary" type="submit">Excel</button></td>
                    </tr>                    
                </tbody>
            </table>
        </div>
    </form>

    <table id="dataTableAction" class="dataTableAction" width="100%" cellspacing="0" align="center">
        <thead class="thead">
            <tr>
                <th></th>
                <th>Fecha creación</th>
                <th class="hidden">Código cierre</th>
                <th>Nro. Orden</th>
                <th>Joyería</th>
                <th>Valor</th>
                <th>Documento</th>
                <th>Referencia</th>
                <th>Destino</th>
                <th class="hidden">Descripción</th>
                <th class="hidden">Cuenta</th>
                <th class="hidden">Valor débito</th>
                <th class="hidden">Valor crédito</th>
                <th> </th>
            </tr>
        </thead>
    </table>

</div>

@endsection

@section('javascript')
{{-- en column van los datos cal cual lleguen de la base de datos / la primer url es de donde vienen los datos / la segunda idioma datatable  --}}
@parent
  //<script>
    column=[
        {"className": 'details-control no-replace-spaces', "orderable": false, "data": null, "defaultContent": ''},
        { "data": "fecha"},
        { "data": "id_cierre","visible": false},
        { "data": "codigo_movimiento"},
        { "data": "nombre"},
        { "data": "valor"},
        { "data": "tipo_documento"},
        { "data": "referencia"},
        { "data": "destino"},
        { "data": "descripcion","visible": false },
        { "data": "cuenta","visible": false },
        { "data": "debito","visible": false },
        { "data": "credito","visible": false },
        { "data": null, "visible": false },
    ];
    dtMultiSelectRowAndInfo("dataTableAction", "{{ url('/contabilidad/movimientoscontables/get') }}","{{ url('/plugins/datatable/DataTables-1.10.13/json/spanish.json') }}",column);
    
 
function detalles_tabla(){
    $('#dataTableAction tbody').on('click', 'td.details-control', function(){
    var tr = $(this).closest('tr');
    var mov_cont = $(tr).attr('id');
    var cod_movimiento_contable = mov_cont.split("/");
    var codigo_cierre = cod_movimiento_contable[0];
    var numero_orden = cod_movimiento_contable[1];
    var id_tienda = cod_movimiento_contable[2];
    var id_tipo_documento = cod_movimiento_contable[3];
    var row = table_multi_select.row( tr );
    if ( row.child.isShown()){
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
        row.child(detalle_tabla_html(codigo_cierre, numero_orden, id_tienda, id_tipo_documento)).show();
        tr.addClass('shown');
        }
    });
};
function detalle_tabla_html(codigo_cierre, numero_orden, id_tienda, id_tipo_documento){
    var html_tabla = '<table>';
    html_tabla +=
       '<thead><th>Descripción documento</th><th>Número Cuenta</th><th>Valor Débito</th><th>Valor Crédito</th></thead>';       
        $.ajax({
            url: urlBase.make(`contabilidad/movimientoscontables/logMovimientosContables/${ codigo_cierre }/${ numero_orden }/${ id_tienda }/${ id_tipo_documento }`),
            type: "get",
            async: false,
            success: function(datos){
                jQuery.each(datos, function(indice, valor){
                    html_tabla +=
                    `<tr>
                        <td>${ datos[indice].descripcion_documento }</td>
                        <td>${ datos[indice].cuenta }</td>
                        <td>${ datos[indice].valor_debito }</td>
                        <td>${ datos[indice].valor_credito }</td>
                    </tr>`
                });
            }
        });
    return html_tabla;
};

$(document).ready(function(){
    detalles_tabla();
    @if(Auth::user()->role->id==env('ROL_TESORERIA')|| Auth::user()->role->id==env('ROLE_SUPER_ADMIN'))    
        //Función para llenar el campo departamento
        $('#col0_filter').change(function(){
            fillSelect('#col0_filter','#col1_filter',"{{ url('/pais/getSelectListPais') }}");
        });
        //Función para llenar el campo ciudad
        $('#col1_filter').change(function(){
            fillSelect('#col1_filter','#col2_filter',"{{ url('/departamento/getSelectListDepartamento') }}");
        });
        //Función para llenar el campo zona
        $('#col2_filter').change(function(){
            fillSelect('#col0_filter','#col3_filter',"{{ url('/zona/getSelectListZonaPais') }}");
        });
        // Función para llenar el campo tienda
        $('#col3_filter').change(function(){
            fillSelect('#col3_filter','#col4_filter',"{{ url('/zona/getSelectListZonaTienda') }}");
        });
        // País
        $("#col0_filter option").each(function () {
            if ($(this).val() == {{tienda::OnLine()->id_pais}}){
                $(this).attr('selected', 'selected');
            }
        });
        fillSelect('#col0_filter','#col1_filter',"{{ url('/pais/getSelectListPais') }}");
        // Departamento
        $("#col1_filter option").each(function () {
            if ($(this).val() == {{tienda::OnLine()->id_departamento}})
                $(this).attr('selected', 'selected');
        });
        fillSelect('#col1_filter','#col2_filter',"{{ url('/departamento/getSelectListDepartamento') }}");
        // Ciudad
        $("#filter_col2 option").each(function () {
            if ($(this).val() == {{tienda::OnLine()->id_ciudad}})
                $(this).attr('selected', 'selected');
        });
        fillSelect('#col0_filter','#col3_filter',"{{ url('/zona/getSelectListZonaPais') }}");
        // Zona
        $("#col3_filter option").each(function () {
            if ($(this).val() == {{tienda::OnLine()->id_zona}})
                $(this).attr('selected', 'selected');
        });
        fillSelect('#col3_filter','#col4_filter',"{{ url('/zona/getSelectListZonaTienda') }}");
        // Tienda 
        $("#filter_col4 option").each(function () {
            if ($(this).val() == {{tienda::OnLine()->id}})
                $(this).attr('selected', 'selected');
        });	    
    @endif

});
@endsection

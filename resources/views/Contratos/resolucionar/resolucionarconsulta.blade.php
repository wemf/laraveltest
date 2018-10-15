@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Perfeccionamiento de contratos vencidos</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="row">
        <div class="btn-group pull-right espacio" role="group" aria-label="..." >
            <button title="Resolucionar" id="btn-resolucionar" onclick="resolucion.ordenes_resolucion().resolucionar();" class="btn btn-primary">Perfeccionar</a>
        </div> 
    </div>
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
            <tbody>

                <tr id="filter_col0" data-column="0">
                    <td>Joyería
                        <select @if(Auth::user()->id_role != env('ROLE_SUPER_ADMIN')) disabled @endif class="column_filter form-control slc_tienda" id="col0_filter" data-load="@if(isset($tienda->id)){{ $tienda->id }}@endif">
                            <option value> -Seleccione una opción - </option>
                        </select>
                    </td>
                </tr>
               
                <tr id="filter_col1" data-column="1">
                    <td>Categoría
                        <select class="column_filter form-control slc_categoria_general" id="col1_filter">
                            <option value> -Seleccione una opción - </option>
                        </select>
                    </td>
                </tr>

                <tr id="filter_col2" data-column="2">
                    <td>Tipo de documento<select class="column_filter form-control slc_tipo_documento" id="col2_filter">
                        <option value> -Seleccione una opción - </option>
                        </select>
                    </td>
                </tr>
                
                <tr id="filter_col3" data-column="3">
                    <td>Número de documento
                    <input type="text" class="column_filter form-control" id="col3_filter" name="fecha_cracion_i" maxlength="25">
                    </td>
                </tr>

                <tr id="filter_col4" data-column="4">
                    <td>No. contrato desde<input type="text" class="column_filter form-control justNumbers" id="col4_filter"></td>
                </tr>

                <tr id="filter_col5" data-column="5">
                    <td>No. contrato hasta<input type="text" class="column_filter form-control justNumbers" id="col5_filter"></td>
                </tr>

                <tr id="filter_col6" data-column="6">
                    <td>Días sin prórroga<input type="text" class="column_filter form-control justNumbers" id="col6_filter"></td>
                </tr>

                <tr id="filter_col7" data-column="7">
                    <td>Vencidos sin plazo de pago vigente 
                        <input type="checkbox" onchange="intercaleCheck(this);" id="col7_filter" class="column_filter check-control check-pos" value="0" />
                        <label for="col7_filter" class="lbl-check-control" style="font-size: 27px !important; font-weight: 100; height: 26px; display: block;"></label>
                    </td>
                </tr>


                <tr id="filter_col9" data-column="9" style="width: 160px !important;">
                    <td><p class="col-md-12 no-padding">Meses adeudados</p>
                        <div class="no-padding">
                            <select class="column_filter form-control" id="col9_filter" onchange="resolucion.ordenes_resolucion().meses_adeudados(this.value);">
                                <option value="1">Igual</option>
                                <option value="2">Mayor</option>
                                <option value="3">Mayor o igual</option>
                                <option value="4">Menor</option>
                                <option value="5">Menor o igual</option>
                                <option value="6">Diferente</option>
                                <option value="7">Entre</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr id="filter_col8" data-column="8" style="width: 100px !important;">
                    <td><p class="col-md-12 no-padding">    </p>
                        <div class="no-padding">
                            <input type="text" class="column_filter form-control justNumbers" id="col8_filter">
                        </div>
                    </td>
                </tr>
                <tr id="filter_col10" data-column="10" class="hide" style="width: 100px !important;">
                    <td><p class="col-md-12 no-padding">    </p>
                        <div class="no-padding">
                            <input type="text" class="column_filter form-control justNumbers" id="col10_filter">
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><button type="button" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                TOTALES   |   Valor de los contratos: $ <label id="lbl_total_valor_contratos">0</label>   -   
                Cantidad de contratos: <label id="lbl_total_contratos">0</label>    -   
                Peso total: <label id="lbl_total_peso_contratos">0</label>   -   
                Peso estimado: <label id="lbl_estimado_peso_contratos">0</label>   -   
                Cantidad de items: <label id="lbl_total_cantidad_items">0</label>
            </div>
        </div>
    </div>

    <table id="table_resolucion" class="display totales_resolucion" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 10px !important;">
                    <input type="checkbox" onchange="intercaleCheck(this);" id="all_check" class="check-control check-pos" value="0" />
                    <label for="all_check" class="lbl-check-control" style="font-size: 20px!important; font-weight: 100; margin: 0px; display: block;"></label>
                </th>
                <th></th>
                <th>Joyería</th>
                <th>Categ.</th>
                <th>Tipo</th>
                <th>No. documento</th>
                <th>Nombres y apellidos</th>
                <th>No. contrato</th>
                <th>Fecha creación          </th>
                <th>Término</th>
                <th>Mes trans</th>
                <th>No. prórrogas</th>
                <th>Mes adeu</th>
                <th>Mes venc</th>
                <th>Últ. prórroga             </th>
                <th>Peso total</th>
                <th>Peso estimado</th>
                <th>Valor contrato</th>
                <th>Cant. ítems</th>
                <th>Cod. bolsas</th>
            </tr>
        </thead>
    </table>

  </div>
</div>

@endsection

<style>

th, td{
    font-size: 13px;
}

.colums-hides tbody tr td:nth-child(17), .dataTables_filter, .dataTables_length{
    display:none;
}
.colums-hides tbody tr td:nth-child(18){
    display:none;
}
.colums-hides tbody tr td:nth-child(19){
    display:none;
}

</style>

<link rel="stylesheet" type="text/css" href="{{asset('/css/resolucion/estilos.css')}}">

@push('scripts')
    <!-- <script src="{{asset('/js/configcontrato.js')}}"></script> -->
    <script src="{{asset('js/contrato/resolucionar.js')}}"></script>
  <script src="{{ asset('/js/OrdenResolucion/totales.js') }}"></script>
@endpush

@section('javascript')   
  @parent
    var i = 0;
   column=[             
            { 
                "className":      'no-replace-spaces',
                "defaultContent": `<label><input type="checkbox" onchange="intercaleCheck(this);" class="check-control check-pos check-resolucionar" value="0" />
                                    <div class="lbl-check-control" style="font-size: 20px!important; font-weight: 100; margin: 0px; display: block;"></div></label>`,
                "orderable":      false,
            },
            { 
                "className":      'details-control no-replace-spaces',
                "orderable":      false,
                "data": "null",
                "defaultContent": ''
            },
            { "data": "tienda" },
            { "data": "categoria_general" },
            { "data": "tipo_documento"},
            { "data": "documento_cliente"},
            { "data": "nombres_cliente"},
            { "data": "codigo_contrato"},
            { "data": "fecha_creacion" },
            { "data": "termino" },
            { "data": "meses_transcurridos" },
            { "data": "numero_prorrogas" },
            { "data": "meses_adeudados" },
            { "data": "meses_vencidos" },
            { "data": "fecha_prorroga" },
            { "data": "peso_total_total", "className": "var_peso_contrato" },
            { "data": "peso_estimado_total", "className": "var_peso_estimado_contrato" },
            { "data": "valor_contrato", "className": "var_valor_contrato" },
            { "data": "cantidad_items", "className": "var_cantidad_items" },
            { "data": "cod_bolsas_seguridad" }
        ];
        dtMultiSelectRowAndInfo('table_resolucion', "{{url('/contratos/resolucionar/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)
    
    var url2=urlBase.make('gestionestado/estado/getEstadoByTema')+"/"+2;
    loadSelectInput('#col7_filter', url2, true);

    $(document).ready(function(){
        resolucion.ordenes_resolucion().document_ready();
        // Ajustar el scroll de la pantalla
        $('.button_filter, .sorting_desc').click(function(){
            resetTotales();
        });
        totales_resolucion();
    });
@endsection
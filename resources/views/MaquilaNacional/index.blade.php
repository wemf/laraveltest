@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<form id="frm_reporte_pdf" class="hide" method="POST" action="{{ url('contrato/refaccion/generatepdf') }}">
    {{ csrf_field() }}
    <input type="hidden" id="id_orden" name="id_orden" />
    <input type="hidden" id="id_tienda_orden" name="id_tienda_orden" value="@if($tienda != null){{ $tienda->id }}@endif" />
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="font-size: 20px !important;">Reportes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <button type="button" title="Generar reporte PDF" id="btn_certificado_mineria_pdf" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i> Certificado de minería (PDF)</button>
        <button type="button" title="Generar reporte PDF" id="btn_reporte_pdf" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Reporte (PDF)</button>
        <a title="Generar reporte Excel" id="btn_reporte_excel" class="btn btn-success"><i class="	fa fa-file-excel-o"></i> Reporte (Excel)</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<div class="x_panel">
  <div class="x_title"><h2>Maquila nacional</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <a title="Nuevo Registro" id="newAction" class="btn btn-success btn-procesar-index"><i class="fa fa-paper-plane"></i> Procesar</a>
      <a title="Transformación global" id="transformacion-global" class="btn btn-success"><i class="fa fa-life-ring"></i> Transf. global</a>
      <a title="Nuevo Registro" id="viewAction" class="btn btn-primary btn-ver-index"><i class="fa fa-eye"></i> Ver</a>
      <button type="button" id="btn-reporte" class="btn btn-warning">Reportes</button>
      <button type="button" id="reporte" style="display:none;" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">Reportes</button>
      <button type="button" title="Anular Orden" id="btn_anular" class="btn btn-danger hide"><i class="fa fa-eraser"></i>Anular</button>
      <button type="button" title="Anular Orden" id="btn_anular_confirm" class="btn btn-danger"><i class="fa fa-eraser"></i>Anular</button>
      
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
            <tbody>
                <tr id="filter_col1" data-column="0">
                    <td>Joyería
                      <select  class="column_filter form-control slc_tienda" id="col0_filter" disabled data-load="@if($tienda != null){{ $tienda->id }}@endif"></select>
                    </td>
                </tr>
                <tr id="filter_col2" data-column="1">
                    <td>Categoría
                      <select  class="column_filter form-control " id="col1_filter"></select>
                    </td>
                </tr>
                <tr id="filter_col3" data-column="2">
                    <td>Estado
                      <select class="column_filter form-control filter_estado" id="col2_filter">
                        <option value="1">Abierta</option>
                        <option value="2">Cerrada</option>
                        <option value="3">Transformación</option>
                        <option value="0">Anulada</option>
                      </select>
                    </td>
                </tr>
                <tr>
                    <td><button type="text" onclick="intercaleFunction('col2_filter'); totales_resolucion_det();" onmouseup="totales_resolucion_det();" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
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

    <table id="table_maquilanacional" class="display totales_resolucion" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>
                    
                </th>      
                <th> </th>  
                <!-- <th>Número de contrato</th>               -->
                <th>Número de la orden</th>              
                <th>Joyería</th>              
                <th>Categoría</th> 
                <th>Fecha de creación</th>
                <th>Valor total</th>
                <th>Peso total</th>
                <th>Peso estimado</th>
                <th>Peso libre</th>
                <!-- <th>Peso taller</th> -->
                <th>Cantidad ítems</th>
                <th>Estado</th>
                <th>Cod. bolsas seguridad</th>
            </tr>
        </thead>        
      </table>

  </div>
</div>

<style>
    .dataTables_length, .dataTables_filter{
        display: none;
    }
</style>

@endsection

@push('scripts')
  <script src="{{ asset('/js/OrdenResolucion/maquilanacional.js') }}"></script>
  <script src="{{ asset('/js/OrdenResolucion/totales.js') }}"></script>
@endpush


@section('javascript')
  @parent
  //<script> 

    column=[
        {
            "className":      'no-replace-spaces',
            "defaultContent": `<label><input type="checkbox" onchange="intercaleCheck(this);" class="check-control check-pos check-resolucionar" value="0" />
                                <div class="lbl-check-control" onclick="resetChecks();" style="font-size: 20px!important; font-weight: 100; margin: 0px; display: block;"></div></label>`,
            "orderable":      false,
        },
        {
            "className":      'details-control no-replace-spaces',
            "orderable":      false,
            "data": "null",
            "defaultContent": ''
        },
        { "data": "id_orden" },
        { "data": "tienda_orden" },
        { "data": "categoria"},
        { "data": "fecha_creacion"},
        { "data": "valor_contrato", "className": 'var_valor_contrato'},
        { "data": "peso_total_total", "className": 'var_peso_contrato'},
        { "data": "peso_estimado_total", "className": 'var_peso_estimado_contrato'},
        { "data": "peso_libre_total", "className": 'var_peso_libre_contrato'},
        // { "data": "peso_taller_total", "className": 'var_peso_taller'},
        { "data": "cantidad_items", "className": 'var_cantidad_items'},
        { "data": "estado"},
        { "data": "codigos_bolsas" }
    ];
    
    


    loadSelectInput("#col1_filter", "{{ url('/products/categories/getCategory') }}")
    loadSelectInput(".slc_tienda", urlBase.make('/tienda/getSelectList'), true);

    datatableMaquilaNacional('table_maquilanacional', "{{ url('/contrato/maquilanacional/get') }}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column);

    $("#newAction").click(function() {
        var ordenes = "";
        var id_tienda = $('#col0_filter').val();
        $('#table_maquilanacional .check-resolucionar:checked').each(function(){
            ordenes += $(this).parent().parent().parent().attr('id') + '-';
        });

        var url2="{{ url('/contrato/maquilanacional/maquilanacionalar') }}/"+id_tienda+"/"+ordenes.slice(0,-1)+"/1";
        if (ordenes != null && ordenes != "") {
            window.location = url2;
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });


    $("#viewAction").click(function() {
        var ordenes = "";
        var id_tienda = $('#col0_filter').val();
        $('#table_maquilanacional .check-resolucionar:checked').each(function(){
            ordenes += $(this).parent().parent().parent().attr('id') + '-';
        });
        
        var url2="{{ url('/contrato/maquilanacional/maquilanacionalar') }}/"+id_tienda+"/"+ordenes.slice(0,-1)+"/2";
        if (ordenes != null && ordenes != "") {
            window.location = url2;
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error');
        }
    });

    $("#transformacion-global").click(function(){
        var ordenes = "";
        var id_tienda = $('#col0_filter').val();
        $('#table_maquilanacional .check-resolucionar:checked').each(function(){
            ordenes += $(this).parent().parent().parent().attr('id') + '-';
        });

        var url2=`{{ url('/contrato/maquilanacional/transformacionglobal') }}/${ id_tienda }/${ ordenes.slice(0,-1) }`;
        if (ordenes != null && ordenes != "") {
            window.location = url2;
        } else {
            Alerta('Error', 'Seleccione un registro.', 'error')
        }
    });

    $("#updateAction1").click(function() {
        var url2="{{ url('/franquicia/update') }}";
        updateRowDatatableAction(url2)
    });

    $("#deletedAction1").click(function() {
        var url2="{{ url('/franquicia/delete') }}";
        deleteRowDatatableAction(url2);
    });

    $("#activatedAction1").click(function() { 
        var url2="{{ url('/franquicia/active') }}";
        deleteRowDatatableAction(url2, "¿Activar el registro?");
    });

    $(document).ready(function(){
        maquilanacional.detalles_tabla();
        setTimeout(() => {
            $('.button_filter').click();
        }, 500);
        replaceNull();
    });

@endsection
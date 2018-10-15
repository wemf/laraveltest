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
        <h5 class="modal-title" id="exampleModalLabel" style="font-size: 20px !important;">Generar reportes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <button type="button" title="Generar reporte PDF" id="btn_certificado_mineria_pdf" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i> Certificado de minería (PDF)</button>
        <button type="button" title="Generar reporte PDF" id="btn_reporte_pdf" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Reporte (PDF)</button>
        <a title="Generar reporte Excel" id="btn_reporte_excel" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Reporte (Excel)</a>
        <a title="Generar Excel" id="btn_stikers_excel" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Stikers (Excel)</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" name="rol_user" id="rol_user" value="{{ Auth::user()->role->id }}">
<input type="hidden" name="role_jefe_zona" id="role_jefe_zona" value="{{ env('role_jefe_zona') }}">
<input type="hidden" name="rol_administrador_joyeria" id="rol_administrador_joyeria" value="{{ env('rol_administrador_joyeria') }}">

<div class="x_panel">
  <div class="x_title"><h2>Vitrina</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
        <a title="Nuevo Registro" onclick="btnProcesar();" class="btn btn-success"><i class="fa fa-plus  "></i> Procesar</a>
        <a title="Nuevo Registro" onclick="btnProcesar(1);" class="btn btn-primary"><i class="fa fa-plus  "></i> Ver</a>
        <button type="button" id="btn-reporte" class="btn btn-warning">Generar reporte</button>
        <button type="button" id="reporte" style="display:none;" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">Generar reporte</button>
        <button type="button" title="Anular Orden" id="btn_anular" class="btn btn-danger hide"><i class="fa fa-eraser"></i>Anular</button>
      <button type="button" title="Anular Orden" id="btn_anular_confirm" class="btn btn-danger"><i class="fa fa-eraser"></i>Anular</button>
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
            <tbody>
                <tr id="filter_col1" data-column="0">
                    <td>Tienda
                        <select  class="column_filter form-control slc_tienda" id="col0_filter" disabled data-load="{{ $tienda->id }}"></select>
                    </td>
                </tr>
                <tr id="filter_col2" data-column="1">
                    <td>Categoría
                        <select  class="column_filter form-control " id="col1_filter"></select>
                    </td>
                </tr>
                <tr id="filter_col2" data-column="2">
                    <td>Estado
                        <select  class="column_filter form-control " id="col2_filter">
                            <option value="">- Seleccione una opción -</option>
                            <option value="{{ env('ORDEN_PENDIENTE_POR_PROCESAR') }}">Abiertas</option>
                            <option value="{{ env('ORDEN_PROCESADA') }}">Cerradas</option>
                            <option value="{{ env('ANULADA_VITRINA') }}">Anuladas</option>
                            <option value="{{ env('APJZ_VITRINA') }}">APJZ</option>
                            <option value="{{ env('APAJ_VITRINA') }}">APAJ</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><button type="text" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                TOTALES   |   
                Valor contratos: $ <label id="lbl_total_valor_contratos">0</label>    -   
                Cantidad de contratos: <label id="lbl_total_contratos">0</label>    -   
                Peso total: <label id="lbl_total_peso_contratos">0</label>    -   
                Peso estimado: <label id="lbl_estimado_peso_contratos">0</label>    -   
                Peso taller: <label id="lbl_total_peso_taller">0</label>    -   
                Peso final: <label id="lbl_total_peso_final">0</label>    -   
                Cantidad ID: <label id="lbl_total_ids">0</label>
            </div>
        </div>
    </div>    


    <table id="table_vitrina" class="display table_resolucion totales_resolucion" width="100%" cellspacing="0">
    <thead>
       <tr>    
            <th>
                <!-- <input type="checkbox" id="all_checkx" class="check-control check-pos" value="0" /> -->
                <!-- <label for="all_check" class="lbl-check-control" style="font-size: 20px!important; font-weight: 100; margin: 0px; display: block;"></label> -->
            </th>         
            <th> </th>
            <th>Número de orden</th>
            <th>Joyería</th>
            <th>Categoría</th>
            <th>Fecha de creación</th>
            <th>Valor total</th>
            <th>Peso total</th>
            <th>Peso estimado</th>
            <th>Peso taller</th>
            <th>Peso final</th>
            <th>Estado</th>
            <th>Código bolsa de seguridad</th>
            <th class="hide"></th>
       </tr>
   </thead>        
 </table>

  </div>
</div>

@endsection

<style>
    .dataTables_length, .dataTables_filter{
        display: none;
    }
</style>

@push('scripts')
    <script src="{{ asset('/js/OrdenResolucion/vitrina.js') }}"></script>
@endpush
@section('javascript')   
  @parent
  //<script>    
    column=
    [                 
        { 
            "className":      'no-replace-spaces',
            "defaultContent": `<label><input type="checkbox" onchange="intercaleCheck(this);" class="check-control check-pos check-resolucionar" value="0" />
                                <div class="lbl-check-control" onclick="resetChecks();" style="font-size: 20px!important; font-weight: 100; margin: 0px; display: block;"></div></label>`,
            "orderable":      false,
        },
        { 
            "className":      'details-control',
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
        { "data": "peso_taller", "className": 'var_peso_taller'},
        { "data": "peso_final", "className": 'var_peso_final'},
        { "data": "estado","className": 'var_estado'},
        { "data": "cod_bolsas_seguridad"},
        { "data": "ids_internos","className": "var_ids_internos hide"},
    ];
    datatableVitrina('table_vitrina', "{{ url('/contrato/vitrina/get') }}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    

    loadSelectInput("#col0_filter", urlBase.make('/tienda/getSelectList'), true);
    loadSelectInput("#col1_filter", "{{ url('/products/categories/getCategory') }}")

    $("#newAction").click(function() {
    var ordenes = "";
    var id_tienda = $('#col0_filter').val();
    $('.selected').each(function(){
      ordenes += $(this).attr('id') + '-';
    });
    
    var url2="{{ url('/contrato/vitrina/procesar') }}/"+id_tienda+"/"+ordenes.slice(0,-1);
    if (ordenes != null && ordenes != "") {
        window.location = url2;
    } else {
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
  });

    $("#btn-reporte").click(function() {
        var table = $('.check-resolucionar:checked')
        if (table.length > 0) {
            $('#reporte').click();
        } else {
            Alerta('Error', 'Debe seleccionar un registro para poder continuar.', 'Error')
        }
    });

    $('.button_filter').click(function(){
        totales_resolucion();
    })

    $(document).ready(function(){
        vitrina.detalles_tabla();
        setTimeout(() => {
            totales_resolucion()
        }, 500);
        replaceNull();

    });

@endsection 
@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')


<div class="x_panel">
  <div class="x_title"><h2>Joya Especial</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <a title="Nuevo Registro" id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Procesar</a>
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
                <tr id="filter_col1" data-column="0">
                    <td>Tienda
                    <select  class="column_filter form-control slc_tienda" id="col0_filter" disabled data-load="{{ $tienda->id }}"></select>
                    </td>
                </tr>
                <tr id="filter_col2" data-column="1">
                    <td>Categoria
                    <select  class="column_filter form-control " id="col1_filter"></select>
                    </td>
                </tr>
                <tr>
                    <td><button type="text" onclick="intercaleFunction('col2_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div> 


    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                TOTALES   |   
                Valor de los contratos: $ <label id="lbl_total_valor_contratos">0</label>    -   
                Cantidad de contratos: <label id="lbl_total_contratos">0</label>    -   
                Peso: <label id="lbl_total_peso_contratos">0</label>
            </div>
        </div>
    </div>


    <table id="table_vitrina" class="display totales_resolucion table_resolucion" width="100%" cellspacing="0">
    <thead>
       <tr>       
            <th>
                <input type="checkbox" onchange="intercaleCheck(this);" id="all_check" class="check-control check-pos" value="0" />
                <label for="all_check" class="lbl-check-control" style="font-size: 20px!important; font-weight: 100; margin: 0px;"></label>
            </th>        
            <th> </th>  
            <th>Número de orden</th>              
            <th>Orden de la tienda</th>              
            <th>Categoria</th> 
            <th>Fecha de creación</th>
            <th>Estado</th>
            <th>Valor</th>
            <th>Peso</th>
       </tr>
   </thead>        
 </table>

  </div>
</div>

@endsection
@push('scripts')
    <script src="{{ asset('/js/OrdenResolucion/vitrina.js') }}"></script>
  <script src="{{ asset('/js/OrdenResolucion/totales.js') }}"></script>
@endpush
@section('javascript')   
  @parent
  //<script>    
    column=
    [       
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
        { "data": "id_orden" },
        { "data": "tienda_orden" },
        { "data": "categoria"},
        { "data": "fecha_creacion"},
        { "data": "estado"},
        { "data": "valor_contrato", "className": "var_valor_contrato"},
        { "data": "peso_contrato", "className": "var_peso_contrato"},
    ];
    dtMultiSelectRowAndInfo('table_vitrina', "{{ url('/contrato/joyaespecial/get') }}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    $(document).ready(function(){
        vitrina.detalles_tabla();
    });

    loadSelectInput("#col0_filter", urlBase.make('/tienda/getSelectList'), true);
    loadSelectInput("#col1_filter", "{{ url('/products/categories/getCategory') }}")

    $("#newAction").click(function() {
    // var ordenes = "";
    // var id_tienda = $('#col0_filter').val();
    // $('.selected').each(function(){
    //   ordenes += $(this).attr('id') + '-';
    // });
    
    // var url2="{{ url('/contrato/joyaespecial/procesar') }}/"+id_tienda+"/"+ordenes.slice(0,-1);
    // if (ordenes != null && ordenes != "") {
    //     window.location = url2;
    // } else {
    //     Alerta('Error', 'Seleccione un registro.', 'error')
    // }
    
    var contratos = "";
    var cont = 0;
    $('.table_resolucion .check-resolucionar:checked').each(function(){
        if(cont > 0)
            contratos += "-";
        contratos += $(this).parent().parent().parent().attr('id');
        ++cont;
    });

    ( contratos != "" ) 
        ? location.href = urlBase.make('contrato/joyaespecial/procesar/' + $('#col0_filter').val() + "/" + contratos) 
        : Alerta( 'Alerta', 'Debe seleccionar por lo menos una orden', 'warning' );
  });

@endsection
@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Consulta de contrato</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
  <div class="row">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
    <a href="{{ url('creacioncontrato/verificacioncliente') }}" title="Nuevo Contrato" id="btn-contrato" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo</a>
    <button title="Ver Contrato" id="btn-ver" class="btn btn-primary"><i class="fa fa-eye"></i> Ver</a>
    <button title="Retroventa de Contrato" id="btn-retroventa" class="btn btn-default"><i class="fa fa-handshake-o"></i> Retroventa</a>
    <button title="Prorrogar Contrato" onclick="prorrogaRedirect();" id="btn-prorrogar" class="btn btn-info"><i class="fa fa-minus-square  "></i> Prórroga</a>
    <button title="Aplazar Contrato" id="btn-aplazar" class="btn paginate_button" style="color: #fff; background-color: #777;"><i class="fa fa-pencil-square-o  "></i> Aplazar</a>
    <!-- <button title="Cerrar Contrato"  id="btn-cerrarContrato" type="button" class="btn btn-warning"><i class="fa fa-times-circle  "></i> Cierre</button> -->
    <!-- <button title="Resolución de Contrato"  id="deletedAction1"  type="button" class="btn btn-orange"><i class="fa fa-file-pdf-o "></i> Resolución</button> -->
    <button title="Anular Contrato"  id="anularAction" type="button" class="btn btn-danger"><i class="fa fa-ban "></i> Anulación</button> 
    </div> 
    </div>
    
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
            <tbody>

                <tr id="filter_col0" data-column="0">
                    <td>País
                        <select type="text" class="column_filter form-control" id="col0_filter">
                        </select>
                    </td>
                </tr>

                <tr id="filter_col1" data-column="1">
                    <td>Departamento
                        <select type="text" class="column_filter form-control" id="col1_filter">
                            <option value="">-- Seleccione una opción  --</option>
                        </select>
                    </td>
                </tr>

                <tr id="filter_col2" data-column="2">
                    <td>Ciudad
                        <select type="text" class="column_filter form-control" id="col2_filter">
                            <option value="">-- Seleccione una opción --</option> 
                        </select>
                    </td>
                </tr>
                
                <tr id="filter_col3" data-column="3">
                    <td>Zona
                        <select type="text" class="column_filter form-control" id="col3_filter">
                            <option value="">-- Seleccione una opción --</option>                                 
                        </select>
                    </td>
                </tr>

                <tr id="filter_col4" data-column="4">
                    <td>Tienda<select type="text" class="column_filter form-control" id="col4_filter">
                        <option value> -Seleccione una opción - </option>
                        </select>
                    </td>
                </tr>

                <tr id="filter_col11" data-column="11">
                    <td>Tipo de documento<select type="text" class="column_filter form-control" id="col11_filter">
                        <option value> -Seleccione una opción - </option>
                        </select>
                    </td>
                </tr>
                
                <tr id="filter_col12" data-column="12">
                    <td>Número de documento
                    <input type="text" class="column_filter form-control" id="col12_filter" name="fecha_cracion_i" maxlength="25">
                    </td>
                </tr>

                <tr id="filter_col13" data-column="13">
                    <td>Nombres
                    <input type="text" class="column_filter form-control" id="col13_filter" name="fecha_cracion_i" maxlength="40">
                    </td>
                </tr>

                <tr id="filter_col14" data-column="14">
                    <td>Primer apellido
                    <input type="text" class="column_filter form-control" id="col14_filter" name="fecha_cracion_i" maxlength="20">
                    </td>
                </tr>

                <tr id="filter_col15" data-column="15">
                    <td>Segundo apellido
                    <input type="text" class="column_filter form-control" id="col15_filter" name="fecha_cracion_i" maxlength="20">
                    </td>
                </tr>

                <tr id="filter_col16" data-column="16">
                    <td>Categoría
                    <select type="text" class="column_filter form-control" id="col16_filter" name="Categoria">
                        <option value> -Seleccione una opción - </option>
                        </select>
                    </td>
                </tr>

                <tr id="filter_col5" data-column="5">
                    <td>Fecha de creación: Desde
                    <input type="text" class="column_filter form-control data-picker-only" id="col5_filter" name="fecha_cracion_i" maxlength="10" placeholder="Desde">
                    </td>
                </tr>
                <tr id="filter_col6" data-column="6">    
                    <td>Fecha de creación: Hasta<input type="text" class="column_filter form-control data-picker-only" id="col6_filter" name="fecha_creacion_f" maxlength="10" placeholder="Hasta"></td>
                </tr>
                
                <tr id="filter_col7" data-column="7">
                    <td>Estado<select type="text" class="column_filter form-control" id="col7_filter">
                                <option value> -Seleccione una opción - </option>
                                </select>
                    </td>
                </tr>
                <tr id="filter_col8" data-column="8">
                    <td>Motivo<select type="text" class="column_filter form-control" id="col8_filter">
                                <option value> -Seleccione una opción - </option>
                                </select>
                    </td>
                </tr>
                <tr id="filter_col9" data-column="9">
                    <td>Código tienda<input type="text" class="column_filter form-control" id="col9_filter"></td>
                </tr>

                <tr id="filter_col10" data-column="10">
                    <td>No. Contrato<input type="text" class="column_filter form-control justNumbers" id="col10_filter"></td>
                </tr>

                <tr>
                    <td><button type="button" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>         
                <th>Tienda</th>
                <th>Categoría</th>
                <th>No. Contrato</th>
                <th>Tipo</th>
                <th>Número de Documento</th>
                <th>Nombres y Apellidos</th>
                <th>Fecha Inicio            </th>
                <th>Término del Contrato</th>
                <th>No. Prórrogas</th>
                <th>Fecha Terminación        </th>
                <th>Valor Contrato</th>
                <th>Estado</th>
                <th>Motivo</th>
                <th>Porcentaje Retroventa</th>
                <th>Fecha Retroventa        </th>
                <th>Reclama Tercero</th>
                <th>Contrato Extraviado</th>
                <th></th>
                <th></th> 
                <th></th>
            </tr>
        </thead>        
    </table>

  </div>
</div>

<form id="form_pdf_contrato" class="hide" method="POST" action="{{ url('creacioncontrato/generarpdf') }}">
    {{ csrf_field() }}  
    <input type="hidden" id="contrato_pdf" name="contrato_pdf" >
    <input type="hidden" id="tienda_pdf" name="tienda_pdf" >
    <input type="submit" />
</form>

<input type="hidden" id="tienda_actual" name="tienda_actual" value="{{$tienda_actual->id}}" >

@endsection

<style>

th, td{
    font-size: 13px;
}

</style>

@push('scripts')
    <!-- <script src="{{asset('/js/configcontrato.js')}}"></script> -->
    <script src="{{asset('js/Trasversal/Filtros/cabeceraDatatable.js')}}"></script>
@endpush

@section('javascript')   
  @parent
    //<script>

    @if(Session::has('session_tienda_pdf'))
        alert("HOLA MUNDO");
        $('#tienda_pdf').val({{ Session::get('session_tienda_pdf') }});
        $('#contrato_pdf').val({{ Session::get('session_contrato_pdf') }});
        $('#form_pdf_contrato').submit();
    @endif

   column=[           
            { "data": "tienda" },
            { "data": "categoria_general" },
            { "data": "codigo_contrato"},
            { "data": "tipo_documento"},
            { "data": "documento_cliente"},
            { "data": "nombres_cliente"},
            { "data": "fecha_creacion" },
            { "data": "termino" },
            { "data": "numero_prorrogas" },
            { "data": "fecha_terminacion" },
            { "data": "valor_contrato" },
            { "data": "estado_tema" },
            { "data": "motivo_contrato" },
            { "data": "porcen_retroventa" },
            { "data": "fecha_retroventa" },
            { "data": "reclamo_tercero" },
            { "data": "contrato_extraviado" },
            { "data": "", "visible": false, },
            { "data": "", "visible": false, },
            { "data": "", "visible": false, },
        ];
  	dataTableActionFilter("{{url('/contrato/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)
    
    var url2=urlBase.make('gestionestado/estado/getEstadoByTema')+"/"+2;
    loadSelectInput('#col7_filter', url2, true);

    
    loadSelectInput('#col11_filter', urlBase.make('clientes/tipodocumento/getSelectList2'), true);
    loadSelectInput('#col16_filter', urlBase.make('products/categories/getCategory'), true);

    $('#col7_filter').change(function(){
        var id=$(this).val();
        var url2=urlBase.make('/gestionestado/motivo/getmotivobyestado')+"/"+id;
        loadSelectInput('#col8_filter', url2, true); 
    });
    
    $('#btn-aplazar').click(function(){
      var url = "{{ url('/contrato/aplazar') }}";
      updateRowDatatableAction(url)
    });

    $('#btn-ver').click(function(){
      var url = "{{ url('/contrato/ver') }}";
      updateRowDatatableAction(url);
    });

    $('#btn-retroventa').click(function(){
      var url = "{{ url('/contrato/retroventa') }}";
      updateRowDatatableAction(url);
    });

    // $('#btn-prorrogar').click(function(){
    //     var url = "{{ url('/contrato/prorrogar') }}";
    //     updateRowDatatableAction(url)
    // });

    $("#updateAction1").click(function() {
      var url2="{{ url('/profesion/update') }}";
      updateRowDatatableAction(url2)
    });

    $("#btn-cerrarContrato").click(function()
    {
      var url2 ="{{ url('/contrato/cerrarcontrato') }}";
      updateRowDatatableAction(url2)
    })

    $("#anularAction").click(function() { 
      var url2="{{ url('/contrato/anular') }}";
      updateRowDatatableAction(url2);
    });

@endsection
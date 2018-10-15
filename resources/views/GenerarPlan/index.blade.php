@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Consulta de plan separe</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
        <div class="row">
            <div class="btn-group pull-right espacio" role="group" >
                <a title="Nuevo Registro" href="{{ url('/generarplan/verificarcliente') }}"  id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
                <button title="Información plan separe"  id="info" class="btn btn-warning"><i class="fa fa-info-circle"></i> Ver</button>
                <button title="Abonar plan separe"  id="abonar" class="btn btn-primary"><i class="fa fa-money"></i> Abonar</button>
                <button title="Transferir plan separe"  id="transferir" type="button" class="btn btn-success"><i class="fa fa-exchange "></i> Transferir</button>
                <button title="Facturar plan separe"  id="facturar" type="button" class="btn btn-info"><i class="fa fa-money "></i> Facturar</button>
            </div> 
        </div>

    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
                <tr id="filter_col1" data-column="0">
                    <td>
                        <label>Tienda</label>
                        <select class="form-control column_filter" id="col0_filter">
                            <option value="">-- seleccionar un registro</option>
                            @foreach($tienda as $tipo)
                                <option value="{{$tipo->id}}" @if($id_tienda == $tipo->id) selected @endif>{{$tipo->name}}</option>
                            @endforeach    
                        </select>
                    </td>
                </tr>
                <tr id="filter_col2" data-column="1">
                    <td>
                        <label>Código plan separe</label>
                        <input  class="form-control column_filter" type="text" id="col1_filter" placeholder="-Ingrese código plan separe-">
                    </td>
                </tr>
                <tr id="filter_col3" data-column="2">
                    <td>
                        <label>Tipo documento</label>
                        <select class="form-control column_filter" id="col2_filter">
                            <option value="">-- seleccionar un registro</option>
                            @foreach($tipo_documento as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->name}}</option>
                            @endforeach    
                        </select>
                    </td>
                </tr>
                <tr id="filter_col4" data-column="3">
                    <td>
                        <label>Número de documento</label>
                        <input  class="form-control column_filter" type="text" id="col3_filter" name="numero_documento" placeholder="-Ingrese número de documento-">
                    </td>
                </tr>
                <tr id="filter_col5" data-column="4">
                    <td>
                        <label>Estado</label>
                        <select class="form-control column_filter" id="col4_filter" name="estado">
                            <option value="">-- seleccionar un registro</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}" @if($estado->id == env('PLAN_ESTADO_ACTIVO')) selected @endif>{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="filter_col6" data-column="5">
                    <td>
                        <label>Fecha de creación: Desde</label>
                        <input type="text" class="column_filter form-control data-picker-only" id="col5_filter" name="fecha_cracion_i" maxlength="10" placeholder="Desde">
                    </td>
                </tr>
                <tr id="filter_col7" data-column="6">    
                    <td>
                        <label>Hasta</label>
                        <input type="text" class="column_filter form-control data-picker-only" id="col6_filter" name="fecha_creacion_f" maxlength="10" placeholder="Hasta" value="{{ date('d-m-Y') }}">
                    </td>
                </tr>
                <tr id="filter_col8" data-column="7">
                    <td>
                        <label>Fecha límite: Desde</label>
                        <input type="text" class="column_filter form-control data-picker-only" id="col7_filter" name="fecha_limite_i" maxlength="10" placeholder="Desde">
                    </td>
                </tr>
                <tr id="filter_col9" data-column="8">    
                    <td>
                        <label>Hasta</label>
                        <input type="text" class="column_filter form-control data-picker-only" id="col8_filter" name="fecha_limite_f" maxlength="10" placeholder="Hasta" value="{{ date('d-m-Y') }}">
                    </td>
                </tr>
                <tr id="filter_col10" data-column="0">
                    <td><button type="text" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div> 
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
            <tr> 
                <th>Código plan separe</th>
                <th>Nombre tienda</th>
                <th>Tipo documento</th>
                <th>Número documento</th>
                <th>Nombre y apellido</th>
                <th>Fecha de creación</th>
                <th>Fecha límite    </th>
                <th>Valor plan separe</th>
                <th>Total abonos</th>
                <th>Saldo pendiente</th>
                <th>Estado</th>
            </tr>
        </thead>        
    </table>
  </div>
</div>

@endsection
@push('scripts')
    <script src="{{asset('/js/plansepare.js')}}"></script>
@endpush

@section('javascript')   
  @parent
  //<script>

   column=[  
            {"data": "codigo_plan_separe"},
            {"data": "nombre_tienda"},
            {"data": "tipo_documento"},
            {"data": "numero_documento"},
            {"data": "nombre_completo"},
            {"data": "fecha_creacion"},
            {"data": "fecha_limite"},
            {"data": "valor_plan"},
            {"data": "total_abonos"},
            {"data": "saldo_pendiente"},
            {"data": "estado"},
        ];
      dataTableActionFilter("{{url('generarplan/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)
    
    
    $("#abonar").click(function() {
        var table = $('#dataTableAction').DataTable();
        var valueId = table.$('tr.selected').attr('id');
        var url2="{{ url('/generarplan/abonar') }}";
        if (valueId != "" && valueId != undefined) {
            abonoRedirect(url2)
        } else {
            Alerta('Error', 'Debe seleccionar un registro para poder continuar.', 'Error')
        }
    });

    $("#info").click(function() {
        var table = $('#dataTableAction').DataTable();
        var valueId = table.$('tr.selected').attr('id');
        var url2="{{ url('/generarplan/infoAbono') }}";
        if (valueId != "" && valueId != undefined) {
            updateRowDatatableAction(url2)
        } else {
            Alerta('Error', 'Debe seleccionar un registro para poder continuar.', 'Error')
        }
    });

    $("#facturar").click(function() {
        var table = $('#dataTableAction').DataTable();
        var valueId = table.$('tr.selected').attr('id');
        var url2="{{ url('/ventas/createVentaPlan') }}";
        if (valueId != "" && valueId != undefined) {
            facturarRedirect(url2)
        } else {
            Alerta('Error', 'Debe seleccionar un registro para poder continuar.', 'Error')
        }
    });
    
    $("#transferir").click(function() { 
        var table = $('#dataTableAction').DataTable();
        var valueId = table.$('tr.selected').attr('id');
        var url2="{{ url('/generarplan/transferirPlan') }}";
        if (valueId != "" && valueId != undefined) {
            transferirRedirect(url2);
        } else {
            Alerta('Error', 'Debe seleccionar un registro para poder continuar.', 'Error')
        }
    });
@endsection
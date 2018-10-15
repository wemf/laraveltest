@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
        <h2>Logística</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="row">
            <div class="btn-group pull-right espacio" role="group" aria-label="..." >
                <a href="{{ url('/contrato/logistica/create') }}" title="Nuevo Contrato" id="btn-contrato" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo</a>
                <button title="Retroventa de Contrato" id="btn-seguimiento" class="btn btn-primary"><i class="fa fa-eye"></i> Seguimiento</a>
                <button title="Cerrar Contrato"  id="btn-trazabilidad" type="button" class="btn btn-warning"><i class="fa fa-list"></i> Trazabilidad</button>
                <button title="Anular Contrato"  id="btn-anular" type="button" class="btn btn-danger"><i class="fa fa-ban "></i> Anulación</button> 
            </div> 
        </div>
        <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
        <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
        <div class="contentfilter-table">
            <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
                <tbody>
                    <tr id="filter_col1" data-column="0">
                        <td>
                            <label>Número de pedido</label>
                            <input class="form-control column_filter data-picker-only" type="text" id="col0_filter">
                        </td>
                    </tr>
                    <tr id="filter_col2" data-column="1">
                        <td>
                            <label>Codigo de guía</label>
                            <input class="form-control column_filter data-picker-only" type="text" id="col1_filter">
                        </td>
                    </tr>
                    <tr id="filter_col3" data-column="2">
                        <td>
                            <label>Tienda</label>
                            <select class="form-control column_filter" id="col2_filter" name="id_estado">
                                <option value="">-- seleccionar un registro</option>
                                @foreach($tiendas as $tienda)
                                    <option value="{{ $tienda->id }}">{{ $tienda->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="filter_col4" data-column="3">
                        <td><button type="text" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table class="display dataTableAction" width="100%" cellspacing="0" id="dataTableAction">
            <thead>
                <tr>
                    <th>Guía</th>
                    <th>Codigo guía</th>
                    <th>Estado</th>
                    <th>Destino</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('/js/contrato/guia.js')}}"></script>
@endpush 

@section('javascript')   
  @parent
  
  column=[  
        {"data": "DT_RowId"},
        {"data": "codigo_guia"},
        {"data": "estado"},
        {"data": "tienda"}
    ];
    dataTableActionFilter("{{url('/contrato/logistica/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)
    
@endsection
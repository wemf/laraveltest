@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
        <h2>Pedidos</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="row">
            <div class="btn-group pull-right espacio" role="group" aria-label="..." >
            
                <button title="Retroventa de Contrato" id="btn-ver" class="btn btn-primary"><i class="fa fa-eye"></i> Ver</a>
                <button title="Retroventa de Contrato" id="btn-aprobar" class="btn btn-success"><i class="fa fa-check"></i> Aprobar</a>
                <button title="Anular Contrato"  id="btn-rechazar" type="button" class="btn btn-danger"><i class="fa fa-ban "></i> Rechazar</button>
            </div> 
        </div>
        <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
        <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
        <div class="contentfilter-table">
            <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
                <tbody>
                    <tr id="filter_col1" data-column="0">
                        <td>
                            <label>Fecha</label>
                            <input  class="form-control column_filter data-picker-only" type="text" id="col0_filter">
                        </td>
                    </tr>
                    <tr id="filter_col2" data-column="1">
                        <td>
                            <label>Categoria</label>
                            <select class="form-control column_filter" id="col1_filter" name="id_categoria">
                                <option value="">-- seleccionar un registro</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr id="filter_col3" data-column="2">
                        <td>
                            <label>Estado</label>
                            <select class="form-control column_filter" id="col2_filter" name="id_estado">
                                <option value="">-- seleccionar un registro</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
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
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Aprobar pedido</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Número de aprobación <span class="required">*</span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input maxlength="25" type="text" id="num_aprobacion" name="num_aprobacion" class="form-control col-md-7 col-xs-12 justNumbers">
                                <input type="hidden" id="valuex" name="valuex">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="save-aprobar">Aprobar</button>
                </div>
            </div>
        </div>
    </div>
        <div class="items_pedidos_tmp">
            <table class="display dataTableAction" width="100%" cellspacing="0" id="dataTableAction">
                <thead>
                    <tr>
                        <th>Tienda Pedido</th>
                        <th>Número de pedido</th>
                        <th>Referencia</th>
                        <th>Referencia Tienda</th>
                        <th>Categoria</th>
                        <th>Estado</th>
                        <th>Fecha pedido</th>
                        <th>Fecha aprobación</th>
                        <th>Fecha cierre</th>
                        <th>Nro aprobación</th>
                        <th>Unidades pedido</th>
                        <th>Recibidas</th>
                        <th>Pendientes</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('/js/pedido.js')}}"></script>
@endpush 


@section('javascript')
    @parent
    
    column=[           
            { "data": "tienda_pedido" },
            { "data": "numero_pedido" },
            { "data": "referencia" },
            { "data": "tienda_referencia" },
            { "data": "categoria" },
            { "data": "estado" },
            { "data": "fecha_pedido" },
            { "data": "fecha_aprobacion" },
            { "data": "fecha_cierre" },
            { "data": "numero_aprobacion" },
            { "data": "unidades" },
            { "data": "recibidas" },
            { "data": "pendientes" },
        ];
  	dataTableAction("{{url('pedidos/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)    
    
    $("#btn-ver").click(function() {
        ver();
    });

    $("#btn-aprobar").click(function() {
        aprobar();
    });

    $("#btn-rechazar").click(function() {
        rechazar();
    });


@endsection
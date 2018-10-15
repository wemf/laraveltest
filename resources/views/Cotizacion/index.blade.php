@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Consulta de cotizaciones de plan separe</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
        <div class="row">
            <div class="btn-group pull-right espacio" role="group" >
                <a title="Nuevo Registro" href="{{ url('/cotizacion/create') }}"  id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Cotizar</a>
                <button title="Ver cotización"  id="info" class="btn btn-warning"><i class="fa fa-info-circle"></i> Ver</button>
        </div>

    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
                <tr id="filter_col1" data-column="0">
                    <td>
                        <label>Estado</label>
                        <select class="form-control column_filter" id="col0_filter">
                            <option value="">- seleccion opción -</option>
                            <option value="1">Pendiente</option>
                            <option value="0">Respondido</option>
                        </select>
                    </td>
                </tr>
                <tr id="filter_col1" data-column="1">
                    <td><button type="text" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div> 
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
            <tr> 
                <th>Número de cotización</th>
                <th>Nombre joyeria</th>
                <th>Descripción</th>
                <th>Referencia</th>
                <th>Precio</th>
                <th>Fecha creación</th>
                <th>Fecha respuesta</th>
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
            {"data": "id_cotizacion"},
            {"data": "nombre_tienda"},
            {"data": "descripcion"},
            {"data": "referencia"},
            {"data": "precio"},
            {"data": "fecha"},
            {"data": "fecha_res"},
            {"data": "estado"},
        ];
      dataTableActionFilter("{{url('cotizacion/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    $("#info").click(function() {
      var url2="{{ url('/cotizacion/update') }}";
      updateRowDatatableAction(url2)
    });

@endsection
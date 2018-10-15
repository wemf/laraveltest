@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Ventas</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <a title="Nueva factura por venta directa" href="{{ url('compras/createCompra') }}" id="newAction" class="btn btn-success"><i class="fa fa-plus"></i> Ingresar compra</a>
      <a title="Hacer devolución" id="devolucion" class="btn btn-danger"><i class="fa fa-minus"></i> Devolución de compra</a>
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
            
                <tr id="filter_col1" data-column="0">
                    <td>Tienda
                        <select  class="column_filter form-control " id="col0_filter">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                    </td>
                </tr>

                <tr id="filter_col2" data-column="1">
                    <td>Lote 
                        <select  class="column_filter form-control " id="col1_filter">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                    </td>
                </tr>

                <tr id="filter_col10" class="no-width" data-column="9">
                    <td>
                    Inactivos<input type="checkbox" onchange="intercaleCheckInvert(this);" id="col9_filter" class="column_filter check-control check-pos" value="1" />
                        <label for="col9_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                    </td>
                </tr>
                <tr>
                    <td><button type="text" onclick="intercaleFunction('col9_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div> 
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
          <tr>               
              <th>Tienda</th> 
              <th>Lote</th> 
              <th>Número de<br>articulos</th>
              <th>Costo</th>
              <th>Fecha de compra</th>
              <th>Número de<br>devoluciones</th>
              <th>Costo de<br>devoluciones</th>
              <th>Fecha devolución</th>
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@section('javascript')   
  @parent
   //<script>
   column=[           
            { "data": "tienda" },
            { "data": "lote" },
            { "data": "compra" },
            { "data": "costo_compra" },
            { "data": "fecha_compra" },
            { "data": "devolucion_compra" },
            { "data": "costo_devolucion" },
            { "data": "fecha_devolucion" },
        ];
  	dataTableActionFilter("{{url('/compras/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column);

    $("#devolucion").click(function() {
      var url2="{{ url('compras/devolucion') }}";
      updateRowDatatableAction(url2)
    });
@endsection
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
      <a title="Nueva factura por venta directa" href="{{ url('ventas/createVentaDirecta') }}" id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Factura venta directa</a>
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
            
                <tr id="filter_col1" data-column="0">
                    <td>País
                        <select  class="column_filter form-control " id="col0_filter">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                    </td>
                </tr>

                <tr id="filter_col2" data-column="1">
                    <td>Departamento 
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
              <th>Tipo documento</th> 
              <th>Documento</th>
              <th>Nombre completo</th>
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
            { "data": "pais" },
            { "data": "departamento" },
            { "data": "ciudad" },
            { "data": "zona" },
        ];
  	dataTableActionFilter("{{url('/tienda/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column);


@endsection
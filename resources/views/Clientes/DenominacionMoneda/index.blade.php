@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Denominación de Monedas</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('Trasversal.Boton.botonCrud', ['href' => "/clientes/denominacionmoneda/create"])
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
                    <td>Nombre<input type="text" class="column_filter form-control" id="col1_filter"></td>
                </tr>

                <tr id="filter_col3" class="no-width" data-column="2">
                    <td>
                        Inactivos<input type="checkbox" onchange="intercaleCheckInvert(this);" id="col2_filter" class="column_filter check-control check-pos" value="1" />
                        <label for="col2_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                    </td>
                </tr>

                <tr id="" data-column="5">
                    <td><button type="text" onclick="intercaleFunction('col2_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div> 
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
          <tr>               
              <th>País</th>           
              <th>Nombre</th> 
              <th>Valor</th>               
              <th>Activo</th> 
          </tr>
      </thead>        
    </table>

  </div>
</div>

@endsection

@section('javascript')   
  @parent
   column=[           
            { "data": "pais" },   
            { "data": "nombre" },
            { "data": "valor" },            
            { "data": "estado" },
        ];
  	dataTableActionFilter("{{url('/clientes/denominacionmoneda/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

      loadSelectInput("#col0_filter","{{ url('/pais/getSelectList') }}")
      SelectValPais("#col0_filter");

    $("#updateAction1").click(function() {
      var url2="{{ url('/clientes/denominacionmoneda/update') }}";
      updateRowDatatableAction(url2)
    });

    $("#deletedAction1").click(function() { 
      var url2="{{ url('/clientes/denominacionmoneda/delete') }}";
      deleteRowDatatableAction(url2);
    });

    $("#activatedAction1").click(function() { 
      var url2="{{ url('/clientes/denominacionmoneda/active') }}";
      deleteRowDatatableAction(url2, "¿Activar el registro?");
    });

@endsection
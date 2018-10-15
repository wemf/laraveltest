@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')


<div class="x_panel">
  <div class="x_title"><h2>
    Ciudades</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('Trasversal.Boton.botonCrud', ['href' => "/ciudad/create"])
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
            
                <tr id="filter_col0" data-column="0">
                    <td>País
                    <select  class="column_filter form-control " id="col0_filter">
                        <option value="">- Seleccione una opción -</option>
                    </select>
                    </td>
                </tr>

                <tr id="filter_col1" data-column="1">
                    <td>Departamento 
                    <select  class="column_filter form-control " id="col1_filter">
                        <option value="">- Seleccione una opción -</option>
                    </select>
                    </td>
                </tr>

                <tr id="filter_col3" data-column="2">
                    <td>Ciudad<input type="text" class="column_filter form-control" id="col2_filter"></select></td>
                </tr>

                <tr id="filter_col3" data-column="3">
                    <td>Código Dane<input type="text" class="column_filter form-control" id="col3_filter"></select></td>
                </tr>

                <tr id="filter_col4" class="no-width" data-column="4">
                    <td>
                        Inactivos<input type="checkbox" onchange="intercaleCheckInvert(this);" id="col4_filter" class="column_filter check-control check-pos" value="1" />
                        <label for="col4_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                    </td>
                </tr>

                <tr>
                    <td><button type="text" onclick="intercaleFunction('col4_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div> 
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
          <tr>               
              <th>País</th> 
              <th>Departamento</th>
              <th>Ciudad</th>
              <th>Código DANE</th>
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
            { "data": "departamento" },
            { "data": "nombre" },
            { "data": "codigo_dane" },
            { "data": "estado" },
        ];
  	dataTableActionFilter("{{url('/ciudad/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    var url2 = urlBase.make('pais/getSelectList');
    loadSelectInput('#col0_filter', url2, true);
    SelectValPais("#col0_filter");

    function llenarSelect()
    {
        var id = $('#col0_filter').val();
        var url2 = urlBase.make('departamento/getdepartamentobypais') + "/" + id;
        loadSelectInput('#col1_filter', url2, true);
    }
    llenarSelect();

    $('#col0_filter').change(function () {
        llenarSelect();
    });      
      
    $("#updateAction1").click(function() {
      var url2="{{ url('/ciudad/update') }}";
      updateRowDatatableAction(url2)
    });

    $("#deletedAction1").click(function() { 
      var url2="{{ url('/ciudad/delete') }}";
      deleteRowDatatableAction(url2);
    });

    $("#activatedAction1").click(function() { 
      var url2="{{ url('/ciudad/active') }}";
      deleteRowDatatableAction(url2, "¿Activar el registro?");
    });

@endsection
@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Joyerías/Establecimientos Administrativos</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('Trasversal.Boton.botonCrud', ['href' => "/tienda/create"])
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

                <tr id="filter_col3" data-column="2">
                    <td>Ciudad<select class="column_filter form-control" id="col2_filter">
                                <option value="">- Seleccione una opción -</option>
                              </select></td>
                </tr>

                <tr id="filter_col4" data-column="3">
                    <td>Zona<select class="column_filter form-control" id="col3_filter"></select></td>
                </tr>

                <tr id="filter_col5" data-column="4">
                    <td>Sociedad<input type="text" class="column_filter form-control" id="col4_filter"></td>
                </tr>
                
                <tr id="filter_col6" data-column="5">
                    <td>Nombre Comercial<input type="text" class="column_filter form-control" id="col5_filter"></td>
                </tr>
                <tr id="filter_col7" data-column="6">
                    <td>Tienda<input type="text" class="column_filter form-control" id="col6_filter"></td>
                </tr>
                
                <tr id="filter_col8" data-column="7">
                    <td>Código Tienda<input type="text" class="column_filter form-control" id="col7_filter"></td>
                </tr>

                <tr id="filter_col9" data-column="8">
                    <td>IP Tienda<input type="text" class="column_filter form-control" id="col8_filter"></td>
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
              <th>País</th> 
              <th>Departamento</th> 
              <th>Ciudad</th>
              <th>Zona</th> 
              <th>Sociedad</th> 
              <th>Nombre Comercial</th> 
              <th>Tienda</th>               
              <th>Código Tienda</th>                                           
              <th>Teléfono</th> 
              <th>Ip Tienda</th> 
              <th>Activo</th>
              <th class='hide'></th>
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
            { "data": "ciudad" },
            { "data": "zona" },
            { "data": "sociedad" },
            { "data": "franquicia" },
            { "data": "nombre" },            
            { "data": "codigo_tienda" },            
            { "data": "telefono" },
            { "data": "ip_tienda" },
            { "data": "estado" },
            { "data": "" , "visible": false}
        ];
  	dataTableActionFilter("{{url('/tienda/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column);

      var url2 = urlBase.make('pais/getSelectList');
      loadSelectInput('#col0_filter', url2, true);
      SelectValPais("#col0_filter");
  
      $('#col0_filter').change(function () {
          var id = $('#col0_filter').val();
          var url2 = urlBase.make('departamento/getdepartamentobypais') + "/" + id;
          loadSelectInput('#col1_filter', url2, true);
  
          url2 = urlBase.make('zona/getSelectListZonaPais') + "/" + id;
          loadSelectInput('#col3_filter', url2, true);
      });   
  
      $('#col0_filter').change();

    $('#col1_filter').change(function() {
        var id = $(this).val();
        var url2 = urlBase.make('ciudad/getciudadbydepartamento') + "/" + id;
        loadSelectInput('#col2_filter', url2, true);
    });

    $("#updateAction1").click(function() {
      var url2="{{ url('/tienda/update') }}";
      updateRowDatatableAction(url2)
    });

    $("#deletedAction1").click(function() { 
      var url2="{{ url('/tienda/delete') }}";
      deleteRowDatatableAction(url2);
    });
    
    $("#activatedAction1").click(function() { 
      var url2="{{ url('/tienda/active') }}";
      deleteRowDatatableAction(url2, "¿Activar el registro?");
    });

@endsection
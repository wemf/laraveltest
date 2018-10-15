@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
      <h2>Prestamos Entre Sociedades</h2>
    <div class="clearfix"></div>
    </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
        <a title="Nuevo Registro" href="{{ url('/tesoreria/prestamos/create') }}"  id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Prestamos</a>        
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
                <tr id="filter_col0" data-column="0">
                    <td>Sociedad Prestadora
                        <select  class="column_filter form-control " id="col0_filter">
                        <option value="">-Seleccione una opción-</option>
                        @foreach($sociedades AS $sociedad)
                        <option value="{{$sociedad->name}}">{{$sociedad->name}}</option>
                        @endforeach
                        </select>
                    </td>
                </tr>

                <tr id="filter_col1" >
                    <td>Sociedad Presta
                        <select  class="column_filter form-control " id="col1_filter">
                        <option value="">-Seleccione una opción-</option>
                        @foreach($sociedades AS $sociedad)
                        <option value="{{$sociedad->id}}">{{$sociedad->name}}</option>
                        @endforeach
                        </select>                    
                    </td>
                </tr>

                 <tr id="filter_col6" data-column="1">
                    <td>Tienda Presta
                        <select  class="column_filter form-control " id="col6_filter">
                        <option value="">-Seleccione una opción-</option>
                        </select>                    
                    </td>
                </tr>

                <tr id="filter_col2" data-column="2">
                    <td>País <select  class="column_filter form-control " id="col2_filter"></select></td>
                </tr>

                <tr id="filter_col3" data-column="3">
                    <td>Departamento <select  class="column_filter form-control " id="col3_filter"></select></td>
                </tr>

                <tr id="filter_col4" data-column="4">
                    <td>Ciudad <select  class="column_filter form-control " id="col4_filter"><option value="">-Seleccione una opción-</option></select></td>
                </tr>

                <tr id="filter_col4" data-column="5">
                    <td>Tienda <select  class="column_filter form-control " id="col5_filter"><option value="">-Seleccione una opción-</option></select></td>
                </tr>
                
                <tr>
                    <td><button type="text" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
      <thead>
          <tr>               
              <th>Sociedad Prestadora</th>           
              <th>Tienda Presta</th>           
              <th>Usuario</th>           
              <th>Fecha Prestamo</th>           
              <th>Valor</th>
              <th class="hide"></th>               
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@section('javascript')   
  @parent
   column=[              
            { "data": "sociedad_prestadora" },
            { "data": "tienda_presta" },
            { "data": "usuario" },
            { "data": "fecha" },
            { "data": "valor" },
            { "data": "", "visible": false, },
        ];
  	dataTableActionFilter("{{url('/tesoreria/prestamos/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    $("#updateAction1").click(function() {
      var url2="{{ url('/tesoreria/impuesto/update') }}";
      updateRowDatatableAction(url2)
    });

    //Cargas Iniciales
    loadSelectInput("#col2_filter",urlBase.make('pais/getSelectList'));
    SelectValPais("#col2_filter");

    //Eventos
    $('#col2_filter').change(function () {
            var id = $('#col2_filter').val();
            var url2 = urlBase.make('departamento/getdepartamentobypais') + "/" + id;
            loadSelectInput('#col3_filter', url2, true);
    });

    $('#col2_filter').change();    

  $('#col1_filter').change(function(){
      fillSelect('#col1_filter','#col6_filter','{{ url('/tienda/gettiendabysociedad') }}');
  });

    $('#col3_filter').change(function() {
        var id = $(this).val();
        loadSelectInput('#col4_filter',urlBase.make('ciudad/getciudadbydepartamento')+"/"+id, true);
    });

    $('#col4_filter').change(function() {
        var id = $(this).val();
        loadSelectInput('#col5_filter', urlBase.make('tienda/getTiendaByCiudad')+"/"+id, true);
    });

@endsection

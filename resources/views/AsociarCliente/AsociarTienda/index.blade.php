@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Asociaciones a Tiendas</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
	    <a title="Nuevo Registro" href="{{ url('/asociarclientes/asociartienda/create') }}"  id="newAction" class="btn btn-primary hide"><i class="fa fa-pencil-square-o  "></i> </a>
	    <button title="Gestionar Tiendas"  id="updateAction1" type="button" class="btn btn-success"><i class="fa fa-pencil-square-o  "></i> Asociar a tienda</button>
        <button title="Desactivar Registro Seleccionado"  id="deletedAction1"  type="button" class="btn btn-danger hide"><i class="fa fa-times-circle "></i> Desactivar</button>
        <button title="Activar Registro Seleccionado"  id="activatedAction1"  type="button" class="btn btn-warning hide"><i class="fa fa-check "></i> Activar</button> 
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
                <tr id="filter_col6" data-column="5">
                    <td>Tipo de Cliente
                        <select  class="column_filter form-control " id="col5_filter">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                </td>
                </tr>
                 <tr id="filter_col1" data-column="0">
                    <td>Tipo de Documento
                        <select  class="column_filter form-control " id="col0_filter">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                    </td>
                </tr>
                <tr id="filter_col7" data-column="6">
                    <td>Documento<input type="text" class="column_filter form-control" id="col6_filter"></td>
                </tr>
                <tr id="filter_col3" data-column="2">
                    <td>Nombre<input type="text" class="column_filter form-control" id="col2_filter"></td>
                </tr>
                <tr id="filter_col4" data-column="3">
                    <td>Primer Apellido<input type="text" class="column_filter form-control" id="col3_filter"></td>
                </tr>
                <tr id="filter_col5" data-column="4">
                    <td>Segundo Apellido<input type="text" class="column_filter form-control" id="col4_filter"></td>
                </tr>
                <tr id="filter_col2" data-column="1" class="hide">
                    <td>
                        Desactivados<input type="checkbox" onchange="intercaleCheckInvert(this);" id="col1_filter" class="column_filter check-control check-pos" value="1" />
                        <label for="col1_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                    </td>
                </tr>
                <tr id="filter_col0" data-column="5">
                    <td><button type="text" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
                
            </tbody>
        </table>
    </div> 
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
          <tr> 
              <th>Tipo de Cliente</th>
              <th>Tipo Documento</th>
              <th>Documento</th>              
              <th>Nombre</th> 
              <th>Primer Apellido</th>
              <th>Segundo Apellido</th>
              <th>Correo</th>
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
            { "data": "tipodocliente" },     
            { "data": "tipodocumento" },
            { "data": "documento" },
            { "data": "nombre" },
            { "data": "primerapellido" },
            { "data": "segundoapellido" },
            { "data": "correo" },
            { "data": "estado" },
        ];
  	dataTableActionFilter("{{url('/asociarclientes/asociartienda/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    $("#updateAction1").click(function() {
      var url2="{{ url('/asociarclientes/asociartienda/create') }}";
      updateRowDatatableAction(url2)
    });

    $("#deletedAction1").click(function() { 
      var url2="{{ url('/clientes/areatrabajo/delete') }}";
      deleteRowDatatableAction(url2);
    });

    $("#activatedAction1").click(function() { 
      var url2="{{ url('/clientes/areatrabajo/active') }}";
      deleteRowDatatableAction(url2, "¿Activar el registro?");
    });

    loadloadSelectWithTextValue("#col0_filter","{{ url('/clientes/tipodocumento/getSelectList') }}");
    loadloadSelectWithTextValue("#col5_filter","{{ url('/asociarclientes/asociartienda/getselectlisttipocliente') }}");

@endsection
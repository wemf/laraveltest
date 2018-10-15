@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
      <h2>Tipo de Documentos Contables</h2>
        <div class="clearfix"></div>
    </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <a title="Nuevo Registro" href="{{ url('/tesoreria/tipodocumentocontable/create') }}"  id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
      <button title="Actualizar Registro Seleccionado"  id="updateAction1" type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o  "></i> Actualizar</button>
      <button title="Desactivar Registro Seleccionado"  id="deletedAction1"  type="button" class="btn btn-orange"><i class="fa fa-times-circle "></i> Desactivar</button>
      <button title="Activar Registro Seleccionado"  id="activatedAction1"  type="button" class="btn btn-warning"><i class="fa fa-times-circle "></i> Activar</button>
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
            <tbody>
                <tr id="filter_col1" data-column="0">
                    <td>Nombre<input type="text" class="column_filter form-control" id="col0_filter"></td>
                </tr>
                <tr id="filter_col2" class="no-width" data-column="1">
                    <td>
                        Inactivos<input type="checkbox" onchange="intercaleCheckInvert(this);" id="col1_filter" class="column_filter check-control check-pos" value="1" />
                        <label for="col1_filter" class="lbl-check-control" style="font-size: 27px !important; font-weight: 100; height: 26px; display: block;"></label>
                    </td>
                </tr> 
                <tr>
                    <td><button type="text" onclick="intercaleFunction('col1_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
      <thead>
          <tr>               
              <th>Nombre</th> 
              <th>Activo</th> 
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@section('javascript')   
  @parent
    $(document).ready(function(){
        $('.button_filter').click();
    });

   column=[           
            { "data": "nombre" },
            { "data": "estado" },
        ];
  	dataTableActionFilter("{{url('/tesoreria/tipodocumentocontable/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    $("#updateAction1").click(function() {
      var url2="{{ url('/tesoreria/tipodocumentocontable/update') }}";
      updateRowDatatableAction(url2);
    });

    $("#deletedAction1").click(function() { 
      var url2="{{ url('/tesoreria/tipodocumentocontable/desactivate') }}";
      deleteRowDatatableAction(url2);
    });

    $("#activatedAction1").click(function() { 
      var url2="{{ url('/tesoreria/tipodocumentocontable/active') }}";
      deleteRowDatatableAction(url2, "¿Activar el registro?");
    });
@endsection
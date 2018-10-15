@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
      <h2>Impuestos</h2>
    <div class="clearfix"></div>
    </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
        <!-- <a title="Nuevo Registro" href="{{ url('/tesoreria/impuesto/create') }}"  id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>         -->
        <!-- <button title="Actualizar Registro Seleccionado"  id="updateAction1" type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o  "></i> Actualizar</button> -->
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
            <tbody>
                <tr id="filter_col0" data-column="0">
                    <td>Nombre<input type="text" class="column_filter form-control" id="col0_filter"></td>
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
              <th>Nombre</th>           
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@section('javascript')   
  @parent
   column=[              
            { "data": "nombre" },
        ];
  	dataTableActionFilter("{{url('/tesoreria/impuesto/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    $("#updateAction1").click(function() {
      var url2="{{ url('/tesoreria/impuesto/update') }}";
      updateRowDatatableAction(url2)
    });
@endsection
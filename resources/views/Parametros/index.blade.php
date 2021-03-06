@extends('layouts.master')

@section('content')

@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title"><h2>Parámetros Generales</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
	    @if($existeParametro == 0)
            <a title="Nuevo Registro" href="{{ url('/parametros/create') }}"  id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
        @endif
	    <button title="Actualizar Registro Seleccionado"  id="updateAction1" type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o  "></i> Actualizar</button>
    {{--  <button title="Desactivar Registro Seleccionado"  id="deletedAction1"  type="button" class="btn btn-danger"><i class="fa fa-times-circle "></i> Desactivar</button>   --}}
    <button title="Activar Registro Seleccionado"  id="activatedAction1"  type="button" class="btn btn-warning hide"><i class="fa fa-check "></i> Activar</button>      
    </div> 
    {{--<input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
            <tbody>
                <tr id="filter_col1" data-column="0">
                    <td>Nombre<input type="text" class="column_filter form-control" id="col0_filter"></td>
                </tr>
                <tr id="filter_col2" data-column="1">
                    <td>
                        Inactivos<input type="checkbox" onchange="intercaleCheckInvert(this);" id="col1_filter" class="column_filter check-control check-pos" value="1" />
                        <label for="col1_filter" class="lbl-check-control" style="font-size: 27px !important; font-weight: 100; height: 26px; display: block;"></label>
                    </td>
                </tr>
                <tr id="filter_col3" data-column="0">
                    <td><button type="text" onclick="intercaleFunction('col1_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div> --}}
      <table id="dataTableAction" class="display" width="100%" cellspacing="0">
         <thead>
            <tr>               
                <th>País</th> 
                <th>Abreviado Lenguaje</th> 
                <th>Lenguaje</th>
                <th>Abreviado Moneda</th> 
                <th>Moneda</th> 
                <th>Decimales</th> 
                <th>Redondeo</th> 
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
            { "data": "abreviadoleng" },
            { "data": "lenguaje" },
            { "data": "abreviadomon" },
            { "data": "moneda" },
            { "data": "decimales" },
            { "data": "redondeo" },
            { "data": "estado" },
        ];
  	dataTableActionFilter("{{url('/parametros/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    $("#updateAction1").click(function() {
      var url2="{{ url('/parametros/update') }}";
      updateRowDatatableAction(url2)
    });

    $("#deletedAction1").click(function() { 
      var url2="{{ url('/parametros/delete') }}";
      deleteRowDatatableAction(url2);
    });

    $("#activatedAction1").click(function() { 
      var url2="{{ url('/parametros/active') }}";
      deleteRowDatatableAction(url2, "¿Activar el registro?");
    });
@endsection
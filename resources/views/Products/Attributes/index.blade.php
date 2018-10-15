@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title"><h2>
    Administrar Atributos</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
    <a href="{{ url('/products/attributes/create') }}" title="Agregar Nuevo Registro" type="button" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
	  <button title="Actualizar Registro Seleccionado"  id="updateAction1" type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o "></i> Actualizar</button>
    <button title="Desactivar Registro Seleccionado"  id="deletedAction1"  type="button" class="btn btn-orange"><i class="fa fa-times-circle "></i> Desactivar</button>
    <button title="Activar Registro Seleccionado"  id="activatedAction1"  type="button" class="btn btn-warning hide"><i class="fa fa-check "></i> Activar</button>
    <button title="Eliminar Registro Seleccionado"  id="deletedAction2"  type="button" class="btn btn-danger"><i class="fa fa-times-circle "></i> Eliminar</button> 
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
      <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
        <tbody>
            <tr id="filter_col2" data-column="1">
                <td>Categoría<select type="text" class="column_filter form-control" id="col1_filter"></select></td>
            </tr>
            <tr id="filter_col1" data-column="0">
                <td>Nombre<input type="text" maxlength="70" class="column_filter form-control" id="col0_filter"></td>
            </tr>
            <tr id="filter_col3" class="no-width" data-column="2">
                <td>
                    Inactivos<input type="checkbox" onchange="intercaleCheckInvert(this);" id="col2_filter" class="column_filter check-control check-pos" value="1" />
                    <label for="col2_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                </td>
            </tr>
            <tr>
                <td><button type="button" onclick="intercaleFunction('col2_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
            </tr>
        </tbody>
      </table>
    </div>
      <table id="dataTableAction" class="display nowrap" width="100%" cellspacing="0">
         <thead>
            <tr>
                <th>Categoría</th>
                <th>Atributo Padre</th>
                <th>Nombre</th>
                <th>Activo</th>
            </tr>
        </thead>       
      </table>

  </div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('/js/attributes.js')}}"></script>
@endpush

@section('javascript')
  URL.setUrlGetCategory("{{ url('/products/categories/getCategory') }}");
  URL.setUrlAttributeCategoryById("{{ url('/products/categories/getAttributeCategoryById') }}");
  runAttributeList();
  @parent
   column=[           
            { "data": "categoria" },
            { "data": "atributopadre" },
            { "data": "nombre" },
            { "data": "estado" },
        ];
  	dataTableActionFilter("{{url('/products/attributes/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    $("#updateAction1").click(function() {
      var url2="{{ url('/products/attributes/edit') }}";
      updateRowDatatableAction(url2)
    });

    $("#deletedAction1").click(function() { 
      var url2="{{ url('/products/attributes/inactive') }}";
      deleteRowDatatableAction(url2);
    });

    $("#deletedAction2").click(function() { 
      var url2="{{ url('/products/attributes/delete') }}";
      deleteRowDatatableAction(url2, "¿Eliminar el registro?");
    });

    
    $("#activatedAction1").click(function() { 
      var url2="{{ url('/products/attributes/active') }}";
      deleteRowDatatableAction(url2, "¿Activar el registro?");
    });
@endsection
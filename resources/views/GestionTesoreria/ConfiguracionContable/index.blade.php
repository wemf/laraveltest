@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
      <h2>Configuración Contable</h2>
        <div class="clearfix"></div>
    </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <a title="Nuevo Registro" href="{{ url('/contabilidad/configuracioncontable/create') }}"  id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
      <button title="Actualizar Registro Seleccionado"  id="updateAction1"  type="button" class="btn btn-info"><i class="fa fa-pencil-square-o  "></i> Actualizar</button>            
      <button title="Ver Registro Seleccionado"  id="viewAction1" type="button" class="btn btn-primary"><i class="fa fa-eye"></i> Ver</button>
      <button title="Eliminar Registro Seleccionado"  id="deletedAction1"  type="button" class="btn btn-danger"><i class="fa fa-times-circle "></i> Eliminar</button>          
    </div> 
    
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
            <tbody>
                <tr id="filter_col0" data-column="0">
                    <td>Tipo Documento Contable 
                        <select  class="column_filter form-control " id="col0_filter">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                    </td>
                </tr>
                <tr id="filter_col1" data-column="1">
                    <td>Nombre<input type="text" class="column_filter form-control" id="col1_filter"></td>
                </tr>
                <tr id="filter_col2" data-column="2">
                    <td>Producto<input type="text" class="column_filter form-control" id="col2_filter" title="Para filtrar los registros sin producto escriba 'NO TIENE PRODUCTO'"></td>
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
              <th>Tipo Documento Contable</th> 
              <th>Nombre</th> 
              <th>Producto</th> 
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('/js/tesoreria/configuracionContable.js')}}"></script>
@endpush

@section('javascript')   
  @parent
   column=[           
            { "data": "tipodocumentocontable" },
            { "data": "nombre" },
            { "data": "nombreproducto" },
        ];
  	dataTableActionFilter("{{url('/contabilidad/configuracioncontable/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    loadSelectInput("#col0_filter","{{ url('/tesoreria/tipodocumentocontable/getselectlist') }}");

    $("#viewAction1").click(function() {
      var url2="{{ url('/contabilidad/configuracioncontable/view') }}";
      updateRowDatatableAction(url2)
    });

    $("#updateAction1").click(function() {
      var url2="{{ url('/contabilidad/configuracioncontable/update') }}";
      updateRowDatatableAction(url2)
    });
    
    $("#deletedAction1").click(function() { 
      var url2="{{ url('/contabilidad/configuracioncontable/validarborrable') }}";
      var url1="{{ url('/contabilidad/configuracioncontable/delete') }}";
      validarborrable(url2,url1);
    });
@endsection
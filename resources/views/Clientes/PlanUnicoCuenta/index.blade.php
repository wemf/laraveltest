@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
      <h2>Plan Unico de Cuentas</h2>
        <div class="clearfix"></div>
    </div>
  <div class="x_content">  

    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <a title="Nuevo Registro" href="{{ url('/clientes/planunicocuenta/create') }}"  id="newAction" class="btn btn-success"><i class="fa fa-plus  "></i> Nuevo</a>
      <button title="Actualizar Registro Seleccionado"  id="updateAction1" type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o  "></i> Actualizar</button>   
      <button title="Exportar"  id="exportAction" type="button" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Excel</button>   
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
                <tr id="filter_col0" data-column="0">
                    <td>Cuenta<input type="text" class="column_filter form-control justNumbers" id="col0_filter"></td>
                </tr>
                <tr id="filter_col1" data-column="1">
                    <td>Nombre<input type="text" class="column_filter form-control" id="col1_filter"></td>
                </tr>
                <tr id="filter_col2" data-column="2">
                    <td>Naturaleza
                        <select  class="column_filter form-control " id="col2_filter">
                            <option value="">- Seleccione una opción -</option>
                            <option value="0">Credito</option>
                            <option value="1">Debito</option>
                        </select>
                    </td>
                </tr>
                <tr >
                    <td><button type="text" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
      <thead>
          <tr>               
              <th>Cuenta</th> 
              <th>Nombre</th> 
              <th>Naturaleza</th> 
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@section('javascript')   
  @parent
   column=[           
            { "data": "cuenta" },
            { "data": "nombre" },
            { "data": "naturaleza" },
        ];
  	dataTableActionFilter("{{url('/clientes/planunicocuenta/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column, 1)

    $("#updateAction1").click(function() {
      var url2="{{ url('/clientes/planunicocuenta/update') }}";
      updateRowDatatableAction(url2)
    });

    $("#exportAction").click(function() {
        var url2="{{ url('/clientes/planunicocuenta/getexcel') }}";        
        pageAction.redirect(url2);      
    });
@endsection
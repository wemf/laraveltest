@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Sociedades</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
	  <a title="Nuevo Registro" href="{{ url('/profesion/create') }}"  id="newAction" class="btn btn-primary"><i class="fa fa-pencil-square-o  "></i> Nuevo</a>
	  <button title="Actualizar Registro Seleccionado"  id="updateAction1" type="button" class="btn btn-success"><i class="fa fa-pencil-square-o  "></i> Actualizar</button>
    <button title="Desactivar Registro Seleccionado"  id="deletedAction1"  type="button" class="btn btn-danger"><i class="fa fa-times-circle "></i> Desactivar</button> 
    </div> 
      <table id="dataTableAction" class="display" width="100%" cellspacing="0">
         <thead>
            <tr>               
                <th>Nombre</th> 
                <th>Nit</th> 
                <th>Régimen</th> 
                <th>Franquicia</th> 
                <th>País</th> 
                <th>Departamento</th> 
                <th>Ciudad</th> 
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
            { "data": "nit" },
            { "data": "regime" },
            { "data": "franquicia" },
            { "data": "pais" },
            { "data": "provincia" },
            { "data": "ciudad" },
        ];
  	dataTableAction("{{url('/profesion/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    $("#updateAction1").click(function() {
      var url2="{{ url('/profesion/update') }}";
      updateRowDatatableAction(url2)
    });

    $("#deletedAction1").click(function() { 
      var url2="{{ url('/profesion/delete') }}";
      deleteRowDatatableAction(url2);
    });

@endsection
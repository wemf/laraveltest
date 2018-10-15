@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Secuencias por Tiendas</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
	  <button title="Actualizar Registro Seleccionado"  id="updateAction1" type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o  "></i> Actualizar</button>
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
                <tr id="filter_col2" name="filter_col2" data-column="2">
                    <td>Ciudad<input type="text" class="column_filter form-control buscar_ciudad" onkeyup="buscarCiudad(this);" id="col2_filter">
                        <select multiple id="lista-ciudades" style="display:none" class="form-control" onclick="selectValue(this);">                        
                        </select>
                    </td>
                </tr>
                {{--  <tr id="filter_col6" data-column="3">
                    <td>Zona<input type="text" class="column_filter form-control" id="col3_filter"></td>
                </tr>  --}}
                <tr id="filter_col3" data-column="4">
                    <td>Tienda<input type="text" class="column_filter form-control" id="col4_filter"></td>
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
              <th>País</th> 
              <th>Departamento</th> 
              <th>Ciudad</th> 
              <th>Nombre tienda</th> 
              <th>Establecimiento Admin</th> 
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
            { "data": "nombre" },
            { "data": "sede_principal" },
        ];
  	dataTableActionFilter("{{url('/secuenciatienda/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

    $("#newAction").click(function() {
      var url2="{{ url('/secuenciatienda/create') }}";
      updateRowDatatableAction(url2)
    });

    $("#updateAction1").click(function() { 
      var url2="{{ url('/secuenciatienda/update') }}";
      updateRowDatatableAction(url2);
    });

    function selectValue(val)
    {
        $(val).parent().siblings('.buscar_ciudad').val($(val).find('option:selected').text());
        $('.buscar_ciudad').val($(val).val());
        $('#lista-ciudades').hide();
    }
    function __($var){
        if ($var != '' && $var !== undefined && $var != undefined && $var != "undefined" && $var !== null){
            return $var;
        }else{
            return '';
        }
    }
    function buscarCiudad(element){
        var option = "";
        $('#lista-ciudades').show();
        $.ajax({
            url: urlBase.make('ciudad/getCiudadbyName/'+$(element).val()),
            type: "get",
            
            success: function (data) {
                var j=0;
                jQuery.each(data,function(i,val){
                    if(__(data[j])!=""){
                        option += '<option value="'+data[j].nombre+'">'+data[j].nombre+'</option>';
                        j++;
                    }
                });
                $('#lista-ciudades').empty();
                $('#lista-ciudades').append(option);
                option="";
                
                
            }
        });
    }
@endsection
@extends('layouts.master')

@section('content')

<div class="x_panel">
  <div class="x_title"><h2>Mensajes</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <button title="Notificar"  onclick="noti.vistoAction()" type="button" class="btn btn-primary "><i class="fa fa-bell "></i> Revisar</button>
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
               <tr id="filter_col0" data-column="0">
                    <td>Fecha incial<input type="text" class="data-picker-only column_filter form-control" id="col0_filter" ></td>
                </tr>

                <tr id="filter_col1" data-column="1">
                    <td>Fecha final<input type="text" class="data-picker-only column_filter form-control" id="col1_filter" ></td>
                </tr>

                <tr id="filter_col2" data-column="2">
                    <td>Emisor<input type="text" class="column_filter form-control" id="col2_filter"></td>
                </tr>

                <tr id="filter_col3" data-column="3">
                    <td>
                        Sin leer<input type="checkbox" onchange="intercaleCheckInvert(this);" id="col3_filter" class="column_filter check-control check-pos" value="0" />
                        <label for="col3_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                    </td>
                </tr>

                <tr id="filter_col4" data-column="4">
                    <td>
                        Estado<input type="checkbox" onchange="intercaleCheck(this);" id="col4_filter" class="column_filter check-control check-pos" value="0" />
                        <label for="col4_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                    </td>
                </tr>

                <tr id="filter_col5" data-column="5">
                    <td><button id="col5_filter" type="text" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div> 
      <table id="dataTableAction" class="display" width="100%" cellspacing="0">
         <thead>
            <tr>  
                <th>Fecha</th> 
                <th>Emisor</th>
                <th>Mensaje</th> 
                <th>Estado Lectura</th> 
                <th>Estado</th> 
            </tr>
        </thead>        
      </table>

  </div>
</div>

@endsection

@section('javascript')   
  @parent
    noti.setUrlGet("{{route('mensajes.get')}}");
    noti.setUrlDatatable("{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}");
    noti.setUrlVito("{{ route('mensajes.get.id') }}");
    noti.setUrlBase("{{ url('/') }}");
    noti.run();
@endsection
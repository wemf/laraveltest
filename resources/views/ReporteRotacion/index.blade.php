@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
      <h2>Reporte de rotación de inventario</h2>
        <div class="clearfix"></div>
    </div>
  <div class="x_content">  

    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
      <a title="Nuevo Registro" id="btn-generar-pedido" class="btn btn-success"><i class="fa fa-plus  "></i> Generar pedido</a>
    </div> 
    <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
    <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
    <div class="contentfilter-table" id="contentfilter-table">
        <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
            <tbody>
                <tr id="filter_col1" data-column="0">
                    <td>Pais<select  class="column_filter form-control" id="col0_filter"></select></td>
                </tr>
                <tr id="filter_col2" data-column="1">
                    <td>Departamento<select  class="column_filter form-control" id="col1_filter"><option value="">- Seleccione una opción -</option></select></td>
                </tr>
                <tr id="filter_col3" data-column="2">
                    <td>Ciudad<select  class="column_filter form-control" id="col2_filter"><option value="">- Seleccione una opción -</option></select></td>
                </tr>
                <tr id="filter_col4" data-column="3">
                    <td>Socidad<select  class="column_filter form-control" id="col3_filter"><option value="">- Seleccione una opción -</option></select></td>
                </tr>
                <tr id="filter_col5" data-column="4">
                    <td>Zona<select  class="column_filter form-control" id="col4_filter"></select></td>
                </tr>
                <tr id="filter_col6" data-column="5">
                    <td>Tienda<select  class="column_filter form-control slc_tienda" id="col5_filter"><option value="">- Seleccione una opción -</option></select></td>
                </tr>
                <tr id="filter_col7" data-column="6">
                    <td>Categoria Articulo<select  class="column_filter form-control requiered" id="col6_filter"></select></td>
                </tr>
                <tr id="filter_col8" data-column="7">
                    <td>Referencia<input type="text" class="column_filter form-control" id="col7_filter"></td>
                </tr>
                <tr id="filter_col9" data-column="8">
                    <td>Rango de fecha: inicio
                        <input type="text" class="column_filter form-control data-picker-only requiered" id="col8_filter">
                    </td>
                </tr>
                <tr id="filter_col10" data-column="9">
                    <td>Fin
                        <input type="text" class="column_filter form-control data-picker-only requiered" id="col9_filter">
                    </td>
                </tr>
                <tr id="filter_col12" data-column="11">
                    <td><p>Ordenado por:Antiguedad - Referencia</p>
                        <label class="switch_check column_filter form-control">
                            <input type="checkbox" id="col11_filter" name="col11_filter" onchange="intercaleCheck(this);" value="1">
                            <span class="slider"></span>
                        </label>
                    </td>
                </tr>
                <tr id="filter_col12" data-column="11">
                    <td><p>Reporte:Consolidado - Detalle</p>
                        <label class="switch_check column_filter form-control">
                            <input type="checkbox" id="col11_filter" name="col11_filter" onchange="intercaleCheck(this);" value="1">
                            <span class="slider"></span>
                        </label>
                    </td>
                </tr>
                
                <tr>
                    <td><button type="text" onclick="intercaleFunction('col1_filter');val_filter();" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
      <thead>
          <tr>      
              <th>
                <input type="checkbox" onchange="intercaleCheck(this);" id="all_check" class="check-control check-pos" value="0" />
                <label for="all_check" class="lbl-check-control" style="font-size: 20px!important; font-weight: 100; margin: 0px;"></label>
              </th>         
              <th> </th>
              <th>Referencia</th>
              <th>Tienda</th>
              <th>Descripción</th>
              <th>Inventario<br>Inicial</th>
              <th>Costo<br>Inicial</th>
              <th>Compras</th>
              <th>Costo<br>Compras</th>
              <th>Devolución<br>Ventas</th>
              <th>Costo<br>Devolución<br>Ventas</th>
              <th>Tralados<br>Entrada</th>
              <th>Costo<br>Traslado<br>Entrada</th>
              <th>Total<br>Unidades<br>Ingresadas</th>
              <th>Total<br>Costo<br>Ingresos</th>
              <th>Ventas</th>
              <th>Costo<br>Ventas</th>
              <th>Devolución<br>Compras</th>
              <th>Costo<br>Devolución<br>Compras</th>
              <th>Tralados<br>Salida</th>
              <th>Costo<br>Traslado<br>Salida</th>
              <th>Total<br>Salidas</th>
              <th>Total<br>Costo<br>Salidas</th>
              <th>Inventario<br>final</th>
              <th>Costo<br>Inventario<br>final</th>
              <th>% Rotación<br>unidades</th>
            </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@section('javascript')   
  @parent
  //<script>
//     loadSelectInput(".slc_tienda", urlBase.make('/tienda/getSelectList'), true);
    loadSelectInput("#col0_filter", "{{ url('/pais/getSelectList') }}")
    loadSelectInput("#col4_filter", "{{ url('/zona/getSelectList') }}")
    loadSelectInput("#col6_filter", "{{ url('/products/categories/getCategory') }}")
    $("#col0_filter").change(function(){
        fillSelect("#col0_filter", "#col1_filter", "{{ url('/departamento/getdepartamentobypais') }}")
    });
    $("#col1_filter").change(function(){
        fillSelect("#col1_filter", "#col2_filter", "{{ url('/ciudad/getciudadbydepartamento') }}")
    });

    $("#col2_filter").change(function(){
        fillSelect("#col2_filter", "#col5_filter", "{{ url('/tienda/gettiendabyciudad') }}")
    });

    $("#col3_filter").change(function(){
        fillSelect("#col3_filter", "#col5_filter", "{{ url('/tienda/selecttiendabysociedad') }}")
    });

    $("#col4_filter").change(function(){
        fillSelect("#col4_filter", "#col5_filter", "{{ url('/tienda/gettiendabyzona') }}")
    });

   column=[      
            { 
                "className":      'no-replace-spaces',
                "defaultContent": `<label><input type="checkbox" onchange="intercaleCheck(this);" class="check-control check-pos check-reporte" value="0" />
                                    <div class="lbl-check-control" style="font-size: 20px!important; font-weight: 100; margin: 0px; display: block;"></div></label>`,
                "orderable":      false,
            },
            { 
                "className":      'details-control no-replace-spaces',
                "orderable":      false,
                "data": "null",
                "defaultContent": ''
            },
            { "data" : "referencia" },
            { "data" : "tienda" },
            { "data" : "descripcion" },
            { "data" : "inventario_inicial" },
            { "data" : "costo_inicial" },
            { "data" : "compras" },
            { "data" : "costo_compra" },
            { "data" : "devoluciones_venta" },
            { "data" : "costo_dev_venta" },
            { "data" : "traslado_entrada" },
            { "data" : "costo_traslado_entrada" },
            { "data" : "total_unidades_ingresadas" },
            { "data" : "costo_total_unidades_ingresadas" },
            { "data" : "ventas" },
            { "data" : "costo_ventas" },
            { "data" : "devoluciones_compra" },
            { "data" : "costo_dev_compra" },
            { "data" : "traslado_salida" },
            { "data" : "costo_traslado_salida" },
            { "data" : "total_salidas" },
            { "data" : "total_costo_salida" },
            { "data" : "inventario_final" },
            { "data" : "costo_final" },
            { "data" : "rotacion_inventario" },
        ];

  	dtMultiSelectRowAndInfo("dataTableAction","{{url('/reporteRotacion/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)
    
    
    $("#btn-generar-pedido").click(function() {
        var reporte = "";
        var cont = 0;
        $('#dataTableAction .check-reporte:checked').each(function(){
            if(cont > 0) reporte += ",";
            reporte += $(this).parent().parent().parent().attr('id');
            ++cont;
        });

        $.ajax({
            url: urlBase.make('pedidos/validarPedido'),
            type: 'post',
            data:{
                ids: reporte
            },
            success: function(data){
                
            }
        });

        ( reporte != "" ) ? location.href = urlBase.make('pedidos/create/' + reporte) : Alerta( 'Alerta', 'Debe seleccionar por lo menos un registro', 'warning' );

    });

@endsection
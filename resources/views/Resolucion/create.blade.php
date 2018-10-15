<!-- Author       : <Andrey Higuita> -->
<!-- Create date  : <Lunes, 16 de abril de 2018> -->
<!-- Description  : <Vista de la hoja de trabajo para realizar el primer paso de la resolución (perfeccionamiento de contratos)> -->

@extends('layouts.master') @section('content') @include('Trasversal.migas_pan.migas')

<form id="form_generar_reporte" class="hide" method="POST" action="{{ url('contratos/resolucionar/pdfperfeccionamiento') }}">
    {{ csrf_field() }}
    <input type="hidden" id="codigos_contratos" name="codigos_contratos" value="{{ $contratos->codigo_contratos }}" />
    <input type="hidden" id="id_tienda_contrato" name="id_tienda_contrato" value="{{ $items[0]->id_tienda_contrato }}" />
    <input type="submit" id="btn-generar-reporte" />
</form>



<!-- Modal para agregar contratos al perfeccionamiento de contratos -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 67%;">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Agregar contrato</h4>
        </div>
        <div class="modal-body">


            <input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
            <label class="btn-filter-table" for="chk-filter-table">Filtros <i class="fa fa-angle-down"></i></label>
            <div class="contentfilter-table">
                <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%;">
                    <tbody>

                        <tr id="filter_col0" data-column="0">
                            <td>Tienda
                                <select disabled class="column_filter form-control slc_tienda" id="col0_filter" data-load="{{ $id_tienda_orden }}">
                                    <option value> -Seleccione una opción - </option>
                                </select>
                            </td>
                        </tr>
                    
                        <tr id="filter_col1" data-column="1">
                            <td>Categoría
                                <select disabled class="column_filter form-control slc_categoria_general" id="col1_filter" data-load="{{ $items[0]->id_categoria }}">
                                    <option value> -Seleccione una opción - </option>
                                </select>
                            </td>
                        </tr>

                        <tr id="filter_col2" data-column="2">
                            <td>Tipo de documento<select class="column_filter form-control slc_tipo_documento" id="col2_filter">
                                <option value> -Seleccione una opción - </option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr id="filter_col3" data-column="3">
                            <td>Número de documento
                            <input type="text" class="column_filter form-control" id="col3_filter" name="fecha_cracion_i" maxlength="25">
                            </td>
                        </tr>

                        <tr id="filter_col4" data-column="4">
                            <td>No. contrato desde<input type="text" class="column_filter form-control justNumbers" id="col4_filter"></td>
                        </tr>

                        <tr id="filter_col5" data-column="5">
                            <td>No. contrato hasta<input type="text" class="column_filter form-control justNumbers" id="col5_filter"></td>
                        </tr>

                        <tr id="filter_col6" data-column="6">
                            <td>Días sin prórroga<input type="text" class="column_filter form-control justNumbers" id="col6_filter"></td>
                        </tr>

                        <tr id="filter_col7" data-column="7">
                            <td>Vencidos sin plazo de pago vigente 
                                <input type="checkbox" onchange="intercaleCheck(this);" id="col7_filter" class="column_filter check-control check-pos" value="0" />
                                <label for="col7_filter" class="lbl-check-control" style="font-size: 27px !important; font-weight: 100; height: 26px; display: block;"></label>
                            </td>
                        </tr>


                        <tr id="filter_col9" data-column="9" style="width: 160px !important;">
                            <td><p class="col-md-12 no-padding">Meses adeudados</p>
                                <div class="no-padding">
                                    <select class="column_filter form-control" id="col9_filter" onchange="resolucion.ordenes_resolucion().meses_adeudados(this.value);">
                                        <option value="1">Igual</option>
                                        <option value="2">Mayor</option>
                                        <option value="3">Mayor o igual</option>
                                        <option value="4">Menor</option>
                                        <option value="5">Menor o igual</option>
                                        <option value="6">Diferente</option>
                                        <option value="7">Entre</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr id="filter_col8" data-column="8" style="width: 100px !important;">
                            <td><p class="col-md-12 no-padding">    </p>
                                <div class="no-padding">
                                    <input type="text" class="column_filter form-control justNumbers" id="col8_filter">
                                </div>
                            </td>
                        </tr>
                        <tr id="filter_col10" data-column="10" class="hide" style="width: 100px !important;">
                            <td><p class="col-md-12 no-padding">    </p>
                                <div class="no-padding">
                                    <input type="text" class="column_filter form-control justNumbers" id="col10_filter">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><button type="button" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body">
                        TOTALES   |   Valor de los contratos: $ <label id="lbl_total_valor_contratos">0</label>   -   Cantidad de contratos: <label id="lbl_total_contratos">0</label>    -   
                        Peso estimado: <label id="lbl_estimado_peso_contratos">0</label>   -   
                        Peso total: <label id="lbl_total_peso_contratos">0</label>   -   
                        Cantidad de items: <label id="lbl_total_cantidad_items">0</label>
                    </div>
                </div>
            </div>


            <table id="table_resolucion" class="display totales_resolucion" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 10px !important;">
                            <input type="checkbox" onchange="intercaleCheck(this);" id="all_check" class="check-control check-pos" value="0" />
                            <label for="all_check" class="lbl-check-control" style="font-size: 20px!important; font-weight: 100; margin: 0px; display: block;"></label>
                        </th>
                        <th></th>
                        <th>Tienda</th>
                        <th>Categoría</th>
                        <th>Tipo</th>
                        <th>No. Documento</th>
                        <th>Nombres y Apellidos</th>
                        <th>No. Contrato</th>
                        <th>Fecha Creación          </th>
                        <th>Término</th>
                        <th>Meses Transcurridos</th>
                        <th>No. Prórrogas</th>
                        <th>Meses Adeudados</th>
                        <th>Meses Vencidos</th>
                        <th>Última Prórroga          </th>
                        <th>Cod. Bolsas</th>
                        <th>Peso Estimado Total</th>
                        <th>Peso Total</th>
                        <th>Valor Contrato</th>
                        <th>Cantidad Ítems</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="resolucion.hoja_trabajo().agregar_contratos();">Aceptar</button>
        </div>
        </div>
    </div>
</div>
<!-- Fin modal para agregar contratos al perfeccionamiento de contratos -->



<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Perfeccionar contrato</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="cont_fran">
                <div class="row">
                    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
                        <button onclick="(function(){ $('#myModal').modal('show'); })();" title="Agregar contratos" data-toggle="modal" value="Quitar" id="btn-agregar-contratos" type="button" class="btn btn-primary"><i class="fa fa-times-circle  "></i> Agregar contratos</button>
                        <button title="Quitar contratos" onclick="resolucion.hoja_trabajo().quitar_contratos();"  id="btn-quitar-contratos" type="button" class="btn btn-danger"><i class="fa fa-ban "></i> Quitar contratos</button>
                    </div>
                </div>
                <br />
                <form id="form_resolucionar" method="POST" class="form-horizontal form-label-left" action="{{ url('contratos/resolucionar/hojatrabajo/procesar') }}" autocomplete="off">
                    {{ csrf_field() }} @include('FormMotor/message')
                    <div class="row">
                        <div class="col-md-10">
                            <div class="col-md-4 col-xs-12 bottom-20">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="numero_orden">Número de orden </label>
                                        <input maxlength="25" type="text" id="numero_orden" name="numero_orden" readonly class="form-control col-xs-12" value="{{ $items[0]->id_orden }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xs-12 bottom-20">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="fecha_resolucion">Fecha de perfeccionamiento </label>
                                        <input maxlength="25" type="text" id="fecha_resolucion" readonly value="{{ date('d-m-Y', strtotime($items[0]->fecha_perfeccionamiento_general)) }}" name="fecha_resolucion" required="required" class="form-control col-xs-12 requiered">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xs-12 bottom-20">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="categoria_general">Categoría general </label>
                                        <input maxlength="25" type="text" id="categoria_general" name="categoria_general" readonly class="form-control col-xs-12" value="@if(isset($items[0]->categoria)){{ $items[0]->categoria }}@endif">
                                    </div>
                                </div>
                            </div>
                        </div>
                            @if(count($procesos) > 1)
                                @if(isset($items[0]->control_peso)) 
                                    @if($items[0]->control_peso != 0)
                                    <div class="col-md-2">
                                        <div class=" col-xs-12 bottom-20">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <label for="last-name">Abrir bolsa</label><br>
                                                    <label class="switch_check">
                                                        <input type="checkbox" id="subdividir" @if($items[0]->abre_bolsa == 1) checked value="1" @else value="0" @endif name="subdividir" onchange="intercaleCheck(this);" >
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            @endif
                    </div>
                    
                    <hr>

                     <div class="form-group" style="display:none" id="cont-selectAll">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <label class="col-md-12 col-sm-12 col-xs-12 no-padding" for="last-name">Seleccionar todos</label>
                        <div class="col-md-5 col-sm-5 col-xs-12 no-padding">
                            <select name="selectAll" id="selectAll" class="form-control">
                            <option value=""> Seleccione opción </option>
                            @foreach($procesos as $pro)
                                <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        </div>
                    </div>

                    

                    <div class="item_refac notop">
                        <table id="dataTableAction" class="table table-hover display">
                            <thead>
                                <th class="subdividir">Llevar a:                           </th>
                                <th>Nro. Contrato</th>
                                <th>Fec. perfeccionamiento</th>
                                <th>Fec. contratación</th>
                                <th>Nro ID</th>
                                @foreach($columnas_items as $columna_item)
                                <th>{{ str_replace(' ', ' ', $columna_item->nombre) }}   </th>
                                @endforeach
                                <th>Atributos</th>
                                <th>Descripción</th>
                                <th>Peso total</th>
                                <th>Peso estimado</th>
                                <th>Peso joyería          </th>
                                <th>Valor compra item</th>
                                <th>Valor total contrato</th>
                                <th>Cantidad bolsa seguiridad</th>
                                <th>Cantidad</th>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    @if(isset($items[0]->control_peso)) @if($items[0]->control_peso == 0)
                                    <td class="subdividir col-md-2 input-table" style="display:none">
                                        <input type="hidden" name="id_item_table[]" id="id_item_table[]" class="form-control requiered" value="{{ $item->id_linea_item_contrato }}">
                                        <input type="hidden" name="codigo_contrato_table[]" id="codigo_contrato_table[]" class="form-control requiered" value="{{ $item->codigo_contrato }}">
                                        <input type="hidden" name="id_inventario[]" value="{{ $item->id_inventario }}">
                                        
                                        <input type="hidden" name="peso_estimado[]" id="peso_estimado[]" class="form-control requiered" value="{{ $item->peso_estimado_noformat }}">
                                        <input type="hidden" name="peso_total[]" id="peso_total[]" class="form-control requiered" value="{{ $item->peso_total_noformat }}">
                                        <input type="hidden" name="precio_ingresado[]" id="precio_ingresado[]" class="form-control requiered" value="{{ $item->precio_ingresado_noformat }}">

                                        <select name="subdivicion[]" value="6" id="subdivicion[]" class="form-control select-sub" required="required">>
                                            <option value=""> Seleccione opción </option>
                                            @foreach($procesos as $pro)
                                            <option @if($item->abre_bolsa == 1 && $item->id_proceso == $pro->id ) selected  @else @if($item->abre_bolsa == 0 && $pro->id == 6) selected @endif @endif value="{{ $pro->id }}">{{ $pro->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @else
                                    <td class="subdividir col-md-2 input-table" style="display:none">
                                        <input type="hidden" name="id_item_table[]" id="id_item_table[]" class="form-control requiered" value="{{ $item->id_linea_item_contrato }}">
                                        <input type="hidden" name="codigo_contrato_table[]" id="codigo_contrato_table[]" class="form-control requiered" value="{{ $item->codigo_contrato }}">
                                        <input type="hidden" name="id_inventario[]" value="{{ $item->id_inventario }}">

                                        <input type="hidden" name="peso_estimado[]" id="peso_estimado[]" class="form-control requiered" value="{{ $item->peso_estimado_noformat }}">
                                        <input type="hidden" name="peso_total[]" id="peso_total[]" class="form-control requiered" value="{{ $item->peso_total_noformat }}">
                                        <input type="hidden" name="precio_ingresado[]" id="precio_ingresado[]" class="form-control requiered" value="{{ $item->precio_ingresado_noformat }}">

                                        <select name="subdivicion[]" value="16" id="subdivicion[]" class="form-control select-sub" required="required">
                                            <option value=""> Seleccione opción </option>
                                            @foreach($procesos as $pro)
                                            <option  @if($item->abre_bolsa == 1 && $item->id_proceso == $pro->id ) selected  @else @if($item->abre_bolsa == 0 && $pro->id == 16) selected @endif  @endif value="{{ $pro->id }}">{{ $pro->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @endif @endif
                                    <td class="codigo_contrato_tabla">{{ $item->codigo_contrato }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->fecha_perfeccionamiento)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item->fecha_contratacion)) }}</td>
                                    <td>{{ $item->id_inventario }}</td>
                                    @for($i = 0; $i < count($columnas_items); $i++)
                                        <input type="hidden" value="{{ $col_print = 0 }}" />
                                        @for($j = 0; $j < count($datos_columnas_items); $j++)
                                            @if($columnas_items[$i]->nombre == $datos_columnas_items[$j]->atributo && $datos_columnas_items[$j]->linea_item == $item->id_linea_item_contrato)
                                            <td>{{$datos_columnas_items[$j]->valor}} <input type="hidden" value="{{ $col_print = 1 }}" /></td>
                                            @endif
                                        @endfor
                                        @if($col_print == 0)
                                            <td></td>
                                        @endif
                                    @endfor
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->observaciones }}</td>
                                    <td class="peso_total_dest">{{ $item->peso_total }}</td>
                                    <td class="peso_estimado_dest">{{ $item->peso_estimado }}</td>
                                    <td class="input-table">
                                        <input type="number" step="0.01" name="peso_joyeria[]" id="peso_joyeria[]" class="form-control peso_joyeria" @if($item->abre_bolsa)  value="{{ $item->peso_taller}}" required @else value="{{ str_replace(',', '.', $item->peso_estimado) }}" disabled @endif />
                                    </td>
                                    <td class="precio_ingresado_dest">{{ $item->precio_ingresado }}</td>
                                    <td>{{ $item->Suma_contrato }}</td>
                                    <td>{{ $item->Bolsas }}</td>
                                    <td>1</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <div class="items_dest">
                        <table class="table_destinatario display">
                            <thead>
                                <th>Proceso</th>
                                <th># bolsa de seguridad</th>
                                <th>Destinatario</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Sucursal</th>
                                <th class="hide"></th>
                            </thead>
                            <tbody>
                                @if(count($procesos) == 1)
                                <tr data-proceso="{{$procesos[0]->id}}">
                                    <td>{{$procesos[0]->name}}</td>
                                    <td><input type="text" name="numero_bolsa[]" id="numero_bolsa[]" class="form-control" required /></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input  class="form-control resertInp buscar_destinatario" placeholder="Nombre proveedor" onkeyup="buscarDestinatario(this);"  type="text" id="buscar_destinatario" name="buscar_destinatario">
                                                <div class="content_buscador" style="display:none;">
                                                    <select name="select_buscar_destinatario" size="4" class="form-control co-md-12 select_buscar_destinatario" onclick="selectValue(this);"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text" id="numero_documento" placeholder="Nit proveedor" name="numero_documento[]" class="form-control nit" required="required">
                                                    <span class="input-group-addon white-color">
                                                        <input id="prueba" maxlength='1' name="digito_verificacion[]" type="text" class="nit-val"
                                                            onBlur="validarNit(this)" required>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <label class="nombres" name="nombres[]">
                                    </td>
                                    <td>
                                        <label class="telefonos" name="telefonos[]">
                                    </td>
                                    <td>
                                        <select name="sucursales[]" class="form-control select-suc" required >
                                            <option value=""> Seleccione opción </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="id_proceso[]" value='{{$procesos[0]->id}}'>
                                        <input type="hidden" class="id_cliente" name="id_cliente[]">
                                        <input type="hidden" class="id_tienda_cliente" name="id_tienda_cliente[]">
                                    </td>
                                </tr>
                                @else
                                @if($item->abre_bolsa == 4)
                                <tr data-proceso="16">
                                    <td>Pre-refacción</td>
                                    <td><input type="text" name="numero_bolsa[]" id="numero_bolsa[]" class="form-control" required /></td>
                                    <td>
                                        <div class="input-group">

                                            <input  class="form-control resertInp buscar_destinatario" onkeyup="buscarDestinatario(this);" type="text" id="buscar_destinatario" name="buscar_destinatario">
                                            <div class="content_buscador" style="display:none;">
                                                <select size="4" class="form-control co-md-12 select_buscar_destinatario" onclick="selectValue(this);"></select>
                                            </div>

                                            <input type="text" id="numero_documento" name="numero_documento[]" class="form-control nit" required="required">
                                            <span class="input-group-addon white-color">
                                                <input id="prueba" maxlength='1' name="digito_verificacion[]" type="text" class="nit-val"
                                                    onBlur="validarNit(this)" required>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <label class="nombres" name="nombres[]">
                                    </td>
                                    <td>
                                        <label class="telefonos" name="telefonos[]">
                                    </td>
                                    <td>
                                        <select name="sucursales[]" class="form-control select-suc" required>
                                            <option value=""> Seleccione opción </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="id_proceso[]" value='16'>
                                        <input type="hidden" class="id_cliente" name="id_cliente[]">
                                        <input type="hidden" class="id_tienda_cliente" name="id_tienda_cliente[]">
                                    </td>
                                </tr>
                                @else
                                    @foreach($destinatarios as $destinatario)
                                    <tr data-proceso="{{$destinatario->id_proceso}}">
                                        <td>{{$destinatario->proceso}}</td>
                                        <td><input type="text" name="numero_bolsa[]" id="numero_bolsa[]" value="{{$destinatario->numero_bolsa}}" class="form-control" required /></td>
                                        <td>
                                            <!-- <div class="input-group">

                                                

                                                
                                                <span class="input-group-addon white-color">
                                                    
                                                </span>
                                            </div> -->

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input  class="form-control resertInp buscar_destinatario" placeholder="Nombre proveedor" onkeyup="buscarDestinatario(this);"  type="text" id="buscar_destinatario" name="buscar_destinatario">
                                                    <div class="content_buscador" style="display:none;">
                                                        <select name="select_buscar_destinatario" size="4" class="form-control co-md-12 select_buscar_destinatario" onclick="selectValue(this);"></select>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" id="numero_documento" placeholder="Nit proveedor" name="numero_documento[]" value="{{$destinatario->destinatario}}" class="form-control nit" required="required">
                                                        <span class="input-group-addon white-color">
                                                            <input id="prueba" maxlength='1' name="digito_verificacion[]" value="{{$destinatario->codigo_verificacion}}" type="text" class="nit-val"
                                                                onBlur="validarNit(this)" required>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="nombres" name="nombres[]">
                                        </td>
                                        <td>
                                            <label class="telefonos" name="telefonos[]">
                                        </td>
                                        <td>
                                            <select name="sucursales[]" class="form-control select-suc" required>
                                                <option value> Seleccione opción </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="hidden" name="id_proceso[]" value='{{$destinatario->id_proceso}}'>
                                            <input type="hidden" class="id_cliente" name="id_cliente[]">
                                            <input type="hidden" class="id_tienda_cliente" name="id_tienda_cliente[]">
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                            @foreach($items as $item)
                            <input type="hidden" name="id_item[]" id="id_item[]" class="form-control requiered" value="{{ $item->id_linea_item_contrato }}">
                            <input type="hidden" name="codigo_contrato[]" id="codigo_contrato[]" class="form-control requiered" value="{{ $item->codigo_contrato }}"> @endforeach
                            <input type="hidden" name="procesar" id="procesar" value="1">
                            <input type="hidden" name="id_categoria" value="{{ $items[0]->id_categoria }}">
                            <input type="hidden" id="id_tienda_contrato" name="id_tienda_contrato" value="{{ $items[0]->id_tienda_contrato }}">
                            <input type="hidden" id="id_orden_guardar" name="id_orden_guardar" value="{{ $id }}">

                            <!-- <input id="btn-guardar" name="btn-guardar" onclick="resolucion.hoja_trabajo().guardar();" class="btn btn-success" type="button" value="Guardar"> -->

                            <button type="button" title="Reporte Resolución" id="btn-reporte" class="btn btn-primary">Generar Reporte</button>
                            <input id="btn-guardar" name="btn-guardar" onclick="resolucion.hoja_trabajo().actualizar();" class="btn btn-primary" type="button"
                                value="Guardar">

                            <input id="btn-procesar" name="btn-procesar" onclick="resolucion.hoja_trabajo().procesar_perfeccionamiento();" class="btn btn-success" type="submit"
                                value="Procesar">
                            <a href="{{ url('/contrato/resolucion') }}" class="btn btn-danger" type="button">Cancelar</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .content_buscador{
        position: absolute;
        width: calc(100% - 20px);
        z-index: 100;
    }

    .table_destinatario td{
        vertical-align: top;
    }
</style>

<div id="res"></div>
@endsection @push('scripts')
<script src="{{ asset('/js/contrato/resolucionar.js') }}"></script>
<script src="{{ asset('/js/OrdenResolucion/totales.js') }}"></script>
@endpush
@section('javascript')
@parent
$(document).ready(function(){
    $(".nit-val").blur();
    @if (Session:: has('print_reporte'))
        $('#btn-reporte').click();
    @endif
    resolucion.ordenes_resolucion().document_ready();
    // Función para redireccionar luego de procesar
    $('#form_resolucionar').submit(function(e){
        // Validate the form using generic validaing
        if( validator.checkAll( $(this) ) ){
            setTimeout(function () { location.href = urlBase.make('contrato/resolucion'); }, 5000);
        }else{
            return false;
        }
    });
});

$('#dataTableAction').DataTable({
    language: { url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"},
    scrollX: true,
    scrollCollapse: true,
    "pageLength": 1000,
    "fnDrawCallback": function( oSettings ) {
        $('#dataTableAction tbody td:not(.input-table)').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
        $(window).resize(); },
        "fixedColumns": true,
    }
);
loadSelectInput("#tipo_documento", "{{ url('/clientes/tipodocumento/getSelectList2') }}")
$('#subdividir').val(@if(isset($items[0]->fecha_resolucion)){{$items[0]->fecha_resolucion }}@endif);
if($("#subdividir").val() == "1") {
    $("#subdividir").prop('checked', true); $(".subdividir").css('display','table-cell');
    $("#cont-selectAll").css('display','inline-block');
    $("#cont-selectAll").css('display','inline-block');
} else {
    $("#subdividir").prop('checked', false); } $(document).ready(function(){ resolucion.hoja_trabajo().document_ready();
    $("#cont-selectAll").css('display', 'none');
});

var i = 0;
   column=[             
            { 
                "className":      'no-replace-spaces',
                "defaultContent": `<label><input type="checkbox" onchange="intercaleCheck(this);" class="check-control check-pos check-resolucionar" value="0" />
                                    <div class="lbl-check-control" style="font-size: 20px!important; font-weight: 100; margin: 0px; display: block;"></div></label>`,
                "orderable":      false,
            },
            { 
                "className":      'details-control no-replace-spaces',
                "orderable":      false,
                "data": "null",
                "defaultContent": ''
            },
            { "data": "tienda" },
            { "data": "categoria_general" },
            { "data": "tipo_documento"},
            { "data": "documento_cliente"},
            { "data": "nombres_cliente"},
            { "data": "codigo_contrato"},
            { "data": "fecha_creacion" },
            { "data": "termino" },
            { "data": "meses_transcurridos" },
            { "data": "numero_prorrogas" },
            { "data": "meses_adeudados" },
            { "data": "meses_vencidos" },
            { "data": "fecha_prorroga" },
            { "data": "cod_bolsas_seguridad" },
            { "data": "peso_estimado_total", "className": "var_peso_estimado_contrato" },
            { "data": "peso_total_total", "className": "var_peso_contrato" },
            { "data": "valor_contrato", "className": "var_valor_contrato" },
            { "data": "cantidad_items", "className": "var_cantidad_items" }
        ];
        dtMultiSelectRowAndInfo('table_resolucion', "{{url('/contratos/resolucionar/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column)

@endsection

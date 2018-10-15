@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Refaccionar orden</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="cont_fran">
                <br />
                <form id="from_proceso" method="POST" class="form-horizontal form-label-left form-proces-resolucion" autocomplete="off" action="{{ url('/contrato/refaccion/create') }}">
                {{ csrf_field() }}  
                @include('FormMotor/message')

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document" style="width: 67%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Recuperar contrato</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover">
                                        <thead>
                                        <th>Número de inventario</th>
                                        <th>Número de orden</th>
                                        <th>Número de cotrato</th>
                                        <th>Joyería</th>
                                        <th>Estado</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="confirmar">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end modal -->


                    <div class="modal-diag modal-diag-hide" id="modal_costos">
                        <div class="modal-header">
                            <h4 class="modal-title font-weight-bold col-md-11">Costos adicionales</h4>
                            <button type="button" class="close" onclick="modal_costos.hide(); modal_costos.cancel();" aria-label="Close">
                                <span aria-hidden="t" rue="">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="bottom-20">
                                <label for="mano_obra">MO - Mano de obra </label>
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" min="0" id="mano_obra" name="mano_obra" class="form-control moneda centrar-derecha" aria-label="Amount (to the nearest dollar)" />
                                </div>
                            </div>
                            <div class="bottom-20">
                                <label for="transporte">T - Transporte </label>
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" min="0" id="transporte" name="transporte" class="form-control moneda centrar-derecha" aria-label="Amount (to the nearest dollar)" />
                                </div>
                            </div>
                            <div class="bottom-20">
                                <label for="costos_indirectos">CIF - Costos indirectos </label>
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" min="0" id="costos_indirectos" name="costos_indirectos" class="form-control moneda centrar-derecha" aria-label="Amount (to the nearest dollar)" />
                                </div>
                            </div>
                            <div class="bottom-20">
                                <label for="otros_costos">Otros costos </label>
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" min="0" id="otros_costos" name="otros_costos" class="form-control moneda centrar-derecha" aria-label="Amount (to the nearest dollar)" />
                                </div>
                            </div>
                            <div class="bottom-20"></div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button onclick="modal_costos.hide(); modal_costos.cancel();" type="button" class="btn btn-outline-primary btn-md waves-effect waves-light">Cancelar</button>
                            <button onclick="modal_costos.accept();" type="button" class="btn btn-primary btn-md waves-effect waves-light">Aceptar  <i class="fa fa-play ml-2"></i></button>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-10">
                            <div class="col-md-4 col-xs-12 bottom-20">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="numero_orden">Número de orden </label>
                                        <input maxlength="25" type="text" id="numero_orden" name="numero_orden" readonly class="form-control col-xs-12" value="{{ $id }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xs-12 bottom-20">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="fecha_resolucion">Fecha de la orden</label>
                                        <input maxlength="25" type="text" id="fecha_resolucion" name="fecha_resolucion" required="required" class="form-control col-md-7 col-xs-12" value="@if(isset($items[0]->fecha_resolucion)) {{ date('d-m-Y', strtotime($items[0]->fecha_resolucion)) }} @else{{ date('d-m-Y H:i:s', strtotime(Carbon\Carbon::now())) }}@endif" readonly>
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
                            <div class="col-md-2">
                                <div class=" col-xs-12 bottom-20">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label for="last-name">Subdividir</label><br>
                                            <label class="switch_check">
                                                <input type="checkbox" @if($items[0]->abre_bolsa == 1) checked value="1" @else value="0" @endif id="subdividir" name="subdividir"  onchange="intercaleCheck(this);" >
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                            <div class="col-md-4 col-xs-12 bottom-20">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="numero_orden">Número de orden de perfeccionamiento </label>
                                        <input maxlength="25" type="text" id="numero_orden" name="numero_orden" readonly class="form-control col-xs-12" value="{{ $id }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xs-12 bottom-20">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label for="fecha_resolucion">Fecha de la orden de perfeccionamiento</label>
                                        <input maxlength="25" type="text" id="fecha_resolucion" name="fecha_resolucion" required="required" class="form-control col-md-7 col-xs-12" value="@if(isset($items[0]->fecha_resolucion)) {{ date('d-m-Y', strtotime($items[0]->fecha_resolucion)) }} @else{{ date('d-m-Y H:i:s', strtotime(Carbon\Carbon::now())) }}@endif" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    

                    <hr>

                    <div class="form-group" style="display:none" id="cont-selectAll">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="col-md-12 col-sm-12 col-xs-12" for="last-name">Seleccionar todos</label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <select name="selectAll" id="selectAll" class="form-control">
                                    <option value=""> Seleccione opción </option>
                                    @foreach($procesos as $pro)
                                        <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
            
                    <div style="width: auto; float: right;">
                        <div style="display: inline-block;" class="hide">
                            <div class="input-group"  style="width: 300px;">
                                <span class="input-group-addon">Costos</span>
                                <input readonly type="text" min="0" id="total_costos" name="total_costos" class="form-control moneda centrar-derecha" aria-label="Amount (to the nearest dollar)" />
                                <span id="editar_costos" style="background-color: #337ab7 !important; color: #fff; border: 1px solid #337ab7;" onclick="modal_costos.show();" class="input-group-addon btn btn-primary">
                                <i class="fa fa-edit"></i>
                                </span>
                            </div>
                        </div>
                        <div style="display: inline-block; vertical-align: top;">
                            <input id="btn-quitar" name="btn-quitar" type="button" class="btn btn-danger" data-toggle="modal" value="Quitar">
                        </div>
                    </div>
            
                    <div class="item_refac notop hidefilters">
                        <table id="tabla_refaccion" class="table table-hover dataTableAction display tabla-resolucion">
                            <thead>
                            <th class="subdividir">Llevar a:                           </th>
                            <th>Nro. Contrato</th>
                            <th>Joyería</th>
                            <th>Fecha del contrato</th>
                            <th>Número ID</th>
                            @foreach($columnas_items as $columna_item)
                            <th class="bold" align="center">{{ $columna_item->nombre }}</th>
                            @endforeach
                            <th>Atributos</th>
                            <th>Descripción</th>
                            <th>Peso total</th>
                            <th>Peso estimado</th>
                            <th>Peso taller</th>
                            <th>Valor ID</th>
                            <th>Valor total contrato</th>
                            <th>Cantidad ID</th>
                            <th>Bolsas de seguridad</th>
                            <!-- <th>Código bolsas de seguridad</th> -->
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr id="{{ $item->id_tienda_inventario }}-{{ $item->id_inventario }}-{{ $item->id_contrato }}-{{ $item->id_orden }}">
                                <td class="subdividir col-md-2 input-table" style="display:none">
                                    <input type="hidden" name="id_item[]" value="{{ $item->id_item }}">
                                    <input type="hidden" name="id_inventario[]" value="{{ $item->id_inventario }}">
                                    <input type="hidden" name="id_tienda_inventario[]" value="{{ $item->id_tienda_inventario }}">
                                    <input type="hidden"  name="contrato[]" value="{{ $item->id_contrato }}" />
                                    <input type="hidden"  name="tienda_contrato[]" value="{{ $item->tienda_contrato }}" />
                                    <input type="hidden"  name="fecha_creacion[]" value="{{ $item->fecha_creacion }}" />
                                    <input type="hidden"  name="atributo[]" value="{{ $item->nombre }}" />
                                    <input type="hidden"  name="descripcion[]" value="{{ $item->observaciones }}" />
                                    <input type="hidden"  name="peso_total[]" value="{{ $item->peso_total_noformat }}" />
                                    <input type="hidden"  name="peso_estimado[]" value="{{ $item->peso_estimado_noformat }}" />
                                    <input type="hidden" name="precio_ingresado[]" id="precio_ingresado[]" value="{{ $item->precio_ingresado_noformat }}">
                                    <input type="hidden"  name="suma_contrato[]" value="{{ $item->Suma_contrato }}" />
                                    <input type="hidden"  name="bolsas[]" value="{{ $item->Bolsas }}" />
                                    <select name="subdivision[]" value="6" id="subdivision_{{ $item->id_orden }}" class="form-control select-sub" @if($item->abre_bolsa == 1) required @endif>
                                        <option value=""> Seleccione opción </option>
                                        @foreach($procesos as $pro)
                                        <option  @if($item->abre_bolsa == 1 && $item->id_proceso == $pro->id ) selected  @else @if($item->abre_bolsa == 0 && $pro->id == 6) selected @endif @endif value="{{ $pro->id }}">{{ $pro->name }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>{{ $item->id_contrato }}</td>
                                <td>{{ $item->nombre_tienda_contrato }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->fecha_creacion)) }}</td>
                                <td>{{ $item->id_inventario }}</td>
                                @for($i = 0; $i < count($columnas_items); $i++)
                                    <input type="hidden" value="{{ $col_print = 0 }}" />
                                    @for($j = 0; $j < count($datos_columnas_items); $j++)
                                        @if($columnas_items[$i]->nombre == $datos_columnas_items[$j]->atributo && $datos_columnas_items[$j]->linea_item == $item->linea_item)
                                        <td>{{$datos_columnas_items[$j]->valor}} <input type="hidden" value="{{ $col_print = 1 }}" /></td>
                                        @endif
                                    @endfor
                                    @if($col_print == 0)
                                        <td></td>
                                    @endif
                                @endfor
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->observaciones }}</td>
                                <td>{{ $item->peso_total }}</td>
                                <td>{{ $item->peso_estimado }}</td>
                                <td class="input-table">
                                    <input type="number" step="0.01" name="peso_taller[]" id="peso_taller[]" class="form-control requiered peso_taller_input validate-required" value="{{ $item->peso_taller }}" step=".01" required>
                                </td>
                                <td>{{ $item->precio_ingresado }}</td>
                                <td>{{ $item->Suma_contrato }}</td>
                                <td>1</td>
                                <td>{{ $item->Bolsas }}</td>
                                </tr>
                            @endforeach  
                            </tbody>
                        </table>
                    </div>

                    <div class="items_dest"> 
                        <table class= "table_destinatario display">
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
                                
                                @if($item->abre_bolsa == 0)
                                <tr data-proceso="6">
                                    <td>Vitrina</td>
                                    <td><input type="text" name="numero_bolsa[]" id="numero_bolsa[]" class="form-control validate-required"/></td>
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
                                                    <input type="text" id="numero_documento" placeholder="Nit proveedor" name="numero_documento[]" class="form-control nit validate-required" required="required">
                                                    <span class="input-group-addon white-color">
                                                        <input id="prueba" maxlength='1' name="digito_verificacion[]" type="text" class="nit-val validate-required"
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
                                        <select name="sucursales[]" class="form-control select-suc validate-required-select">
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
                                    @foreach($destinatarios as $destinatario)
                                    <tr data-proceso="{{$destinatario->id_proceso}}">
                                        <td>{{$destinatario->proceso}}</td>
                                        <td><input type="text" name="numero_bolsa[]" id="numero_bolsa[]" value="{{$destinatario->numero_bolsa}}" class="form-control validate-required" required /></td>
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
                                                        <input type="text" id="numero_documento" placeholder="Nit proveedor" name="numero_documento[]" value="{{$destinatario->destinatario}}" class="form-control nit validate-required" required="required">
                                                        <span class="input-group-addon white-color">
                                                            <input id="prueba" maxlength='1' name="digito_verificacion[]" value="{{$destinatario->codigo_verificacion}}" type="text" class="nit-val validate-required"
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
                                            <select name="sucursales[]" class="form-control select-suc validate-required-select">
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
                            </tbody>
                        </table>
                    </div>
    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div align="center" class="col-md-12 col-sm-12 col-xs-12">
                            <input type="hidden" name="procesar" id="procesar" value="1">
                            <input type="hidden" name="id_tienda_orden" value="{{ $items[0]->id_tienda_orden }}">
                            <input type="hidden" name="id_hoja_trabajo" value="{{ $items[0]->id_hoja_trabajo }}">
                            <input type="hidden" name="id_tienda_hoja_trabajo" value="{{ $items[0]->id_tienda_hoja_trabajo }}">
                            <input type="hidden" id="pros" name="pros" value="refaccion">
                            <input onclick="saveOrden('contrato/refaccion/guardar');" id="btn-guardar" name="btn-guardar" class="btn btn-primary" type="button" value="Guardar">
                            <input onclick="modal_costos.reset_inputs();" id="btn-procesar-refaccion" name="btn-procesar-refaccion" class="btn btn-success " type="button" value="Procesar">
                            <input onclick="resetInputs();" class="btn btn-primary" type="reset" value="Reestablecer">
                            <input class="btn btn-success hide btn-procesar-orden" type="submit" value="Procesar">
                            <a href="{{ url('/contrato/refaccion') }}" class="btn btn-danger" type="button">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="res"></div>

@endsection

@push('scripts')
  <script src="{{ asset('/js/OrdenResolucion/vitrina.js') }}"></script>
@endpush

@section('javascript')   
  @parent

    

    $('#tabla_refaccion').DataTable(
        {
            language: { url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"},
            scrollX: true,
            scrollCollapse: true,
            "pageLength": 1000,
            "fnDrawCallback": function( oSettings ) {
                $('#tabla_refaccion tbody td:not(.input-table)').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
                $(window).resize(); 
            },
            "fixedColumns": true,
        }
    );

    $('#tabla_refaccion tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            var table = $('#tabla_refaccion').DataTable();
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    loadSelectInput("#tipo_documento", "{{ url('/clientes/tipodocumento/getSelectList2') }}")
    ESTADOS.setProcesado({{ env('ORDEN_PROCESADA') }});

    if($("#subdividir").val() == "1") {
    $("#subdividir").prop('checked', true); $(".subdividir").css('display','table-cell');
    $("#cont-selectAll").css('display','inline-block');
    $("#cont-selectAll").css('display','inline-block');
} else {
    $("#subdividir").prop('checked', false); 
} 
    
$(document).ready(function(){ 
    $("#cont-selectAll").css('display', 'none');
    $(".nit-val").blur();
});

@if($action == 2)
        $('input, select').attr('disabled', 'disabled');
    @endif
@endsection

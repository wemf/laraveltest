<!-- Author       : <Andrey Higuita> -->
<!-- Create date  : <Jueves, 15 de febrero de 2018> -->
<!-- Description  : <Vista de la hoja de trabajo para realizar el primer paso de la resolución (perfeccionamiento de contratos)> -->

@extends('layouts.master') @section('content') @include('Trasversal.migas_pan.migas')



<form id="form_generar_reporte" class="hide" method="POST" action="{{ url('contratos/resolucionar/pdfreporte') }}">
    {{ csrf_field() }}
    <input type="hidden" id="codigos_contratos" name="codigos_contratos" value="{{ $id }}" />
    <input type="hidden" id="id_tienda_contrato" name="id_tienda_contrato" value="{{ $items[0]->id_tienda_contrato }}" />
    <input type="submit" id="btn-generar-reporte" />
</form>

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
                        <button title="Agregar contratos"  id="btn-agregar-contratos" type="button" class="btn btn-primary"><i class="fa fa-times-circle  "></i> Agregar contratos</button>
                        <button title="Quitar contratos"  id="btn-quitar-contratos" type="button" class="btn btn-danger"><i class="fa fa-ban "></i> Quitar contratos</button>
                    </div>
                </div>
                <br />
                <form id="form_resolucionar" method="POST" class="form-horizontal form-label-left" action="{{ url('contratos/resolucionar/hojatrabajo/procesar') }}">
                    {{ csrf_field() }} @include('FormMotor/message')
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Número de contrato</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input maxlength="25" type="text" id="numero_contratos" name="numero_contratos" readonly class="form-control col-md-7 col-xs-12"
                                    value="{{ $id }}">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fecha resolución
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input maxlength="25" type="text" id="fecha_resolucion" readonly value="{{ Carbon\Carbon::now() }}" name="fecha_resolucion"
                                    required="required" class="form-control col-md-7 col-xs-12 requiered">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Categoría general</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input maxlength="25" type="text" id="categoria_general" name="categoria_general" readonly class="form-control col-md-7 col-xs-12"
                                    value="@if(isset($items[0]->categoria)){{ $items[0]->categoria }}@endif">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"># bolsa de seguridad de envío</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input maxlength="25" type="text" id="numero_bolsa" name="numero_bolsa" class="form-control col-md-7 col-xs-12 validate-required">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 hide">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Destino final
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input maxlength="25" type="text" id="destino_final" name="destino_final" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                    </div>
                    @if(count($procesos) > 1)
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Abrir bolsa</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="switch_check">
                                    <input type="checkbox" id="subdividir" name="subdividir" onchange="intercaleCheck(this);" value="0">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif


                    <div class="item_refac notop">
                        <table id="dataTableAction" class="table table-hover display">
                            <thead>
                                <th class="subdividir">Llevar a:                           </th>
                                <th>Nro. Contrato</th>
                                <th>Fecha ingreso         </th>
                                <th>Número de Id</th>
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
                                        <!-- <input type="hidden" name="id_item[]" value="{{ $item->id_orden }}">
                        <input type="hidden" name="id_inventario[]" value="{{ $item->id_inventario }}"> -->
                                        <!-- <input type="hidden" name="id_tienda_inventario[]" value="{{ $item->id_tienda_inventario }}"> -->
                                        <input type="hidden" name="id_item_table[]" id="id_item_table[]" class="form-control requiered" value="{{ $item->id_linea_item_contrato }}">
                                        <input type="hidden" name="codigo_contrato_table[]" id="codigo_contrato_table[]" class="form-control requiered" value="{{ $item->codigo_contrato }}">
                                        <input type="hidden" name="peso_estimado[]" id="peso_estimado[]" class="form-control requiered" value="{{ $item->peso_estimado }}">
                                        <input type="hidden" name="peso_total[]" id="peso_total[]" class="form-control requiered" value="{{ $item->peso_total }}">
                                        <input type="hidden" name="precio_ingresado[]" id="precio_ingresado[]" class="form-control requiered" value="{{ $item->precio_ingresado }}">
                                        <select name="subdivicion[]" value="6" id="subdivicion[]" class="form-control select-sub" required="required">>
                                            <option value=""> Seleccione opción </option>
                                            @foreach($procesos as $pro)
                                            <option @if($pro->id == 6) selected @endif value="{{ $pro->id }}">{{ $pro->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @else
                                    <td class="subdividir col-md-2 input-table" style="display:none">
                                        <input type="hidden" name="id_item_table[]" id="id_item_table[]" class="form-control requiered" value="{{ $item->id_linea_item_contrato }}">
                                        <input type="hidden" name="codigo_contrato_table[]" id="codigo_contrato_table[]" class="form-control requiered" value="{{ $item->codigo_contrato }}">
                                        <input type="hidden" name="peso_estimado[]" id="peso_estimado[]" class="form-control requiered" value="{{ $item->peso_estimado }}">
                                        <input type="hidden" name="peso_total[]" id="peso_total[]" class="form-control requiered" value="{{ $item->peso_total }}">
                                        <input type="hidden" name="precio_ingresado[]" id="precio_ingresado[]" class="form-control requiered" value="{{ $item->precio_ingresado }}">
                                        <select name="subdivicion[]" value="16" id="subdivicion[]" class="form-control select-sub" required="required">
                                            <option value=""> Seleccione opción </option>
                                            @foreach($procesos as $pro)
                                            <option @if($pro->id == 16) selected @endif value="{{ $pro->id }}">{{ $pro->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @endif @endif
                                    <td class="codigo_contrato_item">{{ $item->codigo_contrato }}</td>
                                    <td>{{ $item->fecha_creacion }}</td>
                                    <td>{{ $item->id_inventario }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->observaciones }}</td>
                                    <td>{{ $item->peso_total }}</td>
                                    <td>{{ $item->peso_estimado }}</td>
                                    <td class="input-table">
                                        <input type="number" step="0.01" name="peso_joyeria[]" id="peso_joyeria[]" class="form-control peso_joyeria" disabled="disabled"
                                            value="{{ $item->peso_joyeria }}">
                                    </td>
                                    <td>{{ $item->precio_ingresado }}</td>
                                    <td>{{ $item->Suma_contrato }}</td>
                                    <td>{{ $item->Bolsas }}</td>
                                    <td>1</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="items_dest">
                        <table class="table_destinatario display">
                            <thead>
                                <th>Proceso</th>
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
                                    <td>
                                        <div class="input-group">
                                            <input type="text" id="numero_documento" name="numero_documento[]" class="form-control nit validate-required">
                                            <span class="input-group-addon white-color">
                                                <input id="prueba" maxlength='1' name="digito_verificacion" type="text" class="nit-val validate-required"
                                                    onBlur="validarNit(this)">
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
                                        <select name="sucursales[]" class="form-control select-suc validate-required">
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
                                <tr data-proceso="16">
                                    <td>Pre-refacción</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" id="numero_documento" name="numero_documento[]" class="form-control nit validate-required" required="required">
                                            <span class="input-group-addon white-color">
                                                <input id="prueba" maxlength='1' name="digito_verificacion[]" type="text" class="nit-val validate-required"
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
                                        <select name="sucursales[]" class="form-control select-suc validate-required">
                                            <option value=""> Seleccione opción </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="id_proceso[]" value='16'>
                                        <input type="hidden" class="id_cliente" name="id_cliente[]">
                                        <input type="hidden" class="id_tienda_cliente" name="id_tienda_cliente[]">
                                    </td>
                                </tr>
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
                            <input type="hidden" name="id_tienda_contrato" value="{{ $items[0]->id_tienda_contrato }}">
                            <input type="hidden" name="id_hoja_trabajo" value="{{ $items[0]->id_hoja_trabajo }}">
                            <input type="hidden" name="id_tienda_hoja_trabajo" value="{{ $items[0]->id_tienda_hoja_trabajo }}">
                            <!-- <input id="btn-guardar" name="btn-guardar" onclick="resolucion.hoja_trabajo().guardar();" class="btn btn-success" type="button" value="Guardar"> -->
                            <button title="Reporte Resolución" id="btn-reporte" class="btn btn-primary"><i class="fa fa-eye"></i> Generar Reporte</button>
                            <input id="btn-guardar" name="btn-guardar" onclick="resolucion.hoja_trabajo().guardar();" class="btn btn-primary" type="button"
                                value="Guardar">

                            <input id="btn-procesar" name="btn-procesar" onclick="resolucion.hoja_trabajo().procesar();" class="btn btn-success" type="button"
                                value="Procesar">
                            <a href="{{ url('/contratos/resolucionar') }}" class="btn btn-danger" type="button">Cancelar</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div id="res"></div>
@endsection @push('scripts')
<script src="{{ asset('/js/contrato/resolucionar.js') }}"></script>
<script src="{{ asset('/js/OrdenResolucion/totales.js') }}"></script>
@endpush
@section('javascript')
@parent
$(document).ready(function(){
  $('#btn-guardar').click();
  totales_resolucion();
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
} else {
    $("#subdividir").prop('checked', false); } $(document).ready(function(){ resolucion.hoja_trabajo().document_ready();
});



@endsection

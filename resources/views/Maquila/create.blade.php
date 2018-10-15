@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Maquila</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="cont_fran">
                <br />
                <form id="form_maquila" method="POST" class="form-horizontal form-label-left" autocomplete="off" action="{{ url('/contrato/maquila/create') }}">
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
                                        <th>Tienda</th>
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
                                        <input maxlength="25" type="text" id="fecha_resolucion" name="fecha_resolucion" required="required" class="form-control col-md-7 col-xs-12" value="@if(isset($items[0]->fecha_resolucion)){{ date('d-m-Y', strtotime($items[0]->fecha_resolucion)) }} @else{{ date('d-m-Y H:i:s', strtotime(Carbon\Carbon::now())) }}@endif" readonly>
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
                            <div class="col-md-2 hide">
                                <div class=" col-xs-12 bottom-20">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label for="last-name">Subdividir</label><br>
                                            <label class="switch_check">
                                                <input type="checkbox" @if($items[0]->abre_bolsa == 1) checked value="1" @else value="0" @endif checked id="subdividir" name="subdividir"  onchange="intercaleCheck(this);" >
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
                        <table id="tabla-resolucion" class="table table-hover dataTableAction display tabla-resolucion">
                            <thead>
                            <th>Nro. Contrato</th>
                            <th>Joyería</th>
                            <th>Fecha del contrato</th>
                            <th>Número ID</th>
                            @foreach($columnas_items as $column)
                            <th>{{str_replace(' ', ' ',$column->nombre)}}</th>
                            @endforeach
                            <th>Atributos</th>
                            <th>Descripción</th>
                            <th>Peso total</th>
                            <th>Peso estimado</th>
                            <th>Peso taller</th>
                            <th>Peso libre</th>
                            <th>Valor ID</th>
                            <th>Valor total contrato</th>
                            <th class="hide">Cantidad ID</th>
                            <th>Código bolsas de seguridad</th>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                
                                <tr id="{{ $item->id_tienda_inventario }}-{{ $item->id_inventario }}-{{ $item->id_contrato }}">
                                    <td style="display:none">
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
                                        <input type="hidden"  name="peso_taller[]" value="{{ $item->peso_taller }}" />
                                        <input type="hidden" name="precio_ingresado[]" id="precio_ingresado[]" value="{{ $item->precio_ingresado_noformat }}">
                                        <input type="hidden"  name="suma_contrato[]" value="{{ $item->Suma_contrato }}" />
                                        <input type="hidden"  name="bolsas[]" value="{{ $item->Bolsas }}" />
                                    </td>

                                    <td>{{ $item->id_contrato }}</td>
                                    <td>{{ $item->tienda_contrato }}</td>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($item->fecha_creacion)) }}</td>
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
                                    <td>{{ $item->peso_total }}</td>
                                    <td>{{ $item->peso_estimado }}</td>
                                    <td>{{ $item->peso_taller}}</td>
                                    <td class="input-table">
                                        <input type="number" step="0.01" maxlength="5" name="peso_libre[]" id="peso_libre[]" maxlength="5" class="form-control  peso_libre_input " value="{{str_replace(',', '.',$item->peso_libre)}}" required>
                                    </td>
                                    <td>{{ $item->precio_ingresado }}</td>
                                    <td>{{ $item->Suma_contrato }}</td>
                                    <td class="hide">1</td>
                                    <td>{{ $item->Bolsas }}</td>
                                </tr>
                                @endforeach  
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
                            <input type="hidden" id="pros" name="pros" value="maquila">
                            <input type="hidden" name="process_nal_imp" id="process_nal_imp" value="" /> <!-- Variable para definir si se envía a nacional o importada -->
                            <input onclick="saveOrden('contrato/maquila/guardar', '0');" id="btn-guardar" name="btn-guardar" class="btn btn-primary" type="button" value="Guardar">
                            <input onclick="saveOrden('contrato/maquila/guardar', '{{ $maquila_nacional }}');" id="btn-procesar-nacional" name="btn-procesar-nacional" class="btn btn-success" type="button" value="Convertir a Maquila Nacional">
                            <input onclick="saveOrden('contrato/maquila/guardar', '{{ $maquila_importada }}');" id="btn-procesar-importada" name="btn-procesar-importada" class="btn btn-success" type="button" value="Convertir a Maquila Importada">
                            <input class="btn btn-success hide btn-procesar-orden" type="submit" value="Procesar">
                            <a href="{{ url('/contrato/maquila') }}" class="btn btn-danger" type="button">Atrás</a>
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
  <script src="{{ asset('/js/OrdenResolucion/maquilacreate.js') }}"></script>
@endpush

@section('javascript')   
  @parent

  $('.dataTableAction').DataTable({
        language: 
        {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",					
        },
        scrollX: true,
        scrollCollapse: true,
        "pageLength": 1000,
        scrollY: 400,
        "fnDrawCallback": function( oSettings ) {
                $('.dataTableAction tbody td:not(.input-table)').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
                $(window).resize(); 
        },
        "fixedColumns": true,
    });
    $('.dataTableAction tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
            } else {
                    var table = $('.dataTableAction').DataTable();
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
            }
    });

    @if($action == 2)
        $('input,select').attr('disabled', 'disabled');
        $('input[type="submit"],input[type="button"],input[type="reset"]').attr('disabled', 'disabled');
    @endif

    

    loadSelectInput("#tipo_documento", "{{ url('/clientes/tipodocumento/getSelectList2') }}")
    ESTADOS.setProcesado({{ env('ORDEN_PROCESADA') }});

    <!-- $("#subdividir").change(); -->
    if($("#subdividir").val() == "1") {
    $("#subdividir").prop('checked', true); 
    $(".subdividir").css('display','table-cell');
    $("#cont-selectAll").css('display','inline-block');
    
} else {
    $("#subdividir").prop('checked', false); } 
   

$(document).ready(function(){ 
    {{-- $("#cont-selectAll").css('display', 'none'); --}}
    $("#cont-selectAll").css('display','inline-block');
    $(".subdividir").css('display','table-cell');
    $('.nit-val').blur();
    
});
@endsection

@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
    <div class="x_panel">
        <div class="x_title">
            <h2>Información plan separe</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="btn-group pull-right espacio" role="group" >
                    @if($infoAbono->estado_plan == env('PLAN_ESTADO_ACTIVO'))
                        @if(Auth::user()->role->id==env('ROLE_JEFE_ZONA'))
                            @if($reverso != null)
                            <button title="Reversar abono" id="reversar_abono" type="button" class="btn btn-success"><i class="fa fa-minus-square"></i> Reversar abono</button>
                            <button title="Rechazar reversar abono" id="rechazar_reversar_abono" type="button" class="btn btn-danger"><i class="fa fa-minus-square"></i> Rechazar reversar abono</button>
                            @endif
                        @else
                            @if($reverso == null)
                                <button title="Solicitar reversar abono" id="solicitar_reversar_abono" type="button" class="btn btn-success"><i class="fa fa-minus-square"></i> Solicitud reversar abono</button>
                            @endif
                        @endif
                        
                        @if(Auth::user()->role->id!=env('ROLE_JEFE_ZONA'))
                            @if($infoAbono->estado_plan != env('CERRAR_PLAN_SEPARE_ANULACION') && $infoAbono->estado_plan != env('CERRAR_PLAN_SEPARE_PEN_ANULACION'))
                                <button title="Solicitar anular plan separe"  id="solicitud_anular" type="button" class="btn btn-danger"><i class="fa fa-sign-in "></i> Solicitar anulación</button>
                            @endif
                        @endif
                    @endif
                    @if(Auth::user()->role->id==env('ROLE_JEFE_ZONA'))
                        @if($infoAbono->estado_plan != env('CERRAR_PLAN_SEPARE_ANULACION')) 
                            <button title="Anular plan separe"  id="anular" type="button" class="btn btn-danger"><i class="fa fa-sign-in "></i> Anular</button>
                        @endif
                    @endif
                </div>
                    
            </div>
            <div class="x_title">
                <h2>Datos del cliente</h2>
                <div class="clearfix"></div>
            </div>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <div class="col-md-6 bottom-20">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="tipo_documento">Tipo de documento <span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <select id="tipo_documento" name="tipo_documento" class="form-control col-md-7 col-xs-12 obligatorio" required="required" disabled>
                                    <option value="">- Seleccione una opción -</option>
                                    @foreach($tipo_documento as $tipo)
                                        <option @if($tipo->id == $infoAbono->id_tipo_documento) selected @endif value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 bottom-20">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="numero_documento">Número de documento<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="numero_documento" id="numero_documento" type="text" readonly class="form-control column_filter numeric obligatorio" value=" {{ $infoAbono->numero_documento }}">                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 bottom-20">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="nombres">Nombres <span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="nombres" readonly id="nombres" type="text" class="form-control obligatorio" value="{{ $infoAbono->nombres }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 bottom-20">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="codigo_planS">Código plan separe<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="codigo_planS" readonly id="codigo_planS" type="text" class="form-control obligatorio" value="{{ $codigo_plan }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 bottom-20">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="apellidos">Apellidos<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="apellidos" readonly id="apellidos" type="text" class="form-control obligatorio" value="{{ $infoAbono->primer_apellido." ".$infoAbono->segundo_apellido }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 bottom-20">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="deuda_total">Deuda total<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="deuda_total" readonly id="deuda_total" type="text" class="form-control obligatorio" value="{{ $infoAbono->monto }}" >
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 bottom-20">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_pendiente">Saldo pendiente<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="saldo_pendiente" readonly id="saldo_pendiente" type="text" class="form-control obligatorio" value="{{ $infoAbono->deuda }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bottom-20">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_pendiente">Cantidad abonada<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="saldo" readonly id="saldo" type="text" class="form-control obligatorio" value="{{ $saldo_favor }}">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="x_title">
                <h1>Productos separados</h1>
                <div class="clearfix"></div>
            </div>
            <div class="item_refac notop hidefilters">
                <table id="productosPlan" class="display" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Categoria</th>
                            <th>Referencia</th>
                            <th>Nombre</th>
                            <th>Peso</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->categoria }}</td>
                                <td>{{ $item->referencia }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->peso }}</td>
                                <td>{{ $item->precio }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="x_title">
                <h1>Abonos</h1>
                <div class="clearfix"></div>
            </div>
            <div class="item_refac notop hidefilters">
                <table id="dataTableAction" class="display" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tienda</th>
                            <th>Código abono</th>
                            <th>Tipo abono</th>
                            <th>Abono</th>
                            <th>Fecha abono</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <input type="hidden" id="id_tienda" name="id_tienda" value="{{ $id_tienda }}"/>
            <input type="hidden" id="idRemitente" name="idRemitente" value="{{ $idRemitente }}"/>
            <!-- <input type="hidden" id="codigo_abono" name="codigo_abono" value=""/> -->
            <input type="hidden" id="fecha_creacion" name="fecha_creacion" value="{{ $infoAbono->fecha_creacion }}"/>
            <input type="hidden" id="fecha_actual" name="fecha_actual" value="{{ Carbon\Carbon::today()->format('d-m-Y') }}"/>
            <input type="hidden" id="abonorever" name="abonorever" value="@if(isset($reverso)){{ $reverso }}@endif">
            <input type="hidden" id="abonorever_sal" name="abonorever_sal" value="@if(isset($reverso_abono)){{ $reverso_abono }}@endif">
            <input type="hidden" id="deuda" name="deuda" value="@if(isset($abono->deuda)){{ $abono->deuda }}@endif">
            <input type="hidden" id="cantidad_abonos" name="cantidad_abonos" value="{{ count($abonos) }}">
            

            @if($saldo_favor != '0,00')
                <input type="hidden" value="1" id="isset_abonos" />
            @else
                <input type="hidden" value="0" id="isset_abonos" />
                <input type="hidden" id="saldo_abonado" name="saldo_abonado" value="{{ $saldo_favor }}"/>
            @endif            

            <div class="row" style="margin-top: 0.5em !important">
                <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="form-group">
                        <a href="{{url('/generarplan/')}}" class="btn btn-danger">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('/js/plansepare.js')}}"></script>
@endpush

@section('javascript')
    //<script>
    column=[
        { "className": 'details-control no-replace-spaces', "orderable": false, "data": null, "defaultContent": ''},
        { "data": "nombre"},
        { "data": "codigo_abono"},
        { "data": "tipo_abono"},
        { "data": "saldo_abonado"},
        { "data": "fecha"}
    ];
    dtMultiSelectRowAndInfo("dataTableAction", "{{ url('/generarplan/getInfoAbonos') }}/{{ $id_tienda }}/{{ $codigo_plan }}","{{ url('/plugins/datatable/DataTables-1.10.13/json/spanish.json') }}",column);
 
function detalles_tabla(){
    $('#dataTableAction tbody').on('click', 'td.details-control', function(){
        var tr = $(this).closest('tr');
        var iabono = $(tr).attr('id');
        var ab = iabono.split("/");
        var id_abono = ab[0];
        var id_tienda = ab[1];
        var row = table_multi_select.row( tr );
        if ( row.child.isShown()){
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
        // Open this row
        row.child(detalle_tabla_html(id_tienda, id_abono)).show();
        tr.addClass('shown');
        }
    });
};
function detalle_tabla_html(id_tienda, id_abono){
    var html_tabla = '<table>';
    html_tabla +=
       '<thead><th>Tipo</th><th>Valor</th><th>Comprobante</th><th>Observaciones</th></thead>';       
        $.ajax({
            url: urlBase.make(`generarplan/detalleAbono/${id_tienda}/${id_abono}`),
            type: "get",
            async: false,
            success: function(datos){
                jQuery.each(datos, function(indice, valor){
                    html_tabla +=
                    `<tr>
                        <td>${ datos[indice].tipo }</td>
                        <td>${ datos[indice].valor }</td>
                        <td>${ datos[indice].comprobante }</td>
                        <td>${ datos[indice].observaciones }</td>
                    </tr>`
                });
            }
        });
    return html_tabla;
};

$(document).ready(function(){
    detalles_tabla();
    $('#dataTableAction tr').each(function(){
        var id = $(this).attr('id');
        var rever = ("{{$reverso}}" != "") ? "{{ $reverso }}" : null
        // if(id[0] == rever) 
    });

    $("#dataTableAction tr").click(function(){
        $('#dataTableAction tr').each(function(){ $(this).removeClass("selected"); });
        $(this).addClass("selected");
    })
});
    
@endsection
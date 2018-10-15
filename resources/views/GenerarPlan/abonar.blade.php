@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
    <div class="x_panel">
        <div class="x_title">
            <h2>Abonar plan separe</h2>
            <div class="clearfix"></div>
        </div>
        @if($plan->estado == env('CERRAR_PLAN_SEPARE_ANULACION') || $plan->estado == env('CERRAR_PLAN_SEPARE_PEN_ANULACION') || $plan->estado == env('CERRAR_PLAN_SEPARE_ESTADO') || $plan->estado == env('CERRAR_PLAN_SEPARE_PENDIENTE_CIERRE'))
        <div class="alert alert-danger" style="display:" id="alertPas">
            <h4 class="alert-heading">Información</h4>
            <p id="textAlert">Este plan no puede ser abonado ya que no se encuentra activo</p>
        </div>
        @endif
        <div class="x_content">            
        <form id="form-attribute" action="{{ url('/generarplan/guardar') }}" method="POST" class="form-horizontal form-label-left">
        {{ csrf_field() }}  
            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <div class="col-md-6">
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

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="numero_documento">Número de documento<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="numero_documento" id="numero_documento" type="text" readonly class="form-control column_filter numeric obligatorio" value=" {{ $infoAbono->numero_documento }}">                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="nombres">Nombres <span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="nombres" readonly id="nombres" type="text" class="form-control obligatorio" value="{{ $infoAbono->nombres }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="codigo_planS">Código plan separe<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="codigo_planS" readonly id="codigo_planS" type="text" class="form-control obligatorio" value="{{ $codigo_plan }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="apellidos">Apellidos<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="apellidos" readonly id="apellidos" type="text" class="form-control obligatorio" value="{{ $infoAbono->primer_apellido." ".$infoAbono->segundo_apellido }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="deuda_total">Deuda total<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="monto_total" readonly id="monto_total" type="text" class="form-control obligatorio" value="{{ $infoAbono->monto }}" >
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_pendiente">Saldo pendiente<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="saldo_pendiente" readonly id="saldo_pendiente" type="text" class="form-control obligatorio" value="{{ $infoAbono->deuda }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_pendiente">Cantidad abonada<span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input name="saldo" readonly id="saldo" type="text" class="form-control obligatorio" value="{{ $saldo_favor }}">
                            </div>
                        </div>
                    </div>

                </div>
            </div>










            <div id="content_abono">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1"> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="tienda">Tienda <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="tienda" readonly id="tienda" type="text" class="form-control requiered" value="{{ $plan->tienda }}">
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-md-6"> -->
                            <!-- <div class="form-group"> -->
                                <!-- <label class="control-label col-md-5 col-sm-3 col-xs-12" for="codigo_transaccion">Código transacción<span class="required red">*</span></label> -->
                                <!-- <div class="col-md-7 col-sm-6 col-xs-12"> -->
                                    <input name="codigo_transaccion" readonly id="codigo_transaccion"  type="hidden" class="form-control requiered" value="{{ $codigo_transaccion[0]->response }}">
                                <!-- </div> -->
                            <!-- </div> -->
                        <!-- </div> -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="codigo_abono">Código abono<span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="codigo_abono" readonly id="codigo_abono" type="text" class="form-control requiered" value="{{ $codigo_abono }}" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="fecha_abono">Fecha del abono <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input type="text" readonly class="form-control requiered" id="fecha_abono" name="fecha_abono" value="{{ Carbon\Carbon::today()->format('d-m-Y') }} ">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="fecha_limite">Fecha Limite <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input type="text" readonly  class="form-control" id="fecha_limite" name="fecha_limite" value="{{ $plan->fecha_limite }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_abonar_efectivo">Abono efectivo<span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                                    <input name="saldo_abonar_efectivo" id="efectivo" type="text" class="form-control requiered moneda" maxlength="10">
                                </div>
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_abonar_credito">Abono tarjeta de credito<span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                                    <input name="saldo_abonar_credito" id="credito" type="text" class="form-control requiered moneda" maxlength="10">
                                </div>
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_abonar_debito">Abono tarjeta debito<span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                                    <input name="saldo_abonar_debito" id="debito" type="text" class="form-control requiered moneda" maxlength="10">
                                </div>
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_abonar_otro">Abono otro<span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                                    <input name="saldo_abonar_otro" id="otro" type="text" class="form-control requiered moneda" maxlength="10">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_abonar"> <span class="required red"></span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                                    <select name="" id="" class="form-control requiered moneda" style="visibility: hidden;"></select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_abonar">Abono tarjeta de credito<span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="saldo_abonar_credito" id="saldo_abonar_credito" type="text" class="form-control requiered moneda" maxlength="10">
                                </div>
                            </div>
                        </div> -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="comprobante_credito">Codigo de aprobación <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                                    <input name="comprobante_credito" id="comprobante_credito" type="text" class="form-control requiered" maxlength="10">
                                </div>
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="comprobante_debito">Codigo de aprobación<span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="margin-bottom: 10px;">
                                    <input name="comprobante_debito" id="comprobante_debito" type="text" class="form-control requiered" maxlength="10">
                                </div>
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="comprobante_otro">Codigo de aprobación<span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="comprobante_otro" id="comprobante_otro" type="text" class="form-control requiered" maxlength="10">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_abonar">Abono tarjeta debito<span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="saldo_abonar_debito" id="saldo_abonar_debito" type="text" class="form-control requiered moneda" maxlength="10">
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_abonar">Codigo de aprobación<span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="comprobante_debito" id="comprobante_debito" type="text" class="form-control requiered" maxlength="10">
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="observaciones">Observaciones <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control" id="observaciones" name="observaciones">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_abonar">Total <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input type="text" readonly  class="form-control moneda" id="saldo_abonar" name="saldo_abonar">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-offset-3 col-md-6">
                                <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center" style="margin-top: 0.5em !important">
                                    <input type="hidden" name="id_tienda" id="id_tienda" value="{{ $plan->id_tienda }}"/>
                                    <input type="hidden" name="id_tienda_on" id="id_tienda_on" value="{{ tienda::Online()->id }}"/>
                                    <input type="hidden" name="id_comprobante" id="id_comprobante" value="{{ $infoAbono->id_comprobante }}"/>
                                    <input type="hidden" name="codigo_tienda" id="codigo_tienda" value="{{ tienda::OnLine()->codigo_tienda }}">
                                    <input type="hidden" name="paso" id="paso" value="0"/>
                                    <!-- <input type="hidden" name="saldo_abonar" id ="saldo_abonar"/> -->
                                    <a href="{{url('/generarplan/')}}" class="btn btn-danger">Cancelar</a>
                                    @if($plan->estado != env('CERRAR_PLAN_SEPARE_ANULACION') && $plan->estado != env('CERRAR_PLAN_SEPARE_PEN_ANULACION') && $plan->estado != env('CERRAR_PLAN_SEPARE_ESTADO') && $plan->estado != env('CERRAR_PLAN_SEPARE_PENDIENTE_CIERRE'))
                                        <button type="button" id='btn-procesar' class="btn btn-success">Abonar</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </form>

            <!-- Formulario para la generación del PDF de la creación del Plan Separe -->
            <form id="form_generate_pdf" class="hide" method="POST" action="{{ url('generarplan/generarpdf') }}">
                {{ csrf_field() }}
                <input type="hidden" id="tipo_documento_var" name="params_ps[tipo_documento_var]"  />
                <input type="hidden" id="numero_documento_var" name="params_ps[numero_documento_var]"  />
                <input type="hidden" id="codigo_plan_var" name="params_ps[codigo_plan_var]"  />
                <input type="hidden" id="id_tienda_var" name="params_ps[id_tienda_var]"  />
                <input type="hidden" id="codigo_abono_var" name="params_ps[codigo_abono]"  />
                <input type="hidden" id="monto_total_var" name="params_ps[monto_total]"  />
                <input type="hidden" id="saldo_abonar_var" name="params_ps[saldo_abonar]"  />
                <input type="hidden" id="saldo_pendiente_var" name="params_ps[saldo_pendiente]"  />
            </form>
        </div>
    </div>
@endsection   

@push('scripts')
    <script src="{{asset('/js/plansepare.js')}}"></script>
@endpush
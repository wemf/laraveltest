@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

    <!-- Formulario para la generación del PDF de la creación del Plan Separe -->
    <form id="form_generate_pdf" class="hide" method="POST" action="{{ url('generarplan/generarpdf') }}">
        {{ csrf_field() }}
        <input type="hidden" id="tipo_documento_var" name="params_ps[tipo_documento_var]" value="{{ $infoAbono->id_tipo_documento }}" />
        <input type="hidden" id="numero_documento_var" name="params_ps[numero_documento_var]" value="{{ $infoAbono->numero_documento }}" />
        <input type="hidden" id="codigo_plan_var" name="params_ps[codigo_plan_var]"/>
        <input type="hidden" id="id_tienda_var" name="params_ps[id_tienda_var]"/>
        <input type="hidden" id="codigo_abono_var" name="params_ps[codigo_abono]"/>
        <input type="hidden" id="monto_total_var" name="params_ps[monto_total]" value="{{ $infoAbono->monto_total }}" />
        <input type="hidden" id="saldo_abonar_var" name="params_ps[saldo_abonar]"  />
        <input type="hidden" id="saldo_pendiente_var" name="params_ps[saldo_pendiente]"  />
    </form>

    <form id="pdfcontrato" class="hide" method="get">
        {{ csrf_field() }}
        <input type="submit" name="boton_pdf" id="boton_pdf" value="enviar" style="display:none;">
    </form>



    <div class="x_panel">
        <div class="x_title">
            <h2>Transferir plan separe</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="content_transfer">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="tipo_documento">Tipo de documento <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <select id="tipo_documento" name="tipo_documento" class="form-control col-md-7 col-xs-12 requiered" required="required" disabled>
                                        @foreach($tipo_documento as $tipo)
                                            <option value="{{ $tipo->id }}" @if($infoAbono->id_tipo_documento == $tipo->id) selected @endif>{{ $tipo->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="numero_documento">Número de documento <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="numero_documento" id="numero_documento" type="text" readonly class="form-control column_filter numeric requiered" value="{{ $infoAbono->numero_documento }}" >                                
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="nombres">Nombres <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="nombres" readonly id="nombres" type="text" class="form-control requiered" value="{{ $infoAbono->nombres }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="codigo_planS">Código plan separe <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="codigo_planS" readonly id="codigo_planS" type="text" class="form-control requiered" value="{{ $codigo_plan }}"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="apellidos">Apellidos <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="apellidos" readonly id="apellidos" type="text" class="form-control requiered" value="{{ $infoAbono->primer_apellido." ".$infoAbono->segundo_apellido }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="saldo_favor">Saldo a favor <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input name="saldo_favor" readonly id="saldo_favor" type="text" class="form-control requiered" value="{{ $saldo_favor->nuevo_saldo_favor }} ">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="transferir">Transferir: <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <select id="transferir" name="transferir" class="form-control col-md-7 col-xs-12 requiered" required="required">
                                        <option value="">- Seleccione una opción -</option>
                                        <option value="1"> Plan Separe </option>
                                        <option value="2"> Contrato </option>
                                    </select>
                                </div>
                            </div>
                        </div> 

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="transferirA">Transferir a: <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <select id="transferirA" name="transferirA" class="form-control col-md-7 col-xs-12 requiered" required="required">
                                        <option value="">- Seleccione una opción -</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="transferirA">Cantidad a transferir: <span class="required red">*</span></label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <input type="text" class="moneda form-control requiered centrar-derecha resertInp" name="cantidad" id="cantidad" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-3 col-xs-12" for="trasferir_nuevo_plan">Transferir a nuevo plan separe</label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <!-- <input type="checkbox" name="trasferir_nuevo_plan" id="trasferir_nuevo_plan" /> -->
                                    <label class="switch_check">
                                        <input type="checkbox" id="trasferir_nuevo_plan" name="trasferir_nuevo_plan" value="0"  onchange="intercaleCheck(this);" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center" style="margin-top: 0.5em !important">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id"/>
                                <input type="hidden" name="paso" id="paso" value="0"/>
                                <input type="hidden" id="codigo_abono" name="codigo_abono" value="{{ $codigo_abono }}"/>
                                <input type="hidden" id="codigo_cliente" name="codigo_cliente" value="{{ $codigo_cliente }}"/>
                                <input type="hidden" id="id_tienda" name="id_tienda" value="{{ $id_tienda }}"/>
                                <input type="hidden" id="id_tienda_cliente" name="id_tienda_cliente" value="{{ $infoAbono->id_tienda_cliente }}"/>
                                <input type="hidden" name="precio_total" id="precio_total"/>
                                <input type="hidden" id="deuda2" name="deuda2"/>
                                <input type="hidden" id="saldo_pendiente_plan" name="saldo_pendiente_plan" value="{{ $infoAbono->deuda }}"/>
                                <input type="hidden" id="saldo_pendiente_plan" name="saldo_pendiente_plan"/>
                                <input type="hidden" name="porcen_retro" id="porcen_retro"/>
                                <input type="hidden" name="valor_abonado_bd" id="valor_abonado_bd"/>
                                <input type="hidden" name="meses_prorroga" id="meses_prorroga"/>
                                <input type="hidden" name="total_prorrogar" id="total_prorrogar"/>
                                <input type="hidden" name="valor_ingresado" id="valor_ingresado"/>
                                <input type="hidden" name="nuevo_valor_abonado" id="nuevo_valor_abonado"/>
                                <input type="hidden" name="id_tienda_plan" id="id_tienda_plan"/>
                                <input type="hidden" name="id_tienda_login" id="id_tienda_login" value="{{ $id_tienda_login }}"/>
                                <input type="hidden" name="fecha_terminacion_cabecera" id="fecha_terminacion_cabecera"/>
                                <input type="hidden" name="fecha_prorroga" id="fecha_prorroga" value="{{ Carbon\Carbon::now() }}"/>
                                <input type="hidden" name="meses_adeudados" id="meses_adeudados" >

                                <a href="{{url('/generarplan/')}}" class="btn btn-danger">Cancelar</a>
                                <button type="button" id='btn-transferP' class="btn btn-success">Transferir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
    <script src="{{asset('/js/contrato/prorrogar.js')}}"></script>
    <script src="{{asset('/js/plansepare.js')}}"></script>
@endpush
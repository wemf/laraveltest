@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
    <div class="x_panel">
        <div class="x_title">
            <h2>Solicitar cotización plan separe</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">            
        <form id="form-attribute" action="{{ url('/cotizacion/storeUpdate') }}" method="POST" class="form-horizontal form-label-left" autocomplete="off">
        {{ csrf_field() }} 
            <div id="content_abono">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1"> 
                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="tienda">Descripción<span class="required red">*</span></label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <textarea name="descripcion" id="descripcion" class="form-control requiered" required readonly cols="30" rows="5">{{ $data->descripcion }}</textarea>
                                </div>
                            </div>
                        </div>  

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="tienda">Especificaciones</label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <textarea name="especificaciones" id="especificaciones" class="form-control" cols="30" rows="5" @if($data->estado == 0) readonly @endif>{{ $data->especificaciones }}</textarea>
                                </div>
                            </div>
                        </div>  

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label for="ajax" class="col-md-3 col-sm-3 col-xs-12">Referencia<span class="required">*</span></label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input id="ajax" name="referencia" type="text" list="json-datalist" placeholder="Buscar referencia" class="form-control datalist-load"
                                        data-ajax-url="{{ url('bucar/referencia') }}" onkeyup="autoCompletateAction.run(this);" oninvalid="isDetailsRequiered(this);" 
                                        required value="{{ $data->referencia }}" @if($data->estado == 0) readonly @endif>
                                    <datalist id="json-datalist"></datalist>
                                </div>
                                <input type="hidden" id="id_referencia-name" name="id_catalogo_producto" class="requiered" required>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="precio">Precio <span class="required red">*</span></label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input name="precio" id="precio" type="text" class="form-control moneda requiered" maxlength="10" required value="{{ $data->precio }}" @if($data->estado == 0) readonly @endif >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="precio">Peso <span class="required">*</span></label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input name="peso" id="peso" type="text" class="form-control @if($data->estado == 1) moneda @endif requiered" required value="{{ $data->peso }}" @if($data->estado == 0) readonly @endif>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="precio">Fecha entrega <span class="required">*</span></label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input name="fecha_entrega" id="fecha_entrega" type="text" required class="form-control data-picker-only requiered" value="{{ $data->fecha_entrega }}" @if($data->estado == 0) readonly @endif>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-offset-3 col-md-6">
                                <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center" style="margin-top: 0.5em !important">
                                    <input type="hidden" name="id_tienda" value="{{ $data->id_tienda }}">
                                    <input type="hidden" name="id_cotizacion" value="{{ $data->id_cotizacion }}">
                                    <input type="hidden" name="id_usuario" value="{{ $data->id_usuario }}">
                                    <a href="{{url('/cotizacion')}}" class="btn btn-danger">Volver</a>
                                    @if($data->estado == 1)
                                    <button type="submit" id='btn-procesar' class="btn btn-success hide">Responder</button>
                                    <button type="button" id='btn-procesarX' class="btn btn-success">Responder</button>
                                    @endif  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('/js/Trasversal/Autocomplate/datalist.js')}}"></script>
    <script src="{{asset('/js/plansepare/cotizacion.js')}}"></script>
@endpush
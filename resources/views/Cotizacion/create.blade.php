@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
    <div class="x_panel">
        <div class="x_title">
            <h2>Solicitar cotización plan separe</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">            
        <form id="form-attribute" action="{{ url('/cotizacion/store') }}" method="POST" class="form-horizontal form-label-left">
        {{ csrf_field() }} 
            <div id="content_abono">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1"> 
                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="tienda">Descripción<span class="required red">*</span></label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <textarea name="descripcion" id="descripcion" class="form-control requiered" required cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="tienda">Especificaciones</label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <textarea name="especificaciones" id="especificaciones" class="form-control requiered" required cols="30" rows="5" readonly></textarea>
                                </div>
                            </div>
                        </div>    
                                
                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="referencia">Referencia</label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input name="referencia" id="referencia" type="text" class="form-control" value="" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="precio">Precio</label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input name="precio" id="precio" type="text" class="form-control" value="" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="precio">Peso</label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input name="Peso" id="Peso" type="text" class="form-control" value="" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 bottom-20">
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12" for="precio">Fecha entrega</label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input name="fecha_entrega" id="fecha_entrega" type="text" class="form-control" value="" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-offset-3 col-md-6">
                                <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center" style="margin-top: 0.5em !important">
                                    <a href="{{url('/cotizacion')}}" class="btn btn-danger">Cancelar</a>
                                    <button type="submit" id='btn-procesar' class="btn btn-success">Cotizar</button>
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
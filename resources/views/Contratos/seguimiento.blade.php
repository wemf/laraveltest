@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title"><h2>Seguimiento Guía</h2>
    @if($guia->id_tienda_principal == 0)
        @if(Auth::user()->role->id==env('ROL_ADMIN_BOD') || Auth::user()->role->id==env('ROL_JESE_ZONA') || Auth::user()->role->id==env('ROL_AUXILIAR_TIENDA'))
            @if($guia->id_estado == env('ESTADO_LOGISTICA_SOLICITUD_ENVIO'))
                <button type="button" class="btn btn-success" id="confirm_prog" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Confirmar programación de envio</button>
                <input type="hidden" id="id_estado" value="{{ env('ESTADO_LOGISTICA_ENVIO') }}">
                <input type="hidden" id="id_motivo" value="{{ env('MOTIVO_LOGISTICA_ENVIO') }}">
                <input type="hidden" name="destino" id="destino" value="{{ $guia->id_bodega_envio }}">
            @endif 
        @endif
        @if($guia->id_estado == env('ESTADO_LOGISTICA_ENVIO'))
            <button type="button" class="btn btn-success" id="confirm_envio" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Confirmar envio</button>
            <input type="hidden" id="id_estado" value="{{ env('ESTADO_LOGISTICA_EN_TRANCITO') }}">
            <input type="hidden" id="id_motivo" value="{{ env('MOTIVO_LOGISTICA_TRANCITO') }}">
            <input type="hidden" name="destino" id="destino" value="{{ $guia->id_bodega_envio }}">
        @endif 
        
        @if($guia->id_estado == env('ESTADO_LOGISTICA_EN_TRANCITO'))
            <button type="button" class="btn btn-success" id="confirm_entrega" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Aceptar envio</button>
            <input type="hidden" id="id_estado" value="{{ env('ESTADO_LOGISTICA_ENTREGA') }}">
            <input type="hidden" id="id_motivo" value="{{ env('MOTIVO_LOGISTICA_ENTREGA') }}">
            <input type="hidden" name="destino" id="destino" value="{{ $guia->id_bodega_envio }}">
        @endif 
    @endif

    @if($guia->id_tienda_principal == 1)
        @if(Auth::user()->role->id==env('ROL_ADMIN_BOD') || Auth::user()->role->id==env('ROL_JESE_ZONA') || Auth::user()->role->id==env('ROL_AUXILIAR_TIENDA'))
            @if($guia->id_estado == env('ESTADO_LOGISTICA_SOLICITUD_ENVIO'))
                <button type="button" class="btn btn-success" id="confirm_prog" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Confirmar programación de envio</button>
                <input type="hidden" id="id_estado" value="{{ env('ESTADO_LOGISTICA_ENVIO') }}">
                <input type="hidden" id="id_motivo" value="{{ env('MOTIVO_LOGISTICA_ENVIO_TIENDA') }}">
                <input type="hidden" name="destino" id="destino" value="{{ $guia->tienda_padre }}">
            @endif 
        @endif
        @if($guia->id_estado == env('ESTADO_LOGISTICA_ENVIO') && $guia->id_motivo == env('MOTIVO_LOGISTICA_ENVIO_TIENDA'))
            <button type="button" class="btn btn-success" id="confirm_envio" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Confirmar envio</button>
            <input type="hidden" id="id_estado" value="{{ env('ESTADO_LOGISTICA_EN_TRANCITO') }}">
            <input type="hidden" id="id_motivo" value="{{ env('MOTIVO_LOGISTICA_TRANCITO_TIENDA') }}">
            <input type="hidden" name="destino" id="destino" value="{{ $guia->tienda_padre }}">
        @endif 
        
        @if($guia->id_estado == env('ESTADO_LOGISTICA_EN_TRANCITO') && $guia->id_motivo == env('MOTIVO_LOGISTICA_TRANCITO_TIENDA'))
            <button type="button" class="btn btn-success" id="confirm_entrega" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Aceptar envio</button>
            <input type="hidden" id="id_estado" value="{{ env('ESTADO_LOGISTICA_ENTREGA') }}">
            <input type="hidden" id="id_motivo" value="{{ env('MOTIVO_LOGISTICA_ENTREGA_TIENDA') }}">
            <input type="hidden" name="destino" id="destino" value="{{ $guia->tienda_padre }}">
        @endif 

        @if($guia->id_estado == env('ESTADO_LOGISTICA_ENTREGA') && $guia->id_motivo == env('MOTIVO_LOGISTICA_ENTREGA_TIENDA'))
            <button type="button" class="btn btn-success" id="confirm_prog_principal" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Confirmar programación de envio</button>
            <input type="hidden" id="id_estado" value="{{ env('ESTADO_LOGISTICA_ENVIO') }}">
            <input type="hidden" id="id_motivo" value="{{ env('MOTIVO_LOGISTICA_ENVIO') }}">
            <input type="hidden" name="destino" id="destino" value="{{ $guia->id_bodega_envio }}">
        @endif 

        @if($guia->id_estado == env('ESTADO_LOGISTICA_ENVIO') && $guia->id_motivo == env('MOTIVO_LOGISTICA_ENVIO'))
            <button type="button" class="btn btn-success" id="confirm_envio" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Confirmar envio</button>
            <input type="hidden" id="id_estado" value="{{ env('ESTADO_LOGISTICA_EN_TRANCITO') }}">
            <input type="hidden" id="id_motivo" value="{{ env('MOTIVO_LOGISTICA_TRANCITO') }}">
            <input type="hidden" name="destino" id="destino" value="{{ $guia->id_bodega_envio }}">
        @endif 

        @if($guia->id_estado == env('ESTADO_LOGISTICA_EN_TRANCITO') && $guia->id_motivo == env('MOTIVO_LOGISTICA_TRANCITO'))
            <button type="button" class="btn btn-success" id="confirm_entrega" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;">Aceptar envio</button>
            <input type="hidden" id="id_estado" value="{{ env('ESTADO_LOGISTICA_ENTREGA') }}">
            <input type="hidden" id="id_motivo" value="{{ env('MOTIVO_LOGISTICA_ENTREGA') }}">
            <input type="hidden" name="destino" id="destino" value="{{ $guia->id_bodega_envio }}">
        @endif 
    @endif
    <div class="clearfix"></div>
  </div>
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="col-md-10 bottom-20">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_pais">Observación<span class="required red">*</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                       <textarea rows="5" cols="15" class="form-control" id="observaciones" name="observaciones"></textarea>
                                       <input type="hidden" name="id" id="id" value="{{ $guia->id_sec_guia }}">
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm_process">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="x_content">
        <div class="alert alert-danger" style="display: none" id="alertPas">
            <h4 class="alert-heading">Información</h4>
            <p id="textAlert"></p>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-6 bottom-20">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_pais">País </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="id_pais" value="{{ $guia->pais}}" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bottom-20">
                    <div class="form-group" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_departamento">Departamento </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="id_departamento" value="{{ $guia->departamento }}" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">    
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-6 bottom-20">
                    <div class="form-group" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_ciudad">Ciudad </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="id_ciudad" value="{{ $guia->ciudad }}" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bottom-20">
                    <div class="form-group" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_envio">Envio a </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="id_envio" value="{{ $guia->envio }}" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-6 bottom-20">
                    <div class="form-group" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tienda_envio">Pasar por tienda principal</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="id_tienda_envio" value="{{ $guia->pasar_por_tienda }}" class="form-control" disabled>
                        </div>
                    </div>
                </div>  
                <div class="col-md-6 bottom-20">  
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bodega_envio">Destino</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="bodega_envio" value="{{ $guia->destino }}" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-6 bottom-20">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_bodega"> Recibe en destino</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="user_bodega" value="{{ $guia->recibe }}" class="form-control" disabled>
                        </div>
                    </div>
                </div>        
            </div>
        </div> -->
        <div class="x_title"><h2>Ordenes de resolución</h2>
            <div class="clearfix"></div>
        </div>
        <div class="item_temp notop">
            <table class="display dataTableAction" width="100%" cellspacing="0" id="#dataTableAction">
                <thead>
                    <tr>               
                        <th>Número de orden</th>
                        <th>Proceso</th>
                    </tr>
                </thead> 
                <tbody>
                    @foreach($resoluciones as $res)
                        <tr>
                            <td>{{ $res->id }}</td>
                            <td>{{ $res->proceso }}</td>
                        </tr>    
                    @endforeach    
                </tbody>       
            </table>   
        </div> 
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('/js/contrato/guia.js')}}"></script>
@endpush

@section('javascript')
  @parent
  //<script>
    $('.dataTableAction').DataTable({
        language: 
        {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
        },
    });
  

@endsection

@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title"><h2>Generar Guía</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
      <div class="circleTraza col-md-offset-3">
        <div class="circleTraza-row">
          <div class="circleTraza-step">
            <a type="button" id="st1" class="btn btn-primary btn-circle">1</a>
          </div>
          <div class="circleTraza-step">
            <a type="button" id="st2" class="btn btn-default btn-circle">2</a>
          </div>
        </div>
      </div>  
      <div class="alert alert-danger" style="display: none" id="alertPas">
        <h4 class="alert-heading">Informacion</h4>
        <p id="textAlert"></p>
      </div>
      <!-- parte 1 -->
    <div id="step-1">
        <div class="x_title">
            <h2>Listado de ordenes de resolución</h2>
            <div class="clearfix"></div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="col-md-12 bottom-20">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-3 col-xs-12" for="id_tienda">Tienda <span class="required red">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select id="id_tienda" name="id_tienda" disabled class="form-control col-md-7 col-xs-12 requiered" data-load="{{ $tienda->id }}"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-3 col-xs-12" for="id_resolucion">Resoluciones <span class="required red">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12 multiselec">
                            <select multiple="multiple" id="id_resolucion" name="id_resolucion" class="form-control col-md-7 col-xs-12 requiered">
                            </select>
                        </div>
                    </div>
                </div>         
            </div>
        </div>
    </div>
    <!-- parte 2 -->
    <div id="step-2" style="display:none">
        <div class="x_title">
            <h2>Datos de envio</h2>
            <div class="clearfix"></div>
        </div>
        <div class="row" id="n_principal">
            <div class="col-md-10 col-md-offset-3">
                <div class="col-md-9 bottom-20">
                    <div class="form-group" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_pais">País <span class="required red">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select id="id_pais" name="id_pais" class="form-control col-md-7 col-xs-12 limpiar">
                                <option value="">- Seleccione una opción -</option>
                                @foreach($pais as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 bottom-20">
                    <div class="form-group" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_departamento">Departamento <span class="required red">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select id="id_departamento" name="id_departamento" class="form-control col-md-7 col-xs-12 limpiar">
                                <option value="">- Seleccione una opción -</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 bottom-20">
                    <div class="form-group" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_ciudad">Ciudad <span class="required red">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select id="id_ciudad" name="id_ciudad" class="form-control col-md-7 col-xs-12 limpiar">
                                <option value="">- Seleccione una opción -</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 bottom-20">
                    <div class="form-group" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_envio">Envio a <span class="required red">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="inline-30">
                                <input type="radio" id="id_envio_1" name="id_envio" class="radio-control" value="0" onchange="envio(this);" />
                                <label for="id_envio_1" class="lbl-radio-control" style="font-size: 16px!important; font-weight: 100; height: 26px; display: block;"> Tienda</label>          
                            </div>
                            <div class="inline-30">
                                <input type="radio" id="id_envio_2" name="id_envio" class="radio-control" value="1" onchange="envio(this);" />
                                <label for="id_envio_2" class="lbl-radio-control" style="font-size: 16px!important; font-weight: 100; height: 26px; display: block;"> Bodega</label>          
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-md-9 bottom-20" id="pasa_tienda">
                    <div class="form-group" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tienda_envio">Pasar por tienda principal</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <label class="switch_check">
                                <input type="checkbox" id="id_tienda_envio" name="id_tienda_envio"  onchange="intercaleCheck(this);" class="limpiar" value="0">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>  
                <div class="col-md-9 bottom-20">  
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bodega_envio">Destino<span class="required red">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select id="bodega_envio" name="bodega_envio" class="form-control col-md-7 col-xs-12 limpiar">
                                <option value="">- Seleccione una opción -</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-9 bottom-20">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_bodega"> Recibe en destino<span class="required red">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select id="user_bodega" name="user_bodega" class="form-control col-md-7 col-xs-12 requiered limpiar">
                                <option value="">- Seleccione una opción -</option>
                            </select>
                        </div>
                    </div>
                </div>         -->
            </div>
        </div>
    </div>

      <div class="x_title">
        <div class="clearfix"></div>
      </div>
      <div style="margin-top: 0.5em !important">
        <div class="col-md-offset-4 btn-step" id="step-1Btn">
          <a href="{{url('/contrato/logistica')}}" class="btn btn-danger">Cancelar</a>
          <input type="reset" title="Restablecer" class="btn btn-primary" onclick="previousStep('step-1','step-1')" value="Restablecer">
          <input type="button" title="Siguiente" class="btn btn-success" id="g1" value="Siguiente">
        </div>
        <div class="col-md-offset-4 btn-step" id="step-2Btn" style="display: none;">
          <a href="{{url('/contrato/logistica')}}" class="btn btn-danger">Cancelar</a>
          <input type="button" title="Cancelar" class="btn btn-primary" onclick="valCont(2,1);" value="Anterior">
          <input type="button" title="Siguiente" class="btn btn-success" id="g2" value="Crear guía">
        </div>
      </div>
  </div>
</div>

<div id="error"></div>

@endsection

@push('scripts')
    <script src="{{asset('/js/contrato/guia.js')}}"></script>
@endpush

@section('javascript')
  @parent
    loadSelectInput("#id_tienda", urlBase.make('/tienda/getSelectList'), true);
@endsection

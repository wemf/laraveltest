@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <!-- <div class="x_title"><h2>Generación de plan separe</h2>
    <div class="clearfix"></div>
  </div> -->


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



  <div class="x_content">
      <div class="circleTraza col-md-offset-3">
        <div class="circleTraza-row">
          <div class="circleTraza-step">
            <a type="button" id="st1" class="btn btn-primary btn-circle">1</a>
          </div>
          <div class="circleTraza-step">
            <a type="button" id="st2" class="btn btn-default btn-circle">2</a>
          </div>
          <div class="circleTraza-step">
            <a type="button" id="st3" class="btn btn-default btn-circle">3</a>
          </div>
        </div>
      </div>  
      <div class="alert alert-danger" style="display: none" id="alertPas">
        <h4 class="alert-heading">Información</h4>
        <p id="textAlert"></p>
      </div>
        <div class="modal-styles confirm-hide modal-cc">
            <div class="shadow" onclick="confirm.hide();"></div>
            <div class="container">
                <div class="title">
                    <h1 id="confirmtitle">Documento del Cliente</h1>
                </div>
                
                <input type="checkbox" name="chk_flip" id="chk_flip" class="hide">
                <div class="flip" style="height: 200px; margin: 10px auto;">
                    <img @if($info_cliente != null) src="{{env('RUTA_ARCHIVO_OP')}}colombia\cliente\doc_persona_natural\{{$info_cliente->ruta_foto_posterior}}" @else  src="{{asset('images/noimagen.png') }}" @endif class="flip-1" onerror="this.src='{{ asset('images/noimagen.png') }}'" height="200px">
                    <img @if($info_cliente != null) src="{{env('RUTA_ARCHIVO_OP')}}colombia\cliente\doc_persona_natural\{{$info_cliente->ruta_foto_anterior}}" @else  src="{{asset('images/noimagen.png') }}" @endif class="flip-2" onerror="this.src='{{ asset('images/noimagen.png') }}'" height="200px">
                </div>

                <div class="buttons">
                    <label for="chk_flip" type="button" class="btn btn-success"><i class="fa fa-refresh"></i> Girar</label>
                    <button id="cancelConfirm" type="button" class="btn btn-primary" onclick="confirm.hide();">Cerrar</button>
                </div>
            </div>
        </div>
      <form id="form-cliente" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }} 
      <!-- parte 1 -->
      <div id="step-1">
          <div class="x_title">
            <h2>Localización de la tienda</h2>
            <div class="clearfix"></div>
          </div>
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="pais">País <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            <select id="pais" name="pais" class="form-control col-md-7 col-xs-12 requiered" disabled data-value="{{ $pdc->id_pais }}">
                                <option value="{{ $pdc->id_pais }}">{{ $pdc->nombre_pais }}</option>
                            </select>  
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="departamento">Departamento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <select id="departamento" name="departamento" class="form-control col-md-7 col-xs-12 requiered" disabled data-value="{{ $pdc->id_departamento }}">
                                  <option value="{{ $pdc->id_departamento }}">{{ $pdc->nombre_departamento }}</option>
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="ciudad">Ciudad <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            <select id="ciudad" name="ciudad" class="form-control col-md-7 col-xs-12 requiered" disabled data-value="{{ $pdc->id_ciudad }}">
                                <option value="{{ $pdc->id_ciudad }}">{{ $pdc->nombre_ciudad }}</option>
                            </select>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="id_tienda">Tienda <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            <select id="id_tienda" name="id_tienda" class="form-control col-md-7 col-xs-12 requiered" readonly data-value="{{ $pdc->id_tienda }}">
                                <option value="{{ $pdc->id_tienda }}">{{ $pdc->nombre_tienda }}</option>
                            </select>
                          </div>
                      </div>
                  </div>          
              </div>
          </div>
          <div class="x_title">
            <h2>Información del Cliente</h2>
            <div class="btn btn-primary pull-right" onclick="$('.modal-cc').addClass('confirm-visible').removeClass('confirm-hide');">Ver Documento</div>
            <div class="clearfix"></div>
          </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="tipo_documento">Tipo de Documento <span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <select id="tipo_documento" name="tipo_documento" class="form-control col-md-7 col-xs-12 requiered resertInp" readonly>
                                    <option value="">- Seleccione una opción -</option>
                                    @foreach($tipo_documento as $tipo)
                                    <option value="{{ $tipo->id }}" @if($tipodocumento == $tipo->id) selected @endif>{{ $tipo->name }}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                    </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="numero_documento">Número de Documento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="numero_documento" id="numero_documento" type="text" class="form-control numeric requiered resertInp" value="{{ $numdocumento }}" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="pais">País residencia<span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            @if($info_cliente != null)
                                <input name="pais_residencia" id="pais_residencia" type="text" class="form-control numeric requiered resertInp" value="{{ $info_cliente->pais_residencia }}" readonly>
                            @else
                                <select id="pais_residencia" name="pais_residencia" class="form-control col-md-7 col-xs-12 resertInp" onchange='loadSelectInputByParent("#ciudad_residencia", "{{ url('/ciudad/getciudadbypais') }}", this.value, 1);'>
                                    <option value="">- Seleccione una opción -</option>
                                    @foreach($pais as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach    
                                </select>  
                            @endif
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="ciudad_residencia">Ciudad residencia <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            @if($info_cliente != null)
                                <input type="text" class="form-control numeric requiered resertInp" value="{{ $info_cliente->ciudad_residencia }}" readonly>
                                <input name="ciudad_residenciax" readonly id="ciudad_residenciax" class="cr" type="hidden" value="@if($info_cliente != null){{$info_cliente->id_ciudad_residencia}}@endif" class="form-control col-xs-12 ciudad">
                            @else
                                <select id="ciudad_residencia" name="ciudad_residencia" class="form-control col-md-7 col-xs-12 requiered resertInp">
                                    <option value="">- Seleccione una opción -</option>
                                </select> 
                            @endif
                           </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="pais_expedicion">País de Expedición <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                                @if($info_cliente != null)
                                    <input name="pais_expedicion" id="pais_expedicion" type="text" class="form-control numeric  resertInp" value="{{ $info_cliente->pais_expedicion }}" readonly>
                                @else
                                    <select id="pais_expedicion" name="pais_expedicion" class="form-control col-md-7 col-xs-12  resertInp" onchange='loadSelectInputByParent("#ciudad_expedicion", "{{ url('/ciudad/getciudadbypais') }}", this.value, 1);'>
                                        <option value="">- Seleccione una opción -</option>
                                        @foreach($pais as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach    
                                    </select>  
                                @endif
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="ciudad_nacimiento">Ciudad de expedición<span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                                @if($info_cliente != null)
                                    <input name="ciudad_expedicion" id="ciudad_expedicion" type="text" class="form-control numeric  resertInp" value="{{ $info_cliente->ciudad_expedicion }}" readonly>
                                @else
                                    <select id="ciudad_expedicion" name="ciudad_expedicion" class="form-control col-md-7 col-xs-12  resertInp">
                                        <option value="">- Seleccione una opción -</option>
                                    </select>
                                @endif    
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="fecha_expedicion">Fecha de Expedición <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="fecha_expedicion" id="fecha_expedicion" type="text" class="form-control requiered resertInp data-picker-only" @if($info_cliente != null) value="{{ $info_cliente->fecha_expedicion }}" readonly @endif>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="fecha_nacimiento">Fecha de Nacimiento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="fecha_nacimiento" id="fecha_nacimiento" type="text" class="form-control requiered resertInp data-picker-only" @if($info_cliente != null) value="{{ $info_cliente->fecha_nacimiento }}" readonly @endif>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="primer_nombre">Primer nombre <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="primer_nombre" id="primer_nombre" type="text" class="form-control requiered resertInp" @if($info_cliente != null) readonly @endif value="{{ $nombre1 }}">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="segundo_nombre">Segundo nombre</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="segundo_nombre" id="segundo_nombre" type="text" class="form-control resertInp" @if($info_cliente != null) readonly @endif value="{{ $nombre2 }}">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="primer_apellido">Primer apellido <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="primer_apellido" id="primer_apellido" type="text" class="form-control requiered resertInp" @if($info_cliente != null) value="{{ $info_cliente->primer_apellido }}" readonly @endif>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="segundo_apellido">Segundo apellido</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="segundo_apellido" id="segundo_apellido" type="text" class="form-control resertInp" @if($info_cliente != null) value="{{ $info_cliente->segundo_apellido }}" readonly @endif>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="correo">Correo electrónico <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="correo" id="correo" type="text" class="form-control requiered resertInp" @if($info_cliente != null) value="{{ $info_cliente->correo_electronico }}" @endif>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="genero">Género <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                                @if($info_cliente != null)
                                    <input type="text" name="genero" id="genero" class="form-control requiered resertInp" value="{{ $info_cliente->genero }}" readonly>
                                @else
                                    <select name="genero" id="genero" class="form-control col-xs-12 requiered resertInp" @if($info_cliente != null) disabled @endif>
                                        <option value="">- Seleccione una opción -</option>
                                        <option value="1">Masculino</option>
                                        <option value="2">Femenino</option>
                                    </select>
                                @endif
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="direccion_residencia">Dirección de Residencia <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="direccion_residencia" id="direccion_residencia" type="text" readonly class="form-control direccion requiered resertInp" data-pos="1" @if($info_cliente != null) value="{{ $info_cliente->direccion_residencia }}" @endif>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="regimen">Régimen</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            @if($info_cliente != null)
                                <input type="text" name="regimen" id="regimen" class="form-control resertInp" value="{{ $info_cliente->regimen }}" readonly>
                            @else
                              <select name="regimen" id="regimen" class="form-control col-xs-12 resertInp"></select>
                            @endif
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="telefono_residencia">Teléfono Fijo <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-7 col-xs-12"> 
                          <div class="col-md-3" style="padding:0;">
                                <input type="text" id="telefono_residencia_indicativo" name="telefono_residencia_indicativo" readonly maxlength="5" class="form-control col-md-7 col-xs-12 requiered resertInp indicativo_cliente_telefono" placeholder="">
                            </div>
                            <div class="col-md-9" style="padding:0;">
                                <input type="text" id="telefono_residencia" name="telefono_residencia" maxlength="10" class="form-control col-md-7 col-xs-12 numeric requiered resertInp" @if($info_cliente != null) value="{{ $info_cliente->telefono_residencia }}" @endif>
                            </div>
                            </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="telefono_celular">Celular <span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <div class="col-md-3" style="padding:0;">
                                    <input type="text" id="telefono_celular_indicativo" name="telefono_celular_indicativo" readonly maxlength="5" class="form-control col-md-7 col-xs-12 requiered resertInp indicativo_cliente_celular" placeholder="">
                                </div>
                                <div class="col-md-9" style="padding:0;">
                                    <input type="text" id="telefono_celular" name="telefono_celular" maxlength="10" class="form-control col-md-7 col-xs-12 numeric requiered resertInp" @if($info_cliente != null) value="{{ $info_cliente->telefono_celular }}" @endif>
                                </div>
                            </div>
                      </div>
                  </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="direccion_residencia">Cliente confiable <span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <select name="cliente_confiable" id="cliente_confiable" class="form-control col-xs-12 requiered resertInp" @if($info_cliente != null) disabled @endif>
                                    <option value="">- Seleccione una opción -</option>
                                    @foreach($confiabilidad as $con)
                                        <option value="{{ $con->id }}">{{ $con->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    @if($info_cliente != null)
                        @if($info_cliente->ruta_foto_anterior == '')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto_1" class="control-label col-md-5 col-sm-3 col-xs-12">Documento Identificación parte frontal <span class="required red">*</span></label>
                                <input type="hidden" id="hf_guardar_anterior" name="hf_guardar_anterior" value="1" />
                                <div class="col-md-7 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <input type="file" id="foto_1" name="foto_1" class="form-control col-xs-12 requerido">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <input type="hidden" id="hf_guardar_anterior" name="hf_guardar_anterior" value="0" />
                        @endif
                    @else
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto_1" class="control-label col-md-5 col-sm-3 col-xs-12">Documento Identificación parte frontal <span class="required red">*</span></label>
                                <input type="hidden" id="hf_guardar_anterior" name="hf_guardar_anterior" value="1" />
                                <div class="col-md-7 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <input type="file" id="foto_1" name="foto_1" class="form-control col-xs-12 requerido">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif




                    @if($info_cliente != null)
                        @if($info_cliente->ruta_foto_posterior == '')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foto_2" class="control-label col-md-5 col-sm-3 col-xs-12">Documento Identificación parte posterior <span class="required red">*</span></label>
                                    <input type="hidden" id="hf_guardar_posterior" name="hf_guardar_posterior" value="1" />
                                    <div class="col-md-7 col-xs-12">
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <input type="file" id="foto_2" name="foto_2" class="form-control col-xs-12 requerido">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <input type="hidden" id="hf_guardar_posterior" name="hf_guardar_posterior" value="0" />
                        @endif
                    @else
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto_2" class="control-label col-md-5 col-sm-3 col-xs-12">Documento Identificación parte posterior <span class="required red">*</span></label>
                                <input type="hidden" id="hf_guardar_posterior" name="hf_guardar_posterior" value="1" />
                                <div class="col-md-7 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <input type="file" id="foto_2" name="foto_2" class="form-control col-xs-12 requerido">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($info_cliente != null)
                        <input type="hidden" id="cliente" value="0">
                    @else
                        <input type="hidden" id="cliente" value="1">
                    @endif
                    <input type="hidden" id="codigo_cliente" @if($info_cliente != null) value="{{ $info_cliente->codigo_cliente }}" @endif>
                    <input type="hidden" id="id_tienda_cliente" @if($info_cliente != null) value="{{ $info_cliente->id_tienda }}" @else value="{{ $id_tienda }}" @endif>
                    <input type="hidden" id="x">
                    <input type="hidden" id="entrada" value="{{ $entrada }}">
                    <input type="hidden" id="id_cot">
                    <input type="hidden" id="id_tienda_cot">
              </div>
          </div>
      </div>
      <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center btn-step" id="step-1Btn">
          <a href="{{url('/generarplan/')}}" class="btn btn-danger" title="Cancelar">Cancelar</a>
          <input type="submit" title="Siguiente" class="btn btn-success" id="g1" onclick="valRequiered('step-1','step-2','step-1Btn','step-2Btn', 'st1', 'st2')" value="Siguiente">
        </div>
    </form>
    <form method="post" autocomplete="off">
        
    
        <!-- Parte 2 -->
        <div id="step-2" style="display:none;">
            <div class="x_title">
                <h2>Información de los productos</h2>
                <div class="form-group" id="div_check_prod">
                    <label for="producto" class="col-md-offset-5 col-md-1 col-sm-1 col-xs-1">Sin producto</label>
                    <div class="col-md-1 col-sm-1 col-xs-1">
                        <label class="switch_check">
                            <input type="checkbox" id="producto" name="producto" value="1"  onchange="intercaleCheck(this);" />
                            <span class="slider"></span>
                        </label>
                    </div>
                    <label for="producto" class="col-md-1 col-sm-1 col-xs-1">Con producto</label>
                </div>
                <div class="clearfix"></div>
            </div>
                
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12" id="cot" style="display:none;">
                        <label>Cotización <span class="required red">*</span></label>
                        <select name="id_cotizacion" id="id_cotizacion" class="form-control col-xs-12 resertInp">
                            <option value="">- Seleccione una opción -</option>
                            @foreach($cotizaciones as $cotizacion)
                                <option value="{{ $cotizacion->id_cotizacion }}/{{ $cotizacion->id_tienda }}">{{ $cotizacion->id_cotizacion }} - {{ $cotizacion->referencia }}</option>
                            @endforeach  
                        </select>
                    </div>
                    <div class="co-md-12 col-xs-12" id="div_referencia">
                        <label>Referencia <span class="required red">*</span></label>
                        <input  class="form-control resertInp" type="text" id="codigo_inventarioX" name="codigo_inventarioX">
                        <input type="hidden" name="codigo_plan" id="codigo_plan">
                        <input type="hidden" name="id_inventario" id="id_inventario">
                        <input type="hidden" name="id_porcentaje" id="id_porcentaje">
                        <input type="hidden" name="id_catalogo_producto" id="id_catalogo_producto"/>
                        <div class="content_buscador" style="display:none;">
                            <select name="select_codigo_inventario" id="select_codigo_inventario" size="4" class="form-control co-md-12" onclick="selectValue(this);"></select>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                        <label>Referencia</label>
                        <input  class="form-control resertInp" type="text" id="nombre_producto" readonly name="nombre_producto">
                    </div> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">
                        <label>Nombre</label>
                        <textarea name="descripcion" id="descripcion" readonly class="form-control resertInp" cols="30" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                        <label>Precio</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="moneda form-control centrar-derecha resertInp" readonly name="precio" id="precio">
                        </div>
                    </div>
                    <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                        <label>Peso</label>
                        <input class="form-control resertInp requiered" type="text" id="peso" name="peso" readonly maxlength="3">
                    </div>
                    <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center">
                        <input type="button" title="Agregar" class="btn-sg margin-btn" value="Agregar" id="addproduct" style="display:none">
                    </div>
                </div>
            </div>
            <div class="x_title"><h2>Ítems del plan separe</h2>
                <div class="clearfix"></div>
            </div>
            <div class="cont-quitar">
                <input id="btn_quitar_item" name="btn_quitar_item" type="button" class="btn btn-danger btn-lg" value="Quitar">
            </div>
            <div class="item_refac notop hidefilters">
            <table id="productosPlan" class="dataTableAction display tabla sortable" width="100%" cellspacing="0" align="center">
                <thead class="thead">
                    <tr>
                        <th></th> 
                        <th>Código inventario</th> 
                        <th>Referencia</th> 
                        <th>Nombre</th>
                        <th>Precio</th> 
                        <th>Peso / Unidades</th>
                    </tr>
                </thead> 
                <tbody class="tbody"></tbody>           
                <tfoot class="tfoot">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>TOTAL:</td>
                        <td id="total" class="moneda"></td>
                        <td></td>
                    </tr>
                </tfoot>           
            </table>
            </div>
        </div> 
      
      <!-- parte 3 -->
      <div id="step-3" style="display:none;">
        <div class="x_title"><h2>Información del plan separe</h2>
          <div class="clearfix"></div>
        </div>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Tipo de documento<span class="required red">*</span></label>
                    <select id="tipo_documento" name="tipo_documento" class="form-control col-md-7 col-xs-12 requiered resertInp" readonly>
                        <option value="">- Seleccione una opción -</option>
                        @foreach($tipo_documento as $tipo)
                        <option value="{{ $tipo->id }}" @if($tipodocumento == $tipo->id) selected @endif>{{ $tipo->name }}</option>
                        @endforeach 
                    </select>
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Número de documento<span class="required red">*</span></label>
                    <input name="numero_documento" id="numero_documento" type="text" class="form-control numeric requiered resertInp" value="{{ $numdocumento }}" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Primer nombre<span class="required red">*</span></label>
                    <input name="primer_nombre" id="primer_nombre_X" type="text" class="form-control requiered resertInp" @if($info_cliente != null) readonly @endif value="{{ $nombre1 }}">
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Segundo nombre<span class="required red">*</span></label>
                    <input name="segundo_nombre" id="segundo_nombre_X" type="text" class="form-control resertInp" @if($info_cliente != null) readonly @endif value="{{ $nombre2 }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Primer apellido<span class="required red">*</span></label>
                    <input name="primer_apellido" id="primer_apellido_X" type="text" class="form-control requiered resertInp" @if($info_cliente != null) value="{{ $info_cliente->primer_apellido }}" readonly @endif>
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Segundo apellido<span class="required red">*</span></label>
                    <input name="segundo_apellido" id="segundo_apellido_X" type="text" class="form-control resertInp" @if($info_cliente != null) value="{{ $info_cliente->segundo_apellido }}" readonly @endif>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Monto <span class="required red">*</span></label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" class="moneda form-control requiered centrar-derecha resertInp" readonly name="monto" id="monto">
                    </div>
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>% de abono<span class="required red">*</span></label>
                    <input  class="form-control numeric requiered resertInp" readonly type="text" id="porcentaje" name="porcentaje">
                </div>
                 
            </div>
        </div>
            
        <!-- FORMA DE PAGO -->
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Abono minimo <span class="required red">*</span></label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" name="abono_mayor" id="abono_mayor" class="moneda form-control requiered" readonly style="text-align: right;"/>
                    </div>
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label for="saldo_abonar_efectivo">Abono efectivo<span class="required red">*</span></label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input name="saldo_abonar_efectivo" id="efectivo" type="text" class="form-control requiered moneda" maxlength="10">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label for="saldo_abonar_credito">Abono tarjeta de crédito<span class="required red">*</span></label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input name="saldo_abonar_credito" id="credito" type="text" class="form-control requiered moneda" maxlength="10">
                    </div>
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label for="comprobante_credito">Código de aprobación <span class="required red">*</span></label>
                    <input name="comprobante_credito" id="comprobante_credito" type="text" class="form-control requiered" maxlength="10">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label for="saldo_abonar_debito">Abono tarjeta de débito<span class="required red">*</span></label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                         <input name="saldo_abonar_debito" id="debito" type="text" class="form-control requiered moneda" maxlength="10">
                    </div>
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label for="comprobante_debito">Código de aprobación <span class="required red">*</span></label>
                    <input name="comprobante_debito" id="comprobante_debito" type="text" class="form-control requiered" maxlength="10">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label for="saldo_abonar_otro">Abono otro<span class="required red">*</span></label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                         <input name="saldo_abonar_otro" id="otro" type="text" class="form-control requiered moneda" maxlength="10">
                    </div>
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label for="comprobante_otro">Código de aprobación <span class="required red">*</span></label>
                    <input name="comprobante_otro" id="comprobante_otro" type="text" class="form-control requiered" maxlength="10">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label for="observaciones">Observaciones <span class="required red">*</span></label>
                    <input type="text" class="form-control" id="observaciones" name="observaciones">
                </div>
            </div>
        </div>

        <!-- FIN FORMA DE PAGO -->

        <div class="row">
            <div class="col-md-offset-3 col-md-6">
               
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Total <span class="required red">*</span></label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" class="moneda form-control requiered centrar-derecha resertInp" name="abono" id="abono" readonly/>
                        
                    </div>
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Deuda <span class="required red">*</span></label>
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" class="moneda form-control requiered centrar-derecha resertInp" readonly name="deuda" id="deuda">
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Fecha creación plan separe <span class="required red">*</span></label>
                    <input type="text" class="form-control requiered" id="fecha_creacion" readonly name="fecha_creacion" maxlength="10" value="{{ $fecha }}">
                </div>
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Fecha límite plan separe <span class="required red">*</span></label>
                    <input type="text" class="form-control requiered" id="fecha_limite" readonly name="fecha_limite" maxlength="10">
                </div>
            </div>
        </div>

        <div class="row" id="div_fecha_entrega" style="display:none;">

            <div class="col-md-offset-3 col-md-6">
                <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                    <label>Fecha entrega <span class="required red">*</span></label>
                    <input type="text" class="form-control requiered" id="fecha_entrega" readonly name="fecha_entrega" maxlength="10" value="{{ $fecha }}">
                </div>
            </div>
        </div>
      </div>

    </form>
    
        <input type="hidden" name="codigo_tienda" id="codigo_tienda" value="{{ tienda::OnLine()->codigo_tienda }}">
        <input type="hidden" name="paso" id="paso" value="0"/>

      <div class="x_title">
        <div class="clearfix"></div>
      </div>
      <div style="margin-top: 0.5em !important">
        <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center btn-step" id="step-2Btn" style="display:none;">
          <a href="{{url('/generarplan/')}}" class="btn btn-danger" title="Cancelar">Cancelar</a>
          <input type="button" title="Anterior" class="btn btn-warning" onclick="valVolver(2,1);" value="Anterior">
          <input type="button" title="Siguiente" class="btn btn-success" id="g2" onclick="valProducto('step-2','step-3','step-2Btn','step-3Btn', 'st2', 'st3')" value="Siguiente">
        </div>
        <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center btn-step" id="step-3Btn" style="display: none;">
          <a href="{{url('/generarplan/')}}" class="btn btn-danger" title="Cancelar">Cancelar</a>
          <input type="button" title="Anterior" class="btn btn-warning" onclick="valVolver(3,2);" value="Anterior">
          <input type="button" title="Guardar" class="btn btn-success" id="g3" value="Finalizar">
        </div>
      </div>
  </div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('/js/Trasversal/Autocomplate/datalist.js')}}"></script>
    <script src="{{asset('/js/plansepare.js')}}"></script>
@endpush

@section('javascript')
  @parent
  //<script>

    loadSelectInput("#pais_residencia", "{{ url('/pais/getSelectList') }}",2); 
    loadSelectInput("#ciudad_residencia", "{{ url('/ciudad/getSelectList') }}",2);
    // loadSelectInput("#ciudad_expedicion", "{{ url('/ciudad/getSelectList') }}",2);
    loadSelectInput("#regimen", "{{url('/sociedad/getSelectListRegimen')}}",2); 
    URL.setSRC("{{ env('RUTA_ARCHIVO_OP')}}colombia/cliente/doc_persona_natural/");
    URL.setSRC2("{{asset('images/noimagen.png') }}");
    $('#regimen').val('{{ $regimen }}');
    @if($info_cliente != null)
    $('#cliente_confiable').val('{{ $info_cliente->id_confiabilidad }}');
    @endif
    fillInput('#ciudad_residenciax', '.indicativo_cliente_telefono', urlBase.make('ciudad/getinputindicativo2'));
    fillInput('#ciudad_residenciax', '.indicativo_cliente_celular', urlBase.make('ciudad/getinputindicativo'));
    
@endsection

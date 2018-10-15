@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title"><h2>Generación factura por venta directa</h2>
    <div style="display:;" id="divBtn">
        <div class="btn btn-primary pull-right" onclick="$('.modal-cc').addClass('confirm-visible').removeClass('confirm-hide');">Ver Documento</div>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="x_content"> 
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
                    <img class="flip-1" onerror="this.src='{{ asset('images/noimagen.png') }}'" height="200px">
                    <img class="flip-2" onerror="this.src='{{ asset('images/noimagen.png') }}'" height="200px">
                </div>

                <div class="buttons">
                    <label for="chk_flip" type="button" class="btn btn-success"><i class="fa fa-refresh"></i> Girar</label>
                    <button id="cancelConfirm" type="button" class="btn btn-primary" onclick="confirm.hide();">Cerrar</button>
                </div>
            </div>
        </div>
      <form id="form-cliente" method="POST" enctype="multipart/form-data" autocomplete="off">
      {{ csrf_field() }} 
      <!-- parte 1 -->
      <div id="step-1">
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="tipo_documento">Tipo de Documento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <select id="tipo_documento" name="tipo_documento" class="form-control col-md-7 col-xs-12 requiered resertInp resertInp">
                                  <option value="">- Seleccione una opción -</option>
                                  @foreach($tipo_documento as $tipo)
                                  <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                  @endforeach 
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="numero_documento">Número de Documento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="numero_documento" id="numero_documento" type="text" class="form-control numeric requiered resertInp">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="pais">País residencia<span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            <select id="pais_residencia" name="pais_residencia" class="form-control col-md-7 col-xs-12 requiered resertInp selectBloqueo"  data-value="{{ $pdc->id_pais }}" onchange='loadSelectInputByParent("#ciudad_residencia", "{{ url('/ciudad/getciudadbypais') }}", this.value, 1);'>
                                <option value="">- Seleccione una opción -</option>
                                @foreach($pais as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach    
                            </select>  
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="pais">Ciudad residencia <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            <select id="ciudad_residencia" name="ciudad_residencia" class="form-control col-md-7 col-xs-12 requiered resertInp selectBloqueo"  data-value="{{ $pdc->id_pais }}">
                                <option value="">- Seleccione una opción -</option>
                            </select>  
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="pais_expedicion">País de Expedición <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <select id="pais_expedicion" name="pais_expedicion" class="form-control col-md-7 col-xs-12 requiered resertInp selectBloqueo"  data-value="{{ $pdc->id_pais }}" onchange='loadSelectInputByParent("#ciudad_expedicion", "{{ url('/ciudad/getciudadbypais') }}", this.value, 1);'>
                                    <option value="">- Seleccione una opción -</option>
                                    @foreach($pais as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach    
                                </select>  
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="ciudad_nacimiento">Ciudad de expedición<span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                                <select id="ciudad_expedicion" name="ciudad_expedicion" class="form-control col-md-7 col-xs-12 requiered resertInp selectBloqueo"  data-value="{{ $pdc->id_pais }}">
                                    <option value="">- Seleccione una opción -</option>
                                </select>  
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="fecha_expedicion">Fecha de Expedición <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="fecha_expedicion" id="fecha_expedicion" readonly type="text" class="form-control requiered resertInp">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="fecha_nacimiento">Fecha de Nacimiento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="fecha_nacimiento" id="fecha_nacimiento" readonly type="text" class="form-control requiered resertInp">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="primer_nombre">Primer nombre <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="primer_nombre"  id="primer_nombre" type="text" class="form-control requiered resertInp inputBloqueo">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="segundo_nombre">Segundo nombre</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="segundo_nombre"  id="segundo_nombre" type="text" class="form-control resertInp inputBloqueo">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="primer_apellido">Primer apellido <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="primer_apellido" id="primer_apellido"  type="text" class="form-control requiered resertInp inputBloqueo">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="segundo_apellido">Segundo apellido</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="segundo_apellido" id="segundo_apellido"  type="text" class="form-control resertInp inputBloqueo">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="correo">Correo electrónico <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="correo" id="correo" type="text" class="form-control requiered resertInp inputBloqueo">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="genero">Género</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                                <select name="genero" id="genero" class="form-control col-xs-12 resertInp selectBloqueo">
                                    <option value="">- Seleccione una opción -</option>
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>
                                </select>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="direccion_residencia">Dirección de Residencia <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="direccion_residencia" id="direccion_residencia" type="text" class="form-control direccion requiered resertInp" data-pos="1" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="regimen">Régimen</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <select name="regimen" id="regimen" class="form-control col-xs-12 resertInp selectBloqueo"></select>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="telefono_residencia">Teléfono Fijo <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-7 col-xs-12"> 
                          <div class="col-md-3" style="padding:0;">
                                <input type="text" id="telefono_residencia_indicativo" readonly name="telefono_residencia_indicativo"  maxlength="5" class="form-control col-md-7 col-xs-12 requiered resertInp" placeholder="">
                            </div>
                            <div class="col-md-9" style="padding:0;">
                                <input type="text" id="telefono_residencia" name="telefono_residencia" maxlength="10" class="form-control col-md-7 col-xs-12 numeric requiered resertInp inputBloqueo">
                            </div>
                            </div>
                      </div>
                  </div>
                  <div class="col-md-6 bottom-20">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="telefono_celular">Celular <span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <div class="col-md-3" style="padding:0;">
                                    <input type="text" id="telefono_celular_indicativo" readonly name="telefono_celular_indicativo"  maxlength="5" class="form-control col-md-7 col-xs-12 requiered resertInp" placeholder="">
                                </div>
                                <div class="col-md-9" style="padding:0;">
                                    <input type="text" id="telefono_celular" name="telefono_celular" maxlength="10" class="form-control col-md-7 col-xs-12 numeric requiered resertInp inputBloqueo">
                                </div>
                            </div>
                      </div>
                  </div>
                                    
                  <input type="hidden" id="cliente" value="0">
                  <input type="hidden" id="codigo_cliente">
                  <input type="hidden" id="id_tienda_cliente">
                  <input type="hidden" id="lote">
              </div>
          </div>
      </div>
        <!-- Parte 2 -->
        <div id="step-2">
            <div class="x_title"><h2>Items</h2>
                <div class="clearfix"></div>
            </div>
            <div class="item_refac notop hidefilters">
            <table id="productosVenta" class="dataTableAction display tabla sortable" width="100%" cellspacing="0" align="center">
                <thead class="thead">
                    <tr>
                        <th>Código inventario</th> 
                        <th>Referencia</th> 
                        <th>Lote</th>
                        <th>Precio</th> 
                        <th>Concepto</th> 
                        <th>Iva</th>
                        <th>% descuento</th>
                        <th>valor descuento</th>
                    </tr>
                </thead> 
                <tbody class="tbody">
                    @foreach($dataProductos as $producto)
                        <tr>
                            <td>{{ $producto->codigo_inventario }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->lote }}</td>
                            <td>{{ $producto->precio_venta }}</td>
                            <td>
                                <select name="concepto" id="concepto" class="form-control requiered resertInp">
                                    <option value="">- Seleccione una opción -</option>
                                    <option value="1">concepto 1</option>
                                    <option value="2">concepto 2</option>
                                    <option value="3">concepto 3</option>
                                    <option value="4">concepto 4</option>
                                    <option value="5">concepto 5</option>
                                </select>
                            </td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    @endforeach
                </tbody>           
                <tfoot class="tfoot">
                    <tr>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table">Base IVA:</td>
                        <td class="no-border-table" id="base_iva" class="moneda">0</td>
                    </tr>
                    <tr class="no-border-table">
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table">IVA:</td>
                        <td class="no-border-table" id="iva" class="moneda">0</td>
                    </tr>
                    <tr class="no-border-table">
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table">Rentenciones:</td>
                        <td class="no-border-table" id="retenciones" class="moneda">0</td>
                    </tr>
                    <tr class="no-border-table">
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table">Impuestos:</td>
                        <td class="no-border-table" id="impuestos" class="moneda">0</td>
                    </tr>
                    <tr class="no-border-table">
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table">Subtotal:</td>
                        <td class="no-border-table" id="subtotal" class="moneda">0</td>
                    </tr>
                    <tr class="no-border-table">
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table">Toltal:</td>
                        <td class="no-border-table" id="total" class="moneda"></td>
                    </tr>
                </tfoot>           
            </table>
            </div>
        </div> 
      
      <div class="x_title">
        <div class="clearfix"></div>
      </div>
      <div style="margin-top: 0.5em !important">
        <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center btn-step" id="step-3Btn">
          <a href="{{url('/generarplan/')}}" class="btn btn-danger" title="Cancelar">Cancelar</a>
          <input type="button" title="Anterior" class="btn btn-warning" onclick="valVolver(3,2);" value="Anterior">
          <input type="button" title="Restablecer" id="rest3" class="btn btn-primary rest" onclick="previousStep('step-1','step-1')" value="Restablecer">
          <input type="button" title="Guardar" class="btn btn-success" id="g3" value="Guardar">
        </div>
      </div>
  </div>
</div>
</form>

@endsection

@push('scripts')
    <!-- <script src="{{asset('/js/venta.js')}}"></script> -->
@endpush

@section('javascript')
  @parent
  //<script>
    loadSelectInput("#tipo_documento", "{{ url('/clientes/tipodocumento/getSelectList2') }}");
    loadSelectInput("#pais_residencia", "{{ url('/pais/getSelectList') }}",2); 
    loadSelectInput("#ciudad_residencia", "{{ url('/ciudad/getSelectList') }}",2);
    loadSelectInput("#ciudad_expedicion", "{{ url('/ciudad/getSelectList') }}",2);
    loadSelectInput("#regimen", "{{url('/sociedad/getSelectListRegimen')}}",2); 
    // funcion.setSRC("{{ env('RUTA_ARCHIVO_OP')}}colombia/cliente/doc_persona_natural/");
    // funcion.setSRC2("{{asset('images/noimagen.png') }}");
    var nombres = "{{ $data->nombres }}";
        nombres = nombres.split(" ");
        primer_nombre = (nombres[0] == "") ? primer_nombre = "" : primer_nombre = nombres[0];
        segundo_nombre = (nombres[1] == "") ? segundo_nombre = "" : segundo_nombre = nombres[1];
    $('#tipo_documento').val('{{ $data->id_tipo_documento }}');
    $('#numero_documento').val('{{ $data->numero_documento }}');
    $('#pais_residencia').val('{{ $data->id_pais_residencia }}');
    $('#ciudad_residencia').val('{{ $data->id_ciudad_residencia }}');
    $('#pais_expedicion').val('{{ $data->id_pais_expedicion }}');
    $('#ciudad_expedicion').val('{{ $data->id_ciudad_expedicion }}');
    $('#fecha_expedicion').val('{{ $data->fecha_expedicion }}');
    $('#fecha_nacimiento').val('{{ $data->fecha_nacimiento }}');
    $('#primer_nombre').val(primer_nombre);
    $('#segundo_nombre').val(segundo_nombre);
    $('#primer_apellido').val('{{ $data->primer_apellido }}');
    $('#segundo_apellido').val('{{ $data->segundo_apellido }}');
    $('#correo').val('{{ $data->correo_electronico }}');
    $('#genero').val('{{ $data->genero }}');
    $('#direccion_residencia').val('{{ $data->direccion_residencia }}');
    $('#regimen').val('{{ $data->id_regimen_contributivo }}');
    $('#telefono_residencia').val('{{ $data->telefono_residencia }}');
    $('#telefono_celular').val('{{ $data->telefono_celular }}');

    fillInput('#ciudad_residencia', '#telefono_residencia_indicativo', urlBase.make('/ciudad/getinputindicativo2'));
    fillInput('#ciudad_residencia', '#telefono_celular_indicativo', urlBase.make('/ciudad/getinputindicativo'));

@endsection

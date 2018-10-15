@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title"><h2>Generación factura por venta directa</h2>
    <div style="display:;" id="divBtn">
        <div class="btn btn-primary pull-right" onclick="$('.modal-cc').addClass('confirm-visible').removeClass('confirm-hide');">Ver Documento</div>
        <div class="btn btn-primary pull-right" id="ver">Ver info</div>
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
      <form id="form-cliente" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ url('venta/facturarPlan') }}">
      {{ csrf_field() }} 
      <!-- parte 1 -->
      <div id="step-1" style="display:none">
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="tipo_documento">Tipo de Documento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                                @foreach($tipo_documento as $tipo)
                                    @if($tipo->id == $data->id_tipo_documento)
                                        <input name="tipo_documento_nombre" id="tipo_documento_nombre" type="text" class="form-control numeric requiered resertInp" value="{{ $tipo->name }}" readonly>
                                        <input name="tipo_documento" id="tipo_documento" type="hidden" class="form-control numeric requiered resertInp" value="{{ $tipo->id }}" readonly>
                                    @endif
                                @endforeach 
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="numero_documento">Número de Documento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="numero_documento" id="numero_documento" type="text" class="form-control numeric requiered resertInp" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="pais">País residencia<span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            <select id="pais_residencia" name="pais_residencia" disabled class="form-control col-md-7 col-xs-12 requiered resertInp selectBloqueo"  data-value="{{ $pdc->id_pais }}" onchange='loadSelectInputByParent("#ciudad_residencia", "{{ url('/ciudad/getciudadbypais') }}", this.value, 1);'>
                                <option value="">- Seleccione una opción -</option>
                                @foreach($pais as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach    
                            </select>  
                            
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="pais">Ciudad residencia <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            <select id="ciudad_residencia" name="ciudad_residencia" class="form-control col-md-7 col-xs-12 requiered resertInp selectBloqueo" disabled data-value="{{ $pdc->id_pais }}">
                                <option value="">- Seleccione una opción -</option>
                            </select>  
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="pais_expedicion">País de Expedición <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <select id="pais_expedicion" name="pais_expedicion" disabled class="form-control col-md-7 col-xs-12 requiered resertInp selectBloqueo"  data-value="{{ $pdc->id_pais }}" onchange='loadSelectInputByParent("#ciudad_expedicion", "{{ url('/ciudad/getciudadbypais') }}", this.value, 1);'>
                                    <option value="">- Seleccione una opción -</option>
                                    @foreach($pais as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach    
                                </select>  
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="ciudad_nacimiento">Ciudad de expedición<span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                                <select id="ciudad_expedicion" name="ciudad_expedicion" disabled class="form-control col-md-7 col-xs-12 requiered resertInp selectBloqueo"  data-value="{{ $pdc->id_pais }}">
                                    <option value="">- Seleccione una opción -</option>
                                </select>  
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="fecha_expedicion">Fecha de Expedición <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="fecha_expedicion" id="fecha_expedicion" readonly type="text" class="form-control requiered resertInp">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="fecha_nacimiento">Fecha de Nacimiento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="fecha_nacimiento" id="fecha_nacimiento" readonly type="text" class="form-control requiered resertInp">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="primer_nombre">Primer nombre <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="primer_nombre"  id="primer_nombre" type="text" class="form-control requiered resertInp inputBloqueo" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="segundo_nombre">Segundo nombre</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="segundo_nombre"  id="segundo_nombre" type="text" class="form-control resertInp inputBloqueo" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="primer_apellido">Primer apellido <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="primer_apellido" id="primer_apellido"  type="text" class="form-control requiered resertInp inputBloqueo" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="segundo_apellido">Segundo apellido</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="segundo_apellido" id="segundo_apellido"  type="text" class="form-control resertInp inputBloqueo" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="correo">Correo electrónico <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="correo" id="correo" type="text" class="form-control requiered resertInp inputBloqueo" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="genero">Género</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                                <select name="genero" id="genero" class="form-control col-xs-12 resertInp selectBloqueo" disabled>
                                    <option value="">- Seleccione una opción -</option>
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>
                                </select>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="direccion_residencia">Dirección de Residencia <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="direccion_residencia" id="direccion_residencia" type="text" readonly class="form-control requiered resertInp" data-pos="1" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="regimen">Régimen</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <select name="regimen" id="regimen" class="form-control col-xs-12 resertInp selectBloqueo" disabled></select>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="telefono_residencia">Teléfono Fijo <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-7 col-xs-12"> 
                          <div class="col-md-3" style="padding:0;">
                                <input type="text" id="telefono_residencia_indicativo" readonly name="telefono_residencia_indicativo"  maxlength="5" class="form-control col-md-7 col-xs-12 requiered resertInp" placeholder="">
                            </div>
                            <div class="col-md-9" style="padding:0;">
                                <input type="text" id="telefono_residencia" name="telefono_residencia" readonly maxlength="10" class="form-control col-md-7 col-xs-12 numeric requiered resertInp inputBloqueo">
                            </div>
                            </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="telefono_celular">Celular <span class="required red">*</span></label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <div class="col-md-3" style="padding:0;">
                                    <input type="text" id="telefono_celular_indicativo" readonly name="telefono_celular_indicativo"  maxlength="5" class="form-control col-md-7 col-xs-12 requiered resertInp" placeholder="">
                                </div>
                                <div class="col-md-9" style="padding:0;">
                                    <input type="text" id="telefono_celular" name="telefono_celular" readonly maxlength="10" class="form-control col-md-7 col-xs-12 numeric requiered resertInp inputBloqueo">
                                </div>
                            </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="numero_bolsas">Número de bolsas </label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="numero_bolsas" id="numero_bolsas" maxlength="2" type="text" class="form-control justNumbers requiered resertInp">
                          </div>
                      </div>
                  </div>
                                    
                  <input type="hidden" id="cliente" value="0">
                  <input type="hidden" id="codigo_cliente">
                  <input type="hidden" id="id_tienda_cliente">
                  <input type="hidden" name="id_tienda" id="id_tienda" value="{{ $id_tienda }}">
                  <input type="hidden" name="id_tienda_pr" id="id_tienda_pr" value="{{ $id_tienda_pr }}">
                  <input type="hidden" name="codigo_tienda" id="codigo_tienda" value="{{ tienda::OnLine()->codigo_tienda }}">
                  <input type="hidden" name="id" id="id" value="{{ $id }}">
                  <input type="hidden" id="lote">
              </div>
          </div>
      </div>
        <!-- Parte 2 -->
        <div id="step-2">
            <div class="x_title">
                <h2>Items</h2>
                <div class="btn btn-primary pull-right" id="ver_items">Ver items</div>
                <div class="clearfix"></div>
            </div>
            <div class="item_refac notop hidefilters" style="overflow-x: auto; display: ;" id="items_factura">
            <table id="productosVenta" class="dataTableAction display tabla sortable" width="100%" cellspacing="0" align="center">
                <thead class="thead">
                    <tr>
                        <th>N° ID</th> 
                        <th>Refer.</th> 
                        <!-- <th>Categoria Gnl</th>  -->
                        <!-- <th>Calidad/<br>Clasificacion</th>  -->
                        <th>Detalle                    </th> 
                        <th>Cant.</th>
                        <th>Peso</th> 
                        <th>Precio de venta        </th> 
                        <!-- <th>%Desq</th> 
                        <th>Valor desq</th>  -->
                        <th>%iva   </th>
                        <th>Valor iva     </th>
                        <th>%RetFue</th>
                        <th>Valor<br>retFuent     </th>
                        <th>%00<br>RetICA</th>
                        <th>Valor<br>reteICA     </th>
                        <th>%RetIVA</th>
                        <th>Valor<br>retIVA         </th>
                        <th>Valor<br>Total        </th>
                    </tr>
                </thead> 
                <tbody class="tbody">
                    @foreach($dataProductos as $producto)
                        <tr>
                            <td class="id_inventario_td">
                            {{ $producto->id_inventario }}
                            <input type="hidden" name="id_inventario[]" value="{{ $producto->id_inventario }}">
                            </td>
                            <td>{{ $producto->referencia }}</td>
                            <!-- <td>{{ $producto->categoria_general }}</td> -->
                            <!-- <td>{{ $producto->calidad }}</td> -->
                            <td>{{ $producto->detalle }}</td>
                            <td>{{ $producto->cantidad }}</td>
                            <td>{{ $producto->peso }}</td>
                            <td><input type="text" name="precio_venta[]" id="precio_{{ $producto->id_inventario }}" value="{{ $producto->precio }}" class="form-control money v_precio" readonly></td>
                            <!-- <td><input type="text" id="porcentaje_descuento_{{ $producto->id_inventario }}" name="porcentaje_descuento[]" maxlength="2" class="form-control" value="{{ $producto->porcentaje_descuento }}" onkeyup="calculaValores(this.value,'valor_descuento_'+{{ $producto->id_inventario }},'descuento','descuentos','{{ $producto->valor_total }}');calcular_precio();" readonly></td>
                            <td><input type="text" id="valor_descuento_{{ $producto->id_inventario }}" name="valor_descuento[]" class="form-control money descuento" value="0" readonly></td> -->
                            <td>
                                <input type="text" class="form-control" name="porcentaje_iva[]" id="porcentaje_iva_{{ $producto->id_inventario }}" value="{{ $producto->iva }}" readonly>
                            </td>
                            <td>
                                <input type="hidden" id="viva_{{ $producto->id_inventario }}" name="viva_[]" class="form-control money" value="{{ $producto->valor_iva }}" readonly>
                                <input type="text" id="valor_iva_{{ $producto->id_inventario }}" name="valor_iva[]" class="form-control money v_iva" value="{{ $producto->valor_iva }}" readonly>
                            </td>
                            <td class="porcentaje_rete_td">
                                <input type="text" class="form-control" name="porcentaje_retefuente[]" maxlength="2" id="porcentaje_retefuente_{{ $producto->id_inventario }}" onkeyup="calculaValores(this.value,'valor_retefuente_'+{{ $producto->id_inventario }},'v_retefuente','v_retefuente','{{ $producto->precio }}','{{ $producto->id_inventario }}');calcular_precio_retfuente();">
                            </td>
                            <td><input type="text" id="valor_retefuente_{{ $producto->id_inventario }}" name="valor_retefuente[]" class="form-control money v_retefuente" value="0" readonly></td>
                            <td class="porcentaje_ica_td">
                                <input type="text" class="form-control" name="porcentaje_renteica[]" maxlength="2" id="porcentaje_renteica_{{ $producto->id_inventario }}" value="0" onkeyup="calculaValoresICA(this.value,'valor_renteica_'+{{ $producto->id_inventario }},'v_reteica','v_reteica','{{ $producto->precio }}','{{ $producto->id_inventario }}');calcular_precio_retica();">
                            </td>
                            <td><input type="text" id="valor_renteica_{{ $producto->id_inventario }}" name="valor_renteica[]" class="form-control money v_reteica" value="0" readonly></td>
                            <td class="porcentaje_retiva_td">
                                <input type="text" class="form-control" name="porcentaje_renteiva[]" maxlength="2" id="porcentaje_renteiva_{{ $producto->id_inventario }}" value="0" onkeyup="calculaValoresRetIVA(this.value,'valor_renteiva_'+{{ $producto->id_inventario }},'v_reteiva','v_reteiva','valor_iva_{{ $producto->id_inventario }}','{{ $producto->id_inventario }}');calcular_precio_retiva();">
                            <td><input type="text" id="valor_renteiva_{{ $producto->id_inventario }}" name="valor_renteiva[]" class="form-control money v_reteiva" value="0" readonly></td>
                           <td>
                                {{ $producto->valor_total }}
                                <input type="hidden" name="valor_total_producto[]" id="valor_total_{{ $producto->id_inventario }}" value="{{ $producto->valor_total }}">
                           </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="tfoot">
                    <tr>
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td>
                        <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table" colspan="2">Valor bruto:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="valor_bruto" id="valor_bruto" value="{{ $valor_bruto }}" class="form-control money" readonly></td>
                    </tr>
                    <tr>
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td>
                        <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table" colspan="2">Descuentos:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="descuentos" id="descuentos" value="0" class="form-control money" readonly></td>
                    </tr>
                    <tr class="no-border-table">
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td>
                        <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table" colspan="2">Subtotal:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="subtotal" id="subtotal" value="{{ $subtotal }}" class="form-control money" readonly></td>
                    </tr>
                    <tr class="no-border-table">
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td>
                        <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table" colspan="2">Base IVA:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="base_iva" id="base_iva" value="{{ $subtotal }}" class="form-control money" readonly></td>
                    </tr>
                    <tr class="no-border-table">
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td>
                        <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table" colspan="2">Valor IVA:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="v_iva" id="v_iva" value="{{ $impuestos }}" class="form-control money" readonly></td>
                    </tr>
                    <tr class="no-border-table">
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td>
                        <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table" colspan="2">Valor Retefuente:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="v_retefuente" id="v_retefuente" value="0" class="form-control money" readonly></td>
                    </tr>
                    <tr class="no-border-table">
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td>
                        <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table" colspan="2">Valor ReteICA:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="v_reteica" id="v_reteica" value="0" class="form-control money" readonly></td>
                    </tr>
                    <tr class="no-border-table">
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td>
                        <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table" colspan="2">Valor ReteIVA:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="v_reteiva" id="v_reteiva" value="0" class="form-control money" readonly></td>
                    </tr>
                    <tr class="no-border-table">
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td>
                        <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table" colspan="2">Valor impuesto al consumo:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="v_impuesto_consumo" id="v_impuesto_consumo" value="0" class="form-control money" readonly></td>
                    </tr>
                    
                    <tr class="no-border-table">
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td>
                        <td class="no-border-table"></td> -->
                        <!-- <td class="no-border-table"></td> -->
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table"></td>
                        <td class="no-border-table" colspan="2">Total:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="total" id="total" value="{{ $total }}" class="form-control money" readonly></td>
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
            <input type="hidden" name="subt" id="subt" value="{{ $subtotal }}">
            <a href="{{url('/generarplan/')}}" class="btn btn-danger" title="Cancelar">Cancelar</a>
            <input type="submit" title="facturar" class="btn btn-success" id="facturar" value="Facturar">
        </div>
      </div>
  </div>
</div>
</form>

@endsection

@push('scripts')
    <script src="{{asset('/js/venta.js')}}"></script>
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
    $('.flip-1').attr('src', '{{ env('RUTA_ARCHIVO_OP').'colombia/cliente/doc_persona_natural/'.$data->anterior }}');
    $('.flip-2').attr('src', '{{ env('RUTA_ARCHIVO_OP').'colombia/cliente/doc_persona_natural/'.$data->posterior }}');

    fillInput('#ciudad_residencia', '#telefono_residencia_indicativo', urlBase.make('/ciudad/getinputindicativo2'));
    fillInput('#ciudad_residencia', '#telefono_celular_indicativo', urlBase.make('/ciudad/getinputindicativo'));
    $(document).ready(function(){
        $('#ver').click(function(){
            $('#step-1').toggle('slow');
        })
        $('#ver_items').click(function(){
            $('#items_factura').toggle('slow');
        })
    })

@endsection

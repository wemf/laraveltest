@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title"><h2>Generación factura por venta directa</h2>
    <div style="display:none;" id="divBtn">
        <div class="btn btn-primary pull-right" onclick="$('.modal-cc').addClass('confirm-visible').removeClass('confirm-hide');">Ver Documento</div>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="x_content"> 
      <div class="alert alert-danger" style="display:none" id="alertPas">
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
      <form id="form-cliente" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ url('ventas/createDirecta') }}">
      {{ csrf_field() }} 
      <!-- parte 1 -->
      <div id="step-1">
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="col-md-6">
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
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="numero_documento">Número de Documento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="numero_documento" id="numero_documento" type="text" class="form-control numeric requiered resertInp">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
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
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="pais">Ciudad residencia <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                            <select id="ciudad_residencia" name="ciudad_residencia" class="form-control col-md-7 col-xs-12 requiered resertInp selectBloqueo"  data-value="{{ $pdc->id_pais }}">
                                <option value="">- Seleccione una opción -</option>
                            </select>  
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
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
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="ciudad_nacimiento">Ciudad de expedición<span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                                <select id="ciudad_expedicion" name="ciudad_expedicion" class="form-control col-md-7 col-xs-12 requiered resertInp selectBloqueo"  data-value="{{ $pdc->id_pais }}">
                                    <option value="">- Seleccione una opción -</option>
                                </select>  
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="fecha_expedicion">Fecha de Expedición <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="fecha_expedicion" id="fecha_expedicion" readonly type="text" class="form-control requiered resertInp data-picker-only">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="fecha_nacimiento">Fecha de Nacimiento <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="fecha_nacimiento" id="fecha_nacimiento" readonly type="text" class="form-control requiered resertInp data-picker-only">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="primer_nombre">Primer nombre <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="primer_nombre"  id="primer_nombre" type="text" class="form-control requiered resertInp inputBloqueo">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="segundo_nombre">Segundo nombre</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="segundo_nombre"  id="segundo_nombre" type="text" class="form-control resertInp inputBloqueo">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="primer_apellido">Primer apellido <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="primer_apellido" id="primer_apellido"  type="text" class="form-control requiered resertInp inputBloqueo">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="segundo_apellido">Segundo apellido</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="segundo_apellido" id="segundo_apellido"  type="text" class="form-control resertInp inputBloqueo">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="correo">Correo electrónico <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="correo" id="correo" type="text" class="form-control requiered resertInp inputBloqueo">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
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
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="direccion_residencia">Dirección de Residencia <span class="required red">*</span></label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input name="direccion_residencia" id="direccion_residencia" type="text" class="form-control direccion requiered resertInp no-color-read" data-pos="1" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-5 col-sm-3 col-xs-12" for="regimen">Régimen</label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <select name="regimen" id="regimen" class="form-control col-xs-12 resertInp selectBloqueo"></select>
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
                                <input type="text" id="telefono_residencia" name="telefono_residencia" maxlength="10" class="form-control col-md-7 col-xs-12 numeric requiered resertInp inputBloqueo">
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
                                    <input type="text" id="telefono_celular" name="telefono_celular" maxlength="10" class="form-control col-md-7 col-xs-12 numeric requiered resertInp inputBloqueo">
                                </div>
                            </div>
                      </div>
                  </div>
                    <div class="col-md-6 docs">
                        <div class="form-group">
                            <label for="foto_1" class="control-label col-md-5 col-sm-3 col-xs-12">Documento Identificación parte frontal <span class="required red">*</span></label>
                            <input type="hidden" id="hf_guardar_anterior" name="hf_guardar_anterior" value="1" />
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <input type="file" id="foto_1" name="foto_1" class="form-control col-xs-12">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 docs">
                        <div class="form-group">
                            <label for="foto_2" class="control-label col-md-5 col-sm-3 col-xs-12">Documento Identificación parte posterior <span class="required red">*</span></label>
                            <input type="hidden" id="hf_guardar_posterior" name="hf_guardar_posterior" value="1" />
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <input type="file" id="foto_2" name="foto_2" class="form-control col-xs-12">
                            </div>
                        </div>
                    </div>
                  
                  <input type="hidden" id="cliente" name="cliente" value="0">
                  <input type="hidden" id="codigo_cliente" name="codigo_cliente">
                  <input type="hidden" id="id_tienda" name="id_tienda">
                  <input type="hidden" id="lote" name="lote">
                  <input type="hidden" id="iva" name="iva" value="0">
                  <input type="hidden" id="porcentaje_descuento" name="porcentaje_descuento" value="0">
                  <input type="hidden" id="valor_descuento" name="valor_descuento" value="0">
              </div>
          </div>
      </div>
        <!-- Parte 2 -->
        <div id="step-2">
            <div class="x_title"><h2>Información de los productos</h2>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">
                        <label>Referencia <span class="required red">*</span></label>
                        <input  class="form-control resertInp" type="text" id="referencia" name="referencia">
                        <input type="hidden" name="codigo_plan" id="codigo_plan">
                        <input type="hidden" name="id_inventario" id="id_inventario">
                        <div class="content_buscador" style="display:none;">
                            <select name="select_codigo_inventario" id="select_codigo_inventario" size="4" class="form-control co-md-12" onclick="selectValue(this);"></select>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                        <label>Referencia</label>
                        <input  class="form-control resertInp" type="text" id="nombre_producto"  name="nombre_producto">
                    </div> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12">
                        <label>Nombre</label>
                        <textarea name="descripcion" id="descripcion"  class="form-control resertInp" cols="30" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                        <label>Precio</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="moneda form-control centrar-derecha resertInp"  name="precio" id="precio">
                        </div>
                    </div>
                    <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                        <label>Peso</label>
                        <input type="text" class="form-control resertInp"  name="peso" id="peso">
                    </div>
                    <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center">
                        <input type="button" title="Agregar" class="btn-sg margin-btn" value="Agregar" id="addproduct" style="display:none">
                    </div>
                </div>
            </div>
            <div class="x_title"><h2>Items</h2>
                <div class="clearfix"></div>
            </div>
            <div class="cont-quitar">
                <input id="btn_quitar_item" name="btn_quitar_item" type="button" class="btn btn-danger btn-lg" value="Quitar">
            </div>
            <div class="item_refac notop hidefilters">
            <table id="productosVentaDirecta" class="dataTableAction display tabla sortable" width="100%" cellspacing="0" align="center">
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
                        <th>%RetICA</th>
                        <th>Valor<br>renteICA     </th>
                        <th>%RetIVA</th>
                        <th>Valor<br>retIVA         </th>
                        <th>Valor<br>Total        </th>
                    </tr>
                </thead> 
                <tbody class="tbody"></tbody>           
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
                        <td class="no-border-table" colspan="3"><input type="text" name="valor_bruto" id="valor_bruto" value="0" class="form-control money" readonly></td>
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
                        <td class="no-border-table" colspan="3"><input type="text" name="subtotal" id="subtotal" value="0" class="form-control money" readonly></td>
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
                        <td class="no-border-table" colspan="3"><input type="text" name="base_iva" id="base_iva" value="0" class="form-control money" readonly></td>
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
                        <td class="no-border-table" colspan="3"><input type="text" name="v_iva" id="v_iva" value="0" class="form-control money" readonly></td>
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
                        <td class="no-border-table" colspan="2">Valor Rentefuente:</td>
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
                        <td class="no-border-table" colspan="2">Valor RenteICA:</td>
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
                        <td class="no-border-table" colspan="2">Valor RenteIVA:</td>
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
                        <td class="no-border-table" colspan="2">Toltal:</td>
                        <td class="no-border-table" colspan="3"><input type="text" name="total" id="total" value="0" class="form-control money" readonly></td>
                    </tr>
                </tfoot>        
            </table>
            </div>
        </div> 
        <!-- <input type="hidden" name="arr_i_venta" id="arr_i_venta" value=""> -->
        <div id="arr_venta">

        </div>
      
      <div class="x_title">
        <div class="clearfix"></div>
      </div>
      <div style="margin-top: 0.5em !important">
        <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center btn-step" id="step-3Btn">
          <a href="{{url('/ventas')}}" class="btn btn-danger" title="Cancelar">Cancelar</a>
          <input type="submit" title="Generar" class="btn btn-success" id="g3" value="Generar">
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
    funcion.setSRC("{{ env('RUTA_ARCHIVO_OP')}}colombia/cliente/doc_persona_natural/");
    funcion.setSRC2("{{asset('images/noimagen.png') }}");
    $('#regimen').val(2);
@endsection

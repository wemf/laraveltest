@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title"><h2>Ingreso de compra</h2>
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
        
        <form id="form-cliente" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ url('compras/createDirecta') }}">
        {{ csrf_field() }} 
        <!-- parte 1 -->
        <div id="step-1">
            <div class="row">
                <div class="col-md-10">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="tipo_documento">Tipo de Documento <span class="required red">*</span></label>
                            <select id="tipo_documento" name="tipo_documento" class="form-control col-md-7 col-xs-12 requiered resertInp">
                                <option value="">- Seleccione una opción -</option>
                                @foreach($tipo_documento as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="numero_documento">Número de Documento <span class="required red">*</span></label>
                                <div class="col-md-12" id="ndoc" style="padding:0;">
                                    <input name="numero_documento" id="numero_documento" type="text" class="form-control numeric requiered ">
                                    <input type="hidden" name="id_proveedor" id="id_proveedor">
                                    <input type="hidden" name="id_tienda_proveedor" id="id_tienda_proveedor">
                                </div>
                                <div class="col-md-3" id="div_digito" style="padding:0;display:none;">
                                    <input type="text" id="digito" name="digito_verificacion" class="form-control nit-val" maxlength = '1'>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="pais">Nombre <span class="required red">*</span></label>
                            <input name="nombre" id="nombre" type="text" class="form-control clear" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="pais">Sucursal <span class="required red">*</span></label>
                            <input name="sucursal" id="sucursal" type="text" class="form-control clear" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="direccion">Dirección <span class="required red">*</span></label>
                            <input name="direccion" id="direccion" type="text" class="form-control clear" data-pos="1" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="regimen">Régimen <span class="required red">*</span></label>
                            <input name="regimen" id="regimen" type="text" class="form-control clear" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="telefono">Teléfono <span class="required red">*</span></label> 
                            <div class="col-md-3" style="padding:0;">
                                <input type="text" id="telefono_indicativo" readonly name="telefono_indicativo"  maxlength="5" class="form-control col-md-7 col-xs-12 requiered clear" placeholder="">
                            </div>
                            <div class="col-md-9" style="padding:0;">
                                <input type="text" id="telefono" name="telefono" maxlength="10" class="form-control clear" readonly>
                            </div>
                        </div>
                    </div>
                    
                    
                    <input type="hidden" id="id_ciudad" name="id_ciudad" class="clear">
                    <input type="hidden" id="id_categoria" name="id_categoria">
                    <input type="hidden" id="iva" name="iva" value="0">
                    <input type="hidden" id="porcentaje_descuento" name="porcentaje_descuento" value="0">
                    <input type="hidden" id="valor_descuento" name="valor_descuento" value="0">
                    <input type="hidden" id="id_cliente" name="id_cliente">
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Referencia <span class="required red">*</span></label>
                            <input  class="form-control resertInp" type="text" id="referencia" name="referencia">
                            <input type="hidden" name="codigo_plan" id="codigo_plan">
                            <input type="hidden" name="id_inventario" id="id_inventario">
                            <div class="content_buscador" style="display:none;">
                                <select name="select_codigo_inventario" id="select_codigo_inventario" size="4" class="form-control col-md-12" onclick="selectValue(this);"></select>
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nombre</label>
                            <textarea name="descripcion" id="descripcion"  class="form-control resertInp" cols="30" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-3 col-md-6">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Costo</label>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" name="costo" id="costo" class="moneda form-control centrar-derecha resertInp">
                            </div>
                        </div>
                        <div class="col-lg-6 co-md-6 col-sm-6 col-xs-12">
                            <label>Precio</label>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" name="precio" id="precio" class="moneda form-control centrar-derecha resertInp">
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <div class="col-lg-6 co-md-6 col-sm-12 col-xs-12">
                                <label>Cantidad</label>
                                <input type="text" name="cantidad" id="cantidad" class="form-control resertInp justNumbers">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
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
                <table id="productosVenta" class="dataTableAction display tabla sortable" width="100%" cellspacing="0" align="center">
                    <thead class="thead">
                        <tr>
                            <th>Referencia</th> 
                            <th>Descripción</th>
                            <th>Costo</th> 
                            <th>Precio</th> 
                            <th>Cantidad</th> 
                            <th>Iva</th>
                            <th>Valor iva</th>
                            <th>% descuento</th>
                            <th>Valor<br>descuento</th>
                            <th>Subtotal</th>
                            <th>Valor total</th>
                        </tr>
                    </thead> 
                    <tbody class="tbody"></tbody>           
                    <tfoot class="tfoot">
                        <tr class="no-border-table">
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table">Valor Bruto:</td>
                            <td class="no-border-table" id="valor_bruto" class="moneda"></td>
                        </tr>
                        <tr class="no-border-table">
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table">Descuentos:</td>
                            <td class="no-border-table" id="descuento" class="moneda"></td>
                        </tr>
                        <tr class="no-border-table">
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table">Subtotal:</td>
                            <td class="no-border-table" id="subtotal" class="moneda"></td>
                        </tr>
                        <tr class="no-border-table">
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table">Base Iva:</td>
                            <td class="no-border-table" id="iva" class="moneda"></td>
                        </tr>
                        <tr class="no-border-table">
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table">Valor Iva:</td>
                            <td class="no-border-table" id="valor_iva" class="moneda"></td>
                        </tr>
                        <tr class="no-border-table">
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table">Valor Retefuente:</td>
                            <td class="no-border-table" id="valor_refuente" class="moneda"></td>
                        </tr>
                        <tr class="no-border-table">
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table">Valor ReteICA:</td>
                            <td class="no-border-table" id="valor_rete_ica" class="moneda"></td>
                        </tr>
                        <tr class="no-border-table">
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table">Valor ReteIVA:</td>
                            <td class="no-border-table" id="valor_rete_iva" class="moneda"></td>
                        </tr>
                        <tr class="no-border-table">
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table">Valor impuesto<br>al consumo:</td>
                            <td class="no-border-table" id="valor_impuesto_consumo" class="moneda"></td>
                        </tr>
                        <tr class="no-border-table">
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table"></td>
                            <td class="no-border-table">Total:</td>
                            <td class="no-border-table" id="total" class="moneda"></td>
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center btn-step" id="step-3Btn">
            <a href="{{url('/compras')}}" class="btn btn-danger" title="Cancelar">Cancelar</a>
            <input type="submit" title="Generar" class="btn btn-success" id="g3" value="Generar">
            </div>
        </div>
    </div>
</div>
</form>

@endsection

@push('scripts')
    <script src="{{asset('/js/compra.js')}}"></script>
@endpush

@section('javascript')
  @parent
  //<script>
    loadSelectInput("#tipo_documento", "{{ url('clientes/tipodocumento/getTipoDocumentoProveedor') }}");
    // $('#regimen').val(2);
@endsection

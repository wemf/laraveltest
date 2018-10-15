@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="x_panel">
    <div class="x_title">
        <h2>Ingresar Inventario</h2>
        <div class="clearfix"></div>
    </div>
    <form id="formInventario" action="{{ url('/inventario/nuevo') }}" method="POST">
        {{ csrf_field() }}  
        <div class="row">
            @include('FormMotor/message') 
            <details open>
                <summary>Detalle Tienda</summary>
                <div class="container-summary">
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="tienda">País
                                <span class="required">*</span>
                            </label>
                            <select class="column_filter form-control " id="pais" onchange="loadSelectInputByParent('#departamento', '{{url('/departamento/getdepartamentobypais')}}', this.value, 1);"
                            oninvalid="isDetailsRequiered(this);" required></select>
                        </div>
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="tienda">Departamento
                                <span class="required">*</span>
                            </label>
                            <select class="column_filter form-control " id="departamento" onchange="loadSelectInputByParent('#ciudad', '{{url('/ciudad/getciudadbydepartamento')}}', this.value, 1)"
                            oninvalid="isDetailsRequiered(this);"  required></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="tienda">Ciudad
                                <span class="required">*</span>
                            </label>
                            <select class="column_filter form-control " id="ciudad" onchange="loadSelectInputByParent('#tienda', '{{url('/tienda/gettiendabyzona2')}}', this.value, 1)"
                            oninvalid="isDetailsRequiered(this);"  required></select>
                        </div>
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="tienda">Tienda
                                <span class="required">*</span>
                            </label>
                            <select id="tienda" class="form-control" oninvalid="isDetailsRequiered(this);" name="producto[id_tienda_inventario]" required>
                                <option> - Seleccione una opción - </option>
                            </select>
                        </div>
                    </div>
                </div>
            </details>
            <details>
                <summary>Detalle del producto</summary>
                <div class="container-summary ">
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="origen">Origen
                                <span class="required">*</span>
                            </label>
                            <select id="origen" class="form-control" oninvalid="isDetailsRequiered(this);" name="producto[origen]" required>
                                <option> - Seleccione una opción - </option>
                                <option value="1"> Ingreso por plan separe </option>
                                <option value="2"> Ingreso por orden de compra </option>
                            </select>
                        </div>
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="ajax">Referencia
                                <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <input id="ajax" type="text" list="json-datalist" placeholder="Buscar refencia" class="form-control  centrar-derecha datalist-load"
                                    data-ajax-url="{{ url('bucar/referencia') }}" onkeyup="autoCompletateAction.run(this);" oninvalid="isDetailsRequiered(this);" 
                                    required>
                                <span class="input-group-addon btn btn-info">
                                    <i class="fa fa-search"></i>
                                </span>
                                <datalist id="json-datalist"></datalist>
                            </div>
                            <input type="hidden" id="id_referencia-name" name="producto[id_catalogo_producto]">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="categoriaGeneral">Categoría General
                                <span class="required">*</span>
                            </label>
                            <select id="categoriaGeneral" class="form-control" oninvalid="isDetailsRequiered(this);" readonly required>
                                <option> - Seleccione una opción - </option>
                            </select>
                        </div>
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="descripcion">Descripción
                            </label>
                            <textarea id="descripcion" class="form-control" disabled></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="precioVenta">Precio de venta
                                <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="simbolo_tipo_moneda input-group-addon">$</span>
                                <input id="precioVenta" type="text" class="moneda form-control  centrar-derecha" oninvalid="isDetailsRequiered(this);" name="producto[precio_venta]" required>
                            </div>
                        </div>
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="precioCompra">Precio de compra
                                <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="simbolo_tipo_moneda input-group-addon">$</span>
                                <input id="precioCompra" type="text" class="moneda  form-control centrar-derecha" oninvalid="isDetailsRequiered(this);" name="producto[precio_compra]" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="costoTotal">Costo total
                                <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="simbolo_tipo_moneda input-group-addon">$</span>
                                <input id="costoTotal" type="text" class="moneda form-control  centrar-derecha" oninvalid="isDetailsRequiered(this);" name="producto[costo_total]" required>
                            </div>
                        </div>
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="peso">Peso
                            </label>
                            <input id="peso" class="form-control" maxlength="50" oninvalid="isDetailsRequiered(this);" name="producto[peso]">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="cantidad">Cantidad
                            </label>
                            <input id="cantidad" class="form-control" value="1" min="1" max="1000" name="producto[cantidad]">
                        </div>
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label class="no-margin">Estado del producto:</label>
                            <div align="left">
                                <div>
                                    <input type="radio" id="lbl_nuevo" name="producto[es_nuevo]" class="column_filter radio-control check-pos" value="1" />
                                    <label for="lbl_nuevo" class="lbl-radio-control"> <span>Nuevo</span></label>
                                </div>

                                <div>
                                    <input type="radio" id="lbl_usado" name="producto[es_nuevo]" class="column_filter radio-control check-pos" value="0" />
                                    <label for="lbl_usado" class="lbl-radio-control"> <span>Usado</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </details>
            <details>
                <summary>Detalle de la compra</summary>
                <div class="container-summary">
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="lote">Lote
                                <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <input id="lote" type="text" maxlength="100" placeholder="Validar existencia del lote" class="form-control centrar-derecha"
                                   onchange="validatedLoteAction(this);" oninvalid="isDetailsRequiered(this);" name="producto[lote]" required>
                                <span class="input-group-addon btn btn-info">
                                    <i class="fa fa-exclamation-triangle"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12  fechaCompra padding-acordeon">
                            <label for="fechaCompra">Fecha Compra
                                <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input id="fechaCompra" type="text" class="form-control data-picker-only" oninvalid="isDetailsRequiered(this);" name="compra[fecha_compra]" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="devolucionCompra">Cantidad de devoluciones
                            </label>
                            <input id="devolucionCompra" class="form-control" type="number" value="0" min="0" max="1000" oninvalid="isDetailsRequiered(this);" name="compra[devolucion_compra]">
                        </div>
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="devolucionCosto">Costo de devoluciones
                            </label>
                            <div class="input-group">
                                <span class="simbolo_tipo_moneda input-group-addon">$</span>
                                <input id="devolucionCosto" type="text" class="moneda form-control centrar-derecha" oninvalid="isDetailsRequiered(this);" name="compra[costo_devolucion]">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="costoCompra">Costo de la compra
                                <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="simbolo_tipo_moneda input-group-addon">$</span>
                                <input id="costoCompra" type="text" class="moneda form-control  centrar-derecha" oninvalid="isDetailsRequiered(this);" name="compra[costo_compra]" required>
                            </div>
                        </div>
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="transladoEntrada">Número de translado entrante
                            </label>
                            <input id="transladoEntrada" class="form-control" type="number" value="0" min="0" max="1000" oninvalid="isDetailsRequiered(this);" name="compra[traslado_entrada]">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="transladoEntradaCosto">Costo de translado entrante
                            </label>
                            <div class="input-group">
                                <span class="simbolo_tipo_moneda input-group-addon">$</span>
                                <input id="transladoEntradaCosto" type="text" class="moneda form-control centrar-derecha" oninvalid="isDetailsRequiered(this);" name="compra[costo_traslado_entrada]">
                            </div>
                        </div>
                        <div class="col-md-6  col-xs-12 padding-acordeon">
                            <label for="compra">Cantidad comprada
                                <span class="required">*</span>
                            </label>
                            <input id="compra" class="form-control " type="number" value="1" min="1" max="1000" oninvalid="isDetailsRequiered(this);" name="compra[compra]" required>
                        </div>
                    </div>
                </div>
            </details>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
          <div class="center">
            <button type="submit" class="btn btn-success">Guardar</button>
            <button class="btn btn-primary" type="reset">Restablecer</button>
            <a href="{{ url('/inventario') }}" class="btn btn-danger" type="button">Cancelar</a>
          </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/Trasversal/Autocomplate/datalist.js')}}"></script>
    <script src="{{asset('/js/Inventario/create.js')}}"></script>
@endpush
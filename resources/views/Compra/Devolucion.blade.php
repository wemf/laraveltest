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

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Devolción</h4>
            </div>
            <div class="modal-body">
                <div class="row" >
                  <div class="items_contrato_tmp notop">
                      <table class="display" width="100%" cellspacing="0" id="table_devolucion">
                          <thead>
                                <tr>             
                                    <th>Tienda</th>
                                    <th>Lote</th> 
                                    <th>Referencia</th>
                                    <th>Costo</th>
                                    <th>Precio</th>
                                    <th>Fecha de compra</th>
                                </tr>
                            </thead>
                            <tbody></tbody>   
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="devolver">Devolver</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
        
        <form id="form-cliente" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ url('compras/createDirecta') }}">
        {{ csrf_field() }} 
        <!-- parte 1 -->
        <div id="step-1">
            <div class="row">
                <div class="col-md-10">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="tipo_documento">Tipo de Documento <span class="required red">*</span></label>
                            <input name="tipo_documento" id="tipo_documento" type="text" class="form-control numeric requiered " readonly value="{{ $datos[0]->tipo_documento }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="numero_documento">Número de Documento <span class="required red">*</span></label>
                                <div class="col-md-12" id="ndoc" style="padding:0;">
                                    <input name="numero_documento" id="numero_documento" type="text" class="form-control numeric requiered " readonly value="{{ $datos[0]->numero_documento }}">
                                </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="pais">Nombre <span class="required red">*</span></label>
                            <input name="nombre" id="nombre" type="text" class="form-control clear" readonly value="{{ $datos[0]->nombre }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="pais">Sucursal <span class="required red">*</span></label>
                            <input name="sucursal" id="sucursal" type="text" class="form-control clear" readonly value="{{ $datos[0]->sucursal }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="direccion">Dirección <span class="required red">*</span></label>
                            <input name="direccion" id="direccion" type="text" class="form-control clear" data-pos="1" readonly value="{{ $datos[0]->direccion }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="regimen">Régimen <span class="required red">*</span></label>
                            <input name="regimen" id="regimen" type="text" class="form-control clear" readonly value="{{ $datos[0]->regimen }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-3 col-xs-12" for="telefono">Teléfono <span class="required red">*</span></label> 
                            <div class="col-md-3" style="padding:0;">
                                <input type="text" id="telefono_indicativo" readonly name="telefono_indicativo"  maxlength="5" class="form-control col-md-7 col-xs-12 requiered clear" value="{{ $datos[0]->indicativo }}">
                            </div>
                            <div class="col-md-9" style="padding:0;">
                                <input type="text" id="telefono" name="telefono" maxlength="10" class="form-control clear" readonly value="{{ $datos[0]->telefono }}">
                            </div>
                        </div>
                    </div>
                    
                    
                    <input type="hidden" id="id_ciudad" name="id_ciudad" class="clear">
                    <input type="hidden" id="id_categoria" name="id_categoria">
                    <input type="hidden" id="iva" name="iva" value="0">
                    <input type="hidden" id="porcentaje_descuento" name="porcentaje_descuento" value="0">
                    <input type="hidden" id="valor_descuento" name="valor_descuento" value="0">
                </div>
            </div>
        </div>
            <!-- Parte 2 -->
            <div id="step-2">
                <div class="x_title"><h2>Items</h2>
                    <div class="cont-quitar_x">
                        <input id="btn_quitar_item" name="btn_quitar_item" type="button" class="btn btn-danger btn-lg" value="Quitar">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="item_refac notop hidefilters">
                <table id="dataTableAction" class="dataTableAction display tabla sortable" width="100%" cellspacing="0" align="center">
                    <thead class="thead">
                        <tr>               
                            <th><input type="checkbox" id="checkAll" name="checkAll" value="1" class="check_all" onclick="checksDevolucionAll(this);"></th> 
                            <th>Tienda</th> 
                            <th>Lote</th> 
                            <th>Referencia</th>
                            <th>Costo</th>
                            <th>Precio</th>
                            <th>Fecha de compra</th>
                        </tr>
                    </thead> 
                    <tbody class="tbody">
                        @foreach($datos as $dato)
                            <tr>               
                                <td><input type="checkbox" id="checks[]" name="checks[]" class="check-select" value="{{ $dato->id_inventario }}/{{$dato->id_tienda_inventario}}"></td> 
                                <td>{{$dato->tienda}}</td> 
                                <td>{{$dato->lote}}</td> 
                                <td>{{$dato->referencia}}</td>
                                <td>{{$dato->costo_compra}}</td>
                                <td>{{$dato->precio_compra}}</td>
                                <td>{{$dato->fecha_compra}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div> 
            <div id="arr_venta"></div>
        
        <div class="x_title">
            <div class="clearfix"></div>
        </div>
        <div style="margin-top: 0.5em !important">
            <div class="col-lg-12 co-md-12 col-sm-12 col-xs-12 text-center btn-step" id="step-3Btn">
            <a href="{{url('/compras')}}" class="btn btn-danger" title="Cancelar">Volver</a>
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
  
    $('.dataTableAction').DataTable({
        language: 
        {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
        },
    });
@endsection

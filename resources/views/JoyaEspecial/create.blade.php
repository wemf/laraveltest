@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ordenes de Joya Especial</h2>
        <div class="clearfix"></div>
      </div>

       <!-- Modal -->
       <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 67%;">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Recuperar contrato</h4>
            </div>
            <div class="modal-body">
              <table class="table table-hover">
                <thead>
                  <th>Número de inventario</th>
                  <th>Número de orden</th>
                  <th>Número de cotrato</th>
                  <th>Tienda</th>
                  <th>Estado</th>
                </thead>
                <tbody></tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="confirmar">Aceptar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal -->
      
      <div class="x_content" id="cont_fran">
        <br />
       {{-- <form id="form_refaccion" method="POST" class="form-horizontal form-label-left" action="javascript:void(0)"> --}}
        <form id="form_refaccion" method="POST" class="form-horizontal form-label-left" action="{{ url('/contrato/joyaespecial/procesar') }}">
            {{ csrf_field() }}  
            @include('FormMotor/message')
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Número de orden</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input maxlength="25" type="text" id="numero_orden" name="numero_orden" readOnly class="form-control col-md-7 col-xs-12" value="{{ $id }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"># hoja de trabajo</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input maxlength="25" type="text" id="hoja_trabajo" name="hoja_trabajo" readOnly class="form-control col-md-7 col-xs-12" value="@if(isset($items[0]->id_hoja_trabajo)){{ $items[0]->id_hoja_trabajo }}@endif">
              </div>
            </div>

          </div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Categoria general</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
              
                <input maxlength="25" type="text" id="categoria_general" name="categoria_general" readOnly class="form-control col-md-7 col-xs-12" value="@if(isset($items[0]->categoria)){{ $items[0]->categoria }}@endif">
              </div>
            </div>
          </div> 
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Subdividir</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="subdividir" name="subdividir"  onchange="intercaleCheck(this);"  value="0">
                  <span class="slider"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group" style="display:none" id="cont-selectAll">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label class="col-md-12 col-sm-12 col-xs-12" for="last-name">Seleccionar todos</label>
              <div class="col-md-5 col-sm-5 col-xs-12">
                <select name="selectAll" id="selectAll" class="form-control">
                  <option value=""> Seleccione opción </option>
                  @foreach($procesos as $pro)
                    <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="cont-quitar">
            <input id="btn-quitar" name="btn-quitar" type="button" class="btn btn-danger btn-lg" data-toggle="modal" value="Quitar">
          </div>
          
          <div class="item_refac notop hidefilters">
          <table class="table table-hover dataTableAction display">
            <thead>
              <th class="subdividir">Llevar a:</th>
              <th> </th>
              <th>Nro. Contrato</th>
              <th>Tienda de Contrato</th>
              <th>Fecha ingreso</th>
              <th>Numero de Id</th>
              <th>Atributos</th>
              <th>Descripción</th>
              <th>Peso total</th>
              <th>Peso estimado</th>
              <th>Peso taller</th>
              <th>Valor compra item</th>
              <th>Valor total contrato</th>
              <th>Cantidad bolsa seguiridad</th>
              <th>Cantidad</th>
              <th>Nit Destinatario</th>
            </thead>
            <tbody>
              @foreach($items as $item)
                <tr id="{{ $item->id_tienda_inventario }}-{{ $item->id_inventario }}-{{ $item->contrato }}">
                  <td class="subdividir col-md-2" style="display:none">
                    <input type="hidden" name="id_item[]" value="{{ $item->id_item }}">
                    <input type="hidden" name="id_inventario[]" value="{{ $item->id_inventario }}">
                    <input type="hidden" name="id_orden[]" value="{{ $item->id_orden }}">
                    <input type="hidden" name="id_tienda_orden[]" value="{{ $item->id_tienda_orden }}">
                    <select name="subdivision[]" id="subdivision_{{ $item->id_orden }}" class="form-control select-sub">
                      <option value=""> Seleccione opción </option>
                      @foreach($procesos as $pro)
                        <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td class="input-table"><button type="button" class="btn btn-primary" onclick="reclasificarItem('{{ $item->tienda_contrato }}', '{{ $item->id_inventario }}');">Reclasificar</button> </td>
                  <td name="contrato[]">{{ $item->contrato }}</td>                  
                  <td name="tienda_contrato[]">{{ $item->tienda_contrato }}</td>
                  <td name="fecha_creacion[]">{{ $item->fecha }}</td>
                  <td name="id_inventario[]">{{ $item->id_inventario }}</td>
                  <td name="atributo[]">{{ $item->atributo }}</td>
                  <td name="descripcion[]">{{ $item->descripcion }}</td>
                  <td name="peso_total[]">{{ $item->peso_total }}</td>
                  <td name="peso_estimado[]">{{ $item->peso_estimado }}</td>
                  <td>
                    <input type="text" name="peso_taller[]" id="peso_taller[]" class="form-control requiered" value="{{ $item->peso_taller }}">
                  </td>
                  <td name="precio_ingresado[]">{{ $item->precio_ingresado }}</td>
                  <td name="suma_contrato[]">{{ $item->Suma_contrato }}</td>
                  <td name="bolsas[]">{{ $item->Bolsas }}</td>
                  <td>1</td>
                  <td name="destinatario[]">{{ $item->destinatario }}</td>                  
                </tr>
              @endforeach  
            </tbody>
          </table>
          </div>

          <div class="items_dest" style="display:none"> 
            <table class= "table_destinatario display">
              <thead>
                <th>Proceso</th>
                <th>Destinatario</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Sucursal</th>
                <th class="hide"></th>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
  
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <input type="hidden" name="procesar" id="procesar" value="1">
              <input type="hidden" id="pros" name="pros" value="joyaespecial">
              <input id="btn-procesar" name="btn-procesar" class="btn btn-success" type="submit" value="Procesar">
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/contrato/joyaespecial') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>

        </form>
      </div>
    </div>
</div>
</div>

<div id="res"></div>
@endsection

@push('scripts')
  <script src="{{ asset('/js/OrdenResolucion/vitrina.js') }}"></script>
    <script src="{{asset('/js/references.js')}}"></script>
@endpush

@section('javascript')   
  @parent
    URL.setUrlIndex("{{ url('/products/references') }}");
    URL.setUrlGetCategory("{{ url('/products/categories/getCategory') }}");
    URL.setUrlAttributeCategoryById("{{ url('/products/categories/getFirstAttributeCategoryById') }}");
    URL.setUrlAttributeAttributesById("{{ url('/products/attributes/getAttributeAttributesById') }}");
    $('.dataTableAction').DataTable({
      language: 
      {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
        },
    });

@endsection

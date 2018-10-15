@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<form id="frm_reporte_pdf" class="hide" method="POST" action="{{ url('contrato/refaccion/generatepdf') }}">
    {{ csrf_field() }}
    <input type="hidden" id="id_orden" name="id_orden" value="{{ $id }}" />
    <input type="hidden" id="id_tienda_orden" name="id_tienda_orden" value="{{ $tienda }}" />
</form>

<div id="modal_rename_reference" class="big-modal">
  <div class="shadow"></div>
  <div class="container-big-modal col-md-4 col-md-offset-4">
    <div class="head-big-modal">
      Reclasificar Ítem
    </div>
    <div class="body-big-modal">
      <form id="form-references" action="javascript:void(0)" class="form-horizontal form-label-left">
        {{ csrf_field() }}  
        @include('FormMotor/message') 

        <div class="selects">
        </div>

        <input type="hidden" name="id" id="id" value=>
          
        <div class="ln_solid"></div>
        <div class="form-group">
          <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
            <button type="submit" onclick="reclasificarItemPost();" class="btn btn-success">Guardar</button>
            <button class="btn btn-primary" type="reset">Restablecer</button>
            <a href="#" onclick="hideModal();" class="btn btn-danger" type="button">Cancelar</a>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="font-size: 20px !important;">Generar reportes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <button type="button" title="Generar reporte PDF" id="btn_certificado_mineria_pdf_create" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i> Certificado de minería (PDF)</button>
        <button type="button" title="Generar reporte PDF" id="btn_reporte_pdf_create" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Reporte (PDF)</button>
        <a title="Generar reporte Excel" id="btn_reporte_excel_create" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Reporte (Excel)</a>
        <a title="Generar Excel" id="btn_stikers_excel_create" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Stikers (Excel)</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="var_id_tienda">
<input type="hidden" id="var_id_inventario">
<input type="hidden" id="var_codigo_contrato">
<input type="hidden" id="var_id_linea_item">

<div class="row">
  <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Ordenes de Vitrina</h2>
          <button type="button" class="btn btn-warning" style="float: right;" data-toggle="modal" data-target="#exampleModal">Generar reportes</button>
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
        {{-- <form id="from_proceso" method="POST" class="form-horizontal form-label-left" action="javascript:void(0)"> --}}
          <form id="from_proceso" method="POST" class="form-horizontal form-label-left" action="{{ url('/contrato/vitrina/procesar') }}">
              {{ csrf_field() }}  
              @include('FormMotor/message')
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Número de orden</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input maxlength="25" type="text" id="numero_orden" name="numero_orden" readOnly class="form-control col-md-7 col-xs-12" value="{{ $id }}">
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fecha de la orden</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input maxlength="25" type="text" id="fecha_orden" name="fecha_orden" readOnly class="form-control col-md-7 col-xs-12" value="@if(isset($items[0]->fecha_creacion)) {{ $items[0]->fecha_creacion }} @endif">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Categoria general</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input maxlength="25" type="text" id="categoria_general" name="categoria_general" readOnly class="form-control col-md-7 col-xs-12" value="@if(isset($items[0]->categoria)){{ $items[0]->categoria }}@endif">
                        <input type="hidden" id="id_categoria" value="@if(isset($items[0]->id_categoria)){{ $items[0]->id_categoria }}@endif">
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fecha de perfeccionamiento</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input maxlength="25" type="text" id="" name="" readOnly class="form-control col-md-7 col-xs-12" value="@if(isset($items[0]->fecha_perfeccionamiento)){{ $items[0]->fecha_perfeccionamiento }}@endif">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Número de orden de perfeccionamiento</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input maxlength="25" type="text" id="" name="" readOnly class="form-control col-md-7 col-xs-12" value="@if(isset($items[0]->numero_perfeccionamiento)){{ $items[0]->numero_perfeccionamiento }}@endif">
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"># hoja de trabajo</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input maxlength="25" type="text" id="hoja_trabajo" name="hoja_trabajo" readOnly class="form-control col-md-7 col-xs-12" value="@if(isset($items[0]->id_hoja_trabajo)){{ $items[0]->id_hoja_trabajo }}@endif">
                    </div>
                </div>
            </div>
            <div class="row hide">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Subdividir</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <label class="switch_check">
                            <input type="checkbox" id="subdividir" name="subdividir"  onchange="intercaleCheck(this);"  value="0">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="row" style="display:none" id="cont-selectAll">
              <div class="col-md-6 col-sm-6 col-xs-6">
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

            <!-- <div class="cont-quitar">
              <input id="btn-quitar" name="btn-quitar" type="button" class="btn btn-danger btn-lg" data-toggle="modal" value="Quitar" @if($ver == 1) disabled @endif>
            </div> -->
            
            
            <div class="item_refac notop hidefilters">
            <table class="table table-hover display dataTableAction" id="dataTableAction">
              <thead>
                <th class="subdividir" style="display:none">Llevar a:                               </th>
                <th> </th>
                <th>Reclasi.</th>
                <th># Contrato</th>
                <th>Joyeria</th>
                <th>Fecha ingreso contrato             </th>
                <th>Id</th>
                <th>Atributos</th>
                <th>Descripción</th>
                <th>Peso total</th>
                <th>Peso estimado</th>
                <th>Peso joyería</th>
                <th>Peso taller</th>
                <th>Peso final</th>
                <th>Valor ID</th>
                <th>Valor total contrato</th>
                <th>Codigo bolsa<br>seguridad</th>
                <th>Cantidad</th>
                <th>Nit Destinatario</th>
              </thead>
              <tbody>
                @foreach($items as $item)
                  <tr id="{{ $item->id_tienda_inventario }}-{{ $item->id_inventario }}-{{ $item->contrato }}">
                    <td class="subdividir col-md-2 input-table" style="display:none">
                      <input type="hidden" name="id_item[]" value="{{ $item->id_inventario }}">
                      <input type="hidden" name="id_orden[]" id="id_orden[]" value="{{ $item->id_orden }}">
                      <input type="hidden" name="id_tienda_orden[]" value="{{ $item->id_tienda_orden }}">
                      <input type="hidden" name="contrato[]" value="{{ $item->contrato }}"/>
                      <input type="hidden" name="tienda_contrato[]" value="{{ $item->tienda_contrato }}"/>
                      <input type="hidden" name="fecha_creacion[]" value="{{ $item->fecha }}"/>
                      <input type="hidden" name="id_inventario[]" value="{{ $item->id_inventario }}"/>
                      <input type="hidden" name="descripcion[]" value="{{ $item->descripcion }}"/>
                      <input type="hidden" name="peso_total[]" value="{{ $item->peso_total }}"/>
                      <input type="hidden" name="peso_estimado[]" value="{{ $item->peso_estimado }}"/>
                      <input type="hidden" name="peso_joyeria[]" value="{{ $item->peso_joyeria }}"/>
                      <input type="hidden" name="peso_taller[]" value="{{ $item->peso_taller }}"/>
                      <input type="hidden" name="precio_ingresado[]" value="{{ $item->precio_ingresado }}"/>
                      <input type="hidden" name="suma_contrato[]" value="{{ $item->Suma_contrato }}"/>
                      <input type="hidden" name="bolsas[]" value="{{ $item->Bolsas }}"/>
                      <input type="hidden" name="destinatario[]" value="{{ $item->destinatario }}"/>
                      <input type="hidden" name="atributo[]" value="{{ $item->atributo }}"/>
                      <input type="hidden" class="id_tienda_inventario" value="{{ $item->id_tienda_inventario }}">
                      <select name="subdivision[]" id="subdivision_{{ $item->id_orden }}" class="form-control select-sub input-table">
                        <option value=""> Seleccione opción </option>
                        @foreach($procesos as $pro)
                          <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td class="input-table">
                      @if(Auth::user()->role->id == env('ROLE_JEFE_ZONA'))
                        <button type="button" id="reclass" class="btn btn-primary" onclick="reclasificarItemJZ('{{ $item->tienda_contrato }}', '{{ $item->contrato }}', '{{ $item->id_inventario }}', {{ $item->id_linea_item_contrato }});" @if($ver == 1 || Auth::user()->role->id == env('ROLE_JEFE_ZONA') ) disabled @endif>Reclasificar</button>
                      @else
                        <button type="button" class="btn btn-primary" onclick="reclasificarItem('{{ $item->tienda_contrato }}', '{{ $item->contrato }}', '{{ $item->id_inventario }}', {{ $item->id_linea_item_contrato }});" @if($ver == 1 || Auth::user()->role->id == env('ROLE_JEFE_ZONA') ) disabled @endif>Reclasificar</button>
                      @endif
                    </td>
                    <td id="estado-reclasificacion-{{ $item->id_inventario }}" class="input-table" align="center">
                      <div class="content-val-reclasificado">
                        <input class="val-reclasificado" type="hidden" @if($item->id_catalogo_producto == null) value="0" @else value="1"  @endif />
                        <i @if($item->id_catalogo_producto == null) class="fa fa-times" style="color: red;" @else class="fa fa-check" style="color: green;" @endif></i>
                      </div>
                    </td>
                    <td>{{ $item->contrato }}</td>                  
                    <td>{{ $item->nombre_tienda }}</td>
                    <td>{{ $item->fecha }}</td>
                    <td class="id_inventario">{{ $item->id_inventario }}</td>
                    <td id="nombre-inventario-{{ $item->id_inventario }}">{{ $item->atributo }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->peso_total }}</td>
                    <td>{{ $item->peso_estimado }}</td>
                    <td>{{ $item->peso_joyeria }}</td>
                    <td>{{ $item->peso_taller }}</td>
                    <td class="input-table">
                      <input type="text" name="peso_libre[]" id="peso_libre[]" class="form-control validate-required peso_libre" value="{{ $item->peso }}" @if($ver == 1) readonly @endif>
                    </td>
                    <td>{{ $item->precio_ingresado }}</td>
                    <td>{{ $item->Suma_contrato }}</td>
                    <td>{{ $item->cod_bolsas_seguridad }}</td>
                    <td>1</td>
                    <td>{{ $item->destinatario }}</td>                  
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
                <input type="hidden" id="pros" name="pros" value="vitrina">
                <input type="hidden" id="anterior" name="anterior" value="{{ $anterior }}">
                <input type="hidden" id="id_remitente" value="{{ $id_remitente }}" />
                <input type="submit" name="btn-procesar-orden" value="btn-procesar-orden" class="btn-procesar-orden" style="display:none">
                <input type="hidden" id="id_tienda_ordenes" value="@if (isset($items[0]->id_tienda_orden)) {{ $items[0]->id_tienda_orden }} @endif" />
                  @if(Auth::user()->role->id == env('ROL_ADMINISTRADOR_JOYERIA') )   
                    <input id="btn-procesar" name="btn-procesar" class="btn btn-success" type="button" value="Procesar" @if($ver == 1) disabled @endif>
                    <input id="btn-rechazar" name="btn-rechazar" class="btn btn-warning" type="button" value="Rechazar" @if($ver == 1) disabled @endif>
                  @elseif(Auth::user()->role->id == env('ROLE_JEFE_ZONA') ) 
                    <input id="btn-solicitar-procesarJZ" name="btn-solicitar-procesarJZ" class="btn btn-success hide" type="button" value="Solicitar Procesamiento" @if($ver == 1) disabled @endif>
                    <input id="btn-aceptarJZ" name="btn-aceptarJZ" class="btn btn-success" type="button" value="Aceptar" @if($ver == 1) disabled @endif>
                    <input id="btn-rechazarJZ" name="btn-rechazarJZ" class="btn btn-warning" type="button" value="Rechazar" @if($ver == 1) disabled @endif>
                  @else
                    <input id="btn-solicitar-procesar" name="btn-solicitar-procesar" class="btn btn-success" type="button" value="Solicitar Procesamiento" @if($ver == 1) disabled @endif>
                  @endif
                <input id="btn-guardar" name="btn-guardar" class="btn btn-info" type="button" value="Guardar" @if($ver == 1) disabled @endif>
                <button class="btn btn-primary" type="reset">Restablecer</button>
                <a href="{{ url('/contrato/vitrina') }}" class="btn btn-danger" type="button">Cancelar</a>
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
  <script src="{{ asset('/js/OrdenResolucion/totales.js') }}"></script>
@endpush

@section('javascript')   
  @parent
    URL.setUrlIndex("{{ url('/products/references') }}");
    URL.setUrlGetCategory("{{ url('/products/categories/getCategory') }}");
    URL.setUrlAttributeCategoryById("{{ url('/products/categories/getFirstAttributeCategoryById') }}");
    URL.setUrlAttributeAttributesById("{{ url('/products/attributes/getAttributeAttributesById') }}");
    $('#dataTableAction').DataTable({
      language: 
      {
        url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
      },
      scrollX: true,
      scrollY: true,
      scrollY: 500,
      scrollCollapse: true,
      paging: false,
      "fnDrawCallback": function( oSettings ) {
            $('#dataTableAction tbody td:not(.input-table)').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
          
          $(window).resize();
      },
      "fixedColumns": true,
    });
    ESTADOS.setProcesado({{ env('ORDEN_PROCESADA') }}); 

    function hideModal(){
      $('#modal_rename_reference').hide();
    }
    function showModal(){
      $('#modal_rename_reference').show();
    }
@endsection

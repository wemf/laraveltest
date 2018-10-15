@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Ordenes de Maquila Nacional</h2>
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
				<form id="from_proceso" method="POST" class="form-horizontal form-label-left" action="{{ url('/contrato/maquilanacional/procesar') }}">
						{{ csrf_field() }}  
						@include('FormMotor/message')

					<div class="row">
						<div class="col-md-3">
							<label>Número de la orden</label>
							<input maxlength="25" type="text" id="numero_orden" name="numero_orden" readOnly class="form-control" value="{{ $id }}">
						</div>

						<div class="col-md-3">
							<label>Fecha de la orden</label>
							<input maxlength="25" type="text" id="numero_orden" name="numero_orden" readOnly class="form-control" value="@if(isset($items[0]->fecha_creacion)){{ date('d-m-Y', strtotime($items[0]->fecha_creacion)) }}@endif">
						</div>

						<div class="col-md-3">
							<label>Categoría general</label>
							<input maxlength="25" type="text" id="categoria_general" name="categoria_general" readOnly class="form-control" value="@if(isset($items[0]->categoria)){{ $items[0]->categoria }}@endif">
						</div>

						<div class="col-md-3">
							<label>Fecha de perfeccionamiento</label>
							<input maxlength="25" type="text" id="categoria_general" name="categoria_general" readOnly class="form-control" value="@if(isset($datos_perfeccionamiento->fecha_creacion)){{ $datos_perfeccionamiento->fecha_creacion }}@endif">
						</div>

						<div class="col-md-3">
							<label>Número de orden de perfeccionamiento</label>
							<input maxlength="25" type="text" id="categoria_general" name="categoria_general" readOnly class="form-control" value="@if(isset($datos_perfeccionamiento->id_orden)){{ $datos_perfeccionamiento->id_orden }}@endif">
						</div>

						<div class="col-md-4">
								<label for="last-name">Subdividir</label><br>
								<label class="switch_check">
									<input type="checkbox" id="subdividir" name="subdividir"  onchange="intercaleCheck(this);"  value="0">
									<span class="slider"></span>
								</label>
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
					<table class="table table-hover dataTableAction display tabla-resolucion">
						<thead>
							<th class="subdividir">Llevar a:                           </th>
							<th>Nro. Contrato</th>
							<th>Joyería</th>
							<th>Fecha del contrato</th>
							<th>Número ID</th>
							@foreach($columnas_items as $columna_item)
							<th class="bold" align="center">{{ $columna_item->nombre }}</th>
							@endforeach
							<th>Atributos</th>
							<th>Descripción</th>
							<th>Peso total</th>
							<th>Peso estimado</th>
							<th>Peso libre</th>
							<th>Valor ID</th>
							<th>Valor total contrato</th>
							<th>Cantidad ID</th>
							<th>Bolsas de seguridad</th>
						</thead>
						<tbody>
							@foreach($items as $item)
							<tr id="{{ $item->id_tienda_inventario }}-{{ $item->id_inventario }}-{{ $item->id_contrato }}-{{ $item->id_orden }}">
									<td class="subdividir col-md-2 input-table" style="display:none">
											<input type="hidden" name="id_item[]" value="{{ $item->id_item }}">
											<input type="hidden" name="id_inventario[]" value="{{ $item->id_inventario }}">
											<input type="hidden" name="id_tienda_inventario[]" value="{{ $item->id_tienda_inventario }}">
											<input type="hidden"  name="contrato[]" value="{{ $item->id_contrato }}" />
											<input type="hidden"  name="tienda_contrato[]" value="{{ $item->tienda_contrato }}" />
											<input type="hidden"  name="fecha_creacion[]" value="{{ $item->fecha_creacion }}" />
											<input type="hidden"  name="atributo[]" value="{{ $item->nombre }}" />
											<input type="hidden"  name="descripcion[]" value="{{ $item->observaciones }}" />
											<input type="hidden"  name="peso_total[]" value="{{ $item->peso_total_noformat }}" />
											<input type="hidden"  name="peso_estimado[]" value="{{ $item->peso_estimado_noformat }}" />
											<input type="hidden" name="precio_ingresado[]" id="precio_ingresado[]" value="{{ $item->precio_ingresado_noformat }}">
											<input type="hidden"  name="suma_contrato[]" value="{{ $item->Suma_contrato }}" />
											<input type="hidden"  name="bolsas[]" value="{{ $item->Bolsas }}" />
											<select name="subdivision[]" value="6" id="subdivision_{{ $item->id_orden }}" class="form-control select-sub" @if($item->abre_bolsa == 1) required @endif>
													<option value=""> Seleccione opción </option>
													@foreach($procesos as $pro)
													<option  @if($item->abre_bolsa == 1 && $item->id_proceso == $pro->id ) selected  @else @if($item->abre_bolsa == 0 && $pro->id == 6) selected @endif @endif value="{{ $pro->id }}">{{ $pro->name }}</option>
													@endforeach
											</select>
									</td>

									<td>{{ $item->id_contrato }}</td>
									<td>{{ $item->nombre_tienda_contrato }}</td>
									<td>{{ date('d-m-Y', strtotime($item->fecha_creacion)) }}</td>
									<td>{{ $item->id_inventario }}</td>
									@for($i = 0; $i < count($columnas_items); $i++)
											<input type="hidden" value="{{ $col_print = 0 }}" />
											@for($j = 0; $j < count($datos_columnas_items); $j++)
													@if($columnas_items[$i]->nombre == $datos_columnas_items[$j]->atributo && $datos_columnas_items[$j]->linea_item == $item->linea_item)
													<td>{{$datos_columnas_items[$j]->valor}} <input type="hidden" value="{{ $col_print = 1 }}" /></td>
													@endif
											@endfor
											@if($col_print == 0)
													<td></td>
											@endif
									@endfor
									<td>{{ $item->nombre }}</td>
									<td>{{ $item->observaciones }}</td>
									<td>{{ $item->peso_total }}</td>
									<td>{{ $item->peso_estimado }}</td>
									<td class="input-table">
											<input type="number" step="0.01" name="peso_taller[]" id="peso_taller[]" class="form-control requiered peso_taller_input validate-required" value="{{ $item->peso_libre }}" step=".01" required>
									</td>
									<td>{{ $item->precio_ingresado }}</td>
									<td>{{ $item->Suma_contrato }}</td>
									<td>1</td>
									<td>{{ $item->Bolsas }}</td>
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
							<input type="hidden" id="pros" name="pros" value="maquilanacional">
							<input id="btn-procesar" name="btn-procesar" class="btn btn-success" type="button" value="Procesar">
							<button class="btn btn-primary" type="reset">Restablecer</button>
							<a href="{{ url('/contrato/maquilanacional') }}" class="btn btn-danger" type="button">Cancelar</a>
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
	<script src="{{ asset('/js/OrdenResolucion/maquilanacionalcreate.js') }}"></script>
@endpush

@section('javascript')   
	@parent
		$('.dataTableAction').DataTable({
			language: 
			{
				url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",					
			},
			scrollX: true,
			scrollCollapse: true,
			"pageLength": 1000,
			scrollY: 400,
			"fnDrawCallback": function( oSettings ) {
					$('.dataTableAction tbody td:not(.input-table)').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
					$(window).resize(); 
			},
			"fixedColumns": true,
		});
		$('.dataTableAction tbody').on('click', 'tr', function() {
				if ($(this).hasClass('selected')) {
						$(this).removeClass('selected');
				} else {
						var table = $('.dataTableAction').DataTable();
						table.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
				}
		});
		ESTADOS.setProcesado({{ env('ORDEN_PROCESADA') }}); 
@endsection

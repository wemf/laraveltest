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
				<form id="from_proceso" method="POST" class="form-horizontal form-label-left" action="{{ url('/contrato/maquilanacional/transformacionglobal/procesar') }}">
						{{ csrf_field() }}  
						@include('FormMotor/message')

					<div class="row">
						<div class="col-md-3">
							<label for="numero_orden">Número de la orden</label>
							<input maxlength="25" type="text" id="numero_orden" name="numero_orden" readOnly class="form-control" value="{{ $id }}">
                            <input type="hidden" id="id_tienda_orden" name="id_tienda_orden" value="{{ $id_tienda_orden }}" />
						</div>

						<div class="col-md-3">
							<label for="fecha_orden">Fecha de la orden</label>
							<input maxlength="25" type="text" id="fecha_orden" name="fecha_orden" readOnly class="form-control" value="@if(isset($items[0]->fecha_creacion)){{ date('d-m-Y', strtotime($items[0]->fecha_creacion)) }}@endif">
						</div>

						<div class="col-md-3">
							<label for="categoria_general">Categoría general</label>
							<input maxlength="25" type="text" id="categoria_general" name="categoria_general" readOnly class="form-control" value="@if(isset($items[0]->categoria)){{ $items[0]->categoria }}@endif">
						</div>

						<div class="col-md-3">
							<label for="fecha_perfeccionamiento">Fecha de perfeccionamiento</label>
							<input maxlength="25" type="text" id="fecha_perfeccionamiento" name="fecha_perfeccionamiento" readOnly class="form-control" value="@if(isset($datos_perfeccionamiento->fecha_creacion)){{ $datos_perfeccionamiento->fecha_creacion }}@endif">
						</div>

						<div class="col-md-3">
							<label for="orden_perfeccionamiento">Número de orden de perfeccionamiento</label>
							<input maxlength="25" type="text" id="orden_perfeccionamiento" name="orden_perfeccionamiento" readOnly class="form-control" value="@if(isset($datos_perfeccionamiento->id_orden)){{ $datos_perfeccionamiento->id_orden }}@endif">
						</div>

                        <div class="col-md-3">
							<label for="text_porcentaje_tolerancia">Porcetaje de tolerancia</label>
							<input maxlength="25" type="text" id="text_porcentaje_tolerancia" name="text_porcentaje_tolerancia" readOnly class="form-control" value="{{ $porcentaje_tolerancia }}%">
                            <input type="hidden" id="val_porcentaje_tolerancia" name="val_porcentaje_tolerancia" value="{{ $porcentaje_tolerancia }}" />
						</div>
                        
                        <div class="col-md-3">
							<label for="total_gramos_transformacion">Total de gramos de la transformación</label>
							<input maxlength="25" type="text" id="total_gramos_transformacion" name="total_gramos_transformacion" class="form-control" value="" step="0.01" required>
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
                    <br><br>
					
                    <div class="row">
                        <div class="col-md-12">
						    <input id="btn-agregar-linea" name="btn-agregar-linea" onclick="transformacion.agregarLinea();" type="button" class="btn btn-primary" data-toggle="modal" value="Agregar linea">
                        </div>
					</div>

					<div class="item_refac notop hidefilters">
					<table class="table table-hover display tabla-resolucion">
						<thead>
							<th>Referencia</th>
							<th>Atributos                                    </th>
							<th>Talla/Medida</th>
							<th>Cantidad</th>
							<th>Peso total</th>
                            <th></th>
						</thead>
						<tbody>
							<tr>
                                <td class="col-md-2 input-table">
                                    <select onchange="transformacion.cargarDatosReferencia(this);" name="referencia[]" class="form-control transf-referencia" required>
                                        <option value=""> Seleccione opción </option>  
                                        @foreach($referencias as $referencia)
                                            <option value="{{ $referencia->id }}">{{ $referencia->nombre }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="input-table">
                                    <label class="transf-atributos"></label>
                                </td>
                                <td class="input-table">
                                    <label class="transf-talla-medida"></label>
                                </td>
                                <td class="input-table">
                                    <input type="number" step="0" name="transf_cantidad[]" onkeyup="transformacion.calcularTotales();" class="form-control transf-cantidad" required>
                                </td>
                                <td class="input-table">
                                    <input type="number" step="0.01" name="transf_peso_total[]" onkeyup="transformacion.calcularTotales();" class="form-control transf-peso-total" required>
                                </td>
                                <td class="input-table">
                                    <input type="button" onclick="transformacion.borrarReferencia(this);" class="btn btn-danger btn-remove" value="Borrar">
                                </td>
                            </tr>
						</tbody>
                        <tfoot>
                            <tr>
                                <td class="col-md-2 input-table">
                                   
                                </td>

                                <td class="input-table">
                                    
                                </td>
                                <td class="input-table">
                                    Totales
                                </td>
                                <td class="input-table">
                                    <label name="transf_total_cantidad[]" class="transf-total-cantidad">0</label>
                                </td>
                                <td class="input-table">
                                    <label name="transf_peso_total[]" class="transf-total-peso-total">0,00</label>
                                </td>
                                <td class="input-table">
                                    
                                </td>
                            </tr>
                        </tfoot>
					</table>
					</div>

					
	
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
							<input type="hidden" name="procesar" id="procesar" value="1">
							<input type="hidden" id="pros" name="pros" value="maquilanacional">
							<input id="" onclick="transformacion.validarPesos();" name="" class="btn btn-success" type="button" value="Procesar">
							<input id="btn-procesar" name="btn-procesar" class="btn btn-success hide" type="submit" value="Procesar">
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

<style>
    .dataTables_paginate, .dataTables_info{
        display: none;
    }
</style>
@endsection

@push('scripts')
	<script src="{{ asset('/js/OrdenResolucion/maquilanacionalcreate.js') }}"></script>
	<script src="{{ asset('/js/OrdenResolucion/maquilanacional/transformacion.js') }}"></script>
@endpush

@section('javascript')   
	@parent
		$('.tabla-resolucion').DataTable({
			language: 
			{
				url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",					
			},
			scrollX: true,
			scrollCollapse: true,
			"pageLength": 1000,
			scrollY: 400,
			"fnDrawCallback": function( oSettings ) {
					$('.tabla-resolucion tbody td:not(.input-table)').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
					$(window).resize(); 
			},
			"fixedColumns": true,
		});
		ESTADOS.setProcesado({{ env('ORDEN_PROCESADA') }}); 
@endsection

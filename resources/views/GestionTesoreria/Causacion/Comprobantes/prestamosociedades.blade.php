<div class="row  pagonomina hidenomodify">	
	<div class="x_title"><h2>Registrar Pr&eacute;stamo entre sociedades</h2><div class="clearfix"></div></div>
	<div class="clearfix"></div>

	<div>
		<div class="form-group">

			<label class="control-label col-md-1 col-sm-1 col-xs-12" for="id_concepto_nomina">Concepto <span class="required">*</span>
			</label>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<select id="id_concepto_nomina" name="id_concepto_nomina" class="form-control requieredsalario">
                    <option value="">- Seleccione una opción -</option>              
                </select>
				<div class="row conceptoexiste hide">
            		<span class="col-xs-12 col-md-12" style="color:red">Concepto ya registrado</span>
            	</div>
			</div>
			<label class="control-label col-md-2 col-sm-2 col-xs-12" for="descripcion_pago_nomina">Descripci&oacute;n <span class="required">*</span>
			</label>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<input class="form-control requieredsalario limpiar" type="text" id="descripcion_pago_nomina" value="">
			</div>

			<label class="control-label col-md-1 col-sm-1 col-xs-12">Valor <span class="required">*</span>
			</label>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="text" class="moneda form-control centrar-derecha requieredsalario st" id="salario" value="0" maxlength="15" aria-label="Amount (to the nearest dollar)">
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-1 col-sm-1 col-xs-12">Total <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input name="total" type="text" class="moneda form-control centrar-derecha requieredsalario" readonly id="total" value="0" maxlength="15" aria-label="Amount (to the nearest dollar)">
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="hidden" id="cxc" name="cxc">
				<button type="button" id = 'btn-agregar-salario' class="btn btn-success">Agregar</button>                        
			</div>
		</div>

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4>Salaríos</h4>
			</div>
			<div class="panel-body items_dest">
				<table id="tabla_salarios" class="table-striped table-bordered table-hover table table-hover dataTableAction display">
					<thead>
						<th class="hide"> </th>
						<th>Documento</th>
						<th>Empleado</th>
						<th>Concepto</th>
						<th>Descripción Pago</th>
						<th>Valor</th>
						<th>Borrar</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
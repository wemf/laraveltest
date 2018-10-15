<div class="row  pagocampana hidenomodify">	
	<div class="x_title"><h2>Registrar Administración de Joyer&iacute;as</h2><div class="clearfix"></div></div>
	<div class="clearfix"></div>
	<div class="form-group">

		<label class="control-label col-md-1 col-sm-1 col-xs-12" for="id_concepto_campana">Concepto <span class="required">*</span></label>
		<div class="col-md-3 col-sm-3 col-xs-12">
			<select id="id_concepto_campana" name="id_concepto_campana" class="form-control requieredcampana">
				<option value="">- Seleccione una opción -</option>              
			</select>
			<div class="row conceptoexiste hide">
				<span class="col-xs-12 col-md-12" style="color:red">Concepto ya registrado</span>
			</div>
		</div>

		<label class="control-label col-md-1 col-sm-1 col-xs-12" for="id_tipo_causacion">Art&iacute;culo <span class="required">*</span></label>
		<div class="col-md-2 col-sm-2 col-xs-12">
			<input class="form-control requieredcampana limpiar" type="text" id="articulo_campana" value="">
		</div>

		<label class="control-label col-md-2 col-sm-2 col-xs-12">Valor Bruto <span class="required">*</span></label>
		<div class="col-md-3 col-sm-3 col-xs-12">
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<input type="text" class="moneda form-control centrar-derecha requieredcampana" id="valor_bruto_campana" value="0" maxlength="15" aria-label="Amount (to the nearest dollar)">
			</div>
		</div>
	</div>
	
	<div class="x_title col-md-8"> 
          <div><h2>Impuestos</h2></div>
          <div class="clearfix"></div>
    </div>  

	<div class="row impuestos">
		<div class="col-md-8 imp">
			<div><h3>No se ha seleccionado ningun tipo de concepto</h3></div>
		</div>
	</div>

	<div class="row">
		<div class="x_title col-md-8"> 
			<div class="clearfix"></div>
		</div>  
	</div>

	<br><br>

	<div class="form-group">
		<label class="control-label col-md-1 col-sm-1 col-xs-12">Total <span class="required">*</span>
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<input name="total_campana" type="text" class="moneda form-control centrar-derecha requieredcampana" readonly id="total_campana" value="0" maxlength="15" aria-label="Amount (to the nearest dollar)">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<button type="button" id = 'btn-agregar-campana' class="btn btn-success">Agregar</button>                        
			</div>
		</div>
	</div>
	<br>
	<div class="row">	
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4>Art&iacute;culos</h4>
			</div>
			<div class="panel-body items_de">
				<table id="tabla_campana" class="table-striped table-bordered table-hover table table-hover dataTableAction display">
					<thead>
						<th>Documento</th>
						<th>Nombre</th>
						<th>Art&iacute;culo</th>
						<th>Valor Bruto</th>
						@foreach($impuestos AS $impuesto)
						<th class="lt_imp" id="impuesto{{$impuesto->id}}">{{$impuesto->name}}</th>
						@endforeach						
						<th>Valor Neto</th>
						<th>Borrar</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

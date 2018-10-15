
<div class="row">	
	<div class="x_title"><h2>Localización de la Tienda</h2><div class="clearfix"></div></div>
	<div class="clearfix"></div>
	<div class="col-md-6 col-xs-12">	
		<div class="form-group">
			<label class="control-label col-xs-4">Tipo Empleado<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_tipo_cliente" name="id_tipo_cliente" class="form-control requiered">
					<option value>- Seleccione una opción -</option>
						@foreach($tipo_empleado as $tipo)
							<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
						@endforeach
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Nombre Comercial<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_franquicia" name="id_franquicia" class="form-control requiered">
					<option value="">- Seleccione una opción -</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Sociedad<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_sociedad" name="id_sociedad" class="form-control requiered">
					<option value="">- Seleccione una opción -</option>
						@foreach($sociedad as $tipo)
							<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
						@endforeach 
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Tienda<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_tienda" name="id_tienda" class="form-control requiered">
					<option value="">- Seleccione una opción -</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Cargo<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_cargo_empleado" name="id_cargo_empleado" class="form-control id_cargo_empleado requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($cargo_empleado as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div>
		
	</div>
	
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label class="control-label col-xs-4">País donde desempeñará</label>
			<div class="col-xs-7">
				<select id="id_pais_trabajo" class="form-control id_pais" disabled></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Departamento donde desempeñará</label>
			<div class="col-xs-7">
				<select id="id_departamento_trabajo" class="form-control " disabled></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad donde desempeñará</label>
			<div class="col-xs-7">
				<select id="id_ciudad_trabajo" name="id_ciudad_trabajo" class="form-control requiered" disabled></select>
			</div>
		</div>

		<div class="form-group id_zona_cargo hide">
			<label class="control-label col-xs-4">Zona<span class="required">*</span></label>
			<div class="col-xs-7">
				<select id="id_zona_cargo" name="id_zona_cargo" class="form-control requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($zonas as $zona)
					<option value="{{ $zona->id }}">{{ $zona->name }}</option>
					@endforeach  
				</select>
			</div>
		</div>
		
	</div>
	
</div>

<div class="row">
	<div class="x_title"><h2>Datos Personales</h2><div class="clearfix"></div></div>
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label class="control-label col-xs-4">Tipo de Documento<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('id_tipo_documento'))
				<select id="id_tipo_documento" name="id_tipo_documento" class="form-control  requiered tipo_documento" value="{{Request::old('id_tipo_documento')}}">
					<option value="">- Seleccione una opción -</option>
					@foreach($tipo_documento as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
				@else
				<select id="id_tipo_documento" name="id_tipo_documento" class="form-control  requiered">
				<option value="">- Seleccione una opción -</option>
					@foreach($tipo_documento as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select> 
				@endif
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Número de Documento<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('numero_documento'))
					<input type="text" id="numero_documento" name="numero_documento" maxlength="12" class="form-control  requiered"
					value="{{Request::old('numero_documento')}}"> 
				@else
					<input type="text" id="numero_documento" name="numero_documento" maxlength="12" class="form-control  requiered">        
				@endif
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Fecha Expedición<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('fecha_expedicion'))
					<input readonly type="text" name="fecha_expedicion" class="form-control requiered data-picker-until-today" value="{{Request::old('fecha_expedicion')}}">        
				@else
					<input readonly type="text" name="fecha_expedicion" class="form-control requiered data-picker-until-today">        
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">País de Expedición<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_pais_exp" name="id_pais_expedicion" type="text" class="form-control id_pais requiered id_pais_parametro" data-sufijo="exp">
				<option value="">- Seleccione una opción -</option>
					@foreach($pais as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Departamento de Expedición</label>
			<div class="col-xs-8">
				<select id="id_dep_exp" type="text" class="form-control"></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Expedición</label>
			<div class="col-xs-8">
				<select id="id_ciu_exp" type="text" name="id_ciudad_expedicion" class="form-control "></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Nombre Completo<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('nombres'))
					<input type="text" name="nombres" maxlength="100" class="form-control  requiered" value="{{Request::old('nombres')}}">        
				@else
					<input type="text" name="nombres" maxlength="100" class="form-control  requiered"> 
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Primer Apellido<span class="required">*</span></label>    
			<div class="col-xs-8">
				@if(Request::old('primer_apellido'))
					<input type="text" name="primer_apellido" maxlength="50" class="form-control  requiered" value="{{Request::old('primer_apellido')}}">        
				@else
					<input type="text" name="primer_apellido" maxlength="50" class="form-control  requiered"> 
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Segundo Apellido</label>
			<div class="col-xs-8">
				@if(Request::old('segundo_apellido'))
					<input type="text" name="segundo_apellido" maxlength="50" class="form-control" value="{{Request::old('segundo_apellido')}}">        
				@else
					<input type="text" name="segundo_apellido" maxlength="50" class="form-control"> 
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Género<span class="required">*</span></label>
			<div class="col-xs-8">
				<select type="text" name="genero" id="genero" class="form-control  requiered">
					<option value="">--Seleccionar--</option>
					<option value="1">Masculino</option>
					<option value="2">Femenino</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Libreta Militar</label>
			<div class="col-xs-8">
				@if(Request::old('libreta_militar'))
				<input type="text" name="libreta_militar" id="libreta_militar" maxlength="15" class="form-control  requiered" value="{{Request::old('libreta_militar')}}">
				@else
				<input type="text" name="libreta_militar" id="libreta_militar" maxlength="15" class="form-control  requiered">        
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Distrito Militar</label>
			<div class="col-xs-8">
				@if(Request::old('distrito_militar'))
					<input type="text" name="distrito_militar" id="distrito_militar" class="form-control  " value="{{Request::old('distrito_militar')}}">        
				@else
					<input type="text" name="distrito_militar" id="distrito_militar" class="form-control  ">        
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Correo Electrónico<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('correo_electronico'))
					<input name="correo_electronico" class="form-control requiered requieredEmail email_validado" value="{{Request::old('correo_electronico')}}">        
				@else
					<input name="correo_electronico" class="form-control  requiered requieredEmail email_validado"> 
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Grupo Sanguíneo<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="rh" name="rh" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($tipo_rh as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Estado Civil<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_estado_civil" name="id_estado_civil" class="form-control  requiered">
				<option value="">- Seleccione una opción -</option>
					@foreach($estado_civil as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Tipo de Vivienda<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_tipo_vivienda" name="id_tipo_vivienda" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($tipo_vivienda as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div>

	</div>
	
	<div class="col-md-6 col-xs-12">
				<div class="form-group">
			<label class="control-label col-xs-4">Fecha de Nacimiento<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('fecha_nacimiento'))
					<input readonly type="text" name="fecha_nacimiento" class="form-control  data-picker-until-today requiered" value="{{Request::old('fecha_nacimiento')}}">        
				@else
					<input readonly type="text" name="fecha_nacimiento" class="form-control  data-picker-until-today requiered">        
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">País de Nacimiento<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_pais_nacimiento" name="id_pais_nacimiento" class="form-control id_pais id_pais_parametro" data-sufijo="nacimiento">
					<option value="">- Seleccione una opción -</option>
					@foreach($pais as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Departamento de Nacimiento</label>
			<div class="col-xs-8">
				<select id="id_dep_nacimiento" type="text" class="form-control "></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Nacimiento</label>
			<div class="col-xs-8">
				<select id="id_ciu_nacimiento" type="text" name="id_ciudad_nacimiento" class="form-control "></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">País de Residencia<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_pais_residencia" type="text" class="form-control  id_pais id_pais_parametro">
				<option value="">- Seleccione una opción -</option>
					@foreach($pais as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Departamento de Residencia<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_dep_residencia" type="text" class="form-control "></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Residencia<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_ciu_residencia" type="text" name="id_ciudad_residencia" class="form-control  requiered"></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Dirección Residencia<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('direccion_residencia'))
					<input type="text" name="direccion_residencia" id="direccion_residencia" data-pos="1" class="form-control  requiered direccion" value="{{Request::old('direccion_residencia')}}"> 
				@else
					<input type="text" name="direccion_residencia" id="direccion_residencia" data-pos="1" class="form-control  requiered direccion">        
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Barrio Residencia<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('barrio_residencia'))
					<input type="text" name="barrio_residencia" class="form-control  requiered" value="{{Request::old('barrio_residencia')}}">        
				@else
					<input type="text" name="barrio_residencia" class="form-control  requiered"> 
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Teléfono Residencia<span class="required">*</span></label>
			<div class="col-xs-8" style="font-size: 0;">
				@if(Request::old('telefono_residencia'))
					<input type="text" name="telefono_residencia_indicativo" maxlength="10" style="font-size: 13px !important;" class="form-control tl telefono_indicativo" readOnly>
					<input type="text" name="telefono_residencia" maxlength="10" style="font-size: 13px !important;" class="form-control numeric requiered tlx" value="{{Request::old('telefono_residencia')}}">        
				@else
					<input type="text" name="telefono_residencia_indicativo" maxlength="10" style="font-size: 13px !important;" class="form-control tl telefono_indicativo" readOnly>
					<input type="text" name="telefono_residencia" maxlength="10" style="font-size: 13px !important;" class="form-control numeric requiered tlx">        
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Teléfono Celular<span class="required">*</span></label>
			<div class="col-xs-8" style="font-size: 0;">

				@if(Request::old('telefono_celular_indicativo'))
					<input type="text" name="telefono_celular_indicativo" maxlength="10" style="font-size: 13px !important;" class="form-control requiered tl telefono_indicativo_celular" readOnly>
					<input type="text" name="telefono_celular" maxlength="10" style="font-size: 13px !important;" class="form-control numeric requiered tlx" value="{{Request::old('telefono_celular')}}">        
				@else
					<input type="text" name="telefono_celular_indicativo" maxlength="10" style="font-size: 13px !important;" class="form-control requiered tl telefono_indicativo_celular" readOnly>
					<input type="text" name="telefono_celular" maxlength="10" style="font-size: 13px !important;" class="form-control numeric requiered tlx">        
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Talla Camisa<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="talla_camisa" name="talla_camisa" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($talla_camisa as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Talla Pantalón<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="talla_pantalon" name="talla_pantalon" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($talla_n as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Talla Zapatos<span class="required">*</span></label>
			<div class="col-xs-8">
			<select id="talla_zapatos" name="talla_zapatos" class="form-control  requiered">
				<option value="">- Seleccione una opción -</option>
				@foreach($talla_n as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
				@endforeach 
			</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Tenencia Vivienda<span class="required">*</span></label>
			<div class="col-xs-8">
			<select id="id_tenencia_vivienda" name="id_tenencia_vivienda" class="form-control  requiered">
				<option value="">- Seleccione una opción -</option>
				@foreach($tenencia_vivienda as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
				@endforeach 
			</select>
			</div>
		</div>

	</div>
	<div class="x_title"><div class="clearfix"></div></div>
	<div class="center">
		<button type="button" class="btn btn-success btn-recorrido tb1" data-id-div="tabs-1" next="ui-id-2" data-href="tabs-2">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
	</div>
</div>














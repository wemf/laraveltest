
<div class="row">	
	<div class="x_title"><h2>Localización de la Joyería</h2><div class="clearfix"></div></div>
	<input type="hidden" name="id_tipo_cliente" value="5">
	<div class="col-md-6 col-xs-12">	

		<div class="form-group">
			<label class="control-label col-xs-4">Nombre Comercial<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_franquicia" name="id_franquicia" class="form-control requiered" readonly>
					<option value="{{$franquiciahubicado[0]['id']}}">{{$franquiciahubicado[0]['name']}}</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Sociedad<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_sociedad" name="id_sociedad" class="form-control requiered" readonly>
							<option value="{{ $sociedad[0]['id'] }}">{{ $sociedad[0]['name'] }}</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Joyería<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_tienda" name="id_tienda" class="form-control requiered" readonly>
					<option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
				</select>
			</div>
		</div>

	</div>
	
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label class="control-label col-xs-4">País</label>
			<div class="col-xs-7">
				<select id="id_pais_trabajo" class="form-control id_pais" disabled></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Departamento</label>
			<div class="col-xs-7">
				<select id="id_departamento_trabajo" class="form-control " disabled></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad</label>
			<div class="col-xs-7">
				<select id="id_ciudad_trabajo" name="" class="form-control requiered" disabled></select>
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
				<select id="id_tipo_documento" required name="id_tipo_documento" class="form-control col-md-7 col-xs-12 requiered">
				<option value="">- Seleccione una opción -</option>
					@foreach($tipo_documento as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
					@endforeach  
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Número de Documento<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('numero_documento'))
					<input type="text" id="numero_documento" required name="numero_documento" maxlength="12" class="form-control col-md-7 col-xs-12 requiered ver_doc"
					value="{{Request::old('numero_documento')}}"> 
				@else
					<input type="text" required id="numero_documento" name="numero_documento" maxlength="12" class="form-control col-md-7 col-xs-12 requiered ver_doc">        
				@endif
			</div>
			
			<div id="myModal" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">El provedor natural ya existe en el sistema</h4>
						</div>
						
						<div class="modal-body">
							<p>¿Desea cargar su información?</p>
							<a id="rutaActualizar" class="btn btn-success" type="button">Si</a>
							<a href="{{ url('/clientes/empleado') }}" class="btn btn-danger" data-dismiss="modal" type="button">No</a>
						</div>
					</div>
				</div>
			</div>	
		</div>

				<div class="form-group">
			<label class="control-label col-xs-4">Nombre Completo<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('nombres'))
					<input type="text" required name="nombres" maxlength="100" class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('nombres')}}">        
				@else
					<input type="text" required name="nombres" maxlength="100" class="form-control col-md-7 col-xs-12 requiered"> 
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Primer Apellido<span class="required">*</span></label>    
			<div class="col-xs-8">
				@if(Request::old('primer_apellido'))
					<input required type="text" name="primer_apellido" maxlength="50" class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('primer_apellido')}}">        
				@else
					<input required type="text" name="primer_apellido" maxlength="50" class="form-control col-md-7 col-xs-12 requiered"> 
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Segundo Apellido</label>
			<div class="col-xs-8">
				@if(Request::old('segundo_apellido'))
					<input  type="text" name="segundo_apellido" maxlength="50" class="form-control col-md-7 col-xs-12" value="{{Request::old('segundo_apellido')}}">        
				@else
					<input  type="text" name="segundo_apellido" maxlength="50" class="form-control col-md-7 col-xs-12"> 
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Fecha Expedición</label>
			<div class="col-xs-8">
				@if(Request::old('fecha_expedicion'))
					<input  type="text" name="fecha_expedicion" class="form-control data-picker-until-today" value="{{Request::old('fecha_expedicion')}}" autocomplete="off">
				@else
					<input  type="text" name="fecha_expedicion" class="form-control data-picker-until-today" autocomplete="off">
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">País de Expedición</label>
			<div class="col-xs-8">
				<select id="id_pais_exp" type="text" name="id_pais_expedicion" class="form-control id_pais id_pais_parametro" data-sufijo="exp">
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
				<select id="id_dep_exp" type="text" class="form-control "></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Expedición</label>
			<div class="col-xs-8">
				<select id="id_ciu_exp" type="text" name="id_ciudad_expedicion" class="form-control"></select>
			</div>
		</div>		

		<div class="form-group">
			<label class="control-label col-xs-4">Correo Electrónico<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('correo_electronico'))
					<input required name="correo_electronico" type="email" class="form-control col-md-7 col-xs-12 requieredEmail requiered" value="{{Request::old('correo_electronico')}}">        
				@else
					<input required name="correo_electronico" type="email" class="form-control col-md-7 col-xs-12 requieredEmail requiered"> 
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Género</label>
			<div class="col-xs-8">
				<select type="text" name="genero" id="genero" class="form-control col-md-7 col-xs-12">
					<option value="">--Seleccionar--</option>
					<option value="1">Masculino</option>
					<option value="2">Femenino</option>
				</select>
			</div>
		</div>

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Libreta Militar</label>
			<div class="col-xs-8">
				@if(Request::old('libreta_militar'))
				<input type="text" name="libreta_militar" id="libreta_militar" maxlength="15" class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('libreta_militar')}}">
				@else
				<input type="text" name="libreta_militar" id="libreta_militar" maxlength="15" class="form-control col-md-7 col-xs-12 requiered">        
				@endif
			</div>
		</div> --}}

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Distrito Militar</label>
			<div class="col-xs-8">
				@if(Request::old('distrito_militar'))
					<input type="text" name="distrito_militar" id="distrito_militar" class="form-control col-md-7 col-xs-12 " value="{{Request::old('distrito_militar')}}">        
				@else
					<input type="text" name="distrito_militar" id="distrito_militar" class="form-control col-md-7 col-xs-12 ">        
				@endif
			</div>
		</div> --}}

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Grupo Sanguíneo<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="rh" name="rh" class="form-control col-md-7 col-xs-12 requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($tipo_rh as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div> --}}

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Tipo de Vivienda<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_tipo_vivienda" name="id_tipo_vivienda" class="form-control col-md-7 col-xs-12 requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($tipo_vivienda as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div> --}}

		<div class="form-group">
			<label class="control-label col-xs-4">Documento Identificación parte frontal</label>
			<div class="col-xs-8">
				<input type="file" id="foto_1" name="foto_1" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
	</div>
	
	<div class="col-md-6 col-xs-12">
		<div class="form-group">
			<label class="control-label col-xs-4">Fecha de Nacimiento<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('fecha_nacimiento'))
					<input type="text" required name="fecha_nacimiento" class="form-control col-md-7 col-xs-12 data-picker-until-today requiered" value="{{Request::old('fecha_nacimiento')}}" autocomplete="off">        
				@else
					<input type="text" required name="fecha_nacimiento" class="form-control col-md-7 col-xs-12 data-picker-until-today requiered" autocomplete="off">        
				@endif
			</div>
		</div>

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">País de Nacimiento<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_pais_nacimiento" name="id_pais_nacimiento" type="text" class="form-control col-md-7 col-xs-12 id_pais id_pais_parametro" data-sufijo="nacimiento">
				<option value="">- Seleccione una opción -</option>
					@foreach($pais as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div> --}}

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Departamento de Nacimiento<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_dep_nacimiento" type="text" class="form-control col-md-7 col-xs-12"></select>
			</div>
		</div> --}}

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Nacimiento<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_ciu_nacimiento" type="text" name="id_ciudad_nacimiento" class="form-control col-md-7 col-xs-12 requiered"></select>
			</div>
		</div> --}}		

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Barrio Residencia<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('barrio_residencia'))
					<input type="text" name="barrio_residencia" class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('barrio_residencia')}}">        
				@else
					<input type="text" name="barrio_residencia" class="form-control col-md-7 col-xs-12 requiered"> 
				@endif
			</div>
		</div> --}}

		<div class="form-group">
			<label class="control-label col-xs-4">País de Residencia<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_pais_residencia" required name="id_pais_residencia" type="text" class="form-control col-md-7 col-xs-12 id_pais id_pais_parametro requiered" data-sufijo="residencia">
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
				<select id="id_dep_residencia" required type="text" class="form-control col-md-7 col-xs-12 requiered"></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Residencia<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_ciu_residencia" required type="text" name="id_ciudad_residencia" class="form-control col-md-7 col-xs-12 requiered"></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Dirección Residencia<span class="required">*</span></label>
			<div class="col-xs-8">
				@if(Request::old('direccion_residencia'))
					<input type="text" required name="direccion_residencia" id="direccion_residencia" data-pos="1" class="form-control col-md-7 col-xs-12 requiered direccion" value="{{Request::old('direccion_residencia')}}"> 
				@else
					<input type="text" required name="direccion_residencia" id="direccion_residencia" data-pos="1" class="form-control col-md-7 col-xs-12 requiered direccion">        
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Teléfono Fijo<span class="required">*</span></label>
			<div class="col-xs-8" style="font-size: 0;">
				@if(Request::old('telefono_residencia'))
					<input type="text" name="telefono_residencia_indicativo" maxlength="10" style="font-size: 13px !important;" class="form-control tl telefono_indicativo" readOnly>
					<input type="text" required id="fijo" name="telefono_residencia" maxlength="10" style="font-size: 13px !important;" class="form-control numeric requiered tlx" value="{{Request::old('telefono_residencia')}}">        
				@else
					<input type="text" name="telefono_residencia_indicativo" maxlength="10" style="font-size: 13px !important;" class="form-control tl telefono_indicativo" readOnly>
					<input type="text" required id="fijo" name="telefono_residencia" maxlength="10" style="font-size: 13px !important;" class="form-control numeric requiered tlx">        
				@endif
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Teléfono Celular<span class="required">*</span></label>
			<div class="col-xs-8" style="font-size: 0;">
				@if(Request::old('telefono_celular_indicativo'))
					<input type="text" name="telefono_celular_indicativo" maxlength="10" style="font-size: 13px !important;" class="form-control tl telefono_indicativo_celular" readOnly>
					<input type="text" required id="celular" name="telefono_celular" maxlength="10" style="font-size: 13px !important;" class="form-control numeric requiered tlx" value="{{Request::old('telefono_celular')}}">        
				@else
					<input type="text" name="telefono_celular_indicativo" maxlength="10" style="font-size: 13px !important;" class="form-control tl telefono_indicativo_celular" readOnly>
					<input type="text" required id="celular" name="telefono_celular" maxlength="10" style="font-size: 13px !important;" class="form-control numeric requiered tlx">        
				@endif
			</div>
		</div>

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Talla Camisa<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="talla_camisa" name="talla_camisa" class="form-control col-md-7 col-xs-12 requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($talla_camisa as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div> --}}

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Talla Pantalón<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="talla_pantalon" name="talla_pantalon" class="form-control col-md-7 col-xs-12 requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($talla_n as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div> --}}

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Talla Zapatos<span class="required">*</span></label>
			<div class="col-xs-8">
			<select id="talla_zapatos" name="talla_zapatos" class="form-control col-md-7 col-xs-12 requiered">
				<option value="">- Seleccione una opción -</option>
				@foreach($talla_n as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
				@endforeach 
			</select>
			</div>
		</div> --}}

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Tenencia Vivienda<span class="required">*</span></label>
			<div class="col-xs-8">
			<select id="id_tenencia_vivienda" name="id_tenencia_vivienda" class="form-control col-md-7 col-xs-12 requiered">
				<option value="">- Seleccione una opción -</option>
				@foreach($tenencia_vivienda as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
				@endforeach 
			</select>
			</div>
		</div> --}}

		<div class="form-group">
			<label class="control-label col-xs-4">Provedor Confiable?<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_confiabilidad" required name="id_confiabilidad" class="form-control col-md-7 col-xs-12 requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($confiabilidad as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Estado Civil<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_estado_civil" name="id_estado_civil" class="form-control col-md-7 col-xs-12 requiered">
				<option value="">- Seleccione una opción -</option>
					@foreach($estado_civil as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div> --}}

		<div class="form-group">
			<label class="control-label col-xs-4">Documento Identificación parte posterior</label>
			<div class="col-xs-8">
				<input type="file" id="foto_2" name="foto_2" class="form-control col-md-7 col-xs-12">
			</div>
		</div>	

	</div>
	<div class="x_title"><div class="clearfix"></div></div>
	{{-- <div class="center">
		<button type="button" class="btn btn-success btn-recorrido" data-id-div="tabs-1" data-href="tabs-2" next="ui-id-2">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
	</div> --}}
	
</div>
@section('javascript')
URL.setTiendaZona("{{ url('/clientes/empleado/getTiendaZona/') }}");
URL.setCombos("{{ url('/clientes/empleado/getCombos/') }}");
URL_CLIENTE.setURLValidarDocumento("{{ url('/clientes/funciones/getValidarDocumento') }}");
URL_CLIENTE.setActualizarThis("{{ url('/clientes/proveedor/persona/natural/update') }}");
URL.setEmpleadoActu("clientes/proveedor/persona/natural/update");

$('#id_tienda').change();

	// validamos si uno de los campos ya esta ingresado y quitamos el requerido al otro campo.
		$('#fijo').change(function(){
			if($('#fijo').val() != '' && $('#celular').val() == ''){
				$('#celular').removeClass('requiered');
				$('#celular').removeAttr('required');
			}
		});
		$('#celular').change(function(){
			if($('#celular').val() != ''  && $('#fijo').val() == ''){
				$('#fijo').removeClass('requiered');
				$('#fijo').removeAttr('required');
			}
		});

	// validamos que al cargar la vista siempre este por defecto el proveedor confiable en alto.
		$(document).ready(function(){
			$('#id_confiabilidad').prop('value',1);
		})

@endsection














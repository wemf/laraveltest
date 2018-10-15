<div class="row">	
	<h2>Localización de la Joyería</h2>
	<div class="x_title">
		<h2></h2>
		<div class="clearfix"></div>
	</div>
	<div class="col-md-6 col-xs-12">
	    <input type="hidden" name="id_tipo_cliente" value="3">
	    <input type="hidden" id='codigo_cliente' value="{{$codigo_cliente}}">

		<div class="form-group">
			<label class="control-label col-xs-4">Nombre Comercial<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_franquicia" data-load="{{ $attribute->id_franquicia }}" required name="id_franquicia" disabled class="form-control required"></select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-xs-4">Sociedad<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_sociedad" data-load="{{ $attribute->id_sociedad }}" required name="id_sociedad" disabled class="form-control  required"></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Joyería<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id='id_tienda' data-load="{{ $attribute->id_tienda }}" required name="id_tienda" disabled class="form-control  required"></select>
			</div>
		</div> 
	</div>
	<div class="col-md-6 col-xs-12">	
		<div class="form-group">
			<label class="control-label col-xs-4">País<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_pais_trabajo" required class="form-control  id_pais" disabled></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Departamento<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_departamento_trabajo" required class="form-control " disabled></select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_ciudad_trabajo" required class="form-control " disabled></select>
			</div>
		</div>  
	</div>
</div>
<div class="row">	
	</br>
	<div class="x_title">
		<div class="clearfix"></div>
	</div>

	<div class="x_title">
		<h2>Datos Personales</h2>
		<div class="clearfix"></div>
	</div>
	
	<div class="col-md-6 col-xs-12">	
		<div class="form-group">
			<label class="control-label col-xs-4">Tipo de Documento<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select data-load="{{ $attribute->id_tipo_documento }}" id="id_tipo_documento" required name="id_tipo_documento" class="form-control"></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Número de Documento<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<input type="text" id="numero_documento" name="numero_documento" maxlength="12" value="{{$attribute->numero_documento}}" required class="form-control ver_doc">
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Fecha Expedición
				</label>
				<div class="col-xs-8">
					@if(Request::old('fecha_expedicion'))
					<input type="text" name="fecha_expedicion" class="form-control   data-picker-until-today" value="{{Request::old('fecha_expedicion')}}">
					@else
					<input type="text" name="fecha_expedicion" value="{{dateFormate::ToFormatInverse($attribute->fecha_expedicion)}}" class="form-control   data-picker-until-today">
					@endif
				</div>
			</div>
		<div class="form-group">
			<label class="control-label col-xs-4">País de Expedición
			</label>
			<div class="col-xs-8">
				<select id="id_pais_exp" type="text" data-load="{{ $attribute->id_pais_expedicion }}" onchange="clearSelects([['id_dep_exp', 'delete_options'], ['id_ciu_exp', 'delete_options']], 1); loadSelectChild(this, '#id_dep_exp', '{{ url('/departamento/getdepartamentobypais') }}');" name="id_pais_expedicion" class="form-control id_pais_parametro id_pais" data-sufijo="exp">
					<option value="">- Seleccione una opción -</option>
					@foreach($pais as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Departamento de Expedición
			</label>
			<div class="col-xs-8">
				<select id="id_dep_exp" data-load="{{ $attribute->id_departamento_expedicion }}" onchange="clearSelects([['id_ciu_exp', 'delete_options']], 1); loadSelectChild(this, '#id_ciu_exp', '{{ url('/ciudad/getciudadbydepartamento') }}');" type="text" class="form-control  id_departamento "></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Expedición
			</label>
			<div class="col-xs-8">
				<select id="id_ciu_exp" data-load="{{ $attribute->id_ciudad_expedicion }}" name="id_ciudad_expedicion" class="form-control  id_ciudad"></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Nombre<span class="required">*</span></label>
			<div class="col-xs-8">
				<input type="text" name="nombres" value="{{$attribute->nombres}}" required maxlength="100" class="form-control">
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Primer Apellido<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<input type="text" name="primer_apellido" required value="{{$attribute->primer_apellido}}" maxlength="50" class="form-control  required">
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Segundo Apellido
			</label>
			<div class="col-xs-8">
				<input type="text" name="segundo_apellido" value="{{$attribute->segundo_apellido}}" maxlength="50" class="form-control ">
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-xs-4">Correo Electrónico<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				@if(Request::old('correo_electronico'))
					<input value="{{$attribute->correo_electronico}}" required class="form-control requiredEmail email_validado required" type="email" name="correo_electronico" class="form-control email_validado">					        
				@else
					<input value="{{$attribute->correo_electronico}}" required class="form-control requiredEmail email_validado required" type="email" name="correo_electronico" class="form-control email_validado">
				@endif
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Género
			</label>
			<div class="col-xs-8">
				<select type="text" name="genero" id="genero" class="form-control ">
					<option value="">--Seleccionar--</option>
					<option value="1" @if($attribute->genero == 1) selected @endif>Masculino</option>
					<option value="2" @if($attribute->genero == 2) selected @endif>Femenino</option>
				</select>
			</div>
		</div>

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Libreta Militar
			</label>
			<div class="col-xs-8">
				<input value="{{$attribute->libreta_militar}}" maxlength="15" class="form-control " type="text" name="libreta_militar" id="libreta_militar" class="form-control ">
			</div>
		</div> --}}
		
		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Distrito Militar
			</label>
			<div class="col-xs-8">
				<input value="{{$attribute->distrito_militar}}" maxlength="15" class="form-control " type="text" name="distrito_militar" id="distrito_militar" class="form-control ">
			</div>
		</div> --}}

		{{--  <div class="form-group">
			<label class="control-label col-xs-4">Grupo Sanguíneo<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="rh" name="rh" class="form-control  required">
					<option value="">- Seleccione una opción -</option>
					@foreach($tipo_rh as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div>  --}}
		
		{{--  <div class="form-group">
			<label class="control-label col-xs-4">Tipo de Vivienda<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_tipo_vivienda" name="id_tipo_vivienda" class="form-control  required">
					<option value="">- Seleccione una opción -</option>
					@foreach($tipo_vivienda as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div>  --}}
		<div class="form-group">
			<label class="control-label col-xs-4">Documento Identificación parte frontal</label>
			<div class="col-xs-8">
				<input type="file" id="foto_1" name="foto_1" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		
		@if(!is_null($attribute->ruta_foto_anterior) && $attribute->ruta_foto_anterior != '')
		<div class="form-group">
			<div class="col-xs-12 center">
				<img src="{{env('RUTA_ARCHIVO_OP')}}colombia\cliente\doc_persona_natural\{{$attribute->ruta_foto_anterior}}" style="width:200px; height:150px">
			</div>
		</div>
		@endif
	
	</div>
	<div class="col-md-6 col-xs-12">	
		<div class="form-group">
			<label class="control-label col-xs-4">Fecha de Nacimiento<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<input id="fecha_nacimiento" name="fecha_nacimiento" required value="{{dateFormate::ToFormatInverse($attribute->fecha_nacimiento)}}" class="form-control required  data-picker-until-today">
			</div>
		</div> 
		{{-- <div class="form-group">
			<label class="control-label col-xs-4">País de Nacimiento
			</label>
			<div class="col-xs-8">
				<select id="id_pais_nacimiento" name="id_pais_nacimiento" class="form-control id_pais_parametro id_pais" data-sufijo="nacimiento">
					<option value="">- Seleccione una opción -</option>
					@foreach($pais as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div>  --}}
		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Departamento de Nacimiento
			</label>
			<div class="col-xs-8">
				<select id="id_dep_nacimiento" class="id_departamento form-control "></select>
			</div>
		</div>  --}}
		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Nacimiento
			</label>
			<div class="col-xs-8">
				<select id="id_ciu_nacimiento"  name="id_ciudad_nacimiento" class="id_ciudad form-control "></select>
			</div>
		</div>  --}}

		<div class="form-group">
			<label class="control-label col-xs-4">País de Residencia<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_pais_residencia" data-load="{{ $attribute->id_pais_residencia }}" required onchange="clearSelects([['id_dep_residencia', 'delete_options'],['id_ciu_residencia', 'delete_options']], 1); loadSelectChild(this, '#id_dep_residencia', '{{ url('/departamento/getdepartamentobypais') }}');" name="id_pais_residencia" type="text" class="form-control  id_pais "></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Departamento de Residencia<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_dep_residencia" data-load="{{ $attribute->id_departamento_residencia }}" required onchange="clearSelects([['id_ciu_residencia', 'delete_options']], 1); loadSelectChild(this, '#id_ciu_residencia', '{{ url('/ciudad/getciudadbydepartamento') }}');" type="text" class="form-control  id_departamento"></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Residencia<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_ciu_residencia" data-load="{{ $attribute->id_ciudad_residencia }}" required type="text" name="id_ciudad_residencia" class="form-control  id_ciudad "></select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Dirección Residencia<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<input type="text" name="direccion_residencia" id="direccion_residencia" required data-pos="1" value="{{$attribute->direccion_residencia}}" class="form-control  direccion ">
			</div>
		</div> 
		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Barrio Residencia
			</label>
			<div class="col-xs-8">
				<input type="text" name="barrio_residencia" value="{{$attribute->barrio_residencia}}" class="form-control  ">
			</div>
		</div>  --}}

		<div class="form-group">
			<label class="control-label col-xs-4">Teléfono Fijo<span class="required">*</span></label>
			<div class="col-xs-8" style="font-size: 0;">
				<input required type="text" name="telefono_residencia_indicativo" value="{{ $indicativo2->name }}" style="font-size: 13px !important;" maxlength="10" id="telefono_residencia_indicativo" maxlength="5" class="form-control  tl telefono_indicativo" readOnly>
				<input required maxlength="10" value="{{$attribute->telefono_residencia}}"  class="form-control required tlx numeric" style="font-size: 13px !important;" type="text" name="telefono_residencia" id="telefono_residencia" class="form-control  ">
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4" >Teléfono Celular<span class="required">*</span>
			</label>
			<div class="col-xs-8" style="font-size: 0;">
				<input required type="text" name="telefono_celular_indicativo" value="{{ $indicativo1->name }}"  style="font-size: 13px !important;" maxlength="10" id="telefono_celular_indicativo" maxlength="5" class="form-control  tl telefono_indicativo_celular" readOnly>
				<input required maxlength="10" value="{{$attribute->telefono_celular}}" class="form-control  required numeric tlx" style="font-size: 13px !important;" type="text" name="telefono_celular" id="telefono_celular" class="form-control ">
			</div>
		</div>
	
		{{--  <div class="form-group">
			<label class="control-label col-xs-4">Talla Camisa
			</label>
			<div class="col-xs-8">
				<select id="talla_camisa" name="talla_camisa" class="form-control  required">
					<option value="">- Seleccione una opción -</option>
					@foreach($talla_camisa as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Talla Pantalón
			</label>
			<div class="col-xs-8">
				<select id="talla_pantalon" name="talla_pantalon" class="form-control  required">
					<option value="">- Seleccione una opción -</option>
					@foreach($talla_n as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Talla Zapatos
			</label>
			<div class="col-xs-8">
				<select id="talla_zapatos" name="talla_zapatos" class="form-control  required">
					<option value="">- Seleccione una opción -</option>
					@foreach($talla_n as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div>  
		<div class="form-group">
			<label class="control-label col-xs-4">Tenencia Vivienda<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_tenencia_vivienda" name="id_tenencia_vivienda" class="form-control  required">
					<option value="">- Seleccione una opción -</option>
					@foreach($tenencia_vivienda as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div> --}}

		<div class="form-group">
			<label class="control-label col-xs-4">¿Cliente Confiable?<span class="required">*</span></label>
			<div class="col-xs-8">
			<select id="id_confiabilidad" required name="id_confiabilidad" class="form-control col-md-7 col-xs-12 required" >
				<option value="">- Seleccione una opción -</option>
				@foreach($confiabilidad as $tipo)
					<option value="{{ $tipo->id }}" @if($attribute->id_confiabilidad == $tipo->id) selected @endif>{{ $tipo->name }}</option>
				@endforeach
			</select>
			</div>
		</div>

		{{-- <div class="form-group">
			<label class="control-label col-xs-4">Estado Civil
			</label>
			<div class="col-xs-8">
				<select id="id_estado_civil" name="id_estado_civil" class="form-control ">
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
				<input type="file" id="foto_2" name="foto_2" class="form-control col-md-7 col-xs-12" >
			</div>
		</div>	

		<input type="hidden" id="validate_foto_anterior" name="validate_foto_anterior" value="{{ $attribute->ruta_foto_anterior }}">
		<input type="hidden" id="validate_foto_posterior" name="validate_foto_posterior" value="{{ $attribute->ruta_foto_posterior }}">

		@if(!is_null($attribute->ruta_foto_posterior) && $attribute->ruta_foto_posterior != '')
		<div class="form-group">
			<div class="col-xs-12 center">
				<img src="{{env('RUTA_ARCHIVO_OP')}}colombia\cliente\doc_persona_natural\{{$attribute->ruta_foto_posterior}}" style="width:200px; height:150px">
			</div>
		</div>
		@endif
		
	</div>
	<div class="x_title"><div class="clearfix"></div></div>
	{{-- <div class="center">
		<button type="button" class="btn btn-success btn-recorrido" data-id-div="tabs-1" next="ui-id-2" data-href="tabs-2">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
	</div> --}}
</div>	
@section('javascript')
URL.setUrlList("{{ url('/clientes/persona/natural/getSelectList') }}");
    URL.setUrlListById("{{ url('/clientes/persona/natural/getSelectListById') }}");
    URL.setAction("{{ url('/clientes/persona/natural/update') }}");
    URL.setActionUser("{{ url('/users/registerAjax') }}");
    URL.setEmpleado(" {{ url('/clientes/empleado/getEmpleadoIden') }} ");
    URL.setUser(" {{ url('/clientes/empleado/getUser') }} ");
    URL.setTiendaZona("{{ url('/clientes/empleado/getTiendaZona/') }}");
    URL.setCombos("{{ url('/clientes/empleado/getCombos/') }}");
    URL.setTipoDocumento(" {{ url('/clientes/tipodocumento/getAlfanumerico') }} ");
    URL.setEmpleadoSociedad("{{ url('/clientes/empleado/getSociedad') }}");
    URL.setParametroGeneral("{{ url('/clientes/empleado/getparametroGeneral') }}");
    URL_CLIENTE.setURLValidarDocumento("{{ url('/clientes/funciones/getValidarDocumento') }}");
    URL_CLIENTE.getEmpleadoActualizar("{{ url('/clientes/empleado/update') }}");
    URL_CLIENTE.getPersonaNaturalActualizar("{{ url('/clientes/persona/natural/update') }}");
    URL_CLIENTE.getProveedorNaturalActualizar("{{ url('/clientes/proveedor/persona/natural/update') }}");

    var y = '{{$attribute->telefono_celular}}';
    var x = y.split(" ");

    $('#telefono_celular').val(x[1]);
    $('#telefono_celular_indicativo').val(x[0]);
    if(x[1] == "" || x[1] === undefined) 
    {
      $('#telefono_celular').val(x[0]);
      $('#telefono_celular_indicativo').val("");
    }  

    var y1 = '{{$attribute->telefono_residencia}}';
    var x1 = y1.split(" ");
    
    <!-- $('#telefono_residencia_indicativo').val(x1[1]); -->
    $('#telefono_residencia').val(x1[0]);
    if(x1[1] == "" || x1[1] === undefined) 
    {
      <!-- $('#telefono_celular').val(x1[0]); -->
      $('#telefono_celular_indicativo').val("");
    }  

    $(document).ready(function()
    {

       /*-- --------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN GRUPO FAMILIAR
      ---- --------------------------------------------------- --*/
    
      @for($j=0;$j<count($familiar);$j++)
          document.getElementsByName("id_tienda_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_tienda']}}";
            document.getElementsByName("codigo_cliente_familiares[]")[{{$j}}].value = "{{$familiar[$j]['codigo_cliente']}}";
            document.getElementsByName("id_tipo_documento_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_tipo_documento']}}";
            document.getElementsByName("identificacion_familiares[]")[{{$j}}].value = "{{$familiar[$j]['numero_documento']}}";
            document.getElementsByName("nombres_completos_familiares[]")[{{$j}}].value = "{{$familiar[$j]['nombre']}}";
            {{-- document.getElementsByName("id_parentesco_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_tipo_parentesco']}}"; --}}
            document.getElementsByName("fecha_nacimiento_familiares[]")[{{$j}}].value = "{{dateFormate::ToFormatInverse($familiar[$j]['fecha_nacimiento'])}}";
            document.getElementsByName("id_genero_familiares[]")[{{$j}}].value = "{{$familiar[$j]['genero']}}";
            {{-- @if($familiar[$j]['beneficiario'] == 1)
              document.getElementsByName("hd_beneficiario[]")[{{$j}}].value = "1";
              document.getElementsByName("beneficiario[]")[{{$j}}].checked = true;
            @else
              document.getElementsByName("hd_beneficiario[]")[{{$j}}].value = "0";
            @endif --}}
            {{-- document.getElementsByName("ocupacion_familiares[]")[{{$j}}].value = "{{$familiar[$j]['ocupacion']}}";    
            document.getElementsByName("grado_escolaridad_familiares[]")[{{$j}}].value = "{{$familiar[$j]['grado_escolaridad']}}"; 
            document.getElementsByName("id_nivel_estudio_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_nivel_estudio']}}"; 
            document.getElementsByName("semestre_familiares[]")[{{$j}}].value = "{{$familiar[$j]['semestre']}}"; 
            @if($familiar[$j]['a_cargo_persona_familiares'] == 1)
              document.getElementsByName("hd_a_cargo_persona_familiares[]")[{{$j}}].value = "1";
              document.getElementsByName("a_cargo_persona_familiares[]")[{{$j}}].checked = true;
            @endif
            @if($familiar[$j]['vive_con_persona_familiares'] == 1)
              document.getElementsByName("hd_vive_con_persona_familiares[]")[{{$j}}].value = "1";
              document.getElementsByName("vive_con_persona_familiares[]")[{{$j}}].checked = true;
            @endif --}}
      @endfor


      /*-- ------------------------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN CONTACTO EN CASO DE EMERGENCIA
      ---- ------------------------------------------------------------------- --*/

      {{-- @for($k=0;$k<count($contacto_emergencia);$k++)
            document.getElementsByName("id_tienda_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_tienda']}}";
            document.getElementsByName("codigo_cliente_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['codigo_cliente']}}";
            document.getElementsByName("id_tipo_documento_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_tipo_documento']}}";
            document.getElementsByName("identificacion_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['numero_documento']}}";
            document.getElementsByName("nombre_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['nombre']}}";
            document.getElementsByName("parentesco_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_tipo_parentesco']}}";  
            document.getElementsByName("direccion_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['direccion_residencia']}}";    
            document.getElementsByName("ciudad_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_ciudad_residencia']}}"; 
            document.getElementsByName("telefono_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['telefono_residencia']}}";
      @endfor --}}


      /*-- ----------------------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN CONTACTO ESTUDIOS REALIZADOS
      ---- ----------------------------------------------------------------- --*/

      {{-- @for($j=0;$j<count($estudios);$j++)
            document.getElementsByName("nombre_estudios[]")[{{$j}}].value = "{{$estudios[$j]['nombre_estudio']}}";
            document.getElementsByName("anos_cursados_estudios[]")[{{$j}}].value = {{$estudios[$j]['anos_cursados_estudio']}};  
            document.getElementsByName("fecha_inicio_estudios[]")[{{$j}}].value = "{{dateFormate::ToFormatInverse($estudios[$j]['fecha_inicio_estudio'])}}";    
            document.getElementsByName("fecha_terminacion_estudios[]")[{{$j}}].value = "{{dateFormate::ToFormatInverse($estudios[$j]['fecha_terminacion_estudio'])}}"; 
            document.getElementsByName("institucion_estudios[]")[{{$j}}].value = "{{$estudios[$j]['institucion_estudio']}}"; 
            document.getElementsByName("titulo_obtenido_estudios[]")[{{$j}}].value = "{{$estudios[$j]['titulo_obtenido_estudio']}}"; 
            document.getElementsByName("finalizado_estudios[]")[{{$j}}].value = "{{$estudios[$j]['finalizado_estudio']}}"; 
      @endfor --}}


      /*-- ----------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN HISTORIA LABORAL
      ---- ----------------------------------------------------- --*/

      {{-- @for($j=0;$j<count($hist_laboral);$j++)
            document.getElementsByName("empresa_hist_laboral[]")[{{$j}}].value = "{{$hist_laboral[$j]['empresa']}}";
            document.getElementsByName("cargo_hist_laboral[]")[{{$j}}].value = "{{$hist_laboral[$j]['cargo']}};"
            document.getElementsByName("nombre_jefe_hist_laboral[]")[{{$j}}].value = "{{$hist_laboral[$j]['nombre_jefe_inmediato']}}";
            document.getElementsByName("fecha_ingreso_hist_laboral[]")[{{$j}}].value = "{{dateFormate::ToFormatInverse($hist_laboral[$j]['fecha_ingreso'])}}";
            document.getElementsByName("fecha_retiro_hist_laboral[]")[{{$j}}].value = "{{dateFormate::ToFormatInverse($hist_laboral[$j]['fecha_retiro'])}}";
            document.getElementsByName("personas_a_cargo_hist_laboral[]")[{{$j}}].value = "{{$hist_laboral[$j]['cantidad_personas_a_cargo']}}";
            document.getElementsByName("ultimo_salario_hist_laboral[]")[{{$j}}].value = "{{$hist_laboral[$j]['ultimo_salario']}}";
            document.getElementsByName("horario_trabajo_hist_laboral[]")[{{$j}}].value = "{{$hist_laboral[$j]['horario_trabajo']}}";
            document.getElementsByName("tipo_contrato_hist_laboral[]")[{{$j}}].value = "{{$hist_laboral[$j]['id_tipo_contrato']}}";
      @endfor --}}

      
      /*-- ---------------------------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LAS LISTAS RESTANTES DE LAS OTRAS PESTAÑAS
      ---- -------------------------------------------------------------------- --*/
	  
	  loadSelectInput("#id_tipo_documento", "{{ url('/clientes/tipodocumento/getSelectList2') }}", 2);
	  loadSelectInput("#id_pais_exp", "{{ url('/pais/getpais') }}", 2);
	  loadSelectInput("#id_pais_residencia", "{{ url('/pais/getpais') }}", 2);
	  loadSelectInput("#id_franquicia", "{{ url('/franquicia/getSelectList') }}", 2);
	  loadSelectInput("#id_tienda", "{{ url('/tienda/getSelectList') }}", 2);
	  loadSelectInput("#id_sociedad", "{{ url('/sociedad/getSelectList') }}", 2);
	  $("#id_tipo_documento, #id_pais_exp, #id_pais_residencia, #id_franquicia, #id_tienda, #id_sociedad").change();

      
	  

      $('#id_tipo_cliente').val({{$attribute->id_tipo_cliente}});
      $('#id_tienda').val({{$attribute->id_tienda}});
      $('#id_contrato').val({{$attribute->id_tipo_contrato}});
      $('#id_ciudad_trabajo').val({{$attribute->id_ciudad_trabajo}});
      $('#id_salario').val({{$attribute->salario}});
      $('#id_valor_auxilio_vivenda').val({{$attribute->valor_auxilio_vivenda}});
      $('#id_valor_auxilio_transporte').val({{$attribute->valor_auxilio_transporte}});
      $('#id_cargo_persona').val({{$attribute->id_cargo_persona}});
      $('#id_ciu_nacimiento').val({{$attribute->id_ciudad_nacimiento}});
      $('#id_ciu_residencia').val({{$attribute->id_ciudad_residencia}});
      $('#id_estado_civil').val({{$attribute->id_estado_civil}});
      $('#id_tipo_vivienda').val({{$attribute->id_tipo_vivienda}});
      $('#id_tenencia_vivienda').val({{$attribute->id_tenencia_vivienda}});
      $('#id_cargo_ejercido').val({{$attribute->id_cargo_ejercido_anterior}});
      $('#id_fondo_cesantias').val({{$attribute->id_fondo_cesantias}});
      $('#id_fondo_pensiones').val({{$attribute->id_fondo_pensiones}});
      $('#id_eps').val({{$attribute->id_eps}});
      $('#id_caja_compensacion').val({{$attribute->id_caja_compensacion}});
      $('#nivel_estudio').val({{$attribute->id_nivel_estudio}});
      $('#nivel_estudio_actual').val({{$attribute->id_nivel_estudio_actual}});
      $('select[name="id_motivo_retiro"]').val({{$attribute->id_motivo_retiro}});
      $('#id_regimen_contributivo').val({{$attribute->id_regimen_contributivo}});
      $('#talla_camisa').val({{$attribute->talla_camisa}});
      $('#talla_pantalon').val({{$attribute->talla_pantalon}});
      $('#talla_zapatos').val({{$attribute->talla_zapatos}});
      $('#rh').val({{$attribute->rh}});
      $('#id_confiabilidad').val({{$attribute->id_confiabilidad}});
      $('#genero').val({{$attribute->genero}});

      cargarInputDocumento();
    });
URL.setEmpleadoActu("clientes/proveedor/persona/natural/update");

	// validamos si uno de los campos ya esta ingresado y quitamos el requerido al otro campo.
		$('#telefono_residencia').change(function(){
			if($('#telefono_residencia').val() != '' && $('#telefono_celular').val() == ''){
				$('#telefono_celular').removeClass('requiered');
				$('#telefono_celular').removeAttr('required');
			}
		});
		$('#telefono_celular').change(function(){
			if($('#telefono_celular').val() != ''  && $('#telefono_residencia').val() == ''){
				$('#telefono_residencia').removeClass('requiered');
				$('#telefono_residencia').removeAttr('required');
			}
		});

@endsection

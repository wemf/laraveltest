<div class="row">	
	<div class="x_title"><h2>Localización de la Tienda</h2><div class="clearfix"></div></div>
		<div class="clearfix"></div>
	
	<input type="hidden" id="id_tipo_cliente_enviado" name="id_tipo_cliente_enviado" value="{{$id_tipo_cliente_enviado}}">
	<div class="col-md-6 col-xs-12">	
		<div class="form-group">
			<label class="control-label col-xs-4">Tipo Empleado<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_tipo_cliente" name="id_tipo_cliente" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($tipo_empleado as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach
				</select>
			</div>
		</div> 

		<div class="form-group">
			<label class="control-label col-xs-4">Nombre Comercial<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_franquicia" name="id_franquicia" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($sociedad as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-xs-4">Sociedad<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_sociedad" name="id_sociedad" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($sociedad as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div> 

		<input type="hidden" id="codigo_cliente" name = "codigo_cliente">

		<div class="form-group">
			<label class="control-label col-xs-4">Tienda<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_tienda" name="id_tienda" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
				</select>
			</div>
		</div> 

		<div class="form-group">
			<label class="control-label col-xs-4">Cargo<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_cargo_empleado" name="id_cargo_empleado" class="form-control  id_cargo_empleado">
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
			<label class="control-label col-xs-4">País en donde desempeña
			</label>
			<div class="col-xs-8">
				<select id="id_pais_trabajo" class="form-control  id_pais" disabled></select>
			</div>
		</div>
		 
		<div class="form-group">
			<label class="control-label col-xs-4">Departamento en donde desempeña
			</label>
			<div class="col-xs-8">
				<select id="id_departamento_trabajo" class="form-control " disabled></select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad en donde desempeña<span class="required">*</span>
			</label>
			<div class="col-xs-8">
				<select id="id_ciudad_trabajo" name="id_ciudad_trabajo" class="form-control  requiered" disabled></select>				
			</div>
		</div>

		<div class="form-group id_zona_cargo hide">
			<label class="control-label col-xs-4">Zona<span class="required">*</span></label>
			<div class="col-xs-8">
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
			<label class="control-label col-xs-4">Tipo de Documento
			</label>
			<div class="col-xs-8">
				<select id="id_tipo_documento" name="id_tipo_documento" class="form-control requiered tipo_documento">
					<option value="">- Seleccione una opción -</option>
					@foreach($tipo_documento as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Número de Documento
			</label>
			<div class="col-xs-8">
				<input type="text" id="numero_documento" name="numero_documento" maxlength="12" value="{{$attribute->numero_documento}}" class="form-control  requiered ">
			</div>
		</div> 

		<div class="form-group">
			<label class="control-label col-xs-4">Fecha Expedición<span class="required">*</span>
				</label>
				<div class="col-xs-8">
					@if(Request::old('fecha_expedicion'))
					<input readonly type="text" name="fecha_expedicion" class="form-control  requiered data-picker-until-today" value="{{Request::old('fecha_expedicion')}}">
					@else
					<input readonly type="text" name="fecha_expedicion" value='{{dateFormate::ToFormatInverse("$attribute->fecha_expedicion")}}' class="form-control  requiered data-picker-until-today">
					@endif
				</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">País de Expedición
			</label>
			<div class="col-xs-8">
				<select id="id_pais_exp" name="id_pais_expedicion" type="text" class="form-control  id_pais id_pais_parametro requiered" data-sufijo="exp">
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
				<select id="id_dep_exp" type="text" class="form-control  id_departamento "></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Expedición
			</label>
			<div class="col-xs-8">
				<select id="id_ciu_exp"  name="id_ciudad_expedicion" class="form-control  id_ciudad"></select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Nombre Completo
			</label>
			<div class="col-xs-8">
				<input type="text" name="nombres" value="{{$attribute->nombres}}" maxlength="100" class="form-control  requiered">
			</div>
		</div> 
		
		<div class="form-group">
			<label class="control-label col-xs-4">Primer Apellido
			</label>
			<div class="col-xs-8">
				<input type="text" name="primer_apellido" value="{{$attribute->primer_apellido}}" maxlength="50" class="form-control  requiered">
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
			<label class="control-label col-xs-4">Género
			</label>
			<div class="col-xs-8">
				<select type="text" name="genero" id="genero" class="form-control  requiered">
					<option value="">--Seleccionar--</option>
					<option value="1">Masculino</option>
					<option value="2">Femenino</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Libreta Militar
			</label>
			<div class="col-xs-8">
				<input value="{{$attribute->libreta_militar}}" maxlength="15" class="form-control " type="text" name="libreta_militar" id="libreta_militar" class="form-control ">
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Distrito Militar
			</label>
			<div class="col-xs-8">
				<input value="{{$attribute->distrito_militar}}" maxlength="15" class="form-control " type="text" name="distrito_militar" id="distrito_militar" class="form-control ">
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Correo Electrónico
			</label>
			<div class="col-xs-8">
				<input value="{{$attribute->correo_electronico}}" class="form-control  requiered requieredEmail" type="text" name="correo_electronico" class="form-control email_validado">
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-xs-4">Grupo Sanguíneo
			</label>
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
			<label class="control-label col-xs-4">Estado Civil
			</label>
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
			<label class="control-label col-xs-4">Tipo de Vivienda
			</label>
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
			<label class="control-label col-xs-4">Fecha de Nacimiento
			</label>
			<div class="col-xs-8">
				<input readonly id="fecha_nacimiento" name="fecha_nacimiento" value='{{dateFormate::ToFormatInverse("$attribute->fecha_nacimiento")}}' class="form-control  data-picker-until-today">
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">País de Nacimiento<span class="required">*</span></label>
			<div class="col-xs-8">
				<select id="id_pais_nacimiento" name="id_pais_nacimiento"  class="form-control id_pais id_pais_parametro" data-sufijo="nacimiento">
					<option value="">- Seleccione una opción -</option>
					@foreach($pais as $tipo)
					<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Departamento de Nacimiento
			</label>
			<div class="col-xs-8">
				<select id="id_dep_nacimiento" class="id_departamento form-control "></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Nacimiento
			</label>
			<div class="col-xs-8">
				<select id="id_ciu_nacimiento"  name="id_ciudad_nacimiento" class="id_ciudad form-control "></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">País de Residencia
			</label>
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
			<label class="control-label col-xs-4">Departamento de Residencia
			</label>
			<div class="col-xs-8">
				<select id="id_dep_residencia" type="text" class="form-control  id_departamento"></select>
			</div>
		</div> 
		<div class="form-group">
			<label class="control-label col-xs-4">Ciudad de Residencia
			</label>
			<div class="col-xs-8">
				<select id="id_ciu_residencia" type="text" name="id_ciudad_residencia" class="form-control  id_ciudad requiered"></select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Dirección Residencia
			</label>
			<div class="col-xs-8">
				<input type="text" name="direccion_residencia" id="direccion_residencia" data-pos="1" value="{{$attribute->direccion_residencia}}" class="form-control  direccion requiered">
			</div>
		</div> 

		<div class="form-group">
			<label class="control-label col-xs-4">Barrio Residencia
			</label>
			<div class="col-xs-8">
				<input type="text" name="barrio_residencia" value="{{$attribute->barrio_residencia}}" class="form-control  requiered">
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Teléfono Residencia
			</label>
			<div class="col-xs-8" style="font-size: 0;">
				<input type="text" name="telefono_residencia_indicativo" style="font-size: 13px !important;" maxlength="10" id="telefono_residencia_indicativo" maxlength="5" class="form-control  tl telefono_indicativo" readOnly>
				<input maxlength="10"  class="form-control requiered tlx numeric" style="font-size: 13px !important;" type="text" name="telefono_residencia" id="telefono_residencia" class="form-control  ">
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4" >Teléfono Celular
			</label>
			<div class="col-xs-8" style="font-size: 0;">
				<input type="text" name="telefono_celular_indicativo" style="font-size: 13px !important;" maxlength="10" id="telefono_celular_indicativo" maxlength="5" class="form-control  tl telefono_indicativo_celular" readOnly>
				<input maxlength="10" class="form-control  requiered numeric tlx" style="font-size: 13px !important;" type="text" name="telefono_celular" id="telefono_celular" class="form-control ">
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Talla Camisa
			</label>
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
			<label class="control-label col-xs-4">Talla Pantalón
			</label>
			<div class="col-xs-8">
				<select id="talla_pantalon" name="talla_pantalon" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($talla_n as $tipo)
					<option value="{{ $tipo->id }}"@if($tipo->id == $attribute->talla_pantalon) selected="selected" @endif>{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Talla Zapatos
			</label>
			<div class="col-xs-8">
				<select id="talla_zapatos" name="talla_zapatos" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($talla_n as $tipo)
					<option value="{{ $tipo->id }}"@if($tipo->id == $attribute->talla_zapatos) selected="selected" @endif>{{ $tipo->name }}</option>
					@endforeach 
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-4">Tenencia Vivienda
			</label>
			<div class="col-xs-8">
				<select id="id_tenencia_vivienda" name="id_tenencia_vivienda" class="form-control  requiered">
					<option value="">- Seleccione una opción -</option>
					@foreach($tenencia_vivienda as $tipo)
						<option value="{{ $tipo->id }}"@if($tipo->id == $attribute->tenencia_vivienda) selected="selected" @endif>{{ $tipo->name }}</option>					
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

@section('javascript')   
	URL.setTipoDocumento(" {{ url('/clientes/tipodocumento/getAlfanumerico') }} ");
	URL.setUrlList("{{ url('/clientes/empleado/getSelectList') }}");
    URL.setUrlListById("{{ url('/clientes/empleado/getSelectListById') }}");
    URL.setUrlListFranquicia("{{ url('/franquicia/getSelectList') }}");
    URL.setUrlListSociedadByFranquicia("{{ url('/sociedad/getSelectListFranquiciaSociedad') }}");
    URL.setCompleteEmpleados("{{ url('/clientes/empleado/getAutoComplete') }}");
    URL.setAction("{{ url('/clientes/empleado/update') }}");
    URL.setActionUser("{{ url('/users/registerAjax') }}");
    URL.setAction2("{{ url('/users/updateAjax') }}");
    URL.setEmpleado(" {{ url('/clientes/empleado/getEmpleadoIden') }} ");
    // alert(URL.getActionUser());
    URL.setUser(" {{ url('/clientes/empleado/getUser') }} ");
    URL.setTiendaZona("{{ url('/clientes/empleado/getTiendaZona/') }}");
    URL.setCombos("{{ url('/clientes/empleado/getCombos/') }}");
    URL.setTipoDocumento(" {{ url('/clientes/tipodocumento/getAlfanumerico') }} ");
    URL.setParametroGeneral("{{ url('/clientes/empleado/getparametroGeneral') }}");
    URL_CLIENTE.setURLValidarDocumento("{{ url('/clientes/funciones/getValidarDocumento') }}");
    URL_CLIENTE.getEmpleadoActualizar("{{ url('/clientes/empleado/update') }}");
    URL_CLIENTE.getPersonaNaturalActualizar("{{ url('/clientes/persona/natural/update') }}");
    URL_CLIENTE.getProveedorNaturalActualizar("{{ url('/clientes/proveedor/persona/natural/update') }}");
    URL_CLIENTE.setActualizarThis("{{ url('/clientes/empleado/update') }}");


    /*-- ----------------------------------------------------------- ----
    ---- ----------------------------------------------------------- --*/   
    
    var y = '{{$attribute->telefono_celular}}';
    var x = y.split(" ");

    $('#telefono_celular').val(x[1]);
    if(x[1] == "" || x[1] === undefined) 
    {
      $('#telefono_celular').val(x[0]);
    }  
    
    var y1 = '{{$attribute->telefono_residencia}}';
    var x1 = y1.split(" ");
     
    $('#telefono_residencia').val(x1[1]);
    if(x1[1] == "" || x1[1] === undefined) 
    {
      $('#telefono_residencia').val(x1[0]);
    }  
    
    console.log('{{$attribute->codigo_cliente}}');
    $('#codigo_cliente').val({{$attribute->codigo_cliente}});
    $('#id_contrato').val({{$attribute->id_tipo_contrato}});
    $('#id_ciudad_trabajo').val({{$attribute->id_ciudad_trabajo}});
    // $('#id_salario').val({{$attribute->salario}});
    // $('#id_valor_auxilio_vivenda').val({{$attribute->valor_auxilio_vivenda}});
    // $('#id_valor_auxilio_transporte').val({{$attribute->valor_auxilio_transporte}});
    $('#id_cargo_empleado').val({{$attribute->id_cargo_empleado}});
    $('#id_tipo_documento').val({{$attribute->id_tipo_documento}});
    $('#id_ciu_exp').val({{$attribute->id_ciudad_expedicion}});
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
    $('#talla_camisa').val({{$attribute->talla_camisa}});
    $('#talla_pantalon').val({{$attribute->talla_pantalon}});
    $('#talla_zapatos').val({{$attribute->talla_zapatos}});
    $('#rh').val({{$attribute->rh}});
    $('#genero').val({{$attribute->genero}});
    

    $(document).ready(function()
    {

      /*-- ----------------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN FAMILIARES EN NUTIBARA
      ---- ----------------------------------------------------------- --*/    

      @if(count($familiar_nutibara) > 0)

        $('input[name="familiares_en_nutibara"][value=1]').attr('checked','checked');
        $('#panel-familiares-nutibara #dataTable').find('input,select,textarea').removeClass('requiered').attr('disabled', 'disabled');
        $('#panel-familiares-nutibara').css('opacity','1');
        $('#panel-familiares-nutibara').find('.id_tipo_parentesco').addClass('requiered').removeAttr('disabled');
        $('#panel-familiares-nutibara').find('.borrar-fila,.hd_id_tienda_pariente,.hd_codigo_cliente_pariente').removeAttr('disabled'); 
        
        @for($i=0;$i<count($familiar_nutibara);$i++)
            document.getElementsByName("id_tienda_pariente[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['id_tienda_pariente']}}";  
            document.getElementsByName("codigo_cliente_pariente[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['codigo_cliente_pariente']}}";  
            document.getElementsByName("id_tipo_documento_parientes[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['id_tipo_documento']}}";  
            document.getElementsByName("identificacion_parientes[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['numero_documento']}}";  
            document.getElementsByName("nombre_parientes[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['nombre']}}";  
            document.getElementsByName("fecha_nacimiento_parientes[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['fecha_nacimiento']}}";  
            document.getElementsByName("id_tipo_parentesco[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['id_tipo_parentesco']}}";  
            document.getElementsByName("id_cargo_pariente[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['id_cargo_empleado']}}";  
            document.getElementsByName("ciudad_pariente[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['id_ciudad_residencia']}}";  
        @endfor 

      @else
        $('input[name="familiares_en_nutibara"][value=0]').attr('checked','checked');
        $('#panel-familiares-nutibara').css('opacity','0.5');
        $('#panel-familiares-nutibara #dataTable').find('input,select,textarea').removeClass('requiered').attr('disabled', 'disabled');
      @endif


      /*-- --------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN GRUPO FAMILIAR
      ---- --------------------------------------------------- --*/

      @if(count($familiar) > 0)

        @for($j=0;$j<count($familiar);$j++)
        
            document.getElementsByName("id_tienda_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_tienda']}}";  
            document.getElementsByName("codigo_cliente_familiares[]")[{{$j}}].value = "{{$familiar[$j]['codigo_cliente']}}";  
            document.getElementsByName("id_tipo_documento_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_tipo_documento']}}";  
            document.getElementsByName("identificacion_familiares[]")[{{$j}}].value = "{{$familiar[$j]['numero_documento']}}"; 
            document.getElementsByName("nombres_completos_familiares[]")[{{$j}}].value = "{{$familiar[$j]['nombre']}}";
            document.getElementsByName("id_parentesco_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_tipo_parentesco']}}";  			
            document.getElementsByName("fecha_nacimiento_familiares[]")[{{$j}}].value ='{{dateFormate::ToFormatInverse($familiar[$j]['fecha_nacimiento'])}}'; 
            document.getElementsByName("id_genero_familiares[]")[{{$j}}].value = "{{$familiar[$j]['genero']}}"; 
            @if($familiar[$j]['beneficiario'] == "Si")
              document.getElementsByName("hd_beneficiario[]")[{{$j}}].value = "1";
              document.getElementsByName("beneficiario[]")[{{$j}}].checked = true;
            @else
              document.getElementsByName("hd_beneficiario[]")[{{$j}}].value = "0";
            @endif
            document.getElementsByName("ocupacion_familiares[]")[{{$j}}].value = "{{$familiar[$j]['ocupacion']}}";    
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
            @endif
            //document.getElementsByName("semestre_familiares[]")[{{$j}}].value = "{{$familiar[$j]['vive_con_persona_familiares']}}"; 
        @endfor

      @endif


      /*-- ------------------------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN CONTACTO EN CASO DE EMERGENCIA
      ---- ------------------------------------------------------------------- --*/

      @if(count($contacto_emergencia) > 0)

        @for($k=0;$k<count($contacto_emergencia);$k++)
            document.getElementsByName("id_tienda_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_tienda']}}";
            document.getElementsByName("codigo_cliente_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['codigo_cliente']}}";
            document.getElementsByName("id_tipo_documento_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_tipo_documento']}}";
            document.getElementsByName("identificacion_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['numero_documento']}}";
            document.getElementsByName("nombre_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['nombre']}}";
			document.getElementsByName("primer_apellido_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['primer_apellido']}}";
            document.getElementsByName("segundo_apellido_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['segundo_apellido']}}";
            document.getElementsByName("parentesco_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_tipo_parentesco']}}";  
            document.getElementsByName("direccion_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['direccion_residencia']}}";    
            document.getElementsByName("ciudad_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_ciudad_residencia']}}"; 
            document.getElementsByName("telefono_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['telefono_residencia']}}"; 
        @endfor

      @endif


        /*-- ---------------------------------------------------------------------- ----
        ---- SE CARGA INFORMACIÓN PARA LAS LISTAS RESTANTES DE LAS OTRAS PESTAÑAS
        ---- -------------------------------------------------------------------- --*/
        $('#id_pais_exp').val({{ $attribute->id_pais_expedicion }}); 
        $('#id_pais_exp').change();
        $('#id_dep_exp').val({{ $attribute->id_departamento_expedicion }}); 
        $('#id_dep_exp').change();
        $('#id_ciu_exp').val({{ $attribute->id_ciudad_expedicion }}); 

        $('#id_pais_nacimiento').val({{ $attribute->id_pais_nacimiento }}); 
        $('#id_pais_nacimiento').change();
        $('#id_dep_nacimiento').val({{ $attribute->id_departamento_nacimiento }}); 
        $('#id_dep_nacimiento').change();
        $('#id_ciu_nacimiento').val({{ $attribute->id_ciudad_nacimiento }});

        $('#id_pais_residencia').val({{ $attribute->id_pais_residencia }}); 
        $('#id_pais_residencia').change();
        $('#id_dep_residencia').val({{ $attribute->id_departamento_residencia }}); 
        $('#id_dep_residencia').change();
        $('#id_ciu_residencia').val({{ $attribute->id_ciudad_residencia }}); 
        $('#id_ciu_residencia').change();
        $('#id_tipo_cliente').val({{$attribute->id_tipo_cliente}});
        $('#id_tipo_cliente').change().attr('disabled',true);
        $('#id_franquicia').val({{$attribute->franquicia}});
        $('#id_franquicia').change().attr('disabled',true);
        $('#id_sociedad').val({{ $attribute->id_sociedad }}); 
        $('#id_sociedad').change().attr('disabled',true);
        $('#id_tienda').val({{ $attribute->id_tienda }}); 
        $('#id_tienda').change().attr('disabled',true);
		$('#id_cargo_empleado').change();		
        $('#id_zona_cargo').val({{ $attribute->id_zona_encargado }}); 
		$('#genero').change();		
    });

      /*-- ---------------------------------------------------------------------- ----
        ---- SE CARGA LA INFORMACION DE CREACION DE USUARIO.
        ---- -------------------------------------------------------------------- --*/
        $('#id_role').val({{$attribute->id_role}});
        $('#modo_ingreso').val({{$attribute->modo_ingreso}});
@endsection
@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-11">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Provedor Persona Jurídica</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="javascript:void(0)" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')  
          <div id="tabs">
            <ul class="tabs-nav">
              <li class="tabs-1"><a href="#tabs-1">Datos Generales</a></li>
            </ul>
            <div id="tabs-1" class="contenido-tab">
                  <input type="hidden" name="id_tipo_cliente" value="6">
                  <div class="x_title">
                    <h2>Datos del Provedor</h2>
                    <div class="clearfix"></div>
                  </div> 


                  <div class="form-group">
                    <input type="hidden" id="id_tipo_documento" name="id_tipo_documento" value="32">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nit<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">               
                      <div class="input-group">           
                        <input type="text" id="numero_documento" name="numero_documento" class="form-control nit" readOnly value="{{$attribute->numero_documento}}" >
                        <span class="input-group-addon white-color"><input id="prueba" name="digito_verificacion" readOnly value="{{$attribute->digito_verificacion}}" type="text" class="nit-val"></span>
                      </div>
                    </div>
                  </div> 
 
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre o Razón Social<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('nombres'))
                        <input type="text" name="nombres" required class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('nombres')}}">
                      @else
                        <input type="text" name="nombres" required class="form-control col-md-7 col-xs-12 requiered" value="{{$attribute->nombres}}">
                      @endif
                    </div>
                  </div>   
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Dirección<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('direccion_residencia'))
                        <input type="text" id="direccion_residencia" required name="direccion_residencia" data-pos="1" class="form-control col-md-7 col-xs-12 requiered direccion " value="{{Request::old('direccion_residencia')}}">
                      @else
                        <input type="text" id="direccion_residencia" required name="direccion_residencia" data-pos="1" class="form-control col-md-7 col-xs-12 requiered direccion " value="{{$attribute->direccion_residencia}}">
                      @endif
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Barrio<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('barrio_residencia'))
                        <input type="text" name="barrio_residencia" required class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('barrio_residencia')}}">
                      @else
                        <input type="text" name="barrio_residencia" required class="form-control col-md-7 col-xs-12 requiered" value="{{$attribute->barrio_residencia}}">
                      @endif
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">País<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">                      
                      <select id="id_pais_residencia" required data-load="{{ $attribute->id_pais_residencia }}" onchange="clearSelects([['id_dep_residencia', 'delete_options'],['id_ciu_residencia', 'delete_options']], 1); loadSelectChild(this, '#id_dep_residencia', '{{ url('/departamento/getdepartamentobypais') }}');" name="id_pais_residencia" type="text" class="form-control id_pais id_pais_parametro" data-sufijo="residencia"></select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Departamento<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
				              <select id="id_dep_residencia" required data-load="{{ $attribute->id_departamento_residencia }}" onchange="clearSelects([['id_ciu_residencia', 'delete_options']], 1); loadSelectChild(this, '#id_ciu_residencia', '{{ url('/ciudad/getciudadbydepartamento') }}');" type="text" class="form-control  id_departamento"></select>                      
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ciudad<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
              				<select id="id_ciu_residencia" required data-load="{{ $attribute->id_ciudad_residencia }}" type="text" name="id_ciudad_residencia" class="form-control  id_ciudad "></select>      
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono<span class="required">*</span>
                    </label>
                    <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="col-md-2" style="padding:0;">
                      <input type="text" id="telefono_indicativo_res" value="{{ $indicativo2->name }}" name="telefono_indicativo_res"  readonly  maxlength="10"  class="form-control col-md-7 col-xs-12 telefono_indicativo">
                    </div>
                    <div class="col-md-8" style="padding:0;">
                      <input type="text" id="telefono_residencia" required name="telefono_residencia" maxlength="10" value="{{ $attribute->telefono_residencia }}" class="form-control col-md-7 col-xs-12 obligatorio justNumbers maskTelefono ">
                        </div>
                      </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono Celular<span class="required">*</span>
                    </label>
                    <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="col-md-2" style="padding:0;">
                      <input type="text" id="telefono_indicativo_cel" value="{{ $indicativo1->name }}" name="telefono_indicativo_cel"  readonly  maxlength="10"  class="form-control col-md-7 col-xs-12 telefono_indicativo_celular">
                    </div>
                    <div class="col-md-8" style="padding:0;">
                      <input type="text" id="telefono_celular" required name="telefono_celular" maxlength="10" value="{{ $attribute->telefono_celular }}" class="form-control col-md-7 col-xs-12 obligatorio justNumbers maskTelefono">
                        </div>
                      </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Correo Electrónico<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('correo_electronico'))
                        <input type="email" name="correo_electronico" required class="form-control col-md-7 col-xs-12 requiered email_validado" value="{{Request::old('correo_electronico')}}">
                      @else
                        <input type="email" name="correo_electronico" required class="form-control col-md-7 col-xs-12 requiered email_validado" value="{{$attribute->correo_electronico}}">
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre Contacto<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('contacto'))
                        <input type="text" name="contacto" required class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('contacto')}}">
                      @else
                        <input type="text" name="contacto" required class="form-control col-md-7 col-xs-12 requiered" value="{{$attribute->contacto}}">
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono de Contacto<span class="required">*</span>
                    </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="col-md-2" style="padding:0;">
                      <input type="text" id="telefono_indicativo_con" value="{{ $indicativo2->name }}" name="telefono_indicativo_con"  readonly  maxlength="10"  class="form-control col-md-7 col-xs-12 telefono_indicativo">
                    </div>
                    <div class="col-md-8" style="padding:0;">
                      <input type="text" id="telefono_contacto" required name="telefono_contacto" maxlength="10" value="{{ $attribute->telefono_contacto }}" class="form-control col-md-7 col-xs-12 obligatorio justNumbers maskTelefono ">
                        </div>
                      </div>
                   </div>
              
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Representante Legal<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('representante_legal'))
                        <input type="text" name="representante_legal" required class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('representante_legal')}}">
                      @else
                        <input type="text" name="representante_legal" required class="form-control col-md-7 col-xs-12 requiered" value="{{$attribute->representante_legal}}">
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Número de Documento Representante<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('numero_documento_representante'))
                        <input type="text" maxlength="15" required name="numero_documento_representante" class="form-control col-md-7 col-xs-12 requiered justNumbers" value="{{Request::old('numero_documento_representante')}}">
                      @else
                        <input type="text" maxlength="15" required name="numero_documento_representante" class="form-control col-md-7 col-xs-12 requiered justNumbers " value="{{$attribute->numero_documento_representante}}">
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Régimen Contributivo<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="id_regimen_contributivo" required name="id_regimen_contributivo" class="form-control col-md-7 col-xs-12 requiered id_regimen_contributivo" data-load="{{ $attribute->id_regimen_contributivo }}"></select>
                    </div>
                  </div> 
            </div>
          </div>    
          <br>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="hidden" id="codigo_cliente" name="codigo_cliente" value="{{$attribute->codigo_cliente}}">
              <input type="hidden" id="hd_id_tienda" name="id_tienda_actual" value="{{$attribute->id_tienda}}" >
            </div>
          </div>

          <div class="x_title">
            <h2>Sucursales</h2>
            <div class="clearfix"></div>
          </div> 

          <div class="panel panel-primary">
            <div class="panel-heading">Ingrese las sucursales de este Proveedor.</div>
            <div class="panel-body">
              <button type="button" class="btn btn-info btn-agregar-fila">Agregar</button>
              <table class="table table-striped table-bordered table-hover dataTables-example3 tbl-contenido" id="dataTable">
                <thead>
                  <tr>
                    <th>Nombre Sucursal</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th>Representante</th>
                    <th>Borrar</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($sucursal_clientes AS $sucursal)
                  <tr class="tr-contenido">
                    <td>
                      <input type="hidden" name="id_tienda_sucursal[]" class="hd_id_tienda_sucursal" value= "{{ $sucursal->id_tienda_sucursal }}">
                      <input type="hidden" name="id_sucursal[]" class="hd_id_sucursal" value= "{{ $sucursal->id_sucursal }}" >
                      <input name="nombre_sucursal[]" class="form-control col-md-3" maxlength="50" value= "{{ $sucursal->sucursal }}">    
                  </td>
                    <td>
                      <select name="ciudad_sucursal[]" class="form-control col-md-2">
                      <option value="">- Seleccione una opción -</option>
                      @foreach($ciudad as $tipo)
                      <option @if($sucursal->id_ciudad == $tipo->id) selected @endif value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                      @endforeach     
                      </select>
                      </td>
                    <td><input type="text" maxlength="11" name="telefono_sucursal[]" class="form-control col-md-3 justNumbers" value= "{{ $sucursal->telefono }}"></td>
                    <td><input name="nombre_representante_sucursal[]" class="form-control col-md-3" value= "{{ $sucursal->representante }}"></td>
                    <td>
                      <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>
                    </td>
                  </tr>
                  @endforeach
                  @if(!isset($sucursal_clientes[0]))
                  <tr class="tr-contenido">
                    <td>
                      <input type="hidden" name="id_tienda_sucursal[]" class="hd_id_tienda_sucursal" >
                      <input type="hidden" name="id_sucursal[]" class="hd_id_sucursal" >
                      <input name="nombre_sucursal[]" class="form-control col-md-3" maxlength="50">    
                  </td>
                    <td>
                      <select name="ciudad_sucursal[]" class="form-control col-md-2 id_ciudad">
                      <option value="">- Seleccione una opción -</option>
                      @foreach($ciudad as $tipo)
                      <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                      @endforeach     
                      </select>
                      </td>
                    <td><input type="text" maxlength="11" name="telefono_sucursal[]" class="form-control col-md-3 justNumbers"></td>
                    <td><input name="nombre_representante_sucursal[]" class="form-control col-md-3"></td>
                    <td>
                      <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/clientes/proveedor/persona/juridica') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="{{asset('/js/clientes/personaJuridica/personaJuridica.js')}}"></script>
<script src="{{asset('/js/clientes/clientes.js')}}"></script>
@endpush
@section('javascript')
    
	  loadSelectInput("#id_pais_residencia", "{{ url('/pais/getpais') }}", 2);
	  $("#id_pais_residencia").change();

    URL.setUrlList("{{ url('/clientes/persona/juridica/getSelectList') }}");
    URL.setUrlListById("{{ url('/clientes/persona/juridica/getSelectListById') }}");
    {{--  URL.setCompletepersonaNaturals("{{ url('/clientes/persona/natural/getAutoComplete') }}");  --}}
    URL.setAction("{{ url('/clientes/proveedor/persona/juridica/update') }}");
    URL.setUrlListTipoDoc("{{ url('/clientes/getTipoDoc') }}");
    URL.setTiendaZona("{{ url('/clientes/empleado/getTiendaZona/') }}");
    URL.setCombos("{{ url('/clientes/empleado/getCombos/') }}");
    URL.setDate('{{ $date }}');
    URL.setEmpleado(" {{ url('/clientes/empleado/getEmpleadoIden') }} ");
    URL.setTipoDocumento(" {{ url('/clientes/tipodocumento/getAlfanumerico') }} ");
    URL_CLIENTE.setURLValidarDocumento("{{ url('/clientes/funciones/getValidarDocumento') }}");

    
    $(document).ready(function(){
        $('#id_tipo_cliente').val({{$attribute->id_tipo_cliente}});
        $('#id_tienda').val({{$attribute->id_tienda}});
        $('#id_ciu_residencia').val({{$attribute->id_ciudad_residencia}});
        $('#id_regimen_contributivo').val({{$attribute->id_regimen_contributivo}});
        $('#id_pais_residencia').val({{ $attribute->id_pais_residencia }}); 
        $('#id_pais_residencia').change();
        $('#id_dep_residencia').val({{ $attribute->id_departamento_residencia }}); 
        $('#id_dep_residencia').change();
        $('#id_ciu_residencia').val({{ $attribute->id_ciudad_residencia }}); 
        $('#id_ciu_residencia').change();
    });

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
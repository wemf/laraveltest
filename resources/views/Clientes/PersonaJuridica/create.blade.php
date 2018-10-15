@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-11 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Cliente Persona Jurídica</h2>
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
                  <input type="hidden" name="id_tipo_cliente" value="4">
                  <div class="x_title">
                    <h2>Localización de la Joyería</h2>
                    <div class="clearfix"></div>
                  </div> 

                  <div class="form-group">
                    <label class="control-label col-xs-3">Nombre Comercial<span class="required">*</span></label>
                    <div class="col-xs-6">
                      <select id="id_franquicia" name="id_franquicia" required class="form-control requiered" readonly>
                        <option value="{{ $franquiciahubicado[0]['id'] }}">{{ $franquiciahubicado[0]['name'] }}</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sociedad<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="id_sociedad" name="id_sociedad" required class="form-control col-md-7 col-xs-12 requiered" readonly >
                        <option value="{{ $sociedad[0]['id'] }}">{{ $sociedad[0]['name'] }}</option>
                      </select>
                    </div>
                  </div> 
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Joyería<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="id_tienda" name="id_tienda" required class="form-control col-md-7 col-xs-12 requiered" readonly>
                        <option value="{{ $tienda->id }}">{{ $tienda->nombre }}</option>
                      </select>
                    </div>
                  </div> 
                  </br>  
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
                        <input type="text" id="numero_documento" required name="numero_documento" class="form-control nit" required>
                        <span class="input-group-addon white-color"><input id="prueba" name="digito_verificacion" type="text" class="nit-val" required></span>
                      </div>
                    </div>
                  </div> 
                  
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre o Razón Social<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('nombres'))
                        <input type="text" required name="nombres" class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('nombres')}}">
                      @else
                        <input type="text" required name="nombres" class="form-control col-md-7 col-xs-12 requiered">
                      @endif
                    </div>
                  </div>   
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Dirección Residencia<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('direccion_residencia'))
                        <input type="text" required name="direccion_residencia" id="direccion_residencia" data-pos="1" class="form-control col-md-7 col-xs-12  direccion requiered" value="{{Request::old('direccion_residencia')}}">
                      @else
                        <input type="text" required name="direccion_residencia" id="direccion_residencia" data-pos="1" class="form-control col-md-7 col-xs-12  direccion requiered">
                      @endif
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Barrio<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('barrio_residencia'))
                        <input type="text" required name="barrio_residencia" class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('barrio_residencia')}}">
                      @else
                        <input type="text" required name="barrio_residencia" class="form-control col-md-7 col-xs-12 requiered">
                      @endif
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">País<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="id_pais_residencia" required name="id_pais_residencia" type="text" class="form-control col-md-7 col-xs-12 id_pais id_pais_parametro requiered" data-sufijo="residencia">
                          <option value="">- Seleccione una opción -</option>
                          @foreach($pais as $tipo)
                          <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                          @endforeach  
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Departamento<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="id_dep_residencia" required type="text" class="form-control col-md-7 col-xs-12"></select>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ciudad<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="id_ciu_residencia" required type="text" name="id_ciudad_residencia" class="form-control col-md-7 col-xs-12 requiered"></select>
                    </div>
                  </div> 

                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Telefono <span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                      <div class="col-md-2" style="padding:0;">
                        <input type="text" required id="telefono_indicativo_res" name="telefono_indicativo_res" readonly maxlength="7" class="form-control col-md-7 col-xs-12 obligatorio telefono_indicativo"  value="{{Request::old('telefono_indicativo')}}">
                      </div>
                      <div class="col-md-8" style="padding:0;">
                        <input type="text" required id="telefono_residencia" name="telefono_residencia" maxlength="10" class="form-control col-md-7 col-xs-12 obligatorio justNumbers maskTelefono" value="{{Request::old('telefono_residencia')}}">
                      </div>
                    </div> 
                  </div>

                 <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono Celular<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="col-md-2" style="padding:0;">
                          <input type="text" id="telefono_indicativo_cel" required name="telefono_indicativo_cel" readonly maxlength="7" class="form-control col-md-7 col-xs-12 obligatorio telefono_indicativo_celular"  value="{{Request::old('telefono_indicativo')}}">
                        </div>
                        <div class="col-md-8" style="padding:0;">
                          <input type="text" id="telefono_celular" required name="telefono_celular" maxlength="10" class="form-control col-md-7 col-xs-12 obligatorio justNumbers maskTelefono" value="{{Request::old('telefono_celular')}}">
                        </div>
                    </div> 
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Correo Electrónico<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('correo_electronico'))
                        <input type="email" name="correo_electronico" required class="form-control col-md-7 col-xs-12 email_validado requiered" value="{{Request::old('correo_electronico')}}">
                      @else
                        <input type="email" name="correo_electronico" required class="form-control col-md-7 col-xs-12 email_validado requiered">
                      @endif
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Contacto<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('contacto'))
                        <input type="text" required name="contacto" class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('contacto')}}">
                      @else
                        <input type="text" required name="contacto" class="form-control col-md-7 col-xs-12 requiered">
                      @endif
                    </div>
                  </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono de Contacto<span class="required">*</span>
                  </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="col-md-2" style="padding:0;">
                          <input type="text" required id="telefono_indicativo_con" name="telefono_indicativo_con" readonly maxlength="7" class="form-control col-md-7 col-xs-12 obligatorio telefono_indicativo"  value="{{Request::old('telefono_indicativo')}}">
                        </div>
                        <div class="col-md-8" style="padding:0;">
                          <input type="text" required id="telefono_contacto" name="telefono_contacto" maxlength="10" class="form-control col-md-7 col-xs-12 obligatorio justNumbers maskTelefono" value="{{Request::old('telefono_contacto')}}">
                        </div>
                    </div> 
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Representante Legal<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('representante_legal'))
                        <input type="text" required name="representante_legal" class="form-control col-md-7 col-xs-12 requiered" value="{{Request::old('representante_legal')}}">
                      @else
                        <input type="text" required name="representante_legal" class="form-control col-md-7 col-xs-12 requiered">
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Número de Documento Representante<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      @if(Request::old('numero_documento_representante'))
                        <input type="text" required maxlength="15" name="numero_documento_representante" class="form-control col-md-7 col-xs-12 requiered justNumbers" value="{{Request::old('numero_documento_representante')}}">
                      @else
                        <input type="text" required maxlength="15" name="numero_documento_representante" class="form-control col-md-7 col-xs-12 requiered justNumbers">
                      @endif
                    </div>
                  </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Régimen Contributivo<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="id_regimen_contributivo" required name="id_regimen_contributivo" class="form-control col-md-7 col-xs-12  id_regimen_contributivo requiered"></select>
                  </div>
                </div> 
            </div>   
          </div>    
          <br>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/clientes/persona/juridica') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
        </form>
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
    URL.setUrlList("{{ url('/clientes/persona/juridica/getSelectList') }}");
    URL.setAction("{{ url('/clientes/persona/juridica/create') }}");
    URL.setTipoDocumento(" {{ url('/clientes/tipodocumento/getAlfanumerico') }} ");
    URL_CLIENTE.setURLValidarDocumento("{{ url('/clientes/funciones/getValidarDocumento') }}");
    runPersistenceForm();

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

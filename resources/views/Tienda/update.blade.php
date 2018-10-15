@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div id="pnl-tienda" class="col-md-8 col-md-offset-2"> 
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Joyería/Establecimiento Administrativo</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('tienda/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">País <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_pais" name="id_pais" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Zona <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_zona" name="id_zona" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Departamento <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_departamento" name="id_departamento" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>  

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Ciudad <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_ciudad" name="id_ciudad" class="form-control col-md-7 col-xs-12" >
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre Comercial <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_franquicia" name="id_franquicia" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sociedad <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_sociedad" name="id_sociedad" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código Tienda <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input title="No puedes ingresar numeros negativos" type="number" min = '0' name="codigo_tienda" required="required" class="form-control col-md-7 col-xs-12" value="{{ $attribute->codigo_tienda }}">
            </div>
          </div> 
               
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" required="required" class="form-control col-md-7 col-xs-12" value="{{ $attribute->nombre }}">
            </div>
          </div> 
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Ip Fija <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id='ip_fija' type="text" name="ip_fija" id="ip_fija" onBlur ="validarCampo('ip_fija')" required="required" class="form-control col-md-7 col-xs-12 maskIp" value="{{ $attribute->ip_fija }}">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Dirección <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="direccion" id="direccion" required="required" class="form-control col-md-7 col-xs-12 direccion" data-pos="1" value="{{ $attribute->direccion }}">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Telefono <span class="required">*</span>
            </label>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <div class="col-md-2" style="padding:0;">
                <input type="text" id="telefono_indicativo" name="telefono_indicativo" readonly  maxlength="10"  class="form-control col-md-7 col-xs-12 obligatorio">
              </div>
              <div class="col-md-8" style="padding:0;">
                <input type="text" id="telefono" name="telefono" maxlength="10" value="{{ $attribute->telefono }}" class="form-control col-md-7 col-xs-12 obligatorio justNumbers maskTelefono">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tienda_padre">Tienda padre</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="tienda_padre" name="tienda_padre" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Monto Max</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha obligatorio" id="monto_max" name="monto_max" value="{{$attribute->monto_max}}" maxlength="15" aria-label="Amount (to the nearest dollar)">
              </div>
            </div>
          </div>  

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipo_bodega">Tienda tipo bodega<span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="switch_check" id="sw_tipo_bodega">
              <input type="checkbox" id="tipo_bodega" name="tipo_bodega"  onchange="intercaleCheck(this);" value="{{ $attribute->tipo_bodega }}">
              <span class="slider"></span>
            </label>
          </div>
        </div>

          <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Trabaja Festivos<span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="switch_check">
              <input type="checkbox" id="festivo" name="festivo"  onchange="intercaleCheck(this);"  value="{{ $attribute->festivo }}">
              <span class="slider"></span>
            </label>
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Horario 24 Horas<span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="switch_check">
              <input type="checkbox" id="todoeldia" name="todoeldia"  onchange="intercaleCheck(this);"  value="{{ $attribute->todoeldia }}">
              <span class="slider"></span>
            </label>
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Establecimiento Administrativo<span class="required">*</span></label>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label class="switch_check" id="sw_sede_principal">
              <input type="checkbox" id="sede_principal" name="sede_principal" onchange="intercaleCheck(this);" value="{{$attribute->sede_principal}}">
              <span class="slider"></span>
            </label>
          </div>
        </div>

        

        <div class="form-group" id="config_horarios">    
          <div class="x_title">
              <h2>Configuración horarios tienda</h2>
              <div class="clearfix"></div>
          </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label>Abre</label>
                </div>
                
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label>Cierra</label>
                </div>
              </div>
   
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Lunes
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="lunesH1" onblur="validateMinAndMax('lunesH1', 'lunesH2', 'max','time')"  name="lunesH1"                 
                  @if (isset($horario[0]))           
                    value="{{$horario[0]->hora_inicio}}"                 
                  @endif                  
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="lunesH2" onblur="validateMinAndMax('lunesH2', 'lunesH1', 'min','time')" name="lunesH2"
                  @if (isset($horario[0]))           
                    value="{{$horario[0]->hora_cierre}}"                                    
                  @endif   
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Martes
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="martesH1" onblur="validateMinAndMax('martesH1', 'martesH2', 'max','time')"  name="martesH1"  
                  @if (isset($horario[1]))           
                   value="{{$horario[1]->hora_inicio}}"                 
                  @endif
                   class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="martesH2" onblur="validateMinAndMax('martesH2', 'martesH1', 'min','time')"   name="martesH2" 
                  @if (isset($horario[1]))           
                    value="{{$horario[1]->hora_cierre}}"                 
                  @endif
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Miercoles
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="miercolesH1" onblur="validateMinAndMax('miercolesH1', 'miercolesH2', 'max','time')"   name="miercolesH1" 
                  @if (isset($horario[2]))           
                    value="{{$horario[2]->hora_inicio}}"                 
                  @endif 
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="miercolesH2" onblur="validateMinAndMax('miercolesH2', 'miercolesH1', 'min','time')"  name="miercolesH2" 
                  @if (isset($horario[2]))           
                    value="{{$horario[2]->hora_cierre}}"                 
                  @endif 
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jueves
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="juevesH1"  onblur="validateMinAndMax('juevesH1', 'juevesH2', 'max','time')"  name="juevesH1"    
                  @if (isset($horario[3]))           
                    value="{{$horario[3]->hora_inicio}}"                 
                  @endif 
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="juevesH2" onblur="validateMinAndMax('juevesH2', 'juevesH1', 'min','time')"  name="juevesH2" 
                  @if (isset($horario[3]))           
                    value="{{$horario[3]->hora_cierre}}"                 
                  @endif 
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Viernes
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="viernesH1" onblur="validateMinAndMax('viernesH1', 'viernesH2', 'max','time')"  name="viernesH1" 
                  @if (isset($horario[4]))           
                    value="{{$horario[4]->hora_inicio}}"                 
                  @endif 
                  class="day-store form-control col-md-7 col-xs-12 val" placeholder="__:__">
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="viernesH2" onblur="validateMinAndMax('viernesH2', 'viernesH1', 'min','time')"  name="viernesH2"
                   @if (isset($horario[4]))           
                    value="{{$horario[4]->hora_cierre}}"                 
                  @endif 
                   class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sabado
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="sabadoH1" onblur="validateMinAndMax('sabadoH1', 'sabadoH2', 'max','time')"  name="sabadoH1" 
                  @if (isset($horario[5]))           
                    value="{{$horario[5]->hora_inicio}}"                 
                  @endif 
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="sabadoH2" onblur="validateMinAndMax('sabadoH2', 'sabadoH1', 'min','time')"  name="sabadoH2" 
                  @if (isset($horario[5]))           
                    value="{{$horario[5]->hora_cierre}}"                 
                  @endif 
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Domingo
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="domingoH1" onblur="validateMinAndMax('domingoH1', 'domingoH2', 'max','time')"  name="domingoH1" 
                  @if (isset($horario[6]))           
                    value="{{$horario[6]->hora_inicio}}"                 
                  @endif 
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="domingoH2" onblur="validateMinAndMax('domingoH2', 'domingoH1', 'min','time')"  name="domingoH2" 
                  @if (isset($horario[6]))           
                    value="{{$horario[6]->hora_cierre}}"                 
                  @endif 
                  class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>
        </div>
   

          <input type="hidden" name="id" id = "id" value="{{$attribute->id}}">
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/tienda') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('/js/tienda.js')}}"></script>
@endpush


@section('javascript')
    @parent
    //<script>
    loadSelectInput("#id_pais","{{ url('/pais/getSelectList') }}")  
    loadSelectInput("#id_departamento","{{ url('/departamento/getSelectList') }}")  
    loadSelectInput("#id_ciudad","{{ url('/ciudad/getSelectList') }}")  
    loadSelectInput("#id_franquicia","{{ url('/franquicia/getSelectList') }}")  
    loadSelectInput("#id_sociedad","{{ url('/sociedad/getSelectList') }}")  
    loadSelectInput("#id_zona","{{ url('/zona/getSelectList') }}")  
    //Trae las tiendas padre, pero no se trae ella misma.
    fillSelect('#id', '#tienda_padre', urlBase.make('tienda/getTiendaisnt'));
    
    
    $('#id_franquicia').val({{ $attribute->id_franquicia}});
    $('#id_pais').val({{ $attribute->id_pais }});
    $('#id_sociedad').val({{ $attribute->id_sociedad }});
    $('#id_departamento').val({{ $attribute->id_departamento }}); 
    $('#id_ciudad').val({{ $attribute->id_ciudad }}); 
    $('#id_zona').val({{ $attribute->id_zona }});
    $('#tienda_padre').val({{ $attribute->tienda_padre }});
    fillInput('#id_ciudad','#telefono_indicativo',urlBase.make('ciudad/getinputindicativo2'));    


@endsection

@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div id="pnl-tienda" class="col-md-8 col-md-offset-2">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Joyería/Establecimiento Administrativo</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form  id="form-attribute" action="{{ url('/tienda/create') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')      

          <div class="form-group">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name" >País <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_pais" name="id_pais" required="required" class="form-control col-md-7 col-xs-12 id_pais_create" disabled>
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Zona <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_zona" name="id_zona" class="form-control col-md-7 col-xs-12" required="required"> 
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>    

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Departamento <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_departamento" name="id_departamento" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>  

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Ciudad <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_ciudad" name="id_ciudad" required="required" class="form-control col-md-7 col-xs-12">
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
              <input title="No puedes ingresar numeros negativos" id='codigo_tienda' type="number" onBlur ="validarCampo('codigo_tienda')"  min = '0' name="codigo_tienda" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  id='nombre' type="text" name="nombre" onBlur ="validarCampo('nombre')"  required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div> 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Ip Fija <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id='ip_fija' type="text" name="ip_fija" id="ip_fija" onBlur ="validarCampo('ip_fija')" required="required" class="form-control col-md-7 col-xs-12 maskIp">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Dirección <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="direccion" id="direccion" required="required" class="form-control col-md-7 col-xs-12 direccion" data-pos="1">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Telefono <span class="required">*</span>
            </label>
            <div class="col-md-7 col-sm-7 col-xs-12">
                <div class="col-md-2" style="padding:0;">
                  <input type="text" id="telefono_indicativo" name="telefono_indicativo" readonly maxlength="10" class="form-control col-md-7 col-xs-12 obligatorio">
                </div>
                <div class="col-md-8" style="padding:0;">
                  <input type="text" id="telefono" name="telefono" maxlength="10" class="form-control col-md-7 col-xs-12 obligatorio justNumbers maskTelefono">
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Monto máximo a pagar</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha obligatorio" id="monto_max" name="monto_max" value="0" maxlength="15" aria-label="Amount (to the nearest dollar)">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Saldo inicial cierre caja</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="moneda form-control centrar-derecha obligatorio" id="saldo_cierre_caja" name="saldo_cierre_caja" value="0" maxlength="15" aria-label="Amount (to the nearest dollar)">
              </div>
            </div>
          </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipo_bodega">Tienda tipo bodega<span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="switch_check" id="sw_tipo_bodega">
              <input type="checkbox" id="tipo_bodega" name="tipo_bodega"  onchange="intercaleCheck(this);"  value="0">
              <span class="slider"></span>
            </label>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Trabaja Festivos<span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="switch_check">
              <input type="checkbox" id="festivo" name="festivo"  onchange="intercaleCheck(this);"  value="0">
              <span class="slider"></span>
            </label>
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Horario 24 Horas<span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="switch_check">
              <input type="checkbox" id="todoeldia" name="todoeldia"  onchange="intercaleCheck(this);"  value="0">
              <span class="slider"></span>
            </label>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Establecimiento Administrativo<span class="required">*</span></label>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label class="switch_check" id="sw_sede_principal">
              <input type="checkbox" id="sede_principal" name="sede_principal" onchange="intercaleCheck(this);" value="0">
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
                  <input type="time" id="lunesH1" onblur="validateMinAndMax('lunesH1', 'lunesH2', 'max','time')"  name="lunesH1" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="lunesH2" onblur="validateMinAndMax('lunesH2', 'lunesH1', 'min','time')" name="lunesH2" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Martes
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="martesH1" onblur="validateMinAndMax('martesH1', 'martesH2', 'max','time')"  name="martesH1" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="martesH2" onblur="validateMinAndMax('martesH2', 'martesH1', 'min','time')"   name="martesH2" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Miercoles
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="miercolesH1" onblur="validateMinAndMax('miercolesH1', 'miercolesH2', 'max','time')"   name="miercolesH1" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="miercolesH2" onblur="validateMinAndMax('miercolesH2', 'miercolesH1', 'min','time')"  name="miercolesH2" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jueves
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="juevesH1"  onblur="validateMinAndMax('juevesH1', 'juevesH2', 'max','time')"  name="juevesH1" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="juevesH2" onblur="validateMinAndMax('juevesH2', 'juevesH1', 'min','time')"  name="juevesH2" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Viernes
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="viernesH1" onblur="validateMinAndMax('viernesH1', 'viernesH2', 'max','time')"  name="viernesH1" class="day-store form-control col-md-7 col-xs-12 val" placeholder="__:__">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="viernesH2" onblur="validateMinAndMax('viernesH2', 'viernesH1', 'min','time')"  name="viernesH2" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sabado
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="sabadoH1" onblur="validateMinAndMax('sabadoH1', 'sabadoH2', 'max','time')"  name="sabadoH1" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="sabadoH2" onblur="validateMinAndMax('sabadoH2', 'sabadoH1', 'min','time')"  name="sabadoH2" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Domingo
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="domingoH1" onblur="validateMinAndMax('domingoH1', 'domingoH2', 'max','time')"  name="domingoH1" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="time" id="domingoH2" onblur="validateMinAndMax('domingoH2', 'domingoH1', 'min','time')"  name="domingoH2" class="day-store form-control col-md-7 col-xs-12" placeholder="__:__">
                </div>
              </div>
        </div>

            <div class="form-group">
              <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button class="btn btn-primary" type="reset">Restablecer</button>
                <a href="{{ url('/tienda') }}" class="btn btn-danger" type="button">Regresar</a>
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

        /*Llena el Select*/
        FillSelectValPais("#id_pais");
        /*----------------------------*/

           
@endsection

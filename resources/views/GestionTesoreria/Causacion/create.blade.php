@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title col-md-12"> 
          <div class="col-md-4 col-md-offset-4"><h1>Causaciones</h1></div>
          <div class="clearfix"></div>
        </div>        
      <div class="x_content">
        <br />
        <form action="javascript:void(0)" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
          <div class="x_title"><h3>Datos de la causación</h3><div class="clearfix"></div></div>
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">            
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Tipo Causación <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select id="id_tipo_causacion" name="id_tipo_causacion" class="form-control generalrequired">
                    <option value="">- Seleccione una opción -</option>              
                    @foreach($tiposcausacion AS $tipocausacion)
                      <option value="{{$tipocausacion->id}}">{{$tipocausacion->name}}</option>
                    @endforeach
                    <input type="hidden" id="id_empleado" name="id_empleado" value="" class="limpiar">
                    <input type="hidden" id="id_tienda_empleado" name="id_tienda_empleado" value="" class="limpiar">
                  </select>
                </div>
              </div>

              <div class="form-group">            
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_documento_contable">Tipo Documento Contable <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select id="id_tipo_documento_contable" name="id_tipo_documento_contable" class="form-control generalrequired">
                    <option value="">- Seleccione una opción -</option>              
                    @foreach($tipo_documento_contables AS $tipo_documento_contable)
                      <option value="{{$tipo_documento_contable->id}}">{{$tipo_documento_contable->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">            
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_configuracion_contable">Configuración Contable <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select id="id_tipo_configuracion_contable" name="id_tipo_configuracion_contable" class="form-control generalrequired">
                    <option value="">- Seleccione una opción -</option>              
                  </select>
                </div>
              </div>

              <!-- Dirigido a empleado.. -->
              <div class="dirigido dirigidoempleado hide">
                <div class="x_title"><h2>Empleado</h2><div class="clearfix"></div></div>           

                <div class="form-group">            
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Tipo Documento <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <select id="id_tipo_documento" name="id_tipo_documento" class="form-control">
                      <option value="">- Seleccione una opción -</option>              
                      @foreach($tiposdocumentos AS $tipodocumento)
                        @if($tipodocumento->id != 32)
                        <option value="{{$tipodocumento->id}}">{{$tipodocumento->name}}</option>
                        @endif                    
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group documento">            
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Documento <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <input class="form-control justNumbers requieredsalario limpiar" type="text" id="documento_empleado" value="">
                  </div>
                </div>
                
                <div class="form-group">            
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Nombre <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <input class="form-control requieredsalario limpiar" type="text" readonly id="nombre_empleado" value="">
                  </div>
                </div>
              </div>

              <!-- Tipo Proveedor -->
              <div class="dirigido tipoproveedor hide">
                <div class="form-group">            
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Tipo de Persona<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <select id="id_tipo_proveedor" name="id_tipo_proveedor" class="form-control">
                      <option value="">- Seleccione una opción -</option>
                      <option value="0">Cliente Jur&iacute;dico</option>
                      <option value="1">Cliente Natural</option>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Dirigido a Proveedor Juridico.. -->
              <div class="dirigido dirigidoproveedorjuridico hide">
                <div class="x_title"><h2>Proveedor jur&iacute;dico</h2><div class="clearfix"></div></div>
                <div class="form-group nit">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">NIT<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">               
                    <div class="input-group">
                      <input type="text" id="numero_documento" name="numero_documento" class="form-control nit limpiar">
                      <span class="input-group-addon white-color"><input id="digito_verificacion" name="digito_verificacion" type="text" class="nit-val limpiar"></span>
                    </div>
                  </div>
                </div>

                <div class="form-group">            
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Nombre <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <input class="form-control  limpiar" type="text" readonly id="nombre_empleado_nit" value="">
                  </div>
                </div>
              </div>

              <!-- Dirigido a Proveedor Natural.. -->
              <div class="dirigido dirigidoproveedornatural hide">
                <div class="x_title"><h2>Proveedor Natural</h2><div class="clearfix"></div></div>
                <div class="form-group">            
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Tipo Documento <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <select id="id_tipo_documento_proveedor_natural" name="id_tipo_documento_proveedor_natural" class="form-control requiered">
                      <option value="">- Seleccione una opción -</option>              
                      @foreach($tiposdocumentos AS $tipodocumento)
                        @if($tipodocumento->id != 32)
                        <option value="{{$tipodocumento->id}}">{{$tipodocumento->name}}</option>
                        @endif                    
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group documento">            
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Documento <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <input class="form-control justNumbers  limpiar" type="text" id="documento_proveedor_natural" value="">
                  </div>
                </div>
                
                <div class="form-group">            
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Nombre <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <input class="form-control  limpiar" type="text" readonly id="nombre_proveedor_natural" value="">
                    <input type="hidden" id="id_proveedor_natural" name="id_proveedor_natural" value="" class="limpiar">
                    <input type="hidden" id="id_tienda_proveedor_natural" name="id_tienda_proveedor_natural" value="" class="limpiar">
                  </div>
                </div>
              </div>

              <!-- Dirigido a Sociedad.. -->
              <div class="dirigido dirigidosociedad hide">
                <div class="x_title"><h4>Sociedad que presta</h4><div class="clearfix"></div></div>
                  <input type="text" readonly id="sociedadprestadora" value="{{$sociedad[0]->name}}" class="form-control">
                  <input type="hidden" name="id_sociedadprestadora" readonly id="id_sociedadprestadora" value="{{$sociedad[0]->id}}" class="form-control">
                <div class="x_title"><h4>Sociedad a prestar</h4><div class="clearfix"></div></div>
                  <select id="sociedadaprestar" name="sociedadaprestar" class="form-control limpiar">
                    <option value="">- Seleccione una opción -</option>              
                      @foreach($sociedades AS $socied)
                        <option value="{{$socied->id}}">{{$socied->name}}</option>                    
                      @endforeach
                  </select>
              </div>
            </div>

            <div class="col-md-6 datostienda">
              <!-- Rol Tesorero o Super Admin -->            
              @if((Auth::user()->role->id==env('ROL_TESORERIA')) || (Auth::user()->role->id==env('ROLE_SUPER_ADMIN')))
              <div class="form-group">
                <label class="control-label col-xs-4">País<span class="required">*</span>
                </label>
                <div class="col-xs-8">
                  <select id="id_pais" name="id_pais" class="form-control  generalrequired">
                    <option value="">- Seleccione una opción -</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-xs-4">Departamento<span class="required">*</span>
                </label>
                <div class="col-xs-8">
                  <select id="id_departamento" name="id_departamento" class="form-control  generalrequired">
                    <option value="">- Seleccione una opción -</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-xs-4">Ciudad<span class="required">*</span>
                </label>
                <div class="col-xs-8">
                  <select id="id_ciudad" name="id_ciudad" class="form-control  generalrequired">
                    <option value="">- Seleccione una opción -</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-xs-4">Joyer&iacute;a<span class="required">*</span>
                </label>
                <div class="col-xs-8">
                  <select id="id_tienda" name="id_tienda" class="form-control  generalrequired">
                    <option value="">- Seleccione una opción -</option>
                  </select>
                </div>
              </div>

              <div class="form-group documento">            
                  <label class="control-label col-md-4 col-sm-4 col-xs-12">Monto Maxímo <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                  <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input name="monto_max" type="text" class="moneda form-control centrar-derecha" readonly id="monto_max" value="0" maxlength="15" aria-label="Amount (to the nearest dollar)">
                  </div>
                  </div>
              </div>

              @else
              <div class="form-group">
                <label class="control-label col-xs-4">Joyer&iacute;a<span class="required">*</span>
                </label>
                <div class="col-xs-8">
                  <input class="form-control  requiered" type="text" readonly id="nombre_tienda" value="{{$tienda->nombre}}">
                  <input type="hidden" id="id_tienda" name="id_tienda" value="{{$tienda->id}}">
                </div>
              </div>

              <div class="form-group documento">            
                  <label class="control-label col-md-4 col-sm-4 col-xs-12">Monto Maxímo <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input name="monto_max" type="text" class="moneda form-control centrar-derecha" readonly id="monto_max" value="0" maxlength="15" aria-label="Amount (to the nearest dollar)">
                    </div>
                  </div>
              </div>
              @endif    
            </div>
          </div>
          <div  class="pagonomina">
            @include('GestionTesoreria/Causacion/Comprobantes/pagonomina')          
          </div>
          <div class="pagocamapaña">
            @include('GestionTesoreria/Causacion/Comprobantes/pagocampana')          
          </div>
          <div class="anticipo">
            @include('GestionTesoreria/Causacion/Comprobantes/anticipo')          
          </div>
       
          <div class="ln_solid"></div>
          @if((Auth::user()->role->id==env('ROL_TESORERIA')) || (Auth::user()->role->id==env('ROLE_SUPER_ADMIN')))          
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="button" id = 'btn-guardar' class="btn btn-success">Causar</button>
              <a href="{{ url('/tesoreria/causacion') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
          @else
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="button" id = 'btn-guardar' class="btn btn-success">Causar</button>
              <button type="button" id = 'payAction' class="btn btn-info">Pagar</button>
              <a href="{{ url('/tesoreria/causacion') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
          @endif
          <!-- Modal de pagar. -->
          @include('GestionTesoreria/Causacion/Modals/Pagar')          
        </form>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/tesoreria/causacion.js')}}"></script>
@endpush

@section('javascript')   
    loadSelectInput("#id_pais","{{ url('/pais/getSelectList') }}");
    SelectValPais("#id_pais");
    $('#id_pais').change();
    $('#id_tienda').change();
    @if((Auth::user()->role->id==env('ROL_TESORERIA')) || (Auth::user()->role->id==env('ROLE_SUPER_ADMIN')))
      superAdmin = 1;
    @endif
@endsection

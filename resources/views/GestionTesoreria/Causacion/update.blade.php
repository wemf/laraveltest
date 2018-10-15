@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')
@include('GestionTesoreria/Causacion/Modals/Pagar')
@include('GestionTesoreria/Causacion/Modals/anular')

<div class="row">
<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title col-md-12"> 
          <div class="col-md-4 col-md-offset-4"><h1>Revisar Causación</h1></div>
          <div class="clearfix"></div>
        </div>        
      <div class="x_content">
        <br />
        <form action="javascript:void(0)" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')
          <div class="x_title"><h3>Datos de la Causación</h3><div class="clearfix"></div></div>
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">            
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_documento_contable">Tipo Documento Contable <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input class="form-control" type="text" readonly value="{{$causacion->tipo_documento_contable}}">                 
                  <input class="form-control" type="hidden" id="id_tipo_documento_contable" name="id_tipo_documento_contable" readonly value="{{$causacion->id_tipo_documento_contable}}">                 
                </div>
              </div>

              <div class="form-group">            
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_configuracion_contable">Configuración Contable <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input class="form-control" type="text" readonly value="{{$causacion->configuracion}}">                       
                  <input class="form-control" type="hidden" name="id_tipo_configuracion_contable" id="id_tipo_configuracion_contable" readonly value="{{$causacion->id_configuracion}}">                       
                  <input class="form-control" type="hidden" name="comprobante_contable" id="comprobante_contable" readonly value="{{$causacion->comprobante_contable}}">                       
                  <input class="form-control" type="hidden" name="id_causacion" id="id_causacion" readonly value="{{$causacion->id}}">                       
                  <input class="form-control" type="hidden" name="id_tienda_causacion" id="id_tienda_causacion" readonly value="{{$causacion->id_tienda}}">                       
                </div>
              </div>

              <div class="form-group">            
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Tipo Causación <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input class="form-control" type="text" readonly value="{{$causacion->tipo_causacion}}">                                           
                  <input class="form-control" type="hidden" id="id_tipo_causacion" name="id_tipo_causacion" readonly value="{{$causacion->id_tipo_causacion}}">
                  <input type="hidden" id="id_empleado" name="id_empleado" value="" class="limpiar">
                  <input type="hidden" id="id_tienda_empleado" name="id_tienda_empleado" value="" class="limpiar">                                   
                  <input type="hidden" id="id_cierre_caja_realizado" name="id_cierre_caja_realizado" value="{{$causacion->id_cierre_realizado}}">                                   
                  <input type="hidden" id="id_cierre_caja_actual" name="id_cierre_caja_actual" value="{{$cierre_caja_actual->id_cierre}}">              
                  <input type="hidden" id="automatico" name="automatico" value="{{$causacion->automatico}}">
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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tipo_causacion">Tipo de Proveedor <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <select id="id_tipo_proveedor" name="id_tipo_proveedor" class="form-control limpiar">
                      <option value="">- Seleccione una opción -</option>              
                      <option value="0">Proveedor Jur&iacute;dico</option>              
                      <option value="1">Proveedor Natural</option>              
                    </select>
                  </div>
                </div>
              </div>

              <!-- Dirigido a Proveedor Juridico.. -->
              <div class="dirigido dirigidoproveedorjuridico hide">
                <div class="x_title"><h2>Proveedor jur&iacute;dico</h2><div class="clearfix"></div></div>
                <div class="form-group nit">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Nit<span class="required">*</span>
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
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-xs-4">Joyer&iacute;a<span class="required">*</span>
                </label>
                <div class="col-xs-8">
                  <input class="form-control  requiered" type="text" readonly id="nombre_tienda" value="{{$causacion->nombre}}">
                  <input type="hidden" id="id_tienda" name="id_tienda" value="{{$causacion->id_tienda}}">
                </div>
              </div>

              <div class="form-group documento">            
                  <label class="control-label col-md-4 col-sm-4 col-xs-12">Monto Maxímo <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input name="monto_max" type="text" class="moneda form-control centrar-derecha" readonly id="monto_max" value="{{$causacion->monto_max}}" maxlength="15" aria-label="Amount (to the nearest dollar)">
                    </div>
                  </div>
              </div>

              <div class="form-group">
                <label class="control-label col-xs-4">Estado<span class="required">*</span>
                </label>
                <div class="col-xs-8">
                  <input class="form-control  requiered" type="text" readonly id="nombre_estado" value="{{$causacion->estado}}">
                  <input type="hidden" id="id_estado" name="id_estado" value="{{$causacion->id_estado}}">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-xs-4">Fecha Creado<span class="required">*</span>
                </label>
                <div class="col-xs-8">
                  <input class="form-control  requiered" type="text" readonly id="fecha_creado" name="fecha_creado" value="{{$causacion->fecha_creado}}">
                </div>
              </div>

            </div>
          </div>
          <div  class="pagonomina">
            @include('GestionTesoreria/Causacion/Update/Comprobantes/pagonomina')          
          </div>
          <div class="pagocamapaña">
            @include('GestionTesoreria/Causacion/Update/Comprobantes/pagocampana')          
          </div>
          
          <div class="ln_solid"></div>
          <!-- Rol Tesorero o Super Admin -->            
          @if((Auth::user()->role->id==env('ROL_TESORERIA')) || (Auth::user()->role->id==env('ROLE_SUPER_ADMIN')))
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="button" id = 'payAction' class="opcion btn btn-primary">Pagar</button>
              <button class="opcion btn btn-info" id='btn-transferir' type="button">Transferir a joyer&iacute;a</button>
              @if(($causacion->id_cierre_realizado!=$cierre_caja_actual->id_cierre) &&  ($causacion->id_estado == 111 || $causacion->id_estado == 112 || $causacion->id_estado == 113)) 
              <button type="button" id = 'confirmanular' class="btn btn-primary">Confirmar</button>
              <button class="btn btn-orange" id='rechazaranular' type="button">Rechazar</button>
              @endif
              <a href="{{ url('/tesoreria/causacion') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
          @elseif(Auth::user()->role->id==env('ROL_JESE_ZONA') && ($causacion->id_cierre_realizado==$cierre_caja_actual->id_cierre) && ($causacion->id_estado == 111 || $causacion->id_estado == 112 || $causacion->id_estado == 113))
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="button" id = 'confirmanular' class="btn btn-primary">Confirmar</button>
              <button class="btn btn-orange" id='rechazaranular' type="button">Rechazar</button>
              <a href="{{ url('/tesoreria/causacion') }}" class="btn btn-danger" type="button">Cancelar</a>              
            </div>
          </div>
          @else
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="button" id = 'payAction' class="opcion btn btn-primary">Pagar</button>
              <button type="button" id = 'btn-anular-admin' class="opcion btn btn-orange">Solicitar Anulación</button>              
              <a href="{{ url('/tesoreria/causacion') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <span style="color:red;" class="cierreactual hide" >Toda solicitud de anular se enviará al jefe de zona.</span>
              <span style="color:red;" class="pasocierre hide" >Toda solicitud de anular se enviará al Super Admin.</span>
            </div>
          </div>
          @endif
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
  $('#id_tipo_causacion').change();
  $('#id_tienda').change();  
  $('#id_tipo_configuracion_contable').change();
  salarioTotal();
  $('.dirigidoempleado').addClass('hide');
  @if((Auth::user()->role->id==env('ROL_TESORERIA')) || (Auth::user()->role->id==env('ROLE_SUPER_ADMIN')))
    superAdmin = 1;
  @endif
@endsection

<div class="modal-styles confirm-hide modal-cc-info">
	<div class="shadow" onclick="confirm.hide();"></div>
	<div class="container">
		<div class="title">
			<h1 id="confirmtitle">Documento del Cliente</h1>
		</div>
		
		<input type="checkbox" name="chk_flip" id="chk_flip" class="hide">
		<div class="flip" style="height: 200px; margin: 10px auto;">
			<img @if($attribute != null) src="{{env('RUTA_ARCHIVO_OP')}}colombia\cliente\doc_persona_natural\{{$attribute->ruta_foto_posterior}}" @else  src="{{asset('images/noimagen.png') }}" @endif class="flip-1" onerror="this.src='{{ asset('images/noimagen.png') }}'" height="200px">
			<img @if($attribute != null) src="{{env('RUTA_ARCHIVO_OP')}}colombia\cliente\doc_persona_natural\{{$attribute->ruta_foto_anterior}}" @else  src="{{asset('images/noimagen.png') }}" @endif class="flip-2" onerror="this.src='{{ asset('images/noimagen.png') }}'" height="200px">
		</div>

		<div class="buttons">
			<label for="chk_flip" type="button" class="btn btn-primary"><i class="fa fa-refresh"></i> Girar</label>
			<button id="cancelConfirm" type="button" class="btn btn-danger" onclick="confirm.hide();">Cancelar</button>
		</div>
	</div>
</div> 
 
 <div class="x_content">
    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10">
                            <label>Estado Actual</label>
                            <br>
                            <input class="form-control" id="estado_contrato" type="text" value="{{$contrato[0]->Estado_Contrato}}" readonly>
                            <input class="form-control hide" id="estado_cerrado" name="estado_cerrado" type="text" value="31">
                            <input class="form-control hide" id="estado_aplazar" name="estado_aplazar" type="text" value="48">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6  col-sm-10 col-xs-12">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10">
                            <label>Motivo Actual </label>
                            <input class="form-control" type="text" value="{{$contrato[0]->Motivo_Contrato}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
  <div class="row">
        <form id="form-prorroga" action="{{ url('/contrato/prorrogar') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
            <div id="frm_nueva_prorroga" >
                <div class="container">
                  <!-- Trigger the modal with a button -->
                  
                  <!-- Modal -->
                  <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Generar una nueva prórroga para el contrato</h4>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" id="var_efectivo" name="var_efectivo" />
                            <input type="hidden" id="var_debito" name="var_debito" />
                            <input type="hidden" id="var_credito" name="var_credito" />
                            <input type="hidden" id="var_otros" name="var_otros" />


                            <div class="row">
                                <div class="col-md-4 col-xs-12 bottom-20">
                                    <label>Fecha Prórroga <span class="required">*</span></label>
                                    <input type="text" readonly name="fecha_prorroga" value="{{ Carbon\Carbon::now() }}" class="form-control col-md-7 col-xs-12" >
                                </div>

                                <div class="col-md-4 col-xs-12 bottom-20">
                                    <label>Meses a Prorrogar <span class="required">*</span></label>
                                    <input type="number" name="meses_prorroga" id="meses_prorroga" onkeyup="prorroga.calcularValor();" onchange="prorroga.calcularValor();" required="required" class="form-control col-md-7 col-xs-12" value="">
                                </div>

                                <div class="col-md-4 col-xs-12 bottom-20">
                                    <label>Total a prorrogar <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" name="total_prorrogar" id="total_prorrogar" onkeyup="prorroga.calcularMeses();" onchange="prorroga.calcularMeses();" required="required" class="form-control col-md-7 col-xs-12 moneda" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <hr style="margin: 0;">
                            </div>

                            <div class="row">
                                <h3 align="center" style="margin-bottom: 10px;"><strong>EFECTIVO</strong></h3>
                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <label>Importe</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" name="efectivo" id="efectivo"  class="form-control col-md-7 col-xs-12 moneda">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <hr style="margin: 0;">
                            </div>

                            <div class="row">
                                <h3 align="center" style="margin-bottom: 10px;"><strong>TARJETA DÉBITO</strong></h3>
                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <label>Importe</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" name="debito" id="debito"  class="form-control col-md-7 col-xs-12 moneda">
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <label>Código de aprobación <span class="required">*</span></label>
                                    <input type="text" name="aprobacion_debito" id="aprobacion_debito"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="row">
                            <hr style="margin: 0;">
                            </div>

                            <div class="row">
                                <h3 align="center" style="margin-bottom: 10px;"><strong>TARJETA CRÉDITO</strong></h3>
                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <label>Importe</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" name="credito" id="credito"  class="form-control col-md-7 col-xs-12 moneda">
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <label>Código de aprobación <span class="required">*</span></label>
                                    <input type="text" name="aprobacion_credito" id="aprobacion_credito"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="row">
                            <hr style="margin: 0;">
                            </div>

                            <div class="row">
                                <h3 align="center" style="margin-bottom: 10px;"><strong>OTROS</strong></h3>
                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <label>Importe</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" name="otros" id="otros"  class="form-control col-md-7 col-xs-12 moneda">
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <label>Código de aprobación <span class="required">*</span></label>
                                    <input type="text" name="aprobacion_otros" id="aprobacion_otros"  class="form-control col-md-7 col-xs-12">
                                </div>

                                <div class="col-md-12 col-xs-12 bottom-20">
                                    <label>Observación <span class="required">*</span></label>
                                    <input type="text" name="observacion_otros" id="observacion_otros"  class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="id_tienda" value="{{$id_tienda}}">
                        <input type="hidden" name="precio_total" id="precio_total" value="{{$precio_total}}">
                        <input type="hidden" name="porcentaje_retroventa" id="porcentaje_retroventa" value="{{$attribute->porcentaje_retroventa}}">
                        <input type="hidden" name="valor_abonado_bd" id="valor_abonado_bd" value="@if(isset($valor_abonado[0]->valor)) {{ $valor_abonado[0]->valor }} @else 0 @endif">
                        <input type="hidden" name="nuevo_valor_abonado" id="nuevo_valor_abonado">
                        <input type="hidden" name="fecha_terminacion_cabecera" value="{{$fecha_terminacion_cabecera}}">
                        <div class="modal-footer">
                          <div class="form-group">
                            <button type="submit" class="btn btn-success" style="display:none"></button>
                            <button type="button" onclick="prorroga.validateProrroga();" class="btn btn-success">Guardar</button>
                            <button type="submit" id="btn-prorrogar" class="btn btn-success hide">Guardar</button>
                            <button class="btn btn-primary" type="reset">Restablecer</button>
                            <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                          </div>
                        </div>
                      
                      </div>
                </div>
              </div>
            </div>
           </div>
        </form>
        </div> 
    </div>
    <br>
    <div class="x_title">
        <h2>Información del cliente</h2>
        <div class="clearfix"></div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <div class="row">        
          <div class="col-md-offset-1 col-md-10">
            <label>Tipo de documento</label>
            <input type="text" name="tipo_documento" required="required" class="form-control col-md-7 col-xs-12" value="{{$attribute->tipo_documento}}" disabled>
          </div>
        </div>
      </div>
      <div class="col-md-6">
          <div class="row">        
          <div class="col-md-offset-1 col-md-10">
            <label>Fecha de nacimiento</label>
            <input  class="form-control" type="text" id="nombre" name="nombre" value="{{$attribute->fecha_nacimiento}}" disabled>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <div class="row">        
          <div class="col-md-offset-1 col-md-10">
           <label>Número de documento</label>
            <input  class="form-control" type="text" id="numeroDocumento" name="numeroDocumento" value="{{$attribute->numero_documento}}" disabled>
          </div>
        </div>
      </div>
      <div class="col-md-6">
          <div class="row">        
          <div class="col-md-offset-1 col-md-10">
            <label>Fecha de expedición</label>
              <input type="text" name="fecha" required="required" class="form-control col-md-7 col-xs-12" value="{{$attribute->fecha_expedicion}}" disabled>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <div class="row">        
          <div class="col-md-offset-1 col-md-10">
             <label>Nombres</label>
            <input  class="form-control" type="text" id="Nombres" name="Nombres" value="{{$attribute->nombres}}" disabled>
          </div>
        </div>
      </div>
      <div class="col-md-6">
          <div class="row">        
          <div class="col-md-offset-1 col-md-10">
            <label>Apellido</label>
            <input  class="form-control" type="text" id="Apellido" name="Apellido" value="{{$attribute->apellidos}}" disabled>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <div class="row">        
          <div class="col-md-offset-1 col-md-10">
            <label>Correo</label>
            <input  class="form-control" type="text" id="Correo" name="Correo" value="{{$attribute->correo_electronico}}" disabled>
          </div>
        </div>
      </div>
      <div class="col-md-6">
          <div class="row">        
          <div class="col-md-offset-1 col-md-10">
             <label>Alerta de confiabilidad</label>
              <input  class="form-control" type="text" id="Correo" name="Correo" value="{{$attribute->confiabilidad}}" disabled>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="x_title">
    <h2>Información general de contrato</h2>
    <div class="clearfix"></div>
</div>
<div class="row">
    <div class="col-md-6 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <label>Fecha de creación</label>
                <input type="text" required="required" class="form-control col-md-7 col-xs-12" value="{{$attribute->fecha_creacion}}" disabled>
            </div>
        </div>
    </div>   
    <div class="col-md-6 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <label>Tienda</label>
                <input type="text" required="required" class="form-control col-md-7 col-xs-12" value="{{$attribute->tienda}}" disabled>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <label>Categoría general</label>
                <input type="text" required="required" class="form-control col-md-7 col-xs-12" value="{{$attribute->categoria_general}}" disabled>
            </div>
        </div>
    </div>
    <div class="col-md-6 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <label>Código contrato</label>
                <input type="text" required="required" class="form-control col-md-7 col-xs-12" value="{{$id}}" disabled>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <label>% de retroventa</label>
                <input type="text" id="porcen_retro" required="required" class="form-control col-md-7 col-xs-12" value="{{$attribute->porcentaje_retroventa}}" disabled>
            </div>
        </div>
    </div>
    <div class="col-md-6 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <label>Término</label>
                <input type="text" required="required" class="form-control col-md-7 col-xs-12" value="{{$attribute->termino}}" disabled>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <label>Códigos de bolsa de seguridad utilizadas</label>
                <input type="text" required="required" class="form-control col-md-7 col-xs-12" value="{{$attribute->cod_bolsas_seguridad}}" disabled>
            </div>
        </div>
    </div>
    <div class="col-md-6 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <label>Fecha de terminación</label>
                <input type="text" required="required" class="form-control col-md-7 col-xs-12" value="@if(isset($infoActualContrato[0]->nueva_fecha_terminacion) && $infoActualContrato[0]->nueva_fecha_terminacion != '') {{$infoActualContrato[0]->nueva_fecha_terminacion}} @else {{$attribute->fecha_terminacion}} @endif" disabled>
            </div>
        </div>
    </div>
    <div class="col-md-6 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <label>Fecha aplazado</label>
                <input type="text" required="required" class="form-control col-md-7 col-xs-12" value="@if(isset($infoActualContrato[0]->fecha_aplazo) && $infoActualContrato[0]->fecha_aplazo != '') {{$infoActualContrato[0]->fecha_aplazo}} @endif" disabled>
            </div>
        </div>
    </div>
    <div class="col-md-6 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <label>Fecha de retroventa</label>
                <input type="text" required="required" class="form-control col-md-7 col-xs-12" value="{{$attribute->fecha_retroventa}}" disabled>
            </div>
        </div>
    </div>
    @if(isset($autorizarTercero))
    <div class="col-md-6 col-xs-12 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-xs-12">
                <label for="autorizar_tercero">Autorizar tercero </label><br>
                <label class="switch_check">
                    <input type="checkbox" id="autorizar_tercero" name="autorizar_tercero"  onchange="intercaleCheck(this); autorizarTercero();" 
                        @if(count($tercero) > 0)
                            value="1" checked
                        @else
                            value="0"
                        @endif
                        />
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>
    @endif
    @if(isset($autorizarTercero))
    <div class="col-md-6 col-xs-12 bottom-20">
        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-xs-12">
                <label for="contrato_extraviado">Contrato extraviado </label><br>
                <label class="switch_check">
                    <input type="checkbox" id="contrato_extraviado" name="contrato_extraviado" onchange="intercaleCheck(this); contrato.contratoExtraviado()" 
                        @if($attribute->extraviado == 1)
                            value="1" checked
                        @else
                            value="0"
                        @endif
                         />
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </div>
    @endif
</div>

<div  class="pnl_autorizar_tercero"
@if(count($tercero) == 0)
    style="display:none;"
@endif
>
    <div class="x_title">
        <h2>Información del Tercero</h2>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        @if(count($tercero) == 0)
        <form method="POST" action="{{url('contrato/guardartercero')}}">
        @else
        <form method="POST" action="{{url('contrato/actualizartercero')}}">
        @endif
            {{ csrf_field() }}  






            @if(count($tercero) == 0)
            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="paistercero">País <span class="required">*</span></label>
                        <select @if(!isset($autorizarTercero)) disabled="disabled" @endif id="paistercero" name="paistercero" onchange="loadSelectInputByParent('#departamentotercero', '{{url('/departamento/getdepartamentobypais')}}', this.value, 1);" class="form-control col-md-7 col-xs-12 requerido_tercero" required="required">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="departamentotercero">Departamento <span class="required">*</span></label>
                        <select @if(!isset($autorizarTercero)) disabled="disabled" @endif id="departamentotercero" name="departamentotercero" onchange="loadSelectInputByParent('#ciudadtercero', '{{url('/ciudad/getciudadbydepartamento')}}', this.value, 1);" class="form-control col-md-7 col-xs-12 requerido_tercero" required="required">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="ciudadtercero">Ciudad <span class="required">*</span></label>
                        <select @if(!isset($autorizarTercero)) disabled="disabled" @endif id="ciudadtercero" onchange="contrato.indicativoPais();" name="ciudadtercero" class="form-control col-md-7 col-xs-12 requerido_tercero" required="required">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="nombres_tercero">Nombres <span class="required">*</span></label>
                        <input @if(!isset($autorizarTercero)) disabled="disabled" @endif type="text" id="nombres_tercero" name="nombres_tercero" maxlength="40" value="@if(count($tercero) > 0){{ $tercero[0]->nombres }}@endif" class="form-control col-md-7 col-xs-12 requerido_tercero">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="apellidos_tercero">Apellidos <span class="required">*</span></label>
                        <input @if(!isset($autorizarTercero)) disabled="disabled" @endif type="text" id="apellidos_tercero" name="apellidos_tercero" maxlength="40" value="@if(count($tercero) > 0){{ $tercero[0]->apellidos }}@endif" class="form-control col-md-7 col-xs-12 requerido_tercero">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="parentesco_tercero">Parentesco <span class="required">*</span></label>
                        <select @if(!isset($autorizarTercero)) disabled="disabled" @endif name="parentesco_tercero[]" required id="parentesco_tercero" data-load="@if(count($tercero) > 0){{ $tercero[0]->parentesco }}@endif" class="form-control col-md-3 requerido_tercero">
                            <option value="">- Seleccione una opción -</option>
                            @foreach($tipo_parentesco as $tipo)
                            <option value="{{ $tipo->id }}"
                            @if(count($tercero) > 0)
                                @if($tipo->id == $tercero[0]->parentesco)
                                    selected
                                @endif
                            @endif>{{ $tipo->name }}</option>
                            @endforeach 
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="tipodocumentotercero">Tipo de Documento <span class="required">*</span></label>
                        <select @if(!isset($autorizarTercero)) disabled="disabled" @endif id="tipodocumentotercero" name="tipodocumentotercero" required data-load="@if(count($tercero) > 0){{ $tercero[0]->id_tipo_documento }}@endif" class="form-control col-md-7 col-xs-12 tipodocumento requerido_tercero" required="required">
                            <option value="">- Seleccione una opción -</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="numero_documeto_tercero">Número de Documento <span class="required">*</span></label>
                        <input @if(!isset($autorizarTercero)) disabled="disabled" @endif type="text" id="numero_documeto_tercero" name="numero_documeto_tercero" maxlength="25" value="@if(count($tercero) > 0){{ $tercero[0]->numero_documento }}@endif" class="form-control col-md-7 col-xs-12 requerido_tercero justNumbers">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="correo_tercero">Correo <span class="required"> </span> </label>
                        <input @if(!isset($autorizarTercero)) disabled="disabled" @endif type="text" id="correo_tercero" name="correo_tercero" value="@if(isset($tercero[0]->correo)){{ $tercero[0]->correo }}@endif" class="form-control col-md-7 col-xs-12 email_validado" required="" style="border: 1px solid rgb(204, 204, 204); box-shadow: none;" pattern="[a-z0-9._%+-]+@[a-z0-9-]+\.[a-z]+" title="Ej: ejemplo@ejemplo.co">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                    <label for="direccion_tercero">Dirección <span class="required">*</span></label>
                        <input @if(!isset($autorizarTercero)) disabled="disabled" @endif type="text" id="direccion_tercero" name="direccion_tercero" maxlength="80" value="@if(count($tercero) > 0){{ $tercero[0]->direccion }}@endif" class="form-control col-md-7 col-xs-12 direccion requerido_tercero" required>
                    </div>
                </div> 
            </div>

            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                    <label for="telefono_tercero">Teléfono <span class="required">*</span></label><br>
                        <input @if(!isset($autorizarTercero)) disabled="disabled" @endif type="text" id="telefono_tercero_indicativo" name="telefono_tercero_indicativo" style="font-size: 13px !important;" maxlength="10" class="form-control col-md-7 col-xs-12 tl" value="+57">
                        <input @if(!isset($autorizarTercero)) disabled="disabled" @endif type="text" id="telefono_tercero" name="telefono_tercero" value="@if(isset($tercero[0]->telefono)){{ $tercero[0]->telefono }}@endif" onkeyup="contrato.telefonosTercero();" maxlength="10" class="form-control col-md-7 col-xs-12 tlx justNumbers requerido_tercero">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                    <label for="celular_tercero">Celular <span class="required">*</span></label><br>
                        <input @if(!isset($autorizarTercero)) disabled="disabled" @endif type="text" id="celular_tercero_indicativo" name="celular_tercero_indicativo" style="font-size: 13px !important;" maxlength="10" class="form-control col-md-7 col-xs-12 tl" value="+57">
                        <input @if(!isset($autorizarTercero)) disabled="disabled" @endif type="text" id="celular_tercero" name="celular_tercero" value="@if(isset($tercero[0]->celular)){{ $tercero[0]->celular }}@endif" onkeyup="contrato.telefonosTercero();" maxlength="10" class="form-control col-md-7 col-xs-12 tlx justNumbers requerido_tercero">
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="codigo_contrato" id="codigo_contrato" value="{{ $id }}">
            <input type="hidden" name="tienda_contrato" id="tienda_contrato" value="{{ $id_tienda }}">
            @if(isset($autorizarTercero))
            <row>
                <div class="col-md-12" align="center">
                    <button class="btn btn-success" type="submit">Actualizar tercero</a>
                </div>
            </row>
            @endif
        </form>
    </div>
</div>
    
    <div class="x_title">
        <h2>Información Actual del Contrato</h2>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-md-4 bottom-20">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <label for="">Meses del Contrato</label>
                    <input type="text" readonly id=""  value="{{ $infoActualContrato[0]->meses_contrato }}" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
        </div>
        <div class="col-md-4 bottom-20">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <label for="">Número de Prórrogas</label>
                    <input type="text" readonly id=""  value="{{ $infoActualContrato[0]->numero_prorrogas }}" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
        </div>
        <div class="col-md-4 bottom-20">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <label for="">Meses Adeudados</label>
                    <input type="text" readonly id=""  value="{{ $infoActualContrato[0]->meses_adeudados }}" class="form-control col-md-7 col-xs-12">
                    <input type="hidden" id="meses_adeudados"  value="{{ $infoActualContrato[0]->meses_adeudados_int }}">
                </div>
            </div>
        </div>
        <div class="col-md-4 bottom-20">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <label for="">Meses Vencidos</label>
                    <input type="text" readonly id=""  value="{{ $infoActualContrato[0]->meses_vencidos }}" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
        </div>
        <div class="col-md-4 bottom-20">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <label for="">Fecha Cancelación Última Prórroga</label>
                    <input type="text" readonly id=""  value="{{ $infoActualContrato[0]->fecha_ultima_prorroga }}" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
        </div>
        <div class="col-md-4 bottom-20">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <label for="">Valor de Prórrogas Canceladas</label>
                    <input type="text" readonly id=""  value="{{ number_format($infoActualContrato[0]->valor_prorrogas_canceladas, 2, ',', '.') }}" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
        </div>
        <div class="col-md-4 bottom-20">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <label for="">Valor de la Retroventa a Cobrar</label>
                    <input type="text" readonly id=""  value="{{ number_format($infoActualContrato[0]->valor_retroventa, 2, ',', '.') }}" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
        </div>
        <div class="col-md-4 bottom-20">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <label for="">Descuento Concendido</label>
                    <input type="text" readonly id=""  value="{{ number_format($descuento_retroventa, 2, ',', '.') }}" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
        </div>
        <div class="col-md-4 bottom-20">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <label for="">Valor a Cobrar Después de Descuento</label>
                    <input type="text" readonly id=""  value="{{ number_format($retroventa_menos, 2, ',', '.') }}" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
        </div>
    </div>

    <div class="x_title">
        <h2>Items de contrato</h2>
        <div class="clearfix"></div>
    </div>
    <div class="items_contrato_tmp">
        <div class="hide">{{ $total_peso = 0 }}</div>
        <table class="display dataTableAction" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Línea Item</th>
                    <th>Categoría</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Peso Estimado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items AS $item)
                <tr>
                    <td>{{$item->id_linea_item_contrato}}</td>
                    <td>{{$item->categoria_general}}</td>
                    <td>{{$item->nombre_item}}</td>
                    <td>{{$item->descripcion_item}}</td>
                    <td>{{$item->precio_ingresado}}</td>
                    <td>{{$item->peso_estimado}}</td>
                    <td><div class="hide">{{ $total_peso += $item->peso_estimado }}</div></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>TOTALES: </td>
                    <td>{{ $items[0]->precio_ingresado_total }}</td>
                    <td>{{ $total_peso }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
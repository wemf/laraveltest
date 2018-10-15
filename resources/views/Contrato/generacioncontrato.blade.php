@extends('layouts.master') @section('content')

<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Generación de Contrato</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="form-horizontal form-label-left">
                    <div class="circleTraza col-md-offset-3 col-xs-offset-3">
                        <div class="circleTraza-row circlecontrato-row setup-panel">
                            <div class="circleTraza-step">
                                <a type="button" id="st1" class="btn btn-circle step btn-default btn-primary disabled">1</a>
                            </div>
                            <div class="circleTraza-step">
                                <a type="button" id="st2" class="btn btn-default btn-circle step disabled">2</a>
                            </div>
                            <div class="circleTraza-step">
                                <a type="button" id="st3" class="btn btn-default btn-circle step disabled">3</a>
                            </div>
                            <div class="circleTraza-step">
                                <a type="button" id="st4" class="btn btn-default btn-circle step disabled">4</a>
                            </div>
                        </div>
                    </div>


                    <!-- INFORMACIÓN Y ACTUALIZACIÓN DEL CLIENTE -->
                    <div id="step-1">
                        <form id="form-cliente" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}  
                            <div class="modal-styles confirm-hide modal-cc">
                                <div class="shadow" onclick="confirm.hide();"></div>
                                <div class="container">
                                    <div class="title">
                                        <h1 id="confirmtitle">Documento del Cliente</h1>
                                    </div>
                                    
                                    <input type="checkbox" name="chk_flip" id="chk_flip" class="hide">
                                    <div class="flip" style="height: 200px; margin: 10px auto;">
                                        <img @if($cliente != null) src="{{env('RUTA_ARCHIVO_OP')}}colombia\cliente\doc_persona_natural\{{$cliente->ruta_foto_posterior}}" @else  src="{{asset('images/noimagen.png') }}" @endif class="flip-1" onerror="this.src='{{ asset('images/noimagen.png') }}'" height="200px">
                                        <img @if($cliente != null) src="{{env('RUTA_ARCHIVO_OP')}}colombia\cliente\doc_persona_natural\{{$cliente->ruta_foto_anterior}}" @else  src="{{asset('images/noimagen.png') }}" @endif class="flip-2" onerror="this.src='{{ asset('images/noimagen.png') }}'" height="200px">
                                    </div>

                                    <div class="buttons">
                                        <label for="chk_flip" type="button" class="btn btn-success"><i class="fa fa-refresh"></i> Girar</label>
                                        <button id="cancelConfirm" type="button" class="btn btn-primary" onclick="confirm.hide();">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="x_title">
                                <h2>Información del Cliente</h2>
                                <div class="btn btn-primary pull-right" onclick="$('.modal-cc').addClass('confirm-visible').removeClass('confirm-hide');">Ver Documento</div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                                <label for="tipodocumento">Tipo de Documento <span class="required">*</span></label>
                                                <select id="tipodocumento" readonly name="tipodocumento" data-load="{{ $datos_cc['tipo_documento'] }}" class="form-control col-xs-12 tipodocumento"
                                                    required="required">
                                                    <option value="">- Seleccione una opción -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="numdocumento">Número de Documento <span class="required">*</span></label>
                                                <input name="numdocumento" readonly maxlength="25" id="numdocumento" type="text" value="{{ $datos_cc['numero_documento'] }}" class="form-control col-xs-12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="pais_residencia">País de Residencia <span class="required">*</span></label>
                                                @if($accion_cliente == 'create' || $ingresoManual == '')
                                                    <select name="pais_residencia" id="pais_residencia" onchange="loadSelectInputByParent('#ciudad_residencia', '{{url('/ciudad/getciudadbypais')}}', this.value, 1);" class="form-control col-xs-12 requerido pais"></select>
                                                @else
                                                    <input name="pais_residencia" readonly id="pais_residencia" type="text" value="@if($cliente != null){{$cliente->pais_residencia}}@endif" class="form-control col-xs-12 pais">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="ciudad_residencia">Ciudad de Residencia <span class="required">*</span></label>
                                                @if($accion_cliente == 'create' || $ingresoManual == '')
                                                    <select name="ciudad_residencia" id="ciudad_residencia" class="form-control col-xs-12 requerido ciudad" onchange="contrato.indicativoCliente();"></select>
                                                @else
                                                    <input readonly type="text" value="@if($cliente != null){{$cliente->ciudad_residencia}}@endif" class="form-control col-xs-12">
                                                    <input name="ciudad_residencia" readonly id="ciudad_residencia" type="hidden" value="@if($cliente != null){{$cliente->id_ciudad_residencia}}@endif" class="form-control col-xs-12 ciudad">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="fechanacimiento">Fecha de Nacimiento <span class="required">*</span></label>
                                                <input name="fechanacimiento" id="fechanacimiento" type="text" value="{{ $datos_cc['fecha_nacimiento'] }}" class="data-picker-only form-control col-xs-12 requerido" {{ $ingresoManual }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="fecha_expedicion">Fecha de Expedición </label>
                                                @if($accion_cliente == 'create')
                                                    <input name="fecha_expedicion" id="fecha_expedicion" type="text" class="data-picker-only form-control col-xs-12" {{ $ingresoManual }}>
                                                @else
                                                    <input name="fecha_expedicion" id="fecha_expedicion" type="text" value="@if($cliente != null){{$cliente->fecha_expedicion}}@endif" class="data-picker-only form-control col-xs-12" {{ $ingresoManual }}>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="pais_expedicion">País de Expedición </label>
                                                @if($accion_cliente == 'create' || $ingresoManual == '')
                                                    <select name="pais_expedicion" id="pais_expedicion" onchange="loadSelectInputByParent('#ciudad_expedicion', '{{url('/ciudad/getciudadbypais')}}', this.value, 1);" class="form-control col-xs-12 pais"></select>
                                                @else
                                                    <input name="pais_expedicion" readonly id="pais_expedicion" type="text" value="@if($cliente != null){{$cliente->pais_expedicion}}@endif" class="form-control col-xs-12 pais">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="ciudad_expedicion">Ciudad de Expedición </label>
                                                @if($accion_cliente == 'create' || $ingresoManual == '')
                                                    <select name="ciudad_expedicion" id="ciudad_expedicion" class="form-control col-xs-12 ciudad"></select>
                                                @else
                                                    <input name="ciudad_expedicion" readonly id="ciudad_expedicion" type="text" value="@if($cliente != null){{$cliente->ciudad_expedicion}}@endif" class="form-control col-xs-12 ciudad">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                                <label for="primer_nombre">Primer Nombre <span class="required">*</span></label>
                                                <input name="primer_nombre" {{ $ingresoManual }} id="primer_nombre" type="text" value="{{ $datos_cc['primer_nombre'] }}" class="form-control col-xs-12 requerido">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="segundo_nombre">Segundo Nombre </label>
                                                <input name="segundo_nombre" {{ $ingresoManual }} id="segundo_nombre" type="text" value="{{ $datos_cc['segundo_nombre'] }}" class="form-control col-xs-12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="primer_apellido">Primer Apellido <span class="required">*</span></label>
                                                <input name="primer_apellido" id="primer_apellido" {{ $ingresoManual }} type="text" value="{{ $datos_cc['primer_apellido'] }}" class="form-control col-xs-12 requerido">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="segundo_apellido">Segundo Apellido </label>
                                                <input name="segundo_apellido" id="segundo_apellido" {{ $ingresoManual }} type="text" value="{{ $datos_cc['segundo_apellido'] }}" class="form-control col-xs-12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="correo">Correo electrónico </label>
                                                @if($accion_cliente == 'create')
                                                    <input name="correo" id="correo" type="text" class="form-control col-xs-12 email_validado">
                                                @else
                                                    <input name="correo" id="correo" type="text" value="@if($cliente != null){{$cliente->correo_electronico}}@endif" class="form-control col-xs-12 email_validado">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="genero">Genero </label>
                                                <select name="genero" {{ $ingresoManual }} id="genero" class="form-control col-xs-12">
                                                    <option value="1" @if($datos_cc['genero'] == "M" || $datos_cc['genero'] == 'Masculino') selected @endif>Masculino</option>
                                                    <option value="2" @if($datos_cc['genero'] == "F" || $datos_cc['genero'] == 'Femenino') selected @endif>Femenino</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="direccion_residencia">Dirección de Residencia <span class="required">*</span></label>
                                                @if($accion_cliente == 'create')
                                                    <input data-post="1" name="direccion_residencia" id="direccion_residencia" type="text" class="form-control direccion col-xs-12 requerido">
                                                @else
                                                    <input data-post="1" name="direccion_residencia" id="direccion_residencia" value="@if($cliente != null){{$cliente->direccion_residencia}}@endif" type="text" class="form-control direccion col-xs-12 requerido">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="regimen">Régimen <span class="required">*</span></label>
                                                @if($accion_cliente == 'create' ||  $ingresoManual == '')
                                                    <select name="regimen" disabled="disabled" id="regimen" type="text" class="form-control col-xs-12 requerido"></select>
                                                @else
                                                    <input name="regimen" disabled="disabled" id="regimen" value="@if($cliente != null) @if($cliente->regimen != null){{$cliente->regimen}}@else Régimen Simplificado @endif @endif" type="text" class="form-control col-xs-12">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="telefono_residencia">Teléfono Fijo </label><br>
                                                @if($accion_cliente == 'create')
                                                    <input type="text" name="telefono_residencia_indicativo" id="telefono_residencia_indicativo" style="font-size: 13px !important;" maxlength="10" class="form-control col-md-7 col-xs-12  tl indicativo_cliente_telefono" readonly>
                                                    <input name="telefono_residencia" maxlength="10" id="telefono_residencia" type="text" class="form-control col-xs-12 justNumbers tlx">
                                                @else
                                                    <input type="text" name="telefono_residencia_indicativo" id="telefono_residencia_indicativo" style="font-size: 13px !important;" maxlength="10" class="form-control col-md-7 col-xs-12 tl indicativo_cliente_telefono" readonly>
                                                    <input name="telefono_residencia" maxlength="10" id="telefono_residencia" type="text" class="form-control col-xs-12 justNumbers tlx">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="telefono_celular">Celular <span class="required">*</span></label><br>
                                                @if($accion_cliente == 'create')
                                                    <input type="text" name="telefono_celular_indicativo" id="telefono_celular_indicativo" style="font-size: 13px !important;" maxlength="10" class="form-control col-md-7 col-xs-12 tl indicativo_cliente_celular" readonly >
                                                    <input name="telefono_celular" id="telefono_celular" maxlength="10" type="text" class="form-control col-xs-12 requerido justNumbers tlx">
                                                @else
                                                    <input type="text" name="telefono_celular_indicativo" id="telefono_celular_indicativo" style="font-size: 13px !important;" maxlength="10" class="form-control col-md-7 col-xs-12 requerido tl indicativo_cliente_celular" readonly>
                                                    <input name="telefono_celular" id="telefono_celular" maxlength="10" type="text" class="form-control col-xs-12 requerido justNumbers tlx">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                                <label for="cliente_confiable">Cliente Confiable </label><br>
                                                <!-- <label class="switch_check">
                                                    <input type="checkbox" id="cliente_confiable" name="cliente_confiable" value="1" onchange="intercaleCheck(this);" checked />
                                                    <span class="slider"></span>
                                                </label> -->
                                                <select id="cliente_confiable" name="cliente_confiable" class="form-control col-xs-12">
                                                <option value="">- Seleccione una opción -</option>
                                                @foreach ($confiabilidad as $item)
                                                <option data-contrato="{{ $item->permitir_contrato }}" value="{{ $item->DT_RowId }}" 
                                                @if($cliente != null)
                                                @if($cliente->id_confiabilidad == $item->DT_RowId)
                                                selected
                                                @endif
                                                @endif
                                                >{{ $item->nombre }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 bottom-20 hide">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                                <label for="suplantacion">Suplantación </label><br>
                                                <label class="switch_check">
                                                    <input type="checkbox" id="suplantacion" name="suplantacion" value="0" onchange="intercaleCheck(this);" />
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if($cliente != null)
                                        @if($cliente->ruta_foto_anterior == '')
                                            <input type="hidden" id="hf_guardar_anterior" name="hf_guardar_anterior" value="1" />
                                            <div class="col-md-6 col-xs-12 bottom-20">
                                                <div class="row">
                                                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                                                        <label for="foto_1">Documento Identificación parte frontal </label><br>
                                                        <input type="file" id="foto_1" name="foto_1" class="form-control col-xs-12 requerido">
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <input type="hidden" id="hf_guardar_anterior" name="hf_guardar_anterior" value="0" />
                                        @endif
                                    @else
                                        <input type="hidden" id="hf_guardar_anterior" name="hf_guardar_anterior" value="1" />
                                        <div class="col-md-6 col-xs-12 bottom-20">
                                            <div class="row">
                                                <div class="col-md-offset-1 col-md-10 col-xs-12">
                                                    <label for="foto_1">Documento Identificación parte frontal </label><br>
                                                    <input type="file" id="foto_1" name="foto_1" class="form-control col-xs-12 requerido">
                                                </div>
                                            </div>
                                        </div>
                                    @endif




                                    @if($cliente != null)
                                        @if($cliente->ruta_foto_posterior == '')
                                            <input type="hidden" id="hf_guardar_posterior" name="hf_guardar_posterior" value="1" />
                                            <div class="col-md-6 col-xs-12 bottom-20">
                                                <div class="row">
                                                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                                                        <label for="foto_2">Documento Identificación parte posterior </label><br>
                                                        <input type="file" id="foto_2" name="foto_2" class="form-control col-xs-12 requerido">
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <input type="hidden" id="hf_guardar_posterior" name="hf_guardar_posterior" value="0" />
                                        @endif
                                    @else
                                        <input type="hidden" id="hf_guardar_posterior" name="hf_guardar_posterior" value="1" />
                                        <div class="col-md-6 col-xs-12 bottom-20">
                                            <div class="row">
                                                <div class="col-md-offset-1 col-md-10 col-xs-12">
                                                    <label for="foto_2">Documento Identificación parte posterior </label><br>
                                                    <input type="file" id="foto_2" name="foto_2" class="form-control col-xs-12 requerido">
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    @if($accion_cliente == 'update')
                                        <input name="id_tienda" type="hidden" id="idtienda" value="@if($cliente != null){{$cliente->id_tienda}}@endif">
                                        <input name="codigo_cliente" type="hidden" id="idcliente" value="@if($cliente != null){{$cliente->codigo_cliente}}@endif">
                                    @else
                                        <input type="hidden" name="id_tienda" id="idtienda" value="{{ $tienda->id }}">
                                        <input type="hidden" name="codigo_cliente" id="idcliente">
                                    @endif
                                    <input type="hidden" id="ultimo_cod_bolsa" value="@if(isset($ultimo_cod_bolsa)){{$ultimo_cod_bolsa}}@else 0 @endif">
                                    <input type="hidden" id="codigo_contrato">
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2" align="center">
                                    
                                    @for($i = 0; $i < count($cod_bolsas_bloq); $i++)
                                    @if(isset($cod_bolsas_bloq[$i]->sec_invalida))
                                        <input type="hidden" name="bolsas_bloq[]" class="bolsas_bloq" value="{{ $cod_bolsas_bloq[$i]->sec_invalida }}">
                                    @endif
                                    @endfor
                                    
                                    
                                    @if($accion_cliente == 'create')
                                        <input type="hidden" id="type-action" value="create">
                                    @else
                                        <input type="hidden" id="type-action" value="update">
                                    @endif
                                    <a href="{{ url('contrato/index') }}" class="btn btn-danger">Cancelar</a>
                                    <button type="submit" class="btn btn-success">Siguiente</button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <!-- INFORMACIÓN GENERAL DEL CONTRATO (CABECERA) -->
                    <div id="step-2" style="display: none;">
                        <div class="x_title">
                            <h2>Información General del Contrato</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <form>
                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <div class="row">
                                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                                        <label for="tienda_contrato">Tienda <span class="required">*</span></label>
                                            <select id="tienda_contrato" {{ $enabletienda }} name="tienda_contrato" data-load="{{ $tienda->id }}" onchange="getTerminoRetroventa('{{ url('creacioncontrato/getterminoretroventa') }}');" class="form-control col-md-7 col-xs-12 requerido">
                                                <option> - Seleccione una opción - </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <div class="row">
                                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                                        <label for="category">Categoría General <span class="required">*</span></label>
                                            <select id="category" name="category" data-col-item="2" onchange="getTerminoRetroventa('{{ url('creacioncontrato/getterminoretroventa') }}'); contrato.pesoEstimado();  contrato.bolsaCategoria(); loadFirstAttributes(this, '{{ url('/configcontrato/itemcontrato/getatributoscontrato') }}'); contrato.validarDatosCategoria();" onmouseup="contrato.validarItems()" class="form-control col-md-7 col-xs-12 requerido">
                                                <option> - Seleccione una opción - </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <div class="row">
                                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                                        <label for="porcentaje_retroventa">% de Retroventa <span class="required">*</span></label>
                                            <input type="number" disabled="disabled" id="porcentaje_retroventa" name="porcentaje_retroventa" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <div class="row">
                                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                                        <label for="termino">Término <span class="required">*</span></label>
                                            <input type="number" disabled="disabled" id="termino" name="termino" onchange="calcularTerminacion();" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12 bottom-20 hide">
                                    <div class="row">
                                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                                        <label for="dias_gracia">Días de gracia <span class="required">*</span></label>
                                            <input type="number" disabled="disabled" id="dias_gracia" name="dias_gracia" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <div class="row">
                                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                                        <label for="fecha_creacion">Fecha Creación <span class="required">*</span></label>
                                            <input type="text" disabled="disabled" id="fecha_creacion" value="{{ Carbon\Carbon::now() }}" name="fecha_creacion" class="form-control col-md-7 col-xs-12 data-picker-only">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <div class="row">
                                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                                        <label for="fecha_terminacion">Fecha Terminacion <span class="required">*</span></label>
                                            <input type="text" disabled="disabled" id="fecha_terminacion" name="fecha_terminacion" class="form-control col-md-7 col-xs-12 data-picker-only">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-xs-12 bottom-20 hide" id="campo_aplica_bolsa">
                                    <div class="row">
                                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                                        <label for="numero_bolsa">Cantidad de Bolsas de Seguridad <span class="required">*</span></label>
                                            <input type="number" id="numero_bolsa" name="numero_bolsa" value="0" class="form-control col-md-7 col-xs-12 requerido">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-xs-12 bottom-20">
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="autorizar_tercero">Autorizar Tercero <span class="required">*</span></label><br>
                                            <label class="switch_check">
                                                <input type="checkbox" id="autorizar_tercero" name="autorizar_tercero" value="0" onchange="intercaleCheck(this); autorizarTercero();" />
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="pnl_autorizar_tercero" style="display:none;">
                            <div class="x_title">
                                <h2>Información del Tercero</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                <form>
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="paistercero">País <span class="required">*</span></label>
                                                <select id="paistercero" name="paistercero" onchange="loadSelectInputByParent('#departamentotercero', '{{url('/departamento/getdepartamentobypais')}}', this.value, 1);" class="form-control col-md-7 col-xs-12 requerido_tercero pais" required="required">
                                                    <option value="">- Seleccione una opción -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="departamentotercero">Departamento <span class="required">*</span></label>
                                                <select id="departamentotercero" name="departamentotercero" onchange="loadSelectInputByParent('#ciudadtercero', '{{url('/ciudad/getciudadbydepartamento')}}', this.value, 1);" class="form-control col-md-7 col-xs-12 requerido_tercero ciudad" required="required">
                                                    <option value="">- Seleccione una opción -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="ciudadtercero">Ciudad <span class="required">*</span></label>
                                                <select id="ciudadtercero" onchange="contrato.indicativoPais();" name="ciudadtercero" class="form-control col-md-7 col-xs-12 requerido_tercero ciudad" required="required">
                                                    <option value="">- Seleccione una opción -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="nombres_tercero">Nombres <span class="required">*</span></label>
                                                <input type="text" id="nombres_tercero" maxlength="40" name="nombres_tercero" class="form-control col-md-7 col-xs-12 requerido_tercero">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="apellidos_tercero">Apellidos <span class="required">*</span></label>
                                                <input type="text" id="apellidos_tercero" maxlength="40" name="apellidos_tercero" class="form-control col-md-7 col-xs-12 requerido_tercero">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="parentesco_tercero">Parentesco <span class="required">*</span></label>
                                                <select name="parentesco_tercero[]" id="parentesco_tercero" class="form-control col-md-3 requerido_tercero">
                                                    <option value="">- Seleccione una opción -</option>
                                                    @foreach($tipo_parentesco as $tipo)
                                                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="tipodocumentotercero">Tipo de Documento <span class="required">*</span></label>
                                                <select id="tipodocumentotercero" name="tipodocumentotercero" class="form-control col-md-7 col-xs-12 tipodocumento requerido_tercero" required="required">
                                                    <option value="">- Seleccione una opción -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="numero_documeto_tercero">Número de Documento <span class="required">*</span></label>
                                                <input type="text" id="numero_documeto_tercero" maxlength="25" name="numero_documeto_tercero" class="form-control col-md-7 col-xs-12 requerido_tercero">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="correo_tercero">Correo </label>
                                                <input type="text" id="correo_tercero" maxlength="50" name="correo_tercero" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="direccion_tercero">Dirección <span class="required">*</span></label>
                                                <input data-post="2" type="text" maxlength="80" id="direccion_tercero" name="direccion_tercero" class="form-control col-md-7 col-xs-12 direccion requerido_tercero">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="telefono_tercero">Teléfono <span class="required">*</span></label><br>
                                                <input type="text" id="telefono_tercero_indicativo" name="telefono_tercero_indicativo" style="font-size: 13px !important;" maxlength="10" class="form-control col-md-7 col-xs-12 tl" readonly>
                                                <input type="text" id="telefono_tercero" onkeyup="contrato.telefonosTercero();" maxlength="10" name="telefono_tercero" class="form-control col-md-7 col-xs-12 tlx justNumbers requerido_tercero">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 bottom-20">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-10 col-xs-12">
                                            <label for="celular_tercero">Celular <span class="required">*</span></label><br>
                                                <input type="text" id="celular_tercero_indicativo" name="celular_tercero_indicativo" style="font-size: 13px !important;" maxlength="10" class="form-control col-md-7 col-xs-12 tl" readonly>
                                                <input type="text" id="celular_tercero" onkeyup="contrato.telefonosTercero();" maxlength="10" name="celular_tercero" class="form-control col-md-7 col-xs-12 tlx justNumbers requerido_tercero">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2" align="center">
                                <button type="button" class="btn btn-danger" onclick="valVolver(2,1);">Atrás</button>
                                <button type="button" class="btn btn-success btn-guardar-contrato" disabled="disabled" onclick="contrato.validarRequeridos('#step-2', 2); contrato.bolsaCategoria(); contrato.tablaItems().agregarColumnas();">Siguiente</button>
                            </div>
                        </div>
                        <input type="hidden" value="0" id="contrato_guardado">
                    </div>



                    <!-- ITEMS DEL CONTRATO -->
                    <div id="step-3" style="display: none;">

                        <!-- MODAL PARA LA EDICIÓN DE LOS ITEMS -->
                        <div class="confirm-hide modal-update modal-styles">
                            <div class="shadow" onclick="confirm.hide();"></div>
                            <div class="container" style="margin-top: 20px;">
                                <div class="title"><h1 id="confirmtitle">Actualizar Ítem</h1></div>
                                <form class="form-horizontal form-left">
                                    <div class="form-group bottom-20">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="edit_nombre_item">Nombre</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" disabled="disabled" id="edit_nombre_item" name="edit_nombre_item" class="form-control col-md-7 col-xs-12 type-text">
                                        </div>
                                    </div>

                                    <div class="selects_actualizar">
                                    </div>

                                    <div class="form-group bottom-20 control_peso_contrato_edit">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="edit_peso_total_item">Peso total</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" min="0" id="edit_peso_total_item" name="edit_peso_total_item" onkeyup="contrato.validarPesoActualizar();" class="form-control col-md-7 col-xs-12 moneda centrar-derecha">
                                        </div>
                                    </div>
                                    <div class="form-group bottom-20 control_peso_contrato_edit">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="edit_peso_estimado_item">Peso estimado</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" min="0" id="edit_peso_estimado_item" name="edit_peso_estimado_item" onkeyup="contrato.validarPesoActualizar();" class="form-control col-md-7 col-xs-12 moneda centrar-derecha">
                                        </div>
                                    </div>
                                    <div class="form-group bottom-20">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="edit_precio_sugerido_item">Precio sugerido</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon">$</span>
                                                <input type="text" min="0" readonly id="edit_precio_sugerido_item" name="edit_precio_sugerido_item" class="form-control col-md-7 col-xs-12 moneda centrar-derecha" aria-label="Amount (to the nearest dollar)" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group bottom-20">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="edit_precio_ingresado_item">Precio ingresado</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon">$</span>
                                                <input type="text" min="0" id="edit_precio_ingresado_item" name="edit_precio_ingresado_item" class="form-control col-md-7 col-xs-12 moneda centrar-derecha" aria-label="Amount (to the nearest dollar)" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group bottom-20">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="edit_descripcion_item">Descripción </label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <textarea name="edit_descripcion_item" id="edit_descripcion_item" class="form-control col-md-7 col-xs-12"></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" id="edit_id_linea_item">
                                    <div class="form-group bottom-20">
                                        <div class="col-md-12">
                                            <button type="button" onclick="contrato.actualizarItem()" class="btn btn-success pull-right col-md-12" style="margin-right:0">Guardar</button>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group bottom-20">
                                        <div class="col-md-12">
                                            <button type="button" onclick="$('.modal-update').addClass('confirm-hide').removeClass('confirm-visible');" class="btn btn-primary pull-right col-md-12" style="margin-right:0">Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="x_title">
                            <h2>Información Detallada del Contrato</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row form-items-contrato">
                            <div class="col-md-6">
                                <form class="form-horizontal">
                                    <div class="selects">

                                    </div>
                                    <input type="hidden" name="valores_atributos" id="valores_atributos" />
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12 bottom-20">
                                            <label for="nombre_item">Nombre <span class='required red'>*</span></label>
                                            <input type="text" data-col-item="3" disabled="disabled" id="nombre_item" name="nombre_item" class="form-control col-md-7 col-xs-12 requerido-item type-text">
                                        </div>
                                    </div>

                                    <div class="row control_peso_contrato">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12 bottom-20">
                                            <label for="peso_total_item">Peso total <span class='required red'>*</span></label>
                                            <input type="text" min="0" id="peso_total_item" data-col-item="7" onkeyup="contrato.pesoIgual();" name="peso_total_item" class="form-control col-md-7 col-xs-12 requerido-item moneda centrar-derecha">
                                        </div>
                                    </div>

                                    <div class="row control_peso_contrato">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12 bottom-20">
                                            <label for="peso_estimado_item">Peso estimado <span class='required red'>*</span></label>
                                            <input type="text" min="0" id="peso_estimado_item" data-col-item="8" onkeyup="contrato.pesoIgual();" name="peso_estimado_item" class="form-control col-md-7 col-xs-12 requerido-item moneda centrar-derecha">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12 bottom-20">
                                            <label for="precio_sugerido_item">Precio por <span id="unidad_medida"></span> <span class='required red'>*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">$</span>
                                                <input type="text" readonly id="precio_sugerido_item" data-col-item="5" name="precio_sugerido_item" class="form-control col-md-7 col-xs-12 moneda centrar-derecha" aria-label="Amount (to the nearest dollar)" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12 bottom-20">
                                            <label for="precio_ingresado_item">Precio ingresado <span class='required red'>*</span></label>
                                            
                                            <div class="input-group">
                                                <span class="input-group-addon">$</span>
                                                <input type="text" min="0" id="precio_ingresado_item" data-col-item="6" name="precio_ingresado_item" class="form-control col-md-7 col-xs-12 requerido-item moneda centrar-derecha" aria-label="Amount (to the nearest dollar)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12 bottom-20">
                                            <label for="descripcion_item">Descripción </label>
                                            <textarea name="descripcion_item" data-col-item="4" id="descripcion_item" class="form-control col-md-7 col-xs-12"></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-10 col-xs-12 bottom-20">
                                            <button id="guardarItem" type="button" onclick="contrato.tablaItems().agregarItem()" class="btn btn-success pull-right col-md-12" style="margin-right:0">Guardar</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="btn-group pull-right espacio" role="group" aria-label="...">
                            <button title="Editar Registro Seleccionado" id="updateAction2" type="button" class="btn btn-primary" onclick="contrato.editarItem()"><i class="fa fa-pencil-square-o "></i> Actualizar</button>
                            <button title="Eliminar Registro Seleccionado" id="deletedAction2" type="button" class="btn btn-danger" onclick="contrato.tablaItems().removerItem()"><i class="fa fa-times-circle "></i> Eliminar</button>
                        </div>
                        <div class="col-md-12 content_tabla_items" style="overflow-x: auto;">
                            <table class="display" id="dataTableItems">
                            </table>
                        </div>                            

                        <!-- <table id="dataTableItems" class="display dataTable no-footer" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Linea Item</th>
                                    <th>Categoría</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio Sugerido</th>
                                    <th>Precio Ingresado</th>
                                    <th>Peso Estimado</th>
                                    <th>Peso Total</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td class="dataTables_empty"></td>
                                    <td class="dataTables_empty"></td>
                                    <td class="dataTables_empty"></td>
                                    <td class="dataTables_empty"></td>
                                    <td style="text-align: left !important;" class="dataTables_empty">Totales</td>
                                    <td style="text-align: left !important;" class="dataTables_empty" id="total_precio_ingresado">0</td>
                                    <td style="text-align: left !important;" class="dataTables_empty" id="total_peso_estimado">0</td>
                                    <td style="text-align: left !important;" class="dataTables_empty" id="total_peso_total">0</td>
                                </tr>
                            </tfoot>
                        </table> -->
                        <br>
                        <br>
                        <!-- <h2>Totales</h2>
                        <table id="totalesItems" class="display dataTable no-footer" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Precio Sugerido</th>
                                    <th>Precio Ingresado</th>
                                    <th>Peso Estimado</th>
                                    <th>Peso Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                            </tbody>
                        </table>
                        <br> -->
                        <div class="form-group">
                            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2" align="center">
                                <button type="button" class="btn btn-danger" onclick="valVolver(3,2);">Atrás</button>
                                <button type="button" class="btn btn-success" id="g3" onclick="contrato.resumenContrato()">Siguiente</button>
                            </div>
                        </div>
                    </div>




                    <!-- RESUMEN DEL CONTRATO -->
                    <div id="step-4" style="display: none;">
                        <div class="x_title">
                            <h2>Resumen de Contrato</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-md-offset-1">
                                <label>Tienda: <label id="res_tienda"></label></label><br>
                                <label>Código del Empleado: {{ Auth::user()->id }}</label><br>
                                <label>Nombre del Empleado: {{Auth::user()->name}}</label><br>
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <label>Nombre del Cliente: <label id="res_nombre_cliente"></label></label><br>
                                <label>Apellidos del Cliente: <label id="res_apellidos_cliente"></label></label><br>
                                <label>Fecha de Retroventa: <label id="res_fecha_retroventa"></label></label><br>
                            </div>
                            <hr>
                            <div class="col-md-5 col-md-offset-1">
                                <label>Categoría: <label id="res_categoria"></label></label><br>
                                <label class="codigos_bolsas">Número de Bolsas: <label id="res_numero_bolsa"></label></label><br class="codigos_bolsas">
                                <label>Códigos de Bolsas: <label id="res_cod_bolsas"></label></label><br>
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <label>Porcentaje de Retroventa: <label id="res_porcentaje_retroventa"></label></label><br>
                                <label>Término del Contrato: <label id="res_termino"></label></label><br>
                                <label>Retroventa del Contrato: <label id="res_retroventa"></label></label><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <h4>Items</h4>
                                <div id="table_items" class="col-md-12" style="overflow-x: auto;">
                                    <!-- <thead>
                                        <tr>
                                            <th>Línea Ítem</th>
                                            <th>Categoría</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Precio Sugerido</th>
                                            <th>Precio Ingresado</th>
                                            <th>Peso Total</th>
                                            <th>Peso Estimado</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody> -->
                                </div>
                            </div>
                        </div>      
                        <br><br>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <button type="button" class="btn btn-danger" onclick="valVolver(4,3);">Atrás</button>
                                <!-- <button type="button" class="btn btn-success" onclick="print.window('step-4');">Imprimir</button> -->
                                <!-- <a href="{{ url('contrato/index') }}" class="btn btn-primary">Terminar</a> -->
                                <button id="btn-terminar-contrato" class="btn btn-primary" onclick="contrato.guardarContrato()" >Terminar</button>
                            </div>
                        </div>  

                        <form id="form_pdf_contrato" class="hide" method="POST" action="{{ url('creacioncontrato/generarpdf') }}">
                            {{ csrf_field() }}  
                            @include('FormMotor/message')
                            <input type="hidden" id="contrato_pdf" name="contrato_pdf" >
                            <input type="hidden" id="tienda_pdf" name="tienda_pdf" >
                            <input type="submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #dataTableItems tr[role="row"] td:nth-child(1), #table_items tr[role="row"] td:nth-child(1) {
        font-size: 0 !important;
    }
    #dataTableItems td:nth-child(2), #dataTableItems td:nth-last-child(-n+4){
        text-align: right;
    }
    .dataTables_empty{
        text-align: center !important;
    }
</style>

@endsection @push('scripts')
<script src="{{asset('/js/contrato/generacioncontrato.js')}}"></script>
@endpush 
@section('javascript') 
@parent 
    //<script>


    var y = '@if(isset($cliente->telefono_celular)){{$cliente->telefono_celular}}@endif';
    var x = y.split(" ");

    $('#telefono_celular').val(x[1]);
    $('#telefono_celular_indicativo').val(x[0]);
    if(x[1] == "" || x[1] === undefined) 
    {
      $('#telefono_celular').val(x[0]);
      $('#telefono_celular_indicativo').val("");
    }  
    
    var y1 = '@if(isset($cliente->telefono_residencia)){{$cliente->telefono_residencia}}@endif';
    var x1 = y1.split(" ");

    $('#telefono_residencia').val(x1[1]);
    $('#telefono_residencia_indicativo').val(x1[0]);
    if(x1[1] == "" || x1[1] === undefined) 
    {
      $('#telefono_residencia').val(x1[0]);
      $('#telefono_residencia_indicativo').val("");
    } 


    loadSelectInput("#regimen", "{{url('/sociedad/getSelectListRegimen')}}",2); 
    $('#regimen option[value="2"]').attr('selected', 'selected');
    loadSelectInput(".pais", "{{url('/pais/getSelectList')}}",2); 
    loadSelectInput(".ciudad", "{{url('/ciudad/getSelectList')}}",2); 
    loadSelectInput(".tipodocumento", "{{url('/clientes/tipodocumento/getSelectList2')}}",2); 
    loadSelectInput("#tienda_contrato", "{{url('/tienda/getSelectList')}}",2); 

    
    loadSelectInput("#departamentotercero", "{{url('/departamento/getSelectList')}}",2); 
    fillInput('#ciudad_residencia', '.indicativo_cliente_telefono', urlBase.make('ciudad/getinputindicativo2'));
    fillInput('#ciudad_residencia', '.indicativo_cliente_celular', urlBase.make('ciudad/getinputindicativo'));
    
    fillInput('#ciudadtercero', '#telefono_tercero_indicativo', urlBase.make('ciudad/getinputindicativo2'));
    fillInput('#ciudadtercero', '#celular_tercero_indicativo', urlBase.make('ciudad/getinputindicativo'));
    contrato.setUrlGetCategory("{{ url('/products/categories/getCategory') }}");
    contrato.setUrlAttributeCategoryById("{{ url('/configcontrato/itemcontrato/getatributoscontrato') }}");
    contrato.setUrlAttributeAttributesById("{{ url('/configcontrato/itemcontrato/getatributoshijoscontrato') }}");
    runAttributeForm(); 

    column=[ 
        { "data": "Linea_Item" },
        { "data": "Categoria_Item" },
        { "data": "Nombre_Item" },
        { "data": "Descripcion_Item" },
        { "data": "Precio_Item" },
        { "data": "Precio_Estimado_Item" },
    ];
    // $('#dataTableItems').DataTable({
    //     language: {
    //         url: urlBase.make('plugins/datatable/DataTables-1.10.13/json/spanish.json')
    //     }
    // });

@endsection
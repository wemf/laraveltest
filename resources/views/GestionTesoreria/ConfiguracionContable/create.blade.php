@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-12">
<div class="x_panel">
<div class="x_title">
    <h2>Nueva Configuraci&oacute;n Contable</h2>
<div class="clearfix"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Atributos</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-1">
                    <form class="form-horizontal">
                        <div class="selects">
                        </div>
                        <input type="hidden" name="valores_atributos" id="valores_atributos" />
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="form-group">
                        <label class="control-label col-md-offset-1" for="nombre_item">Nombre</label>
                        <div class="col-md-9 col-md-offset-1">
                            <input type="text" readOnly id="nombre_item" name="nombre_item" class="form-control type-text">
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='enviarAtributosModal'>Enviar</button>      
        <button type="button" class="btn btn-danger" data-dismiss="modal" id='cerrarModal'>Cerrar</button>
      </div>
    </div>
  </div>
</div>
      <div class="x_content">
        <br />
        <form id="form-attribute" autocomplete="off" action="javascript:void(0)" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}
            @include('FormMotor/message')
            <!-- <div class="x_title"><h2>Datos Generales</h2><div class="clearfix"></div></div> -->
            <div class="row">
                <div class="col-md-6 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label class="control-label col-xs-4">Tipo Documento Contable<span class="required">*</span></label>
                        <div class="col-md-8">
                            <select  class="column_filter form-control requiered" name='id_tipo_documento_contable' id="id_tipo_documento_contable">
                                <option value="">- Seleccione una opci&oacute;n -</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label class="control-label col-xs-4">Categor&iacute;a General</label>
                        <div class="col-md-8">
                            <select id="category" name="category" onchange="loadFirstAttributes(this, '{{ url('/configcontrato/itemcontrato/getatributoscontrato') }}'); unlockDisables();" data-col-item="2" class="form-control col-md-7 col-xs-8">
                                <option> - Seleccione una opci&oacute;n - </option>
                            </select>
                        </div>                            
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label class="control-label col-xs-4">Atributos</label>
                        <div class="col-md-7">                        
                            <input readOnly type="text" id="producto" name="producto" class="form-control" value=''>
                        </div>
                        <div class="col-md-1">
                            <a data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-list-ul fa-lg"></i>
                            </a>
                        </div>
                        <input type="hidden" name="valores_atributos_principal" id="valores_atributos_principal" />
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label class="control-label col-xs-4">Nombre Concepto<span class="required">*</span></label>
                        <div class="col-md-8">                        
                            <input type="text" id="nombre" name="nombre" class="form-control requiered" value=''>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label class="control-label col-xs-4">Descripci&oacute;n Tesorer&iacute;a<span class="required">*</span></label>
                        <div class="col-md-8">
                            <select  class="column_filter form-control requiered" name='id_clase' id="id_clase">
                                <option value="">- Seleccione una opci&oacute;n -</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label class="control-label col-xs-4"></label>
                        <div class="col-md-8">
                            <select  class="column_filter form-control requiered" name='id_subclase' id="id_subclase">
                                <option value="">- Seleccione una opci&oacute;n -</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="x_title">
                    <h2>Conceptos</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="movimientos">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-xs-2 justNumbers">PUC<span class="required">*</span></label>
                            <div class="col-xs-8">
                                <input type="text" id="nom_puc" name="nom_puc[]" class="form-control requieredPuc nom_puc requiered" value='' onkeyup="buscarCodigos(this)">
                                <input type="hidden" id="cod_puc" name="cod_puc[]" class="form-control requieredPuc cod_puc " value=''>
                                <input type="hidden" id="hd_codigoPuc" name="hd_codigoPuc[]" class="form-control hd_codigoPuc" value=''>
                            </div>
                            <div class="selec_puc col-xs-8 col-xs-offset-2" style="display:none;">
                                <select name="selec_puc[]" id="selec_puc" class="selectSearch form-control col-xs-12" size="4" class="form-control co-md-12" onclick="selectValue(this);"></select>
                            </div>
                        </div>	
                        
                        <div class="form-group">
                            <label class="control-label col-xs-2">Naturaleza<span class="required">*</span></label>
                            <div class="col-xs-8">
                                <select class="column_filter form-control id_naturaleza requiered" disabled="true" id="id_naturaleza" name="id_naturaleza[]">
                                    <option value="">- Seleccione una opci&oacute;n -</option>
                                    <option value="0">Cr&eacute;dito</option>
                                    <option value="1">D&eacute;bito</option>
                                </select> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Descripci&oacute;n<span class="required">*</span></label>
                            <div class="col-xs-5">
                                <input type="text" id="descripcion" name="descripcion[]" class="form-control requiered" value=''>        
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3" style="margin-top: -4px;">
                                Tiene Tercero? <input type="checkbox" onchange="intercaleCheck(this), habilitartercero(this);" id="tercero0" name="tienetercero[]" class="column_filter check-control check-pos" value="0" />
                                <label for="tercero0" class="lbl-check-control" style="font-size: 27px!important; margin-top: -10px; font-weight: 100; height: 26px; display: block;"></label>
					        </div>
                            <div class="row primeraCausacion hide">
                                <span class="col-xs-8 col-md-8 col-md-offset-2 col-xs-offset-2" style="color:red">El sistema tomar&aacute; estos datos como la cuenta causaci&oacute;n.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Tercero<span class="required">*</span></label>
                            <div class="col-xs-8">
                                <input type="text" readOnly id="terceros" name="terceros[]" class="form-control  terceros" onkeyup="buscarProv(this)" value=''>
                                <input type="hidden" id="cod_tercero" name="cod_tercero[]" class="form-control  cod_tercero" value=''>
                                <input type="hidden" id="cod_tienda_tercero" name="cod_tienda_tercero[]" class="form-control  cod_tienda_tercero" value=''>
                                <input type="hidden" id="hd_terceros" name="hd_terceros[]" class="form-control  hd_terceros" value=''>
                            </div>
                            <div class="selec_puc col-xs-8 col-xs-offset-2" style="display:none;">
                                <select name="selec_puc[]" id="selec_puc" class="selectSearchProv form-control col-xs-12" size="4" class="form-control co-md-12" onclick="selectValueProv(this);"></select>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 col-xs-12 opciones col-md-offset-5">
                        <button type="button" id="adicionar" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar</button>
                        <button type="button" id="borrar" onclick="borrarfila(this)" class="btn btn-danger"><i class="fa fa-remove"></i> Borrar</button>
                    </div>
                </div>
                <hr>
            </div>
            <div class="row">
                <div class="x_title">
                    <h2>Impuestos</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="impuestos">
                <div class="col-md-6 col-xs-12 opcionesimpuesto col-md-offset-5">
                    <button type="button" id="adicionarimpuesto" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar</button>
                    <button type="button" id="borrar" onclick="borrarfila(this)" class="btn btn-danger"><i class="fa fa-remove"></i> Borrar</button>
                </div>
            </div>
          <div class="row">
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-5">
              <button type="submit" class="btn btn-success">Guardar</button>
              <a href="{{ url('/contabilidad/configuracioncontable') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/tesoreria/configuracionContable.js')}}"></script>
    <script src="{{asset('/js/contrato/generacioncontrato.js')}}"></script>
@endpush

@section('javascript')
loadSelectInput("#id_tipo_documento_contable","{{ url('/tesoreria/tipodocumentocontable/getselectlist') }}");
loadSelectInput("#id_clase","{{ url('/contabilidad/configuracioncontable/selectlistclase') }}");
$('#id_clase').change(function()
{
    fillSelect("#id_clase","#id_subclase","{{ url('/contabilidad/configuracioncontable/selectlistsubclasebyclase') }}");
});
@parent
    contrato.setUrlGetCategory("{{ url('/products/categories/getCategory') }}");
    contrato.setUrlAttributeCategoryById("{{ url('/configcontrato/itemcontrato/getatributoscontrato') }}");
    contrato.setUrlAttributeAttributesById("{{ url('/configcontrato/itemcontrato/getatributoshijoscontrato') }}");
    runAttributeForm();
@endsection

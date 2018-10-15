@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Configuraci&oacute;n Contable</h2>
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
                <br>
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
                    <div class="form-group">
                        <label class="control-label col-md-8 col-sm-8 col-xs-8 col-md-offset-1" for="nombre_item">Nombre</label>
                        <div class="col-md-offset-1 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" readOnly id="nombre_item" name="nombre_item" class="form-control col-md-8 col-xs-8 type-text">
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
            
            <input type="hidden" id="idconfiguracion" name="idconfiguracion" value="{{$configuracioncontable->id}}">         
            <input type="hidden" name="es_borrable" value="{{$configuracioncontable->es_borrable}}">         
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
                            <select id="category" name="category" onchange="loadFirstAttributes(this, '{{ url('/configcontrato/itemcontrato/getatributoscontrato') }}');" data-col-item="2" class="form-control col-md-7 col-xs-8">
                                <option> - Seleccione una opci&oacute;n - </option>
                            </select>
                        </div>                            
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label class="control-label col-xs-4">Atributos</label>
                        <div class="col-md-7">                        
                            <input readOnly type="text" id="producto" name="producto" class="form-control"value='{{$configuracioncontable->nombreproducto}}'>
                        </div>
                        @if($configuracioncontable->es_borrable == 1)
                        <div class="col-md-1">
                            <a  data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-list-ul fa-lg"></i>                            
                            </a>
                        </div>
                        @endif
                        <input type="hidden" name="valores_atributos_principal" id="valores_atributos_principal" value="{{$configuracioncontable->atributos}}" />                        
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label class="control-label col-xs-4">Nombre Concepto<span class="required">*</span></label>
                        <div class="col-md-8">                        
                            <input type="text" id="nombre" name="nombre" class="form-control requiered" value='{{$configuracioncontable->nombre}}'>
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
                                <input type="text" id="nom_puc" name="nom_puc[]" class="form-control requieredPuc nom_puc" value='{{$movimientos[0]->nom_puc}}' onkeyup="buscarCodigos(this)">
                                <input type="hidden" id="cod_puc" name="cod_puc[]" class="form-control requieredPuc cod_puc "value='{{$movimientos[0]->idpuc}}'>
                                <input type="hidden" id="id" name="id[]" class="form-control "value='{{$movimientos[0]->id}}'>
                                <input type="hidden" id="hd_codigoPuc" name="hd_codigoPuc[]" class="form-control hd_codigoPuc" value='{{$movimientos[0]->nom_puc}}'>
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
                                <option @if ($movimientos[0]->id_naturaleza == 0) selected="selected" @endif value="0" >Cr&eacute;dito</option>
                                <option @if ($movimientos[0]->id_naturaleza == 1) selected="selected" @endif value="1">D&eacute;bito</option>
                            </select> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Descripci&oacute;n<span class="required">*</span></label>
                            <div class="col-xs-5">
                                <input type="text" id="descripcion" name="descripcion[]" class="form-control requiered" value='{{$movimientos[0]->descripcion}}'>        
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3" style="margin-top: -4px;">
                                Tiene Tercero? <input type="checkbox" onchange="intercaleCheck(this), habilitartercero(this);" id="tercero0" name="tienetercero[]" class="column_filter check-control check-pos tercero" value='{{$movimientos[0]->tienetercero}}'/>
                                <label for="tercero0" class="lbl-check-control" style="font-size: 27px!important; margin-top: -10px; font-weight: 100; height: 26px; display: block;"></label>
					        </div>
                            <div class="row primeraCausacion hide">
                                <span class="col-xs-8 col-md-8 col-md-offset-2 col-xs-offset-2" style="color:red">El sistema tomar&aacute;n estos datos como la cuenta causaci&oacute;n.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Tercero<span class="required">*</span></label>
                            <div class="col-xs-8">
                                <input type="text" id="terceros" name="terceros[]" onkeyup="buscarProv(this);validarRequeridos(this);" value='{{$movimientos[0]->nombre_cliente}}' @if ($movimientos[0]->tienetercero == 0) readOnly class="form-control terceros" @else  class="form-control terceros requiered" @endif >
                                <input type="hidden" id="cod_tercero" name="cod_tercero[]" class="form-control  cod_tercero "value='{{$movimientos[0]->id_cliente}}'>                                
                                <input type="hidden" id="cod_tienda_tercero" name="cod_tienda_tercero[]" class="form-control  cod_tienda_tercero" value='{{$movimientos[0]->id_tienda}}'>                                
                                <input type="hidden" id="hd_terceros" name="hd_terceros[]" class="form-control hd_terceros"  value='{{$movimientos[0]->nombre_cliente}}'>
                            </div>
                            <div class="selec_puc col-xs-8 col-xs-offset-2" style="display:none;">
                                <select name="selec_puc[]" id="selec_puc" class="selectSearchProv form-control col-xs-12" size="4" class="form-control co-md-12" onclick="selectValueProv(this);"></select>
                            </div>
                        </div>
                    </div>
                    @if(isset($movimientos[1]))
                    @for($i = 1; $i < count($movimientos);$i++)
                    <div class="col-md-6 col-xs-12 movimiento">
                        <div class="form-group">
                            <label class="control-label col-xs-2 justNumbers">PUC<span class="required">*</span></label>
                            <div class="col-xs-8">
                                <input type="text" id="nom_puc" name="nom_puc[]" class="form-control requiered nom_puc" onkeyup="buscarCodigos(this)" value='{{$movimientos[$i]->nom_puc}}'>
                                <input type="hidden" id="cod_puc" name="cod_puc[]" class="form-control requiered cod_puc " value='{{$movimientos[$i]->idpuc}}'>
                                <input type="hidden" id="id" name="id[]" class="form-control "value='{{$movimientos[$i]->id}}'>                                                                                                                                                                         
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
                                    <option @if ($movimientos[$i]->id_naturaleza == 0) selected="selected" @endif value="0" >Cr&eacute;dito</option>
                                    <option @if ($movimientos[$i]->id_naturaleza == 1) selected="selected" @endif value="1">D&eacute;bito</option>
                                </select> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Descripci&oacute;n<span class="required">*</span></label>
                            <div class="col-xs-5">
                            <input type="text" id="descripcion" name="descripcion[]" class="form-control requiered" value='{{$movimientos[$i]->descripcion}}'>        
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3" style="margin-top: -4px;">
                                Tiene Tercero? <input type="checkbox" onchange="intercaleCheck(this), habilitartercero(this);"    id="tercero{{$i}}" name="tienetercero[]" class="column_filter check-control check-pos tercero" value='{{$movimientos[$i]->tienetercero}}'/>
                                <label for="tercero{{$i}}" class="lbl-check-control" style="font-size: 27px!important; margin-top: -10px; font-weight: 100; height: 26px; display: block;"></label>
					        </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Tercero<span class="required">*</span></label>
                            <div class="col-xs-8">
                                <input type="text" id="terceros" name="terceros[]" class="form-control  terceros" onkeyup="buscarProv(this)" value='{{$movimientos[$i]->nombre_cliente}}' @if ($movimientos[$i]->tienetercero == 0) readOnly @endif >
                                <input type="hidden" id="cod_tercero" name="cod_tercero[]" class="form-control  cod_tercero " value='{{$movimientos[$i]->id_cliente}}'>                                
                                <input type="hidden" id="cod_tienda_tercero" name="cod_tienda_tercero[]" class="form-control  cod_tienda_tercero " value='{{$movimientos[$i]->id_tienda}}'>                                
                                <input type="hidden" id="hd_terceros" name="hd_terceros[]" class="form-control hd_terceros"  value='{{$movimientos[0]->nombre_cliente}}'>
                            </div>
                            <div class="selec_puc col-xs-8 col-xs-offset-2" style="display:none;">
                                <select name="selec_puc[]" id="selec_puc" class="selectSearchProv form-control col-xs-12" size="4" class="form-control co-md-12" onclick="selectValueProv(this);"></select>
                            </div>
                        </div>

                    </div>
                    @endfor
                    @endif   
                    <div class="col-md-6 col-xs-12 opciones col-md-offset-5">
                        <button type="button" id="adicionar" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar</button>                    
                        <button type="button" id="borrar" onclick="borrarfila(this)" class="btn btn-danger"><i class="fa fa-remove"></i> Borrar</button>                    
                    </div>
                </div>
                <br>                     
            </div>
            <div class="row">
                <div class="x_title">
                    <h2>Impuestos</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="impuestos">
                @for($i = 0; $i < count($impuestos); $i++)
                <div class="col-md-6 col-xs-12 movimiento">
                    <div class="form-group">
                        <label class="control-label col-xs-2">Nombre<span class="required">*</span></label>
                        <div class="col-xs-8">
                            <input type="text" id="impuesto_nombre" name="impuesto_nombre[]" class="form-control requiered" value='{{$impuestos[$i]->nombre_impuesto}}'>
                            <input type="hidden" id="id" name="idimpuestos[]" class="form-control" value='{{$impuestos[$i]->id}}'>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-2 justNumbers">PUC</label>
                        <div class="col-xs-8">
                            <input type="text" id="impuesto" name="impuesto[]" class="form-control nom_puc requieredPuc" value='{{$impuestos[$i]->nom_puc}}' onkeyup="buscarCodigosImpuestos(this)">        
                            <input type="hidden" id="select_puc_impuesto" name="select_puc_impuesto[]" class="form-control cod_puc" value='{{$impuestos[$i]->idpuc}}'>        
                        <input type="hidden" id="hd_codigoPuc" name="hd_codigoPuc[]" class="form-control hd_codigoPuc" value='{{$impuestos[$i]->nom_puc}}'>
                        </div>
                        <div class="selec_puc_impuesto col-xs-7 col-xs-offset-2 " style="display:none;">
                            <select id="selec_puc_impuesto" class="selectSearch form-control col-xs-12" size="4" class="form-control co-md-12" onclick="selectValue(this);"></select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-2">Naturaleza<span class="required">*</span></label>
                        <div class="col-xs-8">
                        <select class="column_filter form-control id_naturaleza_impuesto requiered" id="id_naturaleza_impuesto" name="id_naturaleza_impuesto[]" >
                            <option value="">- Seleccione una opci&oacute;n -</option>
                            <option @if ($impuestos[$i]->id_naturaleza == 0) selected="selected" @endif value="0">Cr&eacute;dito</option>
                            <option @if ($impuestos[$i]->id_naturaleza == 1) selected="selected" @endif value="1">D&eacute;bito</option>
                        </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-2">Porcentaje<span class="required">*</span></label>
                        <div class="col-xs-8">
                            <input readOnly type="number" id="porcentaje_impuesto" name="porcentaje_impuesto[]" step="any" class="form-control requiered" value='{{$impuestos[$i]->porcentaje}}'>        
                        </div>
                    </div>
                </div>
                @endfor
                <div class="col-md-6 col-xs-12 opcionesimpuesto col-md-offset-5">
                    <button type="button" id="adicionarimpuesto" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar</button>                    
                    <button type="button" id="borrar" onclick="borrarfila(this)" class="btn btn-danger"><i class="fa fa-remove"></i> Borrar</button>                    
                </div> 
            </div>
            <div class="row"></div>
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
@parent 
contrato.setUrlGetCategory("{{ url('/products/categories/getCategory') }}");
contrato.setUrlAttributeCategoryById("{{ url('/configcontrato/itemcontrato/getatributoscontrato') }}");
contrato.setUrlAttributeAttributesById("{{ url('/configcontrato/itemcontrato/getatributoshijoscontrato') }}");
runAttributeForm(); 

loadSelectInput("#id_tipo_documento_contable","{{ url('/tesoreria/tipodocumentocontable/getselectlist') }}");
loadSelectInput("#id_clase","{{ url('/contabilidad/configuracioncontable/selectlistclase') }}");

$('#id_clase').change(function()
{
    fillSelect("#id_clase","#id_subclase","{{ url('/contabilidad/configuracioncontable/selectlistsubclasebyclase') }}");    
});

$('#id_tipo_documento_contable').val({{$configuracioncontable->id_tipo_documento_contable}})
$('#category').val({{$configuracioncontable->id_categoria}});
$('#category').change();
$('#id_clase').val({{$configuracioncontable->id_clases}});
$('#id_clase').change();
$('#id_subclase').val({{$configuracioncontable->id_subclase}})

if({{$configuracioncontable->es_borrable}} == 0)
{
  $('#id_tipo_documento_contable').attr('disabled', 'disabled');
  $('#category').attr('disabled', 'disabled');
  $('#id_clase').attr('disabled', 'disabled');
  $('#id_subclase').attr('disabled', 'disabled');
}
@endsection

    

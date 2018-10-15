@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ver Configuraci&oacute;n Contable</h2>
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
                <div class="col-md-offset-1 col-md-8 col-xs-8">
                    <label for="category">Categor&iacute;a General <span class="required">*</span></label>
                    <select id="category" name="category" data-col-item="2" class="form-control col-md-7 col-xs-8 requerido">
                        <option> - Seleccione una opci&oacute;n - </option>
                    </select>
                </div>
            </div>
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
                            <input readOnly type="text" class="form-control" value  ="{{$configuracioncontable->categoria}}">
                        </div>                            
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label class="control-label col-xs-4">Producto</label>
                        <div class="col-md-8">
                            <input readOnly type="text" id="producto" name="producto" class="form-control" value='{{$configuracioncontable->nombreproducto}}'>
                        </div>
                        
                        <input type="hidden" name="valores_atributos_principal" id="valores_atributos_principal" value="{{$configuracioncontable->atributos}}" />                        
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label class="control-label col-xs-4">Nombre Concepto<span class="required">*</span></label>
                        <div class="col-md-8">                        
                            <input readOnly type="text" id="nombre" name="nombre" class="form-control requiered" value='{{$configuracioncontable->nombre}}'>
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
                @for($i = 0; $i < count($movimientos); $i++)                
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-xs-2 justNumbers">PUC<span class="required">*</span></label>
                            <div class="col-xs-8">
                                <input readonly type="text" id="nom_puc" name="nom_puc[]" class="form-control requiered nom_puc" value='{{$movimientos[$i]->nom_puc}}'>
                                <input type="hidden" id="cod_puc" name="cod_puc[]" class="form-control requiered cod_puc " value=''>                                
                            </div>
                            <div class="selec_puc col-xs-8 col-xs-offset-2" style="display:none;">
                                <select name="selec_puc[]" id="selec_puc" class="selectSearch form-control col-xs-12" size="4" class="form-control co-md-12" onclick="selectValue(this);"></select>
                            </div>
                        </div>	
                        
                        <div class="form-group">
                            <label class="control-label col-xs-2">Naturaleza<span class="required">*</span></label>
                            <div class="col-xs-8">
                            <input readonly type="text" id="nom_puc" name="nom_puc[]" class="form-control requiered nom_puc" value='{{$movimientos[$i]->naturaleza}}'>                             
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Descripci&oacute;n<span class="required">*</span></label>
                            <div class="col-xs-8">
                            <input readonly type="text" id="descripcion" name="descripcion[]" class="form-control requiered" value='{{$movimientos[$i]->descripcion}}'>        
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="control-label col-xs-2">Tercero<span class="required">*</span></label>
                            <div class="col-xs-8">
                                <input readonly type="text" id="terceros" name="terceros[]" class="form-control  terceros" value='{{$movimientos[$i]->nombre_cliente}}'>
                            </div>
                        </div>
                    </div>
                @endfor                    
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
                <div class="row">
                @for($i = 0; $i < count($impuestos); $i++)
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-xs-2">Nombre<span class="required">*</span></label>
                            <div class="col-xs-8">
                                <input readOnly type="text" id="impuesto_nombre" name="impuesto_nombre[]" class="form-control requiered" value='{{$impuestos[$i]->nombre_impuesto}}'>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2 justNumbers">PUC</label>
                            <div class="col-xs-8">
                            <input readOnly type="text" id="impuesto" name="impuesto[]" class="form-control nom_puc" value='{{$impuestos[$i]->nom_puc}}'>        
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Naturaleza<span class="required">*</span></label>
                            <div class="col-xs-8">
                                <input readOnly type="text" id="impuesto" name="impuesto[]" class="form-control nom_puc" value='{{$impuestos[$i]->naturaleza}}'>        
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
                </div>          
            </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-5">
              <a href="{{ url('/contabilidad/configuracioncontable') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
@endsection
@section('javascript')
loadSelectInput("#id_tipo_documento_contable","{{ url('/tesoreria/tipodocumentocontable/getselectlist') }}");
loadSelectInput("#id_subclase","{{ url('/contabilidad/configuracioncontable/selectlistsubclase') }}");
loadSelectInput("#id_clase","{{ url('/contabilidad/configuracioncontable/selectlistclase') }}");
$('#id_tipo_documento_contable').val({{$configuracioncontable->id_tipo_documento_contable}})
$('#id_clase').val({{$configuracioncontable->id_clases}})
$('#id_subclase').val({{$configuracioncontable->id_subclase}})
$('#id_tipo_documento_contable').attr('disabled', 'disabled');
$('#id_clase').attr('disabled', 'disabled');
$('#id_subclase').attr('disabled', 'disabled');

@endsection

<h4>Retiro de Personal
  <input type="checkbox" name="retiro" class="check-retiro">
  <input type="hidden" name="retiro" class="check-retiro" >
  <input type="hidden" id="anterior">
</h4>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de retiro
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input id="fecha_retiro" name="fecha_retiro" class="form-control col-md-7 col-xs-12 data-picker-only" value="{{$attribute->fecha_retiro}}" disabled>
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">Motivo de retiro
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <select id="id_motivo_retiro" name="id_motivo_retiro" class="form-control col-md-7 col-xs-12 id_motivo_retiro" disabled>
        <option value="">- Seleccione una opción -</option>
        @foreach($motivo_retiro as $tipo)
        <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
        @endforeach 
    </select>
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">Observaciones
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <textarea name="observacion_novedad" class="form-control col-md-7 col-xs-12 id_motivo_retiro" disabled>{{$attribute->observacion_novedad}}</textarea>
  </div>
</div>
<div class="form-group">
  <div class="col-md-6 col-sm-6 col-xs-12">
    <input type="hidden" id="codigo_cliente" name="codigo_cliente" value="{{$attribute->codigo_cliente}}">
    <input type="hidden" id="hd_id_tienda" name="id_tienda_actual" value="{{$attribute->id_tienda}}" >
  </div>
</div>
<div class="center">
    <button type="button" class="btn btn-anterior btn-primary" data-id-div="tabs-6" data-anterior="1" data-href="tabs-5" next="ui-id-5"><i class="fa fa-angle-left" aria-hidden="true"></i> Anterior</button>
</div>
<div class="x_title">
  <div class="clearfix"></div>
</div>
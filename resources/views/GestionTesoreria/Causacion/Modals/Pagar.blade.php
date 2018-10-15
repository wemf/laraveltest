<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Forma de Pago</h4>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-1">
                    <form class="form-horizontal">
                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-xs-4">Forma de Pago<span class="required">*</span>
                                </label>
                                <div class="col-xs-8">
                                <select id="formaPago" name="formaPago" class="form-control  generalrequired">
                                    <option value="0">-Seleccione un registro-</option>
                                    <option value="1">Banco</option>
                                    <option value="2">Caja</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id" />
                    </form>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='pagar'>Pagar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" id='cerrarModal'>Cerrar</button>
      </div>
    </div>
  </div>
</div>
    <!--  Modal de Confirmación  -->
    <div class="modal-confirm confirm-hide">
      <div class="shadow" onclick="confirm.hide();"></div>
      <div class="container">
        <div class="title"><h1 id="confirmtitle">Título</h1></div>
        <h3 id="confirmsegment" class="segment">¿Confirmar?</h3>
        <div class="buttons">
          <button id="confirmSuccess" type="button" onclick="confirm.success();" class="btn btn-success" >Aceptar</button>
          <button id="cancelConfirm" type="button" class="btn btn-primary" onclick="confirm.hide();">Cancelar</button>
        </div>
      </div>
    </div>
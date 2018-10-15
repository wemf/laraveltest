<h4>Información Académica</h4>
<div class="panel panel-primary">
  <div class="panel-heading">Estudios Realizados</div>
  <div class="panel-body">
    <button type="button" class="btn btn-info btn-agregar-fila">Agregar</button>
    <table class="table table-striped table-bordered table-hover dataTables-example3 tbl-contenido" id="dataTable">
      <thead>
        <tr>
          <th>Nombre Estudios</th>
          <th>Años Cursados</th>
          <th>Fecha Inicio</th>
          <th>Fecha Terminación</th>
          <th>Institución</th>
          <th>Título Obtenido</th>
          <th>Estado</th>
          <th>Borrar</th>
        </tr>
      </thea  d>
      <tbody>
        <tr class="tr-contenido">
          <td><input name="nombre_estudios[]" class="form-control col-md-3" maxlength="50"></td>
          <td><input name="anos_cursados_estudios[]" class="form-control col-md-3 " type="number" min="0" maxlength="2"></td>
          <td><input id="fecha_inicio_estudios" name="fecha_inicio_estudios[]" class="form-control col-md-3 data-picker-only fecha_inicio"></td>
          <td><input id="fecha_terminacion_estudios" name="fecha_terminacion_estudios[]" class="form-control fecha_terminacion_estudios fecha_fin col-md-3 data-picker-only obl"></td>
          <td><input name="institucion_estudios[]" class="form-control col-md-3 "></td>
          <td><input name="titulo_obtenido_estudios[]" class="form-control col-md-3 " maxlength="50"></td>
          <td>
            <select id="finalizado" name="finalizado_estudios[]" class="form-control col-md-3 estudio_finalizado">
              <option value="3">Finalizado</option>            
              <option value="1">Cursando</option>
              <option value="2">Suspendido</option>
            </select>
          </td>
          <td>
            <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>                    
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="x_title">
  <h2>Días de estudio</h2>
  <div class="clearfix"></div>
</div>
<table class="table" id="tbl_info_dias_estudio">
  <thead>
    <tr>
      <th>Lunes</th>
      <th>Martes</th>
      <th>Miércoles</th>
      <th>Jueves</th>
      <th>Viernes</th>
      <th>Sábado</th>
      <th>Domingo</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="checkbox" class="check" name="estudio_lunes_empleado" value="0"></td>
      <td><input type="checkbox" class="check" name="estudio_martes_empleado" value="0"></td>
      <td><input type="checkbox" class="check" name="estudio_miercoles_empleado" value="0"></td>
      <td><input type="checkbox" class="check" name="estudio_jueves_empleado" value="0"></td>
      <td><input type="checkbox" class="check" name="estudio_viernes_empleado" value="0"></td>
      <td><input type="checkbox" class="check" name="estudio_sabado_empleado" value="0"></td>
      <td><input type="checkbox" class="check" name="estudio_domingo_empleado" value="0"></td>
    </tr>
  </tbody>
</table>
<div class="center">
    <button type="button" class="btn btn-primary btn-recorrido" data-id-div="tabs-3" data-anterior="1" next="ui-id-2" data-href="tabs-2"><i class="fa fa-angle-left" aria-hidden="true"></i> Anterior</button>
    <button type="button" class="btn btn-success btn-recorrido" data-id-div="tabs-3" data-href="tabs-4" next="ui-id-4">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
</div>
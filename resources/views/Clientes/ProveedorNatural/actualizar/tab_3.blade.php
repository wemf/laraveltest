<h4>Información Académica:</h4>
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
      </thead>
      <tbody>
        @foreach($estudios AS $estudio)
          <tr class="tr-contenido">
              <td><input name="nombre_estudios[]" class="form-control col-md-3" maxlength="50" ></td>
              <td><input name="anos_cursados_estudios[]" class="form-control col-md-3" type="number" min="0" maxlength="2" ></td>
              <td><input id="fecha_inicio_estudios" name="fecha_inicio_estudios[]" class="form-control col-md-3 data-picker-only"></td>
              <td><input id="fecha_terminacion_estudios" name="fecha_terminacion_estudios[]" class="form-control col-md-3 data-picker-only"></td>
              <td><input name="institucion_estudios[]" class="form-control col-md-3"></td>
              <td><input name="titulo_obtenido_estudios[]" class="form-control col-md-3" maxlength="50" ></td>
              <td>
                <select id="finalizado" name="finalizado_estudios[]" class="form-control col-md-3">
                  <option value="">--Seleccione una opción</option>
                  <option value="1">Cursando</option>
                  <option value="2">Suspendido</option>
                  <option value="3">Finalizado</option>
                </select>
              </td>
              <td>
                <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>                    
              </td>
          </tr>
        @endforeach
        @if(!isset($estudios[0]))
          <tr class="tr-contenido">
              <td><input name="nombre_estudios[]" class="form-control col-md-3"></td>
              <td><input name="anos_cursados_estudios[]" class="form-control col-md-3" type="number" min="0" maxlength="2"></td>
              <td><input id="fecha_inicio_estudios" name="fecha_inicio_estudios[]" class="form-control col-md-3 data-picker-only"></td>
              <td><input id="fecha_terminacion_estudios" name="fecha_terminacion_estudios[]" class="form-control fecha_terminacion_estudios col-md-3 data-picker-only obl"></td>
              <td><input name="institucion_estudios[]" class="form-control col-md-3"></td>
              <td><input name="titulo_obtenido_estudios[]" class="form-control col-md-3"></td>
              <td>
                <select id="finalizado" name="finalizado_estudios[]" class="form-control col-md-3 estudio_finalizado">
                <option value="">--Seleccione una opción</option>
                <option value="1">Cursando</option>
                <option value="2">Suspendido</option>
                <option value="3">Finalizado</option>
                </select>
              </td>
              <td>
                <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>                    
              </td>
          </tr>
          @endif
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
      <td>
        @if($attribute->estudio_lunes == 1)
          <input class="check" type="checkbox" checked="checked" name="estudio_lunes_persona" value="1"></td>
        @else 
          <input class="check" type="checkbox" name="estudio_lunes_persona" value="0"></td>
        @endif
      </td>
      <td>
        @if($attribute->estudio_martes == 1)
          <input class="check" type="checkbox" checked="checked" name="estudio_martes_persona" value="1"></td>
        @else 
          <input class="check" type="checkbox" name="estudio_martes_persona" value="0"></td>
        @endif
      <td> 
        @if($attribute->estudio_miercoles == 1)
          <input class="check" type="checkbox" checked="checked" name="estudio_miercoles_persona" value="1"></td>
        @else 
          <input class="check" type="checkbox" name="estudio_miercoles_persona" value="0"></td>
        @endif
      </td>
      <td> 
        @if($attribute->estudio_jueves == 1)
          <input class="check" type="checkbox" checked="checked" name="estudio_jueves_persona" value="1"></td>
        @else 
          <input class="check" type="checkbox" name="estudio_jueves_persona" value="0"></td>
        @endif
      </td>
      <td> 
        @if($attribute->estudio_viernes == 1)
          <input class="check" type="checkbox" checked="checked" name="estudio_viernes_persona" value="1"></td>
        @else 
          <input class="check" type="checkbox" name="estudio_viernes_persona" value="0"></td>
        @endif
      </td>
      <td> 
        @if($attribute->estudio_sabado == 1)
          <input class="check" type="checkbox" checked="checked" name="estudio_sabado_persona" value="1"></td>
        @else 
          <input class="check" type="checkbox" name="estudio_sabado_persona" value="0"></td>
        @endif
      </td>
      <td> 
        @if($attribute->estudio_domingo == 1)
          <input class="check" type="checkbox" checked="checked" name="estudio_domingo_persona" value="1"></td>
        @else 
          <input class="check" type="checkbox" name="estudio_domingo_persona" value="0"></td>
        @endif
      </td> 
    </tr>
  </tbody>
</table>
<div class="x_title"><div class="clearfix"></div></div>
<div class="center">
    <button type="button" class="btn btn-primary btn-recorrido" data-id-div="tabs-3" data-anterior="1" data-href="tabs-2" next="ui-id-2"><i class="fa fa-angle-left" aria-hidden="true"></i> Anterior</button>
    <button type="button" class="btn btn-success btn-recorrido" data-id-div="tabs-3" data-href="tabs-4" next="ui-id-4">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
</div>



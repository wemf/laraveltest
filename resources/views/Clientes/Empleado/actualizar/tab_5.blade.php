<h4>Información Laboral</h4>
<div class="panel panel-primary" style="overflow: scroll;">
  <div class="panel-heading">Describa sus dos últimas experiencia laborales</div>
  <div class="panel-body">
   {{-- <button type="button" class="btn btn-info btn-agregar-fila">Agregar</button>--}}
    <table class="table table-striped table-bordered table-hover dataTables-example3 tbl-contenido" id="dataTable">
      <thead>
        <tr>
          <th>Empresa</th>
          <th>Cargo</th>
          <th>Nombre Jefe Inmediato</th>
          <th>Fecha Ingreso</th>
          <th>Fecha Retiro</th>
          <th>Personas a Cargo</th>
          <th>Último Salario Devengado</th>
          <th>Horario de Trabajo</th>
          <th>Tipo de Contrato</th>
        </tr>
      </thead>
      <tbody>
      @foreach($hist_laboral AS $h_laboral)
        <tr class="tr-contenido">
          <td><input name="empresa_hist_laboral[]" class="form-control col-md-3" maxlength="50" value="{{$h_laboral->empresa}}"></td>
          <td><input name="cargo_hist_laboral[]" class="form-control col-md-3" type="" maxlength="50" value="{{$h_laboral->cargo}}"></td>
          <td><input name="nombre_jefe_hist_laboral[]" class="form-control col-md-3" value="{{$h_laboral->nombre_jefe_inmediato}}"></td>
          <td><input name="fecha_ingreso_hist_laboral[]" class="form-control col-md-3 data-picker-only fecha_inicio" value="{{dateFormate::ToFormatInverse($h_laboral->fecha_ingreso)}}"></td>
          <td><input name="fecha_retiro_hist_laboral[]" class="form-control col-md-3 data-picker-only fecha_fin" value="{{dateFormate::ToFormatInverse($h_laboral->fecha_retiro)}}"></td>
          <td><input type="number" name="personas_a_cargo_hist_laboral[]" class="form-control col-md-3" maxlength="5" value="{{$h_laboral->cantidad_personas_a_cargo}}"></td>
          <td><input type="number" name="ultimo_salario_hist_laboral[]" class="form-control col-md-3" maxlength="10" value="{{$h_laboral->ultimo_salario}}"></td>
          <td><input name="horario_trabajo_hist_laboral[]" class="form-control col-md-3" maxlength="12" value="{{$h_laboral->horario_trabajo}}"></td>
          <td><select name="tipo_contrato_hist_laboral[]" class="form-control col-md-3 id_contrato">
                <option value="">- Seleccione una opción -</option>
                @foreach($tipo_contrato as $tipo)
                <option value="{{ $tipo->id }}"  @if($h_laboral->id_tipo_contrato == $tipo->id)selected="selected" @endif >{{ $tipo->name }}                   
                </option>
                @endforeach 
              </select>
          </td>
          <td>
            <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>                    
          </td>
        </tr>
      @endforeach 
      </tbody>
    </table>
  </div>
</div>
<div class="x_title">
  <div class="clearfix"></div>
</div>
<div class="center">
  <button type="button" class="btn btn-primary btn-recorrido" data-id-div="tabs-5" data-anterior="1" data-href="tabs-4" next="ui-id-4"><i class="fa fa-angle-left" aria-hidden="true"></i> Anterior</button>
  <button type="button" class="btn btn-success btn-recorrido" data-id-div="tabs-5" data-href="tabs-6" next="ui-id-6">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
</div>
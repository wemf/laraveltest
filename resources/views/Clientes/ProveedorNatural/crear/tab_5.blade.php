<h4>Sucursales</h4>
  <div class="panel panel-primary">
  <div class="panel-heading">Ingrese las sucursales de este Proveedor.</div>
  <div class="panel-body">
    <button type="button" class="btn btn-info btn-agregar-fila">Agregar</button>
    <table class="table table-striped table-bordered table-hover dataTables-example3 tbl-contenido" id="dataTable">
      <thead>
        <tr>
          <th>Nombre Sucursal</th>
          <th>Ciudad</th>
          <th>Teléfono</th>
          <th>Representante</th>
          <th>Borrar</th>
        </tr>
      </thead>
      <tbody>
        <tr class="tr-contenido">
          <td><input name="nombre_sucursal[]" class="form-control col-md-3" maxlength="50"></td>
          <td>
            <select name="ciudad_sucursal[]" class="form-control col-md-2 id_ciudad">
            <option value="">- Seleccione una opción -</option>
            @foreach($ciudad as $tipo)
            <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
            @endforeach     
            </select>
            </td>
          <td><input type="text" maxlength="11" name="telefono_sucursal[]" class="form-control col-md-3 justNumbers"></td>
          <td><input name="nombre_representante_sucursal[]" class="form-control col-md-3"></td>
          <td>
            <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>                    
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="form-group">
  <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
    <button type="button" class="btn btn-primary btn-recorrido" data-id-div="tabs-5" data-anterior="1" next="ui-id-4" data-href="tabs-4"><i class="fa fa-angle-left" aria-hidden="true"></i> Anterior</button>
    <button type="submit" class="btn btn-success">Guardar</button>
    <button class="btn btn-primary" type="reset">Restablecer</button>
  </div>
</div>
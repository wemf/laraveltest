
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
      @foreach($sucursal_clientes AS $sucursal)
        <tr class="tr-contenido">
          <td>
            <input type="hidden" name="id_tienda_sucursal[]" class="hd_id_tienda_sucursal" value= "{{ $sucursal->id_tienda_sucursal }}">
            <input type="hidden" name="id_sucursal[]" class="hd_id_sucursal" value= "{{ $sucursal->id_sucursal }}" >
            <input name="nombre_sucursal[]" class="form-control col-md-3" maxlength="50" value= "{{ $sucursal->sucursal }}">    
         </td>
          <td>
            <select name="ciudad_sucursal[]" class="form-control col-md-2 id_ciudad" value= "{{ $sucursal->id_ciudad }}">
            <option value="">- Seleccione una opción -</option>
            @foreach($ciudad as $tipo)
            <option @if($sucursal->id_ciudad == $tipo->id) selected @endif value="{{ $tipo->id }}">{{ $tipo->name }}</option>
            @endforeach     
            </select>
            </td>
          <td><input type="text" maxlength="11" name="telefono_sucursal[]" class="form-control col-md-3 justNumbers" value= "{{ $sucursal->telefono }}"></td>
          <td><input name="nombre_representante_sucursal[]" class="form-control col-md-3" value= "{{ $sucursal->representante }}"></td>
          <td>
            <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>                    
          </td>
        </tr>
        @endforeach
        @if(!isset($sucursal_clientes[0]))
        <tr class="tr-contenido">
          <td>
            <input type="hidden" name="id_tienda_sucursal[]" class="hd_id_tienda_sucursal" >
            <input type="hidden" name="id_sucursal[]" class="hd_id_sucursal" >
            <input name="nombre_sucursal[]" class="form-control col-md-3" maxlength="50">    
         </td>
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
        @endif
      </tbody>
    </table>
  </div>
</div>

<div class="x_title"><div class="clearfix"></div></div>
<div class="center">
  <button type="button" class="btn btn-primary btn-recorrido" data-id-div="tabs-5" data-anterior="1" data-href="tabs-4" next="ui-id-4"><i class="fa fa-angle-left" aria-hidden="true"></i> Anterior</button>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12">¿Tiene familiares que laboren en la empresa?
  </label>
  <div class="col-md-6 col-sm-6 col-xs-12 requieredcheck">
    <input type="radio" name="familiares_en_nutibara" value="1">Sí
    <input type="radio" name="familiares_en_nutibara" value="0">No
  </div>
</div>
<div class="panel panel-primary" id="panel-familiares-nutibara" style="opacity:0.4; overflow: scroll;">
  <div class="panel-heading">Familiares en Nutibara</div>
  <div class="panel-body">
    <h3>Buscar por:</h3>
    <div class="row">
      <div class="form-group col-md-1">
        <label type="text" class="">Indicativo</label>
        <input type="text" id="indicativo_telefono_pariente_nutibara" class="form-control" value="+57">
      </div>
      <div class="form-group col-md-2">
        <label type="text" class="">Teléfono</label>
        <input type="text" id="telefono_pariente_nutibara" class="form-control">
      </div>
      <div class="form-group col-md-3">
        <label type="text" class="">Tipo Documento</label>
        <select id="tipo_documento_pariente_nutibara" class="form-control tipo_documento">
					<option value="">- Seleccione una opción -</option>
					@foreach($tipo_documento as $tipo)
						<option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
					@endforeach  
				</select>
      </div>
      <div class="form-group col-md-3">
        <label type="text" class="">Número Documento</label>
        <input type="text" id="numero_documento_pariente_nutibara" class="form-control">
      </div>
      <div class="form-group col-md-2">
        <h1 type="text" class=""> </h1>
        <button type="button" id="btn_pariente_nutibara" class="btn btn-success form-control">Buscar</button>
      </div>
    </div>
    <br>
    <button type="button" class="btn btn-info btn-agregar-fila">Agregar</button>
    <table class="table table-striped table-bordered table-hover dataTables-example3 tbl-contenido" id="dataTable" >
      <thead>
        <tr>
          <th>Tipo de Documento</th>
          <th>Número de Documento</th>
          <th>Nombres</th>
          <th>Fecha de Nacimiento</th>
          <th>Parentesco</th>
          <th>Cargo Actual</th>
          <th>Ciudad donde labora</th>
          <th>Borrar</th>
        </tr>
      </thead>
      <tbody>
         @foreach($familiar_nutibara AS $familiar_nuti)
          <tr class="tr-contenido">
            <td>
              <input type="hidden" name="id_tienda_pariente[]" class="hd_id_tienda_pariente" disabled>
              <input type="hidden" name="codigo_cliente_pariente[]" class="hd_codigo_cliente_pariente" disabled>
              <select name="id_tipo_documento_parientes[]" class="form-control col-md-7 col-xs-12  tipo_documento">
                <option value="">- Seleccione una opción -</option>
                @foreach($tipo_documento as $tipo)
                  <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach  
              </select>
            </td>
            <td><input name="identificacion_parientes[]" maxlength="12" class="form-control col-md-3" ></td>
            <td class="td-contenido">
              @if(Request::old('nombre_parientes[]'))
                <input type="text" id="nombre_parientes" name="nombre_parientes[]" class="form-control col-md-7 col-xs-12" disabled min="0" value="{{Request::old('nombre_parientes')}}">
              @else
                <input type="text" id="nombre_parientes" name="nombre_parientes[]" class="form-control col-md-7 col-xs-12" disabled min="0">
              @endif  
            </td>
            <td>
              <input type="text" name="fecha_nacimiento_parientes[]" class="form-control col-md-7 col-xs-12 data-picker-only" value="{{Request::old('fecha_nacimiento_parientes')}}"> 
            </td>
            <td>
              <select id="id_tipo_parentesco" name="id_tipo_parentesco[]" class="id_tipo_parentesco form-control col-md-7 col-xs-12" disabled>
                <option value="">- Seleccione una opción -</option>
                @foreach($tipo_parentesco as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach 
              </select>
            </td>
            <td>
              <select id="id_cargo_pariente" name="id_cargo_pariente[]" class="form-control col-md-7 col-xs-12 id_cargo_empleado" disabled>
                <option value="">- Seleccione una opción -</option>
                @foreach($cargo_empleado as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach 
              </select>
            </td>
            <td>
              <select id="id_cargo_pariente" name="ciudad_pariente[]" class="form-control col-md-7 col-xs-12 id_ciudad" disabled>
                <option value="">- Seleccione una opción -</option>
                @foreach($ciudad as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach 
              </select>
            </td>
            <td>
              <button type="button" class="borrar-fila" disabled><i class="fa fa-trash-o fa-2x colorRed"></i></button>                    
            </td>
          </tr>
        @endforeach
        @if(!isset($familiar_nutibara[0]))
        <tr class="tr-contenido">
            <td>
              <input type="hidden" name="id_tienda_pariente[]" class="hd_id_tienda_pariente" disabled>
              <input type="hidden" name="codigo_cliente_pariente[]" class="hd_codigo_cliente_pariente" disabled>
              <select name="id_tipo_documento_parientes[]" class="form-control col-md-7 col-xs-12  tipo_documento">
                <option value="">- Seleccione una opción -</option>
                @foreach($tipo_documento as $tipo)
                  <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach  
              </select>
            </td>
            <td><input name="identificacion_parientes[]" maxlength="12" class="form-control col-md-3" ></td>
            <td class="td-contenido">
              @if(Request::old('nombre_parientes[]'))
                <input type="text" id="nombre_parientes" name="nombre_parientes[]" class="form-control col-md-7 col-xs-12" disabled min="0" value="{{Request::old('nombre_parientes')}}">
              @else
                <input type="text" id="nombre_parientes" name="nombre_parientes[]" class="form-control col-md-7 col-xs-12" disabled min="0">
              @endif  
            </td>
            <td>
              <input type="text" name="fecha_nacimiento_parientes[]" class="form-control col-md-7 col-xs-12 data-picker-only" value="{{Request::old('fecha_nacimiento_parientes')}}"> 
            </td>
            <td>
              <select id="id_tipo_parentesco" name="id_tipo_parentesco[]" class="id_tipo_parentesco form-control col-md-7 col-xs-12" disabled>
                <option value="">- Seleccione una opción -</option>
                @foreach($tipo_parentesco as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach 
              </select>
            </td>
            <td>
              <select id="id_cargo_pariente" name="id_cargo_pariente[]" class="form-control col-md-7 col-xs-12 id_cargo_empleado" disabled>
                <option value="">- Seleccione una opción -</option>
                @foreach($cargo_empleado as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach 
              </select>
            </td>
            <td>
              <select id="id_cargo_pariente" name="ciudad_pariente[]" class="form-control col-md-7 col-xs-12 id_ciudad" disabled>
                <option value="">- Seleccione una opción -</option>
                @foreach($ciudad as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach 
              </select>
            </td>
            <td>
              <button type="button" class="borrar-fila" disabled><i class="fa fa-trash-o fa-2x colorRed"></i></button>                    
            </td>
          </tr>
        @endif
          <!-- Otra columna -->
      </tbody>
    </table>
  </div>
</div>
<div class="x_title">
  <h2></h2>
  <div class="clearfix"></div>
</div>
<h4>Información Grupo Familiar</h4>
<br>
<div class="panel panel-primary" style="overflow: scroll;">
  <div class="panel-heading" style="width: 2515px;">Suministrar Nombre, Apellidos completos de las personas que conforman actualmente su núcleo familiar. De igual manera marcar cuales de las personas será benceficias para la caja de compensación y EPS</div>
  <div class="panel-body">
    <button type="button" class="btn btn-info btn-agregar-fila">Agregar</button>
    <table class="table table-striped table-bordered table-hover dataTables-example3 tbl-contenido" id="dataTable" style="overflow: scroll;width: 2500px;">
        <thead>
            <tr>
              <th>Tipo de Documento</th>
              <th>Número de Documento</th>
              <th>Nombre Completo</th>
              <th>Parentesco</th>
              <th>Fecha de Nacimiento</th>
              <th>Género</th>
              <th>Beneficiario(Eps)</th>
              <th>Ocupación Actual</th>
              <th>Grado de Escolaridad</th>
              <th>Estudio Actual</th>
              <th>Año o semestre que cursa</th> 
              <th>¿A cargo de esta persona?</th>
              <th>¿Vive con esta persona?</th>
              <th>Borrar</th>            
            </tr>
        </thead>
        <tbody>
            @foreach($familiar AS $family)
              <tr class="tr-contenido">
                  <td>
                    <input type="hidden" name="id_tienda_familiares[]" class="hd_id_tienda_pariente" >
                    <input type="hidden" name="codigo_cliente_familiares[]" class="hd_codigo_cliente_pariente" >
                    <select name="id_tipo_documento_familiares[]" class="form-control col-md-7 col-xs-12 tipo_documento">
                      <option value="">- Seleccione una opción -</option>
                      @foreach($tipo_documento as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                      @endforeach  
                    </select>
                  </td>
                  <td><input name="identificacion_familiares[]" maxlength="12" class="form-control col-md-3" ></td>
                  <td><input name="nombres_completos_familiares[]" class="form-control col-md-3"></td>
                  <td style="width: 155px;">
                    <select name="id_parentesco_familiares[]" class="form-control col-md-3 id_tipo_parentesco">
                        <option value="">- Seleccione una opción -</option>
                        @foreach($tipo_parentesco as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                        @endforeach  
                    </select>
                  </td>
                  <td><input id="fecha_nacimiento_familiares" name="fecha_nacimiento_familiares[]" class="form-control col-md-3 data-picker-only"></td>
                  <td style="width: 135px;">
                    <select id="id_genero_familiares" name="id_genero_familiares[]" class="form-control col-md-2">
                      <option value="">--Seleccione una opción--</option>
                      <option value="1">Masculino</option>
                      <option value="2">Femenino</option> 
                    <select>
                  </td>
                  <td>
                    <input type="checkbox" name="beneficiario[]" class="col-md-2 check check-beneficiario" onClick ='checkNext(this)' >
                    <input type="hidden" name="hd_beneficiario[]" class="col-md-2 check" value="0">
                  </td>
                  <td>
                    <select name="ocupacion_familiares[]" class="form-control col-md-3">
                        <option value="">- Seleccione una opción -</option>
                      @foreach($ocupaciones as $ocupacion)
                        <option value="{{ $ocupacion->id }}">{{ $ocupacion->name }}</option>
                      @endforeach  
                    </select>
                  </td>
                  <td style="width: 151px;">
                    <input type="text" id="grado_escolaridad_familiares" name="grado_escolaridad_familiares[]" class="form-control col-md-3 id_nivel_estudio " value="{{ $family["grado_escolaridad"] }}">
                  </td>
                  <td style="width: 135px;">
                    <select id="id_nivel_estudio_familiares" name="id_nivel_estudio_familiares[]" class="form-control col-md-3 id_nivel_estudio">
                        <option value="">- Seleccione una opción -</option>
                        @foreach($nivel_estudio as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                        @endforeach  
                    </select>
                  </td>
                  <td><input type="text"min="0" name="semestre_familiares[]" maxlength="6" class="form-control col-md-2"></td>
                  <td>
                    <input type="checkbox" name="a_cargo_persona_familiares[]" class="col-md-2 check check-a-cargo-familia" onClick='checkNext(this)'>
                    <input type="hidden" name="hd_a_cargo_persona_familiares[]" class="col-md-2 check" value="0">
                  </td>
                  <td>
                    <input type="checkbox" name="vive_con_persona_familiares[]" class="col-md-2 check check-vive-con-familia" onClick='checkNext(this)'>
                    <input type="hidden" name="hd_vive_con_persona_familiares[]" class="col-md-2 check" value="0">
                  </td>
                  <td>
                      <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed "></i></button>                    
                  </td>
              </tr>
            @endforeach
            @if(!isset($familiar[0]))
            <tr class="tr-contenido">
                <td>
                  <input type="hidden" name="id_tienda_familiares[]" class="hd_id_tienda_pariente" >
                  <input type="hidden" name="codigo_cliente_familiares[]" class="hd_codigo_cliente_pariente" >
                  <select name="id_tipo_documento_familiares[]" class="form-control col-md-7 col-xs-12 tipo_documento">
                    <option value="">- Seleccione una opción -</option>
                    @foreach($tipo_documento as $tipo)
                      <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                    @endforeach  
                  </select>
                </td>
                <td><input name="identificacion_familiares[]" maxlength="12" class="form-control col-md-3" ></td>
                <td><input name="nombres_completos_familiares[]" class="form-control col-md-3"></td>
                <td style="width: 155px;">
                  <select name="id_parentesco_familiares[]" class="form-control col-md-3 id_tipo_parentesco">
                      <option value="">- Seleccione una opción -</option>
                      @foreach($tipo_parentesco as $tipo)
                      <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                      @endforeach  
                  </select>
                </td>
                <td><input id="fecha_nacimiento_familiares" name="fecha_nacimiento_familiares[]" class="form-control col-md-3 data-picker-only"></td>
                <td style="width: 135px;">
                  <select id="id_genero_familiares" name="id_genero_familiares[]" class="form-control col-md-2">
                    <option value="">--Seleccione una opción--</option>
                    <option value="1">Masculino</option>
                    <option value="2">Femenino</option> 
                  <select>
                </td>
                <td>
                  <input type="checkbox" name="beneficiario[]" class="col-md-2 check check-beneficiario" onClick ='checkNext(this)' >
                  <input type="hidden" name="hd_beneficiario[]" class="col-md-2 check" value="0">
                </td>
                <td>
                  <select name="ocupacion_familiares[]" class="form-control col-md-3">
                      <option value="">- Seleccione una opción -</option>
                    @foreach($ocupaciones as $ocupacion)
                      <option value="{{ $ocupacion->id }}">{{ $ocupacion->name }}</option>
                    @endforeach  
                  </select>
                </td>
                <td style="width: 151px;">
                  <select id="grado_escolaridad_familiares" name="grado_escolaridad_familiares[]" class="form-control col-md-3 id_nivel_estudio ">
                      <option value="">- Seleccione una opción -</option>
                      @foreach($nivel_estudio as $tipo)
                      <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                      @endforeach  
                  </select>
                </td>
                <td style="width: 135px;">
                  <select id="id_nivel_estudio_familiares" name="id_nivel_estudio_familiares[]" class="form-control col-md-3 id_nivel_estudio ">
                      <option value="">- Seleccione una opción -</option>
                      @foreach($nivel_estudio as $tipo)
                      <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                      @endforeach  
                  </select>
                </td>
                <td><input type="number" min="0" name="semestre_familiares[]" maxlength="6" class="form-control col-md-2"></td>
                <td>
                  <input type="checkbox" name="a_cargo_persona_familiares[]" class="col-md-2 check check-a-cargo-familia" onClick='checkNext(this)'>
                  <input type="hidden" name="hd_a_cargo_persona_familiares[]" class="col-md-2 check" value="0">
                </td>
                <td>
                  <input type="checkbox" name="vive_con_persona_familiares[]" class="col-md-2 check check-vive-con-familia" onClick='checkNext(this)'>
                  <input type="hidden" name="hd_vive_con_persona_familiares[]" class="col-md-2 check" value="0">
                </td>
                <td>
                    <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed "></i></button>                    
                </td>
            </tr>
            @endif
            <!-- Aqui deberia de ir la otra columna de el HTML poner si fall.a -->
        </tbody>
      </table>
    </div>
  </div> 
<br>
<div class="panel panel-primary"  style="overflow: scroll;">
  <div class="panel-heading" style="width: 2515px;">En caso de emergencia, sumistre los datos de dos personas a las que pueda contactar</div>
  <div class="panel-body">
    <button type="button" class="btn btn-info btn-agregar-fila">Agregar</button>
    <table class="table table-striped table-bordered table-hover dataTables-example3 tbl-contenido" style="overflow: scroll;width: 2500px;" id="dataTable">
      <thead>
        <tr class="">
          <th>Tipo de Documento</th>
          <th>Número de Documento</th>
          <th>Nombres</th>
          <th>Primer Apellido</th>
          <th>Segundo Apellido</th>
          <th>Parentesco</th>
          <th>Dirección</th>
          <th>Ciudad</th>
          <th>Teléfono</th>
          <th>Borrar</th>
        </tr>
      </thead>
      <tbody>
        @foreach($contacto_emergencia AS $emergency)      
          <tr class="tr-contenido">
            <td>
              <input type="hidden" name="id_tienda_emergencia[]" class="hd_id_tienda_pariente" >
              <input type="hidden" name="codigo_cliente_emergencia[]" class="hd_codigo_cliente_pariente" >
              <select name="id_tipo_documento_emergencia[]" class="form-control col-md-7 col-xs-12 tipo_documento requiered">
                <option value="">- Seleccione una opción -</option>
                @foreach($tipo_documento as $tipo)
                  <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach  
              </select>
            </td>
            <td><input name="identificacion_emergencia[]" maxlength="12" class="form-control col-md-3 requiered"></td>
            <td><input type="text" name="nombre_emergencia[]" class="form-control col-md-2 requiered"></td>
            <td><input type="text" name="primer_apellido_emergencia[]" class="form-control col-md-2 requiered"></td>
            <td><input type="text" name="segundo_apellido_emergencia[]" class="form-control col-md-2"></td>
            <td>
              <select name="parentesco_emergencia[]" class="form-control col-md-3 id_tipo_parentesco">
                <option value="">- Seleccione una opción -</option>
                @foreach($tipo_parentesco as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach 
              </select>
            </td>
            <td><input type="text" name="direccion_emergencia[]" id="direccion_emergencia" class="form-control col-md-2 direccion"></td>
            <td>
              <select name="ciudad_emergencia[]" class="form-control col-md-2 id_ciudad">
                <option value="">- Seleccione una opción -</option>
                @foreach($ciudad as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach     
              </select>
            </td>
            <td><input type="number" min="0" name="telefono_emergencia[]" maxlength="12"  class="form-control col-md-2 requiered"></td>
            <td>
              <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>                    
            </td>
          </tr>
        @endforeach
        @if(!isset($contacto_emergencia[0]))
          <tr class="tr-contenido">
            <td>
              <input type="hidden" name="id_tienda_emergencia[]" class="hd_id_tienda_pariente" >
              <input type="hidden" name="codigo_cliente_emergencia[]" class="hd_codigo_cliente_pariente" >
              <select name="id_tipo_documento_emergencia[]" class="form-control col-md-7 col-xs-12 tipo_documento">
                <option value="">- Seleccione una opción -</option>
                @foreach($tipo_documento as $tipo)
                  <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach  
              </select>
            </td>
            <td><input name="identificacion_emergencia[]" maxlength="12" class="form-control col-md-3" ></td>
            <td><input type="text" name="nombre_emergencia[]" class="form-control col-md-2"></td>
            <td><input type="text" name="primer_apellido_emergencia[]" class="form-control col-md-2 requiered"></td>
            <td><input type="text" name="segundo_apellido_emergencia[]" class="form-control col-md-2"></td>
            <td>
              <select name="parentesco_emergencia[]" class="form-control col-md-3 id_tipo_parentesco">
                <option value="">- Seleccione una opción -</option>
                @foreach($tipo_parentesco as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach 
              </select>
            </td>
            <td><input type="text" name="direccion_emergencia[]" id="direccion_emergencia" class="form-control col-md-2 direccion"></td>
            <td>
              <select name="ciudad_emergencia[]" class="form-control col-md-2 id_ciudad">
                <option value="">- Seleccione una opción -</option>
                @foreach($ciudad as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                @endforeach     
              </select>
            </td>
            <td><input type="number" min="0" name="telefono_emergencia[]" maxlength="12"  class="form-control col-md-2"></td>
            <td>
              <button type="button" class="borrar-fila"><i class="fa fa-trash-o fa-2x colorRed"></i></button>                    
            </td>
          </tr>
        @endif
        <!-- Otra columna. -->
      </tbody>
    </table>
  </div>
</div>
<div class="x_title">
<div class="clearfix"></div>
</div>
<div class="center">
  <button type="button" class="btn btn-primary btn-recorrido" data-id-div="tabs-3" data-anterior="2" data-href="tabs-3" next="ui-id-2"><i class="fa fa-angle-left" aria-hidden="true"></i> Anterior</button>
  <button type="button" class="btn btn-success btn-recorrido" data-id-div="tabs-3" data-href="tabs-4" next="ui-id-4">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
</div>
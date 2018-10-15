@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Empleado</h2>
        <div class="text-right">
          <button type="button" class="btn btn-primary" id="asignacion">Asignación de usuario</button>
        </div>
      </div>
      <div class="modal" id="modalUser">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Creación de nuevo usuario</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">      
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="id_role" class="col-md-4 control-label">Rol</label>
                            <div class="col-md-6">
                                <select type="text" class="form-control" id="id_role" name="id_role"  value="{{ old('id_role') }}" required autofocus>
                                  <option value="">- Seleccione una opción -</option>
                                  @foreach($role as $tipo)
                                  <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                  @endforeach 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Nombres</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" maxlength="100" value="{{$attribute->nombres}} {{$attribute->primer_apellido}} {{$attribute->segundo_apellido}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{$attribute->correo_electronico}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="modo_ingreso" class="col-md-4 control-label">Modo de ingreso</label>

                            <div class="col-md-6">
                              <select id="modo_ingreso" name="modo_ingreso" class="form-control" required="required">
                                    <option value="">- Seleccione una opción -</option>
                                    <option value="0">Lector biométrico</option>
                                    <option value="1">Numero de identificación</option>
                                </select>  
                            </div>
                        </div>
                    </form>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="idUsuario">
              <button type="submit" class="btn btn-success" id="guardarUser">Guardar</button>
              <button type="submit" class="btn btn-success" id="actualizarUser">Guardar</button>
              <!-- <button class="btn btn-primary" type="reset">Restablecer</button> -->
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="javascript:void(0)" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')  
          <div id="tabs">
            <ul class="tabs-nav">
              <li class="tabs-1"><a href="#tabs-1">Datos Generales</a></li>
              <li class="tabs-2"><a href="#tabs-2">Información Contractual</a></li>
              <li class="tabs-3"><a href="#tabs-3">Datos Familiares</a></li>
              <li class="tabs-4"><a href="#tabs-4">Información Académica</a></li>
              <li class="tabs-5"><a href="#tabs-5">Información Laboral</a></li>
              <li class="tabs-6"><a href="#tabs-6">Novedad de Empleado</a></li>
            </ul>
            <div id="tabs-1" class="contenido-tab">
              @include('Clientes/Empleado/actualizar/tab_1')  
            </div>
            <div id="tabs-2" class="contenido-tab">
              @include('Clientes/Empleado/actualizar/tab_2')  
            </div>
            <div id="tabs-3" class="contenido-tab">
              @include('Clientes/Empleado/actualizar/tab_3')  
            </div>
            <div id="tabs-4" class="contenido-tab">  
              @include('Clientes/Empleado/actualizar/tab_4')  
            </div>
            <div id="tabs-5" class="contenido-tab">
              @include('Clientes/Empleado/actualizar/tab_5')  
            </div>
            <div id="tabs-6" class="contenido-tab">
              @include('Clientes/Empleado/actualizar/tab_6')  
            </div>  
        
      </div>
            <br>
              <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button class="btn btn-primary" type="reset">Restablecer</button>
                    <a href="{{ url('/clientes/empleado') }}" class="btn btn-danger" type="button">Cancelar</a>
                </div>
              </div> 
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/empleado.js')}}"></script>
    <script src="{{asset('/js/clientes/clientes.js')}}"></script>
    <script src="{{asset('/js/clientes/empleados/actualizar/tab_1.js')}}"></script>
@endpush
@section('javascript')   
    //<script>
    URL.setUrlList("{{ url('/clientes/empleado/getSelectList') }}");
    URL.setUrlListById("{{ url('/clientes/empleado/getSelectListById') }}");
    URL.setUrlListFranquicia("{{ url('/franquicia/getSelectList') }}");
    URL.setUrlListSociedadByFranquicia("{{ url('/sociedad/getSelectListFranquiciaSociedad') }}");
    URL.setCompleteEmpleados("{{ url('/clientes/empleado/getAutoComplete') }}");
    URL.setAction("{{ url('/clientes/empleado/update') }}");
    URL.setActionUser("{{ url('/users/registerAjax') }}");
    URL.setAction2("{{ url('/users/updateAjax') }}");
    URL.setEmpleado(" {{ url('/clientes/empleado/getEmpleadoIden') }} ");
    // alert(URL.getActionUser());
    URL.setUser(" {{ url('/clientes/empleado/getUser') }} ");
    URL.setTiendaZona("{{ url('/clientes/empleado/getTiendaZona/') }}");
    URL.setCombos("{{ url('/clientes/empleado/getCombos/') }}");
    URL.setTipoDocumento(" {{ url('/clientes/tipodocumento/getAlfanumerico') }} ");
    URL.setParametroGeneral("{{ url('/clientes/empleado/getparametroGeneral') }}");
    URL_CLIENTE.setURLValidarDocumento("{{ url('/clientes/funciones/getValidarDocumento') }}");
    URL_CLIENTE.getEmpleadoActualizar("{{ url('/clientes/empleado/update') }}");
    URL_CLIENTE.getPersonaNaturalActualizar("{{ url('/clientes/persona/natural/update') }}");
    URL_CLIENTE.getProveedorNaturalActualizar("{{ url('/clientes/proveedor/persona/natural/update') }}");
    URL_CLIENTE.setActualizarThis("{{ url('/clientes/empleado/update') }}");


    /*-- ----------------------------------------------------------- ----
    ---- ----------------------------------------------------------- --*/   
    
    var y = '{{$attribute->telefono_celular}}';
    var x = y.split(" ");

    $('#telefono_celular').val(x[1]);
    $('#telefono_celular_indicativo').val(x[0]);
    if(x[1] == "" || x[1] === undefined) 
    {
      $('#telefono_celular').val(x[0]);
      $('#telefono_celular_indicativo').val("");
    }  
    
    var y1 = '{{$attribute->telefono_residencia}}';
    var x1 = y1.split(" ");

    $('#telefono_residencia').val(x1[1]);
    $('#telefono_residencia_indicativo').val(x1[0]);
    if(x1[1] == "" || x1[1] === undefined) 
    {
      $('#telefono_celular').val(x1[0]);
      $('#telefono_celular_indicativo').val("");
    }  
    
    $('#codigo_cliente').val({{$attribute->codigo_cliente}});
    $('#id_contrato').val({{$attribute->id_tipo_contrato}});
    $('#id_ciudad_trabajo').val({{$attribute->id_ciudad_trabajo}});
    // $('#id_salario').val({{$attribute->salario}});
    // $('#id_valor_auxilio_vivenda').val({{$attribute->valor_auxilio_vivenda}});
    // $('#id_valor_auxilio_transporte').val({{$attribute->valor_auxilio_transporte}});
    $('#id_cargo_empleado').val({{$attribute->id_cargo_empleado}});
    $('#id_tipo_documento').val({{$attribute->id_tipo_documento}});
    $('#id_ciu_exp').val({{$attribute->id_ciudad_expedicion}});
    $('#id_ciu_nacimiento').val({{$attribute->id_ciudad_nacimiento}});
    $('#id_ciu_residencia').val({{$attribute->id_ciudad_residencia}});
    $('#id_estado_civil').val({{$attribute->id_estado_civil}});
    $('#id_tipo_vivienda').val({{$attribute->id_tipo_vivienda}});
    $('#id_tenencia_vivienda').val({{$attribute->id_tenencia_vivienda}});
    $('#id_cargo_ejercido').val({{$attribute->id_cargo_ejercido_anterior}});
    $('#id_fondo_cesantias').val({{$attribute->id_fondo_cesantias}});
    $('#id_fondo_pensiones').val({{$attribute->id_fondo_pensiones}});
    $('#id_eps').val({{$attribute->id_eps}});
    $('#id_caja_compensacion').val({{$attribute->id_caja_compensacion}});
    $('#nivel_estudio').val({{$attribute->id_nivel_estudio}});
    $('#nivel_estudio_actual').val({{$attribute->id_nivel_estudio_actual}});
    $('select[name="id_motivo_retiro"]').val({{$attribute->id_motivo_retiro}});
    $('#talla_camisa').val({{$attribute->talla_camisa}});
    $('#talla_pantalon').val({{$attribute->talla_pantalon}});
    $('#talla_zapatos').val({{$attribute->talla_zapatos}});
    $('#rh').val({{$attribute->rh}});
    $('#genero').val({{$attribute->genero}});
    

    $(document).ready(function()
    {

      /*-- ----------------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN FAMILIARES EN NUTIBARA
      ---- ----------------------------------------------------------- --*/    

      @if(count($familiar_nutibara) > 0)

        $('input[name="familiares_en_nutibara"][value=1]').attr('checked','checked');
        $('#panel-familiares-nutibara #dataTable').find('input,select,textarea').removeClass('requiered').attr('disabled', 'disabled');
        $('#panel-familiares-nutibara').css('opacity','1');
        $('#panel-familiares-nutibara').find('.id_tipo_parentesco').addClass('requiered').removeAttr('disabled');
        $('#panel-familiares-nutibara').find('.borrar-fila,.hd_id_tienda_pariente,.hd_codigo_cliente_pariente').removeAttr('disabled'); 
        
        @for($i=0;$i<count($familiar_nutibara);$i++)
            document.getElementsByName("id_tienda_pariente[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['id_tienda_pariente']}}";  
            document.getElementsByName("codigo_cliente_pariente[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['codigo_cliente_pariente']}}";  
            document.getElementsByName("id_tipo_documento_parientes[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['id_tipo_documento']}}";  
            document.getElementsByName("identificacion_parientes[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['numero_documento']}}";  
            document.getElementsByName("nombre_parientes[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['nombre']}}";  
            document.getElementsByName("fecha_nacimiento_parientes[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['fecha_nacimiento']}}";  
            document.getElementsByName("id_tipo_parentesco[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['id_tipo_parentesco']}}";  
            document.getElementsByName("id_cargo_pariente[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['id_cargo_empleado']}}";  
            document.getElementsByName("ciudad_pariente[]")[{{$i}}].value = "{{$familiar_nutibara[$i]['id_ciudad_residencia']}}";  
        @endfor 

      @else
        $('input[name="familiares_en_nutibara"][value=0]').attr('checked','checked');
        $('#panel-familiares-nutibara').css('opacity','0.5');
        $('#panel-familiares-nutibara #dataTable').find('input,select,textarea').removeClass('requiered').attr('disabled', 'disabled');
      @endif


      /*-- --------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN GRUPO FAMILIAR
      ---- --------------------------------------------------- --*/

      @if(count($familiar) > 0)

        @for($j=0;$j<count($familiar);$j++)
        
            document.getElementsByName("id_tienda_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_tienda']}}";  
            document.getElementsByName("codigo_cliente_familiares[]")[{{$j}}].value = "{{$familiar[$j]['codigo_cliente']}}";  
            document.getElementsByName("id_tipo_documento_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_tipo_documento']}}";  
            document.getElementsByName("identificacion_familiares[]")[{{$j}}].value = "{{$familiar[$j]['numero_documento']}}"; 
            document.getElementsByName("nombres_completos_familiares[]")[{{$j}}].value = "{{$familiar[$j]['nombre']}}";
            document.getElementsByName("id_parentesco_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_tipo_parentesco']}}";  
            document.getElementsByName("fecha_nacimiento_familiares[]")[{{$j}}].value = "{{$familiar[$j]['fecha_nacimiento']}}"; 
            document.getElementsByName("id_genero_familiares[]")[{{$j}}].value = "{{$familiar[$j]['genero']}}"; 
            @if($familiar[$j]['beneficiario'] == 1)
              document.getElementsByName("hd_beneficiario[]")[{{$j}}].value = "1";
              document.getElementsByName("beneficiario[]")[{{$j}}].checked = true;
            @else
              document.getElementsByName("hd_beneficiario[]")[{{$j}}].value = "0";
            @endif
            document.getElementsByName("ocupacion_familiares[]")[{{$j}}].value = "{{$familiar[$j]['ocupacion']}}";    
            document.getElementsByName("grado_escolaridad_familiares[]")[{{$j}}].value = "{{$familiar[$j]['grado_escolaridad']}}"; 
            document.getElementsByName("id_nivel_estudio_familiares[]")[{{$j}}].value = "{{$familiar[$j]['id_nivel_estudio']}}"; 
            document.getElementsByName("semestre_familiares[]")[{{$j}}].value = "{{$familiar[$j]['semestre']}}"; 
            @if($familiar[$j]['a_cargo_persona_familiares'] == 1)
              document.getElementsByName("hd_a_cargo_persona_familiares[]")[{{$j}}].value = "1";
              document.getElementsByName("a_cargo_persona_familiares[]")[{{$j}}].checked = true;
            @endif
            @if($familiar[$j]['vive_con_persona_familiares'] == 1)
              document.getElementsByName("hd_vive_con_persona_familiares[]")[{{$j}}].value = "1";
              document.getElementsByName("vive_con_persona_familiares[]")[{{$j}}].checked = true;
            @endif
            document.getElementsByName("semestre_familiares[]")[{{$j}}].value = "{{$familiar[$j]['vive_con_persona_familiares']}}"; 
        @endfor

      @endif


      /*-- ------------------------------------------------------------------- ----
      ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN CONTACTO EN CASO DE EMERGENCIA
      ---- ------------------------------------------------------------------- --*/

      @if(count($contacto_emergencia) > 0)

        @for($k=0;$k<count($contacto_emergencia);$k++)
            document.getElementsByName("id_tienda_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_tienda']}}";
            document.getElementsByName("codigo_cliente_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['codigo_cliente']}}";
            document.getElementsByName("id_tipo_documento_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_tipo_documento']}}";
            document.getElementsByName("identificacion_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['numero_documento']}}";
            document.getElementsByName("nombre_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['nombre']}}";
            document.getElementsByName("parentesco_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_tipo_parentesco']}}";  
            document.getElementsByName("direccion_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['direccion_residencia']}}";    
            document.getElementsByName("ciudad_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['id_ciudad_residencia']}}"; 
            document.getElementsByName("telefono_emergencia[]")[{{$k}}].value = "{{$contacto_emergencia[$k]['telefono_residencia']}}"; 
        @endfor


        /*-- ----------------------------------------------------------------- ----
        ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN CONTACTO ESTUDIOS REALIZADOS
        ---- ----------------------------------------------------------------- --*/

        @for($l=0;$l<count($estudios);$l++)
            document.getElementsByName("nombre_estudios[]")[{{$l}}].value = "{{$estudios[$l]['nombre_estudio']}}";
            document.getElementsByName("anos_cursados_estudios[]")[{{$l}}].value = "{{$estudios[$l]['anos_cursados_estudio']}}";  
            document.getElementsByName("fecha_inicio_estudios[]")[{{$l}}].value = "{{$estudios[$l]['fecha_inicio_estudio']}}";    
            document.getElementsByName("fecha_terminacion_estudios[]")[{{$l}}].value = "{{$estudios[$l]['fecha_terminacion_estudio']}}"; 
            document.getElementsByName("institucion_estudios[]")[{{$l}}].value = "{{$estudios[$l]['institucion_estudio']}}"; 
            document.getElementsByName("titulo_obtenido_estudios[]")[{{$l}}].value = "{{$estudios[$l]['titulo_obtenido_estudio']}}"; 
            document.getElementsByName("finalizado_estudios[]")[{{$l}}].value = "{{$estudios[$l]['finalizado_estudio']}}"; 
              @if($estudios[$l]['finalizado_estudios'] != 1)
                  document.getElementsByName("fecha_terminacion_estudios[]")[{{$l}}].removeAttribute('disabled');
              @endif
        @endfor


        /*-- ----------------------------------------------------- ----
        ---- SE CARGA INFORMACIÓN PARA LA SECCIÓN HISTORIA LABORAL
        ---- ----------------------------------------------------- --*/

        @for($m=0;$m<count($hist_laboral);$m++)
            document.getElementsByName("empresa_hist_laboral[]")[{{$m}}].value = "{{$hist_laboral[$m]['empresa']}}";
            document.getElementsByName("cargo_hist_laboral[]")[{{$m}}].value = "{{$hist_laboral[$m]['cargo']}};"  
            document.getElementsByName("nombre_jefe_hist_laboral[]")[{{$m}}].value = "{{$hist_laboral[$m]['nombre_jefe_inmediato']}}";    
            document.getElementsByName("fecha_ingreso_hist_laboral[]")[{{$m}}].value = "{{$hist_laboral[$m]['fecha_ingreso']}}"; 
            document.getElementsByName("fecha_retiro_hist_laboral[]")[{{$m}}].value = "{{$hist_laboral[$m]['fecha_retiro']}}"; 
            document.getElementsByName("personas_a_cargo_hist_laboral[]")[{{$m}}].value = "{{$hist_laboral[$m]['cantidad_personas_a_cargo']}}"; 
            document.getElementsByName("ultimo_salario_hist_laboral[]")[{{$m}}].value = "{{$hist_laboral[$m]['ultimo_salario']}}"; 
            document.getElementsByName("horario_trabajo_hist_laboral[]")[{{$m}}].value = "{{$hist_laboral[$m]['horario_trabajo']}}"; 
            document.getElementsByName("tipo_contrato_hist_laboral[]")[{{$m}}].value = "{{$hist_laboral[$m]['id_tipo_contrato']}}"; 
        @endfor

      @endif


        /*-- ---------------------------------------------------------------------- ----
        ---- SE CARGA INFORMACIÓN PARA LAS LISTAS RESTANTES DE LAS OTRAS PESTAÑAS
        ---- -------------------------------------------------------------------- --*/
        $('#id_pais_exp').val({{ $attribute->id_pais_expedicion }}); 
        $('#id_pais_exp').change();
        $('#id_dep_exp').val({{ $attribute->id_departamento_expedicion }}); 
        $('#id_dep_exp').change();
        $('#id_ciu_exp').val({{ $attribute->id_ciudad_expedicion }}); 

        $('#id_pais_nacimiento').val({{ $attribute->id_pais_nacimiento }}); 
        $('#id_pais_nacimiento').change();
        $('#id_dep_nacimiento').val({{ $attribute->id_departamento_nacimiento }}); 
        $('#id_dep_nacimiento').change();
        $('#id_ciu_nacimiento').val({{ $attribute->id_ciudad_nacimiento }});

        $('#id_pais_residencia').val({{ $attribute->id_pais_residencia }}); 
        $('#id_pais_residencia').change();
        $('#id_dep_residencia').val({{ $attribute->id_departamento_residencia }}); 
        $('#id_dep_residencia').change();
        $('#id_ciu_residencia').val({{ $attribute->id_ciudad_residencia }}); 

        $('#id_tipo_cliente').val({{$attribute->id_tipo_cliente}});
        $('#id_tipo_cliente').change().attr('disabled',true);
        $('#id_franquicia').val({{$attribute->franquicia}});
        $('#id_franquicia').change().attr('disabled',true);
        $('#id_sociedad').val({{ $attribute->id_sociedad }}); 
        $('#id_sociedad').change().attr('disabled',true);
        $('#id_tienda').val({{ $attribute->id_tienda }}); 
        $('#id_tienda').change().attr('disabled',true);
    });

@endsection

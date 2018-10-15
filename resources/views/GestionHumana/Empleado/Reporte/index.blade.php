@extends('layouts.master')

@section('content')

<div class="x_panel">
  <div class="x_title"><h2>Generación de Reportes de Empleados</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <form action="">
      <div class="stepwizard col-md-offset-3">
        <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle step">1</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle step">2</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle step">3</a>
          </div>
          <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle step disabled">4</a>
          </div>
        </div>
      </div>  
      <div id="step-1" class="setup-content">
        <div class="x_title"><h2>Filtrar por Características Personales Empleado</h2>
          <div class="clearfix"></div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>Tipo de Documento</label>
            <select class="form-control" id="tipoCedula" name="tipoCedula"></select>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
            <label>Número de Documento</label>
            <input class="form-control" type="text" id="cedula" name="cedula" placeholder="-Ingrese Número de Documento-">
          </div>  
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
            <label>Nombre(s)</label>
            <input  class="form-control" type="text" id="nombre" name="nombre" placeholder="-Ingrese Nombre-">
          </div>
        </div>   
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
            <label>Primer Apellido</label>
            <input  class="form-control" type="text" id="primerApellido" name="primerApellido" placeholder="-Ingrese Primer Apellido-">
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
            <label>Segundo Apellido</label>
            <input  class="form-control" type="text" id="segundoApellido" name="segundoApellido" placeholder="-Ingrese Segundo Apellido-">
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>Número de Hijos</label>
            <br>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding">
              <input type="number" class="form-control" id="hijosMin" name="hijosMin" placeholder="-Mínimo-">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" align="center">a</div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding">
              <input type="number" class="form-control" id="hijosMax" name="hijosMax" placeholder="-Máximo-">             
            </div>     
          </div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>Estado Civil</label>
            <select class="form-control" id="estadoCivil" name="estadoCivil"></select>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>Personas a Cargo</label>
            <br>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding">
              <input type="number" class="form-control" id="personasCargoMin" name="personasCargoMin" placeholder="-Mínimo-">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" align="center">a</div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding">
              <input type="number" class="form-control" id="personasCargoMax" name="personasCargoMax" placeholder="-Máximo-">            
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>Tenencia de Vivienda</label>
            <select class="form-control" id="tenenciaVivienda" name="tenenciaVivienda"></select>
          </div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">        
            <label>Tipo de Vivienda</label>
            <select class="form-control" id="tipoVivienda" name="tipoVivienda"></select>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>Rango de Edad</label>
            <br>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding">              
              <input type="number" class="form-control retireAlert" id="rangoEdadMin" name="rangoEdadMin" onblur="edad.validatedError(this)" min="15" max="100" placeholder="- Desde -">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" align="center">a</div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding">
              <input type="number" class="form-control retireAlert" id="rangoEdadMax" name="rangoEdadMax" onblur="edad.validatedError(this)" min="15" max="100" placeholder="- Hasta -">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>Tipo de Estudio</label>
            <input type="text" class="form-control" id="tipoEstudio" name="tipoEstudio">
          </div>
        </div>       
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 no-padding">
            <br>
            <label>Fecha de Estudio</label>
            <br>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding"> 
              <div class="input-group">
                  <input  type="text"  class="form-control data-picker-only" id="fechaEstudioMin" name="fechaEstudioMin" maxlength="10" placeholder="dd-MM-yyyy">
                  <span class="input-group-addon btn btn-info">
                      <i class="fa fa-calendar"></i>
                  </span>
              </div>
            </div>
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" align="center">a</div>              
              <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding">
                  <div class="input-group">
                    <input type="text" class="form-control data-picker-only" id="fechaEstudioMax" name="fechaEstudioMax" maxlength="10" placeholder="dd-MM-yyyy">
                    <span class="input-group-addon btn btn-info">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
              </div>       
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <br>
            <label>Estado de Estudio</label>
            <select class="form-control" id="estadoEstudio" name="estadoEstudio">
              <option value>-Seleccione una opción-</option>
              <option value="1">Terminado</option>
              <option value="2">Suspendido</option>
              <option value="3">Cursando</option>
            </select>
          </div>
        </div>
      </div>
      <div id="step-2" class="setup-content" style="display:none;">
        <div class="x_title"><h2>Filtrar por Características Empresariales</h2>
          <div class="clearfix"></div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>Cargo</label>
            <input  class="form-control" type="text" id="cargo" name="cargo" placeholder="-Ingrese Cargo-">
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>¿Tiene Familiares Laborando en la Empresa?</label>
            <select class="form-control" id="familiaEmpresa" name="familiaEmpresa">
              <option value>-Seleccione una opción-</option>
              <option value="1">Si</option>
              <option value="2">No</option>
            </select>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>¿Está retirado?</label>
            <select class="form-control" id="retirado" name="retirado">
              <option value>-Seleccione una opción-</option>
              <option value="0">Si</option>
              <option value="1">No</option>
            </select>
          </div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>Salario</label>
            <br>
            <div class="row">
              <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input type="text" class="moneda form-control centrar-derecha" name="salarioMin" id="salarioMin" maxlength="15" aria-label="Amount (to the nearest dollar)">
                </div>
              </div>
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" align="center">a</div>
              <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input type="text" class="moneda form-control centrar-derecha" name="salarioMax" id="salarioMax" maxlength="15" aria-label="Amount (to the nearest dollar)">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="familiaEmpresaTtl" style="display:none">
            <label>Número de Familiares</label>
            <br>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding" id="rangoFamiliaresMinDiv">
                <input type="number" class="form-control" id="rangoFamiliaresMin" name="rangoFamiliaresMin" placeholder="-Mínimo-">            
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" align="center">a</div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding" id="rangoFamiliaresMaxDiv">
              <input type="number" class="form-control" id="rangoFamiliaresMax" name="rangoFamiliaresMax" placeholder="-Máximo-">            
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="fechaRetiroTtl" style="display:none">
            <label>Fecha de Retiro</label>
            <br>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 no-padding">
                <div class="input-group">
                  <input type="text" class="form-control data-picker-only" id="fechaRetiroMin" name="fechaRetiroMin" style="display:none" maxlength="10" placeholder="dd-MM-yyyy">
                  <span class="input-group-addon btn btn-info">
                      <i class="fa fa-calendar"></i>
                  </span>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" align="center">a</div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 no-padding">
              <div class="input-group">
                <input type="text" class="form-control data-picker-only" id="fechaRetiroMax" name="fechaRetiroMax" style="display:none" maxlength="10" placeholder="dd-MM-yyyy">
                <span class="input-group-addon btn btn-info">
                    <i class="fa fa-calendar"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label>Auxilio de Transporte</label>
            <select class="form-control" id="auxilioTransporte" name="auxilioTransporte">
              <option value>-Seleccione una opción-</option>
              <option value="1">Si</option>
              <option value="2">No</option>
            </select>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="motivoRetiroTtl" style="display:none">
            <label>Motivo de Retiro</label>
            <select class="multi-select" type="text" id="motivoRetiro" name="motivoRetiro"></select>
          </div>
        </div>
      </div>
      <div id="step-3" class="setup-content" style="display:none;">
        <div class="x_title"><h2>Filtrar por Reportes Específicos</h2>
          <div class="clearfix"></div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label>¿Desea Incluir la Información Detalla de los Hijos?</label>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
              <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
                <label><input type="radio" class="check" id="infoDetalladaHijos" name="infoDetalladaHijos" value="Si">Si</label>
              </div>
              <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
                <label><input type="radio" class="check" id="infoDetalladaHijos" name="infoDetalladaHijos" Value="No" checked="checked">No</label>
              </div>
            </div>
          </div>
        </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <label>¿Desea Incluir la Información Detalla de las Personas a Cargo?</label>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
                  <label><input type="radio" class="check" id="infoDetalladaPersonasCargo" name="infoDetalladaPersonasCargo" value="Si">Si</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
                  <label><input type="radio" class="check" id="infoDetalladaPersonasCargo" name="infoDetalladaPersonasCargo" Value="No" checked="checked">No</label>
                </div>
              </div>
            </div>
          </div>
        <div class="row" style="margin-top: 2%;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label>¿Desea Incluir la Información Detalla de los Familiares que Laboran en la Empresa?</label>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
              <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
                <label><input type="radio" class="check" id="infoDetalladaFamiliaEmpresa" name="infoDetalladaFamiliaEmpresa" value="Si">Si</label>
              </div> 
              <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">             
                <label><input type="radio" class="check" id="infoDetalladaFamiliaEmpresa" name="infoDetalladaFamiliaEmpresa" Value="No" checked="checked">No</label>
              </div>
            </div>
          </div> 
        </div>    
      </div>    
      <div id="step-4" class="setup-content" style="display:none;">
        <table id="dataTableAction" class="display tabla" width="100%" cellspacing="0">
          <thead class="thead">
              <tr>               
                  <th>Nombre(s)</th> 
                  <th>Apellidos</th> 
                  <th>Tipo Documento</th> 
                  <th>Número Documento</th>
                  <th>Celular</th>
                  <th>Correo</th>
                  <th>Cargo</th>
                  <th>Ciudad</th>
              </tr>
          </thead> 
          <tbody class="tbody"></tbody>       
        </table>
      </div>
      <div>
        <div class="col-md-offset-4 col-lg-offset-4 col-sm-offset-4 btn-step" id="step-1Btn" style="display: none;">
          <input type="reset" title="Cancelar" class="btn btn-danger col-lg-2 col-md-2 col-sm-2 col-xs-5 col-xs-offset-1" onclick="previousStep('step-1','step-1')" value="Cancelar" style="margin-top: 4%">
          <input type="button" title="Siguiente" class="btn btn-success col-lg-2 col-md-2 col-sm-2 col-xs-5" onclick="nextStep('step-1','step-2')" value="Siguiente" style="margin-top: 4%">
        </div>
        <div class="col-md-offset-4 btn-step" id="step-2Btn" style="display: none;">
          <input type="button" title="Cancelar" class="btn btn-danger col-lg-2 col-md-2 col-sm-2 col-xs-5 col-xs-offset-1" onclick="previousStep('step-2','step-1')" value="Anterior" style="margin-top: 4%">
          <input type="button" title="Siguiente" class="btn btn-success col-lg-2 col-md-2 col-sm-2 col-xs-5" onclick="nextStep('step-2','step-3')" value="Siguiente" style="margin-top: 4%">
        </div>
        <div class="col-md-offset-4 btn-step" id="step-3Btn" style="display: none;">
          <input type="button" title="Cancelar" class="btn btn-danger col-lg-2 col-md-2 col-sm-2 col-xs-5 col-xs-offset-1" onclick="previousStep('step-3','step-2')" value="Anterior" style="margin-top: 4%">
          <input type="button" title="Siguiente" class="btn btn-success col-lg-2 col-md-2 col-sm-2 col-xs-5" onclick="getDataStep('step-3','step-4')" value="Siguiente" style="margin-top: 4%">
        </div>
        <div class="col-md-offset-4 btn-step" id="step-4Btn" style="display: none;">
          <input type="button" title="Cancelar" class="btn btn-danger col-lg-2 col-md-2 col-sm-2 col-xs-5 col-xs-offset-1" onclick="previousStep('step-4','step-3')" value="Regresar" style="margin-top: 4%">
          <input type="button" id="siguiente" title="Siguiente" onclick="GenerateExcel()" class="btn btn-success col-lg-2 col-md-2 col-sm-2 col-xs-5" value="Exportar" style="margin-top: 4%">
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
    <script src="{{asset('/js/report.js')}}"></script>
@endpush

@section('javascript')
  @parent

    URL.setUrl(" {{ url('/gestionhumana/empleado/get') }}" );
    URL.setUrlExcel("{{url('gestionhumana/empleado/exportExcel')}}");

    loadSelectInput("#estadoCivil","{{url('/gestionhumana/empleado/getselectlistEstadoCivil')}}")
    loadSelectInput("#tenenciaVivienda","{{url('/gestionhumana/empleado/getselectlistTenenciaVivienda')}}")
    loadSelectInput("#tipoVivienda","{{url('/gestionhumana/empleado/getselectlistTipoVivienda')}}")
    loadSelectInput("#tipoEstudio","{{url('/gestionhumana/empleado/getselectlistTipoEstudio')}}")
    loadSelectInput("#motivoRetiro","{{url('/gestionhumana/empleado/getselectlistMotivoRetiro')}}")
    loadSelectInput("#tipoCedula","{{url('/gestionhumana/empleado/getselectlistTipoDocumento')}}")

@endsection

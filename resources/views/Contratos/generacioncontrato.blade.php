@extends('layouts.master') @section('content')

<div class="col-md-10 col-md-offset-1">
    <div class="x_panel">
        <div class="x_title">
            <h2>Generación de Contrato</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <form>
                    <div class="stepwizard col-md-offset-3">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                                <a href="#step-1" type="button" class="btn btn-circle step btn-default btn-primary">1</a>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-2" type="button" class="btn btn-default btn-circle step">2</a>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-3" type="button" class="btn btn-default btn-circle step">3</a>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-4" type="button" class="btn btn-default btn-circle step">4</a>
                            </div>
                        </div>
                    </div>
                    <div id="step-1" class="setup-content" style="display: block;">
                        <div class="x_title">
                            <h2>Información del Cliente</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="col-md-6 bottom-20">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-3 col-xs-12" for="first-name">Tipo de Documento</label>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <select id="tipodocumento" name="tipodocumento" class="form-control col-md-7 col-xs-12" required="required">
                                                <option value="">- Seleccione una opción -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bottom-20">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-3 col-xs-12" for="first-name">Fecha de Nacimiento</label>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <input type="text" class="data-picker-only form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bottom-20">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-3 col-xs-12" for="first-name">Número de Documento</label>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <select id="pais" name="pais" class="form-control col-md-7 col-xs-12" required="required">
                                                <option value="">- Seleccione una opción -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bottom-20">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-3 col-xs-12" for="first-name">Fecha de Expedición</label>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <input type="text" class="data-picker-only form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bottom-20">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-3 col-xs-12" for="first-name">Nombres</label>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bottom-20">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-3 col-xs-12" for="first-name">Apellidos</label>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bottom-20">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-3 col-xs-12" for="first-name">Correo electrónico</label>
                                        <div class="col-md-7 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="step-2" class="setup-content" style="display: none;">
                        <div class="x_title">
                            <h2>Información General del Contrato</h2>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <div id="step-3" class="setup-content" style="display: none;">
                        <div class="x_title">
                            <h2>Información Detallada del Contrato</h2>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <div id="step-4" class="setup-content" style="display: none;">
                        <div class="x_title">
                            <h2>Resumen de Contrato</h2>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection @section('javascript') @parent loadSelectInput("#col5_filter", "{{url('/pais/getpais')}}", 2); column=[ { "data":"ciudad"
}, { "data": "zona" }, { "data": "tienda" }, { "data": "meses_transcurridos" }, { "data": "dias_transcurridos" },{ "data":
"menos_meses" }, { "data": "menos_porcentaje_retroventas" }, { "data": "monto_desde" }, { "data": "monto_hasta"},{ "data":
"estado" }, ]; dataTableActionFilter("{{url('/configcontrato/apliretroventa/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column);
$("#updateAction1").click(function() { var url2="{{ url('/configcontrato/apliretroventa/edit') }}"; updateRowDatatableAction(url2)
}); $("#deletedAction1").click(function() { var url2="{{ url('/configcontrato/apliretroventa/inactive') }}"; deleteRowDatatableAction(url2);
}); $("#deletedAction2").click(function() { var url2="{{ url('/configcontrato/apliretroventa/delete') }}"; deleteRowDatatableAction(url2);
}); $("#activatedAction1").click(function() { var url2="{{ url('/configcontrato/apliretroventa/active') }}"; deleteRowDatatableAction(url2,
"¿Activar el registro?"); }); @endsection
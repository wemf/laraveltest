@extends('layouts.master') @section('content')


<div class="modal-styles confirm-hide modal-documento">
    <div class="shadow"></div>
    <div class="container">
        <div class="title">
            <h1 id="confirmtitle">Escanear Documento</h1>
        </div>
        <h3 class="segment">Seleccione el tipo de documento del cliente y pase el documento por el lector de barras</h3>
        <div class="row">
            <div class="col-md-12 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="tipodocumento_documento">Tipo de Documento <span class="required">*</span></label>
                        <select id="tipodocumento_documento" name="tipodocumento_documento" class="form-control col-xs-12 tipodocumento" required="required">
                            <option value="">- Seleccione una opción -</option>
                            @foreach ($tipos_doc as $tipo_doc)
                            <option data-id="{{ $tipo_doc->id }}" value="{{ $tipo_doc->nombre_abreviado }}">{{ $tipo_doc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="buttons">
            <button type="button" class="btn btn-primary" onclick="confirm.hide();">Cancelar</button>
        </div>
    </div>
</div>

<div class="modal-styles confirm-hide modal-manual">
    <div class="shadow"></div>
    <div class="container">
        <div class="title">
            <h1 id="confirmtitle">Ingrese datos del cliente</h1>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                        <label for="tipodocumento_manual">Tipo de Documento <span class="required">*</span></label>
                        <select id="tipodocumento_manual" name="tipodocumento_manual" class="form-control col-xs-12 tipodocumento requerido">
                            <option value="">- Seleccione una opción -</option>
                            @foreach ($tipos_doc as $tipo_doc)
                            <option value="{{ $tipo_doc->id }}">{{ $tipo_doc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 bottom-20">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-xs-12">
                    <label for="numdocumento">Número de Documento <span class="required">*</span></label>
                        <input name="numdocumento" id="numdocumento" type="text" class="form-control col-xs-12 requerido">
                    </div>
                </div>
            </div>
        </div>

        <div class="buttons">
            <button type="button" class="btn btn-success" onclick="vcliente.clienteManual();">Aceptar</button>
            <button type="button" class="btn btn-primary" onclick="confirm.hide();">Cancelar</button>
        </div>
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2>Generación de Plan separe<small> Verificación Datos Cliente</small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <!-- <div class="row">
            <h1 align="center">Forma de Verificación</h1>
        </div> -->
        <br>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="col-md-4">
                    <div onclick="$('.modal-documento').addClass('confirm-visible').removeClass('confirm-hide');" class="btn btn-primary btn-img">
                        <img src="{{ asset('images/pasaporte.png') }}" height="115px" alt="Escanear Documento">
                        <p>Escanear Documento</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div onclick="$('.modal-manual').addClass('confirm-visible').removeClass('confirm-hide');" class="btn btn-primary btn-img">
                        <img src="{{ asset('images/teclas.png') }}" height="115px" alt="Ingresar Manualmente">
                        <p>Ingresar Manualmente</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- <br>
        <br>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach ($tipos_doc as $tipo_doc)
                    <div class="inline-30">
                        <input type="radio" id="{{ $tipo_doc->id }}" name="tipodoc" class="radio-control" value="{{ $tipo_doc->nombre_abreviado }}" />
                        <label for="{{ $tipo_doc->id }}" class="lbl-radio-control" style="font-size: 16px!important; font-weight: 100; height: 26px; display: block;"> {{ $tipo_doc->nombre }}</label>          
                    </div>
                @endforeach
            </div>
        </div> -->
        <div class="">
            <input type="text" id="element_doc_1" style="border:0;color:white;color: transparent;overflow: hidden;width: 0;">
            <input type="text" id="element_doc_2" style="border:0;color:white;color: transparent;overflow: hidden;width: 0;">
            <input type="text" id="element_doc_3" style="border:0;color:white;color: transparent;overflow: hidden;width: 0;">
            <input type="text" id="element_doc_4" style="border:0;color:white;color: transparent;overflow: hidden;width: 0;">
            <input type="text" id="element_doc_5" style="border:0;color:white;color: transparent;overflow: hidden;width: 0;">
            <input type="text" id="element_doc_6" style="border:0;color:white;color: transparent;overflow: hidden;width: 0;">
            <input type="text" id="element_doc_7" style="border:0;color:white;color: transparent;overflow: hidden;width: 0;">
            <input type="text" id="element_doc_8" style="border:0;color:white;color: transparent;overflow: hidden;width: 0;">
            <input type="text" id="element_doc_9" style="border:0;color:white;color: transparent;overflow: hidden;width: 0;">
            <input type="text" id="element_doc_10" style="border:0;color:white;color: transparent;overflow: hidden;width: 0;">
        </div>
    </div>
</div>

@endsection 

@push('scripts')
<script src="{{asset('/js/plansepare/validarcliente.js')}}"></script>
@endpush

@section('javascript') 
@parent 
loadSelectInput("#col5_filter", "{{url('/pais/getpais')}}", 2); 
column=[ { "data":"ciudad" }, { "data": "zona" }, { "data": "tienda" }, { "data": "meses_transcurridos" }, { "data": "dias_transcurridos" },{ "data": "menos_meses" }, { "data": "menos_porcentaje_retroventas" }, { "data": "monto_desde" }, { "data": "monto_hasta"},{ "data": "estado" }, ]; 
dataTableActionFilter("{{url('/configcontrato/apliretroventa/get')}}","{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}",column);
$("#updateAction1").click(function() { var url2="{{ url('/configcontrato/apliretroventa/edit') }}"; updateRowDatatableAction(url2) }); 
$("#deletedAction1").click(function() { var url2="{{ url('/configcontrato/apliretroventa/inactive') }}"; deleteRowDatatableAction(url2); }); 
$("#deletedAction2").click(function() { var url2="{{ url('/configcontrato/apliretroventa/delete') }}"; deleteRowDatatableAction(url2); }); 
$("#activatedAction1").click(function() { var url2="{{ url('/configcontrato/apliretroventa/active') }}"; deleteRowDatatableAction(url2, "¿Activar el registro?"); });
@endsection
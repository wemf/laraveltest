@extends('layouts.master') 

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
        <h2>Generación de Contrato<small> Verificación Datos Cliente</small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="row">
            <h1 align="center">Escanee Documento o Huella</h1>
            <br>
            <br>
            <div class="col-md-2 col-md-offset-3">
                <img src="{{ asset('images/huella.svg') }}" alt="Ejemplo de Huella" width="100%">
            </div>
            <div class="col-md-2 col-md-offset-2">
                <img src="{{ asset('images/documento_identidad.svg') }}" alt="Ejemplo de Cédula" width="100%">
            </div>
        </div>
        <br>
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
        </div>
        <div class="">
            <input type="text" id="element_doc_1">
            <input type="text" id="element_doc_2">
            <input type="text" id="element_doc_3">
            <input type="text" id="element_doc_4">
            <input type="text" id="element_doc_5">
            <input type="text" id="element_doc_6">
            <input type="text" id="element_doc_7">
            <input type="text" id="element_doc_8">
            <input type="text" id="element_doc_9">
            <input type="text" id="element_doc_10">
        </div>
    </div>
</div>

@endsection 

@push('scripts')
<script src="{{asset('/js/contrato/validarcliente.js')}}"></script>
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
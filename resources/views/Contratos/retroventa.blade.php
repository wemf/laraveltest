@extends('layouts.master') 

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="modal-styles confirm-hide modal-cc">
	<div class="shadow" onclick="confirm.hide();"></div>
	<div class="container">
		<div class="title">
			<h1 id="confirmtitle">Documento del Cliente</h1>
		</div>
		
		<input type="checkbox" name="chk_flip" id="chk_flip" class="hide">
		<div class="flip" style="height: 200px; margin: 10px auto;">
			<img @if($attribute != null) src="{{env('RUTA_ARCHIVO_OP')}}colombia\cliente\doc_persona_natural\{{$attribute->ruta_foto_posterior}}" @else  src="{{asset('images/noimagen.png') }}" @endif class="flip-1" onerror="this.src='{{ asset('images/noimagen.png') }}'" height="200px">
			<img @if($attribute != null) src="{{env('RUTA_ARCHIVO_OP')}}colombia\cliente\doc_persona_natural\{{$attribute->ruta_foto_anterior}}" @else  src="{{asset('images/noimagen.png') }}" @endif class="flip-2" onerror="this.src='{{ asset('images/noimagen.png') }}'" height="200px">
		</div>

		<div class="buttons">
			<label type="button" class="btn btn-success" onclick="generarPDF();"> Aceptar</label>
			<label for="chk_flip" type="button" class="btn btn-primary"><i class="fa fa-refresh"></i> Girar</label>
			<button id="cancelConfirm" type="button" class="btn btn-danger" onclick="confirm.hide();">Cancelar</button>
		</div>
	</div>
</div>
<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
	<div class="row">
		@if($attribute->extraviado == 0)
		<a href="javascript:retroventa()" title="Retroventa del Contrato" id="deletedAction1" class="btn btn-danger" style="width: 100%">
			<i class="glyphicon glyphicon-remove-circle "></i>Retroventa del contrato</a>
		<a href="{{ url('/contrato/reversarretroventa') }}/{{$contrato[0]->Codigo_Contrato}}/{{$contrato[0]->id_tienda_contrato}}/{{$infoActualContrato[0]->valor_retroventa}}"
		 title="Aprobar Reverso de Cierre" id="updateAction1" class="btn btn-success col-md-9 col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-offset-3 hide">
			<i class="fa fa-sign-in"></i>Autorizar Reversa</a>
			<div class="btn btn-primary col-md-9 col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-offset-3 " onclick="$('.modal-cc-info').addClass('confirm-visible').removeClass('confirm-hide');">Ver Documento</div>
		@else
		<div class="btn btn-primary pull-right" onclick="$('.modal-cc').addClass('confirm-visible').removeClass('confirm-hide');">Imprimir copia</div>
		@endif
	</div>
</div>
<div class="x_panel">
	@if($attribute->extraviado == 1)
	<div class="alert alert-error">
        <strong id="EstadoSolicitud">Estado del contrato: Extraviado</strong>  
        <p>Hola, {{Auth::user()->name}} el contrato está extraviado.</p>              
	</div>
	@endif
	<div class="x_title">
		<h2>Retroventa contrato</h2>
		<div class="clearfix"></div>
	</div>
	@include('Contratos.infocontrato')
	<br>
	<br>

	<div class="x_title">
		<div class="clearfix"></div>
	</div>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-5">
			<a href="{{url('contrato/index')}}" class="btn btn-danger" type="button">
				<i class="fa fa-reply"></i> Regresar</a>
		</div>
	</div>
</div>

<input type="hidden" id="contrato_extraviado" name="contrato_extraviado" value="1" />

<form id="form_pdf_contrato" class="hide" method="POST" action="{{ url('creacioncontrato/generarpdf') }}">
	{{ csrf_field() }}  
	<input type="hidden" id="contrato_pdf" name="contrato_pdf" value="{{ $id }}" >
	<input type="hidden" id="tienda_pdf" name="tienda_pdf" value="{{ $id_tienda }}" >
	<input type="hidden" id="copia_pdf" name="copia_pdf" value="1" >
	<input type="submit" id="btn-submit" />
</form>
@endsection 

@push('scripts')
<script src="{{asset('/js/contrato/generacioncontrato.js')}}"></script>
<script src="{{asset('/js/contrato/retroventa.js')}}"></script> 
@endpush 
@section('javascript')
@parent 

//<script>

@if(Session::has('session_tienda_pdf'))
	$('#tienda_pdf').val({{ Session::get('session_tienda_pdf') }});
	$('#contrato_pdf').val({{ Session::get('session_contrato_pdf') }});
	$('#form_pdf_contrato').submit();
@endif
	
function retroventa(){
	var message = '¿Desea realizar la retroventa?';
	confirm.setTitle('Alerta');
	confirm.setSegment(message);
	confirm.show();

	confirm.setFunction(function() {
		location.href= "{{ url('/contrato/retroventapost') }}/{{$contrato[0]->Codigo_Contrato}}/{{$contrato[0]->id_tienda_contrato}}/{{$infoActualContrato[0]->valor_retroventa}}";
	});
}



@endsection


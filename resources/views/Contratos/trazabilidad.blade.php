@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title"><h2>Trazabilidad guía</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('layouts.trazabilidad',$traza)
    <a href="{{url('/contrato/logistica')}}" class="btn btn-danger">Regresar</a>
	</div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/contrato/resolucion.js')}}"></script>
@endpush

@section('javascript')
  @parent
  //<script>
    $('.dataTableAction').DataTable({
        language: 
        {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
        },
    });
  

@endsection
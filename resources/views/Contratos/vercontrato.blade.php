@extends('layouts.master') @section('content')
@include('Trasversal.migas_pan.migas')
<div class="x_panel">
    <div class="x_title">
        <h2>Ver contrato</h2>
        <div class="clearfix"></div>
    </div>
    @include('Contratos.infocontrato')
    <div class="x_title">
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <div class="col-md-6" style='text-align: center; width: 100%;'>
            <a href="{{url('contrato/index')}}" class="btn btn-danger" type="button"><i class="fa fa-reply"></i> Regresar</a>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection @push('scripts')
<script src="{{asset('/js/contrato/generacioncontrato.js')}}"></script>
<script src="{{asset('/js/contrato/retroventa.js')}}"></script>
 
@endpush 


@section('javascript') 
@parent 
loadSelectInput(".tipodocumento", "{{url('/clientes/tipodocumento/getSelectList')}}",2); 
loadSelectInput("#paistercero", "{{url('/pais/getSelectList')}}",true); 
loadSelectInput("#departamentotercero", "{{url('/departamento/getSelectList')}}",2); 
loadSelectInput("#ciudadtercero", "{{url('/ciudad/getSelectList')}}",2);



@endsection
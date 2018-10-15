@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
	<div class="row">
    <button type="button" class="btn btn-primary" style="width: 100%;" data-toggle="modal" data-target="#myModal"> <i class="fa fa-send "></i> Prorrogar</button>
  </div>
</div>
<div class="x_panel">
  <div class="x_title">
    <h2>Prorrogar contrato</h2>
    <div class="clearfix"></div>
  </div>
  @include('Contratos.infocontrato')
    <br><br>
    <div class="row">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
    
    </div> 
    <div class="x_title">
      <h2>Historial de prórrogas del contrato</h2>
      <div class="clearfix"></div>
    </div>
    </div>
    <div class="items_contrato_tmp">
      <table class="display dataTableAction" width="100%" cellspacing="0">
         <thead>
            <tr>                
                <th>Fecha de Terminación</th> 
                <th>Fecha de Prórroga</th> 
                <th>Nueva Fecha de Terminación</th> 
                <th>Valor Ingresado</th> 
                <th>Meses Prorrogados</th> 
            </tr>
        </thead> 
        <tbody>
            @foreach($historial AS $historia)
                <tr>
                  <td>{{$attribute->fecha_terminacion}}</td>
                  <td>{{$historia->fecha_prorroga}}</td>
                  <td>{{$historia->fecha_terminacion}}</td>
                  <td>{{$historia->valor_ingresado}}</td>
                  <td>{{$historia->meses_ingresados}}</td>
                </tr>
              @endforeach
        </tbody>
      </table>
    </div> 
      <hr>

    <div class="x_title">
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <a href="{{url('contrato/index')}}" class="btn btn-danger" type="button"><i class="fa fa-reply"></i> Regresar</a>
        </div>
    </div>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="{{asset('/js/contrato/generacioncontrato.js')}}"></script>
<script src="{{asset('/js/contrato/prorrogar.js')}}"></script>
@endpush 

@section('javascript')   
  @parent
  $('.dataTableAction').DataTable({
     language: {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
        },
  });
@endsection
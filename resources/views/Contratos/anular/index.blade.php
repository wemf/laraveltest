@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')


<div class="x_panel">
<div class="row"> 
   <!-- Rol: Jefe de Zona -->
    @if(Auth::user()->role->id==env('ROL_JESE_ZONA'))   
      <!-- Estado de contrato: Pendiente de Aprobación -->  
      @if($contrato[0]->Id_Contrato==env('ESTADO_CONTRATO_PENDIENTE') )
         <button title="Anular Contrato"  id="AprobarSolicitudAction"  onclick="anular.AprobarSolicitudAction()" type="button" class="btn btn-success col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-offset-7"><i class="fa fa-send "></i> Anular Contrato</button> 
        <button title="Rechazar Solicitud"  id="RechazarSolicitudActionBtn"  onclick="anular.RechazarSolicitudAction()" type="button" class="btn btn-danger col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-offset-7"><i class="fa fa-send "></i> Rechazar Solicitud</button> 
      @else
        <div class="alert alert-success">
            <strong id="EstadoSolicitud">Estado de la solicitud: {{$contrato[0]->Estado_Contrato}}</strong>               
        </div>
      @endif 
      
    <!-- Rol: Auxiliar de Tienda -->
    @elseif(Auth::user()->role->id==env('ROL_AUXILIAR_TIENDA')) 
      <!-- Estado de contrato: Pendiente de Aprobación  || Anulado -->   
      @if($contrato[0]->Id_Contrato==env('ESTADO_CONTRATO_PENDIENTE') || $contrato[0]->Id_Contrato==env('ESTADO_CONTRATO_ANULADO') )
        <div class="alert alert-success">
            <strong id="EstadoSolicitud">Estado de la solicitud: {{$contrato[0]->Estado_Contrato}}</strong>               
        </div>
      <!--  Aprobado  -->  
      @elseif($contrato[0]->Id_Contrato==env('ESTADO_CONTRATO_APROBADO'))
        <button title="Anular Contrato"  id="AnularContratoActionBtn"  onclick="anular.AnularContratoAction()" type="button" class="btn btn-success col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-offset-7"><i class="fa fa-send "></i> Anular Contrato</button> 
      @else
        <button title="Solicitar Aprobación"  id="SolicitarAnularActionBtn"  onclick="anular.SolicitarAnularAction()" type="button" class="btn btn-success col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-offset-7"><i class="fa fa-send "></i> Solicitar Aprobación</button> 
      @endif 
    <!-- Rol: Otro -->
    @else
      <div class="alert alert-success">
        <strong id="EstadoSolicitud">Estado de la solicitud: {{$contrato[0]->Estado_Contrato}}</strong>  
        <p>Hola, {{Auth::user()->name}} no tienes asignado el Rol para gestionar el módulo de anular contrato.</p>              
      </div>
    @endif 

  </div> 
<div class="row">
  <div class="x_content">
    <div class="x_title">
      <h2>Anular contrato</h2>
      <div class="clearfix"></div>
    </div>
    @include('Contratos.infocontrato')
    <hr>
    <div class="row">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
    
    </div> 
    </div>
      <hr>
      <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <a href="{{url('contrato/index')}}" class="btn btn-danger" type="button"><i class="fa fa-reply"></i> Regresar</a>
        </div>
      </div>

  </div>
</div>
@endsection

@push('scripts')
  <script src="{{asset('/js/contrato/generacioncontrato.js')}}"></script>
  <script src="{{asset('/js/contrato/anular.js')}}"></script>
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
  anular.setUrlDatatable("{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}");
  anular.setIdTienda("{{$contrato[0]->id_tienda_contrato}}");
  anular.setCodigoContrato("{{$contrato[0]->Codigo_Contrato}}");
  anular.setIdRemitente("{{$idRemitente}}");
  anular.setUrlSolicitud("{{route('contrato.anular.solicitud')}}");
  anular.setUrlAprobado("{{route('contrato.anular.solicitud.aprobado')}}");
  anular.setUrlSolicitudRechazada("{{route('contrato.anular.solicitud.rechazada')}}");
  anular.setUrlAnulado("{{route('contrato.anular.anulado')}}");
  anular.run();
@endsection
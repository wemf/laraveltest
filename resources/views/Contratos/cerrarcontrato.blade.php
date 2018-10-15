@extends('layouts.master') @section('content') @include('Trasversal.migas_pan.migas')

<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
	<div class="row">
    <!-- Rol: Jefe de Zona -->
    @if(Auth::user()->role->id==env('ROL_JESE_ZONA'))
        <!-- Estado de contrato: Pendiente de Aprobación De Cerrado -->  
        @if($contrato[0]->Id_Contrato==env('ESTADO_CONTRATO_PENDIENTE_CERRADO') )
            <button title="Cerrar Contrato" style="width: 100%;"  id="deletedAction1" class="btn btn-danger " data-toggle="modal" data-target="#myModalCerrar"><i class="glyphicon glyphicon-remove-circle "></i> Cerrar contrato</a>   
            </div> 
            </div>
        @elseif($contrato[0]->Id_Contrato==env('ESTADO_CONTRATO_PENDIENTE_REVERSADO'))      
            <button title="Reversar Contrato" style="width: 100%;"  id="reversarAction1" class="btn btn-success " data-toggle="modal" data-target="#myModalReversar"><i class="fa fa-sign-in"></i> Reversar contrato</a>                  
            </div> 
            </div>
        @else
            </div> 
            </div> 
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="alert alert-success">
                        <strong id="EstadoSolicitud">Estado del Contrato: {{$contrato[0]->Estado_Contrato}}</strong>               
                    </div>
                </div> 
            </div>
        @endif

    <!-- Rol: Auxiliar de Tienda -->
    @elseif(Auth::user()->role->id==env('ROL_AUXILIAR_TIENDA')) 
      <!-- Estado de contrato: Pendiente de Aprobación De Cerrado  || Cerrado -->   
        @if($contrato[0]->Id_Contrato==env('ESTADO_CONTRATO_PENDIENTE_CERRADO')  )
            </div> 
            </div> 
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="alert alert-success">
                        <strong id="EstadoSolicitud">Estado del Contrato: {{$contrato[0]->Estado_Contrato}}</strong>               
                    </div>
                </div> 
            </div> 
        @elseif($contrato[0]->Id_Contrato==env('ESTADO_CONTRATO_CERRADO'))
            <button title="Aprobar Reverso de Cierre" style="width: 100%;"  data-toggle="modal" data-target="#myModalsolicitudreversa"  id="updateAction1"  type="button" class="btn btn-success"><i class="fa fa-sign-in"></i> Solicitud Reversar Cierre</button>       
            </div>
            </div>
        @elseif($contrato[0]->Id_Contrato==env('ESTADO_CONTRATO_RESTABLECER'))
            <button title="Solicitud Cerrar Contrato" style="width: 100%;"  id="deletedAction1" class="btn btn-danger " data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-remove-circle "></i> Solicitud Cerrar Contrato</a>      
            </div>
            </div>
        @else
            </div> 
            </div> 
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="alert alert-success">
                        <strong id="EstadoSolicitud">Estado del Contrato: {{$contrato[0]->Estado_Contrato}}</strong>               
                    </div>
                </div>    
            </div>    
        @endif 
    <!-- Rol: Otro -->
    @else
        </div> 
        </div> 
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="alert alert-success">
                    <strong id="EstadoSolicitud">Estado del Contrato: {{$contrato[0]->Estado_Contrato}}</strong>  
                    <p>Hola, {{Auth::user()->name}} no tienes asignado el Rol para gestionar el módulo de Cerrar contrato.</p>              
                </div>
            </div>    
        </div>         
    @endif 
<!-- Seccion del modal. -->
<!-- Reversar Contrato -->
<form id="form-attribute" action="{{ url('/contrato/cerrarcontrato/reversarcierre') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
{{ csrf_field() }}  
            @include('FormMotor/message') 
    <div class="modal fade" id="myModalReversar" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reversar Contrato</h4>
                </div>
                <div class="modal-body">
                            <span>¿Esta Seguro de Reversar este Contrato?</span>
                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Si</button>
                                    <button class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                </div>
                <div class="form-group">
                                <input type="hidden" name="id" value="{{$contrato[0]->Codigo_Contrato}}">
                                <input type="hidden" name="id_tienda" value="{{$contrato[0]->id_tienda_contrato}}">
                                <input type="hidden" name="idRemitente" value="{{$idRemitente}}">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
    
</form>
<!-- Fin Reversar Contrato  -->
<!-- Cerrar Contrato. -->
<form id="form-attribute" action="{{ url('/contrato/cerrarcontrato/cerrar') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
    {{ csrf_field() }}  
                @include('FormMotor/message') 
    <div class="modal fade" id="myModalCerrar" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cerrar Contrato</h4>
                                                </div>
                    <div class="modal-body">
                            <span>¿Esta Seguro de Cerrar este Contrato?</span>
                        <div class="form-group">
                                    <button type="submit" class="btn btn-success">Si</button>
                                    <button class="btn btn-danger" data-dismiss="modal">No</button>
                                            </div>
                                            </div>
                            <div class="form-group">
            <input type="hidden" name="id" value="{{$contrato[0]->Codigo_Contrato}}">
            <input type="hidden" name="id_tienda" value="{{$contrato[0]->id_tienda_contrato}}">
                                <input type="hidden" name="idRemitente" value="{{$idRemitente}}">
                    </div>
                </div>
            </div>
    </div>
    
</form>
<!-- Fin Cerrar Contrato -->
<!-- Solicitud Cerrar Contrato. -->
<form id="form-attribute" action="{{ url('/contrato/cerrarcontrato/solicitudcerrar') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
{{ csrf_field() }}  
            @include('FormMotor/message') 
<div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Solucitud Cerrar Contrato</h4>
                </div>
                <div class="modal-body">
                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Motivo<span class="required">*</span> </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class=" form-control" id="Motivo_Cierre" required="required" name="Motivo_Cierre">
                        <option value>Seleccione...</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Certificado<span class="required">*</span> </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                            <div clasS="content_file_input">
                                <input type="file" name="file_certificado" required="required" id="file_certificado" class="input-file1">
                                <label tabindex="0" for="my-file1" class="input-file-trigger f1"><i aria-hidden="true" class="fa fa-upload fa-2x"></i></label>
                                <p class="file-return1"></p>
                                            </div>
                            <div class="conten_dele_file" onclick="reset_file('file_certificado','file-return1')">
                                                    <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                                </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Denuncia<span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div clasS="content_file_input">
                                <input type="file" name="file_denuncia" required="required" onkeydown="return false;" id="file_denuncia" class="input-file2">
                                <label tabindex="0" for="my-file2" class="input-file-trigger f2"><i aria-hidden="true" class="fa fa-upload fa-2x"></i></label>
                                <p class="file-return2"></p>
                                            </div>
                            <div class="conten_dele_file">
                                                <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Incautación<span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div clasS="content_file_input">
                                <input type="file" name="file_incautacion" id="file_incautacion" required="required" class="input-file3">
                                <label tabindex="0" for="my-file3" class="input-file-trigger f3"><i aria-hidden="true" class="fa fa-upload fa-2x"></i></label>
                                <p class="file-return3"></p>
                                                </div>
                            <div class="conten_dele_file" onclick="reset_file('file_incautacion')">
                                                            <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            <input type="hidden" name="id" value="{{$contrato[0]->Codigo_Contrato}}">
            <input type="hidden" name="id_tienda" value="{{$contrato[0]->id_tienda_contrato}}">
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" style="display:none"></button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button class="btn btn-primary" type="reset">Restablecer</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
    </div>
</div>
</form>
<!-- Fin Solicitud Cerrar Contrato -->
<!-- Reversar Contrato -->

<form id="form-attribute" action="{{ url('/contrato/cerrarcontrato/solicitudreversarcierre') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
    {{ csrf_field() }} @include('FormMotor/message')
<div class="modal fade" id="myModalsolicitudreversa" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reversar Contrato</h4>
                </div>
                <div class="modal-body">
                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Motivo de Reversa<span class="required">*</span>
                        </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class=" form-control" id="Motivo_Solicitud_Cierre" required="required" name="Motivo_Solicitud_Cierre">
                        <option value>Seleccione...</option>
                        </select>
                    </div>
                </div>
                </div>
                
            <input type="hidden" name="id" value="{{$contrato[0]->Codigo_Contrato}}">
            <input type="hidden" name="id_tienda" value="{{$contrato[0]->id_tienda_contrato}}">
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" style="display:none"></button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button class="btn btn-primary" type="reset">Restablecer</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
    </div>
</div>
</form>
<!-- Fin reversar Contrato -->
<!-- /////////////////// -->

<div class="x_panel">
<div class="row">
        <div class="x_title">
            <h2>Cerrar contrato</h2>
            <div class="clearfix"></div>
        </div>
        @include('Contratos.infocontrato')
        <div class="x_title">
            <h2>Documentos adjuntos</h2>
            <div class="clearfix"></div>
        </div>
        <div class="content-file">
            <div class="group-file">
                <div class="gfile ffile"><b>Certificado</b></div>
                <div class="gfile"><span id="nombre_archivo_1"></span></div>
                <div class="gfile ffile"><b>Tamaño</b></div>
                <div class="gfile"><span id="peso_archivo_1"></span></div>
                <div class="gfile"><span id="kb_1"></span></div>
                <div class="gfile"><a href="{{ url('/contrato/cerrarcontratodescargar') }}/{{$contrato[0]->id_certificado}}" class="dfile"><i class="fa fa-download" aria-hidden="true"></i></a></div>
            </div>
            <div class="group-file">
                <div class="gfile ffile"><b>Denuncia</b></div>
                <div class="gfile"><span id="nombre_archivo_2"></span></div>
                <div class="gfile ffile"><b>Tamaño</b></div>
                <div class="gfile"><span id="peso_archivo_2"></span></div>
                <div class="gfile"><span id="kb_2"></span></div>
                <div class="gfile"><a href="{{ url('/contrato/cerrarcontratodescargar') }}/{{$contrato[0]->id_denuncia}}" class="dfile"><i class="fa fa-download" aria-hidden="true"></i></a></div>
            </div>
            <div class="group-file">
                <div class="gfile ffile"><b>Incautación</b></div>
                <div class="gfile"><span id="nombre_archivo_3"></span></div>
                <div class="gfile ffile"><b>Tamaño</b></div>
                <div class="gfile"><span id="peso_archivo_3"></span></div>
                <div class="gfile"><span id="kb_3"></span></div>
                <div class="gfile"><a href="{{ url('/contrato/cerrarcontratodescargar') }}/{{$contrato[0]->id_incautacion}}" class="dfile"><i class="fa fa-download" aria-hidden="true"></i></a></div>
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
    <script src="{{asset('/js/contrato/cerrar.js')}}"></script>
@endpush

@section('javascript')   
@parent   
//<script>
consultarArchivo('{{$contrato[0]->id_certificado}}',1);
consultarArchivo('{{$contrato[0]->id_denuncia}}',2);
consultarArchivo('{{$contrato[0]->id_incautacion}}',3);


$('.dataTableAction').DataTable({
   language: 
   {
        url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
    },
});

 fillSelect('#estado_cerrado','#Motivo_Cierre','{{ url('/contrato/cerrarcontrato/listMotivosEstado') }}');     
 fillSelect('#estado_aplazar','#Motivo_Solicitud_Cierre','{{ url('/contrato/cerrarcontrato/listMotivosEstado') }}');     
 fillSelect('#estado_cerrado','#Motivo_Reversa','{{ url('/contrato/cerrarcontrato/listMotivosEstado') }}');

@endsection
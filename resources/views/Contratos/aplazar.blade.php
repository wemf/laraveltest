@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')
<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
	<div class="row">
    <button type="button" class="btn btn-primary" style="width: 100%" data-toggle="modal" data-target="#myModal"> <i class="fa fa-send "></i> Aplazar</button>
  </div>
</div>
<div class="x_panel">
  <div class="x_title">
    <h2>Aplazar contrato</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
  <div class="row">
        <form id="form-attribute" action="{{ url('/contrato/aplazar') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
            <div id="frm_nuevo_aplazo" >
                <div class="container">
                  <!-- Modal -->
                  <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Generar un nuevo aplazo para el contrato</h4>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha Aplazo <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="fecha_aplazo" id="fecha_aplazo" required="required" class="form-control col-md-7 col-xs-12 data-picker-only" >
                              </div>
                          </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Comentario</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <!-- <input type="text" name="comentario" required="required" class="form-control col-md-7 col-xs-12" value=""> -->
                              <textarea name="comentario" id="comentario" class="form-control col-md-7 col-xs-12" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        </div>
                        <input type="hidden" name="id" id="id" value="{{$id}}">
                        <input type="hidden" name="id_tienda" id="id_tienda" value="{{$id_tienda}}">
                        <input type="hidden" name="tienda" id="tienda" value="{{$attribute->tienda}}">
                        <input type="hidden" name="correo_email" id="correo_email" value="{{$attribute->correo_electronico}}">
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
            </div>
           </div>
        </form>
        </div> 
    </div>
    @include('Contratos.infocontrato')
    <br><br>
    <div class="row">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
    
    </div> 
    <div class="x_title">
      <h2>Historial de aplazos del contrato</h2>
      <div class="clearfix"></div>
    </div>
    </div>
    <div class="items_contrato_tmp">
      <table class="display dataTableAction" width="100%" cellspacing="0">
         <thead>
            <tr>               
                <th>Fecha de Aplazamiento</th> 
                <th>Motivo</th> 
            </tr>
        </thead> 
        <tbody>
            @foreach($historial AS $historia)
                <tr>
                  <td>{{$historia->fecha_aplazo}}</td>
                  <td>{{$historia->comentario}}</td>
                </tr>
              @endforeach
        </tbody>
      </table>
    </div>  
      <hr>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <a href="{{url('contrato/index')}}" class="btn btn-danger" type="button"><i class="fa fa-reply"></i> Regresar</a>
        </div>
    </div>
      </div>
    </div>
</div>
</div>

@push('scripts')
<script src="{{asset('/js/contrato/generacioncontrato.js')}}"></script>
@endpush 
@endsection

@section('javascript')   
  @parent
  $('.dataTableAction').DataTable({
     language: {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
        },
  });

@endsection

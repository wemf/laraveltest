@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-9 col-md-offset-1">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Secuencia Tienda</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Secuencias Invalidad</h4>
            </div>
            <div class="modal-body">
              <div class="row" >
                <div class="form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-12 col-md-offset-1" for="last-name">Secuencia<span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="sec_invalida" id="sec_invalida" required="required" class="form-control col-md-12 col-xs-12 requiered">
                    <input type="hidden" name="sec_tienda" id="sec_tienda" value="3">
                    <input type="hidden" name="id_tienda" id="id_tienda" value="{{ $attribute->id_tienda }}">
                  </div>
                </div>
                <div style="margin-top:40px">
                  <div class="col-md-7 col-sm-7 col-xs-12 col-md-offset-5">
                    <button type="button" class="btn btn-primary" id="addSecuencia">Agregar</button>
                  </div>
                </div>
                <div class="items_contrato_tmp notop">
                  <table class="display dataTableAction" width="100%" cellspacing="0" id="dataTableAction">
                      <thead>
                        <tr>               
                            <th>Secuencias invalidas</th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($secuencia_invalida as $sec_inv)
                          <tr>
                            <td>{{ $sec_inv->sec_invalida }}</td>
                          </tr>
                        @endforeach  
                    </tbody>       
                  </table>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

        <form id="form-attribute" action="{{ url('secuenciatienda/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
            <div class="row" >
              <div class="panel-group col-md-12" id="accordion">
              @foreach($secuencias as $sec)
                  <div class="panel panel-default col-md-5 col-md-offset-1" style="padding-right: 0px;padding-left: 0px;margin-top:5px;margin-left: 5%;">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$sec->sec_tipo}}">{{ $sec->nombre }}</a>
                      </h4>
                    </div>
                    <div id="collapse{{$sec->sec_tipo}}" class="panel-collapse collapse">
                      <div class="panel-body">

                        <div class="form-group">
                          <label class="col-md-12 col-sm-12 col-xs-12" for="last-name">Secuencia desde<span class="required">*</span></label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" name="sec_desde_{{$sec->sec_tipo}}" id="sec_desde_{{$sec->sec_tipo}}" required="required" class="form-control col-md-7 col-xs-12 numeric" onblur="valMin('sec_desde_{{$sec->sec_tipo}}','sec_hasta_{{$sec->sec_tipo}}','sec_siguiente_{{$sec->sec_tipo}}')" value="{{$sec->sec_desde}}">
                          </div>
                          <label class="col-md-12 col-sm-12 col-xs-12" for="last-name">Secuencia hasta<span class="required">*</span></label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" name="sec_hasta_{{$sec->sec_tipo}}" id="sec_hasta_{{$sec->sec_tipo}}" required="required" class="form-control col-md-7 col-xs-12 numeric" onblur="valMin('sec_desde_{{$sec->sec_tipo}}','sec_hasta_{{$sec->sec_tipo}}','sec_siguiente_{{$sec->sec_tipo}}')" value="{{$sec->sec_hasta}}">
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label class="col-md-12 col-sm-12 col-xs-12" for="last-name">Secuencia actual (Utilizada)<span class="required">*</span></label>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" name="sec_siguiente_{{$sec->sec_tipo}}" id="sec_siguiente_{{$sec->sec_tipo}}" required="required" class="form-control col-md-7 col-xs-12 numeric" onblur="valMin('sec_desde_{{$sec->sec_tipo}}','sec_hasta_{{$sec->sec_tipo}}','sec_siguiente_{{$sec->sec_tipo}}')" value="{{$sec->sec_actual}}">
                          </div>
                          @if($sec->sec_tipo == 3)
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Invalidar secuencias</button>
                          </div>
                          @endif
                          <!-- <label class="col-md-3 col-sm-3 col-xs-12" for="last-name">Fecha fin<span class="required">*</span></label> -->
                          <!-- <div class="col-md-3 col-sm-3 col-xs-12"> -->
                            <!-- <input type="text" name="sec_fecha_{{$sec->sec_tipo}}" required="required" class="form-control col-md-7 col-xs-12" value="{{$sec->fecha_fin}}"> -->
                          <!-- </div> -->
                        </div>  
                        
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
  
            <input type="hidden" name="id" id="id" value="{{$attribute->id_tienda}}">
          <div class="ln_solid"></div>
          <div class="form-group"  style="width:  100%;text-align:  center;">
            <div>
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/secuenciatienda') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
  <script src="{{asset('/js/secuencia.js')}}"></script>
@endpush

@section('javascript')
    @parent

    $('.dataTableAction').DataTable({
      language: 
      {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
        },
    });

    if($("#sede_principal").val() == "1")
    {
      $("#sede_principal").prop('checked', true);
    }
    else
    {
      $("#sede_principal").prop('checked', false);
    }


    
@endsection

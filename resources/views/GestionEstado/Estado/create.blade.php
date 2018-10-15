@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Estados</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('/gestionestado/estado/create') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')  

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tema <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_tema" name="id_tema" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" id="nombre"  class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Motivo <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select multiple="multiple" id="id_motivo" name="id_motivo" required = "required">
              </select>
            </div>
          </div>
      </div> 

          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
            <!--'{{ url('/gestionestado/estado/create') }}'  -->
              <button type="button" class="btn btn-success" id="btn-guardar">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/gestionestado/estado') }}" class="btn btn-danger" type="button">Regresar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/estados.js')}}"></script>
@endpush

@section('javascript')   
  @parent  

  loadSelectInput("#id_motivo","{{ url('/gestionestado/motivo/getselectlist') }}", false);
  $('#id_motivo').multiSelect({
    selectableHeader: "<div class='custom-header'>Motivos Sistema</div>",
    selectionHeader: "<div class='custom-header'>Motivos Asociados</div>",
  });


  loadSelectInput("#id_tema","{{ url('/gestionestado/estado/getselectlist') }}");
  
    URL.setUrl(" {{ url('/gestionestado/estado/create') }}" );
    URL.setRedirec(" {{ url('/gestionestado/estado') }}" );
    $('#btn-guardar').click(function(){
      runAsociaciones();
    });

  @endsection
@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Ciudad</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('/ciudad/create') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')   

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">País <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_pais" name="id_pais" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div>    

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Departamento <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_departamento" name="id_departamento" required="required" class="form-control col-md-7 col-xs-12">
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div> 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" maxLength='30' required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div> 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código DANE <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="codigo_dane" maxLength='5' required="required" class="form-control col-md-7 col-xs-12 justNumbers">
            </div>
          </div> 

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/ciudad') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>

        </form>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/attributes.js')}}"></script>
@endpush

@section('javascript')   
    loadSelectInput("#id_pais","{{ url('/pais/getSelectList') }}")  

    $('#id_pais').change(function(){
      fillSelect('#id_pais','#id_departamento','{{ url('/pais/getSelectListPais') }}');
    });
@endsection

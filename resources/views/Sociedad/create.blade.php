@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Sociedad</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('/sociedad/create') }}" method="POST" class="form-horizontal form-label-left">
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nit <span class="required">*</span></label>   
            <div class="col-md-6 col-sm-6 col-xs-12">               
              <div class="input-group">           
                <input type="text" name="nit" class="form-control nit" maxlength='13' minlength='9' required>
                <span class="input-group-addon white-color"><input id="prueba" name="digito_verificacion" maxlength='1' type="text" class="nit-val justNumbers" required></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código de Sociedad<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" min = "0" max = "99999" title = "No puedes ingresar valores negativos o mayores a 5 digitos." name="codigo_sociedad" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Régimen <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <select id="id_regimen" name="id_regimen" required="required" class="form-control col-md-7 col-xs-12">
              <option value="">- Seleccione una opción -</option>
            </select>
            </div> 
          </div>   

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dirección <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="direccion" required="required" id="direccion" class="form-control col-md-7 col-xs-12 requiered direccion" autocomplete="off">
            </div>
          </div> 
           
          <div class="ln_solid"></div>

          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/sociedad') }}" class="btn btn-danger" type="button">Cancelar</a>
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
    loadSelectInput("#id_pais","{{ url('/pais/getSelectList') }}");
    loadSelectInput("#id_regimen","{{ url('/sociedad/getSelectListRegimen') }}");
@endsection

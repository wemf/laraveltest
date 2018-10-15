@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Realizar Prestamo</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br/>
        <form id="form-attribute" action="{{ url('/tesoreria/prestamos/create') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
          <div class="form-group">
            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Sociedad Prestadora <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input readOnly type="text" name="sociedad_prestadora" id="sociedad_prestadora" required="required" class="form-control col-md-7 col-xs-12" value="{{$sociedad[0]->name}}" >
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Sociedad a Prestar <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select  class="column_filter form-control " name="sociedad_presta" id="sociedad_presta">
                    <option value="">-Seleccione una opción-</option>
                    @foreach($sociedades AS $soc)
                    <option value="{{$soc->id}}">{{$soc->name}}</option>
                    @endforeach
                </select>    
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Tienda a Prestar <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select  class="column_filter form-control " name="id_tienda_presta" id="id_tienda_presta">
                    <option value="">-Seleccione una opción-</option>
                </select>    
            </div>
          </div>

        <div class="form-group">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Valor <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="moneda form-control centrar-derecha requieredsalario st" name="valor" required="required"  id="valor" value="0" maxlength="15" aria-label="Amount (to the nearest dollar)">
                </div>
            </div>
        </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Prestar</button>
              <a href="{{ url('/tesoreria/prestamos') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>

        </form>
      </div>
    </div>
</div>
</div>
@endsection
@section('javascript')   
  $('#sociedad_presta').change(function(){
      fillSelect('#sociedad_presta','#id_tienda_presta','{{ url('/tienda/gettiendabysociedad') }}');
  });
@endsection
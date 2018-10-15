@extends('layouts.master')

@section('content')
<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Secuencias De La Tienda</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('/secuenciatienda/create') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message')      
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código Cliente <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="codigo_cliente" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código Contrato <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="codigo_contrato" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código Plan Separe <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="codigo_plan" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código Bolsa<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="codigo_bolsa" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código Inventario<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="codigo_inventario" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <input type="hidden" name="id" value="{{$id}}">
        </div>
        <div class="form-group">
          <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
            <button type="submit" class="btn btn-success">Guardar</button>
            <button class="btn btn-primary" type="reset">Restablecer</button>
            <a href="{{ url('/secuenciatienda') }}" class="btn btn-danger" type="button">Regresar</a>
          </div>
        </div>
      </form>
        
      </div>
    </div>
</div>
</div>
@endsection

@section('javascript')   


@endsection

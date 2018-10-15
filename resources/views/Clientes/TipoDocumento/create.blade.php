@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Tipo Documento</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('/clientes/tipodocumento/create') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            {{-- @include('FormMotor/message') --}}

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Abreviatura <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="nombre_abreviado" maxlenght = '3' required="required" class="form-control col-md-7 col-xs-12" value="{{old('nombre_abreviado')}}">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" required="required" maxlenght = '20' class="form-control col-md-7 col-xs-12" value="{{old('nombre')}}">
            </div>
          </div> 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código DIAN <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="codigo_dian" required="required" maxlength='8' class="form-control col-md-7 col-xs-12" value="{{old('codigo_dian')}}">
            </div>
          </div>  

          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Alfanumérico<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                <input type="checkbox" id="alfanumerico" name="alfanumerico"   onchange="intercaleCheck(this);"  value="{{old('alfanumerico')}}">
                  <span class="slider"></span>
                </label>
              </div>
          </div>
          
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Requiere dígito verificador<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                <input type="checkbox" id="digito_verificacion" name="digito_verificacion"  onchange="intercaleCheck(this);"  value="{{old('digito_verificacion')}}">
                  <span class="slider"></span>
                </label>
              </div>
          </div>

          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Contrato<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                <input type="checkbox" id="contrato" name="contrato"   onchange="intercaleCheck(this);"  value="{{old('contrato')}}">
                  <span class="slider"></span>
                </label>
              </div>
          </div>

          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Venta<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="switch_check">
                  <input type="checkbox" id="venta" name="venta"   onchange="intercaleCheck(this);"  value="{{old('venta')}}">
                  <span class="slider"></span>
                </label>
              </div>
          </div>

      <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/clientes/tipodocumento') }}" class="btn btn-danger" type="button">Cancelar</a>
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

@extends('layouts.master')

@section('content')

@include('Trasversal.migas_pan.migas')
<div class="row">
<div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Parámetros Generales</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" action="{{ url('parametros/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">País <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre_pais" id="nombre_pais" class="form-control col-md-7 col-xs-12" value="{{ tienda::Configuracion()->pais }}" readonly>
              <input type="hidden" name="id_pais" id="id_pais" value="{{ tienda::Configuracion()->id_pais }}">
              {{-- <select type="text" id="id_pais" name="id_pais" required="required" class="form-control col-md-7 col-xs-12">
                <option>- Seleccione una opción -</option>                
              </select> --}}
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Lenguaje <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="lenguaje" id="lenguaje" class="form-control col-md-7 col-xs-12" value="{{ tienda::Configuracion()->lenguaje }}" readonly>
              <input type="hidden" name="id_lenguaje" id="id_lenguaje" value="{{ tienda::Configuracion()->id_lenguaje }}">
              {{-- <select type="text" id="id_lenguaje" name="id_lenguaje"  class="form-control col-md-7 col-xs-12" >
                <option value="">-- Seleccione una opción --</option>
              </select> --}}
            </div>
          </div>

          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Moneda <span class="required">*</span>
              </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="moneda" id="moneda" class="form-control col-md-7 col-xs-12" value="{{ tienda::Configuracion()->moneda }}" readonly>
              <input type="hidden" name="id_moneda" id="id_moneda" value="{{ tienda::Configuracion()->id_moneda }}">
              {{-- <select type="text" id="id_moneda" name="id_moneda"  class="form-control col-md-7 col-xs-12" >
                <option value="">-- Seleccione una opción --</option>
              </select> --}}
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Abreviatura Moneda <span class="required">*</span>
              </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control" id="av_moneda" name="av_moneda" readonly>
            </div>
          </div>

          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Redondeo <span class="required">*</span>
              </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="numeric5 form-control" required id="redondeo" name="redondeo" maxlength="1">
            </div>
          </div>

          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Decimales <span class="required">*</span>
              </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="numeric5 form-control justNumbers" required id="decimales" name="decimales" maxlength="5">
            </div>
          </div>

          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Precio bolsa <span class="required">*</span>
              </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="numeric5 form-control justNumbers" required id="precio_bolsa" name="precio_bolsa" maxlength="5">
            </div>
          </div>

          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Rete CREE <span class="required">*</span>
              </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="numeric5 form-control justNumbers" required id="retecree" name="retecree" maxlength="5">
            </div>
          </div>

          <input type="hidden" name="id" value="{{$attribute->id}}">
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/parametros') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</div>
@endsection

@section('javascript')
    @parent
    //<script>
    loadSelectInput("#id_pais","{{ url('/pais/getSelectList') }}") ;
    loadSelectInput("#id_lenguaje","{{ url('/parametros/getselectlistlenguaje') }}");
    loadSelectInput("#id_moneda","{{ url('/parametros/getselectlistmoneda') }}");  
    loadSelectInput("#id_medida_peso","{{ url('/parametros/getselectlistmedidapeso') }}");

    $('#id_moneda').change(function(){
      $.ajax({
        url: urlBase.make('parametros/getAbreviatura'),
        type: 'get',
        data: {
          id: $('#id_moneda').val()
        },
        success:function(data){
          $('#av_moneda').val(data.abreviatura);
        }
      })
    })

    $(document).ready(function(){
      $.ajax({
        url: urlBase.make('parametros/getAbreviatura'),
        type: 'get',
        data: {
          id: $('#id_moneda').val()
        },
        success:function(data){
          $('#av_moneda').val(data.abreviatura);
        }
      })
    });

    $('#id_pais').val({{ $attribute->id_pais }});
    $('#id_lenguaje').val({{ $attribute->id_lenguaje }}); 
    $('#id_moneda').val({{ $attribute->id_moneda }}); 
    $('#id_medida_peso').val({{ $attribute->id_medida_peso }}); 
    $('#cantidad_aplazos_contrato').val({{ $attribute->cantidad_aplazos_contrato }}); 
    $('#redondeo').val({{ $attribute->redondeo }}); 
    $('#decimales').val({{ $attribute->decimales }}); 
    $('#retecree').val({{ $attribute->retecree }}); 
    $('#precio_bolsa').val({{ $attribute->precio_bolsa }}); 

    $('.numeric5').each(function(){
        $(this).keyup(function (){
            this.value = (this.value + '').replace(/[^0-5]/g, '');
        });
    });

@endsection

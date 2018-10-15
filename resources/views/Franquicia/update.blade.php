@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')


<div class="row">
<div class="col-md-10 col-md-offset-1">
    <div class="x_panel">
      <div class="x_title">
        <h2>Actualizar Nombre Comercial</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-attribute" class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}  
            @include('FormMotor/message') 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">País <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="id_pais" name="id_pais" required="required" class="form-control col-md-7 col-xs-12" >
                <option value="">- Seleccione una opción -</option>
              </select>
            </div>
          </div> 

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="2" value="{{ $attribute->codigo_franquicia }}" type="text" id="codigo_franquicia" name="codigo_franquicia" required="required" class="form-control col-md-7 col-xs-12 justNumbers">
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="40" value="{{ $attribute->nombre }}" type="text" id="nombre" name="nombre" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Logo</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" id="logo" name="logo" class="form-control col-md-7 col-xs-12">
              <input type="hidden" id="id_logo" name="id_logo" value="{{ $attribute->id_logo }}">
              @if($attribute->ruta_logo)
                <div>
                  <img src="{{ env('RUTA_ARCHIVO_OP').'colombia/nombre_comercial/'.$attribute->logo }}" alt="{{ $attribute->logo }}" width="40%">
                  <label>{{ $attribute->logo }}</label>
                </div>
              @endif  
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Linea de Atención</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="15" type="text" value="{{ $attribute->linea_atencion }}" id="linea_atencion" name="linea_atencion" class="form-control col-md-7 col-xs-12 justNumbers">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Correo Electronico HABEAS DATA</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="40" type="email" value="{{ $attribute->correo_habeas }}" id="correo_habeas" name="correo_habeas" class="form-control col-md-7 col-xs-12 correo">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Correo Electronico de Pedidos</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="40" type="email" value="{{ $attribute->correo_pedidos }}" id="correo_pedidos" name="correo_pedidos" class="form-control col-md-7 col-xs-12 correo">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Correo Electronico de Denuncias</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="40" type="email" value="{{ $attribute->correo_denuncias }}" id="correo_denuncia" name="correo_denuncia" class="form-control col-md-7 col-xs-12 correo">
            </div>
          </div>

          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Página WEB</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="50" type="text" value="{{ $attribute->pagina_web }}" id="pagina_web" name="pagina_web" class="form-control col-md-7 col-xs-12 ">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Whatsapp</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="10" type="text" value="{{ $attribute->whatsapp }}" id="whatsapp" name="whatsapp" class="form-control col-md-7 col-xs-12 justNumbers"> </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Facebook</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="50" type="text" value="{{ $attribute->facebook }}" id="facebook" name="facebook" class="form-control col-md-7 col-xs-12"> </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Instagram</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="50" type="text" value="{{ $attribute->instagram }}" id="instagram" name="instagram" class="form-control col-md-7 col-xs-12"> </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Otros</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="50" type="text" value="{{ $attribute->otros1 }}" id="otro1" name="otro1" class="form-control col-md-7 col-xs-12"> </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Otros</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="50" type="text" value="{{ $attribute->otros2 }}" id="otro2" name="otro2" class="form-control col-md-7 col-xs-12"> </div>
          </div>
          
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sociedades <span class="required">*</span>
          </label>
           <div class="col-md-6 col-sm-6 col-xs-12 multiselec">
            <select multiple="multiple" id="id_sociedad" name="id_sociedad" required="required" class="form-control col-md-7 col-xs-12 requiered">
            </select>
           </div>
        </div>

          <input type="hidden" id="id" name="id" value="{{$attribute->id}}">
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
              <button id="btn-guardar" type="submit" class="btn btn-success" onclick="valSociedades()">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/franquicia') }}" class="btn btn-danger" type="button">Cancelar</a>
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
    
    loadSelectInput("#id_pais","{{ url('/pais/getSelectList') }}")  
    $('#id_pais').val({{ $attribute->id_pais }});
    
    fillSelect('#id_pais','#id_sociedad','{{ url('/sociedad/getSelectListSociedadesPais') }}',false);
    URL.setUrl(" {{ url('/franquicia/sociedadesdefranquicia') }}" );
    runMotivosEstado('#id_sociedad');

    $('#id_pais').change(function(){
      fillSelect('#id_pais','#id_sociedad','{{ url('/sociedad/getSelectListSociedadesPais') }}',false);
      URL.setUrl(" {{ url('/franquicia/sociedadesdefranquicia') }}" );
      runMotivosEstado('#id_sociedad');
      $('#id_sociedad').multiSelect('refresh'); 
    });

    $('#id_sociedad').multiSelect({
      selectableHeader: "<div class='custom-header'>Sociedades Sistema</div>",
      selectionHeader: "<div class='custom-header'>Sociedades Asociadas</div>",
    });

    //Vamo a guardar
      URL.setUrl(" {{ url('/franquicia/update') }}" );
      URL.setRedirec("{{ url('/franquicia') }}" );

@endsection

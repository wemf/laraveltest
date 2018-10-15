@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-10 col-md-offset-1">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ingresar Nombre Comercial</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content" id="cont_fran">
        <br />
        <form id="form-attributex" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="2" type="text" id="codigo_franquicia" name="codigo_franquicia" required="required" class="form-control col-md-7 col-xs-12 justNumbers">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="25" type="text" id="nombre" name="nombre" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Logo</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" id="logo" name="logo" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Linea de Atención</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="15" type="text" id="linea_atencion" name="linea_atencion" class="form-control col-md-7 col-xs-12 justNumbers">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Correo Electronico HABEAS DATA</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="40" type="email" id="correo_habeas" name="correo_habeas" class="form-control col-md-7 col-xs-12 ">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Correo Electronico de Pedidos</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="40" type="email" id="correo_pedidos" name="correo_pedidos" class="form-control col-md-7 col-xs-12 ">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Correo Electronico de Denuncias</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="40" type="email" id="correo_denuncia" name="correo_denuncia" class="form-control col-md-7 col-xs-12 ">
            </div>
          </div>

          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Página WEB</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="50" type="text" id="pagina_web" name="pagina_web" class="form-control col-md-7 col-xs-12 ">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Whatsapp</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="10" type="text" id="whatsapp" name="whatsapp" class="form-control col-md-7 col-xs-12 justNumbers"> </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Facebook</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="50" type="text" id="facebook" name="facebook" class="form-control col-md-7 col-xs-12"> </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Instagram</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="50" type="text" id="instagram" name="instagram" class="form-control col-md-7 col-xs-12"> </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Otro</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="50" type="text" id="otro1" name="otro1" class="form-control col-md-7 col-xs-12"> </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Otro</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input maxlength="50" type="text" id="otro2" name="otro2" class="form-control col-md-7 col-xs-12"> </div>
          </div>
          

        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sociedades <span class="required">*</span>
          </label>
           <div class="col-md-6 col-sm-6 col-xs-12 multiselec">
            <select multiple="multiple" id="id_sociedad" name="id_sociedad" required="required" class="form-control col-md-7 col-xs-12 requiered">
            </select>
           </div>
        </div>
  
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
              <button id="btn-guardar" name="btn-guardar" type="submit" class="btn btn-success" onclick="valSociedades()">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('/franquicia') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>

        </form>
      </div>
    </div>
</div>
</div>

<div id="res"></div>
@endsection

@push('scripts')
  <script src="{{asset('/js/estados.js')}}"></script>
@endpush

@section('javascript')   
  loadSelectInput("#id_pais","{{ url('/pais/getSelectList') }}")

  $('#id_pais').change(function(){
      fillSelect('#id_pais','#id_sociedad','{{ url('/sociedad/getSelectListSociedadesPais') }}',false);
      $('#id_sociedad').multiSelect('refresh');
  });

    $('#id_sociedad').multiSelect({
      selectableHeader: "<div class='custom-header'>Sociedades Sistema</div>",
      selectionHeader: "<div class='custom-header'>Sociedades Asociadas</div>",
    });

    //Vamo a guardar
    URL.setUrl(" {{ url('/franquicia/create') }}" );
    URL.setRedirec("{{ url('/franquicia') }}" );

@endsection

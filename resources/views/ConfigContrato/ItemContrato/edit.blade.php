@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="row">
<div class="col-md-8 col-md-offset-2">
    <div class="x_panel">
      <div class="x_title">
        <h2>Editar Configuración de Ítems para Contrato</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="form-diagracia" action="{{ url('configcontrato/itemcontrato/update') }}" method="POST" class="form-horizontal form-label-left">
            {{ csrf_field() }}  
            @include('FormMotor/message') 

           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Categoría <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="categoria" id="categoria" data-load="@if(isset($itemcontrato)){{ $itemcontrato->id_categoria_general }}@endif" onchange="loadAttributes('{{ url('/products/categories/getAttributeCategoryById') }}');" class="form-control col-md-7 col-xs-12 hide" required>
                  <option value="0" selected> - Seleccione una opción - </option>
              </select>
              <input type="text" readonly value="@if(isset($itemcontrato)){{ $itemcontrato->nombre_categoria }}@endif" class="form-control col-md-7 col-xs-12" >
            </div>
          </div>

          <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre <span class="required red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nombre" id="nombre" value="@if(isset($itemcontrato)){{ $itemcontrato->nombre }}@endif" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div> -->

          <div class="form-group">
            <div class=" col-md-1 col-md-offset-1 col-sm-2 col-xs-2">
            
              <div class="col-md-9" align="right">
                <i class="fa fa-long-arrow-up" style="text-align: right; margin-top: 40px; font-size: 20px;"></i>
                <i class="fa fa-hand-paper-o" style="text-align: right; margin-top: 10px; font-size: 20px; display:block;"></i>
                <i class="fa fa-long-arrow-down" style="text-align: right; margin-top: 10px; font-size: 20px;"></i>
              </div>
            </div>
            <div class=" col-md-9 col-sm-6 col-xs-12 conf-itm-contr">
              <br>
              <div class="col-md-8">
                Atributo
              </div>
              <div class="col-md-2">
                Requerido
              </div>
              <div class="col-md-2">
                Posición
              </div>
              <br><br>
              <ul id="atributos" class="no-list-style"></ul>
            </div>
          </div>




          
          
          <input type="hidden" name="id" id="id" value="@if(isset($itemcontrato)){{$itemcontrato->id}}@endif">

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
             <button type="button" onclick="updateItem('{{ url('configcontrato/itemcontrato/update') }}');" class="btn btn-success">Guardar</button>
              <button class="btn btn-primary" type="reset">Restablecer</button>
              <a href="{{ url('configcontrato/itemcontrato') }}" class="btn btn-danger" type="button">Cancelar</a>
            </div>
          </div>

        </form>
      </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="{{asset('/js/configcontrato/configcontrato.js')}}"></script>
    <script src="{{asset('/js/configcontrato/itemcontrato.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush

@section('javascript')
    @parent
    URL.setUrlGetCategoria("{{ url('/products/categories/getCategory') }}");
    URL.setUrlGetZona("{{ url('/pais/getpais') }}");
    URL.setUrlGetTiendaByZona("{{ url('/tienda/gettiendabyzona') }}");
    URL.setUrlList("{{ url('/configcontrato/itemcontrato') }}");
    runItemContratoForm();
    $('#categoria').change();
    getAttributes('{{ url('/configcontrato/itemcontrato/getatributos') }}');

    $("#updateAction2").click(function() 
    {
      var url2="{{ url('/products/attributes/store') }}";
      updateRowDatatableAction(url2)
    });

    $( function() {
      $( "#atributos" ).sortable({
        placeholder: "ui-state-highlight"
      });
      $( "#atributos" ).disableSelection();
    } );
@endsection

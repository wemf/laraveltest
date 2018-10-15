@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Trazabilidad de los Ids</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('Inventario.Trazabilidad.filtros')
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
          <tr>            
              <th>Joyer&iacute;a</th>
              <th>Id</th>
              <th>Id Origen</th>
              <th>Movimiento</th>
              <th>Fecha Ingreso</th>
              <th>Fecha Salida</th>
              <th>Ubicaci&oacute;n</th>
              <th>Categor&iacute;a</th>
              <th>Motivo</th>
              <th>Estado</th>
              <th>Nro. Contrato</th>
              <th>Nro. &Iacute;tem</th>
              <!--<th>Nro. Orden</th>-->
              <th>Nro. Orden/ Nro. Compra/ Nro. Plan Separe/ Nro. Factura/ Nro. Traslado</th>
              <th>Usuario</th>
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@push('scripts')
  <script src="{{asset('/js/Inventario/Trazabilidad/index.js')}}"></script>
@endpush
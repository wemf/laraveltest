@extends('layouts.master')

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
  <div class="x_title">
    <h2>Inventario</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    @include('Inventario.botones', ['href' => '/inventario/nuevo'])   
    @include('Inventario.filtros')
    <table id="dataTableAction" class="display" width="100%" cellspacing="0">
        <thead>
          <tr>            
              <th>Tienda</th> 
              <th>ID</th>  
              <th>Lote</th>  
              <th>Categoria</th>  
              <th>Referencia</th> 
              <th>Estado Producto</th> 
              <th>Fecha Ingreso</th>  
              <th>Fecha Salida</th>   
              <th>Precio Venta</th>  
              <th>Precio Compra</th>  
              <th>Costo Total</th>  
              <th>Cantidad</th> 
              <th>Peso</th> 
              <th>Estado</th>  
              <th>Motivo</th>  
          </tr>
      </thead>        
    </table>
  </div>
</div>

@endsection

@push('scripts')
  <script src="{{asset('/js/Inventario/index.js')}}"></script>
@endpush
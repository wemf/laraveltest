@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
        <h2>Generar pedido</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <form action="{{ url('pedidos/updatePost') }}" method="post" class="form-horizontal form-label-left">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Número de orden</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input maxlength="25" type="text" id="numero_orden" name="numero_orden" readonly class="form-control col-md-7 col-xs-12" value="{{ $data[0]->id_pedido }}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fecha</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input maxlength="25" type="text" id="fecha" name="fecha" readonly class="form-control col-md-7 col-xs-12" value="{{ $data[0]->fecha_creacion }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Categoría</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input maxlength="25" type="text" id="categoria" name="categoria" readonly class="form-control col-md-7 col-xs-12" value="{{ $data[0]->categoria }}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Estado</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input maxlength="25" type="text" id="estado" name="estado" readonly class="form-control col-md-7 col-xs-12" value="{{ $data[0]->estado }}">
                    </div>
                </div>
            </div>

            <div class="items_pedidosx_tmp">
            
                <table class="display dataTableAction" width="100%" cellspacing="0" id="dataTableAction">
                    <thead>
                        <tr>
                            <th>Tienda      </th>
                            <th>Referencia</th>
                            <th>Descripción                 </th>
                            <th>Precio por unidad</th>
                            <th>Unidades</th>
                            <th>Recibidas</th>
                            <th>Pendientes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $d)
                            <tr>
                                <td>{{ $d->tienda }}</td>
                                <td>{{ $d->referencia }}</td>
                                <td>{{ $d->descripcion }}</td>
                                <td><input type="text" name="precio[]" id="precio[]" value="{{ $d->precio }}" class="form-control"></td>
                                <td><input type="text" name="unidades[]" id="unidades[]" value="{{ $d->unidades }}" class="form-control">
                                    <input type="hidden" id="id_referencia[]" name="id_referencia[]" value="{{ $d->id_referencia }}">
                                </td>
                                <td><input type="text" name="recibidas[]" id="precio[]" @if($data[0]->id_estado == 98) readonly @endif value="{{ $d->recibidas }}" class="form-control"></td>
                                <td><input type="text" name="pendientes[]" id="precio[]" @if($data[0]->id_estado == 98) readonly @endif  value="{{ $d->pendientes }}" class="form-control"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
             <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
                    <input type="button" id="regresar"  value="Regresar" class="btn btn-danger">
                    <input type="hidden" id="id_tienda" name="id_tienda" value="{{ $data[0]->id_tienda }}">
                    <input type="hidden" id="id_pedidos" name="id_pedidos" value="{{ $data[0]->id_pedido }}">
                    <input type="hidden" id="id_tienda_pedido" name="id_tienda_pedidon" value="{{ $id_tienda_pedido }}">
                    @if($data[0]->id_estado == 98)
                        <input type="submit" id="guardar_borrador" name="guardar_borrador" value="Guardar borrador" class="btn btn-primary">
                        <input type="submit" id="generar_pedido" name="generar_pedido" value="Generar pedido" class="btn btn-success">
                    @else
                        <input type="submit" id="guardar" name="guardar" value="Guardar" class="btn btn-success">
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('javascript')
    @parent
    //<script>
    $('.dataTableAction').DataTable({
      language: 
      {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
        },
    });

    $('#regresar').click(function(){
        window.location = urlBase.make('pedidos');
    });

@endsection
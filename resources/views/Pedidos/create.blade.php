@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
        <h2>Generar pedido</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <form action="{{ url('pedidos/create') }}" method="post" class="form-horizontal form-label-left">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Número de orden</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input maxlength="25" type="text" id="numero_orden" name="numero_orden" readonly class="form-control col-md-7 col-xs-12" value="{{ $numero_orden }}">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fecha</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input maxlength="25" type="text" id="fecha" name="fecha" readonly class="form-control col-md-7 col-xs-12" value="{{ Carbon\Carbon::now() }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Zona</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input maxlength="25" type="text" id="zona" name="zona" readonly class="form-control col-md-7 col-xs-12" value="">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Categoría</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input maxlength="25" type="text" id="categoria" name="categoria" readonly class="form-control col-md-7 col-xs-12" value="">
                    </div>
                </div>
            </div>

            <div class="items_contrato_tmp">
            
                <table class="display dataTableAction" width="100%" cellspacing="0" id="dataTableAction">
                    <thead>
                        <tr>
                            <th>Tienda</th>
                            <th>Referencia</th>
                            <th>Descripción</th>
                            <th>Inventario</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0;$i < count($data); $i++)
                            <tr>
                                <th>{{ $data[$i]['tienda'] }}</th>
                                <th>{{ $data[$i]['referencia'] }}</th>
                                <th>{{ $data[$i]['descripcion'] }}</th>
                                <th>{{ $data[$i]['inventario'] }}</th>
                                <th>
                                    <input type="text" name="cantidad[]">
                                    <input type="text" name="pos[]" value="{{ $data[$i]['pos'] }}">
                                </th>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
             <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
                    <input type="submit" name="guardar" value="Guardar borrador" class="btn btn-success">
                    <input type="submit" name="generar" value="Generar pedido" class="btn btn-primary">
                    <input type="button"  value="Cancelar" class="btn btn-danger">
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('javascript')
    @parent

    $('.dataTableAction').DataTable({
      language: 
      {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
        },
    });

@endsection
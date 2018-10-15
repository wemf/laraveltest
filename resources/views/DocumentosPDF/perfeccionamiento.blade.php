<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <style>
            *{
                margin: 0;
                padding: 0;
                font-family: Arial;
                font-family: arial;
                text-transform: uppercase;
            }

            .logo{
                width: 100px;
            }

            .documento-pdf{
                width: 100%;
                box-sizing: border-box;
                font-family: Arial;
                padding: 10px 30px 30px 30px;
            }

            .documento-pdf h4{
                font-size: 10px;
            }

            .documento-pdf h5{
                font-size: 8px;
            }

            .documento-pdf p{
                font-size: 9px;
            }

            .red{
                color: red;
            }
            .align-right{
                text-align: right;
            }
            .align-center{
                text-align: center;
            }

            .header .table{
                width: 100%;
                table-layout: fixed;
            }

            .footer .table{
                width: 90%;
                margin: auto;
                table-layout: fixed;
                border-collapse: separate;
                border-spacing: 40px;
            }

            .footer .table td{
                border-top: 1px solid #000;
            }

            .content{
                margin-top: 20px;
            }
            .content .table{
                width: 100%;
                font-size: 0;
                border-collapse: separate;
                border-spacing: 0;
            }

            .content .table th{
                color: #fff;
                font-size: 6px;
                padding: 5px;
                border-right: 1px solid #444;
                border-top: 1px solid #444;
                border-bottom: 1px solid #444;
                font-weight: 500;
                background: #2f75b5;
            }
            .content .table td{
                color: #000;
                font-size: 6px;
                padding: 5px;
                border-right: 1px solid #444;
                border-bottom: 1px solid #444;
                font-weight: 500;
            }

            .content .table th:nth-child(1), .content .table td:nth-child(1){
                border-left: 1px solid #444;
            }

            .right{
                text-align: right;
            }

            .table-header{
                border: 1px solid #ccc;
                padding: 5px;
                border-radius: 10px;
            }
        </style>
    </head>
    <body>
        <input type="hidden" value="{{ $count = 0 }}" />
        <input type="hidden" value="{{ $total_peso_total = 0 }}" />
        <input type="hidden" value="{{ $total_peso_estimado = 0 }}" />
        <input type="hidden" value="{{ $total_precio_contrato = 0 }}" />
        <input type="hidden" value="{{ $total_items = 0 }}" />
        @foreach ($object as $orden)
            @if(isset($orden[0]))
            <div class="documento-pdf">
                <div class="header align-center">
                    <img class="logo" src="images/oroexpress.png" />
                    <br>
                    <br>
                    <p>{{ $orden[0]->nombre_tienda }}</p>
                    <p>{{ $orden[0]->direccion_tienda }} - {{ $orden[0]->ciudad_tienda }} - {{ $orden[0]->telefono_tienda }}</p>
                    <p>{{ $orden[0]->nit_sociedad }} - {{ $orden[0]->nombre_sociedad }} - {{ $orden[0]->nombre_regimen }}</p>
                    <br>
                    <h4><strong>Perfeccionamiento de contratos vencidos</strong></h4>
                    <br>
                    <h4 class="align-right" align="right"><div style="border: 1px solid #000; border-radius: 4px; padding: 3px; max-width: 90px; float: right;" class="align-right">N° {{ $orden[0]->id_orden_perfeccionamiento }}</div> <br><br><br>HOJA {{ ++$count }} DE {{ count($object) }}</h4>
                    <br>
                    <table class="align-center table table-header">
                        <tbody>
                            <tr>
                                <td align="left"><h5>FECHA:</h5></td>
                                <td align="left"><h5><span>{{ date('d-m-Y', strtotime($orden[0]->fecha_creacion_perfeccionamiento)) }}</span></h5></td>
                                <td align="left"><h5>CATEGORÍA:</h5></td>
                                <td align="left"><h5><span>{{ $orden[0]->categoria_general }}</span></h5></td>
                                @if($orden[0]->control_peso_contrato == 1)
                                <td align="left"><h5>PESOS TOTALES:</h5></td>
                                <td align="left"><h5><span>{{ $orden[0]->peso_total_total }}</span></h5></td>
                                @endif
                            </tr>
                            <tr>
                                <td align="left"><h5>OBSERVACIÓN:</h5></td>
                                <td align="left" colspan="3"><h5><span></span></h5></td>
                                @if($orden[0]->control_peso_contrato == 1)
                                <td align="left"><h5>PESOS ESTIMADOS:</h5></td>
                                <td align="left"><h5><span>{{ $orden[0]->peso_estimado_total }}</span></h5></td>
                                @endif
                            </tr>
                            <tr>
                                <td align="left" colspan="4"><h5><span></span></h5></td>
                                <td align="left"><h5>VALOR DE CONTRATOS:</h5></td>
                                <td align="left"><h5><span>{{ $orden[0]->valor_contratos }}</span></h5></td>
                            </tr>
                            <tr>
                                <td align="left" colspan="4"><h5><span></span></h5></td>
                                <td align="left"><h5>CANTIDAD DE CONTRATOS:</h5></td>
                                <td align="left"><h5><span>{{ count($codigos_contratos) }}</span></h5></td>
                            </tr>
                            <tr>
                                <td align="left" colspan="4"><h5><span></span></h5></td>
                                <td align="left"><h5>CANTIDAD DE ITEM:</h5></td>
                                <td align="left"><h5><span>{{ count($orden) }}</span></h5></td>
                            </tr>
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="content">
                    <table class="table" colspan="0px">
                        <thead>
                            <tr>
                                <th>N° CONTRATO</th>
                                <th>FECHA DE CONTRATO</th>
                                <th>FECHA DE PERFECCIONAMIENTO</th>
                                <th>ID</th>
                                @foreach($columnas_items as $columna_item)
                                <th>{{ str_replace(' ', ' ', $columna_item->nombre) }}   </th>
                                @endforeach
                                <th>DETALLE</th>
                                @if($orden[0]->control_peso_contrato == 1)
                                <th>PESO TOTAL</th>
                                <th>PESO ESTIMADO</th>
                                @endif
                                <th>VALOR COMPRA ID</th>
                                <th>VALOR DEL CONTRATO</th>
                                @if($orden[0]->control_peso_contrato == 1)
                                <th>CÓDIGO BOLSA DE SEGURIDAD</th>
                                <th>PROMEDIO DE CONTRATACIÓN</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($orden); $i++)
                                <tr>
                                    <td>
                                        <input type="hidden" value="{{ $total_peso_total += $orden[$i]->peso_total_noformat }}" />
                                        <input type="hidden" value="{{ $total_peso_estimado += $orden[$i]->peso_estimado_noformat }}" />
                                        <input type="hidden" value="{{ $total_precio_contrato += $orden[$i]->valor_item_noformat }}" />
                                        <input type="hidden" value="{{ ++$total_items }}" />
                                        {{ $orden[$i]->numero_contrato }}
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($orden[$i]->fecha_ingreso)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($orden[$i]->fecha_creacion_perfeccionamiento)) }}</td>
                                    <td>{{ $orden[$i]->numero_id }}</td>
                                    @for($j = 0; $j < count($columnas_items); $j++)
                                        <input type="hidden" value="{{ $col_print = 0 }}" />
                                        @for($k = 0; $k < count($datos_columnas_items); $k++)
                                            @if($columnas_items[$j]->nombre == $datos_columnas_items[$k]->atributo && $datos_columnas_items[$k]->linea_item == $orden[$i]->id_linea_item)
                                            <td>{{$datos_columnas_items[$k]->valor}} <input type="hidden" value="{{ $col_print = 1 }}" /></td>
                                            @endif
                                        @endfor
                                        @if($col_print == 0)
                                            <td></td>
                                        @endif
                                    @endfor
                                    <td>{{ $orden[$i]->detalle }}</td>
                                    @if($orden[0]->control_peso_contrato == 1)
                                    <td align="right">{{ $orden[$i]->peso_total }}</td>
                                    <td align="right">{{ $orden[$i]->peso_estimado }}</td>
                                    @endif
                                    <td align="right">{{ $orden[$i]->valor_item }}</td>
                                    <td align="right">{{ $orden[$i]->valor_contrato }}</td>
                                    @if($orden[0]->control_peso_contrato == 1)
                                    <td>{{ $orden[$i]->codigos_bolsas }}</td>
                                    <td align="right">{{ $orden[$i]->valor_promedio }}</td>
                                    @endif
                                </tr>
                            @endfor
                        </tbody>
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                @foreach($columnas_items as $columna_item)
                                <th></th>
                                @endforeach
                                <th>TOTALES</th>
                                @if($orden[0]->control_peso_contrato == 1)
                                <th align="right">{{ $orden[0]->peso_total_total }}</th>
                                <th align="right">{{ $orden[0]->peso_estimado_total }}</th>
                                @endif
                                <th align="right">{{ $orden[0]->valor_contratos }}</th>
                                <th align="right">{{ $orden[0]->valor_contratos }}</th>
                                @if($orden[0]->control_peso_contrato == 1)
                                <th></th>
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
                <br><br>
                <div class="footer">
                    <table class="align-center table">
                        <tbody>
                            <tr>
                                <td><h5>FIRMA JEFE DE ZONA</h5></td>
                                <td><h5>ADMINISTRADOR</h5></td>
                                <td><h5>REVISOR</h5></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="right">
                    <h5>USUARIO: <span>{{ $user }}</span> - FECHA IMPRESIÓN: <span>{{ $date }}</span></h5>
                </div>
            </div>
            @else
              <h3 style="padding: 10px; box-sizing: border-box;">Ocurrió un problema tratando de encontrar los datos de la orden</h3>
            @endif
            <br></br></br>
        @endforeach
    </body>
</html>
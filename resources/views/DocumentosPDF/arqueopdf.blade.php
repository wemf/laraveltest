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
        }

        .logo{
            width: 320px;
        }

        .oroexpressfooter{
            width: 100%;
        }

        .documento-pdf{
            width: 100%;
            box-sizing: border-box;
            font-family: Arial;
            padding: 10px 30px 30px 30px;
        }

        .red{
            color: red;
        }

        .bold{
            font-weight: bold;
        }

        .all-border{
            border: 2px solid #000;
        }

        .back-yellow{
            background-color: yellow;
        }

        .back-blue{
            background-color: #9bc2e6;
        }

        .border-top{
            border-top: 1px solid #000;
        }

        .align-right{
            text-align: right;
        }
        .align-center{
            text-align: center;
        }

        .huella{
            width: 70px;
            height: 90px;
            border: 2px solid #000;
            margin-left: 20px;
        }

        .firma{
            width: 400px;
        }

        .inline-block{
            display: inline-block;
        }
        
        .table{
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 40px 5px;
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
        </style>
    </head>
    <body>
        <input type="hidden" value="0" />
        <input type="hidden" value="0" />
        <input type="hidden" value="0" />
        <input type="hidden" value="0" />
            <div class="documento-pdf">
            <table class="align-center table">
                <tbody>
                    <tr>
                        <td></td>
                        <td>
                        <img class="logo" src="{{ asset('images/oroexpress.png') }}" />
                        <h2>{{$object["franquicia"]}}</h2>
                        </td>
                        <td class="bold"><h2>COMPROBANTE DE ARQUEO DE CAJA 1</h2></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><h5>{{$object["tienda"]}}</h5></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><h5>{{ $object['info_tienda']}}</h5></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><h5>{{ $object['sociedad'] }} - {{ $object['regimen'] }}</h5></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="left" class="bold"><h5>Fecha y Hora: {{ $object['fecha'] }}</h5></td>
                        <td align="left" class="bold"><h5>Usuario: {{ $usuario }}</h5></td>
                        <td class="bold"><h6>HOJA 1 DE 1</h6></td>
                    </tr>
                </tbody>
                </table>
                </div>
                <div class='content'>
                <table class="align-center table">
                <thead>
                   <tr> 
                    <th><h2>Saldos del Sistema</h2></th>
                   </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <table class="align-center table">
                                <thead>
                                    <tr>
                                       <td>Fecha y Hora Saldo Inicial </td>
                                       <td>Saldo Inicial</td>
                                       <td>Ingresos</td>
                                       <td>Egresos</td>
                                       <td>Total Sistema </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr> 
                                        <td>{{$object['fecha_saldo_inicial']}}</td>
                                        <td>{{$object['saldo_inicial']}}</td>
                                        <td>{{$object['ingresos']}}</td>
                                        <td>{{$object['egresos']}}</td>
                                        <td>{{$object['total_sistema']}}</td>   
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>
                <br>
                <table class="align-center table">
                <thead>
                   <tr> 
                    <th><h2>CONTEO DEL EFECTIVO DE CAJA MEJOR</h2></th>
                   </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <table class="align-center table">
                                <thead>
                                    <tr>
                                       <td> VALORES EN CAJA MENOR</td>
                                       <td> VALORES EN CAJA FUERTE</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr> 
                                        <td>
                                            <table class="align-center table">
                                                <thead>
                                                    <tr>
                                                        <td>DENOMINACIÓN DE BILLETE O MONEDA</td>
                                                        <td>CANTIDAD</td>
                                                        <td>TOTAL</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for($i = 0; $i < count($object['valormenor']); $i++ ) )                                                                                                  
                                                        <tr>
                                                            <td>{{ $object['valormenor'][$i] }}</td>
                                                            <td>{{ $object['cantidadmenor'][$i] }}</td>
                                                            <td>{{ $object['totalmenor'][$i] }}</td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="align-center table">
                                                <thead>
                                                    <tr>
                                                        <td>DENOMINACIÓN DE BILLETE O MONEDA</td>
                                                        <td>CANTIDAD</td>
                                                        <td>TOTAL</td>
                                                    </tr>
                                                </thead>
                                                <tbody>    
                                                    @for($i = 0; $i < count($object['valorfuerte']); $i++ ) )                                              
                                                        <tr>
                                                            <td>{{ $object['valorfuerte'][$i] }}</td>
                                                            <td>{{ $object['cantidadfuerte'][$i] }}</td>
                                                            <td>{{ $object['totalfuerte'][$i] }}</td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>
                <br>
                <table class="align-center table">
                <thead>
                   <tr> 
                    <th><h2>SALDO DE ARQUEO</h2></th>
                   </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <table class="align-center table">
                                <thead>
                                    <tr>
                                       <td>TOTAL CAJA MENOR (Billetes y Monedas)</td>
                                       <td>TOTAL CAJA FUERTE (Billetes y Monedas)</td>
                                       <td>TOTAL FISICO</td>
                                       <td>TOTAL SISTEMA</td>
                                       <td>SOBRANTE</td>
                                       <td>FALTANTE</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr> 
                                        <td>{{$object['totalcajamenor']}}</td>
                                        <td>{{$object['totalcajafuerte']}}</td>
                                        <td>{{$object['totalfisico']}}</td>
                                        <td>{{$object['total_sistema']}}</td>
                                        <td>{{$object['sobrante']}}</td>   
                                        <td>{{$object['faltante']}}</td>   
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>
                <br>
                <table class="align-center table">
                    <thead>
                        <tr>
                            <td> <h2 class ='bold'>OBSERVACIONES DE LAS NOVEDADES PRESENTADAS </h2></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><p>{{$object['observaciones']}}</p></td>
                        </tr>
                    </tbody>
                </table>
                </table>
                </div>
                <div class="footer">
                    <table class="align-center table">
                        <tbody>
                            <tr>
                                <td><h5>FIRMA JEFE DE ZONA</h5></td>
                                <td><h5>ADMINISTRADOR DE TIENDA</h5></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="right">
                    <h5>USUARIO: <span class="red">{{ $usuario }}</span> - FECHA IMPRESIÓN: <span class="red">{{ $object['fecha'] }}</span></h5>
                </div>
                <div style="page-break-after:always;"></div>
            </div>
            <br></br></br>
    </body>
</html>
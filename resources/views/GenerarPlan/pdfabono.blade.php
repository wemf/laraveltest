<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDFAbono</title>
    <style>
        *{ 
            margin: 0; 
            padding: 0; 
            font-family: Arial; 
            font-size: 10px;
        }
        .content{ 
            width:100%; 
        }
        .cont{ 
            border: 1px solid; 
            display: inline-block; 
            width:96%; 
        }
        .logo{ 
            width: 100%; 
            height: 50px;
        }
        .table{ 
            width: 95%; 
            table-layout: fixed; 
            border-collapse: separate;
            margin: 0px 0px 1px 10px; 
            padding: 2px;
        }
        .thead{ 
            text-align: center; 
        }
        .border{ 
            border-style: dashed; 
            border-width: 1px; 
            border-color: #000; 
        }
        .espacio{
            height: 30px;
            border-bottom: 1px solid #000;

        }

        .border_bottom{
            border-bottom: 1px solid #000;
            position: relative;
        }

        .border_bottom p, .border_bottom span{
            display: inline-block;
        }
        .border_bottom span{
            min-width: 100px;
        }

        .border_bottom p{
            bottom: -2px;
            background-color: #fff;
            position: relative;
        }
        .justify{
            text-align: justify;
        }
        img.logofooter {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="content">
        <table width="100%">
        <tr>
        @for($i = 0; $i < 3; $i++)
        <td>
            <div class="cont">
                <table class="table">
                    <tbody class="thead">
                        <tr><td><img class="logo" src="{{ asset('images/oroexpress.png') }}" /></td></tr> 
                        <tr><td>{{ $tienda->nombre }}</td></tr>
                        <tr><td>{{ $tienda->direccion }} - {{ $tienda->nombre_ciudad }} - {{ $tienda->telefono }}</td></tr>
                        <tr><td>{{ $tienda->nit }} - {{ $tienda->nombre_sociedad }} {{ $tienda->nombre_regimen }}</td></tr>
                    </tbody>
                </table>
                
                <table class="table border">
                    <caption>PAGO CUOTA PLAN SEPARE</caption>
                    <tbody>
                        <tr>
                            <td class="border_bottom"><p>N° Plan Separe: </p><span>{{ $codigo_plan }}</span></td>
                            <td class="border_bottom"><p>N° Pago: </p><span>{{ $codigo_abono }}</span></td>
                        </tr>
                        <tr>
                            <td class="border_bottom"><p>Fecha de pago: </p><span>{{ $fecha }}</span></td>
                            <td class="border_bottom"><p>Valor de Pago: </p><span>{{ $pago }}</span></td>
                        </tr>
                        @if($fecha_entrega != "")
                        <tr>
                            <td class="border_bottom"><p>Fecha de entrega: </p><span>{{ $fecha_entrega->fecha_entrega }}</span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <table class="table border">
                    <tbody>
                        <tr>
                            <td colspan="2">DATOS DEL CLIENTE</td>
                        </tr>
                        <tr>
                            <td class="border_bottom"><p>NIT/CC: </p><span>{{ number_format($info_cliente->numero_documento,0,",",'.') }}</span></td>
                            <td class="border_bottom"><p>Lugar de exp: </p><span>{{ $info_cliente->ciudad_expedicion }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border_bottom"><p>Nombre: </p><span>{{ $info_cliente->nombres }} {{ $info_cliente->primer_apellido }} {{ $info_cliente->segundo_apellido }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border_bottom"><p>Dirección: </p><span>{{ $info_cliente->direccion_residencia }}</span></td>
                        </tr>
                        <tr>
                            <td class="border_bottom"><p>Ciudad: </p><span>{{ $info_cliente->ciudad_residencia }}</span></td>
                            <td class="border_bottom"><p>Teléfono: </p><span>@if($info_cliente->telefono_celular != ""){{ $info_cliente->telefono_celular }}@else{{ $info_cliente->telefono_residencia }}@endif</span></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table border">
                    <tbody>
                        <tr>
                            <td colspan="2">DATOS DEL PLAN SEPARE</td>
                        </tr>
                        <tr>
                            <td class="border_bottom"><p>Fecha de inicio: </p><span>{{ $datos_plan->fecha_creacion }}</span></td>
                            <td class="border_bottom"><p>Plazo: </p><span>{{ $datos_plan->plazo }} mes(es)</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border_bottom"><p>Fecha de terminación: </p><span>{{ $datos_plan->fecha_limite }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border_bottom"><p>Valor total acuerdo plan separe: </p><span>{{ $monto_total }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border_bottom"><p>Pagos acumulados: </p><span>{{ $datos_plan->abonos }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border_bottom"><p>Saldo pendiente: </p><span>{{ $saldo_pendiente }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border_bottom"><p>Vendedor: </p><span>{{ Auth::user()->name }}</span></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table">
                    <tbody>
                        <tr>
                            <td colspan="4" class="justify">
                                En virtud de lo dispuesto en la Ley 1581 del 2012 de protección de datos y 
                                sus normas reglamentarias, EL COMPRADOR autoriza como titular de los datos, 
                                para que estos sean incorporados en una base de datos responsabilidad DEL 
                                VENDEDOR y sus encargados o quien represente sus derechos, para que sean 
                                tratados con finalidades: comerciales, operacionales, contables, administrativas
                                y fiscales. EL VENDEDOR da constancia de conocer la política de protección de 
                                datos personales la cual  puede consultar en la {{ $tienda->direccion }}. Declaro que conoce la 
                                posibilidad de ejercer su derecho de acceso, corrección, suspensión, revocación
                                o reclamo sobre sus datos, mediante el envió de un correo electrónico a la dirección {{ $tienda->correo_habeas }}.
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="table">
                    <tbody>
                        <tr>
                            <td colspan="2"><b>EL COMPRADOR</b></td>
                            <td colspan="2"><b>EL VENDEDOR</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="espacio"></td>
                            <td colspan="2" class="espacio"></td>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $info_cliente->abreviado_documento }} {{ number_format($info_cliente->numero_documento,0,",",'.') }} DE {{ $info_cliente->ciudad_expedicion }}</td>
                            <td colspan="2">@if(isset($empleado)){{ $empleado->tipo_documento_abreviado }} {{ number_format($info_cliente->numero_documento,0,",",'.') }} DE {{ $empleado->ciudad_expedicion }} @else ADMINISTRADOR @endif</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table">
                    <tbody class="thead">
                        <tr><td>USUARIO: {{ Auth::user()->name }}- SINNUT -FECHA IMPRESIÓN: {{ $fecha }}</td></tr>
                        <tr><td><img class="logofooter" src="{{ asset('images/oroexpressfooter.png') }}" /></td></tr> 
                    </tbody>
                </table>

            </div>
            </td>
        @endfor 
        </tr>
        </table>   
    </div>
</body>
</html>

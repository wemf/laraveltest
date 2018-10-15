<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css" media="all">
            

            .logo{
                width: 98%;
                height: 40px;
            }

            .oroexpressfooter{
                width: 100%;
            }

            *{
                margin: 5px;
                padding: 0;
            }

            .documento{
                position: fixed;
                top: 0;
            }

            .documento-pdf{
                width: 304px;
                box-sizing: border-box;
                font-family: Arial;
                padding: 10px 10px 10px 10px;
                display: inline-block;
                border: 2px solid #000;
                vertical-align: top;
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
                margin-top: 5px;
                margin-bottom: 5px;
                background-color: #f0f0f0;
            }

            .back-blue{
                margin-top: 5px;
                background-color: #f0f0f0;
            }

            .back-yellow h6, .back-blue h6{
                text-align: justify;
                text-justify: inter-word;
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
                margin-left: 140px;
            }

            .firma{
                width: 700px;
                text-transform: uppercase;
            }

            .inline-block{
                display: inline-block;
                vertical-align: top;
            }
            
            .table{
                width: 100%;
                table-layout: fixed;
                border-collapse: separate;
                border-spacing: 40px 1px;
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
                margin-bottom: 10px;
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

            .marca_agua_copia{
                position: absolute;
                top: 0px;
                left: 10px;
                opacity: .45;
            }

            .tabla-detalle {
                width: 100%;
            }

            .tabla-detalle td{
                font-size: 10px;
            }

            .font-small {
                font-size: 8px;
            }

            .font-medium {
                font-size: 10px;
            }

            .justify {
                text-align: justify;
            }
        </style>
    </head>
    <body>
        <div class="documento">
        @if(isset($object[0]))
            <table>
            <tbody>
            <tr>
        @for( $i = 0; $i < 3; $i++ )
        <td>
            <div class="documento-pdf">
                <img class="logo" src="{{ asset('images/oroexpress.png') }}" />
                <h6 align="center">{{ $object[0]->nombre_tienda }}</h6>
                <h6 align="center">{{ $object[0]->direccion_tienda }} - {{ $object[0]->ciudad_tienda }} - {{ $object[0]->telefono_tienda }}</h6>
                <h6 align="center">{{ $object[0]->nit_sociedad }}-{{ $object[0]->digito_verificacion_sociedad }} - {{ $object[0]->nombre_sociedad }} - {{ $object[0]->nombre_regimen }}</h6>

                <h5 class="font-medium" align="center">RESOLUCIÓN DE CONTRATOS</h5>

                <table class="tabla-detalle">
                    <tbody>
                        <tr>
                            <td>Fecha:</td>
                            <td>{{ Carbon\Carbon::now()->format('d/m/Y') }}</td>
                            <td>Valor del contrato:</td>
                            <td>{{ $object[0]->valor_contrato }}</td>
                        </tr>
                        <tr>
                            <td>N° CONTRATO:</td>
                            <td>{{ $object[0]->cod_contrato_bar }}</td>
                            <td>Valor de retroventa:</td>
                            <td>{{ $object[0]->valor_retroventa_simple }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Total a pagar:</td>
                            <td>{{ $object[0]->valor_retroventa }}</td>
                        </tr>
                        <tr>
                            <td>Fecha de contrato:</td>
                            <td>{{ Carbon\Carbon::parse($object[0]->fecha_creacion)->format('d/m/Y') }}</td>
                            <td>Prorrogado hasta:</td>
                            <td>{{ Carbon\Carbon::parse($object[0]->fecha_terminacion_prorroga)->format('d/m/Y') }}</td>
                        </tr>
                    </tbody>
                </table>
                <p class="font-small justify">
                    Entre los suscritos {{ $object[0]->nombres }} identificado con {{ $object[0]->tipo_documento }}. No {{ $object[0]->numero_documento }}, Expedida en <span  style="font-size: 8px; text-transform: uppercase;">{{ $object[0]->ciudad_expedicion_cliente }}</span> domiciliado en {{ $object[0]->direccion_cliente }} teléfono:{{ $object[0]->telefono }}, 
                    mayor de edad quien obra en nombre propio y se denomina para efectos del presente contrato EL VENDEDOR de una parte; y 
                    por otra parte @if(isset($empleado)){{ $empleado->nombres_empleado }} {{ $empleado->primer_apellido_empleado }} {{ $empleado->segundo_apellido_empleado }}@endif, identificado con @if(isset($empleado)){{ $empleado->tipo_documento }}@endif No. @if(isset($empleado)){{ $empleado->numero_documento }}@endif expedida en <span  style="text-transform: uppercase;">@if(isset($empleado)){{ $empleado->ciudad_expedicion }}@endif</span> y quien para los efectos del presente 
                    contrato se denominará EL COMPRADOR en representación del establecimiento de comercio denominado {{ $object[0]->nombre_tienda }} Nit: {{ $object[0]->nit_sociedad }}-{{ $object[0]->digito_verificacion_sociedad }}, 
                    {{ $object[0]->nombre_regimen }}, Ubicado en la dirección {{ $object[0]->direccion_tienda }} Teléfono: {{ $object[0]->telefono_tienda }}.
                </p>
                <p class="font-small justify">
                    EL VENDEDOR  hace uso de la facultad de retroventa mencionada en la clausula primera del contrato, pagando la sumaestupulada de {{ $object[0]->valor_contrato_texto }} {{ $moneda->abreviatura }} M/CTE al COMPRADOR. 
                    Motivo por el cual este hace entrega y en efecto EL VENDEDOR recibe el bien objeto del presente contrato en las mismas condiciones en que lo vendio. Manufestando 
                    total satisfaccion.
                </p>
                <p class="font-small justify">
                    En virtud de lo dispuesto en la Ley 1581 del 2012 de protección de datos y sus normas reglamentarias, EL VENDEDOR  autoriza 
                    como titular de los datos, para que estos sean incorporados en una base de datos responsabilidad DEL COMPRADOR y sus 
                    encargados o quien represente sus derechos, para que sean tratados con finalidades: comerciales, operacionales, contables, 
                    administrativas y fiscales. EL COMPRADOR da constancia de conocer la política de protección de datos personales la cual  
                    puede consultar en la {{ $object[0]->direccion_sociedad }}. Declaro que conoce la posibilidad de ejercer su derecho de acceso, corrección, suspensión, 
                    revocación o reclamo sobre sus datos, mediante el envió de un correo electrónico a la dirección {{ $object[0]->correo_habeas }}. 
                </p>
                <p class="font-small justify">
                    TANTO VENDEDOR COMO COMPRADOR HAN LEÍDO, COMPRENDIDO Y ACEPTADO EL TEXTO DE ESTE CONTRATO. En constancia de lo anterior lo firman las partes 
                    en la fecha {{ Carbon\Carbon::now()->format('d-m-Y') }}
                </p>

                <table class="tabla-detalle">
                    <tbody>
                        <tr>
                            <td>EL VENDEDOR</td>
                            <td>EL COMPRADOR</td>
                        </tr>
                        <tr>
                            <td>  </td>
                            <td>  </td>
                        </tr>
                        <tr>
                            <td>  </td>
                            <td>  </td>
                        </tr>
                        <tr>
                            <td class="border-top">{{ $object[0]->tipo_documento_abreviado }} {{ $object[0]->numero_documento }} DE {{ $object[0]->ciudad_expedicion_cliente }}</td>
                            <td class="border-top">@if(isset($empleado)){{ $empleado->tipo_documento_abreviado }} {{ $empleado->numero_documento }} DE {{ $empleado->ciudad_expedicion   }} @else ADMINISTRADOR @endif</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <p class="font-medium" style="text-transform: uppercase;">USUARIO: {{Auth::user()->name}} FECHA IMPRESIÓN: {{ Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
                <p class="font-medium" align="center">{{ $object[0]->nombre_tienda }}</p>
                <p class="font-medium" align="center">{{ $object[0]->direccion_tienda }} - {{ $object[0]->ciudad_tienda }} - {{ $object[0]->telefono_tienda }}</p>
                <p class="font-medium" align="center">{{ $object[0]->nit_sociedad }}-{{ $object[0]->digito_verificacion_sociedad }} - {{ $object[0]->nombre_sociedad }} - {{ $object[0]->nombre_regimen }}</p>
                <p class="font-medium">Fecha: {{ Carbon\Carbon::now()->format('d-m-Y') }}</p>
                <p class="font-medium">DATOS DEL CLIENTE</p>
                <p class="font-medium">NIT/CC: {{ $object[0]->tipo_documento_abreviado }} {{ $object[0]->numero_documento }}  Lugar de exp: {{ $object[0]->ciudad_expedicion_cliente }}</p>
                <p class="font-medium">Nombre: {{ $object[0]->nombres }}</p>
                <p class="font-medium">Dirección: {{ $object[0]->direccion_cliente }}</p>
                <p class="font-medium">Teléfono: {{ $object[0]->telefono }}</p>
                <p class="font-medium">Prórroga de retroventa del contrato: {{ $object[0]->cod_contrato_bar }} <span style="text-align: right;">Subtotal: {{ $object[0]->valor_ingresado_prorroga }}</span></p>
                <p class="font-medium">TEXTO CONTABLE: VAR 72 <span style="text-align: right;">Total: {{ $object[0]->valor_ingresado_prorroga }}</span></p>
                <p class="font-medium" style="text-transform: uppercase;">USUARIO: {{Auth::user()->name}}         FECHA IMPRESIÓN: {{ Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
                <img class="oroexpressfooter" src="{{ asset('images/oroexpressfooter.png') }}" />
            </div>
            </td>
        @endfor
        </tr>
        </tbody>
        </table>
        @endif
        </div>
    </body>
</html>
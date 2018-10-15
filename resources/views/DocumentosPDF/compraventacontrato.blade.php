<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css" media="all">
            *{
                margin: 0;
                padding: 0;
                font-family: Arial;
            }

            .logo{
                width: 200px;
            }

            .oroexpressfooter{
                width: 100%;
            }

            .documento-pdf{
                width: 1100px;
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

            h5{
                font-size: 7px;
            }

            h6{
                font-size: 7px;
            }
            h2{
                font-size: 11px;
            }

            td{
                font-size: 8px;
            }

            .marca_agua_copia{
                position: absolute;
                top: 0px;
                left: 10px;
                opacity: .45;
            }
        </style>
    </head>
    <body>
    @for($h = 0; $h < 2; $h++)
        <p style="display: none;">{{$hoja_actual = 0}}</p>
        @for( $k = 0; $k < ceil(count($object) / 5); $k++ )
        @if($copia)<img class="marca_agua_copia" src="{{ asset('images/marca_agua_copia.png') }}" />@endif
        <p style="display: none;">{{++$hoja_actual}}</p>
        <div class="documento-pdf">
            <table class="align-center table">
                <thead>
                    <tr>
                        <td></td>
                        <td><img class="logo" src="{{ asset('images/oroexpress.png') }}" /></td>
                        <td align="center" class="bold"><h2>CONTRATO N° {{ $object[0]->cod_contrato_bar }}</h2><br><img src="data:image/png;base64,{{DNS1D::getBarcodePNG($object[0]->cod_pais.$object[0]->cod_nombre_comercial.$object[0]->cod_sociedad.$object[0]->cod_tienda.$object[0]->cod_contrato_bar, 'I25')}}" alt="barcode" /></td>
                    </tr>
                    <tr>
                        <td colspan="3"><h5 style="font-size: 16px;">{{ $object[0]->nombre_tienda }}</h5></td>
                    </tr>
                    <tr>
                        <td colspan="3"><h5>{{ $object[0]->direccion_tienda }} - {{ $object[0]->ciudad_tienda }} - {{ $object[0]->telefono_tienda }}</h5></td>
                    </tr>
                </thead>
            </table>
                    

            <table class="align-center table">
                <tbody>
                    <tr>
                        <td class="bold" style="width: 10% !important;"></td>
                        <td style="width: 80% !important;"><h5>{{ $object[0]->nit_sociedad }}-{{ $object[0]->digito_verificacion_sociedad }} - {{ $object[0]->nombre_sociedad }} - {{ $object[0]->nombre_regimen }}</h5></td>
                        <td class="bold" style="width: 10% !important;">@if($h == 0) ORIGINAL @else COPIA @endif</td>
                    </tr>
                </tbody>
            </table>

            <table class="align-center table">
                <tbody>
                    <tr>
                        <td align="center" class="bold"><h6 style="font-size: 9px;">INICIO CONTRATO: {{ Carbon\Carbon::parse($object[0]->fecha_creacion)->format('d/m/Y') }}</h6></td>
                        <td align="center" class="bold"><h6 style="font-size: 9px;">VALOR COMPRA: {{ $object[0]->valor_contrato }}</h6></td>
                        <td class="bold"><h6 style="font-size: 9px;">HOJA {{ $hoja_actual }} DE {{ ceil(count($object) / 5) }}</h6></td>
                    </tr>
                    <tr>
                        <td align="center" class="bold"><h6 style="font-size: 9px;">TERMINACION CONTRATO: {{ Carbon\Carbon::parse($object[0]->fecha_terminacion)->format('d/m/Y') }}</h6></td>
                        <td align="center" class="bold"><h6 style="font-size: 9px;">VALOR RETROVENTA: {{ $object[0]->valor_retroventa }}</h6></td>
                        <td class="bold"><h6 style="font-size: 9px;">TERMINO: {{ $object[0]->termino }} MES/ES</h6></td>
                    </tr>
                </tbody>
            </table>
            <table class="back-yellow">
                <tbody>
                    <tr>
                        <td align="center" class="all-border"><h5 style="font-size: 9px;">CONTRATO DE COMPRAVENTA CON PACTO DE RETROVENTA. ARTÍCULO 1939 DEL CÓDIGO CIVIL COLOMBIANO</h5></td>
                    </tr>
                    <tr>
                        <td align="left">
                            <h6>
                                "Entre los suscritos <span  style="font-size: 8px; text-transform: uppercase;">{{ $object[0]->nombres }} </span> identificado con {{ $object[0]->tipo_documento }}. No {{ $object[0]->numero_documento }}, 
                                Expedida en <span  style="font-size: 8px; text-transform: uppercase;">{{ $object[0]->ciudad_expedicion_cliente }}</span> domiciliado en {{ $object[0]->direccion_cliente }} teléfono: {{ $object[0]->telefono }}, 
                                mayor de edad quien obra en nombre propio y se denomina para efectos 
                                del presente contrato EL VENDEDOR de una parte; y por otra parte <span  style="font-size: 8px; text-transform: uppercase;">@if(isset($empleado)){{ $empleado->nombres_empleado }} {{ $empleado->primer_apellido_empleado }} {{ $empleado->segundo_apellido_empleado }}@endif</span>, 
                                identificado con la @if(isset($empleado)){{ $empleado->tipo_documento }}@endif No. @if(isset($empleado)){{ $empleado->numero_documento }}@endif expedida en <span  style="font-size: 8px; text-transform: uppercase;">@if(isset($empleado)){{ $empleado->ciudad_expedicion }}@endif</span> y quien para los 
                                efectos del presente contrato se denominará EL COMPRADOR en representación 
                                del establecimiento de comercio denominado {{ $object[0]->nombre_tienda }} Nit: {{ $object[0]->nit_sociedad }}-{{ $object[0]->digito_verificacion_sociedad }} , Ubicado en 
                                la dirección {{ $object[0]->direccion_tienda }}  Teléfono: {{ $object[0]->telefono_tienda }}  Manifestamos que hemos celebrado un 
                                contrato de compraventa sobre el(los) siguiente(s) bien(es) mueble(s) que 
                                a continuación se identifica(n):"
                            </h6>
                        </td>
                    </tr>
                </tbody>
            </table>

            <input type="hidden" value="{{ $total_peso_total = 0 }}" />
            <input type="hidden" value="{{ $total_peso_estimado = 0 }}" />
            <table width="100%" border="1" cellspacing="0">
                <thead>
                    <tr>
                        <td class="bold" align="center">N° ITEM</td>
                        <td class="bold" align="center">Cant.</td>
                        <td class="bold" align="center">Categoría Gnl</td>
                        <td class="bold" align="center">Detalle</td>
                        @foreach($columnas_items as $columna_item)
                        <td class="bold" align="center">{{ $columna_item->nombre }}</td>
                        @endforeach
                        @if($object[0]->control_peso_contrato == 1)
                        <td class="bold" align="center">Peso Total</td>
                        <td class="bold" align="center">Peso Estimado</td>
                        @endif
                        <td class="bold" align="center">Valor Compra</td>
                    </tr>
                </thead>
                <tbody>
                    @for($d = ($k * 5); $d < (($k + 1) * 5); $d++)
                        <tr>
                            @if(isset($object[$d]))
                            <td align="right">{{ $object[$d]->linea_item }}</td>
                            <td align="right">1</td>
                            <td>{{ $object[$d]->categoria_general }}</td>
                            <td>{{ $object[$d]->detalle }}</td>
                            @for($i = 0; $i < count($columnas_items); $i++)
                                <input type="hidden" value="{{ $col_print = 0 }}" />
                                @for($j = 0; $j < count($datos_columnas_items); $j++)
                                    @if($columnas_items[$i]->nombre == $datos_columnas_items[$j]->atributo && $datos_columnas_items[$j]->linea_item == $object[$d]->linea_item)
                                    <td>{{$datos_columnas_items[$j]->valor}} <input type="hidden" value="{{ $col_print = 1 }}" /></td>
                                    @endif
                                @endfor
                                @if($col_print == 0)
                                    <td></td>
                                @endif
                            @endfor
                            @if($object[0]->control_peso_contrato == 1)
                            <td align="right">{{ $object[$d]->peso_total }}</td>
                            <td align="right">{{ $object[$d]->peso_estimado }}</td>
                            @endif
                            <td align="right">{{ $object[$d]->precio_total }}
                                <input type="hidden" value="{{ $total_peso_total += $object[$d]->peso_total }}" />
                                <input type="hidden" value="{{ $total_peso_estimado += $object[$d]->peso_estimado }}" />
                            </td>
                            @else
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @if($object[0]->control_peso_contrato == 1)
                            <td></td>
                            <td></td>
                            @endif
                            @for($i = 0; $i < count($columnas_items); $i++)
                            <td></td>
                            @endfor
                            @endif
                        </tr>
                    @endfor
                </tbody>
                @if($k == (ceil(count($object) / 5)) - 1)
                <tfoot>
                    <tr>
                        <td class="bold">TOTALES</td>
                        <td align="right">{{ count($object) }}</td>
                        <td></td>
                        <td></td>
                        @foreach($columnas_items as $columna_item)
                        <td></td>
                        @endforeach
                        @if($object[0]->control_peso_contrato == 1)
                        <td align="right">{{ $object[0]->peso_total_total }}</td>
                        <td align="right">{{ $object[0]->peso_estimado_total }}</td>
                        @endif
                        <td align="right">{{ $object[0]->valor_contrato }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
            <table class="back-blue">
                <tbody>
                    @if($object[0]->aplica_bolsa == 1)
                    <tr>
                        <td align="left"><h6>BOLSAS DE SEGURIDAD: {{ $object[0]->cod_bolsas_seguridad }}</h6></td>
                    </tr>
                    @endif
                    <tr>
                        <td align="left">
                            <h6>
                                EL PRECIO DE LA COMPRAVENTA ES LA SUMA DE: {{ $object[0]->valor_contrato_texto }} {{ $moneda->abreviatura }}  M/CTE. 
                                El VENDEDOR transfiere al COMPRADOR, a título de compraventa 
                                el derecho de dominio y posesión que tiene y ejerce sobre los 
                                anteriores artículos y declara que los bienes que transfiere, 
                                los adquirió lícitamente, no fue su importador, son de su 
                                exclusiva propiedad, los posee de manera regular, pública y  
                                pacífica, están libres de gravamen, limitación al dominio, 
                                pleitos pendientes y embargos, con la obligación de salir al 
                                saneamiento en casos de ley, EL VENDEDOR manifiesta que el 
                                patrimonio que posee y ha poseído son de origen licito, manifiesta 
                                que no admite que terceros lo involucren en actividades ilícitas 
                                contempladas en el código penal colombiano o en cualquier norma que 
                                lo modifique, adicione o sustituya y que no efectuará transacciones 
                                en favor de actividades ilícitas o de personas relacionadas con las mismas.
                            </h6>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="all-border"><h5 style="font-size: 9px;">CLAUSULAS ACCESORIAS QUE RIGEN EL PRESENTE CONTRATO:</h5></td>
                    </tr>
                    <tr>
                        <td align="left">
                            <h6>
                                1.Los contratantes de conformidad con el artículo 1939 del Código 
                                Civil Colombiano, EL VENDEDOR se reserva la facultad de recobrar 
                                los artículos vendidos por medio de este contrato, pagando al 
                                COMPRADOR como precio de retroventa la suma de: {{ $object[0]->valor_retroventa_texto }} {{ $moneda->abreviatura }}  M/CTE. 
                                2. El derecho que nace del pacto de retroventa del presente contrato, 
                                no podrá cederse a ningún título. En caso de pérdida de este contrato 
                                EL VENDEDOR se obliga a dar noticia inmediata al COMPRADOR y éste, 
                                sólo exhibirá al COMPRADOR el artículo descrito para la terminación 
                                del presente contrato. 3. EL VENDEDOR Y EL COMPRADOR pactan que la 
                                facultad de retroventa del presente contrato lo podrá ejercer EL 
                                VENDEDOR dentro del término de {{ $object[0]->termino }} mes/es contados a partir de la 
                                firma del presente documento. 4. Las partes aquí firmantes, hemos 
                                establecido que en caso de deterioro o pérdida de los artículos descritos, 
                                ocasionada por fuerza mayor o caso fortuito, se exonera de cualquier 
                                responsabilidad AL COMPRADOR. 5. Las controversias relativas al presente 
                                contrato se resolverán por un tribunal de arbitramento de conformidad con 
                                las disposiciones que rigen la materia nombrado por la Cámara de comercio 
                                de esta ciudad.6. EL VENDEDOR autoriza al COMPRADOR  o a quien represente 
                                sus derechos con carácter permanente o temporal; para consultar ante 
                                entidades o en bases de datos de información y listas restrictivas que 
                                considere EL VENDEDOR cualquier dato que ayude a prevenir y controlar el 
                                Lavado de Activos y la Financiación del Terrorismo. El VENDEDOR declara 
                                que cumplirá con la obligación de actualizar sus datos personales cuando 
                                se produzca algún cambio en el contenido del mismo o cuando expresamente 
                                lo solicite EL COMPRADOR. Bajo la gravedad del juramento EL VENDEDOR 
                                manifiesta no encontrarse incluido en listas restrictivas nacionales e 
                                internacionales relacionadas con algún delito del Lavado de Activos y 
                                Financiación del Terrorismo. 7. En virtud de lo dispuesto en la Ley 1581 
                                del 2012 de protección de datos y sus normas reglamentarias, EL VENDEDOR 
                                autoriza como titular de los datos, para que estos sean incorporados en 
                                una base de datos responsabilidad de  EL COMPRADOR y sus encargados o quien
                                represente sus derechos, para que sean tratados con finalidades: comerciales
                                , operacionales, contables, administrativas y fiscales. El VENDEDOR da 
                                constancia de conocer la política de protección de datos personales del
                                COMPRADOR la cual la puede consultar en la . EL VENDEDOR declara que
                                conoce la posibilidad de ejercer su derecho de acceso, corrección,
                                suspensión, revocación o reclamo sobre sus datos, mediante el envió de
                                un correo electrónico a la dirección {{ $object[0]->correo_habeas }}. TANTO VENDEDOR COMO COMPRADOR
                                HAN LEÍDO, COMPRENDIDO Y ACEPTADO EL TEXTO DE ESTE CONTRATO. En constancia
                                de lo anterior el contrato N° {{ $object[0]->cod_contrato_bar }} lo firman las partes en la fecha: {{ Carbon\Carbon::parse($object[0]->fecha_creacion)->format('d/m/Y H:i:s') }}.
                            </h6>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <div class="inline-block">
                                <h5>EL VENDEDOR:</h5>
                                <br>
                                <br>
                                <br>
                                <br>
                                <h5 class="border-top firma">{{ $object[0]->tipo_documento_abreviado }} {{ $object[0]->numero_documento }} DE {{ $object[0]->ciudad_expedicion_cliente }}                  </h5>
                            </div>
                            <div class="inline-block huella">

                            </div>
                        </td>
                        <td>
                            <div class="inline-block">
                                <h5>EL COMPRADOR:</h5>
                                <br>
                                <br>
                                <br>
                                <br>
                                <h5 class="border-top firma">@if(isset($empleado)){{ $empleado->tipo_documento_abreviado }} {{ $empleado->numero_documento }} DE {{ $empleado->ciudad_expedicion }} @else ADMINISTRADOR @endif                  </h5>
                            </div>
                            <div class="inline-block huella">

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h5 align="right" style="text-transform: uppercase;">USUARIO: {{Auth::user()->name}}         FECHA IMPRESIÓN: {{ Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</h5>
            <br>
            <!-- <h5 align="right">USUARIO</h5> -->
            <img class="oroexpressfooter" src="{{ asset('images/oroexpressfooter.png') }}" />
            @if ($hoja_actual < ceil(count($object) / 5))
            <div style="page-break-after:always;"></div>
            @endif
        </div>
        
        @endfor
        @if($h == 0) <div style="page-break-after:always;"></div> @endif
    @endfor

    
    <script>
        $(document).ready(function(){
            $("body").click(function(){
                window.close();
            });

            $("body").keypress(function(){
                window.close();
            });
        })
    </script>
    </body>
</html>
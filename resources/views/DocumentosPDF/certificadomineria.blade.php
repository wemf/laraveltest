<!DOCTYPE html>
<html lang="en">
<head>
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        *
        {
            font-family: Arial;
            font-size: 9px;
            padding: 0;
            margin: 0;
        }

        body
        {
            padding: 10px;
        }

        table
        {
            border-spacing: 0;
        }

        td
        {
            border: 1px solid #000;
            text-align: center;
        }

        .border-bottom
        {
            border-bottom: 2px solid #000;
        }

        .light-green
        {
            background-color: #a9d18e;
        }

        .dark-green
        {
            background-color: #385723;
            color: #fff;
        }

        .eq-empty
        {
            width: 7px;
            height: 7px;
            border: 1px solid #000;
            display: inline-block;
        }
    </style>
</head>
<body>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td colspan="3">
                    <img src="{{ asset('images/mineria.png') }}" />
                </td>
                <td colspan="12">
                    <h4><strong>VICEPRESIDENCIA DE SEGUIMIENTO CONTROL Y SEGURIDAD MINERA</strong></h4>
                    <p>Grupo de Regalías y Contraprestaciones Económicas</p>
                </td>
            </tr>
            <tr>
                <td colspan="15" class="dark-green">
                    ACREDITACIÓN DE FACTURAS CASAS DE COMPRA Y VENTAS
                </td>
            </tr>
            <tr>
                <td colspan="5" class="light-green">
                    FECHA
                </td>
                <td>
                    <div class="micro-td border-bottom">
                        DD
                    </div>
                    <div class="micro-td"> </div>
                </td>
                <td>
                <div class="micro-td border-bottom">
                        MM
                    </div>
                    <div class="micro-td"> </div>
                </td>
                <td>
                    <div class="micro-td border-bottom">
                        AAAA
                    </div>
                    <div class="micro-td"> </div>
                </td>
                <td class="light-green">CIUDAD</td>
                <td>                                  </td>
                <td class="light-green">No.<br> CONSECUTIVO</td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="15" class="dark-green">
                    INFORMACIÓN
                </td>
            </tr>
            <tr>
                <td colspan="9" class="dark-green">
                    CASA DE COMPRA-VENTA
                </td>
                <td colspan="6" class="dark-green">
                    INFORMACION DEL COMERCIALIZADOR CERTIFICADO
                </td>
            </tr>
            <tr>
                <td colspan="3" class="light-green">
                    NOMBRES Y APELLIDOS O RAZÓN SOCIAL
                </td>
                <td colspan="6">
                   
                </td>
                <td colspan="2" class="light-green">
                    <div class="micro-td border-bottom">
                        NOMBRES Y APELLIDOS O RAZÓN SOCIAL
                    </div>
                    <div class="micro-td">
                        TIPO DE IDENTIFICACIÓN
                    </div>
                </td>
                <td colspan="4">
                    <table class="micro-table" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    CIIGSA
                                </td>
                            </tr>
                            <tr>
                                <td>NIT</td>
                                <td>CÉDULA</td>
                                <td>CÉDULA DE EXTRANJERÍA</td>
                                <td>RUT</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="light-green">
                    TIPO DE IDENTIFICACIÓN
                </td>
                <td>
                    NIT
                </td>
                <td>
                    CÉDULA
                </td>
                <td colspan="3">
                    CÉDULA DE EXTRANJERÍA
                </td>
                <td>
                    RUT
                </td>
                <td colspan="2" class="light-green">
                   No. DOCUMENTO DE IDENTIDAD
                </td>
                <td colspan="4">
                    
                </td>
            </tr>


            <tr>
                <td colspan="3" class="light-green">
                    No. DOCUMENTO DE IDENTIFICACIÓN
                </td>
                <td colspan="6">
                   
                </td>
                <td colspan="2" class="light-green">
                    <div class="micro-td border-bottom">
                        No. RUCOM
                    </div>
                    <div class="micro-td">
                        No. CP
                    </div>
                </td>
                <td colspan="4">
                    <div class="micro-td border-bottom">
                        
                    </div>
                    <div class="micro-td">
                        
                    </div>
                </td>
            </tr>

            
            <tr>
                <td colspan="15" class="dark-green">
                    INFORMACIÓN DE LAS FACTURAS DE COMPRA
                </td>
            </tr>


            <tr>
                <td class="light-green">
                    No.
                </td>
                <td class="light-green">
                    NOMBRE O RAZÓN SOCIAL DEL VENDEDOR
                </td>
                <td class="light-green">
                    NIT O CC
                </td>
                <td colspan="2" class="light-green">
                    No. DE FACTURA, CONTRATO<br> COMPRA-VENTA O<br> DOCUMENTO EQUIVALENTE
                </td>
                <td colspan="3" class="light-green">
                    <table class="micro-table" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    FECHA DE LA FACTURA
                                </td>
                            </tr>
                            <tr>
                                <td>DD</td>
                                <td>MM</td>
                                <td>AAAA</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td colspan="5" class="light-green">
                    DESCRIPCIÓN DEL PRODUCTO
                </td>
                <td class="light-green">
                    CANTIDAD
                </td>
                <td class="light-green">
                    UNIDAD DE<br> MEDIDA
                </td>
            </tr>



            @foreach($object as $item)
            <tr>
                <td>
                    No.
                </td>
                <td>
                    {{ $item->nombres_cliente }}
                </td>
                <td>
                    {{ $item->numero_documento_cliente }}
                </td>
                <td colspan="2">
                    {{ $item->codigo_contrato }}
                </td>
                <td>{{ $item->dia_contrato }}</td>
                <td>{{ $item->mes_contrato }}</td>
                <td>{{ $item->anho_contrato }}</td>
                <td colspan="5">
                    {{ $item->nombre }}
                </td>
                <td>
                    {{ $item->peso_total }}
                </td>
                <td>
                    GRAMOS
                </td>
            </tr>

            @endforeach

            
            <tr>
                <td colspan="15">
                Doy fe y declaro bajo la gravedad de juramento que la información que se está suministrando corresponde a la realidad y que los  documentos que aportan son fiel copia de los originales que reposan en nuestros <br> archivos y autorizo que en cualquier momento CIIGSA pueda verificar la existencia de esta información.
                </td>
            </tr>


            <tr>
                <td colspan="2" class="dark-green">
                    <br><br><br><br><br><br>
                    FIRMA REPRESENTANTE LEGAL
                    <br><br><br><br><br><br>
                </td>
                <td colspan="3">
                   
                </td>
                <td colspan="3">
                    <div class="micro-td border-bottom">
                        HUELLA
                    </div>
                    <div class="micro-td">
                        <br><br><br><br><br><br>
                         
                        <br><br><br><br><br><br>
                    </div>
                </td>
                <td colspan="2" class="dark-green">
                    <br><br><br><br><br><br>
                    FIRMA REVISOR FISCAL
                    <br><br><br><br><br><br>
                </td>
                <td colspan="3">
                   
                </td>
                <td colspan="2">
                    <div class="micro-td border-bottom">
                        HUELLA
                    </div>
                    <div class="micro-td">
                        <br><br><br><br><br><br>
                         
                        <br><br><br><br><br><br>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</body>
</html>
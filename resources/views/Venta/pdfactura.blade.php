<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PDFactura</title>
	<style>
	*{
	margin:0px;
	padding:0px;
	box-sizing:border-box;
}

section{
	margin: 15px;
    width: 100%;
}

p{
	font-size:10px;
	margin: 0 0 2px 0;
}

h2{
	font-size:10px;
	text-decoration:underline;
	margin: 0 0 10px 0;
}

.var{
	padding:0px;
}

.var p{
	color:black;
	font-size:10px;
	text-transform:uppercase;
}

.header{
	width:100%;
}

.codigo{
	width:14%;
	display:inline-block;
	text-align:center;
	vertical-align: top;
}

.var2{
	border:2px solid #333;
	padding: 5px 2px;
	margin-top: 7px;
}

.var2 p{
	font-size:20px;
}

.principal{
	width:85%;
	display:inline-block;
	vertical-align: bottom;
}


.logo{
	width:50%;
	display:inline-block;
	vertical-align:middle;
	text-align:right;
	height: 50px;
}

.principal .var{
	width:100%;
	text-align:center;
}

.header .principal .var1{
	width:25%;
	display:inline-block;
	vertical-align:middle;
}

.nuemro{
	width:24%;
	display:inline-block;
	vertical-align:middle;
}

.codigobarra{
	width:100%;
	padding: 4px 0px;
}

.codigobarra img{
	width:100%;
}

.datosfactura{
	width:100%;
	vertical-align: top;
	padding:3px 0;
}

.datosfactura .info{
	width: 30%;
	display:inline-block;
	vertical-align: top;
}

.titulo{
    width: 49%;
	display: inline-block;
	vertical-align: top;
}

.resultado{
    width: 49%;
	display: inline-block;
	vertical-align: top;
}

.hoja{
	width: 40%;
	display: inline-block;
	vertical-align: top;
    text-align: right;
}

.hoja div,
.hoja p{
	display:inline-block;
	margin:0 5px;
}

.datoscliente{
	width:100%;
	vertical-align: top;
	padding:3px 0;
}

.datoscliente .info{
	width: 35%;
	display:inline-block;
	vertical-align: top;
}

.sin-borde,
.sin-borde td{
	border:1px solid transparent;
}

table{
	width:100%;
}

td, th{
	text-align:center;
	border:1px solid #000;
	padding: 1px;
	font-size: 10px;
}

.tabla2{
	width:30%;
	vertical-align: bottom;
}

.textos{
	width:69%;
	display:inline-block;
	vertical-align: top;
}

.textos > div{
	border:1px solid #000;
	text-align:center;
}

.textos > div > div p{
	display:inline-block;
	margin:5px
}

.textos .datos div{
	padding:15px 0;
	text-align:center;
}

.firma1{
	width: 30%;
    display: inline-block;
    padding-left: 16%;
}

.firma2{
	width: 69%;
    display: inline-block;
    padding-left: 16%;
}

.titulo_firma{
	padding-bottom: 20px;
}

.user{
	text-align: right;
    width: 100%;
}
	</style>
</head>
<body>
	<input type="hidden" name="pagina" value="{{ $pagina = 1 }}">
	<input type="hidden" name="pagina" value="{{ $cant_pagina = 1 }}">
	<input type="hidden" name="pagina" value="{{ $pagina_actual = 1 }}">
	<input type="hidden" name="sum_peso" value="{{ $sum_peso = 0 }}">
	<section>
		<div class="header">
			<div class="principal">
				<div class="logo">
					<img src="{{ asset('images/oroexpress.png') }}" alt="logo">
				</div>
				<div class="var var1"><p>{{ $tienda->nombre_franquicia }}</p></div>
				<din class="nuemro"><p>FACTURA DE VENTA N°</p></din>
				<div class="var var6"><p>{{ $tienda->nombre_sociedad }}</p></div>
				<div class="var var6a"><p>{{ $tienda->nombre }}</p></div>
				<div class="var var7"><p>{{ $tienda->direccion }} - {{ $tienda->nombre_ciudad }} - {{ $tienda->telefono }}</p></div>
				<div class="var var8" style="margin-bottom: 4px;"><p>{{ $tienda->nombre_regimen }}</p></div>
			</div>
			<div class="codigo">
				<div class="var var2"><p>{{ $numero_factura }}</p></div>
				<div class="codigobarra">
					{!!DNS1D::getBarcodeHTML($numero_factura, 'C39')!!}
				</div>
				<div class="var var3"><p></p></div>
				<div class="var var4"><p>Número de hoja {{ $pagina }}</p></div>
			</div>
		</div>
		<div class="datosfactura">
			<div class="info">
				<div class="titulo">
					<p>Fecha:</p>
					<p>Usuario:</p>
				</div>
				<div class="resultado">
					<p>{{ date('d-m-Y') }} <span></span></p>
					<div class="var var10">
						<p>{{ Auth::user()->name }}</p>
					</div>
				</div>
			</div>
			<div class="info">
				<div class="titulo">
					<p>Medio de pago:</p>
				</div>
				<div class="resultado">
					<p>Credicontado</p>
					<div class="var var10">
						<p></p>
					</div>
				</div>
			</div>
			<div class="hoja">
				<div class="var var5"><p>Pag {{$cant_pagina}}</p></div>
				<p>HOJA {{ $pagina_actual }} DE {{ $cant_pagina }}</p>
			</div>
		</div>
		<div class="datoscliente">
			<h2>datos del cliente</h2>
			<div class="info">
				<div class="titulo">
					<div class="var12">	
						<p>NIT/CC:</p>
					</div>
					<div class="var12">
						<p>NOMBRE:</p>
					</div>
					<div class="var12">
						<p>DIRECCION:</p>
					</div>
				</div>
				<div class="resultado">
					<div class="var var12">
						<p>{{ $info_cliente->numero_documento }}</p>
					</div>
					<div class="var var13">
						<p>{{ $info_cliente->nombres }} {{ $info_cliente->primer_apellido }} {{ $info_cliente->segundo_apellido }}</p>
					</div>
					<div class="var var14">
						<p>{{ $info_cliente->direccion_residencia }}</p>
					</div>
				</div>
			</div>
			<div class="info">
				<div class="titulo">
					<div class="var12">	
						<p>TELEFONO:</p>
					</div>
					<div class="var12">	
						<p>SUCURSAL:</p>
					</div>
					<div class="var12">	
						<p>REGIMEN:</p>
					</div>
				</div>
				<div class="resultado">
					<div class="var var15">
						<p>@if($info_cliente->telefono_celular == "") {{ $info_cliente->telefono_residencia}} @else {{ $info_cliente->telefono_celular}} @endif</p>
					</div>
					<div class="var var16">
						<p>{{ $tienda->codigo_tienda }}</p>
					</div>
					<div class="var var17">
						<p>{{ $info_cliente->regimen }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="tabla">
			<table cellpadding="0" cellspacing="0">
				
				<tr>
					<th>ID</th>
					<th>REFERENCIA</th>
					<th>CATEGORIA</th>
					<th>CALIDAD</th>
					<th>DETALLE</th>
					<th>CANTIDAD</th>
					<th>PESO UNIDAD</th>
					<th>PRECIO DE VENTA</th>
					<th>DCTO</th>
					<th>VALOR DESCUENTO</th>
					<th>SUBTOTAL</th>
					<th>IVA</th>
					<th>VALOR IVA</th>
					<th>VALOR TOTAL</th>
				</tr>
				@for($i = 0; $i < count($info_inventario); $i++)
				<tr>
					<td>{{ $info_inventario[$i]->id }}</td>
					<td>{{ $info_inventario[$i]->referencia }}</td>
					<td>{{ $info_inventario[$i]->categoria}}</td>
					<td>{{ $info_inventario[$i]->calidad }}</td>
					<td>{{ $info_inventario[$i]->detalle }}</td>
					<td>{{ $info_inventario[$i]->cantidad }}</td>
					<td>{{ $info_inventario[$i]->peso }} <input type="hidden" name="sum" value="{{ $sum_peso = $sum_peso + $info_inventario[$i]->peso }}">  </td>
					<td>{{ $request->precio_venta[$i] }}</td>
					<td>{{ $info_inventario[$i]->descuento }}</td>
					<td>{{ $info_inventario[$i]->valor_descuento }}</td>
					<td>{{ $request->precio_venta[$i] }}</td>
					<td>{{ $request->porcentaje_iva[$i] }}</td>
					<td>{{ $request->valor_iva[$i] }}</td>
					<td>{{ $request->valor_total_producto[$i] }}</td>
				</tr>
				@endfor
				<tr>
					<td>TOTAL</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ count($request->id_inventario) }}</td>
					<td>{{ $sum_peso }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
					<td class="sin-borde"> </td>
				</tr>
			</table>
			<div class="textos">
				<div class="datos">
					<div class="var var38"><p>Var38</p><p>TEXTO TRATAMIENTO DE DATOS</p></div>
					<div class="var var45"><p>Var45</p><p>TEXTO DE GARANTIAS</p></div>
				</div>
				<div>
					<div class="var var37"><p>Var37</p><p>TEXTO RESOLUCION DIAN</p></div>
				</div>
			</div>
			<div style="display: inline-block; width: 30%; vertical-align:top;">
				<table class="tabla2" style="width: 100%;" cellpadding="0" cellspacing="0">
					<tr>
						<td>VALOR BRUTO</td>
						<td>
							<div class="var var29">
								<p>{{ $request->valor_bruto }}</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>DESCUENTOS</td>
						<td>
							<div class="var var29a">
								<p>{{ $request->descuentos }}</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>SUBTOTAL</td>
						<td>
							<div class="var var29b">
								<p>{{ $request->subtotal }}</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>BASE DE IVA</td>
						<td>
							<div class="var var30">
								<p>{{ $request->base_iva }}</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>VALOR IVA</td>
						<td>
							<div class="var var31">
								<p>{{ $request->v_iva }}</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>VALOR RETEFUENTE</td>
						<td>
							<div class="var var32">
								<p>{{ $request->v_retefuente }}</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>VALOR RETEICA</td>
						<td>
							<div class="var var33">
								<p>{{ $request->v_reteica }}</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>VALOR RETEIVA</td>
						<td>
							<div class="var var34">
								<p>{{ $request->v_reteiva }}</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>VALOR IMPUESTO CONSUMO</td>
						<td>
							<div class="var var35">
								<p>{{ $request->v_impuesto_consumo }}</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>TOTAL</td>
						<td>
							<div class="var var36">
								<p>{{ $request->total }}</p>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="datosfooter">
			<div class="firmas">
				<div class="firma1">
					<div class="titulo_firma">
						<p>ACEPTA  Y RECIBE LA FACTURA: </p>
					</div>
					<div class="raya">
						<p>_______________________________</p>
						<p>{{ $info_cliente->abreviado_documento }}{{ $info_cliente->numero_documento }} DE {{ $info_cliente->ciudad_expedicion }}</p>
					</div>
				</div>
				<div class="firma2">
					<div class="titulo_firma">
						<p>EL VENDEDOR: </p>
					</div>
					<div class="raya">
						<p>_______________________________</p>
						<p>@if(isset($empleado)){{ $empleado->tipo_documento_abreviado }} {{ $empleado->numero_documento }} DE {{ $empleado->ciudad_expedicion }} @else ADMINISTRADOR @endif</p>
					</div>
				</div>
			</div>
			<div class="user">
				<p>USUARIO: {{ Auth::user()->name }}- FECHA IMPRESIÓN: {{ date('d-m-Y') }}</p>
			</div>
			<div class="imgfooter">
				<img height="50" width="600px" src="{{ asset('images/oroexpressfooter.png') }}" style="margin: 0px 5px;" /> </td>
			</div>
		</div>
	</section>
</body>
</html>
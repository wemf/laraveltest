@extends('layouts.master')

@section('head')
	@parent
	<link href="{{asset('/css/datepickerJquery.css')}}" rel="stylesheet" />
	<link href="{{asset('/css/formMotor.css')}}" rel="stylesheet" />
@endsection

@section('content')    
<h3>Crear Formulario</h3>
<br>
<div class="panel panel-default">
	<div class="panel-heading">
		<div id="processingForm" class="alert alert-success ocultar" role="alert">
			<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
			<span class="">Procesando, por favor espere...</span> 
		</div>
		<input id="nameForm" class="form-control" placeholder="Nombre del Formulario" title="Nombre del Formulario" min="4" max="70" pattern="[a-zA-Z0-9]+"></input>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-1">
				<div class="btn-group-vertical" role="group" aria-label="Menu-Izq">
					<button id="etiqueta" type="button" class="btn btn-default">Etiqueta</button>
					<button id="input" type="button" class="btn btn-default">Input</button>
					<button id="parrafo" type="button" class="btn btn-default">Parrafo</button>
					<button id="lista" type="button" class="btn btn-default">Lista</button>
					<button id="radio" type="button" class="btn btn-default">Radio</button>
					<button id="checkbox" type="button" class="btn btn-default">Checkbox</button>
					<button id="guardar" type="button" class="btn btn-default">Guardar</button>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<div id="container" class="sortable1">													
							<div id="container-add" class="list-group sortable2 connectedSortable"></div>							
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div id="menu-der" class="btn-group-vertical" role="group" aria-label="Menu-Der">
					<h1 class="list-group-item tam">Atributos</h1>
					<input id="id-input" type="hidden"></input>
					<input class="list-group-item" id="text" placeholder="Texto" title="Texto"></input>
					<input class="list-group-item" id="placeholder" placeholder="Placeholder" title="Placeholder"></input>
					<input class="list-group-item" id="value" placeholder="Value" title="Value"></input>
					<input class="list-group-item" id="name" placeholder="Nombre Post" title="Nombre Post"></input>
					<input class="list-group-item" id="fila" placeholder="Número Filas" min="1" type="number" title="Número Filas"></input>
					<input class="list-group-item" id="columna" placeholder="Número Columnas" min="1" type="number" title="Número Columnas"></input>					
					<select class="list-group-item" id="mascara" title="Mascara">					    
						<option value="">Mascara Texto</option>
						<option value="email">Mascara Email</option>
						<option value="fecha">Mascara Fecha</option>
						<option value="telefono">Mascara Teléfono</option>
						<option value="numero">Mascara Número</option>						
						<option value="moneda">Mascara Moneda</option>
						<option value="direccion">Mascara Dirección</option>
						<option value="postal">Mascara Cod. Postal</option>
					</select>					
					<div class="checkbox list-group-item" id="div-required">
						<label>
							<input id="required" type="checkbox"> Obligatorio
						</label>
					</div>
					<div id="itm-select" class="list-group-item">
						<div class="row">
							<div class="col-md-6">
								<input id="itm" placeholder="Elemento" type="text" title="Elementos de la lista"></input>	
							</div>
							<div class="col-md-6">
								<button id="add-itm" type="button" class="btn btn-default btn-xs">Agregar</button>
							</div>							
						</div>
						<div class="row">
							<br>
							<div id="container-itm-add" class="list-group"></div>
						</div>
					</div>					
					<button class="btn btn-default" id="updateAttr" type="button">Actualizar</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/formMotor.js')}}"></script>
@endpush

@section('javascript')
	@parent
	savedItm.setUrlPost("{{ url('/form/saved') }}");	 
	savedItm.seturlRedirect("{{ url('/definer/update') }}");	 
@endsection
@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Crear Cláusulas</h2>
                <div class="clearfix">
                </div>
            </div>
            <div class="x_content">
                <form id="form-attribute" action="{{ url('/modificarClausulas/create') }}" method="POST" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label class=" col-sm-6 col-md-4 col-xs-12" for="pais">País</label>
                            <div class="col-sm-6 col-md-8 col-xs-12">
                                <select name="pais" id="col0_filter" onchange="clearSelects([['departamento', 'delete_options'], ['ciudad', 'delete_options'], ['tienda', 'delete_options']], true);loadSelectChild(this, '#departamento', '{{ url('/departamento/getdepartamentobypais') }}');" class="form-control">
                                    @foreach($paises as $pais)
                                <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" col-sm-6 col-md-4 col-xs-12" for="departamento">Departamento</label>
                            <div class="col-sm-6 col-md-8 col-xs-12">
                                <select name="departamento" id="departamento" onchange="clearSelects([['ciudad', 'delete_options'], ['tienda', 'delete_options']], true);loadSelectChild(this, '#ciudad', '{{ url('/ciudad/getciudadbydepartamento') }}');" class="form-control">
                                    <option > - Seleccione una opción - </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" col-sm-6 col-md-4 col-xs-12" for="ciudad">Ciudad</label>
                            <div class="col-sm-6 col-md-8 col-xs-12">
                                <select name="ciudad" id="ciudad" onchange="clearSelects([['tienda', 'delete_options']], true);loadSelectChild(this, '#tienda', '{{ url('/tienda/gettiendabyzona') }}');" class="form-control">
                                    <option > - Seleccione una opción - </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class=" col-sm-6 col-md-4 col-xs-12" for="tienda">Joyería</label>
                            <div class="col-sm-6 col-md-8 col-xs-12">
                                <select name="tienda" id="tienda" class="form-control">
                                    
                                </select>
                            </div>
                        </div>
                        
                    </div>
                
                    <div class="form-group">
                       
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label>Desde</label>
                            <input type="text" class="form-control data-picker-only" name="fecha_cracionD" id="fecha_cracionD" maxlength="10" placeholder="Desde" value='{{ dateFormate::ToFormatInverse(date('Y-m-d')) }}' autocomplete="off">
                            </div>
                            {{-- <div class="col-md-6">
                                <input type="text" class="form-control data-picker-only" name="fecha_cracionH" id="fecha_cracionH" maxlength="10" placeholder="Hasta" value='{{ dateFormate::ToFormatInverse(date('Y-m-d')) }}' autocomplete="off">
                            </div> --}}
                        </div>
                        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombreclausula">Nombre de Cláusula</label>
                            <input type="text" name="nombreclausula" class="form-control" maxlength="250" id="nombreclausula"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="clausula">Descripción de Cláusula</label>
                            <textarea name="clausula" class="form-control" maxlength="500" id="clausula" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-2 col-md-offset-4">
                            <button type="submit" id="btn-save" class="btn btn-success form-control">Guardar</button>
                            {{-- <button type="button" onclick="saveData();" class="btn btn-success form-control">Guardar</button> --}}
                            {{-- <button class="btn btn-primary" type="reset">Restablecer</button>  --}}                
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 col-md-offset-0"> 
                            <a href="{{ url('/modificarClausulas') }}" class="btn btn-danger form-control" type="button">Cancelar</a>             
                        </div>              
                    </div>
                    <input type="hidden" id="fecha_actual" value="{{ date_format(Carbon\Carbon::now(), 'd-m-Y') }}" />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/configcontrato/configcontrato.js')}}"></script>
@endpush

@section('javascript')
{{-- en column van los datos cal cual lleguen de la base de datos / la primer url es de donde vienen los datos / la segunda idioma datatable  --}}

 {{-- function saveData(){
    if( !validate_form.validate_values('fecha_actual', 'fecha_cracionD', 'datetime', true) ) {
        Alerta('Información', 'La vigencia desde no puede ser menor o igual a la fecha actual', 'warning');
    }else{
        $("#btn-save").click();
    }
}  --}}

$(document).ready(function(){
    
    @if(Auth::user()->role->id==env('ROL_TESORERIA')|| Auth::user()->role->id==env('ROLE_SUPER_ADMIN'))    
        //Función para llenar el campo departamento
        $('#col0_filter').change(function(){
            fillSelect('#col0_filter','#col1_filter',"{{ url('/pais/getSelectListPais') }}");
        });
       
        
        
        // País
        $("#col0_filter option").each(function () {
            if ($(this).val() == {{tienda::OnLine()->id_pais}}){
                $(this).attr('selected', 'selected');
            }
        });
        $("#col0_filter").change();
        fillSelect('#col0_filter','#col1_filter',"{{ url('/pais/getSelectListPais') }}");
        // Departamento
        $("#col1_filter option").each(function () {
            if ($(this).val() == {{tienda::OnLine()->id_departamento}})
                $(this).attr('selected', 'selected');
        });
        fillSelect('#col1_filter','#col2_filter',"{{ url('/departamento/getSelectListDepartamento') }}");
        // Ciudad
        $("#filter_col2 option").each(function () {
            if ($(this).val() == {{tienda::OnLine()->id_ciudad}})
                $(this).attr('selected', 'selected');
        });
        // Zona
        $("#col3_filter option").each(function () {
            if ($(this).val() == {{tienda::OnLine()->id_zona}})
                $(this).attr('selected', 'selected');
        });
        fillSelect('#col3_filter','#col4_filter',"{{ url('/zona/getSelectListZonaTienda') }}");
        // Tienda 
        $("#filter_col4 option").each(function () {
            if ($(this).val() == {{tienda::OnLine()->id}})
                $(this).attr('selected', 'selected');
        });	    
    @endif

});
@endsection
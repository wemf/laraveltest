@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Modificar Cláusula</h2>
                <div class="clearfix">
                </div>
            </div>
            <div class="x_content">
                <form id="form-attribute" action="{{ url('/modificarClausulas/update') }}" method="POST" class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    
                <input type="hidden" id="id" name="id" value="{{$clausula[0]->id}}">
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                        <label class=" col-sm-6 col-md-4 col-xs-12" for="pais">País</label>
                        <div class="col-sm-6 col-md-8 col-xs-12">
                        <input type="text" name="pais" class="form-control" value="{{ $clausula[0]->pais }}" readonly>
                        </div>
                        
                        </div>
                        <div class="form-group">
                            <label class=" col-sm-6 col-md-4 col-xs-12" for="departamento">Departamento</label>
                            <div class="col-sm-6 col-md-8 col-xs-12">
                                <input type="text" name="departamento" class="form-control" value="{{ $clausula[0]->departamento }}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" col-sm-6 col-md-4 col-xs-12" for="ciudad">Ciudad</label>
                            <div class="col-sm-6 col-md-8 col-xs-12">
                                <input type="text" name="ciudad" class="form-control" value="{{ $clausula[0]->ciudad }}" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class=" col-sm-6 col-md-4 col-xs-12" for="tienda">Joyería</label>
                            <div class="col-sm-6 col-md-8 col-xs-12">
                                <input type="text" name="tienda" class="form-control" value="{{ $clausula[0]->tienda }}" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="clausula">Nombre de Cláusula</label>
                            <input class="form-control" id="nombreclausula" name="nombreclausula" value="{{$clausula[0]->nombre_clausula}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            
                            <div class="col-md-4">
                                <label>Vigencia Actual</label>
                                <input type="text" name="vigencia_desde" id="vigencia_desde" value="{{dateFormate::ToFormatInverse($clausula[0]->vigencia_desde)}}" class="form-control" readonly>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="clausula">Descripción de Cláusula Vigente</label>
                        <textarea class="form-control" name="clausulavigente"  rows="3" readonly>{{$clausula[0]->descripcion_clausula}}</textarea>
                        </div>
                    </div>
                    @if(count($clausula)>1)
                        
                            <input type="hidden" name="id_detalle" id="id_detalle" value="{{$clausula[1]->id_detalle}}">
                        
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label>Vigencia Desde</label>
                        <input type="text" class="form-control data-picker-only" name="fecha_cracionD" id="fecha_cracionD" maxlength="10" placeholder="Desde" value='{{dateFormate::ToFormatInverse(($clausula[1]->vigencia_desde=="")?date('Y-m-d'):$clausula[1]->vigencia_desde)   }}' autocomplete="off">
                        </div>
                        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="clausula">Descripción de Cláusula Futura</label>
                        <textarea class="form-control" id="clausula" maxlength="500" name="clausula" rows="3">{{($clausula[1]->descripcion_clausula=="")?$clausula[0]->descripcion_clausula:$clausula[1]->descripcion_clausula}}</textarea>
                        </div>
                    </div>
                    @else
                    <div class="col-md-12">
                            <div class="col-md-6">
                                <label>Vigencia Desde</label>
                            <input type="text" class="form-control data-picker-only" name="fecha_cracionD" id="fecha_cracionD" maxlength="10" placeholder="Desde" value='{{dateFormate::ToFormatInverse(date('Y-m-d'))   }}' autocomplete="off">
                            </div>
                            
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="clausula">Descripción de Cláusula Futura</label>
                            <textarea class="form-control" id="clausula" maxlength="500" name="clausula" rows="3">{{$clausula[0]->descripcion_clausula}}</textarea>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-2 col-md-offset-4">
                            <button type="submit" id="btn-save" class="btn btn-success form-control hide">Modificar</button>
                            <button type="button" onclick="saveData();" class="btn btn-success form-control">Modificar</button>
                            {{-- <button class="btn btn-primary" type="reset">Restablecer</button>  --}}                
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 col-md-offset-0"> 
                            <a href="{{ url('/modificarClausulas') }}" class="btn btn-danger form-control" type="button">Cancelar</a>             
                        </div>              
                    </div>
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

function saveData(){
    if( !validate_form.validate_values('vigencia_desde', 'fecha_cracionD', 'datetime', true ) ) {
        Alerta('Información', 'La vigencia desde no puede ser menor o igual a la vigencia actual', 'warning');
    }else{
        $("#btn-save").click();
        
    }
}
@endsection
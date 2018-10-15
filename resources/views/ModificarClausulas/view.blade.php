@extends('layouts.master')
@section('content')
@include('Trasversal.migas_pan.migas')
<div class="row">
    <div class="col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Ver Cláusula</h2>
                <div class="clearfix">
                </div>
            </div>
            <div class="x_content">
                <form id="form-attribute" action="" method="POST" class="form-horizontal form-label-left">
                    
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                        <label class=" col-sm-6 col-md-4 col-xs-12" for="pais">País</label>
                        <div class="col-sm-6 col-md-8 col-xs-12">
                        <input type="text" class="form-control" value="{{ $clausula->pais }}" readonly>
                        </div>
                        
                        </div>
                        <div class="form-group">
                            <label class=" col-sm-6 col-md-4 col-xs-12" for="departamento">Departamento</label>
                            <div class="col-sm-6 col-md-8 col-xs-12">
                                <input type="text" class="form-control" value="{{ $clausula->departamento }}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" col-sm-6 col-md-4 col-xs-12" for="ciudad">Ciudad</label>
                            <div class="col-sm-6 col-md-8 col-xs-12">
                                <input type="text" class="form-control" value="{{ $clausula->ciudad }}" readonly>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class=" col-sm-6 col-md-4 col-xs-12" for="tienda">Joyería</label>
                            <div class="col-sm-6 col-md-8 col-xs-12">
                                <input type="text" class="form-control" value="{{ $clausula->tienda }}" readonly>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            
                            <div class="col-md-4">
                                <label>Desde</label>
                                <input type="text" value="{{dateFormate::ToFormatInverse($clausula->vigencia_desde)}}" class="form-control" readonly>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                        <label for="clausula">Nombre de Cláusula</label>
                        <textarea class="form-control" id="clausula" rows="3" readonly>{{$clausula->nombre_clausula}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="clausula">Descripcion de cláusula</label>
                        <textarea class="form-control" id="clausula" rows="3" readonly>{{$clausula->descripcion_clausula}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                            <div class="col-md-2 col-sm-2 col-xs-2 col-md-offset-5"> 
                                <a href="{{ url('/modificarClausulas') }}" class="btn btn-danger form-control" type="button">Regresar</a>             
                            </div>              
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
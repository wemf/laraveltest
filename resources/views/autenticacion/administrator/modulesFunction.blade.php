@extends('layouts.master') 

@section('head')
<link href="{{asset('/css/autenticacion/administrator/modules.css')}}" rel="stylesheet" /> 
<style>
    .accordion2 > h3 {
        color: white;
        background: rgba(42, 63, 84, 0.37) !important;
        height: 24px;
        padding: 5px !important;
        font-size: 14px !important;
    }  
    label.lbl-check-control {
        color: #4b6886 !important;
    } 
</style>
@endsection

@section('content')
@include('Trasversal.migas_pan.migas')

<div class="x_panel">
    <div class="x_title">
        <h2>Funcionalidades del Rol <b>{{$role}}</b></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">            
			@foreach ($data as $key => $rol)			
			<div class="panel panel-default phd">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{$loop->index}}" aria-expanded="false" aria-controls="collapse_{{$loop->index}}">
					<div class="panel-heading hd" role="tab" id="heading_{{$loop->index}}">
						<h4 class="panel-title">
                                {{$key}}
						</h4>
					</div>
				</a>
				<div id="collapse_{{$loop->index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_{{$loop->index}}">
					<div class="panel-body">
						<div class="row">
						<div class="accordion2">
							@foreach ($rol as $key2 => $funcion)								
                                    <h3>{{$funcion['modulo']}}</h3>
                                    <div>                                        									
										@if(count($funcion['funcionalidad']["id"])>1)
											@for ($j = 0; $j< count($funcion['funcionalidad']["id"]); $j++) 
											<p>	
												<div class="col-xs-12 col-sm-4">
													<input id="a_{{$loop->parent->index}}_{{$loop->index}}_{{$j}}" class='chk_funcionalidad check-control' onclick='funcionAction(this);' type='checkbox' value="{{$funcion['funcionalidad']['id'][$j]}}"
														@if($funcion['funcionalidad']['isChecked'][$j]==true) checked @endif />
													<label for="a_{{$loop->parent->index}}_{{$loop->index}}_{{$j}}" class="lbl-check-control">{{$funcion['funcionalidad']["value"][$j]}}</label>
												</div>
											</p>
											@endfor
										@else
										<p>	
											<div class="col-xs-12 col-sm-4">
												<input id="b_{{$loop->parent->index}}_{{$loop->index}}" class='chk_funcionalidad check-control' onclick='funcionAction(this);' type='checkbox' value="{{$funcion['funcionalidad']['id']}}"
													@if($funcion['funcionalidad']['isChecked']==true) checked @endif />
												<label for="b_{{$loop->parent->index}}_{{$loop->index}}" class="lbl-check-control">{{$funcion['funcionalidad']["value"]}}</label>
											</div>
										</p>
										@endif                                        
                                    </div>  
							@endforeach
						</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="center">			
			<a href="{{route('admin.roles.module')}}" class="btn btn-danger" type="button"><i class="fa fa-reply"></i> Regresar</a>			
		</div>
	</div>
</div>
@endsection 

@push('scripts')
    <script src="{{asset('/js/autenticacion/administrator/modules.js')}}"></script>
@endpush 

@section('javascript')
    URL.setFuncionalidad("{{ route('admin.roles.funcionalidad.update') }}"); 
    URL.setIdRole("{{$idRole}}");
	$( ".accordion2" ).accordion({
      heightStyle: "content"
    });
 @endsection
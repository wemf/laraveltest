@extends('layouts.master')

@section('content')

<div class="x_panel">
  <h2 class="x_title">Administrar Formularios</h2>
      <div class="clearfix"></div>
  <div class="panel-body well2">
    <div class="btn-group pull-right espacio" role="group" aria-label="..." >
		@if(Sentinel::inRole('formUpdate'))
    	 <button title="Actualizar Registro Seleccionado"  id="updateAction" type="button" class="btn btn-success"><i class="fa fa-pencil-square-o  "> Actualizar</i></button>
    @endif    
		@if(Sentinel::inRole('formDelete'))
    	 <button title="Borrar Registro Seleccionado"  id="deletedAction"  type="button" class="btn btn-danger"><i class="fa fa-trash-o "> Borrar</i></button> 
    @endif 	  
    </div> 
      <table id="dataTableAction" class="display" width="100%" cellspacing="0">
         <thead>
            <tr>               
                <th>Formulario</th>               
								<th>Fecha Creación</th> 
								<th>Fecha Actualización</th> 				
            </tr>
        </thead>        
      </table>
  </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('/js/formMotorList.js')}}"></script>
@endpush
@section('javascript')   
  @parent		
	initFormMotorDefiner.setUrlGet("{{url('/form/get')}}")
	initFormMotorDefiner.setUrlSpanish("{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}")
	initFormMotorDefiner.setUrlDelete("{{ url('/form/delete') }}")
	initFormMotorDefiner.setUrlActualizar("{{ url('/definer/update') }}")
	//initFormMotorDefiner.setUrlDuplicated("{{ url('/formmotor/duplicated') }}")
	initFormMotorDefiner.setUrlOpenForm("{{ url('/form/view') }}")
	initFormMotorDefiner.run()	
@endsection




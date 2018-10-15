@extends('layouts.master')

@section('content')

    <div class="container">
        <h1 class="text-info">Maestros Nutibara</h1>   
        <form action="{{url('/motorform/persistence/module/list')}}" method="GET">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Seleccione un maestro para su administración</label>
                <select id="idform" name="idform" class="form-control" required>   
                    <option value="">- Seleccione una opción -</option>
                        @foreach($modules AS $module)
                            @if($module->id == $idform)
                                <option value="{{$module->id}}" selected>{{$module->name}}</option>
                            @else
                                <option value="{{$module->id}}">{{$module->name}}</option>
                            @endif
                        @endforeach                 
                </select>
                <input type="hidden" name="idcompany" value="1">
            </div>
        </form>    
    </div>
    @isset($url)
    <div class="x_panel">
        <div class="x_title">
            <h2>Registros</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="btn-group pull-right espacio" role="group" aria-label="..." >
                <a title="Nuevo Registro" href="{{ url('motorform/persistence/form/list') }}" id="createAction" class="btn btn-primary"><i class="fa fa-plus  "> Nuevo Registro</i></a>
                <button title="Actualizar Registro Seleccionado"  id="updateAction" type="button" class="btn btn-default"><i class="fa fa-pencil-square-o  "> Actualizar</i></button>
                <button title="Borrar Registro Seleccionado"  id="deletedAction"  type="button" class="btn btn-default"><i class="fa fa-trash-o "> Borrar</i></button> 
            </div> 
            <table id="dataTableAction" data-url="{{$url}}">
                <thead>
                    <tr>  
                        <th>#</th>              
                        @foreach($head as $i)
                            @if (!$loop->first)
                                <th>{{$i}}</th>  
                            @endif          
                        @endforeach 
                    </tr>
                </thead>
                <tbody>
                    @foreach ($field as $fila)
                    <tr id="{{$fila->id}}">
                        <td>{{$loop->iteration}}</td>
                        @foreach ($fila as $campo)
                            @if (!$loop->first)
                                <td>{{$campo}}</td> 
                            @endif 
                        @endforeach                
                    </tr>
                    @endforeach                    
                </tbody>    
            </table>
        </div>
    </div>
    @endisset

@endsection

@push('scripts')
@endpush

@section('javascript')
    @parent
     $('#dataTableAction').DataTable( {  
         language: {
            url: "{{url('/plugins/datatable/DataTables-1.10.13/json/spanish.json')}}"
        },
    } );

    $("#deletedAction").click(function() { 
        var url2="{{url('/motorform/persistence/form/delete')}}"
        deleteRowDatatableAction2(url2)
    });

    $("#updateAction").click(function() { 
        var url2="{{url('/motorform/persistence/form/view/update')}}"
        updateRowDatatableAction2(url2)
    });

    function deleteRowDatatableAction2(url2){ 
        var table = $('#dataTableAction').DataTable(); 
        var valueId=table.$('tr.selected').attr('id');   
        var post={
            id:valueId,
            url:$('#dataTableAction').attr('data-url')
        };          
        if(valueId!=null){
            var r = confirm("¿Borrar el registro?");//Cambiar por uno bonito
            if (r == true) //Cambiar por uno bonito
            {                     
                var action=actionAjax(post,url2);
                if(action){        
                    table.row('tr.selected').remove().draw();             
                }        
            }
        }else{
            Alerta('Error', 'Seleccione un registro.','error')       
        } 
    }

    function updateRowDatatableAction2(url2){  
        var table = $('#dataTableAction').DataTable();  
        var valueId=table.$('tr.selected').attr('id');  
        var url=$('#dataTableAction').attr('data-url');   
        var arrayUrl = url.split("/"); 
        if(valueId!=null){
            window.location=url2+'/'+arrayUrl[0]+'/'+arrayUrl[1]+'/'+valueId;
        }else{
            Alerta('Error', 'Seleccione un registro.','error')       
        }
    }

    $('#idform').change(function(){
        $('form').submit();
    });
    
@endsection
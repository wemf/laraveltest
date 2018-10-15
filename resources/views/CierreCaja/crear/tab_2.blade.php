
<div class="row">	
    <div class="x_title">
        <h2>{{$ReporteCierreCaja[1]->clase}}</h2>
        <div class="clearfix"></div>
    </div>
    @for($i=1; $i< 39; $i++)
            @if($i != 1 && $ReporteCierreCaja[$i]->clase != $ReporteCierreCaja[$i-1]->clase)
            <div class="x_title">
                <h2>{{$ReporteCierreCaja[$i]->clase}}</h2>
                <div class="clearfix"></div>
            </div>
            @endif
            <div class="form-group">
                    <label class="control-label col-xs-2">{{$ReporteCierreCaja[$i]->subclase}}</span></label>
                <div class="col-xs-8">
                    <input readOnly type="text" id="ingresos_{{$ReporteCierreCaja[$i]->subclase}}" name="ingresos_{{$ReporteCierreCaja[$i]->subclase}}" class="form-control" value='{{$ReporteCierreCaja[$i]->valor}}'>        
                </div>
            </div>
    @endfor
    <div class="x_title"><div class="clearfix"></div></div>
    <div class="center">
        <button type="button" class="btn btn-primary btn-recorrido" data-id-div="tabs-2" data-anterior="1" data-href="tabs-1" next="ui-id-1"><i class="fa fa-angle-left" aria-hidden="true"></i> Anterior</button>
        <button type="button" class="btn btn-success btn-recorrido" data-id-div="tabs-2" data-anterior="1" data-href="tabs-3" next="ui-id-3">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
	</div>
</div>
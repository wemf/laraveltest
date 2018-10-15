<br>
<div class="row">	
    <div class="col-md-12 col-xs-12">	
        <div class="item_refac notop hidefilters">
            <table class="table table-hover dataTableAction display">
                <thead>
                    <tr>
                        <th colspan="3" style = 'text-align:center;'>Caja Menor</th>
                        <th colspan="3" style = 'text-align:center;'>Caja Fuerte</th>
                        </tr>
                        <tr>
                        <th>Denominaci&oacute;n</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Denominaci&oacute;n</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($Monedas as $Moneda)                
                    <tr>
                        <td>
                            <label class='denominacionesmenor' name='denominacionmenor[]' >{{ $Moneda->denominacion }}</label>
                            <input type="hidden" class='valormenor' name='valormenor[]' value= '{{$Moneda->valor}}'>                                                        
                        </td>
                        <td>
                            <input type="text" class='form-control cantidadesmenor' name='cantidadmenor[]' value='0' onkeypress="return isNumber(event);">
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input readOnly type="text" class="moneda form-control totalmenor" name="totalmenor[]" maxlength="15" value='0' aria-label="Amount (to the nearest dollar)">
                            </div>
                        </td>
                        <td>
                            <label class='denominacionesmayor' name='denominacionfuerte[]' > {{ $Moneda->denominacion }}</label>     
                            <input type="hidden" class='valorfuerte' name='valorfuerte[]'  value= '{{$Moneda->valor}}'>                                                                           
                        </td>
                        <td>
                            <input type="text" class='form-control cantidadesfuerte' name='cantidadfuerte[]' value='0' onkeypress="return isNumber(event);">                
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input readOnly type="text" class="moneda form-control totalfuerte" name="totalfuerte[]" maxlength="15" value='0' aria-label="Amount (to the nearest dollar)">
                            </div>                                                       
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="x_title"><div class="clearfix"></div></div>
    <div class="center">
        <button type="button" class="btn btn-primary btn-recorrido" data-id-div="tabs-2" data-anterior="1" data-href="tabs-1" next="ui-id-1"><i class="fa fa-angle-left" aria-hidden="true"></i> Anterior</button>
        <button type="button" class="btn btn-success btn-recorrido" data-id-div="tabs-2" data-anterior="1" data-href="tabs-3" next="ui-id-3">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
	</div>
</div>
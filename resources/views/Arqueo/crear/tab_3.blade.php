<br>
<div class="row">	
	<div class="x_title"><h2>Datos Generales</h2><div class="clearfix"></div></div>
	<div class="col-md-6 col-xs-12">

		<div class="form-group">
			<label class="control-label col-xs-4">Total Caja Menor</span></label>
            <div class="input-group col-xs-8">
                <span class="input-group-addon">$</span>
                <input readOnly type="text" class="moneda form-control totalcajamenor" name="totalcajamenor" maxlength="15" value='0' aria-label="Amount (to the nearest dollar)">
            </div> 
		</div>
		
		<div class="form-group">
			<label class="control-label col-xs-4">Total Caja Fuerte</span></label>
            <div class="input-group col-xs-8">
                <span class="input-group-addon">$</span>
                <input readOnly type="text" class="moneda form-control totalcajafuerte" name="totalcajafuerte" maxlength="15" value='0' aria-label="Amount (to the nearest dollar)">
            </div>       
		</div>

        <div class="form-group">
			<label class="control-label col-xs-4">Total Sistema</span></label>
            <div class="input-group col-xs-8">
                <span class="input-group-addon">$</span>
                <input readOnly type="text" class="moneda form-control total_sistema" name="total_sistema" maxlength="15" value='0' aria-label="Amount (to the nearest dollar)">
            </div>    
		</div>

        <div class="form-group">
			<label class="control-label col-xs-4">Total F&iacute;sico</span></label>
            <div class="input-group col-xs-8">
                <span class="input-group-addon">$</span>
                <input readOnly type="text" class="moneda form-control totalfisico" name="totalfisico" maxlength="15" value='0' aria-label="Amount (to the nearest dollar)">
            </div>    
		</div>
	</div>

	<div class="col-md-6 col-xs-12">
        <div class="form-group">
			<label class="control-label col-xs-4">Sobrante</span></label>
            <div class="input-group col-xs-7">
                <span class="input-group-addon">$</span>
                <input readOnly type="text" class="moneda form-control sobrante" name="sobrante" maxlength="15" value='0' aria-label="Amount (to the nearest dollar)">
            </div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4">Faltante</span></label>
            <div class="input-group col-xs-7">
                <span class="input-group-addon">$</span>
                <input readOnly type="text" class="moneda form-control faltante" name="faltante" maxlength="15" value='0' aria-label="Amount (to the nearest dollar)">
            </div>
		</div>
	</div>
</div>
<div class="row">	
	<div class="x_title"><h2>Observaciones</h2><div class="clearfix"></div></div>
	<div class="col-md-12 col-xs-12">
        <textarea name="observaciones" id="observaciones" style = 'width : 100% !important; overflow:auto; resize:none;' draggable="false" maxlength="255" rows="10" cols="20"></textarea>
    </div>
</div>
<div class="x_title"><div class="clearfix"></div></div>
<div class="center">
@if(isset($cierreCaja))
    <input  type="button" class="btn btn-success continuar hide" id="continuar" value='Continuar'>
@endif
  <button type="submit" class="btn btn-success" id='arqueoConfirm'></i> Imprimir</button>
@if(!isset($cierreCaja))  
  <button type="button" class="btn btn-primary hide" id='terminararqueo'></i>Terminar Arqueo</button>
@endif
  
</div>
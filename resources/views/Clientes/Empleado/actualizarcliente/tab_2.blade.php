<br>
<div class="row">	
    <div class="col-md-6 col-xs-12">	
        <div class="form-group">
            <label class="control-label col-xs-4">Tipo Contrato <span class="required ">*</span>
            </label>
            <div class="col-xs-8">
                <select id="id_contrato" name="id_contrato" class="id_contrato form-control obligatorio requiered">
                    <option value="">- Seleccione una opción -</option>
                    @foreach($tipo_contrato as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                    @endforeach  
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-4">Salario <span class="required">*</span>
            </label>
            <div class="col-xs-8">
                <!-- <input type="text" id="id_salario" name="salario" maxlength="12" class="form-control obligatorio numeric requiered"> -->
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="moneda form-control centrar-derecha" value="{{$attribute->salario}}" name="id_salario" id="id_salario" maxlength="15" aria-label="Amount (to the nearest dollar)">
                </div>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-xs-4">Valor auxilio vivienda
            </label>
            <div class="col-xs-8">
                <!-- <input type="text" id="id_valor_auxilio_vivenda" maxlength="12" name="valor_auxilio_vivenda" class="form-control numeric "> -->
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="moneda form-control centrar-derecha" name="id_valor_auxilio_vivenda" id="id_valor_auxilio_vivenda" value="{{$attribute->valor_auxilio_vivenda}}" maxlength="15" aria-label="Amount (to the nearest dollar)">
                </div>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-xs-4">Valor auxilio transporte
            </label>
            <div class="col-xs-8">
                <!-- <input type="text" id="id_valor_auxilio_transporte" maxlength="12" name="valor_auxilio_transporte" class="form-control numeric "> -->
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="moneda form-control centrar-derecha" name="id_valor_auxilio_transporte" id="id_valor_auxilio_transporte" value="{{$attribute->valor_auxilio_transporte}}" maxlength="15" aria-label="Amount (to the nearest dollar)">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-4">Fecha Ingreso<span class="required">*</span>
            </label>
            <div class="col-xs-8">
                <input readonly id="fecha_ingreso" name="fecha_ingreso" value="{{$attribute->fecha_ingreso}}" class="form-control data-picker-only obligatorio obligatorio requiered">
            </div>
        </div> 
        <div class="clearfix"></div>
    </div>
    <div class="col-md-6 col-xs-12">	

        <div class="form-group">
            <label class="control-label col-xs-4">Fondo de Cesantías<span class="required">*</span>
            </label>
            <div class="col-xs-8">
                <select id="id_fondo_cesantias" name="id_fondo_cesantias" class="form-control obligatorio requiered">
                    <option value="">- Seleccione una opción -</option>
                    @foreach($fondo_cesantias as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                    @endforeach 
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-4">Fondo de Pensiones<span class="required">*</span>
            </label>
            <div class="col-xs-8">
                <select id="id_fondo_pensiones" name="id_fondo_pensiones" class="form-control obligatorio requiered">
                    <option value="">- Seleccione una opción -</option>
                    @foreach($fondo_pensiones as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                    @endforeach  
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-4">EPS<span class="required">*</span>
            </label>
            <div class="col-xs-8">
                <select id="id_eps" name="id_eps" class="form-control id_eps obligatorio">
                    <option value="">- Seleccione una opción -</option>
                    @foreach($eps as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                    @endforeach  
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-4">Caja de compensación familiar<span class="required">*</span>
            </label>
            <div class="col-xs-8">
                <select id="id_caja_compensacion" name="id_caja_compensacion" class="form-control obligatorio">
                    <option value="">- Seleccione una opción -</option>
                    @foreach($caja_compensacion as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                    @endforeach  
                </select>
            </div>
        </div>
    </div>
    <div class="x_title"><div class="clearfix"></div></div>
    <div class="center">
        <button type="button" class="btn btn-primary btn-recorrido" data-id-div="tabs-2" data-anterior="1" data-href="tabs-1" next="ui-id-1"><i class="fa fa-angle-left" aria-hidden="true"></i> Anterior</button>
        <button type="button" class="btn btn-success btn-recorrido" data-id-div="tabs-2" data-href="tabs-3" next="ui-id-3">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
	</div>
</div>
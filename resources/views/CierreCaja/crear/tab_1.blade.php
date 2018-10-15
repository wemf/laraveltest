
<div class="row">	
    <div class="x_title">
    <h2>Datos Generales</h2>
    <div class="clearfix"></div>
    </div>
    <div class="col-md-6 col-xs-12">

         <div class="form-group">
                <label class="control-label col-xs-4">Tienda</span></label>
            <div class="col-xs-8">
                <input readOnly type="text" id="tienda" name="tienda" class="form-control" value='{{$Tienda}}'>        
            </div>
        </div>	

        <div class="form-group">
                <label class="control-label col-xs-4">Información de la Tienda</span></label>
            <div class="col-xs-8">
                <input readOnly type="text" id="info_tienda" name="info_tienda" class="form-control" value='{{$InfoTienda->Direccion}}, {{$InfoTienda->Ciudad}}, {{$InfoTienda->Telefono}}'>        
            </div>
        </div>
            
        <div class="form-group">
                <label class="control-label col-xs-4">Regimen de la Sociedad</span></label>
            <div class="col-xs-8">
                <input readOnly type="text" id="regimen" name="regimen" class="form-control" value='{{$InfoTienda->Regimen}}'>        
            </div>
        </div>

        <div class="form-group">
                <label class="control-label col-xs-4">Usuario</span></label>
            <div class="col-xs-8">
                <input readOnly type="text" id="usuario" name="usuario" class="form-control" value = '{{$Usuario}}'>        
            </div>
        </div>

        <div class="form-group">
                <label class="control-label col-xs-4">Sociedad</span></label>
            <div class="col-xs-8">
                <input readOnly type="text" id="sociedad" name="sociedad" class="form-control" value='{{$InfoTienda->Sociedad}}'>        
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">

        <div class="form-group">
                <label class="control-label col-xs-4">Comprobante Arqueo de Caja</span></label>
            <div class="col-xs-7">
                <input readOnly type="text" id="comprobante_arqueo" name="comprobante_arqueo" class="form-control" value='{{$UltimoArqueo}}'>        
            </div>
        </div>

        <div class="form-group">
                <label class="control-label col-xs-4">Franquicia</span></label>
            <div class="col-xs-7">
                <input readOnly type="text" id="franquicia" name="franquicia" class="form-control" value='{{$InfoTienda->Franquicia}}'>        
            </div>
        </div>
            
        <div class="form-group">
                <label class="control-label col-xs-4">Fecha</span></label>
            <div class="col-xs-7">
                <input readOnly type="text" id="fecha" name="fecha" class="form-control fecha" value = '{{$Fecha}}'>         
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="x_title">

        <h2>Saldos del Sistema</h2>
        <div class="clearfix"></div>

        <div class="form-group">
                <label class="control-label col-xs-2">Fecha Inicial</span></label>
            <div class="col-xs-8">
                <input readOnly type="text" id="fecha_saldo_inicial" name="fecha_saldo_inicial" class="form-control" value='{{$CierreCajaActual->fecha_inicio}}'>        
            </div>
        </div>

        <div class="form-group">
                <label class="control-label col-xs-2">Fecha Fin</span></label>
            <div class="col-xs-8">
                <input readOnly type="text" id="fecha_saldo_inicial" name="fecha_saldo_inicial" class="form-control" value='{{$Fecha}}'>        
            </div>
        </div>

        <div class="form-group">
                <label class="control-label col-xs-2">Saldo Inicial</span></label>
            <div class="col-xs-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input readOnly type="text" class="moneda form-control centrar-derecha saldo_inicial" name="saldo_inicial" id="saldo_inicial" maxlength="15" aria-label="Amount (to the nearest dollar)" value='{{$CierreCajaActual->saldo_inicial}}'>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Ingresos</span></label>
            <div class="col-xs-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input readOnly type="text" class="moneda form-control centrar-derecha ingresos" name="ingresos" id="ingresos" maxlength="15" aria-label="Amount (to the nearest dollar)" value='{{$Ingresos}}'>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Egresos</span></label>
            <div class="col-xs-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input readOnly type="text" class="moneda form-control centrar-derecha egresos" name="egresos" id="egresos" maxlength="15" aria-label="Amount (to the nearest dollar)" value='{{$Egresos}}'>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Total Sistema</span></label>
            <div class="col-xs-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input readOnly type="text" class="moneda form-control centrar-derecha total_sistema" name="total_sistema" id="total_sistema" maxlength="15" aria-label="Amount (to the nearest dollar)">
                </div>
            </div>
        </div>
    </div>
    
    <div class="x_title">
        <div class="clearfix"></div>
    </div>
    <div class="center">
        <button type="button" class="btn btn-success btn-recorrido tb1" data-id-div="tabs-1" next="ui-id-2" data-href="tabs-2">Siguiente <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
    </div>
</div>















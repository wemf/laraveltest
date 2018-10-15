    <div class="contentfilter-table">
      <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
        <tbody>
            <tr id="filter_col0" data-column="0">
                  <td>País
                    <select type="text" class="column_filter form-control" id="col0_filter">
                        <option value> -Seleccione una opción - </option>                                            
                    </select>
                </td>  
            </tr>
            <tr id="filter_col1" data-column="1">
                <td>Departamento<select type="text" class="column_filter form-control" id="col1_filter">
                <option value> -Seleccione una opción - </option>
                </select></td>
            </tr>
            <tr id="filter_col2" data-column="2">
                <td>Ciudad<select type="text" class="column_filter form-control" id="col2_filter">
                <option value> -Seleccione una opción - </option>
                </select></td>
            </tr>
            <tr id="filter_col3" data-column="3">
                <td>Zona<select type="text" class="column_filter form-control" id="col3_filter">
                <option value> -Seleccione una opción - </option>
                </select></td>
            </tr>
            <tr id="filter_col4" data-column="4">
                <td>Joyería<select type="text" class="column_filter form-control" id="col4_filter">
                <option value> -Seleccione una opción - </option>
                </select></td>
            </tr>
            <tr id="filter_col5" data-column="5">
                <td>Tipo Documento
                    <select type="text" class="column_filter form-control" id="col5_filter">
                        <option value> -Seleccione una opción - </option>
                    </select>
                </td>                
            </tr>
            <tr id="filter_col6" data-column="6">
                <td>Número Documento<input type="text" class="column_filter form-control" id="col6_filter"></td>
            </tr>          
            <tr id="filter_col7" data-column="7">
                <td>Nombres<input type="text" class="column_filter form-control" id="col7_filter"></td>
            </tr>
            </tr>
            <tr id="filter_col8" data-column="8">
                <td>Primer Apellido<input type="text" class="column_filter form-control" id="col8_filter"></td>
            </tr>
            <tr id="filter_col9" data-column="9">
                <td>Tipo Cliente
                    <select id="col9_filter" class="column_filter form-control">
                        <option value="">- Seleccione una opción -</option>
                        @if(isset($tipo_cliente))                        
                            @foreach($tipo_cliente as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                            @endforeach
                        @endif
                    </select>                
                </td>
            </tr>  
            <tr id="filter_col10" data-column="10">
                <td>Cargo
                    <select id="col10_filter" class="column_filter form-control">
                        <option value="">- Seleccione una opción -</option>
                        @if(isset($cargo_empleado))
                            @foreach($cargo_empleado as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                            @endforeach  
                        @endif
                    </select>                
                </td>
            </tr>      
            <tr id="filter_col11" class="no-width" data-column="11">
                <td>
                    Inactivos
                    <input type="checkbox" onchange="intercaleCheckInvert(this);" id="col11_filter" class="column_filter check-control check-pos" value="1" />
                    <label for="col11_filter" class="lbl-check-control" style="font-size: 27px!important; font-weight: 100; height: 26px; display: block;"></label>
                </td>
            </tr>
            <tr>
                <td><button type="button" onclick="intercaleFunction('col11_filter');" class="btn btn-primary button_filter"><i class="fa fa-search"></i> Buscar</button></td>
            </tr>
        </tbody>
      </table>
    </div>
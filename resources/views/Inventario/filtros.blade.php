<input type="checkbox" name="chk-filter-table" id="chk-filter-table" checked>
<label class="btn-filter-table" for="chk-filter-table">Filtros
    <i class="fa fa-angle-down"></i>
</label>
<div class="contentfilter-table">
    <table cellpadding="3" class="table-filter" cellspacing="0" border="0" style="width: 100%; margin: 30px 10px;">
        <tbody>
            <tr id="filter_col0" data-column="0">
                <td>País
                    <select type="text" class="column_filter form-control" id="col0_filter" onchange="loadSelectInputByParent('#col1_filter', '{{url('/departamento/getdepartamentobypais')}}', this.value, 1);">
                        <option value> -Seleccione una opción - </option>
                    </select>
                </td>
            </tr>

            <tr id="filter_col1" data-column="1">
                <td>Departamento
                    <select type="text" class="column_filter form-control" id="col1_filter" onchange="loadSelectInputByParent('#col2_filter', '{{url('/ciudad/getciudadbydepartamento')}}', this.value, 1)">
                        <option value> -Seleccione una opción - </option>
                    </select>
                </td>
            </tr>

            <tr id="filter_col2" data-column="2">
                <td>Ciudad
                    <select type="text" class="column_filter form-control" id="col2_filter" onchange="loadSelectInputByParent('#col3_filter', '{{url('/tienda/gettiendabyzona')}}', this.value, 1)">
                        <option value> -Seleccione una opción - </option>
                    </select>
                </td>
            </tr>

            <tr id="filter_col3" data-column="3">
                <td>Tienda
                    <select type="text" class="column_filter form-control" id="col3_filter">
                        <option value> -Seleccione una opción - </option>
                    </select>
                </td>
            </tr>

            <tr id="filter_col4" data-column="4">
                <td>Lote
                    <input type="text" class="column_filter form-control" id="col4_filter">
                </td>
            </tr>

            <tr id="filter_col5" data-column="5">
                <td>Categoria
                    <input type="text" class="column_filter form-control" id="col5_filter">
                </td>
            </tr>

            <tr id="filter_col6" data-column="6">
                <td>Referencia
                    <input type="text" class="column_filter form-control" id="col6_filter">
                </td>
            </tr>

            <tr id="filter_col7" data-column="7">
                <td>Fecha Ingreso
                    <input type="text" class="data-picker-only column_filter form-control" id="col7_filter">
                </td>
            </tr>

            <tr id="filter_col8" data-column="8">
                <td>Fecha Salida
                    <input type="text" class="data-picker-only column_filter form-control" id="col8_filter">
                </td>
            </tr>

            <tr id="filter_col9" data-column="9">
                <td>Estado
                    <select type="text" class="column_filter form-control" id="col9_filter">
                        <option value> -Seleccione una opción - </option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <button type="button" class="btn btn-primary button_filter">
                        <i class="fa fa-search"></i> Buscar</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
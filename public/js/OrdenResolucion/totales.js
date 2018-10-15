var total_valor_contratos = 0,
    total_contratos = 0,
    valor_contrato = 0,
    total_peso_contratos = 0,
    total_peso_estimado_contratos = 0,
    total_peso_taller = 0,
    total_peso_final = 0,
    peso_contrato = 0,
    peso_estimado_contrato = 0,
    cantidad_items = 0,
    total_cantidad_items = 0;


function totales_resolucion() {
    $('.totales_resolucion tbody').on('click', '.check-resolucionar', function () {
        if (!$(this).find('td').hasClass('dataTables_empty')) {
            valor_contrato = ($(this).parent().parent().parent().find('td.var_valor_contrato').text() != '') ? ($(this).parent().parent().parent().find('td.var_valor_contrato').text().replace(/\./g, '').replace(',', '.')) : '$ 0';
            valor_contrato = parseFloat(valor_contrato.split('$ ')[1]);
            peso_contrato = ($(this).parent().parent().parent().find('td.var_peso_contrato').text() != '') ? parseFloat($(this).parent().parent().parent().find('td.var_peso_contrato').text().replace(',','.')) : 0;
            peso_taller = ($(this).parent().parent().parent().find('td.var_peso_taller').text() != '') ? parseFloat($(this).parent().parent().parent().find('td.var_peso_taller').text().replace(',','.')) : 0;
            peso_final = ($(this).parent().parent().parent().find('td.var_peso_final').text() != '') ? parseFloat($(this).parent().parent().parent().find('td.var_peso_final').text().replace(',','.')) : 0;
            peso_estimado_contrato = ($(this).parent().parent().parent().find('td.var_peso_estimado_contrato').text() != '') ? parseFloat($(this).parent().parent().parent().find('td.var_peso_estimado_contrato').text().replace(',','.')) : 0;
            cantidad_items = ($(this).parent().parent().parent().find('td.var_cantidad_items').text() != '') ? parseInt($(this).parent().parent().parent().find('td.var_cantidad_items').text()) : 0;

            valor_contrato = (valor_contrato == NaN || valor_contrato == "NaN") ? 0 : valor_contrato;
            peso_contrato = (peso_contrato == NaN) ? 0 : peso_contrato;
            peso_taller = (peso_taller == NaN) ? 0 : peso_taller;
            peso_final = (peso_final == NaN) ? 0 : peso_final;
            peso_estimado_contrato = (peso_estimado_contrato == NaN) ? 0 : peso_estimado_contrato;
            cantidad_items = (cantidad_items == NaN) ? 0 : cantidad_items;
            if ($(this).val() == '1') {
                total_valor_contratos -= valor_contrato;
                total_peso_contratos -= peso_contrato;
                total_peso_taller -= peso_taller;
                total_peso_final -= peso_final;
                total_peso_estimado_contratos -= peso_estimado_contrato;
                total_cantidad_items -= cantidad_items;
                --total_contratos;
                $('#all_check').prop('checked', false);
                $('#all_check').val('0');
            } else {
                total_valor_contratos += valor_contrato;
                total_peso_contratos += peso_contrato;
                total_peso_taller += peso_taller;
                total_peso_final += peso_final;
                total_peso_estimado_contratos += peso_estimado_contrato;
                total_cantidad_items += cantidad_items;
                ++total_contratos;
            }
            $('#lbl_total_valor_contratos').text(money.replace((total_valor_contratos.toFixed(money.getNumDecimal())).toString().replace(/\./g, ',')));
            $('#lbl_total_peso_contratos').text(((total_peso_contratos.toFixed(2)).toString().replace(/\./g, ',')));
            $('#lbl_total_peso_taller').text(((total_peso_taller.toFixed(2)).toString().replace(/\./g, ',')));
            $('#lbl_total_peso_final').text(((total_peso_final.toFixed(2)).toString().replace(/\./g, ',')));
            $('#lbl_estimado_peso_contratos').text(((total_peso_estimado_contratos.toFixed(2)).toString().replace(/\./g, ',')));
            $('#lbl_total_cantidad_items').text(((total_cantidad_items).toString()));
            $('#lbl_total_contratos').text(money.replace((total_contratos).toString()));
        }
    });

    $('#all_check').click(function () {
        if ($(this).prop('checked')) {
            $('.check-resolucionar').prop('checked', true);
            $('.check-resolucionar').val('1');
            total_valor_contratos = 0;
            total_peso_contratos = 0;
            total_peso_estimado_contratos = 0;
            total_cantidad_items = 0;
            total_contratos = 0;
            $('.totales_resolucion tbody tr').find('td.var_valor_contrato').each(function () {
                valor_contrato = ($(this).text() != '') ? ($(this).text().replace(/\./g, '').replace(',', '.')) : '$ 0';
                valor_contrato = parseFloat(valor_contrato.split('$ ')[1]);
                peso_contrato = ($(this).parent().find('td.var_peso_contrato').text() != '') ? parseFloat($(this).parent().find('td.var_peso_contrato').text().replace(',','.')) : 0;
                peso_estimado_contrato = ($(this).parent().find('td.var_peso_estimado_contrato').text() != '') ? parseFloat($(this).parent().find('td.var_peso_estimado_contrato').text().replace(',','.')) : 0;
                cantidad_items = ($(this).parent().find('td.var_cantidad_items').text() != '') ? parseInt($(this).parent().find('td.var_cantidad_items').text()) : 0;
                peso_taller = ($(this).parent().find('td.var_peso_taller').text() != '') ? parseFloat($(this).parent().find('td.var_peso_taller').text().replace(',','.')) : 0;
                peso_final = ($(this).parent().find('td.var_peso_final').text() != '') ? parseFloat($(this).parent().find('td.var_peso_final').text().replace(',','.')) : 0;
                valor_contrato = (valor_contrato == NaN) ? 0 : valor_contrato;
                peso_contrato = (peso_contrato == NaN) ? 0 : peso_contrato;
                peso_estimado_contrato = (peso_estimado_contrato == NaN) ? 0 : peso_estimado_contrato;
                peso_taller = (peso_taller == NaN) ? 0 : peso_taller;
                peso_final = (peso_final == NaN) ? 0 : peso_final;
                cantidad_items = (cantidad_items == NaN) ? 0 : cantidad_items;
                total_valor_contratos += valor_contrato;
                total_peso_contratos += peso_contrato;
                total_peso_estimado_contratos += peso_estimado_contrato;
                total_cantidad_items += cantidad_items;
                total_peso_taller += peso_taller;
                total_peso_final += peso_final;
                ++total_contratos;
            });
        } else {
            $('.check-resolucionar').prop('checked', false);
            $('.check-resolucionar').val('0');
            total_valor_contratos = 0;
            total_peso_contratos = 0;
            total_peso_estimado_contratos = 0;
            total_cantidad_items = 0;
            total_contratos = 0;
            total_peso_taller = 0;
            total_peso_final = 0;
        }
        $('#lbl_total_valor_contratos').text(money.replace((total_valor_contratos.toFixed(money.getNumDecimal())).toString().replace(/\./g, ',')));
        $('#lbl_total_peso_contratos').text(money.replace((total_peso_contratos.toFixed(2)).toString().replace(/\./g, ',')));
        $('#lbl_estimado_peso_contratos').text(money.replace((total_peso_estimado_contratos.toFixed(2)).toString().replace(/\./g, ',')));
        $('#lbl_total_cantidad_items').text(((total_cantidad_items).toString()));
        $('#lbl_total_contratos').text(money.replace((total_contratos).toString()));
        $('#lbl_total_peso_taller').text(money.replace((total_peso_taller.toFixed(2)).toString().replace(/\./g, ',')));
        $('#lbl_total_peso_final').text(money.replace((total_peso_final.toFixed(2)).toString().replace(/\./g, ',')));
    });
}

function limpiarVal(val) {
    var v = val.split('.');
    var valLimpiar = val.replace(/\./g, '');
    valLimpiar = valLimpiar.replace(',', '.', valLimpiar);
    valLimpiar = valLimpiar.trim(valLimpiar);
    return valLimpiar;
}
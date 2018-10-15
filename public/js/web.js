var $CANT_BREADCRUMBS = 0;
$(document).ready(function() {
    //Wizard step
    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content');
    allBtnStep = $('.btn-step')

    allWells.hide();

    navListItems.click(function(e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);
        var targetMe = $(this).attr('href');
        if (!$item.hasClass('disabled')) {
            targetMe = targetMe.replace('#', '');
            navListItems.removeClass('btn-primary').addClass('btn-default');
            allBtnStep.hide();
            allBtnStep.each(function() {
                var idBtnStep = $(this).attr('id').replace('Btn', '');
                if (idBtnStep == targetMe) {
                    $(this).show();
                }
            });
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    $('div.setup-panel div a.btn-primary').trigger('click');

    $('.multi-select').searchableOptionList();

    //Select datables
    $('#dataTableAction tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            var table = $('#dataTableAction').DataTable();
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    //Select datables
    $('#dataTableActionExport tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            var table = $('#dataTableAction').DataTable();
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });



    //datetimepicker 
    $('.form_datetime').datetimepicker({
        language: 'es',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1.
    });

    $(function() {
        $(".datepicker-years").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0', // specifying a hard coded year range
        });
    });

    $(".form_datetime input").each(function() {
        var id = $(this).prop('id');
        var startDate = $(this).prop('min');
        var endDate = $(this).prop('max');
        if (startDate != '') {
            $("#div_" + id).datetimepicker('setStartDate', startDate);
        }
        if (endDate != '') {
            $("#div_" + id).datetimepicker('setEndDate', endDate);
        }
    });
    //Fin datetimepicker


    //Datepicker Jquery 
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '< Ant',
        nextText: 'Sig >',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };

    $.datepicker.setDefaults($.datepicker.regional['es']);

    $(".form_date").each(function() {
        var id = $(this).prop('id');
        var startDate = $(this).prop('min');
        var endDate = $(this).prop('max');
        if (startDate != '' && endDate == '') {
            $("#" + id).datepicker({ minDate: new Date(startDate) });
        } else if (startDate == '' && endDate != '') {
            $("#" + id).datepicker({ maxDate: new Date(endDate) });
        } else if (startDate != '' && endDate != '') {
            $("#" + id).datepicker({ minDate: new Date(startDate), maxDate: new Date(endDate) });
        } else {
            $("#" + id).datepicker();
        }
    });
    //Fin Datepicker

    //carga datables no Ajax
    $('.dataTables-no-ajax').DataTable({
        language: {
            url: urlBase.make('plugins/datatable/DataTables-1.10.13/json/spanish.json')
        }
    });

    // Recorre todos los switches para validar si es 1 ponerlo chequeado
    $('.switch_check input').each(function(){
        if($(this).val() == 1)
            $(this).prop('checked');
    });

    // Definición de variable con cantidad de items en migas de pan
    // Para la transmutación de las migas de pan
    $CANT_BREADCRUMBS = $(".breadcrumbs li").length;
    transmutacionBreadcrumbs();



    // Función para limpiar campo ciudad general
    var id_pais = "";
    var id_departamento = "";
    var id_ciudad = "";
    var cant_pais = 0;
    $('.table-filter select.column_filter').each(function(){
        var text = ($(this).parent().text());
        text = text.split(' ')[0];
        switch (text.replace("-", "").trim()) {
            case "País":
                id_pais = $(this).attr('id');
                ++cant_pais;
                break;
            case "Departamento":
                id_departamento = $(this).attr('id')
                break;
            case "Ciudad":
                id_ciudad = $(this).attr('id')
                break;
        
            default:
                break;
        }        
    });
    if(id_pais != "" && id_departamento != "" && id_ciudad != "" && cant_pais == 1)
        addEventLocation(id_pais, id_departamento, id_ciudad);
    else{
        id_pais = "";
        id_departamento = "";
        id_ciudad = "";
        cant_pais = 0;
        $('.form-group select.form-control').each(function(){
            var text = ($(this).parent().siblings("label").text());
            text = text.split(' ')[0];
            switch (text.replace("-", "").replace("*", "").trim()) {
                case "País":
                    id_pais = $(this).attr('id');
                    ++cant_pais;
                    break;
                case "Departamento":
                    id_departamento = $(this).attr('id')
                    break;
                case "Ciudad":
                    id_ciudad = $(this).attr('id')
                    break;
            
                default:
                    break;
            }        
        });
        if(id_pais != "" && id_departamento != "" && id_ciudad != "" && cant_pais == 1)
            addEventLocation(id_pais, id_departamento, id_ciudad);
    }

});

function addEventLocation(id_pais, id_departamento, id_ciudad){

    pais = document.getElementById(id_pais);
    console.log(id_pais);
    pais.addEventListener(
        'change',
        function() { clearSelects([[id_ciudad, 'delete_options']], null); },
        false
    );
}


function transmutacionBreadcrumbs(){
    var $EXIST_CURRENT_PAGE = false;
    var $OPEN_MENU = true;
    var $CURRENT_URL = "";
    
    while(!$EXIST_CURRENT_PAGE && $CANT_BREADCRUMBS > 0){
        $('#sidebar-menu .current-page').each(function(){
            $EXIST_CURRENT_PAGE = true;
        });
        $CURRENT_URL = $('.breadcrumbs').find('li:nth-child(' + $CANT_BREADCRUMBS-- + ') a').attr('href');
        $('#sidebar-menu').find('a[href="' + $CURRENT_URL + '"]').parent('li').addClass('current-page');
    }

    $('.side-menu li.active').each(function(){
        $OPEN_MENU = false;
    });

    // Este código funciona para el menú de tres niveles, si el menú llegase a crecer se debe cambiar para uno dinámico
    if($OPEN_MENU){
        $('.current-page').parent('ul').parent('li').parent('ul').parent('li').find('> a').click();
        $('.current-page').parent('ul').parent('li').find('> a').click();
    }
}

function refreshClick(item, fun) {
    var myEl = document.querySelectorAll(item);
    [].forEach.call(myEl, function(myEls) {
        myEls.addEventListener('click', fun, false);
    });
}

/* Función para mandar valor true o false con los inputs tipo checkbox */
function intercaleCheck(checkbox) {
    if ($(checkbox).val() == "1") {
        $(checkbox).val("0");
        $(checkbox).prop('checked', false);
    } else {
        $(checkbox).val("1");
        $(checkbox).prop('checked', true);
    }
}

/*Funcion de arriba pero valores invertidos*/
function intercaleCheckInvert(checkbox) {
    if ($(checkbox).val() == "1") {
        $(checkbox).val("0");
        $(checkbox).prop('checked', true);
    } else {
        $(checkbox).val("1");
        $(checkbox).prop('checked', false);
    }
}

/*********************
**llamados ajax **
data2, es un objeto {id:2}
*********************/
function actionAjax(data2, url2) {
    var retornar = false;
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url2,
        type: 'POST',
        async: false,
        data: data2,
        success: function(datos) 
        {
            if (!datos.msm.val) {
                Alerta('Error', datos.msm.msm, 'error')
            } else {
                retornar = datos.msm.val;
                Alerta('Información', datos.msm.msm)
            }
        },
        error: function(request, status, error) {
            Alerta('Error', 'No se pudo realizar la operación.', 'error')
        }
    });
    return retornar;
}

/*********************
**llamados ajax general **
*********************/
function generalAjax(data2, url2,type2='POST',async2=false) {
    var retornar = false;
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url2,
        type: type2,
        async: async2,
        data: data2,
        success: function(response) 
        {
            retornar=response;
        },
        error: function(request, status, error) {
            Alerta('Error', 'No se pudo realizar la operación.', 'error')
        }
    });
    return retornar;
}
//Este Ajax recoje valores en los mensajes y retorna el mensaje dependiendo del valor de msm
function actionAjaxWithMessages(data2, url2) {
    var retornar = false;
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url2,
        type: 'POST',
        async: false,
        data: data2,
        success: function(datos) {
            if (datos.msm.val == "Error") {
                Alerta('Error', datos.msm.msm, 'error')
            } else if (datos.msm.val == "Insertado") {
                retornar = datos.msm.val;
                Alerta('Información', datos.msm.msm)
            } else if (datos.msm.val == "Actualizado") {
                retornar = datos.msm.val;
                Alerta('Información', datos.msm.msm)
            } else if (datos.msm.val == "ErrorUnico") {
                Alerta('Alerta', datos.msm.msm, 'Notice')
            }
        },
        error: function(request, status, error) {
            Alerta('Error', 'No se pudo realizar la operación.', 'error')
        }
    });
    return retornar;
}

function actionAjaxWithMessages2(data2, url2) {
    var retornar = false;
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url2,
        type: 'POST',
        async: false,
        data: data2,
        success: function(datos) {
            if (datos.msm.val == "Error") {
                Alerta('Error', datos.msm, 'error')
            } else if (datos.val == "Insertado") {
                retornar = datos.val;
                Alerta('Información', datos.msm)
            } else if (datos.val == "Actualizado") {
                retornar = datos.val;
                Alerta('Información', datos.msm)
            } else if (datos.val == "ErrorUnico") {
                Alerta('Alerta', datos.msm, 'Notice')
            }
        },
        error: function(request, status, error) {
            Alerta('Error', 'No se pudo realizar la operación.', 'error')
        }
    });
    return retornar;
}


function Alerta(title, text, type = 'success', removeAlerts = true) {
    if(removeAlerts) PNotify.removeAll();
    new PNotify({
        title: title,
        text: text,
        type: type
    });
}


function dataTableAction(url, url_lenguage, column) {
    $('#dataTableAction').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "ajax": {
            "url": url
        },
        language: {
            url: url_lenguage
        },
        "columns": column,

    });
}

function dataTableActionExport(url, url_lenguage, column) {
    $('#dataTableActionExport').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "ajax": {
            "url": url
        },
        language: {
            url: url_lenguage
        },
        "columns": column,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]

    });
}

function filterGlobal(id_table = 'dataTableAction') {
    $('#' + id_table).DataTable().search(
        $('#global_filter').val(),
        $('#global_regex').prop('checked'),
        $('#global_smart').prop('checked')
    ).draw();
}

function filterColumn(id_table = 'dataTableAction') {
    $('.table-filter .column_filter').each(function() {
        var i = $(this).parents('tr').attr('data-column');
        $('#' + id_table).DataTable().column(i).search(
            $('#col' + i + '_filter').val(),
        );
    });
    $('#' + id_table).DataTable().draw();
}

function dataTableActionFilterRefrechSelect(url, url_lenguage, column) {
    dataTableActionFilter(url, url_lenguage, column)
    //Select datables
    $('#dataTableAction tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            var table = $('#dataTableAction').DataTable();
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
}

function dataTableActionFilter(url, url_lenguage, column, order = 0) {
    $('#dataTableAction').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "order": [[ order, "asc" ]],
        scrollX: true,
        scrollCollapse: true,
        ajax: {
            url: url,
        },
        language: {
            url: url_lenguage
        },
        "fnDrawCallback": function( oSettings ) {
            $('#dataTableAction tbody td').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
            $(window).resize();
        },
        "aoColumns": column,
        "fixedColumns": true,
    });
    $('.global_filter').on('click', function() {
        filterGlobal();
        
    });

    $('.button_filter').click(function() {
        filterColumn();
        
    });

    $('.button_filter2').click(function() {
        if ($("#col3_filter").is(':checked')) {
            $('#deletedAction1').html("<i class='fa fa-check'></i> Activar");
            $('#deletedAction1').addClass("btn-warning").removeClass("btn-orange");
        } else {
            $('#deletedAction1').html("<i class='fa fa-times-circle'></i> Desactivar");
            $('#deletedAction1').removeClass("btn-warning").addClass("btn-orange");
        }
        filterColumn();
        
    });
    
}

function dataTableActionFilterPedido(url, url_lenguage, column) {
    $('#dataTableAction').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        scrollX: true,
        scrollCollapse: true,
        ajax: {
            url: url,
        },
        language: {
            url: url_lenguage
        },
        "fnDrawCallback": function (oSettings) {
            $('#dataTableAction tbody td').text(function () { $(this).text($(this).text().replace(/\s/g, " ")) });
            $('#dataTableAction > tbody  > tr').find('td:eq(11)').each(function () {
                $(this).html('<input type="text" name="recibidas[]" value="' + $(this).text() + '" class="form-control justNumbers" onchange="guardarRecibidas(this);">');
            });
            $('#dataTableAction > tbody  > tr').find('td:eq(12)').each(function () {
                $(this).html('<input type="text" name="pendientes[]" value="' + $(this).text() + '" class="form-control justNumbers" onchange="guardarPendientes(this);">');
            });
            $(window).resize();
        },
        "aoColumns": column,
        "fixedColumns": true,
    });
    $('.global_filter').on('click', function () {
        filterGlobal();

    });

    $('.button_filter').click(function () {
        filterColumn();

    });

   

    $('.button_filter2').click(function () {
        if ($("#col3_filter").is(':checked')) {
            $('#deletedAction1').html("<i class='fa fa-check'></i> Activar");
            $('#deletedAction1').addClass("btn-warning").removeClass("btn-orange");
        } else {
            $('#deletedAction1').html("<i class='fa fa-times-circle'></i> Desactivar");
            $('#deletedAction1').removeClass("btn-warning").addClass("btn-orange");
        }
        filterColumn();

    });

}

var table_multi_select;
function dtMultiSelectRow(id_table, url_ajax, url_lenguage, columns) {
    table_multi_select = $('#' + id_table).DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        scrollX: true,
        scrollCollapse: true,
        ajax: {
            url: url_ajax,
        },
        language: {
            url: url_lenguage
        },
        "fnDrawCallback": function( oSettings ) {
            $('#' + id_table + ' tbody td').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
            $(window).resize();
        },
        "aoColumns": columns,
        "fixedColumns": true,
        "order": [[1, 'asc']]
    });

    $('#' + id_table).click(function(){
        $(this).find('tbody tr[role="row"]:hover').toggleClass('selected');        
    });

    $('.global_filter').on('click', function() {
        filterGlobal(id_table);
        
    });

    $('.button_filter').click(function() {
        filterColumn(id_table);
        
    });

    $('.button_filter2').click(function() {
        if ($("#col3_filter").is(':checked')) {
            $('#deletedAction1').html("<i class='fa fa-check'></i> Activar");
            $('#deletedAction1').addClass("btn-warning").removeClass("btn-orange");
        } else {
            $('#deletedAction1').html("<i class='fa fa-times-circle'></i> Desactivar");
            $('#deletedAction1').removeClass("btn-warning").addClass("btn-orange");
        }
        filterColumn(id_table);
        
    });
    
}

function dataTableActionFilterExport(url, url_lenguage, column) {
    $('#dataTableActionExport').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        ajax: {
            url: url,
        },
        language: {
            url: url_lenguage
        },
        "columns": column,
        dom: 'Bfrtip',
        "fnDrawCallback": function( oSettings ) {
            $('#dataTableAction td, #dataTableAction th').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
            $(window).resize();
        },
        "fixedColumns": true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('.global_filter').on('click', function() {
        filterGlobal();
    });

    $('.button_filter').click(function() {
        filterColumn();
    });

    $('.button_filter2').click(function() {
        if ($("#col3_filter").is(':checked')) {
            $('#deletedAction1').html("<i class='fa fa-check'></i> Activar");
            $('#deletedAction1').addClass("btn-warning").removeClass("btn-orange");
        } else {
            $('#deletedAction1').html("<i class='fa fa-times-circle'></i> Desactivar");
            $('#deletedAction1').removeClass("btn-warning").addClass("btn-orange");
        }
        filterColumn();
    });


}

function deleteRowDatatableAction(url2, message = "¿Desactivar el registro?") {
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    var idPost = { id: valueId };
    if (valueId != null) {
        confirm.setTitle('Alerta');
        confirm.setSegment(message);
        confirm.show();

        confirm.setFunction(function() {
            var action = actionAjax(idPost, url2);
            if (action) {
                table.row('tr.selected').remove().draw();
            }
        });
    } else {
        Alerta('Error', 'Seleccione un registro.', 'error');
    }
}

$(function() {
    $('select[multiple].active.3col').multiselect({
        columns: 3,
        placeholder: '- Seleccione Opciones -',
        search: true,
        searchOptions: {
            'default': 'Buscar Opciones'
        },
        selectAll: true
    });

});

function activeRowDatatableAction(url2) {
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    var idPost = { id: valueId };
    if (valueId != null) {
        confirm.setTitle('Alerta');
        confirm.setSegment("¿Activar el registro?");
        confirm.show();

        confirm.setFunction(function() {
            var action = actionAjax(idPost, url2);
            if (action) {
                table.row('tr.selected').remove().draw();
            }
        });
    } else {
        Alerta('Error', 'Seleccione un registro.', 'error');
    }
}


function updateRowDatatableAction(url2) {
    var table = $('#dataTableAction').DataTable();
    var valueId = table.$('tr.selected').attr('id');
    if (valueId != null) {
        window.location = url2 + '/' + valueId
    } else {
        Alerta('Error', 'Seleccione un registro.', 'error')
    }
}

//carga select mediante ajax
function loadSelectInput(idIput, url, inputDefaul = true) {
    $(idIput).find('option').remove();
    if (inputDefaul) {
        $(idIput).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }
    $.ajax({
        url: url,
        type: "get",
        async: false,
        data: {},
        success: function(datos) {
            jQuery.each(datos, function(indice, valor) {
                var selected = "";
                if ($(idIput).data('load') == valor.id) {
                    selected = "selected";
                }
                $(idIput).append($('<option value="' + valor.id + '" ' + selected + '>' + valor.name + '</option>'));
            });
        }
    });
}

function loadSelectChild(id,child,url2)
{
    $(child).find('option').remove();
    var id = $(id).val();
    $.ajax(
    {
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},        
        url : url2,
        type : 'GET',
        async : false,
        dataType : 'JSON',
        data : 
        {
            id : id
        },
        success: function (datos) {
            $(child).append($('<option>', {
                value: '0',
                text: " - Seleccione una opción - "
            }));

            jQuery.each(datos, function (indice, datos) {   
                var selected = "";
                if($(child).data('load') == datos.id){
                    selected = "selected";
                }
                $(child).append($('<option value="' + datos.id + '" ' + selected + '>' + datos.nombre + '</option>'));
            });
        },
        
    });
    $(child).change();
}

//carga select mediante ajax
function loadSelectInputByParent(idIput, url, parentValue, inputDefaul = true) {
    $(idIput).find('option').remove();
    if (inputDefaul) {
        $(idIput).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }

    $.ajax({
        url: url,
        type: "get",
        async: false,
        data: {
            id: parentValue
        },
        success: function(datos) {
            jQuery.each(datos, function(indice, valor) {
                var selected = "";
                if ($(idIput).data('load') == valor.id) {
                    selected = "selected";
                }
                $(idIput).append($('<option value="' + valor.id + '" ' + selected + '>' + valor.name + '</option>'));
            });
        }
    });
    
}

//Carga select mediante ajax con el nombre de valor
function loadSelectValName(idIput, url, inputDefaul = true) {
    $(idIput).find('option').remove();
    if (inputDefaul) {
        $(idIput).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }

    $.ajax({
        url: url,
        type: "get",
        async: false,
        data: {},
        success: function(datos) {
            jQuery.each(datos, function(indice, valor) {
                $(idIput).append($('<option>', {
                    value: valor.nombre,
                    text: valor.nombre
                }))
            });
        }
    });
}

//carga select mediante ajax
function loadloadSelectWithTextValue(idIput, url, inputDefaul = true) {
    $(idIput).find('option').remove();
    if (inputDefaul) {
        $(idIput).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }

    $.ajax({
        url: url,
        type: "get",
        async: false,
        data: {},
        success: function(datos) {
            jQuery.each(datos, function(indice, valor) {
                $(idIput).append($('<option>', {
                    value: valor.name,
                    text: valor.name
                }))
            });
        }
    });
}

//carga select mediante ajax
function loadloadSelectWithTextValue(idIput, url, inputDefaul = true) {
    $(idIput).find('option').remove();
    if (inputDefaul) {
        $(idIput).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }

    $.ajax({
        url: url,
        type: "get",
        async: false,
        data: {},
        success: function(datos) {
            jQuery.each(datos, function(indice, valor) {
                $(idIput).append($('<option>', {
                    value: valor.name,
                    text: valor.name
                }))
            });
        }
    });
}


//Le asigna el Valor de pais  de Parametros Generales a el select. (21/10/2017) Jose David. (es posible mejorarlo para Generico)
function SelectValPais(idIput) {
    $.ajax({
        url: urlBase.make('/parametros/getselectpais'),
        type: "get",
        async: false,
        data: {},
        success: function(datos) {
            $(idIput).val(datos.id);
        }
    });
}

//Llena el Select solo con los datos del pais de Parametros generales.. (27/11/2017) Jose David.
function FillSelectValPais(idIput) {
    $(idIput).find('option').remove();
    $.ajax({
        url: urlBase.make('/parametros/getselectpais'),
        type: "get",
        async: false,
        data: {},
        success: function(datos) {
            $(idIput).append($('<option value="' + datos.id + '" >' + datos.name + '</option>'));
        }
    });
}

//Actualiza o postback de la pagina actual
var pageAction = (function() {
    return {
        reload: function(second = 0) {
            setTimeout("location.reload(true);", second * 1000);
        },
        back: function(second = 0) {
            setTimeout("window.history.back();", second * 1000);
        },
        redirect: function(url, second = 0) {
            setTimeout("location.assign('" + url + "');", second * 1000);
        }
    }
})();

//Muestra y Oculta la contraseña
var controlOpenPass = true;
$(".openPass").click(function() {
    if (controlOpenPass) {
        $(this).html("<i class='fa fa-eye'></i>");
        $(this).parents("div").find('input.changeTypePass').prop('type', 'text');
        controlOpenPass = false;
    } else {
        $(this).html("<i class='fa fa-eye-slash'></i>");
        $(this).parents("div").find('input.changeTypePass').prop('type', 'password');
        controlOpenPass = true;
    }
});

//Genera una contraseña por tamaño
function generar(longitud) {
    var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHIJKLMNPQRTUVWXYZ2346789";
    var passw = "";
    for (i = 0; i < longitud; i++) passw += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    return passw;
}

//Validar rquired en los input
//Class -> required
var valRequired = (function() {
    return {
        input: function() {
            var retornar = true;
            $("input.required").each(function() {
                if ($(this).val() == '') {
                    retornar = false;
                    $(this).css({
                        "border-color": "rgb(255, 126, 167)",
                        "-webkit-box-shadow": "0px 0px 7px -2px rgb(51, 122, 183)",
                        "-moz-box-shadow": "0px 0px 7px -2px rgb(51, 122, 183)",
                        "box-shadow": "0px 0px 7px -2px rgb(51, 122, 183)",
                    });
                    // if(getMessaje=='placeholder'){
                    var a = $(this).prop("placeholder")
                        // }else{
                        // var a=$(this).parents('div.form-group').find('label').text(); 
                        // }                    
                    Alerta('Error', 'El campo: <b>' + a + ',</b> es obligatorio.', 'error');
                }
            });
            return retornar;
        },
    }
})();

/*Sólo ingresar caracteres alfabeticos en el input*/
$('.justLetters').keyup(function() {
    this.value = (this.value + '').replace(/[^a-zA-Z]/g, '');
});

/*Sólo ingresar números en el input*/
$('.justNumbers').keyup(function() {
    this.value = (this.value + '').replace(/[^0-9]/g, '');
});

$('.justNumbers').keydown(function() {
    this.value = (this.value + '').replace(/[^0-9]/g, '');
});

$('.justNumbers').blur(function() {
    this.value = (this.value + '').replace(/[^0-9]/g, '');
});

/*Cargar Input a partir de un Select*/
function fillInput(idtarget, idrequested, url) {
    var id = $(idtarget).val();
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url,
        type: 'GET',
        async: false,
        data: { id: id },
        success: function(datos) {
            jQuery.each(datos, function(indice, valor) {
                $(idrequested).val(datos.name)
            });
        },
        error: function(request, status, error) {
            Alerta('Error', 'No se pudo realizar la operación.', 'error')
        }
    });
}

/* Cargar Select de otro Select */
function fillSelect(idtarget, idrequested, url, inputDefaul = true) {
    var id = $(idtarget).val();
    $(idrequested).find('option').remove();
    if (inputDefaul) {
        $(idrequested).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url,
        type: 'GET',
        async: false,
        data: { id: id },
        success: function(datos) 
        {
            jQuery.each(datos, function(indice, valor) 
            {
                var selected = "";
                if ($(idrequested).data('load') == valor.id)
                    selected = "selected";
                $(idrequested).append($('<option value="' + valor.id + '" ' + selected + '>' + valor.name + '</option>'));
            });
        },
        error: function(request, status, error) {
            Alerta('Error', 'No se pudo realizar la operación.', 'error')
        }
    });
}
/*Cambia el boton Activar o Desactivar dependiendo del checkBox*/
function intercaleFunction(checkbox) {
    if ($("#" + checkbox).val() == "1") {
        $("#activatedAction1").addClass('hide');
        $("#deletedAction1").removeClass('hide');
    } else {
        $("#activatedAction1").removeClass('hide');
        $("#deletedAction1").addClass('hide');
    }
}

/*Cambia el boton Activar o Desactivar dependiendo del checkBox*/
function intercaleFunction(checkbox) {
    if ($("#" + checkbox).val() == "1") {
        $("#activatedAction1").addClass('hide');
        $("#deletedAction1").removeClass('hide');
    } else {
        $("#activatedAction1").removeClass('hide');
        $("#deletedAction1").addClass('hide');
    }
}


/* Cargar Select de otro Select solo el texto*/
function fillSelectWithTextValue(idtarget, idrequested, url, inputDefaul = true) {
    var id = $(idtarget).val();
    $(idrequested).find('option').remove();
    if (inputDefaul) {
        $(idrequested).append($('<option>', {
            value: '',
            text: '- Seleccione una opción -',
        }));
    }
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url,
        type: 'GET',
        async: false,
        data: { id: id },
        success: function(datos) {
            jQuery.each(datos, function(indice, valor) {
                $(idrequested).append($('<option>', {
                    value: valor.name,
                    text: valor.name
                }))
            });
        },
        error: function(request, status, error) {
            Alerta('Error', 'No se pudo realizar la operación.\nRevice su conexión a Internet.', 'error')
        }
    });
}

function nextStep(step, target) {
    $('div.setup-panel div a').removeClass('btn-primary').addClass('btn-default');
    $('.step').each(function(element) {
        ref = $(this).attr('href');
        if (ref == ('#' + target)) {
            $(this).addClass('btn-primary');
        }
    });
    $('#' + target).show();
    $('#' + target + 'Btn').show();
    $('#' + step).hide();
    $('#' + step + 'Btn').hide();
}

function previousStep(step, target) {
    $('div.setup-panel div a').removeClass('btn-primary').addClass('btn-default');
    $('.step').each(function(element) {
        ref = $(this).attr('href');
        if (ref == ('#' + target)) {
            $(this).addClass('btn-primary');
        }
    });
    if (step != target) {
        $('#' + target).show();
        $('#' + target + 'Btn').show();
        $('#' + step).hide();
        $('#' + step + 'Btn').hide();
    }

}

$('#retirado').change(function() {
    var val = $(this).attr('checked', true).val();
    if (val == '0') {
        $('#fechaRetiroTtl').show();
        $('#motivoRetiroTtl').show();
        $('#fechaRetiroMin').show();
        $('#fechaRetiroMax').show();
        $('#motivoRetiroDiv').show();
        $('#infoRetirados').show();
        $('#infoActivos').hide();
    } else {
        $('#fechaRetiroTtl').hide();
        $('#motivoRetiroTtl').hide();
        $('#fechaRetiroMin').hide();
        $('#fechaRetiroMax').hide();
        $('#motivoRetiroDiv').hide();
        $('#infoRetirados').hide();
        $('#infoActivos').show();
    }
});

$('#familiaEmpresa').change(function() {
    var val = $(this).val();
    if (val == '1') {
        $('#familiaEmpresaTtl').show();
        $('#rangoFamiliaresMinDiv').show();
        $('#rangoFamiliaresMaxDiv').show();
    } else {
        $('#familiaEmpresaTtl').hide();
        $('#rangoFamiliaresMinDiv').hide();
        $('#rangoFamiliaresMaxDiv').hide();
    }
});

$('.data-picker').datetimepicker({
    autoclose: true,
    dayOfWeekStart: 1,
    lang: 'en',
    format: 'dd-mm-yyyy hh:ii:00', //'yyyy-mm-dd',
    disabledDates:['08/01/1986', '09/01/1986', '10/01/1986'],// ['1986/01/08', '1986/01/09', '1986/01/10'],
    startDate: '05/01/1986'
});

$('.data-picker-only').datetimepicker({
    pickTime: false,
    minView: 2,
    format:'dd-mm-yyyy', //'yyyy-mm-dd',
    startDate: new Date(01, 01, 1900),
    autoclose: true,
});

$('.data-picker-until-today').datetimepicker({
    pickTime: false,
    minView: 2,
    format: 'dd-mm-yyyy', //'yyyy-mm-dd',
    autoclose: true,
    startDate: new Date(01, 01, 1900),
    endDate: new Date(),
});

$('.check-hidden').click(function() {
    if (this.checked)
        $(this).next('input').val('1');
    else
        $(this).next('input').val('0');
});

function validateMinAndMax(target1, target2, operator, type = "number") {
    if (type == "number") {
        var target1_1 = ($('#' + target1).val() == '') ? 0 : parseInt($('#' + target1).val());
        var target2_1 = ($('#' + target2).val() == '') ? 0 : parseInt($('#' + target2).val());
    } else {
        var target1_1 = ($('#' + target1).val() == '') ? 0 : ($('#' + target1).val());
        var target2_1 = ($('#' + target2).val() == '') ? 0 : ($('#' + target2).val());
    }


    if (operator == "max") {
        if (target1_1 > target2_1) {
            $('#' + target2).val(target1_1);
        }
    }
    if (operator == "min") {
        if (target1_1 < target2_1) {
            $('#' + target2).val(target1_1);
        }
    }
}

function limitTextPb(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    }
}

function valMinAndMax(target1, target2) {
    
        var numberx = ($('#' + target1).val() == '') ? '0' : limpiarInt($('#' + target1).val());
        var numberx2 = ($('#' + target2).val() == '') ? '0' : limpiarInt($('#' + target2).val());
    
        var number_1 = numberx.split(',')[0];
        var number_1_2 = ((numberx.split(',')[1] === undefined) ? '0' : numberx.split(',')[1]);
        var number_2 = numberx2.split(',')[0];
        var number_2_2 = ((numberx2.split(',')[1] === undefined) ? '0' : numberx2.split(',')[1]);
        
        number_1 = parseInt(number_1);
        number_1_2 = parseInt(number_1_2);
        number_2 = parseInt(number_2);
        number_2_2 = parseInt(number_2_2);
    
        if (number_1 > number_2) 
        {
            $('#' + target2).val(numberx);
        }
    
        if (number_1 < number_2) 
        {
            $('#' + target2).val(numberx2);
        }
    
        if(number_1 == number_2)
        {
            if(number_1_2 > number_2_2)
            {
                $('#' + target2).val(numberx);
            }else if(number_2_2 < number_1_2)
            {
                $('#' + target1).val(numberx2);
            }
        }
}

function limpiarInt(val)
{   
    var res = val.split(".").join("");
    return res;
} 

var print = (function() {
    return {
        window: function(element) {
            var ficha = document.getElementById(element);
            var ventimp = window.open(' ', 'popimpr');
            ventimp.document.write(ficha.innerHTML);
            ventimp.document.close();
            ventimp.print();
            ventimp.close();
        }
    }
})();

function clearSelects(selects, value = null) {
    for (var i = 0; i < selects.length; i++) {
        if (selects[i][1] == 'delete_options') {
            $('#' + selects[i][0] + ' option').remove();
            if (value == null)
                $('#' + selects[i][0]).append('<option value>- Seleccione una opción -</option>');
            else
                $('#' + selects[i][0]).append('<option value="0">- Seleccione una opción -</option>');
        } else {
            $('#' + selects[i][0])[0].selectedIndex = 0;
        }
    }
}


$('input[type="number"]').attr('min', '0');


/*- -----------------------------------------------------------------
--- Funcion para impedir que se ingresen numero Negativos en un input
--- ---------------------------------------------------------------*/

$('.SoloNumeros').keypress(function() {
    return SoloNumeros(event);
});

function SoloNumeros(e) {
    var tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8)
        return true;
    patron = /^[0-9]+$/;
    tecla = String.fromCharCode(tecla);
    return patron.test(tecla);
}

/*- -----------------------------------------------------------------
--- -----------------------------------------------------------------*/

/*- -----------------------------------------------------------------------
--- Función para teclear una cantidad de caracteres o numeros especificados
--- -------------------------------------------------------------------- */

$('[maxlength]').keypress(function() {
    return cantidadCaracteres(this);
});

function cantidadCaracteres(elemento) {
    var valor = elemento.value;
    var cantidad = 0;
    if (valor != '') {
        cantidad = valor.length;
    }
    var maximo = $(elemento).attr('maxlength');
    if (cantidad >= maximo) {
        return false;
    }
}

/*- -----------------------------------------------------------------------
--- -------------------------------------------------------------------- */


/*- -----------------------------------------------------------------------
--- Función para validar Email en un input
--- -------------------------------------------------------------------- */

function validarEmail(email) {
    var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!expr.test(email))
        return false;
    else
        return true;
}

/*- -----------------------------------------------------------------------
--- -------------------------------------------------------------------- */


var urlBase = (function() {
    var url = {};
    url.base = '';
    return {
        setBase: function(url2) {
            url.base = url2;
        },
        getBase: function() {
            return url.base;
        },
        make: function(url2) {
            return url.base + '/' + url2;
        },
    }
})();

$('.switch_check').each(function() {
    if ($(this).children().val() == "1") {
        $(this).children().prop('checked', true);
    } else {
        $(this).children().prop('checked', false);
    }
});


/*- -----------------------------------------------------------------------------
--- Función para acceder a una función Ajax desde cualquier parte de la apliación
--- -------------------------------------------------------------------------- */

function getAjaxGeneral(value2, url2) {
    var retorno = -1;
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url2,
        type: "POST",
        async: false,
        data: {
            value: value2
        },
        success: function(datos) {
            retorno = datos;
        },
        error: function(request, status, error) {
            Alerta('Error', 'No se pudo realizar la operación.', 'error')
        }
    });
    return retorno;
}

/*- -----------------------------------------------------------------------
--- -------------------------------------------------------------------- */




function sumNumbers(arraySum) {
    var res = 0;
    for (var i = 0; i < arraySum.length; i++) {

        var num = arraySum[i];
        // num = num.replace(/\./g, "");

        res = parseFloat(res) + parseFloat(num);
    }

    return res; //20000
}

function resNumbers(arraySum) {
    var res = 0;
    for (var i = 0; i < arraySum.length; i++) {

        var num = arraySum[i];
        // num = num.replace(/\./g, "");

        res = parseFloat(res) - parseFloat(num);
    }

    return res; //20000
}

//Valida y Abre el "details" si esta cerrado, cuando elemento es requirido
function isDetailsRequiered(element){ 
	while(!$(element).is("details")){	
		element = $(element).parent();
    }
    element.first().prop('open',true);
}

function dtMultiSelectRowAndInfo(id_table, url_ajax, url_lenguage, columns) {
    table_multi_select = $('#' + id_table).DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 100,
        scrollY: 400,
        scrollX: true,
        scrollCollapse: true,
        ajax: {
            url: url_ajax,
        },
        fixedColumns:   {
            'iLeftColumns': 2
        },
        language: {
            url: url_lenguage
        },
        "fnDrawCallback": function( oSettings ) {
            $('#' + id_table + ' tbody td:not(.no-replace-spaces)').text(function(){$(this).text($(this).text().replace(/\s/g, " "))});
            $(window).resize();
            $('.right_col').css('min-height', $('.right_col').height() - 70);
        },
        "aoColumns": columns,
        "order": [[2, 'asc']],
    });

    $('.global_filter').on('click', function() {
        filterGlobal(id_table);
        
    });

    $('.button_filter').click(function() {
        filterColumn(id_table);
        
    });

    
    $('.button_filter2').click(function() {
        if ($("#col3_filter").is(':checked')) {
            $('#deletedAction1').html("<i class='fa fa-check'></i> Activar");
            $('#deletedAction1').addClass("btn-warning").removeClass("btn-orange");
        } else {
            $('#deletedAction1').html("<i class='fa fa-times-circle'></i> Desactivar");
            $('#deletedAction1').removeClass("btn-warning").addClass("btn-orange");
        }
        filterColumn(id_table);
        
    });
    $('.button_filter').click();
    
}
function val_filter(){
    if (valDivRequiered('contentfilter-table')) {
        filterColumn('dataTableAction');
    }
}

function validateRequiredInput(container = 'body'){
    var complete = true;
    $(container + ' .validate-required').each(function(){
        if($(this).val() == "" || $(this).val() == null){
            complete = false;
            $(this).addClass('alert-validate-required');
            $(this).attr("placeholder", "Este campo es requerido");
        }else{
            $(this).removeClass('alert-validate-required');
            $(this).attr("placeholder", "");
        }
    });

    $(container + ' .validate-required-select').each(function(){
        if($(this).find('option:selected').val() == "" || $(this).find('option:selected').val() == null){
            complete = false;
            $(this).addClass('alert-validate-required');
            $(this).attr("placeholder", "Este campo es requerido");
        }else{
            $(this).removeClass('alert-validate-required');
            $(this).attr("placeholder", "");
        }
    });

    return complete;
}
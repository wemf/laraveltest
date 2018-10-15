//Carga las URL necesarias para que funcione la persitencia
var URL = (function() {
    //variable global
    var url = {};
    url.getData = '';
    url.getUrl = '';
    url.getRedirec = '';
    url.getsetUrlDataTable = '';
    url.excel = '';
    return {
        setUrl: function(url2) {
            url.getUrl = url2;
        },
        getUrl: function() {
            return url.getUrl;
        },
        setData: function(url2) {
            url.getData = url2;
        },
        getUrlExcel: function() {
            return url.excel;
        },
        setUrlExcel: function(url2) {
            url.excel = url2;
        },
        getData: function() {
            return url.getData;
        },
        setRedirec: function(url2) {
            url.getRedirec = url2;
        },
        getRedirec: function() {
            return url.getRedirec;
        }
    }
})();



//Toma los datos de
var dataEmpleado = {};

// $(window).load(function() {
//     $('.check').each(function() {
//         $(this).val('No');
//         if ($(this).prop('id') == 'retirado') {
//             $(this).val('1');
//         }
//     })
// })

function getDataStep(step, target) {
    var i = 0;
    var valore = [];
    var valoreBox = [];
    var conta = 0;
    $('.check').each(function() {
        if ($(this).is(":checked")) {
            valore[conta] = $(this).val();
            conta++;
        }
    });

    dato = {
        nombre: $('#nombre').val(),
        primerApellido: $('#primerApellido').val(),
        segundoApellido: $('#segundoApellido').val(),
        tipoCedula: $('#tipoCedula').val(),
        cedula: $('#cedula').val(),
        estadoCivil: $('#estadoCivil').val(),
        personasCargoMin: $('#personasCargoMin').val(),
        personasCargoMax: $('#personasCargoMax').val(),
        hijosMin: $('#hijosMin').val(),
        hijosMax: $('#hijosMax').val(),
        rangoEdadMin: $('#rangoEdadMin').val(),
        rangoEdadMax: $('#rangoEdadMax').val(),
        tipoVivienda: $('#tipoVivienda').val(),
        tenenciaVivienda: $('#tenenciaVivienda').val(),
        tipoEstudio: $('#tipoEstudio').val(),
        fechaEstudioMin: $('#fechaEstudioMin').val(),
        fechaEstudioMax: $('#fechaEstudioMax').val(),
        estadoEstudio: $('#estadoEstudio').val(),
        cargo: $('#cargo').val(),
        salarioMin: $('#salarioMin').val(),
        salarioMax: $('#salarioMax').val(),
        auxilioTransporte: $('#auxilioTransporte').val(),
        retirado: $('#retirado').val(),
        fechaRetiroMin: $('#fechaRetiroMin').val(),
        fechaRetiroMax: $('#fechaRetiroMax').val(),
        motivoRetiro: $('#motivoRetiro').val(),
        familiaEmpresa: $('#familiaEmpresa').val(),
        rangoFamiliaresMin: $('#rangoFamiliaresMin').val(),
        rangoFamiliaresMax: $('#rangoFamiliaresMax').val(),
        infoDetalladaHijos: valore[0],
        infoDetalladaPersonasCargo: valore[1],
        infoDetalladaFamiliaEmpresa: valore[2],
        nulo: 1,
    }
    var controlChecked = true; //vacío

    $('.check').each(function() {
        if ($(this).prop("checked")) {
            if ($(this).val() == "Si") {
                controlChecked = false;
                return false;
            }
        }
    });
    
    if (controlChecked) {
        dato.nulo = 2;
    }

    if (dato.nulo == 2) {
        $.each(dato, function(key, value) {
            if (key != 'nulo') {
                if (value == "" || value == "No") {
                    dato.nulo = 2;
                } else {
                    dato.nulo = 1;
                    return false;
                }
            }
        });
    }
    dataEmpleado = dato;
    $.ajax({
        url: URL.getUrl(),
        type: 'get',
        async: false,
        data: dato,
        success: function(data) {            
            if (data.msn.info.length > 0) {
                $(".tbody").empty();
                $.each(data, function(key, value) {
                    $.each(data.msn.info, function(key, value) {
                        $('.tbody').append("<tr><th>" + data.msn.info[key].nombres + "</th><th>" + data.msn.info[key].apellidos + "</th><th>" + data.msn.info[key].tipo_documento + "</th><th>" + data.msn.info[key].cedula + "</th><th>" + data.msn.info[key].celular + "</th><th>" + data.msn.info[key].correo + "</th><th>"+ data.msn.info[key].cargo +"</th><th>" + data.msn.info[key].ciudad_residencia + "</th></tr>");
                    });
                });
                $('div.setup-panel div a').removeClass('btn-primary').addClass('btn-default');
                $('.step').each(function(element){
                    ref = $(this).attr('href');
                    if (ref == ('#' + target)){
                        $(this).addClass('btn-primary');
                    }
                });
                $('#' + target).show();
                $('#' + target + 'Btn').show();
                $('#' + step).hide();
                $('#' + step + 'Btn').hide();
                // if (data.msn.children.length == 0 && dato.infoDetalladaHijos == "Si") {
                //     Alerta("Error", "No Hay Registros Del Detalle De Los Hijos", 'error');
                // }
                // if (data.msn.dependents.length == 0 && dato.infoDetalladaPersonasCargo == "Si") {
                //     Alerta("Error", "No Hay Registros Del Detalle De Las Personas a Cargo", 'error');
                // }
                // if (data.msn.nutyFamily.length == 0 && dato.infoDetalladaFamiliaEmpresa == "Si") {
                //     Alerta("Error", "No Hay Registros Del Detalle De Los Familiares", 'error');
                // }
            } else {
                //Se comenta la siguiente linea de código para dejar de mostrar los errores
                //A petición de Eduardo
                //Alerta("Error", "No Hay Empleados Registrados", 'error');
                $(".tbody").empty();
                $('div.setup-panel div a').removeClass('btn-primary').addClass('btn-default');
                $('.step').each(function(element) {
                    ref = $(this).attr('href');
                    if (ref == ('#' + target)) {
                        $(this).addClass('btn-primary');
                    }
                });
                $('#' + target).show();
                $('#' + target + 'Btn').show();
                //$('#' + target + 'Btn #siguiente').hide();
                $('#' + step).hide();
                $('#' + step + 'Btn').hide();
            }
        }
    });
}

function GenerateExcel() {
    Alerta('Alerta', 'Descargando Excel..');
    $.each(dataEmpleado, function(key, value) {
        if(key==="retirado" && value===""){
            dataEmpleado[key] = -1;
        }else if (value == '') {
            dataEmpleado[key] = 0;
        }
    });
    var dataGet = dataEmpleado.nombre + '/' + dataEmpleado.primerApellido + '/' + dataEmpleado.segundoApellido + '/' + dataEmpleado.tipoCedula + '/' + dataEmpleado.cedula + '/' + dataEmpleado.estadoCivil + '/' + dataEmpleado.personasCargoMin + '/' + dataEmpleado.personasCargoMax + '/' + dataEmpleado.hijosMin + '/' + dataEmpleado.hijosMax + '/' + dataEmpleado.rangoEdadMin + '/' + dataEmpleado.rangoEdadMax + '/' + dataEmpleado.tipoVivienda + '/' + dataEmpleado.tenenciaVivienda + '/' + dataEmpleado.tipoEstudio + '/' + dataEmpleado.fechaEstudioMin + '/' + dataEmpleado.fechaEstudioMax + '/' + dataEmpleado.estadoEstudio + '/' + dataEmpleado.cargo + '/' + dataEmpleado.salarioMin + '/' + dataEmpleado.salarioMax + '/' + dataEmpleado.auxilioTransporte + '/' + dataEmpleado.retirado + '/' + dataEmpleado.fechaRetiroMin + '/' + dataEmpleado.fechaRetiroMax + '/' + dataEmpleado.motivoRetiro + '/' + dataEmpleado.familiaEmpresa + '/' + dataEmpleado.rangoFamiliaresMin + '/' + dataEmpleado.rangoFamiliaresMax + '/' + dataEmpleado.infoDetalladaHijos + '/' + dataEmpleado.infoDetalladaPersonasCargo + '/' + dataEmpleado.infoDetalladaFamiliaEmpresa + '/' + dataEmpleado.nulo;
    pageAction.redirect(URL.getUrlExcel() + '/' + dataGet);
}

function Alerta(title, text, type = 'success') {
    new PNotify({
        title: title,
        text: text,
        type: type
    });
}



// validar el MIN y el MAX del filtro "Rango de edad"
$('.retireAlert').on('keypress',function(){
    tool.hide();
});

$('.retireAlert').on('change',function(){
    tool.hide();
});

$('.retireAlert').on('click',function(){
    tool.hide();
});


var edad= (function (){ 
    var e="";
    return{ 
        validated:function(value){			
            var response=false;
            if(!isNaN(value) && value < 15 || value > 100) {
                response=true;
            }
            return response;
        },
        validatedError:function(e2){
            e=e2;
            var value = parseInt($(e).val());
            if(edad.validated(value)){
                edad.getMenssajeError(`La edad ${value}. El rango de edad permitido es de 15 a 100.`);
                $(e).val("");
            }else{
                if(edad.validatedRange() ){
                    edad.getMenssajeError("La edad mínima debe se menor a la edad máxima.");
                }else{
                    edad.desbloquear();
                }
            }
        },
        validatedRange:function(){
            var response=false;
            var edadMin = parseInt($('#rangoEdadMin').val());
            var edadMax = parseInt($('#rangoEdadMax').val());
            if(edadMin >  edadMax){
                response=true;
            }
            return response;
        },
        desbloquear:function(){
            $('.btn').attr("disabled", false); 
        },
		getMenssajeError: function(msm){			
            $('#tool').remove();
            $(e).after(`<div class="tool tool-visible" id="tool"><p>${msm}</p></div>`);
            $('.btn').attr("disabled", true);  
        },
	}
})();


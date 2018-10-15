var URL= (function (){ 
    var url = {}; 
        url.getCategory='';

    return{ 
        setUrlGetCategory:function(url2){            
            url.getCategory=url2;
        },
        getUrlGetCategory:function(){            
            return url.getCategory;
        },
    }
})();

var validate_form_C = (function () {
    return {
        save_specific: function () {
            if (!this.validate_values('valid_since', 'valid_until', 'datetime')) {
                Alerta('Información', 'La vigencia desde no puede ser mayor a la vigencia hasta', 'warning');
            } else {
                $('#btn-save').click();
            }
        },

        validate_values: function (target1, target2, type = 'number') {
            var result = true;
            if (type == "number") {
                var target1_1 = ($('#' + target1).val() == '') ? 0 : parseInt($('#' + target1).val());
                var target2_1 = ($('#' + target2).val() == '') ? 0 : parseInt($('#' + target2).val());
            } else if (type == "datetime") {
                if($('#' + target1).val() != '') {
                var target1_1 = ($('#' + target1).val() == '') ? 0 : ($('#' + target1).val()).split('-');
                target1_1 = parseInt(target1_1[2].toString() + target1_1[1].toString() + target1_1[0].toString());
                }
                if ($('#' + target2).val() != '') {
                var target2_1 = ($('#' + target2).val() == '') ? 0 : ($('#' + target2).val()).split('-');
                target2_1 = parseInt(target2_1[2].toString() + target2_1[1].toString() + target2_1[0].toString());
                }
            } else if (type == "money") {
                var target1_1 = ($('#' + target1).val() == '') ? 0 : ($('#' + target1).val().replace(/\./g, '').replace(/\,/g, '.'));
                var target2_1 = ($('#' + target2).val() == '') ? 0 : ($('#' + target2).val().replace(/\./g, '').replace(/\,/g, '.'));
                target1_1 = parseFloat(target1_1);
                target2_1 = parseFloat(target2_1);
            }

            (target1_1 > target2_1) ? result = false: null;
            return result;
        }
    }
})();

function runCategoryList(){
    loadSelectValName("#col0_filter",URL.getUrlGetCategory(),2);   
}

function checkedit(){
    $('input[type="checkbox"]').each(function(){
        if($(this).val() == 1){
            $(this).attr('checked', true);
        }
    });
}
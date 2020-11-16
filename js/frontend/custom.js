function loading_show(){
    $(".se-pre-con").show();
}

function loading_hide(){
    $(".se-pre-con").fadeOut('slow');
}

$(document).ready(function(){
    $('#menu_toggle').click(function () {
        if ($('#menu_toggle').hasClass('logo_active')) {
            $('.img_logo').addClass('hide_logo');
            $(this).removeClass('logo_active');
            $('.nav.side-menu li').removeClass('active-sm');
            $('.child_menu').css('display','none');
            $('li a span.fa-chevron-down').css('display','none');
        }
        else {
            $('.img_logo').removeClass('hide_logo');
            $('.img_logo').addClass('show_logo');
            $(this).addClass('logo_active');

    }});
});
//Get all params in url
function getURLParameters(url) {
    var result = {};
    var searchIndex = url.indexOf("?");
    if (searchIndex == -1 ) return result;
    var sPageURL = url.substring(searchIndex +1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        result[sParameterName[0]] = sParameterName[1];
    }
    return result;
}

// Create link with parameter
function createLink(baseUrl, parameters) {
    str = '';
    $.each(parameters, function(key, val) {
        str = str + key + '=' + val + '&';
    });
    str = str.replace(/^\&+|\&+$/g, '');

    return baseUrl.replace(/^\?+|\?+$/g, '') + '?' + str;
}

// Get param from current url
$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
        return null;
    }
    else{
        return results[1] || 0;
    }
};

// form serialize to object
$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function resetValidatePlan() {
    $('.data-table.kb-error').removeClass('kb-error');
    $('.data-table.kb-error').attr('title', '');
}

function getDataTablePlan() {
    resetValidatePlan();

    $data = [];
    isError = 0;
    $('.table-input tbody tr.tr-data').each(function() {
        $dataTR = {};
        $(this).find('.data-table').each(function () {
            if (!$(this).is(':disabled')) {
                // validate data
                if (typeof($(this).attr('kb-validate-required')) != 'undefined' && $(this).val() === '') {
                    $(this).addClass('kb-error');
                    $(this).attr('title', txt_input_require);
                    isError = 1;
                }
                if (typeof($(this).attr('kb-validate-type-integer')) != 'undefined' && $(this).val() !== '') {
                    if(!$.isNumeric($(this).val()) || Math.floor($(this).val()) != $(this).val()) {
                        $(this).addClass('kb-error');
                        $(this).attr('title', txt_input_integer);
                        isError = 1;
                    }
                    else if (typeof($(this).attr('kb-validate-min')) != 'undefined' && $(this).val() < $(this).attr('kb-validate-min')) {
                        $(this).addClass('kb-error');
                        $(this).attr('title', txt_input_min_+$(this).attr('kb-validate-min'));
                        isError = 1;
                    }
                }
                if (typeof($(this).attr('kb-validate-type-number')) != 'undefined' && $(this).val() !== '') {
                    if(!$.isNumeric($(this).val())) {
                        $(this).addClass('kb-error');
                        $(this).attr('title', txt_input_number);
                        isError = 1;
                    }
                    else if (typeof($(this).attr('kb-validate-min')) != 'undefined' && $(this).val() < $(this).attr('kb-validate-min')) {
                        $(this).addClass('kb-error');
                        $(this).attr('title', txt_input_min_+$(this).attr('kb-validate-min'));
                        isError = 1;
                    }
                }

                $dataTR[$(this).attr('name')] = $(this).val();
            }
        });

        $data.push($dataTR);
    });

    return {error:isError, data:$data};
}

$(document).ready(function(){

    // table: check all
    $('#check-all').click(function () {
        if (this.checked) {
            $('input[name="table_records"]:enabled').prop('checked', true);
        } else {
            $('input[name="table_records"]:enabled').prop('checked', false);
        }
    });

});

// table
$(document).on('click', '.cbox-table-all', function () {
    table = $(this).closest('table');
    if (this.checked) {
        table.find('.cbox-table-row:enabled').prop('checked', true);
    } else {
        table.find('.cbox-table-row:enabled').prop('checked', false);
    }
});

$(document).on('click', '.cbox-table-row', function () {
    if (!this.checked) {
        $(this).closest('table').find('.cbox-table-all').prop('checked', false);
    }
});
// END table

// table input
$(document).on('keydown', '.td-input > input', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode == 37 || keyCode == 38 || keyCode == 39 || keyCode == 40) {
        $table = $(this).closest('.table-input');
        $tr = $(this).closest('tr');
        $td = $(this).closest('td');
        $rowLength = $table.find('tbody tr').length;
        rowIndex = $table.find('tbody tr').index($tr);
        colIndex = $tr.find('td').index($td);

        var $elems = $('.td-input > input');

        switch(e.keyCode) {
            case 37://left
                $elems.eq($elems.index($(this)) - 1).focus();
                break;
            case 39://right
                $elems.eq($elems.index($(this)) + 1).focus();
                break;
            case 38://up
                for(rowIndexTmp = rowIndex - 1; rowIndexTmp != rowIndex; rowIndexTmp--) {
                    if (rowIndexTmp < 0) {
                        rowIndexTmp = $rowLength-1;
                    }
                    if ($table.find('tbody tr:eq(' + rowIndexTmp + ') td:eq(' + colIndex + ')').find('input').length) {
                        break;
                    }
                }
                $table.find('tbody tr:eq(' + rowIndexTmp + ') td:eq(' + colIndex + ')').find('input').focus();
                break;
            case 40://down
                for(rowIndexTmp = rowIndex + 1; rowIndexTmp != rowIndex; rowIndexTmp++) {
                    if (rowIndexTmp > $rowLength-1) {
                        rowIndexTmp = 0;
                    }
                    if ($table.find('tbody tr:eq(' + rowIndexTmp + ') td:eq(' + colIndex + ')').find('input').length) {
                        break;
                    }
                }
                $table.find('tbody tr:eq(' + rowIndexTmp + ') td:eq(' + colIndex + ')').find('input').focus();
                break;
        }

        return false;
    }
    
    // enter
    if(keyCode === 13) {
        $('.td-input > input')[$('.td-input > input').index(this)+1].focus();
        return false;
    }

    return true;
});
// END table input

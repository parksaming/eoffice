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

function loading_show(){
    $(".se-pre-con").show();
}

function loading_hide(){
    $(".se-pre-con").fadeOut('slow');
}

$(document).ready(function(){
    //active menu siderbar left
    $('#menu_toggle').click(function () {
        if ($(this).hasClass('menu_active')) {
            $('.img_logo').addClass('hide_logo');
            $(this).removeClass('menu_active');
            $('.child_menu').css('display','none');
            $('li a span.fa-chevron-down').css('display','none');
        } else {
            $('.img_logo').removeClass('hide_logo');
            $('.img_logo').addClass('show_logo');

            $(this).addClass('menu_active');

        }
    });

    // table: check all
    $('#check-all').click(function () {
        if (this.checked) {
            $('input[name="table_records"]:enabled').prop('checked', true);
        } else {
            $('input[name="table_records"]:enabled').prop('checked', false);
        }
    });
    $('navbar-toggle').click(function () {
        if($(this).hasClass('active')){
            if ($('.navbar-toggle').hasClass('fa-chevron-down')) {
                $('.navbar-toggle').removeClass('fa-chevron-down');
                $('li > a span').addClass('fa-chevron-up');
                $(this).removeClass('active');
            } else {
                $('li > a span').removeClass('fa-chevron-up');
                $('li > a span').addClass('fa-chevron-down');
                $(this).addClass('active');

            }
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
//

$(document).ready(function() {
    $('.alert-danger, .alert-success').delay(7000).slideUp();
});


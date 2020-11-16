$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

function validateFile(file) {
    if (!file.disabled) {
        // check file size
        let fileSize = file.files[0].size / 1024 / 1024; // in MB
        if (fileSize > 20) {
            $(file).val('');
            alert('Chỉ cho upload định dạng file: doc, docx, xls, xlsx, ppt, pptx, pdf với dung lượng < 20M');
            return false;
        }

        // check file type
        let fileExt = file.files[0].name.split('.').pop().toLowerCase();
        let extAccept = file.getAttribute('accept').split(',');
        if (!extAccept.includes('.'+fileExt)) {
            $(file).val('');
            alert('Chỉ cho upload định dạng file: doc, docx, xls, xlsx, ppt, pptx, pdf với dung lượng < 20M');
            return false;
        }
    }

    return true;
}
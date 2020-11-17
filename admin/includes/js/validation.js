$(document).ready(function () {
    $("div.form-group").each(function () {
        let element = $(this).find('input, select, textarea');
        if ($(this).data('validate-required') !== undefined) {
            if(element.hasClass('date-picker')) {
                $(this).children("div[class*=col-]").children('.input-group').append('<span class="text-danger error-star">*</span>');
            } else {
                $(this).children("div[class*=col-]").append('<span class="text-danger error-star">*</span>');
            }
        }
    });
    $("div.validation-div").each(function () {
        let element = $(this).find('input:not(.ignore), select:not(.ignore), textarea:not(.ignore)');
        if($(this).data('error') !== undefined) {
            var Err = $(this).data('error');
            if(element.hasClass("chosen-select")) {
                $(this).children("div[class*=col-]").append('<p id="err_' + element.attr('id') + '"><span class="text-danger">' + Err + '</span></p>');
            } else {
                $(this).children("div[class*=col-]").append('<p id="err_' + element.attr('id') + '"><br><span class="text-danger">' + Err + '</span></p>');
            }
        }
    });
    $('form').submit(function () {
        let formSubmit = true;
        $("div.validation-div").each(function () {
            let element = $(this).find('input:not(.ignore), select:not(.ignore), textarea:not(.ignore)');
            let EValue = $(element).val();
            let elemValid = true;
            if ($(this).data('validate-required') !== undefined) {
                let Error = $(this).data('validate-required');
                $("p#err_" + element.attr('id')).remove();
                if (EValue == '') {
                    if(element.hasClass("chosen-select") || element.attr('type') == 'file' || element.prop("tagName").toLowerCase() == 'textarea' || element.hasClass('date-picker')) {
                        $(this).children("div[class*=col-]").append('<p id="err_' + element.attr('id') + '"><span class="text-danger">' + Error + '</span></p>');
                    } else {
                        $(this).children("div[class*=col-]").append('<p id="err_' + element.attr('id') + '"><br><span class="text-danger">' + Error + '</span></p>');
                    }
                    formSubmit = false;
                    elemValid = false;
                }
            }
            if ($(this).data('validate-number') !== undefined && elemValid) {
                let Error = $(this).data('validate-number');
                $("p#err_" + element.attr('id')).remove();
                if (isNaN(EValue)) {
                    if(element.hasClass("chosen-select") || element.attr('type') == 'file' || element.prop("tagName").toLowerCase() == 'textarea' || element.hasClass('date-picker')) {
                        $(this).children("div[class*=col-]").append('<p id="err_' + element.attr('id') + '"><span class="text-danger">' + Error + '</span></p>');
                    } else {
                        $(this).children("div[class*=col-]").append('<p id="err_' + element.attr('id') + '"><br><span class="text-danger">' + Error + '</span></p>');
                    }
                    formSubmit = false;
                    elemValid = false;
                }
            }
        });
        return formSubmit;
    });
});

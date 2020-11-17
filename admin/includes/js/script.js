function startAjaxLoader() {
    $(".ajaxloader").removeClass('hide');
}

function stopAjaxLoader() {
    $(".ajaxloader").addClass('hide');
}

var orderFalseIndex = [];
var columnDefs = [];

function getSearchAction() {
    var action = [];
    var empty = true;
    $("#filterForm button[type!=button], #filterForm select, #filterForm input").each(function () {
        if ($(this).val() == null || $(this).val() == "") {
        } else {
            empty = false;
            action.push([$(this).attr('id'), $(this).val()]);
        }
    });
    return action;
}

function getSearchData(action = []) {
    var data = "";
    if (action.length > 0) {
        action.forEach(function (item, index) {
            if (index > 0) {
                data += "&";
            }
            data += item[0] + "=" + item[1];
        });
    }
    return data;
}

function drawTable(action = [], from = '') {
    startAjaxLoader();
    $("#filterForm select, #filterForm input, #filterForm button[type!=button]").each(function () {
        $.cookie("search_" + $(this).attr("id"), $(this).val());
    });
    var defaultSorting = [[0, "asc"]];
    var columnDefs = [];
    var action = getSearchAction();
    var data = getSearchData(action);
    var pageLength = $("#dataTable_length").children('select').val();
    if (from == "print") {
        pageLength = 500;
        var printHides = [];
        $("thead tr th").each(function (index) {
            if ($(this).data('printhide') == true) {
                printHides.push(index);
            }
        });
        columnDefs.push({
            "targets": printHides,
            "visible": false
        });
    }
    $("#dataTable.ajax").DataTable().destroy();
    if ($("table").data('checkbox') == true) {
        orderFalseIndex.push(0);
        columnDefs.push({
            "width": '1px',
            "targets": 0
        });
    }
    $("thead tr th").each(function (index) {
        if ($(this).data('order') == false) {
            orderFalseIndex.push(index);
        }
    });
    for (let i = 0; i < 10; i++) {
        if (!orderFalseIndex.includes(i)) {
            defaultSorting = [[i, "asc"]];
            break;
        }
    }
    $("table thead tr th").each(function(index,elem) {
        if($(elem).data('default-sort') !== undefined && $(elem).data('default-sort') == true) {
            var sort_dir = 'asc';
            if($(elem).data('sort-dir') !== undefined && $(elem).data('sort-dir') != '') {
                sort_dir = $(elem).data('sort-dir');
            }
            defaultSorting = [[index,sort_dir]];
        }
    });
    columnDefs.push({
        "orderable": false,
        "targets": orderFalseIndex
    });
    var table = $('#dataTable.ajax').DataTable({
        "order": defaultSorting,
        "dom": 't<"table-bottom"irlp><"clear">',
        "columnDefs": columnDefs,
        "pageLength": pageLength,
        "processing": true,
        "serverSide": true,
        "searching": false,
        "createdRow": function (row, data, index) {
            $("thead tr th").each(function (i) {
                if ($(this).hasClass('text-center')) {
                    $(row).children(":nth-child(" + (i + 1) + ")").addClass('text-center');
                }
            });
        },
        "fnDrawCallback": function () {
            stopAjaxLoader();
            $("#dataTable_previous").html('<i class="ace-icon fa fa-angle-double-left"></i>');
            $("#dataTable_next").html('<i class="ace-icon fa fa-angle-double-right"></i>');
            if ($("tbody").text() != "No data available in table") {
                var html = '';
                if ($(".table-tools").html() == undefined) {
                    html += '<div class="table-tools">';
                }
                if(typeof tabletools !== 'undefined' && tabletools !== null) {
                    tabletools.forEach(element => {
                        if (element == 'print') {
                            var printHtml = '';
                            printHtml = '<button type="button" class="btn btn-white print-btn"><i class="fas fa-print"></i></button>';
                            html += printHtml;
                        }
                        if (element == 'export') {
                            var exportHtml = '';
                            exportHtml = '<button type="button" class="btn btn-white btn-success export-btn"><i class="fa fa-file-excel"></i></button>';
                            html += exportHtml;
                        }
                    });
                }
                if ($(".table-tools").html() == undefined) {
                    html += '</div>';
                    $(".table-responsive").before(html);
                } else {
                    $(".table-tools").html(html);
                }
            } else {
                $(".table-tools").remove();
            }
        },
        "stateSave": false,
        "ajax": {
            "url": '',
            "type": "POST",
            "data": {
                data: data,
                listing_data: true,
            }
        }
    });
    $(".dataTables_processing").empty();
    $(".dataTables_processing").append('<i class="ace-icon fa fa-spinner fa-spin white bigger-250"></i>');
}

setTimeout(function () {
    $(".alert.alert-dismissible").children('button').click();
}, 4000);
var index = 0;

function successMessage(message) {
    index = index + 1;
    $("body").append("<div class='alert alert-success alert-dismissible' id='" + (index) + "'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Success!</strong> " + message + "</div>");
    setTimeout(() => {
        $(".alert#" + index).children('button').click();
    }, 8000);
}

function failMessage(message) {
    index = index + 1;
    $("body").append("<div class='alert alert-danger alert-dismissible' id='" + (index) + "'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error!</strong> " + message + "</div>");
    setTimeout(() => {
        $(".alert#" + index).children('button').click();
    }, 9000);
}

$(document).ready(function () {
    $("button").click(function () {
        $(this).css("outline", 'none !important');
        $(this).css("decoration", 'none !important');
    });
    var count = 0;
    $(".dataTables_processing").empty();
    $(".dataTables_processing").append('<i class="ace-icon fa fa-spinner fa-spin white bigger-250"></i>');
    $("input.hide, input[type=hidden]").each(function () {
        $(this).addClass('ignore');
    });
    $("#filterForm select, #filterForm input[type!=button]").each(function () {
        var tagName = $(this).prop("tagName").toLowerCase();
        switch (tagName) {
            case "input":
                if ($.cookie("search_" + $(this).attr("id")) != "") {
                    $(this).val($.cookie("search_" + $(this).attr("id")));
                    count++;
                }
                break;
            case "select":
                if ($.cookie("search_" + $(this).attr("id")) != "null") {
                    $(this).val($.cookie("search_" + $(this).attr("id")));
                    count++;
                }
                break;
        }
    });

    if ($('table.ajax.table').length > 0) {
        drawTable(getSearchAction());
    }
    $("#filterForm").submit(function (e) {
        e.preventDefault();
        $("#filterForm button[type=button]#search").click();
    });
    $("#filterForm button#search").click(function () {
        drawTable(getSearchAction());
    });
    $("#filterForm button[type=button]#reset").click(function () {
        $("#filterForm button[type!=button], #filterForm select, #filterForm input").val("");
        $("#filterForm button[type=button]#search").click();
    });
    $("input").each(function () {
        if ($(this).data('type') == 'number') {
            var value = 0;
            var min = 1;
            var max = 15000;
            var step = 1;
            if ($(this).val() != '') {
                value = $(this).val();
            }
            if ($(this).attr('min') != undefined && $(this).attr('min') != '') {
                min = $(this).attr('min');
            }
            if ($(this).attr('max') != undefined && $(this).attr('max') != '') {
                max = $(this).attr('max');
            }
            if ($(this).attr('step') != undefined && $(this).attr('step') != '') {
                step = $(this).attr('step');
            }
            $('#' + $(this).attr('id')).ace_spinner({
                value: value, min: min, max: max, step: step, btn_up_class: 'btn-info', btn_down_class: 'btn-info'
            }).closest('.ace-spinner').on('changed.fu.spinbox', function () {
            });
        }
    });
    $("input.only-number").keydown(function (e) {
        var key = e.charCode || e.keyCode || 0;
        return (
            key == 8 ||
            key == 9 ||
            key == 13 ||
            key == 46 ||
            key == 110 ||
            key == 190 ||
            (key >= 35 && key <= 40) ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105));
    });
    // $(".formsubmit").click(function () {
    //     var ids = $(this).attr('id');
    //     if (ids == 'formSubmit') {
    //         $("form").prepend("<input class='hide' type='text' name='submit_btn' value='"+COMMON_SAVE+"'>");
    //     } else if (ids == 'formSubmitBack') {
    //         $("form").prepend("<input class='hide' type='text' name='submit_btn' value='"+COMMON_SAVE_AND_BACK+"'>");
    //     }
    //     $("form").submit();
    // });
    $("#formReset").click(function () {
        $("form").trigger('reset');
    });
    $(document).delegate('input.change_status.ajax', 'change', function () {
        var url = $(this).data('url');
        var id = $(this).parent().parent().parent().attr('id').split(":")[1];
        var statusCode = $(this).attr("name");
        var status = '0';
        if ($(this).prop('checked')) {
            status = '1';
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: {id: id, status: status, status_code: statusCode, action: 'change_status'},
            beforeSend: function () {
                $(".alert.alert-dismissible").remove();
                startAjaxLoader();
            },
            success: function (response) {
                if (response == 'success') {
                    successMessage("Status is changed successfully.");
                } else {
                    failMessage("Error while changing status.");
                }
            },
            complete: function () {
                drawTable(getSearchAction());
                stopAjaxLoader();
            }
        });
    });

    $(document).delegate('a.ajax.delete', 'click', function (e) {
        e.preventDefault();
        var atag = $(this);
        bootbox.confirm("Are you sure to delete this record ?", function (result) {
            if (result) {
                var url = $(atag).attr('href');
                $.ajax({
                    url: url,
                    type: "GET",
                    beforeSend: function () {
                        startAjaxLoader();
                    },
                    success: function (response) {
                        if (response == 'success') {
                            successMessage('Data is deleted successfully.');
                        } else {
                            failMessage(response);
                        }
                    },
                    complete: function () {
                        drawTable(getSearchAction());
                        stopAjaxLoader();
                    }
                });
            }
        });
    });
    $("thead tr th > #table_select_all").change(function () {
        $("tbody tr td > input[class*=table_checkbox]").prop('checked', $(this).prop('checked'));
    });

    if(!ace.vars['touch']) {
        $('.chosen-select').chosen({allow_single_deselect:true}); 
        //resize the chosen on window resize
        $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': '70%'});
            })
        }).trigger('resize.chosen');
        //resize chosen on sidebar collapse/expand
        $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
            if(event_name != 'sidebar_collapsed') return;
            $('.chosen-select').each(function() {
                var $this = $(this);
                $this.next().css({'width': '70%'});
            })
        });

        $('#chosen-multiple-style .btn').on('click', function(e){
            var target = $(this).find('input[type=radio]');
            var which = parseInt(target.val());
            if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
            else $('#form-field-select-4').removeClass('tag-input-style');
        });
    }

    $(".upload_file").click(function() {
        $($(this).data('trigger')).click();
    });

    $("input[type=file]").change(function() {
        var file = $(this)[0].files[0];
        var fileName = '';
        if (file) {
            fileName = file.name;
            console.log(file.name);
          }
        $(this).siblings("div[class*=col-]").append("<p id='filename_"+$(this).attr('id')+"'>"+fileName+"</p>");
    });
    autosize($('textarea[class*=autosize]'));

    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
    })
    //show datepicker when clicking on the icon
    .next().on(ace.click_event, function(){
        $(this).prev().focus();
    });

    $('input[name=date-range-picker]').daterangepicker({
        'applyClass' : 'btn-sm btn-success',
        'cancelClass' : 'btn-sm btn-default',
        locale: {
            applyLabel: 'Apply',
            cancelLabel: 'Cancel',
        }
    })
    .prev().on(ace.click_event, function(){
        $(this).next().focus();
    });

    $('.bootstrap-timepicker input[type=text]').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false,
        disableFocus: true,
        icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down'
        }
    }).on('focus', function() {
        $(this).timepicker('showWidget');
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
});

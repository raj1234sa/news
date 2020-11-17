$(document).ready(() => {
    var main_container_padding = $(".main-container").css("padding");
    var main_content_padding = $(".main-content").css("margin-left");
    $(document).keyup(function (e) {
        if (e.which == 27 && window.printMode == true) {
            drawTable(getSearchAction());
            $("#navbar").show();
            $("#breadcrumbs").show();
            $("#sidebar").show();
            $(".main-content").css('margin-left', main_content_padding);
            $(".page-header").show();
            $("#filterForm").show();
            $(".table-tools").show();
            $(".dataTable_processing").show();
            $(".dataTables_length").show();
            $(".dataTables_paginate").show();
            $(".dataTables_info").show();
            $("div.footer").show();
            $(".main-container").css('padding', main_container_padding);
            window.printMode = false;
        }
    });
    $(document).delegate(".print-btn", 'click', function () {
        window.printMode = true;
        drawTable(getSearchAction(), 'print');
        $("#navbar").hide();
        $("#breadcrumbs").hide();
        $("#sidebar").hide();
        $(".main-content").css('margin-left', "0");
        $(".page-header").hide();
        $("#filterForm").hide();
        $(".table-tools").hide();
        $(".dataTable_processing").hide();
        $(".dataTables_length").hide();
        $(".dataTables_paginate").hide();
        $(".dataTables_info").hide();
        $("div.footer").hide();
        $(".main-container").css('padding', "0");
    });
    $(document).delegate('.export-btn', 'click', function () {
        var action = getSearchAction();
        var params = $('#dataTable').DataTable().ajax.params();
        params.export = true;
        params.listing_data = undefined;
        $.ajax({
            url: '',
            type: "POST",
            data: params,
            beforeSend: function () {
                startAjaxLoader();
            },
            success: function (data) {
                data = JSON.parse(data);
                var $a = $("<a>");
                $a.attr("href", data.file);
                $("body").append($a);
                $a.attr("download", data.fileName);
                $a[0].click();
                $a.remove()
            },
            complete: function () {
                stopAjaxLoader();
            }
        });
    });
});

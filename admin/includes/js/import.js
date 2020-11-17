$(document).ready(function () {
    $(".summary").hide();
    $(".upload-import").click(function (e) {
        e.preventDefault();
        $("#import_csv").click();
    });

    $("#import_csv").change(function (e) {
        if($(this).val() != '') {
            var filename = $(this).val().substr($(this).val().lastIndexOf('\\') + 1);
            $("#fileName").text(filename);
            $("#upload_form").submit();
        }
    });

    $("#upload_form").submit(function() {
        var button = $(".upload-import");
        var formData = $(this).serialize();
        $.ajax({
            url: "/upload-csv",
            type: 'POST',
            data: new FormData(document.getElementById('upload_form')),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                button.attr("disabled", '');
            },
            success: function(data) {
                button.removeAttr("disabled");
                $("#upload_form").children("input[type=reset]").click();
                data = JSON.parse(data);
                if (data['success'] == "success") {
                    $("#summary-div").html(data['data']['html']);
                    $("#rowsuccess").html(data['data']['rowsuccess'] + "<div>Correct</div>");
                    $("#rowskipped").html(data['data']['rowskipped'] + "<div>Incorrect</div>");
                    $(".summary").show();
                    if (data['data']['rowsuccess'] > 0) {
                        $(".btn-next").removeClass('disabled');
                    }
                }
            },
            complete: function() {
                button.removeAttr("disabled");
            }
        });
        return false;
    });
});

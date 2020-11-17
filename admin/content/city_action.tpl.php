<form method="POST" class="form-horizontal">
    <div class="page-header">
        <h1>
            <?php
                echo $pageTitle;
                if(!empty($form_data['state_name'])) {
                    ?>
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?php echo $form_data['state_name'] ?>
                    </small>
                    <?php
                }
            ?>
        </h1>
        <?php echo draw_form_buttons("save,save_back,back", array('backUrl'=>DIR_HTTP_ADMIN.ADMIN_FILE_CITIES)) ?>
    </div>
    <?php
        echo form_element(COMMON_STATE_NAME, 'text', 'city_name', $form_data['city_name'], array('validation'=>array('required'=>THIS_FIELD_IS_REQUIRED)));

        echo form_element(COMMON_COUNTRY_NAME, 'select', 'country_id', $form_data['country_id'], array('validation'=>array('required'=>THIS_FIELD_IS_REQUIRED), 'list'=> $countryList, 'value_field'=>'country_id', 'text_field'=>'country_name', 'list_before'=>"<option value=''>Select Country</option>",'attributes'=>"data-sid='".$form_data['state_id']."'"));

        echo form_element(COMMON_STATE_NAME, 'select', 'state_id', $form_data['state_id'], array('validation'=>array('required'=>THIS_FIELD_IS_REQUIRED), 'list'=> array(), 'list_before'=>"<option value=''>Select State</option>"));
        
        echo form_element(COMMON_STATUS, 'switchbutton', 'status', $form_data['status'], array());
    ?>
</form>

<?php
$page_js = <<<JS
<script>
$(document).ready(function() {
    $("#country_id").change(function() {
        var cnt_id = $(this).val();
        var st_id = $(this).data("sid");
        $.ajax({
            url: '',
            data: {action: 'get_country_states', cid: cnt_id, selected_state: st_id},
            type: "POST",
            success: function(response) {
                $("#state_id").html(response);
                $('#state_id').trigger("chosen:updated");
            }
        });
    });
    $("#country_id").trigger("change");
});
</script>
JS;
?>
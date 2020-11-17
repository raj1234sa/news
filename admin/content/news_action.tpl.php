<form method="POST" class="form-horizontal" enctype="multipart/form-data">
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
    </div><!-- /.page-header -->
    <?php
        $required = array('required'=>THIS_FIELD_IS_REQUIRED);

        echo form_element(COMMON_NEWS_TITLE, 'text', 'news_title', $form_data['news_title'], array('validation'=>$required));

        echo form_element(COMMON_INDUSTRY_NAME, 'select', 'industry_id', $form_data['industry_id'], array('validation'=>$required, 'list'=> $industryList, 'value_field'=>'industry_id', 'text_field'=>'industry_name', 'list_before'=>"<option value=''>Select Industry</option>"));

        echo form_element(COMMON_SHORT_DESCRIPTION, 'textarea', 'short_desc', $form_data['short_desc'], array('validation'=>$required, 'autosize'=>true));

        echo form_element(COMMON_LONG_DESCRIPTION, 'textarea', 'long_desc', $form_data['long_desc'], array('autosize'=>true));

        echo form_element(COMMON_SMALL_IMAGE, 'file', 'small_image', $form_data['small_image'], array('validation'=>$required));

        echo form_element(COMMON_LARGE_IMAGE, 'file', 'large_image', $form_data['large_image'], array('validation'=>$required));

        echo form_element(COMMON_COUNTRY_NAME, 'select', 'country_id', $form_data['country_id'], array('list'=> $countryList, 'value_field'=>'country_id', 'text_field'=>'country_name', 'list_before'=>"<option value=''>Select Country</option>",'attributes'=>"data-sid='".$form_data['state_id']."'"));

        echo form_element(COMMON_STATE_NAME, 'select', 'state_id', $form_data['state_id'], array('list'=> array(), 'list_before'=>"<option value=''>Select State</option>",'attributes'=>"data-cid='".$form_data['city_id']."'"));

        echo form_element(COMMON_CITY_NAME, 'select', 'city_id', $form_data['city_id'], array('list'=> array(), 'list_before'=>"<option value=''>Select City</option>"));
        
        echo form_element(COMMON_PUBLISH_DATE, 'datepicker', 'news_date', date(SITE_DATE_FORMAT, strtotime($form_data['news_date'])), array());
        
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
                $("#state_id").trigger('change');
                $('#state_id').trigger("chosen:updated");
            }
        });
    });
    $("#country_id").trigger("change");

    $("#state_id").change(function() {
        var st_id = $(this).val();
        var ct_id = $(this).data("cid");
        $.ajax({
            url: '',
            data: {action: 'get_state_cities', sid: st_id, selected_city: ct_id},
            type: "POST",
            success: function(response) {
                $("#city_id").html(response);
                $('#city_id').trigger("chosen:updated");
            }
        });
    });
});
</script>
JS;
?>
<form method="POST" class="form-horizontal">
    <div class="page-header">
        <h1>
            <?php
                echo $pageTitle;
                if(!empty($form_data['country_name'])) {
                    ?>
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?php echo $form_data['country_name'] ?>
                    </small>
                    <?php
                }
            ?>
        </h1>
        <?php echo draw_form_buttons("save,save_back,back", array('backUrl'=>DIR_HTTP_ADMIN.ADMIN_FILE_COUNTRIES)) ?>
    </div>
    <?php
        echo form_element(COMMON_COUNTRY_NAME, 'text', 'country_name', $form_data['country_name'], array('validation'=>array('required'=>THIS_FIELD_IS_REQUIRED)));
        
        echo form_element(COMMON_STATUS, 'switchbutton', 'status', $form_data['status'], array());
    ?>
</form>
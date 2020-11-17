<form method="POST" class="form-horizontal">
    <div class="page-header">
        <h1>
            <?php
                echo $pageTitle;
                if(!empty($news_id)) {
                    ?>
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?php echo $form_data['industry_name'] ?>
                    </small>
                    <?php
                }
            ?>
        </h1>
        <?php echo draw_form_buttons("save,save_back,back", array('backUrl'=>DIR_HTTP_ADMIN.ADMIN_FILE_INDUSTRIES)) ?>
    </div>
    <?php
        echo form_element(COMMON_INDUSTRY_NAME, 'text', 'industry_name', $form_data['industry_name'], array('validation'=>array('required'=>THIS_FIELD_IS_REQUIRED), 'error'=>$validation['industry_name']));
        
        echo form_element(COMMON_SORT_ORDER, 'number', 'sort_order', $form_data['sort_order'], array('validation'=>array('required'=>THIS_FIELD_IS_REQUIRED)));

        echo form_element(COMMON_STATUS, 'switchbutton', 'status', $form_data['status'], array());
    ?>
</form>
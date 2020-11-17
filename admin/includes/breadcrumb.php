<div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
    <ul class="breadcrumb">
        <?php
        if(FILE_FILENAME_WITHOUT_EXT !== 'dashboard') {
            $html = '<li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="' . DIR_HTTP_ADMIN.ADMIN_FILE_DASHBOARD . '">'.COMMON_HOME.'</a>
                </li>';
            foreach ($breadcrumbs as $key => $value) {
                if ($value['active'] == true) {
                    $html .= '<li class="active">' . $value['title'] . '</li>';
                } else {
                    $html .= '<li>
                                <a href="' . $value['route'] . '">' . $value['title'] . '</a>
                            </li>';
                }
            }
        } else {
            $html = '<li class="active"><i class="ace-icon fa fa-home home-icon"></i>'.COMMON_HOME.'</li>';
        }
        echo $html;
        ?>
    </ul><!-- /.breadcrumb -->
    <i class="ace-icon fa fa-spinner fa-spin bigger-150 ajaxloader hide"></i>
</div>
<!DOCTYPE html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <meta name="description" content="Common Buttons &amp; Icons"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <?php require_once(ADMIN_DIR_WS_INCLUDE.'css.php'); ?>
    <title><?php echo $pageTitle ?> :: Admin</title>
</head>
<body class="no-skin">
    <?php require_once(ADMIN_DIR_WS_INCLUDE.'header.php'); ?>
    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
            try {
                ace.settings.loadState('main-container')
            } catch (e) {
            }
        </script>

        <?php require_once(ADMIN_DIR_WS_INCLUDE.'leftmenu.php'); ?>
        <div class="main-content">
            <div class="main-content-inner">
                <?php require_once(ADMIN_DIR_WS_INCLUDE.'breadcrumb.php'); ?>
                <div class="page-content">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <?php
                                $filetpl = (!empty($tplFile)) ? ADMIN_DIR_WS_CONTENT.$tplFile : ADMIN_DIR_WS_CONTENT.FILE_FILENAME_WITHOUT_EXT;
                                require_once($filetpl.'.tpl.php');
                            ?>
                            <!-- PAGE CONTENT ENDS -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.page-content -->
            </div>
        </div><!-- /.main-content -->
        <?php require_once(ADMIN_DIR_WS_INCLUDE.'footer.php'); ?>
    </div><!-- /.main-container -->
    <?php require_once(ADMIN_DIR_WS_INCLUDE.'js.php'); ?>
    <script>
        <?php
            $flash_message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            echo "var message='".$flash_message[0]."';";
            echo "var mode='".$flash_message[1]."';";
        ?>
        if(mode == 'success') {
            successMessage(message);
        } else if(mode == 'fail') {
            failMessage(message);
        }
    </script>
    <script>
        var COMMON_SAVE_AND_BACK = "<?php echo COMMON_SAVE_AND_BACK ?>";
        var COMMON_SAVE = "<?php echo COMMON_SAVE ?>";
    </script>
    <?php echo $page_js; ?>
</body>
</html>
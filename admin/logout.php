<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."AdminMaster.php");

unset($_SESSION['admin_login']);
show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_LOGIN);
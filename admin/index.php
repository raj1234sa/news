<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."AdminMaster.php");

$objAdminMaster = new AdminMaster();
$objAdminData = new AdminData();

if(isset($_SESSION['admin_login']) && !empty($_SESSION['admin_login'])) {
    show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_DASHBOARD);
}

$loginbtn = $_POST['loginbtn'];

if(isset($loginbtn)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $backurl = $_POST['backUrl'];
    
    $objAdminMaster->setWhere("AND admin_username = :admin_username", $username, 'string');
    $objAdminMaster->setWhere("AND admin_password = :admin_password", $password, 'string');
    $adminDetails = $objAdminMaster->getAdmin();
    
    if(empty($adminDetails)) {
        $message = ADMIN_LOGIN_FAIL;
    } else {
        $_SESSION['admin_login'] = $adminDetails[0]['admin_id'];
        $backurl = empty($backurl) ? DIR_HTTP_ADMIN.ADMIN_FILE_DASHBOARD : $backurl;
        show_page_header($backurl);
    }
}

$backurl = $_GET['backurl'];

require_once(ADMIN_DIR_WS_CONTENT."index.tpl.php");

?>
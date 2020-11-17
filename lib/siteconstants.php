<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."AdminMaster.php");

$objAdminMaster = new AdminMaster();

$objAdminMaster->setWhere("AND admin_id = :admin_id", $_SESSION['admin_login'], 'int');
$loginAdminData = $objAdminMaster->getAdmin();

if(!empty($loginAdminData)) {
    $loginAdminData = $loginAdminData[0];
    define('ADMIN_ID', $loginAdminData->admin_id);
    define('ADMIN_USERNAME', $loginAdminData->admin_username);
    define('IS_ADMIN', true);
} else {
    define('IS_ADMIN', false);
}

define('SITE_DATE_FORMAT', 'm/d/Y');
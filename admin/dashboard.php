<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."AdminMaster.php");

$objAdminMaster = new AdminMaster();
$objAdminData = new AdminData();

$pageTitle = COMMON_DASHBOARD;

$objAdminData->admin_username = 'admin';
$objAdminData->admin_password = 'admin';

// echo $objAdminMaster->addAdmin($objAdminData);

$objAdminMaster->setWhere("AND admin_id = :admin_id", '1', 'int');
// echo '<pre>'; print_r(objectToArray($objAdminMaster->getAdmin())); echo '</pre>';

$action_buttons = array();
$action_buttons['Add Service'] = array(
    'class' => 'btn btn-success',
    'link' => 'add-service',
    'icon' => 'fa fa-plus',
);
$action_buttons['Import Service'] = array(
    'class' => 'btn btn-grey',
    'link' => 'import-service',
    'icon' => 'fa fa-upload',
);

require_once(ADMIN_FILE_MAIN_INTERFACE);

?>
<?php
session_start();
error_reporting(0);

require_once("path.php");
require_once(DIR_WS_LIB."functions.php");

$filenameWithoutExt = pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_FILENAME);
$filename = pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_BASENAME);
define('FILE_FILENAME_WITHOUT_EXT', $filenameWithoutExt);
define('FILE_FILENAME_WITH_EXT', $filename);

require_once(ADMIN_DIR_WS_INCLUDE.'filenames.php');

if(strpos($_SERVER['REQUEST_URI'], '/admin') !== FALSE) {
    define('IS_ADMIN_URL', true);
} else {
    define('IS_ADMIN_URL', false);
}

$is_ajax_request = false;
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    $is_ajax_request = true;
}

define('CURRENT_FILE_URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);

$backurl = '';
if(FILE_FILENAME_WITHOUT_EXT != 'index') {
    if(empty($_SESSION['admin_login'])) {
        show_page_header(DIR_HTTP_ADMIN.ADMIN_FILE_LOGIN.'?backurl='.urlencode(CURRENT_FILE_URL));
    }
}

if(IS_ADMIN_URL) {
    require_once DIR_WS_VENDOR."autoload.php";
    require_once(ADMIN_DIR_WS_INCLUDE.'constants.php');
    require_once(ADMIN_DIR_WS_INCLUDE.'html_render.php');
    require_once(ADMIN_DIR_WS_INCLUDE.'functions.php');
}
require_once(DIR_WS_LIB."siteconstants.php");
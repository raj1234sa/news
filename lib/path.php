<?php
// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";

define('SITE_HTTP_URL', 'http://'.$_SERVER['HTTP_HOST'].'/master/');
define('SITE_WS_URL', $_SERVER['DOCUMENT_ROOT'].'/master/');

define('DIR_HTTP_CSS', SITE_HTTP_URL.'css/');
define('DIR_HTTP_JS', SITE_WS_URL.'js/');

define('DIR_HTTP_IMAGES', SITE_HTTP_URL.'images/');
define('DIR_WS_IMAGES', SITE_WS_URL.'images/');

define('DIR_WS_LIB', SITE_WS_URL.'lib/');

define('DIR_WS_VENDOR', SITE_WS_URL.'vendor/');

define('DIR_HTTP_ADMIN', SITE_HTTP_URL.'admin/');
define('DIR_WS_ADMIN', SITE_WS_URL.'admin/');

define('DIR_WS_MODEL', SITE_WS_URL.'Model/');

define('DIR_WS_MODEL_CLASSES', DIR_WS_MODEL.'Classes/');

define('ADMIN_DIR_WS_INCLUDE', DIR_WS_ADMIN.'includes/');
define('ADMIN_DIR_HTTP_INCLUDE', DIR_HTTP_ADMIN.'includes/');

define('ADMIN_DIR_WS_CONTENT', DIR_WS_ADMIN.'content/');
define('ADMIN_DIR_HTTP_CONTENT', DIR_HTTP_ADMIN.'content/');

define('ADMIN_DIR_HTTP_CSS', ADMIN_DIR_HTTP_INCLUDE.'css/');
define('ADMIN_DIR_HTTP_JS', ADMIN_DIR_HTTP_INCLUDE.'js/');

define('DIR_HTTP_IMAGES_NEW', DIR_HTTP_IMAGES.'news/');
define('DIR_WS_IMAGES_NEWS', DIR_WS_IMAGES.'news/');
?>
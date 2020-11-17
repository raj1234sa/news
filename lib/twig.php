<?php
date_default_timezone_set("Asia/Kolkata");
require_once DIR_WS_VENDOR."autoload.php";

use Twig\Extra\Intl\IntlExtension;

$loader = new \Twig\Loader\FilesystemLoader(ADMIN_DIR_WS_CONTENT);
$twig = new \Twig\Environment($loader);
$twig->addExtension(new IntlExtension());

<?php
session_start();
ob_start();
define('_DIR_ROOT', __DIR__);
require_once 'models/ModelDAO.php';
require_once 'helper/functions.php';
require_once 'controllers/Controller.php';
require_once 'helper/routes.php';
require_once 'App.php';
$app = new App();
?>


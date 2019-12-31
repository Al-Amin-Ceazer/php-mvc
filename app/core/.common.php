<?php
session_start();
date_default_timezone_set('Asia/Dhaka');

define('APPLICATION_PATH', __DIR__);

define('BASEPATH', __DIR__);


$FLASH = @$_SESSION['__FLASH__'];
$_SESSION['__FLASH__'] = array();
unset($_SESSION['__FLASH__']);

if (empty($FLASH)) {
    $FLASH = array();
}

require APPLICATION_PATH."/config.php";
require APPLICATION_PATH."/environment.php";
require APPLICATION_PATH."/functions.php";


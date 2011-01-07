<?php

$page = basename (__FILE__, '.php');
require_once ('public_init.php');

$general = $br->general_settings ();
$albums = $br->list_albums ();
header ('Content-Type: text/javascript');
require_once ('html/public_config.php');

?>
<?php

$page = basename (__FILE__, '.php');
require_once ('public_init.php');

$general = $br->general_settings ();
$albums = $br->list_albums ();
header ('Content-Type: text/css');
require_once ('html/public_css.php');

?>
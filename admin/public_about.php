<?php

$page = basename (__FILE__, '.php');
require_once ('public_init.php');

$about_page = $br->about_page ();
require_once ('html/public_about.php');

?>
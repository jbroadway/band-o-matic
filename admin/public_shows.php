<?php

$page = basename (__FILE__, '.php');
require_once ('public_init.php');

$shows = $br->public_shows ();
header ('Content-Type: application/json');
require_once ('html/public_shows.php');

?>
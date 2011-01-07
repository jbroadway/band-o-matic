<?php

$page = basename (__FILE__, '.php');
require_once ('init.php');

$shows = $br->list_shows ();
$past = $br->list_past_shows ();
require_once ('html/shows.php');

?>
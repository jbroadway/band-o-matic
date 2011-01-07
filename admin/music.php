<?php

$page = basename (__FILE__, '.php');
require_once ('init.php');

$albums = $br->list_albums ();
require_once ('html/music.php');

?>
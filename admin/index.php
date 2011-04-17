<?php

$page = basename (__FILE__, '.php');
require_once ('init.php');

if ($_POST['artist_name']) {
	if (! $br->general_settings ($_POST)) {
		$updated = false;
		$general = (object) $_POST;
	} else {
		$updated = true;
		$general = $br->general_settings ();
	}
} else {
	$general = $br->general_settings ();
}

$about_page = $br->about_page ();

require_once ('html/index.php');

?>
<?php

$page = basename (__FILE__, '.php');
require_once ('init.php');

if ($_POST['name']) {
	if (! $br->add_album ($_POST)) {
		$updated = false;
	} else {
		$updated = true;
	}
}
require_once ('html/music_add.php');

?>
<?php

$page = basename (__FILE__, '.php');
require_once ('init.php');

if ($_POST['date']) {
	if (! $br->add_show ($_POST)) {
		$updated = false;
	} else {
		$updated = true;
	}
} else {
	$_POST['date'] = gmdate ('Y-m-d');
	$_POST['time'] = '20:00:00';
	$_POST['city'] = $settings['default_city'];
}
require_once ('html/shows_add.php');

?>
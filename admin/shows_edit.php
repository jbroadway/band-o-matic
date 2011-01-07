<?php

$page = basename (__FILE__, '.php');
require_once ('init.php');

if ($_POST['date']) {
	if (! $br->edit_show ($_POST)) {
		$updated = false;
	} else {
		$updated = true;
	}
	$show = (object) $_POST;
} else {
	$show = $br->view_show ($_REQUEST['id']);
}
require_once ('html/shows_edit.php');

?>
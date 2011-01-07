<?php

$page = basename (__FILE__, '.php');
require_once ('init.php');

if ($_POST['name']) {
	if (! $br->edit_album ($_POST)) {
		$updated = false;
	} else {
		$updated = true;
	}
	$album = (object) $_POST;
} else {
	$album = $br->view_album ($_REQUEST['id']);
}
require_once ('html/music_edit.php');

?>
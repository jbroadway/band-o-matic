<?php

$page = basename (__FILE__, '.php');
require_once ('init.php');

if (! $br->delete_album ($_GET['id'])) {
	$updated = false;
} else {
	$updated = true;
}
require_once ('html/music_delete.php');

?>
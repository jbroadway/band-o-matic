<?php

$page = basename (__FILE__, '.php');
require_once ('init.php');

if ($_POST['shows_rss']) {
	if (! $br->shows_rss ($_POST['shows_rss'])) {
		$updated = false;
	} else {
		$updated = true;
	}
}

$shows_rss = $br->shows_rss ();
$shows = $br->list_shows ();
$past = $br->list_past_shows ();
require_once ('html/shows.php');

?>
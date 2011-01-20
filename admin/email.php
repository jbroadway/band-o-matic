<?php

$page = basename (__FILE__, '.php');
require_once ('init.php');

if (isset ($_POST['title'])) {
	if (! $br->email_page ($_POST)) {
		$updated = false;
		$email_page = (object) $_POST;
	} else {
		$updated = true;
		$email_page = $br->email_page ();
	}
} else {
	$email_page = $br->email_page ();
	if (! $email_page) {
		$email_page->css = "body {\n\tbackground-color: transparent;\n\tfont-family: Helvetica, Arial, sans-serif;\n\tcolor: #eee;\n}\n";
	}
}
require_once ('html/email.php');

?>
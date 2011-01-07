<?php

if (get_magic_quotes_gpc ()) {
	foreach ($_GET as $k => $v) {
		$_GET[$k] = stripslashes ($v);
	}
	foreach ($_POST as $k => $v) {
		$_POST[$k] = stripslashes ($v);
	}
	foreach ($_REQUEST as $k => $v) {
		$_REQUEST[$k] = stripslashes ($v);
	}
}

$settings = parse_ini_file ('config/settings.php');
if ($settings['admin_username'] == 'default' && $settings['admin_password'] == 'default') {
	die ('You have not yet configured this site to be administered. Please edit the admin/settings.php file to enable the admin area.');
}

if (function_exists ('date_default_timezone_set')) {
	date_default_timezone_set ('GMT');
}

require_once ('lib/Database.php');

if (! db_open ('config/database.db')) {
	die (db_error ());
}

require_once ('lib/Bandorama.php');

$br = new Bandorama ($settings);

if (! $br->authenticate ()) {
	$unauthorized = true;
	require_once ('html/login.php');
	exit;
}

$br->initialize ();

?>
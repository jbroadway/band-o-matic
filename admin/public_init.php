<?php

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

require_once ('lib/Bandomatic.php');

$br = new Bandomatic ($settings);

?>
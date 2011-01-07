<?php

$page = basename (__FILE__, '.php');
require_once ('public_init.php');

$email_page = $br->email_page ();
require_once ('html/public_email.php');

?>
<div id="index" data-role="page"></div>
<?php

chdir ('admin');

$page = basename (__FILE__, '.php');
require_once ('public_init.php');

$albums = $br->list_albums ();
foreach ($albums as $album) {
	printf (
		"<div id=\"%s\" data-role=\"page\"></div>\n",
		preg_replace ('/[^a-z0-9-]+/', '-', strtolower ($album->name))
	);
}

?>
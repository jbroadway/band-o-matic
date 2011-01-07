_br.artist_name = '<?php echo $general->artist_name; ?>';

_br.twitter_user = '<?php echo $general->twitter_id; ?>';

_br.twitter_count = <?php echo $general->twitter_posts; ?>;

_br.shows_url = 'admin/public_shows.php';

_br.email_page = 'admin/public_email.php';

_br.popup_delay = 10000;

_br.initial_popup_delay = 3000;

_br.loop_popups = true;

_br.loop_tracks = true;

_br.tracks = {
<?php

$sep = "\t";
foreach ($albums as $album) {
	printf (
		$sep . "'%s': [\n\t\t'%s'\n\t]",
		preg_replace ('/[^a-z0-9-]+/', '-', strtolower ($album->name)),
		preg_replace ('/[\r\n]+/', "',\n\t\t'", trim ($album->songs))
	);
	$sep = ",\n\t";
}

?>

};

_br.pages = {
	'index': {transition: 'slide'},
<?php

$sep = "\t";
foreach ($albums as $album) {
	printf (
		$sep . "'%s': {transition: 'slide'}",
		preg_replace ('/[^a-z0-9-]+/', '-', strtolower ($album->name))
	);
	$sep = ",\n\t";
}

?>

};

_br.messages = {
	'index': [
		'<?php

echo preg_replace ('/[\r\n]+/', "',\n\t\t'", trim (addslashes ($general->popups)));

		?>'
	],
<?php

$sep = "\t";
foreach ($albums as $album) {
	printf (
		$sep . "'%s': [\n\t\t'%s'\n\t]",
		preg_replace ('/[^a-z0-9-]+/', '-', strtolower ($album->name)),
		preg_replace ('/[\r\n]+/', "',\n\t\t'", trim (addslashes ($album->popups)))
	);
	$sep = ",\n\t";
}

?>

};

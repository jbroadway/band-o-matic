<?php require_once ('html/header.php'); ?>

<h2>Music</h2>

<p><a href="music_add.php">Add an album</a></p>

<h3>Albums</h3>

<?php

if (count ($albums) == 0) {
	echo '<p>No albums yet.</p>';
}

foreach ($albums as $album) {
	echo sprintf (
		'<p class="album"><img src="%s" class="icon" /><strong>%s</strong><br /><a href="music_edit.php?id=%d">Edit</a> | <a href="music_delete.php?id=%d" onclick="return confirm(\'Are you sure?\')">Delete</a></p>',
		$album->icon,
		$album->name,
		$album->id,
		$album->id
	);
}

?>

<?php require_once ('html/footer.php'); ?>
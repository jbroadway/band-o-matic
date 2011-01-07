<?php require_once ('html/header.php'); ?>

<h2>Delete Album</h2>

<?php

if (isset ($updated) && $updated) {
	echo '<p class="notice">Your album has been deleted. <a href="music.php">Back</a></p>';
} elseif (isset ($updated) && ! $updated) {
	echo '<p class="error">Failed to delete the album: ' . $br->error . '</p>';
}

?>

<?php require_once ('html/footer.php'); ?>
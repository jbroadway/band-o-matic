<?php require_once ('html/header.php'); ?>

<h2>Delete Show</h2>

<?php

if (isset ($updated) && $updated) {
	echo '<p class="notice">Your show has been deleted. <a href="shows.php">Back</a></p>';
} elseif (isset ($updated) && ! $updated) {
	echo '<p class="error">Failed to delete the show: ' . $br->error . '</p>';
}

?>

<?php require_once ('html/footer.php'); ?>
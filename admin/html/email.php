<?php require_once ('html/header.php'); ?>

<h2>Email Page</h2>

<?php

if (isset ($updated) && $updated) {
	echo '<p class="notice">Your changes have been saved.</p>';
} elseif (isset ($updated) && ! $updated) {
	echo '<p class="error">Failed to save the changes: ' . $br->error . '</p>';
}

?>

<form method="post">
<p>Page title:<br /><input type="text" name="title" value="<?php echo $email_page->title; ?>" size="50" /></p>

<p>Page body (HTML):<br />
<textarea name="body" id="body" rows="20" cols="90"><?php echo htmlentities ($email_page->body); ?></textarea></p>

<p>Stylesheet (CSS):<br />
<textarea name="css" id="css" rows="10" cols="90"><?php echo $email_page->css; ?></textarea></p>

<p><input type="submit" value="Save" /></p>
</form>

<?php require_once ('html/footer.php'); ?>
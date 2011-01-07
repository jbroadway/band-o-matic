<?php require_once ('html/header.php'); ?>

<h2>General Settings</h2>

<?php

if (isset ($updated) && $updated) {
	echo '<p class="notice">Your settings have been saved.</p>';
} elseif (isset ($updated) && ! $updated) {
	echo '<p class="error">Failed to save the settings: ' . $br->error . '</p>';
}

?>

<form method="post">
<p>Artist name:<br /><input type="text" name="artist_name" value="<?php echo $general->artist_name; ?>" size="50" /></p>

<p>Twitter ID:<br /><input type="text" name="twitter_id" value="<?php echo $general->twitter_id; ?>" size="30" /></p>

<p>Show Twitter posts: <select name="twitter_posts">
	<option value="5"<?php if ($general->twitter_posts == 5) { echo ' selected'; } ?>>5</option>
	<option value="10"<?php if ($general->twitter_posts == 10) { echo ' selected'; } ?>>10</option>
	<option value="15"<?php if ($general->twitter_posts == 15) { echo ' selected'; } ?>>15</option>
</select> (5 is recommended for phones)</p>

<p>Homepage popup messages (one-per-line):<br />
<textarea name="popups" rows="12" cols="90"><?php echo htmlentities ($general->popups); ?></textarea></p>

<p class="example"><strong>Popup examples:</strong><br />
Buy our new album on &lt;a href="...itunes link..."&gt;iTunes&lt;/a&gt;<br />
http://www.your-band.com/photos/live-shot-01.jpg</p>

<p><strong>Homepage Backgrounds</strong></p>

<p>iPhone portrait: (link to 320x480 jpg file)<br />
<input type="text" name="bg_320x480" placeholder="/m/pix/bg_320x480.jpg" value="<?php echo $general->bg_320x480; ?>" size="50" /></p>

<p>iPhone landscape: (link to 480x320 jpg file)<br />
<input type="text" name="bg_480x320" placeholder="/m/pix/bg_480x320.jpg" value="<?php echo $general->bg_480x320; ?>" size="50" /></p>

<p>iPad portrait: (link to 768x1024 jpg file)<br />
<input type="text" name="bg_768" placeholder="/m/pix/bg_768.jpg" value="<?php echo $general->bg_768; ?>" size="50" /></p>

<p>iPad landscape: (link to 1024x768 jpg file)<br />
<input type="text" name="bg_1024" placeholder="/m/pix/bg_1024.jpg" value="<?php echo $general->bg_1024; ?>" size="50" /></p>

<p><input type="submit" value="Save" /></p>
</form>

<?php require_once ('html/footer.php'); ?>
<?php require_once ('html/header.php'); ?>

<script type="text/javascript">

$(document).ready (function () {
	_admin.registered_for_bandorama ();
});

</script>

<div id="registered-for-bandorama">Register your band for the Band-o-rama iPhone &amp; iPad app, it's a great way to get heard and grow your fanbase!<br />
Plus it's free, just like Band-o-matic! <a href="http://www.band-o-rama.com/artists" target="_blank">Click here to register</a></div>

<div id="qr-code"><img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=http%3A%2F%2F<?php echo $_SERVER['HTTP_HOST']; ?>%2F&choe=UTF-8" border="0" alt="QR Code" /><br />
Use the above <a href="http://en.wikipedia.org/wiki/QR_code" target="_blank">QR code</a> in flyers and giveaway cards to send fans to your mobile site.
</div>

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

<p>Twitter ID or News RSS:<br /><input type="text" name="twitter_id" value="<?php echo $general->twitter_id; ?>" size="50" /></p>

<!-- p>Show Twitter/News posts: <select name="twitter_posts">
	<option value="5"<?php if ($general->twitter_posts == 5) { echo ' selected'; } ?>>5</option>
	<option value="10"<?php if ($general->twitter_posts == 10) { echo ' selected'; } ?>>10</option>
	<option value="15"<?php if ($general->twitter_posts == 15) { echo ' selected'; } ?>>15</option>
</select> (5 is recommended for phones)</p -->
<input type="hidden" name="twitter_posts" value="5" />

<p>About/bio page (HTML):<br />
<textarea name="body" id="body" rows="20" cols="82"><?php echo htmlentities ($about_page->body); ?></textarea></p>

<p>Homepage popup messages for phones (one-per-line):<br />
<textarea name="popups" rows="12" cols="82"><?php echo htmlentities ($general->popups); ?></textarea></p>

<p class="example"><strong>Popup examples:</strong><br />
Buy our new album on &lt;a href="...itunes link..."&gt;iTunes&lt;/a&gt;<br />
http://www.your-band.com/photos/live-shot-01.jpg</p>

<p><strong>Homepage Backgrounds</strong></p>

<p>iPhone portrait: (link to 320x480 jpg file)<br />
<input type="text" name="bg_320x480" id="bg_320x480" placeholder="/m/pix/bg_320x480.jpg" value="<?php echo $general->bg_320x480; ?>" size="50" /> <input type="file" id="file_bg_320x480" class="jpg" /></p>

<p>iPhone landscape: (link to 480x320 jpg file)<br />
<input type="text" name="bg_480x320" id="bg_480x320" placeholder="/m/pix/bg_480x320.jpg" value="<?php echo $general->bg_480x320; ?>" size="50" /> <input type="file" id="file_bg_480x320" class="jpg" /></p>

<p>iPad portrait: (link to 768x1024 jpg file)<br />
<input type="text" name="bg_768" id="bg_768" placeholder="/m/pix/bg_768.jpg" value="<?php echo $general->bg_768; ?>" size="50" /> <input type="file" id="file_bg_768" class="jpg" /></p>

<p>iPad landscape: (link to 1024x768 jpg file)<br />
<input type="text" name="bg_1024" id="bg_1024" placeholder="/m/pix/bg_1024.jpg" value="<?php echo $general->bg_1024; ?>" size="50" /> <input type="file" id="file_bg_1024" class="jpg" /></p>

<p><a href="#" onclick="$('#themes').toggle ('slow'); return false">Or choose a theme</a></p>

<div id="themes" style="display: none">
<a href="#" onclick="return theme_select ('theme1', 'png')"><img src="themes/theme1/thumb.jpg" /></a>
<a href="#" onclick="return theme_select ('theme2', 'png')"><img src="themes/theme2/thumb.jpg" /></a>
<a href="#" onclick="return theme_select ('theme3', 'jpg')"><img src="themes/theme3/thumb.jpg" /></a>
<a href="#" onclick="return theme_select ('theme4', 'jpg')"><img src="themes/theme4/thumb.jpg" /></a>
<a href="#" onclick="return theme_select ('theme5', 'jpg')"><img src="themes/theme5/thumb.jpg" /></a>
<a href="#" onclick="return theme_select ('theme6', 'jpg')"><img src="themes/theme6/thumb.jpg" /></a>
<a href="#" onclick="return theme_select ('theme7', 'jpg')"><img src="themes/theme7/thumb.jpg" /></a>
<a href="#" onclick="return theme_select ('theme8', 'jpg')"><img src="themes/theme8/thumb.jpg" /></a>
<a href="#" onclick="return theme_select ('theme9', 'jpg')"><img src="themes/theme9/thumb.jpg" /></a>
<a href="#" onclick="return theme_select ('theme10', 'jpg')"><img src="themes/theme10/thumb.jpg" /></a>
</div>

<p><input type="submit" value="Save" /></p>
</form>

<?php require_once ('html/footer.php'); ?>
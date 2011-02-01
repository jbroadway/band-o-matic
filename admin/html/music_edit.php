<?php require_once ('html/header.php'); ?>

<h2>Edit Album</h2>

<?php

if (isset ($updated) && $updated) {
	echo '<p class="notice">Your album has been updated. <a href="music.php">Back</a></p>';
} elseif (isset ($updated) && ! $updated) {
	echo '<p class="error">Failed to save the album: ' . $br->error . '</p>';
}

?>

<form method="post">
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />

<p>Album name:<br />
<input type="text" name="name" value="<?php echo $album->name; ?>" size="30" /></p>

<p>Sorting weight: (higher numbers appear first)<br />
<input type="text" name="weight" value="<?php echo $album->weight; ?>" size="20" /></p>

<p>Icon: (link to 40x40 jpg file)<br />
<input type="text" name="icon" id="icon" placeholder="/m/pix/album_icon.jpg" value="<?php echo $album->icon; ?>" size="50" /> <input type="file" id="file_icon" class="jpg" /></p>

<p><strong>Backgrounds</strong></p>

<p>iPhone portrait: (link to 320x480 jpg file)<br />
<input type="text" name="bg_320x480" id="bg_320x480" placeholder="/m/pix/album_320x480.jpg" value="<?php echo $album->bg_320x480; ?>" size="50" /> <input type="file" id="file_bg_320x480" class="jpg" /></p>

<p>iPhone landscape: (link to 480x320 jpg file)<br />
<input type="text" name="bg_480x320" id="bg_480x320" placeholder="/m/pix/album_480x320.jpg" value="<?php echo $album->bg_480x320; ?>" size="50" /> <input type="file" id="file_bg_480x320" class="jpg" /></p>

<p>iPad portrait: (link to 768x1024 jpg file)<br />
<input type="text" name="bg_768" id="bg_768" placeholder="/m/pix/album_768.jpg" value="<?php echo $album->bg_768; ?>" size="50" /> <input type="file" id="file_bg_768" class="jpg" /></p>

<p>iPad landscape: (link to 1024x768 jpg file)<br />
<input type="text" name="bg_1024" id="bg_1024" placeholder="/m/pix/album_1024.jpg" value="<?php echo $album->bg_1024; ?>" size="50" /> <input type="file" id="file_bg_1024" class="jpg" /></p>

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

<p>Songs: (links to MP3 files, one-per-line. Max file size: <?php echo ini_get ('upload_max_filesize'); ?>)<br />
<textarea name="songs" id="songs" rows="4" cols="90" placeholder="/m/mp3/song_name.mp3"><?php echo $album->songs; ?></textarea><br />
&nbsp;<input type="file" id="file_songs" class="mp3" /></p>

<p>Popup messages (one-per-line):<br />
<textarea name="popups" rows="8" cols="90"><?php echo htmlentities ($album->popups); ?></textarea></p>

<p class="example"><strong>Popup examples:</strong><br />
Buy this album on &lt;a href="...itunes link..."&gt;iTunes&lt;/a&gt;<br />
This album was inspired by cute baby animals.</p>

<p><input type="submit" value="Save" /></p>
</form>

<?php require_once ('html/footer.php'); ?>
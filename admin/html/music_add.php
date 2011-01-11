<?php require_once ('html/header.php'); ?>

<h2>Add Album</h2>

<?php

if (isset ($updated) && $updated) {
	echo '<p class="notice">Your album has been added. <a href="music.php">Back</a></p>';
} elseif (isset ($updated) && ! $updated) {
	echo '<p class="error">Failed to save the album: ' . $br->error . '</p>';
}

?>

<form method="post">
<p>Album name:<br />
<input type="text" name="name" value="<?php echo $_POST['name']; ?>" size="30" /></p>

<p>Sorting weight: (higher numbers appear first)<br />
<input type="text" name="weight" value="<?php

if (! isset ($_POST['weight'])) {
	echo db_shift ('select count(*) from albums') + 1;
} else {
	echo $_POST['weight'];
}

?>" size="20" /></p>

<p>Icon: (link to 40x40 jpg file)<br />
<input type="text" name="icon" placeholder="/m/pix/album_icon.jpg" value="<?php echo $_POST['icon']; ?>" size="50" /></p>

<p><strong>Backgrounds</strong></p>

<p>iPhone portrait: (link to 320x480 jpg file)<br />
<input type="text" name="bg_320x480" id="bg_320x480" placeholder="/m/pix/album_320x480.jpg" value="<?php echo $_POST['bg_320x480']; ?>" size="50" /> <input type="file" id="file_bg_320x480" class="jpg" /></p>

<p>iPhone landscape: (link to 480x320 jpg file)<br />
<input type="text" name="bg_480x320" id="bg_480x320" placeholder="/m/pix/album_480x320.jpg" value="<?php echo $_POST['bg_480x320']; ?>" size="50" /> <input type="file" id="file_bg_480x320" class="jpg" /></p>

<p>iPad portrait: (link to 768x1024 jpg file)<br />
<input type="text" name="bg_768" id="bg_768" placeholder="/m/pix/album_768.jpg" value="<?php echo $_POST['bg_768']; ?>" size="50" /> <input type="file" id="file_bg_768" class="jpg" /></p>

<p>iPad landscape: (link to 1024x768 jpg file)<br />
<input type="text" name="bg_1024" id="bg_1024" placeholder="/m/pix/album_1024.jpg" value="<?php echo $_POST['bg_1024']; ?>" size="50" /> <input type="file" id="file_bg_1024" class="jpg" /></p>

<p>Songs: (links to MP3 files, one-per-line. Max file size: <?php echo ini_get ('upload_max_filesize'); ?>)<br />
<textarea name="songs" id="songs" rows="4" cols="90" placeholder="/m/mp3/song_name.mp3"><?php echo $_POST['songs']; ?></textarea><br />
&nbsp;<input type="file" id="file_songs" class="mp3" /></p>

<p>Popup messages (one-per-line):<br />
<textarea name="popups" rows="8" cols="90"><?php echo htmlentities ($_POST['popups']); ?></textarea></p>

<p class="example"><strong>Popup examples:</strong><br />
Buy this album on &lt;a href="...itunes link..."&gt;iTunes&lt;/a&gt;<br />
This album was inspired by cute baby animals.</p>

<p><input type="submit" value="Save" /></p>
</form>

<?php require_once ('html/footer.php'); ?>
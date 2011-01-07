<?php require_once ('html/header.php'); ?>

<h2>Edit Show</h2>

<?php

if (isset ($updated) && $updated) {
	echo '<p class="notice">Your show has been updated. <a href="shows.php">Back</a></p>';
} elseif (isset ($updated) && ! $updated) {
	echo '<p class="error">Failed to save the show: ' . $br->error . '</p>';
}

?>

<form method="post">
<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />

<p>Date:<br /><input type="text" name="date" id="date" value="<?php echo $show->date; ?>" size="25" /></p>

<p>Time:<br /><select name="time">
	<option value="06:00:00"<?php if ($show->time == '06:00:00') { echo ' selected'; } ?>>6:00am</option>
	<option value="06:30:00"<?php if ($show->time == '06:30:00') { echo ' selected'; } ?>>6:30am</option>
	<option value="07:00:00"<?php if ($show->time == '07:00:00') { echo ' selected'; } ?>>7:00am</option>
	<option value="07:30:00"<?php if ($show->time == '07:30:00') { echo ' selected'; } ?>>7:30am</option>
	<option value="08:00:00"<?php if ($show->time == '08:00:00') { echo ' selected'; } ?>>8:00am</option>
	<option value="08:30:00"<?php if ($show->time == '08:30:00') { echo ' selected'; } ?>>8:30am</option>
	<option value="09:00:00"<?php if ($show->time == '09:00:00') { echo ' selected'; } ?>>9:00am</option>
	<option value="09:30:00"<?php if ($show->time == '09:30:00') { echo ' selected'; } ?>>9:30am</option>
	<option value="10:00:00"<?php if ($show->time == '10:00:00') { echo ' selected'; } ?>>10:00am</option>
	<option value="10:30:00"<?php if ($show->time == '10:30:00') { echo ' selected'; } ?>>10:30am</option>
	<option value="11:00:00"<?php if ($show->time == '11:00:00') { echo ' selected'; } ?>>11:00am</option>
	<option value="11:30:00"<?php if ($show->time == '11:30:00') { echo ' selected'; } ?>>11:30am</option>
	<option value="12:00:00"<?php if ($show->time == '12:00:00') { echo ' selected'; } ?>>12:00pm</option>
	<option value="12:30:00"<?php if ($show->time == '12:30:00') { echo ' selected'; } ?>>12:30pm</option>
	<option value="13:00:00"<?php if ($show->time == '13:00:00') { echo ' selected'; } ?>>1:00pm</option>
	<option value="13:30:00"<?php if ($show->time == '13:30:00') { echo ' selected'; } ?>>1:30pm</option>
	<option value="14:00:00"<?php if ($show->time == '14:00:00') { echo ' selected'; } ?>>2:00pm</option>
	<option value="14:30:00"<?php if ($show->time == '14:30:00') { echo ' selected'; } ?>>2:30pm</option>
	<option value="15:00:00"<?php if ($show->time == '15:00:00') { echo ' selected'; } ?>>3:00pm</option>
	<option value="15:30:00"<?php if ($show->time == '15:30:00') { echo ' selected'; } ?>>3:30pm</option>
	<option value="16:00:00"<?php if ($show->time == '16:00:00') { echo ' selected'; } ?>>4:00pm</option>
	<option value="16:30:00"<?php if ($show->time == '16:30:00') { echo ' selected'; } ?>>4:30pm</option>
	<option value="17:00:00"<?php if ($show->time == '17:00:00') { echo ' selected'; } ?>>5:00pm</option>
	<option value="17:30:00"<?php if ($show->time == '17:30:00') { echo ' selected'; } ?>>5:30pm</option>
	<option value="18:00:00"<?php if ($show->time == '18:00:00') { echo ' selected'; } ?>>6:00pm</option>
	<option value="18:30:00"<?php if ($show->time == '18:30:00') { echo ' selected'; } ?>>6:30pm</option>
	<option value="19:00:00"<?php if ($show->time == '19:00:00') { echo ' selected'; } ?>>7:00pm</option>
	<option value="19:30:00"<?php if ($show->time == '19:30:00') { echo ' selected'; } ?>>7:30pm</option>
	<option value="20:00:00"<?php if ($show->time == '20:00:00') { echo ' selected'; } ?>>8:00pm</option>
	<option value="20:30:00"<?php if ($show->time == '20:30:00') { echo ' selected'; } ?>>8:30pm</option>
	<option value="21:00:00"<?php if ($show->time == '21:00:00') { echo ' selected'; } ?>>9:00pm</option>
	<option value="21:30:00"<?php if ($show->time == '21:30:00') { echo ' selected'; } ?>>9:30pm</option>
	<option value="22:00:00"<?php if ($show->time == '22:00:00') { echo ' selected'; } ?>>10:00pm</option>
	<option value="22:30:00"<?php if ($show->time == '22:30:00') { echo ' selected'; } ?>>10:30pm</option>
	<option value="23:00:00"<?php if ($show->time == '23:00:00') { echo ' selected'; } ?>>11:00pm</option>
	<option value="23:30:00"<?php if ($show->time == '23:30:00') { echo ' selected'; } ?>>11:30pm</option>
	<option value="00:00:00"<?php if ($show->time == '00:00:00') { echo ' selected'; } ?>>12:00am</option>
	<option value="00:30:00"<?php if ($show->time == '00:30:00') { echo ' selected'; } ?>>12:30am</option>
	<option value="01:00:00"<?php if ($show->time == '01:00:00') { echo ' selected'; } ?>>1:00am</option>
	<option value="01:30:00"<?php if ($show->time == '01:30:00') { echo ' selected'; } ?>>1:30am</option>
	<option value="02:00:00"<?php if ($show->time == '02:00:00') { echo ' selected'; } ?>>2:00am</option>
	<option value="02:30:00"<?php if ($show->time == '02:30:00') { echo ' selected'; } ?>>2:30am</option>
	<option value="03:00:00"<?php if ($show->time == '03:00:00') { echo ' selected'; } ?>>3:00am</option>
	<option value="03:30:00"<?php if ($show->time == '03:30:00') { echo ' selected'; } ?>>3:30am</option>
	<option value="04:00:00"<?php if ($show->time == '04:00:00') { echo ' selected'; } ?>>4:00am</option>
	<option value="04:30:00"<?php if ($show->time == '04:30:00') { echo ' selected'; } ?>>4:30am</option>
	<option value="05:00:00"<?php if ($show->time == '05:00:00') { echo ' selected'; } ?>>5:00am</option>
	<option value="05:30:00"<?php if ($show->time == '05:30:00') { echo ' selected'; } ?>>5:30am</option>
</select></p>

<p>City:<br /><input type="text" name="city" value="<?php echo $show->city; ?>" size="25" /></p>

<p>Venue:<br /><input type="text" name="venue" value="<?php echo $show->venue; ?>" size="25" /></p>

<p>Info:<br /><input type="text" name="info" value="<?php echo $show->info; ?>" size="50" /></p>

<p>Ticket Link: (optional)<br /><input type="text" name="ticket_link" value="<?php echo $show->ticket_link; ?>" size="50" /></p>

<p><input type="submit" value="Save" /></p>
</form>

<?php require_once ('html/footer.php'); ?>
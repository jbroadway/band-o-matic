<?php require_once ('html/header.php'); ?>

<h2>Shows</h2>

<p><a href="shows_add.php">Add a show</a></p>

<h3>Upcoming Shows</h3>

<?php

if (count ($shows) == 0) {
	echo '<p>No shows scheduled at the moment.</p>';
}

foreach ($shows as $show) {
	if (! empty ($show->ticket_link)) {
		$show->ticket_link = ' <a href="' . $show->ticket_link . '">Tickets</a>';
	}
	echo sprintf (
		'<p><strong>%s - %s</strong> %s <strong>%s</strong><br />%s%s<br /><a href="shows_edit.php?id=%d">Edit</a> | <a href="shows_delete.php?id=%d" onclick="return confirm(\'Are you sure?\')">Delete</a></p>',
		date ('M j', strtotime ($show->date)),
		date ('g:ia', strtotime ($show->date . ' ' . $show->time)),
		$show->city,
		$show->venue,
		$show->info,
		$show->ticket_link,
		$show->id,
		$show->id
	);
}

?>

<hr />

<h3>Past Shows</h3>

<?php

if (count ($past) == 0) {
	echo '<p>No past shows yet.</p>';
}

foreach ($past as $show) {
	if (! empty ($show->ticket_link)) {
		$show->ticket_link = ' <a href="' . $show->ticket_link . '">Tickets</a>';
	}
	echo sprintf (
		'<p><strong>%s - %s</strong> %s <strong>%s</strong><br />%s%s<br /><a href="shows_edit.php?id=%d">Edit</a> | <a href="shows_delete.php?id=%d" onclick="return confirm(\'Are you sure?\')">Delete</a></p>',
		date ('M j, Y', strtotime ($show->date)),
		date ('ga', strtotime ('2010-10-10 ' . $show->time)),
		$show->city,
		$show->venue,
		$show->info,
		$show->ticket_link,
		$show->id,
		$show->id
	);
}

?>

<?php require_once ('html/footer.php'); ?>
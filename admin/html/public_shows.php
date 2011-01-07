_br_shows_callback([
<?php

$sep = "\t";
foreach ($shows as $show) {
	if (empty ($show->ticket_link)) {
		unset ($show->ticket_link);
	}
	unset ($show->id);
	$show->time = gmdate ('g:ia', strtotime ($show->date . ' ' . $show->time));
	$show->date = gmdate ('M j', strtotime ($show->date));
	echo $sep . json_encode ($show);
	$sep = ",\n\t";
}

?>

]);
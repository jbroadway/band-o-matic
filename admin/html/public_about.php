<?php

if (! empty ($about_page->title)) {
	echo '<h2>' . $about_page->title . "</h2>\n\n";
}

echo $about_page->body;

?>
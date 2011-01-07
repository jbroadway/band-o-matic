<!DOCTYPE html>
<html>
<head>
	<title><?php echo $email_page->title; ?></title>
	<style type="text/css">
<?php echo $email_page->css; ?>
	</style>
</head>
<body>

<?php

if (! empty ($email_page->title)) {
	echo '<h1>' . $email_page->title . "</h1>\n\n";
}

echo $email_page->body;

?>


</body>
</html>
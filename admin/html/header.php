<html>
<head>
	<title>Band-o-rama - Mobile Site Admin</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.8.7.custom.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.7.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.pager.js"></script>
	<script type="text/javascript">
		$(document).ready (function () {
			$('table.list').pager ('tbody', {
				navId: 'nav'
			});
			$('#date').datepicker ({
				dateFormat: 'yy-mm-dd'
			});
		});
	</script>
</head>
<body>
<div id="wrapper">

<h1 id="title">Band-o-rama</h1>

<div id="nav">
<?php if (! $unauthorized) { ?>
<a href="logout.php">Log Out</a>
<a href="email.php"<?php if (preg_match ('/^email/', $page)) { echo ' class="active"'; } ?>>Email Page</a>
<a href="music.php"<?php if (preg_match ('/^music/', $page)) { echo ' class="active"'; } ?>>Music</a>
<a href="shows.php"<?php if (preg_match ('/^shows/', $page)) { echo ' class="active"'; } ?>>Shows</a>
<a href="index.php"<?php if (preg_match ('/^index/', $page)) { echo ' class="active"'; } ?>>General</a>
<? } ?>
</div>

<div id="content">

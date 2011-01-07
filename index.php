<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="X-UA-Compatible" content="chrome=1" />
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/mobile/1.0a2/jquery.mobile-1.0a2.min.css" />
	<link rel="stylesheet" type="text/css" href="css/band-o-rama.css" />
	<link rel="stylesheet" type="text/css" href="admin/public_css.php" />
	<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 	<script src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
 	<script src="js/jquery.jplayer.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.0a2/jquery.mobile-1.0a2.min.js"></script>
	<script type="text/javascript" src="js/band-o-rama.js"></script>
	<script type="text/javascript" src="admin/public_config.php"></script>
	<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript">
		$(document).ready (function () {
			_br.init ();
		});
	</script>
</head>
<body>

<div id="br-play-pause">
<a href="#" onclick="return _br.playPause ()" id="br-play-link"></a>
</div>

<div id="br-pages">
<a href="#index" data-transition="slide" class="br-page-link active" id="br-link-index" onclick="_br.changePage ('index')"></a>
</div>

<?php require_once ('admin/public_pages.php'); ?>

<div id="br-player"></div>

</body>
</html>
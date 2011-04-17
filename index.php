<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="X-UA-Compatible" content="chrome=1" />
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/mobile/1.0a4/jquery.mobile-1.0a4.min.css" />
	<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/band-o-matic.css" />
	<link rel="stylesheet" type="text/css" href="admin/public_css.php" />
 	<script src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
 	<script src="js/jquery.jplayer.min.js"></script>
 	<script src="js/jquery.jgfeed-min.js"></script>
	<script src="http://code.jquery.com/mobile/1.0a4/jquery.mobile-1.0a4.min.js"></script>
	<script type="text/javascript" src="js/band-o-matic.js"></script>
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
<a href="#" onclick="return _br.playPause ()" id="br-play-link" title="Play/Pause"></a>
</div>

<div id="br-pages">
<a href="javascript:void(0);" class="br-page-link active" id="br-link-index" onclick="return _br.changePage ('index')" title="Home"></a>
<div id="br-web-player">
<a href="#" onclick="return _br.next ()" id="br-web-next-link" title="Next Track"></a>
<a href="#" onclick="return _br.playPause ()" id="br-web-play-link" title="Play/Pause"></a>
<a href="#" onclick="return _br.previous ()" id="br-web-prev-link" title="Previous Track"></a>
</div>
</div>

<?php require_once ('admin/public_pages.php'); ?>

<div id="br-player"></div>

</body>
</html>